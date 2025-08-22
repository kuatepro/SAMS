

<?php
include 'db.php';
session_start();

if (!isset($_GET['class_id'])) {
    die("No class ID provided");
}

$class_id = intval($_GET['class_id']);

// If you also want to fetch by student for parent dashboard
$student_id = isset($_GET['student_id']) ? intval($_GET['student_id']) : null;

if ($student_id) {
    // Fetch attendance for a single student
    $sql = "SELECT s.student_id, s.fullname, a.date, a.status, a.week, a.month
            FROM students s
            LEFT JOIN attendance a ON s.student_id = a.student_id
            WHERE s.student_id = ? 
            ORDER BY a.date DESC";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $student_id);
} else {
    // Fetch attendance for all students in a class
    $sql = "SELECT s.student_id, s.fullname, a.date, a.status, a.week, a.month
            FROM students s
            LEFT JOIN attendance a ON s.student_id = a.student_id
            WHERE s.class_id = ?
            ORDER BY s.fullname, a.date";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $class_id);
}

if (!$stmt) {
    die("Prepare failed: " . $conn->error);
}

$stmt->execute();
$result = $stmt->get_result();

$records = [];
while ($row = $result->fetch_assoc()) {
    $records[] = $row;
}

echo json_encode($records);

