<?php
session_start();
include("db.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    if (empty($email) || empty($password)) {
        $_SESSION['error'] = "All fields are required!";
        header("Location: admin-login.php");
        exit();
    }

    // Find admin in the admins table
    $sql = "SELECT * FROM admins WHERE email = ? OR admin_id = ? LIMIT 1";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $email, $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            $_SESSION['admin_id'] = $row['id'];
            $_SESSION['admin_name'] = $row['fullname'];
            header("Location: adminb.php");
            exit();
        } else {
            $_SESSION['error'] = "Invalid password!";
            header("Location: admin-login.php");
            exit();
        }
    } else {
        $_SESSION['error'] = "Admin not found!";
        header("Location: admin-login.php");
        exit();
    }
}


