<?php
session_start();
$role = isset($_GET['role']) ? strtolower($_GET['role']) : 'admin';
if (!in_array($role, ['admin','teacher','parent'])) $role = 'admin';
?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>SAMS – Register</title>
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
      <p>With SAMS you can upload attendance for parents to view.</p>
      <a class="cta-btn" href="login.php?role=<?php echo $role; ?>">LOGIN</a>
    </div>
    <footer>© SAMS, 2025</footer>
  </aside>
  <main class="right">
    <div class="form card">
      <h2>You Register as a <?php echo ucfirst($role); ?></h2>
      <form method="post" action="process_register.php">
        <input type="hidden" name="role" value="<?php echo htmlspecialchars($role); ?>">
        <input required type="text" name="full_name" placeholder="Full Name">
        <input required type="email" name="email" placeholder="Email">
        <input required type="text" name="id_number" placeholder="ID">
        <input required type="text" name="contact" placeholder="Contact">
        <input required type="password" name="password" placeholder="Password">
        <label class="small"><input type="checkbox" name="remember"> Remember me</label>
        <div class="topbar">
          <a class="link" href="login.php?role=<?php echo $role; ?>">Already have an account? Login</a>
        </div>
        <button type="submit">REGISTER</button>
      </form>
    </div>
  </main>
</div>
</body>
</html>
