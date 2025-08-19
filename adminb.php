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
       
        <a href="#">Parents</a>
        <a href="#">Teachers</a>
        <a href="#">Students</a>
        <a href="admin-logout.php" id="less" onclick="return confirmLogout()" ><span>Log out</span></a>
        
    </nav>
</aside>

<!-- Main Content -->
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
        <div class="user-info">🛠 Admin</div>
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
                    <th>Student</th>
                    <th>Contact</th>
                    <th>Action</th>
                </tr>
            </thead>
            <?php
            $parents = $conn->query("SELECT  p.parent_id, p.fullname, p.phone, s.fullname AS student
            FROM parents p 
            LEFT JOIN students s ON p.parent_id = s.parent_id");
            if ($parents && $parents->num_rows > 0) {
                while ($row = $parents->fetch_assoc()) {
                    echo "<tr>
                     <td>{$row['fullname']}</td>;
                     <td>{$row['student']}</td>;
                     <td>{$row['phone']}</td>;
                     <td><button onclick='removeRow(this)'>Remove</button></td>
                    </tr>";
                }
            } else {
                echo "<tr><td colspan='4'>No parents found.</td></tr>";
            }
            
           
            ?>
           <!-- <tbody>
                <tr>
                    <td>Marc</td>
                    <td>Michael Doe</td>
                    <td>+237 670 000 000</td>
                    <td><button onclick="removeRow(this)">Remove</button></td>
                </tr>
                <tr>
                    <td>Emma</td>
                    <td>Sarah Smith</td>
                    <td>+237 671 111 111</td>
                    <td><button onclick="removeRow(this)">Remove</button></td>
                </tr>-->
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
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Mr. Brown</td>
                    <td>Math</td>
                    <td>+237 672 222 222</td>
                    <td><button onclick="removeRow(this)">Remove</button></td>
                </tr>
                <tr>
                    <td>Mrs. Johnson</td>
                    <td>Science</td>
                    <td>+237 673 333 333</td>
                    <td><button onclick="removeRow(this)">Remove</button></td>
                </tr>
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
                    <td>Michael Doe</td>
                    <td>Form 3A</td>
                    <td>95%</td>
                </tr>
                <tr>
                    <td>Sarah Smith</td>
                    <td>Form 2B</td>
                    <td>90%</td>
                </tr>
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

    // Post School Info
  /*  document.getElementById("postForm").addEventListener("submit", function(e) {
        e.preventDefault();
        let title = document.getElementById("infoTitle").value;
        let content = document.getElementById("infoContent").value;
        let listItem = document.createElement("li");
        listItem.innerHTML = `<strong>${title}</strong>: ${content}`;
        document.getElementById("infoList").prepend(listItem);
        this.reset();
    });*/

       
          function confirmLogout() {
      return confirm("Are you sure you want to logout from your account?");
    }
    
</script>


    
</body>
</html>