<?php
session_start();
require_once 'dataBase_functions.php';
require_once "assistFunctions.php";

if (!isset($_SESSION['logged'])) {
    header('Location: login.php');
    die();
}


$path = "images/{$_SESSION['logged']}.png";
$data = $_POST['registerData'];
$image = $_FILES;
$arrAll = getValidatedDataChange($data, $image);

$data_old = getUserData($_SESSION['logged']);

if (empty($arrAll["error"])) {
    foreach ($data_old as $key => $value) {
        if (isset($arrAll['data'][$key])) {
            $data_old[$key] = $arrAll['data'][$key];
        }
    }
    if (!empty($_POST['registerData']['userPassword'])) {
        $data_old['password'] = password_hash($arrAll['data']['password'], PASSWORD_BCRYPT);
        $_SESSION['error']['saveData'] = $data_old;
    }
    $data_new = [];
    foreach ($data_old as $value) {
        array_push($data_new, $value);
    }

    updateUserData($data_new, $_SESSION['logged']);
//    $sql = "UPDATE `users` SET `name` = ?, surname = ?, email = ?, `password` = ? WHERE `login` = '{$_SESSION['logged']}'";
//    $result = mysqli_execute_query($connect, $sql, $data_new);
//    if ($result === false) {
//        $_SESSION['error']['saveData'] = "Ошибка исполнения запроса";
//        header('Location: dataChange.php');
//        die();
//    }

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
    header('Location: dataChange.php');
    die();
}

$_SESSION['message'] = "Data successfully updated";
header('Location: index.php');
die();