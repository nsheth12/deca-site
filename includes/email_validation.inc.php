<?php
require_once(__DIR__ . "/connection.inc.php");

//$email has already been trimmed and lowercased when passed in
function checkIfEmailCanBeUsed ($email) {
	$conn = dbConnect("read");
	$sql = "SELECT email FROM valid_emails WHERE email = ?";
	$stmt = $conn->stmt_init();
	$stmt->prepare($sql);
	$stmt->bind_param('s', $email);
	$stmt->execute();
	$stmt->store_result();
	if ($stmt->num_rows > 0) return true;
	return false;
}

//$email has already been trimmed and lowercased when passed in
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
