<?php
include 'db.php';
session_start();
if (!isset($_SESSION['teacher_id'])) {
  header('Location: teacher-login.php');
  exit();
}

// Get class from URL, default to "Form 1" if not set
$class = isset($_GET['class']) ? $_GET['class'] : "Form 1";
$students = [];
$attendance = [];

// Fetch students for the selected class
$sql = "SELECT id, fullname, matricule, class FROM students WHERE class = ?";
$stmt = $conn->prepare($sql);
if ($stmt) {
  $stmt->bind_param("s", $class);
  $stmt->execute();
  $result = $stmt->get_result();
  while ($row = $result->fetch_assoc()) {
    $students[] = $row;
  }
  $stmt->close();
}

// Fetch recent attendance for these students
if (!empty($students)) {
  $student_ids = array_column($students, 'id');
  $in = str_repeat('?,', count($student_ids) - 1) . '?';
  $sql2 = "SELECT student_id, date, status FROM attendance WHERE student_id IN ($in) ORDER BY date DESC LIMIT 30";
  $stmt2 = $conn->prepare($sql2);
  if ($stmt2) {
    $types = str_repeat('i', count($student_ids));
    $stmt2->bind_param($types, ...$student_ids);
    $stmt2->execute();
    $result2 = $stmt2->get_result();
    while ($row2 = $result2->fetch_assoc()) {
      $attendance[] = $row2;
    }
    $stmt2->close();
  }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teacher Dashboard</title>
    <link rel="stylesheet" href="Teacherb.css">
</head>
<body>
  <nav class="sidebar">
     <img src="logo.jpg" alt="logo">
    <a href="Teacherb.php">Dashboard</a>
    <a href="teacher-logout.php" onclick="return confirmLogout()" class="log"><span>Log out</span></a>
  </nav>
  <main class="main">
   <header>
      <h1>Welcome, <?php echo isset($_SESSION['teacher_name']) ? htmlspecialchars($_SESSION['teacher_name']) : 'Teacher'; ?></h1>
      <div id="date"></div>
    </header>
    <h3>Click on a class below to take attendance or to view attendance</h3>
    <div class="classes">
      <a href="teacher_attendance.php?class=Form 1" class="form-1">Form <span>1 </span></a>
      <a href="Teacherb.php?class=Form 2" class="form-1">Form <span>2 </span></a> 
      <a href="Teacherb.php?class=Form 3" class="form-1">Form <span>3 </span></a> 
      <a href="Teacherb.php?class=Form 4" class="form-1">Form <span>4</span></a> 
      <a href="Teacherb.php?class=Form 5" class="form-1" id="forms">Form <span>5</span></a> 
      <a href="Teacherb.php?class=Lower sixth" class="form-1" id="forms">Lower <br>sixth </a> 
      <a href="Teacherb.php?class=Upper sixth" class="form-1" id="forms">Upper <br>sixth </a> 
    </div>
    <p></p>
    <div id="notif" style="background: white;padding: 10px;border-radius: 8px;margin-bottom: 15px;">
      <h3>School notifications</h3>
      <ul style="list-style: none;padding: 0;margin: 0;">
        <?php
        $sql = "SELECT * FROM posts ORDER BY post_date DESC";
        $result = $conn->query($sql);
        if ($result && $result->num_rows > 0) {
          while ($row = $result->fetch_assoc()) {
            echo "<li style='margin-bottom: 10px; padding: 8px; background:#f9f9f9; border-left:4px solid #007BFF; border-radius: 4px;'>";
            echo "<strong>" . htmlspecialchars($row['title']) . "</strong>: " . htmlspecialchars($row['content']);
            echo "<br><small>Posted by: " . htmlspecialchars($row['posted_by']) . " on " . htmlspecialchars($row['post_date']) . "</small>";
            echo "</li>";
          }
        } else {
          echo "<div class='notifCard'>No announcements yet.</div>";
        }
        ?>
      </ul>
    </div>
    <h2>Recent Students Attendance (<?php echo htmlspecialchars($class); ?>)</h2>
    <table id="attendanceTable">
      <thead>
        <tr>
          <th>Name</th>
          <th>Matricule</th>
          <th>Class</th>
          <th>Date</th>
          <th>Status</th>
        </tr>
      </thead>
      <tbody>
      <?php if (!empty($students) && !empty($attendance)): ?>
        <?php foreach ($attendance as $row):
          $student = array_filter($students, function($s) use ($row) { return $s['id'] == $row['student_id']; });
          $student = $student ? array_values($student)[0] : null;
          if (!$student) continue;
        ?>
        <tr>
          <td><?php echo htmlspecialchars($student['fullname']); ?></td>
          <td><?php echo htmlspecialchars($student['matricule']); ?></td>
          <td><?php echo htmlspecialchars($student['class']); ?></td>
          <td><?php echo htmlspecialchars($row['date']); ?></td>
          <td class="<?php echo strtolower($row['status']) == 'present' ? 'present' : 'absent'; ?>">
            <?php echo htmlspecialchars($row['status']); ?>
          </td>
        </tr>
        <?php endforeach; ?>
      <?php else: ?>
        <tr><td colspan="5">No attendance records found.</td></tr>
      <?php endif; ?>
      </tbody>
    </table>
  </main>
  <footer>
    <p>Copyright &copy SAMS , 2025</p>
  </footer>
  <script>
    // Show current date
    const dateEl = document.getElementById('date');
    const options = { year: 'numeric', month: 'long', day: 'numeric' };
    dateEl.textContent = new Date().toLocaleDateString(undefined, options);

    function confirmLogout() {
      return confirm("Are you sure you want to logout from your account?")
    }
  </script>
</body>
</html>