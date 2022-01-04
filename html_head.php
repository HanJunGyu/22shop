<?
include "./lib/config.php";
include "./lib/function.php";
if(!defined(__INCLUDE_CLASS_PHP)) include "./lib/class.php";
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
$subdesign=$MySQL->fetch_array("select * from sub_design limit 0,1");
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
$__SITE_ALIGN = $design[mainAlign];	//사이트 정열방식 ex)left, center
$USERID = $_SESSION["GOOD_SHOP_USERID"];
$GOOD_SHOP_PART_GUBUN = $_SESSION["GOOD_SHOP_PART_GUBUN"];

// GD 2.0 셋팅정보
$GD_SET = $admin_row[bGdset];

// 상품목록 진열방식
$designType = $design_goods[designType];
?>
<html>
<head>
<style>
<?= $design[css]?>
</style>
<meta http-equiv="Content-Type" content="text/html; charset=euc-kr">
<?
// 메타검색 정보 입력 goods_detail.php 페이지일 경우 상단 타이틀 및 메타태그 상품의 정보 입력
if($__THIS_PAGE_NAME == "goods_detail.php")
{
	$goods_row=$MySQL->fetch_array("select name,meta_str from goods where idx=$goodsIdx limit 1");
	if ($goods_row[meta_str])
	{
		$meta_str = $goods_row[meta_str];
		$title_str = $meta_str;
	}
	else
	{
		$meta_str = $goods_row[name];
		$title_str = $meta_str;
	}
}
else if ($__THIS_PAGE_NAME == "goods_list.php")
{
	$c_row=$MySQL->fetch_array("select name from category where idx=$Index limit 1");
	if ($c_row[name])
	{
		$meta_str = $c_row[name];
		$title_str = $meta_str;
	}
	else
	{
		$meta_str = $admin_row[shopTitle];
		$title_str = $meta_str;
	}
}
else
{
	$title_str = $admin_row[shopTitle];
	$meta_str = $admin_row[shopKeyword];
}
?>
<title><?=$title_str?></title>
<META name="description" content="<?=$meta_str?>">
<META name="keywords" content="<?=$meta_str?>">
<script language=javascript src="./script/admin.js"></script>
</head>