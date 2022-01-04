<?
include "head.php";
$cate_row=$MySQL->fetch_array("select *from category where code='$parentcode'");  //현재 카테고리 정보
$good_code = strtoupper($good_code);
$qry = "update category set ";
$qry.= "name = '$name', ";			//카테고리명
$qry.= "bHide = '$bHide', ";
$qry.= "editday = now() ";
$qry.= " where code='$parentcode'";
if($MySQL->query($qry))
{
	OnlyMsgView("수정완료 하였습니다.");
	ReFresh("category_manage.php");
}
else
{
	echo "$qry";
}
?>