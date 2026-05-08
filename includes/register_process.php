<?php

include "db_config.php";

if (isset($_POST['register_btn'])) {
    // Collect and clean data to prevent SQL Injection
    // Using 'username' to match your login query logic
    $username = mysqli_real_escape_string($conn, $_POST['fullname']);
    $reg      = mysqli_real_escape_string($conn, $_POST['regno']);
    $pass     = mysqli_real_escape_string($conn, $_POST['password']);
    $role     = "student";

    // SQL command updated to match your table columns: username, password, role, reg_no
    $sql = "INSERT INTO users (username, password, role, reg_no) 
            VALUES ('$username', '$pass', '$role', '$reg')";

    // Execute query
    if (mysqli_query($conn, $sql)) {
        // Redirect back to login page on success
        header("Location: ../index.php?msg=registration_success");
        exit();
    } else {
        // Show specific error (useful for catching duplicate Reg No. errors)
        echo "Database Error: " . mysqli_error($conn);
    }
} else {
    header("Location: ../register.php");
    exit();
}
?>
