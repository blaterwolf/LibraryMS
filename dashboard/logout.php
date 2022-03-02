<?php
session_start();
$_SESSION = array();
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(
        session_name(),
        '',
        time() - 60 * 60,
        $params["path"],
        $params["domain"],
        $params["secure"],
        $params["httponly"]
    );
}
// >> Make an if statement where in you will unset on the admin_login session and the student_login session
unset($_SESSION['admin_login']);
session_destroy(); // destroy session
header("Location: ../index.php");