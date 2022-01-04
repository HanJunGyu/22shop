<?
include "head.php";
if($admin_row[xUse_bhtml])
{
	$xUse = $admin_row[xUse];
}
else
{
	$xUse = nl2br(htmlspecialchars($admin_row[xUse]));
}
?>
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
								<td width="2"  bgcolor="<?=$subdesign[bc12]?>" rowspan="2"></td>
								<td width="2"  bgcolor="<?=$subdesign[bc12]?>" rowspan="2"></td>
								<td width="220" height="30" bgcolor="<?=$subdesign[bc12]?>"><img src="./upload/design/<?=$subdesign[img12]?>" ></td>
								<td width="490" height="30" bgcolor="<?=$subdesign[bc12]?>"><div align="right"> &nbsp;<font color="<?=$subdesign[tc12]?>"> <img src='image/good/icon0.gif'>&nbsp; 현재위치 : <a href="index.php"><font color="<?=$subdesign[tc12]?>">HOME</font></a> &gt; 이용안내</font>&nbsp;</div></td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td valign="top" width="720">
						<table width="714" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td><?
								if ($subdesign[titimg12])
								{
									?><img src="./upload/design/<?=$subdesign[titimg12]?>" ><?
								}
								else
								{
									?><img src="image/index/use_guide_img1.gif" ><?
								}
								?></td>
							</tr>
						</table><br><br>
						<table width="650" border="0" cellspacing="1" cellpadding="0" bgcolor="#ffffff" align="center">
							<tr>
								<td height="27"><img src="image/work/u1.gif" ></td>
							</tr>
							<tr>
								<td valign="top"><br><?=$xUse?></td>
							</tr>
						</table><br><br><br><br><br>
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