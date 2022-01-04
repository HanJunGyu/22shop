<?
include "head.php";
?>
<SCRIPT LANGUAGE="JavaScript">
<!--
function etcSendit()
{
	document.adm_etcForm.submit();
}

function price_change()
{
	if (confirm("가격을 변경하시겠습니까?"))
	{
		if (document.priceForm.perc.value=="")
		{
			alert("퍼센트 값을 입력해주세요.");
		}
		else
		{
		document.priceForm.submit();
		}
	}
}
//-->
</SCRIPT>
<body bgcolor="#FFFFFF" text="#5A595A" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<object id="dlgHelper" classid="clsid:3050f819-98b5-11cf-bb82-00aa00bdce0b" width="0px" height="0px"></object>
<? include "top_menu.php"; ?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr><?
	$__TOP_MENU = "goods";     //왼쪽 소메뉴 설정 변수
	include "left_menu.php";
	if(!defined(__ADMIN_ROW))
	{
		define(__ADMIN_ROW,"TRUE");
		$admin_row=$MySQL->fetch_array("select *from admin limit 0,1"); //관리자 정보 배열
	}
	if($admin_row[bGoodsapp] =="y")
	{
		$true_bGoodsapp = "checked";
		$false_bGoodsapp= "";
	}
	else
	{
		$true_bGoodsapp = "";
		$false_bGoodsapp= "checked";
	}
	if($admin_row[beditprice_warn]=="y")
	{
		$true_beditprice_warn = "checked";
		$false_beditprice_warn= "";
	}
	else
	{
		$true_beditprice_warn = "";
		$false_beditprice_warn= "checked";
	}
	if($admin_row[bAskboard] =="y")
	{
		$true_bAskboard = "checked";
		$false_bAskboard= "";
	}
	else
	{
		$true_bAskboard = "";
		$false_bAskboard= "checked";
	}
	if($admin_row[bHit])	$bHit = "checked";
	else					$bHit = "";
	if($admin_row[bNew])	$bNew = "checked";
	else					$bNew = "";
	if($admin_row[bEtc])	$bEtc = "checked";
	else					$bEtc = "";
	?>
		<td width="85%" valign="top">
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td height='5'></td>
				</tr>
				<tr>
					<td>
						<table width="750" border="0" cellspacing="0" cellpadding="0" align='center'>
							<tr>
								<td rowspan="3" width="200"><img src="image/good_tit_img.gif"></td>
								<td>&nbsp;</td>
							</tr>
							<tr>
								<td bgcolor="#E6E6E6" height='26'><div align='right'><font class='text1'>SHOP 상품정보를 수정하실수 있습니다.&nbsp;</div></td>
							</tr>
							<tr>
								<td>&nbsp;</td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td>
						<form name="adm_etcForm" method="post" action="goods_manage_ok.php" enctype="multipart/form-data" >
						<table width="750" border="0" cellspacing="0" cellpadding="0" align="center" height="500">
							<tr>
								<td colspan="2">
									<table width="750" border="0" cellspacing="0" cellpadding="0" align="center">
										<tr>
											<td height='1' colspan='3' bgcolor='DADADA'></td>
										</tr>
										<tr>
											<td width='440'><img src="image/good_manager.gif"></td>
										</tr>
										<tr>
											<td height='1' colspan='3' bgcolor='DADADA'></td>
										</tr>
										<tr>
											<td height='20' colspan='3'><font class="help">※ 이미지 업로드후 변동사항이 없을경우 <b>페이지 새로고침</b>을 해주세요. </font></td>
										</tr>
									</table>
								</td>
							</tr>
							<tr>
								<td height='5' colspan="2"></td>
							</tr>
							<tr>
								<td width="201" height="25" bgcolor="#FAFAFA">&nbsp;&nbsp;<img src="image/icon.gif" width="11" height="11"> 상품평 사용여부</td>
								<td width="549" height="25">
									<table width="450" border="0" cellspacing="0" cellpadding="0" align="center">
										<tr>
											<td width="10%"> <div align="center"> <input type="radio" name="bGoodsapp" value="y" <?=$true_bGoodsapp?>></div></td>
											<td width="25%"> <div align="left">사용함</div></td>
											<td width="10%"> <div align="center"> <input type="radio" name="bGoodsapp" value="n" <?=$false_bGoodsapp?>></div></td>
											<td width="25%"> <div align="left">사용하지 않음</div></td>
										</tr>
									</table>
								</td>
							</tr>
							<tr>
								<td colspan="2" height="1" background="image/line_bg1.gif"></td>
							</tr>
							<tr>
								<td width="201" height="25" bgcolor="#FAFAFA">&nbsp;&nbsp;<img src="image/icon.gif" width="11" height="11"> 상품질문 사용여부</td>
								<td width="549" height="25">
									<table width="450" border="0" cellspacing="0" cellpadding="0" align="center">
										<tr>
											<td width="10%"> <div align="center"> <input type="radio" name="bAskboard" value="y" <?=$true_bAskboard?>></div></td>
											<td width="25%"> <div align="left">사용함</div></td>
											<td width="10%"> <div align="center"> <input type="radio" name="bAskboard" value="n" <?=$false_bAskboard?>></div></td>
											<td width="25%"> <div align="left">사용하지 않음</div></td>
										</tr>
									</table>
								</td>
							</tr>
							<tr>
								<td colspan="2" height="1" background="image/line_bg1.gif"></td>
							</tr>
							<tr>
								<td width="201" height="25" bgcolor="#FAFAFA">&nbsp;&nbsp;<img src="image/icon.gif" width="11" height="11"> 상품목록상에서 판매가 수정시<br> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;경고메세지창 설정</td>
								<td width="549" height="25">
									<table width="549" border="0" cellspacing="0" cellpadding="0">
										<tr>
											<td width="549" height=50>&nbsp; &nbsp;<input type="radio" name="beditprice_warn" value="y" <?=$true_beditprice_warn?>>기능 설정함&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="beditprice_warn" value="n" <?=$false_beditprice_warn?>>기능 설정안함&nbsp;&nbsp;&nbsp;&nbsp;<br>&nbsp;&nbsp;관리자가 판매가 수정시 이전가와 <input class="box" type="text" name="editprice_warn" value="<?=$admin_row[editprice_warn]?>" size=8 <?__ONLY_NUM?>> 원 이상 차이날때 경고메시지 출력 &nbsp;</font></td>
										</tr>
									</table>
								</td>
							</tr>
							<tr>
								<td colspan="2" height="1" background="image/line_bg1.gif"></td>
							</tr>
							<tr>
								<td width="201" height="25" bgcolor="#FAFAFA">&nbsp;&nbsp;<img src="image/icon.gif" width="11" height="11"> NEW 이미지 사용</td>
								<td width="549" height="25">
									<table width="450" border="0" cellspacing="0" cellpadding="0">
										<tr>
											<td width="20"></td>
											<td><img src="../upload/goods_new_img"></td>
											<td> 사용함 <input type="checkbox" name="bNew" value="1" <?=$bNew?>></td>
											<td><input class="box" type="file" name="goodsNewImg"></td>
										</tr>
										<tr>
											<td colspan=4>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>새로운 상품등록</b>시 본 이미지를 <input style="background-color:#FCFBB9" type="text" class="box" name="new_day" size=3 value="<?=$admin_row[new_day]?>"> 일간 화면에 <b>자동출력</b></td>
										</tr>
									</table>
								</td>
							</tr>
							<tr>
								<td colspan="2" height="1" background="image/line_bg1.gif"></td>
							</tr>
							<tr>
								<td width="201" height="25" bgcolor="#FAFAFA"  >&nbsp;&nbsp;<img src="image/icon.gif" width="11" height="11"> 기타 이미지 사용</td>
								<td width="549" height="25">
									<table width="450" border="0" cellspacing="0" cellpadding="0">
										<tr>
											<td width="20"></td>
											<td><img src="../upload/goods_etc_img"></td>
											<td>사용함 <input type="checkbox" name="bEtc" value="1" <?=$bEtc?>></td>
											<td><input class="box" type="file" name="goodsEtcImg"></td>
										</tr>
									</table>
								</td>
							</tr>
							<tr>
								<td colspan="2" height="1" background="image/line_bg1.gif"></td>
							</tr>
							<tr>
								<td width="201" height="25" bgcolor="#FAFAFA">&nbsp;&nbsp;<img src="image/icon.gif" width="11" height="11"> HIT 이미지 </td>
								<td width="549" height="25">
									<table width="450" border="0" cellspacing="0" cellpadding="0">
										<tr>
											<td width="20"></td>
											<td width=30><img src="../upload/goods_hit_img" ></td>
											<td width="300"><input class="box" type="file" name="goodsHitImg"></td>
										</tr>
									</table>
								</td>
							</tr>
							<tr>
								<td colspan="2" height="1" background="image/line_bg1.gif"></td>
							</tr>
							<tr>
								<td width="201" height="25" bgcolor="#FAFAFA">&nbsp;&nbsp;<img src="image/icon.gif" width="11" height="11"> 판매가 이미지</td>
								<td width="549" height="25">
									<table width="450" border="0" cellspacing="0" cellpadding="0">
										<tr>
											<td width="20"></td>
											<td width=30><img src="../upload/goods_price_img"></td>
											<td width="300"><input class="box" type="file" name="goods_price_img"></td>
										</tr>
									</table>
								</td>
							</tr>
							<tr>
								<td colspan="2" height="1" background="image/line_bg1.gif"></td>
							</tr>
							<tr>
								<td width="201" height="25" bgcolor="#FAFAFA">&nbsp;&nbsp;<img src="image/icon.gif" width="11" height="11"> 적립금 이미지</td>
								<td width="549" height="25">
									<table width="450" border="0" cellspacing="0" cellpadding="0">
										<tr>
											<td width="20"></td>
											<td width=30><img src="../upload/goods_point_img"></td>
											<td width="300"><input class="box" type="file" name="goodsPointImg"></td>
										</tr>
									</table>
								</td>
							</tr>
							<tr>
								<td colspan="2" height="1" background="image/line_bg1.gif"></td>
							</tr>
							<tr>
								<td width="201" height="25" bgcolor="#FAFAFA">&nbsp;&nbsp;<img src="image/icon.gif" width="11" height="11"> 확대보기</td>
								<td width="549" height="25">
									<table width="450" border="0" cellspacing="0" cellpadding="0">
										<tr>
											<td width="20"></td>
											<td width=30><img src="../upload/goods_view_img"></td>
											<td width="300"><input class="box" type="file" name="goods_view_img"></td>
										</tr>
									</table>
								</td>
							</tr>
							<tr>
								<td colspan="2" height="1" background="image/line_bg1.gif"></td>
							</tr>
							<tr>
								<td width="201" height="25" bgcolor="#FAFAFA">&nbsp;&nbsp;<img src="image/icon.gif" width="11" height="11"> 품절표시</td>
								<td width="549" height="25">
									<table width="450" border="0" cellspacing="0" cellpadding="0">
										<tr>
											<td width="20"></td>
											<td width=30><img src="../upload/no_good_img"></td>
											<td width="300"><input class="box" type="file" name="no_good_img"></td>
										</tr>
									</table>
								</td>
							</tr>
							<tr>
								<td colspan="2" height="1" background="image/line_bg1.gif"></td>
							</tr>
							<tr>
								<td width="201" height="25" bgcolor="#FAFAFA">&nbsp;&nbsp;<img src="image/icon.gif" width="11" height="11"> 카테고리 베스트상품</td>
								<td width="549" height="25">
									<table width="450" border="0" cellspacing="0" cellpadding="0">
										<tr>
											<td width="20"></td>
											<td width=30><img src="../upload/catebest_img"></td>
											<td width="300"><input class="box" type="file" name="catebest_img"></td>
										</tr>
									</table>
								</td>
							</tr>
							<tr>
								<td colspan="2" height="1" background="image/line_bg1.gif"></td>
							</tr>
							<tr>
								<td width="201" height="25" bgcolor="#FAFAFA">&nbsp;&nbsp;<img src="image/icon.gif" width="11" height="11"> 상품목록 폰트설정</td>
								<td width="549" height="25">
									<table width="100%" border="1" cellspacing="0" cellpadding="3" class="table_coll">
										<tr align="center">
											<td><input type="checkbox" name="bGoodsList_1" value="1" <? if ($design_goods[bGoodsList_1]==1) echo "checked";?>> 화면노출</td>
											<td valign="middle">샘플사진</td>
											<td><img src="../image/goodsample.jpg" width="100" height="100"></td>
											<td colspan="2"></td>
										</tr>
										<tr align="center">
											<td><input type="checkbox" name="bGoodsList_2" value="1" <? if ($design_goods[bGoodsList_2]==1) echo "checked";?>> 화면노출</td>
											<td>상품명</td>
											<td><font color="<?=$design_goods[gname_color]?>" id="text_no_font_color1">리바이스 자켓</font></td>
											<td>
												<table id="no_font_color1" onClick="setColor('', 'bg',this.id);"  class="square" bgcolor="<?=$design_goods[gname_color]?>" style="cursor:pointer" width="40" border="1" cellspacing="0" cellpadding="0" height="20" >
													<tr>
														<td  align="center"></td>
													</tr>
												</table>
											</td>
											<td>&nbsp;RGB 코드 <input class="box" name="t_no_font_color1" type="text" id="t_no_font_color1"  value="<?= $design_goods[gname_color]?>" size="8"> </td>
										</tr>
										<tr align="center">
											<td><input type="checkbox" name="bGoodsList_4" value="1" <? if ($design_goods[bGoodsList_4]==1) echo "checked";?>> 화면노출</td>
											<td>판매가</td>
											<td><font color="<?=$design_goods[gprice_color]?>" id="text_no_font_color2">57,000 원</font></td>
											<td>
												<table style="cursor:pointer" align="center" id="no_font_color2" onClick="setColor('', 'bg',this.id);" class="square" bgcolor="<?=$design_goods[gprice_color]?>" width="40" border="1" cellspacing="0" cellpadding="0" height="20">
													<tr>
														<td ></td>
													</tr>
												</table>
											</td>
											<td>&nbsp;RGB 코드 <input class="box" name="t_no_font_color2" type="text" id="t_no_font_color2" onChange="setChangedColor(this);no_font2.color=this.value;" value="<?= $design_goods[gprice_color]?>" size="8"> </td>
										</tr>
										<tr align="center">
											<td><input type="checkbox" name="bGoodsList_5" value="1" <? if ($design_goods[bGoodsList_5]==1) echo "checked";?>> 화면노출</td>
											<td>적립금</td>
											<td><font color="<?=$design_goods[gpoint_color]?>" id="text_no_font_color3">570 원</font></td>
											<td>
												<table style="cursor:pointer" align="center" id="no_font_color3" onClick="setColor('', 'bg',this.id);" class="square" bgcolor="<?=$design_goods[gpoint_color]?>" width="40" border="1" cellspacing="0" cellpadding="0" height="20">
													<tr>
														<td ></td>
													</tr>
												</table>
											</td>
											<td>&nbsp;RGB 코드 <input class="box" name="t_no_font_color3" type="text" id="t_no_font_color3" onChange="setChangedColor(this);no_font3.color=this.value;" value="<?= $design_goods[gpoint_color]?>" size="8"> </td>
										</tr>
									</table>
								</td>
							</tr>
							<tr>
								<td colspan="2" height="1" background="image/line_bg1.gif"></td>
							</tr>
							<tr>
								<td width="201" height="25" bgcolor="#FAFAFA">&nbsp;&nbsp;<img src="image/icon.gif" width="11" height="11"> 워터마크 이미지</td>
								<td width="549" height="25">
									<table width="450" border="0" cellspacing="0" cellpadding="0">
										<tr>
											<td width="20"></td>
											<td><img src="../upload/watermark_img"></td>
										</tr>
										<tr>
											<td colspan=2>&nbsp;&nbsp;<input class="box" type="file" name="watermark_img"><font class="help">&nbsp;(JPG 권장)<br>&nbsp;※ GD 설치된 호스팅에서만 사용가능. 상품이미지에 <b>상품등록,수정시</b> 자동삽입</font><br>&nbsp;▶상품이미지상의 워터마크 삽입 위치&nbsp;&nbsp;<select name="wm_pos"><?
											for ($i=0; $i<9; $i++)
											{
												?><option value="<?=$i?>" <? if ($i==$admin_row[wm_pos]) echo "selected";?>><?=$i?></option><?
											}
											?></select><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img src="./image/wm_pos.jpg"></td>
										</tr>
									</table>
								</td>
							</tr>
							<tr>
								<td colspan="2" height="1" background="image/line_bg1.gif"></td>
							</tr>
							<tr>
								<td width="201" height="25" bgcolor="#FAFAFA">&nbsp;&nbsp;<img src="image/icon.gif" width="11" height="11"> 상품이미지 자동압축 사이즈</td>
								<td width="549" height="25">
									<table width="450" border="0" cellspacing="0" cellpadding="0">
										<tr>
											<td width="20"></td>
											<td width="300">작은이미지 사이즈 가로 <input class="box" type="text" name="gdimg1_width" size="5" value="<?=$design_goods[gdimg1_width]?>"> px &nbsp;&nbsp;세로 <input class="box" type="text" name="gdimg1_height" size="5" value="<?=$design_goods[gdimg1_height]?>"> px <br>중간이미지 사이즈 가로 <input class="box" type="text" name="gdimg2_width" size="5" value="<?=$design_goods[gdimg2_width]?>"> px &nbsp;&nbsp;세로 <input class="box" type="text" name="gdimg2_height" size="5" value="<?=$design_goods[gdimg2_height]?>"> px </td>
										</tr>
									</table>
								</td>
							</tr>
							<tr>
								<td colspan="2" height="1" background="image/line_bg1.gif"></td>
							</tr>
							<tr>
								<td colspan="2" height="40" valign="middle">
									<table width="50%" border="0" align="center" cellpadding="0" cellspacing="0">
										<tr>
											<td><div align="center"><a href="javascript:etcSendit();"><img src="image/save_btn.gif" width="40" height="17" border="0"></a></div></td>
											<td><div align="center"><a href="javascript:formClear(document.adm_etcForm);"><img src="image/cancel_btn.gif" width="40" height="17" border="0"></a></div></td>
										</tr>
									</table>
								</td>
							</tr>
							</form><!-- adm_etcForm -->
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