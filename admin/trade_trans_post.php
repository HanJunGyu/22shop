<?
session_start();
$date = date("Ymd");
$time = date("Hims");
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
echo "수취인명\t수취인주소\t수취인상세주소\t수취인우편번호\t수취인전화번호\t수취인이동통신\t상품명\t요금구분코드\n";

$i=1;
while($f_row = mysql_fetch_array($f_result))
{
	$content = str_replace("\r\n","",$f_row[content]);
	$EXCEL_STR = "";
	$EXCEL_STR.="$f_row[rname]\t";
	$EXCEL_STR.="$f_row[radr1]\t";
	$EXCEL_STR.="$f_row[radr2]\t";
	$EXCEL_STR.="$f_row[rzip]\t";
	$EXCEL_STR.="$f_row[rtel]\t";
	$EXCEL_STR.="$f_row[rhand]\t";
	$EXCEL_STR.="$admin_row[trans_goodname]\t";
	$EXCEL_STR.=" \t\n";

	echo $EXCEL_STR;
	$i++;
}
?>