// 1. Client-side form validation for Add and Edit student forms
function validateStudentForm() {
    let name = document.getElementById("name").value.trim();
    let ic = document.getElementById("ic").value.trim();
    let marks = document.getElementById("marks").value.trim();

    // Check for empty fields
    if (name === "" || ic === "" || marks === "") {
        alert("Please fill in all required fields.");
        return false;
    }

    // Validate marks range (0 - 100)
    if (isNaN(marks) || marks < 0 || marks > 100) {
        alert("Marks must be a valid number between 0 and 100.");
        return false;
    }

    return true;
}

// 2. Confirmation prompt dialog before deleting a student record
function confirmDelete() {
    return confirm("Are you sure you want to permanently delete this student record?");
}