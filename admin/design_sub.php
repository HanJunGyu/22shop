<?
include "head.php";
?>
<SCRIPT LANGUAGE="JavaScript">
<!--
function subSendit(form)
{
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
	if(!defined(__ADMIN_ROW))
	{
		define(__ADMIN_ROW,"TRUE");
		$admin_row=$MySQL->fetch_array("select *from admin limit 0,1"); //관리자 정보 배열
	}
	$design=$MySQL->fetch_array("select *from sub_design limit 0,1"); //관리자 정보 배열
	?>
		<td width="85%" valign="top">
			<table width="100%" border="0" cellspacing="0" cellpadding="0" height="500">
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
								<td><img src="image/design_sub_tit.gif"></td>
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
								<td valign="top" height="25">
									<table width="700" border="0" cellspacing="0" cellpadding="0" align="center">
										<tr>
											<td height="40"><img src="image/design_main_icon.gif" width="21" height="11">sub 화면 구성</td>
										</tr>
										<tr>
											<td>&nbsp;</td>
										</tr>
										<tr>
											<td valign="top">
												<table width="600" border="0" cellspacing="0" cellpadding="0" align="center">
													<tr>
														<td> <div align="center"></div></td>
													</tr>
													<tr>
														<td> <div align="center"><img src="image/design_sub_view1.gif" ></div></td>
													</tr>
												</table>
											</td>
										</tr>
										<tr>
											<td>&nbsp;</td>
										</tr>
										<tr>
											<td>
												<table width="650" border="1" cellspacing="0" cellpadding="10" align="center" bordercolor="#FFD28E" bordercolordark="#ffffff" height="50">
													<tr>
														<td bgcolor="#FFF3E1"> <p>서브 페이지 타이틀 이미지 및 배경 컬러 변경 , 글자색 변경</p></td>
													</tr>
												</table>
											</td>
										</tr>
										<tr>
											<td>&nbsp;</td>
										</tr>
										<tr>
											<td height="40"><img src="image/design_main_icon.gif" width="21" height="11">서브페이지 타이틀 이미지 및 배경 컬러</td>
										</tr>
										<tr>
											<td valign="top">&nbsp; </td>
										</tr><?
										for($i=0;$i<count($SUB_ARR);$i++)
										{
											$num = $i+1;
											$imgStr = "img".$num;
											$bcStr = "bc".$num;
											$tcStr = "tc".$num;
											$titimgStr = "titimg".$num;
											if ($SUB_ARR[$i])
											{
												?>
										<form name="subForm<?=$num?>" method="post" action="design_sub_ok.php?part=<?=$num?>" enctype="multipart/form-data" >
										<tr>
											<td valign="top">
												<table width="850" border="0" cellspacing="0" cellpadding="0" align="center">
													<tr>
														<td rowspan="3" width="100" valign="top"> <div align="center"><font color="#FF9900"><b><?=$num?>. <?=$SUB_ARR[$i]?></b></font></div></td>
														<td> <?
														if ($num != 1 )
														{
															?>
															<table width="750" border="1" cellspacing="0" cellpadding="2" align="center" bordercolor="#FFD28E" bordercolordark="#ffffff">
																<tr>
																	<td width="200"> <div align="center"><img src="../upload/design/<?=$design[$imgStr]?>"> </div></td>
																	<td width="300">
																		<table width="100%" border="0" cellspacing="0" cellpadding="0">
																			<tr>
																				<td> <div align="center"> <input type="file" name="img"   size="25" style="BORDER-RIGHT: gray 1px solid; BORDER-TOP: gray  1px solid; FONT-SIZE: 9pt; BORDER-LEFT: gray 1px solid; BORDER-BOTTOM: gray  1px solid; FONT-FAMILY: gulim; HEIGHT: 19px; BACKGROUND-COLOR: white"></div></td>
																				<td>&nbsp;</td>
																			</tr>
																		</table>
																	</td>
																</tr>
																<tr bgcolor="#FFF3E1">
																	<td colspan="2"> <div align="center">gif , jpg 사용가능 (최적화 사이즈 179×30 px) </div></td>
																</tr>
															</table><?
														}
														else
														{
															?>
															<table width="750" border="1" cellspacing="0" cellpadding="2" align="center" bordercolor="#FFD28E" bordercolordark="#ffffff">
																<tr>
																	<td>※ 제품리스트는 카테고리 이미지3 이 출력되므로 이미지 추가가 없습니다. </td>
																</tr>
															</table><?
														}
														if ($num != 1 && $num != 2)
														{
															?>
															<table width="750" border="1" cellspacing="0" cellpadding="2" align="center" bordercolor="#FFD28E" bordercolordark="#ffffff">
																<tr>
																	<td width="100%"> <?
																	if ($design[$titimgStr])
																	{
																		?><div align="center"><img src="../upload/design/<?=$design[$titimgStr]?>"> </div><?
																	}
																	?></td>
																</tr>
																<tr>
																	<td width="100%">
																		<table width="100%" border="0" cellspacing="0" cellpadding="0">
																			<tr>
																				<td> <div align="center"> 타이틀 이미지 大 : <input type="file" name="titimg" size="25" style="BORDER-RIGHT: gray 1px solid; BORDER-TOP: gray  1px solid; FONT-SIZE: 9pt; BORDER-LEFT: gray 1px solid; BORDER-BOTTOM: gray  1px solid; FONT-FAMILY: gulim; HEIGHT: 19px; BACKGROUND-COLOR: white"></div></td>
																				<td>&nbsp;</td>
																			</tr>
																		</table>
																	</td>
																</tr>
																<tr bgcolor="#FFF3E1">
																	<td colspan="2"> <div align="center">gif , jpg 사용가능 (최적화 사이즈 가로 720 px) </div></td>
																</tr>
															</table>
														</td>
													</tr><?
														}
														?>
													<tr>
														<td height="5"></td>
													</tr>
													<tr>
														<td>
															<table width="750" border="1" cellspacing="0" cellpadding="2" align="center" bordercolor="#FFD28E" bordercolordark="#ffffff">
																<tr>
																	<td bgcolor="#FFF3E1"> <div align="center">배경색</div></td>
																	<td bgcolor="#FFF3E1"> <div align="center">글자색</div></td>
																	<td width="100" bgcolor="#FFF3E1"> <div align="center">저장</div></td>
																</tr>
																<tr>
																	<td width="200">
																		<table width="200" border="0" cellspacing="0" cellpadding="0" align="center">
																			<tr>
																				<td width="100">
																					<table width="60" border="0" cellspacing="0" cellpadding="0" height="40" align="center">
																						<tr>
																							<td bgcolor="<?=$design[$bcStr]?>" style="color:<?=$design[$tcStr]?>;" id="BC<?=$num?>"> <div align="center">글자</div></td>
																						</tr>
																					</table>
																				</td>
																				<td><a href="javascript:subsetColor('mul','bg','BC<?=$num?>','document.subForm<?=$num?>');"><img src="image/design_p.gif" width="19" height="20" border="0"></a></td>
																				<td width="150"> <div align="right"> <input type="text" class="box" name="copyBC" size="8" value="<?=$design[$bcStr]?>"></div></td>
																			</tr>
																		</table>
																	</td>
																	<td width="200">
																		<table width="200" border="0" cellspacing="0" cellpadding="0" align="center">
																			<tr>
																				<td width="100">
																					<table width="60" border="0" cellspacing="0" cellpadding="0" height="40" align="center">
																						<tr>
																							<td bgcolor="<?=$design[$bcStr]?>" style="color:<?=$design[$tcStr]?>;" id="BC<?=$num?>_1"><div align="center">글자</div></td>
																						</tr>
																					</table>
																				</td>
																				<td><a href="javascript:subsetColor('mul','tx','BC<?=$num?>_1','document.subForm<?=$num?>');"><img src="image/design_p.gif" width="19" height="20" border="0"></a></td>
																				<td width="150"> <div align="right"><input type="text" class="box" name="copyTC" size="8" value="<?=$design[$tcStr]?>"></div></td>
																			</tr>
																		</table>
																	</td>
																	<td width="100" bgcolor="#FFF3E1"> <div align="center"><a href="javascript:subSendit(document.subForm<?=$num?>);"><img src="image/design_save_i.gif" width="46" height="18" border="0"></a></div></td>
																</tr>
															</table>
														</td>
													</tr>
												</table>
											</td>
										</tr>
										<tr>
											<td valign="top" height="50">&nbsp;</td>
										</tr>
										</form><?
											}
										}
										?>
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
<? include "copy.php";?>
</body>
</html>