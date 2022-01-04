<?
include "head.php";
if($edit_part=="del")
{
	$group_info = $MySQL->fetch_array("select code from webmail_adr_grp where idx=$idx");
	$MySQL->query("delete from webmail_adr where grp='$group_info[code]'");
	$qry = "delete from webmail_adr_grp where idx=$idx";
	if($MySQL->query($qry))
	{
		ReFresh("admmail_group.php");
	}
	else
	{
		echo"Err. : $qry";
	}
}
else if($edit_part=="alldel")
{
	$idxArr = explode("-",$idxStr);
	for($i=0;$i<count($idxArr);$i++)
	{
		$group_info = $MySQL->fetch_array("select code from webmail_adr_grp where idx=$idxArr[$i]");
		$MySQL->query("delete from webmail_adr where grp='$group_info[code]'");
		$MySQL->query("delete from webmail_adr_grp where idx=$idxArr[$i]");
	}
	OnlyMsgView("삭제완료 하였습니다.");
	ReFresh("admmail_group.php");
}
else
{
	$qry = "update webmail_adr_grp set ";
	$qry.= "name='$name',content = '$content' where idx=$idx";
	if($MySQL->query($qry))
	{
		OnlyMsgView("수정완료 하였습니다.");
		ReFresh("admmail_group_edit.php?idx=$idx");
	}
	else
	{
		echo"Err. : $qry";
	}
}
?>