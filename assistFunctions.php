<?php
const MAX_UPLOAD_IMAGE_SIZE_BYTE = 10000;
function isEmailExists($email): bool
{
    if (glob("users/*.json") === false) {
        return false;
    }
    foreach (glob("users/*.json") as $file) {
        if (json_decode(file_get_contents($file), true)["Email"] === $email) {
            return true;
        }
    }
    return false;
}

function getValidatedData(array $data, array $image): array
{
    $arrData = [];
    $arrError = [];
    if (!empty($data['Login'])) {
        if (file_exists("users/{$data["Login"]}.json")) {
            $arrError['Login'] = "This user is already exists";
        } else {
            $arrData['Login'] = $data['Login'];
        }
    }
    if (!empty($data['userEmail'])) {
        if (filter_var($data["userEmail"], FILTER_VALIDATE_EMAIL) === false) {
            $arrError['Email'] = "Enter correct E-mail";
        } elseif (isEmailExists($data['userEmail'])) {
            $arrError['Email'] = "Another user already have this E-mail";
        } else {
            $arrData['Email'] = $data['userEmail'];
        }
    }
    if (!empty($data['userPassword'])) {
        if (!preg_match('/(?=.*[A-Z])(?=.*?\d).{5,}/', $data['userPassword'])) {
            $arrError['Password'] = "Your password should include at least 1 Uppercase letter, 1 digit and be at least 5 char length";
        } elseif ($data["userPassword"] !== $data["userPasswordConfirm"]) {
            $arrError['Password'] = "Passwords don't match";
        } else {
            $arrData['Password'] = md5($data['userPasswordConfirm']);
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
    $arrData['Name'] = $data['userName'];
    $arrData['Surname'] = $data['userSurname'];
    return array("error" => $arrError, "data" => $arrData);
}