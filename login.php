<?php
require("./includes/logged_in_redirect.inc.php");
require_once('./includes/update_login_logout_log.inc.php');

$error = "";
if (isset($_POST['email']) && isset($_POST['pwd'])){
	require_once("./includes/connection.inc.php");

	$email = $_POST["email"];
	$pwd = $_POST["pwd"];

	$conn = dbConnect("read");
	$sql = "SELECT user_id, password FROM users WHERE email = ? AND con_code IS NULL";
	$stmt = $conn->stmt_init();
	$stmt->prepare($sql);
	$stmt->bind_param('s', $email);
	$stmt->bind_result($user_id, $hashed_password);
	$stmt->execute();
	$stmt->store_result();
	if ($stmt->num_rows == 1){
		$stmt->fetch();
		if (password_verify($pwd, $hashed_password)){
			$_SESSION['user_id'] = $user_id;
			updateLoginLogout($conn, $user_id, true);
			header('Location: get_problem.php');
			exit;
		}
		else{
			$error = "Incorrect password.";
		}
	}
	else{
		$error = "Email address entered does not correspond to a valid account.";
	}
}

$title = "Login | NEO";
require_once("./includes/template_begin.inc.php");
?>
<div class="row" style="margin-top: 3px;">
	<div class="col-xs-0 col-md-2"></div>
	<div class="col-xs-12 col-md-8">
		<div class="jumbotron" style="padding-top: 12px;">
			<h2>Login</h2>
			<?php if ($error != ""){?><p><?php echo($error);?></p><?php } ?>
			<form action="" method="post" id="form1" style="margin-left: 10px; margin-right: 10px;">
				<div class="form-group">
					<label for="email">Email:</label>
					<input type="text" name="email" id="email" class="form-control" required autofocus>
				</div>
				<div class="form-group">
					<label for="pwd">Password:</label>
					<input type="password" name="pwd" id="pwd" class="form-control" required>
				</div>
				<button type="submit" class="btn btn-success btn-block" name="login" id="login" style="padding: 5px 0px; font-size: 18px;">Login</button>
				<br><a href="forgot_password.php">Forgot Password?</a>
			</form>
		</div>
	</div>
	<div class="col-xs-0 col-md-2"></div>
</div>

<?php
require_once("./includes/template_end.inc.php");
?>
