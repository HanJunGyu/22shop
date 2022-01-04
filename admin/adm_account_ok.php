<?
// 소스형상관리
// 20060720-1 파일교체 김성호
include "head.php";
/*------------------------관리자 결제정보 설정 수정 ---------------------------------*/
if(empty($bCardpay))		$bCardpay			=0;		//카드결제 사용여부
if(empty($bHpppay))			$bHpppay			=0;		//핸드폰결제 사용여부
if(empty($bIchepay))		$bIchepay			=0;		//계좌이체 사용여부
if(empty($bCyberpay))		$bCyberpay			=0;		//가상계좌 사용여부
if(empty($bBankpay))		$bBankpay			=0;		//상점자체 무통장입금 사용여부
if(empty($bUsepoint))		$bUsepoint			=0;		//적립금 사용여부
if(empty($str_poReg))		$str_poReg			=0;		//회원가입시 적립금
if(empty($str_poTotal))		$str_poTotal		=0;		//일괄처리
if(empty($str_poUnit))		$str_poUnit			=0;		//제품단위
if(empty($str_poMin))		$str_poMin			=0;		//적립금 최소 사용가능 금액
if(empty($str_poMax))		$str_poMax			=0;		//적립금 최대 사용가능 금액
if(empty($str_poMaxunlimit))$str_poMaxunlimit	=0;		//적립금 최대 사용가능 금액 : 무제한 여부

if(empty($popayM)) $popayM=0;
if(empty($write_goodsP)) $write_goodsP=0;

$qry = "update admin set ";
$qry.= "pgName			= '$pgName', ";					//지불대행사 명
$qry.= "pG_test			= '$pG_test', ";				//PG 테스트
$qry.= "shopId			= '$shopId', ";					//지불대행사 상점 아이디
$qry.= "shop_Escrow_Id	= '$shop_Escrow_Id', ";			//이니시스 에스크로용 아이디
$qry.= "shop_pg_mertkey	= '$shop_pg_mertkey', ";		//PG 보안키
$qry.= "shop_pg_encryption	= '$shop_pg_encryption', ";	//암호화 적용여부
$qry.= "bCardpay		= $bCardpay, ";					//카드결제 사용여부
$qry.= "bHpppay			= $bHpppay, ";					//핸드폰결제 사용여부
$qry.= "bIchepay		= $bIchepay, ";					//계좌이체 사용여부
$qry.= "bCyberpay		= $bCyberpay, ";				//가상계좌 사용여부
$qry.= "pg_rate			= '$pg_rate', ";				//카드결제 수수료
$qry.= "pg_rate_hand	= '$pg_rate_hand', ";			//핸드폰결제 수수료
$qry.= "pg_rate_iche	= '$pg_rate_iche', ";			//계좌이체 수수료
$qry.= "pg_rate_cyber	= '$pg_rate_cyber', ";			//가상계좌 수수료
$qry.= "bBankpay		= $bBankpay, ";					//상점자체 무통장입금 사용여부
$qry.= "bBank			= '$str_bBank', ";				//각 통장 사용여부
$qry.= "bankName		= '$str_bankName', ";			//각 무통 은행명 
$qry.= "bankId			= '$str_bankId', ";				//각 무통 게좌번호
$qry.= "bankOwn 		= '$str_bankOwn', ";			//각 무통 예금주
$qry.= "bUsepoint		= $bUsepoint, ";				//적립금 사용여부
$qry.= "poReg			= $str_poReg, ";				//회원가입시 적립금
$qry.= "poMethod		= '$str_poMethod', ";			//제품 구매시 적립금 적용 방식
$qry.= "poTotal			= $str_poTotal, ";				//일괄처리
$qry.= "poUnit			= $str_poUnit, ";				//제품단위
$qry.= "poMin			= $str_poMin, ";				//적립금 최소 사용가능 금액
$qry.= "poMax			= $str_poMax, ";				//적립금 최대 사용가능 금액
$qry.= "poMaxunlimit	= $str_poMaxunlimit, ";			//적립금 최대 사용가능 금액 : 무제한 여부
$qry.= "popayM			= $popayM, ";
$qry.= "write_goodsP	= $write_goodsP ";

if($MySQL->query($qry))
{
	OnlyMsgView("수정완료 하였습니다.");
	ReFresh("adm_account.php");
}
else
{
	ErrMsg($qry);
	ReFresh("adm_account.php");
}
?>