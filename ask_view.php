<?
include "head.php";
?>
<SCRIPT LANGUAGE="JavaScript">
<!--
//err message
function comLoginErr()
{
	alert("답변쓰기 권한이 없습니다.\n\n로그인 해주십시오.");
}
function comErr()
{
	alert("답변쓰기 권한이 없습니다.");
}
//수정
function bbsEdit()
{
	var form=document.pwdForm;
	if(form.pwd.value=="")
	{
		alert("비밀번호를 입력해 주십시오.");
		form.pwd.focus();
	}
	else
	{
		form.action="board_pwd_chek.php?data=<?=$data?>&boardIndex=<?=$boardIndex?>&edit=1";
		form.submit();
	}
}
//삭제
function bbsDel()
{
	var choose = confirm("글의 내용이 삭제됩니다.\n\n삭제 하시겠습니까?");
	if(choose)
	{
		location.href="ask_del.php?data=<?=$data?>";
	}
	else return;
}
//-->
</SCRIPT>
<? include "top.php";?>
<table width="900" border="0" cellspacing="0" cellpadding="0" bgcolor="<?=$ALL_BGCOLOR?>">
	<tr>
		<? include "left_menu.php";?>
		<td height="30" valign="top" width="720" bgcolor="#FFFFFF">
			<table width="720" height="100%" border="0" cellspacing="0" cellpadding="0">
				<tr bgcolor="#FFFFFF" valign="top">
					<td colspan="2" height="30">
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
						</table><?
						$dataArr = Decode64($data);
						$view_row = $MySQL->fetch_array("select *from bbs_data where idx=$dataArr[idx]"); //게시판 정보
						$MySQL->query("update bbs_data set readnum=readnum+1 where idx=$dataArr[idx]");
						?>
						<table width="670" border="0" cellspacing="1" cellpadding="5" align="center" bgcolor="#ffffff" >
							<tr>
								<td bgcolor="#FFFFFF" valign="top"><br>
									<table width="670" border="0" cellspacing="1" cellpadding="5" align="center">
										<tr>
											<td colspan="2" valign="top"><br>
												<table width="670" border="0" cellspacing="0" cellpadding="0" align="center">
													<tr>
														<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<B><?=$bbs_admin_row[name]?></B><br></td>
													</tr>
													<tr>
														<td height="22" colspan="5" align="center">
															<table width="670" border="0" cellspacing="0" cellpadding="0">
																<tr>
																	<td colspan="5">
																		<table width="670" border="0" cellspacing="0" cellpadding="0">
																			<tr>
																				<td height='2' bgcolor='1a0050'></td>
																			</tr>
																			<tr>
																				<td>
																					<table width="670" border="0" cellspacing="0" cellpadding="0" height="30">
																						<tr>
																							<td width="100" bgcolor="f8f8f8"><div align="center"><img src='image/board/t_subject.gif'></div></td>
																							<td width='1' bgcolor='dddddd'></td>
																							<td>&nbsp;&nbsp;<B><?=$view_row[title]?></B></td>
																						</tr>
																					</table>
																				</td>
																			</tr>
																			<tr>
																				<td bgcolor="#dddddd" height="1"></td>
																			</tr>
																			<tr>
																				<td>
																					<table width="670" border="0" cellspacing="0" cellpadding="0" height="30">
																						<tr>
																							<td width="100" bgcolor="f8f8f8"><div align="center"><img src='image/board/t_date.gif'></div></td>
																							<td width='1' bgcolor='dddddd'></td><td>&nbsp;&nbsp;<?=$view_row[writeday]?></td>
																							<td width='1' bgcolor='dddddd'></td>
																							<td width="100" bgcolor="f8f8f8"><div align="center"><img src='image/board/t_click.gif'></div></td>
																							<td width='1' bgcolor='dddddd'></td>
																							<td width="225">&nbsp;&nbsp;<?=$view_row[readnum]?></td>
																						</tr>
																					</table>
																				</td>
																			</tr>
																			<tr>
																				<td bgcolor="#dddddd" height="1"></td>
																			</tr>
																			<tr>
																				<td>
																					<table width="670" border="0" cellspacing="0" cellpadding="0" height="30">
																						<tr>
																							<tr>
																							<td width="100" bgcolor="f8f8f8"><div align="center"><img src='image/board/t_writer.gif'></div></td>
																							<td width='1' bgcolor='dddddd'></td>
																							<td>&nbsp;&nbsp;<?=$view_row[name]?></td>
																							<td width="1" bgcolor="dddddd"></td>
																							<td width="100" bgcolor="f8f8f8" align="center"><img src='image/board/t_mail.gif'></td>
																							<td width='1' bgcolor='dddddd'></td>
																							<td width="225">&nbsp;&nbsp;<a href="javascript:sendMail('<?=$view_row[email]?>');"><u><?=$view_row[email]?></a></td>
																						</tr>
																					</table>
																				</td>
																			</tr><?
																			if(!empty($view_row[up_file]))
																			{
																				?>
																			<tr>
																				<td bgcolor="dddddd" height="1"></td>
																			</tr>
																			<tr>
																				<td>
																					<table width="670" border="0" cellspacing="0" cellpadding="0" height="30">
																						<tr>
																							<td width="62" bgcolor="f4f4f4" align="center"><img src='image/board/t_data.gif'></td>
																							<td width='1' bgcolor='dddddd'></td>
																							<td bgcolor="f0f0f0">&nbsp;&nbsp; <img src="image/icon/icon_10.gif" width="12" height="12"> <a href="./upload/bbs/<?=$view_row[up_file]?>"><?=$view_row[up_file]?></a></td>
																						</tr>
																					</table>
																				</td>
																			</tr><?
																			}
																			?>
																		</table>
																	</td>
																</tr>
																<tr>
																	<td colspan="5" height="1" bgcolor="dddddd"></td>
																</tr>
																<tr>
																	<td colspan="5" height="80"><br>
																		<table width="500" border="0" cellspacing="0" cellpadding="0" align="center">
																			<tr>
																				<td style="word-break:break-all"><?=($view_row[bHtml]==1)?nl2br(htmlspecialchars($view_row[content])):$view_row[content]?></td>
																			</tr>
																		</table><br>
																	</td>
																</tr>
																<tr>
																	<td colspan="5" height="1" bgcolor="dddddd"></td>
																</tr>
																<tr>
																	<td>&nbsp;</td>
																	<td><br>
																		<table width="240" border="0" cellspacing="0" cellpadding="0" align="right">
																			<tr align="center">
																				<td width="60"><a href="ask_list.php?data=<?=$data?>"><img src="image/board/btn_list.gif" border="0"></a></td><?
																				if(!$view_row[badmin])
																				{
																					?>
																				<td width="60"><a href="ask_edit.php?data=<?=$data?>"><img src="image/board/btn_edit.gif" border="0"></a></td><?
																				}
																				if($view_row[badmin])
																				{
																					?>
																				<td width="60"><a href="ask_write.php?data=<?=$data?>"><img src="image/board/btn_re.gif" border="0"></a></td><?
																				}
																				if(!$view_row[badmin])
																				{
																					?>
																				<td width="60"><a href="javascript:bbsDel();"><img src="image/board/btn_delete.gif" border="0"></a></td><?
																				}
																				?>
																			</tr>
																		</table>
																	</td>
																</tr>
															</table>
														</td>
													</tr>
													<tr>
														<td valign="top" height="2" colspan="5"></td>
													</tr>
												</table><br>
												<!-- 관련 글 시작 --><?
												$MySQL->query("select * from bbs_data where ref=$view_row[ref]");
												if($MySQL->is_affected() >1)
												{
													//관련글이 있을 경우
													?>
												<table width="550" border="0" cellspacing="0" cellpadding="3" align="center">
													<tr>
														<td bgcolor="#D9D9D9" height="1"></td>
													</tr>
													<tr>
														<td bgcolor="f4f4f4"><img src="image/icon/icon8.gif" width="11" height="11"> 관련글 (총 <?=$MySQL->is_affected()?>개)</td>
													</tr>
													<tr>
														<td>
															<!-- 목록 시작 -->
															<table width="100%" border="0" cellspacing="0" cellpadding="0" align="right"><?
															$relay_result = $MySQL->query("select *from bbs_data where ref=$view_row[ref]   order by ref desc,re_step asc ");
															while($relay_row=mysql_fetch_array($relay_result))
															{
																$encode_str = "idx=".$relay_row[idx];
																$redata=Encode64($encode_str);					//각 레코드 정보
																//새글이미지
																if(BetweenPeriod($relay_row[writeday],$bbs_admin_row[newPeriod]) > 0) $newImg = "<img src='image/icon/icon_new.gif' width='30' height='10'>";
																else $newImg = "";
																//첨부파일
																if(empty($relay_row[up_file]))	$upImg	= "";
																else $upImg	= "<img src='image/s_file.gif'>";
																if($relay_row[re_level]>0)
																{
																	//답변
																	$wid=10*$relay_row[re_level];              //레벨 이미지 길이
																	$level_img="<img src='admin/image/level.gif' width=".$wid." height=8><img src='image/icon/board_re.gif' width='10' height='10'>";
																}
																else
																{
																	$level_img="";
																}
																?>
																<tr valign="middle" bgcolor="ffffff" style='cursor:pointer;' onMouseOver="this.style.backgroundColor='#fafafa'" onMouseOut="this.style.backgroundColor=''" onclick="location.href='ask_view.php?data=<?=$redata?>'"><?
																if($relay_row[idx]==$view_row[idx])
																{
																	?>
																	<td width="3%" height="20"><img src="image/icon/icon9.gif" width="10" height="10"></td>
																	<td width="84%" height="20">&nbsp;<?=$level_img?> <B><?=StringCut($relay_row[title],40)?></B> <?=$newImg?></td><?
																}
																else
																{
																	?>
																	<td width="3%" height="20">&nbsp;</td>
																	<td width="84%" height="20">&nbsp;<?=$level_img?> <?=StringCut($relay_row[title],40)?> <?=$newImg?></td><?
																}
																?>
																	<td width="13%" height="20"><?=$relay_row[name]?></td>
																</tr>
																<tr>
																	<td colspan="3" height="1" background="image/icon/dot_width.gif"></td>
																</tr><?
															}
															?>
															</table>
															<!-- 목록 끝 -->
														</td>
													</tr>
												</table><?
												}
												?>
												<!-- 관련 글 끝 -->
											</td>
										</tr>
									</table><br><br><br><br>
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