<?php
const MAX_UPLOAD_IMAGE_SIZE_BYTE = 10000;

function isEmailExists(string $email): bool
{
    require "config.php";
    $connect = mysqli_connect($host, $username, $password, $databaseName);
    $sql = "SELECT `email` FROM `users` WHERE `email` = ?";
    $result = mysqli_execute_query($connect, $sql, [$email]);
    $arr = mysqli_fetch_assoc($result);
    if ($arr !== NULL) {
        return true;
    }
    return false;
}


function getValidatedDataChange(array $data, array $image): array
{
    $arrData = [];
    $arrError = [];
    require "config.php";
    if (!empty($data['Login'])) {
        $connect = mysqli_connect($host, $username, $password, $databaseName);
        $sql = "SELECT `login` FROM `users` WHERE `login` = ?";
        $result = mysqli_execute_query($connect, $sql, [$data['Login']]);
        $arr = mysqli_fetch_assoc($result);
        if ($arr !== NULL) {
            $arrError['Login'] = "This user is already exists";
        } else {
            $arrData['login'] = $data['Login'];
        }
    }
    if (!empty($data['email'])) {
        if (filter_var($data["email"], FILTER_VALIDATE_EMAIL) === false) {
            $arrError['Email'] = "Enter correct E-mail";
        } elseif (isEmailExists($data['email'])) {
            $arrError['Email'] = "Another user already have this E-mail";
        } else {
            $arrData['email'] = $data['email'];
        }
    }
    if (!empty($data['userPassword'])) {
        if (!preg_match('/(?=.*[A-Z])(?=.*?\d).{5,}/', $data['userPassword'])) {
            $arrError['Password'] = "Your password should include at least 1 Uppercase letter, 1 digit and be at least 5 char length";
        } elseif ($data["userPassword"] !== $data["userPasswordConfirm"]) {
            $arrError['Password'] = "Passwords don't match";
        } else {
            $arrData['password'] = $data['userPasswordConfirm'];
        }
    }
    if (is_uploaded_file($image['avatar']['tmp_name'])) {
        if ($image['avatar']['size'] >= MAX_UPLOAD_IMAGE_SIZE_BYTE) {
            $arrError['Avatar1'] = "Avatar's size must less than 10 KB";
        }
        if ($image['avatar']['type'] !== 'image/png') {
            $arrError['Avatar2'] = "Avatar must be .png";
        }
    }
    if (!empty($data['name'])) {
        $arrData['name'] = $data['name'];
    }
    if (!empty($data['surname'])) {
        $arrData['surname'] = $data['surname'];
    }
    return ["error" => $arrError, "data" => $arrData];
}


function getValidatedData(array $data, array $image): array
{
    $arrData = [];
    $arrError = [];
    require "config.php";
    $connect = mysqli_connect($host, $username, $password, $databaseName);
    $sql = "SELECT `login` FROM `users` WHERE `login` = ?";
    $result = mysqli_execute_query($connect, $sql, [$data['Login']]);
    $arr = mysqli_fetch_assoc($result);
    if ($arr !== NULL) {
        $arrError['Login'] = "This user is already exists";
    } else {
        $arrData['Login'] = $data['Login'];
    }
    if (filter_var($data["email"], FILTER_VALIDATE_EMAIL) === false) {
        $arrError['Email'] = "Enter correct E-mail";
    } elseif (isEmailExists($data['email'])) {
        $arrError['Email'] = "Another user already have this E-mail";
    } else {
        $arrData['Email'] = $data['email'];
    }
    if (!preg_match('/(?=.*[A-Z])(?=.*?\d).{5,}/', $data['userPassword'])) {
        $arrError['Password'] = "Your password should include at least 1 Uppercase letter, 1 digit and be at least 5 char length";
    } elseif ($data["userPassword"] !== $data["userPasswordConfirm"]) {
        $arrError['Password'] = "Passwords don't match";
    } else {
        $arrData['Password'] = $data['userPasswordConfirm'];
    }
    if (is_uploaded_file($image['avatar']['tmp_name'])) {
        if ($image['avatar']['size'] >= MAX_UPLOAD_IMAGE_SIZE_BYTE) {
            $arrError['Avatar1'] = "Avatar's size must less than 10 KB";
        }
        if ($image['avatar']['type'] !== 'image/png') {
            $arrError['Avatar2'] = "Avatar must be .png";
        }
    }
    $arrData['Name'] = $data['name'];
    $arrData['Surname'] = $data['surname'];
    return ["error" => $arrError, "data" => $arrData];
}
