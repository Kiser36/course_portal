<?php
// 1. Start the session to remember the user is logged in
session_start();

// 2. Include the database connection details
include "db_config.php";

// 3. Check if the login button was actually clicked
if (isset($_POST['login_btn'])) {

    // 4. Get the data from the form
    // $username is the "bucket" holding whatever they typed (Name or Reg No)
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    // 5. UPDATED SQL: This now checks BOTH the username and reg_no columns
    $sql = "SELECT * FROM users WHERE (username='$username' OR reg_no='$username') AND password='$password' LIMIT 1";
    $result = mysqli_query($conn, $sql);

    // 6. Check if a match was found
    if (mysqli_num_rows($result) > 0) {
        $user_data = mysqli_fetch_assoc($result);

        // Store session data from the database results
        $_SESSION['username'] = $user_data['username'];
        $_SESSION['role'] = $user_data['role'];
        $_SESSION['reg_no'] = $user_data['reg_no']; // Captures '2024-B071-22936'

        // 7. Redirect based on their role
        // Note: Ensure these files exist in the folder ABOVE 'includes'
        if ($_SESSION['role'] == 'admin') {
            header("Location: ../admin_dashboard.php");
        } else {
            header("Location: ../student_dashboard.php");
        }
        exit();

    } else {
        // If query fails, go back to login with error message
        header("Location: ../index.php?error=invalid_credentials");
        exit();
    }
} else {
    // If someone tries to access this file directly without clicking login
    header("Location: ../index.php");
    exit();
}
?>