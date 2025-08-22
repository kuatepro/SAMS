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
                    <input type="text" id="full-name" name="fullname" placeholder="Fullname*" required>
                     <i class="fa-solid fa-user" id="name-icon"></i>
                </div>
                <div class="input-group">
                    <input type="email" id="email" name="email" placeholder="Email*" required>
                      <i class="fa-solid fa-envelope" id="email-icon"></i>
                </div>
               <!-- <div class="input-group">
                    <input type="telephone" id="contact" placeholder="Contact" required>
                </div>-->
                
                    <div class="input-group">
                        <input type="text" id="admin-id" name="admin_id" placeholder="ID*" required>
                        <i class="fa-solid fa-id-badge" id="id-icon"></i>
                    </div>
                    <div class="input-group">
                        <input type="password" id="password" name="password" placeholder="Password*" required>
                         <i  class="fa-solid fa-eye-slash" onclick="togglePassword()" id="eye-icon"></i>
                    </div>
                
               
               <!-- <div class="input-group">
                    <input type="text" id="teacher-id"placeholder="Position" required>
                </div>-->
                <div class="checkbox-group">
                    <label>
                        <input type="checkbox" id="remember"> Remember me
                    </label>
                    
                </div>
                <div id="errorMsg" style="color:red; margin-bottom:10px;"></div>
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
     // Prevent form submission by default
    
    let fullname = document.getElementById('full-name').value.trim();
    let teacherId = document.getElementById('admin-id').value.trim();
    //let contact = document.getElementById('contact').value.trim();
    let password = document.getElementById('password').value;
   // let age = document.getElementById('age').value.trim();
   // let address = document.getElementById('address').value.trim();
   // let email = document.getElementById('email').value.trim();
    let errorMsg = document.getElementById('errorMsg');

    // Clear previous error
    errorMsg.textContent = "";

    // Full Name
    if(!fullname){
        e.preventDefault();
        errorMsg.textContent = "Full Name is required!";
        return;
    }
    if(fullname.length > 12){
        e.preventDefault();
        errorMsg.textContent = "Full Name cannot exceed 12 characters!";
        return;
    }
        if(fullname.length < 5){
        e.preventDefault();
        errorMsg.textContent = "Full name should be greater than 5 characters!";
        return;
    }

    // ID
   /* if(!teacherId){
        e.preventDefault();
        errorMsg.textContent = "ID is required!";
        return;
    }*/

    // Contact
   /* if(!contact){
        e.preventDefault();
        errorMsg.textContent = "Contact is required!";
        return;
    }*/
    /*if(!/^\d{9}$/.test(contact)){
        e.preventDefault();
        errorMsg.textContent = "Contact must be exactly 9 digits!";
        return;
    }*/

    // Password
    if(!password){
        e.preventDefault();
        errorMsg.textContent = "Password is required!";
        return;
    }
    if(password.length < 6){
        e.preventDefault();
        errorMsg.textContent = "Password must be at least 6 characters!";
        return;
    }

    // Age
   /* if(!age){
        e.preventDefault();
        errorMsg.textContent = "Age is required!";
        return;
    }*/
    /*if(isNaN(age) || age < 18){
        e.preventDefault();
        errorMsg.textContent = "Age must be a number and at least 18!";
        return;
    }*/

    // Address
   /* if(!address){
        e.preventDefault();
        errorMsg.textContent = "Address is required!";
        return;
    }*/

    // Email
    /*if(!email){
        e.preventDefault();
        errorMsg.textContent = "Email is required!";
        return;
    }
    let emailPattern = /^[^ ]+@[^ ]+\.[a-z]{2,3}$/;
    if(!emailPattern.test(email)){
        e.preventDefault();
        errorMsg.textContent = "Invalid email format!";
        return;
    }*/

    // All validations passed → form submits
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