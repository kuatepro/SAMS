             
             Student Attendance Management System(SAMS)

* Overview

SAMS is a web-based system designed to help schools manage attendance efficiently. Teachers can take attendance, post updates, and parents can monitor their children’s attendance in real-time. Admins can manage teachers, students, and parents, while posting announcements.

The system improves communication between school staff and parents and provides a centralized attendance record.


              * Features

    🥸 Admin

Manage teachers, students, and parents.

Post announcements and updates.

View attendance summaries for all classes.

Secure login and session management.


    👩‍🏫 Teacher

Take attendance per class, week, and month.

Cannot delete posted attendance.

View weekly/monthly attendance reports and posts them.

 
       👪 Parent

Monitor child’s attendance in real-time.

Receive school announcements.

            Tech Stack

Frontend: HTML, CSS, JavaScript

Backend: PHP (PDO/MySQLi)

Database: MySQL

            Dashboard Screenshots

Admin Dashboard
![Admin dashboard](<img/admin dashboard.png>)



Teacher Attendance Page
![teacher take attendance page](<img/admin dashboard.png>)



Parent Dashboard
![Parent dashboard](<img/parent dashboard.png>)

Teacher Dashboard
![teacher dashboard](<img/teacher dashboard.png>)



             Database  Tables:

1. teachers – stores teacher info.

2. students – stores student info.

3. parents – stores parent info.

4. attendance – stored attendance records.

5. posts – stores announcements.

6. users – stores users (teachers,  parents).

7. Admin - stores admin credentials.

8. classes - stores the different classes in the system

               Relationships:

teachers(id) → attendance(teacher_id)
students(id) → attendance(student_id)
parents(id) → students(parent_id)

               Installation & Setup fo the project

1. Clone the repository: git clone <https://github.com/kuatepro/SAMS.git>

2. Import database.sql into MySQL.

3. Update db.php with your database credentials.

4. Run on a local server (XAMPP/WAMP/LAMP).

5. Access dashboards:

Admin: admin-Register.php

Teacher: teacher-Register.php

Parent: parent-Register.php

                 How to Use

1. Admin: Reister, Log in, manage users, post announcements, view attendance summaries.


2. Teacher: Register, Log in, take attendance, view reports.


3. Parent: Register, Log in, monitor child attendance, view announcements.



