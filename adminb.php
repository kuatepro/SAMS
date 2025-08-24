<?php
include 'db.php';
session_start();

if (!isset($_SESSION['admin_id'])) {
    header('Location: admin-login.php');
    exit();
}
if(isset($_POST['submit_post'])) {
    $title = $_POST['infoTitle'];
    $content = $_POST['infoContent'];

    $sql = "INSERT INTO posts (title, content, posted_by) VALUES (?, ?, 'admin')";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $title, $content);
    $stmt->execute();
    $stmt->close();


   
    header("Location: adminb.php");
    exit();

    
    
}
if (isset($_POST['delete_id']) && isset($_POST['delete_post'])) {
    $delete_id = $_POST['delete_id'];

    $stmt = $conn->prepare("DELETE FROM posts WHERE post_id = ?");
    if (!$stmt) {
        die("SQL error: " . $conn->error);
    }
    $stmt->bind_param("i", $delete_id);
    $stmt->execute();
   // $sql = "DELETE FROM posts WHERE id = ?";
    //$stmt = $conn->prepare($sql);
    //$stmt->bind_param("i", $postId);
  //  if ($stmt->affected_rows > 0){
    //    echo "Post Deleted successfully!";
    //}else {
     //   echo "Error deleting post: ";
    //}
   

    $stmt->close();
    header("Location: adminb.php");
    exit();
}

// Handle student form submission
if (isset($_POST['add_student'])) {
    $fullname = $_POST['student_fullname'];
    $matricule = $_POST['student_matricule'];
    $class = $_POST['student_class'];
    // You may want to add parent_id if needed
    $stmt = $conn->prepare("INSERT INTO students (fullname, matricule, class_id) VALUES (?, ?, ?)");
    $stmt->bind_param("ssi", $fullname, $matricule, $class);
    $stmt->execute();
    $stmt->close();
    $_SESSION['message'] = "Student added successfully!";
    header("Location: adminb.php?show=students");
    exit();
}

// Handle parent deletion
if (isset($_POST['delete_parent_id'])) {
    $delete_id = $_POST['delete_parent_id'];
    $stmt = $conn->prepare("DELETE FROM parents WHERE id = ?");
    $stmt->bind_param("i", $delete_id);
    $stmt->execute();
    $stmt->close();
    $_SESSION['message'] = "Parent deleted successfully!";
    header("Location: adminb.php?show=parents");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin Dashboard</title>
<link rel="stylesheet" href="adminb.css">
</head>
<body>

<!-- Sidebar -->
<aside class="sidebar">
    <img src="logo.jpg" alt="logo">
    <nav>
        <a href="adminb.php">Dashboard</a>
        <a href="#" onclick="showSection('parents')">Parents</a>
        <a href="add_student.php">Students</a>
        <a href="#" onclick="showSection('teachers')">Teachers</a>
        <a href="admin-logout.php" id="less" onclick="return confirmLogout()" ><span>Log out</span></a>
    </nav>
</aside>
<main class="main-content">

    <!-- Topbar -->
    <header class="topbar">
        <?php
        if (isset($_SESSION['message'])) {
            echo "<p style='color:green;'>" . $_SESSION['message'] . "</p>";
            unset($_SESSION['message']);
        }
        ?>
        <h1>Admin Dashboard  </h1>
        <h2>Welcome, <?php echo $_SESSION['admin_name']; ?> 👑</h2>
        <div class="user-info">Admin</div>
    </header>

    <!-- Post School Info -->
    <section class="card">
        <h2>Post School Info</h2>
        <form  method="POST">
            <input type="text" name="infoTitle" id="infoTitle" placeholder="Title" required>
            <textarea id="infoContent" name="infoContent" placeholder="Write school update..." rows="4" required></textarea>
            <button type="submit" name="submit_post" class="submit-btn">Post Info</button>
        </form>
        <h3>Latest Announcements:</h3>
        <ul  id="infoList"  style="list-style: none; padding: 0; margin: 0;">
            <?php
            $sql = "SELECT * FROM posts ORDER BY post_date DESC";
            $result = $conn->query($sql);

            if ($result && $result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<li style='margin-bottom: 10px; padding: 8px; background:#f9f9f9; border-left:4px solid #007BFF; border-radius: 4px;'>";
                    echo "<strong>" . $row['title'] . "</strong>: " . $row['content'];
                    echo "<br><small>Posted by: ".$row['posted_by']." on ".$row['post_date']."</small>";
                    echo "<form method='POST' style='margin-top: 5px;'>";
                    echo "<input type='hidden' name='delete_id' value='".$row['post_id']."'>";
                    echo "<button type='submit' name='delete_post' style='background:#d9534f;color:white;border:none;padding:3px 8px;border-radius: 4px;cursor:pointer;'>Delete</button>";
                    echo "</form>"; 
                    echo "</li>";
                }
            } else {
                echo "<li>No announcements available.</li>";
            }
            ?>
            
        </ul>
        
    </section>

    <!-- Parents List -->
    <section class="card">
        <h2>Parents</h2>
        <div class="search-bar">
            <input type="text" id="searchParent" placeholder="Search parent...">
            <button onclick="searchParent()">Search</button>
        </div>
        <table id="parentTable">
            <thead>
                <tr>
                    <th>Parent Name</th>
                    <th>Contact</th>
                    <th>Action</th>
                   
                </tr>
            </thead>
            <?php
            $parents = $conn->query("SELECT  p.parent_id, p.fullname, p.phone 
            FROM parents p");
            if ($parents && $parents->num_rows > 0) {
                while ($row = $parents->fetch_assoc()) {
                    echo "<tr>
                     <td>".htmlspecialchars($row['fullname'])."</td>
                     <td>".htmlspecialchars($row['phone'])."</td>
                     <td><button onclick='removeRow(this)'>Remove</button></td>
                    </tr>";
                }
            } else {
                echo "<tr><td colspan='3'>No parents found.</td></tr>";
            }
            
           
            ?>
         
            </tbody>
        </table>
    </section>

    <!-- Teachers List -->
    <section class="card">
        <h2>Teachers</h2>
        <table>
            <thead>
                <tr>
                    <th>Teacher Name</th>
                    <th>Subject</th>
                    <th>Contact</th>
                    
                </tr>
            </thead>
            <tbody>
<?php


// Example for adminb.php or parentb.php
$sql = "SELECT a.student_id, s.fullname, a.date, a.status
        FROM attendance a
        JOIN students s ON a.student_id = s.id
        ORDER BY a.date DESC LIMIT 30";
$result1 = $conn->query($sql);
if ($result1 && $result1->num_rows > 0) {
    while ($row = $result1->fetch_assoc()) {
        echo "<tr>
            <td>{$row['fullname']}</td>
            <td>{$row['date']}</td>
            <td>{$row['status']}</td>
        </tr>";
    }
}

// Now run the teachers query and use a different result variable
$sql = "SELECT fullname, subject, contact FROM teachers";
$result2 = $conn->query($sql);

if ($result2 && $result2->num_rows > 0) {
    while($row = $result2->fetch_assoc()) {
        echo "<tr>";
        echo "<td>".htmlspecialchars($row['fullname'])."</td>";
        echo "<td>".htmlspecialchars($row['subject'])."</td>";
        echo "<td>".htmlspecialchars($row['contact'])."</td>";
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='3'>No teachers found.</td></tr>";
}
?>

    </tbody>
        </table>
    </section>

    <!-- Students List -->
    <section class="card">
        <h2>Students</h2>
        <table>
            <thead>
                <tr>
                    <th>Student Name</th>
                    <th>Class</th>
                    <th>Attendance</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Emma</td>
                    <td>form 5</td>
                    <td>95%</td>
                </tr>
                <tr>
                    <td>Wills</td>
                    <td>form 2</td>
                    <td>90%</td>
                </tr>
                  <tr>
                    <td>Wilbrown</td>
                    <td>upper sixth</td>
                    <td>90%</td>
                </tr>
                  <tr>
                    <td>Aziz</td>
                    <td>upper sixth</td>
                    <td>90%</td>
                </tr>
            </tbody>
        </table>
    </section>

    <!-- Attendance Summary Search -->
<div>
  <h2>Attendance Summary</h2>
  <div style="margin-bottom:10px;">
    <input type="text" id="searchName" placeholder="Enter student name" style="padding:5px;">
    <input type="text" id="searchId" placeholder="Enter student ID" style="padding:5px;">
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

    <!-- Students Form Section -->
    <section class="card" id="studentsFormSection" style="display:none;">
        <h2>Add Student</h2>
        <form method="POST">
            <label>Full Name</label>
            <input type="text" name="student_fullname" required>
            <label>Matricule</label>
            <input type="text" name="student_matricule" required>
            <label>Class</label>
            <input type="number" name="student_class" required>
            <button type="submit" name="add_student" class="submit-btn">Save Student</button>
        </form>
    </section>

    <!-- Parents List Section (only visible when 'Parents' is clicked) -->
    <section class="card" id="parentsSection" style="display:none;">
        <h2>All Parents</h2>
        <table>
            <thead>
                <tr>
                    <th>Parent Name</th>
                    <th>Contact</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
            <?php
            // Use id and contact instead of parent_id and phone
            $parents = $conn->query("SELECT id, fullname, contact FROM parents");
            if (!$parents) {
                echo "<tr><td colspan='3'>Error: " . $conn->error . "</td></tr>";
            } else if ($parents->num_rows > 0) {
                while ($row = $parents->fetch_assoc()) {
                    echo "<tr>
                        <td>".htmlspecialchars($row['fullname'])."</td>
                        <td>".htmlspecialchars($row['contact'])."</td>
                        <td>
                            <form method='POST' style='display:inline;' onsubmit=\"return confirm('Delete this parent?');\">
                                <input type='hidden' name='delete_parent_id' value='".$row['id']."'>
                                <button type='submit' style='background:#d9534f;color:white;border:none;padding:3px 8px;border-radius:4px;cursor:pointer;'>Delete</button>
                            </form>
                        </td>
                    </tr>";
                }
            } else {
                echo "<tr><td colspan='3'>No parents found.</td></tr>";
            }
            ?>
            </tbody>
        </table>
    </section>

    <!-- Teachers List Section (only visible when 'Teachers' is clicked) -->
    <section class="card" id="teachersSection" style="display:none;">
        <h2>All Teachers</h2>
        <table>
            <thead>
                <tr>
                    <th>Teacher ID</th>
                    <th>Full Name</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
            <?php
            // Handle teacher deletion
            if (isset($_POST['delete_teacher_id'])) {
                $delete_id = $_POST['delete_teacher_id'];
                $stmt = $conn->prepare("DELETE FROM teachers WHERE teacher_id = ?");
                $stmt->bind_param("i", $delete_id);
                $stmt->execute();
                $stmt->close();
                $_SESSION['message'] = "Teacher deleted successfully!";
                header("Location: adminb.php?show=teachers");
                exit();
            }
            $teachers = $conn->query("SELECT teacher_id, fullname FROM teachers");
            if (!$teachers) {
                echo "<tr><td colspan='3'>Error: " . $conn->error . "</td></tr>";
            } else if ($teachers->num_rows > 0) {
                while ($row = $teachers->fetch_assoc()) {
                    echo "<tr>
                        <td>".htmlspecialchars($row['teacher_id'])."</td>
                        <td>".htmlspecialchars($row['fullname'])."</td>
                        <td>
                            <form method='POST' style='display:inline;' onsubmit=\"return confirm('Delete this teacher?');\">
                                <input type='hidden' name='delete_teacher_id' value='".$row['teacher_id']."'>
                                <button type='submit' style='background:#d9534f;color:white;border:none;padding:3px 8px;border-radius:4px;cursor:pointer;'>Delete</button>
                            </form>
                        </td>
                    </tr>";
                }
            } else {
                echo "<tr><td colspan='3'>No teachers found.</td></tr>";
            }
            ?>
            </tbody>
        </table>
    </section>

</main>
 <footer>
        <p>Copyright &copy; <span class="logo">SAMS</span>,2025</p>
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
  const id = document.getElementById('searchId').value.trim();
  if (!name && !id) {
    alert('Please enter student name or ID.');
    return;
  }
  fetch('get_students.php?class_id=' + encodeURIComponent(defaultClassId))
    .then(res => res.json())
    .then(data => {
      const students = data.students || [];
      // Partial and case-insensitive match for fullname and exact match for ID
      const student = students.find(stu =>
        (name ? (stu.fullname && stu.fullname.toLowerCase().includes(name)) : true) &&
        (id ? (stu.id && String(stu.id) === id) : true)
      );
      if (!student) {
        renderAttendanceSummary([]);
        alert('No student found with that name and ID.');
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

    function showSection(section) {
    document.querySelectorAll('.card').forEach(card => card.style.display = 'none');
    if (section === 'parents') {
        document.getElementById('parentsSection').style.display = 'block';
    }
    if (section === 'teachers') {
        document.getElementById('teachersSection').style.display = 'block';
    }
    // Add more sections as needed
}
    
</script>


    
</body>
</html>