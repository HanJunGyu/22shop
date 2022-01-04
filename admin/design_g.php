<?
include "head.php";
?>
<SCRIPT LANGUAGE="JavaScript">
<!--
//정보 전송
function sendit()
{
	var form=document.copyForm;
	form.submit();
}

function titleFormSendit()
{
	var form=document.titleForm;
	if(form.img.value=="")
	{
		alert("이미지를 선택해 주십시오.");
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
	$__TOP_MENU = "design";     //왼쪽 소메뉴 설정 변수
	include "left_menu.php";
	?>
		<td width="85%" valign="top">
			<table width="100%" height="500" border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td height='5'></td>
				</tr>
				<tr>
					<td>
						<table width="750" border="0" cellspacing="0" cellpadding="0" align='center'>
							<tr>
								<td rowspan="3" width="200"><img src="image/design_tit_img.gif"></td>
								<td>&nbsp;</td>
							</tr>
							<tr>
								<td bgcolor="#E6E6E6" height='26'><div align='right'><font class='text1'>SHOP 디자인을 변경하실수 있습니다.&nbsp;</div></td>
							</tr>
							<tr>
								<td>&nbsp;</td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td>
						<table width="750" border="0" cellspacing="0" cellpadding="0" align="center">
							<tr>
								<td width='1' bgcolor='dadada'></td>
							</tr>
							<tr>
								<td><img src="image/design_tit_g.gif"></td>
							</tr>
							<tr>
								<td width='1' bgcolor='dadada'></td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td height='10'></td>
				</tr>
				<tr>
					<td valign="top">
						<table width="750" border="0" cellspacing="0" cellpadding="0" align="center">
							<? include "main_design_menu.php";?>
							<tr>
								<td colspan="2" height="10"></td>
							</tr>
							<tr>
								<td colspan="2" valign="top" height="25"><img src="image/design_main_icon.gif" width="21" height="11">G 화면 구성</td>
							</tr>
							<tr>
								<td colspan="2">
									<table width="100%" border="0" cellspacing="0" cellpadding="0" align='center'>
										<tr>
											<td width="80">&nbsp;</td>
											<td width="170"> <div align="center"><img src="image/design_g_view.gif" ></div></td>
											<td width="20"> <div align="center"></div></td>
											<td width="200"> <div align="center"><img src="image/design_g_view1.gif" ></div></td>
											<td width="70">&nbsp;</td>
										</tr>
									</table>
								</td>
							</tr>
							<tr>
								<td colspan="2" height="60">
									<table width="100%" border="1" cellspacing="0" cellpadding="2" align="center" bordercolor="#FFD28E" bordercolordark="#ffffff">
										<tr>
											<td bgcolor="#FFF3E1" align="center" height="40">
												<table width="90%" border="0" cellspacing="0" cellpadding="0" align="center">
													<tr>
														<td height="40"> * 하단 좌측 로고이미지 등록 <br> * 회사 소개 메뉴 - 배경색과 글자 색상 변경가능</td>
													</tr>
												</table>
											</td>
										</tr>
									</table>
								</td>
							</tr>
							<tr>
								<td colspan="2" valign="top">&nbsp;</td>
							</tr>
							<tr>
								<td colspan="2" valign="top" height="35"><br><img src="image/design_main_icon.gif" width="21" height="11">로고 이미지 </td>
							</tr>
							<form name="titleForm" method="post" action="design_ok.php?act=design_g&part=1"  enctype="multipart/form-data" >
							<tr>
								<td colspan="2" height="70">
									<table width="100%" border="1" cellspacing="0" cellpadding="2" align="center" bordercolor="#FFD28E" bordercolordark="#ffffff">
										<tr>
											<td width="150"> <div align="center"><img src="../upload/design/<?=$design[copyLogo]?>" > </div></td>
											<td width="400">
												<table width="100%" border="0" cellspacing="0" cellpadding="0">
													<tr>
														<td> <div align="center"> <input type="file" name="img" size="25" style="BORDER-RIGHT: gray 1px solid; BORDER-TOP: gray  1px solid; FONT-SIZE: 9pt; BORDER-LEFT: gray 1px solid; BORDER-BOTTOM: gray  1px solid; FONT-FAMILY: gulim; HEIGHT: 19px; BACKGROUND-COLOR: white"></div></td>
														<td><a href="javascript:titleFormSendit();"><img src="image/design_save_i.gif" width="46" height="18" border="0"></a> </td>
													</tr>
												</table>
											</td>
										</tr>
										<tr bgcolor="#FFF3E1">
											<td colspan="2"> <div align="center">gif , jpg   사용가능</div></td>
										</tr>
									</table>
								</td>
							</tr>
							</form>
							<tr>
								<td colspan="2" valign="top">&nbsp;</td>
							</tr>
							<form name="copyForm" method="post" action="design_ok.php?act=design_g&part=2"  enctype="multipart/form-data" >
							<tr>
								<td colspan="2" height="40"><img src="image/design_main_icon.gif" width="21" height="11">회사소개 메뉴 배경 색상</td>
							</tr>
							<tr>
								<td colspan="2">
									<table width="100%" border="1" cellspacing="0" cellpadding="2" align="center" bordercolor="#FFD28E" bordercolordark="#ffffff">
										<tr>
											<td width="400" align="center">
												<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
													<tr>
														<td width="100">
															<table width="100%" border="0" cellspacing="0" cellpadding="0" height="40" align="center">
																<tr>
																	<td  bgcolor="<?=$design[copyBC]?>" style="color:<?=$design[copyTC]?>;" id="BC1"><div align="center">회사소개</div></td>
																</tr>
															</table>
														</td>
														<td><a href="javascript:setColor('mul','bg','BC1');"><img src="image/design_p.gif" width="19" height="20" border="0"></a> <input type="text" name="copyBC" value="<?=$design[copyBC]?>" size="8"></td>
													</tr>
												</table>
											</td>
											<td bgcolor="#FFF3E1"><div align="center"><a href="javascript:sendit();"><img src="image/design_save_i.gif" width="46" height="18" border="0"></a></div></td>
										</tr>
									</table>
								</td>
							</tr>
							<tr>
								<td colspan="2" height="40"><img src="image/design_main_icon.gif" width="21" height="11">회사소개 메뉴 글자 색상</td>
							</tr>
							<tr>
								<td colspan="2">
									<table width="100%" border="1" cellspacing="0" cellpadding="2" align="center" bordercolor="#FFD28E" bordercolordark="#ffffff">
										<tr>
											<td width="400" align="center">
												<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
													<tr>
														<td width="100">
															<table width="100%" border="0" cellspacing="0" cellpadding="0" height="40" align="center">
																<tr>
																	<td  bgcolor="<?=$design[copyBC]?>" style="color:<?=$design[copyTC]?>;" id="BC2"><div align="center">회사소개</div></td>
																</tr>
															</table>
														</td>
														<td><a href="javascript:setColor('mul','tx','BC2');"><img src="image/design_p.gif" width="19" height="20" border="0"></a> <input type="text" name="copyTC" value="<?=$design[copyTC]?>" size="8"></td>
													</tr>
												</table>
											</td>
											<td bgcolor="#FFF3E1"><div align="center"><a href="javascript:sendit();"><img src="image/design_save_i.gif" width="46" height="18" border="0"></a></div></td>
										</tr>
									</table>
								</td>
							</tr>
							</form><!-- copyForm -->
							<tr>
								<td colspan="2">&nbsp;</td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>
<? include "copy.php";?>
</body>
</html>