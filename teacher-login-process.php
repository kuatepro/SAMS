<?php
session_start();
include("db.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    if (empty($email) || empty($password)) {
        $_SESSION['error'] = "All fields are required!";
        header("Location: teacher-login.php");
        exit();
    }

    // Correct table and columns
        // Authenticate using users table (where teacher credentials are stored)
        $sql = "SELECT * FROM users WHERE (email = ? OR username = ?) AND role = 'teacher' LIMIT 1";
    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }

        $stmt->bind_param("ss", $email, $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            $_SESSION['teacher_id'] = $row['id'];
            $_SESSION['teacher_email'] = $row['email'];
            header("Location: Teacherb.php");
            exit();
        } else {
            $_SESSION['error'] = "Invalid password!";
            header("Location: teacher-login.php");
            exit();
        }
    } else {
        $_SESSION['error'] = "Teacher not found!";
        header("Location: teacher-login.php");
        exit();
    }
        // Now get teacher info from teachers table
        $sql2 = "SELECT * FROM teachers WHERE user_id = ? LIMIT 1";
        $stmt2 = $conn->prepare($sql2);
        $stmt2->bind_param("i", $row['id']);
        $stmt2->execute();
        $result2 = $stmt2->get_result();
        if ($result2->num_rows === 1) {
            $teacher = $result2->fetch_assoc();
            $_SESSION['teacher_id'] = $teacher['id'];
            $_SESSION['teacher_name'] = $teacher['fullname'];
            header("Location: Teacherb.php");
            exit();
        } else {
            $_SESSION['error'] = "Teacher profile not found.";
            header("Location: teacher-login.php");
            exit();
        }
}
?>


