<?php
require('./includes/not_logged_in_redirect.inc.php');

$title = "Problem History | NEO";
require_once("./includes/template_begin.inc.php");

$uid = $_SESSION['user_id'];
require_once('./includes/past_problems.inc.php');

require_once("./includes/template_end.inc.php");
?>
