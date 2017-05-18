<?php
require("./includes/not_logged_in_redirect.inc.php");

echo json_encode($_SESSION['user_id']);