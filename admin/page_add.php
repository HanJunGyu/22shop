<?
include "head.php";
?>
<SCRIPT LANGUAGE="JavaScript">
<!--
function pageDel(pageIdx)
{
	var choose = confirm("페이지의 내용이 삭제됩니다.\n\n삭제 하시겠습니까?");
	if(choose)
	{
		location.href="page_add_edit_ok.php?del=1&pageIdx="+pageIdx;
	}
	else return;
}
//-->
</SCRIPT>
<body bgcolor="#FFFFFF" text="#5A595A" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<? include "top_menu.php"; ?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr><?
	$__TOP_MENU = "page";     //왼쪽 소메뉴 설정 변수
	include "left_menu.php";
	?>
		<td width="85%" valign="top" height='400'>
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td height='5'></td>
				</tr>
				<tr>
					<td>
						<table width="750" border="0" cellspacing="0" cellpadding="0" align='center'>
							<tr>
								<td rowspan="3" width="200"><img src="image/page_img.gif"></td>
								<td>&nbsp;</td>
							</tr>
							<tr>
								<td bgcolor="#E6E6E6" height='26'><div align='right'><font class='text1'>SHOP 새로운 페이지를 생성하실수 있습니다.&nbsp;</div></td>
							</tr>
							<tr>
								<td>&nbsp;</td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td>
						<table width="750" border="0" cellspacing="0" cellpadding="0" align="center">
							<tr>
								<td width='1' bgcolor='dadada' colspan='3'></td>
							</tr>
							<tr>
								<td width='440'><img src="image/page_tit.gif"></td>
							</tr>
							<tr>
								<td width='1' bgcolor='dadada' colspan='3'></td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td height='10'></td>
				</tr>
				<tr>
					<td valign="top">
						<table width="750" border="0" cellspacing="0" cellpadding="0" align="center">
							<tr>
								<td colspan="2" height="30" valign="top"> <div valign="middle"><B>- 쇼핑몰내에 없는 새로운 페이지를 만들고자 할때 이 기능을 사용합니다.</B></div></td>
							</tr>
							<tr>
								<td colspan="2" height="30" valign="top"> <div valign="middle"><B>- 페이지코드 : 간단히 식별할수 있는 정도의 영문자</B></div></td>
							</tr>
							<tr>
								<td colspan="2" height="30" valign="top"> <div valign="middle"><B>- 등록후 해당페이지 링크방법 : ./new_page.php?code=<FONT  COLOR="#CC0000">페이지코드</FONT></B></div></td>
							</tr>
							<tr>
								<td colspan="2" height="30" valign="top"> <div valign="middle"><B>- 예) : http://고객님의 도메인/new_page.php?code=<FONT  COLOR="#CC0000">event</FONT></B></div></td>
							</tr>
							<tr>
								<td valign="top" height="25">
									<table width="750" border="0" cellspacing="1" cellpadding="0" align="center" bgcolor='cdcdcd'>
										<tr>
											<td width="50" height="30" valign="middle" bgcolor="#EBEBEB"> <div align="center"><img src="image/icon.gif" width="11" height="11"> 번호</div></td>
											<td width="200" valign="middle" bgcolor="#EBEBEB"> <div align="center"><img src="image/icon.gif" width="11" height="11"> 페이지 코드</div></td>
											<td width="200" height="30" valign="middle" bgcolor="#EBEBEB"> <div align="center"><img src="image/icon.gif" width="11" height="11"> 페이지 제목</div></td>
											<td height="30" valign="middle" width="100" bgcolor="#EBEBEB"> <div align="center"><img src="image/icon.gif" width="11" height="11"> 수정/삭제</div></td>
										</tr><?
										$qry = "select *from page order by idx asc";
										$result = $MySQL->query($qry);
										$cnt=0;
										while($row = mysql_fetch_array($result))
										{
											$cnt++;
											?>
										<tr>
											<td width="50" height="30" valign="middle" bgcolor="ffffff"> <div align="center"><?=$cnt?></div></td>
											<td width="200" height="30" valign="middle" bgcolor="ffffff"> <div align="center"><B><FONT COLOR="#CC0000"><?=$row[code]?></FONT></B></div></td>
											<td width="200" height="30" valign="middle" bgcolor="ffffff"> <div align="center"><?=$row[title]?></div></td>
											<td height="30" valign="middle" width="100" bgcolor="ffffff"> <div align="center"><a href="page_add_edit.php?pageIdx=<?=$row[idx]?>"><img src="image/page_01.gif" width="35" height="23" border="0"></a><a href="javascript:pageDel('<?=$row[idx]?>');"><img src="image/page_02.gif" width="35" height="23" border="0"></a></div></td>
										</tr><?
										}
										?>
									</table>
								</td>
							</tr>
							<tr>
								<td height="50"><div align="center"><a href="page_add_write.php"><img src="image/page_btn.gif" width="62" height="33" border="0"></a></div></td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>
<? include "copy.php";?>
</body>
</html>