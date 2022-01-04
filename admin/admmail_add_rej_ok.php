<?
include "head.php";
$qry ="insert into webmail_reject(badmin,rej_email)values(1,'$rej_email')";
if($MySQL->query($qry))
{
	?>
<SCRIPT LANGUAGE="JavaScript">
<!--
alert("등록완료 하였습니다.");
window.close();
//-->
</SCRIPT><?
}
else
{
	echo"Err : $qry";
}
?>