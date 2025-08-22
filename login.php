<?php
session_start();
$role = isset($_GET['role']) ? strtolower($_GET['role']) : 'admin';
if (!in_array($role, ['admin','teacher','parent'])) $role = 'admin';
?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>SAMS – Login</title>
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
      <h1>Welcome back</h1>
      <p>Access your personalized SAMS dashboard.</p>
      <a class="cta-btn" href="register.php?role=<?php echo $role; ?>">CREATE ACCOUNT</a>
    </div>
    <footer>© SAMS, 2025</footer>
  </aside>
  <main class="right">
    <div class="form card">
      <h2>Login as <?php echo ucfirst($role); ?></h2>
      <form method="post" action="process_login.php">
        <input type="hidden" name="role" value="<?php echo htmlspecialchars($role); ?>">
        <input required type="email" name="email" placeholder="Email">
        <input required type="password" name="password" placeholder="Password">
        <div class="topbar">
          <a class="link" href="register.php?role=<?php echo $role; ?>">Need an account?</a>
        </div>
        <button type="submit">LOGIN</button>
      </form>
    </div>
  </main>
</div>
</body>
</html>
