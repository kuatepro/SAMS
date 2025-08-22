<?php session_start(); ?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>SAMS – Welcome</title>
  <link rel="stylesheet" href="assets/style.css">
</head>
<body>
<div class="auth-shell">
  <aside class="left">
    <div>
      <div class="logo">
        <img src="assets/logo.svg" alt="SAMS logo">
        <div class="brand">SAMS</div>
      </div>
      <h1>Welcome to SAMS</h1>
      <p>Stay connected, stay informed. SAMS keeps schools, teachers and families aligned in one place.</p>
    </div>
    <footer>© SAMS, 2025</footer>
  </aside>
  <main class="right">
    <div class="form card center">
      <h2>What is your role?</h2>
      <p class="small">Click below to continue 👇</p>
      <div class="role-grid">
        <a href="register.php?role=admin">Admin</a>
        <a href="register.php?role=teacher">Teacher</a>
        <a href="register.php?role=parent">Parent</a>
      </div>
    </div>
  </main>
</div>
</body>
</html>
