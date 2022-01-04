<?
include "head.php";
$tel = $tel1."-".$tel2."-".$tel3;
$qry = "insert into webmail_adr(grp,badmin,name,email,tel)values(";
$qry.= "'$grp',1,'$name','$email','$tel')";
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