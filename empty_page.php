<?
include "head.php";
?>
<? include "top.php";?>
<table width="900" border="0" cellspacing="1" cellpadding="0" bgcolor="<?=$ALL_BGCOLOR?>">
	<tr>
		<? include "left_menu.php";?>
		<td  valign="top" width="720" bgcolor="#FFFFFF">
			<table width="720" height="100%" border="0" cellspacing="0" cellpadding="0">
				<tr bgcolor="#FFFFFF" valign="top">
					<td colspan="2" >
						<table width="720"   border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td width="2"  bgcolor="<?=$subdesign[bc11]?>" rowspan="2"></td>
								<td width="2"  bgcolor="<?=$subdesign[bc11]?>" rowspan="2"></td>
								<td width="220" height="30" bgcolor="<?=$subdesign[bc11]?>"><img src="./upload/design/<?=$subdesign[img11]?>" ></td>
								<td width="490" height="30" bgcolor="<?=$subdesign[bc11]?>"><div align="right"> &nbsp;<font color="<?=$subdesign[tc11]?>"> &nbsp;현재위치 : <a href="index.php"><font color="<?=$subdesign[tc11]?>">HOME</a> &gt; 공지사항</font>&nbsp;</div></td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td valign="top" width="720">
						<table width="720" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td> <img src="image/icon/company_img.gif" width="714" height="101"></td>
							</tr>
						</table>
						<table width="714" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td>원하는 내용을 작성하세요</td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>
<? include "copy.php"; ?>
</body>
</html>