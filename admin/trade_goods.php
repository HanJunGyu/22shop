<?
$now = date("YmdHims",time());
$EXCEL_NAME = "goods_".$now;
if($_GET[excel])
{
	header( "Content-type: application/vnd.ms-excel; charset=ks_c_5601-1987");
	header( "Content-Disposition: attachment; filename=$EXCEL_NAME.xls");
	header( "Content-Description: PHP4 Generated Data");
}
include "head.php";
echo "<script>document.title = '결제확인주문 재고파악 $now';</script>";
?>
<table width=100% cellspacing="1" cellpadding="0" bordercolor="#000000" border=1>
	<tr bgcolor="eeeeee" height=30>
		<td align=center>상품명</td>
		<td width=20% align=center>옵션</td>
		<td width=7% align=center>구매수량</td>
		<td width=15% align=center>재고수량</td>
		<td width=15% align=center>결제일</td>
	</tr><?
	$trade_goods_result = $MySQL->query("SELECT sum(cnt),name,goodsIdx,sday2,tradecode,option1,option2,option3 from trade_goods WHERE status=1 $MALL_STR group by goodsIdx order by sday2 asc");
	while ($trade_goods_row = mysql_fetch_array($trade_goods_result))
	{
		$goods_row = $MySQL->fetch_array("SELECT bLimit,limitCnt from goods WHERE idx=$trade_goods_row[goodsIdx] limit 1");
		$trade_row = $MySQL->fetch_array("SELECT name from trade WHERE tradecode='$trade_goods_row[tradecode]' limit 1");

		///////////옵션//////////////
		$optionArr = Array("$trade_goods_row[option1]","$trade_goods_row[option2]","$trade_goods_row[option3]");	//옵션 배열
		///////////재고////////////
		if ($goods_row[bLimit] && !$goods_row[limitCnt]) $STOCK = "<font color=red><b>품절</b></font>";
		else if ($goods_row[bLimit] && $goods_row[limitCnt]) $STOCK = $goods_row[limitCnt];
		else $STOCK = "무제한";
		if (is_numeric($STOCK) && $STOCK < $trade_goods_row[0]) $EMPTY_STOCK = " <b>[재고부족]</b>";
		else $EMPTY_STOCK = "";
		?>
	<tr height=25 align=center>
		<td align=center><?=$trade_goods_row[name]?> <?=$trade_goods_row[tradecode]?></td>
		<td align=center>
			<table width="100%" border="0" cellspacing="0" cellpadding="0"><?
			for($i=0;$i<count($optionArr);$i++)
			{
				if(!empty($optionArr[$i]))
				{
					$option = explode("」「",$optionArr[$i]);
					?>
				<tr>
					<td width="40%"  bgcolor="#F7F7F7"><div align="center"><?=$option[0]?> </div></td>
					<td   bgcolor="#DDFFFB"><div align="left"> : <?=$option[1]?></div></td>
				</tr>
				<tr bgcolor="#CCCCCC">
					<td colspan="2" height="1"></td>
				</tr><?
				}
			}
			?>
			</table>
		</td>
		<td align=center><?=$trade_goods_row[0]?></td>
		<td align=center><?=$STOCK?> <?=$EMPTY_STOCK?></td>
		<td align=center><?=$trade_goods_row[sday2]?></td>
	</tr><?
	}//while

	if(!$excel)
	{
		?>
	<tr>
		<td height=50 colspan=6 align=center><img src="image/print_btn.gif" onclick="window.print();" style="cursor:pointer;">&nbsp;&nbsp;&nbsp;<a href="trade_goods.php?excel=1"><img src="image/excel_down.gif"></a>&nbsp;&nbsp;&nbsp;<img src="image/close_btn.gif" onclick="self.close();" style="cursor:pointer;"></td>
	</tr><?
	}
		?>
</table>