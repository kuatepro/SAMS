<?php
include 'db.php';

$sql = "SELECT student_id, fullname FROM students";
$result = $conn->query($sql);

$students = [];
while ($row = $result->fetch_assoc()) {
    $students[] = $row;
}
echo json_encode($students);
?>











Perfect 👌 thanks for sending both dashboards.
Now I can show you exactly how to integrate the attendance system into both the parent dashboard and the admin dashboard.


---

✅ Step 1: Attendance Table (final simple structure)

Let’s use this clean table so you don’t get foreign key errors anymore:

CREATE TABLE attendance (
    attendance_id INT AUTO_INCREMENT PRIMARY KEY,
    student_id INT NOT NULL,
    date DATE NOT NULL,
    status ENUM('Present','Absent') NOT NULL,
    FOREIGN KEY (student_id) REFERENCES students(student_id) ON DELETE CASCADE
);

No teacher link inside here (keeps it simple).

Attendance is connected directly to students.

Later, if you want, we can add teacher_id.



---

✅ Step 2: Show Attendance in Parent Dashboard

Replace your hardcoded attendance <tbody> with this PHP:



This way, each parent only sees their own child’s attendance.


---

✅ Step 3: Show Attendance in Admin Dashboard

Inside the Students List section, instead of static percentages, let’s fetch from the DB:

<?php
$sql = "SELECT s.student_id, s.fullname, s.class, 
               ROUND(SUM(a.status='Present') / COUNT(a.attendance_id) * 100, 1) as attendance_rate
        FROM students s
        LEFT JOIN attendance a ON s.student_id = a.student_id
        GROUP BY s.student_id";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>".$row['fullname']."</td>";
        echo "<td>".$row['class']."</td>";
        echo "<td>".($row['attendance_rate'] ?? 0)."%</td>";
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='3'>No students found.</td></tr>";
}
?>

