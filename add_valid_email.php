<?php
require_once('./includes/admin_redirect.inc.php');
require_once('./includes/connection.inc.php');

$addedEmails = false;

if (isset($_POST["submit"])) {
	$emails_list = $_POST["emails"];
	$emails_list = str_replace(" ", "\r\n", $emails_list); //replace spaces with newlines, just in case user makes an input error
	$emails_list = str_replace(",", "\r\n", $emails_list); //replace commas with newlines, same reason
	$emails_to_add = explode("\r\n", $emails_list);
	$conn = dbConnect("write");
	$sql = "INSERT INTO valid_emails (email) VALUES (?)";
	foreach ($emails_to_add as $key => $value) {
		$trimmed_email = strtolower(trim($value));
		$stmt = $conn->stmt_init();
		$stmt->prepare($sql);
		$stmt->bind_param('s', $trimmed_email);
		$stmt->execute();
	}
	$addedEmails = true;	
}

$title = "Add Valid Emails | NEO";
require_once("./includes/template_begin.inc.php");
?>

<?php if ($addedEmails) echo "Emails have been added successfully."; ?>
<form id = "add_emails" method = "post" action = "">
<p>
	<label for="emails">Input emails, one per line:</label><br>
	<textarea name="emails" id="emails" rows="10" cols="60"></textarea>
</p>
<p>
	<input name="submit" type="submit" value="Add Emails">
</p>
</form>

<?php
require_once("./includes/template_end.inc.php");
?>