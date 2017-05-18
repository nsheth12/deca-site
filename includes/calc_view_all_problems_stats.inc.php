<?php
$error = false;
$problemDataTable = array();

if (isset($inReport)) $sqlAttempts = $sqlAttemptsSpecific;
else{
    $sqlAttempts = 'SELECT * FROM attempts';
}
$resultAttempts = $conn->query($sqlAttempts);

if ($resultAttempts !== false){
    while ($attempt = $resultAttempts->fetch_assoc()){
        if (isset($problemDataTable[(int)$attempt['problem_id']])){
            $problemDataTable[(int)$attempt['problem_id']]['total_attempts'] += (int)$attempt['number_attempts'];
            $problemDataTable[(int)$attempt['problem_id']]['solved'] += (int)$attempt['solved'];
            $problemDataTable[(int)$attempt['problem_id']]['num_students'] += 1;
            if ((int)$attempt['solved'] == 1){
                $problemDataTable[(int)$attempt['problem_id']]['attempts_for_solved'] += (int)$attempt['number_attempts'];
            }
        }
        else{
            $problemDataTable[(int)$attempt['problem_id']]['total_attempts'] = (int)$attempt['number_attempts'];
            $problemDataTable[(int)$attempt['problem_id']]['solved'] = (int)$attempt['solved'];
            $problemDataTable[(int)$attempt['problem_id']]['num_students'] = 1;
            if ((int)$attempt['solved'] == 1){
                $problemDataTable[(int)$attempt['problem_id']]['attempts_for_solved'] = (int)$attempt['number_attempts'];
            }
            else{
                $problemDataTable[(int)$attempt['problem_id']]['attempts_for_solved'] = 0;
            }
        }
    }
}
else{
    $error = true;
}

if (isset($inReport)) $sqlProblems = $sqlProblemsSpecific;
else{
    $sqlProblems = 'SELECT * FROM problems';
}
$resultProblems = $conn->query($sqlProblems);

if ($resultProblems !== false && $resultProblems->num_rows != 0);
else{
    $error = true;
}
