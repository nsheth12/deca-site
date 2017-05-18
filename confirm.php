<?php
require_once('./includes/connection.inc.php');
$success = false;

if (isset($_GET['passkey'])){
	$conn = dbConnect('write');
	$sql = 'UPDATE users SET con_code = NULL WHERE con_code = ?';
	$stmt = $conn->stmt_init();
	$stmt->prepare($sql);
	$passkey = $_GET['passkey'];
	$stmt->bind_param('s', $passkey);
	if ($stmt->execute()) $success = true;
}
?>
<!DOCTYPE HTML>
<html>
<head>
	<title>Confirm your Email Address</title>
</head>
<body>
	<?php if ($success) { ?>
		<h1>Thanks for registering! You can log in <a href="login.php">here</a>.</h1>
	<?php } else { ?>
		<h1>Looks like you're on the wrong page! You can register <a href="register.php">here</a>.</h1>
	<?php } ?>
</body>
</html>