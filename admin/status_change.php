<?
include "head.php";
$trans_company = $admin_row[transCom];	// 목록상에서 거래상태 일괄변경했을때 미리 배송사변수 설정해야함 
$sms = $MySQL->fetch_array("select * from smsinfo");
if (!$tgidx) $type = "all"; // 일괄배송임을 명시

// 주문상태 배열            0			1		2		3			4		5
// $TRADE_ARR	 = array("주문접수","결제확인","배송중","배송완료","주문취소","반품처리");

$sdayArr = array("sday1","sday2","sday3","sday4","sday5","sday6");
if ($data) $dataArr = Decode64($data);

// 목록상에서 거래상태 일괄변경했을때
if ($status_list_change == "y")
{
	$str = Laststrcut($select_str);
	$str_arr = explode("/",$str);
	if (count($str_arr)<2) $str_arr[0] = $str;
	$formno_str = Laststrcut($formno_str);
	$formno_str_arr = explode("/",$formno_str);
	if (count($formno_str_arr)<2) $formno_str_arr[0] = $formno_str;
	$transnum_str = Laststrcut($transnum_str);
	$transnum_str_arr = explode("/",$transnum_str);
	if (count($transnum_str_arr)<2) $transnum_str_arr[0] = $transnum_str;
}
else	// 목록 일괄변경이 아닐때도 for문을 돌기때문에 $str_arr[0] 에 trade_row idx값 넣음 
{
	$str_arr[0] = $dataArr[idx];
	$trans_company = $tc;
	$transnum_str_arr[0] = $tn;
}
for ($status_i=0; $status_i<count($str_arr); $status_i++)
{
	$trade_row	= $MySQL->fetch_array("select *from trade where idx=$str_arr[$status_i]");	// 주문정보
	$nowStatus	= $trade_row[status];	// 현재상태
	$newStatus	= $status;	// 새로운 상태

	// 개별배송이 아닐때 trade에 배송사,송장번호를 업데이트 
	// if (!$tgidx && $newStatus>=2 && $newStatus<=3)
	// 전체 주문건에 대한 최종거래상태는 갱신한다. 
	$qry="update trade set status=$newStatus WHERE tradecode='$trade_row[tradecode]'";
	$MySQL->query($qry);
	$tgnum = $MySQL->articles("SELECT idx from trade_goods WHERE tradecode='$trade_row[tradecode]'");
	// $tgidx값이 있으면 개별상품 상태변경임. 
	if ($tgidx) $TG_QRY = " and idx=$tgidx";	// 주문상품이 한개일때는 주문취소상태로 일괄변경해도 바뀌도록 1.31 재수정
	else if ($tgnum==1) $TG_QRY = "";
	else $TG_QRY = " and status<4";	// 개별 주문상품변경이 아니라면 주문취소 이하인 상태만 변경되도록!! 2006. 1. 4 수정  
	$qry = "select * from trade_goods where tradecode='$trade_row[tradecode]' $TG_QRY";
	$result = $MySQL->query($qry);
	$goods_name = "";
	while($trade_goods_row = mysql_fetch_array($result))
	{
		$nowStatus		= $trade_goods_row[status];	//현재상태
		$newStatus		= $status;			//새로운 상태
		$goods_row = $MySQL->fetch_array("select * from goods where idx=$trade_goods_row[goodsIdx]");
		// 재고수량 변경
		if($goods_row[bLimit])
		{
			if($nowStatus <4 && $newStatus >3)
			{
				@$MySQL->query("update goods set limitCnt=limitCnt+$trade_goods_row[cnt] where idx=$trade_goods_row[goodsIdx]");
			} // 주문취소에서 배송완료로 
			else if($nowStatus >3 && $newStatus <4)
			{
				@$MySQL->query("update goods set limitCnt=limitCnt-$trade_goods_row[cnt] where idx=$trade_goods_row[goodsIdx]");
			}
		}
		$goods_name.=$goods_row[name]."<br>";
		$nowsdayArr = array("$trade_goods_row[sday1]","$trade_goods_row[sday2]","$trade_goods_row[sday3]","$trade_goods_row[sday4]","$trade_goods_row[sday5]","$trade_goods_row[sday6]");		//현재 상태 날짜 배열
		//=====================================  해당 상품 날짜 변경 =================================================================== 
		if($newStatus ==0)
		{
			for($i=1;$i<count($sdayArr);$i++)
			{
				$editQry = "update trade_goods set $sdayArr[$i] = NULL where idx=$trade_goods_row[idx]";
				@$MySQL->query($editQry) or die("Err. : $editQry");
			}
		}
		else if($nowStatus > $newStatus)
		{
			for($i=$newStatus;$i<count($sdayArr);$i++)
			{
				if($i==$newStatus)
				{
					$editQry = "update trade_goods set $sdayArr[$i] = now() where idx= $trade_goods_row[idx]";
					$editQry1 = "update trade set $sdayArr[$i] = now() where tradecode='$trade_goods_row[tradecode]'";
				}
				else
				{
					$editQry = "update trade_goods set $sdayArr[$i] = NULL where idx=$trade_goods_row[idx]";
					$editQry1 = "update trade set $sdayArr[$i] = NULL where tradecode='$trade_goods_row[tradecode]'";
				}
				@$MySQL->query($editQry) or die("Err. : $editQry");
				@$MySQL->query($editQry1) or die("Err. : $editQry1");
			}
		}
		else
		{
			/////주문취소 밑의 단계일때////////// 
			if($newStatus <4)
			{
				for($i=0;$i<$newStatus;$i++)
				{
					if(empty($nowsdayArr[$i]))
					{
						$editQry = "update trade_goods set $sdayArr[$i] =now() where idx=$trade_goods_row[idx]";
						@$MySQL->query($editQry) or die("Err. : $editQry");
						$editQry1 = "update trade set $sdayArr[$i] =now() where tradecode='$trade_goods_row[tradecode]'";
						@$MySQL->query($editQry1) or die("Err. : $editQry1");
					}
				}
				$editQry = "update trade_goods set $sdayArr[$newStatus] =now() where idx=$trade_goods_row[idx]";
				$editQry1 = "update trade set $sdayArr[$newStatus] =now() where tradecode='$trade_goods_row[tradecode]'";
				$MySQL->query($editQry);
				$MySQL->query($editQry1);
				////배송완료전 상태에서 주문취소 상태로//
			}
			else if($newStatus >3 && $nowStatus <4)
			{
				$editQry = "update trade_goods set $sdayArr[$newStatus] =now() where idx=$trade_goods_row[idx]";
				$MySQL->query($editQry);
			}
			else
			{
				$editQry = "update trade_goods set $sdayArr[$newStatus] =now(),$sdayArr[$nowStatus]=NULL where idx=$trade_goods_row[idx]";
				$MySQL->query($editQry);
			}
		}
		$qry = "update trade_goods set status=$newStatus";
		if ($transnum_str_arr[$status_i] && ($newStatus==2 || $newStatus==3))
		{
			$qry.=" ,trans_num='$transnum_str_arr[$status_i]'"; // 송장번호 있을때만 업데이트 
			$qry.=" ,trans_company='$trans_company'"; // 택배사 첫 업데이트일때 
		}
		$qry.=" where idx=$trade_goods_row[idx]";
		$MySQL->query($qry);
	} /////////////////// while 
	//=====================================  배송 메일발송 ========================================================================
	if($newStatus==2 && $admin_row[bTramail]=="y" )
	{
		$trans_company = $trans_company;
		$trans_num = $transnum_str_arr[$status_i];
		if (!$tgidx) $type = "all"; // 일괄배송임을 명시 
		include "../email/goods_trans.php";
	}
	if($newStatus==2)
	{
		//sms 보내기 시작/////////////////////////////////////////////////////////////////////////////
		if($sms[bSms] && !empty($sms[userid]) && !empty($sms[pwd]))
		{
			//배송 sms 보내기
			$SMS_PART = "send";
			include "../sms/smsclient.php";
		}
		//sms 보내기 끝/////////////////////////////////////////////////////////////////////////////
	}
	//=====================================  주문취소 메일발송 ========================================================================
	if($newStatus==4 && $admin_row[bEscmail]=="y" )
	{
		include "../email/goods_order_cancel.php";
		///////4.3 추가 
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
					include "../sms/smsclient.php";
				}
			}
			else //비회원이면 무조건 SMS발송
			{
				$SMS_PART = "cancel";
				include "../sms/smsclient.php";
			}
		}
		///////4.3 추가 끝 
	}
	//=====================================  결제확인 메일발송 ========================================================================
	if($newStatus==1)
	{
		if (!$tgidx) $type = "all"; // 일괄배송임을 명시 
		include "../email/b2b_credit.php"; // 관리자,고객 
	}
	if($trade_row[userid_part]=="member")
	{
		///////////////////////////////////// 회원일 경우 적립금 설정//////////////////////////
		$qry = "select * from trade_goods where tradecode='$trade_row[tradecode]' $TG_QRY";
		$result = $MySQL->query($qry);
		while ($trade_goods_row = mysql_fetch_array($result))
		{
			//배송완료 , 주문취소
			$MySQL->query("select *from trade_goods where status=3 and tradecode='$trade_row[tradecode]'");
			$completeTrCnt = $MySQL->is_affected();
			$MySQL->query("select *from trade_goods where status > 3 and tradecode='$trade_row[tradecode]'");
			$cancelTrCnt = $MySQL->is_affected();
			$MySQL->query("select *from trade_goods where tradecode='$trade_row[tradecode]'");
			$goodsTrCnt = $MySQL->is_affected();
			// 상품의 해당 적립금 적립 /회수
			if($trade_goods_row[bPsupply]==0 && $newStatus ==3)
			{
				//적립금 지급
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
				// 회원 구매수, 구매액 수정	 
				if(empty($buyNum[0])) $buyNum[0] =0;
				if(empty($buyMoney[0])) $buyMoney[0] =0;
				$editQry = "update member set buyNum=$buyNum[0],buyMoney=$buyMoney[0],nearBuy=now() where userid='$trade_row[userid]'";
				$MySQL->query($editQry);
				// 주문취소시
			}
			else if($trade_goods_row[bPsupply]==1 && $newStatus!=3)
			{
				//지급된 적립금 회수
				$MySQL->query("update trade_goods set bPsupply =0 where idx=$trade_goods_row[idx]");
				if ($trade_goods_row[goodsP])
				{
					$MySQL->query("update member set point=point-$trade_goods_row[goodsP] where userid='$trade_row[userid]'");
					$trade_goodsP =$trade_goods_row[goodsP]*(-1);
					$point_qry = "insert into point_table(part,userid,point,reason,writeday)values(";
					$point_qry.= "'회수','$trade_row[userid]',$trade_goodsP,'배송완료 -> $TRADE_ARR[$newStatus] [주문코드:$trade_goods_row[tradecode]]',now())";
					$MySQL->query($point_qry);
				}
				// 구매후기를 작성한 내역이 있으면 구매후기적립금 회수
				if ($MySQL->articles("SELECT idx from point_table WHERE userid='$trade_row[userid]' and part='지급' and tradecode='$trade_goods_row[tradecode]' limit 1"))
				{
					$backP_row = $MySQL->fetch_array("SELECT point from point_table WHERE userid='$trade_row[userid]' and tradecode='$trade_goods_row[tradecode]' limit 1");
					$backP = $backP_row[point] * (-1);
					$qry = "update member set point=point+$backP where userid='$trade_row[userid]'";
					$MySQL->query($qry);
					$point_qry = "insert into point_table(part,userid,point,reason,writeday)values(";
					$point_qry.= "'회수','$trade_row[userid]',$backP,'구매취소로 인한 구매후기작성 적립금 회수 [주문코드:$trade_goods_row[tradecode]]',now())";
					$MySQL->query($point_qry);
				}
				// 주문취소시 회원정보의 구매수,구매액 업데이트
				$buyNum = $MySQL->fetch_array("select count(*) from trade where userid='$trade_row[userid]' and bPay=1 and status<4");
				$buyMoney =$MySQL->fetch_array("select sum(payM) from trade where userid='$trade_row[userid]' and bPay=1 and status<4");
				// 회원 구매수, 구매액 수정
				if(empty($buyNum[0])) $buyNum[0] =0;
				if(empty($buyMoney[0])) $buyMoney[0] =0;
				$editQry = "update member set buyNum=$buyNum[0],buyMoney=$buyMoney[0] where userid='$trade_row[userid]'";
				$MySQL->query($editQry);
			}
		}
		// 주문시 적립금사용 / 복구
		if($trade_row[useP])
		{
			if($trade_row[bPsupply]==0 && $cancelTrCnt != $goodsTrCnt)
			{
				// 상품구매시 적립금 사용 적용 
				$MySQL->query("update trade set bPsupply=1 where idx=$str_arr[$status_i]");
				$MySQL->query("update member set point=point-$trade_row[useP] where userid='$trade_row[userid]'");
				$trade_goodsP =$trade_row[useP]*(-1);
				$point_qry = "insert into point_table(part,userid,point,reason,writeday)values(";
				$point_qry.= "'사용','$trade_row[userid]',$trade_goodsP,'상품구매 [주문코드:$trade_row[tradecode]]',now())";
				$MySQL->query($point_qry);
			}
			else if($trade_row[bPsupply]==1 && $cancelTrCnt == $goodsTrCnt)
			{
				// 사용한 적립금 복구 주문취소 
				$MySQL->query("update trade set bPsupply=0 where idx=$str_arr[$status_i]");
				$MySQL->query("update member set point=point+$trade_row[useP] where userid='$trade_row[userid]'");
				$point_qry = "insert into point_table(part,userid,point,reason,writeday)values(";
				$point_qry.= "'복구','$trade_row[userid]',$trade_row[useP],";
				$point_qry.= "'$TRADE_ARR[$nowStatus] -> $TRADE_ARR[$newStatus] [주문코드:$trade_row[tradecode]]',now())";
				$MySQL->query($point_qry);
			}
		}
	}
}
if ($status_list_change=="y")
{
	OnlyMsgView("완료하였습니다.");
	echo "<script>parent.location.reload();</script>";
}
else if ($tgidx) Refresh("trade_order_view.php?data=$data");
else close_par_refresh();
?>