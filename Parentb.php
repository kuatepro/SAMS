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
    <title>Document</title>
    <link rel="stylesheet" href="Parentb.css">
</head>
<body>
    <!-- Sidebar -->
    <aside class="sidebar">
        <img src="logo.jpg" alt="logo" class="logo">
        <nav>
            <a href="Parentb.php">Dashboard</a>
            <a href="studentinfo.php">My Child</a>
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
    <div class="summary">
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
    </div>

        <!-- Child Selector 
        <section class="card">
            <div class="search-container">
                <div class="child-inputs-column">
                    <input type="text" placeholder="Enter child name" id="child-name" class="child-input">
                    <input type="text" placeholder="Enter child Matricule" id="child-matricule" class="child-input">
                </div>
                <button class="search-btn">Search</button>
            </div>
        </section>-->

        <!-- Attendance Stats
        <section class="stats">
            <div class="stat-card">Present Days: 45% Present</div>
            <div class="stat-card">Absent Days: 5% Present</div>
            <div class="stat-card">Attendance Percentage: 90%</div>
        </section> -->

        <!-- Attendance Table -->
        <section class="card">
            <h2> Recent Attendance Records </h2>
            <table>
                <thead>
                    <tr>
                        <th>Student Names</th>
                        <th>Matricule</th>
                        <th>Date</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                    
                        <td>John</td>
                        <td>SAMS201</td>
                        <td>2025-08-12</td>
                        <td class="present">Present</td>
                    </tr>
                    <tr>
                        <td>Wilbrown</td>
                        <td>SAMS202</td>
                        <td>2025-08-11</td>
                        <td class="absent">Absent</td>
                    </tr>
                    <tr> 
                        <td>Emmanuel</td>
                        <td>SAMS203</td>
                        <td>2025-08-10</td>
                        <td class="present">Present</td>
                    </tr>
                     <tr> 
                        <td>Anne Marie</td>
                        <td>SAMS204</td>
                        <td>2025-08-9</td>
                        <td class="present">Present</td>
                    </tr>
                     <tr> 
                        <td>Johnson</td>
                        <td>SAMS205</td>
                        <td>2025-08-8</td>
                        <td class="absent">Absent</td>
                    </tr>
                     <tr> 
                        <td>Greghor</td>
                        <td>SAMS206</td>
                        <td>2025-08-7</td>
                        <td class="present">Present</td>
                    </tr>
                     <tr> 
                        <td>Rayan</td>
                        <td>SAMS207</td>
                        <td>2025-08-6</td>
                        <td class="absent">Absent</td>
                    </tr>
                     <tr> 
                        <td>Wilson</td>
                        <td>SAMS208</td>
                        <td>2025-08-5</td>
                        <td class="absent">Absent</td>
                    </tr>
                </tbody>
            </table>
        </section>
    </main>
     <footer>
        <p>Copyright &copy;SAMS ,2025</p>
</footer>
    <script>
          function confirmLogout() {
      return confirm("Are you sure you want to logout from your account?");
    }
    </script>

 
</body>
</html>






