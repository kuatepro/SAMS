<?php
include 'db.php';

session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <link rel="stylesheet" href="Admin Register.css"></link>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body> <video autoplay muted loop id="big-video">
    <source src="img/1.mp4"></video>

    <div class="fade-container">
        <div class="container">
        <div class="left-section">
            <img src="logo.jpg" alt="logo">
            <h1>Welcome to SAMS</h1>
            <p>With SAMS you can upload school info for students parents to view.</p>
            
        </div>
        <div class="right-section">
            <h2>You Login as an Administrator</h2>
             <div id="errorMsg" style="color:red; margin-bottom:10px;"></div>
            <?php
            if (isset($_SESSION['error'])) {
                echo '<p style=\'color:red\'>' .
                $_SESSION['error'] . '</p>';
                unset($_SESSION['error']);
            }
            ?>
            <form id="login-form" method="POST" action="admin-login-process.php">
                <div class="input-group">
                    <input type="text" id="email" name="email" placeholder="Email*">
                    <i class="fa-solid fa-envelope" id="email-icon"></i>
                    <div class="error" id="emailError" style="color:red; font-size:13px;"></div>
                </div>
                <div class="input-group">
                    <input type="password" id="password" name="password" placeholder="Password*">
                    <i class="fa-solid fa-eye-slash" onclick="togglePassword()" id="eye-icon"></i>
                    <div class="error" id="passwordError" style="color:red; font-size:13px;"></div>
                </div>
                <div class="checkbox-group">
                    <label>
                        <input type="checkbox" id="remember" name="remember"> Remember me
                    </label>
                    <p><a href="contact.php" class="forgot-password"><span>Forgot password</span>?</a></p>
                </div>
                <button type="submit" class="btn register-btn">LOGIN</button>
            </form>
            
            <div class="social-buttons">
                <a href="#"><i class="fa-brands fa-google fa-" style="color: #ff0000;"></i></a>
                <a href="#"><i class="fa-brands fa-facebook fa-bounce" style="color: #0080ff;"></i></a>
            </div>
        </div>
   
    </div>
    </div>
    <footer>
        <p>Copyright &copy; <span class="logo">SAMS</span>,2025</p>
    </footer>

<script>
document.getElementById('login-form').addEventListener('submit', function(e) {
    document.getElementById('emailError').textContent = "";
    document.getElementById('passwordError').textContent = "";

    let email = document.getElementById('email').value.trim();
    let password = document.getElementById('password').value;
    let hasError = false;

    if(!email){
        document.getElementById('emailError').textContent = "Please fill the Email field!";
        hasError = true;
    }
    if(!password){
        document.getElementById('passwordError').textContent = "Please fill the Password field!";
        hasError = true;
    }
    if(hasError){
        e.preventDefault();
    }
});
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