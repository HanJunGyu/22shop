<?
session_start();
include "./lib/config.php";
include "./lib/function.php";
/*------------------------상품평 글 등록 ---------------------------------*/
if ($del)
{
	$qry="DELETE from goods_comment WHERE idx=$com_idx and userid='$_SESSION[GOOD_SHOP_USERID]'";
	if($MySQL->query($qry))
	{
		ReFresh("goods_detail.php?goodsIdx=$goodsIdx");
	}
	else
	{
		echo"Err. : $qry";
	}
}
else
{
	$qry = "insert into goods_comment (gidx,userid,content,userIp,name,writeday)values(";
	$qry.= "$goodsIdx,";
	$qry.= "'$_SESSION[GOOD_SHOP_USERID]',";
	$qry.= "'$content',";
	$qry.= "'$REMOTE_ADDR',";
	$qry.= "'$name',";
	$qry.= "now()";
	$qry.= ")";
	if($MySQL->query($qry))
	{
		ReFresh("goods_detail.php?goodsIdx=$goodsIdx");
	}
	else
	{
		echo"Err. : $qry";
	}
}
?>