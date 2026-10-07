// 1. Client-side validation for change password form
function validatePasswordForm() {
    let oldPassword = document.getElementById("old_password").value;
    let newPassword = document.getElementById("new_password").value;
    let confirmPassword = document.getElementById("confirm_password").value;

    // Check if any field is empty
    if (oldPassword === "" || newPassword === "" || confirmPassword === "") {
        alert("Please fill in all password fields.");
        return false;
    }

    // Verify if new password matches confirm password
    if (newPassword !== confirmPassword) {
        alert("New password and confirm password do not match.");
        return false;
    }

    // Ensure new password differs from old password
    if (oldPassword === newPassword) {
        alert("New password must be different from old password.");
        return false;
    }

    return true;
}