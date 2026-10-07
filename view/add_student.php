<?php
// 1. Get status notification from query string
$error = $_GET["error"] ?? "";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Add Student - PSP Student Portal</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <!-- External Custom CSS -->
    <link rel="stylesheet" href="../css/style.css">
</head>
<body class="py-4">

<div class="container" style="max-width: 650px;">

    <!-- Page Header -->
    <div class="card card-custom bg-white mb-4">
        <div class="card-body d-flex align-items-center gap-3 py-3 px-4">
            <div class="p-2 bg-light rounded-3 text-purple">
                <i class="bi bi-person-plus-fill fs-3"></i>
            </div>
            <div>
                <h3 class="fw-bold text-dark mb-0">Add New Student</h3>
                <p class="text-muted small mb-0">Enter student details to register</p>
            </div>
        </div>
    </div>

    <!-- Alert Notifications -->
    <?php if ($error === "empty") { ?>
        <div class="alert alert-danger alert-dismissible fade show rounded-3 shadow-sm" role="alert">
            <i class="bi bi-exclamation-triangle-fill me-2"></i> Please fill in all fields.
        </div>
    <?php } ?>

    <?php if ($error === "marks") { ?>
        <div class="alert alert-danger alert-dismissible fade show rounded-3 shadow-sm" role="alert">
            <i class="bi bi-exclamation-triangle-fill me-2"></i> Marks must be between 0 and 100.
        </div>
    <?php } ?>

    <?php if ($error === "failed") { ?>
        <div class="alert alert-danger alert-dismissible fade show rounded-3 shadow-sm" role="alert">
            <i class="bi bi-x-circle-fill me-2"></i> Failed to add student.
        </div>
    <?php } ?>

    <!-- Add Student Form Card -->
    <div class="card card-custom bg-white p-4 mb-4">
        <form action="../controller/student_controller.php" method="POST" onsubmit="return validateStudentForm();">

            <!-- Student Name Input -->
            <div class="mb-3">
                <label for="name" class="form-label fw-semibold text-dark">
                    <i class="bi bi-person me-1 text-purple"></i> Student Name
                </label>
                <input type="text" name="name" id="name" class="form-control form-control-lg rounded-3 fs-6" placeholder="Enter full name" required>
            </div>

            <!-- Student IC Input -->
            <div class="mb-3">
                <label for="ic" class="form-label fw-semibold text-dark">
                    <i class="bi bi-card-heading me-1 text-purple"></i> IC Number
                </label>
                <input type="text" name="ic" id="ic" class="form-control form-control-lg rounded-3 fs-6" placeholder="Enter NRIC (e.g., 010101-01-0101)" required>
            </div>

            <!-- Student Marks Input -->
            <div class="mb-4">
                <label for="marks" class="form-label fw-semibold text-dark">
                    <i class="bi bi-award me-1 text-purple"></i> Marks (0 - 100)
                </label>
                <input type="number" name="marks" id="marks" class="form-control form-control-lg rounded-3 fs-6" placeholder="Enter marks" min="0" max="100" required>
            </div>

            <!-- Action Buttons -->
            <div class="d-flex gap-2 pt-2">
                <!-- Submit Button -->
                <button type="submit" name="add" class="btn btn-purple rounded-3 px-4 py-2.5 fw-semibold shadow-sm">
                    <i class="bi bi-check-lg me-1"></i> Add Student
                </button>
                <!-- Back Link Button -->
                <a href="student.php" class="btn btn-outline-purple rounded-3 px-4 py-2.5 fw-semibold">
                    <i class="bi bi-arrow-left me-1"></i> Back
                </a>
            </div>

        </form>
    </div>

</div>

<script src="../js/student.js"></script>
</body>
</html>