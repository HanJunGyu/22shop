<?
include "head.php";
$now = time();
$now = date("Y-m-d",$now);
$now = explode("-",$now);
if (!$year) // 날짜검색없을떄 
{
	$year = $now[0];
	$month = $now[1];
	$day = 1;
	$year2 = $now[0];
	$month2 = $now[1];
	$day2 = 31;
	if (strlen($day)==1) $day = "0".$day;
	if (strlen($month)==1) $month = "0".$month;
	if (strlen($day2)==1) $day2 = "0".$day2;
	if (strlen($month2)==1) $month2 = "0".$month2;
	$start = $year."-".$month."-".$day;
	$end = $year2."-".$month2."-".$day2;
}
else // 날짜검색있을때
{
	if (strlen($day)==1) $day = "0".$day;
	if (strlen($month)==1) $month = "0".$month;
	if (strlen($day2)==1) $day2 = "0".$day2;
	if (strlen($month2)==1) $month2 = "0".$month2;
	$start = $year."-".$month."-".$day;
	$end = $year2."-".$month2."-".$day2;
}
?>
<SCRIPT LANGUAGE="JavaScript">
<!--
<? if ($page_print){ ?>
document.title = "상품매출통계";
window.print();
<? } ?>
function print_page()
{
	window.open("<?=$PHP_SELF?>?page_print=1","","scrollbars=yes,left=10,top=10,width=850,height=650,toolbar=yes");
}
///////////////// A ~ Z 검색버튼 누를때 날짜범위도 같이 반영하기 위해 searchForm을 submit함 
function abc_func(url)
{
	var form = document.searchForm;
	form.action = form.action + "?" + url;
	form.submit();
}
function search_submit()
{
	var form = document.searchForm;
	form.action = form.action + "?POS_GOODTYPE=" + "<?=$POS_GOODTYPE?>";
	form.submit();
}
//-->
</SCRIPT>
<body bgcolor="#FFFFFF" text="#5A595A" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<? if (!$page_print) include "top_menu.php";?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr><?
	$__TOP_MENU = "data";     //왼쪽 소메뉴 설정 변수
	if (!$page_print) include "left_menu.php";
	?>
		<td width="85%" valign="top">
			<table width="100%" height="500" border="0" cellspacing="0" cellpadding="0"><?
			if (!$page_print)
			{
				?>
				<tr>
					<td height='5'></td>
				</tr>
				<tr>
					<td>
						<table width="750" border="0" cellspacing="0" cellpadding="0" align='center'>
							<tr>
								<td rowspan="3" width="200"><img src="image/graph_tit_img.gif"></td>
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
					<td height="2">
						<table width="750" border="0" cellspacing="0" cellpadding="0" align="center">
							<tr>
								<td bgcolor='DADADA' height='1'></td>
							</tr>
							<tr>
								<td>
									<table width="750" border="0" cellspacing="0" cellpadding="0" align="center">
										<tr>
											<td width='440'><img src="image/good_list_tit02.gif"></td>
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
						</table>
					</td>
				</tr><?
			}
			?>
				<tr>
					<td valign="top">
						<table width="800" border="0" cellspacing="1" cellpadding="1" align="center" bgcolor='cdcdcd'>
							<tr>
								<td colspan=5 bgcolor='ffffff'><font color="#999999">※ 계산처리가 많은 페이지이므로 자료량이 많아질경우 페이지 로딩이 느려질수 있습니다.</font></td>
							</tr>
							<form name="searchForm" method="post" action="goods_stat.php">
							<input type="hidden" name="search" value="1">
							<tr>
								<td colspan=5 bgcolor='f6f6f6'><select name="year"><?
								for ($i=$now[0]; $i>$now[0]-5; $i--)
								{
									?><option value="<?=$i?>" <? if ($i == $year) echo "selected";?>><?=$i?></option><?
								}
								?></select>년 <select name="month"><?
								for ($i=1; $i<13; $i++)
								{
									?><option value="<?=$i?>" <? if ($i == $month) echo "selected";?>><?=$i?></option><?
								}
								?></select>월 <select name="day"><?
								for ($i=1; $i<32; $i++)
								{
									?><option value="<?=$i?>" <? if ($i == $day) echo "selected";?>><?=$i?></option><?
								}
								?></select>일 ~ <select name="year2"><?
								for ($i=$now[0]; $i>$now[0]-5; $i--)
								{
									?><option value="<?=$i?>" <? if ($i == $year2) echo "selected";?>><?=$i?></option><?
								}
								?></select>년 <select name="month2"><?
								for ($i=1; $i<13; $i++)
								{
									?><option value="<?=$i?>" <? if ($i == $month2) echo "selected";?>><?=$i?></option><?
								}
								?></select>월 <select name="day2"><?
								for ($i=1; $i<32; $i++)
								{
									?><option value="<?=$i?>" <? if ($i == $day2) echo "selected";?>><?=$i?></option><?
								}
								?></select>일 &nbsp;&nbsp;<a href="javascript:search_submit();"><img align="absmiddle" src="image/bbs_search_btn.gif" width="41" height="23" border="0"></a>&nbsp;&nbsp;<a href="javascript:abc_func('POS_GOODTYPE=mainbest&parentcode=<?=$parent_row[code]?>')"><img src="image/stat_mainbest.jpg"></a>&nbsp;&nbsp;<a href="javascript:abc_func('POS_GOODTYPE=mainhit&parentcode=<?=$parent_row[code]?>')"><img src="image/stat_mainhit.jpg"></a>&nbsp;&nbsp;<a href="javascript:abc_func('POS_GOODTYPE=mainnew&parentcode=<?=$parent_row[code]?>')"><img src="image/stat_mainnew.jpg"></a>&nbsp;&nbsp;<a href="javascript:abc_func('POS_GOODTYPE=best&parentcode=<?=$parent_row[code]?>')"><img src="image/stat_catebest.jpg"></a></td>
							</tr>
							</form>
							<tr bgcolor="#EBEBEB">
								<td align="center" width=15% height=30>분류명</td>
								<td align="center" width=10%>총상품/구매수</td>
								<td align="center" width=11% bgcolor="#9CEFFF">판매가합</td>
								<td align="center" width=9% bgcolor="#9CEFFF">공급가합</td>
								<td align="center" width=6% bgcolor="#9CEFFF">매익률</td>
							</tr><?
							$day_search = "and left(sday1,10) between '$start' and '$end'";
							$category_sum_arr = Array(); /////////// 카테고리별 매출액 저장배열
							$category_cnt = 0;
							$parent_result = $MySQL->query("SELECT name,code from category WHERE deep=0 order by position asc");
							while ($parent_row = mysql_fetch_array($parent_result))
							{
								$cnt = 0; 
								$total_norm_goods_num= 0;
								$total_trade_goods_price = 0;
								$total_trade_goods_sprice = 0;
								$total_trade_goods_num =0;
								$parent_name = $parent_row[name];
								/////////// 해당 카테고리의 하부 카테고리들 정보 추출 /////////////// 
								$cate_result = $MySQL->query("SELECT name,code from category WHERE code='$parent_row[code]'");
								while ($cate_row = mysql_fetch_array($cate_result))
								{
									// 판매가합
									$trade_goods_result = $MySQL->query("SELECT sum(price * cnt) from trade_goods WHERE category='$cate_row[code]' and status>0 and status<4 $day_search");
									$trade_goods_price = mysql_result($trade_goods_result,0);
									$total_trade_goods_price+= $trade_goods_price;
									$trade_goods_sresult = $MySQL->query("SELECT sum(sprice * cnt) from trade_goods WHERE category='$cate_row[code]' and status>0 and status<4 $day_search"); 
									$trade_goods_sprice = mysql_result($trade_goods_sresult,0);
									$total_trade_goods_sprice+= $trade_goods_sprice;
									// 구매수
									$trade_goods_num = $MySQL->articles("SELECT idx from trade_goods WHERE category='$cate_row[code]' and status>0 and status<4 $day_search");
									////// 상품정보 추출 ///////
									$norm_goods_num = $MySQL->articles("SELECT idx from goods WHERE category='$cate_row[code]' ");
									///////종합적인 상품별 구매합/////////// 
									$total_trade_goods_num+= $trade_goods_num;
									///////해당 카테고리 상품별 구매합//////////
									$total_norm_goods_num+= $norm_goods_num;
									$cnt++;
								}
								// 매익률
								if ($total_trade_goods_price) $profit = (($total_trade_goods_price - $total_trade_goods_sprice) / $total_trade_goods_price) * 100; 
								else $profit=0;
								$category_sum_arr[$category_cnt] = $total_trade_goods_price; ////////// 추후 통계그래프를 위해 //////////
								?>
							<tr bgcolor="ffffff">
								<td align="right" height=25><?=$parent_name?></td>
								<td align="right"><?=$total_norm_goods_num?> / <?=$total_trade_goods_num?></td>
								<td align="right">총합 <?=PriceFormat($total_trade_goods_price)?></td>
								<td align="right"><?=PriceFormat($total_trade_goods_sprice)?></td>
								<td align="right"><?=round($profit,1)." %"?></td>
							</tr><?
								$all_goods_num+= $total_norm_goods_num;
								$all_trade_goods_num+= $total_trade_goods_num;
								$all_goods_price+= $total_trade_goods_price;
								$all_goods_sprice+= $total_trade_goods_sprice;
								if ($all_goods_price) $total_profit = (($all_goods_price - $all_goods_sprice) / $all_goods_price) * 100;
								$category_cnt++;
							}
							?>
							<tr bgcolor="#EBEBEB">
								<td align="right" height=30><B>T O T A L</B></td>
								<td align="right"><?=$all_goods_num?> / <?=$all_trade_goods_num?></td>
								<td align="right">총합 <?=PriceFormat($all_goods_price)?></td>
								<td align="right"><?=PriceFormat($all_goods_sprice)?></td>
								<td align="right"><?=round($total_profit,1)." %"?></td>
							</tr>
						</table><br><?
						//////////////// 상세검색결과가 없을때 기본화면에서 나옴//////////////////// 
						if (!$POS_GOODTYPE)
						{
							?>
						<table class="table_coll" border=1 width="800" align="center">
							<tr>
								<td colspan=4 height="30" bgcolor="f5f5f5" align="center"><b>총매출 대비 카테고리별 매출액 그래프</b> &nbsp;[<?=$start?> ~ <?=$end?>] 결과합계 : &nbsp;<?=PriceFormat($all_goods_price)?> 원</td>
							</tr><?
							global $all_goods_price; //////////// 총 매출액 
							global $category_sum_arr; /////////// 카테고리별 매출액 저장배열    
							$cnt=0;
							$parent_result = $MySQL->query("SELECT name,code from category WHERE deep=0 order by position asc");
							while ($parent_row = mysql_fetch_array($parent_result))
							{
								if(empty($category_sum_arr[$cnt]))	  $buyMPercent  = 0;
								else	$buyMPercent	= $category_sum_arr[$cnt]/$all_goods_price*100;	//구매액 퍼센트
								$graph_img = $buyMPercent * 5;
								?>
							<tr>
								<td align="right" width="150"><?=$parent_row[name]?></td>
								<td align="left" width="500" height="30"><img src="image/graph_01.gif" width="<?=$graph_img?>" height="15"></td>
								<td align="right" width="100"><?=PriceFormat($category_sum_arr[$cnt])?></td>
								<td align="right" width="50"><?=PriceFormat($buyMPercent)?> %</td>
							</tr><?
								$cnt++;
							}
							?>
						</table><br><!-------------- 특정위치 매출 추이 그래프 -----------------><?
							$special_page_arr = Array("메인베스트","메인히트","메인신규","카테고리베스트(대)","카테고리베스트");
							$special_page_code_arr = Array("mainbest","mainhit","mainnew","recommend","best");
							$DAY_SEARCH2 = "and left(tg.sday1,10) between '$start' and '$end'";
							$qry = "SELECT (tg.price * tg.cnt) from trade_goods as tg,position as pos WHERE pos.part = tg.goodtype and tg.status>0 and tg.status<4 and (tg.goodtype='mainbest' or tg.goodtype='mainhit' or tg.goodtype='mainnew' or tg.goodtype='recommend' or tg.goodtype='best') $DAY_SEARCH2 group by pos.part";
							$total_sum_row = $MySQL->fetch_array($qry);
							$total_price = $total_sum_row[0];
						?>
						<table class="table_coll" border=1 width="800" align="center">
							<tr>
								<td colspan=4 height="30" bgcolor="f5f5f5" align="center"><b> 총매출 대비 특정위치 등록상품 매출액 그래프</b> &nbsp;[<?=$start?> ~ <?=$end?>] 결과합계 : &nbsp;<?=PriceFormat($total_price)?> 원</td>
							</tr><?
							for ($i=0; $i<count($special_page_arr); $i++)
							{
								$qry = "SELECT (tg.price * tg.cnt) from trade_goods as tg,position as pos WHERE pos.part = tg.goodtype and tg.status>0 and tg.status<4 and (tg.goodtype='$special_page_code_arr[$i]') $DAY_SEARCH2 group by pos.part"; 
								$sum_row = $MySQL->fetch_array($qry);
								$price = $sum_row[0];
								if   (empty($price))	  $buyMPercent  = 0;
								else	$buyMPercent	= ($price/$all_goods_price) *100;	//구매액 퍼센트
								$graph_img = $buyMPercent * 5;
								?>
							<tr>
								<td align="right" width="150"><?=$special_page_arr[$i]?></td>
								<td align="left" width="500" height="30"><img src="image/graph_01.gif" width="<?=$graph_img?>" height="15"></td>
								<td align="right" width="100"><?=PriceFormat($price)?></td>
								<td align="right" width="50"><?=PriceFormat($buyMPercent)?> %</td>
							</tr><?
							}
							?>
						</table><?
						}
						?><br>
					</td>
				</tr><?
				if (!$page_print)
				{
					?>
				<tr>
					<TD align="center" height="40"><img src="image/print_btn.gif" onclick="print_page();" style="cursor:pointer"></TD>
				</tr><?
				}
				?>
			</table>
		</td>
	</tr>
</table>
<? if (!$page_print) include "copy.php";?>
</body>
</html>