<?php
session_start();
require_once 'config.php';

$role = $_POST['role'] ?? '';
$email = trim($_POST['email'] ?? '');
$password = $_POST['password'] ?? '';

$stmt = $conn->prepare('SELECT id, role, password_hash FROM users WHERE email=? AND role=?');
$stmt->bind_param('ss', $email, $role);
$stmt->execute();
$res = $stmt->get_result();
if($row = $res->fetch_assoc()){
  $hash = $row['password_hash'];
  if(password_verify($password, $hash) || $password === $hash){ // allow plaintext for seeded users
    $_SESSION['user_id'] = $row['id'];
    $_SESSION['role'] = $row['role'];
    header('Location: dashboards/'.$row['role'].'.php');
    exit;
  }
}
echo 'Invalid credentials';
?>
