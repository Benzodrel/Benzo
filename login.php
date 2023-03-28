<?php
session_start();

if (isset($_COOKIE['logged'])) {
    require_once 'config.php';
    $connect = mysqli_connect($host, $username, $password, $databaseName);
    if ($connect === false) {
        $_SESSION['error']['saveData'] = "Ошибка подключения в базе данных";
        header('Location: login.php');
        die();
    }
    $sql = "SELECT `password` FROM `users` WHERE `login` = '{$_COOKIE['logged']}' ";
    $result = mysqli_query($connect, $sql);
    $arr = mysqli_fetch_assoc($result);
    $dbLogin = $arr['login'];
    $dbPassword = $arr['password'];
    if ($arr['password'] === $dbPassword) {
        $_SESSION['logged'] = $_COOKIE['logged'];
    }
    header('Location: index.php');
    die();
}
if (isset($_SESSION['logged'])) {
    header('Location: index.php');
    die();
}
$header = 'Страница входа';
ob_start();
require_once( 'headerTemplate.php' );
$output = ob_get_clean();
echo $output;
?>
<body>
<header>
</header>"
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
        if (isset($_SESSION['message'])) {
            echo "<p class='text-success'> {$_SESSION['message']} </p>";
            unset($_SESSION['message']);
        }
        if (isset($_SESSION['error']['enter'])) {
            echo "<p class='text-danger'> {$_SESSION['error']['enter']} </p>";
            unset($_SESSION['error']['enter']);
        }
        if (isset($_SESSION['error']['save'])) {
            echo "<p class='text-danger'>{$_SESSION['error']['save']}</p>";
            unset($_SESSION['error']['save']);
        }
        ?>
    </section>
</main>
<footer>
</footer>
</body>
</html>