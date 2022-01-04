<?
if($sms[company]=="icodekorea")
{
	//  smsWorld SMS 전송 PHP-API Test Sample
	require_once("class.sms.php");
	if($SMS_PART == "member_join")
	{
		//회원가입
		$SMS = new SMS($sms[userid],$sms[pwd],$sms[gubun]);
		$adminTel = str_replace("-","",$sms[adminTel]);
		$retel= str_replace("-","",$sms[retel]);
		if($sms[bSend1])
		{
			$msg = str_replace("__NAME",$name,$sms[msg1]);
			$msg = str_replace("__USERID",$userid,$msg);
			$msg = str_replace("__SITE",$admin_row[shopName],$msg);
			$hand = str_replace("-","",$hand);
			$result = $SMS->Add($hand,$adminTel,"",$msg,"");
			$result = $SMS->Send();
			$SMS->Init(); // 보관하고 있던 결과값을 지웁니다.
		}
		if($sms[bSend2])
		{
			$msg = str_replace("__NAME",$name,$sms[msg2]);
			$msg = str_replace("__USERID",$userid,$msg);
			$msg = str_replace("__SITE",$admin_row[shopName],$msg);
			$result = $SMS->Add($retel,$adminTel,"",$msg,"");
			$result = $SMS->Send();
			$SMS->Init(); // 보관하고 있던 결과값을 지웁니다.
		}
	}
	else if($SMS_PART == "trade")
	{
		//상품주문
		$SMS = new SMS($sms[userid],$sms[pwd],$sms[gubun]);
		$adminTel = str_replace("-","",$sms[adminTel]);
		$retel= str_replace("-","",$sms[retel]);
		$SMS_WRITEDAY = date("m월 d일");
		if($payMethod=="card") $SMS_PAYMETHOD = "카드결제";
		else $SMS_PAYMETHOD = "무통장입금";
		if($sms[bSend3])
		{
			$msg = str_replace("__NAME",		$temp_row[name],	$sms[msg3]);
			$msg = str_replace("__WRITEDAY",	$SMS_WRITEDAY,		$msg);
			$msg = str_replace("__GOODS",		$SMS_GOODS,			$msg);
			$msg = str_replace("__PAYMETHOD",	$SMS_PAYMETHOD,		$msg);
			$msg = str_replace("__PRICE",		$payM,				$msg);
			$msg = str_replace("__CNT",			$SMS_CNT,			$msg);
			$msg = str_replace("__SITE",		$admin_row[shopName],$msg);
			$hand = str_replace("-","",$temp_row[hand]);
			$result = $SMS->Add($hand,$adminTel,"",$msg,"");
			$result = $SMS->Send();
			$SMS->Init(); // 보관하고 있던 결과값을 지웁니다.
		}
		if($sms[bSend4])
		{
			$msg = str_replace("__NAME",$temp_row[name],$sms[msg4]);
			$msg = str_replace("__WRITEDAY",$SMS_WRITEDAY,$msg);
			$msg = str_replace("__GOODS",$SMS_GOODS,$msg);
			$msg = str_replace("__PAYMETHOD",$SMS_PAYMETHOD,$msg);
			$msg = str_replace("__PRICE",$payM,$msg);
			$msg = str_replace("__CNT",$SMS_CNT,$msg);
			$msg = str_replace("__SITE",$admin_row[shopName],$msg);
			$result = $SMS->Add($retel,$adminTel,"",$msg,"");
			$result = $SMS->Send();
			$SMS->Init(); // 보관하고 있던 결과값을 지웁니다.
		}
	}
	else if($SMS_PART == "cancel")
	{
		//주문취소
		$SMS = new SMS($sms[userid],$sms[pwd],$sms[gubun]);
		$adminTel = str_replace("-","",$sms[adminTel]);
		$retel= str_replace("-","",$sms[retel]);
		$SMS_WRITEDAY = date("m월 d일");
		if($payMethod=="card") $SMS_PAYMETHOD = "카드결제";
		else if($payMethod=="hpp") $SMS_PAYMETHOD = "핸드폰";
		else if($payMethod=="iche") $SMS_PAYMETHOD = "계좌이체";
		else if($payMethod=="bank") $SMS_PAYMETHOD = "무통장입금";
		if($sms[bSend8])
		{
			$msg = str_replace("__NAME",		$temp_row[name],	$sms[msg8]);
			$msg = str_replace("__GOODS",		$SMS_GOODS,			$msg);
			$msg = str_replace("__PAYMETHOD",	$SMS_PAYMETHOD,		$msg);
			$msg = str_replace("__SITE",		$admin_row[shopName],$msg);
			$hand = str_replace("-","",$temp_row[hand]);
			$result = $SMS->Add($hand,$adminTel,"",$msg,"");
			$result = $SMS->Send();
			$SMS->Init(); // 보관하고 있던 결과값을 지웁니다.
		}
	}
	else if($SMS_PART == "send")
	{
		//상품배송
		$SMS = new SMS($sms[userid],$sms[pwd],$sms[gubun]);
		$adminTel = str_replace("-","",$sms[adminTel]);
		$SMS_SENDDAY = date("m월 d일");
		if($sms[bSend5])
		{
			$msg = str_replace("__NAME",		$trade_row[name],	$sms[msg5]);
			$msg = str_replace("__TRANSNUM",	$trans_num,	$msg);
			$msg = str_replace("__GOODS",		StringCut($goods_row[name],20),	$msg);
			$msg = str_replace("__SENDDAY",		$SMS_SENDDAY,		$msg);
			$msg = str_replace("__SITE",		$admin_row[shopName],$msg);
			$hand = str_replace("-","",$trade_row[hand]);
			$result = $SMS->Add($hand,$adminTel,"",$msg,"");
			$result = $SMS->Send();
			$SMS->Init(); // 보관하고 있던 결과값을 지웁니다.
		}
	}
	else if($SMS_PART=="allmember")
	{
		//회원전체 보내기 (SMS수신동의한 회원만) 
		$SMS = new SMS($sms[userid],$sms[pwd],$sms[gubun]);
		$adminTel = str_replace("-","",$sms[adminTel]);
		$qry = "select * from member where bSms='y' and hand<>''";
		$qry_result = $MySQL->query($qry);
		while($row = mysql_fetch_array($qry_result))
		{
			$hand = str_replace("-","",$row[hand]);
			$result = $SMS->Add($hand,$adminTel,"",$content,"");
		}
		echo "<HR>";
		$result = $SMS->Send();
		if ($result)
		{
			echo "SMS 서버에 접속했습니다.<br>";
			$success = $fail = 0;
			foreach($SMS->Result as $result)
			{
				list($phone,$code)=explode(":",$result);
				if ($code=="Error")
				{
					echo $phone.'로 발송하는데 에러가 발생했습니다.<br>';
					$fail++;
				}
				else
				{
					echo $phone."로 전송했습니다. (메시지번호:".$code.")<br>";
					$success++;
				}
			}
			echo $success."건을 전송했으며 ".$fail."건을 보내지 못했습니다.<br>";
			$SMS->Init(); // 보관하고 있던 결과값을 지웁니다.
		}
		else echo "에러: SMS 서버와 통신이 불안정합니다.<br>";
	}
	else if($SMS_PART=="selected_member")
	{
		// 검색된 회원만 보내기
		$SMS = new SMS($sms[userid],$sms[pwd],$sms[gubun]);
		$adminTel = str_replace("-","",$sms[adminTel]);
		$temp = explode("/",$idx_arr);
		for ($i=0; $i<count($temp); $i++)
		{
			$row = $MySQL->fetch_array("SELECT hand from member WHERE idx=$temp[$i] and bSms='y' and hand<>'' limit 1");
			if($row[hand])
			{
				$hand = str_replace("-","",$row[hand]);
				$result = $SMS->Add($hand,$adminTel,"",$content,"");
			}
		}
		echo "<HR>";
		$result = $SMS->Send();
		if ($result)
		{
			echo "SMS 서버에 접속했습니다.<br>";
			$success = $fail = 0;
			foreach($SMS->Result as $result) 
			{
				list($phone,$code)=explode(":",$result);
				if ($code=="Error")
				{
					echo $phone.'로 발송하는데 에러가 발생했습니다.<br>';
					$fail++;
				}
				else
				{
					echo $phone."로 전송했습니다. (메시지번호:".$code.")<br>";
					$success++;
				}
			}
			echo $success."건을 전송했으며 ".$fail."건을 보내지 못했습니다.<br>";
			$SMS->Init(); // 보관하고 있던 결과값을 지웁니다.
		}
		else echo "에러: SMS 서버와 통신이 불안정합니다.<br>";
	}
	else if($SMS_PART=="permember")
	{
		// 회원개인 보내기
		$SMS = new SMS($sms[userid],$sms[pwd],$sms[gubun]);
		$result = $SMS->Add($hand,$adminTel,"",$content,"");
		if ($result) echo $result; else echo "일반메시지 입력 성공<BR>";
		echo "<HR>";
		$result = $SMS->Send();
		if ($result)
		{
			echo "SMS 서버에 접속했습니다.<br>";
			$success = $fail = 0;
			foreach($SMS->Result as $result)
			{
				list($phone,$code)=explode(":",$result);
				if ($code=="Error")
				{
					echo $phone.'로 발송하는데 에러가 발생했습니다.<br>';
					$fail++;
				}
				else
				{
					echo $phone."로 전송했습니다. (메시지번호:".$code.")<br>";
					$success++;
				}
			}
			echo $success."건을 전송했으며 ".$fail."건을 보내지 못했습니다.<br>";
			$SMS->Init(); // 보관하고 있던 결과값을 지웁니다.
		}
		else echo "에러: SMS 서버와 통신이 불안정합니다.<br>";
	}
}
?>