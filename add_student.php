<?php
include 'db.php';
session_start();
if (!isset($_SESSION['admin_id'])) {
    header('Location: admin-login.php');
    exit();
}
if (isset($_POST['add_student'])) {
    $fullname = $_POST['student_fullname'];
    $matricule = $_POST['student_matricule'];
    $class = $_POST['student_class'];
    // Save to column 'class' instead of 'class_id'
    $stmt = $conn->prepare("INSERT INTO students (fullname, matricule, class) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $fullname, $matricule, $class);
    if (!$stmt->execute()) {
        die("Error saving student: " . $stmt->error);
    }
    $stmt->close();
    $_SESSION['message'] = "Student added successfully!";
    header("Location: add_student.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Student</title>
    <link rel="stylesheet" href="adminb.css">
</head>
<body>
<!-- Sidebar -->
<aside class="sidebar">
    <img src="logo.jpg" alt="logo">
    <nav>
        <a href="adminb.php">Dashboard</a>
       
    </nav>
</aside>
<main class="main-content">
    <h2>Add Student</h2>
    <?php
    if (isset($_SESSION['message'])) {
        echo "<p style='color:green;'>" . $_SESSION['message'] . "</p>";
        unset($_SESSION['message']);
    }
    ?>
    <form method="POST">
        <label>Full Name</label>
        <input type="text" name="student_fullname" required>
        <label>Matricule</label>
        <input type="text" name="student_matricule" required>
        <label>Class</label>
        <input type="text" name="student_class" required>
        <button type="submit" name="add_student" class="submit-btn">Save Student</button>
    </form>
    <br>

</main>
<footer>
    <p>Copyright &copy; <span class="logo">SAMS</span>,2025</p>
</footer>

</body>
</html>
