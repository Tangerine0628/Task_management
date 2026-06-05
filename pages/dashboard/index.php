<?php
// Require auth, admin guard, and DB connection
require_once '../../includes/session.php';
require_once '../../includes/guard.admin.php';
require_once '../../includes/conn.php';

// ── Summary stat queries ──────────────────────────────────────────────────────

// Total number of registered users
$total_users_result = mysqli_query($conn, "SELECT COUNT(*) AS total FROM tbl_users");
$total_users = mysqli_fetch_assoc($total_users_result)['total'];

// Total number of tasks across all users
$total_tasks_result = mysqli_query($conn, "SELECT COUNT(*) AS total FROM tbl_tasks");
$total_tasks = mysqli_fetch_assoc($total_tasks_result)['total'];

// Tasks currently in progress
$ongoing_tasks_result = mysqli_query($conn, "SELECT COUNT(*) AS total FROM tbl_tasks WHERE status = 'In Progress'");
$ongoing_tasks = mysqli_fetch_assoc($ongoing_tasks_result)['total'];

// Tasks marked as completed
$completed_tasks_result = mysqli_query($conn, "SELECT COUNT(*) AS total FROM tbl_tasks WHERE status = 'Completed'");
$completed_tasks = mysqli_fetch_assoc($completed_tasks_result)['total'];

// Tasks past their due date and not yet completed
$overdue_tasks_result = mysqli_query($conn, "SELECT COUNT(*) AS total FROM tbl_tasks WHERE due_date < CURDATE() AND status != 'Completed'");
$overdue_tasks = mysqli_fetch_assoc($overdue_tasks_result)['total'];

// ── Priority breakdown counts ─────────────────────────────────────────────────

$high_priority_result = mysqli_query($conn, "SELECT COUNT(*) AS total FROM tbl_tasks WHERE priority = 'High'");
$high_priority = mysqli_fetch_assoc($high_priority_result)['total'];

$medium_priority_result = mysqli_query($conn, "SELECT COUNT(*) AS total FROM tbl_tasks WHERE priority = 'Medium'");
$medium_priority = mysqli_fetch_assoc($medium_priority_result)['total'];

$low_priority_result = mysqli_query($conn, "SELECT COUNT(*) AS total FROM tbl_tasks WHERE priority = 'Low'");
$low_priority = mysqli_fetch_assoc($low_priority_result)['total'];

// ── Activity metrics ──────────────────────────────────────────────────────────

// Tasks created today
$assigned_today_result = mysqli_query($conn, "SELECT COUNT(*) AS total FROM tbl_tasks WHERE DATE(created_at) = CURDATE()");
$assigned_today = mysqli_fetch_assoc($assigned_today_result)['total'];

// Tasks that have at least one comment
$with_comments_result = mysqli_query($conn, "SELECT COUNT(DISTINCT task_id) AS total FROM tbl_task_comments");
$with_comments = mysqli_fetch_assoc($with_comments_result)['total'];

// ── Team performance: top 10 users by assigned task count ────────────────────
// ── Team performance: top 10 users by assigned task count ────────────────
$team_performance_result = mysqli_query($conn, "
    SELECT
        u.user_id,
        u.first_name,
        u.last_name,
        u.profile_pic,
        COUNT(t.task_id) AS assigned,
        SUM(t.status = 'Completed') AS completed,
        SUM(t.status = 'In Progress') AS ongoing,
        SUM(t.due_date < CURDATE() AND t.status != 'Completed') AS overdue
    FROM tbl_users u
    LEFT JOIN tbl_tasks t ON t.assigned_to = u.user_id
    GROUP BY u.user_id
    ORDER BY assigned DESC
    LIMIT 10
");
?>
<!doctype html>
<html lang="en" dir="ltr" data-bs-theme="light" data-bs-theme-color="theme-color-default">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Task Management System | Dashboard</title>
  <?php include '../../includes/link.php'; ?>

  <style>
    /* ── Stat Cards ── */
    .stat-card {
      border: none;
      border-radius: 16px;
      padding: 20px 22px;
      min-height: 120px;
      display: flex;
      flex-direction: column;
      justify-content: space-between;
      position: relative;
      overflow: hidden;
      transition: transform 0.2s, box-shadow 0.2s;
      box-shadow: 0 2px 10px rgba(0, 0, 0, 0.06);
    }

    .stat-card:hover {
      transform: translateY(-3px);
      box-shadow: 0 8px 24px rgba(0, 0, 0, 0.10);
    }

    .stat-card .stat-icon {
      width: 44px;
      height: 44px;
      border-radius: 12px;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 1.3rem;
      margin-bottom: 12px;
      flex-shrink: 0;
    }

    .stat-card p {
      margin: 0 0 4px;
      font-size: 0.82rem;
      font-weight: 600;
      text-transform: uppercase;
      letter-spacing: 0.05em;
      opacity: 0.72;
    }

    .stat-card h4 {
      margin: 0;
      font-size: 1.9rem;
      font-weight: 800;
      line-height: 1;
    }

    /* Card color themes */
    .stat-users {
      background: linear-gradient(135deg, #e8f0fe 0%, #d2e3fc 100%);
    }

    .stat-users .stat-icon {
      background: rgba(78, 115, 223, 0.15);
      color: #4e73df;
    }

    .stat-users h4,
    .stat-users p {
      color: #1e3a8a;
    }

    .stat-tasks {
      background: linear-gradient(135deg, #e0f7fa 0%, #b2ebf2 100%);
    }

    .stat-tasks .stat-icon {
      background: rgba(0, 188, 212, 0.15);
      color: #00bcd4;
    }

    .stat-tasks h4,
    .stat-tasks p {
      color: #006064;
    }

    .stat-ongoing {
      background: linear-gradient(135deg, #fff8e1 0%, #ffecb3 100%);
    }

    .stat-ongoing .stat-icon {
      background: rgba(255, 193, 7, 0.18);
      color: #f59e0b;
    }

    .stat-ongoing h4,
    .stat-ongoing p {
      color: #78350f;
    }

    .stat-done {
      background: linear-gradient(135deg, #e8f5e9 0%, #c8e6c9 100%);
    }

    .stat-done .stat-icon {
      background: rgba(56, 176, 0, 0.15);
      color: #22c55e;
    }

    .stat-done h4,
    .stat-done p {
      color: #14532d;
    }

    .stat-overdue {
      background: linear-gradient(135deg, #fce4ec 0%, #f8bbd0 100%);
    }

    .stat-overdue .stat-icon {
      background: rgba(239, 68, 68, 0.15);
      color: #ef4444;
    }

    .stat-overdue h4,
    .stat-overdue p {
      color: #7f1d1d;
    }

    /* ── Section Cards ── */
    .section-card {
      border: none;
      border-radius: 16px;
      box-shadow: 0 2px 10px rgba(0, 0, 0, 0.06);
    }

    .section-card .card-header {
      background: transparent;
      border-bottom: 1px solid rgba(0, 0, 0, 0.06);
      padding: 1.25rem 1.5rem !important;
    }

    .section-card .card-title {
      font-size: 1rem;
      font-weight: 700;
      margin-bottom: 2px;
    }

    /* ── View All Button ── */
    .btn-view-all {
      background: #4e73df;
      color: #fff;
      font-size: 0.82rem;
      font-weight: 600;
      padding: 7px 15px;
      border-radius: 10px;
      transition: background 0.15s, transform 0.15s;
      text-decoration: none;
      display: inline-flex;
      align-items: center;
      gap: 6px;
      white-space: nowrap;
    }

    .btn-view-all:hover {
      background: #3562c7;
      color: #fff;
      transform: translateY(-1px);
    }

    /* ── Team Performance Table ── */
    .team-table thead th {
      font-size: 0.78rem;
      font-weight: 700;
      text-transform: uppercase;
      letter-spacing: 0.05em;
      color: #6c757d;
      border-bottom: 2px solid #f0f0f0;
      padding: 10px 14px;
    }

    .team-table tbody td {
      padding: 10px 14px;
      font-size: 0.88rem;
      vertical-align: middle;
      border-bottom: 1px solid #f5f5f5;
    }

    .team-table tbody tr:last-child td {
      border-bottom: none;
    }

    .team-table tbody tr:hover td {
      background: #f4f7ff;
      transition: background 0.15s;
    }

    .member-avatar {
      width: 32px;
      height: 32px;
      border-radius: 50%;
      background: #4e73df;
      color: #fff;
      font-size: 0.75rem;
      font-weight: 700;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      margin-right: 8px;
      flex-shrink: 0;
      overflow: hidden;
    }

    .member-avatar img {
      width: 100%;
      height: 100%;
      object-fit: cover;
      border-radius: 50%;
    }

    .progress-bar-sm {
      height: 6px;
      border-radius: 99px;
      background: #e9ecef;
      overflow: hidden;
      min-width: 60px;
    }

    .progress-bar-sm .fill {
      height: 100%;
      border-radius: 99px;
      background: #4e73df;
      transition: width 0.6s ease;
    }

    .badge-overdue {
      background: #fce4ec;
      color: #c0392b;
      font-size: 0.78rem;
      padding: 3px 9px;
      border-radius: 20px;
      font-weight: 600;
    }

    .badge-done {
      background: #e8f5e9;
      color: #1a7a35;
      font-size: 0.78rem;
      padding: 3px 9px;
      border-radius: 20px;
      font-weight: 600;
    }

    .badge-ongoing {
      background: #fff8e1;
      color: #b45309;
      font-size: 0.78rem;
      padding: 3px 9px;
      border-radius: 20px;
      font-weight: 600;
    }

    /* ── Priority Metric Boxes ── */
    .metric-box {
      border-radius: 14px;
      padding: 18px 20px;
      display: flex;
      flex-direction: column;
      gap: 6px;
      transition: transform 0.18s, box-shadow 0.18s;
      cursor: default;
    }

    .metric-box:hover {
      transform: translateY(-2px);
      box-shadow: 0 6px 18px rgba(0, 0, 0, 0.09);
    }

    .metric-box p {
      margin: 0;
      font-size: 0.8rem;
      font-weight: 700;
      text-transform: uppercase;
      letter-spacing: 0.05em;
    }

    .metric-box h4 {
      margin: 0;
      font-size: 1.6rem;
      font-weight: 800;
    }

    .metric-box small {
      font-size: 0.75rem;
      opacity: 0.7;
    }

    .metric-high {
      background: #fce4ec;
    }

    .metric-high p,
    .metric-high h4 {
      color: #b71c1c;
    }

    .metric-high .metric-icon {
      color: #ef4444;
    }

    .metric-medium {
      background: #fff8e1;
    }

    .metric-medium p,
    .metric-medium h4 {
      color: #78350f;
    }

    .metric-medium .metric-icon {
      color: #f59e0b;
    }

    .metric-low {
      background: #e8f5e9;
    }

    .metric-low p,
    .metric-low h4 {
      color: #14532d;
    }

    .metric-low .metric-icon {
      color: #22c55e;
    }

    .metric-today {
      background: #e8f0fe;
    }

    .metric-today p,
    .metric-today h4 {
      color: #1e3a8a;
    }

    .metric-comment {
      background: #f3e8ff;
    }

    .metric-comment p,
    .metric-comment h4 {
      color: #4c1d95;
    }
  </style>
</head>

<body>
  <!-- Loader -->
  <div id="loading">
    <div class="loader simple-loader">
      <div class="loader-body"></div>
    </div>
  </div>

  <!-- Sidebar -->
  <?php $activePage = 'dashboard';
  include '../../includes/sidebar.php'; ?>

  <main class="main-content">
    <div class="position-relative iq-banner">
      <?php include '../../includes/navbar.php'; ?>
      <div class="iq-navbar-header" style="height: 215px;">
        <div class="container-fluid iq-container">
          <div class="row">
            <div class="col-md-12">
              <div class="d-flex flex-wrap justify-content-between align-items-center">
                <div>
                  <h1>Welcome, <?php echo htmlspecialchars($currentUser['first_name']); ?>!</h1>
                  <p>Here's an overview of the task management system.</p>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="iq-header-img">
          <img src="../../html/assets/images/dashboard/top-header.png" alt="header"
            class="theme-color-default-img img-fluid w-100 h-100 animated-scaleX">
        </div>
      </div>
    </div>

    <div class="container-fluid content-inner mt-n5 py-0">

      <!-- ── STAT CARDS ── -->
      <div class="row row-cols-1 mb-4">
        <div class="overflow-hidden d-slider1">
          <ul class="p-0 m-0 mb-2 swiper-wrapper list-inline">

            <li class="swiper-slide card-slide" data-aos="fade-up" data-aos-delay="100">
              <div class="stat-card stat-users">
                <div class="stat-icon"><i class="ti ti-users"></i></div>
                <div>
                  <p>Total Users</p>
                  <h4><?php echo $total_users; ?></h4>
                </div>
              </div>
            </li>

            <li class="swiper-slide card-slide" data-aos="fade-up" data-aos-delay="200">
              <div class="stat-card stat-tasks">
                <div class="stat-icon"><i class="ti ti-clipboard-list"></i></div>
                <div>
                  <p>Total Tasks</p>
                  <h4><?php echo $total_tasks; ?></h4>
                </div>
              </div>
            </li>

            <li class="swiper-slide card-slide" data-aos="fade-up" data-aos-delay="300">
              <div class="stat-card stat-ongoing">
                <div class="stat-icon"><i class="ti ti-clock"></i></div>
                <div>
                  <p>Ongoing Tasks</p>
                  <h4><?php echo $ongoing_tasks; ?></h4>
                </div>
              </div>
            </li>

            <li class="swiper-slide card-slide" data-aos="fade-up" data-aos-delay="400">
              <div class="stat-card stat-done">
                <div class="stat-icon"><i class="ti ti-circle-check"></i></div>
                <div>
                  <p>Completed Tasks</p>
                  <h4><?php echo $completed_tasks; ?></h4>
                </div>
              </div>
            </li>

            <li class="swiper-slide card-slide" data-aos="fade-up" data-aos-delay="500">
              <div class="stat-card stat-overdue">
                <div class="stat-icon"><i class="ti ti-alert-triangle"></i></div>
                <div>
                  <p>Overdue Tasks</p>
                  <h4><?php echo $overdue_tasks; ?></h4>
                </div>
              </div>
            </li>

          </ul>
          <div class="swiper-button swiper-button-next"></div>
          <div class="swiper-button swiper-button-prev"></div>
        </div>
      </div>

      <!-- ── TEAM PERFORMANCE TRACKER ── -->
      <div class="row mt-2 mb-4">
        <div class="col-12">
          <div class="card section-card">
            <div class="card-header d-flex justify-content-between align-items-center">
              <div>
                <h5 class="card-title">Team Performance Tracker</h5>
                <p class="mb-0 text-muted" style="font-size:0.85rem;">Monitor task assignments and team workload.</p>
              </div>
              <a href="../users/user.management.php" class="btn-view-all">
                <i class="ti ti-users"></i> View Users
              </a>
            </div>
            <div class="card-body p-0">
              <div class="table-responsive" style="max-height: 320px; overflow-y: auto;">
                <table class="table team-table mb-0">
                  <thead class="table-light sticky-top">
                    <tr>
                      <th>#</th>
                      <th>Member</th>
                      <th>Tasks Assigned</th>
                      <th>Completed</th>
                      <th>Ongoing</th>
                      <th>Overdue</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $members = [];
                    while ($member = mysqli_fetch_assoc($team_performance_result)) {
                      $members[] = $member;
                    }
                    $max_assigned = max(array_column($members, 'assigned') ?: [1]);
                    foreach ($members as $member):
                      $initials = strtoupper(substr($member['first_name'], 0, 1) . substr($member['last_name'], 0, 1));
                      $pct = $max_assigned > 0 ? round(($member['assigned'] / $max_assigned) * 100) : 0;
                      $memberPic = !empty($member['profile_pic'])
                        ? '/task_management/uploads/avatars/' . htmlspecialchars($member['profile_pic'])
                        : null;
                      ?>
                      <tr>
                        <td><span class="text-muted"><?php echo $member['user_id']; ?></span></td>
                        <td>
                          <div class="d-flex align-items-center">
                            <span class="member-avatar" <?php if (!$memberPic) echo 'style="background:#4e73df;"'; ?>>
                              <?php if ($memberPic): ?>
                                <img src="<?php echo $memberPic; ?>" alt="<?php echo htmlspecialchars($member['first_name']); ?>">
                              <?php else: ?>
                                <?php echo $initials; ?>
                              <?php endif; ?>
                            </span>
                            <span class="fw-600"><?php echo htmlspecialchars($member['first_name'] . ' ' . $member['last_name']); ?></span>
                          </div>
                        </td>
                        <td>
                          <div class="d-flex align-items-center gap-2">
                            <span class="fw-bold"><?php echo $member['assigned']; ?></span>
                            <div class="progress-bar-sm flex-grow-1">
                              <div class="fill" style="width:<?php echo $pct; ?>%"></div>
                            </div>
                          </div>
                        </td>
                        <td><span class="badge-done"><?php echo $member['completed']; ?></span></td>
                        <td><span class="badge-ongoing"><?php echo $member['ongoing']; ?></span></td>
                        <td><span class="badge-overdue"><?php echo $member['overdue']; ?></span></td>
                      </tr>
                    <?php endforeach; ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- ── TASK DISTRIBUTION & ACTIVITY ── -->
      <div class="row mb-4">

        <!-- Priority Metrics + Activity -->
        <div class="col-lg-5 mb-4 mb-lg-0">
          <div class="card section-card h-100">
            <div class="card-header d-flex justify-content-between align-items-center">
              <div>
                <h5 class="card-title">Task Distribution & Activity</h5>
                <p class="mb-0 text-muted" style="font-size:0.85rem;">Monitor task status in real time.</p>
              </div>
              <a href="../tasks/task.management.php" class="btn-view-all">
                <i class="ti ti-list-check"></i> View Tasks
              </a>
            </div>
            <div class="card-body">
              <div class="row g-3 mb-3">
                <div class="col-4">
                  <div class="metric-box metric-high">
                    <i class="ti ti-flame metric-icon" style="font-size:1.2rem;"></i>
                    <p>High</p>
                    <h4><?php echo $high_priority; ?></h4>
                  </div>
                </div>
                <div class="col-4">
                  <div class="metric-box metric-medium">
                    <i class="ti ti-minus-vertical metric-icon" style="font-size:1.2rem;"></i>
                    <p>Medium</p>
                    <h4><?php echo $medium_priority; ?></h4>
                  </div>
                </div>
                <div class="col-4">
                  <div class="metric-box metric-low">
                    <i class="ti ti-arrow-down-circle metric-icon" style="font-size:1.2rem;"></i>
                    <p>Low</p>
                    <h4><?php echo $low_priority; ?></h4>
                  </div>
                </div>
              </div>
              <div class="row g-3">
                <div class="col-6">
                  <div class="metric-box metric-today">
                    <i class="ti ti-calendar-plus" style="font-size:1.1rem; color:#4e73df;"></i>
                    <p>Assigned Today</p>
                    <h4><?php echo $assigned_today; ?></h4>
                    <small>Today</small>
                  </div>
                </div>
                <div class="col-6">
                  <div class="metric-box metric-comment">
                    <i class="ti ti-message-dots" style="font-size:1.1rem; color:#7c3aed;"></i>
                    <p>With Comments</p>
                    <h4><?php echo $with_comments; ?></h4>
                    <small>Commented tasks</small>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Priority Donut Chart -->
        <div class="col-lg-7">
          <div class="card section-card h-100">
            <div class="card-header">
              <h5 class="card-title">Priority Breakdown</h5>
              <p class="mb-0 text-muted" style="font-size:0.85rem;">Visual breakdown of tasks by priority level.</p>
            </div>
            <div class="card-body d-flex align-items-center justify-content-center">
              <div style="position:relative; width:100%; max-width:340px;">
                <canvas id="priorityDonutChart" height="220"></canvas>
              </div>
            </div>
          </div>
        </div>

      </div>
      <!-- ── END TASK DISTRIBUTION ── -->

    </div>

    <?php include '../../includes/scripts.php'; ?>
    <?php include '../../includes/footer.php'; ?>
  </main>

  <script>
    // Priority Donut Chart
    (function () {
      const ctx = document.getElementById('priorityDonutChart');
      if (!ctx) return;

      const high = <?php echo (int) $high_priority; ?>;
      const medium = <?php echo (int) $medium_priority; ?>;
      const low = <?php echo (int) $low_priority; ?>;
      const total = high + medium + low || 1;

      new Chart(ctx, {
        type: 'doughnut',
        data: {
          labels: ['High', 'Medium', 'Low'],
          datasets: [{
            data: [high, medium, low],
            backgroundColor: ['#ef4444', '#f59e0b', '#22c55e'],
            borderColor: ['#fff', '#fff', '#fff'],
            borderWidth: 3,
            hoverOffset: 8
          }]
        },
        options: {
          responsive: true,
          cutout: '65%',
          plugins: {
            legend: {
              position: 'bottom',
              labels: {
                padding: 20,
                font: { size: 13, weight: '600' },
                boxWidth: 12,
                boxHeight: 12,
              }
            },
            tooltip: {
              callbacks: {
                label: function (ctx) {
                  const val = ctx.parsed;
                  const pct = ((val / total) * 100).toFixed(1);
                  return ` ${ctx.label}: ${val} tasks (${pct}%)`;
                }
              }
            }
          }
        },
        plugins: [{
          id: 'centerText',
          beforeDraw(chart) {
            const { ctx, chartArea: { width, height, left, top } } = chart;
            ctx.save();
            ctx.font = 'bold 28px sans-serif';
            ctx.fillStyle = '#1e3a8a';
            ctx.textAlign = 'center';
            ctx.textBaseline = 'middle';
            ctx.fillText(total, left + width / 2, top + height / 2 - 10);
            ctx.font = '600 12px sans-serif';
            ctx.fillStyle = '#6c757d';
            ctx.fillText('Total Tasks', left + width / 2, top + height / 2 + 16);
            ctx.restore();
          }
        }]
      });
    })();
  </script>

</body>

</html>