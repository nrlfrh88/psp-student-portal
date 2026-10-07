<?php
// 1. Initialize session tracking
session_start();

// 2. Include user model for password database queries
include "../model/user_model.php";

// 3. Verify user session authorization
if (!isset($_SESSION["student_id"])) {
    header("Location: ../view/login.php");
    exit();
}

// 4. Verify form submit action
if (!isset($_POST["change_password"])) {
    header("Location: ../view/change_password.php");
    exit();
}

// 5. Retrieve form inputs and session student ID
$student_id = $_SESSION["student_id"];
$old_password = $_POST["old_password"] ?? "";
$new_password = $_POST["new_password"] ?? "";
$confirm_password = $_POST["confirm_password"] ?? "";

// 6. Server-side validation for empty password fields
if ($old_password === "" || $new_password === "" || $confirm_password === "") {
    header("Location: ../view/change_password.php?error=empty");
    exit();
}

// 7. Verify new password and confirm password alignment
if ($new_password !== $confirm_password) {
    header("Location: ../view/change_password.php?error=mismatch");
    exit();
}

// 8. Ensure new password is distinct from old password
if ($old_password === $new_password) {
    header("Location: ../view/change_password.php?error=same");
    exit();
}

// 9. Fetch existing user credentials by student ID
$user = getUserByStudentId($student_id);

if (!$user) {
    header("Location: ../view/change_password.php?error=user");
    exit();
}

// 10. Verify submitted old password against stored database hash
if (!password_verify($old_password, $user["password"])) {
    header("Location: ../view/change_password.php?error=old");
    exit();
}

// 11. Hash new password using Bcrypt algorithm
$hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

// 12. Execute password update operation in database
if (updatePassword($student_id, $hashed_password)) {
    header("Location: ../view/change_password.php?success=1");
    exit();
} else {
    header("Location: ../view/change_password.php?error=failed");
    exit();
}
?>