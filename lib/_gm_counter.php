<?
function set_os($os)
{
	global $os_version,$os_name,$array;
	$os_version="";
	for($i=0;$i<sizeof($array);$i++)
	{
		$j=$i+1;
		if(eregi("$os",$array[$i]) && eregi("^[0-9]{1,2}([\.]{1}[0-9]{1,2})*[a-z]{0,1}$",$array[$j])) $os_version=$array[$j];
	}
}

function set_br($br)
{
	global $br_version,$br_name,$array;
	$br_version="";
	for($i=0;$i<sizeof($array);$i++)
	{
		$j=$i+1;
		if(eregi("$br",$array[$i]) && eregi("^[0-9]{1,2}([\.]{1}[0-9]{1,2})*[a-z]{0,1}$",$array[$j])) $br_version=$array[$j];
	}
}

function check_agent()
{
	global $HTTP_SERVER_VARS,$os_name,$os_version,$br_version,$br_name,$array;
	$temp=$HTTP_SERVER_VARS["HTTP_USER_AGENT"];
	$temp=eregi_replace("([ 0-9\.\])*%","",$temp);
	$temp=trim(eregi_replace("-|_|=|\+|;"," ",$temp));
	$array=split(" ",$temp);
	if(eregi("([a-z])+/",$array[0])){$br_version_temp=split("/",$array[0]);}
	$br_version_temp=$br_version_temp[1];
	if(eregi("Win|Window",$temp))
	{
		$os_name="Windows";
		if(ereg("s 3\.1|n3\.1",$temp)) $os_version="3.1";
		if(ereg("s 95|n95",$temp)) $os_version="95";
		if(ereg("s 98|n98",$temp)) $os_version="98";
		if(ereg("s ME|nME",$temp)) $os_version="ME";
		if(ereg("s NT|nNT",$temp)) $os_version="NT";
		if(ereg("s NT|nNT",$temp) && eregi("T 5\.0| 2000",$temp)) $os_version="2000";
		if(ereg("s NT|nNT",$temp) && eregi("T 5\.1| XP",$temp)) $os_version="XP";
	}
	elseif(eregi("Mac PowerPC|PPC",$temp))
	{
		$os_name="Mac PowerPC";
		set_os("Mac powerPC");
	}
	elseif(eregi("Mac",$temp))
	{
		$os_name="Macintosh";
		set_os("Mac");
	}
	elseif(eregi("Linux",$temp))
	{
		$os_name="Linux";
		set_os("Linux");
	}
	elseif(eregi("IRIX",$temp))
	{
		$os_name="IRIX";
		set_os("IRIX");
	}
	elseif(eregi("sunOS",$temp))
	{
		$os_name="sunOS";
		set_os("sunOS");
	}
	elseif(eregi("phone",$temp))
	{
		$os_name="CellPhone";
		set_os("phone");
	}
	else
	{
		$os_name="Unknown";
		$os_version="";
	}
	if(eregi("MSN",$temp))
	{
		$br_name="MSN";
		set_br("MSN");
	}
	elseif(eregi("MSIE",$temp))
	{
		$br_name="MSIE";
		set_br("MSIE");
	}
	elseif(eregi("(\[){1}[a-z]{1,3}(\]){1}",$temp) && eregi("\]",$temp))
	{
		$br_name="Netscape";
		$br_version=$br_version_temp;
	}
	elseif(eregi("opera",$temp))
	{
		$br_name="Opera";
		set_br("opera");
		if(!$br_version)
		{
			$br_version=$br_version_temp;
		}
	}
	elseif(eregi("gec|gecko",$temp))
	{
		$br_name="Gecko";
		set_br("Gecko");
		if(!$br_version)
		{
			$br_version=$br_version_temp;
		}
	}
	elseif(eregi("MSMB",$temp))
	{
		$br_name="MSMB";
	}
	else
	{
		$br_name="Unknown";
	}
}
$gm_session_id	= session_id();
$gm_year		= date("Y");
$gm_month		= date("m");
$gm_day			= date("d");
$gm_hour		= date("H");
$gm_week		= date("w");
if(substr($_SERVER[PHP_SELF],-15)!='_gm_counter.php')
{
	$MySQL->query("SELECT * FROM GM_Counter WHERE gm_session_id='".$gm_session_id."' and gm_year='".$gm_year."' and gm_month='".$gm_month."' and gm_day='".$gm_day."' and gm_hour='".$gm_hour."'");
	if($MySQL->is_affected())
	{
		$MySQL->query("UPDATE GM_Counter SET gm_page_view=gm_page_view+1 WHERE gm_session_id='".$gm_session_id."' and gm_year='".$gm_year."' and gm_month='".$gm_month."' and gm_day='".$gm_day."' and gm_hour='".$gm_hour."'");
	}
	else
	{
		$log=@str_replace("http://www.","http://",$_SERVER[HTTP_REFERER]);
		$log=@str_replace("http://","",$log);
		$gm_http_referer		= eregi_replace("^(.{2,6}://)?([^/]*)?(.*)", "\\2", $log);	//방문경로주소

		check_agent();
		$gm_brower	= $br_name." ".$br_version;
		$gm_os		= $os_name." ".$os_version;

		$qry = "INSERT INTO GM_Counter SET
					gm_session_id			= '".$gm_session_id."',
					gm_page_view			= 1,
					gm_year					= '".$gm_year."',
					gm_month				= '".$gm_month."',
					gm_day					= '".$gm_day."',
					gm_hour					= '".$gm_hour."',
					gm_week					= '".$gm_week."',
					gm_http_referer			= '".$gm_http_referer."',
					gm_http_referer_detail	= '".$_SERVER[HTTP_REFERER]."',
					gm_remote_addr			= '".$_SERVER[REMOTE_ADDR]."',
					gm_http_user_agent		= '".$_SERVER[HTTP_USER_AGENT]."',
					gm_brower				= '".$gm_brower."',
					gm_os					= '".$gm_os."'
				";
		$MySQL->query($qry);
	}
}
?>