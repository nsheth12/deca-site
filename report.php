<?php
require("./includes/not_logged_in_redirect.inc.php");

$uid = $_SESSION['user_id'];

$title = "Report | NEO";
require_once("./includes/template_begin.inc.php");

require_once('./includes/report.inc.php');
require_once('./includes/template_end.inc.php');
?>