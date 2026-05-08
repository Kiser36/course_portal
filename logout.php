<?php
// 1. Initialize the session to access it
session_start();

// 2. Destroy the session entirely
// This removes 'fullname', 'regno', and 'role' in one command
session_destroy();

// 3. Redirect to the login page
header("Location: index.php");
exit();
?>