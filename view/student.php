<?php
// 1. Include student model for database fetch operations
include "../model/student_model.php";

// 2. Fetch all student records from database
$result = getAllStudents();

// 3. Get status notifications from query string
$success = $_GET["success"] ?? "";
$error = $_GET["error"] ?? "";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Student Records - PSP Student Portal</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <!-- External Custom CSS -->
    <link rel="stylesheet" href="../css/style.css">
</head>
<body class="py-4">

<div class="container" style="max-width: 1000px;">

    <!-- Page Header & Action Controls -->
    <div class="card card-custom bg-white mb-4">
        <div class="card-body d-flex flex-wrap justify-content-between align-items-center py-3 px-4 gap-3">
            <div class="d-flex align-items-center gap-3">
                <div class="p-2 bg-light rounded-3 text-purple">
                    <i class="bi bi-journal-bookmark-fill fs-3"></i>
                </div>
                <div>
                    <h3 class="fw-bold text-dark mb-0">Student Records</h3>
                    <p class="text-muted small mb-0">Manage student information and marks</p>
                </div>
            </div>
            <!-- Add New Student Button -->
            <a href="add_student.php" class="btn btn-purple rounded-3 px-4 py-2.5 fw-semibold shadow-sm">
                <i class="bi bi-person-plus-fill me-2"></i> Add Student
            </a>
        </div>
    </div>

    <!-- Alert Notifications -->
    <?php if ($success === "add") { ?>
        <div class="alert alert-success alert-dismissible fade show rounded-3 shadow-sm" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i> Student added successfully.
        </div>
    <?php } ?>

    <?php if ($success === "update") { ?>
        <div class="alert alert-success alert-dismissible fade show rounded-3 shadow-sm" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i> Student updated successfully.
        </div>
    <?php } ?>

    <?php if ($success === "delete") { ?>
        <div class="alert alert-success alert-dismissible fade show rounded-3 shadow-sm" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i> Student deleted successfully.
        </div>
    <?php } ?>

    <?php if ($error === "delete") { ?>
        <div class="alert alert-danger alert-dismissible fade show rounded-3 shadow-sm" role="alert">
            <i class="bi bi-exclamation-triangle-fill me-2"></i> Failed to delete student.
        </div>
    <?php } ?>

    <!-- Student Table Card -->
    <div class="card card-custom bg-white overflow-hidden mb-4">
        <div class="table-responsive">
            <!-- Fixed: Added student-table and table-bordered classes for grid lines -->
            <table class="table table-bordered student-table align-middle mb-0">
                <!-- Table Header in Purple Gradient -->
                <thead>
                    <tr>
                        <th class="ps-4 py-3">ID</th>
                        <th class="py-3">Name</th>
                        <th class="py-3">IC</th>
                        <th class="text-center py-3">Marks</th>
                        <th class="text-end pe-4 py-3">Action</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                // 4. Render student list dynamically if records exist
                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                ?>
                    <tr>
                        <!-- Student ID -->
                        <td class="ps-4 fw-bold text-purple text-center">#<?php echo htmlspecialchars($row["id"]); ?></td>
                        <!-- Student Name -->
                        <td class="fw-semibold text-dark"><?php echo htmlspecialchars($row["name"]); ?></td>
                        <!-- Student IC -->
                        <td class="text-muted text-center"><?php echo htmlspecialchars($row["ic"]); ?></td>
                        <!-- Student Marks Badge -->
                        <td class="text-center">
                            <span class="badge badge-purple rounded-pill px-3 py-2 fw-bold fs-7">
                                <?php echo htmlspecialchars($row["marks"]); ?>
                            </span>
                        </td>
                        <!-- Action Links & Delete Form -->
                        <td class="text-center pe-4">
                            <!-- Edit Link -->
                            <a href="edit_student.php?id=<?php echo $row["id"]; ?>" class="btn btn-sm btn-outline-warning rounded-2 me-1">
                                <i class="bi bi-pencil-square"></i> Edit
                            </a>
                            <!-- Delete Form -->
                            <form action="../controller/student_controller.php" method="POST" class="d-inline" onsubmit="return confirmDelete();">
                                <input type="hidden" name="id" value="<?php echo $row["id"]; ?>">
                                <button type="submit" name="delete" class="btn btn-sm btn-outline-danger rounded-2">
                                    <i class="bi bi-trash-fill"></i> Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                <?php
                    }
                } else {
                ?>
                    <!-- Empty State Row -->
                    <tr>
                        <td colspan="5" class="text-center py-5 text-muted">
                            <i class="bi bi-inbox fs-2 d-block mb-2 text-secondary"></i>
                            No student records found.
                        </td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Navigation Area -->
    <div>
        <a href="profile.php" class="btn btn-outline-purple rounded-3 px-4 py-2.5 fw-semibold">
            <i class="bi bi-arrow-left me-2"></i> Back to Profile
        </a>
    </div>

</div>

<script src="../js/student.js"></script>
</body>
</html>