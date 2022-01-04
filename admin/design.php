<?
include "head.php";
?>
<SCRIPT LANGUAGE="JavaScript">
<!--
//전송
function designSendit()
{
	document.alignForm.submit();
}
//-->
</SCRIPT>
<body bgcolor="#FFFFFF" text="#5A595A" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<? include "top_menu.php"; ?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr><?
	$__TOP_MENU = "design";     //왼쪽 소메뉴 설정 변수
	include "left_menu.php";
	?>
		<td width="85%" valign="top">
			<table width="100%" border="0" cellspacing="0" cellpadding="0" align='center'>
				<tr>
					<td height='5'></td>
				</tr>
				<tr>
					<td>
						<table width="750" border="0" cellspacing="0" cellpadding="0" align='center'>
							<tr>
								<td rowspan="3" width="200"><img src="image/design_tit_img.gif"></td>
								<td>&nbsp;</td>
							</tr>
							<tr>
								<td bgcolor="#E6E6E6" height='26'><div align='right'><font class='text1'>SHOP 디자인을 변경하실수 있습니다.&nbsp;</div></td>
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
								<td width='1' bgcolor='dadada'></td>
							</tr>
							<tr>
								<td><img src="image/design_tit.gif"></td>
							</tr>
							<tr>
								<td width='1' bgcolor='dadada'></td>
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
							<? include "main_design_menu.php";?>
							<tr>
								<td colspan="2">&nbsp;</td>
							</tr>
							<tr>
								<td colspan="2" height="25" valign="top"><img src="image/design_main_icon.gif" width="21" height="11">화면 구성 (아래 그림에 해당하는 위치를 클릭해도 바로 이동합니다.)</td>
							</tr>
							<tr>
								<td colspan="2"><?
								$main=1;
								include "design_view.php";
								?></td>
							</tr>
							<tr>
								<td colspan="2" height="20"> </td>
							</tr>
							<tr>
								<td colspan="2" valign="top" height="25"><br><img src="image/design_main_icon.gif" width="21" height="11">페이지 정렬 방식 (※ 좌측정렬시 좌측 레이어베너, 우측정렬시 우측 레이어베너는 사용할수 없습니다.)</td>
							</tr>
							<form name="alignForm" method="post" action="design_ok.php?act=design" enctype="multipart/form-data">
							<tr>
								<td colspan="2"><br>
									<table width="100%" border="0" cellspacing="0" cellpadding="0" align='center'>
										<tr>
											<td>&nbsp;</td>
											<td width="100"><img src="image/design_left.gif" width="100" height="80"></td>
											<td>&nbsp;</td>
											<td width="100"><img src="image/design_center.gif" width="100" height="80"></td>
											<td>&nbsp;</td>
											<td width="100"><img src="image/design_right.gif" width="100" height="80"></td>
											<td>&nbsp;</td>
										</tr>
										<tr>
											<td height="40">&nbsp;</td>
											<td width="100" height="40"> <div align="center"> <input type="radio" name="mainAlign" value="left" <?if($design[mainAlign]=="left") echo"checked";?>>왼쪽정렬</div></td>
											<td height="40">&nbsp;</td>
											<td width="100" height="40"> <div align="center"> <input type="radio" name="mainAlign" value="center" <?if($design[mainAlign]=="center") echo"checked";?>>가운데정렬</div></td>
											<td height="40">&nbsp;</td>
											<td width="100" height="40"> <div align="center"> <input type="radio" name="mainAlign" value="right" <?if($design[mainAlign]=="right") echo"checked";?>>오른쪽정렬</div></td>
											<td height="40">&nbsp;</td>
										</tr>
									</table>
								</td>
							</tr><?
							$now = date("Y-m-d",time());
							$now = explode("-",$now);
							if (empty($design[startday]) && empty($design[endday]))
							{
								$year = $now[0];
								$month = $now[1];
								$day = $now[2];
								$year2 = $now[0];
								$month2 = $now[1];
								$day2 = $now[2];
							}
							else
							{
								$startday = explode("-",$design[startday]);
								$endday = explode("-",$design[endday]);
								$year = $startday[0];
								$month = $startday[1];
								$day = $startday[2];
								$year2 = $endday[0];
								$month2 = $endday[1];
								$day2 = $endday[2];
							}
							?>
							<tr>
								<td colspan="2" valign="top" height="25"><br><img src="image/design_main_icon.gif" width="21" height="11">공사중 페이지 설정<? if (__DEMOPAGE){ ?>&nbsp;&nbsp;&nbsp;※ 데모페이지 사용기능 제한 <? }else { ?>&nbsp;&nbsp;&nbsp;<input type="checkbox" name="bUnder" value="1" <? if ($design[bUnder]) echo "checked";?>>설정함<? } ?></td>
							</tr>
							<tr>
								<td colspan="2"><br>
									<table width="70%" border="0" cellspacing="0" cellpadding="0" align='center'>
										<tr>
											<td>시작일 : <input type="text" name="year" class="box" size="4" value="<?=$year?>"> 년 <input type="text" name="month" class="box" size="2" value="<?=$month?>"> 월 <input type="text" name="day" class="box" size="2" value="<?=$day?>"> 일 ~ 종료일 : <input type="text" name="year2" class="box" size="4" value="<?=$year2?>"> 년 <input type="text" name="month2" class="box" size="2" value="<?=$month2?>"> 월 <input type="text" name="day2" class="box" size="2" value="<?=$day2 ?>"> 일</td>
										</tr>
										<tr>
											<td>공사중 이미지 삽입 <input class="box" type="file" name="underImg"></td>
										</tr>
									</table>
								</td>
							</tr>
							<tr>
								<td colspan="2" valign="top" height="25"><br><img src="image/design_main_icon.gif" width="21" height="11">스타일시트 </td>
							</tr>
							<tr>
								<td colspan="2"><br>
									<table width="100%" border="0" cellspacing="0" cellpadding="0" align='center'>
										<tr>
											<td><div align='center'><textarea name="css" cols="100" rows="20" class="box" <? if (__DEMOPAGE) echo "readonly";?>><?=$design[css]?></textarea></div></td>
										</tr>
									</table>
								</td>
							</tr>
							<tr>
								<td colspan="2" height="80"><div align="center">
									<table width="100%" border="0" cellspacing="0" cellpadding="0">
										<tr>
											<td align="center"><a href="javascript:designSendit();"><img src="image/design_save.gif" width="140" height="50" border="0"></a></td>
										</tr>
									</table></div>
								</td>
							</tr>
							</form>
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