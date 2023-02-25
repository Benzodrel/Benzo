<?php
session_start();

if (isset($_POST['Login']) === true) {
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

}
