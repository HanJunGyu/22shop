<?
session_start();
include "./lib/config.php";
include "./lib/function.php";
include "./lib/class.php";
$idxstr = Laststrcut($idxstr);
if (empty($_SESSION["GOOD_SHOP_USERID"]))
{
	//비회원 세션 아이디 등록
	$GOOD_SHOP_USERID	= time();
	$GOOD_SHOP_NAME		= "비회원";
	$GOOD_SHOP_PART		= "guest";
	$GOOD_SHOP_CART		= time();
	$GOOD_SHOP_PART_GUBUN	= "G";
	$_SESSION['GOOD_SHOP_USERID'] = "$GOOD_SHOP_USERID";
	$_SESSION['GOOD_SHOP_NAME'] = "$GOOD_SHOP_NAME";
	$_SESSION['GOOD_SHOP_PART'] = "$GOOD_SHOP_PART";
	$_SESSION['GOOD_SHOP_CART'] = "$GOOD_SHOP_CART";
	$_SESSION['GOOD_SHOP_PART_GUBUN'] = "$GOOD_SHOP_PART_GUBUN";
}
$idx_arr = explode("/",$idxstr);
if (count($idx_arr)==1) $idx_arr[0] = $idxstr;
$cnt=1; /////수량 
for ($i=0; $i<count($idx_arr); $i++)
{
	$goods_info_row = $MySQL->fetch_array("select *from goods where idx=$idx_arr[$i]"); //상품정보
	$gprice = new CGoodsPrice($goods_info_row[idx]);
	if(!empty($option1)) $option1 = $goods_info_row[partName1]."」「".$option1;//상품옵션  ex) 색깔」「노랑 
	else $option1="";
	if(!empty($option2)) $option2 = $goods_info_row[partName2]."」「".$option2;
	else $option2="";
	if(!empty($option3)) $option3 = $goods_info_row[partName3]."」「".$option3;
	else $option3="";
	$chek_qry = "select *from cart where userid='$GOOD_SHOP_USERID' and goodsIdx=$idx_arr[$i] and option1='$option1' and option2='$option2' and option3='$option3'";
	$MySQL->query($chek_qry);
	if($MySQL->is_affected())
	{
		//같은상품이 현재 장바구니에 존재할 경우 개수만 증가
		$cart_row = $MySQL->fetch_array($chek_qry);
		if ($goods_info_row[bLimit])//상품 재고량 사용할때
		{
			$cart_cnt = $cart_row[cnt]+$cnt; // 현재 장바구니에 담긴 상품갯수 + 수량추가 
			if ($goods_info_row[limitCnt] < $cart_cnt) // 장바구니에 담긴 상품수량이 상품재고를 넘으면 
			{
				echo "<script>alert('$goods_info_row[name] 상품은 \\n재고부족으로 더이상 장바구니에 담을수 없습니다.')</script>";
				exit;
			}
		}
		$new_cnt = $cart_row[cnt]+$cnt;
		$new_point = ($cart_row[point]/$cart_row[cnt]) * $new_cnt; ///2006.1.19 추가
		$add_cart_qry = "update cart set cnt=cnt+$cnt,point=$new_point where userid='$GOOD_SHOP_USERID' and goodsIdx=$idx_arr[$i] and option1='$option1' and option2='$option2' and option3='$option3'";
	}
	else
	{
		//장바구니 담기
		$price = $gprice->Price();
		$point = $gprice->PutPoint();
		$point = $point *$cnt;
		$add_cart_qry = "insert into cart(userid, goodsIdx,cnt,option1,option2,option3,price,point,writeday)values('$GOOD_SHOP_USERID',$idx_arr[$i],$cnt,'$option1','$option2','$option3',$price,$point, now())";
	}
	$MySQL->query($add_cart_qry);
}
?>
<SCRIPT LANGUAGE="JavaScript">
<!--
function goMypage()
{
	opener.location.href="cart.php";
	window.close();
}
//-->
</SCRIPT>
<style>
.tt01{ font-family:돋움 ; font-size:9pt ; font-weight:bold ; letter-spacing:-1px ; LINE-HEIGHT: 160%;}
</style>
<body bgcolor="#FFFFFF" topmargin='10' leftmargin='10' text='464646' marginwidth="0" marginheight="0">
<table width="430" border='0' cellpadding='0' cellspacing='0'>
	<tr>
		<td width='4'><img src='image/sub/table_tleft.gif'></td>
		<td width='422' background='image/sub/table_tbg.gif'></td>
		<td width='4'><img src='image/sub/table_tright.gif'></td>
	</tr>
	<tr>
		<td background='image/sub/interest_bg.gif' colspan='3' align='center'>
			<table width="410" height="150" border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td valign="top" align="center"><img src="image/work/cart_ok_mid.gif"></td>
				</tr>
				<tr>
					<td style='padding:30 10 10 30'><font class='tt01'>선택한 상품이 장바구니에 담겼습니다. <br>장바구니를 지금 확인하시겠습니까? 등록하신 상품은 상단메뉴<br><font color='ff4800'>장바구니</font> 에서 확인하실 수 있습니다.</font></td>
				</tr>
				<tr>
					<td align="center" style='padding:10 10 10 10'><a href="javascript:goMypage();"><img src="image/icon/cart_btn_s.gif" border="0"></a> <a href="javascript:window.close();"><img src="image/icon/close.gif" border="0"></a></td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td><img src='image/sub/table_bleft.gif'></td>
		<td background='image/sub/table_bbg.gif'></td>
		<td><img src='image/sub/table_bright.gif'></td>
	</tr>
</table>
</body>
</html>