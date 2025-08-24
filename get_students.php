<?php
include 'db.php';

$class = isset($_GET['class']) ? $_GET['class'] : '';
$students = [];

if ($class !== '') {
    $sql = "SELECT id, fullname, matricule, class FROM students WHERE class = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $class);
    $stmt->execute();
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
        $students[] = $row;
    }
    $stmt->close();
} else {
    // If no class specified, return all students (optional)
    $sql = "SELECT id, fullname, matricule, class FROM students";
    $result = $conn->query($sql);
    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $students[] = $row;
        }
    }
}

echo json_encode(['students' => $students]);
?>