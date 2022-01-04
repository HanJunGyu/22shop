<?
include "head.php";
if($edit_part=="del")
{
	if($mbox=="4")
	{
		// .eml 파일 삭제
		$qry = "select * from webmail_mail where idx=$idx";
		$row = $MySQL->fetch_array($qry);
		if(file_exists("../eml/$row[m_filename]")) @unlink("../eml/$row[m_filename]");
		$MySQL->query("delete from webmail_mail where idx=$idx");
		ReFresh("admmail_list.php?mbox=$mbox");
	}
	else
	{
		//휴지통버리기
		$MySQL->query("update webmail_mail set mbox='4' where idx=$idx");
		ReFresh("admmail_list.php?mbox=$mbox");
	}
}
else if($edit_part=="move")
{
	//메일 편지함 이동
	$qry = "update webmail_mail set mbox='$movebox' where idx=$idx";
	$MySQL->query($qry);
	ReFresh("admmail_list.php?mbox=$mbox");
}
?>