<?php
require_once 'func2.php';
require_once 'func3.php';
require_once 'randomNumGen.php';
require_once 'generatedStrInFile.php';

if ($argc != 3) {
    echo "Wrong number of Arguments";
    die();
}
if (!ctype_digit($argv[1]) || !ctype_digit($argv[2])) {
    echo "ERROR: Input should be integer";
    die();
}
if (!($argv[1] != 0 && $argv[2] != 0 && $argv[1] < 100 && $argv[2] < 100)) {
    echo "ERROR: Please input correct int numbers from 1 to 99";
    die();
}
if (is_writable(__DIR__ . '/Test_cases.txt') === false && file_exists(__DIR__ . '/Test_cases.txt') === true) {
    echo "Read/create file ERROR";
    die();
}
$file = fopen(__DIR__ . '/Test_cases.txt', 'w+');
if ($file === false) {
    echo "Unexpected error, file cant be opened";
    die();
}
$count = $argv[1];
$randmax = $argv[2];

inFile($count, $randmax);

$str = '';
while (!feof($file)) {
    $str = trim((fgets($file)), "\r\n");
    $isClosed1Result = isClosed1($str);
    $isClosed2Result = isClosedStack($str);
    if ($isClosed1Result === $isClosed2Result) {
        echo "Test Passed\n";
    } else {
        echo ($isClosed1Result) ? "true" : "false";
        echo "!=";
        echo ($isClosed2Result) ? "true" : "false";
        echo $str . " - " . "Test Failed\n";
    }
}
fclose($file);






