<?
include "head.php";
?>
<SCRIPT LANGUAGE="JavaScript">
<!--
function admSendit()
{
	<? if ($demo_readonly) { ?>
	alert("데모페이지를 통한 스팸메일 발송을 막기위해\n 기능제한을 두었습니다. 죄송합니다.");
	<? }else { ?>
	var form=document.admForm;
	if(form.adm_bWebmail[0].checked && form.adm_name.value=="")
	{
		alert("관리자 이름을 입력해 주십시오.");
		form.adm_name.focus();
	}
	else if(form.adm_bWebmail[0].checked && !isEmail(form.adm_email1.value+"@"+form.adm_email2.value))
	{
		alert("기본메일 주소가 올바르지 않습니다.");
		form.adm_email1.focus();
	}
	else if(form.adm_bWebmail[0].checked && form.adm_smtp.value=="")
	{
		alert("smtp 주소를 입력해 주십시오.");
		form.adm_smtp.focus();
	}
	else if(form.adm_bWebmail[0].checked && form.adm_pop3.value=="")
	{
		alert("pop3 주소를 입력해 주십시오.");
		form.adm_pop3.focus();
	}
	else if(form.adm_bWebmail[0].checked && form.adm_user.value=="")
	{
		alert("아이디를 입력해 주십시오.");
		form.adm_user.focus();
	}
	else if(form.adm_bWebmail[0].checked && form.adm_pass.value=="")
	{
		alert("비밀번호를 입력해 주십시오.");
		form.adm_pass.focus();
	}
	else
	{
		form.submit();
	}
	<? } ?>
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
								<td bgcolor="#E6E6E6" height='26'><div align='right'><font class='text1'>SHOP 관리자메일을 설정 하실 수 있습니다.&nbsp;</div></td>
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
											<td width='440'><img src="image/webmail_tit_1.gif"></td>
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
									<form name="admForm" method="post" action="admmail_adm_ok.php">
									<table width="750" border="0" cellspacing="0" cellpadding="0" align="center"><?
									$adm_email_arr = explode("@",$webmail_admin_row[adm_email]);
									?>
										<tr>
											<td colspan="2" height="1" background="image/line_bg1.gif"></td>
										</tr>
										<tr valign="middle">
											<td width="30%" height="25" bgcolor="#f1f1f1"> <div align="left">&nbsp;&nbsp;<img src="image/icon.gif" width="11" height="11"> 관리자 웹메일 사용 여부</div></td>
											<td width="70%" height="25"> <input type="radio" name="adm_bWebmail" value="1" <?if($webmail_admin_row[adm_bWebmail])echo"checked"?>>사용 <input type="radio" name="adm_bWebmail" value="0" <?if(!$webmail_admin_row[adm_bWebmail])echo"checked"?>>미사용</td>
										</tr>
										<tr>
											<td colspan="2" height="1" background="image/line_bg1.gif"></td>
										</tr>
										<tr valign="middle">
											<td width="30%" height="25" bgcolor="#f1f1f1"> <div align="left">&nbsp;&nbsp;<img src="image/icon.gif" width="11" height="11"> 관리자 메일 표시 이름</div></td>
											<td width="70%" height="25"> <input type="text" name="adm_name" class="box" size="25" value="<?=$webmail_admin_row[adm_name]?>"></td>
										</tr>
										<tr>
											<td colspan="2" height="1" background="image/line_bg1.gif"></td>
										</tr>
										<tr valign="middle">
											<td width="30%" height="25" bgcolor="#f1f1f1"> <div align="left">&nbsp;&nbsp;<img src="image/icon.gif" width="11" height="11"> 기본 메일</div></td>
											<td width="70%" height="25"> <input type="text" name="adm_email1" class="box" size="20" value="<?=$adm_email_arr[0]?>">@<input type="text" name="adm_email2" class="box" size="30" value="<?=$adm_email_arr[1]?>"></td>
										</tr>
										<tr>
											<td colspan="2" height="1" background="image/line_bg1.gif"></td>
										</tr>
										<tr valign="middle">
											<td width="30%" height="25" bgcolor="#f1f1f1"> <div align="left">&nbsp;&nbsp;<img src="image/icon.gif" width="11" height="11"> 보내는 서버(SMTP) 주소</div></td>
											<td width="70%" height="25"> <input type="text" name="adm_smtp" class="box" size="40" value="<?=$webmail_admin_row[adm_smtp]?>"></td>
										</tr>
										<tr>
											<td colspan="2" height="1" background="image/line_bg1.gif"></td>
										</tr>
										<tr valign="middle">
											<td width="30%" height="25" bgcolor="#f1f1f1"> <div align="left">&nbsp;&nbsp;<img src="image/icon.gif" width="11" height="11"> 받는 서버(POP3) 주소</div></td>
											<td width="70%" height="25"> <input type="text" name="adm_pop3" class="box" size="40" value="<?=$webmail_admin_row[adm_pop3]?>"></td>
										</tr>
										<tr>
											<td colspan="2" height="1" background="image/line_bg1.gif"></td>
										</tr>
										<tr valign="middle">
											<td width="30%" height="25" bgcolor="#f1f1f1"> <div align="left">&nbsp;&nbsp;<img src="image/icon.gif" width="11" height="11"> POP3 아이디</div></td>
											<td width="70%" height="25"> <input type="text" name="adm_user" class="box" size="20" value="<?=$webmail_admin_row[adm_user]?>"></td>
										</tr>
										<tr>
											<td colspan="2" height="1" background="image/line_bg1.gif"></td>
										</tr>
										<tr valign="middle">
											<td width="30%" height="25" bgcolor="#f1f1f1"> <div align="left">&nbsp;&nbsp;<img src="image/icon.gif" width="11" height="11"> POP3 비밀번호</div></td>
											<td width="70%" height="25"> <input type="password" name="adm_pass" class="box" size="20" value="<?=$webmail_admin_row[adm_pass]?>"></td>
										</tr>
										<tr>
											<td colspan="2" height="1" background="image/line_bg1.gif"></td>
										</tr>
										<tr>
											<td colspan="2" height="40" valign="middle">
												<table width="50%" border="0" align="center" cellpadding="0" cellspacing="0">
													<tr>
														<td> <div align="center"><a href="javascript:admSendit();"><img src="image/save_btn.gif" width="40" height="17" border="0"></a></div></td>
														<td> <div align="center"><a href="javascript:formClear(document.admForm);"><img src="image/cancel_btn.gif" width="40" height="17" border="0"></a></div></td>
													</tr>
												</table>
											</td>
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
</table>
<? include "copy.php"; ?>
</body>
</html>