<?php
// Add this at the top to parse JSON input
$data = json_decode(file_get_contents('php://input'), true);

if (!isset($data['attendance']) || !is_array($data['attendance'])) {
    echo "No attendance data received.";
    exit;
}
include 'db.php';
// Connect to database
// adjust path as needed

if (!$conn) {
    echo "Database connection failed: " . mysqli_connect_error();
    exit;
}

$success = true;
foreach ($data['attendance'] as $rec) {
    $student_id = $rec['student_id'];
    $student_name = isset($rec['name']) ? $rec['name'] : ''; // use 'name' from frontend
    $date_taken = $rec['date'];
    $status = $rec['status'];

    $stmt = $conn->prepare("INSERT INTO attendance (student_id, student_name, date_taken, status) VALUES (?, ?, ?, ?)");
    if ($stmt === false) {
        $success = false;
        echo "Prepare failed: " . $conn->error;
        continue;
    }
    $stmt->bind_param("isss", $student_id, $student_name, $date_taken, $status);
    if (!$stmt->execute()) {
        $success = false;
        echo "Execute failed: " . $stmt->error;
    }
    $stmt->close();
}

echo $success ? "Attendance saved." : "Error saving attendance.";
?>