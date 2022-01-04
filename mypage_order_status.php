<?
// 회원이 배송완료 처리하는 모듈
include "head.php";
if (!$_POST["tradecode"])
{
	MsgViewHref("정상적인 접근이 아닙니다.","mypage_order.php");
	exit;
}
if ($cancel)
{
	$trade_row = $MySQL->fetch_array("SELECT * from trade WHERE tradecode='$tradecode' limit 1");
	$result = $MySQL->query("select * from trade_goods where tradecode='$tradecode'");
	while($trade_goods_row = mysql_fetch_array($result))
	{
		$editQry = "update trade_goods set sday5 =now(),status=4 where idx='$trade_goods_row[idx]'";
		$MySQL->query($editQry);
		$goods_row = $MySQL->fetch_array("select * from goods where idx=$trade_goods_row[goodsIdx]");
		if($goods_row[bLimit])
		{
			$MySQL->query("update goods set limitCnt=limitCnt+$trade_goods_row[cnt] where idx=$trade_goods_row[goodsIdx]");
		}
	}
	///4.3추가 
	$sms = $MySQL->fetch_array("select * from smsinfo");
	if($sms[bSms] && !empty($sms[userid]) && !empty($sms[pwd]))
	{
		$temp_row[name] = $trade_row[name];
		$temp_row[hand] = $trade_row[hand];
		$payMethod = $trade_row[payMethod];
		$trade_goods_row = $MySQL->fetch_array("SELECT name from trade_goods WHERE tradecode='$trade_row[tradecode]' limit 1");
		$SMS_GOODS = StringCut($trade_goods_row[name],20);
		if ($trade_row[userid_part]=="member") //회원구매
		{
			if ($MySQL->articles("SELECT idx from member WHERE userid='$trade_row[userid]' and bSms='y'")) // SMS 수신 허용했는지
			{
				$SMS_PART = "cancel";
				include "./sms/smsclient.php";
			}
		}
		else //비회원이면 무조건 SMS발송
		{
			$SMS_PART = "cancel";
			include "./sms/smsclient.php";
		}
	}
	///4.3추가끝 
	if($trade_row[bPsupply]==1 && $trade_row[useP])
	{
		$MySQL->query("update member set point=point+$trade_row[useP] where userid='$trade_row[userid]'");
		$point_qry = "insert into point_table(part,userid,point,reason,writeday)values(";
		$point_qry.= "'복구','$trade_row[userid]',$trade_row[useP],'주문서 삭제 [주문코드:$trade_row[tradecode]]',now())";
		$MySQL->query($point_qry);
	}
	$editQry = "update trade set sday5 =now() ,status=4 where tradecode='$tradecode'";
	$MySQL->query($editQry);
	$encode_str = "idx=".$trade_row[idx];
	$data=Encode64($encode_str);
	if (!$guest) MsgViewHref("주문취소 처리되었습니다. 감사합니다.","mypage_order_detail.php?data=$data");
	else MsgViewHref("주문취소 처리되었습니다. 감사합니다.","order_detail_nomem.php?tradecode=$tradecode");
}
else
{
	$trade_row = $MySQL->fetch_array("SELECT *from trade WHERE tradecode='$tradecode' limit 1");
	$result = $MySQL->query("SELECT *from trade_goods WHERE tradecode='$trade_row[tradecode]'");
	while($trade_goods_row = mysql_fetch_array($result))
	{
		$nowStatus		= $trade_goods_row[status];	//현재상태
		$newStatus		= 3;			//새로운 상태
		$i = $newStatus;
		$sdayArr = array("sday1","sday2","sday3","sday4","sday5","sday6");
		$nowsdayArr = array("$trade_goods_row[sday1]","$trade_goods_row[sday2]","$trade_goods_row[sday3]","$trade_goods_row[sday4]","$trade_goods_row[sday5]","$trade_goods_row[sday6]");
		$editQry = "update trade_goods set $sdayArr[$i] =now() where idx=$trade_goods_row[idx]";
		$MySQL->query($editQry);
		$editQry1 = "update trade set $sdayArr[$i] =now() where tradecode='$trade_goods_row[tradecode]'";
		$MySQL->query($editQry1);
		if($trade_row[userid_part]=="member")
		{
			if($trade_goods_row[bPsupply]==0 && $newStatus ==3)
			{
				$MySQL->query("update trade_goods set bPsupply =1 where idx=$trade_goods_row[idx]");
				if ($trade_goods_row[goodsP])
				{
					$MySQL->query("update member set point=point+$trade_goods_row[goodsP] where userid='$trade_row[userid]'");
					$point_qry = "insert into point_table(part,userid,point,reason,writeday)values(";
					$point_qry.= "'적립','$trade_row[userid]',$trade_goods_row[goodsP],'상품구매 [주문코드:$trade_goods_row[tradecode]]',now())";
					$MySQL->query($point_qry);
				}

				// 배송완료시 회원정보의 구매수,구매액 업데이트
				$buyNum = $MySQL->fetch_array("select count(*) from trade where userid='$trade_row[userid]' and bPay=1 and status<4");
				$buyMoney =$MySQL->fetch_array("select sum(payM) from trade where userid='$trade_row[userid]' and bPay=1 and status<4");

				//회원 구매수, 구매액 수정
				if(empty($buyNum[0])) $buyNum[0] =0;
				if(empty($buyMoney[0])) $buyMoney[0] =0;
				$editQry = "update member set buyNum=$buyNum[0],buyMoney=$buyMoney[0],nearBuy=now() where userid='$trade_row[userid]'";
				$MySQL->query($editQry);
			}
		}
		$MySQL->query("update trade_goods set status = $newStatus where idx=$trade_goods_row[idx]");
	}
	$MySQL->query("update trade set status = $newStatus where idx=$trade_row[idx]");

	// 제품후기
	if ($good_str)
	{
		if ($guest=="y")
		{
			$GOOD_SHOP_NAME = $trade_row[name];
			$_SESSION[GOOD_SHOP_USERID] = "비회원";
		}
		$good_str_arr = explode("//",$good_str);
		$comment_str_arr = explode("//",$comment_str);
		if (count($good_str_arr)<2) $good_str_arr[0] = $good_str;
		if (count($comment_str_arr)<2) $comment_str_arr[0] = $comment_str;
		for ($i=0; $i<count($good_str_arr); $i++)
		{
			if ($comment_str_arr[$i])
			{
				$goods_row = $MySQL->fetch_array("SELECT idx,name from goods WHERE idx=$good_str_arr[$i] limit 1");
				$qry = "insert into goods_comment (gidx,userid,content,userIp,name,writeday) values(";
				$qry.= "$good_str_arr[$i],";
				$qry.= "'$_SESSION[GOOD_SHOP_USERID]',";
				$qry.= "'$comment_str_arr[$i]',";
				$qry.= "'$REMOTE_ADDR',";
				$qry.= "'$goods_row[name]',";
				$qry.= "now()";
				$qry.= ")";
				$MySQL->query($qry);
			}
		}

		// 구매후기작성 적립금 지급
		if ($admin_row[bUsepoint] && $admin_row[write_goodsP] && !$guest)
		{
			$pqry = "insert into point_table(part,userid,point,reason,writeday,tradecode)values(";
			$pqry.= "'지급','$_SESSION[GOOD_SHOP_USERID]',$admin_row[write_goodsP],'$tradecode 제품구매후기 작성 ',now(),'$tradecode')";
			$MySQL->query($pqry);
			$MySQL->query("UPDATE member SET point=point+$admin_row[write_goodsP] where userid='$_SESSION[GOOD_SHOP_USERID]'");
		}
	}
	$encode_str = "idx=".$trade_row[idx];
	$data=Encode64($encode_str);
	if (!$guest) MsgViewHref("배송완료 처리되었습니다. 감사합니다.","mypage_order_detail.php?data=$data");
	else MsgViewHref("배송완료 처리되었습니다. 감사합니다.","order_detail_nomem.php?tradecode=$tradecode");
}
?>