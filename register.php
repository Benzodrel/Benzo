<?php
session_start();
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
    <h1>Страница регистрации</h1>
</header>
<main>
    <form action="registerHandler.php" method="post" enctype="multipart/form-data">
        <p>Name: <input type="text" name="userName" required></p>
        <p>Surname: <input type="text" name="userSurname" required></p>
        <p>Email: <input type="email" name="userEmail" required></p>
        <p>Login: <input type="text" name="Login" required></p>
        <p>Password: <input type="password" name="userPassword" required></p>
        <p>Confirm Password: <input type="password" name="userPasswordConfirm" required></p>
        <p>Avatar: <input type="file" name="avatar"></p>
        <p>
            <button type="submit">Register</button>
        </p>
    </form>
    <?php
    if (isset($_SESSION['error'])) {
        echo "<p>{$_SESSION['error']}</p>";
        unset($_SESSION['error']);
    }
    ?>
    <p><a href="login.php">Уже зарегистрированы?</a></p>
</main>
<footer>
</footer>
</body>
</html>