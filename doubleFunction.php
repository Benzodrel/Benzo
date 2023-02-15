<?php
require_once 'func2.php';
require_once 'func3.php';
require_once 'randomNumGen.php';

$f = fopen(__DIR__.'/Test_cases.txt', 'w+');
$count = $argv[1];

while ($count > 0) {
    $randomCharNum = mt_rand(1, $argv[2]);
    $count--;
    file_put_contents(__DIR__.'/Test_cases.txt',  randomStr($randomCharNum), FILE_APPEND);
    if ($count != 0)
    file_put_contents(__DIR__.'/Test_cases.txt', "\n", FILE_APPEND);
}
$str = '';
while (!feof($f)) {
    $str = trim((fgets($f)),"\r\n");
    if (isClosed1($str) === isClosedStack($str)) {
        echo "Test Passed\n";
    } else {
        echo (isClosed1($str))?"true":"false";
        echo "!=";
        echo (isClosedStack($str))?"true":"false";
        echo $str . " - " . "Test Failed\n";
    }
}
fclose($f);



