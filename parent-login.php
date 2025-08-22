<?php
include 'db.php';
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Parent Login</title>
    <link rel="stylesheet" href="Parent Register.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    
</head>
<body>
       <video autoplay muted loop id="big-video">
    <source src="img/1.mp4"></video>
    <div class="fade-container">
    <div class="container">
        <div class="left-section">
            <img src="logo.jpg" alt="logo">
            <h1>Welcome to SAMS</h1>
            <p>With SAMS, you get informed about child school info, child class participation, attendance, and performance.</p>
           
        </div>
        <div class="right-section">
            <h2>You Login as a Parent</h2>
            <div id="errorMsg" style="color:red; margin-bottom:10px;"></div>
            <?php
            if (isset($_SESSION['error'])) {
                echo '<p style=\'color:red\'>' .  $_SESSION['error'] . '</p>';
               
                unset($_SESSION['error']);

            }
            ?>

            <form method="POST" action="parent-login-process.php">
                <div class="input-group">
                    <input type="email" id="email" name="email" placeholder="Email*" required>
                      <i class="fa-solid fa-envelope" id="email-icon"></i>
                </div>
                <div class="input-group">
                    <input type="password" id="password" name="password" placeholder="Password*" required>
                    <i  class="fa-solid fa-eye-slash" onclick="togglePassword()" id="eye-icon"></i>
                </div>
                <div class="checkbox-group">
                    <label>
                        <input type="checkbox" id="remember" name="remember"> Remember me
                    </label>
                    <p><a href="contact.php" class="forgot-password"><span>Forgot password</span>?</a></p>
                </div>
                
                <input type="submit" value="LOGIN" class="btn register-btn">
            </form>
            
            <div class="social-buttons">
                <a href="#"><i class="fa-brands fa-google fa-" style="color: #ff0000;"></i></a>
                <a href="#"><i class="fa-brands fa-facebook fa-bounce" style="color: #0080ff;"></i></a>
               <!--- <button class="btn google-btn">Google</button>
                <button class="btn facebook-btn">Facebook</button> -->
            </div>
        </div>
    </div>
    </div>
         <footer>
        <p>Copyright &copy; <span class="logo">SAMS</span>,2025</p>
    </footer>

<script>
     function togglePassword() {
            const passwordInput = document.getElementById("password");
            const icon = document.getElementById("eye-icon");

            if  (passwordInput.type === "password") {
                passwordInput.type = "text";
                icon.classList.remove("fa-eye-slash");
                icon.classList.add("fa-eye");
            } else {
                passwordInput.type = "password";
                icon.classList.remove("fa-eye");
                icon.classList.add("fa-eye-slash");
            }
        }
    </script>

</body>
</html>
    
