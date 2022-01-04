<?
session_start();
include "./lib/config.php";
include "./lib/function.php";
$MySQL->query("select *from trade where tradecode='$tradecode'");
if(!$MySQL->is_affected())
{
	MsgView("주문코드가 올바르지 않습니다. \\n\\n다시 입력해 주십시오.",-1);
}
else
{
	ReFresh("order_detail_nomem.php?tradecode=$tradecode");
}
?>