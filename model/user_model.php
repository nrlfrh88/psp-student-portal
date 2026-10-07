<?php
// Include database connection configuration
include "conn.php";

// Fetch user account details by username
function getUserByUsername($username)
{
    global $conn;
    $sql = "SELECT id, username, password, student_id FROM users WHERE username = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "s", $username);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    return mysqli_fetch_assoc($result);
}

// Fetch user account details by student ID
function getUserByStudentId($student_id)
{
    global $conn;
    $sql = "SELECT id, username, password, student_id FROM users WHERE student_id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $student_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    return mysqli_fetch_assoc($result);
}

// Update user password hash in database
function updatePassword($student_id, $hashed_password)
{
    global $conn;
    $sql = "UPDATE users SET password = ? WHERE student_id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "si", $hashed_password, $student_id);
    return mysqli_stmt_execute($stmt);
}
?>