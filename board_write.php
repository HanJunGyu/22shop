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
$bbs_admin_row = $MySQL->fetch_array("select *from bbs_list where idx='$boardIndex'"); //게시판 정보
$dataArr=Decode64($data);
if($data)
{
	$bbs_qry="select *from bbs_data where idx=$dataArr[idx]";
	$bbs_row=$MySQL->fetch_array($bbs_qry);
}
$member_row = $MySQL->fetch_array("select *from member where userid='$GOOD_SHOP_USERID' limit 1");
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
	<?if($bbs_admin_row[part]==20){?>
	attach = form.up_file.value;
	dot = attach.lastIndexOf(".");
	ext = attach.substring(dot);
	<? }  if($bbs_admin_row[part]==30){?>
	attach1 = form.img1.value;
	dot1 = attach1.lastIndexOf(".");
	ext1 = attach1.substring(dot1);
	attach2 = form.img2.value;
	dot2 = attach2.lastIndexOf(".");
	ext2 = attach2.substring(dot2);
	<? } ?>
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
	else if(form.pwd.value=="")
	{
		alert("비밀번호를 입력해 주십시오.");
		form.pwd.focus();
	}
	<?if($bbs_admin_row[part]==20){?>
	else if(filehanCheck(form.up_file.value))
	{
		alert("첨부파일은 영문명으로 등록해 주십시오.");
		form.up_file.focus();
	}
	else if (ext==".php" || ext==".PHP" || ext==".php3" || ext==".htm" || ext==".html" || ext==".HTM" || ext==".HTML")
	{
		alert("PHP,HTML 파일은 보안상 업로드할수 없습니다.");
		form.up_file.focus();
	}
	<?}?>
	<?if($bbs_admin_row[part]==30){?>
	else if (ext1==".php" || ext1==".PHP" || ext1==".php3" || ext1==".htm" || ext1==".html" || ext1==".HTM" || ext1==".HTML")
	{
		alert("PHP,HTML 파일은 보안상 업로드할수 없습니다.");
		form.img1.focus();
	}
	else if (ext2==".php" || ext2==".PHP" || ext2==".php3" || ext2==".htm" || ext2==".html" || ext2==".HTM" || ext2==".HTML")
	{
		alert("PHP,HTML 파일은 보안상 업로드할수 없습니다.");
		form.img2.focus();
	}
	else if(form.img1.value=="")
	{
		alert("이미지1을 입력해 주십시오.");
		form.title.focus();
	}
	else if(form.img1.value=="")
	{
		alert("이미지2를 입력해 주십시오.");
		form.title.focus();
	}
	else if(filehanCheck(form.img1.value))
	{
		alert("첨부파일은 영문명으로 등록해 주십시오.");
		form.img1.focus();
	}
	<? } ?>
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
		<?
		$COMMUNITY_PAGE = 1;
		include "left_menu.php";
		?>
		<td height="51" valign="top" width="720" bgcolor="#FFFFFF">
			<table width="720" height="100%" border="0" cellspacing="0" cellpadding="0">
				<tr bgcolor="#FFFFFF" valign="top">
					<td colspan="2" height="30">
						<table width="720" height="35" border="0" cellspacing="0" cellpadding="0" align='center'>
							<tr>
								<td width="2"  bgcolor="<?=$subdesign[bc10]?>" rowspan="2"></td>
								<td width="2"  bgcolor="<?=$subdesign[bc10]?>" rowspan="2"></td>
								<td width="220" height="27" bgcolor="<?=$subdesign[bc10]?>"><img src="./upload/design/<?=$subdesign[img10]?>" ></td>
								<td width="490" height="27" bgcolor="<?=$subdesign[bc10]?>"><div align="right"> &nbsp;<font color="<?=$subdesign[tc10]?>"> <img src='image/good/icon0.gif'>&nbsp;현재위치 : HOME &gt; 게시판</font>&nbsp;</div></td>
							</tr>
						</table><?
						$bbs_admin_row = $MySQL->fetch_array("select *from bbs_list where idx=$boardIndex");
						$code=$bbs_admin_row[code];
						?>
					</td>
				</tr>
				<tr>
					<td valign="top" width="720">
						<table width="714" border="0" cellspacing="0" cellpadding="0">
							<tr><?
							if ($bbs_admin_row[img])
							{
								?>
								<td> <img src="upload/bbs/<?=$bbs_admin_row[img]?>"></td><?
							}
							else if ($subdesign[titimg10])
							{
								?>
								<td> <img src="./upload/design/<?=$subdesign[titimg10]?>" ></td><?
							}
							else
							{
								?>
								<td> <img src="image/index/board.gif" ></td><?
							}
							?>
							</tr>
						</table>
						<table width="650" border="0" cellspacing="1" cellpadding="0" align="center" bgcolor="#FFFFFF">
							<tr>
								<td align="center" bgcolor="#FFFFFF" valign="top">
									<table width="650" border="0" cellspacing="1" cellpadding="5" align="center">
										<tr>
											<td colspan="2" valign="top"><br>
												<form name="bbsForm" method="post" action="board_write_ok.php" enctype="multipart/form-data">
												<input type="hidden" name="boardIndex" value="<?=$boardIndex?>"><!-- 게시판 코드 -->
												<input type="hidden" name="ref" value="<?=$bbs_row[ref]?>"><!-- 답변형게시판 변수 -->
												<input type="hidden" name="re_step" value="<?=$bbs_row[re_step]?>"><!-- 답변형게시판 변수 -->
												<input type="hidden" name="re_level" value="<?=$bbs_row[re_level]?>"><!-- 답변형게시판 변수 -->
												<input type="hidden" name="data" value="<?=$data?>"><!-- 답변형게시판 현재글 정보 -->
												<table width="650" border="0" cellspacing="0" cellpadding="0" align="center">
													<tr>
														<td>
															<table width="650" border="0" cellspacing="0" cellpadding="0">
																<tr>
																	<td height='25'><img src='image/board/icon_tit.gif' align='absmiddle'> <b><?=$bbs_admin_row[name]?></b></td>
																</tr>
																<tr>
																	<td height="2" bgcolor="#1a0050"></td>
																</tr>
																<tr>
																	<td height="30" bgcolor="F4F4F4" style='padding:0 0 0 5;'><img src="image/board/tit_text.gif"></td>
																</tr>
															</table>
														</td>
													</tr>
													<tr>
														<td valign="top" height="1" colspan="9" bgcolor="#dddddd"></td>
													</tr>
													<tr>
														<td valign="top">
															<table width="650" border="0" cellspacing="0" cellpadding="0" align="center">
																<tr>
																	<td width="80" style='padding:5 5 5 30;'><FONT COLOR="#009BD4">이름</FONT></td>
																	<td width='1'><img src="image/board/line.gif"></td>
																	<td height="20" style='padding:5 5 5 5;'> <input class="box_s" type="text" name="name" size="12" value="<?=$member_row[name]?>"></td>
																</tr>
																<tr>
																	<td width="80" style='padding:5 5 5 30;'><FONT COLOR="#009BD4">이메일</FONT></td>
																	<td width='1'><img src="image/board/line.gif"></td>
																	<td height="20" style='padding:5 5 5 5;'> <input class="box_s" type="text" name="email" size="40" value="<?=$member_row[email]?>"></td>
																</tr>
																<tr>
																	<td width="80" style='padding:5 5 5 30;'><FONT COLOR="#009BD4">제 목</FONT></td>
																	<td width='1'><img src="image/board/line.gif"></td>
																	<td height="20" style='padding:5 5 5 5;'> <?
																	if ($bbs_row[title])
																	{
																		?><input class="box_s" type="text" name="title" size="50" value="[RE] <?=$bbs_row[title]?>"><?
																	}
																	else
																	{
																		?><input class="box_s" type="text" name="title" size="50"><?
																	}
																	?></td>
																</tr><?
																	if($bbs_admin_row[part]==30)
																	{
																		?>
																<tr>
																	<td width="80" style='padding:5 5 5 30;'><FONT COLOR="#009BD4">이미지 1</FONT></td>
																	<td width='1'><img src="image/board/line.gif"></td>
																	<td height="20" style='padding:5 5 5 5;'> <input class="box_s" type="file" name="img1"> <FONT class='sm'>갤러리 목록에 보여지는 이미지(최적크기 100X80)</FONT> </td>
																</tr>
																<tr>
																	<td width="80" style='padding:5 5 5 30;'><FONT COLOR="#009BD4">이미지 2</FONT></td>
																	<td width='1'><img src="image/board/line.gif"></td>
																	<td height="20" style='padding:5 5 5 5;'> <input class="box_s" type="file" name="img2"> <FONT class='sm'>작은 이미지를 클릭했을때 실제 보여지는 이미지</FONT></td>
																</tr><?
																	}
																	if($bbs_admin_row[part]==20)
																	{
																		?>
																<tr>
																	<td width="80" style='padding:5 5 5 30;'><FONT COLOR="#009BD4">파일첨부</FONT></td>
																	<td width='1'><img src="image/board/line.gif"></td>
																	<td height="20" style='padding:5 5 5 5;'> <input class="box_s" type="file" name="up_file"><br><font color="#999999">※ PHP,스크립트 파일은 업로드할수 없습니다.</font></td>
																</tr><?
																	}
																	?>
																<tr>
																	<td width="80" height="20" style='padding:5 5 5 30;'><FONT COLOR="#009BD4">비밀번호</FONT></td>
																	<td width='1'><img src="image/board/line.gif"></td>
																	<td height="20" style='padding:5 5 5 5;'> <input class="box_s" type="password" name="pwd" size="15"> <font class='sm'>&lt;수정,삭제시 필요&gt;</font> <input type="checkbox" name="bLock" value="y"> <font class='mem'>게시물 잠금 (본인과 관리자만 열람가능)</font></td>
																</tr>
																<tr>
																	<td width="80" height="20" style='padding:5 5 5 30;'><FONT COLOR="#009BD4">내용입력 형식</FONT></td>
																	<td width='1'><img src="image/board/line.gif"></td>
																	<td height="20" style='padding:5 5 5 5;'> <INPUT TYPE="radio" NAME="bHtml" value='1' onclick="document.getElementById('nsText').style.display='block';document.getElementById('nsHtml').style.display='none';document.getElementById('nsEdit').style.display='none';">TEXT &nbsp; <INPUT TYPE="radio" NAME="bHtml" value='2' <?=$Os_Check?"":"checked"?> onclick="document.getElementById('nsText').style.display='none';document.getElementById('nsHtml').style.display='block';document.getElementById('nsEdit').style.display='none';">HTML &nbsp; <INPUT TYPE="radio" NAME="bHtml" value='0' <?=$Os_Check?"checked":""?> onclick="document.getElementById('nsText').style.display='none';document.getElementById('nsHtml').style.display='none';document.getElementById('nsEdit').style.display='block';" <?= $Use_Check?>>웹에디터</td>
																</tr>
																<tr>
																	<td colspan="3" height="1" bgcolor='dddddd'></td>
																</tr>
																<tr>
																	<td colspan="3" height="10" align="center"><br>
																		<table width="600" cellpadding="0" cellspacing="0" border="0" id='nsText' style='display:none'>
																			<tr>
																				<td><textarea name="TextContent" style="width:100%" rows="15" cols="80"><? if ($bbs_row[content]) echo "\n\n"."---------------------------------------- \n\n".htmlspecialchars(stripslashes($bbs_row[content]));?></textarea></td>
																			</tr>
																		</table>
																		<table width="600" cellpadding="0" cellspacing="0" border="0" id='nsHtml' style='display:<?=$Os_Check?"none":"block"?>'>
																			<tr>
																				<td><textarea name="HtmlContent" style="width:100%" rows="15" cols="80"><? if ($bbs_row[content]) echo "\n\n"."---------------------------------------- <br>".htmlspecialchars(stripslashes($bbs_row[content]));?></textarea></td>
																			</tr>
																		</table>
																		<table width="600" cellpadding="0" cellspacing="0" border="0" id='nsEdit' style='display:<?=$Os_Check?"block":"none"?>'>
																			<tr>
																				<td width='600'><?
																				$form_name = "bbsForm";
																				$dir_path = ".";
																				include "./editor.php";
																				if ($bbs_row[content])
																				{
																					?><textarea style="display:none" class="text" name="content"  cols="90" rows="13"><? echo "\n\n"."---------------------------------------- <br>".htmlspecialchars(stripslashes($bbs_row[content]));?></textarea><?
																				}
																				else
																				{
																					?><textarea style="display:none" class="text" name="content"  cols="90" rows="13"></textarea><?
																				}
																				?></td>
																			</tr>
																		</table>
																	</td>
																</tr>
																<tr>
																	<td colspan="3" height="2" bgcolor='dddddd'></td>
																</tr>
																<tr>
																	<td colspan="3" height="10"></td>
																</tr>
															</table>
															<table width="150" border="0" cellspacing="0" cellpadding="0" align="center">
																<tr align="center">
																	<td><a href="javascript:bbsSendit();"><img src="image/board/btn_save.gif" border="0"></a></td>
																	<td><a href="board_list.php?boardIndex=<?=$boardIndex?>&data=<?=$data?>"><img src="image/board/btn_list.gif" border="0"></a></td>
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
<? include "copy.php";?>
</div>
</body>
</html>