<?php
include 'db.php';
session_start();

if (!isset($_SESSION['teacher_id'])) {
    echo "Unauthorized!";
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['attendance'])) {
    $teacher_id = $_SESSION['teacher_id'];
    $attendanceData = json_decode($_POST['attendance'], true);

    foreach ($attendanceData as $row) {
        $student_id = intval($row['student_id']);
        $class_id   = intval($row['class_id']); // make sure JS sends class_id
        $date_taken = $row['date_taken'];       // renamed for consistency
        $status     = $row['status'];
        $week       = $row['week'] ?? null;     // optional
        $month      = $row['month'] ?? null;    // optional

        // Avoid duplicates
        $check = $conn->prepare("SELECT id FROM attendance 
                                 WHERE student_id=? AND date_taken=? AND week_number=? AND class_id=? AND teacher_id=?");
        $check->bind_param("isiii", $student_id, $week, $class_id, $date_taken, $teacher_id);
        $check->execute();
        $result = $check->get_result();

        if ($result->num_rows == 0) {
            $stmt = $conn->prepare("INSERT INTO attendance 
                (student_id, teacher_id, class_id, date_taken, status, week, month) 
                VALUES (?,?,?,?,?,?,?)");
            $stmt->bind_param("iiissss", $student_id, $teacher_id, $class_id, $date_taken, $status, $week, $month);
            $stmt->execute();
        }
    }

    echo "✅ Attendance saved successfully!";
}
?>


