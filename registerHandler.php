<?php
session_start();

$path = "images/{$_POST['Login']}.png";
if (file_exists("{$_POST["Login"]}.txt")) {
    $_SESSION['error'] = "This user already exists";
    header('Location: register.php');
    die();
}
if (filter_var($_POST["userEmail"], FILTER_VALIDATE_EMAIL) === false) {
    $_SESSION['error'] = "Enter correct E-mail";
    header('Location: register.php');
    die();
}
// TODO: normal regex check, password hashing
if (!preg_match('/(?=.*[A-Z])(?=.*?\d).{5,}/', $_POST['userPassword'])) {
    $_SESSION['error'] = "Your password should include at least 1 Uppercase letter and 1 digit and be at least 5 char length";
    header('Location: register.php');
    die();
}
if ($_POST["userPassword"] !== $_POST["userPasswordConfirm"]) {
    $_SESSION['error'] = "Passwords are not match";
    header('Location: register.php');
    die();
}
if (is_uploaded_file($_FILES['avatar']['tmp_name'])) {
    if ($_FILES['avatar']['size'] >= '10000') {
        $_SESSION['error'] = "Avatar's size must less than 10 MB";
        header('Location: register.php');
        die();
    }
    if ($_FILES['avatar']['type'] !== 'image/png') {
        $_SESSION['error'] = "Avatar must be .png";
        header('Location: register.php');
        die();
    }
    move_uploaded_file($_FILES['avatar']['tmp_name'], $path);
}

file_put_contents("users/{$_POST["Login"]}.txt", $_POST["Login"] . "\n", FILE_APPEND);
file_put_contents("users/{$_POST["Login"]}.txt", $_POST["userName"] . "\n", FILE_APPEND);
file_put_contents("users/{$_POST["Login"]}.txt", $_POST["userSurname"] . "\n", FILE_APPEND);
file_put_contents("users/{$_POST["Login"]}.txt", $_POST["userEmail"] . "\n", FILE_APPEND);
file_put_contents("users/{$_POST["Login"]}.txt", md5($_POST["userPassword"]), FILE_APPEND);


$_SESSION['error'] = "Регистрация завершена";
header('Location: login.php');
die();