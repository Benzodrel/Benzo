<?php
session_start();
if (!isset($_SESSION['logged'])) {
    header('Location: login.php');
    die();
}
$header = 'Страница пользователя';
require_once "headerTemplate.php";
?>
<body>
<header>
</header>
<main>
    <div class="container">
        <div class="row">
    <div class = "col">
        <h1>Страница пользователя</h1>
    <img src= <?php
    if (file_exists("images/{$_SESSION['logged']}.png")) {
        echo "images/{$_SESSION['logged']}.png";
    } else {
        echo "images/default.png";
    }
    ?>
    >
    <p>Your Name:<?= json_decode(file_get_contents("users/{$_SESSION['logged']}.json"), true)['Name'] ?></p>
    <p>Your Surname:<?= json_decode(file_get_contents("users/{$_SESSION['logged']}.json"), true)['Surname'] ?></p>
    <p>Your E-mail:<?= json_decode(file_get_contents("users/{$_SESSION['logged']}.json"), true)['Email'] ?></p>
    <p><a href="dataChange.php">Изменить личные данные</a></p>
    <form action="logout.php" method="post">
        <button type="submit" class = "btn btn-primary">Logout</button>
    </form>
    <?php
    if (isset($_SESSION['message'])) {
        echo "<p class='text-success'>{$_SESSION['message']}</p>";
        unset($_SESSION['message']);
    }
    ?>
    </div>
    <div class = "col">
    <h2>Остальные пользователи</h2>
    <?php
    if (count(glob('users/*.json')) <= 1) {
        echo "Нет других пользователей";
        die();
    }
    foreach (glob('users/*.json') as $i) {
        if (ltrim(rtrim($i, '.json'), 'users/') !== $_SESSION['logged']) {
            echo ltrim(rtrim($i, '.json'), 'users/') . '<br>';
        }
    }
    ?>
    </div>
        </div>
    </div>
</main>
<footer>
</footer>
</body>
</html>
