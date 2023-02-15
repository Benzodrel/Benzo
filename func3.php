<?php

function isClosedStack($bracket): bool
{
    $stack = [];
    $initSymbol = ['[', '(', '{'];
    $completeSym = ['[]', '()', "{}"];

    for ($i = 0; $i < strlen($bracket); $i++) {
        $current = $bracket[$i];
        if (in_array($current, $initSymbol)) {
            array_push($stack, $current);
        } else {
            $prev = array_pop($stack);
            $match = "$prev$current";
            if (!in_array($match, $completeSym)) return false;
        }
    }
    return count($stack) === 0;
}