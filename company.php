<?
include "head.php";
if($admin_row[xCom_bhtml])
{
	$xCom = $admin_row[xCom];
}
else
{
	$xCom = nl2br(htmlspecialchars($admin_row[xCom]));
}
include "top.php";
?>
<table width="900" border="0" cellspacing="0" cellpadding="0" bgcolor="<?=$ALL_BGCOLOR?>">
	<tr>
		<? include "left_menu.php";?>
		<td height="51" valign="top" width="720" bgcolor="#FFFFFF">
			<table width="720"  border="0" cellspacing="0" cellpadding="0">
				<tr bgcolor="#FFFFFF" valign="top">
					<td colspan="2">
						<table width="720" height="35" border="0" cellspacing="0" cellpadding="0" align='center'>
							<tr>
								<td width="2"  bgcolor="<?=$subdesign[bc11]?>" rowspan="2"></td>
								<td width="2"  bgcolor="<?=$subdesign[bc11]?>" rowspan="2"></td>
								<td width="220" height="30" bgcolor="<?=$subdesign[bc11]?>"><img src="./upload/design/<?=$subdesign[img11]?>" ></td>
								<td width="490" height="30" bgcolor="<?=$subdesign[bc11]?>"><div align="right"> &nbsp;<font color="<?=$subdesign[tc11]?>"> <img src='image/good/icon0.gif'>&nbsp;현재위치 : <a href="index.php"><font color="<?=$subdesign[tc11]?>">HOME</font></a> &gt; 회사소개</font>&nbsp;</div></td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td valign="top" width="712">
						<table width="714" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td><?
								if ($subdesign[titimg11])
								{
									?><img src="./upload/design/<?=$subdesign[titimg11]?>" ><?
								}
								else
								{
									?><img src="image/work/company_img.gif" ><?
								}
								?></td>
							</tr>
						</table>
						<br><br>
						<table width="650" border="0" cellspacing="1" cellpadding="0" bgcolor="#ffffff" align="center">
							<tr>
								<td height="27"><img src="image/work/ctit1.gif"></td>
							</tr>
							<tr>
								<td valign="top"><br><?=$xCom?></td>
							</tr>
						</table>
						<br><br><?
						if($admin_row[useShopmap])
						{
							?>
						<table width="650" border="0" cellspacing="1" cellpadding="0" bgcolor="#ffffff" align="center">
							<tr>
								<td height="27"><img src="image/work/ctit2.gif"></td>
							</tr>
							<tr>
								<td align="center"><img src="upload/shop_map_img"> </td>
							</tr>
						</table>
						<br><br><?
						}
						?><br>
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>
<? include "copy.php";?>
</div>
</body>
</html>