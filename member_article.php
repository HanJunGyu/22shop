<?
include "head.php";
if(!defined(__ADMIN_ROW))
{
	define(__ADMIN_ROW,"TRUE");
	$admin_row=$MySQL->fetch_array("select *from admin limit 0,1");
}
if($admin_row[xProfit_bhtml])
{
	$xProfit = $admin_row[xProfit];
}
else
{
	$xProfit = nl2br(htmlspecialchars($admin_row[xProfit]));
}
?>
<SCRIPT LANGUAGE="JavaScript">
<!--
function agreeSendit(Part)
{
	var form=document.agreeForm;
	if(!form.agreement.checked)
	{
		alert("이용약관에 동의하셔야 회원가입이 가능합니다.");
	}
	else
	{
		form.bDeal.value=Part;
		form.submit();
	}
}
//-->
</SCRIPT>
<? include "top.php";?>
<table width="900" border="0" cellspacing="0" cellpadding="0" bgcolor="<?=$ALL_BGCOLOR?>">
	<tr>
		<? include "left_menu.php";?>
		<td height="51" valign="top" width="720" bgcolor="#FFFFFF">
			<table width="720" border="0" cellspacing="0" cellpadding="0">
				<tr bgcolor="#FFFFFF" valign="top">
					<td colspan="2">
						<table width="720" height="35" border="0" cellspacing="0" cellpadding="0" align='center'>
							<tr>
								<td width="2"  bgcolor="<?=$subdesign[bc3]?>" rowspan="2"></td>
								<td width="2"  bgcolor="<?=$subdesign[bc3]?>" rowspan="2"></td>
								<td width="220" height="30" bgcolor="<?=$subdesign[bc3]?>"><img src="./upload/design/<?=$subdesign[img3]?>" ></td>
								<td width="490" height="30" bgcolor="<?=$subdesign[bc3]?>"><div align="right"> &nbsp;<font color="<?=$subdesign[tc3]?>"> <img src='image/good/icon0.gif'>&nbsp;현재위치 : <a href="index.php"><font color="#0f3067">HOME</font></a> &gt; 이용약관</font>&nbsp;</div></td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td valign="top" width="720" valign="top">
						<table width="720" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td><?
								if ($subdesign[titimg3])
								{
									?><img src="./upload/design/<?=$subdesign[titimg3]?>" ><?
								}
								else
								{
									?><img src="image/index/member_article_img1.gif" ><?
								}
								?></td>
							</tr>
						</table><br><br>
						<table width="650" border="0" cellspacing="0" cellpadding="0" height='600' align="center"  >
							<tr>
								<td align="center"><br>
									<table width="580" border="0" cellspacing="0" cellpadding="10" align='center' bgcolor='f6f6f6'>
										<tr>
											<td height="27" valign="bottom"><b><?=$admin_row[shopTitle]?>의 회원이 되시면 다양한 혜택이 주어집니다.<b></td>
										</tr>
										<tr>
											<td><font color="#016EBC"><?=$xProfit?></FONT></td>
										</tr>
									</table><br><br>
									<textarea  cols="85" rows="15" class="text2" readonly><?=$admin_row[xReg]?></textarea><br></td>
							</tr>
							<tr>
								<td align="center" height="50">
									<form name="agreeForm" method="get" action="member_join.php">
									<input type="hidden" name="bDeal">
									<table width="300" border="0" cellspacing="0" cellpadding="0">
										<tr align="center">
											<td colspan="2"><br><input type="checkbox" name="agreement" value="checkbox"> 위의 약관에 동의합니다.<br><br></td>
										</tr>
										<tr align="center">
											<td><a href="javascript:agreeSendit('0');"><img src="image/member/join_1.gif" border="0"></a></td>
											<td><a href="javascript:agreeSendit('1');"><img src="image/member/join_2.gif" border="0"></a></td>
										</tr>
										<tr>
											<td colspan="2" height="20"> </td>
										</tr>
										<tr align="center">
											<td height="20">&nbsp;</td>
											<td height="20">&nbsp;</td>
										</tr>
									</table>
									</form>
								</td>
							</tr>
						</table>
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