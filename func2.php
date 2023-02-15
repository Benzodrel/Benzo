<?php

function isClosed1($bracket): bool
{
    if (strlen($bracket) % 2 != 0) {
        return false;
    }
    $a = strlen($bracket) / 2;
    while ($a > 0) {
        $bracket = str_replace('{}', '', $bracket);
        $bracket = str_replace('()', '', $bracket);
        $bracket = str_replace('[]', '', $bracket);
        $a--;
    }
    if ($bracket === '') return true;
    return false;
}
   
