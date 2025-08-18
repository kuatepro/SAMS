<?php
include 'db.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Parent register</title>
    <link rel="stylesheet" href="Parent Register.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    
</head>
<body>
    <div class="container">
        <div class="left-section">
            <img src="logo.jpg" alt="logo">
            <h1>Welcome to SAMS</h1>
            <p>With SAMS, you get informed about child school info, child class participation, attendance, and performance.</p>
             <a href="parent-login.php" class="form-1" id="forms"><span>LOGIN</span></a> 
            
        </div>
        <div class="right-section">
            <h2>You register as a Parent</h2>
            <div id="errorMsg" style="color:red; margin-bottom:10px;"></div>
            <form id="registration-form" action="parent-register-process.php" method="POST" autocomplete="on">
                <div class="input-group">
                    <input type="text" id="fullname" name="fullname" placeholder="Full Name" required>
                </div>
                <div class="input-group">
                    <input type="email" id="email" name="email" placeholder="Email" required>
                </div>
                <div class="input-group">
                    <input type="text" id="contact" name="contact" placeholder="Contact" required>
                </div>
                <div class="input-group">
                    <input type="password" id="password" name="password" placeholder="Password" required>
                </div>
                <div class="checkbox-group">
                    <label>
                        <input type="checkbox" id="remember"> Remember me
                    </label>
                    <p><a href="#" class="forgot-password"><span>Forgot password</span>?</a></p>
                </div>
                <div id="errorMsg" style="color:red; margin-bottom:10px;"></div>
                <button type="submit" class="btn register-btn">REGISTER</button>
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

    <script src="script.js"></script>

    <script>
document.getElementById('registration-form').addEventListener('submit', function(e) {
    // Prevent form submission by default
    
    let fullname = document.getElementById('fullname').value.trim();
    let contact = document.getElementById('contact').value.trim();
    let password = document.getElementById('password').value;
    let email = document.getElementById('email').value.trim();
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
        errorMsg.textContent = "Full should be greater than 5 characters!";
        return;
    }

    // ID
   /* if(!teacherId){
        e.preventDefault();
        errorMsg.textContent = "ID is required!";
        return;
    }*/

    // Contact
    if(!contact){
        e.preventDefault();
        errorMsg.textContent = "Contact is required!";
        return;
    }
    if(!/^\d{9}$/.test(contact)){
        e.preventDefault();
        errorMsg.textContent = "Contact must be exactly 9 digits!";
        return;
    }

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
    if(!email){
        e.preventDefault();
        errorMsg.textContent = "Email is required!";
        return;
    }
    let emailPattern = /^[^ ]+@[^ ]+\.[a-z]{2,3}$/;
    if(!emailPattern.test(email)){
        e.preventDefault();
        errorMsg.textContent = "Invalid email format!";
        return;
    }

    // All validations passed → form submits
    document.getElementById('registration-form').submit();
});
</script>

</body>
</html>
    
