<?php
include 'db.php'
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to SAMS</title>
    <link rel="stylesheet" href="Welcome.css">
</head>
<body>
    <div class="container">
        <div class="logo">
            <img src="logo.jpg" alt="Logo" style="width: 90px; height: 90px; object-fit: contain; background: transparent; border-radius: 10px;" />
        </div>
        <h1>Welcome to SAMS</h1>
        <p class="subtitle">Stay connected stay informed</p>
        <div class="role-section">
            <p class="role-title">What is your role ? <span class="role-hint">Click below to continue <span class="emoji">👇</span></span></p>
            <div class="role-buttons">
               
                <a href="Admin-Register.php" class="Admin-button">Admin</a> 
                <a href="Teachers-Register.php" class="Teacher-button">Teacher</a> 
               <!-- <button class="role-btn"><a href="Parent signUp.html">Parent</a></button>-->
                <a href="Parent Register.php" class="Parent-button">Parent</a> 
            </div>
        </div>
    </div>
</body>
</html>
