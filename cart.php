<?
include "head.php";
$MySQL->query("DELETE from cart where userid='$_SESSION[GOOD_SHOP_USERID]' and writeday < now() - INTERVAL 1 DAY");
if($admin_row[xCart_bhtml])
{
	$xCart = $admin_row[xCart];
}
else
{
	$xCart = nl2br(htmlspecialchars($admin_row[xCart]));
}
?>
<SCRIPT LANGUAGE="JavaScript">
<!--
//장바구니 수정
function cartEdit(Obj,bLimit,limitCnt,minbuyCnt,maxbuyCnt)
{
	var Cnt = Obj.cnt.value;
	if(Cnt=="" || Cnt=="0" ||Cnt==0 || !numCheck(Cnt))
	{
		alert("구매수량이 올바르지 않습니다.");
		Obj.cnt.focus();
	}
	else if(bLimit && Cnt > limitCnt)
	{
		alert("죄송합니다. 재고수량이 부족합니다.\n\n재고량 : "+limitCnt);
		Obj.cnt.focus();
	}
	else if(minbuyCnt!=0 && Cnt<minbuyCnt)
	{
		alert("본 상품의 최소구매수량은 "+minbuyCnt+ " 개 입니다.");
		Obj.cnt.value = minbuyCnt;
		Obj.cnt.focus();
	}
	else if(maxbuyCnt!=0 && Cnt>maxbuyCnt)
	{
		alert("본 상품의 최대구매수량은 "+maxbuyCnt+ " 개 입니다.");
		Obj.cnt.value = maxbuyCnt;
		Obj.cnt.focus();
	}
	else
	{
		Obj.action = "cart_ok.php?act=edit";
		Obj.submit();
	}
}

//장바구니 삭제
function cartDel(Obj)
{
	Obj.action = "cart_ok.php?act=del";
	Obj.submit();
}

function cartok(url)
{
	location.href= url;
}
//-->
</SCRIPT>
<? include "top.php"; ?>
<table width="900" border="0" cellspacing="0" cellpadding="0" bgcolor="<?=$ALL_BGCOLOR?>">
	<tr>
		<? include "left_menu.php"; ?>
		<td valign="top" width="720" bgcolor="#FFFFFF">
			<table width="720"  border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td width="2" height="30" bgcolor="<?=$subdesign[bc6]?>" rowspan="2"></td>
					<td width="2" height="30" bgcolor="<?=$subdesign[bc6]?>" rowspan="2"></td>
					<td width="220" height="30" bgcolor="<?=$subdesign[bc6]?>"><img src="./upload/design/<?=$subdesign[img6]?>" ></td>
					<td width="490" height="30" bgcolor="<?=$subdesign[bc6]?>"><div align="right"> &nbsp;<font color="<?=$subdesign[tc6]?>"> <img src='image/good/icon0.gif'>&nbsp;현재위치 : HOME &gt; 장바구니</font></td>
				</tr>
			</table>
			<table width="700" border="0" cellspacing="0" cellpadding="0" align="center">
				<tr>
					<td valign="top"><?
					if ($subdesign[titimg11])
					{
						?><img src="./upload/design/<?=$subdesign[titimg6]?>" ><?
					}
					else
					{
						?><img src="image/index/shopping_img.gif" ><?
					}
					?></td>
				</tr>
			</table>
			<br>
			<table width="700" border="0" cellspacing="0" cellpadding="0" align="center">
				<tr>
					<td align=center><img src="image/sub/order_01.gif"></td>
				</tr>
			</table>
			<br>
			<table width="670" border="0" cellspacing="0" cellpadding="0" align="center">
				<tr>
					<td colspan='11' bgcolor='80c9d8' height='2'></td>
				</tr>
				<tr align="center" bgcolor="#edf7f9">
					<td width="220" height="30"><font color='006676'><b>상품명</b></font></td>
					<td width='1'><img src='image/board/line.gif'></td>
					<td width="135"><font color='006676'><b>옵 션</b></font></td>
					<td width='1'><img src='image/board/line.gif'></td>
					<td width="80"><font color='006676'><b>가 격</b></font></td>
					<td width='1'><img src='image/board/line.gif'></td>
					<td width="80"><font color='006676'><b>수 량</b></font></td>
					<td width='1'><img src='image/board/line.gif'></td>
					<td width="80"><font color='006676'><b>합 계</b></font></td>
					<td width='1'><img src='image/board/line.gif'></td>
					<td width="70"><font color='006676'><b>삭 제</b></font></td>
				</tr>
				<tr>
					<td colspan='11' bgcolor='80c9d8' height='1'></td>
				</tr><?
				$cart_result = $MySQL->query("select * from cart where userid='$_SESSION[GOOD_SHOP_USERID]' order by goodsIdx desc");
				$cart_goods_cnt = $MySQL->is_affected(); //현재장바구니 물품개수
				if(empty($cart_goods_cnt))
				{
					//장바구니 물품 없음
					?>
				<tr>
					<td bgcolor="#FaFaFa" colspan="11" height="30" align="center">장바구니에 현재 등록된 물품이 없습니다.</td>
				</tr>
				<tr>
					<td bgcolor="#e1e1e1" colspan="11" height="1">
				</tr><?
				}
				else
				{
					?>
				<tr valign="top">
					<td colspan="11">
						<!-- 장바구니 목록 시작 -->
						<table width="670" border="0" cellspacing="0" cellpadding="0" align="center"><?
						$cart_cnt = 0;
						$total_price = 0;
						while($cart_row = mysql_fetch_array($cart_result))
						{
							$goods_row = $MySQL->fetch_array("select * from goods where idx=$cart_row[goodsIdx]");	// 상품정보
							$gprice = new CGoodsPrice($goods_row[idx]);
							if ($admin_row[bNew])
							{
								$bNew = limitday($goods_row[writeday],$admin_row[new_day]);
								if (empty($bNew) && $goods_row[bNew]) $bNew = "<img src='./upload/goods_new_img'>";
							}
							$bHit =$goods_row[bHit]?"<img src='./upload/goods_hit_img'>":"";	// 히트 이미지
							$bEtc =$goods_row[bEtc]?"<img src='./upload/goods_etc_img'>":"";	// 기타 이미지
							$optionArr = Array("$cart_row[option1]","$cart_row[option2]","$cart_row[option3]");	// 옵션 배열
							$tprice	   = $cart_row[cnt] * $cart_row[price];	// 구매가격 : 상품가격X상품수량
							$bLimit	   = $goods_row[bLimit];	// 재고수량 사용 ex)1:재고수량 사용  0:무제한	
							$limitCnt  = $goods_row[limitCnt];	// 재고수량  0:품절
							if (($bLimit==1 && $limitCnt==0) || $bLimit==2)
							{
								$pumjul = 1;
							}
							else $pumjul = 0;
							if (empty($GD_SET) && $goods_row[img_onetoall]) $img_str = $goods_row[img3];
							else if ($GD_SET && $goods_row[img_onetoall] && empty($goods_row[img1])) $img_str = $goods_row[img3];
							else if ($GD_SET && empty($goods_row[img_onetoall]) && empty($goods_row[img1])) $img_str = $goods_row[img3];
							else $img_str = $goods_row[img1];
							?>
							<form name="cartForm<?=$cart_cnt?>" method="post">
							<input type="hidden" name="cartIdx" value="<?=$cart_row[idx]?>"><!-- 장바구니 idx 번호 -->
							<tr>
								<td height="45" width="50"><img src="upload/goods/<?=$img_str?>" width="45" height="45"></td>
								<td height="45" width="171"><a href="goods_detail.php?goodsIdx=<?=$goods_row[idx]?>"><?=$goods_row[name]?></a> <?=$bHit?> <?=$bNew?> <?=$bEtc?><?
								if ($pumjul)
								{
									?><br><font color="red"><b>-품절-</b></font><?
								}
								?></td>
								<td height="45" width="136">
									<table width="136" border="0" cellspacing="0" cellpadding="0" align="center"><?
									for($i=0;$i<count($optionArr);$i++)
									{
										if(!empty($optionArr[$i]))
										{
											$option = explode("」「",$optionArr[$i]);
											?>
										<tr>
											<td width="50" bgcolor="#F7F7F7"> <div align="center"><?=$option[0]?> </div></td>
											<td width="86" bgcolor="#DDFFFB"> <div align="left"> : <?=$option[1]?></div></td>
										</tr>
										<tr  bgcolor="#CCCCCC">
											<td colspan="2" height="1"></td>
										</tr><?
										}
									}
									?>
									</table>
								</td>
								<td height="45" width="81" align="center"><?=$gprice->PutPrice();?> 원</td>
								<td height="45" width="81" align="center">
									<table width="81" border="0" cellspacing="0" cellpadding="0">
										<tr>
											<td align="center"><input type="text" name="cnt" size="2" value="<?=$cart_row[cnt]?>">개</td>
										</tr>
										<tr>
											<td align="center"><a href="javascript:cartEdit(document.cartForm<?=$cart_cnt?>,<?=$bLimit?>,<?=$limitCnt?>,<?=$goods_row[minbuyCnt]?>,<?=$goods_row[maxbuyCnt]?>);"><img src="image/icon/edit_btn.gif" border="0"></a></td>
										</tr>
									</table>
								</td>
								<td height="45" width="81" align="center"><FONT COLOR="#6600FF"><?=PriceFormat($tprice)?></FONT> 원</td>
								<td height="45" width="70" align="center"><a href="javascript:cartDel(document.cartForm<?=$cart_cnt?>);"><img src="image/icon/btn_delete0.gif" border="0"></a></td>
							</tr>
							<tr bgcolor="#CCCCCC">
								<td colspan="7" height="1"></td>
							</tr>
							</form><!-- cartForm --><?
							$cart_cnt++;
							$total_price += $tprice;				//총구매금액 ex)tprice 의 합
						}
						?>
							<tr>
								<td height="30" colspan="7">
									<table width="670" border="0" cellspacing="1" cellpadding="0" bgcolor="#ffffff" align="right">
										<tr>
											<td bgcolor="fafafa" height="30" align="right">&nbsp;&nbsp;<B>상품합계</B> : <b><font color="#FF0000"><?=PriceFormat($total_price)?>원</font></b> </td>
										</tr>
									</table>
								</td>
							</tr>
						</table>
					</td>
				</tr><?
				}
				?>
			</table>
			<br><br>
			<table width="670" border="0" cellspacing="0" cellpadding="0" align="center"><?
			if(empty($admin_row[bTrans]) && empty($admin_row[chakbul]))	// 배송비미사용
			{
				$transM = 0;
				$transMstr = "무료";
			}
			else if(empty($admin_row[bTrans]) && $admin_row[chakbul])	// 배송비미사용&착불
			{
				$transM = 0;
				$transMstr = "착불";
			}
			else
			{
				if($admin_row[noTrans] <=$total_price)
				{
					$transM = 0;
					$transMstr=PriceFormat($transM)." 원";
				}
				else	//배송비무료 적용금액
				{
					$transM = $admin_row[transMoney];
					$transMstr=PriceFormat($transM)." 원";
				}
				//배송비적용
			}
			if ($MySQL->articles("SELECT idx from cart WHERE userid='$_SESSION[GOOD_SHOP_USERID]'")==1) // 장바구니에 물품이 1개일때 
			{
				$cart_row = $MySQL->fetch_array("SELECT goodsIdx from cart WHERE userid='$_SESSION[GOOD_SHOP_USERID]' limit 1");
				$goods_row = $MySQL->fetch_array("SELECT size from goods WHERE idx=$cart_row[goodsIdx] limit 1");
				if ($goods_row[size]=="n") //무료배송 상품이면 
				{
					$transM = 0;
					$transMstr=PriceFormat($transM)." 원";
				}
			}
			if (!$transMstr) $transMstr=PriceFormat($transM)." 원";
			?>
				<tr>
					<td height="30" colspan="7">
						<table width="100%" border="0" cellspacing="1" cellpadding="0" bgcolor="#ffffff" align="right">
							<tr>
								<td bgcolor="fafafa" height="30" align="right">[ 배송비 : <font color="#FF0000"><?=$transMstr?></font> ] &nbsp;&nbsp; <B>결제금액</B> : <b><font color="#FF0000"><?=PriceFormat($total_price+$transM)?>원</font></b> </td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
			<br>
			<table width="50%" border="0" cellspacing="0" cellpadding="0" align="center">
				<tr><?
				if(!empty($cart_goods_cnt))
				{
					if($_SESSION[GOOD_SHOP_PART] =="member")
					{
						?>
					<td align="center"><a href="#;" onclick="cartok('order_sheet.php')"><img src="image/icon/order_btn.gif" border="0"></a></td><?
					}
					else
					{
						?>
					<td align="center"><a href="#;" onclick="cartok('order_method_check.php?channel=cart')"><img src="image/icon/order_btn.gif" border="0"></a></td><?
					}
				}
				?>
					<td align="center"><a href="javascript:history.go(-2);"><img src="image/icon/shopping_continue_btn.gif" border="0"></a></td>
					<td align="center"><a href="javascript:history.back();"><img src="image/icon/prev_btn.gif" border="0"></a></td>
				</tr>
			</table><br><br>
			<table width="670" border="0" cellspacing="0" cellpadding="0" align="center">
				<tr>
					<td bgcolor='dadfe5' height='1'></td>
				</tr>
				<tr>
					<td height="30" bgcolor='eff3f4' style='padding:0 0 0 10'><img src='image/index/icon_cate00.gif'> <font color='3d5b75'><b>장바구니 이용안내</b></font></td>
				</tr>
				<tr>
					<td bgcolor='dadfe5' height='1'></td>
				</tr>
				<tr>
					<td style='padding:10 10 10 10'><?=$xCart?></td>
				</tr>
				<tr>
					<td bgcolor='dadfe5' height='1'></td>
				</tr>
			</table><br>
		</td>
	</tr>
</table>
<? include "copy.php"; ?>
</div>
</body>
</html>