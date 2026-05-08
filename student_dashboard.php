
<?php

session_start();
require_once('includes/db_config.php'); // Path to your connection

// 1. Authentication Check
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'student') {
    header("Location: index.php?error=nopage");
    exit();
}

// 2. Identity Retrieval from Session
$student_name = $_SESSION['username']; 
$reg_no = $_SESSION['reg_no']; 

/**
 * Verifies if the student is already registered for a course
 */
function checkEnrollment($conn, $reg_no, $course_code) {
    $reg_no = mysqli_real_escape_string($conn, $reg_no);
    $course_code = mysqli_real_escape_string($conn, $course_code);
    
    $query = "SELECT id FROM enrollments WHERE reg_no = '$reg_no' AND course_code = '$course_code'";
    $result = mysqli_query($conn, $query);
    
    return (mysqli_num_rows($result) > 0);
}

// 3. SEARCH LOGIC
$search_query = "";
$sql = "SELECT * FROM courses";

// This checks if a user has typed into the search bar
if (isset($_GET['search']) && !empty($_GET['search'])) {
    $search_query = mysqli_real_escape_string($conn, $_GET['search']);
    $sql .= " WHERE course_name LIKE '%$search_query%' OR course_code LIKE '%$search_query%'";
}

$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Student Portal | <?php echo htmlspecialchars($student_name); ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body { background-color: #f8f9fa; }
        .course-card { border: none; border-radius: 12px; transition: transform 0.2s; background: #fff; }
        .course-card:hover { transform: translateY(-5px); box-shadow: 0 10px 20px rgba(0,0,0,0.1); }
        .identity-header { background: white; border-left: 5px solid #0d6efd; }
    </style>
</head>
<body>

<div class="container py-5">
    <!-- IDENTITY HEADER -->
    <div class="p-4 identity-header shadow-sm rounded mb-4 d-flex justify-content-between align-items-center">
        <div>
            <h2 class="mb-1">Welcome, <strong><?php echo htmlspecialchars($student_name); ?></strong></h2>
            <p class="text-muted mb-0">Reg No: <?php echo htmlspecialchars($reg_no); ?></p>
        </div>
        <a href="logout.php" class="btn btn-outline-danger">Logout</a>
    </div>

    <!-- CATALOGUE SEARCH BAR -->
    <div class="row mb-4">
        <div class="col-md-12">
            <form action="student_dashboard.php" method="GET" class="input-group input-group-lg shadow-sm">
                <input type="text" name="search" class="form-control" placeholder="Search (e.g. SQL, Java, PHP)..." value="<?php echo htmlspecialchars($search_query); ?>">
                <button class="btn btn-primary" type="submit"><i class="fas fa-search me-2"></i>Filter Courses</button>
            </form>
        </div>
    </div>

    <!-- COURSE GRID -->
    <div class="row">
        <?php if ($result && mysqli_num_rows($result) > 0): ?>
            <?php while ($row = mysqli_fetch_assoc($result)): ?>
                <?php $is_enrolled = checkEnrollment($conn, $reg_no, $row['course_code']); ?>
                
                <div class="col-md-4 mb-4">
                    <div class="card h-100 course-card shadow-sm">
                        <div class="card-body d-flex flex-column">
                            <div class="d-flex justify-content-between mb-2">
                                <span class="badge bg-secondary"><?php echo $row['course_code']; ?></span>
                                <span class="text-primary small fw-bold"><?php echo $row['credit_units']; ?> CU</span>
                            </div>
                            <h5 class="fw-bold"><?php echo htmlspecialchars($row['course_name']); ?></h5>
                            <p class="text-muted small"><?php echo htmlspecialchars($row['lecturer']); ?></p>
                            
                            <div class="mt-auto">
                                <hr>
                                <div class="d-grid">
                                    <?php if ($is_enrolled): ?>
                                        <button class="btn btn-success disabled" disabled>Already Enrolled</button>
                                    <?php else: ?>
                                        <!-- ENROLLMENT FORM -->
                                        <form action="includes/enrol_process.php" method="POST">
                                            <input type="hidden" name="course_code" value="<?php echo $row['course_code']; ?>">
                                            <button type="submit" name="enroll_btn" class="btn btn-primary w-100">Enrol Me</button>
                                        </form>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <div class="col-12 text-center py-5">
                <div class="alert alert-info">No courses found matching "<?php echo htmlspecialchars($search_query); ?>".</div>
            </div>
        <?php endif; ?>
    </div>
</div>
</body>
</html>