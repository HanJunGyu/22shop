<?
include "head.php";
if(!defined(__ADMIN_ROW))
{
	define(__ADMIN_ROW,"TRUE");
	$admin_row=$MySQL->fetch_array("select *from admin limit 0,1");
}
$xProfit	= nl2br($admin_row[xProfit]); //회원가입 혜택
?>
<SCRIPT LANGUAGE="JavaScript">
<!--
//회원 로그인
function loginSendit()
{
	var form=document.loginForm;
	if(form.userid.value=="")
	{
		alert("아이디를 입력해 주십시오.");
		form.userid.focus();
	}
	else if(form.pwd.value=="")
	{
		alert("비밀번호를 입력해 주십시오.");
		form.pwd.focus();
	}
	else
	{
		form.submit();
	}
}
function loginChek(aEvent)
{
	var myEvent = aEvent ? aEvent : window.event;
	if(myEvent.keyCode==13) loginSendit();
}
//-->
</SCRIPT>
<? include "top.php";?>
<table width="900" border="0" cellspacing="0" cellpadding="0" bgcolor="<?=$ALL_BGCOLOR?>">
	<tr>
		<td valign="top" bgcolor="#FFFFFF">
			<table width="900" height="100%" border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td valign="top" align='center'>
						<table width="900" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td><img src='image/sub/img_login.gif'></td>
							</tr>
						</table>
						<table width="900" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td bgcolor="<?=$subdesign[bc6]?>"><div align="right"> &nbsp;<font color="<?=$subdesign[tc6]?>"> <img src='image/good/icon0.gif'>&nbsp; 현재위치 : <a href="index.php"><font color="<?=$subdesign[tc6]?>">HOME</font></a>&gt; 로그인</font>&nbsp;</div></td>
							</tr>
						</table><br><br><br>
						<table width="900" border="0" cellspacing="0" cellpadding="0" background='image/sub/login_bg.gif' height='230'>
							<tr>
								<td>
									<table width="800" border="0" cellspacing="0" cellpadding="0" align="center">
										<tr>
											<td><img src="image/sub/login_top.gif"></td>
										</tr>
										<tr>
											<td height="150" bgcolor='ffffff'>
												<table width="700" border="0" cellspacing="0" cellpadding="0" align="center" height="90">
													<tr>
														<td bgcolor='f7f7f7'>
															<form name="loginForm" method="post" action="login_ok.php?buy=1">
															<input type="hidden" name="channel" value="<?=$channel?>">
															<table width="300" border="0" cellspacing="0" cellpadding="0" align="center">
																<tr align="center">
																	<td valign="middle"><img src="image/sub/id.gif"</td>
																	<td width="25" valign="middle">&nbsp;</td>
																	<td valign="top"> <input type="text" name="userid" size="10" onblur="document.loginForm.pwd.focus();"></td>
																	<td width="45" valign="middle">&nbsp;</td>
																	<td rowspan="3" width="65"><a href="javascript:loginSendit();"><img src="image/sub/login_btn.gif" align="middle" border="0"></a></td>
																</tr>
																<tr align="center">
																	<td valign="middle">&nbsp;</td>
																	<td valign="middle">&nbsp;</td>
																	<td valign="top">&nbsp;</td>
																	<td valign="middle">&nbsp;</td>
																</tr>
																<tr align="center">
																	<td valign="middle"><img src="image/sub/pw.gif"</td>
																	<td valign="middle">&nbsp;</td>
																	<td valign="top"> <input type="password" name="pwd" size="10"  onkeydown="javascript:loginChek(event);"></td>
																	<td valign="middle">&nbsp;</td>
																</tr>
															</table>
															</form>
														</td>
														<td width='50'></td>
														<td bgcolor='e1e1e1' width="1"></td>
														<td>
															<table width="230" border="0" cellspacing="2" cellpadding="0" align="center">
																<tr>
																	<td height="30"><a href="javascript:searchId(1);"><img src="image/sub/id_search2.gif" border="0"></a></td>
																</tr>
																<tr>
																	<td height="30"><a href="javascript:searchId(1);"><img src="image/sub/pw_search2.gif" border="0"></a></td>
																</tr>
																<tr>
																	<td height="30"><a href="member_article.php"><img src="image/sub/join_btn2.gif" border="0"></a></td>
																</tr>
															</table>
														</td>
													</tr>
												</table>
											</td>
										</tr>
									</table>
								</td>
							</tr>
						</table>
						<table width="800" border="0" cellspacing="0" cellpadding="0" height='65'>
							<tr>
								<td style='padding:0 0 0 10'><img src="image/sub/nomember_top.gif"></td>
								<td> <div align="center"><a href="order_sheet.php"><img src="image/sub/nomem_btn.gif" border="0"></a></div></td>
							</tr>
							<tr>
								<td bgcolor="e1e1e1" height="1" colspan='2'></td>
							</tr>
						</table><br><br>
						<table width="650" border="0" cellspacing="0" cellpadding="0" align="center" bgcolor='edeae4'>
							<tr>
								<td bgcolor='ffffff'>
									<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
										<tr>
											<td><img src='image/sub/member_tit01.gif'></td>
										</tr>
										<tr valign='top'>
											<td style='padding:10 0 0 15'><b><font color="#ff4800"><?=$admin_row[shopTitle]?></font></b>의 회원이 되시면 다양한 혜택을 받으실 수 있습니다.<br><br><?=$xProfit?></td>
										</tr>
										<tr>
											<td><img src='image/sub/member_tit02.gif'></td>
										</tr>
									</table><br><br>
								</td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>
<? include "copy.php"; ?>
</div>
</body>
</html>