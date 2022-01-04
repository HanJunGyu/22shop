<?
include "head.php";
$admin_row = $MySQL->fetch_array("select * from admin");
$sms	   = $MySQL->fetch_array("select * from smsinfo");
$content_len =  strlen($content);
if($content_len >80)
{
	MsgView("메세지의 길이는 80 byte 를 초과할 수 없습니다.\\n\\n현재 길이 : $content_len byte",-1);
	exit;
}
else
{
	if ($idx_arr) $SMS_PART = "selected_member";
	else $SMS_PART = "allmember";
	include "../sms/smsclient.php";
	OnlyMsgView("메세지 전송을 완료 하였습니다.");
	ReFresh("member_sms.php");
}
?>