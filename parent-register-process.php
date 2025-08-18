<?php
include 'db.php'; // your DB connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Debug: Show all POST data
    //echo '<pre>POST DATA: ' . print_r($_POST, true) . '</pre>';

    $fullname = isset($_POST['fullname']) ? $_POST['fullname'] : '';
    $contact = isset($_POST['contact']) ? $_POST['contact'] : '';
    $password = isset($_POST['password']) ? password_hash($_POST['password'], PASSWORD_DEFAULT) : '';
    $email = isset($_POST['email']) ? $_POST['email'] : '';

    // Debug: Show what values are being used
    echo "<pre>fullname: $fullname\ncontact: $contact\npassword: ".(empty($password)?'EMPTY':'SET')."\nemail: $email</pre>";

    // Check for required fields
    if (empty($fullname) || empty($contact) || empty($password) || empty($email)) {
        die("Error: All fields are required.");
    }

    // Validate contact is exactly 9 digits
    if (strlen($contact) != 9 || !ctype_digit($contact)) {
        die("Error: Contact must be exactly 9 digits.");
    }

    $sql = "INSERT INTO parents (fullname, contact, password, email) VALUES (?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $sql);
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "ssss", $fullname, $contact, $password, $email);
        if (mysqli_stmt_execute($stmt)) {
           // echo "Registration successful! <a href='parent-login.php'>Login</a>";
           header("Location: parent-login.php?success=1");
        } else {
            echo "Error: " . mysqli_stmt_error($stmt);
        }
        mysqli_stmt_close($stmt);
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>
