<?php
include 'db.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Contact Us - Parents Dashboard</title>
<link rel="stylesheet" href="contact.css">
 <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

</head>
<body>
  <!-- Sidebar
  <nav class="sidebar">
    <img src="../img/logo.jpg" alt="logo" class="logo">
    <a href="Parentb.html">Dashboard</a>
    <a href="#">Contact Us</a>
    <a href="studentinfo.html">My Child</a>
    <a href="#">Log Out</a>
  </nav> -->
      <!-- Sidebar -->
    <aside class="sidebar">
        <img src="logo.jpg" alt="logo" class="logo">
        <nav>
            <a href="Parentb.php">Dashboard</a>
          </nav>
    </aside>

  
<main class="main">
    <!--<header> Contact Us</header>
    <p>Hey there , any problem with a students mark ? Reach us by filling the form below</p>-->
     
  
 


  <!-- Contact Form -->
  <div class="contact-form">
    <h3>Send us a message</h3>
    <form id="contactForm">
      <label for="fullName">Fullname*</label>
      <input type="text" id="fullName" name="fullname" placeholder="Your full name" >
       <p class="error" id="fullnameError"></p>

      <label for="email">Email*</label>
      <input type="email" id="email" name="email" placeholder="you@example.com" >
       <p class="error" id="emailError"></p>

      <label for="phone">Phone Number*</label>
      <input type="tel" id="phone"name="contact" placeholder="Your contact ">
       <p class="error" id="ContactError"></p>

      <label for="student">Student Name or Matricule*</label>
      <input type="text" id="student" name="info" placeholder="Child info" >
       <p class="error" id="Child-infoError"></p>

  

      <label for="message">Message*</label>
      <textarea id="message" rows="5" placeholder="Type your message here" ></textarea>
       <p class="error" id="MessageError"></p>

      <button type="submit" >Send Message</button>
    </form>
   
  </div>

  <!-- Contact Info -->
  <div class="contact-info">
    <div>
       <i class="fa-solid fa-phone" id="phone-icon"></i>
      <span>Phone:</span> +237699504895
    </div>
   
    <div>
      <i class="fa-solid fa-envelope" id="email-icon"></i>
      <span>Email:</span> SAMS@gmail.com
    </div>
    
    <div><span>Address:</span> TKC Behind College Flemming, Yaounde, Cameroon .</div>
    <div><span>Office Hours:</span> Mon-Fri, 8:00 AM - 4:00 PM</div>
  </div>
</main>
  <footer>
        <p>Copyright &copy; <span class="logo">SAMS</span>,2025</p>
    </footer>

<script>
/*  const contactForm = document.getElementById("contactForm");
  const confirmation = document.getElementById("confirmation");

  contactForm.addEventListener("submit", function(e){
    e.preventDefault(); // prevent actual submission for now
    // Here you would normally send data to backend via AJAX
    confirmation.style.display = "block";
    contactForm.reset();
  });*/

   document.getElementById("contact-form").addEventListener("submit", function(e){
           // e.preventDefault();
            const fullname = document.getElementById("fullname").value.trim();/* trim is to remove blank space*/ 
            
            const info = document.getElementById("info").value.trim();
       
            const email = document.getElementById("email").value.trim();
       
            const contact = document.getElementById("contact").value.trim();

                   let emptyfields = [];

                if ( fullname === ""){
                    emptyfields.push("fullname");
                } console.log("Check this out");

                if ( Fullname === ""){
                    emptyfields.push("Fullname");
                }

                if ( password === ""){
                    emptyfields.push("password");
                }

                 if ( email === ""){
                    emptyfields.push("email");
                }

                 if ( telephone === ""){
                    emptyfields.push("telephone");
                 }

                emptyfields.forEach(element => {
                    let errorTag = element+"Error";
                    document.getElementById(errorTag).textContent = "Empty field ";

                });

                if(emptyfields.length > 0){
                    
                    //showSuccessMessage("✅ Great Form submited successfully !");
                } 
        });
</script>
 
</body>
</html>
