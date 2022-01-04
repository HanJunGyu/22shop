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

$qry = "select * from trade where status=1";
$f_result=$MySQL->query($qry);
echo "회사명\t수취명\t전화번호\t우편번호\t주소\t기타주소\t품명1\t타입1\t수량1\t운임구분\t기본운임\t기타운임\t주의사항\t운송장번호\t주문자\t취급주의\t파손주의\t품명5\t품명6\t핸드폰\t주문번호\t구분 \n";
$i=1;
while($f_row = mysql_fetch_array($f_result))
{
	$content = str_replace("\r\n","",$f_row[content]);
	$EXCEL_STR = "";
	$EXCEL_STR.="$admin_row[comName]\t";
	$EXCEL_STR.="$f_row[rname]\t";
	$EXCEL_STR.="$f_row[rtel]\t";
	$EXCEL_STR.="$f_row[rzip]\t";
	$EXCEL_STR.="$f_row[radr1]\t";
	$EXCEL_STR.="$f_row[radr2]\t";
	$EXCEL_STR.="\t";
	$EXCEL_STR.="1\t";
	$EXCEL_STR.="1\t";
	$EXCEL_STR.="3\t";
	$EXCEL_STR.="\t";
	$EXCEL_STR.="\t";
	$EXCEL_STR.="$content\t";	//주의 , 특기사항
	$EXCEL_STR.="$f_row[trans_num]\t";
	$EXCEL_STR.="$f_row[name]\t";
	$EXCEL_STR.="\t";	//취급주의
	$EXCEL_STR.="\t";	//파손주의
	$EXCEL_STR.="\t";	//품명5
	$EXCEL_STR.="\t";	//품명6
	$EXCEL_STR.="$f_row[rhand]\t";
	$EXCEL_STR.="$f_row[tradecode]\t";
	$EXCEL_STR.="구분\n";

	echo $EXCEL_STR;
	$i++;
}
?>