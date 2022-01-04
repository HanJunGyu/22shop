<?
include "head.php";
?>
<SCRIPT LANGUAGE="JavaScript">
<!--
function wSendit()
{
	var form = document.wForm;
	if(form.rej_email.value=="")
	{
		alert("이메일을 입력해 주십시오.");
		form.rej_email.focus();
	}
	else if(!isEmail(form.rej_email.value))
	{
		alert("이메일 주소가 올바르지 않습니다.");
		form.rej_email.focus();
	}
	else
	{
		form.submit();
	}
}
//-->
</SCRIPT>
<body bgcolor="#FFFFFF" text="#000000" topmargin='0' leftmargin='0'>
<table width="400" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td><img src="image/webmail/rejection_top.gif" width="400" height="60"></td>
	</tr>
	<tr>
		<td height="100">
			<form name="wForm" method="post" action="admmail_add_rej_ok.php">
			<table width="350" border="0" cellspacing="0" cellpadding="5" align="center">
				<tr>
					<td width="100" height="35"> <div align="center">수신거부 메일주소</div></td>
					<td> <input type="text" name="rej_email" size="40" class="box" value="<?=$email?>"></td>
				</tr>
			</table></form>
		</td>
	</tr>
	<tr>
		<td bgcolor="7DBA0C" height="40">
			<table width="200" border="0" cellspacing="0" cellpadding="0" align="center">
				<tr>
					<td> <div align="center"><a href="javascript:wSendit();"><img src="image/webmail/add_btn5.gif" width="58" height="23" border="0"></a></div></td>
					<td> <div align="center"><a href="javascript:window.close();"><img src="image/webmail/cancel_btn2.gif" width="58" height="23" border="0"></a></div></td>
				</tr>
			</table>
		</td>
	</tr>
</table>
</body>
</html>