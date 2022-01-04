<?
include "head.php";
if(empty($bSend1)) $bSend1 = 0;
if(empty($bSend2)) $bSend2 = 0;
if(empty($bSend3)) $bSend3 = 0;
if(empty($bSend4)) $bSend4 = 0;
if(empty($bSend5)) $bSend5 = 0;
if(empty($bSend8)) $bSend8 = 0;

$retel		= $retel1."-".$retel2."-".$retel3;
$adminTel  = $adminTel1."-".$adminTel2."-".$adminTel3;

if($part ==1)
{
	$qry = "update smsinfo set ";
	$qry.= "bSms			= $bSms,";
	$qry.= "gubun			= $gubun,";
	$qry.= "company		= '$company',";
	$qry.= "userid			= '$userid',";
	$qry.= "pwd			= '$pwd',";
	$qry.= "adminTel		= '$adminTel',";
	$qry.= "retel			= '$retel' ";
	if($MySQL->query($qry))
	{
		OnlyMsgView("수정완료 하였습니다.");
		ReFresh("sms.php");
	}
	else
	{
		echo"Err. : $qry";
	}
}
else if($part ==2)
{
	$qry = "update smsinfo set ";
	$qry.= "bSend1			= $bSend1,";
	$qry.= "msg1			= '$msg1',";
	$qry.= "bSend2			= $bSend2,";
	$qry.= "msg2			= '$msg2'";
	if($MySQL->query($qry))
	{
		OnlyMsgView("수정완료 하였습니다.");
		ReFresh("sms.php");
	}
	else
	{
		echo"Err. : $qry";
	}
}
else if($part ==3)
{
	$qry = "update smsinfo set ";
	$qry.= "bSend3			= $bSend3,";
	$qry.= "msg3			= '$msg3',";
	$qry.= "bSend4			= $bSend4,";
	$qry.= "msg4			= '$msg4'";
	if($MySQL->query($qry))
	{
		OnlyMsgView("수정완료 하였습니다.");
		ReFresh("sms.php");
	}
	else
	{
		echo"Err. : $qry";
	}
}
else if($part ==4)
{
	$qry = "update smsinfo set ";
	$qry.= "bSend5			= $bSend5,";
	$qry.= "msg5			= '$msg5'";
	if($MySQL->query($qry))
	{
		OnlyMsgView("수정완료 하였습니다.");
		ReFresh("sms.php");
	}
	else
	{
		echo"Err. : $qry";
	}
}
else if($part ==6)
{
	$qry = "update smsinfo set ";
	$qry.= "bSend8			= $bSend8,";
	$qry.= "msg8			= '$msg8'";
	if($MySQL->query($qry))
	{
		OnlyMsgView("수정완료 하였습니다.");
		ReFresh("sms.php");
	}
	else
	{
		echo"Err. : $qry";
	}
}
?>