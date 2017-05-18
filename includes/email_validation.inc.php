<?php
require_once($_SERVER['DOCUMENT_ROOT'] . "/includes/connection.inc.php");

function checkIfEmailCanBeUsed ($email) {
	$emails = file('./private/valid_emails.txt');
	for ($i = 0; $i < count($emails); $i++){
		if (strcasecmp($email, trim($emails[$i])) == 0) return true;
	}
	return false;
}

function ensureEmailDoesNotAlreadyExist ($email){
	$conn = dbConnect('read');
	$sql = "SELECT email FROM users WHERE email = ? AND con_code IS NULL";
	$stmt = $conn->stmt_init();
	$stmt->prepare($sql);
	$stmt->bind_param('s', $email);
	$stmt->execute();
	$stmt->store_result();
	if ($stmt->num_rows > 0) return false;
	return true;
}

function isValidEmail ($email){
	//$pattern = '/Content-Type:|Bcc:|CC:/i';

	if (!filter_var($email, FILTER_VALIDATE_EMAIL)) return false;
	return true;
}
