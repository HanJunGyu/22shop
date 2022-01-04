<?
session_cache_limiter("no-cache, must-revalidate");
include "head.php";
if ($sunwi_edit) ////////// 순서수정 
{
	if ($MySQL->query("UPDATE position SET sunwi=$sunwi WHERE idx=$pidx"))
	{
		OnlyMsgView("수정하였습니다");
	}
}
$part=$part?$part:"mainbest";
$position=$position?$position:1;
$category_result = $MySQL->query("select * from category");

// 1:메인베스트 2:메인히트 3:메인신규 4:베스트(대) 5:베스트
$mainbestLimit = $design[mainBestGoodsW] * $design[mainBestGoodsH];
$mainhitLimit  = $design[mainHitGoodsW] * $design[mainHitGoodsH];

$positionStr	= Array("","메인 베스트","메인 히트","메인 신규","베스트(대)","베스트","신규");
$positionLimit	= Array(0,$mainbestLimit,$mainhitLimit,$design[mainNewGoodsList],1,4,20); //분류별 등록 한계

if(empty($category) && $position<4 && $position>0)
{
	$positionTitle = "<B>".$positionStr[$position]."</B>";
}
else
{
	$category_row = $MySQL->fetch_array("select *from category where code='$category'");
	$str_category = $category_row[name];
	$str_category = "<FONT COLOR='#993300'>".$str_category."</FONT>";
	if($part=="recommend")			$positionTitle = $str_category."&nbsp; <B>베스트(대)</B>";
	else if($part=="best")			$positionTitle = $str_category."&nbsp; <B>베스트</B>";
	else if($part=="new")			$positionTitle = $str_category."&nbsp; <B>신규</B>";
}
if(empty($category))
{
	$presentQry = "select *from position where part='$part'";
	$MySQL->query($presentQry);
	$presentPocnt = $MySQL->is_affected();
}
else
{
	$presentPocnt = $MySQL->articles("SELECT *from position WHERE category='$category_row[code]' and part='$part'");
}
if($part=="recommend") $positionIndex = 4;
else if($part=="best") $positionIndex = 5;
else if($part=="new") $positionIndex = 6;
else		     $positionIndex = $position;
?>
<SCRIPT LANGUAGE="JavaScript">
<!--
//특정위치 상품 등록
function addPosition(pL,pP)
{
	var form=document.positionForm;
	<? if($presentPocnt >=$positionLimit[$positionIndex]){?>
	var bAdd = false;
	<?}else{?>
	var bAdd = true;
	<?}?>
	if(bAdd)
	{
		Action="goods_total.php?position=<?=$position?>&category=<?=$category?>&part=<?=$part?>&code="+form.category.value+"&pL="+pL+"&pP="+pP;
		window.open(Action,"","scrollbars=yes,width=600,height=670,top=10,left=150");
	}
	else
	{
		alert("총 등록가능수 : <?=$positionLimit[$positionIndex]?>\n\n현재 등록수 : <?=$presentPocnt?>\n\n더이상 등록이 불가능합니다.");
	}
}
//특정위치 검색
function positionSearch(Part,Position)
{
	var form=document.positionForm;
	if (Position>3)
	{
		form.position.value = Position;
	}
	form.part.value = Part;
	form.action="goods_position.php?part="+Part+"&category="+form.category.value; 
	form.submit();
}
//특정위치 삭제
function positionDel(idx)
{
	Action="change_position.php?del=1&position=<?=$position?>&category=<?=$category?>&part=<?=$part?>&idx="+idx;
	location.href=Action;
}
//-->
</SCRIPT>
<body bgcolor="#FFFFFF" text="#5A595A" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<? include "top_menu.php"; ?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr><?
	$__TOP_MENU = "goods";     //왼쪽 소메뉴 설정 변수
	include "left_menu.php";
	?>
		<td width="85%" valign="top">
			<table width="100%"  cellspacing="0" cellpadding="0">
				<tr>
					<td height='5'></td>
				</tr>
				<tr>
					<td valign=top>
						<table width="750" border="0" cellspacing="0" cellpadding="0" align='center'>
							<tr>
								<td rowspan="3" width="200"><img src="image/good_tit_img.gif"></td>
								<td>&nbsp;</td>
							</tr>
							<tr>
								<td bgcolor="#E6E6E6" height='26'><div align='right'><font class='text1'>SHOP 상품관리를 하실수 있습니다.&nbsp;</div></td>
							</tr>
							<tr>
								<td>&nbsp;</td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td height="2" valign=top>
						<table width="750" border="0" cellspacing="0" cellpadding="0" align="center">
							<tr>
								<td bgcolor='DADADA' height='1'></td>
							</tr>
							<tr>
								<td>
									<table width="750" border="0" cellspacing="0" cellpadding="0" align="center">
										<tr>
											<td width='440'><img src="image/good_position_tit.gif"></td>
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
									<table width="750" border="0" cellspacing="0" cellpadding="0" align="center">
										<tr>
											<td colspan="2">
												<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
													<tr>
														<td height="1" background="image/line_bg1.gif"></td>
													</tr>
													<tr>
														<td height="70" bgcolor="#F5F5F5">
															<table width="100%" border="0" bgcolor="#FAFAFA" align="center" class="table_coll">
																<tr bgcolor="#3D179C" height="25" >
																	<td width=70% align="center"><font color="white" ><b>메인페이지 베스트 / 히트 / 신규 상품지정</b></font></td>
																	<td width=30% align="right"><a onclick="zoom('<?=urlencode('image/position_main.jpg')?>',378,869)" href="#;"><font color="white" ><b>위치보기</b></font></a></td>
																</tr>
																<tr bgcolor="#F5F5F5">
																	<td height="30" colspan="2">
																		<table width="100%" border="0" cellspacing="0" cellpadding="0">
																			<tr align="center">
																				<td width="200"><a href="goods_position.php?part=mainbest&position=1"><img src="image/good_position_m01.gif" width="70" height="19" border="0"></a><br><br>&nbsp;<a href="design_e.php"><font class="help">디자인관리 바로가기</font></a></td>
																				<td width="200"><a href="goods_position.php?part=mainhit&position=2"><img src="image/good_position_m02.gif" width="70" height="19" border="0"></a><br><br>&nbsp;<a href="design_f.php"><font class="help">디자인관리 바로가기</font></a></td>
																				<td width="200"><a href="goods_position.php?part=mainnew&position=3"><img src="image/good_position_m03.gif" width="70" height="19" border="0"></a><br><br>&nbsp;<a href="design_d.php"><font class="help">디자인관리 바로가기</font></a></td>
																			</tr>
																		</table>
																	</td>
																</tr>
															</table>
															<form name="positionForm" method="post" action="goods_position.php">
															<input type="hidden" name="position" value="<?=$position?>"><!-- 특정위치 정보 -->
															<input type="hidden" name="part" value="<?=$part?>">
															<input type="hidden" name="category" value="<?=$category?>">
															<table width="100%" border="0" bgcolor="#FAFAFA" align="center">
																<tr bgcolor="#F5F5F5">
																	<td width="100%" height="30">
																		<table width="100%" border="0" cellspacing="0" cellpadding="0" class="table_coll">
																			<tr bgcolor="#3D179C" height="25" align="center">
																				<td width=70%><font color="white" ><b>카테고리별 판매베스트 상품지정</b></font></td>
																				<td width=30% align="right"><a onclick="zoom('<?=urlencode('image/position_goods.jpg')?>',600,793)" href="#;"><font color="white" ><b>위치보기</b></font></a></td>
																			</tr>
																			<tr>
																				<td height=40>&nbsp;<a href="javascript:positionSearch('recommend',4);"><img src="image/goods_position_best_big.gif"  border="0">&nbsp;<a href="javascript:positionSearch('best',5);"><img src="image/good_position_best.gif" width="48" height="23" border="0"></a>&nbsp;<a href="javascript:positionSearch('new',6);"><img src="image/good_position_new.gif" border="0"></a>&nbsp;<a href="design_good_a.php"><font class="help">상품목록 디자인관리 바로가기</font></a></td>
																			</tr>
																			<tr>
																				<td height=30><?
																				if ($part)
																				{
																					?>&nbsp;<iframe src="frame_category.php?code=<?=$category_row[code]?>&type=goods_position&part=<?=$part?>" width="90%" frameborder=0 height=50 marginheight=0 margintop=0 scroll=0 scrolling=no></iframe><?
																				}
																				?></td>
																			</tr>
																		</table>
																	</td>
																</tr>
															</table>
															</form><!-- positionForm -->
														</td>
													</tr>
													<tr>
														<td height="1" background="image/line_bg1.gif"></td>
													</tr>
												</table>
											</td>
										</tr>
										<tr>
											<td colspan="2">&nbsp;</td>
										</tr>
										<tr>
											<td colspan="2" height="25">&nbsp;&nbsp;&nbsp;<font style="font-size:15px"><?=$positionTitle?></font>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;현재 <B><FONT  COLOR="#6600FF"><?=$presentPocnt?></FONT></B> / <FONT COLOR="#990000"><B><?=$positionLimit[$positionIndex]?></B></FONT> 등록가능상품수&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?
											if ($part)
											{
												?><a href="javascript:addPosition(<?=$presentPocnt?>,<?=$positionLimit[$positionIndex]?>);"><img src="image/entry_btn.gif" width="59" height="17" border="0"></a><?
											}
											?></td>
										</tr>
										<tr>
											<td colspan="2">
												<table width="750" border="0" cellspacing="1" cellpadding="0" align='center' bgcolor='cdcdcd'>
													<tr>
														<td height="30" bgcolor="#EBEBEB" width="50"> <div align="center"><img src="image/icon.gif" width="11" height="11"> 번호</div></td>
														<td height="30" bgcolor="#EBEBEB" width="80"> <div align="center"><img src="image/icon.gif" width="11" height="11"> 상품이미지</div></td>
														<td height="30" bgcolor="#EBEBEB"> <div align="center"><img src="image/icon.gif" width="11" height="11">분류명</div></td>
														<td height="30" bgcolor="#EBEBEB" > <div align="center"><img src="image/icon.gif" width="11" height="11"> 상품명</div></td>
														<td height="30" bgcolor="#EBEBEB" width="100"> <div align="center"><img src="image/icon.gif" width="11" height="11"> 위치이동</div></td>
														<td height="30" bgcolor="#EBEBEB" width="60"> <div align="center"><img src="image/icon.gif" width="11" height="11"> 삭제</div></td>
													</tr><?
													$Cnt=1;
													if(empty($category) && $part)
													{
														/// 메인상품 특정위치 상품목록
														$po_qry = "select *from position where part='$part' order by sunwi asc";
														$po_result = $MySQL->query($po_qry);
														while($po_row = mysql_fetch_array($po_result))
														{
															$goods_row = $MySQL->fetch_array("SELECT *from goods WHERE idx=$po_row[goodsIdx] limit 1");	// 카테고리 정보
															$cate_row = $MySQL->fetch_array("select *from category where code='$goods_row[category]'");
															$category_name = $cate_row[name];
															if ($admin_row[bNew])
															{
																$bNew = limitday($goods_row[writeday],$admin_row[new_day]);
																// 설정된 기간보다 지나서 new 마크가 붙지 않지만 임의로 상품정보에서 뉴마크 사용시
																if (empty($bNew) && $goods_row[bNew]) $bNew = "<img src='../upload/goods_new_img'>";
															}
															if ($bNew == "<img src=upload/goods_new_img>")  $bNew = "<img src=../upload/goods_new_img>";
															if($goods_row[bHit]) $bHit ="<img src='../upload/goods_hit_img'>";
															else				   $bHit ="";
															if($goods_row[bEtc]) $bEtc ="<img src='../upload/goods_etc_img' >";	//기타 이미지
															else				      $bEtc ="";
															?>
													<form name="posForm<?=$Cnt?>" method="post">
													<input type="hidden" name="part" value="<?=$part?>">
													<input type="hidden" name="category" value="<?=$category?>">
													<input type="hidden" name="sunwi_edit" value="1">
													<input type="hidden" name="pidx" value="<?=$po_row[idx]?>">
													<tr>
														<td height="70" bgcolor="ffffff" ><div align="center"><?=$Cnt?></div></td><?
															if (empty($GD_SET) && $goods_row[img_onetoall]) $img_str = $goods_row[img3];
															else if ($GD_SET && $goods_row[img_onetoall] && empty($goods_row[img1])) $img_str = $goods_row[img3];
															else if ($GD_SET && empty($goods_row[img_onetoall]) && empty($goods_row[img1])) $img_str = $goods_row[img3];
															else $img_str = $goods_row[img1];
															?>
														<td height="70" bgcolor="ffffff" > <div align="center"><img src="../upload/goods/<?=$img_str?>" width="60" height="60"></div></td>
														<td height="70" bgcolor="ffffff"> <div align="center"><b><?=$category_name?></b></div></td>
														<td height="70" bgcolor="ffffff"> <div align="center"><?=$goods_row[name]?> <?=$bHit?> <?=$bNew?> <?=$bEtc?></div></td>
														<td height="70" bgcolor="ffffff" > <div align="center">순번 <input value="<?=$po_row[sunwi]?>" name="sunwi" type="text" class="box" size=3><br><input type="image" src="image/edit_btn.gif" border=0></div></td>
														<td height="70" bgcolor="ffffff" > <div align="center"><a href="javascript:positionDel('<?=$po_row[idx]?>');"><img src="image/good_position_delete.gif" width="41" height="23" border="0"></a></div></td>
													</tr>
													</form><?
															$presentPocnt--;
															$Cnt++;
														}
													}
													else
													{
														$po_qry = "select *from position where part='$part' and category='$category_row[code]' order by sunwi asc";
														$po_result = $MySQL->query($po_qry);
														while ($po_row = mysql_fetch_array($po_result))
														{
															$for_limit = $presentPocnt;
															$goods_row = $MySQL->fetch_array("SELECT *from goods WHERE idx=$po_row[goodsIdx] limit 1");
															// 카테고리 정보
															$cate_row = $MySQL->fetch_array("select *from category where code='$category'");
															$str_category = $cate_row[name];
															?>
													<form name="posForm<?=$Cnt?>" method="post">
													<input type="hidden" name="part" value="<?=$part?>">
													<input type="hidden" name="category" value="<?=$category?>">
													<input type="hidden" name="sunwi_edit" value="1">
													<input type="hidden" name="pidx" value="<?=$po_row[idx]?>">
													<tr>
														<td height="70" bgcolor="ffffff" width="50"> <div align="center"><?=$Cnt?></div></td>
														<td height="70" bgcolor="ffffff" width="120"> <?
															if (empty($GD_SET) && $goods_row[img_onetoall]) $img_str = $goods_row[img3];
															else if ($GD_SET && $goods_row[img_onetoall] && empty($goods_row[img2])) $img_str = $goods_row[img3];
															else if ($GD_SET && empty($goods_row[img_onetoall]) && empty($goods_row[img2])) $img_str = $goods_row[img3];
															else $img_str = $goods_row[img1];
															?><div align="center"><img src="../upload/goods/<?=$img_str?>" width="60" height="60"></div></td>
														<td height="70" bgcolor="ffffff"> <div align="center"><b><?=$str_category?></b></div></td>
														<td height="70" bgcolor="ffffff"> <div align="center"><?=$goods_row[name]?></div></td>
														<td height="70" bgcolor="ffffff" > <div align="center"><input value="<?=$po_row[sunwi]?>" name="sunwi" type="text" class="box" size=3> <input type="image" src="image/edit_btn.gif" border=0></div></td>
														<td height="70" bgcolor="ffffff" width="60"> <div align="center"><a href="javascript:positionDel('<?=$po_row[idx]?>');"><img src="image/good_position_delete.gif" width="41" height="23" border="0"></a></div></td>
													</tr>
													</form><?
															$Cnt++;
															$presentPocnt--;
														}
													}
													?><!-- 목록 끝 -->
												</table>
											</td>
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
</table>
<? include "copy.php";?>
</body>
</html>