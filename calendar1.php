<?php
include 'db.php';
session_start();
if (!isset($_SESSION['teacher_id'])) {
    header("Location: teacher-login.php");
    exit();
}
if (!isset($_GET['class_id'])) {
  echo "No class selected";
  exit();
}
$class_id = $_GET['class_id'];

$sql = "SELECT id, fullname, matricule FROM students WHERE class = ?";
$stmt = $conn->prepare($sql);
if ($stmt === false) {
    die("Prepare failed: " . $conn->error);
}

$stmt->bind_param("i", $class_id);
$stmt->execute();
$result = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Student Attendance</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background: #f8f9fa;
      margin: 0;
      padding: 0;
    }
    header {
      background: #004085;
      color: white;
      padding: 15px;
      text-align: center;
    }
    .container {
      max-width: 1100px;
      margin: 20px auto;
      padding: 20px;
      background: white;
      border-radius: 8px;
      box-shadow: 0 2px 5px rgba(0,0,0,0.1);
      margin-right: 100px;
    }

    .controls {
      display: flex;
      flex-wrap: wrap;
      gap: 10px;
      margin-bottom: 20px;
      align-items: center;
    }
    select, button, input {
      padding: 8px;
      font-size: 14px;
      border-radius: 5px;
      border: 1px solid #ccc;
    }
    button {
      background: #004085;
      color: white;
      border: none;
      cursor: pointer;
    }
    button:hover {
      background: #0056b3;
    }
    .week {
      margin-bottom: 25px;
      border: 1px solid #ddd;
      padding: 15px;
      border-radius: 6px;
      background: #fdfdfd;
    }
    .week h3 {
      margin-top: 0;
      color: #004085;
    }
    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 10px;
    }
    th, td {
      padding: 8px;
      border: 1px solid #ccc;
      text-align: center;
    }
    .add-student {
      margin-top: 10px;
      display: flex;
      gap: 10px;
    }
    .add-student input {
      flex: 1;
    }
    .summary {
      margin-top: 30px;
      padding: 15px;
      border: 1px solid #ddd;
      border-radius: 6px;
      background: #f7f9ff;
    }
    .summary h3 {
      margin-top: 0;
      color: #004085;
    }
    /* Sidebar */
.sidebar {
    width: 180px;
    background: #004aad;
    color: white;
    height: 100vh;
    padding: 20px;
    position: fixed;
}
.sidebar .logo {
    text-align: center;
}
.sidebar nav {
    margin-top: 30px;
}
img {
  width: 100px;
  margin-bottom: 20px;
}
footer {
    text-align: center;
    padding: 20px;
    position: fixed;
    left: 0;
    height: 2vh;
    right: 0;
    bottom: 0;
    background: #fff;
    z-index: 100;
}
span{
    color: #10b981;
}
.sidebar nav a {
    display: block;
    padding: 10px;
    color: white;
    text-decoration: none;
    margin-bottom: 10px;
    border-radius: 5px;
}
.sidebar nav a:hover {
    background: #1ed99b;
}

  </style>
</head>
<body>
  <h2>Take Attendance - class <?php echo htmlspecialchars($class_id); ?></h2>
    <!-- Sidebar -->
    <aside class="sidebar">
        <img src="logo.jpg" alt="logo" class="logo">
        <nav>
            <a href="Teacherb.php">Dashboard</a>
        </nav>
    </aside>
  <header>
    <h1>Teacher Dashboard – Attendance</h1>
  </header>

  <div class="container">
    <div class="controls">
      <label for="monthSelect">Select Month:</label>
      <select id="monthSelect"></select>
      
      
     <!-- <button onclick="createNextWeek()">➕ Create Next Week</button>-->

      <label for="weekFilter">Show Week:</label>
      <select id="weekFilter">
        <option value="all">All Weeks</option>
        <option value="all"> Week 1</option>
        <option value="all"> Week 2</option>
        <option value="all"> Week 3</option>
        <option value="all"> Week 4</option>
      </select>

      <input type="text" id="searchInput" placeholder="🔍 Search student ">
      <form method="POST">
  <?php
  $result = $conn->query("SELECT id, fullname FROM students WHERE class_id=1"); 
  if (!$result) {
    die("Query failed:" . $conn->error);
  }
  while($row = $result->fetch_assoc()) {
      echo "<label>{$row['fullname']}</label>";
      echo "<select name='status[{$row['id']}]'>
              <option value='Present'>Present</option>
              <option value='Absent'>Absent</option>
              <option value='Late'>Late</option>
            </select><br>";
  }
  ?>
  <button type="submit">Submit Attendance</button>
</form>
     
    </div>


    <div id="weeksContainer"></div>

    <div class="summary">
      <h3>📊 Monthly Summary</h3>
      <table id="summaryTable">
        <thead>
          <tr>
            <th>Student Name</th>
            <th>Present Count</th>
            <th>Absent Count</th>
          </tr>
        </thead>
        <tbody></tbody>
      </table>
    </div>
  </div>

  <script>
    const monthSelect = document.getElementById("monthSelect");
    const weeksContainer = document.getElementById("weeksContainer");
    const searchInput = document.getElementById("searchInput");
    const weekFilter = document.getElementById("weekFilter");
    const summaryTableBody = document.querySelector("#summaryTable tbody");

    let currentMonth = new Date().getMonth();
    let currentYear = new Date().getFullYear();
    let weeks = {}; // { "2025-08": [ {number, students:[]} ] }

    const months = [
      "January","February","March","April","May","June",
      "July","August","September","October","November","December"
    ];
    const days = ["Mon","Tue","Wed","Thu","Fri","Sat"];

    // Populate months
    for (let i = 0; i < 12; i++) {
      const option = document.createElement("option");
      option.value = i;
      option.textContent = `${months[i]} ${currentYear}`;
      if (i === currentMonth) option.selected = true;
      monthSelect.appendChild(option);
    }

    monthSelect.addEventListener("change", () => {
      currentMonth = parseInt(monthSelect.value);
      renderWeeks();
    });

    searchInput.addEventListener("input", renderWeeks);
    weekFilter.addEventListener("change", renderWeeks);

    function createWeek() {
      const key = `${currentYear}-${currentMonth}`;
      if (!weeks[key]) weeks[key] = [];

      if (weeks[key].length >= 4) {
        alert("You can only create 4 weeks per month!");
        return;
      }

      const weekNum = weeks[key].length + 1;
      weeks[key].push({ number: weekNum, students: [] });
      renderWeeks();
    }

    function renderWeeks() {
      weeksContainer.innerHTML = "";
      summaryTableBody.innerHTML = "";
      const key = `${currentYear}-${currentMonth}`;
      if (!weeks[key]) return;

      // reset week filter options
      weekFilter.innerHTML = '<option value="all">All Weeks</option>';
      weeks[key].forEach(week => {
        const opt = document.createElement("option");
        opt.value = week.number;
        opt.textContent = `Week ${week.number}`;
        weekFilter.appendChild(opt);
      });

      const searchQuery = searchInput.value.toLowerCase();
      const filterWeek = weekFilter.value;

      let summaryData = {};

      weeks[key].forEach(week => {
        if (filterWeek !== "all" && parseInt(filterWeek) !== week.number) return;

        const weekDiv = document.createElement("div");
        weekDiv.className = "week";
        
        // build table header
        let headerRow = "<tr><th>Student Name</th>";
        days.forEach(d => headerRow += `<th>${d}</th>`);
        headerRow += "</tr>";

        weekDiv.innerHTML = `
          <h3>Week ${week.number}</h3>
          <table>
            <thead>${headerRow}</thead>
            <tbody id="week-${key}-${week.number}"></tbody>
          </table>
          <div class="add-student">
            <input type="text" id="studentInput-${key}-${week.number}" placeholder="Enter student name">
            <button onclick="addStudent('${key}', ${week.number})">Add Student</button>
          </div>
        `;
        weeksContainer.appendChild(weekDiv);

        const tbody = weekDiv.querySelector("tbody");
        week.students
          .filter(s => s.name.toLowerCase().includes(searchQuery))
          .forEach((s, idx) => {
            const tr = document.createElement("tr");
            let rowHTML = `<td>${s.name}</td>`;
            days.forEach((d, dayIdx) => {
              const att = s.attendance[dayIdx] || null;
              rowHTML += `
                <td>
                  <label><input type="radio" name="att-${key}-${week.number}-${idx}-${dayIdx}" ${att==="P"?"checked":""} onchange="setAttendance('${key}', ${week.number}, ${idx}, ${dayIdx}, 'P')"> P</label>
                  <label><input type="radio" name="att-${key}-${week.number}-${idx}-${dayIdx}" ${att==="A"?"checked":""} onchange="setAttendance('${key}', ${week.number}, ${idx}, ${dayIdx}, 'A')"> A</label>
                </td>
              `;
            });
            tr.innerHTML = rowHTML;
            tbody.appendChild(tr);

            // update summary counts
            if (!summaryData[s.name]) summaryData[s.name] = { present: 0, absent: 0 };
            s.attendance.forEach(val => {
              if (val==="P") summaryData[s.name].present++;
              if (val==="A") summaryData[s.name].absent++;
            });
          });
      });

      // Render summary
      Object.keys(summaryData).forEach(name => {
        const tr = document.createElement("tr");
        tr.innerHTML = `
          <td>${name}</td>
          <td>${summaryData[name].present}</td>
          <td>${summaryData[name].absent}</td>
        `;
        summaryTableBody.appendChild(tr);
      });
    }

    function addStudent(key, weekNum) {
      const input = document.getElementById(`studentInput-${key}-${weekNum}`);
      const name = input.value.trim();
      if (!name) {
        alert("Enter student name");
        return;
      }
      const week = weeks[key].find(w => w.number === weekNum);
      week.students.push({ name, attendance: Array(6).fill(null) });
      input.value = "";
      renderWeeks();
    }






const classId = <?php echo json_encode($class_id); ?>

function loadStudents() {
 

  fetch("get_students.php?class_id" + classId)
    .then(response => response.json())
    .then(data => {
      const key = `${currentYear}-${currentMonth}`;
      weeks[key] = []; // reset for this month

      // create 4 weeks automatically
      for (let i = 1; i <= 4; i++) {
        weeks[key].push({
          number: i,
          students: data.map(student => ({
            id: student.student_id,
            name: student.fullname,
            attendance: Array(days.length).fill(null)
          }))
        });
      }

      renderWeeks();
    });
}


document.addEventListener("DOMContentLoaded",loadStudents);




/*function loadStudents() {
  fetch("get_students.php")
    .then(response => response.json())
    .then(data => {
      data.forEach(student => {
        // Add each student to current week
        weeks[`${currentYear}-${currentMonth}`].forEach(week => {
          week.students.push({
            id: student.student_id,
            name: student.fullname,
            attendance: Array(days.length).fill(null)
          });
        });
      });
      renderWeeks();
    });
}
*/



    function setAttendance(key, weekNum, studentIdx, dayIdx, value) {
      const week = weeks[key].find(w => w.number === weekNum);
      week.students[studentIdx].attendance[dayIdx] = value;
      renderWeeks();
    }

    // Initial render
    renderWeeks();
function saveAttendance() {
  const key = `${currentYear}-${currentMonth}`;
  const data = [];


  weeks[key].forEach((week, weekIndex) => {
    week.students.forEach((student) => {
      student.attendance.forEach((status, dayIdex) => {
        if (status !== null) {
          const date = new Date(currentYear, currentMonth, dayIdex + 1)
          .toISOString().split('T')[0]; 

          data.push({
            student_id: student.id, // you must replace with real student_id from DB
            date: date,
            class_id: classId,
            year: currentYear,
            week: Week.number,
            mont: currentMonth +1,
            status: status
          });
        }
      });
    });
  });

  fetch("save_attendance.php", {
    method: "POST",
    headers: { "Content-Type": "application/x-www-form-urlencoded" },
    body: "attendance=" + encodeURIComponent(JSON.stringify(attendanceData))
  })
  .then(res => res.text())
  .then(msg => alert(msg));
}


document.addEventListener("DOMContentLoaded",loadStudents);

  </script>
    <footer>
        <p>Copyright &copy; <span class="logo">SAMS</span>,2025</p>
    </footer>
</body>
</html>






