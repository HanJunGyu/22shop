<?
// 소스 형상 관리
// 20060724_1 소스추가 최호수
// 20060724_2 소스수정 최호수(게시판 글입력시 엔터없이 길게 입력할 경우 문단바꿈 적용)
include "head.php";
$dataArr = Decode64($data);
$view_row = $MySQL->fetch_array("select *from bbs_data where idx=$dataArr[idx] limit 1"); //게시물 정보
// 꼬릿말체크
if ($bcomment)
{
	$qry = "INSERT INTO comment(re_name,re_content,re_pwd,boardcode,boardidx,writeday) values ('$re_name','$re_content','$re_pwd','$boardcode','$boardidx',now())";
	if ($MySQL->query($qry))
	{
		Refresh("board_view.php?data=$data&boardIndex=$boardIndex");
		exit;
	}
	else
	{
		MsgViewHref("꼬릿말 저장에 실패하였습니다.","board_view.php?data=$data&boardIndex=$boardIndex");
	}
}
// 잠금기능이 있어서 비밀번호입력이 있었다면
if ($view_row[bLock]=="y")
{
	if ($_POST["lock_pwd"] == "")
	{
		OnlyMsgView("잠금기능이 설정된 게시물 입니다.");
		Refresh("board_lock.php?idx=$bbs_row[idx]&data=$data&boardIndex=$boardIndex");
		exit;
	}
	else if ($view_row[pwd] != $_POST["lock_pwd"])
	{
		OnlyMsgView("비밀번호가 맞지 않습니다.");
		Refresh("board_lock.php?idx=$bbs_row[idx]&data=$data&boardIndex=$boardIndex");
		exit;
	}
}
?>
<SCRIPT LANGUAGE="JavaScript">
<!--
function comment_del(a,b,c)
{
	window.open("comment_del.php?idx="+a+"&boardIndex="+b+"&data="+c,"","scrollbars=no,width=300,height=140,left=250,top=250");
}
function comment_check()
{
	var comform = document.comment;
	if (comform.re_name.value == "")
	{
		alert("이름을 입력하세요");
		comform.re_name.focus();
	}
	else if (comform.re_content.value == "")
	{
		alert("내용을 입력하세요");
		comform.re_content.focus();
	}
	else if (comform.re_pwd.value == "")
	{
		alert("비밀번호를 입력하세요");
		comform.re_pwd.focus();
	}
	else
	{
		comform.bcomment.value = 1;
		comform.submit();
	}
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
	var form=document.pwdForm;
	if(form.pwd.value=="")
	{
		alert("비밀번호를 입력해 주십시오.");
		form.pwd.focus();
	}
	else
	{
		form.action="board_pwd_chek.php?data=<?=$data?>&boardIndex=<?=$boardIndex?>&del=1";
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
			<table width="720" border="0" cellspacing="0" cellpadding="0">
				<tr bgcolor="#FFFFFF" valign="top">
					<td colspan="2" height="1">
						<table width="720" height="35" border="0" cellspacing="0" cellpadding="0" align='center'>
							<tr>
								<td width="2"  bgcolor="<?=$subdesign[bc10]?>" rowspan="2"></td>
								<td width="2"  bgcolor="<?=$subdesign[bc10]?>" rowspan="2"></td>
								<td width="220" height="30" bgcolor="<?=$subdesign[bc10]?>"><img src="./upload/design/<?=$subdesign[img10]?>" ></td>
								<td width="490" height="30" bgcolor="<?=$subdesign[bc10]?>"><div align="right"> &nbsp;<font color="<?=$subdesign[tc10]?>"> <img src='image/good/icon0.gif'>&nbsp;현재위치 : HOME &gt; 게시판</font>&nbsp;</div></td>
							</tr>
						</table>
					</td>
				</tr><?
				$bbs_admin_row = $MySQL->fetch_array("select *from bbs_list where idx='$boardIndex'"); //게시판 정보
				$boardcode = $bbs_admin_row[code];
				$MySQL->query("update bbs_data set readnum=readnum+1 where idx=$dataArr[idx]");
				?>
				<tr>
					<td valign="top" width="720">
						<table width="714" border="0" cellspacing="0" cellpadding="0">
							<tr><?
							if ($bbs_admin_row[img])
							{
								?>
								<td><img src="upload/bbs/<?=$bbs_admin_row[img]?>"></td><?
							}
							else if ($subdesign[titimg10])
							{
								?>
								<td><img src="./upload/design/<?=$subdesign[titimg10]?>"></td><?
							}
							else
							{
								?>
								<td><img src="image/index/board.gif" ></td><?
							}
							?>
							</tr>
						</table>
						<table width="670" border="0" cellspacing="0" cellpadding="0" align="center" bgcolor="#CCCCCC" >
							<tr>
								<td bgcolor="#FFFFFF" valign="top">
									<table width="670" border="0" cellspacing="0" cellpadding="0" align="center">
										<tr>
											<td colspan="2" valign="top"><br>
												<table width="670" border="0" cellspacing="0" cellpadding="0" align="center">
													<tr>
														<td height='25'><img src='image/board/icon_tit.gif' align='absmiddle'> <B><?=$bbs_admin_row[name]?></B><br></td>
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
																				<td bgcolor="dddddd" height="1"></td>
																			</tr>
																			<tr>
																				<td>
																					<table width="670" border="0" cellspacing="0" cellpadding="0" height="30">
																						<tr>
																							<td width="100" bgcolor="f8f8f8"><div align="center"><img src='image/board/t_date.gif'></div></td>
																							<td width='1' bgcolor='dddddd'></td><td>&nbsp;&nbsp;<?=$view_row[gongji]?$view_row[gongji_day]:$view_row[writeday]?></td>
																							<td width='1' bgcolor='dddddd'></td>
																							<td width="100" bgcolor="f8f8f8"><div align="center"><img src='image/board/t_click.gif'></div></td>
																							<td width='1' bgcolor='dddddd'></td>
																							<td width="225">&nbsp;&nbsp;<?=$view_row[readnum]?></td>
																						</tr>
																					</table>
																				</td>
																			</tr>
																			<tr>
																				<td bgcolor="dadada" height="1"></td>
																			</tr>
																			<tr>
																				<td>
																					<table width="670" border="0" cellspacing="0" cellpadding="0" height="30">
																						<tr>
																							<td width="100" bgcolor="f8f8f8"><div align="center"><img src='image/board/t_writer.gif'></div></td>
																							<td width='1' bgcolor='dddddd'></td>
																							<td>&nbsp;&nbsp;<?=$view_row[name]?></td>
																						</tr>
																					</table>
																				</td>
																			</tr><?
																			if($bbs_admin_row[part]==20 && !empty($view_row[up_file]))
																			{
																				//자료실
																				?>
																			<tr>
																				<td bgcolor="dadada" height="1"></td>
																			</tr>
																			<tr>
																				<td>
																					<table width="670" border="0" cellspacing="0" cellpadding="0" height="30">
																						<tr>
																							<td width="100" bgcolor="f8f8f8"><div align="center"><img src='image/board/t_data.gif'></div></td>
																							<td width='1' bgcolor='dddddd'></td>
																							<td>&nbsp;&nbsp; <img src="image/icon/icon_10.gif" width="12" height="12"> <a href="./upload/bbs/<?=$view_row[up_file]?>" target="_blank"><?=$view_row[up_file]?></a></td>
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
																	<td colspan="5" height="1" align="center" bgcolor="dadada"></td>
																</tr>
																<tr>
																	<td colspan="5" height="80">
																		<table width="670" border="0" cellspacing="0" cellpadding="0" align="center"><?
																		if($bbs_admin_row[part]==30 && $view_row[img2])
																		{
																			?>
																			<tr>
																				<td align='center'><img src="./upload/bbs/<?=$view_row[img2]?>"></td>
																			</tr><?
																		}
																		?>
																			<tr>
																				<td style='padding:10 10 10 10;' style="word-break:break-all"><?=($view_row[bHtml]==1)?nl2br(htmlspecialchars($view_row[content])):$view_row[content]?></td>
																			</tr>
																		</table>
																	</td>
																</tr>
																<tr>
																	<td colspan="5" height="2" bgcolor="dddddd"></td>
																</tr>
																<tr>
																	<td colspan="5" height="7"></td>
																</tr>
															</table>
															<table width='670' border='0' cellpadding='3' cellspacing='1' bgcolor='dddddd'>
																<tr bgcolor='f8f8f8' height=20>
																	<td width='80' align='center'><img src='image/board/t_name.gif'></td>
																	<td align='center'><img src='image/board/t_content.gif'></td>
																	<td width=80 align='center'><img src='image/board/t_date.gif'></td>
																	<td width=30 align='center'><img src='image/board/t_del.gif'></td>
																</tr><?
																if ($bbs_admin_row[bComment])
																{
																	// 해당게시물에 등록된 꼬릿말 불러오기
																	$comment_result = mysql_query("SELECT *from comment where boardcode='$boardcode' and boardidx='$dataArr[idx]' order by idx asc");
																	if ($comment_result)
																	{
																		if (mysql_num_rows($comment_result))
																		{
																			while ($comment_row = mysql_fetch_array($comment_result))
																			{
																				$comment_writeday = $comment_row[writeday];
																				$comment_writeday = substr($comment_writeday,5);
																				$comment_re_content = nl2br($comment_row[re_content]);
																				?>
																				<!-- 꼬릿말 출력 및 쓰기폼 시작 -->
																<tr bgcolor='ffffff' height=25>
																	<td align='center'><font color="#009BD4"><?=$comment_row[re_name]?></font></td>
																	<td style="word-break:break-all;"><?=$comment_re_content?></td>
																	<td align='center'><?=$comment_writeday?></td>
																	<td align='center'><a href="javascript:comment_del('<?=$comment_row[idx]?>','<?=$boardIndex?>','<?=$data?>');"><img src='image/board/delete.gif' border='0' alt='코멘트삭제'></a></td>
																</tr><?
																			}
																		}
																	}
																	?>
															</table>
															<br>
															<table width='670' border='0' cellpadding='0' cellspacing='1' bgcolor='dddddd'>
																<tr>
																	<td colspan="5" style="padding:5 5 5 5;" bgcolor='ffffff'>
																		<form name="comment" action="board_view.php?data=<?=$data?>&boardIndex=<?=$boardIndex?>" method="post">
																		<input type="hidden" name="boardcode" value="<?=$boardcode?>"> <!-- 게시판 정보 -->
																		<input type="hidden" name="boardidx" value="<?=$dataArr[idx]?>"> <!-- 게시물 번호 -->
																		<input type="hidden" name="bcomment" value="0">
																		<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
																			<tr>
																				<td colspan='2' height='25'><img src='image/board/name.gif' align='absmiddle'> <input type="text" class="box_s" name="re_name" size="8"> <img src='image/board/pw.gif' align='absmiddle'> <input type="password"  class="box_s" name="re_pwd" size="8"></td>
																			</tr>
																			<tr>
																				<td width="90%" valign=middle><textarea style="background-color:#f2f2f2;border:1px solid #cccccc;text-align:left;color:#525252;width:100%" name="re_content" cols="82" rows="3"></textarea></td>
																				<td width="10%" style='padding:0 0 0 3;'><?
																				if($bbs_admin_row[wAct]==0 || ($bbs_admin_row[wAct]==10 && $_SESSION[GOOD_SHOP_PART]=='member'))
																				{
																					?><a href="javascript:comment_check();"><img src="image/board/btn_comment.gif" border="0" align='absmiddle'></a><?
																				}
																				else
																				{
																					?><a href="javascript:alert('꼬릿말 쓰기권한이 없습니다.');"><img src="image/board/btn_comment.gif" border="0" align='absmiddle'></a><?
																				}
																				?></td>
																			</tr>
																		</table></form>
																	</td>
																</tr>
															</table><?
																}
																?>
															<table width='670' border='0' cellpadding='0' cellspacing='0'>
																<tr>
																	<td colspan='2' height='7'></td>
																</tr>
																<tr>
																	<td colspan='2' height='2' bgcolor='dddddd'></td>
																</tr>
																<tr>
																	<td>
																		<form name="pwdForm" method="post">
																		<table width="300" border="0" cellspacing="0" cellpadding="0">
																			<tr>
																				<td height='30'><img src='image/board/pw.gif' align='absmiddle'> <input class="box_s" type="password" name="pwd" size="15"></td>
																			</tr>
																		</table></form>
																	</td>
																	<td>
																		<table width="240" border="0" cellspacing="0" cellpadding="0" align="right">
																			<tr align="center">
																				<td width="60"><a href="board_list.php?data=<?=$data?>&boardIndex=<?=$boardIndex?>"><img src="image/board/btn_list.gif" border="0"></a></td>
																				<td width="60"><a href="javascript:bbsEdit();"><img src="image/board/btn_edit.gif" border="0"></a></td><?
																				if($bbs_admin_row[part]!=30)
																				{
																					if($bbs_admin_row[cAct]==0 || ($bbs_admin_row[cAct]==10 && $_SESSION[GOOD_SHOP_PART]=='member'))
																					{
																						?>
																				<td width="60"><a href="board_write.php?data=<?=$data?>&boardIndex=<?=$boardIndex?>"><img src="image/board/btn_re2.gif" border="0"></a></td><?
																					}
																					else
																					{
																						//관리자
																						?>
																				<td width="60"><a href="javascript:comErr();"><img src="image/board/btn_re2.gif" border="0"></a></td><?
																					}
																				}
																				?>
																				<td width="60"><a href="javascript:bbsDel();"><img src="image/board/btn_delete.gif" border="0"></a></td>
																			</tr>
																		</table>
																	</td>
																</tr>
																<tr>
																	<td height="10"></td>
																</tr>
																<tr>
																	<td bgcolor='dddddd' height='1' colspan="2"></td>
																</tr><?
																if ($MySQL->articles("SELECT idx from bbs_data WHERE code='$view_row[code]' and idx<$view_row[idx] limit 1"))
																{
																	$pre_bbs_row = $MySQL->fetch_array("SELECT idx,title from bbs_data WHERE code='$view_row[code]' and idx<$view_row[idx] order by idx desc limit 1");
																	$encode_str = "idx=".$pre_bbs_row[idx];
																	$pre_data=Encode64($encode_str);
																	?>
																<tr>
																	<td colspan="2">
																		<table width=100% border='0' cellpadding='0' cellspacing='0' bgcolor='fafafa'>
																			<tr height="25" style='padding:5 0 0 0;'>
																				<td width="80" align="center"><img src='image/board/prev.gif'></td>
																				<td>&nbsp;<a href="board_view.php?idx=<?=$pre_bbs_row[idx]?>&boardIndex=<?=$boardIndex?>&data=<?=$pre_data?>"><?=$pre_bbs_row[title]?></a></td>
																			</tr>
																		</table>
																	</td>
																</tr><?
																}
																if ($MySQL->articles("SELECT idx from bbs_data WHERE code='$view_row[code]' and idx>$view_row[idx] limit 1"))
																{
																	$pre_bbs_row = $MySQL->fetch_array("SELECT idx,title from bbs_data WHERE code='$view_row[code]' and idx>$view_row[idx] order by idx asc limit 1");
																	$encode_str = "idx=".$pre_bbs_row[idx];
																	$pre_data=Encode64($encode_str);
																	?>
																<tr>
																	<td colspan="2">
																		<table width=100% border='0' cellpadding='0' cellspacing='0' bgcolor='fafafa'>
																			<tr height="25" style='padding:0 0 5 0;'>
																				<td width="80" align="center"><img src='image/board/next.gif'></td>
																				<td>&nbsp;<a href="board_view.php?idx=<?=$pre_bbs_row[idx]?>&boardIndex=<?=$boardIndex?>&data=<?=$pre_data?>"><?=$pre_bbs_row[title]?></a></td>
																			</tr>
																		</table>
																	</td>
																</tr>
																<tr>
																	<td bgcolor='dddddd' height='1' colspan="2"></td>
																</tr><?
																}
																?>
															</table>
														</td>
													</tr>
													<tr>
														<td valign="top" height="2" colspan="5"></td>
													</tr>
												</table><br><?
												$MySQL->query("select *from bbs_data where ref=$view_row[ref]");
												$relay_cnt = $MySQL->is_affected();
												if($relay_cnt >1)
												{
													//관련글이 있을 경우
													?>
												<table width="670" border="0" cellspacing="0" cellpadding="0" align="center">
													<tr>
														<td bgcolor="1a0050" height="2"></td>
													</tr>
													<tr>
														<td bgcolor="f8f8f8" height='30' style='padding:0 0 0 5;'><img src="image/board/text.gif" align='absmiddle'> (총 <?=$relay_cnt?>개)</td>
													</tr>
													<tr>
														<td bgcolor="dddddd" height="1"></td>
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
																else				    			$upImg	= "<img src='image/s_file.gif'>";
																if($relay_row[re_level]>0)
																{
																	//답변
																	$wid=10*$relay_row[re_level];              //레벨 이미지 길이
																	$level_img="<img src='admin/image/level.gif' width=".$wid." height=8><img src='image/board/btn_re.gif'>";
																}
																else
																{
																	$level_img="";
																}
																?>
																<tr valign="middle" bgcolor="ffffff" style='cursor:pointer;' onMouseOver="this.style.backgroundColor='#f6f6f6'" onMouseOut="this.style.backgroundColor=''" onclick="location.href='board_view.php?data=<?=$redata?>&boardIndex=<?=$boardIndex?>'"><?
																if($relay_row[idx]==$view_row[idx])
																{
																	?>
																	<td width="3%" height="20" align='center'><img src="image/board/icon00.gif"></td>
																	<td width="84%" height="20">&nbsp;<?=$level_img?> <B><?=StringCut($relay_row[title],40)?></B> <?=$newImg?></td><?
																}
																else
																{
																	?>
																	<td width="3%" height="30">&nbsp;</td>
																	<td width="84%" height="20">&nbsp;<?=$level_img?> <?=StringCut($relay_row[title],40)?> <?=$newImg?></td><?
																}
																?>
																	<td width="13%" height="30"><?=$relay_row[name]?></td>
																</tr>
																<tr>
																	<td colspan="3" height="1" bgcolor='dddddd'></td>
																</tr><?
															}
															?>
															</table>
														</td>
													</tr>
												</table><?
												}
												?>
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
<? include "copy.php";?>
</div>
</body>
</html>