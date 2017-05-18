<?php
require_once("./includes/connection.inc.php");

$error = false;
$conn = dbConnect('read');

$sql = 'SELECT * FROM users WHERE user_id = ' . $uid;
$resultForUser = $conn->query($sql);
$userData = $resultForUser->fetch_assoc();

$sql = 'SELECT * FROM attempts WHERE user_id = ' .$uid . ' AND test_cycle = ' . $userData['current_cycle'] . ' ORDER BY time_of_attempt DESC';
$result = $conn->query($sql);

if ($result->num_rows == 0) $error = true;

if (!$error) { ?>
	<script type="text/javascript">
		function submitForm (vpi){
			$('#vpiField').val(vpi);
			$('#vpiForm').submit();
		}
	</script>
	<form action="view_problem_user_perspective.php" method="post" id="vpiForm">
		<input type="hidden" name="vpi" id="vpiField" value="">
	</form>
	<table class="table">
		<thead>
			<tr style="font-size: 16px;">
				<th style="border-top: none;"></th>
				<th style="border-top: none;"><strong>Problem</strong></hd>
				<th style="border-top: none; padding-left: 0px; padding-right: 0px;"><strong style="white-space: nowrap;"># Attempts</strong></th>
				<th style="border-top: none;"><strong style="white-space: nowrap;">Time of Attempt</strong></th>
				<th style="border-top: none;"></th>
			</tr>
		</thead>
		<tbody>
			<?php while ($row = $result->fetch_assoc()){
				$sqlGetProblem = 'SELECT problem_statement FROM problems WHERE problem_id = ' . $row['problem_id'];
				$resultProblem = $conn->query($sqlGetProblem);
				$problemRow = $resultProblem->fetch_assoc();
			?>
				<tr>
					<td style="color: <?php if ($row['solved'] == '1') echo '#4DE04D'; else {echo '#EB4444';}?>; padding-left: 15px; padding-right: 15px; font-size: 20px;"><span class="glyphicon glyphicon-<?php if ($row['solved'] == '1') echo 'ok'; else {echo 'remove';}?>" aria-hidden="true"></span></td>
					<td style="width: 375px;" class="problem_statement_td"><?php echo $problemRow['problem_statement']; ?></td>
					<td style="text-align: center; padding-left: 0px; padding-right: 0px;"><?php echo $row['number_attempts']; ?></td>
					<td><?php echo date('M j, g:i A', strtotime($row['time_of_attempt'])+7200); ?></td>
					<td><a href="javascript: submitForm(<?php echo $row['problem_id']; ?>)">Details</a></td>
				</tr>
			<?php } ?>
		</tbody>
	</table>
<?php } else { ?>
	<h1>No problems completed yet.</h1>
<?php } ?>
