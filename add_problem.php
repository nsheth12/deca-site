<?php

function checkPasswordValidity ($pword) {
	$pwords = file('./private/adp_passwords.txt');
	for ($i = 0; $i < count($pwords); $i++){
		if ($pword == trim($pwords[$i])) return true;
	}
	return false;
}

$error = false;
if (isset($_POST['submit']) && isset($_POST['problem_statement']) && isset($_POST['problem_solution']) && isset($_POST['choice1']) && isset($_POST['choice2']) && isset($_POST['choice3'])
		&& isset($_POST['choice4']) && isset($_POST['password']) && checkPasswordValidity($_POST['password'])){
	require_once("./includes/connection.inc.php");
	$conn = dbConnect('write');
	$sql = "INSERT INTO problems (choice_1, choice_2, choice_3, choice_4, correct_choice, solution, cluster_id, problem_statement, createdBy) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
	$stmt = $conn->stmt_init();
	$stmt->prepare($sql);
	$choice1 = $_POST['choice1'];
	$choice2 = $_POST['choice2'];
	$choice3 = $_POST['choice3'];
	$choice4 = $_POST['choice4'];
	$correct_choice = (int)$_POST['correct_choice'];
	$cluster_id = (int)$_POST['cluster'];
	$solution = $_POST['problem_solution'];
	$problem_statement = $_POST['problem_statement'];
	$password = $_POST['password'];
	$stmt->bind_param('ssssdsdss', $choice1, $choice2, $choice3, $choice4, $correct_choice, $solution, $cluster_id, $problem_statement, $password);
	$stmt->execute();
}
else{
	if (isset($_POST['submit'])){
		$error = true;
	}
}

?>
<!DOCTYPE HTML>
<html>
<head>
	<title>Add Problem</title>
</head>
<body>
	<p><?php if ($error) echo "Invalid input."?></p>
	<form action="" method="post">
		<label for="problem_statement">Problem Statement:</label><br>
		<textarea id="problem_statement" name="problem_statement" rows="6" cols="50" required></textarea><br><br>
		<label for="choice1">Choice A:</label>
		<input name="choice1" id="choice1" required></input><br><br>
		<label for="choice2">Choice B:</label>
		<input name="choice2" id="choice2" required></input><br><br>
		<label for="choice3">Choice C:</label>
		<input name="choice3" id="choice3" required></input><br><br>
		<label for="choice4">Choice D:</label>
		<input name="choice4" id="choice4" required></input><br><br>

		<label for="correct_choice">Correct Choice</label>
		<select name="correct_choice" id="correct_choice">
			<option value="1">A</option>
			<option value="2">B</option>
			<option value="3">C</option>
			<option value="4">D</option>
		</select><br><br>

		<label for="problem_solution">Problem Solution:</label><br>
		<textarea id="problem_solution" name="problem_solution" rows="6" cols="50" required></textarea><br><br>

		<label for="cluster">Cluster:</label>
		<select name="cluster" id="cluster">
			<option value="1">Marketing</option>
			<option value="2">Finance</option>
			<option value="3">Hospitality &amp; Tourism</option>
			<option value="4">Business Management and Administration</option>
			<option value="5">Principles</option>
		</select><br><br>

		<label for="password">Password:</label>
		<input name="password" id="password" type="password" required></input><br><br>

		<input type="submit" name="submit" id="submit" value="Submit"></input>
	</form>
