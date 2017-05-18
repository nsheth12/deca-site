<?php
require('./includes/not_logged_in_redirect.inc.php');

if (!isset($_POST['pid'])){
	header('Location: login.php');
	exit;
}
?>
<!DOCTYPE HTML>
<html>
<head>
	<title>Report Error</title>
	<link rel="icon" type="image/png" href="assets/favicon-16x16.png" sizes="16x16" />
	<link href="./style/bootstrap.min.css" rel="stylesheet">
	<script type="text/javascript" src="./js/problem_error.js"></script>

	<style>
		body {
			padding-top: 10px;
			padding-left: 10px;
		}
	</style>
</head>
<body>
	<div id = "errorDiv">
			<textarea rows = "4" cols = "30" id="errorDescription" placeholder="Please describe the issue."></textarea><br>
			<button id="reportError" class="btn btn-default" onclick="process(<?php echo ($_POST['pid'] . ','  . $_SESSION['user_id']);?>)">Report Error</button>
	</div>
</body>
</html>
