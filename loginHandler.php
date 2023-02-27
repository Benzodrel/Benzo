<?php
session_start();

if (!empty($_POST['Login']) === true) {
    if (!file_exists("users/{$_POST["Login"]}.txt")) {
        $_SESSION['error'] = 'Пользователь с таким именем отсутствует';
        header('Location: login.php');
        die();
    }
    $password = file("users/{$_POST["Login"]}.txt");
    if ($password[4] === md5($_POST['userPassword'])) {
        $_SESSION['logged'] = $_POST['Login'];
        header('Location: index.php');
    } else {
        $_SESSION['error'] = "Неверный пароль";
        header('Location: login.php');
    }
    if ($_POST['rememberMe']) {
        setcookie('logged', $_POST['Login'], time() + 3600 * 24 * 7);
    }

}
