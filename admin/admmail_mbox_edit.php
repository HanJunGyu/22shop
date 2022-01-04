<?
include "head.php";
$mbox_info = $MySQL->fetch_array("select * from webmail_mbox where mbox='$mbox'");
?>
<SCRIPT LANGUAGE="JavaScript">
<!--
function mboxWSendit()
{
	var form = document.mboxWForm;
	if(form.name.value=="")
	{
		alert("편지함 이름을 입력해 주십시오.");
		form.name.focus();
		return false;
	}
	else
	{
		return true;
	}
}
//-->
</SCRIPT>
<BODY>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td bgcolor="D6EFE7" height="35">
			<form name="mboxWForm" method="post" action="admmail_mbox_ok.php" onsubmit="return mboxWSendit();">
			<input type="hidden" name="edit_part" value="edit">
			<input type="hidden" name="mbox" value="<?=$mbox?>">
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td width="23"> <div align="center"><img src="../image/webmail/left_icon6.gif" width="17" height="17"></div></td>
					<td width="80">편지함 수정 </td>
					<td width="140"> <input type="text" name="name" size="17" value="<?=$mbox_info[name]?>"></td>
					<td><input type="image" src="../image/webmail/edit_btn.gif" border="0"></td>
				</tr>
			</table>
			</form>
		</td>
	</tr>
</table>
</BODY>
</HTML>