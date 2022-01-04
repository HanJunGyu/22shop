<?
include "head.php";
?>
<table width="850" border="0" cellspacing="3" cellpadding="0">
	<tr bgcolor="#EBEBEB" height=30>
		<td align="center"  width=10%>주문자</td>
		<td align="center"  width=10%>주문번호</td>
		<td align="center" width=10%>주문접수일</td>
		<td align="center" width=30%>상품명</td>
		<td align="center" width=12%>옵션</td>
		<td align="center" width=12%>가격/수량</td>
		<td align="center" width=10%>합계</td>
		<td align="center" width=10%>거래상태</td>
	</tr><?
	if ($all) $result = $MySQL->query("SELECT *from trade_goods order by idx desc");
	else $result = $MySQL->query("SELECT *from trade_goods WHERE userid='$userid' order by idx desc");
	while ($trade_goods_row = mysql_fetch_array($result))
	{
		$optionArr = Array("$trade_goods_row[option1]","$trade_goods_row[option2]","$trade_goods_row[option3]"); //옵션 배열
		$tprice = $trade_goods_row[price]*$trade_goods_row[cnt]; //상품합가격 
		$total_price+= $tprice;
		$goods_row = $MySQL->fetch_array("SELECT *from goods WHERE idx=$trade_goods_row[goodsIdx] limit 1");
		////////주문날짜전에 상품정보가 수정된적이 있으면 수정날짜표시 
		if ($trade_goods_row[sday1] < $goods_row[editday]) $editday = "<br><u>상품정보 최근수정일 : ".Substr($goods_row[editday],0,10)."</u>";
		else $editday = "";
		///////적립금지급이 잘못된주문상품의 수정날짜표시 (수정날짜가 주문시간보다 이전임) 
		if (empty($editday) && ($goods_row[point] * $trade_goods_row[cnt]) != $trade_goods_row[goodsP]) $editday = "<br><u>상품정보 최근수정일 : ".Substr($goods_row[editday],0,10)." (일찍)</u>";
		$trade_row = $MySQL->fetch_array("SELECT userid,userid_part,name from trade WHERE tradecode='$trade_goods_row[tradecode]' limit 1");
		if ($trade_row[userid_part]=="guest") $member_str = $trade_row[name]."<br>비회원";
		else $member_str = $trade_row[name]."<BR>".$trade_row[userid];
		?>
	<tr bgcolor="fafafa">
		<td align="center"><?=$member_str?></td>
		<td align="center"><?=$trade_goods_row[tradecode]?></td>
		<td align="center"><?=$trade_goods_row[sday1],0,10?></td>
		<td align="center"><?=$trade_goods_row[name]?> <?=$editday?></td>
		<td align="center"><div align="center">
			<table width="100" border="0" cellspacing="0" cellpadding="0"><?
			for($i=0;$i<count($optionArr);$i++)
			{
				if(!empty($optionArr[$i]))
				{
					$option = explode("」「",$optionArr[$i]);
					?>
				<tr>
					<td width="45"  bgcolor="#F7F7F7"> <div align="center"><?=$option[0]?> </div></td>
					<td   bgcolor="#DDFFFB"> <div align="left"> : <?=$option[1]?></div></td>
				</tr>
				<tr  bgcolor="#CCCCCC">
					<td colspan="2" height="1"></td>
				</tr><?
				}
			}
			?>
			</table></div>
		</td>
		<td align="center"><?=PriceFormat($trade_goods_row[price])?> / <?=$trade_goods_row[cnt]?></td>
		<td align="center"><?=PriceFormat($tprice)?><br>적립 : <?=PriceFormat($trade_goods_row[goodsP])?></td>
		<td align="center"><?=$TRADE_ARR[$trade_goods_row[status]]?></td>
	</tr>
	<tr>
		<td colspan="8" height="1" background="image/line_bg1.gif"></td>
	</tr><?
	}
	?>
	<tr>
		<td colspan=7 align="right"><b>총합 : <?=PriceFormat($total_price)?> 원</b></td>
	</tr>
	<tr>
		<td colspan=7 align="right"><img src="image/close_btn.gif" border=0 onclick="javascript:self.close();" style="cursor:pointer"></b></td>
	</tr>
</table>