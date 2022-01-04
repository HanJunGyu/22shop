<?
include "head.php";
$cate_row = $MySQL->fetch_array("select *from category where code='$parentcode' limit 1");
$str_category = "<b>".$cate_row[name]."</b>";
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
//사이트경로,상품코드 활성/비활성
function showSiteUrl(Obj)
{
	if(Obj.gubun[0].checked)
	{
		showObject(Obj.siteUrl,true);
		showObject(Obj.goodsUrl,false);
	}
	else if(Obj.gubun[1].checked)
	{
		showObject(Obj.siteUrl,false);
		showObject(Obj.goodsUrl,true);
	}
	else
	{
		showObject(Obj.siteUrl,false);
		showObject(Obj.goodsUrl,false);
	}
}
//정보 전송
function bannerwriteSendit(Obj)
{
	if(Obj.gubun[0].checked && Obj.siteUrl.value=="")
	{
		alert("사이트 경로를 입력해 주십시오.");
		Obj.siteUrl.focus();
	}
	else if(Obj.gubun[1].checked &&Obj.goodsUrl.value=="")
	{
		alert("상품 배너입니다. 상품을 선택해 주십시오.");
	}
	else if(Obj.img.value=="")
	{
		alert("이미지를 선택해 주십시오.");
	}
	else
	{
		Obj.siteUrl_str.value = Obj.siteUrl.value;
		Obj.goodsUrl_str.value = Obj.goodsUrl.value;
		Obj.submit();
	}
}
//정보 전송
function bannerSendit(Obj,Url)
{
	if(Obj.gubun[0].checked && Obj.siteUrl.value=="")
	{
		alert("사이트 경로를 입력해 주십시오.");
		Obj.siteUrl.focus();
	}
	else if(Obj.gubun[1].checked &&Obj.goodsUrl.value=="")
	{
		alert("상품 배너입니다. 상품을 선택해 주십시오.");
	}
	else
	{
		Obj.siteUrl_str.value = Obj.siteUrl.value;
		Obj.goodsUrl_str.value = Obj.goodsUrl.value;
		Obj.action +=Url;
		Obj.submit();
	}
}
//-->
</SCRIPT>
<body bgcolor="#FFFFFF" text="#5A595A" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onload="designType_select(<?=$cate_row[designType]?>);">
<? include "top_menu.php"; ?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr><?
	$__TOP_MENU = "category";     //왼쪽 소메뉴 설정 변수
	include "left_menu.php";
	?>
		<td width="85%" valign="top">
			<table width="100%" height="500" border="0" cellspacing="0" cellpadding="0" height="560">
				<tr>
					<td height='5'></td>
				</tr>
				<tr>
					<td>
						<table width="750" border="0" cellspacing="0" cellpadding="0" align='center'>
							<tr>
								<td rowspan="3" width="200"><img src="image/cate_tit.gif"></td>
								<td>&nbsp;</td>
							</tr>
							<tr>
								<td bgcolor="#E6E6E6" height='26'><div align='right'><font class='text1'>SHOP 카테고리 수정 삭제 등록 등을 하실수 있습니다.&nbsp;</font></div></td>
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
								<td width='1' bgcolor='dadada' colspan='3'></td>
							</tr>
							<tr>
								<td width='440'><img src="image/cate_design_tit2.gif"></td>
							</tr>
							<tr>
								<td width='1' bgcolor='dadada' colspan='3'></td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
				</tr>
				<tr>
					<td valign="top">
						<table width="750" border="0" cellspacing="0" cellpadding="0" align="center" >
							<tr>
								<td colspan="2" height="40">▶ <?=$str_category."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img src='image/prepage.gif' align='absmiddle' onclick='history.go(-1);' style='cursor:pointer'>"?> </td>
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
											<td bgcolor="#FFF3E1">* 상품 리스트- 보여주고자 하는 상품의 개수,사이즈를 정할수 있음<br>* 상품 진열방식 - 일반적인 바둑판식배열과 게시판식 배열 <br>* 상품목록 좌측 베너 <br>* 상품목록 중앙 베너<br>* 상품목록 신상품 등록 바로가기 </td>
										</tr>
									</table>
								</td>
							</tr>
							<form name="wForm" method="post" action="category_design_ok.php?part=1">
							<input type="hidden" name="parentcode" value="<?=$parentcode?>">
							<tr>
								<td colspan="2" height="40"> <img src="image/design_main_icon.gif" width="21" height="11">상품 진열방식 </td>
							</tr>
							<tr>
								<td colspan="2">
									<table width="100%" border="1" cellspacing="0" cellpadding="2" align="center" bordercolor="#FFD28E" bordercolordark="#ffffff">
										<tr>
											<td width="200" bgcolor="#FFF3E1"> <div align="center">상품 진열방식</div></td>
											<td width="400">
												<table width="100%" border="0" cellspacing="0" cellpadding="0">
													<tr>
														<td width="70"><div align="center"></div></td>
													</tr>
													<tr>
														<td> <div align="center"> <input type="radio" name="designType" value="1" <? if ($cate_row[designType]==1 || $cate_row[designType]== 0) echo "checked";?> onclick="designType_select(this.value);">바둑판식 배열 &nbsp;&nbsp;<input type="radio" name="designType" value="2" <? if ($cate_row[designType]==2) echo "checked";?> onclick="designType_select(this.value);">게시판식 배열 &nbsp;&nbsp;<input type="radio" name="designType" value="3" <? if ($cate_row[designType]==3) echo "checked";?> onclick="designType_select(this.value);">혼합식 배열 </div></td>
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
														<td> <div align="center"> <input type="text" name="goodsListW" class="box" size="10" value="<?=$cate_row[goodsListW]?>"> x <input type="text" name="goodsListH" class="box" size="10" value="<?=$cate_row[goodsListH]?>"></div></td>
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
														<td> <div align="center"> <input type="text" name="goodsListIW" class="box" size="10" value="<?=$cate_row[goodsListIW]?>"> x <input type="text" name="goodsListIH" class="box" size="10" value="<?=$cate_row[goodsListIH]?>"></div></td>
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
														<td> <div align="center"> <input type="text" name="goodsListIW1" class="box" size="10" value="<?=$cate_row[goodsListIW1]?>"> x <input type="text" name="goodsListIH1" class="box" size="10" value="<?=$cate_row[goodsListIH1]?>"></div></td>
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
														<td> <div align="center"> <input type="text" name="goodsListIW2" class="box" size="10" value="<?=$cate_row[goodsListIW2]?>"> x <input type="text" name="goodsListIH2" class="box" size="10" value="<?=$cate_row[goodsListIH2]?>"></div></td>
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
							<tr>
								<td colspan="2">&nbsp;</td>
							</tr>
							<tr>
								<td colspan="2" valign="top" height="35"><br><img src="image/design_main_icon.gif" width="21" height="11"><a href="goods_position.php?part=new&category=<?=$parentcode?>">상품목록 페이지 <b>왼쪽 신상품</b> 등록메뉴 바로가기 </a></td>
							</tr>
							<tr>
								<td colspan="2">&nbsp;</td>
							</tr>
							<tr>
								<td colspan="2" valign="top" height="35"><br><img src="image/design_main_icon.gif" width="21" height="11">상품목록 페이지 <b>왼쪽</b> 베너목록</td>
							</tr><?
							$ban_qry = "select *from banner where position ='$parentcode' order by sunwi asc";
							$ban_result = @$MySQL->query($ban_qry);
							$ban_cnt =0;
							while($ban_row = mysql_fetch_array($ban_result))
							{
								$ban_cnt ++;
								if($ban_row[gubun]==0)
								{
									$site_color = "white";
									$goods_color = "#dddddd";
									$site_disabled = "";
									$goods_disabled = "disabled";
								}
								else if($ban_row[gubun]==1)
								{
									$site_color = "#dddddd";
									$goods_color = "white";
									$site_disabled = "disabled";
									$goods_disabled = "";
								}
								else
								{
									$site_color = "#dddddd";
									$goods_color = "#dddddd";
									$site_disabled = "disabled";
									$goods_disabled = "disabled";
								}
								?>
							<form name="bannerForm3<?=$ban_cnt?>" method="post" action="category_design_ok.php?part=2"  enctype="multipart/form-data" >
							<input type="hidden" name="siteUrl_str">
							<input type="hidden" name="goodsUrl_str">
							<input type="hidden" name="bannerIdx" value="<?=$ban_row[idx]?>">
							<input type="hidden" name="parentcode" value="<?=$parentcode?>">
							<tr>
								<td colspan="2" height="70">
									<table width="100%" border="1" cellspacing="0" cellpadding="2" align="center" bordercolor="#FFD28E" bordercolordark="#ffffff">
										<tr>
											<td width	="180"><?
											if($ban_row[type]==4)
											{
												$img = "../upload/design/$ban_row[img]";
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
												?><div align="center"><img src="../upload/design/<?=$ban_row[img]?>"></div><?
											}
											?></td>
											<td width="350">
												<table width="100%" border="0" cellspacing="0" cellpadding="0">
													<tr>
														<td width="33%" height="25"> <div align="center"> <input class="radio" type="radio" name="gubun" value="0" <?if($ban_row[gubun]==0)echo"checked";?> onClick="javascript:showSiteUrl(document.bannerForm3<?=$ban_cnt?>);">사이트 URL</div></td>
														<td height="33%"> <div align="center"> <input class="radio" type="radio" name="gubun" value="1" <?if($ban_row[gubun]==1)echo"checked";?> onClick="javascript:showSiteUrl(document.bannerForm3<?=$ban_cnt?>);">상품 URL</div></td>
														<td width="33%" height="25"> <div align="center"> <input class="radio" type="radio" name="gubun" value="2" <?if($ban_row[gubun]==2)echo"checked";?> onClick="javascript:showSiteUrl(document.bannerForm3<?=$ban_cnt?>);">Not URL</div></td>
													</tr>
													<tr>
														<td colspan="3">
															<table width="100%" border="0" cellspacing="0" cellpadding="0">
																<tr>
																	<td > <div align="center">http:// <input type="text" name="siteUrl" value="<?=$ban_row[siteUrl]?>"  size="20" style="BORDER-RIGHT: gray 1px solid; BORDER-TOP: gray  1px solid; FONT-SIZE: 9pt; BORDER-LEFT: gray 1px solid; BORDER-BOTTOM: gray  1px solid; FONT-FAMILY: gulim; HEIGHT: 19px; BACKGROUND-COLOR: <?=$site_color?>" <?=$site_disabled?>><br><input type="radio" name="siteTarget" value="_parent" <? if ($ban_row[siteTarget] == "_parent") echo "checked";?>>현재창 <input type="radio" name="siteTarget" value="_blank" <? if ($ban_row[siteTarget] == "_blank") echo "checked";?>>새창 <br>&nbsp;&nbsp;&nbsp;<b>화면출력 우선순위</b> <input class="box" type="text" name="sunwi" value="<?=$ban_row[sunwi]?>" size=2> 예) 1~10 </div></td>
																	<td rowspan="2" width="60"> <div align="center"><a href="javascript:bannerSendit(document.bannerForm3<?=$ban_cnt?>,'&edit=1');"><img src="image/design_save_i.gif" width="46" height="18" border="0"></a> <a href="javascript:bannerSendit(document.bannerForm3<?=$ban_cnt?>,'&del=1');"><img src="image/design_delete.gif" width="46" height="18" border="0"></a></div></td>
																</tr>
																<tr>
																	<td > <div align="center"> <input type="text" name="goodsUrl" value="<?=$ban_row[goodsUrl]?>" readonly size="18" style="BORDER-RIGHT: gray 1px solid; BORDER-TOP: gray  1px solid; FONT-SIZE: 9pt; BORDER-LEFT: gray 1px solid; BORDER-BOTTOM: gray  1px solid; FONT-FAMILY: gulim; HEIGHT: 19px; BACKGROUND-COLOR: <?=$goods_color?>" <?=$goods_disabled?>> <a href="javascript:selectGoods('document.bannerForm3<?=$ban_cnt?>.goodsUrl');"><img src="image/design_good.gif" width="46" height="18" border="0"></a></div></td>
																</tr>
															</table>
														</td>
													</tr>
													<tr>
														<td colspan="3"> <div align="center"> <input type="file" name="img" size="25" style="BORDER-RIGHT: gray 1px solid; BORDER-TOP: gray  1px solid; FONT-SIZE: 9pt; BORDER-LEFT: gray 1px solid; BORDER-BOTTOM: gray  1px solid; FONT-FAMILY: gulim; HEIGHT: 19px; BACKGROUND-COLOR: white"></div></td>
													</tr>
												</table>
											</td>
										</tr>
									</table>
								</td>
							</tr>
							</form><!-- bannerForm1 --><?
							}
							?>
							<tr>
								<td colspan="2">&nbsp;</td>
							</tr>
							<tr>
								<td colspan="2" align=left>* 상품목록 페이지 <b>왼쪽</b> 베너 신규등록 *</td>
							</tr>
							<form name="bannerwriteForm5" method="post" action="category_design_ok.php?part=3"  enctype="multipart/form-data" >
							<input type="hidden" name="siteUrl_str">
							<input type="hidden" name="goodsUrl_str">
							<input type="hidden" name="parentcode" value="<?=$parentcode?>">
							<tr>
								<td colspan="2">
									<table width="100%" border="1" cellspacing="0" cellpadding="2" align="center" bordercolor="#FFD28E" bordercolordark="#ffffff">
										<tr>
											<td width="166" bgcolor="#FFF3E1"> <div align="center"> <input type="radio" name="gubun" value="0" onClick="javascript:showSiteUrl(document.bannerwriteForm5);" checked>사이트 URL</div></td>
											<td width="166" bgcolor="#FFF3E1"> <div align="center"> <input type="radio" name="gubun" value="1" onClick="javascript:showSiteUrl(document.bannerwriteForm5);">상품 URL</div></td>
											<td width="166" bgcolor="#FFF3E1"> <div align="center"> <input type="radio" name="gubun" value="2" checked  onClick="javascript:showSiteUrl(document.bannerwriteForm5);">Not URL</div></td>
										</tr>
										<tr>
											<td colspan="3"> <div align="center">
												<table width="100%" border="0" cellspacing="0" cellpadding="0">
													<tr>
														<td> <div align="center">http:// <input type="text" name="siteUrl"  size="20" style="BORDER-RIGHT: gray 1px solid; BORDER-TOP: gray  1px solid; FONT-SIZE: 9pt; BORDER-LEFT: gray 1px solid; BORDER-BOTTOM: gray  1px solid; FONT-FAMILY: gulim; HEIGHT: 19px; BACKGROUND-COLOR: #dddddd" disabled><input type="radio" name="siteTarget" value="_parent" checked>현재창 <input type="radio" name="siteTarget" value="_blank" >새창 <br><input type="text" name="goodsUrl"  size="18" style="BORDER-RIGHT: gray 1px solid; BORDER-TOP: gray  1px solid; FONT-SIZE: 9pt; BORDER-LEFT: gray 1px solid; BORDER-BOTTOM: gray  1px solid; FONT-FAMILY: gulim; HEIGHT: 19px; BACKGROUND-COLOR: #dddddd" readonly disabled> <a href="javascript:selectGoods('document.bannerwriteForm5.goodsUrl');"><img src="image/design_good.gif" width="46" height="18" border="0"></a></div></td>
														<td rowspan="2" width="60"> <div align="center"><a href="javascript:bannerwriteSendit(document.bannerwriteForm5);"><img src="image/design_save_i.gif" width="46" height="18" border="0"></a></div></td>
													</tr>
													<tr>
														<td> <div align="center"> <input type="file" name="img"  size="25" style="BORDER-RIGHT: gray 1px solid; BORDER-TOP: gray  1px solid; FONT-SIZE: 9pt; BORDER-LEFT: gray 1px solid; BORDER-BOTTOM: gray  1px solid; FONT-FAMILY: gulim; HEIGHT: 19px; BACKGROUND-COLOR: white"></div></td>
													</tr>
												</table></div>
											</td>
										</tr>
										<tr>
											<td colspan="3" bgcolor="#FFF3E1"> <div align="center">gif , jpg , swf ,  사용가능 (최적화 사이즈 가로 175 pixel) </div></td>
										</tr>
									</table>
								</td>
							</tr>
							</form>
							<tr>
								<td colspan="2">&nbsp;</td>
							</tr>
							<tr>
								<td colspan="2" valign="top" height="35"><br><img src="image/design_main_icon.gif" width="21" height="11"> 상품목록 페이지 <b>화면중앙부분</b> 베너목록</td>
							</tr>
							<tr>
								<td colspan="2">
									<table class="table_coll" width="300"> 
										<tr align="center">
											<td bgcolor="eeeeee">한줄에 출력될 이미지 열 갯수</td>
											<td><select name="midBannerCols" onchange="location.href='category_design_ok.php?part=6&parentcode=<?=$parentcode?>&val='+this.value"><option value="2" <? if ($cate_row[midBannerCols]==2) echo "selected";?>>2개</option><option value="3" <? if ($cate_row[midBannerCols]==3) echo "selected";?>>3개</option><option value="4" <? if ($cate_row[midBannerCols]==4) echo "selected";?>>4개</option></select></td>
										</tr>
									</table>
								</td>
							</tr><?
							$ban_qry = "select *from category_banner where position ='$parentcode' order by sunwi asc";
							$ban_result = @$MySQL->query($ban_qry);
							$ban_cnt =0;
							while($ban_row = mysql_fetch_array($ban_result))
							{
								$ban_cnt ++;
								if($ban_row[gubun]==0)
								{
									$site_color = "white";
									$goods_color = "#dddddd";
									$site_disabled = "";
									$goods_disabled = "disabled";
								}
								else if($ban_row[gubun]==1)
								{
									$site_color = "#dddddd";
									$goods_color = "white";
									$site_disabled = "disabled";
									$goods_disabled = "";
								}
								else
								{
									$site_color = "#dddddd";
									$goods_color = "#dddddd";
									$site_disabled = "disabled";
									$goods_disabled = "disabled";
								}
								?>
							<form name="bannerForm4<?=$ban_cnt?>" method="post" action="category_design_ok.php?part=4"  enctype="multipart/form-data" >
							<input type="hidden" name="siteUrl_str">
							<input type="hidden" name="goodsUrl_str">
							<input type="hidden" name="bannerIdx" value="<?=$ban_row[idx]?>">
							<input type="hidden" name="parentcode" value="<?=$parentcode?>">
							<tr>
								<td colspan="2" height="70">
									<table width="100%" border="1" cellspacing="0" cellpadding="2" align="center" bordercolor="#FFD28E" bordercolordark="#ffffff">
										<tr>
											<td width="180"> <?
											if($ban_row[type]==4)
											{
												$img = "../upload/design/$ban_row[img]";
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
												?><div align="center"><img src="../upload/design/<?=$ban_row[img]?>"> </div><?
											}
											?></td>
											<td width="350">
												<table width="100%" border="0" cellspacing="0" cellpadding="0">
													<tr>
														<td width="33%" height="25"> <div align="center"> <input class="radio" type="radio" name="gubun" value="0" <?if($ban_row[gubun]==0)echo"checked";?> onClick="javascript:showSiteUrl(document.bannerForm4<?=$ban_cnt?>);">사이트 URL</div></td>
														<td height="33%"> <div align="center"> <input class="radio" type="radio" name="gubun" value="1" <?if($ban_row[gubun]==1)echo"checked";?> onClick="javascript:showSiteUrl(document.bannerForm4<?=$ban_cnt?>);">상품 URL</div></td>
														<td width="33%" height="25"> <div align="center"> <input class="radio" type="radio" name="gubun" value="2" <?if($ban_row[gubun]==2)echo"checked";?> onClick="javascript:showSiteUrl(document.bannerForm4<?=$ban_cnt?>);">Not URL</div></td>
													</tr>
													<tr>
														<td colspan="3">
															<table width="100%" border="0" cellspacing="0" cellpadding="0">
																<tr>
																	<td > <div align="center">http:// <input type="text" name="siteUrl" value="<?=$ban_row[siteUrl]?>"  size="20" style="BORDER-RIGHT: gray 1px solid; BORDER-TOP: gray  1px solid; FONT-SIZE: 9pt; BORDER-LEFT: gray 1px solid; BORDER-BOTTOM: gray  1px solid; FONT-FAMILY: gulim; HEIGHT: 19px; BACKGROUND-COLOR: <?=$site_color?>" <?=$site_disabled?>><br><input type="radio" name="siteTarget" value="_parent" <? if ($ban_row[siteTarget] == "_parent") echo "checked";?>>현재창 <input type="radio" name="siteTarget" value="_blank" <? if ($ban_row[siteTarget] == "_blank") echo "checked";?>>새창 <br>&nbsp;&nbsp;&nbsp;<b>화면출력 우선순위</b> <input class="box" type="text" name="sunwi" value="<?=$ban_row[sunwi]?>" size=2> 예) 1~10 </div></td>
																	<td rowspan="2" width="60"> <div align="center"><a href="javascript:bannerSendit(document.bannerForm4<?=$ban_cnt?>,'&edit=1');"><img src="image/design_save_i.gif" width="46" height="18" border="0"></a> <a href="javascript:bannerSendit(document.bannerForm4<?=$ban_cnt?>,'&del=1');"><img src="image/design_delete.gif" width="46" height="18" border="0"></a></div></td>
																</tr>
																<tr>
																	<td > <div align="center"> <input type="text" name="goodsUrl" value="<?=$ban_row[goodsUrl]?>" readonly size="18" style="BORDER-RIGHT: gray 1px solid; BORDER-TOP: gray  1px solid; FONT-SIZE: 9pt; BORDER-LEFT: gray 1px solid; BORDER-BOTTOM: gray  1px solid; FONT-FAMILY: gulim; HEIGHT: 19px; BACKGROUND-COLOR: <?=$goods_color?>" <?=$goods_disabled?>> <a href="javascript:selectGoods('document.bannerForm4<?=$ban_cnt?>.goodsUrl');"><img src="image/design_good.gif" width="46" height="18" border="0"></a></div></td>
																</tr>
															</table>
														</td>
													</tr>
													<tr>
														<td colspan="3"> <div align="center"> <input type="file" name="img" size="25" style="BORDER-RIGHT: gray 1px solid; BORDER-TOP: gray  1px solid; FONT-SIZE: 9pt; BORDER-LEFT: gray 1px solid; BORDER-BOTTOM: gray  1px solid; FONT-FAMILY: gulim; HEIGHT: 19px; BACKGROUND-COLOR: white"></div></td>
													</tr>
												</table>
											</td>
										</tr>
									</table>
								</td>
							</tr>
							</form><!-- bannerForm1 --><?
							}
							?>
							<tr>
								<td colspan="2">&nbsp;</td>
							</tr>
							<tr>
								<td colspan="2" align=left>* 상품목록 페이지 <b>화면중앙부분</b> 신규등록 *</td>
							</tr>
							<form name="bannerForm4" method="post" action="category_design_ok.php?part=5"  enctype="multipart/form-data" >
							<input type="hidden" name="siteUrl_str">
							<input type="hidden" name="goodsUrl_str">
							<input type="hidden" name="parentcode" value="<?=$parentcode?>">
							<tr>
								<td colspan="2">
									<table width="100%" border="1" cellspacing="0" cellpadding="2" align="center" bordercolor="#FFD28E" bordercolordark="#ffffff">
										<tr>
											<td width="166" bgcolor="#FFF3E1"> <div align="center"> <input type="radio" name="gubun" value="0" onClick="javascript:showSiteUrl(document.bannerForm4);" checked>사이트 URL</div></td>
											<td width="166" bgcolor="#FFF3E1"> <div align="center"> <input type="radio" name="gubun" value="1" onClick="javascript:showSiteUrl(document.bannerForm4);">상품 URL</div></td>
											<td width="166" bgcolor="#FFF3E1"> <div align="center"> <input type="radio" name="gubun" value="2" checked  onClick="javascript:showSiteUrl(document.bannerForm4);">Not URL</div></td>
										</tr>
										<tr>
											<td colspan="3"> <div align="center">
												<table width="100%" border="0" cellspacing="0" cellpadding="0">
													<tr>
														<td> <div align="center">http:// <input type="text" name="siteUrl"  size="20" style="BORDER-RIGHT: gray 1px solid; BORDER-TOP: gray  1px solid; FONT-SIZE: 9pt; BORDER-LEFT: gray 1px solid; BORDER-BOTTOM: gray  1px solid; FONT-FAMILY: gulim; HEIGHT: 19px; BACKGROUND-COLOR: #dddddd" disabled><br><input type="radio" name="siteTarget" value="_parent" checked>현재창 <input type="radio" name="siteTarget" value="_blank" >새창 <br><input type="text" name="goodsUrl"  size="18" style="BORDER-RIGHT: gray 1px solid; BORDER-TOP: gray  1px solid; FONT-SIZE: 9pt; BORDER-LEFT: gray 1px solid; BORDER-BOTTOM: gray  1px solid; FONT-FAMILY: gulim; HEIGHT: 19px; BACKGROUND-COLOR: #dddddd" readonly disabled><a href="javascript:selectGoods('document.bannerForm4.goodsUrl');"><img src="image/design_good.gif" width="46" height="18" border="0"></a></div></td>
														<td rowspan="2" width="60"> <div align="center"><a href="javascript:bannerwriteSendit(document.bannerForm4);"><img src="image/design_save_i.gif" width="46" height="18" border="0"></a></div></td>
													</tr>
													<tr>
														<td> <div align="center"> <input type="file" name="img"  size="25" style="BORDER-RIGHT: gray 1px solid; BORDER-TOP: gray  1px solid; FONT-SIZE: 9pt; BORDER-LEFT: gray 1px solid; BORDER-BOTTOM: gray  1px solid; FONT-FAMILY: gulim; HEIGHT: 19px; BACKGROUND-COLOR: white"></div></td>
													</tr>
												</table></div></td>
										</tr>
										<tr>
											<td colspan="3" bgcolor="#FFF3E1"> <div align="center">gif , jpg , swf ,  사용가능 (이미지 가로 사이즈 열갯수설정 4개일때 180 pixel, 3개일때 240px, 2개일때 360px) </div></td>
										</tr>
									</table>
								</td>
							</tr></form>
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