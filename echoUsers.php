<?php
session_start();
require_once 'config.php';
$arr = [];

$dataBase = mysqli_connect($host, $username, $password, $databaseName);
if ($dataBase === false) {
    $_SESSION['error']['saveData'] = "Ошибка подключения в базе данных";
    header('Location: login.php');
    die();
}

$sql = "SELECT `login` FROM `users` WHERE `login` != '{$_SESSION['logged']}' ";

$query = mysqli_query($dataBase, $sql);
if ($query === false) {
    $_SESSION['error']['saveData'] = "Ошибка выполнения запроса";
    header('Location: login.php');
    die();
}

while ($row = mysqli_fetch_assoc($query)) {
    if ($row['login'] === NULL) {
        array_push($arr, "Нет других пользователей");
    }
    array_push($arr, $row['login']);
}
mysqli_close($dataBase);

echo json_encode($arr, JSON_UNESCAPED_UNICODE | JSON_FORCE_OBJECT);
