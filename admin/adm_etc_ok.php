<?
include "head.php";

if($part==1)
{
	if($bRegmail_bHtml==1) $mail_join = $mail_join_Text;
	elseif($bRegmail_bHtml==2) $mail_join = $mail_join_Html;
	$qry = "update admin set ";
	$qry.= "bRegmail	= '$bRegmail', ";
	$qry.= "mail_join	= '$mail_join', ";
	$qry.= "bRegmail_bHtml	= '$bRegmail_bHtml' ";
}
if($part==2)
{
	if($bBuymail_bHtml==1) $mail_buy = $mail_buy_Text;
	elseif($bBuymail_bHtml==2) $mail_buy = $mail_buy_Html;
	$qry = "update admin set ";
	$qry.= "bBuymail	= '$bBuymail', ";
	$qry.= "mail_buy	= '$mail_buy', ";
	$qry.= "bBuymail_bHtml	= '$bBuymail_bHtml' ";
}
if($part==3)
{
	if($bTramail_bHtml==1) $mail_trans = $mail_trans_Text;
	elseif($bTramail_bHtml==2) $mail_trans = $mail_trans_Html;
	$qry = "update admin set ";
	$qry.= "bTramail	= '$bTramail', ";
	$qry.= "mail_trans	= '$mail_trans', ";
	$qry.= "bTramail_bHtml	= '$bTramail_bHtml' ";
}
if($part==4)
{
	if($bEscmail_bHtml==1) $mail_cancel = $mail_cancel_Text;
	elseif($bEscmail_bHtml==2) $mail_cancel = $mail_cancel_Html;
	$qry = "update admin set ";
	$qry.= "bEscmail	= '$bEscmail', ";
	$qry.= "mail_cancel	= '$mail_cancel', ";
	$qry.= "bEscmail_bHtml	= '$bEscmail_bHtml' ";
}
if($part==5)
{
	if($bPassmail_bHtml==1) $mail_pwd = $mail_pwd_Text;
	elseif($bPassmail_bHtml==2) $mail_pwd = $mail_pwd_Html;
	$qry = "update admin set ";
	$qry.= "bPassmail	= '$bPassmail', ";
	$qry.= "mail_pwd	= '$mail_pwd', ";
	$qry.= "bPassmail_bHtml	= '$bPassmail_bHtml' ";
}
if($part==6)
{
	if($bCommail_bHtml==1) $mail_bottom = $mail_bottom_Text;
	elseif($bCommail_bHtml==2) $mail_bottom = $mail_bottom_Html;
	$qry = "update admin set ";
	$qry.= "mail_bottom	= '$mail_bottom', ";
	$qry.= "bCommail_bHtml	= '$bCommail_bHtml' ";
}
if($part==7)
{
	if(empty($goods_list_cnt))	$goods_list_cnt =20;
	if(empty($trade_list_cnt))	$trade_list_cnt =20;
	if(empty($member_list_cnt))	$member_list_cnt =20;
	if(empty($board_list_cnt))	$board_list_cnt =20;
	if(empty($search_list_cnt))	$search_list_cnt =20;
	$qry = "update admin set ";
	$qry.= "goods_list_cnt	= $goods_list_cnt,  ";
	$qry.= "trade_list_cnt	= $trade_list_cnt,  ";
	$qry.= "member_list_cnt	= $member_list_cnt,  ";
	$qry.= "board_list_cnt	= $board_list_cnt,  ";
	$qry.= "search_list_cnt	= $search_list_cnt  ";
}
if($MySQL->query($qry))
{
	OnlyMsgView("수정완료 하였습니다.");
	ReFresh("adm_etc.php");
}
else
{
	ErrMsg($qry);
	ReFresh("adm_etc.php");
}
?>