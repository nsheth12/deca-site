<?php
require("./includes/logged_in_redirect.inc.php");
require_once('./includes/update_login_logout_log.inc.php');

$error = false;
if (isset($_POST['email']) && isset($_POST['pwd'])){
	require_once("./includes/connection.inc.php");

	$email = $_POST["email"];
	$pwd = $_POST["pwd"];

	$conn = dbConnect("read");
	$sql = "SELECT user_id FROM users WHERE email = ? AND password = ? AND con_code IS NULL";
	$stmt = $conn->stmt_init();
	$stmt->prepare($sql);
	$stmt->bind_param('ss', $email, $pwd);
	$stmt->bind_result($user_id);
	$stmt->execute();
	$stmt->store_result();
	if ($stmt->num_rows == 1){
		$stmt->fetch();
		$_SESSION['user_id'] = $user_id;
		updateLoginLogout($conn, $user_id, true);
		header('Location: get_problem.php');
		exit;
	}
	else{
		$error = true;
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
			<?php if ($error){?><p>Invalid login</p><?php } ?>
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
