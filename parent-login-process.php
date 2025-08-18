<?php
session_start();
include 'db.php'; // your DB connection


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';

    if (empty($email) || empty($password)) {
        $_SESSION['error'] = "All fields are required!";
        header("Location: parent-login.php");
        exit();
    }

    $sql = "SELECT * FROM parents WHERE email = ? LIMIT 1";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows === 1) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            $_SESSION['parent_id'] = $row['id'];
            $_SESSION['parent_name'] = $row['fullname'];
            header("Location: Parentb.php");
            exit();
        } else {
            $_SESSION['error'] = "Invalid password!";
            header("Location: parent-login.php");
            exit();
        }
    } else {
        $_SESSION['error'] = "Parent not found!";
        header("Location: parent-login.php");
        exit();
    }
}
?>
