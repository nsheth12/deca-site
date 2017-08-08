<?php
session_start();

if (isset($_POST['register'])){
	require_once('./includes/email_validation.inc.php');
	$email = trim(strtolower($_POST['email']));
	$pwd = $_POST['pwd'];
	$conf_pwd = $_POST['conf_pwd'];
	if ($pwd != $conf_pwd || $pwd == ''){
		$_SESSION['error']['password'] = "Passwords do not match.";
	}

	if (!isValidEmail($email)){
		$_SESSION['error']['email'] = "Invalid email.";
	}
	else{
		if (!checkIfEmailCanBeUsed($email)){
			$_SESSION['error']['email'] = "Not a WA DECA email.";
		}
		else{
			if (!ensureEmailDoesNotAlreadyExist($email)){
				$_SESSION['error']['email'] = "Email already registered.";
			}
		}
	}
}
else{
	$_SESSION['error'] = "Please register";
}

if (isset($_SESSION['error'])){
	header('Location: register.php');
	exit;
}
else{
	require_once('./includes/connection.inc.php');
	$con_code = md5(uniqid(rand()));
	$conn = dbConnect('write');
	$sql = "INSERT INTO users (email, password, con_code, cluster_id, problem_on_id, first_name, last_name) VALUES (?, ?, ?, ?, ?, ?, ?)";
	$stmt = $conn->stmt_init();
	$stmt->prepare($sql);
	$cluster = (int)($_POST['cluster']);
	$problem_on_init = NULL;
	$firstName = trim(strtolower($_POST['firstName']));
	$lastName = trim(strtolower($_POST['lastName']));
	$hashed_pwd = password_hash($pwd, PASSWORD_DEFAULT);
	$stmt->bind_param('sssddss', $email, $hashed_pwd, $con_code, $cluster, $problem_on_init, $firstName, $lastName);
	$stmt->execute();

	$subject = "NEO Registration Confirmation for $email";
	$message = "Please click the following link to confirm: http://wadecatraining.org/confirm.php?passkey=$con_code";
	$sentmail = mail($email, $subject, $message);
}
?>
<!DOCTYPE HTML>
<html>
<head>
	<title>Registration Confirmation</title>
</head>
<body>
	<p>A confirmation email has been sent to the email address you indicated. It may take a few minutes to arrive, so please be patient. If after some time you still have not received the email, check your junk/spam folder, and search for an email from "www-data@wadecatraining.org".</p>
	<p><a href="register.php">Go back</a></p>
</body>
</html>
