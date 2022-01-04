<?
include "head.php";
?>
<SCRIPT LANGUAGE="JavaScript">
<!--
function tradeSendit()
{
	var form=document.tradeSearchForm;
	if(form.tradecode.value=="")
	{
		alert("주문코드를 입력해 주십시오.");
		form.tradecode.focus();
		return false;
	}
	else
	{
		return true;
	}
}
//-->
</SCRIPT>
<? include "top.php";?>
<table width="900" border="0" cellspacing="0" cellpadding="0" bgcolor="<?=$ALL_BGCOLOR?>">
	<tr>
		<? include "left_menu.php";?>
		<td height="51" valign="top" width="720" bgcolor="#FFFFFF">
			<table width="720" height="100%" border="0" cellspacing="0" cellpadding="0">
				<tr bgcolor="#FFFFFF" valign="top">
					<td colspan="2" height="30">
						<table width="720" height="35" border="0" cellspacing="0" cellpadding="0" ailgn='center'>
							<tr>
								<td width="2"  bgcolor="<?=$subdesign[bc7]?>" rowspan="2"></td>
								<td width="2"  bgcolor="<?=$subdesign[bc7]?>" rowspan="2"></td>
								<td width="220" height="27" bgcolor="<?=$subdesign[bc7]?>"><img src="./upload/design/<?=$subdesign[img7]?>" ></td>
								<td width="490" height="27" bgcolor="<?=$subdesign[bc7]?>"><div align="right"> &nbsp;<font color="<?=$subdesign[tc7]?>"> <img src='image/good/icon0.gif'>&nbsp;현재위치 : HOME &gt; 주문조회</font>&nbsp;</div></td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td valign="top" width="720">
						<table width="720" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td> <img src="image/index/order_search.gif"></td>
							</tr>
						</table><br><br>
						<table width="650" border="0" cellspacing="0" cellpadding="0" align="center" background='image/index/search_bg.gif' height='300'>
							<tr>
								<td align="center" valign="top">
									<table width="600" border="0" cellspacing="0" cellpadding="0">
										<tr>
											<td><div align="center"></div></td>
										</tr>
										<tr>
											<td height="80">&nbsp; </td>
										</tr>
										<tr>
											<td>
												<table width="350" border="1" cellspacing="0" cellpadding="0" align="center" bordercolor="#FAFAFA" bordercolordark="ffffff" height="100">
													<tr>
														<td height="40" bgcolor="#f4f4f4"><div align="center">
															<form name="tradeSearchForm" method="post" action="order_refer_ok.php" onSubmit="return tradeSendit();">
															<table width="350" border="0" cellspacing="0" cellpadding="0">
																<tr>
																	<td width="100"> <div align="center"><font color="#114395">주문코드 :</font></div></td>
																	<td width="300"> <input type="text" name="tradecode" size="20"> <input type="image" src="image/icon/search.gif"> </td>
																</tr>
															</table>
															</form><!-- tradeSearchForm --></div>
														</td>
													</tr>
													<tr>
														<td height="25"> <div align="center"><font color="#00A2D0">* 상품 주문시 코드번호를 입력해 주세요.</font></div></td>
													</tr>
												</table>
											</td>
										</tr>
										<tr>
											<td height="100">&nbsp;</td>
										</tr>
									</table>
								</td>
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