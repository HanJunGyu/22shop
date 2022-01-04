<?
include "head.php";
if (__DEMOPAGE)
{
	$readonly = "readonly";
}
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
function mboxEdit(mbox)
{
	window.open("admmail_mbox_edit.php?mbox="+mbox,"","scrollbars=no,width=300,height=100,left=200,top=200");
}
function mailEmpty(mbox)
{
	var choose = confirm("주의!!\n\n해당편지함의 모든 메일이 영구 삭제됩니다.\n\n삭제 하시겠습니까?");
	if(choose)
	{
		location.href="admmail_mbox_ok.php?edit_part=empty&mbox=" + mbox;
	}
	else return;
}
function mboxDel(mbox,bPop3)
{
	if(bPop3)
	{
		alert("에러!!\n\n외부메일이 설정된 편지함입니다.\n\n외부메일의 편지함 경로를 변경후 삭제하시기 바랍니다.");
	}
	else
	{
		var choose = confirm("주의!!\n\n해당편지함의 모든 메일이 영구 삭제됩니다.\n\n삭제 하시겠습니까?");
		if(choose)
		{
			location.href="admmail_mbox_ok.php?edit_part=del&mbox=" + mbox;
		}
		else return;
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
											<td width='440'><img src="image/admmail_tit_1.gif"></td>
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
								<td valign="top">
									<table width="100%" border="0" cellspacing="0" cellpadding="0">
										<tr>
											<td bgcolor="D6EFE7" height="35">
												<form name="mboxWForm" method="post" action="admmail_mbox_ok.php" onsubmit="return mboxWSendit();">
												<input type="hidden" name="edit_part" value="write">
												<table width="100%" border="0" cellspacing="0" cellpadding="0">
													<tr>
														<td width="23"> <div align="center"><img src="image/webmail/left_icon6.gif" width="17" height="17"></div></td>
														<td width="80">편지함 만들기 </td>
														<td width="140"> <input type="text" name="name" size="17"></td>
														<td><input type="image" src="image/webmail/make_btn.gif" width="47" height="17" border="0"></td>
													</tr>
												</table></form>
											</td>
										</tr>
										<tr>
											<td valign="top">
												<table width="100%" border="0" cellspacing="0" cellpadding="0">
													<tr>
														<td colspan="4" height="1" bgcolor="cdcdcd"></td>
													</tr>
													<tr>
														<td height="30" bgcolor="f4f4f4"> <div align="center">편지함 이름</div></td>
														<td height="30" width="100" bgcolor="f4f4f4"> <div align="center">새편지/전체편지</div></td>
														<td height="30" width="90" bgcolor="f4f4f4"> <div align="center">용량</div></td>
														<td height="30" bgcolor="f4f4f4" width="60"> <div align="center">비우기</div></td>
													</tr>
													<tr>
														<td colspan="4" height="1" bgcolor="cdcdcd"></td>
													</tr>
													<tr>
														<td colspan="4" height="2" bgcolor="f4f4f4"></td>
													</tr><?
													for($i=1;$i<count($MBOX_NAME);$i++)
													{
														$mbox = $i;
														$qry = "select idx from webmail_mail where badmin=1 and mbox='$mbox'";
														$MySQL->query($qry);
														$mbox_total_mail_cnt = $MySQL->is_affected();	//편지함내 전체 메일수
														$qry = "select idx from webmail_mail where badmin=1 and mbox='$mbox' and bRead=0";
														$MySQL->query($qry);
														$mbox_noread_mail_cnt = $MySQL->is_affected();	//편지함내 새 메일수
														$qry = "select sum(m_size) from webmail_mail where badmin=1 and mbox='$mbox'";
														$mbox_size_row = $MySQL->fetch_array($qry);
														$mbox_size = $mbox_size_row[0];
														if(!$mbox_size) $mbox_size = 0;
														$mbox_size_str = sprintf("%d KB",intval($mbox_size /1024));
														?>
													<tr>
														<td height="30"> &nbsp;&nbsp;&nbsp;<a href="admmail_list.php?mbox=<?=$i?>"><?=$MBOX_NAME[$i]?></a></td>
														<td height="30"> <div align="center">[ <b><?=$mbox_noread_mail_cnt?></b> / <?=$mbox_total_mail_cnt?>]</div></td>
														<td height="30"> <div align="right"><?=$mbox_size_str?>&nbsp;&nbsp;</div></td>
														<td height="30"> <div align="center"><a href="javascript:mailEmpty('<?=$mbox?>');"><img src="../image/webmail/empty.gif" width="38" height="14" border="0"></a></div></td>
													</tr>
													<tr>
														<td colspan="4" height="1" background="../image/webmail/bg2.gif"></td>
													</tr><?
													}
													$mbox_qry = "select * from webmail_mbox where badmin=1 order by idx asc";
													$mbox_result = $MySQL->query($mbox_qry);
													while($mbox_row = mysql_fetch_array($mbox_result))
													{
														$mbox = $mbox_row[mbox];
														$qry = "select idx from webmail_mail where badmin=1 and mbox='$mbox'";
														$MySQL->query($qry);
														$mbox_total_mail_cnt = $MySQL->is_affected();	//편지함내 전체 메일수
														$qry = "select idx from webmail_mail where badmin=1 and mbox='$mbox' and bRead=0";
														$MySQL->query($qry);
														$mbox_noread_mail_cnt = $MySQL->is_affected();	//편지함내 새 메일수
														$qry = "select sum(m_size) from webmail_mail where badmin=1 and mbox='$mbox'";
														$mbox_size_row = $MySQL->fetch_array($qry);
														$mbox_size = $mbox_size_row[0];
														if(!$mbox_size) $mbox_size = 0;
														$mbox_size_str = sprintf("%d KB",intval($mbox_size /1024));
														$MySQL->query("select idx from webmail_pop3 where mbox='$mbox_row[mbox]'");
														$b_pop3 = $MySQL->is_affected();
														?>
													<tr>
														<td height="30"> &nbsp;&nbsp;&nbsp;<a href="admmail_list.php?mbox=<?=$mbox?>"><?=$mbox_row[name]?></a> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="javascript:mboxEdit('<?=$mbox?>');"><img src="../image/webmail/edit_btn.gif" width="35" height="17" align="absmiddle" border="0"></a> <a href="javascript:mboxDel('<?=$mbox?>',<?=$b_pop3?>);"><img src="../image/webmail/delete_btn.gif" width="35" height="17" align="absmiddle" border="0"></a></td>
														<td height="30"> <div align="center">[ <b><?=$mbox_noread_mail_cnt?></b> / <?=$mbox_total_mail_cnt?>]</div></td>
														<td height="30"> <div align="right"><?=$mbox_size_str?>&nbsp;&nbsp;</div></td>
														<td height="30"> <div align="center"><a href="javascript:mailEmpty('<?=$mbox?>');"><img src="../image/webmail/empty.gif" width="38" height="14" border="0"></a></div></td>
													</tr>
													<tr>
														<td colspan="4" height="1" background="../image/webmail/bg2.gif"></td>
													</tr><?
													}
													?>
												</table>
											</td>
										</tr><?
										$qry = "select idx from webmail_mail where badmin=1";
										$MySQL->query($qry);
										$mbox_total_mail_cnt = $MySQL->is_affected();	//편지함내 전체 메일수
										$qry = "select idx from webmail_mail where badmin=1 and bRead=0";
										$MySQL->query($qry);
										$mbox_noread_mail_cnt = $MySQL->is_affected();	//편지함내 새 메일수
										$qry = "select sum(m_size) from webmail_mail where badmin=1";
										$mbox_size_row = $MySQL->fetch_array($qry);
										$mbox_size = $mbox_size_row[0];
										if(!$mbox_size) $mbox_size = 0;
										$mbox_size_str = sprintf("%d KB",intval($mbox_size /1024));
										?>
										<tr>
											<td height="30" bgcolor="D6EFE7">
												<table width="100%" border="0" cellspacing="0" cellpadding="0">
													<tr>
														<td height="30"> &nbsp;&nbsp;&nbsp;총편지함</td>
														<td height="30" width="100"> <div align="center">[ <b><?=$mbox_noread_mail_cnt?></b> / <?=$mbox_total_mail_cnt?>]</div></td>
														<td height="30" width="90"> <div align="right"><?=$mbox_size_str?>&nbsp;&nbsp;</div></td>
														<td height="30" width="60"> <div align="center">-</div></td>
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
		</td>
	</tr>
</table>
<? include "copy.php"; ?>
</body>
</html>