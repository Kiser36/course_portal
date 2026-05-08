<?php
session_start();
// Include the database connection from the same folder
include "db_config.php";

if (isset($_POST['enroll_btn'])) {
    // 1. Get student ID from session (2024-B071-22936)
    if(isset($_SESSION['reg_no'])) {
        $student_reg = $_SESSION['reg_no']; 
    } else {
        die("Error: Session expired. Please log in again.");
    }
    
    // 2. Get course code from the hidden form input
    $course = mysqli_real_escape_string($conn, $_POST['course_code']);

    // 3. SQL Query using our table columns: reg_no and course_code
    $sql = "INSERT INTO enrollments (reg_no, course_code) VALUES ('$student_reg', '$course')";

    if (mysqli_query($conn, $sql)) {
        // Redirect back up one level to the dashboard
        header("Location: ../student_dashboard.php?status=enrolled");
        exit();
    } else {
        echo "Enrollment Error: " . mysqli_error($conn);
    }
} else {
    // If someone tries to access this file without clicking the button
    header("Location: ../student_dashboard.php");
    exit();
}
?>