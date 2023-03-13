<?php
session_start();

require_once "assistFunctions.php";

if (!isset($_SESSION['logged'])) {
    header('Location: login.php');
    die();
}
if (!file_exists("users/{$_SESSION['logged']}.json")) {
    $_SESSION['error'] = "Data page doesn't exists";
    header('Location: dataChange.php');
    die();
}

$path = "images/{$_SESSION['logged']}.png";
$data = $_POST['registerData'];
$image = $_FILES;
$arrAll = getValidatedDataChange($data, $image);
$json_data_old = json_decode(file_get_contents("users/{$_SESSION['logged']}.json"), true);
if (empty($arrAll["error"])) {
    foreach ($json_data_old as $key => $value) {
        if (isset($arrAll['data'][$key])) {
            $json_data_old[$key] = $arrAll['data'][$key];
        }
    }
    if (!empty($_POST['registerData']['userPassword'])) {
        $json_data_old['Password'] = md5($arrAll['data']['Password']);
    }
    $json_data = json_encode($json_data_old, JSON_UNESCAPED_UNICODE);
    file_put_contents("users/{$_SESSION['logged']}.json", $json_data);
    if (!empty($_FILES['avatar']['tmp_name'])) {
        if (move_uploaded_file($_FILES['avatar']['tmp_name'], $path) === false) {
            $_SESSION['error']['save'] = 'Ошибка сохранения аватара';
            header('Location: dataChange.php');
            die();
        }
    }
} else {
    foreach ($arrAll["error"] as $key => $value) {
        $_SESSION['error'][$key] = $value;
    }
    $_SESSION['error']['change'] = "Ошибка изменения данных";
    unset ($_POST['registerData']);
    header('Location: dataChange.php');
    die();
}

unset ($_POST['registerData']);
$_SESSION['message'] = "Data successfully updated";
header('Location: index.php');
die();