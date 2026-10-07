<?php
// 1. Get status notification from query string
$error = $_GET["error"] ?? "";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>PSP Student Portal - Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <!-- External Custom CSS -->
    <link rel="stylesheet" href="../css/style.css">
</head>
<body class="py-5">

<div class="container" style="max-width: 480px;">

    <!-- Login Card Container -->
    <div class="card card-custom bg-white p-4 p-md-5 shadow-lg">

        <!-- Header & Icon -->
        <div class="text-center mb-4">
            <div class="d-inline-flex align-items-center justify-content-center p-3 bg-light rounded-circle text-purple mb-3">
                <i class="bi bi-mortarboard-fill fs-1"></i>
            </div>
            <h2 class="fw-bold text-dark mb-1">PSP Student Portal</h2>
            <p class="text-muted small mb-0">Sign in to access your student account</p>
        </div>

        <!-- Alert Notifications -->
        <?php if ($error === "empty") { ?>
            <div class="alert alert-danger alert-dismissible fade show rounded-3 shadow-sm" role="alert">
                <i class="bi bi-exclamation-triangle-fill me-2"></i> Please enter your username and password.
            </div>
        <?php } ?>

        <?php if ($error === "invalid") { ?>
            <div class="alert alert-danger alert-dismissible fade show rounded-3 shadow-sm" role="alert">
                <i class="bi bi-x-circle-fill me-2"></i> Invalid username or password.
            </div>
        <?php } ?>

        <!-- Login Form -->
        <form action="../controller/login_controller.php" method="POST">

            <!-- Username Input -->
            <div class="mb-3">
                <label for="username" class="form-label fw-semibold text-dark">
                    <i class="bi bi-person-fill me-1 text-purple"></i> Username
                </label>
                <input type="text" name="username" id="username" class="form-control form-control-lg rounded-3 fs-6" placeholder="Enter your username" required>
            </div>

            <!-- Password Input -->
            <div class="mb-4">
                <label for="password" class="form-label fw-semibold text-dark">
                    <i class="bi bi-lock-fill me-1 text-purple"></i> Password
                </label>
                <input type="password" name="password" id="password" class="form-control form-control-lg rounded-3 fs-6" placeholder="Enter your password" required>
            </div>

            <!-- Submit Button -->
            <button type="submit" name="login" class="btn btn-purple btn-lg w-100 rounded-3 fw-semibold shadow-sm py-2.5">
                <i class="bi bi-box-arrow-in-right me-2"></i> Login
            </button>

        </form>

    </div>

</div>

</body>
</html>