<?
include "head.php";
if (__DEMOPAGE) $readonly = "readonly";
$mail_info = $MySQL->fetch_array("select * from webmail_mail where idx=$idx");
$MySQL->query("update webmail_mail set bRead=1 where idx=$idx"); 

//메일정보 클래스 객체 생성
include "../lib/webmail_view_class.php";
include "../lib/webmail_function.php";

//보내는 사람 이름 뽑아내기
$m_name_arr = explode("<",$mail_info[m_from]);
$m_name = str_replace(" ","",$m_name_arr[0]);
$m_name = str_replace("\"","",$m_name);

if(!$m_name)
{
	$m_name = str_replace(">","",str_replace("<","",$mail_info[m_from]));
}

//보내는 사람 이메일 뽑아내기
$m_email = EmailPickUp($mail_info[m_from]);

$err = "";

$mailObj = new CMailObject;
$mailObj->InitMailObject($mail_info[m_filename],1);
?>
<SCRIPT LANGUAGE="JavaScript">
<!--
function mailMove(movebox)
{
	location.href="admmail_view_ok.php?mbox=<?=$mbox?>&edit_part=move&movebox="+movebox+"&idx=<?=$idx?>";
}
function addressAdd()
{
	window.open("admmail_add_adr.php?name=<?=$m_name?>&email=<?=$m_email?>","","scrollbars=no,left=100,top=100,width=400,height=300");
}
function rejectAdd()
{
	window.open("admmail_add_rej.php?email=<?=$m_email?>","","scrollbars=no,left=100,top=100,width=400,height=200");
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
											<td width='440'><img src="image/admmail_tit_4.gif"></td>
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
											<td bgcolor="D6EFE7">
												<table width="100%" border="0" cellspacing="0" cellpadding="0" height="30">
													<tr>
														<td width="45"> <div align="center"><a href="admmail_write.php?reply=<?=$idx?>"><img src="image/webmail/reply_btn.gif" width="35" height="17" border="0"></a></div></td>
														<td width="45"></td>
														<td>&nbsp;</td>
														<td width="65">&nbsp;</td>
														<td width="45"><div align="center"><a href="admmail_view_ok.php?edit_part=del&mbox=<?=$mbox?>&idx=<?=$idx?>"><img src="image/webmail/delete_btn.gif" width="35" height="17" border="0"></a></div></td>
														<td width="170"> <div align="center"><select name="move_mbox" onchange="javascript:mailMove(this.value);"><option selected value="">-다른편지함으로옮기기-</option><?
														for($i=1;$i<=4;$i++)
														{
															if($mbox!=$i)
															{
																?><option value="<?=$i?>"><?=$MBOX_NAME[$i]?></option><?
															}
														}
														$my_mbox_result = $MySQL->query("select * from webmail_mbox where badmin=1");
														while($my_mbox_row = mysql_fetch_array($my_mbox_result))
														{
															if($my_mbox_row[mbox]!=$mbox)
															{
																?><option value="<?=$my_mbox_row[mbox]?>"><?=$my_mbox_row[name]?></option><?
															}
														}
														?></select></div></td>
													</tr>
												</table>
											</td>
										</tr>
										<tr>
											<td valign="top">
												<table width="100%" border="0" cellspacing="0" cellpadding="0">
													<tr>
														<td height="1" colspan="2" bgcolor="dadada"></td>
													</tr>
													<tr>
														<td height="30" width="100" bgcolor="f4f4f4">&nbsp;&nbsp;&nbsp;제목</td>
														<td> <?=htmlspecialchars($mail_info[m_subject])?></td>
													</tr>
													<tr>
														<td height="1" colspan="2" bgcolor="dadada"></td>
													</tr>
													<tr>
														<td height="30" width="100" bgcolor="f4f4f4">&nbsp;&nbsp;&nbsp;보낸날짜</td>
														<td> <?=$mail_info[m_writeday]?></td>
													</tr>
													<tr>
														<td height="1" colspan="2" bgcolor="dadada"></td>
													</tr>
													<tr>
														<td height="30" width="100" bgcolor="f4f4f4">&nbsp;&nbsp;&nbsp;보낸이</td>
														<td> <?=htmlspecialchars($mail_info[m_from])?> &nbsp;&nbsp;&nbsp;&nbsp; <a href="javascript:addressAdd();"><img src="image/webmail/address_add.gif" width="85" height="17" border="0" align="absmiddle"></a> <a href="javascript:rejectAdd();"><img src="image/webmail/refuse_btn.gif" width="61" height="17" border="0" align="absmiddle"></a></td>
													</tr>
													<tr>
														<td height="1" colspan="2" bgcolor="dadada"></td>
													</tr>
													<tr valign="top">
														<td colspan="2">
															<table width="100%" border="0" cellspacing="0" cellpadding="10">
																<tr>
																	<td height="200" valign="top"><?$mailObj->EchoBody();?></td>
																</tr>
															</table>
														</td>
													</tr>
													<tr>
														<td height="1" colspan="2" bgcolor="dadada"></td>
													</tr><?
													if($mail_info[m_attach])
													{
														$Attach_filename = $mailObj->pAttach();
														?>
													<tr>
														<td bgcolor="f4f4f4" width="100" height="30">&nbsp;&nbsp;&nbsp;첨부파일</td>
														<td><?=$Attach_filename?></td>
													</tr>
													<tr>
														<td height="1" colspan="2" bgcolor="dadada"></td>
													</tr><?
													}
													?>
												</table>
											</td>
										</tr>
										<tr>
											<td height="30" bgcolor="D6EFE7">
												<table width="100%" border="0" cellspacing="0" cellpadding="0" height="30">
													<tr>
														<td width="45"> <div align="center"><a href="admmail_write.php?reply=<?=$idx?>"><img src="image/webmail/reply_btn.gif" width="35" height="17" border="0"></a></div></td>
														<td width="45"></td>
														<td>&nbsp;</td>
														<td width="65">&nbsp;</td>
														<td width="45"><div align="center"><a href="admmail_view_ok.php?edit_part=del&mbox=<?=$mbox?>&idx=<?=$idx?>"><img src="image/webmail/delete_btn.gif" width="35" height="17" border="0"></a></div></td>
														<td width="170"> <div align="center"><select name="move_mbox" onchange="javascript:mailMove(this.value);"><option selected value="">-다른편지함으로옮기기-</option><?
														for($i=1;$i<=4;$i++)
														{
															if($mbox!=$i)
															{
																?><option value="<?=$i?>"><?=$MBOX_NAME[$i]?></option><?
															}
														}
														$my_mbox_result = $MySQL->query("select * from webmail_mbox where badmin=1");
														while($my_mbox_row = mysql_fetch_array($my_mbox_result))
														{
															if($my_mbox_row[mbox]!=$mbox)
															{
																?><option value="<?=$my_mbox_row[mbox]?>"><?=$my_mbox_row[name]?></option><?
															}
														}
														?></select></div></td>
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