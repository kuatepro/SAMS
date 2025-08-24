<?php
include 'db.php';
session_start();
if (!isset($_SESSION['admin_id'])) {
    header('Location: admin-login.php');
    exit();
}
if (isset($_POST['add_teacher'])) {
    $fullname = $_POST['teacher_fullname'];
    $email = $_POST['teacher_email'];
    $password = $_POST['teacher_password'];
    $contact = $_POST['teacher_contact'];
    // Make sure your table has columns: fullname, email, password, contact
    $stmt = $conn->prepare("INSERT INTO teachers (fullname, email, password, contact) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $fullname, $email, $password, $contact);
    if (!$stmt->execute()) {
        die("Error saving teacher: " . $stmt->error);
    }
    $stmt->close();
    $_SESSION['message'] = "Teacher added successfully!";
    header("Location: adminb.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Teacher</title>
    <link rel="stylesheet" href="adminb.css">
</head>
<body>
<main class="main-content">
    <h2>Add Teacher</h2>
    <?php
    if (isset($_SESSION['message'])) {
        echo "<p style='color:green;'>" . $_SESSION['message'] . "</p>";
        unset($_SESSION['message']);
    }
    ?>
    <form method="POST">
        <label>Full Name</label>
        <input type="text" name="teacher_fullname" required>
        <label>Email</label>
        <input type="email" name="teacher_email" required>
        <label>Password</label>
        <input type="password" name="teacher_password" required>
        <label>Contact</label>
        <input type="text" name="teacher_contact" required>
        <button type="submit" name="add_teacher" class="submit-btn">Save Teacher</button>
    </form>
    <br>
    <a href="adminb.php">Back to Dashboard</a>
</main>
</body>
</html>