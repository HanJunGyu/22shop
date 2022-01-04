<?
include "head.php";
$MySQL->query("delete from webmail_reject where badmin=1");
if($rej_str)
{
	$rejArr = explode(",",$rej_str);
	if(count($rejArr))
	{
		for($i=0;$i<count($rejArr);$i++)
		{
			$MySQL->query("insert into webmail_reject(badmin,rej_email)values(1,'$rejArr[$i]')");
		}
	}
}
OnlyMsgView("등록완료 하였습니다.");
ReFresh("admmail_rejection.php");
?>