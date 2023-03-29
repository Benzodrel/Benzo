<?php
session_start();
require_once 'config.php';
require_once 'assistFunctions.php';
if (count($_POST['registerData']) === 6) {
    $_SESSION['userSurname'] = $_POST['registerData']['surname'];
    $_SESSION['userName'] = $_POST['registerData']['name'];
    $_SESSION['userEmail'] = $_POST['registerData']['email'];
    $_SESSION['Login'] = $_POST['registerData']['Login'];
} else {
    $_SESSION['error']['register'] = "Все поля обязательны к заполнению";
    header('Location: register.php');
    die();
}


$path = "images/{$_POST['registerData']['Login']}.png";
$data = $_POST['registerData'];
$image = $_FILES;
$arrAll = getValidatedData($data, $image);
if (empty($arrAll["error"])) {
    $arrAll['data']['Password'] = password_hash($arrAll['data']['Password'], PASSWORD_BCRYPT);
    $connect = mysqli_connect($host, $username, $password, $databaseName);
    if ($connect === false) {
        $_SESSION['error']['saveData'] = "Ошибка подключения в базе данных";
        header('Location: register.php');
        die();
    }
    $stmt = mysqli_prepare($connect, "INSERT INTO `users` (login, name, surname, email, password) VALUES (?,?,?,?,?)");
    if ($stmt === false) {
        $_SESSION['error']['saveData'] = "Ошибка подготовки SQL выражения";
        header('Location: register.php');
        die();
    }
    if (mysqli_stmt_bind_param($stmt, 'sssss', $arrAll['data']['Login'], $arrAll['data']['Name'], $arrAll['data']['Surname'], $arrAll['data']['Email'], $arrAll['data']['Password']) === false) {
        $_SESSION['error']['saveData'] = "Ошибка привязки параметров подготовленного SQL выражения";
        header('Location: register.php');
        die();
    }
    if (mysqli_stmt_execute($stmt) === false) {
        $_SESSION['error']['saveData'] = "Ошибка выполнения подготовленного SQL выражения";
        header('Location: register.php');
        die();
    }

    if (!empty($_FILES['avatar']['tmp_name'])) {
        if (move_uploaded_file($_FILES['avatar']['tmp_name'], $path) === false) {
            $_SESSION['error']['save'] = 'Ошибка сохранения аватара';
            header('Location: login.php');
            die();
        }
    }

} else {
    foreach ($arrAll["error"] as $key => $value) {
        $_SESSION['error'][$key] = $value;
    }
    $_SESSION['error']['register'] = "Ошибка регистрации";
    header('Location: register.php');
    die();
}

mysqli_close($connect);
$_SESSION['message'] = "Регистрация завершена";
header('Location: login.php');

die();
