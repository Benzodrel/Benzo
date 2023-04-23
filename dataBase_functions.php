<?php

// index.php
function getUserData(string $login): array
{
    require 'config.php';

    $connect = mysqli_connect($host, $username, $password, $databaseName);
    $sql = "SELECT `name`, `surname`, `email`, `password` FROM `users` WHERE `login` = '{$login}' ";
    $result = mysqli_query($connect, $sql);
    $arr = mysqli_fetch_assoc($result);
    mysqli_close($connect);
    return $arr;
}
//assist functions

function isUserExists(string $data): bool {
    require "config.php";

    $connect = mysqli_connect($host, $username, $password, $databaseName);
    $sql = "SELECT `login` FROM `users` WHERE EXISTS (SELECT `login` FROM `users` WHERE `login` = ?)";
    $result = mysqli_execute_query($connect, $sql, [$data]);
    $arr =  mysqli_fetch_assoc($result);
    mysqli_close($connect);
    if ($arr !== NULL) {
        return true;
    }
    return false;
}

//assist functions
function isEmailExists(string $email): bool
{
    require "config.php";
    $connect = mysqli_connect($host, $username, $password, $databaseName);
    $sql = "SELECT `email` FROM `users` WHERE EXISTS (SELECT `email` FROM `users` WHERE `email` = ?)";
    $result = mysqli_execute_query($connect, $sql, [$email]);
    $arr = mysqli_fetch_assoc($result);
    if ($arr !== NULL) {
        return true;
    }
    return false;
}

//login handler
function getLoginPassword (string $login): array {
    require "config.php";

    $connect = mysqli_connect($host, $username, $password, $databaseName);
    $sql = "SELECT `login`, `password` FROM `users` WHERE `login` = ? ";
    $result = mysqli_execute_query($connect, $sql, [$login]);
    $arr = mysqli_fetch_assoc($result);
    mysqli_close($connect);
   return $arr;
}


//register handler
function insertUserData(array $data) {
    require "config.php";

    $connect = mysqli_connect($host, $username, $password, $databaseName);
    $stmt = mysqli_prepare($connect, "INSERT INTO `users` (login, name, surname, email, password) VALUES (?,?,?,?,?)");
    mysqli_stmt_bind_param($stmt, 'sssss', $data['Login'], $data['Name'], $data['Surname'], $data['Email'], $data['Password']);
    mysqli_stmt_execute($stmt);
    mysqli_close($connect);
}
//data change handler
function updateUserData ($newData, $login) {
    require "config.php";

    $connect = mysqli_connect($host, $username, $password, $databaseName);
    $sql = "UPDATE `users` SET `name` = ?, surname = ?, email = ?, `password` = ? WHERE `login` = '{$login}'";
    mysqli_execute_query($connect, $sql, $newData);
    mysqli_close($connect);

}
//echo users
function getOtherUsers (string $login): array {
    require 'config.php';
    $arr = [];
    $dataBase = mysqli_connect($host, $username, $password, $databaseName);
    $sql = "SELECT `login` FROM `users` WHERE `login` != '{$login}' ";
    $query = mysqli_query($dataBase, $sql);
    while ($row = mysqli_fetch_assoc($query)) {
        if ($row['login'] === NULL) {
            array_push($arr, "Нет других пользователей");
        }
        array_push($arr, $row['login']);
    }
    mysqli_close($dataBase);
    return $arr;
}
//websocket
function getAllUsers() {
    require 'config.php';
    $arr = [];
    $dataBase = mysqli_connect($host, $username, $password, $databaseName);
    $sql = "SELECT `login` FROM `users` ";
    $query = mysqli_query($dataBase, $sql);
    while ($row = mysqli_fetch_assoc($query)) {
        if ($row['login'] === NULL) {
            array_push($arr, "Нет других пользователей");
        }
        array_push($arr, $row['login']);
    }
    mysqli_close($dataBase);
    return $arr;
}


