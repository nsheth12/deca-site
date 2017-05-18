<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
	<link rel="icon" type="image/png" href="assets/favicon-16x16.png" sizes="16x16" />

	<title><?php echo $title; ?></title>

	<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" rel="stylesheet">
	<link href="./style/jumbotron-narrow.css" rel="stylesheet">
	<link href="./style/sticky-footer.css" rel="stylesheet">
	<link href="./style/theme.default.css" rel="stylesheet">
	<link href="./style/site.css" rel="stylesheet">

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
	<script src="https://cdn.jsdelivr.net/tablesorter/2.28.9/js/jquery.tablesorter.min.js"></script>
	<script src="https://cdn.jsdelivr.net/tablesorter/2.28.9/js/extras/jquery.tablesorter.pager.min.js"></script>

	<script type="text/javascript">
		$(function() {
			$("#problemsTable")
				.tablesorter({theme: 'default', widthFixed: false, sortList: [[0, 0]]})
				.tablesorterPager({container: $("#pager")});
		});
	</script>

	<?php if (strcmp(basename($_SERVER['SCRIPT_FILENAME']), 'view_all_problems.php') == 0){ ?>
		<script type="text/javascript">
			$(window).load(function() {
				document.title = 'View All Problems | NEO';
				$(".loader").fadeOut("slow");
			})
		</script>
	<?php } ?>
	<?php require_once("./includes/analyticstracking.inc.php"); ?>
</head>
<body>
	<?php
	if (!isset($_SESSION['user_id']) || !is_numeric($_SESSION['user_id'])){
		require_once("navbar_not_logged_in.inc.php");
	}
	else{
		require_once("navbar_logged_in.inc.php");
	}
	?>
	<div class="container">
