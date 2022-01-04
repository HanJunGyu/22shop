<?
include "head.php";
$getArrayOS = explode(";", $_SERVER[HTTP_USER_AGENT]);
$BROWGER = trim($getArrayOS[1]);
$OS = trim($getArrayOS[2]);
if(preg_match("/Windows/", $OS) && preg_match("/MSIE/", $BROWGER))
{
	$Os_Check=1;
	$Use_Check="";
}
else
{
	$Os_Check=0;
	$Use_Check="disabled";
}
if($w_to_idxStr)
{
	//선택한 주소록 메일 보내기
	$w_to_idxArr = explode("-",$w_to_idxStr);
	for($i=0;$i<count($w_to_idxArr);$i++)
	{
		$adr_temp_row = $MySQL->fetch_array("select email from webmail_adr where idx=$w_to_idxArr[$i]");
		$w_to_emailArr[$i] = $adr_temp_row[email];
	}
	$w_to = join(";",$w_to_emailArr);
}
if($w_to_grpIdxStr)
{
	//선택한 그룹 메일 보내기
	$w_to_grpIdxArr = explode("-",$w_to_grpIdxStr);
	$w_to_email_Index = 0;
	for($i=0;$i<count($w_to_grpIdxArr);$i++)
	{
		//그룹정보
		$grp_temp_row = $MySQL->fetch_array("select code from webmail_adr_grp where idx=$w_to_grpIdxArr[$i]");
		$adr_temp_result = $MySQL->query("select email from webmail_adr where grp='$grp_temp_row[code]'");
		while($adr_temp_row = mysql_fetch_array($adr_temp_result))
		{
			$w_to_emailArr[$w_to_email_Index] = $adr_temp_row[email];
			$w_to_email_Index++;
		}
	}
	$w_to = join(";",$w_to_emailArr);
}
if($reply)
{
	//답장
	$mail_info = $MySQL->fetch_array("select * from webmail_mail where idx=$reply");
	$w_to = str_replace(">","",str_replace("<","",$mail_info[m_reply]));
	$w_subject = "Re: $mail_info[m_subject]";
	//메일정보 클래스 객체 생성
	include "../lib/webmail_view_class.php";
	$err = "";
	$mailObj = new CMailObject;
	$mailObj->InitMailObject($mail_info[m_filename],1);
}
?>
<SCRIPT LANGUAGE="JavaScript">
<!--
function thisemailChek(email)
{
	//!isEmail
	var bSuccess = true;
	emailArr = email.split(";");
	for(i=0;i<emailArr.length;i++)
	{
		if(!isEmail(emailArr[i])) bSuccess = false;
	}
	return bSuccess;
}
function mailSendit()
{
	<? if ($demo_readonly) { ?>
	alert("데모페이지를 통한 스팸메일 발송을 막기위해\n 기능제한을 두었습니다. 죄송합니다.");
	<? }else { ?>
	var form = document.mWForm;
	if(form.bHtml[2].checked==true)
	{
		<?
		if(!$Os_Check)
		{
			?>
		alert('웹에디터를 지원하지 않습니다.');<?
		}
		?>
		cdiv.gogo();
	}
	if(form.w_to.value=="")
	{
		alert("받는이를 입력해 주십시오.");
		form.w_to.focus();
	}
	else if(!thisemailChek(form.w_to.value))
	{
		alert("이메일 주소가 올바르지 않습니다.");
		form.w_to.focus();
	}
	else if(!thisemailChek(form.w_cc.value) && form.w_cc.value!="")
	{
		alert("이메일 주소가 올바르지 않습니다.");
		form.w_cc.focus();
	}
	else if(form.w_subject.value=="")
	{
		alert("제목을 입력해 주십시오.");
		form.w_subject.focus();
	}
	else
	{
		form.submit();
	}
	<? } ?>
}

function selectAdd(obj)
{
	window.open("admmail_address_select.php?obj="+obj,"","scrollbars=no,width=500,height=450");
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
											<td width='440'><img src="image/admmail_tit_3.gif"></td>
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
									<form name="mWForm" method="post" action="admmail_write_ok.php" enctype="multipart/form-data" >
									<input type="hidden" name="edit_part" value="send">
									<table width="100%" border="0" cellspacing="0" cellpadding="0">
										<tr>
											<td height="35" bgcolor="D6EFE7">
												<table width="100%" border="0" cellspacing="0" cellpadding="0">
													<tr>
														<td width="70"><div align="center"><a href="javascript:mailSendit();"><img src="image/webmail/send_btn.gif" width="63" height="23" border="0"></a></div></td>
														<td width="135"></td>
														<td width="80">&nbsp;</td>
														<td>&nbsp;</td>
													</tr>
												</table>
											</td>
										</tr>
										<tr>
											<td>
												<table width="100%" border="0" cellspacing="0" cellpadding="0">
													<tr>
														<td height="1" colspan="3" bgcolor="dadada"></td>
													</tr>
													<tr>
														<td height="30" width="100" bgcolor="f4f4f4">&nbsp;&nbsp;&nbsp;받는이</td>
														<td> <input type="text" name="w_to" size="65" class="box" value="<?=$w_to?>"><br><FONT COLOR="#CC6600"> - 복수메일 전송시 ";" 구분자로 입력해 주십시오.</FONT></td>
														<td><a href="javascript:selectAdd('document.mWForm.w_to');"><img src="image/webmail/address.gif" width="48" height="17" border="0" align="absmiddle"></a></td>
													</tr>
													<tr>
														<td height="1" colspan="3" bgcolor="dadada"></td>
													</tr>
													<tr>
														<td height="30" width="100" bgcolor="f4f4f4">&nbsp;&nbsp;&nbsp;참조</td>
														<td> <input type="text" name="w_cc" size="65" class="box"></td>
														<td><a href="javascript:selectAdd('document.mWForm.w_cc');"><img src="image/webmail/address.gif" width="48" height="17" border="0" align="absmiddle"></a></td>
													</tr>
													<tr>
														<td height="1" colspan="3" bgcolor="dadada"></td>
													</tr>
													<tr>
														<td height="30" width="100" bgcolor="f4f4f4">&nbsp;&nbsp;&nbsp;제목</td>
														<td> <input type="text" name="w_subject" size="75"  class="box" value="<?=$w_subject?>"></td>
														<td>&nbsp;</td>
													</tr>
													<tr>
														<td height="1" colspan="3" bgcolor="dadada"></td>
													</tr>
													<tr>
														<td height="30" width="100" bgcolor="f4f4f4">&nbsp;&nbsp;&nbsp;내용형식</td>
														<td> <INPUT TYPE="radio" NAME="bHtml" value='1' onclick="document.getElementById('nsText').style.display='block';document.getElementById('nsHtml').style.display='none';document.getElementById('nsEdit').style.display='none';">TEXT &nbsp; <INPUT TYPE="radio" NAME="bHtml" value='2' <?=$Os_Check?"":"checked"?> onclick="document.getElementById('nsText').style.display='none';document.getElementById('nsHtml').style.display='block';document.getElementById('nsEdit').style.display='none';">HTML &nbsp; <INPUT TYPE="radio" NAME="bHtml" value='0' <?=$Os_Check?"checked":""?> onclick="document.getElementById('nsText').style.display='none';document.getElementById('nsHtml').style.display='none';document.getElementById('nsEdit').style.display='block';" <?= $Use_Check?>>웹에디터</td>
														<td>&nbsp;</td>
													</tr>
													<tr>
														<td height="1" colspan="3" bgcolor="dadada"></td>
													</tr>
													<tr>
														<td colspan="3" align="center">
															<table width="700" cellpadding="0" cellspacing="0" border="0" id='nsText' style='display:none'>
																<tr>
																	<td><textarea name="TextContent" style="width:100%" rows="20" cols="80"><?=$reply?$mailObj->EchoBody():""?></textarea></td>
																</tr>
															</table>
															<table width="700" cellpadding="0" cellspacing="0" border="0" id='nsHtml' style='display:<?=$Os_Check?"none":"block"?>'>
																<tr>
																	<td><textarea name="HtmlContent" style="width:100%" rows="20" cols="80"><?=$reply?$mailObj->EchoBody():""?></textarea></td>
																</tr>
															</table>
															<table width="700" cellpadding="0" cellspacing="0" border="0" id='nsEdit' style='display:<?=$Os_Check?"block":"none"?>'>
																<tr>
																	<td><?
																	$form_name = "mWForm";
																	$dir_path = "..";
																	include "../editor.php";
																	?><textarea style="display:none" class="text" name="content" cols="90" rows="13"><?=$reply?$mailObj->EchoBody():""?></textarea></td>
																</tr>
															</table>
														</td>
													</tr>
													<tr>
														<td height="1" colspan="3" bgcolor="dadada"></td>
													</tr>
													<tr>
														<td bgcolor="f4f4f4" width="100">&nbsp;&nbsp;&nbsp;파일첨부1</td>
														<td colspan="3"> <input type="file" name="w_attach1" class="box"></td>
													</tr>
													<tr>
														<td height="1" colspan="3" bgcolor="dadada"></td>
													</tr>
													<tr>
														<td bgcolor="f4f4f4" width="100">&nbsp;&nbsp;&nbsp;파일첨부2</td>
														<td colspan="3"> <input type="file" name="w_attach2" class="box"></td>
													</tr>
													<tr>
														<td height="1" colspan="3" bgcolor="dadada"></td>
													</tr>
													<tr>
														<td bgcolor="f4f4f4" width="100">&nbsp;&nbsp;&nbsp;파일첨부3</td>
														<td colspan="3"> <input type="file" name="w_attach3" class="box"></td>
													</tr>
													<tr>
														<td height="1" colspan="3" bgcolor="dadada"></td>
													</tr>
												</table>
											</td>
										</tr>
										<tr>
											<td height="35" bgcolor="D6EFE7">
												<table width="100%" border="0" cellspacing="0" cellpadding="0">
													<tr>
														<td width="70"><div align="center"><a href="javascript:mailSendit();"><img src="image/webmail/send_btn.gif" width="63" height="23" border="0"></a></div></td>
														<td width="135"></td>
														<td width="80">&nbsp;</td>
														<td>&nbsp;</td>
														<td width="140"><input type="checkbox" name="b_send_save" value="1" checked> 보낸편지함에 저장</td>
													</tr>
												</table>
											</td>
										</tr>
									</table></form>
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