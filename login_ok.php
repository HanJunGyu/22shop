<?
////////////////////////////////////////////////////////////////
// 프로그램명	: login_ok.php
// 설명			: 로그인처리
// 작성자		: 최호수
// 소 속		: (주)올플랜
// 일 자		: 2006년 5월 9일 월요일
///////////////////////////////////////////////////////////////
/*
프로그램 설명
2006-05-09 : 소스 정리(최호수)
*/

session_start();
include "./lib/config.php";
include "./lib/function.php";
if(!defined(__ADMIN_ROW))
{
	define(__ADMIN_ROW,"TRUE");
	$admin_row=$MySQL->fetch_array("select * from admin limit 0,1");
}
if($jdata)
{
	$vars=explode("&",base64_decode($jdata));
	$vars_num=count($vars);
	for($i=0;$i<$vars_num;$i++)
	{
		$elements=explode("=",$vars[$i]);
		$jdataArr[$elements[0]]=$elements[1];
	}
	$userid=$jdataArr[jUserid];
	$pwd=$jdataArr[jPwd];
}
/*------------------------로그인 /로그아웃---------------------------------*/
if (!$referer) $referer = $_SERVER["HTTP_REFERER"];
// 장바구니 페이지에서 로그인했을때 장바구니 정보 update (비회원 -> 회원) 
$referer_pos=strpos($referer,"cart");
if (!is_int($referer_pos) || empty($referer_pos)) {}
else $buy="cart";
$referer_pos=strpos($referer,"search_result"); // 검색결과후 로그인하면 인덱스로 

$referer_pos2=strpos($referer,"member_join");
if (!is_int($referer_pos2) || empty($referer_pos2)) {}
else $join_login=1;

$referer_pos2=strpos($referer,"login");
if (!is_int($referer_pos2) || empty($referer_pos2)) {}
else $join_login=1;

if($del)//로그아웃
{
	/* 쇼핑백 비우기 */
	//-->
	@$MySQL->query("delete from cart where userid='$_SESSION[GOOD_SHOP_USERID]'");
	@$MySQL->query("delete from today_view where userid='$_SESSION[GOOD_SHOP_USERID]'");
	//<--
	@session_unregister("GOOD_SHOP_USERID") or die("session_unregister err");
	@session_unregister("GOOD_SHOP_NAME") or die("session_unregister err");
	@session_unregister("GOOD_SHOP_PART") or die("session_unregister err");
	@session_unregister("GOOD_SHOP_CART") or die("session_unregister err");
	@session_unregister("GOOD_SHOP_PWD") or die("session_unregister err");
	@session_unregister("GOOD_SHOP_PART_GUBUN") or die("session_unregister err");
	ReFresh("index.php");
}
else if($buy)
{
	include "./lib/class.php";
	$input_result = "Select password('$pwd') ";
	$pwd = mysql_result($MySQL->query($input_result),0,0);
	$qry="select * from member where userid='$userid' and pwd='$pwd'";
	$MySQL->query($qry);
	if(!$MySQL->is_affected())
	{
		$qry2="select * from member where userid='$userid'";
		$MySQL->query($qry2);
		if ($MySQL->is_affected())
		{
			$msg = "비밀번호가 잘못되었습니다.";
			MsgView($msg,-1);
			exit;
		}
		$qry3="select * from member where pwd='$pwd'";
		$MySQL->query($qry3);
		if ($MySQL->is_affected())
		{
			$msg = "아이디가 잘못되었습니다.";
			MsgView($msg,-1);
			exit;
		}
		$msg = "해당하는 정보가 없습니다.";
		MsgView($msg,-1);
		exit;
	}
	else
	{
		//회원 방문회수, 최근접속 일자
		$today=date("Y-m-d");
		$editQry = "update member set accNum =accNum+1 ,nearDay=now() where userid='$userid'";
		$MySQL->query($editQry);
		$user_row = $MySQL->fetch_array("select * from member where userid='$userid'");
		$qry="update cart set userid='$user_row[userid]' where userid='$_SESSION[GOOD_SHOP_USERID]'";
		$MySQL->query($qry);
		$qry="update today_view set userid='$user_row[userid]' where userid='$_SESSION[GOOD_SHOP_USERID]' and left(writeday,10)='$today'";
		$MySQL->query($qry);

		$GOOD_SHOP_USERID		= $user_row[userid];
		$GOOD_SHOP_NAME			= $user_row[name];
		$GOOD_SHOP_PART			= "member";
		$GOOD_SHOP_PART_GUBUN	= $user_row[part];	// M 회원, D 거래처
		$GOOD_SHOP_CART			= time();

		$_SESSION['GOOD_SHOP_USERID']		= "$GOOD_SHOP_USERID";
		$_SESSION['GOOD_SHOP_NAME']			= "$GOOD_SHOP_NAME";
		$_SESSION['GOOD_SHOP_PART']			= "$GOOD_SHOP_PART";
		$_SESSION['GOOD_SHOP_PART_GUBUN']	= "$GOOD_SHOP_PART_GUBUN";
		$_SESSION['GOOD_SHOP_CART']			= "$GOOD_SHOP_CART";

		// 장바구니 가격 체크
		$cart_result = $MySQL->query("SELECT * from cart WHERE userid='$_SESSION[GOOD_SHOP_USERID]'"); 
		while ($cart_row = mysql_fetch_array($cart_result))
		{
			$goods_info_row = $MySQL->fetch_array("select * from goods where idx=$cart_row[goodsIdx] limit 1"); //상품정보
			$gprice = new CGoodsPrice($goods_info_row[idx]);
			$price = $gprice->Price();
			$point = $gprice->PutPoint()*$cart_row[cnt];
			// 2006.05.04 수정(김성호)
			$qry="update cart set price=$price,point=$point where userid='$_SESSION[GOOD_SHOP_USERID]' and idx=$cart_row[idx]";
			$MySQL->query($qry);
		}
		if ($buy=="cart") ReFresh("cart.php");
		else ReFresh("order_sheet.php");
	}
}
else
{
	// 입력 받은 값 암호화
	$input_result = " Select password('$pwd') ";
	$pwd = mysql_result($MySQL->query($input_result),0,0);
	$qry="select *from member where userid='$userid' and pwd='$pwd'";
	$MySQL->query($qry);
	if(!$MySQL->is_affected())
	{
		$qry2="select *from member where userid='$userid'";
		$MySQL->query($qry2);
		if ($MySQL->is_affected())
		{
			$msg = "비밀번호가 잘못되었습니다.";
			MsgViewHref($msg,"login.php");
			exit;
		}

		$qry3="select *from member where pwd='$pwd'";
		$MySQL->query($qry3);
		if ($MySQL->is_affected())
		{
			$msg = "아이디가 잘못되었습니다.";
			MsgViewHref($msg,"login.php");
			exit;
		}

		// 관리자 사용자페이지 로그인
		if ($userid == $admin_row[adminId] && $pwd == $admin_row[adminPwd])
		{
			$GOOD_SHOP_USERID	= "admin";
			$GOOD_SHOP_NAME	= "관리자";
			$GOOD_SHOP_PART	= "member";
			$_SESSION['GOOD_SHOP_USERID'] = "$GOOD_SHOP_USERID";
			$_SESSION['GOOD_SHOP_NAME'] = "$GOOD_SHOP_NAME";
			$_SESSION['GOOD_SHOP_PART'] = "$GOOD_SHOP_PART";
			if (empty($referer)) ReFresh("index.php");
			else ReFresh($referer);
			exit;
		}
		else  // 관리자 아이디도 아니라면 
		{
			$msg = "해당하는 정보가 없습니다.";
			MsgViewHref($msg,"login.php");
			exit;
		}
	}
	else
	{
		$today=date("Y-m-d");
		$buyNum = $MySQL->fetch_array("select count(*) from trade where userid='$userid' and status>0 and status<4");
		$buyMoney =$MySQL->fetch_array("select sum(totalM) from trade where userid='$userid' and status>0 and status<4");
		//회원 방문회수, 최근접속 일자, 구매수, 구매액 수정
		if(empty($buyNum[0])) $buyNum[0] =0;
		if(empty($buyMoney[0])) $buyMoney[0] =0;
		$editQry = "update member set accNum =accNum+1 ,nearDay=now(),buyNum=$buyNum[0],buyMoney=$buyMoney[0] where userid='$userid'";
		$MySQL->query($editQry);
		$user_row = $MySQL->fetch_array("select *from member where userid='$userid'");

		$MySQL->query("update cart set userid='$user_row[userid]' where userid='$_SESSION[GOOD_SHOP_USERID]'");
		$MySQL->query("update today_view set userid='$user_row[userid]' where userid='$_SESSION[GOOD_SHOP_USERID]' and left(writeday,10)='$today'");

		$GOOD_SHOP_USERID		= $user_row[userid];
		$GOOD_SHOP_NAME			= $user_row[name];
		$GOOD_SHOP_PART			= "member";
		$GOOD_SHOP_CART			= time();
		$GOOD_SHOP_PART_GUBUN	= $user_row[part]; /// M 회원, D 거래처

		$_SESSION['GOOD_SHOP_USERID']		= "$GOOD_SHOP_USERID";
		$_SESSION['GOOD_SHOP_NAME']			= "$GOOD_SHOP_NAME";
		$_SESSION['GOOD_SHOP_PART']			= "$GOOD_SHOP_PART";
		$_SESSION['GOOD_SHOP_CART']			= "$GOOD_SHOP_CART";
		$_SESSION['GOOD_SHOP_PART_GUBUN']	= "$GOOD_SHOP_PART_GUBUN";

		$buyhap = $user_row[buyMoney]; //// 구매액
		if (empty($referer)) ReFresh("index.php");
		else if ($join_login) ReFresh("index.php");
		else ReFresh($referer);
	}
}
?>