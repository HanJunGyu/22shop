<?
include "head.php";
?>
<SCRIPT LANGUAGE="JavaScript">
<!--
function popWSendit()
{
	var form = document.popWForm;
	if(form.pop3.value=="")
	{
		alert("서버주소를 입력해 주십시오.");
		form.pop3.focus();
	}
	else if(form.pop3_user.value=="")
	{
		alert("아이디를 입력해 주십시오.");
		form.pop3_user.focus();
	}
	else if(form.pop3_pass.value=="")
	{
		alert("비밀번호를 입력해 주십시오.");
		form.pop3_pass.focus();
	}
	else if(!form.bMboxMake.checked && form.mbox.selectedIndex==0)
	{
		alert("편지함을 선택해 주십시오.");
		form.mbox.focus();
	}
	else if(form.bMboxMake.checked && form.mbox_name.value=="")
	{
		alert("편지함 이름을 입력해 주십시오.");
		form.mbox_name.focus();
	}
	else
	{
		form.submit();
	}
}
function pop3Del(idx)
{
	var choose = confirm("해당 외부메일을 삭제 하시겠습니까?");
	if(choose)
	{
		location.href="admmail_pop_ok.php?edit_part=del&idx=" + idx;
	}
	else return;
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
											<td width='440'><img src="image/admmail_tit_6.gif"></td>
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
								<td height='10'>
									<table width="750" border="0" cellspacing="0" cellpadding="0" align="center">
										<tr>
											<td valign="top" height="80">
												<table width="750" border="0" cellspacing="5" cellpadding="0" bgcolor="F4F4F4">
													<tr>
														<td bgcolor="#FFFFFF">
															<table width="100%" border="0" cellspacing="1" cellpadding="0" bgcolor="dadada">
																<tr>
																	<td bgcolor="#FFFFFF">
																		<table width="100%" border="0" cellspacing="0" cellpadding="5" height="100">
																			<tr>
																				<td width="130"> <div align="center"><img src="image/webmail/img2.gif" width="99" height="78"></div></td>
																				<td><b><font color="#FF6600">외부메일(POP3) 설정</font></b><br>ㅁ POP3를 제공하는 외부 메일 계정을 등록해 두면 다른 곳에 있는 메일을 가져올 수 있습니다.<br></td>
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
										<tr>
											<td valign="top">&nbsp; </td>
										</tr>
										<tr>
											<td height="30"><img src="image/webmail/icon0.gif" width="8" height="9"> 사용중인 외부메일(POP) 목록</td>
										</tr>
										<tr>
											<td>
												<table width="100%" border="0" cellspacing="1" cellpadding="0" bgcolor="DADADA">
													<tr bgcolor="F4F4F4">
														<td height="30"> <div align="center">POP3 서버주소</div></td>
														<td height="30" width="100"> <div align="center">아이디</div></td>
														<td height="30"> <div align="center">저장되는 편지함</div></td>
														<td height="30" width="100"> <div align="center">수정 | 삭제</div></td>
													</tr><?
													$my_pop3_qry = "select * from webmail_pop3 where badmin=1";
													$my_pop3_result = $MySQL->query($my_pop3_qry);
													while($my_pop3_row = mysql_fetch_array($my_pop3_result))
													{
														if((int)$my_pop3_row[mbox] <=4 )
														{
															$pop3_mbox_name = $MBOX_NAME[(int)$my_pop3_row[mbox]];
														}
														else
														{
															$pop3_mbox_qry = "select name from webmail_mbox where mbox='$my_pop3_row[mbox]'";
															$MySQL->query($pop3_mbox_qry);
															if($MySQL->is_affected())
															{
																$pop3_mbox_info = $MySQL->fetch_array($pop3_mbox_qry);
																$pop3_mbox_name = $pop3_mbox_info[name];
															}
															else
															{
																$pop3_mbox_name = "(정보없음)";
															}
														}
														?>
													<tr bgcolor="#FFFFFF">
														<td height="30"> <div align="center"><?=$my_pop3_row[pop3]?></div></td>
														<td height="30"> <div align="center"><?=$my_pop3_row[pop3_user]?></div></td>
														<td height="30"> <div align="center"><?=$pop3_mbox_name?></div></td>
														<td height="30"> <div align="center"><a href="admmail_pop_edit.php?idx=<?=$my_pop3_row[idx]?>"><img src="image/webmail/edit_btn.gif" width="35" height="17" border="0"></a> <a href="javascript:pop3Del(<?=$my_pop3_row[idx]?>);"><img src="image/webmail/delete_btn.gif" width="35" height="17" border="0"></a></div></td>
													</tr><?
													}
													?>
												</table>
											</td>
										</tr>
										<tr>
											<td>&nbsp;</td>
										</tr>
										<tr>
											<td height="30"><img src="image/webmail/icon0.gif" width="8" height="9"> 외부메일(POP)추가</td>
										</tr>
										<tr>
											<td>
												<form name="popWForm" method="post" action="admmail_pop_ok.php">
												<input type="hidden" name="edit_part" value="write">
												<table width="100%" border="0" cellspacing="1" cellpadding="5" bgcolor="dadada">
													<tr>
														<td height="30" bgcolor="f4f4f4" width="200">&nbsp;&nbsp;POP3 서버주소</td>
														<td bgcolor="#FFFFFF"><input type="text" name="pop3" class="box" size="30"> <FONT COLOR="#CC6600">ex) pop.mail.yahoo.co.kr , 192.168.1.1</FONT></td>
													</tr>
													<tr>
														<td height="30" bgcolor="f4f4f4" width="200">&nbsp;&nbsp;아이디</td>
														<td bgcolor="#FFFFFF"><input type="text" name="pop3_user" class="box" ></td>
													</tr>
													<tr>
														<td height="30" bgcolor="f4f4f4" width="200">&nbsp;&nbsp;비밀번호</td>
														<td bgcolor="#FFFFFF"><input type="password" name="pop3_pass" class="box" ></td>
													</tr>
													<tr>
														<td height="30" bgcolor="f4f4f4" width="200">&nbsp;&nbsp;저장되는 편지함</td>
														<td bgcolor="#FFFFFF"><select name="mbox"><option selected value="">-편지함선택-</option><?
														for($i=1;$i<=4;$i++)
														{
															?><option value="<?=$i?>"><?=$MBOX_NAME[$i]?></option><?
														}
														$qry = "select * from webmail_mbox where badmin";
														$my_mbox_result = $MySQL->query($qry);
														while($my_mbox_row = mysql_fetch_array($my_mbox_result))
														{
															?><option value="<?=$my_mbox_row[mbox]?>"><?=$my_mbox_row[name]?></option><?
														}
														?></select> 또는 <input type="checkbox" name="bMboxMake" value="1"> 새편지함 만들기 <input type="text" name="mbox_name" class="box" ></td>
													</tr>
													<tr>
														<td height="30" bgcolor="f4f4f4" width="200">&nbsp;&nbsp;서버에 메일 원본을 삭제합니다.</td>
														<td bgcolor="#FFFFFF"> <input type="radio" name="bDel" value="1" checked>예 <input type="radio" name="bDel" value="0">아니오</td>
													</tr>
												</table></form>
											</td>
										</tr>
										<tr>
											<td height="40">
												<table width="30%" border="0" cellspacing="0" cellpadding="0" align="center">
													<tr>
														<td><div align="center"><a href="javascript:popWSendit();"><img src="image/webmail/save_btn.gif" width="58" height="23" border="0"></a></div></td>
														<td><div align="center"><a href="admmail_manager.php"><img src="image/webmail/cancel_btn.gif" width="58" height="23" border="0"></a></div></td>
													</tr>
												</table>
											</td>
										</tr>
										<tr>
											<td>&nbsp;</td>
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
<? include "copy.php"; ?>
</body>
</html>