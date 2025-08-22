<?php
session_start();
require_once 'config.php';

$role = $_POST['role'] ?? 'teacher';
$full_name = trim($_POST['full_name'] ?? '');
$email = trim($_POST['email'] ?? '');
$id_number = trim($_POST['id_number'] ?? '');
$contact = trim($_POST['contact'] ?? '');
$password = $_POST['password'] ?? '';

if(!$full_name || !$email || !$id_number || !$contact || !$password){
  die('Missing fields');
}

$hash = password_hash($password, PASSWORD_DEFAULT);

$stmt = $conn->prepare('INSERT INTO users (role, full_name, email, id_number, contact, password_hash) VALUES (?,?,?,?,?,?)');
$stmt->bind_param('ssssss', $role, $full_name, $email, $id_number, $contact, $hash);
if($stmt->execute()){
  $_SESSION['user_id'] = $stmt->insert_id;
  $_SESSION['role'] = $role;
  header('Location: dashboards/'.$role.'.php');
} else {
  echo 'Error: ' . $conn->error;
}
?>
