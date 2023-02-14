<?php

function isClosed1($bra) :string|bool
{

    if (strlen($bra) % 2 != 0) {
        echo "false";
        return false;
    }
    $a = strlen($bra)/2;
    while ($a>0) {
        $bra = preg_replace('/{}/', '', $bra);
        //if ($bra == '')return true;
        $bra = preg_replace('/\(\)/', '', $bra);
        $bra = preg_replace('/\[]/', '', $bra);
        $a--;
    }
if ($bra == '') return true;
return false;


}
if (($_GET['name']!="")) {
    echo "STR CHANGE RESULT FUNCTION";
    var_dump(isClosed1($_GET['name']));
    include_once "func3.php";
}

   
