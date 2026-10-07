<?php
// 1. Include database connection configuration
include "conn.php";

// 2. Fetch all student records ordered by ID
function getAllStudents()
{
    global $conn;

    $sql = "SELECT id, name, ic, marks FROM students ORDER BY id ASC";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_execute($stmt);
    
    return mysqli_stmt_get_result($stmt);
}

// 3. Fetch a single student record by ID for editing
function getStudentById($id)
{
    global $conn;

    $sql = "SELECT id, name, ic, marks FROM students WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    return mysqli_fetch_assoc($result);
}

// 4. Fetch student profile details for the logged-in student page
function getStudentProfile($id)
{
    global $conn;

    $sql = "SELECT id, name, ic, program, profile_pic FROM students WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    return mysqli_fetch_assoc($result);
}

// 5. Create a new student record with program and automatically generate a unique login account
function addStudent($name, $ic, $marks)
{
    global $conn;

    // Set default program value
    $default_program = "Diploma Teknologi Maklumat";

    // Insert student record into students table
    $sql = "INSERT INTO students (name, ic, program, marks) VALUES (?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "sssi", $name, $ic, $default_program, $marks);

    if (mysqli_stmt_execute($stmt)) {
        // Retrieve generated student ID
        $student_id = mysqli_insert_id($conn);

        // Process name parts for username generation
        $name_parts = explode(' ', trim($name));
        $first_word = strtolower($name_parts[0]);

        // Handle common prefix 'nurul' by appending the second name if available
        if ($first_word === 'nurul' && isset($name_parts[1])) {
            $base_username = $first_word . strtolower($name_parts[1]);
        } else {
            $base_username = $first_word;
        }

        // Clean username from special characters
        $base_username = preg_replace('/[^a-z0-9]/', '', $base_username);
        $username = $base_username;

        // Ensure username uniqueness in database
        $count = 1;
        while (true) {
            $check_sql = "SELECT id FROM users WHERE username = ?";
            $check_stmt = mysqli_prepare($conn, $check_sql);
            mysqli_stmt_bind_param($check_stmt, "s", $username);
            mysqli_stmt_execute($check_stmt);
            $check_res = mysqli_stmt_get_result($check_stmt);

            if (mysqli_num_rows($check_res) == 0) {
                break; // Username is unique
            }

            // Append number if username already exists
            $username = $base_username . $count;
            $count++;
        }

        // Generate default password '123456'
        $hashed_password = password_hash("123456", PASSWORD_DEFAULT);

        // Insert login credentials into users table
        $sql_user = "INSERT INTO users (username, password, student_id) VALUES (?, ?, ?)";
        $stmt_user = mysqli_prepare($conn, $sql_user);
        mysqli_stmt_bind_param($stmt_user, "ssi", $username, $hashed_password, $student_id);

        return mysqli_stmt_execute($stmt_user);
    }

    return false;
}

// 6. Update existing student information in the database
function updateStudent($id, $name, $ic, $marks)
{
    global $conn;

    $sql = "UPDATE students SET name = ?, ic = ?, marks = ? WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ssii", $name, $ic, $marks, $id);

    return mysqli_stmt_execute($stmt);
}

// 7. Permanently delete student record and associated user login account using database transactions
function deleteStudent($id)
{
    global $conn;

    mysqli_begin_transaction($conn);

    try {
        // Delete associated user login account first
        $sql = "DELETE FROM users WHERE student_id = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "i", $id);
        mysqli_stmt_execute($stmt);

        // Delete student profile record
        $sql = "DELETE FROM students WHERE id = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "i", $id);
        mysqli_stmt_execute($stmt);

        mysqli_commit($conn);
        return true;
    } catch (Exception $e) {
        mysqli_rollback($conn);
        return false;
    }
}

// 8. Update profile picture filename for the logged-in student
function updateProfilePic($student_id, $filename)
{
    global $conn;

    $sql = "UPDATE students SET profile_pic = ? WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "si", $filename, $student_id);

    return mysqli_stmt_execute($stmt);
}
?>