<?
session_start();
include "html_head.php";
if(empty($GOOD_SHOP_ADMIN_USERID) || (($admin_row[adminId] != $_SESSION['GOOD_SHOP_ADMIN_USERID']) && ($admin_row[adminPwd] != $_SESSION['GOOD_SHOP_ADMIN_PWD'])))
{
	MsgViewHref("올바른 접근이 아니거나 3분간 아무작업이 없을때 로그인이 끊깁니다.\\n\\n본사이트의 비정상적인 접근은 법적 불이익을 받으실 수 있습니다.", "index.php");
	exit;
}

if($_GET["admin_author"]) $admin_author = 0;	// 보안상 0으로 셋팅(url 직접입력)
?>