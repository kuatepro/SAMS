<?php
require "config.php";
$data = json_decode(file_get_contents("php://input"), true);

$class_id = $data['class_id'];
$month = $data['month'];
$week_number = $data['week_number'];

foreach($data['records'] as $rec) {
    $days = implode(",", $rec['days']);
    $student_id = $rec['student_id'];

    $conn->query("REPLACE INTO attendance_records (class_id, month, week_number, student_id, days) VALUES ('$class_id','$month','$week_number','$student_id','$days')");
}

echo json_encode(["message" => "Attendance saved successfully"]);
?>