<?php
function frameEncode(string $payload,int $opcode=1,bool $fin=true,bool $mask=false){
    $first=0;
    $first  |= $fin?128:0;      //set final
    $first  |= ($opcode & 15);   //restrain opcode to the first 4 bits anyway.

    $length=strlen($payload);

    $second=0;
    $second |= $mask?128:0;     //set mask
    if($length <=125 ){
        $headerLength=2;
        $second |= $length;
    }
    elseif($length < (2**16)) {//fits in 2 bytes
        $headerLength=4;
        $second |= 126;
        $extraLength=pack("n",$length);
    }
    else {
        $headerLength=10;
        $second |= 127;
        $extraLength=pack("J",$length);
    }
    $header =chr($first).chr($second);
    $header.= $extraLength??"";

    if($mask){
        $mask=openssl_random_pseudo_bytes(4);

        if(!$mask) throw new Exception("Can't generate random mask");
        $header.=$mask;
        $payloadArr =str_split($payload);
        $maskArr    =str_split($mask);
        for($i=0;$i<$length;$i++){
            $m=$maskArr[$i % 4];

            $payloadArr[$i] ^= $m;
        }

        $payload=implode("",$payloadArr);
    }
    return $header.$payload;
}
