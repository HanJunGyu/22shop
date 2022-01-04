<?
include "head.php";
$idxstr = Laststrcut($idxstr);
if (empty($_SESSION["GOOD_SHOP_USERID"]))
{
	$GOOD_SHOP_USERID	= time();
	$GOOD_SHOP_NAME		= "?";
	$GOOD_SHOP_PART		= "guest";
	$GOOD_SHOP_CART		= time();
	$_SESSION[GOOD_SHOP_USERID] = $GOOD_SHOP_USERID;
	$_SESSION[GOOD_SHOP_NAME] = $GOOD_SHOP_NAME;
	$_SESSION[GOOD_SHOP_PART] = $GOOD_SHOP_PART;
	$_SESSION[GOOD_SHOP_CART] = $GOOD_SHOP_CART;
}
$idx_arr = explode("/",$idxstr);
if (count($idx_arr)==1) $idx_arr[0] = $idxstr;
for ($i=0; $i<count($idx_arr); $i++)
{
	if (!$MySQL->articles("SELECT idx from compare WHERE userid='$_SESSION[GOOD_SHOP_USERID]' and goodsIdx=$idx_arr[$i]"))
	{
		$MySQL->query("INSERT INTO compare values('','$_SESSION[GOOD_SHOP_USERID]',$idx_arr[$i])");
	}
}
?>
<SCRIPT LANGUAGE="JavaScript">
<!--
function goMypage()
{
	opener.location.href="mypage_compare.php";
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
					<td><img src="image/work/compare_ok_top.gif" ></td>
				</tr>
				<tr>
					<td style='padding:30 10 10 30'><font class='tt01'>선택한 상품이 비교상품목록에 담겼습니다. <br>비교상품목록을 지금 확인하시겠습니까?<br>등록하신 비교상품은 <font color='ff4800'>마이페이지>비교물품보기</font> 에서 확인하실 수 <br>있습니다</font></td>
				</tr>
				<tr>
					<td align="center" style='padding:10 10 10 10'><a href="javascript:goMypage();"><img src="image/icon/compare_btn2.gif"  border="0"></a> <a href="javascript:window.close();"><img src="image/icon/close.gif" border="0"></a></td>
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