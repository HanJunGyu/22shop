<?
session_start();
$now = date("YmdHis",time());
$EXCEL_NAME = "member_".$now.".csv";
header( "Content-type: application/vnd.ms-excel; charset=ks_c_5601-1987" ); 
header( "Content-Disposition: attachment; filename=$EXCEL_NAME" ); 
header( "Content-Description: PHP4 Generated Data" );
include "../lib/config.php";
include "../lib/function.php";
$EXCEL_STR ="아이디,이름,가입일,구매금액,적립금,방문수,이메일,주민등록번호,우편번호,주소,연락처,핸드폰,최근접속일\r\n";
if(!$searchstring)
{
	$search=$data[search];
	$searchstring=$data[searchstring];
}
if(empty($sort1))
{
	$sort1= "writeday";
	$sort2= "desc";
}
if($searchstring) $qry="select * from member where $search like '%$searchstring%'";
else $qry="select * from member";
if($what=="visit")
{
	$now = date("Y-m-d",strtotime ("-$break months"));
	$qry.=" and (nearDay < '$now' or nearDay is NULL)";
}
if($what=="buy")
{
	$now = date("Y-m-d",strtotime ("-$break months"));
	$qry.=" and (nearBuy < '$now' or nearBuy is Null)";
}
if($sex==1) $qry.=" and (mid(ssh,8,1)=1 or mid(ssh,8,1)=3)";
if($sex==2) $qry.=" and (mid(ssh,8,1)=2 or mid(ssh,8,1)=4)";
$today_year = substr(date("Y"),2,2)+101;
if($age)
{
	$start_age = $age/10;
	$end_age = $start_age+1;
	$qry.=" and (left($today_year-left(ssh,2),1)>=$start_age and left($today_year-left(ssh,2),1)<$end_age)";
}
if($money)
{
	if ($updown == "up") $qry.=" and $money >= $price";
	else if ($updown == "down") $qry.=" and $money <= $price";
}
if($birthmail)
{
	$tomonth = date("m");
	$today = date("d");
	if (substr($tomonth,0,1)=="0") $tomonth = substr($tomonth,1,1);
	if (substr($today,0,1)=="0") $today = substr($today,1,1);
	$str = $tomonth."-".$today;
	$qry.= " and substring(birth,6,3)='$str'";
}
if($birthmail2)
{
	$tomonth = date("m");
	$today = date("d");
	if (substr($tomonth,0,1)=="0") $tomonth = substr($tomonth,1,1);
	if (substr($today,0,1)=="0") $today = substr($today,1,1);
	$str = $tomonth."-".$today;
	$qry.= " and substring(birth2,6,3)='$str'";
}
if($gubun)
{
	if($gubun=="M") $qry.=" and part='$gubun'";
	else if($gubun=="D") $qry.=" and part='$gubun'";
}
$bbs_result=$MySQL->query($qry);
$s_letter=$letter_no;
while($bbs_row=mysql_fetch_array($bbs_result))
{
	$writeday = substr($bbs_row[writeday],0,16);
	$nearday = substr($bbs_row[nearDay],0,16);
	$EXCEL_STR.="$bbs_row[userid],";
	$EXCEL_STR.="$bbs_row[name],";
	$EXCEL_STR.="$writeday,";
	$EXCEL_STR.="$bbs_row[buyMoney],";
	$EXCEL_STR.="$bbs_row[point],";
	$EXCEL_STR.="$bbs_row[accNum],";
	$EXCEL_STR.="$bbs_row[email],";
	$EXCEL_STR.="$bbs_row[ssh],";
	$EXCEL_STR.="$bbs_row[zip],";
	$EXCEL_STR.="$bbs_row[address1]"." $bbs_row[address2],";
	$EXCEL_STR.="$bbs_row[tel],";
	$EXCEL_STR.="$bbs_row[hand],";
	$EXCEL_STR.="$nearday \r\n";
}
echo $EXCEL_STR;
?>