<?
include "head.php";
if(empty($mbox))
{
	OnlyMsgView("올바른 접근이 아닙니다.");
	ReFresh("admmail_adm.php");
	exit;
}
if($edit_part=="alldel")
{
	//메일삭제
	$idxArr = explode("-",$idxStr);
	if($mbox=="4")
	{
		//영구삭제
		for($i=0;$i<count($idxArr);$i++)
		{
			// .eml 파일 삭제
			$qry = "select * from webmail_mail where idx=$idxArr[$i]";
			$row = $MySQL->fetch_array($qry);
			if(file_exists("../eml/$row[m_filename]"))
			{
				//같은파일명 체크
				@unlink("../eml/$row[m_filename]");
			}
			$MySQL->query("delete from webmail_mail where idx=$idxArr[$i]");
		}
		ReFresh("admmail_list.php?mbox=$mbox");
	}
	else
	{
		//휴지통버리기
		for($i=0;$i<count($idxArr);$i++)
		{
			$MySQL->query("update webmail_mail set mbox='4' where idx=$idxArr[$i]");
		}
		ReFresh("admmail_list.php?mbox=$mbox");
	}
}
else if($edit_part=="allmove")
{
	$idxArr = explode("-",$idxStr);
	for($i=0;$i<count($idxArr);$i++)
	{
		$MySQL->query("update webmail_mail set mbox='$movebox' where idx=$idxArr[$i]");
	}
	ReFresh("admmail_list.php?mbox=$mbox");
}
?>