<?php
session_start();

require_once 'assistFunctions.php';
if (count($_POST['registerData']) === 6){
    $_SESSION['userSurname'] = $_POST['registerData']['surname'];
    $_SESSION['userName'] = $_POST['registerData']['name'];
    $_SESSION['userEmail'] = $_POST['registerData']['email'];
    $_SESSION['Login'] = $_POST['registerData']['Login'];
} else {
    $_SESSION['error']['register'] = "Все поля обязательны к заполнению";
    unset ($_POST['registerData']);
    header('Location: register.php');
    die();
}


$path = "images/{$_POST['registerData']['Login']}.png";
$data = $_POST['registerData'];
$image = $_FILES;
$arrAll = getValidatedData($data, $image);
if (empty($arrAll["error"])) {
    $arrAll['data']['Password'] = md5($arrAll['data']['Password']);
    $json_data = json_encode($arrAll['data'], JSON_UNESCAPED_UNICODE);
    file_put_contents("users/{$_POST['registerData']['Login']}.json", $json_data);
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
    unset ($_POST['registerData']);
    header('Location: register.php');
    die();
}

unset ($_POST['registerData']);
$_SESSION['message'] = "Регистрация завершена";
header('Location: login.php');

die();
