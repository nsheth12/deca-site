<?php
require("./includes/not_logged_in_redirect.inc.php");
require_once("./includes/connection.inc.php");
require_once("./includes/update_attempts.inc.php");
require_once("./includes/get_current_cycle.inc.php");

if (!isset($_POST['submit'])){
	header('Location: get_problem.php');
	exit;
}

$conn = dbConnect('write');
$correct = false;

//Get current problem
$sqlProblem = 'SELECT * FROM problems WHERE problem_id = ' . $_SESSION['problem_id'];
$problemQueryResult = $conn->query($sqlProblem);
$problem = $problemQueryResult->fetch_assoc();

//Update problemOn, setting to NULL
$sqlUpdateProblemOn = 'UPDATE users SET problem_on_id = NULL WHERE user_id = ?';
$stmt = $conn->stmt_init();
$stmt->prepare($sqlUpdateProblemOn);
$stmt->bind_param('d', $_SESSION['user_id']);
$stmt->execute();

//Check if answer is correct
if ($problem['correct_choice'] == (int)$_POST['multipleChoice']) $correct = true;
else{ $correct = false; }

update($correct, $conn, $problem, getCurrentCycle($conn, $_SESSION['user_id']));

$title = "Solution";
require_once("./includes/template_begin.inc.php");
?>

<script type="text/javascript">
	function submitForm (){
		//$('#pidField').val(pid);
		$('#pidForm').submit();
	}
</script>
<form action="report_error.php" method="post" id="pidForm" target="=_blank">
	<input type="hidden" name="pid" id="pidField" value="<?php echo $problem['problem_id']; ?>">
</form>

<h2><?php if ($correct) echo "<font color='green'>Correct!</font>"; else { echo "<font color='red'>Incorrect.</font>"; } ?></h2>

<div class="custom-jumbotron" style="padding-left: 4px; padding-right: 10px; padding-top: 1px; margin-bottom: 10px;">
	<h4 style="margin-top: 8px; margin-bottom: 0px; font-weight: bold;">Problem:</h4>
	<?php echo $problem['problem_statement']; ?><br>
	<ol type="A">
		<li><?php echo htmlentities($problem['choice_1'], ENT_COMPAT, 'UTF-8'); ?></li>
		<li><?php echo htmlentities($problem['choice_2'], ENT_COMPAT, 'UTF-8'); ?></li>
		<li><?php echo htmlentities($problem['choice_3'], ENT_COMPAT, 'UTF-8'); ?></li>
		<li><?php echo htmlentities($problem['choice_4'], ENT_COMPAT, 'UTF-8'); ?></li>
	</ol>

	<h4 style="margin-top: 15px; margin-bottom: 0px; font-weight: bold;">Solution:</h4>
	<p style="margin-bottom: 6px;"><?php echo $problem['solution']; ?></p>
</div>

<p>
	<a class="btn btn-success" href="get_problem.php">Next Problem!</a>
	<button type="button" id="reportError" class="btn btn-default" onclick="submitForm()">Report an Issue with this Solution</button>
</p>

<?php
require_once("./includes/template_end.inc.php");
?>
