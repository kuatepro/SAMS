
<?php
include 'db.php';
session_start();

$parent_id = $_SESSION['parent_id'];
$sql = "SELECT s.fullname, a.date, a.status 
        FROM attendance a
        JOIN students s ON a.student_id = s.id
        JOIN parents p ON p.student_id = s.id
        WHERE p.id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $parent_id);
$stmt->execute();
$result = $stmt->get_result();

while($row = $result->fetch_assoc()) {
    echo $row['fullname']." - ".$row['date']." - ".$row['status']."<br>";
}
?>
