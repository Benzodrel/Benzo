<?php
function frameDecode(string $frame,&$frameArr){

    $f=array_values(unpack("C*",$frame));

    //first byte
    $fin = (bool) ($f[0] & 128 );
    $rsv1= (bool) ($f[0] & 64  );
    $rsv2= (bool) ($f[0] & 32  );
    $rsv3= (bool) ($f[0] & 16  );
    $opcode= $f[0]  & 15;

    //second byte
    $hasmask=(bool) ($f[1] & 128) ; // mask value on 1 bit
    $primaryLength=$f[1] & 127; //primary length value on 7 bits

    //compute length
    if($primaryLength<=125){
        $headerLength=2;
        $length=$primaryLength;
    }
    elseif( $primaryLength==126){
        $headerLength=4;
        $length=unpack("nhead/nlength",$frame)['length'];//unpack as big endian 16 bit

    }
    elseif ($primaryLength==127){
        $headerLength=10;
        $length=unpack("nhead/Jlength",$frame)['length'];//upack as big endian 64 bit
    }

    $payloadOffset=$hasmask?$headerLength+4:$headerLength;



    //Without extensions involved, there shouldn't be anything beyond the payload inside the frame, however we limit the array slice to $length.
    $payload=array_slice($f,$payloadOffset,$length);

    if ($hasmask)
    {
        $mask= array_slice($f,$headerLength,4);
        $i=0;
        foreach($payload as &$chr){

            $m=$mask[$i % 4];
            $chr= chr($chr ^ $m); //unmask
            $i++;
        }
    }
    else{
        foreach ($payload as &$chr)
            $chr = chr($chr); //turn int to character
    }


    $frameArr=compact('fin','rsv1','rsv2','rsv3','length','hasmask','opcode','payloadOffset','headerLength');

    return implode("",$payload);
}