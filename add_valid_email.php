<?php
//require_once('./includes/admin_redirect.inc.php');
require_once('./includes/connection.inc.php');

if (isset($_POST["submit"])) {
	$emails_to_add = explode("\r\n", $_POST["emails"]);
	$conn = dbConnect("write");
	$sql = "INSERT INTO valid_emails (email) VALUES (?)";
	foreach ($emails_to_add as $key => $value) {
		$trimmed_email = trim($value);
		$stmt = $conn->stmt_init();
		$stmt->prepare($sql);
		$stmt->bind_param('s', $trimmed_email);
		$stmt->execute();
	}	
}

?>

<form id = "add_emails" method = "post" action = "">
<p>
	<label for="emails">Input emails, one per line:</label><br>
	<textarea name="emails" id="emails" rows="20" cols="30"></textarea>
</p>
<p>
	<input name="submit" type="submit" value="Add Emails">
</p>
</form>