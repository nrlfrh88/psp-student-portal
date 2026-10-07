<?php
session_start();

// 1. Check if student is logged in via session
if (!isset($_SESSION["student_id"])) {
    header("Location: login.php");
    exit();
}

// 2. Get status notifications from query string
$error = $_GET["error"] ?? "";
$success = $_GET["success"] ?? "";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Change Password - PSP Student Portal</title>
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
                <i class="bi bi-shield-lock-fill fs-3"></i>
            </div>
            <div>
                <h3 class="fw-bold text-dark mb-0">Change Password</h3>
                <p class="text-muted small mb-0">Update your student account password</p>
            </div>
        </div>
    </div>

    <!-- Alert Notifications -->
    <?php if ($success === "1") { ?>
        <div class="alert alert-success alert-dismissible fade show rounded-3 shadow-sm" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i> Password changed successfully.
        </div>
    <?php } ?>

    <?php if ($error === "empty") { ?>
        <div class="alert alert-danger alert-dismissible fade show rounded-3 shadow-sm" role="alert">
            <i class="bi bi-exclamation-triangle-fill me-2"></i> Please fill in all password fields.
        </div>
    <?php } ?>

    <?php if ($error === "mismatch") { ?>
        <div class="alert alert-danger alert-dismissible fade show rounded-3 shadow-sm" role="alert">
            <i class="bi bi-exclamation-triangle-fill me-2"></i> New password and confirm password do not match.
        </div>
    <?php } ?>

    <?php if ($error === "same") { ?>
        <div class="alert alert-danger alert-dismissible fade show rounded-3 shadow-sm" role="alert">
            <i class="bi bi-exclamation-triangle-fill me-2"></i> New password must be different from old password.
        </div>
    <?php } ?>

    <?php if ($error === "old") { ?>
        <div class="alert alert-danger alert-dismissible fade show rounded-3 shadow-sm" role="alert">
            <i class="bi bi-exclamation-triangle-fill me-2"></i> Old password is incorrect.
        </div>
    <?php } ?>

    <?php if ($error === "user") { ?>
        <div class="alert alert-danger alert-dismissible fade show rounded-3 shadow-sm" role="alert">
            <i class="bi bi-x-circle-fill me-2"></i> User account not found.
        </div>
    <?php } ?>

    <?php if ($error === "failed") { ?>
        <div class="alert alert-danger alert-dismissible fade show rounded-3 shadow-sm" role="alert">
            <i class="bi bi-x-circle-fill me-2"></i> Failed to update password.
        </div>
    <?php } ?>

    <!-- Change Password Form Card -->
    <div class="card card-custom bg-white p-4 mb-4">
        <form action="../controller/password_controller.php" method="POST" onsubmit="return validatePasswordForm();">

            <!-- Old Password Input -->
            <div class="mb-3">
                <label for="old_password" class="form-label fw-semibold text-dark">
                    <i class="bi bi-key me-1 text-purple"></i> Old Password
                </label>
                <input type="password" name="old_password" id="old_password" class="form-control form-control-lg rounded-3 fs-6" placeholder="Enter old password" required>
            </div>

            <!-- New Password Input -->
            <div class="mb-3">
                <label for="new_password" class="form-label fw-semibold text-dark">
                    <i class="bi bi-lock me-1 text-purple"></i> New Password
                </label>
                <input type="password" name="new_password" id="new_password" class="form-control form-control-lg rounded-3 fs-6" placeholder="Enter new password" required>
            </div>

            <!-- Confirm Password Input -->
            <div class="mb-4">
                <label for="confirm_password" class="form-label fw-semibold text-dark">
                    <i class="bi bi-check2-circle me-1 text-purple"></i> Confirm Password
                </label>
                <input type="password" name="confirm_password" id="confirm_password" class="form-control form-control-lg rounded-3 fs-6" placeholder="Confirm new password" required>
            </div>

            <!-- Action Buttons -->
            <div class="d-flex gap-2 pt-2">
                <!-- Submit Button -->
                <button type="submit" name="change_password" class="btn btn-purple rounded-3 px-4 py-2.5 fw-semibold shadow-sm">
                    <i class="bi bi-check-lg me-1"></i> Change Password
                </button>
                <!-- Back Link Button -->
                <a href="profile.php" class="btn btn-outline-purple rounded-3 px-4 py-2.5 fw-semibold">
                    <i class="bi bi-arrow-left me-1"></i> Back
                </a>
            </div>

        </form>
    </div>

</div>

<script src="../js/password.js"></script>
</body>
</html>