<?php
session_start();

// 1. Check if student is logged in via session
if (!isset($_SESSION["student_id"])) {
    header("Location: login.php");
    exit();
}

// 2. Include student model for database operations
include "../model/student_model.php";

// 3. Get active student ID from session
$student_id = $_SESSION["student_id"];

// 4. Fetch student profile data using student ID
$student = getStudentProfile($student_id);

// 5. Check if profile record exists in database
if (!$student) {
    echo "Student profile not found.";
    exit();
}

// 6. Prepare profile picture path (empty if no picture yet)
$pic = "";
if (!empty($student["profile_pic"])) {
    $pic = "../uploads/" . $student["profile_pic"];
}

// 7. Prepare upload status message
$upload_msg = "";
$upload_class = "danger";
if (isset($_GET["upload"])) {
    if ($_GET["upload"] == "success") {
        $upload_msg = "Profile picture uploaded successfully.";
        $upload_class = "success";
    } elseif ($_GET["upload"] == "type") {
        $upload_msg = "Only JPG, JPEG and PNG images are allowed.";
    } elseif ($_GET["upload"] == "size") {
        $upload_msg = "File size must not exceed 2MB.";
    } elseif ($_GET["upload"] == "empty") {
        $upload_msg = "Please choose an image first.";
    } else {
        $upload_msg = "Upload failed. Please try again.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>My Profile - PSP Student Portal</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <!-- External Custom CSS -->
    <link rel="stylesheet" href="../css/style.css">
</head>
<body class="py-4">

<div class="container" style="max-width: 850px;">
    <!-- Top Navigation Bar -->
    <div class="card card-custom bg-white mb-4">
        <div class="card-body d-flex justify-content-between align-items-center py-3 px-4">
            <!-- Portal Header -->
            <div class="d-flex align-items-center gap-2">
                <div class="p-2 bg-light rounded-3 text-purple">
                    <i class="bi bi-mortarboard-fill fs-4"></i>
                </div>
                <span class="fw-bold text-dark fs-5">PSP Student Portal</span>
            </div>
            
            <!-- User Status & Logout Action -->
            <div class="d-flex align-items-center gap-2">
                <div class="badge bg-light text-dark border border-secondary-subtle px-3 py-2 rounded-pill font-monospace">
                    <i class="bi bi-person-circle text-purple me-1"></i> Welcome, <strong><?php echo htmlspecialchars($_SESSION["username"]); ?></strong>
                </div>
                <!-- Logout Button with Standard JS Confirm Alert -->
                <a href="../controller/logout_controller.php" onclick="return confirm('Are you sure you want to logout?');" class="btn btn-sm btn-outline-danger rounded-pill px-3 py-1.5 fw-semibold">
                    <i class="bi bi-box-arrow-right me-1"></i> Logout
                </a>
            </div>
        </div>
    </div>

    <!-- Student Profile Card -->
    <div class="card card-custom bg-white overflow-hidden">
        <!-- Card Header with Purple Gradient Styling -->
        <div class="card-header text-white p-4 border-0" style="background: linear-gradient(135deg, #7952b3 0%, #52279b 100%) !important;">
            <div class="d-flex align-items-center gap-3">
                <div class="profile-icon-box d-flex align-items-center justify-content-center">
                    <i class="bi bi-person-badge-fill fs-2"></i>
                </div>
                <div>
                    <h3 class="fw-bold mb-1 text-white">My Profile</h3>
                    <p class="mb-0 text-white-50 small">Student Personal Information & Academic Details</p>
                </div>
            </div>
        </div>

        <!-- Card Body -->
        <div class="card-body p-4">
            <!-- Upload status message -->
            <?php if ($upload_msg !== "") { ?>
                <div class="alert alert-<?php echo $upload_class; ?>"><?php echo $upload_msg; ?></div>
            <?php } ?>

            <!-- Profile picture -->
            <div class="text-center mb-4">
                <?php if ($pic !== "") { ?>
                    <img src="<?php echo htmlspecialchars($pic); ?>" alt="Profile Picture"
                         class="rounded-circle border mb-3" width="150" height="150" style="object-fit: cover;">
                <?php } else { ?>
                    <div class="mb-3"><i class="bi bi-person-circle text-secondary" style="font-size: 120px;"></i></div>
                <?php } ?>

                <!-- enctype is REQUIRED for file upload -->
                <form action="../controller/upload_controller.php" method="POST" enctype="multipart/form-data">
                    <input type="file" name="profile_pic" class="form-control mb-2" accept=".jpg,.jpeg,.png" required>
                    <button type="submit" name="upload" class="btn btn-purple rounded-3 px-4">
    <i class="bi bi-upload me-1"></i> Upload Profile Picture
</button>

<small class="text-muted d-block mt-2">
    JPG, JPEG or PNG only. Maximum file size: 2MB.
</small>
                </form>
            </div>

            <div class="mb-4">
                <!-- Student Name Row -->
                <div class="info-row d-flex justify-content-between align-items-center p-3">
                    <span class="text-muted fw-semibold"><i class="bi bi-person-fill me-2 text-purple fs-5"></i> Name</span>
                    <span class="fw-bold text-dark fs-6"><?php echo htmlspecialchars($student["name"]); ?></span>
                </div>
                <!-- Student NRIC Row -->
                <div class="info-row d-flex justify-content-between align-items-center p-3">
                    <span class="text-muted fw-semibold"><i class="bi bi-card-heading me-2 text-purple fs-5"></i> NRIC</span>
                    <span class="fw-bold text-dark fs-6"><?php echo htmlspecialchars($student["ic"]); ?></span>
                </div>
                <!-- Student Program Row -->
                <div class="info-row d-flex justify-content-between align-items-center p-3">
                    <span class="text-muted fw-semibold"><i class="bi bi-journal-bookmark-fill me-2 text-purple fs-5"></i> Program</span>
                    <span class="fw-bold text-dark fs-6"><?php echo htmlspecialchars($student["program"]); ?></span>
                </div>
            </div>

            <!-- Action Navigation Buttons -->
            <div class="d-flex flex-wrap gap-2 pt-2">
                <!-- Change Password Button -->
                <a href="change_password.php" class="btn btn-outline-purple rounded-3 px-4 py-2.5 fw-semibold">
                    <i class="bi bi-key-fill me-2"></i> Change Password
                </a>
                <!-- Student Records List Button -->
                <a href="student.php" class="btn btn-purple rounded-3 px-4 py-2.5 fw-semibold shadow-sm">
                    <i class="bi bi-people-fill me-2"></i> Student Records
                </a>
            </div>
        </div>
    </div>
</div>

</body>
</html>