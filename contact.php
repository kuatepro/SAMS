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
  <header> Contact Us</header>

  <p>Hey there , any problem with a students mark ? Reach us by filling the form below</p>

  <!-- Contact Form -->
  <div class="contact-form">
    <h3>Send us a message</h3>
    <form id="contactForm">
      <label for="fullName">Full Name</label>
      <input type="text" id="fullName" placeholder="Your full name" required>

      <label for="email">Email Address</label>
      <input type="email" id="email" placeholder="you@example.com" required>

      <label for="phone">Phone Number</label>
      <input type="tel" id="phone" placeholder="Optional">

      <label for="student">Student Name or Matricule</label>
      <input type="text" id="student" placeholder="Student name or matricule" required>

  

      <label for="message">Message</label>
      <textarea id="message" rows="5" placeholder="Type your message here" required></textarea>

      <button type="submit" >Send Message</button>
    </form>
    <p id="confirmation" style="color:green; 
    display:none; margin-top:10px;">Your message has been sent!</p>
  </div>

  <!-- Contact Info -->
  <div class="contact-info">
    <div><span>Phone:</span> +237699504895</div>
    <div><span>Email:</span> SAMS@gmail.com</div>
    <div><span>Address:</span> TKC Behind College Flemming, Yaounde, Cameroon .</div>
    <div><span>Office Hours:</span> Mon-Fri, 8:00 AM - 4:00 PM</div>
  </div>
</main>

<script>
  const contactForm = document.getElementById("contactForm");
  const confirmation = document.getElementById("confirmation");

  contactForm.addEventListener("submit", function(e){
    e.preventDefault(); // prevent actual submission for now
    // Here you would normally send data to backend via AJAX
    confirmation.style.display = "block";
    contactForm.reset();
  });
</script>
 
</body>
</html>
