<?
include "head.php";
?>
<SCRIPT LANGUAGE="JavaScript">
<!--
function detailSearchSendit()
{
	var form=document.detailSearchForm;
	if(!numCheck(form.price.value))
	{
		alert("가격설정이 올바르지 않습니다.");
		form.price.focus();
	}
	else
	{
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
								<td width="2"  bgcolor="<?=$subdesign[bc15]?>" rowspan="2"></td>
								<td width="2"  bgcolor="<?=$subdesign[bc15]?>" rowspan="2"></td>
								<td width="220" height="30" bgcolor="<?=$subdesign[bc15]?>"><img src="./upload/design/<?=$subdesign[img15]?>" ></td>
								<td width="490" height="30" bgcolor="<?=$subdesign[bc15]?>"><div align="right"> &nbsp;<font color="<?=$subdesign[tc15]?>"> <img src='image/good/icon0.gif'>&nbsp;현재위치 : HOME &gt; 상세검색</font>&nbsp;</div></td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td valign='top'><img src='image/work/search.gif'></td>
				</tr>
				<tr>
					<td valign="top" width="720" ><br><br>
						<table width="650" border="0" cellspacing="0" cellpadding="0" align="center" height='300' background='image/index/search_bg.gif'>
							<tr>
								<td>
									<form name="detailSearchForm" method="get" action="search_result.php?detail=1">
									<input type="hidden" name="detail" value="1">
									<table width="500" border="0" cellspacing="0" cellpadding="0" align="center">
										<tr>
											<td height="1" colspan="2" bgcolor="DADADA"></td>
										</tr>
										<tr>
											<td height="30" colspan="2" bgcolor="#f4f4f4"><b> &nbsp;&nbsp;◎ 상세검색</b></td>
										</tr>
										<tr>
											<td height="1" colspan="2" bgcolor="DADADA"></td>
										</tr>
										<tr>
											<td height="5" colspan="2"></td>
										</tr>
										<tr>
											<td height="30" width="104" bgcolor="#fafafa"> &nbsp;&nbsp;&nbsp;· 대분류</td>
											<td height="30" width="496"> &nbsp;&nbsp;<select name="category"><option value="0">:::대분류 선택:::</option><?
											$max_result = $MySQL->query("select *from category where bHide<>'1' order by position asc");
											while($max_row = mysql_fetch_array($max_result))
											{
												?><option value="<?=$max_row[code]?>">▶<?=$max_row[name]?></option><?
											}
											?></select></td>
										</tr>
										<tr>
											<td height="1" colspan="2" background="image/index/dot_width.gif"></td>
										</tr>
										<tr>
											<td height="30" width="104" bgcolor="#fafafa">&nbsp;&nbsp;&nbsp;· 상품명</td>
											<td height="30" width="496"> &nbsp;&nbsp;<input class="box" type="text" name="name" size="15"></td>
										</tr>
										<tr>
											<td height="1" colspan="2" background="image/index/dot_width.gif"></td>
										</tr>
										<tr>
											<td height="30" width="104" bgcolor="#fafafa">&nbsp;&nbsp;&nbsp;· 제조사</td>
											<td height="30" width="496"> &nbsp;&nbsp;<input class="box" type="text" name="company" size="15"></td>
										</tr>
										<tr>
											<td height="1" colspan="2" background="image/index/dot_width.gif"></td>
										</tr>
										<tr>
											<td height="30" width="104" bgcolor="#fafafa">&nbsp;&nbsp;&nbsp;· 모델명</td>
											<td height="30" width="496"> &nbsp;&nbsp;<input class="box" type="text" name="model" size="15"></td>
										</tr>
										<tr>
											<td height="1" colspan="2" background="image/index/dot_width.gif"></td>
										</tr>
										<tr>
											<td height="30" width="104" bgcolor="#fafafa">&nbsp;&nbsp;&nbsp;· 가격대</td>
											<td height="30" width="496"> &nbsp;&nbsp;<input class="box" type="text" name="price" size="10" <?=__ONLY_NUM?>> 원대</td>
										</tr>
										<tr>
											<td height="1" colspan="2" background="image/index/dot_width.gif"></td>
										</tr>
										<tr>
											<td colspan="2" height="40">
												<table width="187" border="0" cellspacing="0" cellpadding="0" align="center">
													<tr align="center">
														<td width="70"><a href="javascript:detailSearchSendit();"><img src="image/icon/search_2.gif" width="54" height="19" border="0"></a></td>
														<td width="70"><a href="javascript:formClear(document.detailSearchForm);"><img src="image/icon/cancel_btn.gif" width="54" height="19" border="0"></a></td>
													</tr>
												</table>
											</td>
										</tr>
									</table>
									</form><!-- detailSearchForm -->
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