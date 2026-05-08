<?php
// 1. Start the session to verify admin status
session_start();

// 2. Include the database connection
include "db_config.php";

// 3. Security Check: Only allow admins to delete data
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: index.php?error=unauthorized");
    exit();
}

// 4. Check if a valid ID was sent via the URL
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $course_id = mysqli_real_escape_string($conn, $_GET['id']);

    // 5. Create the DELETE query
    // This targets the specific course row in your 'courses' table
    $sql = "DELETE FROM courses WHERE id = '$course_id' LIMIT 1";

    if (mysqli_query($conn, $sql)) {
        // Redirect back to dashboard with a success notification
        header("Location: admin_dashboard.php?msg=course_deleted");
        exit();
    } else {
        // If deletion fails (e.g., due to active student enrollments)
        echo "Error deleting record: " . mysqli_error($conn);
    }
} else {
    // If no ID is provided, redirect back to the dashboard
    header("Location: admin_dashboard.php");
    exit();
}
?>