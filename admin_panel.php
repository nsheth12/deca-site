<?php
require_once('./includes/admin_redirect.inc.php');
require_once('./includes/connection.inc.php');

$successfulReset = false;
$unsuccessfulReset = false;

if (isset($_POST["reset"])) {
	$conn = dbConnect("write");
	$sql = "TRUNCATE TABLE attempts;";
	$sql .= "TRUNCATE TABLE login_logout;";
	$sql .= "TRUNCATE TABLE valid_emails;";
	$sql .= "DELETE FROM users WHERE user_id <> 314 AND user_id <> 316;";

	if ($conn->multi_query($sql)) {
		$successfulReset = true;
	}
	else {
		$unsuccessfulReset = true;
	}
}

$title = "Administrator Panel | NEO";
require_once("./includes/template_begin.inc.php");
?>

<?php if ($successfulReset) echo "Successful reset"; ?>
<?php if ($unsuccessfulReset) echo "There was an error in the end-of-year reset"; ?>
<p>
	<form method="post" action="">
		<label>Use this option to add valid emails to the NEO system:</label><br>
		<a href="add_valid_email.php" class="btn btn-default">Add Valid Emails</a><br><br>

		<label for="reset">This will reset all accounts, except for yours. Only do this at the end of each school year:</label>
		<button type="submit" name="reset" id="reset" class="btn btn-danger">End-of-Year Reset (Cannot be Undone)</button>
	</form>
</p>

<?php
require_once("./includes/template_end.inc.php");
?>