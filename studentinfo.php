<?php
session_start();
include 'db.php';

// Make sure parent is logged in
if (!isset($_SESSION['parent_id'])) {
    header("Location: parent-login.php");
    exit();
}

$parent_id = $_SESSION['parent_id'];
$search = "";

// Base query
$query = "SELECT * FROM students WHERE parent_id = ?";
$types = "i"; 
$params = [$parent_id];

if (isset($_GET['search']) && trim($_GET['search']) != "") {
    $search = trim($_GET['search']);
    $query .= " AND (full_name LIKE ? OR matricule LIKE ?)";
    $types .= "ss";
    $like = "%$search%";
    $params[] = $like;
    $params[] = $like;
}

$stmt = $conn->prepare($query);

// Build dynamic bind_param
$stmt->bind_param($types, ...$params);

$stmt->execute();
$result = $stmt->get_result();
$children = $result->fetch_all(MYSQLI_ASSOC);
?>


<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Student Attendance Dashboard</title>
<link rel="stylesheet" href="studentinfo.css">
</head>
<body>
<!-- Sidebar -->
<nav class="sidebar">
    <h2>Attendance</h2>
    <a href="Parentb.html">Dashboard</a>
    <a href="contact.html">Contact Us</a>
   
</nav>

<main class="main">
    <header> Student Attendance Dashboard</header>

    <!-- Summary Cards 
    <div class="summary">
        <div class="card">
            <h3>Total Students</h3>
            <p id="totalStudents">30</p>
        </div>
        <div class="card">
            <h3>Present This Week</h3>
            <p id="presentThisWeek">27</p>
        </div>
    </div>-->

     <!-- Child Selector
        <section class="card">
            <div class="search-container">
                <div class="child-inputs-column">
                    <input type="text" placeholder="Enter child name" id="child-name" class="child-input">
                    <input type="text" placeholder="Enter child Matricule" id="child-matricule" class="child-input">
                </div>
                <button class="search-btn">Search</button>
            </div>
        </section> -->
        

<form method="GET" action="">
    <input type="text" name="search" placeholder="Search by name or matricule" value="<?php echo htmlspecialchars($search); ?>">
    <button type="submit">Search</button>
</form>

<?php if (count($children) > 0): ?>
    <?php foreach ($children as $child): ?>
        <h2><?php echo htmlspecialchars($child['full_name']); ?> (Matricule: <?php echo htmlspecialchars($child['matricule']); ?>)</h2>
        <table border="1" cellpadding="5">
            <tr>
                <th>Date</th>
                <th>Status</th>
            </tr>
            <?php
            $stmt = $conn->prepare("SELECT * FROM attendance WHERE student_id = ? ORDER BY date DESC");
            $stmt->execute([$child['id']]);
            $attendance = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if (count($attendance) > 0):
                foreach ($attendance as $row):
            ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['date']); ?></td>
                    <td><?php echo htmlspecialchars($row['status']); ?></td>
                </tr>
            <?php
                endforeach;
            else:
            ?>
                <tr><td colspan="2">No attendance records found.</td></tr>
            <?php endif; ?>
        </table>
    <?php endforeach; ?>
<?php else: ?>
    <p>No children found.</p>
<?php endif; ?>

      

    <!-- Filters -->
    <div class="filters">
        <select id="classFilter">
            <option value="">Filter by Class</option>
            <option>Form 1</option>
            <option>Form 2</option>
            <option>Form 3</option>
            <option>Form 4</option>
            <option>Form 5</option>
            <option>Lower sixth</option>
            <option>Upper sixth</option>
        </select>

        <select id="monthFilter">
            <option value="">Filter by Month</option>
            <option>January</option>
            <option>February</option>
            <option>March</option>
            <option>April</option>
            <option>May</option>
            <option>June</option>
            <option>July</option>
            <option>August</option>
            <option>September</option>
            <option>October</option>
            <option>November</option>
            <option>December</option>
        </select>

        <select id="weekFilter" disabled>
            <option value="">Filter by Week</option>
            <option>Week 1</option>
            <option>Week 2</option>
            <option>Week 3</option>
            <option>Week 4</option>
        </select>

        <select id="sortFilter">
            <option value="">Sort Attendance</option>
            <option value="present">Most Present</option>
            <option value="absent">Most Absent</option>
        </select>

        <input type="text" id="searchBox" placeholder="Search Name or Matricule">
    </div>

    <!-- Recent Attendance Table -->
    <h2>Recent Attendance</h2>
    <table id="attendanceTable">
        <thead>
            <tr>
                <th>Name</th>
                <th>Matricule</th>
                <th>Class</th>
                <th>Month</th>
                <th>Week</th>
                <th>Attendance (%)</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>John Doe</td>
                <td>STU001</td>
                <td>Form 1</td>
                <td>January</td>
                <td>Week 1</td>
                <td class="present">90%</td>
            </tr>
            
            <tr>
                <td>Mary Jane</td>
                <td>STU002</td>
                <td>Form 2</td>
                <td>febuary</td>
                <td>Week 1</td>
                <td class="absent">60%</td>
            </tr>
            <tr>
                <td>Peter Parker</td>
                <td>STU003</td>
                <td>Form 3</td>
                <td>March</td>
                <td>Week 3</td>
                <td class="present">95%</td>
            </tr>
            <tr>
                <td>Lucy Smith</td>
                <td>STU004</td>
                <td>Form 1</td>
                <td>April</td>
                <td>Week 2</td>
                <td class="absent">50%</td>
            </tr>
             <tr>
                <td>Emmanuel</td>
                <td>STU005</td>
                <td>Form 5</td>
                <td>May</td>
                <td>Week 1</td>
                <td class="absent">40%</td>
            </tr>
             <tr>
                <td>Ange Gabby</td>
                <td>STU006</td>
                <td>Lower sixth</td>
                <td>June</td>
                <td>Week 1</td>
                <td class="present">20%</td>
            </tr>
             <tr>
                <td>Gabriella</td>
                <td>STU007</td>
                <td>Upper sixth</td>
                <td>July</td>
                <td>Week 1</td>
                <td class="absent">55%</td>
            </tr>
        </tbody>
    </table>
</main>

<script>
const classFilter = document.getElementById("classFilter");
const monthFilter = document.getElementById("monthFilter");
const weekFilter = document.getElementById("weekFilter");
const sortFilter = document.getElementById("sortFilter");
const searchBox = document.getElementById("searchBox");
const tableBody = document.getElementById("attendanceTable").getElementsByTagName("tbody")[0];

// Filter function
function filterTable(){
    let classValue = classFilter.value.toLowerCase();
    let monthValue = monthFilter.value.toLowerCase();
    let weekValue = weekFilter.value.toLowerCase();
    let searchValue = searchBox.value.toLowerCase();

    for(let row of tableBody.rows){
        let classMatch = !classValue || row.cells[2].textContent.toLowerCase()===classValue;
        let monthMatch = !monthValue || row.cells[3].textContent.toLowerCase()===monthValue;
        let weekMatch = !weekValue || row.cells[4].textContent.toLowerCase()===weekValue;
        let searchMatch = row.cells[0].textContent.toLowerCase().includes(searchValue) ||
                          row.cells[1].textContent.toLowerCase().includes(searchValue);
        row.style.display = (classMatch && monthMatch && weekMatch && searchMatch) ? "" : "none";
    }
}

// Sort function
function sortTable(order){
    let rows = Array.from(tableBody.rows);
    rows.sort((a,b)=>{
        let aValue = parseInt(a.cells[5].textContent);
        let bValue = parseInt(b.cells[5].textContent);
        return order==="present" ? bValue - aValue : aValue - bValue;
    });
    rows.forEach(row=>tableBody.appendChild(row));
}

// Update summary cards
function updateSummary(){
    let total = tableBody.rows.length;
    let presentCount = 0;
    for(let row of tableBody.rows){
        if(row.style.display!=="none" && row.cells[5].textContent.replace('%','') >= 75) presentCount++;
    }
    document.getElementById("totalStudents").textContent = total;
    document.getElementById("presentThisWeek").textContent = presentCount;
}

// Event listeners
classFilter.addEventListener("change", ()=>{ filterTable(); updateSummary(); });
monthFilter.addEventListener("change", ()=>{ weekFilter.disabled = !monthFilter.value; filterTable(); updateSummary(); });
weekFilter.addEventListener("change", ()=>{ filterTable(); updateSummary(); });
searchBox.addEventListener("keyup", ()=>{ filterTable(); updateSummary(); });
sortFilter.addEventListener("change", ()=>{ sortTable(sortFilter.value); updateSummary(); });

// Initial summary
updateSummary();
</script>

<footer>
    <p>Copyright &copy; <span class="logo">SAMS</span>, 2025</p>
</footer>

</body>
</html>
