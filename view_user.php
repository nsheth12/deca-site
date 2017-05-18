<?php
require_once('./includes/admin_redirect.inc.php');
require_once('./includes/connection.inc.php');
require_once("./includes/cluster_utilities.inc.php");

$conn = dbConnect('read');
$noResult = false;
$uid = 0;
$user = null;

if (isset($_GET['dataType']) && isset($_GET['firstName']) && isset($_GET['lastName'])){
	$sql = 'SELECT * FROM users WHERE con_code IS NULL AND first_name = "' . trim(strtolower($_GET['firstName'])) . '" AND last_name = "' . trim(strtolower($_GET['lastName'])) . '"';
	$result = $conn->query($sql);
	if ($result->num_rows == 0) $noResult = true;
	else{
		$user = $result->fetch_assoc();
		$uid = $user['user_id'];
	}
}
else if (isset($_GET['dataType']) && isset($_GET['email'])){
	$sql = 'SELECT * FROM users WHERE con_code IS NULL AND email = "' . $_GET['email'] . '"';
	$result = $conn->query($sql);
	if ($result->num_rows == 0) $noResult = true;
	else{
		$user = $result->fetch_assoc();
		$uid = $user['user_id'];
	}
}
else{
	header('Location: admin_report.php');
	exit;
}

$title = "Student Info | NEO";
require_once('./includes/template_begin.inc.php');

if ($noResult){
	echo '<h2>No students match your search.</h2>';
}
else{
	if ($_GET['dataType'] == 'report') {
		require_once('./includes/user_meta_data.inc.php');
		require_once('./includes/report.inc.php');
	}
	else {
		require_once('./includes/user_meta_data.inc.php');
		require_once('./includes/past_problems.inc.php');
	}
}

require_once('./includes/template_end.inc.php');
?>
