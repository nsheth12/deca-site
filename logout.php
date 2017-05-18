<?php
require_once('./includes/not_logged_in_redirect.inc.php');
require_once('./includes/update_login_logout_log.inc.php');
require_once('./includes/connection.inc.php');

$conn = dbConnect('write');
updateLoginLogout($conn, $_SESSION['user_id'], false);

$_SESSION = array();
if (isset($_COOKIE[session_name()])) {
	setcookie(session_name(), '', time()-86400, '/');
}
session_destroy();
header('Location: index.php');
exit;
