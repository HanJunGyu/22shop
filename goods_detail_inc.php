<?
///////////// 공통으로 쓰이는 부분 ////////////////////// 
/////////////상품사진 가로세로 사이즈설정//////////////// 
////메인베스트 , 메인히트, 카테고리추천, 일반목록//////// 

if ($MAINPAGE_BEST)
{
	$goodsListIW = $design[mainBestGoodsIW];
	$goodsListIH = $design[mainBestGoodsIH];
}
else if ($MAINPAGE_HIT)
{
	$goodsListIW = $design[mainHitGoodsIW];
	$goodsListIH = $design[mainHitGoodsIH];
}
else if ($NEW_PAGE)
{
	$goodsListIW = $design[new_img_width];
	$goodsListIH = $design[new_img_height];
}
else if ($category_info[designType] && $design_goods[designTypeCommon]=="n")
{
	if ($CATE_RECOM)
	{
		$goodsListIW = $category_info[goodsListIW1];
		$goodsListIH = $category_info[goodsListIH1];
	}
	else if ($CATE_BEST)
	{
		$goodsListIW = $category_info[goodsListIW2];
		$goodsListIH = $category_info[goodsListIH2];
	}
	else
	{
		$goodsListIW = $category_info[goodsListIW];
		$goodsListIH = $category_info[goodsListIH];
	}
}
else
{
	if ($CATE_RECOM)
	{
		$goodsListIW = $design_goods[goodsListIW1];
		$goodsListIH = $design_goods[goodsListIH1];
	}
	else if ($CATE_BEST)
	{
		$goodsListIW = $design_goods[goodsListIW2];
		$goodsListIH = $design_goods[goodsListIH2];
	}
	else
	{
		$goodsListIW = $design_goods[goodsListIW];
		$goodsListIH = $design_goods[goodsListIH];
	}
}
if ($admin_row[bNew])
{
	$bNew = limitday($goods_row[writeday],$admin_row[new_day]);
	if (empty($bNew) && $goods_row[bNew]) $bNew = "<img src='upload/goods_new_img'>";
}
if($goods_row[bHit]) $bHit ="<img src='upload/goods_hit_img'>";		//히트 이미지
else $bHit =""; 		 
if($goods_row[bEtc]) $bEtc ="<img src='upload/goods_etc_img' >";	//기타 이미지
else $bEtc ="";
if($goods_row[size]=="N") $bNotrans_img ="<img src='upload/goods_notrans_img' >";
else $bNotrans_img =""; 	

//////////////GD 여부에 따른 상품이미지 설정///////////// 
if (empty($GD_SET) && $goods_row[img_onetoall]) $img_str = $goods_row[img3];
else if ($GD_SET && $goods_row[img_onetoall] && empty($goods_row[img1])) $img_str = $goods_row[img3];
else if ($GD_SET && empty($goods_row[img_onetoall]) && empty($goods_row[img1])) $img_str = $goods_row[img3];
else $img_str = $goods_row[img1];

if ($CATE_RECOM)
{
	if (empty($GD_SET) && $goods_row[img_onetoall]) $img_str = $goods_row[img3];
	else if ($GD_SET && $goods_row[img_onetoall] && empty($goods_row[img2])) $img_str = $goods_row[img3];
	else if ($GD_SET && empty($goods_row[img_onetoall]) && empty($goods_row[img2])) $img_str = $goods_row[img3];
	else $img_str = $goods_row[img2];
}
if ($NEW_PAGE)
{
	if (empty($GD_SET) && $goods_row[img_onetoall]) $img_str = $goods_row[img3];
	else if ($GD_SET && $goods_row[img_onetoall] && empty($goods_row[$design[new_img_select]])) $img_str = $goods_row[img3];
	else if ($GD_SET && empty($goods_row[img_onetoall]) && empty($goods_row[$design[new_img_select]])) $img_str = $goods_row[img3];
	else $img_str = $goods_row[$design[new_img_select]];
	$designType = 1; //무조건 바둑판배열
}
$img_str = urlencode($img_str);
$img_str = str_replace("+"," ",$img_str);
///////////// 공통으로 쓰이는 부분 끝//////////////////////	  

if ($designType ==1 || $CATE_RECOM || $CATE_BEST)
{
	?><!-- 목록상에서 상품 1개의 상세정보 출력 include 파일 (바둑판식) -->
	<tr>
		<td valign="top" align="center"><?
		if ($GOODS_LIST_PAGE)
		{
			?>
		<input type="checkbox" name="comparechk" onclick="javascript:compare();" value="<?=$goods_row[idx]?>">
		<input type="hidden" name="comparechk_bLimit"   value="<?=$goods_row[bLimit]?>">
		<input type="hidden" name="comparechk_limitCnt"  value="<?=$goods_row[limitCnt]?>"><?
		}
		if ($design_goods[bGoodsList_1]==1)
		{
			///상품설정에서 이미지 노출할때
			////////행마다 열 틀리게하는 기능사용시 이미지 크기 제한안둠///////////// 
			if (($MAINPAGE_HIT&& $design[mainHitColsChange]=="y") || ($MAINPAGE_BEST&& $design[mainBestColsChange]=="y"))
			{
				?><a href="<?=$LINK?>"><img style="border-width:1px;border-color:#eeeeee;border-style:solid;" src="upload/goods/<?=$img_str?>"  border="0" onError="this.style.visibility=＇hidden＇"></a><?
			}
			else
			{
				?><a href="<?=$LINK?>"><img style="border-width:1px;border-color:#eeeeee;border-style:solid;" src="upload/goods/<?=$img_str?>" width="<?=$goodsListIW?>" height="<?=$goodsListIH?>" border="0"></a><?
			}
		}
		?></td>
	</tr>
	<tr>
		<td><?
		if ($design_goods[bGoodsList_2]==1)
		{
			///상품설정에서  노출할때
			?><div align="center"><a href="<?=$LINK?>"><font color="<?=$design_goods[gname_color]?>"><?=StringCut($goods_row[name],30)?></font></a></div><?
		}
		?></td>
	</tr><?
		if ($design_goods[bGoodsList_4]==1)
		{
			///상품설정에서  노출할때 
			if($goods_row[bOldPrice])
			{
				?>
	<tr>
		<td align="center"><strike><?=PriceFormat($goods_row[oldPrice])?>원</strike> <?
				if ($goods_row[bSaleper] && $goods_row[sale])
				{
					echo " <font color=#D83232><b>($goods_row[sale]%)</b></font>";
				}
				?></td>
	</tr><?
			}
		}
		?>
	<tr>
		<td>
			<table align="center">
				<tr><?
				if ($design_goods[bGoodsList_4]==1)
				{
					///상품설정에서  노출할때
					?>
					<td><img src="upload/goods_price_img"></td>
					<td><font color="<?=$design_goods[gprice_color]?>"><b><?=$gprice->PutPrice();?> 원</b></font></td><?
				}
				?>
				</tr>
			</table>
		</td>
	</tr><?
		if ($admin_row[bUsepoint])
		{
			?>
	<tr>
		<td>
			<table align="center">
				<tr><?
				if ($design_goods[bGoodsList_5]==1)
				{
					///상품설정에서  노출할때
					?>
					<td><img src="upload/goods_point_img"></td>
					<td><font color="<?=$design_goods[gpoint_color]?>"><?=$gprice->PutPoint2()." 원"?></font></td><?
				}
				?>
				</tr>
			</table>
		</td>
	</tr><?
		}
		if ($goods_row[size]=="N" || $goods_row[bHit] || $bNew || $goods_row[bEtc])
		{
			?>
	<tr>
		<td align="center"><?
			if ($admin_row[bHit]) echo $bHit;
			if ($admin_row[bEtc]) echo $bEtc;
			if ($admin_row[bNew]) echo $bNew;
			if ($admin_row[bNotransImg]) echo $bNotrans_img;
			?></td>
	</tr><?
		}
		if (!$MAINPAGE_BEST && !$MAINPAGE_HIT && !$MAINPAGE_BOTTOM && $admin_row[bBigView])
		{
			$info = @getimagesize("./upload/goods/$goods_row[img3]");
			$wSize = $info[0]+250;
			$hSize = $info[1]+120;
			if ($wSize<500) $wSize=600;
			if ($hSize<500) $hSize=600;
			?>
	<tr>
		<td align=center><a href="javascript:zoom2('<?=$goods_row[idx]?>',<?=$wSize?>,<?=$hSize?>);"><img src="upload/goods_view_img"></a></td>
	</tr><?
		}
		?>
	<tr>
		<td>
			<table align="center" cellspacing="0" cellpadding="0">
				<tr>
					<td><?
					//////옵션이 있으면 아이콘 표시///////
					if ($admin_row[bOptionImg] && $goods_row[strPart1])
					{
						?><img src="upload/goods_option_img"><?
					}
					?></td>
				</tr>
			</table>
		</td>
	</tr><?
		if (($goods_row[bLimit] && !$goods_row[limitCnt]) || $goods_row[bLimit]==2) 
		{
			?>
	<tr>
		<td align="center"><?
			if (file_exists("./upload/no_good_img"))
			{
				?><img src="./upload/no_good_img" align="absmiddle"><?
			}
			else
			{
				?><FONT COLOR='#990000'>품절</FONT><?
			}
			?></td>
	</tr><?
		}
		else if (!$MAINPAGE_BEST && !$MAINPAGE_HIT && !$MAINPAGE_BOTTOM)
		{
			?>
	<tr>
		<td align="center"><a href="<?=$LINK?>"><img src="image/icon/buy_btn.gif" border="0"></a></td>
	</tr><?
		}
}
else if ($designType ==2) 
{
	?><!-- 목록상에서 상품 1개의 상세정보 출력 include 파일 (게시판식) -->
	<tr><?
	if ($GOODS_LIST_PAGE)
	{
		?>
		<td width="10"><input type="checkbox" name="comparechk" onclick="javascript:compare();" value="<?=$goods_row[idx]?>"><input type="hidden" name="comparechk_bLimit"   value="<?=$goods_row[bLimit]?>"><input type="hidden" name="comparechk_limitCnt"  value="<?=$goods_row[limitCnt]?>"></td><?
	}
	?>
		<td width="<?=$goodsListIW?>" align="center" style="padding: 5 0 5 0"><?
		if ($design_goods[bGoodsList_1]==1)
		{
			///상품설정에서  노출할때
			?><a href="<?=$LINK?>"><img src="upload/goods/<?=$img_str?>" width="<?=$goodsListIW?>" height="<?=$goodsListIH?>" border="0"></a><?
		}
		?></td>
		<td align="center" valign="middle"><?
		if ($design_goods[bGoodsList_2]==1)
		{
			///상품설정에서  노출할때
			?><a href="<?=$LINK?>"><font color="<?=$design_goods[gname_color]?>"><b><?=$goods_row[name]?></b></font></a><?
		}
		if ($admin_row[bHit]) echo $bHit;
		if ($admin_row[bEtc]) echo $bEtc;
		if ($admin_row[bNew]) echo $bNew;
		if ($admin_row[bNotransImg]) echo $bNotrans_img;
		if ($admin_row[bOptionImg] && $goods_row[strPart1])
		{
			?><img src="upload/goods_option_img"><?
		}
		?></td>
		<td width="100" align="center"><?
		if($goods_row[bOldPrice])
		{
			?>시중가 <strike><?=PriceFormat($goods_row[oldPrice])?>원</strike><?
			if ($goods_row[bSaleper] && $goods_row[sale])
			{
				echo "<font color=#D83232>($goods_row[sale]%)</font>"; 
			}
			?><br><?
		}
		if ($design_goods[bGoodsList_4]==1)
		{
			///상품설정에서  노출할때
			?><img src="upload/goods_price_img"> <font color="<?=$design_goods[gprice_color]?>"><b><?=$gprice->PutPrice();?> </b>원 </font><?
		}
		if ($admin_row[bUsepoint])
		{
			if ($design_goods[bGoodsList_5]==1)
			{
				///상품설정에서  노출할때
				?><br><img src="upload/goods_point_img"><font color="<?=$design_goods[gpoint_color]?>"><?=$gprice->PutPoint2()." 원"?></font><?
			}
		}
		?><br><?
		if (($goods_row[bLimit] && !$goods_row[limitCnt]) || $goods_row[bLimit]==2)
		{
			if (file_exists("./upload/no_good_img"))
			{
				?><img src="./upload/no_good_img" align="absmiddle"><?
			}
			else
			{
				?><FONT COLOR='#990000'>품절</FONT><?
			}
		}
		else
		{
			?><a href="<?=$LINK?>" ><img src="image/icon/buy_btn.gif" border="0"></a></td><?
		}
		?>
	</tr>
	<tr>
		<td colspan="4" background="image/index/dot_width.gif"></td>
	</tr><?
}
else if ($designType ==3)	///////////////////// 혼합식 배열 ///////////////////////////// 
{
	$td_cnt++;
	if ($td_cnt % 2 == 1) echo "<TR>";
	?>
		<td width="50%" valign="top">
			<table width="100%" class="table_coll" border="1" cellspacing="0" cellpadding="0">
				<tr align="center">
					<td width="<?=$goodsListIW?>"><?
					if ($design_goods[bGoodsList_1]==1)
					{
						///상품설정에서  노출할때
						?><a href="<?=$LINK?>"><img src="upload/goods/<?=$img_str?>" width="<?=$goodsListIW?>" height="<?=$goodsListIH?>"></a><?
					}
					?></td>
					<td valign="top">
						<table width="100%" align="center" class="table_coll" border="1" style="border-color:white;" height="<?=$goodsListIH?>">
							<tr align="center" height="20%">
								<td bgcolor="#F4F4F4" align="left"><?
								if ($GOODS_LIST_PAGE)
								{
									?><input type="checkbox" name="comparechk" onclick="javascript:compare();" value="<?=$goods_row[idx]?>"><input type="hidden" name="comparechk_bLimit"   value="<?=$goods_row[bLimit]?>"><input type="hidden" name="comparechk_limitCnt"  value="<?=$goods_row[limitCnt]?>"><?
								}
								if ($design_goods[bGoodsList_2]==1)
								{
									///상품설정에서  노출할때 
									?><a href="<?=$LINK?>"><font color="<?=$design_goods[gname_color]?>"><b><?=$goods_row[name]?></b></font>&nbsp;</a><?
								}
								if (strlen($goods_row[name]>30)) echo "<BR>"; 
								if ($admin_row[bHit]) echo $bHit;
								if ($admin_row[bEtc]) echo $bEtc;
								if ($admin_row[bNew]) echo $bNew;
								if ($admin_row[bNotransImg]) echo $bNotrans_img;
								// 옵션이 있으면 아이콘 표시///////
								if ($admin_row[bOptionImg] && $goods_row[strPart1])
								{
									?><img src="admin/image/option.gif"><?
								}
								?></td>
							</tr>
							<tr>
								<td valign="middle" align="right"><?
								if ($design_goods[bGoodsList_4]==1)
								{
									///상품설정에서  노출할때
									?><img src="upload/goods_price_img"> <font color="<?=$design_goods[gprice_color]?>"><b><?=$gprice->PutPrice();?> </b>원 </font><?
								}
								if ($admin_row[bUsepoint])
								{
									if ($design_goods[bGoodsList_5]==1)
									{
										///상품설정에서  노출할때
										?>&nbsp;&nbsp;<img src="upload/goods_point_img"><font color="<?=$design_goods[gpoint_color]?>"><?=$gprice->PutPoint2()." 원"?></font><?
									}
								}
								if (($goods_row[bLimit] && !$goods_row[limitCnt]) || $goods_row[bLimit]==2)
								{
									if (file_exists("./upload/no_good_img"))
									{
										?><img src="./upload/no_good_img" align="absmiddle">&nbsp;<?
									}
									else
									{
										?><FONT COLOR='#990000'>품절</FONT>&nbsp;<?
									}
								}
								else
								{
									?><a href="<?=$LINK?>"><img src="image/icon/buy_btn.gif" border="0"></a></td><?
								}
								?></td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
		</td><?
		if ($td_cnt % 2 == 0) echo "</TR>";
}
?>