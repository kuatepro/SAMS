<?php
include 'db.php';
session_start();
if (!isset($_SESSION['parent_id'])) {
    header('Location: parent-login.php');
    exit();
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Parent Dashboard</title>
    <link rel="stylesheet" href="Parentb.css">
</head>
<body>
    <!-- Sidebar -->
    <aside class="sidebar">
        <img src="logo.jpg" alt="logo" class="logo">
        <nav>
            <a href="Parentb.php">Dashboard</a>
           
            <a href="contact.php">Contact Us</a>
            
            <a href="parent-logout.php" onclick="return confirmLogout()"  class="log"><span>Log Out</span> </a>
          

        </nav>
    </aside>

    <!-- Main Content -->
    <main class="main-content">
        <!-- Topbar -->
        <header class="topbar">
            <h1>Parent Dashboard</h1>
             <h2>Welcome, <?php echo $_SESSION['parent_name']; ?> 😊</h2>
           
        </header>
        <div id="notifs" style="background: white;padding: 10px;border-radius: 8px;margin-bottom: 15px;">
            <h3>  School Notifications</h3>
            <ul  style="list-style: none;padding: 0;margin: 0;">
                <!--notifications displays here-->
                <?php
                $sql = "SELECT * FROM posts ORDER BY post_date DESC "; // shows lates info first
                $result = $conn->query($sql);
                if ($result && $result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<li style='margin-bottom: 10px; padding: 8px; background:#f9f9f9; border-left:4px solid #007BFF; border-radius: 4px;'>";
                        echo "<strong>".$row['title']."</strong>:".$row['content'];
                        echo "<br><small>Posted by: ". $row['posted_by']." on ".$row['post_date']."</small>";
                        echo "</li>";
                    }
                } else {
                    echo "<li>No notifications available.</li>";
                }
                ?>
            </ul>
        </div>
          <!-- Summary Cards -->
   


        <?php
// Get all children for this parent
$parent_id = $_SESSION['parent_id'];
$children = [];
$sql = "SELECT id, fullname FROM students WHERE parent_id = ?";
$stmt = $conn->prepare($sql);
if ($stmt) {
    $stmt->bind_param("i", $parent_id);
    $stmt->execute();
    $res = $stmt->get_result();
    while ($row = $res->fetch_assoc()) {
        $children[] = $row;
    }
    $stmt->close();
} else {
    // Debug error if query fails
    echo "<p style='color:red;'>Error: " . $conn->error . "</p>";
}
?>

<div>
  <h2>Attendance Summary</h2>
  <div style="margin-bottom:10px;">
    <input type="text" id="searchName" placeholder="Enter student name" style="padding:5px;">
    <input type="text" id="searchMatricule" placeholder="Enter student matricule" style="padding:5px;">
    <button onclick="searchAttendanceSummary()" style="padding:5px 10px;">Search</button>
    <button onclick="loadAttendanceSummary(defaultClassId)" style="padding:5px 10px;">Show All</button>
  </div>
  <table id="attendanceSummaryTable" border="1">
    <thead>
      <tr>
        <th>Student ID</th>
        <th>Name</th>
        <th>Date</th>
        <th>Present</th>
        <th>Absent</th>
        <th>Late</th>
      </tr>
    </thead>
    <tbody></tbody>
  </table>
</div>

</main>
 <footer>

        <p>Copyright &copy; SAMS ,2025</p>
</footer>


<!-- JavaScript -->
<script>
    // Remove row from table
    function removeRow(btn) {
        btn.closest("tr").remove();
    }

    // Search Parent
    function searchParent() {
        let input = document.getElementById("searchParent").value.toLowerCase();
        let rows = document.querySelectorAll("#parentTable tbody tr");
        rows.forEach(row => {
            let name = row.cells[0].textContent.toLowerCase();
            row.style.display = name.includes(input) ? "" : "none";
        });
    }

    const defaultClassId = <?php echo json_encode($class_id ?? ''); ?>;

function loadAttendanceSummary(classId) {
  fetch('get_attendance_summary.php?class_id=' + encodeURIComponent(classId))
    .then(res => res.json())
    .then(data => {
      renderAttendanceSummary(data.summary || []);
    });
}

function searchAttendanceSummary() {
  const name = document.getElementById('searchName').value.trim().toLowerCase();
  const matricule = document.getElementById('searchMatricule').value.trim().toLowerCase();
  if (!name && !matricule) {
    alert('Please enter student name or matricule.');
    return;
  }
  fetch('get_students.php?class_id=' + encodeURIComponent(defaultClassId))
    .then(res => res.json())
    .then(data => {
      const students = data.students || [];
      // Partial and case-insensitive match for fullname and matricule
      const student = students.find(stu =>
        (name ? (stu.fullname && stu.fullname.toLowerCase().includes(name)) : true) &&
        (matricule ? (stu.matricule && stu.matricule.toLowerCase().includes(matricule)) : true)
      );
      if (!student) {
        renderAttendanceSummary([]);
        alert('No student found with that name and matricule.');
        return;
      }
      fetch('get_attendance_summary.php?student_id=' + encodeURIComponent(student.id))
        .then(res => res.json())
        .then(data => {
          renderAttendanceSummary(data.summary || []);
        });
    });
}

function renderAttendanceSummary(summary) {
  const tbody = document.querySelector('#attendanceSummaryTable tbody');
  tbody.innerHTML = '';
  if (summary.length === 0) {
    tbody.innerHTML = '<tr><td colspan="6">No attendance summary found.</td></tr>';
    return;
  }
  summary.forEach(row => {
    tbody.innerHTML += `<tr>
      <td>${row.student_id}</td>
      <td>${row.student_name}</td>
      <td>${row.date_taken ? row.date_taken : ''}</td>
      <td>${row.present}</td>
      <td>${row.absent}</td>
      <td>${row.late}</td>
    </tr>`;
  });
}

// Initial load: show all
loadAttendanceSummary(defaultClassId);

          function confirmLogout() {
      return confirm("Are you sure you want to logout from your account?");
    }
    
</script>



</body>
</html>