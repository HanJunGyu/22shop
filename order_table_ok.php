<?
// 소스형상관리
// 20060720-1 파일교체 김성호 : 1.결제시도방식 저장, 2.자료저장 이후 결제진행토록 수정
session_start();
include "./lib/config.php";
include "./lib/function.php";
$_SELF=explode("/",$_SERVER[PHP_SELF]);
$_SELF[count($_SELF)-1]="";
$_PAY_OK_FILE=implode("/", $_SELF);
if(!defined(__ADMIN_ROW))
{
	define(__ADMIN_ROW,"TRUE");
	$admin_row=$MySQL->fetch_array("select *from admin limit 0,1");//관리자정보
}
if(!defined(__DESIGN_ROW))
{
	define(__DESIGN_ROW,"TRUE");
	$design=$MySQL->fetch_array("select *from design limit 0,1");
}
//은행명 확인용 함수
function Find_Bank($bankcode)
{
	switch($bankcode):
		case 01:	$banknm = "한국은행";		break;
		case 02:	$banknm = "산업은행";		break;
		case 03:	$banknm = "기업은행";		break;
		case 04:	$banknm = "국민은행";		break;
		case 05:	$banknm = "외환은행";		break;
		case 06:	$banknm = "국민은행";		break;
		case 07:	$banknm = "수협";			break;
		case 08:	$banknm = "수출입";			break;
		case 09:	$banknm = "장기신용";		break;
		case 10:	$banknm = "신농협중앙";		break;
		case 11:	$banknm = "농협";			break;
		case 12:	$banknm = "농협";			break;
		case 13:	$banknm = "농협";			break;
		case 14:	$banknm = "농협";			break;
		case 15:	$banknm = "농협";			break;
		case 16:	$banknm = "축협";			break;
		case 20:	$banknm = "우리은행";		break;
		case 21:	$banknm = "조흥은행";		break;
		case 22:	$banknm = "상업은행";		break;
		case 23:	$banknm = "제일은행";		break;
		case 24:	$banknm = "한일은행";		break;
		case 25:	$banknm = "서울은행";		break;
		case 26:	$banknm = "신한은행";		break;
		case 27:	$banknm = "한미은행";		break;
		case 28:	$banknm = "동화은행";		break;
		case 29:	$banknm = "동남은행";		break;
		case 30:	$banknm = "대동은행";		break;
		case 31:	$banknm = "대구은행";		break;
		case 32:	$banknm = "부산은행";		break;
		case 33:	$banknm = "충청은행";		break;
		case 34:	$banknm = "광주은행";		break;
		case 35:	$banknm = "제주은행";		break;
		case 36:	$banknm = "경기은행";		break;
		case 37:	$banknm = "전북은행";		break;
		case 38:	$banknm = "강원은행";		break;
		case 39:	$banknm = "경남은행";		break;
		case 40:	$banknm = "충북은행";		break;
		case 45:	$banknm = "새마을금고";		break;
		case 53:	$banknm = "씨티은행";		break;
		case 71:	$banknm = "우체국";			break;
		case 76:	$banknm = "신용보증";		break;
		case 81:	$banknm = "하나은행";		break;
		case 82:	$banknm = "보람은행";		break;
		case 83:	$banknm = "평화은행";		break;
		case 93:	$banknm = "새마을금고";		break;
		default :	$banknm = "은행명없음";		break;
	endswitch;

	return $banknm;
}
$linkstr = PostToLink($_POST); // 폼변수를 링크주소로 만들어줌 
$sms = $MySQL->fetch_array("select * from smsinfo");

$SMS_GOODS= "";
$SMS_CNT="";
$SMS_HAND="";

$is_escrow = "none";			//에스크로 적용여부 체크
$pG_test = $admin_row[pG_test];	//테스트용 결제여부 체크
$pG_shopId = $admin_row[shopId];	//결제에 사용되는 아이디
$shop_pg_mertkey = $admin_row[shop_pg_mertkey];	//결제에 사용되는 보안키
if($admin_row[pG_test]=="y")	//테스트용 결제시
{
	switch($admin_row[pgName]):
		case 'dacom':		//데이콤 : 테스트용 값을 사용자로 부터 입력받아야 함
			break;

		case 'allat':		//올앳
			$pG_shopId = "allat_test02";	//결제에 사용되는 아이디
			$shop_pg_mertkey = "a77b5ddf2f0e567ace361df4c5765281";	//결제에 사용되는 보안키
			break;

		case 'inicis':		//이니시스
			$pG_shopId = "INIpayTest";	//결제에 사용되는 아이디
			break;
	endswitch;
}

if($GM_Shop_PayMethod == "OffBank")			//무통장 : payForm.submit() 으로 전달된 경우
{
	$bankDay = $year."-".$month."-".$day;
	$payer = $payer;
	$pG_test = "n";			//무통장 결제는 항상 테스트가 아님
	$pG_shopId = "";
}
elseif($admin_row[pgName]=="dacom")			//데이콤 처리루틴
{
	$pay_dacom_row = $MySQL->fetch_array("SELECT * FROM GM_PG_dacom WHERE tradecode='".$oid."'");

	if(empty($pay_dacom_row[tradecode]))
	{
		MsgViewHref('데이콤으로 부터 결제내역을 수신받지 못하였습니다\\n상점에 문의해 주시기 바랍니다','cart.php');
		exit;
	}
	else
	{
		if(("0000" == $pay_dacom_row[respcode]) || ("C000" == $pay_dacom_row[respcode]))	//실시간 계좌는 C000이 성공코드
		{
			$pG_shopId = $pay_dacom_row[shopId];
			$tradecode = $pay_dacom_row[tradecode];
			$pG_payM = $pay_dacom_row[amount];
			$is_escrow = ($pay_dacom_row[useescrow]=="Y") ? "escrow":"none";	//에스크로여부 확인

			//거래방식 체크
			switch($pay_dacom_row[paytype]):
				case SC0010:		//카드사
					$payMethod = "card";
					$bankInfo = $pay_dacom_row[financename];	//카드사
					$bankDay = "";								//입금예정일자
					$payer = $pay_dacom_row[payer];				//결제자
					$escrow_tcd = $pay_dacom_row[transaction];	//데이콤이 부여한 거래번호
					OnlyMsgView('결제를 성공 하셨습니다.');
					break;

				case SC0060:		//핸드폰
					$payMethod="hand";
					$bankInfo = $pay_dacom_row[financename]." : ".$pay_dacom_row[telno];			//휴대폰사 : 휴대폰번호
					$bankDay = "";								//입금예정일자
					$payer = $pay_dacom_row[payer];				//결제자
					$escrow_tcd = $pay_dacom_row[transaction];	//데이콤이 부여한 거래번호
					OnlyMsgView('결제를 성공 하셨습니다.');
					break;

				case SC0030:		//실시간계좌
					$payMethod = "iche";
					$bankInfo = $pay_dacom_row[financename]." ".$pay_dacom_row[accountnumber]." (예금주 : ".$pay_dacom_row[accountowner].")";		//은행명 계좌번호(예금주 : 예금주명)
					$bankDay = "";								//입금예정일자
					$payer = $pay_dacom_row[payer];				//입금자
					$escrow_tcd = $pay_dacom_row[transaction];	//데이콤이 부여한 거래번호
					OnlyMsgView('결제를 성공 하셨습니다.');
					break;

				case SC0040:		//가상계좌
					$payMethod = "cyber";
					$bankInfo = $pay_dacom_row[financename]." ".$pay_dacom_row[accountnumber]." (예금주 : (주)데이콤)";		//은행명 계좌번호(예금주 : 예금주명)
					$bankDay = "";								//입금예정일자
					$payer = $pay_dacom_row[payer];				//입금예정자
					$escrow_tcd = $pay_dacom_row[transaction];	//데이콤이 부여한 거래번호
					OnlyMsgView('고객님의 무통장입금 요청이 완료되었습니다.');
					break;
			endswitch;
		}
		else
		{
			MsgViewHref('결제를 실패 하셨습니다.\\n에러코드 : '.$respcode.'\\n메시지 : '.$respmsg,'cart.php');
			exit;
		}
	}
}
elseif($admin_row[pgName]=="allat")		//올앳 처리루틴
{
	include "./AllplanPG/allat/allatutil.php";

	// 결제인터페이스의 결과값 Get : 이전 주문결제페이지에서 Request Get
	//------------------------------------------------------------------
	$at_data = "allat_shop_id=".urlencode($pG_shopId).		//가맹점 고유 파트너 ID
				"&allat_amt=".$allat_amt.							//승인금액
				"&allat_enc_data=".$_POST["allat_enc_data"].		//Plug-in 결과값
				"&allat_cross_key=".$shop_pg_mertkey;				//가맹점 CrossKey값

	// 올앳과 통신 후 결과값 받기 : SendApproval->통신함수, html->결과값
	//-----------------------------------------------------------------
	$at_txt = ApprovalReq($at_data,($admin_row[shop_pg_encryption]=="y" ? "SSL":"NOSSL"));				//설정 필요 SSL (NOSSL - 에러 코드 0212일 경우 사용함)

	// 결과값(html)에서 필요한값 불리기 예제
	//-----------------------------------------------------------------
	$REPLYCD	=getValue("reply_cd",$at_txt);			//결과코드
	$REPLYMSG	=getValue("reply_msg",$at_txt);			//결과 메세지

	// 결과값 처리
	//------------------------------------------------------------------
	if( !strcmp($REPLYCD,"0000") )	// reply_cd "0000" 일때만 성공
	{
		$ORDER_NO			=getValue("order_no",$at_txt);			//공	통 : 주문번호
		$AMT				=getValue("amt",$at_txt);				//공	통 : 승인금액
		$PAY_TYPE			=getValue("pay_type",$at_txt);			//공	통 : 지불수단
		$APPROVAL_YMDHMS	=getValue("approval_ymdhms",$at_txt);	//공	통 : 승인일시
		$SEQ_NO				=getValue("seq_no",$at_txt);			//공	통 : 거래일련번호
		$APPROVAL_NO		=getValue("approval_no",$at_txt);		//신용카드 : 승인번호
		$CARD_ID			=getValue("card_id",$at_txt);			//신용카드 : 카드ID
		$CARD_NM			=getValue("card_nm",$at_txt);			//신용카드 : 카드명
		$SELL_MM			=getValue("sell_mm",$at_txt);			//신용카드 : 할부개월
		$ZEROFEE_YN			=getValue("zerofee_yn",$at_txt);		//신용카드 : 무이자여부 - 무이자(Y),일시불(N)
		$CERT_YN			=getValue("cert_yn",$at_txt);			//신용카드 : 인증여부 - 인증(Y),미인증(N)
		$CONTRACT_YN		=getValue("contract_yn",$at_txt);		//신용카드 : 직가맹여부 - 3자가맹점(Y),대표가맹점(N)
		$BANK_ID			=getValue("bank_id",$at_txt);			//계좌이체/가상계좌 : 은행ID
		$BANK_NM			=getValue("bank_nm",$at_txt);			//계좌이체/가상계좌 : 은행명
		$CASH_BILL_NO		=getValue("cash_bill_no",$at_txt);		//계좌이체/가상계좌 : 현금영수증 일련 번호
		$ESCROW_YN			=getValue("escrow_yn",$at_txt);			//계좌이체/가상계좌 : 에스크로 적용 여부
		$ACCOUNT_NO			=getValue("account_no",$at_txt);		//가상계좌 : 계좌번호
		$ACCOUNT_NM			=getValue("account_nm",$at_txt);		//가상계좌 : 입금자명
		$INCOME_ACC_NM		=getValue("income_account_nm",$at_txt);	//가상계좌 : 입금계좌명(가상계좌소유주명)
		$INCOME_LIMIT_YMD	=getValue("income_limit_ymd",$at_txt);	//가상계좌 : 입금기한일
		$INCOME_EXPECT_YMD	=getValue("income_expect_ymd",$at_txt);	//가상계좌 : 입금예정일
		$CASH_YN			=getValue("cash_yn",$at_txt);			//가상계좌 : 현금영수증신청 여부

		$tradecode = $ORDER_NO;	//주문코드
		$pG_payM = $AMT;
		$is_escrow = ($ESCROW_YN=="Y") ? "escrow":"none";	//에스크로여부 확인

		switch($PAY_TYPE):
			case 'ABANK':	//계좌이체
				$payMethod = "iche";
				$bankInfo = $BANK_NM;		//은행명
				$bankDay = "";				//입금예정일자
				$payer = $ACCOUNT_NM;		//입금자
				$escrow_tcd = $SEQ_NO;		//거래번호
				OnlyMsgView('결제를 성공 하셨습니다.');
				break;

			case 'VBANK':	//가상계좌
				$payMethod = "cyber";
				$bankInfo = $BANK_NM." ".$ACCOUNT_NO." (예금주 : ".$INCOME_ACC_NM.")";	//은행명 계좌번호(예금주 : 예금주명)
				$bankDay = $INCOME_EXPECT_YMD;		//입금예정일자
				$payer = $ACCOUNT_NM;				//입금예정자
				$escrow_tcd = $SEQ_NO;				//거래 번호
				OnlyMsgView('고객님의 무통장입금 요청이 완료되었습니다.');
				break;

			default :	//신용카드 : 3D, ISP, NOR
				$payMethod = "card";
				$bankInfo = $CARD_NM;		//카드명
				$bankDay = "";				//입금예정일자
				$payer = $ACCOUNT_NM;		//결제자
				$escrow_tcd = $SEQ_NO;				//거래 번호
				OnlyMsgView('결제를 성공 하셨습니다.');
				break;
		endswitch;
	}
	else
	{	
		MsgViewHref('결제를 실패 하셨습니다.\\n'.'['.$REPLYCD.'] '.$REPLYMSG,'cart.php');
		exit;
	}
}
elseif($admin_row[pgName]=="inicis")		// 이니시스 처리루틴
{
	echo "<script language=javascript>
	<!--
	var openwin=window.open('AllplanPG/inicis/INIpay41/childwin.html','childwin','width=300,height=160');
	openwin.close();
	//-->
	</script>";

	/**************************
	 * 1. 라이브러리 인클루드 *
	 **************************/
	require("AllplanPG/inicis/INIpay41/sample/INIpay41Lib.php");

	/***************************************
	 * 2. INIpay41 클래스의 인스턴스 생성 *
	 ***************************************/
	$inipay = new INIpay41;

	/*********************
	 * 3. 지불 정보 설정 *
	 *********************/
	$inipay->m_inipayHome = $DOCUMENT_ROOT.$_PAY_OK_FILE."AllplanPG/inicis/INIpay41";	// 이니페이 홈디렉터리
	$inipay->m_type = "securepay";			// 고정
	$inipay->m_pgId = "IniTechPG_";			// 고정
	$inipay->m_subPgIp = "203.238.3.10";	// 고정
	$inipay->m_keyPw = "1111";				// 키패스워드(상점아이디에 따라 변경)
	$inipay->m_debug = "false";				// 로그모드("true"로 설정하면 상세로그가 생성됨.)
	$inipay->m_mid = $mid;					// 상점아이디
	$inipay->m_uid = $uid;					// INIpay User ID
	$inipay->m_uip = getenv("REMOTE_ADDR");	// 고정
	$inipay->m_goodName = $goodname;
	$inipay->m_currency = $currency;
	$inipay->m_price = $price;
	$inipay->m_buyerName = $buyername;
	$inipay->m_buyerTel = $buyertel;
	$inipay->m_buyerEmail = $buyeremail;
	$inipay->m_payMethod = $paymethod;		//결재방법
	$inipay->m_encrypted = $encrypted;
	$inipay->m_sessionKey = $sessionkey;
	$inipay->m_url = $HTTP_HOST;
	$inipay->m_merchantReserved1 = "merchantreserved1";	// 예비1
	$inipay->m_merchantReserved2 = "merchantreserved2";	// 예비2
	$inipay->m_merchantReserved3 = "merchantreserved3";	// 예비3
	$inipay->m_cardcode = $cardcode;		// 카드코드 리턴
	$inipay->m_recvName = $recvname;		// 수취인 명
	$inipay->m_recvTel = $recvtel;			// 수취인 연락처
	$inipay->m_recvAddr = $recvaddr;		// 수취인 주소
	$inipay->m_recvPostNum = $recvpostnum;	// 수취인 우편번호
	$inipay->m_recvMsg = $recvmsg;			// 전달 메세지

	/****************
	 * 4. 지불 요청 *
	 ****************/
	$inipay->startAction();
	if($inipay->m_resultCode == "00")
	{
		$pG_shopId = $inipay->m_mid;
		$tradecode = $inipay->m_moid;	//주문코드
		$pG_payM = $inipay->m_price;

		switch($inipay->m_payMethod):
			case 'VBank':			//가상계좌 및 에스크로
				$payMethod = "cyber";
				$bankInfo = Find_Bank($inipay->m_vcdbank)." ".$inipay->m_vacct ." (예금주 : " .$inipay->m_nmvacct.")";	//은행명 계좌번호(예금주 : 예금주명)
				$bankDay = $inipay->m_dtinput;	//입금예정일자
				$payer = $inipay->m_nminput;	//입금자
				$escrow_tcd = $inipay->m_tid;	//거래 번호
				$is_escrow = ($inipay->m_mid==$admin_row[shop_Escrow_Id]) ? "escrow":"none";	//에스크로여부 확인
				OnlyMsgView('고객님의 무통장입금 요청이 완료되었습니다.');
				break;

			case 'DirectBank':		//실시간 계좌이체
				$payMethod = "iche";
				$bankInfo = $pay_dacom_row[financename]." ".$pay_dacom_row[accountnumber]." (예금주 : ".$pay_dacom_row[accountowner].")";		//은행명 계좌번호(예금주 : 예금주명)
				$bankDay = "";							//입금예정일자
				$payer = $inipay->m_nminput;			//입금자
				$escrow_tcd = $inipay->m_tid;			//거래 번호
				OnlyMsgView('결제를 성공 하셨습니다.');
				break;

			case 'HPP':				//핸드폰결제
				$payMethod = "hand";
				$bankInfo = $inipay->m_nohpp;		//휴대폰번호
				$bankDay = "";									//입금예정일자
				$payer = $inipay->m_nminput;					//결제자
				$escrow_tcd = $inipay->m_tid;					//거래 번호
				OnlyMsgView('결제를 성공 하셨습니다.');
				break;

			default :				//카드결제
				$payMethod = "card";
				$bankInfo = $inipay->m_cardIssuerCode .":".$inipay->m_cardCode." : ".$inipay->m_cardNumber;	//카드사 : 카드번호
				$bankDay = "";								//입금예정일자
				$payer = $inipay->m_nminput;				//결제자
				$escrow_tcd = $inipay->m_tid;	//에스크로 거래 번호
				OnlyMsgView('결제를 성공 하셨습니다.');
		endswitch;
	}
	else
	{
			MsgViewHref('결제를 실패 하셨습니다.\\n'.$inipay->m_resultMsg,'cart.php');
			exit;
	}
}

/*------------------------주문정보 저장 ---------------------------------*/
$temp_row = $MySQL->fetch_array("select *from trade_temp where tradecode='$tradecode' limit 1");
$SMS_HAND = $temp_row[hand];
$temp_row_content =addslashes_userfc($temp_row[content]);

//임시테이블에서 정보추출
$useP=$temp_row[useP];
$transM=$temp_row[transM];
$payM=$temp_row[payM];
$totalM=$temp_row[totalM];
$transMethod=$temp_row[transMethod];
if(empty($useP))	$useP =0;
if(empty($transM))	$transM =0;
if(empty($payM))	$payM =0;
if(empty($totalM))	$totalM =0;
$pG_Cracked = "";
$temp_trade_goods_row = $MySQL->fetch_array("select sum(price * cnt) as gsum from trade_goods where tradecode='".$tradecode."'");
if($totalM != $temp_trade_goods_row[gsum])
{
	$pG_Cracked = "가격합계 확인요망";
}
elseif($payMethod != "bank")
{
	if($payM != $pG_payM)	//카드결제 예상금액과 PG사 결제확인 금액이 상이
	{
		$pG_Cracked = "PG사 확인요망";
	}
}

//구매직전에 재고가 품절이 되었을경우 체크
$cart_result = $MySQL->query("select *from cart where userid='$temp_row[userid]'");
while($cart_row = mysql_fetch_array($cart_result))
{
	$goods_row = $MySQL->fetch_array("select *from goods where idx=$cart_row[goodsIdx] limit 1");
	if ($goods_row[bLimit])
	{
		if (empty($goods_row[limitCnt]))
		{
			$limit = 1; // 품절이면 1
			$limit_good = $goods_row[name];
		}
		else if ($goods_row[bLimit] && ($goods_row[limitCnt] < $cart_row[cnt])) // 품절은 아닌데 구매수량이 재고수량을 넘어서면 
		{
			$limit = 2; // 재고초과이면 2 
			$over_cnt = $cart_row[cnt] - $goods_row[limitCnt];
			$limit_good = $goods_row[name]."상품의 재고를 $over_cnt 개 초과하였습니다.";
		}
	}
}
if ($limit ==1)
{
	OnlyMsgView("죄송합니다. $limit_good 상품의 마지막 재고가 조금전에 구매되었습니다. 장바구니로 이동합니다.");
	Refresh("cart.php");
	exit;
}
else if ($limit ==2)
{
	OnlyMsgView("죄송합니다. $limit_good 장바구니로 이동합니다.");
	Refresh("cart.php");
	exit;
}
if($temp_row[userid_part]=="member")
{
	// 회원일 경우 적립금 설정
	if ($useP && !$MySQL->articles("SELECT idx from point_table WHERE userid='$temp_row[userid]' and part='사용' and tradecode='$temp_row[tradecode]'")) // 사용한 적립금이 있을때만 & order_table_ok.php 중복새로고침 방지 1번만 실행토록 
	{
		$MySQL->query("update member set point = point - $useP where userid='$temp_row[userid]' ");
		$trade_goodsP =$useP*-1;
		$point_qry = "insert into point_table(part,userid,point,reason,writeday)values(";
		$point_qry.= "'사용','$temp_row[userid]',$trade_goodsP,'상품구매 [주문코드:$temp_row[tradecode]]',now())";
		$MySQL->query($point_qry);
	}
}
$qry = "update trade set payM=$payM,payMethod='$payMethod',useP=$useP,transM=$transM,totalM=$totalM,bPay=1, ";
$qry.= "bankInfo='$bankInfo',bankDay='$bankDay',payer='$payer',transMethod='$transMethod',userip='$REMOTE_ADDR', ";
if(!empty($pG_payM)) $qry.= "pG_payM=".$pG_payM.", ";			//카드결제시 PG사 결제확인 금액
if($pG_Cracked != "") $qry.= "pG_Cracked='".$pG_Cracked."', ";	//결제금액관련 관리자 확인필요
$qry.= "escrow_tcd='".$escrow_tcd."', is_escrow='".$is_escrow."', pG_shopId='".$pG_shopId."', pG_test='".$pG_test."' where tradecode='$tradecode' ";

if ($MySQL->query($qry)) $inSuccess =true;
if($inSuccess)
{
	// 상품주문시 재고에서 삭감 
	$qry = "select *from cart where userid='$temp_row[userid]'";
	$cart_result = $MySQL->query($qry);
	$inSuccess =true;
	while($cart_row = mysql_fetch_array($cart_result))
	{
		$goods_row = $MySQL->fetch_array("select *from goods where idx=$cart_row[goodsIdx] limit 1");
		if($goods_row[bLimit])
		{
			// 재고수량 조절
			$new_limitCnt = $goods_row[limitCnt]-$cart_row[cnt];
			if($new_limitCnt <0) $new_limitCnt=0;
			$MySQL->query("update goods set limitCnt=$new_limitCnt where idx=$goods_row[idx]");
		}
	}

	// 주문 메일 보내기 시작
	if($admin_row[bBuymail]=="y")
	{
		include "email/goods_order.php";
	}

	// sms 보내기 시작
	if($sms[bSms] && !empty($sms[userid]) && !empty($sms[pwd]))
	{
		$t_goods_row = $MySQL->fetch_array("SELECT name,goodsIdx,cnt from trade_goods WHERE tradecode='$tradecode' group by tradecode");
		if ($t_goods_row[cnt]>1)
		{
			$CNT_STR = " 외 ".($t_goods_row[cnt]-1)." ";
		}
		else $CNT_STR = "";
		$SMS_GOODS = StringCut($t_goods_row[name],20);
		$SMS_CNT = $CNT_STR;
		$SMS_PART = "trade";
		include "sms/smsclient.php";
	}

	//무통장 외 카드결제, 에스크로 및 기타일 경우 결제확인의 작업수행
	switch ($payMethod):
		case 'card':	//카드결제
			$editQry = "UPDATE trade_goods SET sday2 =now(),status=1 WHERE tradecode='".$tradecode."'";
			$MySQL->query($editQry);
			$editQry1 = "UPDATE trade SET sday2 =now(),status=1 WHERE tradecode='".$tradecode."'";
			$MySQL->query($editQry1);
			$type = "all";	// 일괄배송 메일발송
			break;

		case 'iche':	//실시간계좌
			$editQry = "UPDATE trade_goods SET sday2 =now(),status=1 WHERE tradecode='".$tradecode."'";
			$MySQL->query($editQry);
			$editQry1 = "UPDATE trade SET sday2 =now(),status=1 WHERE tradecode='".$tradecode."'";
			$MySQL->query($editQry1);
			$type = "all";	// 일괄배송 메일발송
			break;

		case 'hand':		//핸드폰
			$editQry = "UPDATE trade_goods SET sday2 =now(),status=1 WHERE tradecode='".$tradecode."'";
			$MySQL->query($editQry);
			$editQry1 = "UPDATE trade SET sday2 =now(),status=1 WHERE tradecode='".$tradecode."'";
			$MySQL->query($editQry1);
			$type = "all";	// 일괄배송 메일발송
			break;
	endswitch;
	//무통장 외 카드결제, 에스크로 및 기타일 경우 결제확인의 작업수행 끝

	if ($type == "all")	// 일괄배송 메일 발송
	{
		$trade_goods_result = $MySQL->query("SELECT name from trade_goods WHERE tradecode='".$tradecode."'");
		while ($trade_goods_row = mysql_fetch_array($trade_goods_result))
		{
			$goods_name.= $trade_goods_row[name]."<BR>";
		}
		$trade_row = $MySQL->fetch_array("select *from trade where tradecode='".$tradecode."' limit 1");
		include "email/b2b_credit.php"; // 관리자,업체,고객
	}
	ReFresh("order_ok.php?tradecode=$tradecode");
}
else	// 주문에러발생시
{
	echo"Err. ";
}
?>