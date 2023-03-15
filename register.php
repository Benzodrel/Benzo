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
ob_start();
require_once( 'headerTemplate.php' );
$output = ob_get_clean();
echo $output;
?>
<body>
<header>
</header>
<main>
    <section class="text-center">
        <h1>Страница регистрации</h1>
        <form action="registerHandler.php" method="post" enctype="multipart/form-data" class="">
            <p><input type="text" name="registerData[name]"  required placeholder="Name" value="<?php getValues('userName') ?>">
            </p>
            <p><input type="text" name="registerData[surname]" required placeholder="Surname"
                      value="<?php getValues('userSurname') ?>"></p>
            <p><input type="email" name="registerData[email]" required placeholder="Email@mailbox.com"
                      value="<?php getValues('userEmail') ?>"></p>
            <?php
            if (isset($_SESSION['error']['Email'])) {
                echo "<p class='text-danger'>{$_SESSION['error']['Email']}</p>";
            }
            ?>
            <p><input type="text" name="registerData[Login]" required placeholder="Login" value="<?php getValues('Login') ?>"></p>
            <?php
            if (isset($_SESSION['error']['Login'])) {
                echo "<p class='text-danger'>{$_SESSION['error']['Login']}</p>";
            }
            ?>
            <p><input type="password" name="registerData[userPassword]" required placeholder="Enter Password"></p>
            <?php
            if (isset($_SESSION['error']['Password'])) {
                echo "<p class='text-danger'>{$_SESSION['error']['Password']}</p>";
            }
            ?>
            <p><input type="password" name="registerData[userPasswordConfirm]" required placeholder="Confirm Password"></p>
            <p>Avatar: <input type="file" name="avatar"></p>
            <?php
            if (isset($_SESSION['error']['Avatar1'])) {
                echo "<p class='text-danger'>{$_SESSION['error']['Avatar1']}</p>";
            }
            if (isset($_SESSION['error']['Avatar2'])) {
                echo "<p class='text-danger'>{$_SESSION['error']['Avatar2']}</p>";
            }
            ?>
            <p>
                <button type="submit" class="btn btn-primary">Register</button>
            </p>
        </form>
        <?php
        if (isset($_SESSION['error']['register'])) {
            echo "<p class='text-danger'>{$_SESSION['error']['register']}</p>";
        }
        if (isset($_SESSION['error']['saveData'])) {
            echo "<p class='text-danger'>{$_SESSION['error']['saveData']}</p>";
        }
        unset($_SESSION['error']);
        ?>
        <p><a href="login.php">Уже зарегистрированы?</a></p>
    </section>
</main>
<footer>
</footer>
</body>
</html>