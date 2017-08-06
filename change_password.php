<?php
require('./includes/not_logged_in_redirect.inc.php');

$changed = false;
$error = false;
if (isset($_POST['curPwd']) && isset($_POST['newPwd']) && isset($_POST['rNewPwd'])){
	$currentPassword = $_POST['curPwd'];
	$newPword = $_POST['newPwd'];
	$rtypeNewPword = $_POST['rNewPwd'];
	$uid = $_SESSION['user_id'];

	if (strcmp($newPword, $rtypeNewPword) == 0){
		require_once("./includes/connection.inc.php");
		$conn = dbConnect('write');
		$results = $conn->query("SELECT password FROM users WHERE user_id = " . $uid . " AND con_code is NULL");
		if ($results->num_rows == 1 && password_verify($currentPassword, $results->fetch_assoc()["password"])){
			$sql = 'UPDATE users SET password = ? WHERE user_id = ?';
			$stmt = $conn->prepare($sql);
			$stmt->bind_param('sd', password_hash($newPword, PASSWORD_DEFAULT), $uid);
			$stmt->execute();
			if ($stmt->affected_rows == 1 || strcmp($currentPassword, $newPword) == 0) $changed = true;
			else {
				$error = true;
			}
		}
		else {
			$error = true;
		}
	}
	else{
		$error = true;
	}
}

$title = "Change Password | NEO";
require_once("./includes/template_begin.inc.php");
?>

<?php if (!$changed){ ?>
	<?php if ($error) echo "Invalid information."; ?>
	<br><form action="" method="post" id="chgPword" style="width: 300px;">
		<div class="form-group">
			<label for="pwd">Current Password:</label>
			<input type="password" name="curPwd" id="curPwd" class="form-control" required>
		</div>
		<div class="form-group">
			<label for="pwd">New Password:</label>
			<input type="password" name="newPwd" id="newPwd" class="form-control" required>
		</div>
		<div class="form-group">
			<label for="pwd">Retype New Password:</label>
			<input type="password" name="rNewPwd" id="rNewPwd" class="form-control" required>
		</div>
		<button type="submit" class="btn btn-success" name="changePword" id="changePword">Change Password</button>
	</form>
<?php } else { ?>
	<h2>You have successfully changed your password.<br><a href="#" onclick="self.close()">Close window.</a></h2>
<?php } ?>

<?php
require_once("./includes/template_end.inc.php");
?>
