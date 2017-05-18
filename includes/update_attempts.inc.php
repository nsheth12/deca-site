<?php
function update ($correct, $conn, $problem, $test_cycle){
	$sqlGetAttempt = 'SELECT * FROM attempts WHERE test_cycle = ' . $test_cycle . ' AND problem_id = ' . $problem['problem_id'] . ' AND user_id = ' . $_SESSION['user_id'];
	$attemptQueryResult = $conn->query($sqlGetAttempt);
	if ($attemptQueryResult->num_rows == 1){
		if ($correct){
			$sqlUpdateAttempt = 'UPDATE attempts SET solved = 1, number_attempts = number_attempts + 1 WHERE problem_id = ? AND user_id = ?';
		}
		else{
			$sqlUpdateAttempt = 'UPDATE attempts SET number_attempts = number_attempts + 1 WHERE problem_id = ? AND user_id = ?';
		}
		$stmt = $conn->stmt_init();
		$stmt->prepare($sqlUpdateAttempt);
		$stmt->bind_param('dd', $problem['problem_id'], $_SESSION['user_id']);
		$stmt->execute();
	}
	else{
		$sqlCreateNewAttempt = 'INSERT INTO attempts (problem_id, user_id, solved, number_attempts, test_cycle) VALUES (?, ?, ?, ?, ?)';
		$stmt = $conn->stmt_init();
		$stmt->prepare($sqlCreateNewAttempt);
		if ($correct) $solved = 1;
		else { $solved = 0; }
		$num_attempts = 1;
		$stmt->bind_param('ddiii', $problem['problem_id'], $_SESSION['user_id'], $solved, $num_attempts, $test_cycle);
		$stmt->execute();
	}
}
