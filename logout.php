<?php
session_start();
setcookie('logged', '', time()-1);
unset($_SESSION['logged']);
header('Location: login.php');
die();