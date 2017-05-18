<?php
function updateLoginLogout ($conn, $uid, $isLogin){
    $sql = 'INSERT INTO login_logout (login, user_id) VALUES (' . (int)$isLogin . ', ' . $uid . ')';
    $conn->query($sql);
}
