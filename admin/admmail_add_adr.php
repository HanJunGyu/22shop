<?
include "head.php";
?>
<SCRIPT LANGUAGE="JavaScript">
<!--
function wSendit()
{
	var form = document.wForm;
	if(form.name.value=="")
	{
		alert("이름을 입력해 주십시오.");
		form.name.focus();
	}
	else if(form.email.value=="")
	{
		alert("이메일을 입력해 주십시오.");
		form.email.focus();
	}
	else if(!isEmail(form.email.value))
	{
		alert("이메일 주소가 올바르지 않습니다.");
		form.email.focus();
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
		<td><img src="image/webmail/address_top.gif" width="400" height="60"></td>
	</tr>
	<tr>
		<td height="200">
			<form name="wForm" method="post" action="admmail_add_adr_ok.php">
			<table width="350" border="0" cellspacing="0" cellpadding="5" align="center">
				<tr>
					<td width="100" height="35"> <div align="center">그룹명</div></td>
					<td> <select name="grp"><option value="">그룹선택</option><?
					$w_grp_result = $MySQL->query("select * from webmail_adr_grp where badmin=1");
					while($w_grp_row = mysql_fetch_array($w_grp_result))
					{
						?><option value="<?=$w_grp_row[code]?>"><?=$w_grp_row[name]?></option><?
					}
					?></select></td>
				</tr>
				<tr>
					<td width="100" height="35"> <div align="center">이름</div></td>
					<td><input type="text" name="name" size="40" value="<?=$name?>" class="box"></td>
				</tr>
				<tr>
					<td width="100" height="35"> <div align="center">이메일</div></td>
					<td><input type="text" name="email" size="40" value="<?=$email?>" class="box"></td>
				</tr>
				<tr>
					<td width="100" height="35"> <div align="center">연락처</div></td>
					<td><input type="text" name="tel1" size="6" class="box" <?=__ONLY_NUM?> maxlength="3"> - <input type="text" name="tel2" size="6" class="box" <?=__ONLY_NUM?> maxlength="4"> - <input type="text" name="tel3" size="6" class="box" <?=__ONLY_NUM?> maxlength="4"></td>
				</tr>
			</table></form>
		</td>
	</tr>
	<tr>
		<td bgcolor="7DBA0C" height="40">
			<table width="200" border="0" cellspacing="0" cellpadding="0" align="center">
				<tr>
					<td><div align="center"><a href="javascript:wSendit();"><img src="image/webmail/add_btn5.gif" width="58" height="23" border="0"></a></div></td>
					<td><div align="center"><a href="javascript:window.close();"><img src="image/webmail/cancel_btn2.gif" width="58" height="23" border="0"></a></div></td>
				</tr>
			</table>
		</td>
	</tr>
</table>
</body>
</html>