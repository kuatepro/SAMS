<?php
$result = $conn->query("SELECT s.fullname, a.date, a.status 
                        FROM attendance a
                        JOIN students s ON a.student_id = s.id");
while($row = $result->fetch_assoc()) {
    echo $row['fullname']." - ".$row['date']." - ".$row['status']."<br>";
}
?>