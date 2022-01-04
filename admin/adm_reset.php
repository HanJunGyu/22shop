<?
include "head.php";
$now = date("Y-m-d",time());
$now = explode("-",$now);
$year = $now[0];
$month = $now[1];
$day = $now[2];
if ($cart_del)
{
	if (strlen($month)==1) $month = "0".$month;
	if (strlen($day)==1) $day = "0".$day;
	$del_day = $year."-".$month."-".$day;
	$cart_num = $MySQL->articles("SELECT idx from cart WHERE left(writeday,10) < '$del_day'");
	if($MySQL->query("DELETE from cart WHERE left(writeday,10) < '$del_day'"))
	{
		MsgViewHref("삭제하였습니다. $cart_num 건","adm_reset.php");
		exit;
	}
	else
	{
		MsgViewHref("삭제에 실패하였습니다.","adm_reset.php");
	}
}
if ($interest_del)
{
	if (strlen($month)==1) $month = "0".$month;
	if (strlen($day)==1) $day = "0".$day;
	$del_day = $year."-".$month."-".$day;
	$interest_num = $MySQL->articles("SELECT idx from interest WHERE left(writeday,10) < '$del_day'");
	if($MySQL->query("DELETE from interest WHERE left(writeday,10) < '$del_day'"))
	{
		MsgViewHref("삭제하였습니다. $interest_num 건","adm_reset.php");
		exit;
	}
	else
	{
		MsgViewHref("삭제에 실패하였습니다.","adm_reset.php");
	}
}
?>
<SCRIPT LANGUAGE="JavaScript">
<!--
function reset2(part)
{
	<? if (__DEMOPAGE){ ?>
	alert("데모페이지는 기능이 제한되어 있습니다.");
	<? }else{ ?>
	if (confirm("호스팅업체의 백업서비스 신청여부를 확인하셨습니까?"))
	{
		if (confirm("실제 데이터를 정말 초기화 하시겠습니까?"))
		{
			document.adm_etcForm.resetmall.value = 1;
			document.adm_etcForm.action = document.adm_etcForm.action + "?part="+part;
			document.adm_etcForm.submit();
		}
	}
	<? } ?>
}
function cart_del()
{
	location.href="adm_reset.php?cart_del=1";
}
function interest_del()
{
	location.href="adm_reset.php?interest_del=1";
}
//-->
</SCRIPT>
<body bgcolor="#FFFFFF" text="#5A595A" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<? include "top_menu.php"; ?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr><?
	$__TOP_MENU = "basic";     //왼쪽 소메뉴 설정 변수
	include "left_menu.php";
	?>
		<td width="85%" valign="top">
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td height='5'></td>
				</tr>
				<tr>
					<td>
						<table width="750" border="0" cellspacing="0" cellpadding="0" align='center'>
							<tr>
								<td rowspan="3" width="200"><img src="image/account_tit_.gif"></td>
								<td>&nbsp;</td>
							</tr>
							<tr>
								<td bgcolor="#E6E6E6" height='26'><div align='right'><font class='text1'>SHOP 기본정보를 수정하실수 있습니다.&nbsp;</div></td>
							</tr>
							<tr>
								<td>&nbsp;</td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td>
						<form name="adm_etcForm" method="post" action="adm_reset_ok.php">
						<input type="hidden" name="resetmall" value="0">
						<table width="750" border="0" cellspacing="0" cellpadding="0" align="center" >
							<tr>
								<td colspan="2">
									<table width="750" border="0" cellspacing="0" cellpadding="0" align="center">
										<tr>
											<td height='1' colspan='3' bgcolor='DADADA'></td>
										</tr>
										<tr>
											<td width='440'><img src="image/etc_mid_etc.gif"></td>
										</tr>
										<tr>
											<td height='1' colspan='3' bgcolor='DADADA'></td>
										</tr>
									</table>
								</td>
							</tr>
							<tr>
								<td height='5' colspan="2"></td>
							</tr>
							<tr>
								<td width="250" height="100" bgcolor="#FAFAFA">&nbsp;&nbsp;<img src="image/icon.gif" width="11" height="11"> 쇼핑몰 전체 초기화</td>
								<td align="left">&nbsp;<img src="image/log_btn1.gif" onclick="reset2('all');" style="cursor:pointer;"><br>&nbsp;<font color="red"><b>※주의)상품,카테고리,게시판,회원,주문,카운터등의 실제데이터가 모두 삭제됨</b></font></td>
							</tr>
							<tr>
								<td colspan="2" height="1" background="image/line_bg1.gif"></td>
							</tr>
							<tr>
								<td width="250" height="100" bgcolor="#FAFAFA">&nbsp;&nbsp;<img src="image/icon.gif" width="11" height="11"> 쇼핑몰 부분 초기화</td>
								<td align="left">&nbsp;게시판/공지사항/설문조사 관련 삭제<br>&nbsp;<img src="image/log_btn1.gif" border=0 onclick="javascript:reset2('board');" style="cursor:pointer;">
								<br><br>&nbsp;카테고리/상품 관련 삭제<br>&nbsp;<img src="image/log_btn1.gif" border=0 onclick="javascript:reset2('goods');" style="cursor:pointer;">
								<br><br>&nbsp;주문 관련 삭제<br>&nbsp;<img src="image/log_btn1.gif" border=0 onclick="javascript:reset2('trade');" style="cursor:pointer;">
								<br><br>&nbsp;회원/적립금 관련 삭제<br>&nbsp;<img src="image/log_btn1.gif" border=0 onclick="javascript:reset2('member');" style="cursor:pointer;">
								<br><br>&nbsp;접속통계 관련 삭제<br>&nbsp;<img src="image/log_btn1.gif" border=0 onclick="javascript:reset2('stat');" style="cursor:pointer;">
								<br><br>&nbsp;베너/사용자정의페이지 삭제<br>&nbsp;<img src="image/log_btn1.gif" border=0 onclick="javascript:reset2('design');" style="cursor:pointer;">
								<br><br>&nbsp;기타 삭제 (ip차단목록,사용자 소스수정내역,패치예정내역)<br>&nbsp;<img src="image/log_btn1.gif" border=0 onclick="javascript:reset2('etc');" style="cursor:pointer;"></td>
							</tr>
							<tr>
								<td colspan="2" height="1" background="image/line_bg1.gif"></td>
							</tr>
							<tr>
								<td width="180" height="25" bgcolor="#FAFAFA">&nbsp;&nbsp;<img src="image/icon.gif" width="11" height="11"> 장바구니 삭제</td>
								<td width="379" height="25">
									<table width="150" border="0" cellspacing="0" cellpadding="0">
										<tr>
											<td width="50"></td>
											<td>&nbsp;&nbsp;<input type="button" onclick="javascript:cart_del();" value="어제의정보까지삭제"></td>
										</tr>
									</table>
								</td>
							</tr>
							<tr>
								<td colspan="2" height="1" background="image/line_bg1.gif"></td>
							</tr>
							<tr>
								<td width="180" height="25" bgcolor="#FAFAFA">&nbsp;&nbsp;<img src="image/icon.gif" width="11" height="11"> 관심품목 삭제</td>
								<td width="379" height="25">
									<table width="150" border="0" cellspacing="0" cellpadding="0">
										<tr>
											<td width="50"></td>
											<td>&nbsp;&nbsp;<input type="button" onclick="javascript:interest_del();" value="어제의정보까지삭제"></td>
										</tr>
									</table>
								</td>
							</tr>
							<tr>
								<td colspan="2" height="1" background="image/line_bg1.gif"></td>
							</tr>
						</table></form><!-- adm_etcForm -->
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>
<? include "copy.php";?>
</body>
</html>