<?php
session_start();
require_once 'dataBase_functions.php';

$arr = getOtherUsers($_SESSION['logged']);
echo json_encode($arr, JSON_UNESCAPED_UNICODE | JSON_FORCE_OBJECT);
