<?php
session_start();
if (!isset($_SESSION['logged'])) {
    header('Location: login.php');
    die();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Страница пользователя</title>
    <link rel="stylesheet" href="./style.css">
</head>
<body>
<header>
    <h1>Изменение данных пользователя</h1>
</header>
<main>

    <form action="dataChangeHandler.php" method="post" enctype="multipart/form-data">
        <img src= <?php
        if (file_exists("images/{$_SESSION['logged']}.png")) {
            echo "images/{$_SESSION['logged']}.png";
        } else {
            echo "images/default.png";
        }
        ?>
        >
        <input type="file" name="avatar">
        <p>Your Name:<?= file("users/{$_SESSION['logged']}.txt")[1] ?></p>
        <input type="text" name="userName">
        <p>Your Surname:<?= file("users/{$_SESSION['logged']}.txt")[2] ?></p>
        <input type="text" name="userSurname">
        <p>Your E-mail:<?= file("users/{$_SESSION['logged']}.txt")[3] ?></p>
        <input type="text" name="userEmail">
        <p>Change Password</p>
        <input type="password" name="userPassword">
        <p>Confirm New Password</p>
        <input type="password" name="userPasswordConfirm">
        <p><a href="index.php">Вернуться на страницу пользователя</a></p>
        <button type="submit">Послать изменения данных</button>
    </form>
    <?php
    if (isset($_SESSION['error'])) {
        echo "<p> {$_SESSION['error']} </p>";
        unset($_SESSION['error']);
    }
    ?>
</main>
<footer>
</footer>
</body>
</html>