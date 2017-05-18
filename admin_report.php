<?php
require_once('./includes/admin_redirect.inc.php');
require_once('./includes/connection.inc.php');

$conn = dbConnect('read');
$sqlTotalAttempts = 'SELECT SUM(number_attempts) AS total_attempts FROM attempts';
$sqlTotalSolved = 'SELECT SUM(solved) AS total_solved FROM attempts';
$sqlTotalStudents = 'SELECT COUNT(*) AS num_students FROM users WHERE con_code IS NULL';
$totalAttempts = $conn->query($sqlTotalAttempts)->fetch_assoc()['total_attempts'];
$totalSolved = $conn->query($sqlTotalSolved)->fetch_assoc()['total_solved'];
$totalStudents = $conn->query($sqlTotalStudents)->fetch_assoc()['num_students'];

$title = "Administrator Report | NEO";
require_once("./includes/template_begin.inc.php");
?>
<h2 style="margin-top: 5px; margin-bottom: 0px;"><div class="text-center">Club-wide stats:</div></h2>
<h4>
<table class="table table-hover">
	<tr>
		<td style="border-top: none;"># of students registered</td>
		<td style="border-top: none;"><?php echo $totalStudents; ?></td>
	</tr>
	<tr>
		<td>Total # of problems attempted</td>
		<td><?php echo $totalAttempts; ?></td>
	</tr>
	<tr>
		<td>Total # of problems solved</td>
		<td><?php echo $totalSolved; ?></td>
	</tr>
</table>
</h4>
<h2 style="margin-top: 10px;"><div class="text-center">Search for student:</div></h2>
<div class="custom-jumbotron">
	<div class="row marketing" style="margin-top: 0px; margin-bottom: 5px;">
		<div class="col-lg-6">
			<form action="view_user.php" method="get" id="nameForm">
				<h4><strong>Search by name:</strong></h4>
				<div class="form-group">
						<label for="firstName">First Name:</label>
						<input type="text" name="firstName" id="firstName" class="form-control"  style="width: 70%; margin-bottom: 2px;" required>
						<label for="lastName">Last Name:</label>
						<input type="text" name="lastName" id="lastName" class="form-control" style="width: 70%; margin-bottom: 4px;" required>
						<label for="dataType">What would you like?</label>
						<select name="dataType" class="form-control" style="width: 70%; margin-bottom: 6px;" required>
							<option value="report">Report</option>
							<option value="problem_hist">Problem History</option>
						</select>
						<button type="submit" name="searchByName" id="searchByName" class="btn btn-success">Search</button>
				</div>
			</form>
		</div>
		<div class="col-lg-6">
			<form action="view_user.php" method="get" id="emailForm">
				<h4><strong>Search by email:</strong></h4>
				<div class="form-group">
					<label for="email">Email:</label>
					<input type="text" name="email" id="email" class="form-control" style="width: 70%; margin-bottom: 4px;" required>
					<label for="dataType">What would you like?</label>
					<select name="dataType" class="form-control" style="width: 70%; margin-bottom: 6px;">
						<option value="report">Report</option>
						<option value="problem_hist">Problem History</option>
					</select>
					<button type="submit" name="searchByEmail" id="searchByEmail" class="btn btn-success">Search</button>
				</div>
			</form>
		</div>
	</div>
	<div style="margin-left: 13px; margin-right: 13px; margin-bottom: 10px;">
		<a class="btn btn-lg btn-block btn-primary" href="view_all_users.php">View All Students</a>
	</div>
</div>
<h2 style="margin-top: 30px;"><div class="text-center">Search for problem:</div></h2>
<div class="custom-jumbotron">
	<div class="row marketing" style="margin-top: 0px; margin-bottom: 5px;">
		<div class="col-lg-6">
			<form action="view_problem_full_report.php" method="post">
				<h4><strong>Search by problem statement:</strong></h4>
				<div class="form-group">
					<label for="problem_statement">Problem statement:</label>
					<textarea name="problem_statement" rows=6 id="problem_statement" class="form-control" style="width: 70%; margin-bottom: 4px;" required></textarea>
					<button type="submit" name="searchPStatement" id="searchPStatement" class="btn btn-success">Search</button>
				</div>
			</form>
		</div>
		<div class="col-lg-6">
			<form action="view_problem_full_report.php" method="post">
				<h4><strong>Search by problem choices:</strong></h4>
				<div class="form-group">
					<label>Choices:</label>
					<input type="text" placeholder="Choice (A)" name="choiceA" id="choiceA" class="form-control" style="width: 70%; margin-bottom: 4px;">
					<input type="text" placeholder="Choice (B)" name="choiceB" id="choiceB" class="form-control" style="width: 70%; margin-bottom: 4px;">
					<input type="text" placeholder="Choice (C)" name="choiceC" id="choiceC" class="form-control" style="width: 70%; margin-bottom: 4px;">
					<input type="text" placeholder="Choice (D)" name="choiceD" id="choiceD" class="form-control" style="width: 70%; margin-bottom: 4px;">
					<button type="submit" name="searchChoices" id="searchChoices" class="btn btn-success">Search</button>
				</div>
			</form>
		</div>
	</div>
	<div style="margin-left: 13px; margin-right: 13px; margin-bottom: 10px;">
		<a class="btn btn-lg btn-block btn-primary" href="view_all_problems.php">View All Problems</a>
	</div>
</div>
<?php
require_once("./includes/template_end.inc.php");
?>
