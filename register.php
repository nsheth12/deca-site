<?php
require("./includes/logged_in_redirect.inc.php");

$title = "Register | NEO";
require_once("./includes/template_begin.inc.php");

if(isset($_SESSION['error'])) {
	if (isset($_SESSION['error']['email'])){
		echo '<p><font color="red">'.$_SESSION['error']['email'].'</font></p>';
	}
	if (isset($_SESSION['error']['password'])){
		echo '<p><font color="red">'.$_SESSION['error']['password'].'</font></p>';
	}
	unset($_SESSION['error']);
}
?>

<div class="row" style="margin-top: 3px;">
	<div class="col-xs-0 col-md-2"></div>
	<div class="col-xs-12 col-md-8">
		<div class="jumbotron" style="padding-top:12px;">
			<h2>Register</h2>
			<form action="registration_confirmation.php" method="post" id="form1" style="margin-left: 10px; margin-right: 10px;">
				<div class="form-group">
					<label for="firstName">First Name:</label>
					<input type="text" name="firstName" id="firstName" class="form-control" required>
				</div>
				<div class="form-group">
					<label for="lastName">Last Name:</label>
					<input type="text" name="lastName" id="lastName" class="form-control" required>
				</div>
				<div class="form-group">
					<label for="email">Email:</label>
					<input type="text" name="email" id="email" class="form-control" required>
				</div>
				<div class="form-group">
					<label for="pwd">Password:</label>
					<input type="password" name="pwd" id="pwd" class="form-control" required>
				</div>
				<div class="form-group">
					<label for="conf_pwd">Retype Password:</label>
					<input type="password" name="conf_pwd" id="conf_pwd" class="form-control" required>
				</div>
				<div class="form-group">
					<label for="cluster">Cluster:</label>
					<select name="cluster" id="cluster" class="form-control">
						<option value="1">Marketing</option>
						<option value="2">Finance</option>
						<option value="3">Hospitality &amp; Tourism</option>
						<option value="4">Business Management and Administration</option>
						<option value="5">Principles</option>
					</select>
				</div>
				<button type="submit" name="register" id="register" class="btn btn-success btn-block" style="margin-top: 10px; padding: 5px 0px; font-size: 18px;">Register</button>
				<!--<a href="login.php">Login</a>-->
			</form>
		</div>
	</div>
	<div class="col-xs-0 col-md-2"></div>
</div>
<?php
require_once("./includes/template_end.inc.php");
?>
