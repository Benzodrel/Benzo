<?php
session_start();
if (isset($_COOKIE['logged'])) {
    $_SESSION['logged'] = $_COOKIE['logged'];
    header('Location: index.php');
    die();
}
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
</head>
<body>
<header>

</header>
<main>
    <section class="text-center">
        <h1>Страница входа</h1>
        <form action="loginHandler.php" method="post">
            <p><input type="text" name="Login" required placeholder="Login"></p>
            <p><input type="password" name="userPassword" required placeholder="Password"></p>
            <p>
                <button type="submit" class="btn btn-primary">Login</button>
                <input type="checkbox" name="rememberMe"> Запомнить меня
            <p>

        </form>
        <p><a href="register.php">Регистрация</a></p>
        <?php
        if (isset($_SESSION['error'])) {
            echo "<p> {$_SESSION['error']} </p>";
            unset($_SESSION['error']);
        }
        ?>
    </section>
</main>
<footer>
</footer>
</body>
</html>