<?php 
set_time_limit(600);
include("config.inc.php");
include("CP-ENC-7531.php");
$siteslisted = "";
$totallist = 0;
$ListUrl = array( "http://www.malwaredomainlist.com/mdl.php?search=!!URL!!&inactive=on", "http://safeweb.norton.com/report/show?url=!!URL!!", "http://www.spamhaus.org/query/dbl?domain=!!URL!!", "http://hosts-file.net/?s=!!URL!!", "http://www.siteadvisor.com/lookup/?facet=sitereport&q=!!URL!!", "http://www.mywot.com/en/scorecard/!!URL!!", "http://malc0de.com/database/index.php?search=!!URL!!", "http://www.malwareurl.com/search.php?domain=&s=!!URL!!", "http://safebrowsing.clients.google.com/safebrowsing/diagnostic?site=!!URL!!" );
$ListPattern = array( "MDL" => "</nobr></td><td>", "SAFEWEB" => "red.png", "SPAMHAUS" => "is not listed in the DBL", "HPHOSTS" => "This site is currently listed in hpHosts", "SITEADVISOR" => "Red Verdict Image", "MYWOT" => "This site has a poor reputation", "MALC0DE" => "</nobr></td><td", "MALWAREURL" => "<wbr></div></td>", "SAFEBROWSING" => "Site is listed as suspicious" );
if( isset($_GET["URL"]) ) 
{
    $listed = "<img src=img/bad.png alt=\"Site is listed!\">";
    $ok = "<img src=img/good.png alt=\"Not listed :)\">";
    $count = 1;
    $checkurl = $_GET["URL"];
    if( !isset($_GET["summary"]) ) 
    {
        echo "<html><head><link rel=\"stylesheet\" href=\"img/style.css\"></head><body>\r\n\t\t<table class=\"tbl1\" width=\"550\">\r\n\t\t<tr>\r\n\t\t<td align=\"center\" class=\"td1\" width=\"400\"><b>Malware Database</b></td>\r\n\t\t<td align=\"center\" class=\"td1\" width=\"150\"><b>Status</b></td>\r\n\t\t</tr>";
        echo "<tr><td align='center' class='tdx" . $count . "' width='400'>Norton SafeWeb</td><td align='center' class='tdx" . $count . "' width='150'>" . ((checkmdl(1, $checkurl, $ListPattern["SAFEWEB"], 1) == 1 ? "<a href=" . str_replace("!!URL!!", $checkurl, $ListUrl[1]) . "><img src=img/bad.png alt=\"Site is listed!\" border=\"0\"></a>" : $ok)) . "</td></tr>";
        echo "<tr><td align='center' class='tdx" . $count . "' width='400'>My WebOfTrust</td><td align='center' class='tdx" . $count . "' width='150'>" . ((checkmdl(5, $checkurl, $ListPattern["MYWOT"], 1) == 1 ? "<a href=" . str_replace("!!URL!!", $checkurl, $ListUrl[5]) . "><img src=img/bad.png alt=\"Site is listed!\" border=\"0\"></a>" : $ok)) . "</td></tr>";
        echo "<tr><td align='center' class='tdx" . $count . "' width='400'>Malc0de</td><td align='center' class='tdx" . $count . "' width='150'>" . ((checkmdl(6, $checkurl, $ListPattern["MALC0DE"], 1) == 1 ? "<a href=" . str_replace("!!URL!!", $checkurl, $ListUrl[6]) . "><img src=img/bad.png alt=\"Site is listed!\" border=\"0\"></a>" : $ok)) . "</td></tr>";
        echo "<tr><td align='center' class='tdx" . $count . "' width='400'>Google Safe Browsing</td><td align='center' class='tdx" . $count . "' width='150'>" . ((checkmdl(8, $checkurl, $ListPattern["SAFEBROWSING"], 1) == 1 ? "<a href=" . str_replace("!!URL!!", $checkurl, $ListUrl[8]) . "><img src=img/bad.png alt=\"Site is listed!\" border=\"0\"></a>" : $ok)) . "</td></tr>";
        echo "<tr><td align='center' class='tdx" . $count . "' width='400'>Malwaredomainlist</td><td align='center' class='tdx" . $count . "' width='150'>" . ((checkmdl(0, $checkurl, $ListPattern["MDL"], 1) == 1 ? "<a href=" . str_replace("!!URL!!", $checkurl, $ListUrl[0]) . "><img src=img/bad.png alt=\"Site is listed!\" border=\"0\"></a>" : $ok)) . "</td></tr>";
        echo "<tr><td align='center' class='tdx" . $count . "' width='400'>Mcafee SiteAdvisor</td><td align='center' class='tdx" . $count . "' width='150'>" . ((checkmdl(4, $checkurl, $ListPattern["SITEADVISOR"], 1) == 1 ? "<a href=" . str_replace("!!URL!!", $checkurl, $ListUrl[4]) . "><img src=img/bad.png alt=\"Site is listed!\" border=\"0\"></a>" : $ok)) . "</td></tr>";
        echo "<tr><td align='center' class='tdx" . $count . "' width='400'>hpHosts</td><td align='center' class='tdx" . $count . "' width='150'>" . ((checkmdl(3, $checkurl, $ListPattern["HPHOSTS"], 1) == 1 ? "<a href=" . str_replace("!!URL!!", $checkurl, $ListUrl[3]) . "><img src=img/bad.png alt=\"Site is listed!\" border=\"0\"></a>" : $ok)) . "</td></tr>";
        echo "<tr><td align='center' class='tdx" . $count . "' width='400'>MalwareUrl</td><td align='center' class='tdx" . $count . "' width='150'>" . ((checkmdl(7, $checkurl, $ListPattern["MALWAREURL"], 1) == 1 ? "<a href=" . str_replace("!!URL!!", $checkurl, $ListUrl[7]) . "><img src=img/bad.png alt=\"Site is listed!\" border=\"0\"></a>" : $ok)) . "</td></tr>";
        echo "</tr></table>";
        if( 1 <= $totallist ) 
        {
            if( 2 < $totallist ) 
            {
                echo "<br><font color=red>WARNING!</font> Your site appears to be listed on " . $totallist . " dns blacklists!";
            }
            else
            {
                echo "<br><font color=orange>NOTE:</font> Your site appears to be listed on " . $totallist . " dns blacklists!";
            }

        }
        else
        {
            echo "<br><font color=darkgreen>Your site does not appear to be listed on any dns blacklists :)</font>";
        }

    }
    else
    {
        checkmdl(1, $checkurl, $ListPattern["SAFEWEB"], 1);
        checkmdl(5, $checkurl, $ListPattern["MYWOT"], 1);
        checkmdl(6, $checkurl, $ListPattern["MALC0DE"], 1);
        checkmdl(8, $checkurl, $ListPattern["SAFEBROWSING"], 1);
        checkmdl(0, $checkurl, $ListPattern["MDL"], 1);
        checkmdl(4, $checkurl, $ListPattern["SITEADVISOR"], 1);
        checkmdl(3, $checkurl, $ListPattern["HPHOSTS"], 1);
        checkmdl(7, $checkurl, $ListPattern["MALWAREURL"], 1);
        echo "<link rel=\"stylesheet\" href=\"img/style.css\">";
        if( 1 <= $totallist ) 
        {
            $len = strlen($siteslisted);
            $siteslisted = substr($siteslisted, 0, $len - 2);
            if( 1 <= substr_count($siteslisted, ",") ) 
            {
                $siteslisted = substr_replace($siteslisted, " &", strrpos($siteslisted, ","), 1);
            }

            echo "<font color=red><b>WARNING:</b></font> " . $cpMySQL->DataDecrypt(DOMAIN) . " appears to be listed on: " . $siteslisted . "!";
        }
        else
        {
            echo $cpMySQL->DataDecrypt(DOMAIN) . " does not appear to be listed on any well known dns blacklists.";
        }

    }

}
else
{
    echo "No url defined!";
}

function findName($x)
{
    global $ListPattern;
    foreach( $ListPattern as $k => $v ) 
    {
        if( $v == $x ) 
        {
            return $k;
        }

    }
}

function CheckMDL($site, $url, $pattern, $positive)
{
    global $ListUrl;
    global $siteslisted;
    global $totallist;
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, str_replace("!!URL!!", $url, $ListUrl[$site]));
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POST, 0);
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);
    $x = curl_exec($ch);
    curl_close($ch);
    $y = 0;
    if( strstr($x, $pattern) ) 
    {
        $y = 1;
        $totallist++;
        $siteslisted .= findname($pattern) . ", ";
    }

    return $y;
}


