<?php
// 1. Start current session
session_start();

// 2. Clear all session variables
$_SESSION = array();

// 3. Destroy session cookie if exists
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(
        session_name(),
        '',
        time() - 42000,
        $params["path"],
        $params["domain"],
        $params["secure"],
        $params["httponly"]
    );
}

// 4. Destroy the session completely
session_destroy();

// 5. Redirect back to login page
header("Location: ../view/login.php");
exit();
?>