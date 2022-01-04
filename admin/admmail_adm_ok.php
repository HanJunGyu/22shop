<?
include "head.php";
include "../lib/webmail_function.php";

if(empty($adm_bWebmail))
{
	$adm_bWebmail = 0;
}
if($adm_bWebmail)
{
	$err = "";
	//smtp 체크
	if(!CheckSmtp($adm_smtp,&$err))
	{
		MsgView($err,-1);
		exit;
	}
	//pop3체크
	if(!CheckPop3($adm_pop3,$adm_user,$adm_pass,&$err))
	{
		MsgView($err,-1);
		exit;
	}
}
$adm_email = $adm_email1."@".$adm_email2;
$qry = "update webmail_admin set ";
$qry.= "adm_bWebmail= $adm_bWebmail,";
$qry.= "adm_name ='$adm_name',";
$qry.= "adm_email ='$adm_email',";
$qry.= "adm_smtp = '$adm_smtp',";
$qry.= "adm_pop3 = '$adm_pop3',";
$qry.= "adm_user = '$adm_user',";
$qry.= "adm_pass = '$adm_pass' ";
if($MySQL->query($qry))
{
	OnlyMsgView("수정완료 하였습니다.");
	ReFresh("admmail_adm.php");
}
else
{
	echo"Err. : $qry";
}
?>