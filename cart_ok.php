<?
// 소스형상관리
// 20060718-1 파일수정 김성호 : 옵션가격 적용 수정
session_start();
include "./lib/config.php";
include "./lib/function.php";
include "./lib/class.php";

if(empty($_SESSION[GOOD_SHOP_USERID]))
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
if ($act=="add" && $gidx_total)	// 관련상품 같이 담았을때
{
	$idx_arr = explode("/",$gidx_total);
	if (count($idx_arr)<2) $idx_arr[0] = $gidx_total;
	array_unshift($idx_arr,$goodsIdx);
	$is_Success = true;
	for ($i=0; $i<count($idx_arr); $i++)
	{
		if ($idx_arr[$i])
		{
			if ($i==0) $cnt = $cnt;
			else $cnt = 1;
			$goods_info_row = $MySQL->fetch_array("select * from goods where idx=$idx_arr[$i]");
			$gprice = new CGoodsPrice($goods_info_row[idx]);
			$option1 = (($i==0) && !empty($option1))?$goods_info_row[partName1]."」「".$option1:"";
			$option2 = (($i==0) && !empty($option2))?$goods_info_row[partName2]."」「".$option2:"";
			$option3 = (($i==0) && !empty($option3))?$goods_info_row[partName3]."」「".$option3:"";
			$chek_qry = "select * from cart where userid='$_SESSION[GOOD_SHOP_USERID]' and goodsIdx=$idx_arr[$i] and option1='$option1' and option2='$option2' and option3='$option3'";
			$cart_row = $MySQL->fetch_array($chek_qry);
			$price = $gprice->Price();
			$point = $gprice->PutPoint();
			if($cart_row[idx])
			{
				$cart_cnt = $cart_row[cnt]+$cnt;
				if ($goods_info_row[bLimit])
				{
					if ($goods_info_row[limitCnt] < $cart_cnt)
					{
						echo "<script>alert('$goods_info_row[name] 상품은 \\n재고부족으로 더이상 장바구니에 담을수 없습니다.')</script>";
						exit;
					}
				}
				$new_point = $point * $cart_cnt;
				$add_cart_qry = "update cart set price=$price, cnt=$cart_cnt, point=$new_point, writeday=now() where userid='$_SESSION[GOOD_SHOP_USERID]' and goodsIdx=$idx_arr[$i] and option1='$option1' and option2='$option2' and option3='$option3'";
			}
			else
			{
				$new_point = $point * $cnt;
				$add_cart_qry = "insert into cart(userid, goodsIdx,cnt,option1,option2,option3,price,point,writeday)values('$_SESSION[GOOD_SHOP_USERID]',$idx_arr[$i],$cnt,'$option1','$option2','$option3',$price,$new_point, now())";
			}
			if(!$MySQL->query($add_cart_qry))
			{
				echo"Err. : $add_cart_qry <br>";
				$is_Success = false;
			}
		}
	}
	if($is_Success)
	{
		if($channel == "cart") ReFresh("cart.php");
		else
		{
			if($GOOD_SHOP_PART =="member") ReFresh("order_sheet.php");	//회원바로구매하기
			else ReFresh("order_method_check.php");	//비회원바로구매하기
		}
	}
	else exit;
}
else if($act=="add")
{
	$goods_info_row = $MySQL->fetch_array("select * from goods where idx=$goodsIdx");
	$cnt = $cnt?$cnt:1;
	$option1 = !empty($option1)?$goods_info_row[partName1]."」「".$option1:"";
	$option2 = !empty($option2)?$goods_info_row[partName2]."」「".$option2:"";
	$option3 = !empty($option3)?$goods_info_row[partName3]."」「".$option3:"";
	$gprice = new CGoodsPrice($goods_info_row[idx]);
	$chek_qry = "select * from cart where userid='$GOOD_SHOP_USERID' and goodsIdx=$goodsIdx and option1='$option1' and option2='$option2' and option3='$option3' ";
	$cart_row = $MySQL->fetch_array($chek_qry);
	$price = $gprice->Price();
	$point = $gprice->PutPoint();
	if($cart_row[idx])
	{
		$cart_cnt = $cart_row[cnt]+$cnt;
		if ($goods_info_row[bLimit])
		{
			if ($goods_info_row[limitCnt] < $cart_cnt)
			{
				echo "<script>
				alert('$goods_info_row[name] 상품은 \\n재고부족으로 더이상 장바구니에 담을수 없습니다.');
				history.back();
				</script>";
				exit;
			}
		}
		$new_point = $point * $cart_cnt;
		$add_cart_qry = "update cart set price=$price, cnt=$cart_cnt, point=$new_point, writeday=now() where userid='$GOOD_SHOP_USERID' and goodsIdx=$goodsIdx and option1='$option1' and option2='$option2' and option3='$option3' ";
	}
	else
	{
		$new_point = $point * $cnt;
		$add_cart_qry = "insert into cart(userid, goodsIdx,cnt,option1,option2,option3,price,point,writeday)values('$GOOD_SHOP_USERID',$goodsIdx,$cnt,'$option1','$option2','$option3',$price,$new_point, now())";
	}
	if($MySQL->query($add_cart_qry))
	{
		if($channel == "cart") ReFresh("cart.php");
		else
		{
			if($GOOD_SHOP_PART =="member") ReFresh("order_sheet.php"); //회원바로구매하기
			else ReFresh("order_method_check.php");	//비호원바로구매하기
		}
	}
	else echo"Err. : $add_cart_qry";
}
else if($act =="edit")
{
	$cart_row = $MySQL->fetch_array("select * from cart where idx=$cartIdx");
	$goods_info_row = $MySQL->fetch_array("select * from goods where idx=$cart_row[goodsIdx]");
	$gprice = new CGoodsPrice($goods_info_row[idx]);
	$price = $gprice->Price();
	$point = $gprice->PutPoint();
	$new_point = $point * $cnt;
	$edit_qry = "update cart set cnt = $cnt,point=$new_point,price=$price, writeday=now() where idx=$cartIdx";
	if($MySQL->query($edit_qry)) ReFresh("cart.php");
	else echo"Err. : $edit_qry";
}
else if($act =="del")
{
	$del_qry = "delete from cart  where idx=$cartIdx";
	if($MySQL->query($del_qry)) ReFresh("cart.php");
	else echo"Err. : $del_qry";
}
?>