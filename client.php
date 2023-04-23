<?php
session_start();
if (!isset($_SESSION['logged'])) {
    header('Location: login.php');
    die();
}
require_once 'dataBase_functions.php';
$arr = getUserData($_SESSION['logged']);


$header = 'Страница пользователя';
ob_start();
require_once('headerTemplate.php');
$output = ob_get_clean();
echo $output;
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
                <p id="login"><?= $_SESSION['logged'] ?></p>
                <p>Your Name:<?= $arr['name'] ?></p>
                <p>Your Surname:<?= $arr['surname'] ?></p>
                <p>Your E-mail:<?= $arr['email'] ?></p>
                <p><a href="index.php">Вернуться</a></p>
                <form action="logout.php" method="post">
                    <button type="submit" class="btn btn-primary">Logout</button>
                </form>
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
    let session = document.getElementById('login').innerHTML;

    const host = 'ws://127.0.0.1:12345/';
    socketFun(host);
    function socketFun(hostAddress) {

        let socket = new WebSocket(hostAddress);

        socket.onmessage = function (event) {
            document.getElementById("text").innerHTML = '';

            let json = JSON.parse(event.data);
            let z = 1;
            for (let i in json) {
                if (json[i] !== session) {
                    document.getElementById("text").innerHTML += '<p>' + z + ' - ' + json[i] + '</p>';
                    z++;
                }

            }
        }

        socket.onclose = () => {
            document.getElementById("text").innerHTML = "Socket error";
            setTimeout(() => socketFun(), 4000);
            socket.close();
        }
    }
</script>
</body>
</html>
