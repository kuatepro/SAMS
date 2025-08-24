<?php
header('Content-Type: application/json');
include 'db.php';

if (!$conn) {
    echo json_encode(['error' => 'Database connection failed']);
    exit;
}

$class_id = isset($_GET['class_id']) ? $_GET['class_id'] : null;
$student_id = isset($_GET['student_id']) ? $_GET['student_id'] : null;

$where = [];
$params = [];
$types = '';

if ($class_id) {
    $where[] = 'student_id IN (SELECT id FROM students WHERE class_id = ?)';
    $params[] = $class_id;
    $types .= 'i';
}
if ($student_id) {
    $where[] = 'student_id = ?';
    $params[] = $student_id;
    $types .= 'i';
}

$where_sql = $where ? ('WHERE ' . implode(' AND ', $where)) : '';

// Check if attendance table has the correct columns
$sql = "SELECT student_id, student_name, date_taken,
            SUM(status='P') AS present,
            SUM(status='A') AS absent,
            SUM(status='L') AS late
        FROM attendance
        $where_sql
        GROUP BY student_id, student_name, date_taken
        ORDER BY date_taken DESC";

$stmt = $conn->prepare($sql);
if ($stmt === false) {
    echo json_encode(['error' => $conn->error, 'sql' => $sql]);
    exit;
}
if ($params) {
    $stmt->bind_param($types, ...$params);
}
$stmt->execute();
$result = $stmt->get_result();

$summary = [];
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $summary[] = $row;
    }
} else {
    echo json_encode(['error' => 'No result', 'sql' => $sql]);
    exit;
}

echo json_encode(['summary' => $summary]);
?>
