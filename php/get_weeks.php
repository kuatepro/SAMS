<?php
require "config.php";

$class_id = $_GET['class_id'];
$month = $_GET['month'];

$res = $conn->query("SELECT week_number FROM attendance_weeks WHERE class_id='$class_id' AND month='$month'");
$weeks = [];
while($row = $res->fetch_assoc()) $weeks[] = $row;

echo json_encode($weeks);
?>