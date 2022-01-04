<?
include "head.php";
if(empty($adminId) || $adminId =="")
{
	OnlyMsgView("올바른 접근이 아닙니다.");
	ReFresh("adm.php");
	exit;
}
if(!defined(__ADMIN_ROW))
{
	define(__ADMIN_ROW,"TRUE");
	$admin_row=$MySQL->fetch_array("select *from admin limit 0,1"); //관리자 정보 배열
}
/*------------------------관리자 기본 설정 수정 ---------------------------------*/
$comNum = $comNum1."-".$comNum2."-".$comNum3;
$comZip = $comZip1."-".$comZip2;
$qry = "update admin set ";
$qry.= "shopUrl    = '$shopUrl',";		//쇼핑몰 주소
$qry.= "shopTitle  = '$shopTitle',";	//쇼핑몰 제목
$qry.= "shopName   = '$shopName',";	    //쇼핑몰 제목
$qry.= "adminId	   = '$adminId',";		//관리자 아이디
$qry.= "adminPwd   = '$adminPwd',";		//관리자 비밀번호
$qry.= "adminEmail = '$adminEmail',";	//관리자 이메일
$qry.= "comName	   = '$comName',";		//상호
$qry.= "comNum	   = '$comNum',";		//사업자 등록번호
$qry.= "comCon     = '$comCon',";		//업태
$qry.= "comItem    = '$comItem',";		//종목
$qry.= "comCeo     = '$comCeo',";		//대표자 명
$qry.= "comAdr     = '$comAdr',";		//사업장 주소
$qry.= "comTel     = '$comTel',";		//연락처
$qry.= "comFax     = '$comFax', ";		//팩스
$qry.= "esailNum   = '$esailNum', ";		//통신판매업신고번호
$qry.= "adminEmail2 = '$adminEmail2',";
$qry.= "startpage_adm = '$startpage_adm',";
$qry.= "guard = '$guard',";
$qry.= "comZip = '$comZip',";
$qry.= "shopKeyword = '$shopKeyword',";
$qry.= "editDay = now()";

if ($adminId != $admin_row[adminId] || $adminPwd != $admin_row[adminPwd]) //관리자 아이디나 암호가 바뀌어지면 세션 갱신 
{
	@session_unregister("GOOD_SHOP_ADMIN_USERID") or die("session_unregister err");
	@session_unregister("GOOD_SHOP_ADMIN_PWD") or die("session_register err");
	$GOOD_SHOP_ADMIN_USERID		= $adminId;
	$GOOD_SHOP_ADMIN_PWD		= $adminPwd;
	$_SESSION['GOOD_SHOP_ADMIN_USERID']		= "$GOOD_SHOP_ADMIN_USERID";
	$_SESSION['GOOD_SHOP_ADMIN_PWD']		= "$GOOD_SHOP_ADMIN_PWD";
}
if($MySQL->query($qry))
{
	OnlyMsgView("수정완료 하였습니다.");
	ReFresh("adm.php");
}
else
{
	ErrMsg($qry);
	ReFresh("adm.php");
}
?>