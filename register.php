<?php
session_start();

function getValues($value)
{
    if (isset($_SESSION[$value])) {
        echo $_SESSION[$value];
        unset($_SESSION[$value]);
    }
}

$header = 'Страница Регистрации';
require_once "headerTemplate.php";
?>
<body>
<header>
</header>
<main>
    <section class="text-center">
        <h1>Страница регистрации</h1>
        <form action="registerHandler.php" method="post" enctype="multipart/form-data" class="">
            <p><input type="text" name="userName" required placeholder="Name" value="<?php getValues('userName') ?>">
            </p>
            <p><input type="text" name="userSurname" required placeholder="Surname"
                      value="<?php getValues('userSurname') ?>"></p>
            <p><input type="email" name="userEmail" required placeholder="Email@mailbox.com"
                      value="<?php getValues('userEmail') ?>"></p>
            <?php
            if (isset($_SESSION['error']['Email'])) {
                echo "<p class='text-danger'>{$_SESSION['error']['Email']}</p>";
                unset($_SESSION['error']['Email']);
            }
            ?>
            <p><input type="text" name="Login" required placeholder="Login" value="<?php getValues('Login') ?>"></p>
            <?php
            if (isset($_SESSION['error']['Login'])) {
                echo "<p class='text-danger'>{$_SESSION['error']['Login']}</p>";
                unset($_SESSION['error']['Login']);
            }
            ?>
            <p><input type="password" name="userPassword" required placeholder="Enter Password"></p>
            <?php
            if (isset($_SESSION['error']['Password'])) {
                echo "<p class='text-danger'>{$_SESSION['error']['Password']}</p>";
                unset($_SESSION['error']['Password']);
            }
            ?>
            <p><input type="password" name="userPasswordConfirm" required placeholder="Confirm Password"></p>
            <p>Avatar: <input type="file" name="avatar"></p>
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
            <p>
                <button type="submit" class="btn btn-primary">Register</button>
            </p>
        </form>
        <?php
        if (isset($_SESSION['message'])) {
            echo "<p class='text-danger'>{$_SESSION['message']}</p>";
            unset($_SESSION['message']);
        }
        ?>
        <p><a href="login.php">Уже зарегистрированы?</a></p>
    </section>
</main>
<footer>
</footer>
</body>
</html>