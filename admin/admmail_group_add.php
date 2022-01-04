<?
include "head.php";
if (__DEMOPAGE) $readonly = "readonly";
?>
<SCRIPT LANGUAGE="JavaScript">
<!--
function groupSendit()
{
	var form = document.wForm;
	if(form.name.value=="")
	{
		alert("그룹명을 입력해 주십시오.");
		form.name.focus();
	}
	else
	{
		form.submit();
	}
}
//-->
</SCRIPT>
<body bgcolor="#FFFFFF" text="#5A595A" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<? include "top_menu.php"; ?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr><?
	$__TOP_MENU = "admmail";     //왼쪽 소메뉴 설정 변수
	include "left_menu.php";
	if(!defined(__ADMIN_ROW))
	{
		define(__ADMIN_ROW,"TRUE");
		$admin_row=$MySQL->fetch_array("select *from admin limit 0,1"); //관리자 정보 배열
	}
	?>
		<td width="85%" valign="top">
			<table width="100%" border="0" cellspacing="0" cellpadding="0" align='center'>
				<tr>
					<td height='5'></td>
				</tr>
				<tr>
					<td>
						<table width="750" border="0" cellspacing="0" cellpadding="0" align='center'>
							<tr>
								<td rowspan="3" width="200"><img src="image/admmail_tit_img.gif"></td>
								<td>&nbsp;</td>
							</tr>
							<tr>
								<td bgcolor="#E6E6E6" height='26'><div align='right'><font class='text1'>SHOP 관리자메일 설정을 하실수 있습니다.&nbsp;</div></td>
							</tr>
							<tr>
								<td>&nbsp;</td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td height="2" valign="top">
						<table width="750" border="0" cellspacing="0" cellpadding="0" align="center">
							<tr>
								<td bgcolor='DADADA' height='1'></td>
							</tr>
							<tr>
								<td>
									<table width="750" border="0" cellspacing="0" cellpadding="0" align="center">
										<tr>
											<td width='440'><img src="image/admmail_tit_5.gif"></td>
										</tr>
									</table>
								</td>
							</tr>
							<tr>
								<td bgcolor='DADADA' height='1'></td>
							</tr>
							<tr>
								<td height='10'></td>
							</tr>
							<tr>
								<td valign="top" align="center">
									<table width="100%" border="0" cellspacing="0" cellpadding="0">
										<tr>
											<td height="30">
												<table width="100%" border="0" cellspacing="0" cellpadding="0">
													<tr>
														<td><img src="image/webmail/icon0.gif" width="8" height="9"><font color="#FF6600"> <b>그룹 추가하기</b></font></td>
														<td>&nbsp;</td>
														<td width="63"><a href="javascript:groupSendit();"><img src="image/webmail/add_btn3.gif" width="58" height="23" border="0"></a></td>
														<td width="65"><a href="admmail_group.php"><img src="image/webmail/cancel_btn.gif" width="58" height="23" border="0"></a></td>
													</tr>
												</table>
											</td>
										</tr>
										<tr>
											<td height="30">
												<table width="100%" border="0" cellspacing="1" cellpadding="10" bgcolor="cdcdcd">
													<tr>
														<td bgcolor="f4f4f4">
															<form name="wForm" method="post" action="admmail_group_add_ok.php">
															<table width="100%" border="0" cellspacing="2" cellpadding="5" align="center">
																<tr>
																	<td height="35" width="80" bgcolor="e6e6e6"> <div align="center">그룹명</div></td>
																	<td> <input type="text" name="name" size="50" class="box"></td>
																</tr>
																<tr>
																	<td height="35" width="80" bgcolor="e6e6e6"> <div align="center">설명</div></td>
																	<td> <textarea name="content" rows="5" cols="60" class="text"></textarea></td>
																</tr>
															</table></form>
														</td>
													</tr>
												</table>
											</td>
										</tr>
									</table>
								</td>
							</tr>
							<tr>
								<td valign="top">&nbsp;</td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>
<? include "copy.php"; ?>
</body>
</html>