<?php
require('./includes/not_logged_in_redirect.inc.php');
require_once("./includes/connection.inc.php");

$problem = null;
$conn = dbConnect('write');

// check if the user is already on a problem
$sqlCheckIfProblemOn = "SELECT problem_on_id FROM users WHERE user_id = " . $_SESSION['user_id'] . " AND problem_on_id IS NOT NULL AND current_cycle = max_cycle";
$result = $conn->query($sqlCheckIfProblemOn);

if ($result->num_rows == 1){
	// if yes, give the user that problem
	$sqlProblemSelect = 'SELECT * FROM problems WHERE problem_id = ' . $result->fetch_assoc()['problem_on_id'];
	$problemQueryResult = $conn->query($sqlProblemSelect);
	$problem = $problemQueryResult->fetch_assoc();
	$foundProblem = true;
}
else{
	// otherwise, find the user a new problem
	$foundProblem = false;
	$userSql = 'SELECT * FROM users WHERE user_id = ' . $_SESSION['user_id'];
	$userQueryResult = $conn->query($userSql);

	if (!$userQueryResult){
		echo("There was an error in the database query.");
	}

	$user = $userQueryResult->fetch_assoc();

	// SQL query for a problem that the user has not solved and is in their cluster
	$sqlRandomSelect = 'SELECT
							problems.problem_statement,
							problems.choice_1,
							problems.choice_2,
							problems.choice_3,
							problems.choice_4,
							problems.problem_id
						FROM problems
						LEFT OUTER JOIN attempts ON (problems.problem_id = attempts.problem_id AND attempts.user_id=' . $_SESSION['user_id'] . ' AND attempts.test_cycle = ' . $user['current_cycle'] . ')
						WHERE cluster_id = ' . $user['cluster_id'] . ' AND (solved IS NULL OR solved=0)
						ORDER BY RAND()
						LIMIT 1;';
	$result = $conn->query($sqlRandomSelect);

	if ($result->num_rows > 0){
		$foundProblem = true;
		$problem = $result->fetch_assoc();
	}

	// set problemOn
	if ($foundProblem){
		$sqlSetProblemOn = 'UPDATE users SET problem_on_id = ? WHERE user_id = ?';
		$stmt = $conn->stmt_init();
		$stmt->prepare($sqlSetProblemOn);
		$stmt->bind_param('dd', $problem['problem_id'], $_SESSION['user_id']);
		$stmt->execute();
	}
}

// set problem ID session variable for use on other pages
if ($foundProblem){
	$_SESSION['problem_id'] = $problem['problem_id'];
}

$title = "Get Problem | NEO";
require_once("./includes/template_begin.inc.php");
?>

<?php if ($foundProblem){ ?>
	<script type="text/javascript">
		// onClick handler for reporting errors, opens report_error.php in new tab
		// without popup alerts using hidden form field
		function submitForm (){
			$('#pidForm').submit();
		}
	</script>
	<form action="report_error.php" method="post" id="pidForm" target="=_blank">
		<input type="hidden" name="pid" id="pidField" value="<?php echo $problem['problem_id']; ?>">
	</form>
	<h4><?php echo $problem['problem_statement']; ?></h4>
	<div>
		<form action="get_solution.php" method="post">
			<fieldset class="form-group">
				<input type="radio" name="multipleChoice" value="1" id="choice-1" checked>
				<label for="choice-1">(A) <?php echo $problem['choice_1']; ?></label>
				<br>
				<input type="radio" name="multipleChoice" value="2" id="choice-2">
				<label for="choice-2">(B) <?php echo $problem['choice_2']; ?></label>
				<br>
				<input type="radio" name="multipleChoice" value="3" id="choice-3">
				<label for="choice-3">(C) <?php echo $problem['choice_3'] ?></label>
				<br>
				<input type="radio" name="multipleChoice" value="4" id="choice-4">
				<label for="choice-4">(D) <?php echo $problem['choice_4']; ?></label>
				<br>
			</fieldset>
			<p>
				<button type="submit" name="submit" id="submit" class="btn btn-success">Submit</button>
				<button type="button" id="reportError" class="btn btn-default" onclick="submitForm()">Report an Issue with this Problem</button>
			</p>
		</form>
	</div>
<?php } else {
	// if no problems were found (the user has completed all problems)
	if ($user['current_cycle'] == $user['max_cycle']){
		// increment max_cycle so they repeat all problems
		$sqlIncrementMaxCycle = 'UPDATE users SET max_cycle = max_cycle + 1 WHERE user_id = ?';
		$stmtMaxCycle = $conn->stmt_init();
		$stmtMaxCycle->prepare($sqlIncrementMaxCycle);
		$stmtMaxCycle->bind_param('d', $_SESSION['user_id']);
		$stmtMaxCycle->execute();
	}
	?>
	<h1>Congratulations, you've finished all the problems for your cluster!</h1>
	You can now re-do all the problems if you wish. Click on the "Profile" tab at the top of the screen, and on that page you will see a drop-down that allows you to select your "test cycle". Each test cycle represents one completion of all the problems. To re-do the problems, select the next test cycle on the profile page, while to review all the problems you've completed on this test cycle, select the first (or second, third, etc. depending on how many times you've completed all problems) test cycle. Think of it as having essentially multiple accounts (some accounts in which all problems are completed, and one in which not all are completed) and being able to switch between these accounts through the drop-down in the profile page. Contact Nihar Sheth (nsheth12@gmail.com) or Mr. Rogers if you have any questions.
<?php } ?>

<?php
require_once("./includes/template_end.inc.php");
?>
