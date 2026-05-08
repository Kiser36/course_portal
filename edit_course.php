<?php
session_start();
include "includes/db_config.php";

// 1. Security Check: Only admins allowed
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: index.php");
    exit();
}

// 2. Fetch the existing data to show in the form
if (isset($_GET['id'])) {
    $id = mysqli_real_escape_string($conn, $_GET['id']);
    $query = "SELECT * FROM courses WHERE id = '$id' LIMIT 1";
    $result = mysqli_query($conn, $query);
    $course = mysqli_fetch_assoc($result);

    if (!$course) {
        header("Location: admin_dashboard.php?error=notfound");
        exit();
    }
}

// 3. Process the update when the "Update" button is clicked
if (isset($_POST['update_course'])) {
    $id = mysqli_real_escape_string($conn, $_POST['id']);
    $code = mysqli_real_escape_string($conn, $_POST['course_code']);
    $name = mysqli_real_escape_string($conn, $_POST['course_name']);
    $units = mysqli_real_escape_string($conn, $_POST['credit_units']);
    $lecturer = mysqli_real_escape_string($conn, $_POST['lecturer']);

    $sql = "UPDATE courses SET 
            course_code = '$code', 
            course_name = '$name', 
            credit_units = '$units', 
            lecturer = '$lecturer' 
            WHERE id = '$id'";

    if (mysqli_query($conn, $sql)) {
        header("Location: admin_dashboard.php?msg=updated");
        exit();
    } else {
        $error = "Error updating record: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Course | Admin Portal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow border-0">
                    <div class="card-header bg-warning text-dark">
                        <h4 class="mb-0"><i class="fas fa-edit me-2"></i>Modify Course Details</h4>
                    </div>
                    <div class="card-body p-4">
                        
                        <?php if(isset($error)): ?>
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <?php echo $error; ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        <?php endif; ?>

                        <form action="edit_course.php" method="POST">
                            <!-- Hidden ID ensures the correct row is targeted in the UPDATE query -->
                            <input type="hidden" name="id" value="<?php echo $course['id']; ?>">

                            <div class="mb-3">
                                <label class="form-label fw-bold">Course Code</label>
                                <input type="text" name="course_code" class="form-control" value="<?php echo htmlspecialchars($course['course_code']); ?>" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Course Name</label>
                                <input type="text" name="course_name" class="form-control" value="<?php echo htmlspecialchars($course['course_name']); ?>" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Credit Units</label>
                                <input type="number" name="credit_units" class="form-control" value="<?php echo $course['credit_units']; ?>" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Lecturer Name</label>
                                <input type="text" name="lecturer" class="form-control" value="<?php echo htmlspecialchars($course['lecturer']); ?>" required>
                            </div>

                            <div class="d-flex justify-content-between pt-3">
                                <a href="admin_dashboard.php" class="btn btn-outline-secondary">Cancel Changes</a>
                                <button type="submit" name="update_course" class="btn btn-warning px-4">Update Record</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>