<?
session_start();
$date = date("Ymd");
$time = date("His");
$f_name = "invoice".$date."_".$time.".xls";
header( "Content-type: application/vnd.ms-excel; charset=ks_c_5601-1987");
header( "Content-Disposition: attachment; filename=$f_name");
header( "Content-Description: PHP4 Generated Data");
include "../lib/config.php";
include "../lib/function.php";
if(!defined(__ADMIN_ROW))
{
	define(__ADMIN_ROW,"TRUE");
	$admin_row=$MySQL->fetch_array("select *from admin limit 0,1");
}

$spec_report = $admin_row[trans_content];
$comZip = str_replace("-","",$admin_row[comZip]);
$comAdr = $admin_row[comAdr];
$comName = $admin_row[comName];
$comTel = $admin_row[comTel];

$qry = "select * from trade where status=1";
$f_result=$MySQL->query($qry);
//echo "받는사람,우편번호,주소,주문자,고객전화1,고객전화2,발송회사,발송우편,발송자주소,일련번호,발송전화1,발송전화2,수량,고정일련번호,,요구사항,고정일련번호,,,주의사항\n";

$i=1;
while($f_row = mysql_fetch_array($f_result))
{
	$content = str_replace("\r\n","",$f_row[content]);
	$temp_num = "34500".$i;
	$EXCEL_STR = "";	
	$EXCEL_STR.="$f_row[rname]\t";
	$EXCEL_STR.="$f_row[rzip]\t";
	$EXCEL_STR.="$f_row[radr1] $f_row[radr2]\t";
	$EXCEL_STR.="$f_row[name]\t";
	$EXCEL_STR.="$f_row[rtel]\t";
	$EXCEL_STR.="$f_row[rhand]\t";
	$EXCEL_STR.="$admin_row[comName]\t";
	$EXCEL_STR.="$comZip\t";
	$EXCEL_STR.="$comAdr\t";
	$EXCEL_STR.="$temp_num\t";
	$EXCEL_STR.="$comTel\t";
	$EXCEL_STR.="$comTel2\t";
	$EXCEL_STR.="1\t";
	$EXCEL_STR.="$i\t\t";
	$EXCEL_STR.="$content\t";
	$EXCEL_STR.="$i\t\t\t";
	$EXCEL_STR.="$spec_report\n";

	echo $EXCEL_STR;
	$i++;
}
?>