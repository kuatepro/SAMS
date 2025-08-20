

<?php
include 'db.php';
session_start();

if (!isset($_SESSION['teacher_id'])) {
    echo "Unauthorized!";
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $teacher_id = $_SESSION['teacher_id'];
    $attendance = $_POST['attendance']; // this will be JSON data from JS

    $attendanceData = json_decode($attendance, true);

    foreach ($attendanceData as $record) {
        $student_id = $record['student_id'];
        $date_taken = $record['date'];
        $status = $record['status'];

        // prevent duplicate (teacher shouldn’t mark twice for same date & student)
        $check = $conn->prepare("SELECT * FROM attendance WHERE student_id=? AND date_taken=? AND teacher_id=?");
        $check->bind_param("isi", $student_id, $date_taken, $teacher_id);
        $check->execute();
        $result = $check->get_result();

        if ($result->num_rows === 0) {
            $stmt = $conn->prepare("INSERT INTO attendance (student_id, teacher_id, date_taken, status) VALUES (?,?,?,?)");
            $stmt->bind_param("iiss", $student_id, $teacher_id, $date_taken, $status);
            $stmt->execute();
        }
    }

    echo "Attendance saved successfully!";
}
?>

