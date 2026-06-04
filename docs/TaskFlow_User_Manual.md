# TaskFlow — User Manual

**System Name:** TaskFlow — Web-Based Task Management System
**Version:** 1.0
**Prepared for:** End Users and Administrators

---

## Table of Contents

1. Introduction
2. System Requirements
3. User Roles and Access Levels
4. Getting Started
   - 4.1 Registering an Account
   - 4.2 Logging In
   - 4.3 Forgot Password
   - 4.4 Resetting Your Password
   - 4.5 Logging Out
5. Admin Dashboard
6. User Dashboard
7. Task Management (Admin)
   - 7.1 Viewing Tasks
   - 7.2 Searching and Filtering Tasks
   - 7.3 Adding a Task
   - 7.4 Editing a Task
   - 7.5 Deleting a Task
   - 7.6 Bulk Deleting Tasks
   - 7.7 Viewing Task Details, Comments, and Activity Log
   - 7.8 Adding a Comment
8. User Task Actions
   - 8.1 Viewing Your Assigned Tasks
   - 8.2 Updating Your Task Status
   - 8.3 Viewing Task Details and Comments
9. User Management (Admin)
   - 9.1 Viewing All Users
   - 9.2 Searching and Filtering Users
   - 9.3 Adding a New User
   - 9.4 Editing a User's Profile
   - 9.5 Changing a User's Role
   - 9.6 Changing a User's Status
   - 9.7 Deleting a User
10. Profile Management
    - 10.1 Viewing Your Profile
    - 10.2 Editing Your Profile
    - 10.3 Logging Out from the Profile Page
11. Understanding the Activity Log
12. Frequently Asked Questions

---

## 1. Introduction

TaskFlow is a web-based task management system designed to help organizations manage work assignments, monitor team performance, and maintain a transparent record of all task-related activity. It provides two distinct experiences depending on your role: administrators have full control over tasks and users across the entire system, while regular users have a focused view of only the tasks assigned to them.

The system is accessible through a web browser and does not require any software installation on the user's device. All data is stored centrally and is available in real time to all authorized users.

This manual covers every feature available in TaskFlow for both administrators and regular users. Read the sections relevant to your role, or use the table of contents to jump directly to a specific topic.

---

## 2. System Requirements

To use TaskFlow, you need the following:

- A modern web browser such as Google Chrome, Mozilla Firefox, Microsoft Edge, or Safari. The system is not optimized for Internet Explorer.
- A stable internet connection or local network access to the server hosting TaskFlow.
- A valid user account created either through self-registration or by an administrator.

No additional plugins, extensions, or software installations are required.

---

## 3. User Roles and Access Levels

TaskFlow has two user roles. Your role determines which pages you can access and what actions you can perform.

**Administrator (Admin)**

Administrators have full access to all areas of the system. An admin can:
- View the full system-wide dashboard with team performance statistics
- Create, edit, delete, and assign tasks to any user
- View task details, comments, and the complete activity history
- Add comments to any task
- Add, edit, delete, and manage all user accounts
- Change any user's role or account status
- View and edit their own profile

**User**

Regular users have a limited, focused view of the system. A user can:
- View a personal dashboard showing only their assigned tasks
- Update the status of tasks assigned to them
- Add comments to tasks assigned to them
- View the details, comments, and activity history of their own tasks
- View and edit their own profile

A regular user cannot access the Task Management page, the User Management page, or view any tasks that belong to other users. Attempting to access a restricted page will redirect the user to the login page.

---

## 4. Getting Started

### 4.1 Registering an Account

New users can create an account by visiting the registration page. To register:

1. Navigate to the registration page by clicking the "Register" link on the login screen.
2. Enter your first name and last name in the two fields provided side by side.
3. Enter a valid email address. This email will be used to log in and to receive password reset links.
4. Enter a password and re-enter it in the "Confirm Password" field to verify they match.
5. Check the "Terms of Use" checkbox to acknowledge that you agree to the system's terms.
6. Click the "Create Account" button.

If the email address you entered is already associated with an existing account, the system will display an error and ask you to use a different email. If all inputs are valid, your account will be created with the role of "User" and an "Active" status. You will be redirected to the login page upon successful registration.

**Note:** All newly registered accounts are assigned the "User" role by default. Only an administrator can elevate an account to the "Admin" role after the account has been created.

---

### 4.2 Logging In

To log in to TaskFlow:

1. Open the TaskFlow login page in your browser.
2. Enter your registered email address in the email field.
3. Enter your password in the password field. You may click the eye icon on the right side of the field to show or hide your password.
4. Optionally, check the "Remember Me" checkbox. This will save your email address in the browser for 30 days so you do not have to re-enter it on your next visit.
5. Click the "Login" button.

If your credentials are correct and your account is active, you will be redirected to your role-appropriate dashboard. Administrators are taken to the Admin Dashboard, and regular users are taken to the User Dashboard.

If your email or password is incorrect, a toast notification will appear at the bottom-right of the screen with an error message. If your account has been deactivated by an administrator, a message will inform you that your account is inactive and that you should contact an administrator.

---

### 4.3 Forgot Password

If you have forgotten your password:

1. Click the "Forgot password?" link on the login page.
2. On the Forgot Password page, enter the email address associated with your account.
3. Click "Send Reset Link."

If the email address exists in the system, a password reset link will be sent to your inbox. The email contains a link that is valid for 60 minutes from the time it was sent. If you do not receive the email within a few minutes, check your spam or junk folder.

If the email address is not found in the system, an error message will appear and no email will be sent.

---

### 4.4 Resetting Your Password

After clicking the reset link from your email:

1. You will be taken to the Reset Password page. The system automatically validates the link before showing you the form. If the link has expired or has already been used, you will be redirected to the Forgot Password page and asked to request a new one.
2. Enter your new password in the "New Password" field. Passwords must be at least 8 characters long.
3. Re-enter the same password in the "Confirm Password" field.
4. Click "Reset Password."

If the passwords match and meet the minimum length requirement, your password will be updated and you will be redirected to the login page with a success message. The reset link is immediately invalidated after use and cannot be used again.

---

### 4.5 Logging Out

You can log out from two places in the system:

- **From the Navbar:** Click your name or avatar in the top-right navigation bar to open the dropdown menu, then click "Logout."
- **From the Profile Page:** Click the "Logout" button in the top-right section of your profile. A confirmation modal will appear asking you to confirm the action. Click "Yes, Logout" to proceed or "Cancel" to stay logged in.

Logging out will destroy your session entirely. You will need to log in again to access the system.

---

## 5. Admin Dashboard

The Admin Dashboard is the first page an administrator sees after logging in. It provides a high-level, real-time overview of the entire system.

**Welcome Header**
At the top of the page, the dashboard greets the administrator by first name and includes a brief description: "Here's an overview of the task management system."

**Stat Cards**
Below the header is a row of swipeable stat cards. Each card shows a single key metric:
- **Total Users** — the total number of user accounts registered in the system, regardless of role or status.
- **Total Tasks** — the total number of tasks that exist across all users.
- **Ongoing Tasks** — the number of tasks currently marked as "In Progress."
- **Completed Tasks** — the number of tasks marked as "Completed."
- **Overdue Tasks** — the number of tasks whose due date has passed but whose status is not yet "Completed."

On smaller screens, the cards are arranged in a swiper carousel that can be scrolled horizontally.

**Team Performance Tracker**
Below the stat cards is a table that shows the top 10 users ordered by how many tasks have been assigned to them. For each user, the table displays:
- Their assigned task count along with a horizontal progress bar showing their share relative to the most-assigned user
- How many of their tasks are completed
- How many are ongoing
- How many are overdue

The "View Users" button in the top-right of this table links directly to the User Management page.

**Task Distribution and Activity**
To the left of this section is a panel showing three priority metric boxes (High, Medium, Low) with their respective task counts, along with two additional metrics: the number of tasks assigned today and the number of tasks that have at least one comment.

**Priority Breakdown Chart**
To the right is an interactive donut chart built with Chart.js. It shows the proportion of High, Medium, and Low priority tasks visually. Hovering over a segment shows the exact count and the percentage it represents. The total task count is displayed in the center of the chart.

---

## 6. User Dashboard

The User Dashboard is displayed to regular users after login. It shows only the data relevant to the currently logged-in user and does not include any system-wide information.

**Welcome Header**
The dashboard greets the user by first name and includes the subtitle: "Here's an overview of your assigned tasks."

**Stat Cards**
Four stat cards display the following personal metrics:
- **My Tasks** — the total number of tasks assigned to this user
- **In Progress** — the user's tasks currently in progress
- **Completed** — the user's completed tasks
- **Overdue** — the user's tasks that are past due and not yet completed

**My Assigned Tasks Table**
The main section of the dashboard is a table listing all tasks assigned to the current user. The table is sorted automatically in the following priority order: overdue tasks appear first, followed by High priority tasks, then Medium, then Low, and within each group tasks are sorted by due date (earliest first). This ensures the most urgent work is always at the top without any manual sorting needed.

Each row in the table shows the task title, a description snippet if available, the priority badge, the due date (displayed in red and bold if the task is overdue), the current status badge, and two action buttons.

**Flash Messages**
After updating a task status, the page redirects back to the dashboard. If the update was successful, a toast notification will appear at the bottom-right corner of the screen confirming the change. If it failed, a different toast will indicate the error.

**Task Status Donut Chart**
On the right side of the page is a donut chart showing this user's task distribution by status: In Progress, Completed, and Overdue.

**Completion Progress Bar**
Below the chart is a progress bar that shows the percentage of this user's tasks that have been completed. The bar changes color depending on the completion rate: blue for below 40%, orange for 40–74%, and green for 75% and above.

---

## 7. Task Management (Admin)

The Task Management page is accessible only to administrators. It provides a full table of all tasks in the system with tools for creating, editing, filtering, and deleting tasks.

### 7.1 Viewing Tasks

The task table shows 5 tasks per page by default. Each row displays:
- A checkbox for bulk selection
- Task title and a short description snippet
- The name of the assigned user
- A priority badge (color-coded: red for High, yellow for Medium, green for Low)
- A status badge (blue for In Progress, green for Completed)
- The due date
- Three action buttons: Details, Edit, and Delete

### 7.2 Searching and Filtering Tasks

The toolbar above the table includes several tools to help you find specific tasks quickly:

- **Search box** — type any keyword to search across task titles, descriptions, assignee names, priority values, and statuses. Results update when you press Enter or submit the form.
- **Priority filter** — select All Priorities, High, Medium, or Low to limit the list to tasks of a specific priority.
- **Status filter** — select All Statuses, In Progress, or Completed to filter by task status.
- **Sort dropdown** — choose between the default sort (newest tasks first), Due Date ascending (earliest due first), or Due Date descending (latest due first).

All active filters are preserved across page navigation, meaning if you are on page 2 of a filtered result set and click to page 3, the filters remain applied.

### 7.3 Adding a Task

To add a new task:

1. Click the "Add Task" button in the top-right area of the page header.
2. A modal form will appear. Fill in the following fields:
   - **Task Title** (required) — a short, descriptive name for the task.
   - **Description** (optional) — additional context or instructions for the assigned user.
   - **Assign To** — select the user this task should be assigned to from the dropdown list. The list includes all registered users.
   - **Due Date** — the date by which the task should be completed.
   - **Priority** — select High, Medium, or Low.
   - **Status** — select In Progress or Completed as the initial status.
3. Click "Add Task" to save.

The task will appear in the table immediately and an activity log entry of "task_created" will be recorded.

### 7.4 Editing a Task

To edit an existing task:

1. Click the blue pencil (Edit) button on the task row you want to edit.
2. A pre-filled modal form will appear with the task's current values.
3. Modify any of the available fields: title, description, assignee, due date, priority, or status.
4. Click "Save Changes" to apply the updates.

The system automatically detects which fields changed and records a detailed log entry. For example, if you changed the priority from "Low" to "High" and the status from "In Progress" to "Completed," the activity log will contain: "Priority changed from 'Low' to 'High'; Status changed from 'In Progress' to 'Completed'."

### 7.5 Deleting a Task

To delete a single task:

1. Click the red trash (Delete) button on the task row you want to remove.
2. A confirmation modal will appear showing the task's title and asking you to confirm the deletion.
3. Click "Delete" to permanently remove the task.

Deletion is permanent. The task and all its associated comments will be removed from the database. An activity log entry is recorded before deletion.

### 7.6 Bulk Deleting Tasks

To delete multiple tasks at once:

1. Check the checkboxes on the left side of the rows you want to delete. To select all visible tasks at once, check the checkbox in the table header row.
2. Once at least one task is selected, the "Delete Selected" button in the toolbar becomes active (it is greyed out when nothing is selected).
3. Click "Delete Selected."
4. A confirmation dialog will appear. Click "Yes" to confirm.

Each deleted task receives its own activity log entry noting that it was removed as part of a bulk action.

### 7.7 Viewing Task Details, Comments, and Activity Log

To view the full details of a task including its comment thread and activity history:

1. Click the grey Details (three dots) button on the task row.
2. A modal will open showing two panels:
   - **Comments panel** (left) — displays all comments posted on this task, sorted newest first. Each comment shows the author's name, the timestamp, and the comment text.
   - **Activity Log panel** (right) — displays up to the last 30 recorded events for this task. Each entry shows the type of action (e.g., "task_updated"), the details of what changed, the name of the person who performed the action, and the timestamp.

Both panels are scrollable if there are many entries.

### 7.8 Adding a Comment

From within the Task Details modal:

1. Scroll to the bottom of the Comments panel.
2. Type your comment in the text area provided.
3. Click "Add Comment."

The comment will be saved immediately and appear at the top of the comments list without needing to close and reopen the modal. An activity log entry of "comment_added" will also be recorded.

---

## 8. User Task Actions

### 8.1 Viewing Your Assigned Tasks

After logging in, your assigned tasks are displayed in the main table on your dashboard. The table is sorted automatically so that the most urgent tasks appear first. You do not need to manually sort or filter — the system arranges tasks in this order:

1. Overdue tasks (past due date and not completed) — always shown first
2. High priority tasks
3. Medium priority tasks
4. Low priority tasks
5. Within each group, tasks are further sorted by due date, with the earliest due date appearing first

If you have no tasks assigned to you, the table will display a friendly message indicating that there are currently no tasks.

### 8.2 Updating Your Task Status

To update the status of a task assigned to you:

1. In the task table on your dashboard, click the blue pencil (Edit) button on the task whose status you want to change.
2. An "Update Status" modal will appear showing the task title and a dropdown to select the new status.
3. Select either "In Progress" or "Completed."
4. Click "Update Status."

The page will reload and a green toast notification will confirm that the status was updated successfully. The change is also recorded in the task's activity log. You can only update tasks that are directly assigned to you — any attempt to update another user's task will be rejected by the system.

### 8.3 Viewing Task Details and Comments

To view the full details, comments, and activity log for any of your assigned tasks:

1. Click the grey Details button (the icon with three vertical dots) on the task row.
2. A modal will open showing the Comments panel and the Activity Log panel, exactly as described in Section 7.7.

Regular users can only open the details modal for tasks that are assigned to them. The system enforces this restriction server-side.

---

## 9. User Management (Admin)

The User Management page is accessible only to administrators. It provides a two-panel interface: a scrollable user list on the left, and a detailed profile view on the right.

### 9.1 Viewing All Users

When you open the User Management page, all registered user accounts are listed on the left panel, ordered by the most recently created first. Each item in the list shows a colored initials avatar, the user's full name, their role, and a status dot (green for Active, grey for Inactive).

To view a user's full profile, click their name in the list. Their information will appear in the right panel immediately.

### 9.2 Searching and Filtering Users

The left panel includes the following tools:

- **Search input** — type any name or keyword to filter the user list in real time. The list updates as you type without requiring a page reload.
- **Role filter** — select All Roles, Admin, or User to limit the list to accounts of a specific role.
- **Status filter** — select All Status, Active, or Inactive to filter by account status.

Filters can be combined. For example, you can search for "John" while also filtering by Role: User to find all regular users named John.

### 9.3 Adding a New User

To add a user directly from the admin panel without going through the public registration page:

1. Click the "Add User" button in the top-right section of the page header.
2. A modal form will appear. Fill in the following:
   - **First Name** and **Last Name**
   - **Email** — must be a valid, unique email address
   - **Password** — the initial password for the account
   - **Role** — select either Admin or User
3. Click "Add User" to create the account.

The new user is created with an Active status by default. The password is stored as a secure hash and is not visible to anyone, including the administrator.

### 9.4 Editing a User's Profile

To update a user's name or email address:

1. Select the user from the list on the left to load their profile on the right.
2. Click the blue "Edit Profile" button at the bottom of the right panel.
3. A modal form will appear pre-filled with the user's current first name, last name, and email.
4. Make the necessary changes and click "Save Changes."

The system will update the user's record immediately. If the new email is already in use by a different account, the system will not allow the change and will display an error message.

### 9.5 Changing a User's Role

To change a user's role between Admin and User:

1. Select the user from the list.
2. Click the purple "Change Role" button in the right panel.
3. A modal will appear showing two clickable options: "Admin" and "User." The current role will be pre-selected.
4. Click the role you want to assign and then click "Save Changes."

Changing a user's role takes effect immediately. An Admin who is downgraded to User will lose access to the Task Management and User Management pages on their next page load.

### 9.6 Changing a User's Status

A user's status can be either Active or Inactive. Inactive users are blocked from logging in even if they know their password.

To change a user's status:

1. Select the user from the list.
2. Click the orange "Change Status" button in the right panel.
3. A modal will appear showing two clickable options: "Active" and "Inactive." The current status will be pre-selected.
4. Select the desired status and click "Save Changes."

Use this feature to temporarily suspend access for a user without permanently deleting their account and all associated data.

### 9.7 Deleting a User

To permanently delete a user account:

1. Select the user from the list.
2. Click the red "Delete User" button (outlined red button) in the right panel.
3. A confirmation modal will appear showing the user's name and a warning.
4. Click "Delete" to permanently remove the account.

This action is irreversible. Deleting a user removes their account from the database. Tasks that were previously assigned to them will remain in the system but will show no assignee name.

---

## 10. Profile Management

### 10.1 Viewing Your Profile

Click "Profile" in the sidebar navigation to open your profile page. The page displays:

- Your initials in a large colored avatar circle
- Your full name and email address
- A role badge (blue for Admin, grey for User)
- A status badge (green for Active)
- An Account Information section showing your role, status, date joined, and last updated date
- A Contact Information section showing your email and full name

### 10.2 Editing Your Profile

To update your name or email address:

1. Click the "Edit Profile" button in the top-right area of your profile card.
2. A modal form will appear pre-filled with your current first name, last name, and email.
3. Update any of the fields as needed. All three fields are required.
4. Click "Save Changes."

The system validates that the email you entered is not already used by another account before saving. If the email is taken, an error message will appear and the change will not be saved. If successful, a green toast notification will confirm the update and the page will reload after one second to reflect the new information.

**Note:** The profile edit form does not include a password change option. If you need to change your password, log out and use the "Forgot Password" flow from the login page.

### 10.3 Logging Out from the Profile Page

To log out from the Profile page:

1. Click the "Logout" button next to the "Edit Profile" button.
2. A confirmation modal will appear asking: "Are you sure you want to logout?"
3. Click "Yes, Logout" to end your session and be redirected to the login page.
4. Click "Cancel" or anywhere outside the modal to dismiss it and remain logged in.

---

## 11. Understanding the Activity Log

The activity log is a record of every significant action taken on a task. It is viewable inside the Task Details modal, which is accessible from both the Task Management page (admin) and the User Dashboard (users, for their own tasks only).

Each entry in the log contains:
- **Action type** — a label describing what happened (e.g., task_created, task_updated, status_changed, comment_added, task_deleted)
- **Details** — a description of the specific change. For updates, this includes a field-level breakdown such as "Priority changed from 'Low' to 'High'; Status changed from 'In Progress' to 'Completed'."
- **Actor** — the full name of the user who performed the action
- **Timestamp** — the exact date and time the action occurred

The log shows up to the last 30 entries for a task, ordered from newest to oldest. This gives both administrators and users full transparency into the history of a task without needing to contact anyone for information.

The activity log is read-only and cannot be edited or deleted through the user interface.

---

## 12. Frequently Asked Questions

**I forgot my password. What do I do?**
Go to the login page and click "Forgot password?" Enter your registered email address and a reset link will be sent to your inbox. The link is valid for 60 minutes.

**I did not receive the password reset email.**
Check your spam or junk folder. If it is not there, wait a minute and try requesting another reset link. Make sure you are entering the exact email address used when your account was created.

**I am a User but I need Admin access. What do I do?**
Contact your system administrator. Only an administrator can change your role from User to Admin through the User Management page.

**I cannot log in even though my password is correct.**
Your account may have been deactivated. The login screen will show a message saying your account is inactive. Contact your administrator to have your account reactivated.

**I updated a task but the activity log shows wrong details.**
The activity log captures the state of the task at the moment of the change. If the log entry looks unexpected, it is possible a previous edit was not saved correctly. Check the log entries in chronological order (scroll to the bottom) to trace the full history of changes.

**Can I delete a comment I posted?**
No. Comments cannot be edited or deleted through the user interface once they are submitted. They are part of the permanent activity record for the task.

**Can a User see tasks assigned to other users?**
No. The system enforces this restriction both in the interface and on the server. A regular user can only see, update, and comment on tasks directly assigned to their own account.

**What happens to tasks when a user is deleted?**
The tasks remain in the system but the assignee name will appear blank in the task table since the user account no longer exists. The tasks themselves are not deleted.

**Can I change my own role?**
No. Users cannot change their own role. This must be done by an administrator through the User Management page.

**Is there a limit to how many tasks or users the system can hold?**
There is no built-in limit enforced by the application. The practical limit depends on the capacity of the database and server hosting the application.
