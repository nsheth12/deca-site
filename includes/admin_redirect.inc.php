<?php
session_start();
require_once('admin_validation.inc.php');

if (!isset($_SESSION['user_id']) || !isAdmin($_SESSION['user_id'])){
	header('Location: index.php');
	exit;
}
