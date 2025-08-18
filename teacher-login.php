<?php
include 'db.php';

session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teacher Login</title>
    <link rel="stylesheet" href="Teachers Register.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
     <div class="container">
        <div class="left-section">
            <img src="logo.jpg" alt="logo">
            <h1>Welcome to SAMS</h1>
            <p>With PAMS, you can post student class participation, attendance, and performance for their parents to view.</p>
            
        </div>
        <div class="right-section">
            <h2>You Login as a Teacher</h2>
             <div id="errorMsg" style="color:red; margin-bottom:10px;"></div>
            <?php
            if (isset($_SESSION['error'])) {
                echo '<p style=\'color:red\'>' .
                $_SESSION['error'] . '</p>';
                unset($_SESSION['error']);
            }
            ?>
            <div id="errorMsg" style="color: red; margin-bottom: 10px; text-align: center;"></div>
            <form id="registration-form" action="teacher-login-process.php" method="POST">
                <div class="input-group">
                    <input type="text" id="email" name="email" placeholder="Email or ID" required>
                </div>
                <div class="input-group">
                    <input type="password" id="password" name="password" placeholder="Password" required>
                </div>
                <div class="checkbox-group">
                    <label>
                        <input type="checkbox" id="remember"> Remember me
                    </label>
                    <p><a href="contact.php" class="forgot-password"><span>Forgot password</span>?</a></p>
                </div>
                <button type="submit" class="btn register-btn">LOGIN</button>
            </form>
            
            <div class="social-buttons">
                <a href="#"><i class="fa-brands fa-google fa-" style="color: #ff0000;"></i></a>
                <a href="#"><i class="fa-brands fa-facebook fa-bounce" style="color: #0080ff;"></i></a>
               <!--- <button class="btn google-btn">Google</button>
                <button class="btn facebook-btn">Facebook</button> -->
            </div>
        </div>
    </div>
    <footer>
        <p>Copyright &copy; <span class="logo">SAMS</span>,2025</p>
    </footer>





</body>
</html>
