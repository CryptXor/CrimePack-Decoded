<?php 
function EncryptVB($string)
{
    $content = "";
    for( $i = 0; $i < strlen($string); $i++ ) 
    {
        $content .= ord($string[$i]) . ",";
    }
    $content = substr($content, 0, 0 - 1);
    return $content;
}

function SmallRand($len)
{
    $p = "";
    do
    {
        $c = mt_rand(1, 2);
        switch( $c ) 
        {
            case 1:
                $p .= chr(mt_rand(65, 90));
                break;
        }
    }
    while( strlen($p) < $len );
    return $p;
}

function getChar($length, $cc)
{
    $srt_array = array(  );
    $a = 0;
    while( $a <= $cc ) 
    {
        $p = smallrand(1);
        if( !in_array($p, $srt_array) ) 
        {
            $srt_array[] = $p;
            $a++;
        }
        else
        {
            $a--;
            continue;
        }

    }
    return $srt_array;
}


