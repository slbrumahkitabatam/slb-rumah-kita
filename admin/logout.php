<?php
require_once '../config/database.php';

// Destroy session properly
$_SESSION = array();
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie('SLB_SESSION_ID', '', time() - 42000, $params["path"], $params["domain"], $params["secure"], $params["httponly"]);
}
session_destroy();

header('Location: login.php');
exit;
?>
