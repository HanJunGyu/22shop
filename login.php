<?
include "head.php";
if(empty($referer)) $referer = $_SERVER["HTTP_REFERER"];
if(!defined(__ADMIN_ROW))
{
	define(__ADMIN_ROW,"TRUE");
	$admin_row=$MySQL->fetch_array("select *from admin limit 0,1");
}
$jdataArr = Decode64($jdata);  //회원정보
if($admin_row[xProfit_bhtml])
{
	$xProfit = $admin_row[xProfit];
}
else
{
	$xProfit = nl2br(htmlspecialchars($admin_row[xProfit]));
}
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
function loginChek()
{
	if(event.keyCode==13) loginSendit();
}
//-->
</SCRIPT>
<? include "top.php";?>
<table width="900" border="0" cellspacing="0" cellpadding="0" bgcolor="<?=$ALL_BGCOLOR?>">
	<tr>
		<td valign="top" bgcolor="#FFFFFF">
			<table width="900" height="100%" border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td valign="top">
					<table width="900" border="0" cellspacing="0" cellpadding="0">
						<tr>
							<td><img src='image/sub/img_login.gif'></td>
						</tr>
					</table>
					<table width="100%" border="0" cellspacing="0" cellpadding="0" align='center'>
						<tr>
							<td bgcolor="<?=$subdesign[bc18]?>"><div align="right"> &nbsp;<font color="<?=$subdesign[tc18]?>"> <img src='image/good/icon0.gif'>&nbsp; 현재위치 : <a href="index.php"><font color="<?=$subdesign[tc18]?>">HOME</font></a>&gt; 로그인</font>&nbsp;</div></td>
						</tr>
					</table>
					<br><br>
						<table width="900" border="0" cellspacing="0" cellpadding="0" align="center" background='image/sub/login_bg.gif' height='230'>
							<tr>
								<td>
									<table width="800" border="0" cellspacing="0" cellpadding="0" align="center">
										<tr valign="top">
											<td><?
											if ($subdesign[titimg18])
											{
												?><img src="./upload/design/<?=$subdesign[titimg18]?>" ><?
											}
											else
											{
												?><img src="image/sub/login_top.gif" ><?
											}
											?></td>
										</tr>
										<tr>
											<td height="140" bgcolor="#FFFFFF">
												<table width="700" border="0" cellspacing="0" cellpadding="0" align="center" height="90">
													<tr>
														<td bgcolor='f7f7f7'>
															<form name="loginForm" method="post" action="login_ok.php">
															<input type="hidden" name="referer" value="<?=$referer?>">
															<table width="300" border="0" cellspacing="0" cellpadding="0" align="center">
																<tr align="center">
																	<td width="100"><img src="image/sub/id.gif"></td>
																	<td valign="top" align="left" width="103"> <?
																	if($demo_readonly)
																	{
																		?><input type="text" name="userid" size="15" value="test" style="width:110px"><?
																	}
																	else
																	{
																		?><input autocomplete="off" type="text" name="userid" size="15" value="<?=$jdataArr[jUserid]?>" style="width:110px"><?
																	}
																	?></td>
																	<td rowspan="3" width="86"><a href="javascript:loginSendit();" onFocus=document.loginForm.pwd.focus();><img src="image/sub/login_btn.gif" align="middle" border="0"></a></td>
																</tr>
																<tr align="center">
																	<td width="100"><img src="image/sub/pw.gif"></td>
																	<td valign="top" align="left" width="103"> <?
																	if($demo_readonly)
																	{
																		?><input type="password" name="pwd" size="15" value="1111" onKeyDown="javascript:loginChek();" style="width:110px"><?
																	}
																	else
																	{
																		?><input autocomplete="off" type="password" name="pwd" size="15" value="<?=$jdataArr[jPwd]?>" onKeyDown="javascript:loginChek();" style="width:110px"><?
																	}
																	?></td>
																</tr>
															</table></form><!-- loginForm -->
														</td>
														<td width='50'></td>
														<td bgcolor='e1e1e1' width="1"></td>
														<td>
															<table width="230" border="0" cellspacing="2" cellpadding="0" align="center">
																<tr>
																	<td height="30"><a href="javascript:searchId(1);"><img src="image/sub/id_search2.gif" border="0"></a></td>
																</tr>
																<tr>
																	<td height="30"><a href="javascript:searchId(2);"><img src="image/sub/pw_search2.gif" border="0"></a></td>
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
									</table>
								</td>
							</tr>
						</table><br><br>
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