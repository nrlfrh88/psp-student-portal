<?php
// Include student model for database operations
include "../model/student_model.php";

// Process create student request
if (isset($_POST["add"])) {
    $name = trim($_POST["name"] ?? "");
    $ic = trim($_POST["ic"] ?? "");
    $marks = $_POST["marks"] ?? "";

    // Validate required fields
    if ($name === "" || $ic === "" || $marks === "") {
        header("Location: ../view/add_student.php?error=empty");
        exit();
    }

    // Validate marks range between 0 and 100
    if (!is_numeric($marks) || $marks < 0 || $marks > 100) {
        header("Location: ../view/add_student.php?error=marks");
        exit();
    }

    // Execute student insertion into database
    if (addStudent($name, $ic, $marks)) {
        header("Location: ../view/student.php?success=add");
        exit();
    } else {
        header("Location: ../view/add_student.php?error=failed");
        exit();
    }
}

// Process update student request
if (isset($_POST["update"])) {
    $id = $_POST["id"] ?? "";
    $name = trim($_POST["name"] ?? "");
    $ic = trim($_POST["ic"] ?? "");
    $marks = $_POST["marks"] ?? "";

    // Validate student ID
    if (!is_numeric($id) || $id <= 0) {
        header("Location: ../view/student.php?error=invalid");
        exit();
    }

    // Validate required fields
    if ($name === "" || $ic === "" || $marks === "") {
        header("Location: ../view/edit_student.php?id=$id&error=empty");
        exit();
    }

    // Validate marks range between 0 and 100
    if (!is_numeric($marks) || $marks < 0 || $marks > 100) {
        header("Location: ../view/edit_student.php?id=$id&error=marks");
        exit();
    }

    // Execute student record update in database
    if (updateStudent($id, $name, $ic, $marks)) {
        header("Location: ../view/student.php?success=update");
        exit();
    } else {
        header("Location: ../view/edit_student.php?id=$id&error=failed");
        exit();
    }
}

// Process delete student request
if (isset($_POST["delete"])) {
    $id = $_POST["id"] ?? "";

    // Validate student ID
    if (!is_numeric($id) || $id <= 0) {
        header("Location: ../view/student.php?error=invalid");
        exit();
    }

    // Execute student record deletion from database
    if (deleteStudent($id)) {
        header("Location: ../view/student.php?success=delete");
        exit();
    } else {
        header("Location: ../view/student.php?error=delete");
        exit();
    }
}

// Default redirect for direct controller access
header("Location: ../view/student.php");
exit();
?>