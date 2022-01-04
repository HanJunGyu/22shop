<?
include "head.php";
include "../lib/webmail_class.php";
include "../lib/webmail_function.php";
if(!defined(__ADMIN_ROW))
{
	define(__ADMIN_ROW,"TRUE");
	$admin_row=$MySQL->fetch_array("select *from admin limit 0,1");//관리자정보
}
if(!defined(__DESIGN_ROW))
{
	define(__DESIGN_ROW,"TRUE");
	$design=$MySQL->fetch_array("select *from design limit 0,1");
}
$dataArr = Decode64($data);
$member_row = $MySQL->fetch_array("select *from member where idx=$dataArr[idx]");
if($del)
{
	$MySQL->query("delete from cart where userid='$member_row[userid]'");
	$MySQL->query("delete from interest where userid='$member_row[userid]'");
	$MySQL->query("delete from point_table where userid='$member_row[userid]'");
	$MySQL->query("delete from member where idx=$dataArr[idx]");
	OnlyMsgView("삭제완료 하였습니다.");
	Refresh("member_list.php");
}
else if($pwdedit)
{
	if($MySQL->query("update member set pwd=password('$pwd') where idx=$dataArr[idx]"))
	{
		if($admin_row[bPassmail]=="y")
		{
			include "../email/pwd_edit.php";
		}
		OnlyMsgView("수정 [메일발송] 을 완료 하였습니다.");
		Refresh("member.php?data=$data"); 
	}
}
else if($leveledit)
{
	if($MySQL->query("update member set part='$part' where idx=$dataArr[idx]"))
	{
		Refresh("member.php?data=$data"); 
	}
}
else if($baseedit)
{
	$zip = $zip1."-".$zip2;
	$tel = $tel1."-".$tel2."-".$tel3;
	$hand = $hand1."-".$hand2."-".$hand3;
	$ssh = $ssh1."-".$ssh2;
	$ceo_zip = $ceo_zip1."-".$ceo_zip2;
	$birth = $year."-".$month."-".$day;
	$birth2 = $year2."-".$month2."-".$day2;
	$ceonum = $ceonum1."-".$ceonum2."-".$ceonum3;
	$qry = "update member set zip='$zip',tel='$tel',hand='$hand',ssh='$ssh',address1='$address1',";
	$qry.= "address2='$address2',bMail=$bMail,email='$email',bSms='$bSms'";
	$qry.= " ,companyname='$companyname', ";
	$qry.= " ceonum='$ceonum', ";
	$qry.= " ceoname='$ceoname', ";
	$qry.= " ceo_zip='$ceo_zip', ";
	$qry.= " ceo_address1='$ceo_address1', ";
	$qry.= " ceo_address2='$ceo_address2', ";
	$qry.= " upjongtype='$upjongtype', ";
	$qry.= " jongmok ='$jongmok', ";
	$qry.= " birth ='$birth', ";
	$qry.= " birth2 ='$birth2', ";
	$qry.= " member_content ='$member_content'";
	$qry.= ",refund_bank	= '".addslashes($refund_bank)."'";
	$qry.= ",refund_name	= '".addslashes($refund_name)."'";
	$qry.= ",refund_account	= '".addslashes($refund_account)."'";
	$qry.= " where idx=$dataArr[idx]";
	if($MySQL->query($qry))
	{
		OnlyMsgView("수정완료 하였습니다.");
		Refresh("member.php?data=$data");
	}
	else
	{
		echo"Err. : $qry";
	}
}
else if($pointedit)
{
	$supplyPoint = $point -$member_row[point];
	if($supplyPoint >0)
	{
		if (!$reason) $reason = "관리자 지급";
		$qry = "insert into point_table(part,userid,point,reason,writeday)values(";
		$qry.= "'지급','$member_row[userid]',$supplyPoint,'$reason',now())";
		$MySQL->query($qry);
	}
	else if($supplyPoint <0)
	{
		if (!$reason) $reason = "관리자 회수";
		$qry = "insert into point_table(part,userid,point,reason,writeday)values(";
		$qry.= "'회수','$member_row[userid]',$supplyPoint,'$reason',now())";
		$MySQL->query($qry);
	}
	if($MySQL->query("update member set point=$point where idx=$dataArr[idx]"))
	{
		OnlyMsgView("수정완료 하였습니다.");
		Refresh("member.php?data=$data"); 
	}
}
?>