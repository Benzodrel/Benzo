<?php
session_start();
require_once 'config.php';
$login = $_POST["Login"];
$loginPassword = $_POST['userPassword'];

$connect = mysqli_connect($host, $username, $password, $databaseName);
if ($connect === false) {
    $_SESSION['error']['saveData'] = "Ошибка подключения в базе данных";
    header('Location: login.php');
    die();
}

$sql = ("SELECT `login`, `password` FROM `users` WHERE `login` = ? ");
$result = mysqli_execute_query($connect, $sql, [$login]);
$arr = mysqli_fetch_assoc($result);
$dbLogin = $arr['login'];
$dbPassword = $arr['password'];

if (!empty($_POST['Login']) === true) {
    if ($dbLogin === NULL) {
        $_SESSION['error']['enter'] = 'Пользователь с таким именем отсутствует';
        header('Location: login.php');
        die();
    }

    if (password_verify($loginPassword, $dbPassword)) {
        $_SESSION['logged'] = $_POST['Login'];
        if (isset($_POST['rememberMe'])) {
            setcookie('logged', $_POST['Login'], time() + 3600 * 24 * 7);// 1 week
            setcookie('password', $dbPassword, time() + 3600 * 24 * 7);
        }
        header('Location: index.php');
    } else {
        $_SESSION['error']['enter'] = "Неверный пароль";
        header('Location: login.php');
    }


}
