<?
include "head.php";
?>
<SCRIPT LANGUAGE="JavaScript">
<!--
function sendit()
{
	var form=document.wForm;
	if(!numCheck(form.goodsListW.value))
	{
		alert("가로 숫자가 올바르지 않습니다.");
		form.goodsListW.focus();
	}
	else if(form.goodsListW.value <1)
	{
		alert("가로 출력수는 0 이상의 수로 입력해 주십시오.");
		form.goodsListW.focus();
	}
	else if(!numCheck(form.goodsListH.value))
	{
		alert("세로 숫자가 올바르지 않습니다.");
		form.goodsListH.focus();
	}
	else if(form.goodsListH.value <1)
	{
		alert("세로 출력수는 1 이상의 수로 입력해 주십시오.");
		form.goodsListH.focus();
	}
	else
	{
		form.submit();
	}
}

function designType_select(val)
{
	var form = document.wForm;
	if (val==3) //혼합 
	{
		form.goodsListW.value = 2;
		form.goodsListW.readOnly = true; 
		form.goodsListW.style.backgroundColor = "#eeeeee";
	}
	else if (val==2) // 게시판 
	{
		form.goodsListW.value = 1;
		form.goodsListW.readOnly = true; 
		form.goodsListW.style.backgroundColor = "#eeeeee";
	}
	else
	{
		form.goodsListW.readOnly = false; 
		form.goodsListW.style.backgroundColor = "#ffffff";
	}
}
//-->
</SCRIPT>
<body bgcolor="#FFFFFF" text="#5A595A" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onload="designType_select(<?=$design_goods[designType]?>);">
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
								<td><img src="image/design_tit_a.gif"></td>
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
							<? include "good_design_menu.php";?>
							<tr>
								<td colspan="2">&nbsp;</td>
							</tr>
							<tr>
								<td colspan="2" height="25" valign="top"> <p><img src="image/design_main_icon.gif" width="21" height="11">A 화면 구성</p></td>
							</tr>
							<tr>
								<td colspan="2">
									<table width="100%" border="0" cellspacing="0" cellpadding="0" >
										<tr>
											<td width="170"> <div align="center">바둑판식 배열<br><img src="image/design_g_a_view.gif"> </div></td>
											<td width="170"><div align="center">게시판식 배열<br><img src="image/design_g_a_view3.gif"> </div></td>
											<td width="170"><div align="center">혼합식 배열<br><img src="image/design_g_a_view4.gif"> </div></td>
										</tr>
									</table>
								</td>
							</tr>
							<tr>
								<td colspan="2" height="60">
									<table width="100%" border="1" cellspacing="0" cellpadding="10" align="center" bordercolor="#FFD28E" bordercolordark="#ffffff" height="50">
										<tr>
											<td bgcolor="#FFF3E1">* 상품 진열방식 적용 여부 - 카테고리 개별적용 또는 모든 카테고리 일괄적용 <br>* 상품 진열방식 - 일반적인 바둑판식배열과 게시판식 배열 <br>* 상품 리스트- 보여주고자 하는 상품의 개수를 정할수 있음<br></td>
										</tr>
									</table>
								</td>
							</tr>
							<form name="wForm" method="post" action="design_goods_ok.php?act=design_good_a&part=1">
							<tr>
								<td colspan="2" height="40"> <img src="image/design_main_icon.gif" width="21" height="11">상품 진열방식 </td>
							</tr>
							<tr>
								<td colspan="2">
									<table width="100%" border="1" cellspacing="0" cellpadding="2" align="center" bordercolor="#FFD28E" bordercolordark="#ffffff">
										<tr>
											<td width="200" bgcolor="#FFF3E1"> <div align="center">상품 진열방식 설정</div></td>
											<td width="400">
												<table width="100%" border="0" cellspacing="0" cellpadding="0">
													<tr>
														<td width="70"> <div align="center"></div></td>
													</tr>
													<tr>
														<td> <div align="center"> <input type="radio" name="designTypeCommon" value="y" <? if ($design_goods[designTypeCommon]=="y") echo "checked";?>>일괄적용 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="designTypeCommon" value="n" <? if ($design_goods[designTypeCommon]=="n") echo "checked";?>>개별적용</div></td>
													</tr>
												</table>
											</td>
										</tr>
										<tr>
											<td width="200" bgcolor="#FFF3E1"> <div align="center">상품 진열방식</div></td>
											<td width="400">
												<table width="100%" border="0" cellspacing="0" cellpadding="0">
													<tr>
														<td width="70"> <div align="center"></div></td>
													</tr>
													<tr>
														<td> <div align="center"> <input type="radio" name="designType" value="1" <? if ($design_goods[designType]==1) echo "checked";?> onclick="designType_select(this.value);">바둑판식 배열 &nbsp;&nbsp;<input type="radio" name="designType" value="2" <? if ($design_goods[designType]==2) echo "checked";?> onclick="designType_select(this.value);">게시판식 배열 &nbsp;&nbsp;<input type="radio" name="designType" value="3" <? if ($design_goods[designType]==3) echo "checked";?> onclick="designType_select(this.value);">혼합식 배열 </div></td>
													</tr>
												</table>
											</td>
										</tr>
									</table>
								</td>
							</tr>
							<tr>
								<td colspan="2" height="40"> <img src="image/design_main_icon.gif" width="21" height="11">상품 리스트 개수</td>
							</tr>
							<tr>
								<td colspan="2">
									<table width="100%" border="1" cellspacing="0" cellpadding="2" align="center" bordercolor="#FFD28E" bordercolordark="#ffffff">
										<tr>
											<td width="200" bgcolor="#FFF3E1"> <div align="center">상품 목록 수</div></td>
											<td width="300">
												<table width="100%" border="0" cellspacing="0" cellpadding="0">
													<tr>
														<td> <div align="center">가로출력수 x 세로출력수</div></td>
													</tr>
													<tr>
														<td> <div align="center"> <input type="text" name="goodsListW" class="box" size="10" value="<?=$design_goods[goodsListW]?>"> x <input type="text" name="goodsListH" class="box" size="10" value="<?=$design_goods[goodsListH]?>"></div></td>
													</tr>
												</table>
											</td>
										</tr>
									</table>
								</td>
							</tr>
							<tr>
								<td colspan="2">
									<table width="100%" border="1" cellspacing="0" cellpadding="2" align="center" bordercolor="#FFD28E" bordercolordark="#ffffff">
										<tr>
											<td width="200" bgcolor="#FFF3E1"> <div align="center">상품 목록 이미지 사이즈</div></td>
											<td width="300">
												<table width="100%" border="0" cellspacing="0" cellpadding="0">
													<tr>
														<td> <div align="center">가로사이즈 x 세로사이즈</div></td>
													</tr>
													<tr>
														<td> <div align="center"> <input type="text" name="goodsListIW" class="box" size="10" value="<?=$design_goods[goodsListIW]?>"> x <input type="text" name="goodsListIH" class="box" size="10" value="<?=$design_goods[goodsListIH]?>"></div></td>
													</tr>
												</table>
											</td>
										</tr>
									</table>
								</td>
							</tr>
							<tr>
								<td colspan="2">
									<table width="100%" border="1" cellspacing="0" cellpadding="2" align="center" bordercolor="#FFD28E" bordercolordark="#ffffff">
										<tr>
											<td width="200" bgcolor="#FFF3E1"> <div align="center">베스트(대) 이미지 사이즈</div></td>
											<td width="300">
												<table width="100%" border="0" cellspacing="0" cellpadding="0">
													<tr>
														<td> <div align="center">가로사이즈 x 세로사이즈</div></td>
													</tr>
													<tr>
														<td> <div align="center"> <input type="text" name="goodsListIW1" class="box" size="10" value="<?=$design_goods[goodsListIW1]?>"> x <input type="text" name="goodsListIH1" class="box" size="10" value="<?=$design_goods[goodsListIH1]?>"></div></td>
													</tr>
												</table>
											</td>
										</tr>
									</table>
								</td>
							</tr>
							<tr>
								<td colspan="2">
									<table width="100%" border="1" cellspacing="0" cellpadding="2" align="center" bordercolor="#FFD28E" bordercolordark="#ffffff">
										<tr>
											<td width="200" bgcolor="#FFF3E1"> <div align="center">베스트 이미지 사이즈</div></td>
											<td width="300">
												<table width="100%" border="0" cellspacing="0" cellpadding="0">
													<tr>
														<td> <div align="center">가로사이즈 x 세로사이즈</div></td>
													</tr>
													<tr>
														<td> <div align="center"> <input type="text" name="goodsListIW2" class="box" size="10" value="<?=$design_goods[goodsListIW2]?>"> x <input type="text" name="goodsListIH2" class="box" size="10" value="<?=$design_goods[goodsListIH2]?>"></div></td>
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
								<td colspan="2" align="center" height="30"><a href="javascript:sendit();"><img src="image/design_save_i.gif" width="46" height="18" border="0"></a></td>
							</tr>
							</form>
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