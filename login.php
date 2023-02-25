<?php
session_start();
if (isset($_SESSION['logged'])) {
    header('Location: index.php');
    die();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Страница регистрации</title>
    <link rel="stylesheet" href="./style.css">
</head>
<body>
<header>
    <h1>Страница входа</h1>
</header>
<main>
    <form action="loginHandler.php" method="post">
        <p>Login: <input type="text" name="Login" required></p>
        <p>Password: <input type="password" name="userPassword" required></p>
        <p>
            <button type="submit">Login</button>
        <p>
    </form>
    <p><a href="register.php">Регистрация</a></p>
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