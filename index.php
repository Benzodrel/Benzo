<?php
session_start();
if (!isset($_SESSION['logged'])) {
    header('Location: login.php');
    die();
}
$header = 'Страница пользователя';
ob_start();
require_once('headerTemplate.php');
$output = ob_get_clean();
echo $output;

require_once 'config.php';
$connect = mysqli_connect($host, $username, $password, $databaseName);
if ($connect === false) {
    $_SESSION['error']['saveData'] = "Ошибка подключения в базе данных";
    header('Location: login.php');
    die();
}
$sql = "SELECT `name`, `surname`, `email` FROM `users` WHERE `login` = '{$_SESSION['logged']}' ";
$result = mysqli_query($connect, $sql);
if ($result === false) {
    $_SESSION['error']['saveData'] = "Ошибка исполнения запроса";
    header('Location: login.php');
    die();
}
$arr = mysqli_fetch_assoc($result);
if ($arr === false) {
    $_SESSION['error']['saveData'] = "Ошибка формирования ассоциативного массива";
    header('Location: login.php');
    die();
}
mysqli_close($connect);
?>
<body>
<header>
</header>
<main>
    <div class="container">
        <div class="row">
            <div class="col">
                <h1>Страница пользователя</h1>
                <img src= <?php
                if (file_exists("images/{$_SESSION['logged']}.png")) {
                    echo "images/{$_SESSION['logged']}.png";
                } else {
                    echo "images/default.png";
                }
                ?>
                >
                <p>Your Name:<?= $arr['name'] ?></p>
                <p>Your Surname:<?= $arr['surname'] ?></p>
                <p>Your E-mail:<?= $arr['email'] ?></p>
                <p><a href="dataChange.php">Изменить личные данные</a></p>
                <p><a href="client.php">Посмотреть websocket версию</a></p>
                <form action="logout.php" method="post">
                    <button type="submit" class="btn btn-primary">Logout</button>
                </form>
                <?php
                if (isset($_SESSION['message'])) {
                    echo "<p class='text-success'>{$_SESSION['message']}</p>";
                    unset($_SESSION['message']);
                }
                ?>
            </div>
            <div class="col">
                <h2>Остальные пользователи</h2>
                <div id="text"></div>
            </div>
        </div>
    </div>
</main>
<footer>
</footer>
<script>
    window.onload = function () {
        setInterval(() => {
            userPrint()
        }, 1000);

        function userPrint() {
            let xhr = new XMLHttpRequest();
            xhr.open('GET', 'echoUsers.php');
            xhr.send();
            xhr.onload = function () {
                if (xhr.status === 200) {
                    document.getElementById("text").innerHTML = '';
                    let json = JSON.parse(xhr.response);
                    for (let i in json) {
                        document.getElementById("text").innerHTML += '<p>' + (parseInt(i) + 1) + ' - ' + json[i] + '</p>';
                    }
                } else {
                    document.getElementById("text").innerHTML = 'Ошибка запроса';
                }
            }
        }
    }
</script>
</body>
</html>
