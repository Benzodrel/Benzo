<?php
function inFile(int $count, int $randmax)
{
    while ($count > 0) {
        $randomCharNum = mt_rand(1, $randmax);
        $count--;
       file_put_contents(__DIR__ . '/Test_cases.txt', randomStr($randomCharNum), FILE_APPEND);
        if ($count != 0) {
            file_put_contents(__DIR__ . '/Test_cases.txt', "\n", FILE_APPEND);
        }
    }
}