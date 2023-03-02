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
$data = $_POST;
$image = $_FILES;
$arrAll = getValidatedData($data, $image);
$json_data_old = json_decode(file_get_contents("users/{$_SESSION['logged']}.json"), true);
if (empty($arrAll["error"])) {
    foreach ($json_data_old as $key => $value) {
        if (empty($arrAll['data'][$key])) {
            $arrAll['data'][$key] = $value;
        }
    }
    $json_data = json_encode($arrAll['data'], JSON_UNESCAPED_UNICODE);
    file_put_contents("users/{$_SESSION['logged']}.json", $json_data);
    move_uploaded_file($_FILES['avatar']['tmp_name'], $path);
} else {
    foreach ($arrAll["error"] as $key => $value) {
        $_SESSION['error'][$key] = $value;
    }
    $_SESSION['error']['change'] = "Ошибка изменения данных";
    header('Location: dataChange.php');
    die();
}

$_SESSION['message'] = "Data successfully updated";
header('Location: index.php');
die();