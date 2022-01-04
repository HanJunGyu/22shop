<?
include "head.php";
$getArrayOS = explode(";", $_SERVER[HTTP_USER_AGENT]);
$BROWGER = trim($getArrayOS[1]);
$OS = trim($getArrayOS[2]);
if(preg_match("/Windows/", $OS) && preg_match("/MSIE/", $BROWGER))
{
	$Os_Check=1;
	$Use_Check="";
}
else
{
	$Os_Check=0;
	$Use_Check="disabled";
}
$dataArr=Decode64($data);
if($data)
{
	$bbs_qry="select *from bbs_data where idx=$dataArr[idx]";
	$bbs_row=$MySQL->fetch_array($bbs_qry);
}
?>
<SCRIPT LANGUAGE="JavaScript">
<!--
function bbsSendit()
{
	var form=document.bbsForm;
	if(form.bHtml[2].checked==true)
	{
		<?
		if(!$Os_Check)
		{
			?>
		alert('웹에디터를 지원하지 않습니다.');<?
		}
		?>
		cdiv.gogo();
	}
	if(form.name.value=="")
	{
		alert("이름을 입력해 주십시오.");
		form.name.focus();
	}
	else if(form.title.value=="")
	{
		alert("제목을 입력해 주십시오.");
		form.title.focus();
	}
	else if(hanCheck(form.up_file.value))
	{
		alert("첨부파일은 영문명으로 등록해 주십시오.");
		form.up_file.focus();
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
			<table width="720" height="100%" border="0" cellspacing="0" cellpadding="0">
				<tr bgcolor="#FFFFFF" valign="top">
					<td colspan="2" height="51">
						<table width="720" height="35" border="0" cellspacing="0" cellpadding="0" align='center'>
							<tr>
								<td width="2"  bgcolor="<?=$subdesign[bc9]?>" rowspan="2"></td>
								<td width="2"  bgcolor="<?=$subdesign[bc9]?>" rowspan="2"></td>
								<td width="220" height="27" bgcolor="<?=$subdesign[bc9]?>"><img src="./upload/design/<?=$subdesign[img9]?>" ></td>
								<td width="490" height="27" bgcolor="<?=$subdesign[bc9]?>"><div align="right"> &nbsp;<font color="<?=$subdesign[tc9]?>"> &nbsp; 현재위치 : HOME &gt; 1:1문의</font>&nbsp;</div></td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td valign="top" width="720">
						<table width="714" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td><?
								if ($subdesign[titimg9])
								{
									?><img src="./upload/design/<?=$subdesign[titimg9]?>" ><?
								}
								else
								{
									?><img src="image/sub/ask.gif" ><?
								}
								?></td>
							</tr>
						</table>
						<table width="670" border="0" cellspacing="1" cellpadding="0" align="center" bgcolor="#ffffff">
							<tr>
								<td align="center" bgcolor="#FFFFFF" valign="top">
									<table width="670" border="0" cellspacing="1" cellpadding="5" align="center">
										<tr>
											<td colspan="2" valign="top"><br>
												<form name="bbsForm" method="post" action="ask_edit_ok.php" enctype="multipart/form-data" >
												<input type="hidden" name="data" value="<?=$data?>"><!-- 현재글 정보 -->
												<table width="670" border="0" cellspacing="0" cellpadding="0" align="center">
													<tr>
														<td>
															<table width="670" border="0" cellspacing="0" cellpadding="0">
																<tr>
																	<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b><?=$bbs_admin_row[name]?></b></td>
																</tr>
																<tr>
																	<td height="1" colspan="5" bgcolor="BDBDBD"></td>
																</tr>
																<tr>
																	<td height="30" bgcolor="F4F4F4"><img src="image/board/tit_text2.gif"></td>
																</tr>
																<tr>
																	<td valign="top" height="2" colspan="5"></td>
																</tr>
															</table>
														</td>
													</tr>
													<tr>
														<td valign="top" height="1" colspan="9" bgcolor="BDBDBD"></td>
													</tr>
													<tr>
														<td height="277" valign="top">
															<table width="670" border="0" cellspacing="0" cellpadding="0" align="center">
																<tr>
																	<td width="108" height="30"><font color="#009BD4">이름</font></td>
																	<td width='1'><img src="image/board/line.gif"></td>
																	<td width="422" height="30"> <input class="box_s" type="text" name="name" size="12" value="<?=$bbs_row[name]?>"></td>
																</tr>
																<tr>
																	<td colspan="3" height="1" bgcolor='dddddd'></td>
																</tr>
																<tr>
																	<td width="108" height="30"><font color="#009BD4">이메일</font></td>
																	<td width='1'><img src="image/board/line.gif"></td>
																	<td width="422" height="30"> <input class="box_s" type="text" name="email" size="20" value="<?=$bbs_row[email]?>"></td>
																</tr>
																<tr>
																	<td colspan="3" height="1" bgcolor='dddddd'></td>
																</tr>
																<tr>
																	<td width="108" height="30"><font color="#009BD4">제 목</font></td>
																	<td width='1'><img src="image/board/line.gif"></td>
																	<td width="422" height="30"> <input class="box_s" type="text" name="title" size="50" value="<?=$bbs_row[title]?>"></td>
																</tr>
																<tr>
																	<td colspan="3" height="1" bgcolor='dddddd'></td>
																</tr>
																<tr>
																	<td width="108" height="30"><font color="#009BD4">파일첨부</font></td>
																	<td width='1'><img src="image/board/line.gif"></td>
																	<td width="422" height="30"> <input class="box_s" type="file" name="up_file"></td>
																</tr>
																<tr>
																	<td colspan="3" height="1" bgcolor='dddddd'></td>
																</tr><?
																$bHtml_chk[$bbs_row[bHtml]]="checked";
																?>
																<tr>
																	<td width="108" height="30"><font color="#009BD4">내용입력 형식</font></td>
																	<td width='1'><img src="image/board/line.gif"></td>
																	<td width="422" height="30"> <INPUT TYPE="radio" NAME="bHtml" value='1' onclick="document.getElementById('nsText').style.display='block';document.getElementById('nsHtml').style.display='none';document.getElementById('nsEdit').style.display='none';" <?= $bHtml_chk[1]?>>TEXT &nbsp; <INPUT TYPE="radio" NAME="bHtml" value='2' onclick="document.getElementById('nsText').style.display='none';document.getElementById('nsHtml').style.display='block';document.getElementById('nsEdit').style.display='none';" <?= $bHtml_chk[2]?>>HTML &nbsp; <INPUT TYPE="radio" NAME="bHtml" value='0' onclick="document.getElementById('nsText').style.display='none';document.getElementById('nsHtml').style.display='none';document.getElementById('nsEdit').style.display='block';" <?= $Use_Check?> <?= $bHtml_chk[0]?>>웹에디터</td>
																</tr>
																<tr>
																	<td colspan="3" height="1" bgcolor='dddddd'></td>
																</tr>
																<tr>
																	<td colspan="3" height="10" align="center"><br>
																		<table width="600" cellpadding="0" cellspacing="0" border="0" id='nsText' style='display:<?=$bbs_row[bHtml]==1?"block":"none"?>'>
																			<tr>
																				<td><textarea name="TextContent" style="width:100%" rows="15" cols="80"><?=htmlspecialchars($bbs_row[content])?></textarea></td>
																			</tr>
																		</table>
																		<table width="600" cellpadding="0" cellspacing="0" border="0" id='nsHtml' style='display:<?=$bbs_row[bHtml]==2?"block":"none"?>'>
																			<tr>
																				<td><textarea name="HtmlContent" style="width:100%" rows="15" cols="80"><?=htmlspecialchars($bbs_row[content])?></textarea></td>
																			</tr>
																		</table>
																		<table width="600" cellpadding="0" cellspacing="0" border="0" id='nsEdit' style='display:<?=!$bbs_row[bHtml]?"block":"none"?>'>
																			<tr>
																				<td width='600'><?
																				$form_name = "bbsForm";
																				$dir_path = ".";
																				include "./editor.php";
																				?><textarea style="display:none" class="text" name="content" cols="90" rows="10"><?=htmlspecialchars($bbs_row[content])?></textarea></td>
																			</tr>
																		</table>
																	</td>
																</tr>
																<tr>
																	<td colspan="3" height="10"></td>
																</tr>
																<tr>
																	<td colspan="3" height="1" bgcolor='dddddd'></td>
																</tr>
															</table><br><br>
															<table width="292" border="0" cellspacing="0" cellpadding="0" align="center">
																<tr align="center">
																	<td><a href="javascript:bbsSendit();"><img src="image/board/btn_save.gif" border="0"></a></td>
																	<td><a href="javascript:formClear(document.bbsForm);"><img src="image/board/btn_cancel.gif" border="0"></a></td>
																	<td><a href="ask_list.php?data=<?=$data?>"><img src="image/board/btn_list.gif" border="0"></a></td>
																</tr>
															</table><br>
														</td>
													</tr>
													<tr>
														<td height="75">&nbsp; </td>
													</tr>
												</table></form><!-- bbsForm -->
											</td>
										</tr>
									</table><br>
								</td>
							</tr>
						</table><br>
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
