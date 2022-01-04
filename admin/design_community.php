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
?>
<SCRIPT LANGUAGE="JavaScript">
<!--
//메인 타이틀 이미지 전송
function mainSendit()
{
	var form=document.mainForm;
	if(form.community_type[2].checked==true)
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
	form.submit();
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
								<td><img src="image/design_tit_community.gif"></td>
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
							<tr>
								<td colspan="2" height="100"><br>
									<table width="100%" border="1" cellspacing="0" cellpadding="2" align="center" bordercolor="#FFD28E" bordercolordark="#ffffff">
										<tr>
											<td bgcolor="#FFF3E1" align="center" height="40">
												<table width="95%" border="0" cellspacing="0" cellpadding="0" align="center">
													<tr>
														<td height="40">* 커뮤니티 타이틀 이미지 등록<br>* 커뮤니티 HTML 삽입<br>* 커뮤니티 게시판 진열 설정<br>* 커뮤니티 게시판 메인페이지 노출 설정<br></td>
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
								<td colspan="2">
									<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
										<tr>
											<td height="40"> <div align="center"><a href="javascript:mainSendit();"><img src="image/design_save_i.gif" width="46" height="18" border="0"></a></div></td>
										</tr>
									</table>
								</td>
							</tr>
							<form name="mainForm" method="post" action="design_community_ok.php?act=design_community&part=1"  enctype="multipart/form-data" >
							<tr>
								<td colspan="2" valign="top" height="25"><img src="image/design_main_icon.gif" width="21" height="11">타이틀 이미지</td>
							</tr>
							<tr>
								<td colspan="2" height="70">
									<table width="100%" border="1" cellspacing="0" cellpadding="2" align="center" bordercolor="#FFD28E" bordercolordark="#ffffff">
										<tr>
											<td><?
											if($design[maincommunityTitleImg_type]==4)
											{
												$img = "../upload/design/$design[maincommunityTitleImg]";
												$img_info = @getimagesize($img);
												$swf_width = $img_info[0];
												$swf_height = $img_info[1];
												?><div align="center">
													<script language='javascript'>
														getFlash("<?=$img?>", "<?=$swf_width?>", "<?=$swf_height?>");
													</script>
												</div><?
											}
											else
											{
												?><div align="center"><img src="../upload/design/<?=$design[maincommunityTitleImg]?>" > </div><?
											}
											?></td>
										</tr>
									</table>
								</td>
							</tr>
							<tr>
								<td colspan="2"><br>
									<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
										<tr>
											<td>
												<table width="100%" border="1" cellspacing="0" cellpadding="2" align="center" bordercolor="#FFD28E" bordercolordark="#ffffff">
													<tr>
														<td bgcolor="#ffffff"> <div align="center"> <input type="file" name="img" size="25" style="BORDER-RIGHT: gray 1px solid; BORDER-TOP: gray  1px solid; FONT-SIZE: 9pt; BORDER-LEFT: gray 1px solid; BORDER-BOTTOM: gray  1px solid; FONT-FAMILY: gulim; HEIGHT: 19px; BACKGROUND-COLOR: white"></div></td>
													</tr>
													<tr>
														<td bgcolor="#FFF3E1"> <div align="center"> gif , jpg ,  swf 사용가능 (최적화 사이즈 가로 720 px) </div></td>
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
							<tr>
								<td colspan="2" valign="top">&nbsp;</td>
							</tr>
							<tr>
								<td colspan="2" valign="top" height="25"><img src="image/design_main_icon.gif" width="21" height="11">타이틀이미지 밑부분 HTML 삽입 (선택사항) </td>
							</tr>
							<tr>
								<td colspan="2">
									<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
										<tr>
											<td>
												<table width="100%" border="1" cellspacing="0" cellpadding="2" align="center" bordercolor="#FFD28E" bordercolordark="#ffffff"><?
													$community_type_chk[$design[community_type]]="checked";
													?>
													<tr>
														<td bgcolor="#FFF3E1" align="center"> <div align="center">내용입력 형식 : <INPUT TYPE="radio" NAME="community_type" value='1' onclick="document.getElementById('nsText').style.display='block';document.getElementById('nsHtml').style.display='none';document.getElementById('nsEdit').style.display='none';" <?= $community_type_chk[1]?>>TEXT &nbsp; <INPUT TYPE="radio" NAME="community_type" value='2' onclick="document.getElementById('nsText').style.display='none';document.getElementById('nsHtml').style.display='block';document.getElementById('nsEdit').style.display='none';" <?= $community_type_chk[2]?>>HTML &nbsp; <INPUT TYPE="radio" NAME="community_type" value='0' onclick="document.getElementById('nsText').style.display='none';document.getElementById('nsHtml').style.display='none';document.getElementById('nsEdit').style.display='block';" <?= $Use_Check?> <?= $community_type_chk[0]?>>웹에디터</div></td>
													</tr>
													<tr>
														<td align="center">
															<table width="600" cellpadding="0" cellspacing="0" border="0" id='nsText' style='display:<?=$design[community_type]==1?"block":"none"?>'>
																<tr>
																	<td><textarea name="TextContent" style="width:100%" rows="20" cols="80"><?=htmlspecialchars($design[community_content])?></textarea></td>
																</tr>
															</table>
															<table width="600" cellpadding="0" cellspacing="0" border="0" id='nsHtml' style='display:<?=$design[community_type]==2?"block":"none"?>'>
																<tr>
																	<td><textarea name="HtmlContent" style="width:100%" rows="20" cols="80"><?=htmlspecialchars($design[community_content])?></textarea></td>
																</tr>
															</table>
															<table width="600" cellpadding="0" cellspacing="0" border="0" id='nsEdit' style='display:<?=!$design[community_type]?"block":"none"?>'>
																<tr>
																	<td width="600"><input type="hidden" name="bHtml" value="1"><?
																	$form_name = "mainForm";
																	$dir_path = "..";
																	include "../editor.php";
																	?><textarea style="display:none" class="text" name="content" cols="90" rows="14"><?=htmlspecialchars($design[community_content])?></textarea></td>
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
								<td colspan="2">&nbsp;</td>
							</tr>
							<tr>
								<td colspan="2" valign="top" height="25"><img src="image/design_main_icon.gif" width="21" height="11">게시판 진열 설정 </td>
							</tr>
							<tr>
								<td colspan="2">
									<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
										<tr>
											<td><input type="radio" name="community_cols" value="2" <? if ($design[community_cols]==2) echo "checked";?>>2단 구성 &nbsp;&nbsp;<input type="radio" name="community_cols" value="3" <? if ($design[community_cols]==3) echo "checked";?>>3단 구성 &nbsp;&nbsp;<input type="radio" name="community_cols" value="4" <? if ($design[community_cols]==4) echo "checked";?>>4단 구성 </td>
										</tr>
									</table>
								</td>
							</tr>
							<tr>
								<td colspan="2">&nbsp;</td>
							</tr>
							<tr>
								<td colspan="2" valign="top" height="25"><img src="image/design_main_icon.gif" width="21" height="11">메인페이지에 커뮤니티 게시판 노출 설정 </td>
							</tr>
							<tr>
								<td colspan="2">
									<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
										<tr>
											<td><input type="radio" name="bcomm_main" value="y" <? if ($design[bcomm_main]=="y") echo "checked";?>>노출시킴 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="bcomm_main" value="n" <? if ($design[bcomm_main]=="n") echo "checked";?>>노출하지 않음 <br>노출시킬경우 위치설정 &nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="bcomm_main_type" value="1" <? if ($design[bcomm_main_type]==1) echo "checked";?>> 1번 위치 &nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="bcomm_main_type" value="2" <? if ($design[bcomm_main_type]==2) echo "checked";?>> 2번 위치 &nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="bcomm_main_type" value="3" <? if ($design[bcomm_main_type]==3) echo "checked";?>> 3번 위치<br><br><img src="image/comm_type_view.gif"></td>
										</tr>
									</table>
								</td>
							</tr>
							<tr>
								<td colspan="2">&nbsp;</td>
							</tr>
							<tr>
								<td colspan="2">
									<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
										<tr>
											<td height="40"> <div align="center"><a href="javascript:mainSendit();"><img src="image/design_save_i.gif" width="46" height="18" border="0"></a></div></td>
										</tr>
									</table>
								</td>
							</tr></form><!-- mainForm -->
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