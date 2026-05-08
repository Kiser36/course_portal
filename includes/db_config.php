<?php
// Database credentials
$host = "localhost";
$user = "root";      // Default XAMPP username
$pass = "mcterryjr";          // Default XAMPP password is empty
$dbname = "course_portal";

// Create connection
$conn = mysqli_connect($host, $user, $pass, $dbname);

// Check if connection worked
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
