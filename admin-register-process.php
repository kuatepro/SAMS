<?php
include 'db.php'; // make sure this creates a $conn using mysqli
error_reporting(E_ALL);
ini_set('display_errors' , 1);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $fullname = trim($_POST['fullname']);
    $admin_id = trim($_POST['admin_id']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $email    = trim($_POST['email']);

    // check empty
    if (empty($fullname) || empty($admin_id) || empty($_POST['password']) || empty($email)) {
        die("❌ All fields are required.");
    }

    // prepare insert
    $sql = "INSERT INTO admins (fullname, admin_id, password, email) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        die("❌ SQL Error: " . $conn->error);
    }

    $stmt->bind_param("ssss", $fullname, $admin_id, $password, $email);

    if ($stmt->execute()) {
        //echo "✅ Registration successful! <a href='admin-login.php'>Login here</a>";
        header("Location: admin-login.php?success=1");
        exit();
    } else {
        echo "❌ Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>
