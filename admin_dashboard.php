
<?php
session_start();
include "includes/db_config.php";

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: index.php?error=nopage");
    exit();
}

$search_query = "";
$sql = "SELECT * FROM courses"; 

if (isset($_GET['search']) && !empty($_GET['search'])) {
    $search_query = mysqli_real_escape_string($conn, $_GET['search']);
    $sql .= " WHERE course_name LIKE '%$search_query%' 
              OR course_code LIKE '%$search_query%' 
              OR lecturer LIKE '%$search_query%'";
}

$res = mysqli_query($conn, $sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard - ICT Portal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body { background-color: #f8f9fa; }
        .sidebar { height: 100vh; background: #212529; color: white; padding-top: 20px; position: fixed; width: 16.666667%; }
        .sidebar a { color: #adb5bd; text-decoration: none; padding: 12px 20px; display: block; transition: 0.3s; }
        .sidebar a:hover, .sidebar a.active { background: #343a40; color: white; border-left: 4px solid #0d6efd; }
        main { margin-left: 16.666667%; } 
    </style>
</head>
<body>
<div class="container-fluid">
    <div class="row">
        <!-- Sidebar: The only place for the Add New Course link now -->
        <nav class="col-md-2 d-none d-md-block sidebar shadow">
            <h4 class="text-center mb-4 text-primary">Admin Panel</h4>
            <a href="admin_dashboard.php" class="active"><i class="fas fa-home me-2"></i> Dashboard</a>
            <a href="add_course.php"><i class="fas fa-plus-circle me-2"></i> Add New Course</a>
            <hr class="mx-3 border-secondary">
            <a href="logout.php" class="text-danger"><i class="fas fa-sign-out-alt me-2"></i> Logout</a>
        </nav>

        <!-- Main Content -->
        <main class="col-md-10 px-md-4 pt-3">
            <div class="d-flex justify-content-between align-items-center pb-2 mb-3 border-bottom">
                <!-- Removed the redundant blue button from here -->
                <h1 class="h2">Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h1>
                <span class="badge bg-dark">System Administrator</span>
            </div>

            <!-- SEARCH BAR -->
            <div class="row mb-4">
                <div class="col-md-6">
                    <form action="admin_dashboard.php" method="GET" class="input-group shadow-sm">
                        <input type="text" name="search" class="form-control" placeholder="Search courses or lecturers..." value="<?php echo htmlspecialchars($search_query); ?>">
                        <button class="btn btn-primary" type="submit">Search</button>
                    </form>
                </div>
            </div>

            <h5 class="text-muted mb-3"><i class="fas fa-database me-2"></i>Course Records</h5>
            
            <div class="card shadow border-0">
                <div class="card-body p-0">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-3">Code</th>
                                <th>Course Name</th>
                                <th>Units</th>
                                <th>Lecturer</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if(mysqli_num_rows($res) > 0) {
                                while($row = mysqli_fetch_assoc($res)) {
                                    echo "<tr>
                                        <td class='ps-3 fw-bold text-primary'>{$row['course_code']}</td>
                                        <td>{$row['course_name']}</td>
                                        <td>{$row['credit_units']}</td>
                                        <td>{$row['lecturer']}</td>
                                        <td class='text-center'>
                                            <a href='edit_course.php?id={$row['id']}' class='btn btn-sm btn-outline-primary me-1'><i class='fas fa-edit'></i></a>
                                            <a href='delete_course.php?id={$row['id']}' class='btn btn-sm btn-outline-danger' onclick='return confirm(\"Are you sure you want to delete this?\")'><i class='fas fa-trash'></i></a>
                                        </td>
                                    </tr>";
                                }
                            } else {
                                echo "<tr><td colspan='5' class='text-center py-4 text-muted'>No courses found in system.</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>
</div>
</body>
</html>