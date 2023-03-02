<?php
session_start();

if (!isset($_SESSION['logged'])) {
    header('Location: login.php');
    die();
}
$header = 'Изменение данных пользователя';
require_once "headerTemplate.php";
?>
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
            <?php
            if (isset($_SESSION['error']['Avatar1'])) {
                echo "<p class='text-danger'>{$_SESSION['error']['Avatar1']}</p>";
                unset($_SESSION['error']['Avatar1']);
            }
            if (isset($_SESSION['error']['Avatar2'])) {
                echo "<p class='text-danger'>{$_SESSION['error']['Avatar2']}</p>";
                unset($_SESSION['error']['Avatar2']);
            }
            ?>
            <p><input type="text" name="userName" placeholder="Enter New Name"></p>
            <p><input type="text" name="userSurname" placeholder="Enter New Surname"></p>
            <p><input type="text" name="userEmail" placeholder="Enter New E-mail"></p>
            <?php
            if (isset($_SESSION['error']['Email'])) {
                echo "<p class='text-danger'>{$_SESSION['error']['Email']}</p>";
                unset($_SESSION['error']['Email']);
            }
            ?>
            <p><input type="password" name="userPassword" placeholder="Enter New Password"></p>
            <?php
            if (isset($_SESSION['error']['Password'])) {
                echo "<p class='text-danger'>{$_SESSION['error']['Password']}</p>";
                unset($_SESSION['error']['Password']);
            }
            ?>
            <p><input type="password" name="userPasswordConfirm" placeholder="Confirm New Password"></p>
            <p><a href="index.php">Вернуться на страницу пользователя</a></p>
            <button type="submit" class="btn btn-primary">Послать изменения данных</button>
        </form>
        <?php
        if (isset($_SESSION['error']['change'])) {
            echo "<p class='text-danger'> {$_SESSION['error']['change']} </p>";
            unset($_SESSION['error']['change']);
        }
        ?>
    </section>
</main>
<footer>
</footer>
</body>
</html>