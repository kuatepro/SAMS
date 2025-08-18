<?php
include 'db.php';
session_start();
if (!isset($_SESSION['admin_id'])) {
    header('Location: admin-login.php');
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
        <a href="admin-logout.php" class="log"><span>Log out</span></a>
        
    </nav>
</aside>

<!-- Main Content -->
<main class="main-content">

    <!-- Topbar -->
    <header class="topbar">
        <h1>Admin Dashboard  </h1>
        <h2>Welcome, <?php echo $_SESSION['admin_name']; ?> 👑</h2>
        <div class="user-info">🛠 Admin</div>
    </header>

    <!-- Post School Info -->
    <section class="card">
        <h2>Post School Info</h2>
        <form id="postForm">
            <input type="text" id="infoTitle" placeholder="Title" required>
            <textarea id="infoContent" placeholder="Write school update..." rows="4" required></textarea>
            <button type="submit" class="submit-btn">Post Info</button>
        </form>
        <h3>Latest Announcements:</h3>
        <ul id="infoList"></ul>
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
            <tbody>
                <tr>
                    <td>John Doe</td>
                    <td>Michael Doe</td>
                    <td>+237 670 000 000</td>
                    <td><button onclick="removeRow(this)">Remove</button></td>
                </tr>
                <tr>
                    <td>Jane Smith</td>
                    <td>Sarah Smith</td>
                    <td>+237 671 111 111</td>
                    <td><button onclick="removeRow(this)">Remove</button></td>
                </tr>
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
    document.getElementById("postForm").addEventListener("submit", function(e) {
        e.preventDefault();
        let title = document.getElementById("infoTitle").value;
        let content = document.getElementById("infoContent").value;
        let listItem = document.createElement("li");
        listItem.innerHTML = `<strong>${title}</strong>: ${content}`;
        document.getElementById("infoList").prepend(listItem);
        this.reset();
    });
</script>
 <footer>
        <p>Copyright &copy; <span class="logo">SAMS</span>,2025</p>
</footer>

    
</body>
</html>