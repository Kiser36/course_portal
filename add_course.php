<?php
session_start();
include "db_config.php";

// 1. Security Check: Only admins allowed
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: index.php");
    exit();
}

// 2. Process the form when the "Save" button is clicked
if (isset($_POST['save_course'])) {
    $code = mysqli_real_escape_string($conn, $_POST['course_code']);
    $name = mysqli_real_escape_string($conn, $_POST['course_name']);
    $units = mysqli_real_escape_string($conn, $_POST['credit_units']);
    $lecturer = mysqli_real_escape_string($conn, $_POST['lecturer']);

    $sql = "INSERT INTO courses (course_code, course_name, credit_units, lecturer) 
            VALUES ('$code', '$name', '$units', '$lecturer')";

    if (mysqli_query($conn, $sql)) {
        $success = "Course added successfully!";
    } else {
        $error = "Error: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add New Course</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow border-0">
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0">Add New Course</h4>
                    </div>
                    <div class="card-body p-4">
                        
                        <?php if(isset($success)): ?>
                            <div class="alert alert-success"><?php echo $success; ?></div>
                        <?php endif; ?>

                        <form action="add_course.php" method="POST">
                            <div class="mb-3">
                                <label class="form-label">Course Code</label>
                                <input type="text" name="course_code" class="form-control" placeholder="e.g. BIT 1101" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Course Name</label>
                                <input type="text" name="course_name" class="form-control" placeholder="e.g. Introduction to ICT" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Credit Units</label>
                                <input type="number" name="credit_units" class="form-control" placeholder="e.g. 4" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Lecturer Name</label>
                                <input type="text" name="lecturer" class="form-control" placeholder="e.g. Dr. John Doe" required>
                            </div>

                            <div class="d-flex justify-content-between">
                                <a href="admin_dashboard.php" class="btn btn-secondary">Back to Dashboard</a>
                                <button type="submit" name="save_course" class="btn btn-success">Save Course</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>
</html>