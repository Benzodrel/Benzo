<?php
session_start();

$path = "images/{$_POST['Login']}.png";
$_SESSION['userSurname'] = $_POST["userSurname"];
$_SESSION['userName'] = $_POST["userName"];
if (file_exists("users/{$_POST["Login"]}.txt")) {
    $_SESSION['error'] = "This user is already exists";
    unset($_SESSION['Login']);
    header('Location: register.php');
    die();
} else {
    $_SESSION['Login'] = $_POST["Login"];
}
if (filter_var($_POST["userEmail"], FILTER_VALIDATE_EMAIL) === false) {
    $_SESSION['error'] = "Enter correct E-mail";
    header('Location: register.php');
    die();
} else {
    $_SESSION['userEmail'] = $_POST["userEmail"];
}

function isEmailExists() {
    if (glob("users/*.txt") === false) {
        return false;
    }
    foreach (glob("users/*.txt")as $file) {
        if (rtrim(file($file)[3], "\n") ===  $_SESSION['userEmail']) {
            return true;
        }
    }
    return false;
}
if (isEmailExists()) {
    $_SESSION['error'] = " Another user already have this E-mail";
    unset($_SESSION['userEmail']);
    header('Location: register.php');
    die();
}


if (!preg_match('/(?=.*[A-Z])(?=.*?\d).{5,}/', $_POST['userPassword'])) {
    $_SESSION['error'] = "Your password should include at least 1 Uppercase letter, 1 digit and be at least 5 char length";
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
        $_SESSION['error'] = "Avatar's size must less than 10 KB";
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

unset($_SESSION['userName']);
unset($_SESSION['userSurname']);
unset($_SESSION['userEmail']);
unset($_SESSION['Login']);
$_SESSION['error'] = "Регистрация завершена";
header('Location: login.php');

die();
