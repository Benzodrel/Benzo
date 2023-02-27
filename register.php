<?php
session_start();

function getValues($value) {
    if (isset($_SESSION[$value])){
        echo $_SESSION[$value];
    }
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
    <h1>Страница регистрации</h1>
    <form action="registerHandler.php" method="post" enctype="multipart/form-data" class = "">
        <p><input type="text" name="userName" required placeholder="Name" value = "<?php getValues('userName')?>"></p>
        <p><input type="text" name="userSurname" required placeholder="Surname" value = "<?php getValues('userSurname')?>"></p>
        <p><input type="email" name="userEmail" required placeholder="Email@mailbox.com" value = "<?php getValues('userEmail')?>"></p>
        <p><input type="text" name="Login" required placeholder="Login"  value = "<?php getValues('Login')?>"></p>
        <p><input type="password" name="userPassword" required placeholder="Enter Password"></p>
        <p><input type="password" name="userPasswordConfirm" required placeholder="Confirm Password"></p>
        <p>Avatar: <input type="file" name="avatar" ></p>
        <p>
            <button type="submit" class = "btn btn-primary">Register</button>
        </p>
    </form>
    <?php
    if (isset($_SESSION['error'])) {
        echo "<p>{$_SESSION['error']}</p>";
        unset($_SESSION['error']);
    }
    ?>
    <p><a href="login.php">Уже зарегистрированы?</a></p>
    </section>
</main>
<footer>
</footer>
</body>
</html>