<?php
///////////////////////////////////////////////////////////////
// 프로그램명	: escrow_write.php
// 설  명		: 데이콤 에스크로 수신결과 DB/파일처리 모듈
// 작성자		: 김성호
// 소  속		: (주)올플랜
// 일  자		: 2006년 5월 15일 월요일
//	return value
//		true	: DB저장 성공
//		false	: DB저장 실패
///////////////////////////////////////////////////////////////
// 소스형상관리
// 20060720-1 파일추가 김성호

function write_success($noti){	//결제성공시
	global $MySQL;
	$qry_pre = "INSERT INTO GM_PG_dacom(";
	$qry_post = " VALUES(";
	reset($noti);
	while(list($key, $val) = each($noti))
	{
		$qry_pre.= $key.",";
		$qry_post.= "'".addslashes($val)."',";
	}
	$qry_pre.= "readDay";	// 자료수신일자 기록용 필드 추가
	$qry_post.= "now()";	// 자료수신일자 : 데이터 수신시점
	$qry = $qry_pre.")".$qry_post.")";

	if( !($MySQL->query($qry)) )	// DB처리 에러 발생시
	{
		//DB저장 불가시에는 파일로 별도 기록하여 DB 입력에러 사유를 확인토록 함
		$body = "[".date("Y-m-d :h:i:s A")."] 수신내역 (tradecode(oid) : ".$noti[tradecode].") ".$qry;
		write_file($body, "a+");
		return false;	// DB처리에 대한 결과 반환
	}
	else
	{
		/*	수령확인시 포인트 처리등 여러가지 어려움으로 인해 상점 관리자가 관리자 페이지에서 처리해 주시는 방식으로 결정함
		if(("C" == $noti[txtype]) || ("N" == $noti[txtype]))		//결과구분(C=수령확인결과, R=구매취소요청, D=구매취소결과, N=NC처리결과)
		{
			@$MySQL->query("UPDATE trade_goods SET sday4 =now(),status=3 WHERE tradecode='".$noti[tradecode]."'");
			@$MySQL->query("UPDATE trade SET sday4 =now(),status=3 WHERE tradecode='".$noti[tradecode]."'");
		}*/

		return true;
	}
}

function write_hasherr($noti) {
	$body = "[".date("Y-m-d :h:i:s A")."] 해쉬에러 (tradecode(oid) : ".$noti[tradecode].") ";
	write_file($body, "a+");
	return true;
}

//파일기록 처리
function write_file($body, $fopen_opt){
	$filename = "escrow_log.txt";
	$fp = fopen($filename, $fopen_opt);
	fwrite($fp,$body);
	fclose($fp);
}

function get_param($name){
	global $HTTP_POST_VARS, $HTTP_GET_VARS;
	if (!isset($HTTP_POST_VARS[$name]) || $HTTP_POST_VARS[$name] == "") {
		if (!isset($HTTP_GET_VARS[$name]) || $HTTP_GET_VARS[$name] == "") {
			return false;
		} else {
			return $HTTP_GET_VARS[$name];
		}
	}
	return $HTTP_POST_VARS[$name];
}
?>

