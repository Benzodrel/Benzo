<?php
session_start();
if (count(glob('users/*.json')) <= 1) {
    echo "Нет других пользователей";
    die();
}
foreach (glob('users/*.json') as $i) {
    if (ltrim(rtrim($i, '.json'), 'users/') !== $_SESSION['logged']) {
        echo ltrim(rtrim($i, '.json'), 'users/') . '<br>';
    }
}
