<?php
require("./includes/not_logged_in_redirect.inc.php");
require_once("./includes/connection.inc.php");

if (isset($_POST['new_cycle'])){
    $conn = dbConnect('write');
    $sql = 'SELECT * FROM users WHERE user_id = ' . $_SESSION['user_id'];
    $result = $conn->query($sql);
    $user = $result->fetch_assoc();

    $newCycle = $_POST['new_cycle'];
    if ($newCycle <= $user['max_cycle'] && $newCycle != $user['current_cycle']){
        $sqlSetCycle = 'UPDATE users SET current_cycle = ? WHERE user_id = ?';
		$stmt = $conn->stmt_init();
		$stmt->prepare($sqlSetCycle);
		$stmt->bind_param('dd', $newCycle, $_SESSION['user_id']);
		$stmt->execute();
    }
}
else{
    header('Location: index.php');
    exit;
}
