<?php
session_start();
$arr = [];
if (count(glob('users/*.json')) <= 1) {
    array_push($arr, "Нет других пользователей");
    die();
}
foreach (glob('users/*.json') as $i) {
    if (substr(substr($i, 0, -5), 6) !== $_SESSION['logged']) {
        array_push($arr, (substr(substr($i, 0, -5), 6)) );
    }
}
echo json_encode($arr, JSON_UNESCAPED_UNICODE);
