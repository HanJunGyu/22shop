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
	$admin_row=$MySQL->fetch_array("select * from admin limit 0,1");
}

$spec_report = $admin_row[trans_content];
$trans_goodname = $admin_row[trans_goodname];

$qry = "select * from trade where status=1";
$f_result=$MySQL->query($qry);
$today = date("Y-m-d",time());
//echo "회사명\t수취인\t전화번호\t핸드폰\t우편번호\t주소\t화물명\t주의사항\t특기사항 \n";
//echo "공란\t날짜\t우편번호\t주소\t수화인\t전화1\t전화2\t메세지1\t메세지2\t공란\t일련번호\t수량\t공란\t품목\n";
echo"수신자 성명\t수신자 연락처1\t수신자 연락처2\t수신자 우편번호\t수신자 주소\tbox수량\tbox크기\t결제구분\t구매자 메모\n";

$i=1;
while($f_row = mysql_fetch_array($f_result))
{
	$content = str_replace("\r\n","",$f_row[content]);
	if ($f_row[payMethod]=="card") $payMethod = "카드";
	else if ($f_row[payMethod]=="bank") $payMethod = "무통장";
	else if($f_row[payMethod]==$HAND_STR) $payMethod = "핸드폰";
	else if($f_row[payMethod]=="iche") $payMethod = "계좌이체";
	else if($f_row[payMethod]=="cyber") $payMethod = "가상계좌";

	$EXCEL_STR.="$f_row[rname]\t";
	$EXCEL_STR.="$f_row[rtel]\t";
	$EXCEL_STR.="$f_row[rhand]\t";
	$EXCEL_STR.="$f_row[rzip]\t";
	$EXCEL_STR.="$f_row[radr1] $f_row[radr2]\t";
	$EXCEL_STR.= "1\t";
	$EXCEL_STR.= "\t";
	$EXCEL_STR.= "$payMethod\t";
	$EXCEL_STR.="$content\t\n";

	echo $EXCEL_STR;
	$i++;
}
?>