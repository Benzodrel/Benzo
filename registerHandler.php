<?php
session_start();

require_once 'assistFunctions.php';
$_SESSION['userSurname'] = $_POST["userSurname"];
$_SESSION['userName'] = $_POST["userName"];
$_SESSION['userEmail'] = $_POST["userEmail"];
$_SESSION['Login'] = $_POST["Login"];

$path = "images/{$_POST['Login']}.png";
$data = $_POST;
$image = $_FILES;
$arrAll = getValidatedData($data, $image);
if (empty($arrAll["error"])) {
//    ob_start();
//    foreach ($arrAll['data'] as $i) {
//        echo $i . "\n";
//    }
//    $output = ob_get_contents();
//    file_put_contents("users/{$_POST['Login']}.txt", $output);
//    ob_end_clean();
//    Если я правильно понял что ты имел в виду
    $json_data = json_encode($arrAll['data'], JSON_UNESCAPED_UNICODE);
    file_put_contents("users/{$_POST['Login']}.json", $json_data);
    move_uploaded_file($_FILES['avatar']['tmp_name'], $path);
} else {
    foreach ($arrAll["error"] as $key => $value ) {
        $_SESSION['error'][$key] = $value;
    }
    $_SESSION['message'] = "Ошибка регистрации";
    header('Location: register.php');
    die();
}

$_SESSION['message'] = "Регистрация завершена";
header('Location: login.php');

die();
