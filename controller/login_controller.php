<?php
// 1. Initialize user session
session_start();

// 2. Include user model for authentication functions
include "../model/user_model.php";

// 3. Verify form submission request
if (!isset($_POST["login"])) {
    header("Location: ../view/login.php");
    exit();
}

// 4. Retrieve and sanitize login form inputs
$username = trim($_POST["username"] ?? "");
$password = $_POST["password"] ?? "";

// 5. Perform server-side empty field validation
if ($username === "" || $password === "") {
    header("Location: ../view/login.php?error=empty");
    exit();
}

// 6. Query user record from database by username
$user = getUserByUsername($username);

if (!$user) {
    header("Location: ../view/login.php?error=invalid");
    exit();
}

// 7. Verify submitted password against encrypted database hash
if (!password_verify($password, $user["password"])) {
    header("Location: ../view/login.php?error=invalid");
    exit();
}

// 8. Prevent session fixation attacks and store user details in session
session_regenerate_id(true);
$_SESSION["user_id"] = $user["id"];
$_SESSION["student_id"] = $user["student_id"];
$_SESSION["username"] = $user["username"];

// 9. Redirect authenticated user to profile page
header("Location: ../view/profile.php");
exit();
?>