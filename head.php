<?
session_start();
include "html_head.php";
if ($MySQL->articles("SELECT idx from ipblock WHERE ip='$REMOTE_ADDR'"))
{
	OnlyMsgView("접속하신 IP는 본사이트에서 차단설정 되어 있습니다.");
	exit;
}
?>