<?
if(empty($_SESSION["GOOD_SHOP_USERID"]))
{
	MsgViewHref("회원메뉴입니다. 로그인 해주세요.","index.php");
	exit;
}
?>
<table width="650" border="0" cellspacing="0" cellpadding="0" align="center" bgcolor="#dadada">
	<tr bgcolor="#FFFFFF">
		<td><?
		if ($subdesign[titimg5])
		{
			?><img src="./upload/design/<?=$subdesign[titimg5]?>"><?
		}
		else
		{
			?><img src="image/work/company_img.gif"><?
		}
		?></td>
	</tr>
	<tr bgcolor="#FFFFFF">
		<td>
			<table width="680" border="0" cellspacing="0" cellpadding="0" align="center">
				<tr align="center" bgcolor='edf7f9'>
					<td height="70"><a href="mypage_member.php" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('my1','','image/member/mypage_top1_1.gif',1)"><img src="image/member/mypage_top1.gif" name="my1" border="0" id="my1"></a></td>
					<td><a href="mypage_order.php" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('my2','','image/member/mypage_top2_1.gif',1)"><img src="image/member/mypage_top2.gif" name="my2" border="0" id="my2"></a></td><?
					if($admin_row[bUsepoint])
					{
						//관리자 적립금 사용 설정
						?>
					<td><a href="mypage_point.php" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('my3','','image/member/mypage_top3_1.gif',1)"><img src="image/member/mypage_top3.gif" name="my3" border="0" id="my3"></a></td><?
					}
					?>
					<td><a href="mypage_interest.php" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('my4','','image/member/mypage_top4_1.gif',1)"><img src="image/member/mypage_top4.gif" name="my4" border="0" id="my41"></a></td>
					<td height="70"><a href="mypage_compare.php" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('my6','','image/member/mypage_top6_1.gif',1)"><img src="image/member/mypage_top6.gif" name="my6" border="0" id="my6"></a></td>
					<td><a href="mypage_ask.php" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('my7','','image/member/mypage_top7_1.gif',1)"><img src="image/member/mypage_top7.gif"  name="my7" border="0" id="my7"></a></td>
				</tr>
			</table>
		</td>
	</tr>
</table>