<?
include "head.php";
include "../lib/webmail_class.php";
include "../lib/webmail_function.php";
$err = "";
if(!GetPop3(1,"",$webmail_admin_row[adm_pop3],$webmail_admin_row[adm_user],$webmail_admin_row[adm_pass],__LIST_MBOX,__MAIL_DEL,&$err))
{
	$_SESSION['WEBMAIL_ERR'] = $err;
}
if(!$err)
{
	//외부메일 읽어오기
	$external_pop_qry = "select * from webmail_pop3 where badmin=1";
	$external_pop_result = $MySQL->query($external_pop_qry);
	while($external_pop_row = mysql_fetch_array($external_pop_result))
	{
		if(!GetPop3(1,"",$external_pop_row[pop3],$external_pop_row[pop3_user],$external_pop_row[pop3_pass],$external_pop_row[mbox],$external_pop_row[bDel],&$err))
		{
			$_SESSION['WEBMAIL_ERR'] = $err;
		}
		if($err)
		{
			break;
		}
	}
}
if($err)
{
	?>
<SCRIPT LANGUAGE="JavaScript">
<!--
parent.location.href="admmail_err.php";
//-->
</SCRIPT><?
}
else if($mbox)
{
	?>
<SCRIPT LANGUAGE="JavaScript">
<!--
parent.location.href="admmail_list.php?mbox=<?=$mbox?>";
//-->
</SCRIPT><?
}
else
{
	?>
<SCRIPT LANGUAGE="JavaScript">
<!--
parent.location.href="admmail_mbox.php";
//-->
</SCRIPT>
<?}?>