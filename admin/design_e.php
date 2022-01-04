<?
include "head.php";
?>
<SCRIPT LANGUAGE="JavaScript">
<!--
//활성 /비활성
function showApp()
{
	var form=document.bestForm;
	<?if($design[mainHitApp]==2){ ?>
	if(form.mainBestApp[2].checked)
	{
		alert("자동 스크롤뷰는 베스트상품전,히트상품전 중 한곳만 적용가능합니다.");
		form.mainBestApp[0].checked = true;
	}
	<? } ?>
	if(form.mainBestApp[0].checked || form.mainBestApp[2].checked)
	{
		document.getElementById('goodsApp').style.display="";
		document.getElementById('htmlApp').style.display="none";
	}
	else
	{
		document.getElementById('goodsApp').style.display="none";
		document.getElementById('htmlApp').style.display="";
	}
}

//정보 전송
function bestSendit(Part)
{
	var form=document.bestForm;
	if(Part==1 && form.img.value=="")
	{
		alert("이미지를 선택해 주십시오.");
	}
	else if(Part==2 && !numCheck(form.mainBestGoodsW.value))
	{
		alert("가로 출력수 설정이 올바르지 않습니다.");
		form.mainBestGoodsW.focus();
	}
	else if(Part==2 && form.mainBestGoodsW.value <2)
	{
		alert("가로 출력수는 2 이상의 숫자를 입력해 주십시오.");
		form.mainBestGoodsW.focus();
	}
	else if(Part==2 && !numCheck(form.mainBestGoodsH.value))
	{
		alert("세로 출력수 설정이 올바르지 않습니다.");
		form.mainBestGoodsH.focus();
	}
	else if(Part==2 && form.mainBestGoodsH.value <1)
	{
		alert("세로 출력수는 1 이상의 숫자를 입력해 주십시오.");
		form.mainBestGoodsH.focus();
	}
	else if(Part==3 &&  form.mainBestContent.value=="")
	{
		alert("내용을 입력해 주십시오.");
		form.mainBestContent.focus();
	}
	else if(Part==2 && form.mainBestApp[2].checked && form.mainBestGoodsW.value!=4)
	{
		alert("자동스크롤뷰 사용시에는 가로출력수를 4 로 고정해야 합니다..");
	}
	else
	{
		form.action +="&part="+Part;
		form.submit();
	}
}

function ColsChange()
{
	var form=document.bestForm;
	if (form.mainBestColsChange.checked == true)
	{
		document.getElementById('colschange_id').style.display = "inline";
		var cols = form.mainBestGoodsIH.value; ////세로출력수
	}
	else document.getElementById('colschange_id').style.display = "none";
}
//-->
</SCRIPT>
<body bgcolor="#FFFFFF" text="#5A595A" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onload="javascript:showApp();ColsChange();">
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
								<td><img src="image/design_tit_e.gif"></td>
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
								<td colspan="2" valign="top" height="25"><img src="image/design_main_icon.gif" width="21" height="11">E 화면 구성</td>
							</tr>
							<tr>
								<td colspan="2">
									<table width="650" border="0" cellspacing="0" cellpadding="0" align='center'>
										<tr>
											<td> <div align="center"><img src="image/design_e_view.gif"></div></td>
											<td> <div align="center"><img src="image/design_e_view1.gif"></div></td>
										</tr>
									</table>
								</td>
							</tr>
							<tr>
								<td colspan="2" height="80">
									<table width="100%" border="1" cellspacing="0" cellpadding="2" align="center" bordercolor="#FFD28E" bordercolordark="#ffffff">
										<tr>
											<td bgcolor="#FFF3E1" align="center" height="40">
												<table width="90%" border="0" cellspacing="0" cellpadding="0" align="center">
													<tr>
														<td height="40"> * 베스트 상품전 타이틀 이미지 등록 </td>
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
								<td colspan="2" valign="top" height="25"><img src="image/design_main_icon.gif" width="21" height="11">베스트 상품전 또는 이벤트. 광고</td>
							</tr>
							<form name="bestForm" method="post" action="design_ok.php?act=design_e"  enctype="multipart/form-data" >
							<tr>
								<td colspan="2" height="50">
									<table width="100%" border="1" cellspacing="0" cellpadding="2" align="center" bordercolor="#FFD28E" bordercolordark="#ffffff">
										<tr>
											<td bgcolor="#FFF3E1" width="100"> <div align="center">적 용</div></td>
											<td> <div align="center"> <input type="radio" name="mainBestApp" value="1" onclick="javascript:showApp();" <?if($design[mainBestApp]==1) echo"checked";?>>가로 X 세로 고정출력</div></td>
											<td> <div align="center"> <input type="radio" name="mainBestApp" value="0" onclick="javascript:showApp();" <?if(!$design[mainBestApp]) echo"checked";?>>HTML </div></td>
											<td> <div align="center"> <input type="radio" name="mainBestApp" value="2" onclick="javascript:showApp();"  <?if($design[mainBestApp]==2) echo"checked";?>>자동 스크롤뷰</div></td>
											<td rowspan="2" align="center"><a href="javascript:bestSendit(2);"><img src="image/design_save_i.gif" width="46" height="18" border="0"></a> </td>
										</tr>
										<tr>
											<td bgcolor="#FFF3E1"> <div align="center">자동스크롤뷰 <br>세부설정</div></td>
											<td> <div align="center"> 높이 <input type="text" class="box" name="mainScrollHeight" value="<?=$design[mainScrollHeight]?>" size=5> px</div></td>
											<td> <div align="center"> 스크롤속도 <input type="text" class="box" name="mainScrollSpeed" value="<?=$design[mainScrollSpeed]?>" size=5> <font class="help">※ 클수록 느림</font></div></td>
											<td> <div align="center"> 머무는시간 <input type="text" class="box" name="mainScrollWait" value="<?=$design[mainScrollWait]?>" size=5> <font class="help"> 초</font></div></td>
										</tr>
										<tr>
											<td colspan=5><font class="help">※ 자동스크롤뷰는 가로출력수 4 <b>(고정)</b><br>※ 자동스크롤뷰는 베스트상품전,히트상품전 중 <b>한곳에만 적용</b> 가능합니다. <br>※ <b>상품정보이미지 사용</b>은 상품등록시에 <b>상품정보이미지</b>를 등록했을때 메인에서만 사용가능합니다.</font></td>
										</tr>
									</table>
								</td>
							</tr>
							<tr id="goodsApp">
								<td colspan="2"><br>
									<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center" >
										<tr>
											<td>
												<table width="100%" border="1" cellspacing="0" cellpadding="0" align="center" bordercolor="#FFD28E" bordercolordark="#ffffff">
													<tr>
														<td bgcolor="#FFF3E1" width=200> <div align="center"><b>베스트 상품전 타이틀 이미지</b></div></td>
													</tr>
													<tr>
														<td height="30" width=300><img src="../upload/design/<?=$design[mainBestGoodsTitle]?>" border="0"></td>
													</tr>
													<tr>
														<td align="center">
															<table width="80%" border="0" cellspacing="0" cellpadding="0">
																<tr>
																	<td> <div align="center"> <input type="file" name="img" size="25" style="BORDER-RIGHT: gray 1px solid; BORDER-TOP: gray  1px solid; FONT-SIZE: 9pt; BORDER-LEFT: gray 1px solid; BORDER-BOTTOM: gray  1px solid; FONT-FAMILY: gulim; HEIGHT: 19px; BACKGROUND-COLOR: white"></div></td>
																	<td><a href="javascript:bestSendit(1);"><img src="image/design_save_i.gif" width="46" height="18" border="0"></a> </td>
																</tr>
															</table>
														</td>
													</tr>
													<tr bgcolor="#FFF3E1">
														<td bgcolor="#FFF3E1"> <div align="center">gif , jpg 사용가능 (최적화 사이즈 720*30) </div></td>
													</tr>
												</table>
											</td>
										</tr>
										<tr>
											<td height="5"></td>
										</tr>
										<tr>
											<td><br>
												<table width="100%" border="1" cellspacing="0" cellpadding="2" align="center" bordercolor="#FFD28E" bordercolordark="#ffffff">
													<tr>
														<td width="200" bgcolor="#FFF3E1"> <div align="center">베스트 상품전 목록 수</div></td>
														<td width="400">
															<table width="100%" border="0" cellspacing="0" cellpadding="0">
																<tr>
																	<td> <div align="center">가로출력수 × 세로 출력수</div></td>
																	<td rowspan="2" width="70"> <div align="center"><a href="javascript:bestSendit(2);"><img src="image/design_save_i.gif" width="46" height="18" border="0"></a></div></td>
																</tr>
																<tr>
																	<td> <div align="center"> <input class="box" type="text" name="mainBestGoodsW" value="<?=$design[mainBestGoodsW]?>" size="10" <?=__ONLY_NUM?>> × <input class="box" type="text" name="mainBestGoodsH" value="<?=$design[mainBestGoodsH]?>" size="10" <?=__ONLY_NUM?>><br>각 행 마다 열 갯수 변경 기능 <input type="checkbox" value="y" name="mainBestColsChange" onclick="ColsChange();" <? if ($design[mainBestColsChange]=="y") echo "checked";?>>사용함<br><font class="help">※ 세로출력수 변경시 <b>일단 저장후</b> 열 변경 <br>※ 본기능 사용시 아래의 <b>이미지 사이즈 적용안됨</b> </font>
																		<table width=100% id="colschange_id" style="display:none;">
																			<tr>
																				<td><?
																				if ($design[mainBestColsChange]=="y")
																				{
																					$cols_arr = explode("/",$design[mainBestColsChangeValue]);
																				}
																				for ($i=1; $i<=$design[mainBestGoodsH]; $i++)
																				{
																					?><?=$i."행"?> <input type="text" name="cols_arr[]" size="2" class="box" value="<?=$cols_arr[$i-1]?>"> 열<br> <?
																				}
																				?></td>
																			</tr>
																		</table>
																	</td>
																</tr>
															</table>
														</td>
													</tr>
													<tr>
														<td width="200" bgcolor="#FFF3E1"> <div align="center">이미지 출력사이즈</div></td>
														<td width="300">
															<table width="100%" border="0" cellspacing="0" cellpadding="0">
																<tr>
																	<td> <div align="center">가로사이즈 × 세로사이즈</div></td>
																	<td rowspan="2" width="70"> <div align="center"><a href="javascript:bestSendit(4);"><img src="image/design_save_i.gif" width="46" height="18" border="0"></a></div></td>
																</tr>
																<tr>
																	<td> <div align="center"> <input class="box" type="text" name="mainBestGoodsIW" value="<?=$design[mainBestGoodsIW]?>" size="10" <?=__ONLY_NUM?>> × <input class="box" type="text" name="mainBestGoodsIH" value="<?=$design[mainBestGoodsIH]?>" size="10" <?=__ONLY_NUM?>></div></td>
																</tr>
															</table>
														</td>
													</tr>
													<tr bgcolor="#FFF3E1">
														<td bgcolor="#FFF3E1" colspan="2"> <div align="center"> 가로출력수는 2 이상 세로 출력수는 1이상의 숫자를 입력해 주십시오. </div></td>
													</tr>
												</table>
											</td>
										</tr>
									</table>
								</td>
							</tr>
							<tr>
								<td colspan="2">&nbsp; </td>
							</tr>
							<tr id="htmlApp">
								<td colspan="2" height="160">
									<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
										<tr>
											<td>
												<table width="500" border="1" cellspacing="0" cellpadding="2" align="center" bordercolor="#FFD28E" bordercolordark="#ffffff">
													<tr>
														<td colspan="2"> <div align="center"> <textarea name="mainBestContent" cols="65" rows="5"><?=$design[mainBestContent]?></textarea></div></td>
													</tr>
												</table>
											</td>
										</tr>
										<tr>
											<td height="30"> <div align="center"><a href="javascript:bestSendit(3);"><img src="image/design_save_i.gif" width="46" height="18" border="0"></a></div></td>
										</tr>
									</table>
								</td>
							</tr>
							</form><!-- bestForm -->
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