<?
// 소스형상관리
// 20060720-1 파일교체 김성호 : 스크롤 대상 상품이 0개인 경우 자바 스크립 오류발생 수정
?>
<script language="JavaScript">
<!--
// banner_roll("div태그 id", "연결할 태그", 배너1개높이, 딜레이, 1칸이동속도, 0, 묶음, 첫시작시 DELAY시간후 롤링 변수);
OVER1 = OVER2 = 1;
function banner_roll(DID, TNAME, HEIGHT, DELAY, SPEED, THEIGHT, CNT, START)
{
	var div_tag = document.getElementById(DID);
	var tag;
	// 롤링 추가시 아래부분 추가
	if(OVER1 > 0 && DID == "banner_1") THEIGHT++;
	if(OVER2 > 0 && DID == "banner_2") THEIGHT++;
	// 2라인 이상씩 롤링
	if(CNT > 1) HEIGHT_ = HEIGHT * CNT;
	else HEIGHT_ = HEIGHT;
	if(THEIGHT < HEIGHT_) 
	{
		if(START != 1) 
		{
			div_tag.style.top = -THEIGHT;
			setTimeout("banner_roll('" + DID + "', '" + TNAME + "', " + HEIGHT + ", " + DELAY + ", " + SPEED + ", " + THEIGHT + ", " + CNT + ", 0);", SPEED);
		}
		else
		{
			setTimeout("banner_roll('" + DID + "', '" + TNAME + "', " + HEIGHT + ", " + DELAY + ", " + SPEED + ", " + THEIGHT + ", " + CNT + ", 0);", DELAY);
		}
	}
	else
	{
		tag = div_tag.getElementsByTagName(TNAME);
		if(tag.length > 0)	for(i=0;i<CNT;i++) div_tag.appendChild(tag[0]);
		div_tag.style.top = 0;
		setTimeout("banner_roll('" + DID + "', '" + TNAME + "', " + HEIGHT + ", " + DELAY + ", " + SPEED + ", 0, " + CNT + ", 0);", DELAY);
	}
	return true;
}
//-->
</script>
<table cellpadding="0" cellspacing="0" border="0" width="720" background='image/best_bg.gif'>
	<tr>
		<td height="9" colspan="3"></td>
	</tr>
	<tr>
		<TD width="100%" height='<?= $design[mainScrollHeight]-11?>' style='margin:0px' valign='top'>
		<div style="position:absolute; width:720px; height:<?= $design[mainScrollHeight]-11?>px; overflow:hidden">
		<div style="position:relative" id="banner_1"><?
		if ($Index) $category_info = $MySQL->fetch_array("select *from category where idx=$Index limit 1");
		if ($part=="best")
		{
			$MAIN_BEST_GOODS_LIMIT	= $MAIN_BEST_GOODS_COL *$MAIN_BEST_GOODS_ROW;	//메인베스트 상품 총 개수
			$goodW = $design[mainBestGoodsIW];
			$goodH = $design[mainBestGoodsIH];
			$qry = "select *from position where part='mainbest' order by sunwi asc limit 0,$MAIN_BEST_GOODS_LIMIT";
		}
		else if ($part=="hit")
		{
			$MAIN_HIT_GOODS_LIMIT	= $MAIN_HIT_GOODS_COL *$MAIN_HIT_GOODS_ROW;	//메인히트 상품 총 개수
			$goodW = $design[mainHitGoodsIW];
			$goodH = $design[mainHitGoodsIH];
			$qry = "select *from position where part='mainhit' order by sunwi asc limit 0,$MAIN_HIT_GOODS_LIMIT";
		}
		$result = $MySQL->query($qry);
		$cnt =0;		//상품 카운트
		$jscnt =0;
		$now = date("Y-m-d",time());
		while($row = mysql_fetch_array($result))
		{
			$goods_row = $MySQL->fetch_array("SELECT *from goods WHERE idx=$row[goodsIdx] and bLimit<3 limit 1");
			if ($goods_row[idx])
			{
				$cnt++;
				$gprice = new CGoodsPrice($goods_row[idx]);
				$price = $gprice->PutPrice();
				if ($admin_row[bNew])
				{
					$bNew = limitday($goods_row[writeday],$admin_row[new_day]);
					if (empty($bNew) && $goods_row[bNew]) $bNew = "<img src='upload/goods_new_img'>";
				}
				if($goods_row[bHit]) $bHit ="<img src='upload/goods_hit_img'>";		//히트 이미지
				else $bHit ="";
				if($goods_row[bEtc]) $bEtc ="<img src='upload/goods_etc_img' >";	//기타 이미지
				else $bEtc ="";
				if (empty($GD_SET) && $goods_row[img_onetoall]) $img_str = $goods_row[img3];
				else if ($GD_SET && $goods_row[img_onetoall] && empty($goods_row[img1])) $img_str = $goods_row[img3];
				else if ($GD_SET && empty($goods_row[img_onetoall]) && empty($goods_row[img1])) $img_str = $goods_row[img3];
				else $img_str = $goods_row[img1];
				$img_str = urlencode($img_str);
				$name = StringCut(addslashes($goods_row[name]),20);
				$height = $design[mainScrollHeight]-11;
				if ($cnt%4==1) echo "<table cellpadding='0' cellspacing='0' border='0' width='700' height='$height' align='center' onmouseover='OVER1=0' onmouseout='OVER1=1'><tr>";
				echo "<td width=175 valign=top align=center><a href=goods_detail.php?goodsIdx=$goods_row[idx]>";
				if ($design_goods[bGoodsList_1]==1)
				{
					echo "<img src='./upload/goods/$img_str' width=$goodW height=$goodH border=0>";
				}
				echo "</a>";
				if ($design_goods[bGoodsList_2]==1)
				{
					echo "<br><font color=$design_goods[gname_color]><b>$name</b></font>";
				}
				if ($design_goods[bGoodsList_4]==1)
				{
					if($goods_row[bOldPrice])
					{
						echo "<BR><strike>".PriceFormat($goods_row[oldPrice])." 원</strike>";
					}
					if ($goods_row[bSaleper] && $goods_row[sale])
					{
						echo "<font color=#D83232>($goods_row[sale]%)</font>";
					}
					echo "<br><img src=upload/goods_price_img> <b><font color=$design_goods[gprice_color]>$price 원</font></b>";
				}
				if ($design_goods[bGoodsList_5]==1)
				{
					if ($admin_row[bUsepoint])
					{
						echo "<br><img src=upload/goods_point_img><font color=$design_goods[gpoint_color]> ".$gprice->PutPoint2()." 원</font>";
					}
				}
				echo "<br>$bHit $bNew $bEtc";
				if ($goods_row[strPart1]) echo "<br><img src=admin/image/option.gif>";
				if (($goods_row[bLimit] && !$goods_row[limitCnt]) || $goods_row[bLimit]==2)
				{
					echo "<br>";
					if (file_exists("./upload/no_good_img")) { echo "<img src=./upload/no_good_img align=absmiddle>"; }
					else { echo "<FONT COLOR=#990000>품절</FONT>"; }
				}
				echo "</td>";
				if ($cnt%4==0)
				{
					echo "</tr></table>";
					$jscnt++;
				}
			}
		}
		if ($cnt%4!=0)
		{
			for($k=0; $k< ($cnt%4); $k++)
			{
				echo "<td width='175'>&nbsp;</td>";
			}
			echo "</tr></table>";
		}
		?>
		</div>
		</div>
		</td>
	</tr>
	<tr>
		<td height="2"></td>
	</tr>
</table>
<script>banner_roll("banner_1", "table", <?= $design[mainScrollHeight]?>, <?= $design[mainScrollWait]*1000?>, <?= $design[mainScrollSpeed]?>, 0, 1, 1);</script>