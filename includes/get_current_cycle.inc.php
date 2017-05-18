<?php
function getCurrentCycle ($conn, $uid){
    $sqlUser = 'SELECT * FROM users WHERE user_id = ' . $uid;
    $userQueryResult = $conn->query($sqlUser);
    $userData = $userQueryResult->fetch_assoc();
    return $userData['current_cycle'];
}
