<?php
include 'db.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Teacher Attendance Calendar</title>
  <link rel="stylesheet" href="../css/teacher_attendance.css">
</head>
<body>
  <header>
    <h1>Attendance Calendar</h1>
    <div class="controls">
      <label for="month-select">Month:</label>
      <select id="month-select"></select>

      <div id="week-buttons"></div>
    </div>
  </header>

  <main>
    <table id="attendance-table">
      <thead>
        <tr>
          <th>Student</th>
          <th>Mon</th>
          <th>Tue</th>
          <th>Wed</th>
          <th>Thu</th>
          <th>Fri</th>
        </tr>
      </thead>
      <tbody></tbody>
    </table>
  </main>

  <footer>
    <button id="create-week-btn">Create Next Week</button>
    <button id="save-week-btn">Save Attendance</button>
  </footer>

  <script>
    const classId = new URLSearchParams(window.location.search).get('class');
  </script>
  <script src="../script/script.js"></script>
  <footer>
    <p>Copyright &copy; <span class="logo">SAMS</span>, 2025</p>
</footer>
</body>
</html>