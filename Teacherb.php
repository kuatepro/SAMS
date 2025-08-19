<?php
include 'db.php';
session_start();
if (!isset($_SESSION['teacher_id'])) {
  header('Location: teacher-login.php');
  exit();
}

// Fetch students and attendance for this teacher
$teacher_id = $_SESSION['teacher_id'];
$students = [];
$attendance = [];

// Example: get students assigned to this teacher (adjust query as needed)
$sql = "SELECT s.id, s.full_name, s.matricule, s.class FROM students s WHERE s.teacher_id = ?";
$stmt = $conn->prepare($sql);
if ($stmt) {
  $stmt->bind_param("i", $teacher_id);
  $stmt->execute();
  $result = $stmt->get_result();
  while ($row = $result->fetch_assoc()) {
    $students[] = $row;
  }
  $stmt->close();
}

// Example: get recent attendance for these students (adjust query as needed)
if (!empty($students)) {
  $student_ids = array_column($students, 'id');
  $in = str_repeat('?,', count($student_ids) - 1) . '?';
  $sql2 = "SELECT a.student_id, a.date, a.status FROM attendance a WHERE a.student_id IN ($in) ORDER BY a.date DESC LIMIT 30";
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
    <title>Document</title>
    <link rel="stylesheet" href="Teacherb.css">
</head>
<!--<script>
  function logoutConfirm() {
    swal.fire({
      title: 'Are you sure?' ,
      text: "You will be logged out from your account.",
      icon
    })
  }
</script>-->
<body>
  <nav class="sidebar">
     <img src="logo.jpg" alt="logo">
    <a href="Teacherb.php">Dashboard</a>
    <a href="contact.php">Contact Us</a>

    
    <a href="teacher-logout.php" onclick="return confirmLogout()"       class="log"><span>Log out</span></a>
  </nav>
  

  <main class="main">
   <header>
  <h1>Welcome, <?php echo isset($_SESSION['teacher_name']) ? htmlspecialchars($_SESSION['teacher_name']) : 'Teacher'; ?></h1>
      <div id="date"></div>
    </header>
    <h3>Click on a class below to take attendance or to view attendance</h3>
      
    <div class="classes">
      <a href="calendar1.php" class="form-1">Form <span>1 </span></a>
      <a href="calendar1.php" class="form-1">Form <span>2 </span></a> 
      <a href="" class="form-1">Form <span>3 </span></a> 
      <a href="" class="form-1">Form <span>4</span></a> 
      <a href="" class="form-1" id="forms">Form <span>5</span></a> 
      <a href="" class="form-1" id="forms">Lower sixth Arts</a> 
      <a href="" class="form-1" id="forms">Lower sixth Science</a> 
      <a href="" class="form-1" id="forms">Upper sixth Arts</a>
      <a href="" class="form-1" id="forms">Upper sixth Science</a>  
    </div>
     <div id="notif" style="background: white;padding: 10px;border-radius: 8px;margin-bottom: 15px;">
            <h3>  School notifications</h3>
            
            <ul style="list-style: none;padding: 0;margin: 0;">
              <?php
              $sql = "SELECT * FROM posts ORDER BY post_date DESC"; // shows latest info first
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
                <!--notifications displays here-->
            </ul>
        </div>

          <!-- Summary Cards -->
   <!-- <div class="summary">
        <div class="card">
            <h3>Total Students</h3>
            <p id="totalStudents">3000 students</p>
        </div>
        <div class="card">
            <h3>Percentage present this Week</h3>
            <p id="presentThisWeek">67%</p>
        </div>
         <div class="card">
            <h3>Percentage absent this Week</h3>
            <p id="presentThisWeek">33%</p>
        </div>
    </div>-->

   <!--  <section class="summary">
      <div class="card">
        <h3>Total Students</h3>
        <p id="total-students">30</p>
      </div>
      <div class="card">
        <h3>Present Today</h3>
        <p id="present-today">27</p>
      </div>
      <div class="card">
        <h3>Absent Today</h3>
        <p id="absent-today">3</p>
      </div>
    </section>

    <section>
      <h2>Recent Attendance</h2>
      <table>
        <thead>
          <tr>
            <th>Student Name</th>
            <th>Date</th>
            <th>Status</th>
          </tr>
        </thead>
        <tbody id="attendance-table-body">
          <!-- Rows inserted by JavaScript 
        </tbody>
      </table>
    </section>-->
  <h2>Recent Students Attendance</h2>
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
        <td><?php echo htmlspecialchars($student['full_name']); ?></td>
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

    // Sample attendance data (in real app this comes from backend)
    const attendanceRecords = [
      { name: "Samuel Johnson", date: "2025-08-12", status: "Present" },
      { name: "Mary Smith", date: "2025-08-12", status: "Absent" },
      { name: "Alex Kim", date: "2025-08-12", status: "Present" },
      { name: "Fatima Ali", date: "2025-08-11", status: "Present" },
      { name: "John Doe", date: "2025-08-11", status: "Absent" }
    ];

    const tbody = document.getElementById('attendance-table-body');
    attendanceRecords.forEach(record => {
      const tr = document.createElement('tr');
      tr.innerHTML = `
        <td>${record.name}</td>
        <td>${record.date}</td>
        <td style="color:${record.status === 'Present' ? 'green' : 'red'}">${record.status}</td>
      `;
      tbody.appendChild(tr);
    });

    function confirmLogout() {
      return confirm("Are you sure you want to logout from your account?")
    }
  </script>

  
</body>
</html>