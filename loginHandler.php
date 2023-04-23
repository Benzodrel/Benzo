<?php
session_start();
require_once 'dataBase_functions.php';
$login = $_POST["Login"];
$loginPassword = $_POST['userPassword'];

$arr = getLoginPassword($login);
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
            setcookie('logged', $dbLogin, time() + 3600 * 24 * 7);// 1 week
            setcookie('password', $dbPassword, time() + 3600 * 24 * 7);
        }
        header('Location: index.php');
    } else {
        $_SESSION['error']['enter'] = "Неверный пароль";
        header('Location: login.php');
    }


}
