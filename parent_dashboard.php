<?php
include 'db.php';

$class_id = isset($_GET['class_id']) ? $_GET['class_id'] : null;
$student_id = isset($_GET['student_id']) ? $_GET['student_id'] : null;

$where = [];
$params = [];
$types = '';

if ($class_id) {
    $where[] = 'student_id IN (SELECT student_id FROM students WHERE class_id = ?)';
    $params[] = $class_id;
    $types .= 'i';
}
if ($student_id) {
    $where[] = 'student_id = ?';
    $params[] = $student_id;
    $types .= 'i';
}

$where_sql = $where ? ('WHERE ' . implode(' AND ', $where)) : '';

$sql = "SELECT student_id, student_name,
            SUM(status='P') AS present,
            SUM(status='A') AS absent,
            SUM(status='L') AS late
        FROM attendance
        $where_sql
        GROUP BY student_id, student_name";

$stmt = $conn->prepare($sql);
if ($params) {
    $stmt->bind_param($types, ...$params);
}
$stmt->execute();
$result = $stmt->get_result();

$summary = [];
while ($row = $result->fetch_assoc()) {
    $summary[] = $row;
}

echo json_encode(['summary' => $summary]);
?>
<div>
  <h2>Attendance Summary</h2>
  <table id="attendanceSummaryTable" border="1">
    <thead>
      <tr>
        <th>Student ID</th>
        <th>Name</th>
        <th>Present</th>
        <th>Absent</th>
        <th>Late</th>
      </tr>
    </thead>
    <tbody></tbody>
  </table>
</div>
<script>
function loadAttendanceSummary(studentId) {
  fetch('get_attendance_summary.php?student_id=' + encodeURIComponent(studentId))
    .then(res => res.json())
    .then(data => {
      const tbody = document.querySelector('#attendanceSummaryTable tbody');
      tbody.innerHTML = '';
      (data.summary || []).forEach(row => {
        tbody.innerHTML += `<tr>
          <td>${row.student_id}</td>
          <td>${row.student_name}</td>
          <td>${row.present}</td>
          <td>${row.absent}</td>
          <td>${row.late}</td>
        </tr>`;
      });
    });
}
// Call with the current student ID
loadAttendanceSummary(<?php echo json_encode($student_id ?? ''); ?>);
</script>