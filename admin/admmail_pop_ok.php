<?
include "head.php";
include "../lib/webmail_function.php";
$err = "";
if($edit_part=="write")
{
	//외부메일 설정 저장
	if(!CheckPop3($pop3,$pop3_user,$pop3_pass,&$err))
	{
		MsgView($err,-1);
		exit;
	}
	//새편지함 만들기
	if($bMboxMake)
	{
		$mbox = time();
		$mbox_qry = "insert into webmail_mbox(badmin,name,mbox)values(1,'$mbox_name','$mbox')";
		$MySQL->query($mbox_qry);
	}

	$qry = "insert into webmail_pop3(pop3,badmin,pop3_user,pop3_pass,mbox,bDel)values(";
	$qry.= "'$pop3',";
	$qry.= "1,";
	$qry.= "'$pop3_user',";
	$qry.= "'$pop3_pass',";
	$qry.= "'$mbox',";
	$qry.= "$bDel)";

	if($MySQL->query($qry))
	{
		OnlyMsgView("등록완료 하였습니다.");
		ReFresh("admmail_pop.php");
	}
	else
	{
		echo"Err. : $qry";
	}
}
else if($edit_part=="edit")
{
	//외부메일 수정
	if(!CheckPop3($pop3,$pop3_user,$pop3_pass,&$err))
	{
		MsgView($err,-1);
		exit;
	}
	$qry = "update webmail_pop3 set ";
	$qry.= "pop3 = '$pop3',";
	$qry.= "pop3_user = '$pop3_user',";
	$qry.= "pop3_pass = '$pop3_pass',";
	$qry.= "mbox = '$mbox',";
	$qry.= "bDel = $bDel where idx=$idx";
	if($MySQL->query($qry))
	{
		OnlyMsgView("수정완료 하였습니다.");
		ReFresh("admmail_pop.php");
	}
	else
	{
		echo"Err. : $qry";
	}
}
else if($edit_part =="del")
{
	if($MySQL->query("delete from webmail_pop3 where idx=$idx"))
	{
		ReFresh("admmail_pop.php");
	}
	else
	{
		echo"Err. : 외부메일 설정 삭제 에러";
	}
}
?>