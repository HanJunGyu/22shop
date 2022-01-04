<?
// 소스형상관리
// 20060714_1 소스수정 최호수 (통계 프로그램 수정으로 인한 소스 수정)
session_start();
include "../lib/config.php";
include "../lib/function.php";
$adminId = $_POST["adminId"];
$adminPwd = $_POST["adminPwd"];
$HTTP_REFERER = $_SERVER["HTTP_REFERER"];
$HTTP_REFERER = explode("admin/",$HTTP_REFERER);
$HTTP_REFERER = $HTTP_REFERER[1];
/*------------------------ 관리자 로그인---------------------------------*/
if(!empty($del))
{
	@session_unregister("GOOD_SHOP_ADMIN_USERID") or die("session_unregister err");
	@session_unregister("GOOD_SHOP_ADMIN_NAME") or die("session_register err");
	@session_unregister("GOOD_SHOP_ADMIN_PWD") or die("session_register err");
	$MySQL->query("update admin set nearDay=now()"); /////접속완료시각 저장 
	ReFresh("index.php");
}
else
{
	if ($_SESSION['GOOD_SHOP_ADMIN_USERID'])
	{
		OnlyMsgView("관리자 인증세션이 남아있으므로 로그아웃 후 재로그인 합니다.");
		@session_unregister("GOOD_SHOP_ADMIN_USERID") or die("session_unregister err");
		@session_unregister("GOOD_SHOP_ADMIN_NAME") or die("session_register err");
		@session_unregister("GOOD_SHOP_ADMIN_PWD") or die("session_register err");
		Refresh("index.php");
		exit;
	}
	$admin_row = $MySQL->fetch_array("select *from admin");
	if($admin_row[adminId]==$adminId && $admin_row[adminPwd]==$adminPwd) //로그인 성공 
	{
		$GOOD_SHOP_ADMIN_USERID	= $adminId;
		$GOOD_SHOP_ADMIN_PWD      = $admin_row[adminPwd];
		$_SESSION['GOOD_SHOP_ADMIN_USERID'] = "$GOOD_SHOP_ADMIN_USERID";
		$_SESSION['GOOD_SHOP_ADMIN_PWD'] = "$GOOD_SHOP_ADMIN_PWD";
		$_SESSION['GOOD_SHOP_ADMIN_NAME'] = "관리자"; 
		if ($admin_row[nearDay]=="0000-00-00 00:00:00")
		{
			$MySQL->query("update admin set nearDay=now()"); /////접속완료시각 저장
		}
		///////오늘본 상품목록 중 오늘이전의 정보는 자동삭제//////////
		$today=date("Y-m-d"); 
		$MySQL->query("DELETE from today_view WHERE left(writeday,10)<'$today'");
		if ($admin_row[startpage_adm]) ReFresh($admin_row[startpage_adm]);
		else ReFresh("sale_status.php");
	}
	else
	{
		MsgView("관리자의 아이디 또는 비밀번호가 올바르지 않습니다.",-1);
	}
}
?>