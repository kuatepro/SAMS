<?php
require "config.php";

$class_id = $_GET['class_id'];
$month = $_GET['month'];

$res = $conn->query("SELECT COUNT(*) as count FROM attendance_weeks WHERE class_id='$class_id' AND month='$month'");
$count = $res->fetch_assoc()['count'];

if ($count >= 4) {
    echo json_encode(["message" => "Maximum 4 weeks reached"]);
    exit;
}

$conn->query("INSERT INTO attendance_weeks (class_id, month, week_number) VALUES ('$class_id', '$month', '$count' + 1)");
echo json_encode(["message" => "Week created successfully"]);
?>