<?php
require_once '../../includes/session.php';
require_once '../../includes/guard.admin.php';
require_once '../../includes/conn.php';

$total_users_result = mysqli_query($conn, "SELECT COUNT(*) AS total FROM tbl_users");
$total_users = mysqli_fetch_assoc($total_users_result)['total'];

$total_tasks_result = mysqli_query($conn, "SELECT COUNT(*) AS total FROM tbl_tasks");
$total_tasks = mysqli_fetch_assoc($total_tasks_result)['total'];

$ongoing_tasks_result = mysqli_query($conn, "SELECT COUNT(*) AS total FROM tbl_tasks WHERE status = 'In Progress'");
$ongoing_tasks = mysqli_fetch_assoc($ongoing_tasks_result)['total'];

$completed_tasks_result = mysqli_query($conn, "SELECT COUNT(*) AS total FROM tbl_tasks WHERE status = 'Completed'");
$completed_tasks = mysqli_fetch_assoc($completed_tasks_result)['total'];

$overdue_tasks_result = mysqli_query($conn, "SELECT COUNT(*) AS total FROM tbl_tasks WHERE due_date < CURDATE() AND status != 'Completed'");
$overdue_tasks = mysqli_fetch_assoc($overdue_tasks_result)['total'];

$recent_users = mysqli_query($conn, "SELECT * FROM tbl_users ORDER BY created_at DESC LIMIT 5");

?>



<!doctype html>
<html lang="en" dir="ltr" data-bs-theme="light" data-bs-theme-color="theme-color-default">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Task Management System | Dashboard</title>

  <!-- Links -->
  <?php include '../../includes/link.php'; ?>

  <style>
    .btn-view-all {
      background: transparent;
      border: 1px solid #4e73df;
      color: #4e73df;
      font-size: 0.8rem;
      font-weight: 600;
      padding: 5px 14px;
      border-radius: 6px;
      transition: background 0.15s, color 0.15s;
      text-decoration: none;
    }

    .btn-view-all:hover {
      background: #4e73df;
      color: #fff;
    }

    .sidebar-toggle {
      background: transparent !important;
      border: none !important;
      box-shadow: none !important;
      border-radius: 10px !important;
      transition: background 0.2s, color 0.2s !important;
      color: #94a3b8 !important;
      /* visible grey by default */
    }

    .sidebar-toggle:hover {
      background: rgba(78, 115, 223, 0.1) !important;
      color: #4e73df !important;
      /* turns blue on hover */
    }
  </style>

</head>

<body class="  ">
  <!-- loader Start -->
  <div id="loading">
    <div class="loader simple-loader">
      <div class="loader-body">
      </div>
    </div>
  </div>
  <!-- loader END -->

  <!-- Sidebar -->
  <?php
  $activePage = 'dashboard';
  include '../../includes/sidebar.php';
  ?>

  <main class="main-content">
    <div class="position-relative iq-banner">
      <!--Nav Start-->
      <?php include '../../includes/navbar.php'; ?>

      <!-- Nav Header -->
      <div class="iq-navbar-header" style="height: 215px;">
        <div class="container-fluid iq-container">
          <div class="row">
            <div class="col-md-12">
              <div class="flex-wrap d-flex justify-content-between align-items-center">
                <div>
                  <h1>Welcome, <?php echo $currentUser['first_name']; ?>!</h1>
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
      <!--Nav End-->
    </div>

    <div class="conatiner-fluid content-inner mt-n5 py-0">
      <div class="row">
        <div class="col-md-12 col-lg-12">

          <!-- ===================== STAT CARDS CAROUSEL ===================== -->
          <div class="row row-cols-1">
            <div class="overflow-hidden d-slider1">
              <ul class="p-0 m-0 mb-2 swiper-wrapper list-inline">

                <!-- Card 1: Total Users -->
                <li class="swiper-slide card card-slide" data-aos="fade-up" data-aos-delay="700">
                  <div class="card-body">
                    <div class="progress-widget">

                      <div class="progress-detail">
                        <p class="mb-2">Total Users</p>
                        <h4 class="counter"><?php echo $total_users; ?></h4>
                      </div>
                    </div>
                  </div>
                </li>

                <!-- Card 2: Total Tasks -->
                <li class="swiper-slide card card-slide" data-aos="fade-up" data-aos-delay="800">
                  <div class="card-body">
                    <div class="progress-widget">

                      <div class="progress-detail">
                        <p class="mb-2">Total Tasks</p>
                        <h4 class="counter"><?php echo $total_tasks; ?></h4>
                      </div>
                    </div>
                  </div>
                </li>

                <!-- Card 3: Ongoing Tasks -->
                <li class="swiper-slide card card-slide" data-aos="fade-up" data-aos-delay="900">
                  <div class="card-body">
                    <div class="progress-widget">

                      <div class="progress-detail">
                        <p class="mb-2">Ongoing Tasks</p>
                        <h4 class="counter"><?php echo $ongoing_tasks; ?></h4>
                      </div>
                    </div>
                  </div>
                </li>

                <!-- Card 4: Completed Tasks -->
                <li class="swiper-slide card card-slide" data-aos="fade-up" data-aos-delay="1000">
                  <div class="card-body">
                    <div class="progress-widget">

                      <div class="progress-detail">
                        <p class="mb-2">Completed Tasks</p>
                        <h4 class="counter"><?php echo $completed_tasks; ?></h4>
                      </div>
                    </div>
                  </div>
                </li>

                <!-- Card 5: Overdue Tasks -->
                <li class="swiper-slide card card-slide" data-aos="fade-up" data-aos-delay="1100">
                  <div class="card-body">
                    <div class="progress-widget">

                      <div class="progress-detail">
                        <p class="mb-2">Overdue Tasks</p>
                        <h4 class="counter"><?php echo $overdue_tasks; ?></h4>
                      </div>
                    </div>
                  </div>
                </li>

              </ul>
              <div class="swiper-button swiper-button-next"></div>
              <div class="swiper-button swiper-button-prev"></div>
            </div>
          </div>
          <!-- ===================== END STAT CARDS ===================== -->

          <!-- ===================== USER LIST + PIE CHART ===================== -->
          <div class="row mt-3">

            <!-- User List -->
            <div class="col-md-6 col-lg-6 mb-4">
              <div class="card h-100">
                <div class="card-header d-flex justify-content-between align-items-center">
                  <h5 class="card-title mb-0">Users</h5>
                  <a href="../users/user.management.php" class="btn btn-sm btn-view-all">View All</a>
                </div>
                <div class="card-body p-0">
                  <ul class="list-group list-group-flush">
                    <?php while ($user = mysqli_fetch_assoc($recent_users)) { ?>
                      <li class="list-group-item d-flex justify-content-between align-items-center">
                        <div>
                          <h6 class="mb-0"><?php echo $user['first_name'] . ' ' . $user['last_name']; ?></h6>
                          <small class="text-muted"><?php echo $user['email']; ?></small>
                        </div>
                        <span class="badge bg-primary"><?php echo $user['role']; ?></span>
                      </li>
                    <?php } ?>
                  </ul>
                </div>
              </div>
            </div>

            <!-- Task Status Pie Chart -->
            <div class="col-md-6 col-lg-6 mb-4">
              <div class="card h-100">
                <div class="card-header">
                  <h5 class="card-title mb-0">Task Status Overview</h5>
                </div>
                <div class="card-body d-flex flex-column align-items-center justify-content-center">
                  <div style="width: 220px; height: 220px;">
                    <canvas id="taskStatusChart"></canvas>
                  </div>
                  <!-- Legend -->
                  <div class="d-flex gap-4 mt-3">
                    <div class="d-flex align-items-center gap-2">
                      <span
                        style="width:14px; height:14px; border-radius:3px; background:#4e73df; display:inline-block;"></span>
                      <span class="text-muted small">In Progress</span>
                    </div>
                    <div class="d-flex align-items-center gap-2">
                      <span
                        style="width:14px; height:14px; border-radius:3px; background:#1cc88a; display:inline-block;"></span>
                      <span class="text-muted small">Completed</span>
                    </div>
                    <div class="d-flex align-items-center gap-2">
                      <span
                        style="width:14px; height:14px; border-radius:3px; background:#e74a3b; display:inline-block;"></span>
                      <span class="text-muted small">Overdue</span>
                    </div>
                  </div>
                </div>
              </div>
            </div>

          </div>
          <!-- ===================== END USER LIST + PIE CHART ===================== -->

        </div>
      </div>
    </div>

    <!-- Chart.js -->
    <?php include '../../includes/scripts.php'; ?>

    <!-- Footer -->
    <?php include '../../includes/footer.php'; ?>
  </main>

  <!-- Chart.js: Task Status Pie Chart -->
  <script>
    const ctx = document.getElementById('taskStatusChart').getContext('2d');
    const taskStatusChart = new Chart(ctx, {
      type: 'doughnut',
      data: {
        labels: ['In Progress', 'Completed', 'Overdue'],
        datasets: [{
          data: [
            <?php echo $ongoing_tasks; ?>,
            <?php echo $completed_tasks; ?>,
            <?php echo $overdue_tasks; ?>
          ],
          backgroundColor: ['#4e73df', '#1cc88a', '#e74a3b'],
          hoverBackgroundColor: ['#2e59d9', '#17a673', '#be2617'],
          borderWidth: 2,
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        cutout: '65%',
        plugins: {
          legend: {
            display: false // We use our own custom legend above
          },
          tooltip: {
            callbacks: {
              label: function (context) {
                const total = context.dataset.data.reduce((a, b) => a + b, 0);
                const value = context.parsed;
                const percentage = total === 0 ? 0 : ((value / total) * 100).toFixed(1);
                return ` ${context.label}: ${value} (${percentage}%)`;
              }
            }
          }
        }
      }
    });
  </script>

</body>

</html>