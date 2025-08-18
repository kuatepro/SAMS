<?php
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "hometech";

$conn = new mysqli($host, $user, $pass, $dbname);
if ($conn->connect_error) {
    die(json_encode(["status" => "error", "message" => "DB connection failed"]));
}
?>