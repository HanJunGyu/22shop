<?
// 소스형상관리
// 20060720-1 소스수정 김성호 : 결제방식 정보 세분화(카드, 핸드폰, 계좌이체, 가상계좌, 무통장)
include "head.php";
if($admin_row[xOrder_bhtml])
{
	$xOrder = $admin_row[xOrder];
}
else
{
	$xOrder = nl2br(htmlspecialchars($admin_row[xOrder]));
}
$trade_row = $MySQL->fetch_array("select *from trade where tradecode='$tradecode'");  //주문정보
$MySQL->query("delete from cart where userid='$trade_row[userid]'");
$MySQL->query("delete from trade_temp where tradecode='$tradecode'");
if($trade_row[payMethod] =="card") $payMethod="<B>카드결제</B> [".$trade_row[bankInfo]."]";
elseif($trade_row[payMethod] =="hand") $payMethod="<B>휴대폰</B> [".$trade_row[bankInfo]."]";
elseif($trade_row[payMethod] =="iche") $payMethod="<B>계좌이체</B> [".$trade_row[bankInfo]."]";
elseif($trade_row[payMethod] =="cyber") $payMethod="<B>가상계좌</B> [".$trade_row[bankInfo]."]";
elseif($trade_row[payMethod] =="bank") $payMethod="<B>무통장</B> [".$trade_row[bankInfo]."]";
?>
<? include "top.php";?>
<table width="900" border="0" cellspacing="0" cellpadding="0" bgcolor="<?=$ALL_BGCOLOR?>">
	<tr>
		<? include "left_menu.php";?><?
		?>
		<td height="51" valign="top" width="720" bgcolor="#FFFFFF">
			<table width="720" height="100%" border="0" cellspacing="0" cellpadding="0">
				<tr bgcolor="#FFFFFF" valign="top">
					<td colspan="2" height="51">
						<table width="720" height="35" border="0" cellspacing="0" cellpadding="0" align='center'>
							<tr>
								<td width="2"  bgcolor="<?=$subdesign[bc7]?>" rowspan="2"></td>
								<td width="2"  bgcolor="<?=$subdesign[bc7]?>" rowspan="2"></td>
								<td width="220" height="27" bgcolor="<?=$subdesign[bc7]?>"><img src="./upload/design/<?=$subdesign[img7]?>" ></td>
								<td width="490" height="27" bgcolor="<?=$subdesign[bc7]?>"><div align="right"> &nbsp;<font color="<?=$subdesign[tc7]?>"> &nbsp; 현재위치 : HOME &gt; 주문정보</font>&nbsp;</div></td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td valign="top" width="720"><br>
						<table width="700" border="0" cellspacing="0" cellpadding="0" align="center">
							<tr>
								<td align=center><img src="image/sub/order_04.gif"></td>
							</tr>
						</table><br><br>
						<table width="650" border="0" cellspacing="0" cellpadding="0" align="center" height="360">
							<tr>
								<td><img src='image/sub/order_ok_t.gif'></td>
							</tr>
							<tr>
								<td background='image/sub/order_ok_bg.gif'>
									<table width="560" border="0" cellspacing="10" cellpadding="10" align='center' bgcolor='f4f4f4'>
										<tr>
											<td>
												<table width="80%" border="0" cellspacing="0" cellpadding="0">
													<tr>
														<td height="20" style='padding:0 0 0 10'>주문 코드 :</td>
														<td height="20"><FONT  COLOR="#ff0000"><?=$tradecode?></FONT></td>
													</tr>
													<tr>
														<td height="20" style='padding:0 0 0 10'>결제 금액 :</td>
														<td height="20"><FONT  COLOR="#CC0000"><?=PriceFormat($trade_row[payM])?> 원</FONT></td>
													</tr>
													<tr>
														<td height="20" style='padding:0 0 0 10'>결제 종류 :</td>
														<td height="20"> <?=$payMethod?></td>
													</tr>
													<tr>
														<td colspan=2 style='padding:10 0 0 0'><?=$xOrder?></td>
													</tr>
												</table>
											</td>
										</tr>
									</table>
								</td>
							</tr>
							<tr>
								<td background='image/sub/order_ok_bg.gif' align='right' style='padding:10 40 10 10'><a href="<?if($_SESSION[GOOD_SHOP_PART]!="member") echo "order_refer.php"; else echo "mypage_order.php";?>"><img src="image/icon/btn_go_order.gif"></a> <a href="index.php"><img src="image/icon/btn_main.gif"></a></td>
							</tr>
							<tr>
								<td><img src='image/sub/order_ok_b.gif'></td>
							</tr>
						</table><br><br><br><br><br><br><br>
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>
<? include "copy.php"; ?>
</div>
</body>
</html>