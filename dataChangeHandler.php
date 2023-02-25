<?php
session_start();
$path = "images/{$_SESSION['logged']}.png";
if (!file_exists("users/{$_SESSION['logged']}.txt")) {
    $_SESSION['error'] = "Data page doesn't exists";
    header('Location: dataChange.php');
    die();
}
if (!empty($_POST['userEmail'])) {
    if (filter_var($_POST["userEmail"], FILTER_VALIDATE_EMAIL) === false) {
        $_SESSION['error'] = "Enter correct E-mail";
        header('Location: dataChange.php');
        die();
    }
    $email = $_POST['userEmail'];
} else {
    $email = rtrim(file("users/{$_SESSION['logged']}.txt")[3], "\n");
}

if (is_uploaded_file($_FILES['avatar']['tmp_name'])) {
    if ($_FILES['avatar']['size'] >= '10000') {
        $_SESSION['error'] = "Avatar's size must less than 10 MB";
        header('Location: dataChange.php');
        die();
    }
    if ($_FILES['avatar']['type'] !== 'image/png') {
        $_SESSION['error'] = "Avatar must be .png";
        header('Location: dataChange.php');
        die();
    }
    if (file_exists($path)) {
        unlink($path);
    }
    move_uploaded_file($_FILES['avatar']['tmp_name'], $path);
}


if (!empty($_POST['userPassword'])) {
    if (!preg_match('/(?=.*[A-Z])(?=.*?\d).{5,}/', $_POST['userPassword'])) {
        $_SESSION['error'] = "Your password should include at least 1 Uppercase letter and 1 digit and be at least 5 char length";
        header('Location: dataChange.php');
        die();
    }
    if ($_POST["userPassword"] !== $_POST["userPasswordConfirm"]) {
        $_SESSION['error'] = "Passwords are not match";
        header('Location: dataChange.php');
        die();
    }
    $password = md5($_POST['userPassword']);
} else {
    $password = file("users/{$_SESSION['logged']}.txt")[4];
}

if (!empty($_POST['userName'])) {
    $userName = $_POST["userName"];
} else {
    $userName = rtrim(file("users/{$_SESSION['logged']}.txt")[1], "\n");
}
if (!empty($_POST['userSurname'])) {
    $userSurname = $_POST["userSurname"];
} else {
    $userSurname = rtrim(file("users/{$_SESSION['logged']}.txt")[2], "\n");
}

file_put_contents("users/{$_SESSION['logged']}.txt", $_SESSION['logged'] . "\n");
file_put_contents("users/{$_SESSION['logged']}.txt", $userName . "\n", FILE_APPEND);
file_put_contents("users/{$_SESSION['logged']}.txt", $userSurname . "\n", FILE_APPEND);
file_put_contents("users/{$_SESSION['logged']}.txt", $email . "\n", FILE_APPEND);
file_put_contents("users/{$_SESSION['logged']}.txt", $password, FILE_APPEND);

$_SESSION['error'] = "Data Successfully refreshed";
header('Location: index.php');
die();