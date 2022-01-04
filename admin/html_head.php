<?
include "../lib/config.php";
include "../lib/function.php";
if(!defined(__ADMIN_ROW))
{
	define(__ADMIN_ROW,"TRUE");
	$admin_row=$MySQL->fetch_array("select * from admin limit 0,1");
}
if(!defined(__DESIGN_ROW))
{
	define(__DESIGN_ROW,"TRUE");
	$design=$MySQL->fetch_array("select * from design limit 0,1");
}
if(!defined(__DESIGN_GOODS_ROW))
{
	define(__DESIGN_GOODS_ROW,"TRUE");
	$design_goods=$MySQL->fetch_array("select * from design_goods limit 0,1");
}
if(!defined(__WEBMAIL_ADMIN_ROW))
{
	define(__WEBMAIL_ADMIN_ROW,"TRUE");
	$webmail_admin_row=$MySQL->fetch_array("select * from webmail_admin limit 0,1");
}
$GOOD_SHOP_ADMIN_NAME = $_SESSION["GOOD_SHOP_ADMIN_NAME"];
$GOOD_SHOP_ADMIN_USERID = $_SESSION["GOOD_SHOP_ADMIN_USERID"];

// GD 2.0 셋팅정보
$GD_SET = $admin_row[bGdset];
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=euc-kr">
<title><?=$admin_row[shopTitle]?> 관리자</title>
<style>
<?= $design[css]?>
</style>
<script language=javascript src="../script/admin.js"></script>
</head>