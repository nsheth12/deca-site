<?php
require_once('./includes/admin_redirect.inc.php');
require_once('./includes/connection.inc.php');
require_once('./includes/cluster_utilities.inc.php');

$conn = dbConnect('read');
$sql = '';

if (isset($_POST['vpi']) && is_numeric($_POST['vpi'])){
    $sql = 'SELECT * FROM problems WHERE problem_id = ' . $_POST['vpi'];
}
else if (isset($_POST['problem_statement'])){
    $problem_statement = $conn->real_escape_string($_POST['problem_statement']);
    //FIXME: Could be more efficient using full text indexing
    $sql = 'SELECT * FROM problems WHERE UPPER(problem_statement) LIKE UPPER("%' . $problem_statement . '%")';
}
else if (isset($_POST['choiceA']) && isset($_POST['choiceB']) && isset($_POST['choiceC']) && isset($_POST['choiceD'])){
    $choiceA = $conn->real_escape_string($_POST['choiceA']);
    $choiceB = $conn->real_escape_string($_POST['choiceB']);
    $choiceC = $conn->real_escape_string($_POST['choiceC']);
    $choiceD = $conn->real_escape_string($_POST['choiceD']);
    $sql = 'SELECT * FROM problems WHERE UPPER(choice_1) LIKE UPPER("%' . $choiceA . '%")
            AND UPPER(choice_2) LIKE UPPER("%' . $choiceB . '%")
            AND UPPER(choice_3) LIKE UPPER("%' . $choiceC . '%")
            AND UPPER(choice_4) LIKE UPPER("%' . $choiceD . '%")';
}
else{
    header('Location: admin_report.php');
    exit;
}

$title = 'View Problem | NEO';
require_once('./includes/template_begin.inc.php');

$result = $conn->query($sql);
if ($result->num_rows == 1){
    $problemRow = $result->fetch_assoc();
    $solved = true;
    require_once('./includes/problem_meta_data.inc.php');
    require_once('./includes/view_problem.inc.php');
}
else if ($result->num_rows == 0){
    echo '<h2>No problems matched your search.</h2>';
}
else {
    $inReport = true;
    $appendStr = 'problem_id = ' . strval($result->fetch_assoc()['problem_id']);
    while ($row = $result->fetch_assoc()){
        $appendStr .= ' OR problem_id = ' . $row['problem_id'];
    }
    $sqlAttemptsSpecific = 'SELECT * FROM attempts WHERE ' . $appendStr;
    $sqlProblemsSpecific = 'SELECT * FROM problems WHERE ' . $appendStr;
    require_once('./includes/calc_view_all_problems_stats.inc.php');
    require_once('./includes/view_all_problems.inc.php');
    //echo '<h2>More than one problem matched your search. Please use a more specific search query.</h2>';
}

require_once('./includes/template_end.inc.php');
