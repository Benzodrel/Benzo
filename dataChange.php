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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
</head>
<body>
<header>

</header>
<main>
    <section class="text-center">
        <h1>Изменение данных пользователя</h1>
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
            <p><input type="text" name="userName" placeholder="Enter New Name"></p>
            <p><input type="text" name="userSurname" placeholder="Enter New Surname"></p>
            <p><input type="text" name="userEmail" placeholder="Enter New E-mail"></p>
            <p><input type="password" name="userPassword" placeholder="Enter New Password"></p>
            <p><input type="password" name="userPasswordConfirm" placeholder="Confirm New Password"></p>
            <p><a href="index.php">Вернуться на страницу пользователя</a></p>
            <button type="submit" class="btn btn-primary">Послать изменения данных</button>
        </form>
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