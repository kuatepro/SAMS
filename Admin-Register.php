<?php
include 'db.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Register</title>
    <link rel="stylesheet" href="Admin Register.css"></link>
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
            <p>With SAMS you can upload  for their parents to view.</p>
           <!-- <button class="btn login-btn">LOGIN</button>-->
              <a href="admin-login.php" class="form-1" id="forms"><span>LOGIN</span></a> 
        </div>
        <div class="right-section">
            <h2>You Register  as an Admin</h2>
            <div id="errorMsg" style="color: red; margin-bottom: 10px; text-align: center;"></div>
            <form id="registration-form" action="admin-register-process.php" method="POST" autocomplete="on">
                <div class="input-group">
                    <input type="text" id="full-name" name="fullname" placeholder="Fullname*">
                    <i class="fa-solid fa-user" id="name-icon"></i>
                    <div class="error" id="fullnameError" style="color:red; font-size:13px;"></div>
                </div>
                <div class="input-group">
                    <input type="email" id="email" name="email" placeholder="Email*">
                    <i class="fa-solid fa-envelope" id="email-icon"></i>
                    <div class="error" id="emailError" style="color:red; font-size:13px;"></div>
                </div>
                <div class="input-group">
                    <input type="text" id="admin-id" name="admin_id" placeholder="ID*">
                    <i class="fa-solid fa-id-badge" id="id-icon"></i>
                    <div class="error" id="adminIdError" style="color:red; font-size:13px;"></div>
                </div>
                <div class="input-group">
                    <input type="password" id="password" name="password" placeholder="Password*">
                    <i  class="fa-solid fa-eye-slash" onclick="togglePassword()" id="eye-icon"></i>
                    <div class="error" id="passwordError" style="color:red; font-size:13px;"></div>
                </div>
                <div class="input-group">
                    <input type="text" id="role-check" name="role_check" placeholder="Check*">
                    <i class="fa-solid fa-check" id="check-icon"></i>
                    <div class="error" id="roleCheckError" style="color:red; font-size:13px;"></div>
                </div>
                <div class="checkbox-group">
                    <label>
                        <input type="checkbox" id="remember"> Remember me
                    </label>
                </div>
                <button type="submit" name="register" class="btn register-btn">REGISTER</button>
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
document.getElementById('registration-form').addEventListener('submit', function(e) {
    document.getElementById('fullnameError').textContent = "";
    document.getElementById('emailError').textContent = "";
    document.getElementById('adminIdError').textContent = "";
    document.getElementById('passwordError').textContent = "";
    document.getElementById('roleCheckError').textContent = "";

    let fullname = document.getElementById('full-name').value.trim();
    let email = document.getElementById('email').value.trim();
    let adminId = document.getElementById('admin-id').value.trim();
    let password = document.getElementById('password').value;
    let roleCheck = document.getElementById('role-check').value.trim();
    let hasError = false;

    if(!fullname){
        document.getElementById('fullnameError').textContent = "Please fill the Full Name field!";
        hasError = true;
    } else if(fullname.length > 12){
        document.getElementById('fullnameError').textContent = "Full Name cannot exceed 12 characters!";
        hasError = true;
    } else if(fullname.length < 5){
        document.getElementById('fullnameError').textContent = "Full name should be greater than 5 characters!";
        hasError = true;
    }

    if(!email){
        document.getElementById('emailError').textContent = "Please fill the Email field!";
        hasError = true;
    } else {
        let emailPattern = /^[^ ]+@[^ ]+\.[a-z]{2,3}$/;
        if(!emailPattern.test(email)){
            document.getElementById('emailError').textContent = "Invalid email format!";
            hasError = true;
        }
    }

    if(!adminId){
        document.getElementById('adminIdError').textContent = "Please fill the ID field!";
        hasError = true;
    }

    if(!password){
        document.getElementById('passwordError').textContent = "Please fill the Password field!";
        hasError = true;
    } else if(password.length < 6){
        document.getElementById('passwordError').textContent = "Password must be at least 6 characters!";
        hasError = true;
    }

    if(!roleCheck){
        document.getElementById('roleCheckError').textContent = "Please fill the Check field!";
        hasError = true;
    } else if(roleCheck.toLowerCase() !== "wilbrown") {
        document.getElementById('roleCheckError').textContent = "Sorry, no access to this role.";
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