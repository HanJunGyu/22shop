<?
// 소스형상관리
// 20060719-1 파일교체 김성호: 1.결제시도방식 저장, 2.자료저장 이후 결제진행토록 수정
include "head.php";
if(empty($useP)) $useP =0;
if(empty($payM)) $payM =0;
if(empty($transM)) $transM =0;
if(empty($totalM)) $totalM =0;
if(!empty($tradecode))
{
	$temp_qry = "update trade_temp set payM=$payM,useP=$useP,transM=$transM,totalM=$totalM,transMethod='$transMethod' where tradecode='$tradecode'";
	$trade_qry = "update trade set payMethod='".$payMethod."' where tradecode='".$tradecode."'";
	if ($MySQL->query($temp_qry) && $MySQL->query($trade_qry))
	{
	}
	else
	{
		OnlyMsgView("정보정에 문제가 발생하였습니다. 관리자에게 문의해주시기 바랍니다.");
	}
}
?>
<SCRIPT LANGUAGE="JavaScript">
<!--
function OnPayAct()
{
	<?
	if($admin_row[pgName]=="dacom")	//관리자에서 데이콤 카드사용 : 암호화 기능 적용
	{
		$hashdata = md5($admin_row[shopId].$tradecode.$payM.$admin_row[shop_pg_mertkey]);	//암호화된 hashdata 결과물
		echo "parent.document.dacomForm.hashdata.value = '".$hashdata."';\n";
	}

	switch ($payMethod):
		case 'card':	$ParentPayAct = "	parent.go_card();\n";			break;	//신용카드
		case 'hand':	$ParentPayAct = "	parent.go_card();\n";			break;	//핸드폰
		case 'iche':	$ParentPayAct = "	parent.go_card();\n";			break;	//계좌이체
		case 'cyber':	$ParentPayAct = "	parent.go_card();\n";			break;	//가상계좌
		case 'bank':	$ParentPayAct = "	parent.document.payForm.submit();\n";	break;	//상점무통장
		default :		$ParentPayAct = "";		break;	//결제수단 미정
	endswitch;

	switch ($pay_ready):
		case 'paysendit':	//결제행위를 수행
			echo $ParentPayAct;
			break;

		case 'usePoint':		//적립금 사용중
			echo "	parent.document.usePform.pay_ready.value = 'paysendit';\n";
			echo "	parent.bank_select();\n";
			break;

		default :			//결제페이지 로딩중
			echo "	parent.document.usePform.pay_ready.value = 'paysendit';\n";
			echo "	parent.bank_select();\n";
			echo "	parent.viewAct('nsAct');\n";
			break;
	endswitch;
	?>
}
//-->
</SCRIPT>
<body onload="OnPayAct();">
</body>
</html>