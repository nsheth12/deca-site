<?php
session_start();
if (!isset($_SESSION['user_id']) || !is_numeric($_SESSION['user_id'])){
	header('Location: login.php');
	exit;
}