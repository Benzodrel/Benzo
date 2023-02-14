<?php

function isClosedStack($bra):bool {
    $stack = [];
    $initSym = ['[', '(', '{'];
    $completeSym = ['[]', '()', "{}"];

    for ($i = 0; $i < strlen($bra); $i++) {
        $b = $bra[$i];
        if (in_array($b, $initSym)) {
            array_push($stack, $b);
        } else {
            $a = array_pop($stack);
            $match = "$a$b";
            if (!in_array($match, $completeSym)) return false;
        }
    }return true;
}
echo "FUNCTION STACK RESULT:";
var_dump(isClosedStack($_GET["name"]));