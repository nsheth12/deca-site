<?php
require('./includes/not_logged_in_redirect.inc.php');
require_once("./includes/connection.inc.php");
require_once('./includes/admin_validation.inc.php');

function redirectBack (){
	header('Location: past_problems.php');
	exit;
}

$conn = dbConnect('read');
$solved = true;

if (!isset($_POST['vpi']) || !is_numeric($_POST['vpi'])) redirectBack();

$vpi = $_POST['vpi'];

if (!isAdmin($_SESSION['user_id'])){
	$sql = 'SELECT * FROM attempts WHERE user_id = ' . $_SESSION['user_id'] . ' AND problem_id = ' . $vpi;
	$result = $conn->query($sql);

	if ($result->num_rows == 0) redirectBack();
	$resultRow = $result->fetch_assoc();
	if ($resultRow['solved'] == 0) $solved = false;
}

$problemSql = 'SELECT * FROM problems WHERE problem_id = ' . $vpi;
$problemResult = $conn->query($problemSql);
$problemRow = $problemResult->fetch_assoc();

$title = "View Problem | NEO";
require_once("./includes/template_begin.inc.php");

require_once("./includes/view_problem.inc.php");

require_once("./includes/template_end.inc.php");
?>
