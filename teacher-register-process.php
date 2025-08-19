<?php
ob_start();
session_start();
include("db.php"); // $conn = new mysqli(...)
error_reporting(E_ALL);
ini_set('display_errors', 1);


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fullname = trim($_POST['fullname']);
    $contact  = trim($_POST['contact']);
    $email    = strtolower(trim($_POST['email']));
    $password = trim($_POST['password']);

    if (empty($fullname) || empty($contact) || empty($email) || empty($password)) {
        $_SESSION['error'] = "All fields are required!";
        header("Location: Teachers-Register.php");
        exit();
    }

    if (!ctype_digit($contact) || strlen($contact) != 9) {
        $_SESSION['error'] = "Contact must be exactly 9 digits.";
        header("Location: Teachers-Register.php");
        exit();
    }

    // ✅ Check if email already exists
    $check = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $check->bind_param("s", $email);
    $check->execute();
    $check->store_result();

    if ($check->num_rows > 0) {
        $_SESSION['error'] = "Email already registered. Please login.";
        header("Location: teacher-login.php");
        exit();
    }

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // ✅ Insert into users
    $sql_user = "INSERT INTO users ( username, email, password, role) VALUES (?, ?, ?, 'teacher')";
    $stmt = $conn->prepare($sql_user);
    $stmt->bind_param("sss",$fullname, $email, $hashed_password);

    if ($stmt->execute()) {
        $user_id = $conn->insert_id; // ✅ Get inserted user ID

        // Insert into teachers
        $sql_teacher = "INSERT INTO teachers (user_id, fullname, contact) VALUES (?, ?, ?)";
        $stmt2 = $conn->prepare($sql_teacher);
        $stmt2->bind_param("iss", $user_id, $fullname, $contact);

        if ($stmt2->execute()) {
            $_SESSION['success'] = "";
            header("Location: teacher-login.php");
            exit();
        } else {
            $_SESSION['error'] = "Error adding teacher: " . $stmt2->error;
            header("Location: Teachers-Register.php");
            exit();
        }
    } else {
        $_SESSION['error'] = "Error creating user: " . $stmt->error;
        header("Location: Teachers-Register.php");
        exit();
    }
}
?>


