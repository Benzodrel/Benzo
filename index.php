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
    <h1>Страница пользователя</h1>
</header>
<main>
    <img src= <?php
    if (file_exists("images/{$_SESSION['logged']}.png")) {
        echo "images/{$_SESSION['logged']}.png";
    } else {
        echo "images/default.png";
    }
    ?>
    >
    <p>Your Name:<?= file("users/{$_SESSION['logged']}.txt")[1] ?></p>
    <p>Your Surname:<?= file("users/{$_SESSION['logged']}.txt")[2] ?></p>
    <p>Your E-mail:<?= file("users/{$_SESSION['logged']}.txt")[3] ?></p>
    <p><a href="dataChange.php">Изменить личные данные</a></p>
    <form action="logout.php" method="post">
        <button type="submit">Logout</button>
    </form>
    <h2>Остальные пользователи</h2>
    <?php
    if (count(glob('users/*.txt')) <= 1) {
        echo "Нет других пользователей";
        die();
    }
    foreach (glob('users/*.txt') as $i) {
        if (ltrim(rtrim($i, '.txt'), 'users/') !== $_SESSION['logged']) {
            echo ltrim(rtrim($i, '.txt'), 'users/') . '<br>';
        }
    }
    ?>
    <?php
    if (isset($_SESSION['error'])) {
        echo "<p>{$_SESSION['error']}</p>";
        unset($_SESSION['error']);
    }
    ?>
</main>
<footer>
</footer>
</body>
</html>
