# TaskFlow — PowerPoint Slide Content

---

## SLIDE 1 — Title Slide

**Title:** TaskFlow
**Subtitle:** A Web-Based Task Management System
**Visual suggestion:** Full-slide dark blue gradient background (matching the app's login screen aesthetic), centered white logo + title, subtle grid overlay

---

## SLIDE 2 — What is TaskFlow?

**Title:** What is TaskFlow?

**Content:**
TaskFlow is a web-based task management system designed to help teams organize, assign, and track work in one centralized place. Built with PHP and MySQL, it gives administrators full control over tasks and users while letting team members focus on their own assigned work — with real-time status updates, activity tracking, and progress visibility.

**Visual suggestion:** Split layout — left side has a short paragraph, right side shows a mockup screenshot of the admin dashboard

---

## SLIDE 3 — The Problem It Solves

**Title:** The Challenge Without a System

**Phrases (large, one per visual block):**
- Tasks get lost in chat threads and emails
- No clear visibility on who is doing what
- Deadlines pass without anyone noticing
- No history of what changed or when

**Visual suggestion:** 4 icon cards in a 2×2 grid, each with a bold phrase and a matching icon (message bubble, eye-slash, calendar-x, history)

---

## SLIDE 4 — Key Features at a Glance

**Title:** Everything You Need in One Place

**Feature phrases (one per card/column):**
- Role-Based Access Control — Separate views and permissions for Admins and Users
- Full Task Lifecycle Management — Create, assign, edit, track, and delete tasks
- Real-Time Activity Logging — Every change is recorded with who did it and when
- Team Performance Tracker — See how each team member is performing at a glance
- Secure Authentication — Login, registration, and password reset with token expiry
- Profile Management — Users can view and update their own account information

**Visual suggestion:** 6 feature cards in a 2×3 grid, each with a large icon, bold title phrase, and one supporting sentence

---

## SLIDE 5 — User Roles

**Title:** Two Roles, One System

**Left column — Admin:**
- Full access to all pages and features
- Manages all tasks across the entire team
- Creates, edits, and removes user accounts
- Changes user roles and account status
- Views team-wide performance metrics

**Right column — User:**
- Sees only their own assigned tasks
- Updates the status of their tasks
- Adds comments to tasks they are assigned to
- Views their personal progress and completion rate

**Visual suggestion:** Two side-by-side panels with distinct header colors (blue for Admin, grey for User), role icon at the top of each

---

## SLIDE 6 — Authentication Flow

**Title:** Getting In Securely

**Flow steps (left to right with arrows):**
1. **Register** — Provide name, email, and password. Account is created as a regular User with Active status.
2. **Login** — Email and password verified against the database. Inactive accounts are blocked.
3. **Remember Me** — Optional 30-day cookie keeps the email pre-filled on return visits.
4. **Forgot Password** — A secure reset link is emailed with a token that expires in 60 minutes.
5. **Reset Password** — New password must be at least 8 characters. Token is invalidated after one use.
6. **Redirect** — Admins go to the Admin Dashboard. Users go to their personal Dashboard.

**Visual suggestion:** Horizontal flow diagram with numbered steps, icons above each step (person-plus, key, cookie, envelope, lock, arrow-right)

---

## SLIDE 7 — Admin Dashboard

**Title:** The Admin Dashboard — Total Visibility

**Content phrases:**
- Live stat cards showing Total Users, Total Tasks, Ongoing, Completed, and Overdue counts
- A swipeable card carousel so all metrics are accessible without scrolling
- Team Performance Tracker table — ranks users by assigned tasks with a visual progress bar per member
- Priority Breakdown donut chart — shows the split between High, Medium, and Low priority tasks
- Activity metrics — how many tasks were assigned today and how many have active comments

**Visual suggestion:** Full-width screenshot or illustrated mockup of the admin dashboard with callout labels pointing to each section

---

## SLIDE 8 — User Dashboard

**Title:** The User Dashboard — Your Personal Workspace

**Content phrases:**
- Personalized stat cards showing only this user's tasks: total, in progress, completed, and overdue
- Task table sorted automatically — overdue tasks surface to the top, then High priority, then by due date
- Inline status update — change a task from In Progress to Completed directly from the dashboard
- Task Status donut chart — a visual breakdown of this user's tasks by current status
- Completion progress bar — shows percentage complete, changing color from blue to orange to green as work progresses

**Visual suggestion:** Screenshot or mockup of the user dashboard with arrows pointing to the donut chart, progress bar, and task table

---

## SLIDE 9 — Task Management

**Title:** Task Management — Full Control for Admins

**Content phrases:**
- Add tasks with a title, description, assignee, due date, priority level, and initial status
- Edit any task at any time — every field change is logged with a before/after record
- Delete tasks individually with a confirmation step, or bulk-delete multiple tasks at once
- Filter tasks by priority or status, sort by due date, and search across title, description, and assignee
- Task Details panel — view the full comment thread and the complete activity history for any task

**Visual suggestion:** Annotated screenshot of the task management table with callouts for the toolbar filters, action buttons, and the details modal

---

## SLIDE 10 — Task Activity & Comments

**Title:** Full Transparency — Nothing Goes Untracked

**Content phrases:**
- Every task action is recorded: created, updated, status changed, deleted, comment added
- Field-level change logs — the system captures exactly what changed, such as "Priority changed from Low to High"
- Comments allow team members and admins to leave notes directly on a task
- The activity log shows the last 30 events per task, with the actor's name and timestamp
- All of this is visible inside the Task Details modal without leaving the current page

**Visual suggestion:** Two-panel illustration showing the Comments panel on the left and the Activity Log on the right, mirroring the actual modal layout

---

## SLIDE 11 — User Management

**Title:** User Management — Full Team Control

**Content phrases:**
- Two-panel layout: browse all users on the left, view detailed profile on the right
- Search, filter by role, and filter by status to find any user instantly
- Add new users directly from the admin panel without going through the registration page
- Edit a user's name and email, reassign their role between Admin and User, and toggle their account status
- Deactivated users are blocked from logging in without being permanently deleted
- Delete a user account permanently when it is no longer needed

**Visual suggestion:** Screenshot or mockup of the user management page showing both panels, with callouts on the action buttons

---

## SLIDE 12 — Profile Management

**Title:** Profile Management — Every User's Own Space

**Content phrases:**
- Both Admins and Users have access to a personal profile page
- Displays account information: role, status, date joined, and last updated
- Edit first name, last name, and email through a clean modal form
- The system checks that the new email is not already in use by another account
- Changes are applied instantly via AJAX — no full page reload required
- A dedicated logout confirmation modal prevents accidental sign-outs

**Visual suggestion:** Screenshot of the profile page with the Edit Profile modal open alongside it

---

## SLIDE 13 — Security Highlights

**Title:** Built With Security in Mind

**Phrases (one per row or card):**
- Passwords are hashed using bcrypt — plain text passwords are never stored
- Session-based authentication — every protected page checks the session before rendering
- Role guards enforce access server-side — changing the URL is not enough to bypass restrictions
- Password reset tokens expire after 60 minutes and can only be used once
- Inactive users are blocked at login even if they know their password
- All database inputs are sanitized to prevent SQL injection attacks
- AJAX endpoints validate HTTP method and user permissions before executing

**Visual suggestion:** Shield icon as a large background watermark, bullet points overlaid in clean white text on a dark background

---

## SLIDE 14 — Tech Stack

**Title:** What It's Built With

**Items (icon + label + one-liner):**
- **PHP** — Backend logic, server-side rendering, and data processing
- **MySQL** — Relational database storing all users, tasks, comments, and logs
- **Bootstrap 5 + Hope UI** — Responsive layout and pre-built UI components
- **Chart.js** — Interactive donut charts on both dashboards
- **PHPMailer + Mailtrap** — Sends password reset emails via SMTP
- **Vanilla JavaScript** — Handles modals, AJAX fetch calls, toasts, and client-side validation
- **Swiper.js** — Powers the swipeable stat card carousel on the dashboards
- **AOS** — Animate On Scroll library for entrance animations

**Visual suggestion:** Tech logo grid (PHP elephant, MySQL dolphin, Bootstrap B, Chart.js, etc.) arranged in two rows of four

---

## SLIDE 15 — System Flow Overview

**Title:** How It All Connects

**Flow diagram content:**

```
[User opens browser]
        ↓
[index.php checks session]
        ↓
  ┌─────┴─────┐
[Login]   [Redirect to Dashboard]
  ↓               ↓
[Auth]    ┌───────┴────────┐
  ↓    [Admin Dashboard] [User Dashboard]
[Session]       ↓                ↓
           [Tasks / Users]  [My Tasks]
                ↓                ↓
           [Controllers]   [Status Update]
                ↓                ↓
           [Database]      [Activity Log]
```

**Visual suggestion:** Clean flowchart diagram with color-coded boxes (blue for admin paths, grey for user paths, white for shared)

---

## SLIDE 16 — Closing Slide

**Title:** TaskFlow
**Subtitle:** Organized. Transparent. In Control.

**Supporting line:** A complete task management solution for teams who need clarity on what needs to be done, who is doing it, and whether it's on track.

**Visual suggestion:** Same style as the title slide — full dark blue gradient, centered text, logo mark above the title
