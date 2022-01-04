<?
include "head.php";
if($edit_part=="del")
{
	$qry = "delete from webmail_adr where idx=$idx";
	if($MySQL->query($qry))
	{
		ReFresh("admmail_address.php");
	}
	else
	{
		echo"Err : $qry";
	}
}
else if($edit_part=="alldel")
{
	$idxArr = explode("-",$idxStr);
	for($i=0;$i<count($idxArr);$i++)
	{
		$MySQL->query("delete from webmail_adr where idx=$idxArr[$i]");
	}
	OnlyMsgView("삭제완료 하였습니다.");
	ReFresh("admmail_address.php");
}
else
{
	$tel = $tel1."-".$tel2."-".$tel3;
	$birth = $birth1."-".$birth2."-".$birth3;
	$zip = $zip1."-".$zip2;
	$qry = "update webmail_adr set ";
	$qry.= "grp='$grp',";
	$qry.= "name='$name',";
	$qry.= "email ='$email',";
	$qry.= "tel = '$tel',";
	$qry.= "birth= '$birth',";
	$qry.= "zip = '$zip',";
	$qry.= "adr1 = '$adr1',";
	$qry.= "adr2 = '$adr2',";
	$qry.= "content = '$content' where idx=$idx";
	if($MySQL->query($qry))
	{
		ReFresh("admmail_address_edit.php?idx=$idx");
	}
	else
	{
		echo"Err : $qry";
	}
}
?>