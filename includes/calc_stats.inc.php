<?php

$solved = 0;
$totalAttempts = 0;
$totalProblems = 0;
$totalAttemptsOnSolvedProblems = 0;
$error = false;

$sql = 'SELECT * FROM users WHERE user_id = ' . $uid;
$resultForUser = $conn->query($sql);
$userData = $resultForUser->fetch_assoc();

if (!isset($admin)){
	$sql = "SELECT * FROM attempts WHERE user_id = " . $uid . " AND test_cycle = " . $userData['current_cycle'];
}
else{
	$sql = "SELECT * FROM attempts WHERE user_id = " . $uid;
}
$statsResult = $conn->query($sql);

$totalProblems = $statsResult->num_rows;

while ($row = $statsResult->fetch_assoc()){
	$totalAttempts += $row['number_attempts'];
	$solved += $row['solved'];
	if ($row['solved'] == 1){
		$totalAttemptsOnSolvedProblems += $row['number_attempts'];
	}
}

if ($totalAttempts != 0){
	$percentage = round(($solved * 100) / $totalAttempts);
	$avgAttemptsPerCorrectSolution = round($totalAttemptsOnSolvedProblems / $solved, 2);
}
else{
	$error = true;
}
