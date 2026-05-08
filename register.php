
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register | ICT Portal</title>
    <!-- External CSS link -->
    <link rel="stylesheet" href="css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-light">
    <div class="container d-flex align-items-center" style="min-height: 100vh;">
        <div class="row justify-content-center w-100">
            <div class="col-md-5">
                <div class="card shadow-lg border-0 p-4">
                    <div class="text-center mb-4">
                        <i class="fas fa-user-plus fa-4x text-primary"></i>
                        <h2 class="fw-bold mt-2">Create Account</h2>
                        <p class="text-muted">Student Registration Portal</p>
                    </div>

                    <!-- Display potential error messages from register_process.php -->
                    <?php if (isset($_GET['error'])): ?>
                        <div class="alert alert-danger py-2 text-center small">
                            <?php 
                                if($_GET['error'] == "emptyfields") echo "Please fill in all fields.";
                                elseif($_GET['error'] == "usertaken") echo "Registration number already exists.";
                                elseif($_GET['error'] == "sqlerror") echo "Database connection error.";
                            ?>
                        </div>
                    <?php endif; ?>

                    <form action="includes/register_process.php" method="POST">
                        <div class="mb-3">
                            <label class="form-label small fw-bold">Full Name</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-user"></i></span>
                                <input type="text" name="fullname" class="form-control" placeholder="Enter Full Name" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label small fw-bold">Registration Number</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-id-card"></i></span>
                                <input type="text" name="regno" class="form-control" placeholder="e.g. 2024-B071-22936" required>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label small fw-bold">Password</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                <input type="password" name="password" class="form-control" placeholder="********" required>
                            </div>
                        </div>

                        <button type="submit" name="register_btn" class="btn btn-primary w-100 py-2 fw-bold">
                            Register Student
                        </button>
                    </form>

                    <div class="mt-4 text-center">
                        <p class="small">Already have an account? <a href="index.php" class="text-primary fw-bold text-decoration-none">Login</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>