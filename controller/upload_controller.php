<?php
// 1. Initialize user session
session_start();

// 2. Include student model for database functions
include "../model/student_model.php";

// 3. Student must be logged in
if (!isset($_SESSION["student_id"])) {
    header("Location: ../view/login.php");
    exit();
}

// 4. Make sure the upload form was submitted
if (!isset($_POST["upload"])) {
    header("Location: ../view/profile.php");
    exit();
}

// 5. Get active student ID from session (not from the form)
$student_id = $_SESSION["student_id"];
$file = $_FILES["profile_pic"] ?? null;

// 6. Check that a file was actually chosen
if ($file === null || $file["error"] !== UPLOAD_ERR_OK) {
    header("Location: ../view/profile.php?upload=empty");
    exit();
}

// 7. Validate file type: only jpg, jpeg and png
$ext = strtolower(pathinfo($file["name"], PATHINFO_EXTENSION));
$allowed = array("jpg", "jpeg", "png");

if (!in_array($ext, $allowed)) {
    header("Location: ../view/profile.php?upload=type");
    exit();
}

// 8. Validate that the file is a real image (not a renamed fake file)
if (getimagesize($file["tmp_name"]) === false) {
    header("Location: ../view/profile.php?upload=type");
    exit();
}

// 9. Validate file size: maximum 2MB
$max_size = 2 * 1024 * 1024;

if ($file["size"] > $max_size) {
    header("Location: ../view/profile.php?upload=size");
    exit();
}

// 10. Secure rename using uniqid() to prevent overwriting
$new_name = uniqid("psp_") . "." . $ext;

// 11. Delete old picture (if any) to keep the uploads folder clean
$student = getStudentProfile($student_id);
if (!empty($student["profile_pic"])) {
    $old_file = "../uploads/" . $student["profile_pic"];
    if (file_exists($old_file)) {
        unlink($old_file);
    }
}

// 12. Move uploaded file and save the filename in the database
if (move_uploaded_file($file["tmp_name"], "../uploads/" . $new_name)) {
    updateProfilePic($student_id, $new_name);
    header("Location: ../view/profile.php?upload=success");
} else {
    header("Location: ../view/profile.php?upload=fail");
}
exit();
?>