<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Portal | Login</title>
    <!-- Professional Inter Font -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

    <div class="custom-card">
        <h2 class="portal-title">Portal Login</h2>

        <!-- Displays error if login_process.php sends you back -->
        <?php if(isset($_GET['error'])): ?>
            <p style="color: #dc3545; text-align: center; font-size: 0.9rem; margin-bottom: 1rem;">
                Invalid Username or Password
            </p>
        <?php endif; ?>

        <!-- UPDATED ACTION: Points to the correct file name in the includes folder -->
        <form action="includes/login_process.php" method="POST">
            
            <div class="form-group">
                <label class="form-label">Username / Reg No</label>
                <!-- name="username" matches our PHP variable -->
                <input type="text" name="username" class="form-control" placeholder="e.g. 2024-B071-22936" required>
            </div>

            <div class="form-group">
                <label class="form-label">Password</label>
                <!-- name="password" matches our PHP variable -->
                <input type="password" name="password" class="form-control" placeholder="••••••••" required>
            </div>

            <!-- name="login_btn" triggers the isset() check in our PHP -->
            <button type="submit" name="login_btn" class="btn-primary-custom">LOG IN</button>

            <p class="footer-text">
                Don't have an account? <a href="register.php">Register here</a>
            </p>
        </form>
    </div>

</body>
</html>