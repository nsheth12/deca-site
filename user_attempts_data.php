<?php
if (!isset($_POST['uid'])){
	header('Location: report.php');
	exit;
}

require_once("./includes/connection.inc.php");
require_once("./includes/get_current_cycle.inc.php");

$conn = dbConnect('read');
$sql = "SELECT * FROM attempts WHERE user_id = " . $_POST['uid'] . " AND test_cycle = " . getCurrentCycle($conn, $_POST['uid']);
$result = $conn->query($sql);

$attemptsArray['cols'][] = array('label' => 'Number of attempts', 'type' => 'string');
$attemptsArray['cols'][] = array('label' => 'Number of problems', 'type' => 'number');

while ($row = $result->fetch_assoc()){
	if ($row['solved'] == 1){
		if (isset($array[$row['number_attempts']])) $array[$row['number_attempts']]++;
		else{
			$array[$row['number_attempts']] = 1;
		}
	}
}

ksort($array);

foreach ($array as $key => $val){
	if ($key == 1) $keyString = strval($key) . " attempt";
	else{
		$keyString = strval($key) . " attempts";
	}
	$attemptsArray['rows'][] = array('c' => array( array('v'=>$keyString), array('v'=>$val) ));
}

//$attemptsArray['rows'][] = array('c' => array( array('v'=>"1 attempt"), array('v'=>11)) );
//$attemptsArray['rows'][] = array('c' => array( array('v'=>"2 attempts"), array('v'=>3)));
//$array['rows'][] = array('c' => array( array('v'=>'22-01-13'), array('v'=>12)));

//print_r($attemptsArray);
echo json_encode($attemptsArray);
