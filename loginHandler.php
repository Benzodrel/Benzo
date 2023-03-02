<?php
session_start();
$login = $_POST["Login"];
$loginPassword = $_POST['userPassword'];
if (!empty($_POST['Login']) === true) {
    if (!file_exists("users/{$login}.json")) {
        $_SESSION['error']['enter'] = 'Пользователь с таким именем отсутствует';
        header('Location: login.php');
        die();
    }
$json = json_decode(file_get_contents("users/{$login}.json"), true);

    $password = $json['Password'];

    if ($password === md5($loginPassword)) {
        $_SESSION['logged'] = $_POST['Login'];
        header('Location: index.php');
    } else {
        $_SESSION['error']['enter'] = "Неверный пароль";
        header('Location: login.php');
    }
    if ($_POST['rememberMe']) {
        setcookie('logged', $_POST['Login'], time() + 3600 * 24 * 7);
    }

}
