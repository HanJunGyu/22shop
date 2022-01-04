<?
include "head.php";
if (__DEMOPAGE) $readonly = "readonly";
?>
<SCRIPT LANGUAGE="JavaScript">
<!--
function rejSendit()
{
	var emailArr = new Array();
	var form = document.rejForm;
	for(i=0;i<form.rej_list.length;i++)
	{
		emailArr[i] = form.rej_list.options[i].value;
	}
	form.rej_str.value = emailArr.join(",");
	return true;
}
function rejEmailAdd()
{
	var form = document.rejForm;
	add_email = form.rej_email.value;
	if(!isEmail(add_email))
	{
		alert("메일주소 형식이 올바르지 않습니다.");
	}
	else
	{
		var list_length = form.rej_list.length;
		if(add_email!="")
		{
			form.rej_list.options[list_length]			= new Option(add_email,1);
			form.rej_list.options[list_length].value	= add_email;
			form.rej_email.value = "";
			form.rej_email.focus();
		}
	}
}
function rejEmailDel()
{
	var form = document.rejForm;
	selectedIndex = form.rej_list.selectedIndex;
	if(selectedIndex == -1)
	{
		alert("삭제할 항목을 선택해 주십시오.");
	}
	else
	{
		form.rej_list.options[selectedIndex].value = null; 
		form.rej_list.options[selectedIndex]	   = null; 
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
						<form name="rejForm" method="post" action="admmail_rejection_ok.php" onsubmit="return rejSendit();">
						<input type="hidden" name="rej_str">
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
									<table width="750" border="0" cellspacing="5" cellpadding="0" bgcolor="F4F4F4" align="center">
										<tr>
											<td bgcolor="#FFFFFF">
												<table width="100%" border="0" cellspacing="1" cellpadding="0" bgcolor="dadada">
													<tr>
														<td bgcolor="#FFFFFF">
															<table width="100%" border="0" cellspacing="0" cellpadding="5" height="100">
																<tr>
																	<td width="130"> <div align="center"><img src="image/webmail/img1.gif" width="99" height="78"></div></td>
																	<td><b><font color="#FF6600">메일 수신 거부</font></b><br>ㅁ 원치 않는 메일주소를 등록하시면, 메일이 거부됩니다.<br>ㅁ 내용을 변경한 후에는 반드시 [저장]을 눌러야 변경 내용이 반영됩니다.</td>
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
								<td height='10'></td>
							</tr>
							<tr>
								<td valign="top">
									<table width="100%" border="0" cellspacing="1" cellpadding="5" bgcolor="dadada">
										<tr>
											<td bgcolor="f4f4f4" width="150"> <div align="center">메일 수신 거부 설정</div></td>
											<td bgcolor="#FFFFFF">
												<table width="100%" border="0" cellspacing="0" cellpadding="5">
													<tr>
														<td valign="top"> <div align="center"><b>메일주소입력</b><br><input class="box" type="text" name="rej_email" size="30"><br><font color="#0099CC">예) 메일 주소 거부시: <br>master@goodmorningshop.co.kr</font></div></td>
														<td width="120" valign="top"> <div align="center"><br><a href="javascript:rejEmailAdd();"><img src="image/webmail/add_btn2.gif" width="58" height="23" border="0"></a><br><br><a href="javascript:rejEmailDel();"><img src="image/webmail/delete_btn2.gif" width="58" height="23" border="0"></a> </div></td>
														<td> <div align="center"><b>수신거부목록 </b><br><select name="rej_list" style="width:200;" size="7" ondblclick="javascript:rejEmailDel();"><?
														$qry = "select * from webmail_reject where badmin=1";
														$result = $MySQL->query($qry);
														while($row = mysql_fetch_array($result))
														{
															?><option value="<?=$row[rej_email]?>"><?=$row[rej_email]?></option><?
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
								<td height="50">
									<table width="30%" border="0" cellspacing="0" cellpadding="0" align="center">
										<tr>
											<td><div align="center"><input type="image" src="image/webmail/save_btn.gif" width="58" height="23" border="0"></div></td>
											<td><div align="center"><a href="admmail_manager.php"><img src="image/webmail/cancel_btn.gif" width="58" height="23" border="0"></a></div></td>
										</tr>
									</table>
								</td>
							</tr>
							<tr>
								<td valign="top">&nbsp;</td>
							</tr>
						</table></form>
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>
<? include "copy.php"; ?>
</body>
</html>