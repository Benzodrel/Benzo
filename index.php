<?php
session_start();
if (!isset($_SESSION['logged'])) {
    header('Location: login.php');
    die();
}
$header = 'Страница пользователя';
ob_start();
require_once( 'headerTemplate.php' );
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
                <?php $yourData = json_decode(file_get_contents("users/{$_SESSION['logged']}.json"), true) ?>
                <p>Your Name:<?= $yourData['Name'] ?></p>
                <p>Your Surname:<?= $yourData['Surname'] ?></p>
                <p>Your E-mail:<?= $yourData['Email'] ?></p>
                <p><a href="dataChange.php">Изменить личные данные</a></p>
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
                    document.getElementById("text").innerHTML ='';
                    let json = JSON.parse(xhr.response);
                    for (let i in  json) {
                        document.getElementById("text").innerHTML += '<p>'+(parseInt(i)+1)+' - '+json[i]+'</p>' ;
                    }
                } else {
                    return document.getElementById("text").innerHTML = 'Ошибка запроса';
                }
            }
        }
    }
</script>
</body>
</html>
