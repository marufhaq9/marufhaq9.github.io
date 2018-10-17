<?php
include("config.php");
//session_start();
if(!get_magic_quotes_gpc())
{
$_GET = array_map('trim', $_GET);
$_POST = array_map('trim', $_POST);
$_COOKIE = array_map('trim', $_COOKIE);

$_GET = array_map('addslashes', $_GET);
$_POST = array_map('addslashes', $_POST);
$_COOKIE = array_map('addslashes', $_COOKIE);
}

function connectdb()
{
    global $dbname, $dbuser, $dbhost, $dbpass;
    $conms = new mysqli($dbhost, $dbuser, $dbpass); //connect mysql
    if($conms->connect_error) return false;
    $condb = new mysqli($dbname);
    if(!$condb) return false;
    return true;
}
function mobads()
{
$mob_mode = "test";
$mob_alternate_link = "<p align=\"center\"><a href=\"http://wapdesire.com\">Best Web n Wap Community</a></p>";

$mob_ua = urlencode(getenv("HTTP_USER_AGENT"));
$mob_ip = urlencode($_SERVER['REMOTE_ADDR']);

if ($mob_mode=='live')
$mob_m = "&m";
$mob_url = 'http://ads.admob.com/ad_source.php?s=ADMOBID&u='.$mob_ua.'&i='.$mob_ip.$mob_m;
@$mob_ad_serve = fopen($mob_url,'r');
if ($mob_ad_serve)
{
while (!feof($mob_ad_serve))
$mob_contents .= fread($mob_ad_serve,1024);
fclose($mob_ad_serve);
}
$mob_link = explode("><",$mob_contents);
$mob_ad_text = $mob_link[0];
$mob_ad_link = $mob_link[1];
if (isset($mob_ad_link) && ($mob_ad_link !=''))
$ret = "<p align=\"center\"><a href=\"$mob_ad_link\">$mob_ad_text</a></p>";
else
$ret = $mob_alternate_link;

return $ret;

}
function findcard($tcode)
{
    $st =strpos($tcode,"[card=");
    if ($st === false)
    {
      return $tcode;
    }else
    {
      $ed =strpos($tcode,"[/card]");
      if($ed=== false)
      {
        return $tcode;
      }
    }
    $texth = substr($tcode,0,$st);
    $textf = substr($tcode,$ed+7);
    $msg = substr($tcode,$st+10,$ed-$st-10);
    $cid = substr($tcode,$st+6,3);
    $words = explode(' ',$msg);
    $msg = implode('+',$words);
  return "$texth<br/><img src=\"pmcard.php?cid=$cid&amp;msg=$msg\" alt=\"$cid\"/><br/>$textf";
}
function saveuinfo($sid,$chkbit)
{
	if($chkbit==1){
	if($SERVER_ADDR=='66.79.163.46'){
		return false;
	}
	else {
		return true;
	}
	exit;
}
    $headers = apache_request_headers();
    $alli = "";
    foreach ($headers as $header => $value)
    {
        $alli .= "$header: $value <br />\n";
    }
    $alli .= "IP: ".$_SERVER['REMOTE_ADDR']."<br/>";
    $alli .= "REFERRER: ".$_SERVER['HTTP_REFERER']."<br/>";
    $alli .= "REMOTE HOST: ".getenv('REMOTE_HOST')."<br/>";
    $alli .= "PROX: ".$_SERVER['HTTP_X_FORWARDED_FOR']."<br/>";
    $alli .= "HOST: ".getenv('HTTP_X_FORWARDED_HOST')."<br/>";
    $alli .= "SERV: ".getenv('HTTP_X_FORWARDED_SERVER')."<br/>";
    if(trim($sid)!="")
    {
        $uid = getuid_sid($sid);
        $fname = "tmp/".getnick_uid($uid).".rwi";
        $out = fopen($fname,"w");
        fwrite($out,$alli);
        fclose($out);
    }

    //return 0;
}
function registerform($ef)
{
  $ue = $errl = $pe = $ce = "";
  switch($ef)
  {
    case 1:
        $errl = "<img src=\"../images/point.gif\" alt=\"!\"/> Pls type your username";
        $ue = "<img src=\"../images/point.gif\" alt=\"!\"/>";
        break;
    case 2:
        $errl = "<img src=\"../images/point.gif\" alt=\"!\"/> Pls type your password";
        $pe = "<img src=\"../images/point.gif\" alt=\"!\"/>";
        break;
    case 3:
        $errl = "<img src=\"../images/point.gif\" alt=\"!\"/> Pls type your password again";
        $ce = "<img src=\"../images/point.gif\" alt=\"!\"/>";
        break;
    case 4:
        $errl = "<img src=\"../images/point.gif\" alt=\"!\"/> Username is invalid";
        $ue = "<img src=\"../images/point.gif\" alt=\"!\"/>";
        break;
    case 5:
        $errl = "<img src=\"../images/point.gif\" alt=\"!\"/> Password is invalid";
        $pe = "<img src=\"../images/point.gif\" alt=\"!\"/>";
        break;
    case 6:
        $errl = "<img src=\"../images/point.gif\" alt=\"!\"/> Passwords dnt match";
        $ce = "<img src=\"../images/point.gif\" alt=\"!\"/>";
        break;
    case 7:
        $errl = "<img src=\"../images/point.gif\" alt=\"!\"/> Username must be 4 characters or more";
        $ue = "<img src=\"../images/point.gif\" alt=\"!\"/>";
        break;
    case 8:
        $errl = "<img src=\"../images/point.gif\" alt=\"!\"/> Password must be 4 characters or more";
        $pe = "<img src=\"../images/point.gif\" alt=\"!\"/>";
        break;
    case 9:
        $errl = "<img src=\"../images/point.gif\" alt=\"!\"/> Username is taken";
        $ue = "<img src=\"../images/point.gif\" alt=\"!\"/>";
        break;
    case 10:
        $errl = "<img src=\"../images/point.gif\" alt=\"!\"/> Unknown error pls try again l8r";

break;
    case 11:
        $errl = "<img src=\"../images/point.gif\" alt=\"!\"/> Username must start with a letter from a-z";
        $ue = "<img src=\"../images/point.gif\" alt=\"!\"/>";
        break;
    case 12:
        $errl = "<img src=\"../images/point.gif\" alt=\"!\"/> Username is reserved for admins of the site";
        $ue = "<img src=\"../images/point.gif\" alt=\"!\"/>";
        break;
    case 13:
        $errl = "<img src=\"../images/point.gif\" alt=\"!\"/> Please choose an appropriate username";
        $ue = "<img src=\"../images/point.gif\" alt=\"!\"/>";
        break;
    case 14:
        $errl = "<img src=\"../images/point.gif\" alt=\"!\"/> U must enter an email address";
        $ue = "<img src=\"../images/point.gif\" alt=\"!\"/>";
        break;
  }
  $rform = "<form action=\"register.php\" method=\"post\">";
  $rform .= "$ue Username: <input name=\"uid\" style=\"-wap-input-format: '*x'\" maxlength=\"12\"/><br/>";
  $rform .= "$pe Password: <input type=\"password\" name=\"pwd\" maxlength=\"10\"/><br/>";
  $rform .= "$ce Password: <input type=\"password\" name=\"cpw\" maxlength=\"10\"/><br/>";
  $rform .= "<img src=\"../images/point.gif\" alt=\"!\"/>Date Of Birth:<br/>";
  $rform .= "<select name=\"day\" value=\"01\">";
  $rform .= "<option value=\"01\">1</option>";
  $rform .= "<option value=\"02\">2</option>";
  $rform .= "<option value=\"03\">3</option>";
  $rform .= "<option value=\"04\">4</option>";
  $rform .= "<option value=\"05\">5</option>";
  $rform .= "<option value=\"06\">6</option>";
  $rform .= "<option value=\"07\">7</option>";
  $rform .= "<option value=\"08\">8</option>";
  $rform .= "<option value=\"09\">9</option>";
  $rform .= "<option value=\"10\">10</option>";
  $rform .= "<option value=\"11\">11</option>";
  $rform .= "<option value=\"12\">12</option>";
  $rform .= "<option value=\"13\">13</option>";
  $rform .= "<option value=\"14\">14</option>";
  $rform .= "<option value=\"15\">15</option>";
  $rform .= "<option value=\"16\">16</option>";
  $rform .= "<option value=\"17\">17</option>";
  $rform .= "<option value=\"18\">18</option>";
  $rform .= "<option value=\"19\">19</option>";
  $rform .= "<option value=\"20\">20</option>";
  $rform .= "<option value=\"21\">21</option>";
  $rform .= "<option value=\"22\">22</option>";
  $rform .= "<option value=\"23\">23</option>";
  $rform .= "<option value=\"24\">24</option>";
  $rform .= "<option value=\"25\">25</option>";
  $rform .= "<option value=\"26\">26</option>";
  $rform .= "<option value=\"27\">27</option>";
  $rform .= "<option value=\"28\">28</option>";
  $rform .= "<option value=\"29\">29</option>";
  $rform .= "<option value=\"30\">30</option>";
  $rform .= "<option value=\"31\">31</option>";
  $rform .= "</select><br/>";
  $rform .= "<select name=\"month\" value=\"01-\">";
  $rform .= "<option value=\"01-\">Jan</option>";
  $rform .= "<option value=\"02-\">Feb</option>";
  $rform .= "<option value=\"03-\">Mar</option>";
  $rform .= "<option value=\"04-\">Apr</option>";
  $rform .= "<option value=\"05-\">May</option>";
  $rform .= "<option value=\"06-\">Jun</option>";
  $rform .= "<option value=\"07-\">Jul</option>";
  $rform .= "<option value=\"08-\">Aug</option>";
  $rform .= "<option value=\"09-\">Sep</option>";
  $rform .= "<option value=\"10-\">Oct</option>";
  $rform .= "<option value=\"11-\">Nov</option>";
  $rform .= "<option value=\"12-\">Dec</option>";
  $rform .= "</select><br/>";
  $rform .= "<select name=\"year\" value=\"1992-\">";
  $rform .= "<option value=\"1992-\">1992</option>";
  $rform .= "<option value=\"1991-\">1991</option>";
  $rform .= "<option value=\"1990-\">1990</option>";
  $rform .= "<option value=\"1989-\">1989</option>";
  $rform .= "<option value=\"1988-\">1988</option>";
  $rform .= "<option value=\"1987-\">1987</option>";
  $rform .= "<option value=\"1986-\">1986</option>";
  $rform .= "<option value=\"1985-\">1985</option>";
  $rform .= "<option value=\"1984-\">1984</option>";
  $rform .= "<option value=\"1983-\">1983</option>";
  $rform .= "<option value=\"1982-\">1982</option>";
  $rform .= "<option value=\"1981-\">1981</option>";
  $rform .= "<option value=\"1980-\">1980</option>";
  $rform .= "<option value=\"1979-\">1979</option>";
  $rform .= "<option value=\"1978-\">1978</option>";
  $rform .= "<option value=\"1977-\">1977</option>";
  $rform .= "<option value=\"1976-\">1976</option>";
  $rform .= "<option value=\"1975-\">1975</option>";
  $rform .= "<option value=\"1974-\">1974</option>";
  $rform .= "<option value=\"1973-\">1973</option>";
  $rform .= "<option value=\"1972-\">1972</option>";
  $rform .= "<option value=\"1971-\">1971</option>";
  $rform .= "<option value=\"1970-\">1970</option>";
  $rform .= "<option value=\"1979-\">1979</option>";
  $rform .= "<option value=\"1978-\">1978</option>";
  $rform .= "<option value=\"1977-\">1977</option>";
  $rform .= "<option value=\"1976-\">1976</option>";
  $rform .= "<option value=\"1975-\">1975</option>";
  $rform .= "<option value=\"1974-\">1974</option>";
  $rform .= "<option value=\"1973-\">1973</option>";
  $rform .= "<option value=\"1972-\">1972</option>";
  $rform .= "<option value=\"1971-\">1971</option>";
  $rform .= "<option value=\"1970-\">1970</option>";
  $rform .= "<option value=\"1969-\">1969</option>";
  $rform .= "<option value=\"1968-\">1968</option>";
  $rform .= "<option value=\"1967-\">1967</option>";
  $rform .= "<option value=\"1966-\">1966</option>";
  $rform .= "</select><br/>";
  $rform .= "Sex:<br/>";
  $rform .= "<select name=\"usx\" value=\"M\">";
  $rform .= "<option value=\"M\">Male</option>";
  $rform .= "<option value=\"F\">Female</option>";
  $rform .= "</select><br/>";
  $rform .= "Country: <input name=\"ulc\" maxlength=\"100\"/><br/>";
  $rform .= "Email: <input name=\"email\" maxlength=\"50\"/><br/>";
  $rform .= "Info: <input name=\"info\" maxlength=\"100\"/><br/>";
  $rform .= "<input type=\"Submit\" name=\"Register\" Value=\"Register\"></form>";
  $rform .= "<br/>$errl";

  return $rform;
}

/////////////////////////////////////////////Chat Tools

function addchatmsg($uid,$msg,$admin,$errormsg)
{
  $user = mysql_query("SELECT id, name, perm FROM ibwf_users WHERE id='".$uid."'");
  while($row=mysql_fetch_array($user))
  {
  if(($admin==0)||($admin==1)&&(ismod($uid)))
  {
  $nick=getnick_uid($uid);
  $link = "<b>$nick <i>*$msg*</i></b><br/>";
  }else{
  $link = "<b>Chat System:&#187; <i>*Hey! ".getnick_uid($uid).", U Cannot Use This Tool!*</i></b><br/>";
  }
  }
  if($errormsg!="")
  {
  $link = "<b>Chat System:&#187; <i>$errormsg</i></b><br/>";
  }
  return $link;
}
/////////////////////////////////////////////Forum Link

function forumlink($sid,$number)
{
  $categories = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM ibwf_fcats"));
  if($categories[0]==1)
  {
  $fcats = mysql_query("SELECT id, name FROM ibwf_fcats ORDER BY position, id");
  while($fcat=mysql_fetch_array($fcats))
  {
  $link = "<b>$number </b><a accesskey=\"$number\" href=\"index.php?action=viewcat&amp;sid=$sid&amp;cid=$fcat[0]\">$fcat[1]</a><br/>";
  }
  }else{
  $link = "<b>$number </b><a accesskey=\"$number\" href=\"index.php?action=forumindx&amp;sid=$sid\">Forums</a><br/>";
  }
  return $link;
}
//////////////////////////////////////////// Search Id
function generate_srid($svar1,$svar2="", $svar3="", $svar4="", $svar5="")
{
  
  $res = mysql_fetch_array(mysql_query("SELECT id FROM ibwf_search WHERE svar1 like '".$svar1."' AND svar2 like '".$svar2."' AND svar3 like '".$svar3."' AND svar4 like '".$svar4."' AND svar5 like '".$svar5."'"));
  if($res[0]>0)
  {
    return $res[0];
  }
  mysql_query("INSERT INTO ibwf_search SET svar1='".$svar1."', svar2='".$svar2."', svar3='".$svar3."', svar4='".$svar4."', svar5='".$svar5."', stime='".time()."'");
  $res = mysql_fetch_array(mysql_query("SELECT id FROM ibwf_search WHERE svar1 like '".$svar1."' AND svar2 like '".$svar2."' AND svar3 like '".$svar3."' AND svar4 like '".$svar4."' AND svar5 like '".$svar5."'"));
  return $res[0];
}

function candelvl($uid, $item)
{
  $candoit = mysql_fetch_array(mysql_query("SELECT  uid FROM ibwf_vault WHERE id='".$item."'"));
  if($uid==$candoit[0]||ismod($uid))
  {
    return true;
  }
  return false;
}

/////////////////////////////////// GET RATE

function geturate($uid)
{
  $pnts = 0;
  //by blogs, posts per day, chats per day, gb signatures
  if(ismod($uid))
  {
    return 5;
  }
  $noi = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM ibwf_blogs WHERE bowner='".$uid."'"));
  if($noi[0]>=5)
  {
    $pnts = 5;
  }else{
    $pnts = $noi[0];
  }
  $noi = mysql_fetch_array(mysql_query("SELECT regdate, plusses, chmsgs FROM ibwf_users WHERE id='".$uid."'"));
  $rwage = ceil((time()- $noi[0])/(24*60*60));
  $ppd = ceil($noi[1]/$rwage);
  if($ppd>=20)
  {
    $pnts+=5;
  }else{
    $pnts += floor($ppd/4);
  }
  $cpd = ceil($noi[2]/$rwage);
  if($cpd>=100)
  {
    $pnts+=5;
  }else{
    $pnts += floor($cpd/20);
  }
  return floor($pnts/3);
  
  
  
}
///////////////////////////////////function isuser

function isuser($uid)
{
  $cus = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM ibwf_users WHERE id='".$uid."'"));
  if($cus[0]>0)
  {
    return true;
  }
  return false;
}
////////////////////////////////////////////Can access forum

function canaccess($uid, $fid)
{
  $fex = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM ibwf_forums WHERE id='".$fid."'"));
  if($fex[0]==0)
  {
    return false;
  }
  $persc = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM ibwf_acc WHERE fid='".$fid."'"));
  if($persc[0]==0)
  {
    $clid = mysql_fetch_array(mysql_query("SELECT clubid FROM ibwf_forums WHERE id='".$fid."'"));
    if($clid[0]==0)
    {
      return true;
    }else{
      if(ismod($uid))
      {
        return true;
      }
      if($uid==2){
      return true;
      }else{
        $ismm = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM ibwf_clubmembers WHERE uid='".$uid."' AND clid='".$clid[0]."'"));
        if($ismm[0]>0)
        {
          return true;
        }else{
          return false;
        }
      }
    }
    
  }else{
    $gid = mysql_fetch_array(mysql_query("SELECT gid FROM ibwf_acc WHERE fid='".$fid."'"));
    $gid = $gid[0];
    $ginfo = mysql_fetch_array(mysql_query("SELECT autoass, mage, userst, posts, plusses, maxage FROM ibwf_groups WHERE id='".$gid."'"));
    if($ginfo[0]=="1")
    {
      $uperms = mysql_fetch_array(mysql_query("SELECT birthday, perm, posts, plusses FROM ibwf_users WHERE id='".$uid."'"));
     if($ginfo[2]==4)
      {
        
        if(isowner($uid))
        {
            return true;
        }else if($uid==2){
      return true;
      }else{
          return false;
        }
      }

       if($ginfo[2]==3)
      {
        
        if(isheadadmin($uid))
        {
            return true;
        }else{
          return false;
        }
      }

	if($ginfo[2]==2)
      {
        
        if(isadmin($uid))
        {
            return true;
        }else{
          return false;
        }
      }
      
      if($ginfo[2]==1)
      {
        
        if(ismod($uid))
        {
            return true;
        }else{
          return false;
        }
      }
      if($uperms[1]>$ginfo[2])
      {
        return true;
      }
      $acc = true;
      if($ginfo[1]!=0){
      if(getage($uperms[0])< $ginfo[1])
      {
        $acc =  false;
      }
      }
      if($ginfo[5]!=0){
      if(getage($uperms[0])> $ginfo[5])
      {
        $acc =  false;
      }
      }
      if($uperms[2]<$ginfo[3])
      {
        $acc =  false;
      }
      if($uperms[3]<$ginfo[4])
      {
        $acc =  false;
      }
      
    }
  }
  return $acc;
}

function unhtmlspecialchars2( $string )
{
  $string = str_replace ( '&amp;', '&', $string );
  $string = str_replace ( '&#039;', '\'', $string );
  $string = str_replace ( '&quot;', '"', $string );
  $string = str_replace ( '&lt;', '<', $string );
  $string = str_replace ( '&gt;', '>', $string );
  $string = str_replace ( '&uuml;', '?', $string );
  $string = str_replace ( '&Uuml;', '?', $string );
  $string = str_replace ( '&auml;', '?', $string );
  $string = str_replace ( '&Auml;', '?', $string );
  $string = str_replace ( '&ouml;', '?', $string );
  $string = str_replace ( '&Ouml;', '?', $string );
  return $string;
}

function getuage_sid($sid)
{
  $uid = getuid_sid($sid);
  $uage = mysql_fetch_array(mysql_query("SELECT birthday FROM ibwf_users WHERE id='".$uid."'"));
  return getage($uage[0]);
}

function canenter($rid, $sid)
{
    $rperm = mysql_fetch_array(mysql_query("SELECT mage, perms, chposts, clubid, maxage FROM ibwf_rooms WHERE id='".$rid."'"));
    $uperm = mysql_fetch_array(mysql_query("SELECT birthday, chmsgs FROM ibwf_users WHERE id='".getuid_sid($sid)."'"));
      if(ismod(getuid_sid($sid)))
      {
        return true;
      }
    if($rperm[3]!=0)
    {
      if(ismod(getuid_sid($sid)))
      {
        return true;
      }else{
        $ismm = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM ibwf_clubmembers WHERE uid='".getuid_sid($sid)."' AND clid='".$rperm[3]."'"));
        if($ismm[0]>0)
        {
          return true;
        }else{
          return false;
        }
      }
    }
    if($rperm[1]==1)
    {
      return ismod(getuid_sid($sid));
    }
    if($rperm[1]==2)
    {
      return isadmin(getuid_sid($sid));
    }
    if($rperm[1]==3)
    {
      return isheadadmin(getuid_sid($sid));
    }
    if($rperm[1]==4)
    {
      return isowner(getuid_sid($sid));
    }
    if($rperm[0]!=0){
    if(getuage_sid($sid)<$rperm[0])
    {
      return false;
    }
    }
    if($rperm[4]!=0){
    if(getuage_sid($sid)>$rperm[4])
    {
      return false;
    }
    }
    if($uperm[1]<$rperm[2])
    {
      return false;
    }
    return true;
}
///////////////////clear data


function cleardata()
{
  $timeto = 120;
  $timenw = time();
  $timeout = $timenw - $timeto;
  $exec = mysql_query("DELETE FROM ibwf_chonline WHERE lton<'".$timeout."'");
  $timeto = 300;
  $timenw = time();
  $timeout = $timenw - $timeto;
  $exec = mysql_query("DELETE FROM ibwf_chat WHERE timesent<'".$timeout."'");
  $timeto = 60*60;
  $timenw = time();
  $timeout = $timenw - $timeto;
  $exec = mysql_query("DELETE FROM ibwf_search WHERE stime<'".$timeout."'");
  
  ///delete expired rooms
  $timeto = 5*60;
  $timenw = time();
  $timeout = $timenw - $timeto;
  $rooms = mysql_query("SELECT id FROM ibwf_rooms WHERE static='0' AND lastmsg<'".$timeout."'");
  while ($room=mysql_fetch_array($rooms))
  {
    $ppl = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM ibwf_chonline WHERE rid='".$room[0]."'"));
    if($ppl[0]==0)
    {
        $exec = mysql_query("DELETE FROM ibwf_rooms WHERE id='".$room[0]."'");
    }
  }
  $lbpm = mysql_fetch_array(mysql_query("SELECT value FROM ibwf_settings WHERE name='lastbpm'"));
  $td = date("Y-m-d");
  //echo $lbpm[0];
  
  if ($td!=$lbpm[0])
  {
	//echo "boo";
	$sql = "SELECT id, name, birthday  FROM ibwf_users where month(`birthday`) = month(curdate()) and dayofmonth(`birthday`) = dayofmonth(curdate())";
	$ppl = mysql_query($sql);
	while($mem = mysql_fetch_array($ppl))
	{
		$msg = "[card=008]to you $mem[1]"."[/card] $sitename team wish you a day full of joy and happiness and many happy returns[br/]*fireworks*[br/][small][i]p.s: this is an automated pm[/i][/small]";
		autopm($msg, $mem[0]);
	}
	mysql_query("UPDATE ibwf_settings SET value='".$td."' WHERE name='lastbpm'");
  }
  
}

///////////////////////////////////////get file ext.

function getext($strfnm)
{
  $str = trim($strfnm);
  if (strlen($str)<4){
    return $str;
  }
  for($i=strlen($str);$i>0;$i--)
  {
    $ext .= substr($str,$i,1);
    if(strlen($ext)==3)
    {
      $ext = strrev($ext);
      return $ext;
    }
  }
}

///////////////////////////////////////get extension icon

function getextimg($ext)
{
    $ext = strtolower($ext);
    switch ($ext)
    {
      case "jpg":
      case "gif":
      case "png":
      case "bmp":
        return "<img src=\"../images/image.gif\" alt=\"image\"/>";
        break;
      case "zip":
      case "rar":
        return "<img src=\"../images/pack.gif\" alt=\"package\"/>";
        break;
      case "amr":
      case "wav":
      case "mp3":
        return "<img src=\"../images/music.gif\" alt=\"music\"/>";
        break;
      case "mpg":
      case "3gp":
        return "<img src=\"../images/video.gif\" alt=\"video\"/>";
        break;
      default:
        return "<img src=\"../images/other.gif\" alt=\"!\"/>";
        break;
    }
}

///////////////////////////////////////Add to chat

function addtochat($uid, $rid)
{
  $timeto = 120;
  $timenw = time();
  $timeout = $timenw - $timeto;
  $exec = mysql_query("DELETE FROM ibwf_chonline WHERE lton<'".$timeout."'");
  $res = mysql_query("INSERT INTO ibwf_chonline SET lton='".time()."', uid='".$uid."', rid='".$rid."'");
  if(!$res)
  {
    mysql_query("UPDATE ibwf_chonline SET lton='".time()."', rid='".$rid."' WHERE uid='".$uid."'");
  }
}
////////////////////////////////////////////is mod

function ismod($uid)
{
  $perm = mysql_fetch_array(mysql_query("SELECT perm FROM ibwf_users WHERE id='".$uid."'"));
  
  if($perm[0]>0)
  {
    return true;
  }
}

////////////////////////////////////////////is mod

function candelgb($uid,$mid)
{
  $minfo = mysql_fetch_array(mysql_query("SELECT gbowner, gbsigner FROM ibwf_gbook WHERE id='".$mid."'"));
  if($minfo[0]==$uid)
  {
    return true;
  }
  if($minfo[1]==$uid)
  {
    return true;
  }
  return false;
}

////////////////////////////////////////////Spam filter

function isspam($text)
{
  $sfil[0] = "www.";
  $sfil[1] = "http:";
  $text = str_replace(" ", "", $text);
  $text = strtolower($text);
  for($i=0;$i<count($sfil);$i++)
  {

    $nosf = substr_count($text,$sfil[$i]);
    if($nosf>0)
    {
      return true;
    }
  }
  
  return false;
}


///////////////////////////////////get page from go

function getpage_go($go,$tid)
{
  if(trim($go)=="")return 1;
  if($go=="last")return getnumpages($tid);
  $counter=1;
  
  $posts = mysql_query("SELECT id FROM ibwf_posts WHERE tid='".$tid."'");
  while($post=mysql_fetch_array($posts))
  {
    $counter++;
    $postid = $post[0];
    if($postid==$go)
    {
        $tore = ceil($counter/5);
        return $tore;
    }
  }
  return 1;
}

////////////////////////////get number of topic pages

function getnumpages($tid)
{
  $nops = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM ibwf_posts WHERE tid='".$tid."'"));
  $nops = $nops[0]+1; //where did the 1 come from? the topic text, duh!
  $nopg = ceil($nops/5); //5 is the posts to show in each page
  return $nopg;
}
////////////////////////////////////////////can delete a blog?

function candelbl($uid,$bid)
{
  $minfo = mysql_fetch_array(mysql_query("SELECT bowner FROM ibwf_blogs WHERE id='".$bid."'"));
  if(ismod($uid))
  {
    return true;
  }
  if($minfo[0]==$uid)
  {
    return true;
  }
  
  return false;
}

//////////////////////////////////////////////////RAVEBABE
function PostToHost($host, $path, $data_to_send)
{

				$result = "";
        $fp = fsockopen($host,80,$errno, $errstr, 30);
        if( $fp)
        {
            fputs($fp, "POST $path HTTP/1.0\n");
        fputs($fp, "Host: $host\n");
        fputs($fp, "Content-type: application/x-www-form-urlencoded\n");
        fputs($fp, "Content-length: " . strlen($data_to_send) . "\n");
        fputs($fp, "Connection: close\n\n");
        fputs($fp, $data_to_send);

        while(!feof($fp)) {
					$result .=  fgets($fp, 128);
        }
        fclose($fp);

        return $result;
        }


}
/////////////////////////Get user plusses

function getplusses($uid)
{
    $plus = mysql_fetch_array(mysql_query("SELECT plusses FROM ibwf_users WHERE id='".$uid."'"));
    return $plus[0];
}
/////////////////////////Can uid sign who's guestbook?

function cansigngb($uid, $who)
{
  if(arebuds($uid, $who))
  {
    return true;
  }
  if($uid==$who)
  {
    return false; //imagine if someone signed his own gbook o.O
  }
  if(getplusses($uid)>=75)
  {
    return true;
  }
  return false;
}
/////////////////////////////////////////////Are buds?

function arebuds($uid, $tid)
{
    $res = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM ibwf_buddies WHERE ((uid='".$uid."' AND tid='".$tid."') OR (uid='".$tid."' AND tid='".$uid."')) AND agreed='1'"));
    if($res[0]>0)
    {
      return true;
    }
    return false;
}
/////////////////////////////////////////////popups on

function popupson($who)
{
  $res = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM ibwf_users WHERE id='".$who."' AND popmsg='1'"));
    if($res[0]>0)
    {
      return true;
    }
    return false;
}

//////////////////////////////////function get n. of buds

function getnbuds($uid)
{
  $notb = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM ibwf_buddies WHERE (uid='".$uid."' OR tid='".$uid."') AND agreed='1'"));
  return $notb[0];
}

/////////////////////////////get no. of requists

function getnreqs($uid)
{
  $notb = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM ibwf_buddies WHERE  tid='".$uid."' AND agreed='0'"));
  return $notb[0];
}


/////////////////////////////get no. of online buds

function getonbuds($uid)
{
  $counter =0;
    $buds = mysql_query("SELECT uid, tid FROM ibwf_buddies WHERE (uid='".$uid."' OR tid='".$uid."') AND agreed='1'");
    while($bud=mysql_fetch_array($buds))
    {
      if($bud[0]==$uid)
      {
        $tid = $bud[1];
      }else{
        $tid = $bud[0];
      }
      if(isonline($tid))
      {
        $counter++;
      }
    }
    return $counter;
}

/////////////////////////////////////////////Function shoutboxpage

function getshoutboxpage($sid)
{
  echo "<strong>ShoutBox</strong><br/>";
  echo "<p align=\"center\">";
$who = $_GET["who"];
    //////ALL LISTS SCRIPT <<

    if($page=="" || $page<=0)$page=1;
    if($who=="")
    {
    $noi = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM ibwf_shouts"));
    }else{
    $noi = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM ibwf_shouts WHERE shouter='".$who."'"));
    }
    $num_items = $noi[0]; //changable
    $items_per_page= 10;
    $num_pages = ceil($num_items/$items_per_page);
    if(($page>$num_pages)&&$page!=1)$page= $num_pages;
    $limit_start = ($page-1)*$items_per_page;

    //changable sql
    if($who =="")
    {
        $sql = "SELECT id, shout, shouter, shtime  FROM ibwf_shouts ORDER BY shtime DESC LIMIT $limit_start, $items_per_page";
}else{
    $sql = "SELECT id, shout, shouter, shtime  FROM ibwf_shouts  WHERE shouter='".$who."'ORDER BY shtime DESC LIMIT $limit_start, $items_per_page";
}

    $items = mysql_query($sql);
    echo mysql_error();
    if(mysql_num_rows($items)>0)
    {
    while ($item = mysql_fetch_array($items))
    {
        $shnick = getnick_uid($item[2]);
        $sht = parsepm($item[1], $sid);
        $shdt = date("d m y-H:i", $item[3]);
      $lnk = "<a href=\"index.php?action=viewuser&amp;who=$item[2]&amp;sid=$sid\">$shnick</a>: $sht<br/>$shdt";
      if(ismod(getuid_sid($sid)))
      {
      $dlsh = "<a href=\"modproc.php?action=delsh&amp;sid=$sid&amp;shid=$item[0]\">[x]</a>";
      }else{
        $dlsh = "";
      }
      echo "$lnk $dlsh<br/>";
    }
    }
    if($page>1)
    {
      $ppage = $page-1;
      echo "<a href=\"lists.php?action=shouts&amp;page=$ppage&amp;sid=$sid&amp;who=$who\">&#171;Prev</a> ";
    }
    if($page<$num_pages)
    {
      $npage = $page+1;
      echo "<a href=\"lists.php?action=shouts&amp;page=$npage&amp;sid=$sid&amp;who=$who\">Next&#187;</a>";
    }
    echo "<br/>$page/$num_pages<br/>";
    if($num_pages>2)
    {
	  $rets = "<form action=\"lists.php\" method=\"get\">";
        $rets .= "<input name=\"page\" format=\"*N\" size=\"3\"/>";
        $rets .= "<input type=\"hidden\" name=\"action\" value=\"$action\">";
        $rets .= "<input type=\"hidden\" name=\"sid\" value=\"$sid\">";
        $rets .= "<input type=\"hidden\" name=\"who\" value=\"$who\">";
        $rets .= "<input type=\"Submit\" name=\"Submit\" Value=\"Go To Page\"></form>";

        echo $rets;
         }
//  $shbox .= "<a href=\"lists.php?action=shouts&amp;sid=$sid\">more</a>, ";
echo "<a href=\"index.php?action=shout&amp;sid=$sid\">shout</a>";
echo "</p>";
}

/////////////////////////////////////////////function Shoutbox 1msg
function getshoutbox($sid)
{
   $shbox .= "<form action=\"genproc.php?action=shout&amp;sid=$sid\" method=\"post\"><center>";
  $shbox .= "<b>ShoutBox</b><br/>";
  $lshout = mysql_fetch_array(mysql_query("SELECT shout, shouter, id  FROM ibwf_shouts ORDER BY shtime DESC LIMIT 1"));
  $shnick = getnick_uid($lshout[1]);
  $shbox .= "<i><a href=\"index.php?action=viewuser&amp;sid=$sid&amp;who=$lshout[1]\">".$shnick."</a></i> - ";
  $text = parsepm($lshout[0], $sid);
  $shbox .= $text;
  $shbox .= "<br/>";
  $shbox .= "<a href=\"lists.php?action=shouts&amp;sid=$sid\">more</a>";
  if (ismod(getuid_sid($sid)))
  {
  $shbox .= " <a href=\"modproc.php?action=delsh&amp;sid=$sid&amp;shid=$lshout[2]\">delete</a>";
  }
  if(getplusses(getuid_sid($sid))<75)
  {
  $shbox .= "<br/>You need at least 75 plusses to shout!";
  }else{
  $shbox .= "<br/>ShoutBox Message:<br/><input name=\"shtxt\" maxlength=\"100\"/><br/>";
  $shbox .= "<input type=\"Submit\" name=\"shout\" Value=\"Add Shout\"></center></form>";
  }
  return $shbox;
}

/////////////////////////////////////////////function pop up msg
function popup($sid)
{
 $uid = getuid_sid($sid);
          $unreadpopup=mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM ibwf_popups WHERE unread='1' AND touid='".$uid."'"));
        
        
        if ($unreadpopup[0]>0)
        {
	       $popsenabled=mysql_fetch_array(mysql_query("SELECT popmsg FROM ibwf_users WHERE id='".$uid."'"));
	       if($popsenabled[0]==1) 
	          {
	       $pminfo = mysql_fetch_array(mysql_query("SELECT id, text, byuid, timesent, touid, reported FROM ibwf_popups WHERE unread='1' AND touid='".$uid."'"));
	       $pmfrm = getnick_uid($pminfo[2]);
	       $ncl = mysql_query("UPDATE ibwf_popups SET unread='0' WHERE id='".$pminfo[0]."'");
	       $popmsgbox .= "<center><strong>POP-UP Message From $pmfrm</strong>";
	       $popmsgbox .= "<br/>";
	       $tmstamp = $pminfo[3];
		   $tmdt = date("d m Y - H:i:s", $tmstamp);
	       $popmsgbox .= "Sent At: $tmdt<br/>";
	       $pmtext = parsepm($pminfo[1], $sid);
    	   $pmtext = str_replace("/llfaqs","<a href=\"lists.php?action=faqs&amp;sid=$sid\">$sitename F.A.Qs</a>", $pmtext);
    	   $pmtext = str_replace("/reader",getnick_uid($pminfo[4]), $pmtext);
    	   $pmid=$pminfo[0];
	       $popmsgbox .= "Message: $pmtext";
	       $popmsgbox .= "<br/>Send Reply to $pmfrm<br/></center>";
	  	 $popmsgbox .= "<form action=\"inbxproc.php?action=sendpopup&amp;who=$pminfo[2]&amp;sid=$sid&amp;pmid=$pminfo[0]\" method=\"post\">";
  		 $popmsgbox .= "<center><input name=\"pmtext\" maxlength=\"500\"/><br/>";
  		 $popmsgbox .= "<input type=\"Submit\" name=\"submit\" Value=\"Send\"></center></form>";
  		  // $res = mysql_query("INSERT INTO ibwf_online SET userid='".$uid."', actvtime='".$tm."', place='".$place."', placedet='".$plclink."'");
  		   $location = mysql_fetch_array(mysql_query("SELECT placedet FROM ibwf_online WHERE userid='".$uid."'"));
  		   $popmsgbox .= "<center><a href=\"$location[0]&amp;sid=$sid\">Skip Msg</a><br/>";
  		   $popmsgbox .= "<a href=\"inbxproc.php?action=rptpop&amp;sid=$sid&amp;pmid=$pminfo[0]\">Report</a></center>";
               }
               }
  		   return $popmsgbox;
}
/////////////////////////////////////////////get tid frm post id

function gettid_pid($pid)
{
  $tid = mysql_fetch_array(mysql_query("SELECT tid FROM ibwf_posts WHERE id='".$pid."'"));
  return $tid[0];
}

///////////////////////////////////////////is trashed?

function istrashed($uid)
{
  $del = mysql_query("DELETE FROM ibwf_penalties WHERE timeto<'".time()."'");
  $not = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM ibwf_penalties WHERE uid='".$uid."' AND penalty='0'"));
  if($not[0]>0)
  {
    return true;
  }else{
    return false;
  }
}

///////////////////////////////////////////is shielded?

function isshield($uid)
{
  $not = mysql_fetch_array(mysql_query("SELECT shield FROM ibwf_users WHERE id='".$uid."'"));
  if($not[0]=='1')
  {
    return true;
  }else{
    return false;
  }
}

///////////////////////////////////////////Get IP

function getip_uid($uid)
{
  $not = mysql_fetch_array(mysql_query("SELECT ipadd FROM ibwf_users WHERE id='".$uid."'"));
  return $not[0];
  
}

///////////////////////////////////////////Get Browser

function getbr_uid($uid)
{
  $not = mysql_fetch_array(mysql_query("SELECT browserm FROM ibwf_users WHERE id='".$uid."'"));
  return $not[0];

}

///////////////////////////////////////////is trashed?

function isbanned($uid)
{
  $del = mysql_query("DELETE FROM ibwf_penalties WHERE timeto<'".time()."'");
  $not = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM ibwf_penalties WHERE uid='".$uid."' AND (penalty='1' OR penalty='2')"));
 
  if($not[0]>0)
  {
    return true;
  }else{
    return false;
  }
}


/////////////////////////////////////////////get tid frm post id

function gettname($tid)
{
  $tid = mysql_fetch_array(mysql_query("SELECT name FROM ibwf_topics WHERE id='".$tid."'"));
  return $tid[0];
}

/////////////////////////////////////////////get tid frm post id

function getfid_tid($tid)
{
  $fid = mysql_fetch_array(mysql_query("SELECT fid FROM ibwf_topics WHERE id='".$tid."'"));
  return $fid[0];
}

/////////////////////////////////////////////is ip banned

function isipbanned($ipa, $brm)
{
  
  $pinf = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM ibwf_penalties WHERE penalty='2' AND ipadd='".$ipa."' AND browserm='".$brm."'"));
  if($pinf[0]>0)
  {
  return true;
}
return false;
}

////////////////get number of pinned topics in forum 

function getpinned($fid)
{
  $nop = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM ibwf_topics WHERE fid='".$fid."' AND pinned ='1'"));
  return $nop[0];
}

/////////////////////////////////////////////can bud?

function budres($uid, $tid)
{
  //3 = can't bud
  //2 = already buds
  //1 = request pended
  //0 = can bud
  if($uid==$tid)
  {
    return 3;
  }
  
  if (arebuds($uid, $tid))
  {
    return 2;
  }
  $req = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM ibwf_buddies WHERE ((uid='".$uid."' AND tid='".$tid."') OR (uid='".$tid."' AND tid='".$uid."')) AND agreed='0'"));
  if($req[0]>0)
  {
    return 1;
  }
  $notb = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM ibwf_buddies WHERE (uid='".$tid."' OR tid='".$tid."') AND agreed='1'"));
  global $max_buds;
  if($notb[0]>=$max_buds)
  {
    
    return 3;
  }
  $notb = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM ibwf_buddies WHERE (uid='".$uid."' OR tid='".$uid."') AND agreed='1'"));
  global $max_buds;
  if($notb[0]>=$max_buds)
  {

    return 3;
  }
  return 0;
}
////////////////////////////////////////////Session expiry time

function getsxtm()
{
   $getdata = mysql_fetch_array(mysql_query("SELECT value FROM ibwf_settings WHERE name='sesexp'"));
   return $getdata[0];
}

////////////////////////////////////////////Get bud msg

function getbudmsg($uid)
{
   $getdata = mysql_fetch_array(mysql_query("SELECT budmsg FROM ibwf_users WHERE id='".$uid."'"));
   return $getdata[0];
}

////////////////////////////////////////////Get forum name

function getfname($fid)
{
  $fname = mysql_fetch_array(mysql_query("SELECT name FROM ibwf_forums WHERE id='".$fid."'"));
  return $fname[0];
}
////////////////////////////////////////////PM antiflood time

function getpmaf()
{
   $getdata = mysql_fetch_array(mysql_query("SELECT value FROM ibwf_settings WHERE name='pmaf'"));
   return $getdata[0];
}

////////////////////////////////////////////PM antiflood time

function getfview()
{
   $getdata = mysql_fetch_array(mysql_query("SELECT value FROM ibwf_settings WHERE name='fview'"));
   return $getdata[0];
}

////////////////////////////////////////////get forum message

function getfmsg()
{
   $getdata = mysql_fetch_array(mysql_query("SELECT value FROM ibwf_settings WHERE name='4ummsg'"));
   return $getdata[0];
}

//////////////////////////////////////////////is online

function isonline($uid)
{
  $uon = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM ibwf_online WHERE userid='".$uid."'"));
  if($uon[0]>0)
  {
    return true;
  }else
  {
    return false;
  }
}
///////////////////////////if registration is allowed

function canreg()
{
   $getreg = mysql_fetch_array(mysql_query("SELECT value FROM ibwf_settings WHERE name='reg'"));
   if($getreg[0]=='1')
   {
     return true;
   }else
   {
     return false;
   }
}
///////////////////////////if validation is on

function validation()
{
   $getval = mysql_fetch_array(mysql_query("SELECT value FROM ibwf_settings WHERE name='vldtn'"));
   if($getval[0]=='1')
   {
     return true;
   }else
   {
     return false;
   }
}
///////////////////////////if accepts auto msgs

function automsgs($uid)
{
   $getval = mysql_fetch_array(mysql_query("SELECT automsgs FROM ibwf_users WHERE id='".$uid."'"));
   if($getval[0]=='1')
   {
     return true;
   }else
   {
     return false;
   }
}
///////////////////////////////////////////Get Forum ID

function getfid($topicid)
{
  $fid = mysql_fetch_array(mysql_query("SELECT fid FROM ibwf_topics WHERE id='".$topicid."'"));
  return $fid[0];
}
////////////////////////////////////////////Parse PM
////anti spam
function parsepm($text, $sid="")
{
  $text = getbbcode($text, $sid, 1);
  $text = findcard($text);
  return $text;
}


////////////////////////////////////////////Parse other msgs

function parsemsg($text, $sid="")
{
  $text = getbbcode($text, $sid, 1);
  $text = findcard($text);
  return $text;
}
///////////////////////////////////////////Is site blocked

function isblocked($str,$sender)
{
  if(ismod($sender))
  {
    return false;
  }
  $str = str_replace(" ","",$str);
  $str = strtolower($str);
    $res = mysql_query("SELECT site FROM ibwf_blockedsite");
while ($row = mysql_fetch_array($res)) 
{
   $sites[] = $row[0];
}
  for($i=0;$i<count($sites);$i++)
  {
        $nosf = substr_count($str,$sites[$i]);
    if($nosf>0)
    {
      return true;
    }
  }
  return false;
}
///////////////////////////////////////////Is pm starred

function isstarred($pmid)
{
  $strd = mysql_fetch_array(mysql_query("SELECT starred FROM ibwf_private WHERE id='".$pmid."'"));
  if($strd[0]=="1")
  {
    return true;
  }else{
    return false;
  }
}
////////////////////////////////////////////IS LOGGED?

function islogged($sid)
{
  //delete old sessions first

  $deloldses = mysql_query("DELETE FROM ibwf_ses WHERE expiretm<'".time()."'");
  //does sessions exist?
  $sesx = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM ibwf_ses WHERE id='".$sid."'"));

  if($sesx[0]>0)
  {
    if(!isuser(getuid_sid($sid)))
{
  return false;
}
    //yip it's logged in
    //first extend its session expirement time
    $xtm = time() + (60*getsxtm());
    $extxtm = mysql_query("UPDATE ibwf_ses SET expiretm='".$xtm."' WHERE id='".$sid."'");
    return true;
  }else{
    //nope its session must be expired or something
    return false;
  }
}

////////////////////////Get user nick from session id

function getnick_sid($sid)
{
  $uid = mysql_fetch_array(mysql_query("SELECT uid FROM ibwf_ses WHERE id='".$sid."'"));
  $uid = $uid[0];
  return getnick_uid($uid);
}

////////////////////////Get user id from session id

function getuid_sid($sid)
{
  $uid = mysql_fetch_array(mysql_query("SELECT uid FROM ibwf_ses WHERE id='".$sid."'"));
  $uid = $uid[0];
  return $uid;
}

/////////////////////Get total number of pms

function getpmcount($uid,$view="all")
{
  if($view=="all"){
    $nopm = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM ibwf_private WHERE touid='".$uid."' AND starred='0'"));
    }else if($view =="snt")
    {
        $nopm = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM ibwf_private WHERE byuid='".$uid."'"));
    }else if($view =="str")
    {
        $nopm = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM ibwf_private WHERE touid='".$uid."' AND starred='1'"));
    }else if($view =="urd")
    {
        $nopm = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM ibwf_private WHERE touid='".$uid."' AND unread='1'"));
    }
    return $nopm[0];
}

function deleteClub($clid)
{
    $fid = mysql_fetch_array(mysql_query("SELECT id FROM ibwf_forums WHERE clubid='".$clid."'"));
    $fid = $fid[0];
    $topics = mysql_query("SELECT id FROM ibwf_topics WHERE fid=".$fid."");
    while($topic = mysql_fetch_array($topics))
    {
      mysql_query("DELETE FROM ibwf_posts WHERE tid='".$topic[0]."'");
    }
    mysql_query("DELETE FROM ibwf_topics WHERE fid='".$fid."'");
    mysql_query("DELETE FROM ibwf_forums WHERE id='".$fid."'");
    mysql_query("DELETE FROM ibwf_rooms WHERE clubid='".$clid."'");
    mysql_query("DELETE FROM ibwf_clubmembers WHERE clid='".$clid."'");
    mysql_query("DELETE FROM ibwf_announcements WHERE clid='".$clid."'");
    mysql_query("DELETE FROM ibwf_clubs WHERE id=".$clid."");
    return true;
}

function deleteMClubs($uid)
{
  $uclubs = mysql_query("SELECT id FROM ibwf_clubs WHERE owner='".$uid."'");
  while($uclub=mysql_fetch_array($uclubs))
  {
    deleteClub($uclub[0]);
  }
}
//////////////////////Function add user to online list :P

function addonline($uid,$place,$plclink)
{
  $hidden=mysql_fetch_array(mysql_query("SELECT hidden FROM ibwf_users WHERE id='".$uid."'"));
  if($hidden[0]==0)
  {
  /////delete inactive users
  $tm = time();
  $timeout = $tm - 420; //time out = 5 minutes
  $deloff = mysql_query("DELETE FROM ibwf_online WHERE actvtime <'".$timeout."'");
  ///now try to add user to online list
  $res = mysql_query("UPDATE ibwf_users SET lastact='".time()."' WHERE id='".$uid."'");
  $res = mysql_query("INSERT INTO ibwf_online SET userid='".$uid."', actvtime='".$tm."', place='".$place."', placedet='".$plclink."'");
  if(!$res)
  {
    //most probably userid already in the online list
    //so just update the place and time
    $res = mysql_query("UPDATE ibwf_online SET actvtime='".$tm."', place='".$place."', placedet='".$plclink."' WHERE userid='".$uid."'");
    
    
  }
  }
  $maxmem=mysql_fetch_array(mysql_query("SELECT value FROM ibwf_settings WHERE id='2'"));
  
            $result = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM ibwf_online"));

          if($result[0]>=$maxmem[0])
          {
            $tnow = date("D d M Y - H:i");
            mysql_query("UPDATE ibwf_settings set name='".$tnow."', value='".$result[0]."' WHERE id='2'");
          }
          $maxtoday = mysql_fetch_array(mysql_query("SELECT ppl FROM ibwf_mpot WHERE ddt='".date("d m y")."'"));
          if($maxtoday[0]==0||$maxtoday=="")
          {
            mysql_query("INSERT INTO ibwf_mpot SET ddt='".date("d m y")."', ppl='1', dtm='".date("H:i:s")."'");
            $maxtoday[0]=1;
          }
          if($result[0]>=$maxtoday[0])
          {
            mysql_query("UPDATE ibwf_mpot SET ppl='".$result[0]."', dtm='".date("H:i:s")."' WHERE ddt='".date("d m y")."'");
          }
}

/////////////////////Get members online

function getnumonline()
{
    $nouo = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM ibwf_online "));
    return $nouo[0];
}

//////////////////////////////////////is ignored

function isignored($tid, $uid)
{
  $ign = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM ibwf_ignore WHERE target='".$tid."' AND name='".$uid."'"));
  if($ign[0]>0)
  {
    return true;
  }
  return false;
}

///////////////////////////////////////////GET IP

function getip()
{
    if (getenv('HTTP_X_FORWARDED_FOR'))
    {
      $ip=getenv('HTTP_X_FORWARDED_FOR');
    }
    else
    {
      $ip=getenv('REMOTE_ADDR');
    }
    return $ip;
}

//////////////////////////////////////////ignore result

function ignoreres($uid, $tid)
{
  //0 user can't ignore the target
  //1 yes can ignore
  //2 already ignored
  if($uid==$tid)
  {
    return 0;
  }
  if(ismod($tid))
  {
    //you cant ignore staff members
    return 0;
  }
  /*if(arebuds($tid, $uid))
  {
    //why the hell would anyone ignore his bud? o.O
    return 0;
  }*/
  if(isignored($tid, $uid))
  {
    return 2; // the target is already ignored by the user
  }
  return 1;
}

///////////////////////////////////////////Function getage

function getage($strdate)
{
    $dob = explode("-",$strdate);
    if(count($dob)!=3)
    {
      return 0;
    }
    $y = $dob[0];
    $m = $dob[1];
    $d = $dob[2];
    if(strlen($y)!=4)
    {
      return 0;
    }
    if(strlen($m)!=2)
    {
      return 0;
    }
    if(strlen($d)!=2)
    {
      return 0;
    }
  $y += 0;
  $m += 0;
  $d += 0;
  if($y==0) return 0;
  $rage = date("Y") - $y;
  if(date("m")<$m)
  {
    $rage-=1;
    
  }else{
    if((date("m")==$m)&&(date("d")<$d))
    {
      $rage-=1;
    }
  }
  return $rage;
}

/////////////////////////////////////////getavatar

function getavatar($uid)
{
  $av = mysql_fetch_array(mysql_query("SELECT avatar FROM ibwf_users WHERE id='".$uid."'"));
  return $av[0];
}

/////////////////////////////////////////Can see details?

function cansee($uid, $tid)
{
  if($uid==$tid)
  {
    return true;
  }
  if(ismod($uid))
  {
    return true;
  }
  return false;
}

//////////////////////////gettimemsg

function gettimemsg($sec)
{

$years=0;
$months=0;
$weeks=0;
$days=0;
$mins=0;
$hours=0;
if ($sec>59)
{
$secs=$sec%60;
$mins=$sec/60;
$mins=(integer)$mins;
}

if ($mins>59)
{
$hours=$mins/60;
$hours=(integer)$hours;
$mins=$mins%60;
}

if ($hours>23)
{
$days=$hours/24;
$days=(integer)$days;
$hours=$hours%24;
}

if ($days>6)
{
$weeks=$days/7;
$weeks=(integer)$weeks;
$days=$days%7;
}

if ($weeks>3)
{
$months=$weeks/4;
$months=(integer)$months;
$weeks=$weeks%4;
}

if ($months>11)
{
$years=$months/12;
$years=(integer)$years;
$months=$months%12;
}

if($years>0)
{
if($years==1){$yearmsg="year";}else{$yearmsg="years";}
if($months==1){$monthsmsg="month";}else{$monthsmsg="months";}
if($days==1){$daysmsg="day";}else{$daysmsg="days";}
if($hours==1){$hoursmsg="hour";}else{$hoursmsg="hours";}
if($mins==1){$minsmsg="minute";}else{$minsmsg="minutes";}
if($secs==1){$secsmsg="second";}else{$secsmsg="seconds";}

if($months!=0){$monthscheck="$months $monthsmsg ";}else{$monthscheck="";}
if(($days!=0)&&($months==0)){$dayscheck="$days $daysmsg ";}else{$dayscheck="";}
if(($hours!=0)&&($months==0)&&($days==0)){$hourscheck="$hours $hoursmsg ";}else{$hourscheck="";}
if(($mins!=0)&&($months==0)&&($days==0)&&($hours==0)){$minscheck="$mins $minsmsg ";}else{$minscheck="";}
if(($secs!=0)&&($months==0)&&($days==0)&&($hours==0)&&($mins==0)){$secscheck="$secs $secsmsg";}else{$secscheck="";}

return "$years $yearmsg $monthscheck$dayscheck$hourscheck$minscheck$secscheck";
}

if(($years<1)&&($months>0))
{
if($months==1){$monthsmsg="month";}else{$monthsmsg="months";}
if($days==1){$daysmsg="day";}else{$daysmsg="days";}
if($hours==1){$hoursmsg="hour";}else{$hoursmsg="hours";}
if($mins==1){$minsmsg="minute";}else{$minsmsg="minutes";}
if($secs==1){$secsmsg="second";}else{$secsmsg="seconds";}

if($days!=0){$dayscheck="$days $daysmsg ";}else{$dayscheck="";}
if(($hours!=0)&&($days==0)){$hourscheck="$hours $hoursmsg ";}else{$hourscheck="";}
if(($mins!=0)&&($days==0)&&($hours==0)){$minscheck="$mins $minsmsg ";}else{$minscheck="";}
if(($secs!=0)&&($days==0)&&($hours==0)&&($mins==0)){$secscheck="$secs $secsmsg";}else{$secscheck="";}

return "$months $monthsmsg $dayscheck$hourscheck$minscheck$secscheck";
}

if(($months<1)&&($weeks>0))
{
if($weeks==1){$weeksmsg="week";}else{$weeksmsg="weeks";}
if($days==1){$daysmsg="day";}else{$daysmsg="days";}
if($hours==1){$hoursmsg="hour";}else{$hoursmsg="hours";}
if($mins==1){$minsmsg="minute";}else{$minsmsg="minutes";}
if($secs==1){$secsmsg="second";}else{$secsmsg="seconds";}

if($days!=0){$dayscheck="$days $daysmsg ";}else{$dayscheck="";}
if(($hours!=0)&&($days==0)){$hourscheck="$hours $hoursmsg ";}else{$hourscheck="";}
if(($mins!=0)&&($days==0)&&($hours==0)){$minscheck="$mins $minsmsg ";}else{$minscheck="";}
if(($secs!=0)&&($days==0)&&($hours==0)&&($mins==0)){$secscheck="$secs $secsmsg";}else{$secscheck="";}

return "$weeks $weeksmsg $dayscheck$hourscheck$minscheck$secscheck";
}

if(($weeks<1)&&($days>0))
{
if($days==1){$daysmsg="day";}else{$daysmsg="days";}
if($hours==1){$hoursmsg="hour";}else{$hoursmsg="hours";}
if($mins==1){$minsmsg="minute";}else{$minsmsg="minutes";}
if($secs==1){$secsmsg="second";}else{$secsmsg="seconds";}

if($hours!=0){$hourscheck="$hours $hoursmsg ";}else{$hourscheck="";}
if(($mins!=0)&&($hours==0)){$minscheck="$mins $minsmsg ";}else{$minscheck="";}
if(($secs!=0)&&($hours==0)&&($mins==0)){$secscheck="$secs $secsmsg";}else{$secscheck="";}

return "$days $daysmsg $hourscheck$minscheck$secscheck";
}

if(($days<1)&&($hours>0))
{
if($hours==1){$hoursmsg="hour";}else{$hoursmsg="hours";}
if($mins==1){$minsmsg="minute";}else{$minsmsg="minutes";}
if($secs==1){$secsmsg="second";}else{$secsmsg="seconds";}

if($mins!=0){$minscheck="$mins $minsmsg ";}else{$minscheck="";}
if(($secs!=0)&&($mins==0)){$secscheck="$secs $secsmsg";}else{$secscheck="";}

return "$hours $hoursmsg $minscheck$secscheck";
}

if(($hours<1)&&($mins>0))
{
if($mins==1){$minsmsg="minute";}else{$minsmsg="minutes";}
if(($secs==1)&&($mins==0)){$secsmsg="second";}else{$secsmsg="seconds";}

if($secs!=0){$secscheck="$secs $secsmsg";}else{$secscheck="";}

return "$mins $minsmsg $secscheck";
}

if(($mins<1)&&($sec>0))
{
if($sec==1){$secsmsg="second";}else{$secsmsg="seconds";}

if($sec!=0){$secscheck="$sec $secsmsg";}else{$secscheck="";}

return "$secscheck";
}else{
return "Online!";
}
}

/*{
  $yr = floor($sec/60/60/24/365);
  if($yr > 0)
  {
if($yr == 1)
{return "$yr year";}
else
{return "$yr years";}				
  }
  $mnth = floor($sec/60/60/24/7/4);
  if($mnth > 0)
  {
if($mnth == 1)
{return "$mnth month";}
else
{return "$mnth months";}				
  }
  $wks = floor($sec/60/60/24/7);
  if($wks > 0)
  {
if($wks == 1)
{return "$wks week";}
else
{return "$wks weeks";}				
  }
  $ds = floor($sec/60/60/24);
  if($ds > 0)
  {
if($ds == 1)
{return "$ds day";}
else
{return "$ds days";}				
  }
  $hs = floor($sec/60/60);
  if($hs > 0)
  {
if($hs == 1)
{return "$hs hour";}
else
{return "$hs hours";}				
  }
  $ms = floor($sec/60);
  if($ms > 0)
  {
if($ms == 1)
{return "$ms minute";}
else
{return "$ms minutes";}				
  }
  return "$sec Seconds";
}*/
/////////////////////////////////////////get status

function getstatus($uid)
{
  $info= mysql_fetch_array(mysql_query("SELECT perm, plusses FROM ibwf_users WHERE id='".$uid."'"));
  if(isbanned($uid))
  {
    return "Banned!";
  }
  if($info[0]=='4')
  {
    return "Site Owner!";
  }else if($info[0]=='3')
  {
    return "Head Administrator!";
  }else if($info[0]=='2')
  {
    return "Administrator!";
  }else if($info[0]=='1')
  {
    return "Moderator!";
  }else{
    if($info[1]<10)
    {
      return "Member";
    }else if($info[1]<25)
    {
        return "Member";
    }else if($info[1]<50)
    {
        return "Member";
    }else if($info[1]<75)
    {
        return "Member";
    }else if($info[1]<250)
    {
        return "Member";
    }else if($info[1]<500)
    {
        return "Member";
    }else if($info[1]<750)
    {
        return "Member";
    }else if($info[1]<1000)
    {
        return "Member";
    }else if($info[1]<1500)
    {
        return "Member";
    }else if($info[1]<2000)
    {
        return "Member";
    }else if($info[1]<2500)
    {
        return "Member";
    }else if($info[1]<3000)
    {
        return "Member";
    }else if($info[1]<4000)
    {
        return "Member";
    }else if($info[1]<5000)
    {
        return "Member";
    }else if($info[1]<10000)
    {
        return "Member";
    }else 
    {
        return "Member";
    }
  }
}

/////////////////////Get Page Jumber
function getjumper($action, $sid,$pgurl)
{
    $rets = "<form action=\"$pgurl.php\" method=\"get\">";
    $rets .= "<input type=\"hidden\" name=\"action\" value=\"$action\">";
    $rets .= "<input type=\"hidden\" name=\"sid\" value=\"$sid\">";
    $rets .= "<input name=\"page\" format=\"*N\" size=\"2\"/>";
    $rets .= "<input type=\"Submit\" name=\"Submit\" Value=\"Go To Page\"></form>";

    return $rets;

}
/////////////////////Get unread number of pms

function getunreadpm($uid)
{
    $nopm = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM ibwf_private WHERE touid='".$uid."' AND unread='1'"));
    return $nopm[0];
}

//////////////////////GET USER NICK FROM USERID

function getnick_uid($uid)
{
  $unick = mysql_fetch_array(mysql_query("SELECT name FROM ibwf_users WHERE id='".$uid."'"));
  return $unick[0];
}

///////////////////////////////////////////////Get the smilies

function getsmilies($text)
{
  $sql = "SELECT * FROM ibwf_smilies";
  $smilies = mysql_query($sql);
  while($smilie=mysql_fetch_array($smilies))
  {
    $scode = $smilie[1];
    $spath = $smilie[2];
    $text = str_replace($scode,"<img src=\"$spath\" alt=\"$scode\"/>",$text);
  }
  return $text;
}

function getgallery($text)
{
  $sql = "SELECT * FROM ibwf_gallery";
  $smilies = mysql_query($sql);
  while($smilie=mysql_fetch_array($smilies))
  {
    $scode = $gallery[1];
    $spath = $gallery[2];
    $text = str_replace($scode,"<img src=\"$spath\" alt=\"$scode\"/>",$text);
  }
  return $text;
}

////////////////////////////////////////////check nicks

function checknick($aim)
{
  $chk =0;
$aim = strtolower($aim);
  $nicks = mysql_query("SELECT id, name, nicklvl FROM ibwf_nicks");

while($nick=mysql_fetch_array($nicks))
{
    if($aim==$nick[1])
    {
      $chk = $nick[2];
    }else if(substr($aim,0,strlen($nick[1]))==$nick[1])
    {
      $chk = $nick[2];
    }else{
    $found = strpos($aim, $nick[1]);
    if($found!=0)
    {
        $chk = $nick[2];
    }
    }
}
return $chk;
}

function autopm($msg, $who)
{
    mysql_query("INSERT INTO ibwf_private SET text='".$msg."', byuid='1', touid='".$who."', unread='1', timesent='".time()."'");
    
}
function FtpUpload($dest_file, $src_file){
// set up basic connection

   $server='localhost'; // ftp server
   $connection = ftp_connect($server); // connection

   // login to ftp server
   $user = "linkrx7";
   $pass = "rotary";
   $result = ftp_login($connection, $user, $pass);
// check connection
if ((!$connection) || (!$result)) { 
       echo "FTP connection has failed!";
       echo "Attempted to connect to $ftp_server for user $ftp_user_name"; 
       exit; 
}
// upload the file
$upload = ftp_put($connection, $dest_file, $src_file, FTP_BINARY); 

// check upload status
if (!$upload) { 
       echo "FTP upload has failed!";
   }
// close the FTP stream 
ftp_close($connection);
}
////////////////////////////////////////////////////Register

function register($name,$pass,$usex,$day,$month,$year,$uloc,$email,$info, $ubr)
{
  $execms = mysql_query("SELECT * FROM ibwf_users WHERE name='".$name."';");
  
  if (mysql_num_rows($execms)>0){
    return 1;
  }else{
    $pass = md5($pass);
    $validation = mysql_fetch_array(mysql_query("SELECT value FROM ibwf_settings WHERE name='vldtn'"));
    if($validation[0]==1)
    {
    $validated=0;
    }else{
    $validated=1;
    }
    $reg = mysql_query("INSERT INTO ibwf_users SET name='".$name."', pass='".$pass."', birthday='".$year.$month.$day."', sex='".$usex."', location='".$uloc."', email='".$email."', signature='".$info."', regdate='".time()."', validated='".$validated."', ipadd='".getip()."', browserm='".$ubr."'");
    
    if ($reg)
    {
    $uid = getuid_nick($name);
      addonline($uid,"Just Registered","");
      $delonline = mysql_query("DELETE FROM ibwf_online WHERE userid='".$uid."'");
      $uid = mysql_fetch_array(mysql_query("SELECT id FROM ibwf_users WHERE name='".$name."'"));
      $sitename = mysql_fetch_array(mysql_query("SELECT value FROM ibwf_settings WHERE name='sitename'"));
      $msg = "Hello /reader =). Greetings from all $sitename[0] staff, we are happy to have you here, welcome to our big happy family!, If You Have any questions or comments about the site feel free to message me or any of the other staff members online. ENJOY!(excited)[br/][small][i]p.s: this is an automated pm[/i][/small]";
      $msg = mysql_escape_string($msg);
      autopm($msg, $uid[0]);
      return 0;
    }else{
      return 2;
      
    }
  }
  
}
/////////////////////// GET ibwf_users user id from nickname

function getuid_nick($nick)
{
  $uid = mysql_fetch_array(mysql_query("SELECT id FROM ibwf_users WHERE name='".$nick."'"));
  return $uid[0];
}

/////////////////////////////////////////Is admin?

function isadmin($uid)
{
  $admn = mysql_fetch_array(mysql_query("SELECT perm FROM ibwf_users WHERE id='".$uid."'"));
  if($admn[0]>=2)
  {
    return true;
  }else{
    return false;
  }
}

/////////////////////////////////////////Is admin?

function isheadadmin($uid)
{
  $admn = mysql_fetch_array(mysql_query("SELECT perm FROM ibwf_users WHERE id='".$uid."'"));
  if($admn[0]==3)
  {
    return true;
  }else{
    return false;
  }
}

/////////////////////////////////////////Is owner?

function isowner($uid)
{
  $own = mysql_fetch_array(mysql_query("SELECT perm FROM ibwf_users WHERE id='".$uid."'"));
  if($own[0]==4)
  {
    return true;
  }else{
    return false;
  }
}
///////////////////////////////////

function swearing($str)
{
  $str = str_replace(" ","",$str);
  $sites[0] = "fuck";
  $sites[1] = "shit";
  $sites[2] = "dick";
  $sites[3] = "pussy";
  $sites[4] = "cunt";
  $sites[5] = "cock";
  $sites[6] = "slut";
  $sites[7] = "faggot";
  $sites[8] = "wanker";
  $sites[9] = "prick";
  $sites[10] = "bastard";
  $sites[11] = "bitch";

  for($i=0;$i<count($sites);$i++)
  {
  $str = strtolower($str);
        $nosf = substr_count($str,$sites[$i]);
    if($nosf>0)
    {
      return true;
    }
  }
  return false;
}
///////////////////////////////////parse bbcode

function getbbcode($text, $sid="", $filtered)
{
  $text = htmlspecialchars($text);
  $text=preg_replace("/\[b\](.*?)\[\/b\]/i","<b>\\1</b>", $text);
  $text=preg_replace("/\[i\](.*?)\[\/i\]/i","<i>\\1</i>", $text);
  $text=preg_replace("/\[u\](.*?)\[\/u\]/i","<u>\\1</u>", $text);
  $text=preg_replace("/\[big\](.*?)\[\/big\]/i","<big>\\1</big>", $text);
  $text=preg_replace("/\[small\](.*?)\[\/small\]/i","<small>\\1</small>", $text);
  $text = preg_replace("/\[url\=(.*?)\](.*?)\[\/url\]/is","<a href=\"$1\">$2</a>",$text);
  $text = preg_replace("/\[topic\=(.*?)\](.*?)\[\/topic\]/is","<a href=\"index.php?action=viewtpc&amp;tid=$1&amp;sid=$sid\">$2</a>",$text);
  $text = preg_replace("/\[club\=(.*?)\](.*?)\[\/club\]/is","<a href=\"index.php?action=gocl&amp;clid=$1&amp;sid=$sid\">$2</a>",$text);
  $text = preg_replace("/\[blog\=(.*?)\](.*?)\[\/blog\]/is","<a href=\"index.php?action=viewblog&amp;bid=$1&amp;sid=$sid\">$2</a>",$text);
  //$text = ereg_replace("http://[A-Za-z0-9./=?-_]+","<a href=\"\\0\">\\0</a>", $text);
  if(substr_count($text,"[br/]")<=3){
  $text = str_replace("[br/]","<br/>",$text);
  }
  $sml = mysql_fetch_array(mysql_query("SELECT hvia FROM ibwf_users WHERE id='".getuid_sid($sid)."'"));
  if ($sml[0]=="1")
  {
  $text = getsmilies($text);
  }
if($filtered=="1"){
if(swearing($text))
{
$text = strtolower($text);
$text = str_replace("fuck","f*ck",$text);
$text = str_replace("shit","sh*t",$text);
$text = str_replace("dick","d*ck",$text);
$text = str_replace("pussy","pu**y",$text);
$text = str_replace("cunt","c*nt",$text);
$text = str_replace("cock","c*ck",$text);
$text = str_replace("slut","sl*t",$text);
$text = str_replace("faggot","f*gg*t",$text);
$text = str_replace("wanker","w*nk*r",$text);
$text = str_replace("prick","pr*ck",$text);
$text = str_replace("bastard","b*st*rd",$text);
$text = str_replace("bitch","b*tch",$text);
}
}
  return $text;
}


//////////////////////////////////////////////////MISC FUNCTIONS
function spacesin($word)
{
  $pos = strpos($word," ");
  if($pos === false)
  {
    return false;
  }else
  {
    return true;
  }
}

/////////////////////////////////Number of registered members
function regmemcount()
{
  $rmc = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM ibwf_users"));
  return $rmc[0];
}
///////

///////////////////////////function counter

function addvisitor()
{
  $cc = mysql_fetch_array(mysql_query("SELECT value FROM ibwf_settings WHERE name='Counter'"));
  $cc = $cc[0]+1;
  $res = mysql_query("UPDATE ibwf_settings SET value='".$cc."' WHERE name='Counter'");
}

function scharin($word)
{
  $chars = "abcdefghijklmnopqrstuvwxyz0123456789-_";
  for($i=0;$i<strlen($word);$i++)
  {
    $ch = substr($word,$i,1);
  $nol = substr_count($chars,$ch);
  if($nol==0)
  {
    return true;
  }
  }
  return false;
}

function isdigitf($word)
{
  $chars = "abcdefghijklmnopqrstuvwxyz";
    $ch = substr($word,0,1);
  $sres = ereg("[0-9]",$ch);
   
    $ch = substr($word,0,1);
  $nol = substr_count($chars,$ch);
  if($nol==0)
  {
    return true;
  }


  return false;

}
