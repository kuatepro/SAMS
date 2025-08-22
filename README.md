    SAMS Web Application (SAMS)




Overview

SAMS is a web-based system designed to help schools manage attendance efficiently. Teachers can take attendance, post updates, and parents can monitor their children’s attendance in real-time. Admins can manage teachers, students, and parents, while posting announcements.

The system improves communication between school staff and parents and provides a centralized attendance record.


Features

🛠 Admin

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

Secure login system.


🧑‍💻 Tech Stack

Frontend: HTML, CSS, JavaScript

Backend: PHP (PDO/MySQLi)

Database: MySQL




 📷 Screenshots

Admin Dashboard



Teacher Attendance Page



Parent Attendance Page




 Database Structure

Tables:

1. teachers – stores teacher info.


2. students – stores student info.


3. parents – stores parent info.


4. attendance – records attendance per student per week/day.


5. posts – stores announcements.

6. users – stores users (teachers, students, parents).



Relationships:

teachers(id) → attendance(teacher_id)
students(id) → attendance(student_id)
parents(id) → students(parent_id)

Installation & Setup

1. Clone the repository:

git clone <https://github.com/kuatepro/SAMS.git>


2. Import database.sql into MySQL.


3. Update db.php with your database credentials.


4. Run on a local server (XAMPP/WAMP/LAMP).


5. Access dashboards:

Admin: admin-login.php

Teacher: teacher-login.php

Parent: parent-login.php



Usage

1. Admin: Log in, manage users, post announcements, view attendance summaries.


2. Teacher: Log in, take attendance, view reports.


3. Parent: Log in, monitor child attendance, view announcements.




Contributing

1. Fork the repository.


2. Create a branch:

git checkout -b feature-name


3. Commit your changes:

git commit -m "Add new feature"


4. Push and create a pull request.