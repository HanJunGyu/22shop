<?
session_start();
include "html_head.php";
if ($_SESSION['GOOD_SHOP_ADMIN_USERID'])
{
	OnlyMsgView("관리자 인증세션이 남아있으므로 로그아웃 후 재로그인 합니다.");
	@session_unregister("GOOD_SHOP_ADMIN_USERID") or die("session_unregister err");
	@session_unregister("GOOD_SHOP_ADMIN_NAME") or die("session_register err");
	Refresh("index.php");
	exit;
}
?>
<SCRIPT LANGUAGE="JavaScript">
<!--
function loginSendit()
{
	var form=document.loginForm;
	if(form.adminId.value=="")
	{
		alert("아이디를 입력해 주십시오.");
		form.adminId.focus();
		return false;
	}
	else if(form.adminPwd.value=="")
	{
		alert("비밀번호를 입력해 주십시오.");
		form.adminPwd.focus();
		return false;
	}
	else
	{
		return true;
	}
}
//-->
</SCRIPT>
<style type="text/css">
<!--
body {background-color: #c8d7de;}
-->
</style>
<body leftmargin="0" topmargin="0" onload="document.loginForm.adminId.focus();">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td height='200'>&nbsp;</td>
	</tr>
</table>
<table width="100%"	border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td height="4" bgcolor="5f6e78"></td>
	</tr>
	<tr>
		<td height="3"></td>
	</tr>
	<tr>
		<td height="283" bgcolor="5f6e78">
			<table width="600" height="283" border="0" align="center" cellpadding="0" cellspacing="0">
				<tr>
					<td background="image/index/bg_2.gif"><div align="center">
						<form name="loginForm" method="post" action="login_ok.php" onSubmit="return loginSendit();">
						<table width="600" height="256" border="0" cellpadding="0" cellspacing="0">
							<tr>
								<td width="133" rowspan="7"></td>
								<td height="80" colspan="2"><div align="center"><img src="image/index/admin_login.gif" width="339"></div></td>
								<td width="134" rowspan="7"></td>
							</tr>
							<tr>
								<td height="45" colspan="2"><div align="center"><img src="image/index/top.gif" width="339" height="45"></div></td>
							</tr>
							<tr>
								<td height="16" colspan="2" background="image/index/bg_1.gif">&nbsp;</td>
							</tr>
							<tr>
								<td colspan="2" background="image/index/bg_1.gif">
									<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
										<tr>
											<td>
												<table width="150" border="0" align="center" cellpadding="0" cellspacing="0">
													<tr>
														<td width="30%"><div align="right"><img src="image/index/id.gif" width="67" height="18"></div></td>
														<td width="28%" align="left"><input type="text" name="adminId" size="15" value=<? if (__DEMOPAGE) echo "free_demo";?>></td>
													</tr>
													<tr>
														<td><div align="right"><img src="image/index/password.gif" width="67" height="18"></div></td>
														<td align="left"><input type="password" name="adminPwd" size="15" value=<? if (__DEMOPAGE) echo "demo_free";?>></td>
													</tr>
												</table>
											</td>
											<td width='110'><input type="image" src="image/index/log-in.gif" border="0"></td>
										</tr>
									</table>
								</td>
							</tr>
							<tr>
								<td colspan="2" background="image/index/bg_1.gif">
									<table width="180" border="0" cellspacing="0" cellpadding="0">
										<tr>
											<td height="40"></td>
										</tr>
									</table>
								</td>
							</tr>
							<tr>
								<td colspan="2" align="center"><img src="image/index/bottom.gif" width="339" height="15"></td>
							</tr>
							<tr>
								<td height="35" colspan="2" valign="bottom"><div align="center"><img src="image/index/copy.gif" width="339" height="26"></div></td>
							</tr>
						</table></form>
					</div></td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td height="3"></td>
	</tr>
	<tr>
		<td height="4" bgcolor="5f6e78"></td>
	</tr>
</table>
</body>
</html>
