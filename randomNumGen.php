<?php
function randomStr($len = 5): string
{
    $baseSymbols = "{}()[]";
    $gen_str = '';
    while ($len > 0) {
        $gen_str .= $baseSymbols[mt_rand(0, strlen($baseSymbols) - 1)];
        $len--;
    }
    return $gen_str;
}