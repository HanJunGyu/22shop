<?
include "head.php";

if ($_POST["del_trade"]) // 검색기간이전의 주문정보 삭제
{
	if (strlen($mo)==1) $mo = "0".$mo;
	if (strlen($da)==1) $da = "0".$da;
	$day = $ye."-".$mo."-".$da;
	$MySQL->query("DELETE from trade WHERE writeday < '$day'");
	$MySQL->query("DELETE from trade_temp WHERE writeday < '$day'");
	$MySQL->query("DELETE from trade_goods WHERE sday1 < '$day'");
	MsgViewHref("삭제 완료하였습니다.","trade_order.php");
	exit;
}
if ($data) $dataArr = Decode64($data);
$trade_row = $MySQL->fetch_array("select * from trade where idx=$dataArr[idx]");

if($del)
{
	//===================================== 상품의 해당 재고량 복구============================================================
	if ($trade_row[bPay]) // 주문이 미결제된것은 재고삭감이 없으므로 제외한다
	{
		$qry = "select *from trade_goods where tradecode='$trade_row[tradecode]' and status <4";
		$result = @$MySQL->query($qry);
		while($trade_goods_row = mysql_fetch_array($result))
		{
			$goods_row = $MySQL->fetch_array("select *from goods where idx=$trade_goods_row[goodsIdx] limit 1");
			if($goods_row[bLimit])
			{
				@$MySQL->query("update goods set limitCnt=limitCnt+$trade_goods_row[cnt]  where idx=$trade_goods_row[goodsIdx]");
			}
		}
	}

	//////////////////////// 적립금 복구 ////////////////////////////////////////////////////////
	if($trade_row[userid_part]=="member")
	{
		///////////////////////////////////// 회원일 경우 적립금 설정//////////////////////////
		//===================================== 상품의 해당 적립금 회수============================================================
		$qry = "select *from trade_goods where tradecode='$trade_row[tradecode]' and bPsupply=1";
		$result = @$MySQL->query($qry);
		while($trade_goods_row = mysql_fetch_array($result))
		{
			@$MySQL->query("update member set point=point-$trade_goods_row[goodsP] where userid='$trade_row[userid]'");
			$trade_goodsP =$trade_goods_row[goodsP]*(-1);
			$point_qry = "insert into point_table(part,userid,point,reason,writeday)values(";
			$point_qry.= "'회수','$trade_row[userid]',$trade_goodsP,'주문서 삭제 [주문코드:$trade_goods_row[tradecode]]',now())";
			@$MySQL->query($point_qry);
		}
		//===================================== 사용한 적립금 복구 ===============================================================
		if($trade_row[bPsupply]==1 && $trade_row[useP])
		{
			@$MySQL->query("update member set point=point+$trade_row[useP] where userid='$trade_row[userid]'");
			$point_qry = "insert into point_table(part,userid,point,reason,writeday)values(";
			$point_qry.= "'복구','$trade_row[userid]',$trade_row[useP],'주문서 삭제 [주문코드:$trade_row[tradecode]]',now())";
			@$MySQL->query($point_qry);
		}
		//회원정보의 구매수,구매액 업데이트//
		$buyNum = $MySQL->fetch_array("select count(*) from trade where userid='$trade_row[userid]' and bPay=1 and status<4");
		$buyMoney =$MySQL->fetch_array("select sum(totalM) from trade where userid='$trade_row[userid]' and bPay=1 and status<4");
		//회원 구매수, 구매액 수정
		if(empty($buyNum[0])) $buyNum[0] =0;
		if(empty($buyMoney[0])) $buyMoney[0] =0;
		$editQry = "update member set buyNum=$buyNum[0],buyMoney=$buyMoney[0] where userid='$trade_row[userid]'";
		@$MySQL->query($editQry);
	}
	/////////////////////////////////////////////////////////////////////////////////////////////
	if($MySQL->query("delete from trade_goods where tradecode='$trade_row[tradecode]'"))
	{
		if($MySQL->query("delete from trade where idx=$dataArr[idx]"))
		{
			OnlyMsgView("삭제완료 하였습니다.");
			close_par_refresh();
		}
		else
		{
			echo"trade delete Err.";
		}
	}
	else
	{
		echo"trade_goods delete Err.";
	}
}
?>