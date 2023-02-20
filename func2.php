<?php

function isClosed1(string $bracket): bool
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
    return $bracket === '';

}
   
