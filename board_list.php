<?
include "head.php";
?>
<SCRIPT LANGUAGE="JavaScript">
<!--
//검색 전송
function searchSendit()
{
	var form=document.searchForm;
	if(form.searchstring.value=="")
	{
		alert("검색 내용을 입력해 주십시오.");
		form.searchstring.focus();
		return false;
	}
	else
	{
		return true;
	}
}
//err message
function writeLoginErr()
{
	alert("쓰기 권한이 없습니다.\n\n로그인 해주십시오.");
	document.bbs.submit();
}
function writeErr()
{
	alert("쓰기 권한이 없습니다.");
}
function readLoginErr()
{
	alert("읽기 권한이 없습니다.\n\n로그인 해주십시오.");
	document.bbs.submit();
}
function readErr()
{
	alert("읽기 권한이 없습니다.");
}
//-->
</SCRIPT>
<? include "top.php";?>
<!-- 로그인 체크시 referer값 셋팅-->
<form name="bbs" method="post" action="login.php"><input type="hidden" name="referer" value="http://<?=$admin_row[shopUrl]?>/board_list.php?boardIndex=<?=$boardIndex?>"></form>
<table width="900" border="0" cellspacing="0" cellpadding="0" bgcolor="<?=$ALL_BGCOLOR?>" align="<?= $__SITE_ALIGN?>">
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
								<td width="220" height="30" bgcolor="<?=$subdesign[bc10]?>"><img src="./upload/design/<?=$subdesign[img10]?>" ></td>
								<td width="490" height="30" bgcolor="<?=$subdesign[bc10]?>"><div align="right"> &nbsp;<font color="<?=$subdesign[tc10]?>"> <img src='image/good/icon0.gif'>&nbsp;현재위치 : HOME &gt; 게시판</font>&nbsp;</div></td>
							</tr>
						</table><?
						$bbs_admin_row = $MySQL->fetch_array("select *from bbs_list where idx=$boardIndex");
						if ($bbs_admin_row[intro_html])
						{
							$intro =  $bbs_admin_row[intro];
						}
						else $intro = nl2br($bbs_admin_row[intro]);
						$code=$bbs_admin_row[code];
						if($bbs_admin_row[part]==20)
						{
							$__TD_COLSPAN = 11;
							$__TITLE_WIDTH = 310;
						}
						else
						{
							$__TD_COLSPAN = 9;
							$__TITLE_WIDTH = 360;
						}
						$data=Decode64($data);
						$pagecnt=$data[pagecnt];
						$letter_no=$data[letter_no];
						$offset=$data[offset];
						if(!$searchstring)
						{
							$search=$data[search];
							$searchstring=$data[searchstring];
						}
						if($searchstring) $numresults=$MySQL->query("select idx from bbs_data where code='$code' and $search like '%$searchstring%' and gongji<>1");
						else $numresults=$MySQL->query("select idx from bbs_data where code='$code' and gongji<>1");
						$numrows=mysql_num_rows($numresults);				//총 레코드수..
						$LIMIT		=$admin_row[board_list_cnt];							//페이지당 글 수
						$PAGEBLOCK	=10;								//블럭당 페이지 수
						if($pagecnt==""){$pagecnt=0;}						//페이지 번호 
						if(!$offset){$offset=$pagecnt*$LIMIT*$PAGEBLOCK;} //각 페이지의 시작 글  
						if(!$letter_no){$letter_no=$numrows;}				//글번호
						if($searchstring)
						{
							$bbs_qry = "select * from bbs_data where code='$code' and gongji<>1 and $search like '%$searchstring%' order by ref desc,re_step asc limit $offset,$LIMIT";
						}
						else
						{
							$bbs_qry = "select * from bbs_data where code='$code' and gongji<>1 order by ref desc,re_step asc limit $offset,$LIMIT";
						}
						?>
					</td>
				</tr><?
				if($bbs_admin_row[part]!=30)
				{
					?><!-- 일반게시판 시작 -->
				<tr>
					<td valign="top" width="720">
						<table width="714" border="0" cellspacing="0" cellpadding="0">
							<tr><?
							if ($bbs_admin_row[img])
							{
								?><td> <img src="./upload/bbs/<?=$bbs_admin_row[img]?>"></td><?
							}
							else if ($subdesign[titimg10])
							{
								?><td> <img src="./upload/design/<?=$subdesign[titimg10]?>" ></td><?
							}
							else
							{
								?><td> <img src="image/index/board.gif" ></td><?
							}
							?></tr>
						</table>
						<table width="650" border="0" cellspacing="1" cellpadding="0" align="center" bgcolor="#ffffff">
							<tr>
								<td align="center" bgcolor="#FFFFFF" valign="top">
									<table width="600" border="0" cellspacing="1" cellpadding="5" align="center"><?
									if($bbs_admin_row[part]==30)
									{
										?>
										<tr><?
										if ($bbs_admin_row[img])
										{
											?>
											<td colspan="2" valign="top"> <img src="upload/bbs/<?=$bbs_admin_row[img]?>"></td><?
										}
										else
										{
											?>
											<td colspan="2" valign="top"> <img src="image/index/board.gif" ></td><?
										}
										?></tr><?
									}
									else
									{
									}
									?>
										<tr>
											<td colspan="2" valign="top">
												<table width="670" border="0" cellspacing="0" cellpadding="0" align="center">
													<tr>
														<td>
															<table width="670" border="0" cellspacing="0" cellpadding="0">
																<tr>
																	<td>
																		<table width="670" cellspacing="2" cellpadding="2" class="table_coll" border='1'><?
																		$result = $MySQL->query("SELECT *from bbs_list WHERE bCommunity='y' order by idx asc");
																		$bbs_list_cnt=0;
																		while ($row = mysql_fetch_array($result))
																		{
																			if ($bbs_list_cnt%3==0) echo "<tr align='center'>";
																			?>
																				<td><a href="board_list.php?boardIndex=<?=$row[idx]?>"><?=$row[name]?></a></td><?
																			$bbs_list_cnt++;
																			if ($bbs_list_cnt%3==0) echo "</tr>";
																		}
																		if ($bbs_list_cnt%3!=0)
																		{
																			while($bbs_list_cnt%3!=0)
																			{
																				echo "<td></td>";
																				$bbs_list_cnt++;
																			}
																			echo "</tr>";
																		}
																		?>
																		</table>
																	</td>
																</tr>
																<tr>
																	<td height=10></td>
																</tr>
																<tr>
																	<td><?=$intro?><br><br></td>
																</tr>
															</table>
															<table width="670" border="0" cellspacing="0" cellpadding="0">
																<tr>
																	<td><img src='image/board/icon_tit.gif' align='absmiddle'> <B><?=$bbs_admin_row[name]?></B></td>
																	<td align='right'>전체 [ <font color="#ff4800"><?=$numrows?></font> ]개</td>
																</tr>
															</table>
															<table width="670" border="0" cellspacing="0" cellpadding="0">
																<tr>
																	<td height="2" colspan="<?=$__TD_COLSPAN?>" bgcolor="#1a0050"></td>
																</tr>
																<tr bgcolor='#f8f8f8'>
																	<td height="30" width="30" align="center"><img src='image/board/t_number.gif'></td>
																	<td height="30" width="2"><img src="image/board/line.gif"></td>
																	<td height="30" width="<?=$__TITLE_WIDTH?>" align="center"><img src='image/board/t_subject.gif'></td>
																	<td height="30" width="2" ><img src="image/board/line.gif"></td>
																	<td height="30" align="center" width='80'><img src='image/board/t_writer.gif'></td>
																	<td height="30" width="2"><img src="image/board/line.gif"></td>
																	<td height="30" align="center" width='80'><img src='image/board/t_date.gif'></td>
																	<td height="30" width="2"><img src="image/board/line.gif"></td>
																	<td height="30" width="50" align="center"><img src='image/board/t_click.gif'></td><?
																	if($bbs_admin_row[part]==20)	// 자료실
																	{
																		?>
																	<td height="30" width="2" align="center"><img src="image/board/line.gif"></td>
																	<td height="30" width="50" align="center"><img src='image/board/t_data.gif'></td><?
																	}
																	?>
																</tr>
																<tr>
																	<td valign="top" height="2" colspan="<?=$__TD_COLSPAN?>" bgcolor="#dddddd"></td>
																</tr>
																<tr>
																	<td valign="top" height="2" colspan="<?=$__TD_COLSPAN?>" ></td>
																</tr><?
																$bbs_result=$MySQL->query($bbs_qry);
																$s_letter=$letter_no;								//페이지별 시작 글번호
																$gongji_result = $MySQL->query("SELECT * from bbs_data where code='$code' and gongji=1 order by gongji_day desc ");
																if (mysql_num_rows($gongji_result))
																{
																	while ($gongji_row = mysql_fetch_array($gongji_result))
																	{
																		$encode_str = "idx=".$gongji_row[idx]."&pagecnt=".$pagecnt."&letter_no=".$s_letter."&offset=".$offset;
																		$encode_str.= "&search=".$search."&searchstring=".$searchstring."&present_num=".$letter_no;
																		$data=Encode64($encode_str);					//각 레코드 정보
																		$com_num = 0; //초기화
																		// 해당게시물 꼬릿말갯수
																		$com_qry = "SELECT idx from comment where boardidx=$gongji_row[idx]";
																		$com_num = $MySQL->articles($com_qry);
																		if ($com_num)
																		{
																			$com_qry = "SELECT writeday from comment where boardidx=$gongji_row[idx] order by idx desc limit 1";
																			$com_row = $MySQL->fetch_array($com_qry);
																			$time_limit = 60*60*24*1;  // 24시간
																			$down_time = strtotime($com_row[writeday]);
																			$date_diff = time() - $down_time;
																			if ($date_diff > $time_limit) // 24시간 지남 
																			{
																				$com_num = "[".$com_num."]";
																			}
																			else $com_num = "<b>[".$com_num."]</b>";
																		}
																		else $com_num = "";
																		if($bbs_admin_row[rAct]==100)
																		{
																			?>
																<tr valign="middle" bgcolor="#E9F2F1" onMouseOver="this.style.backgroundColor='eeeeee'" onMouseOut="this.style.backgroundColor='#E9F2F1'"><?
																		}
																		else if($bbs_admin_row[rAct]==0 || ($bbs_admin_row[rAct]==10 && $_SESSION[GOOD_SHOP_PART]=='member'))
																		{
																			?>
																<tr valign="middle" bgcolor="#E9F2F1" style='cursor:pointer;' onMouseOver="this.style.backgroundColor='eeeeee'" onMouseOut="this.style.backgroundColor='#E9F2F1'" onclick="location.href='board_view.php?data=<?=$data?>&boardIndex=<?=$boardIndex?>'"><?
																		}
																		else
																		{
																			// 권한없음
																			?>
																<tr valign="middle" bgcolor="#E9F2F1" style='cursor:pointer;' onMouseOver="this.style.backgroundColor='eeeeee'" onMouseOut="this.style.backgroundColor='#E9F2F1'" onclick="javascript:readLoginErr();"><?
																		}
																		?>
																	<td height="25" width="30" align="center"><img src='image/board/icon_notice.gif'></td>
																	<td height="30" width="2" ></td>
																	<td height="30" width="<?=$__TITLE_WIDTH?>">&nbsp;<?=$level_img?> <?=StringCut($gongji_row[title],40)?> <?=$newImg?> <?=$com_num?></td>
																	<td height="30" width="2" ></td>
																	<td height="30" width="75" align="center"><?=$gongji_row[name]?></td>
																	<td height="30" width="2" ></td>
																	<td height="30" width="75" align="center"><?=substr($gongji_row[gongji_day],0,10)?></td>
																	<td height="30" width="2"></td>
																	<td height="30" width="45" align="center"><?=$gongji_row[readnum]?></td><?
																		if($bbs_admin_row[part]==20)
																		{
																			?>
																	<td height="30" width="2" align="center"></td><?
																			if(empty($gongji_row[up_file]))
																			{
																				//첨부파일 미존재
																				?>
																	<td height="30" width="30" align="center">&nbsp;</td><?
																			}
																			else
																			{
																				?>
																	<td height="30" width="30" align="center"><img src="image/icon/icon_10.gif" width="12" height="12"></td><?
																			}
																		}
																		//자료실 이면
																		?>
																</tr><?
																	}
																}
																while($bbs_row=mysql_fetch_array($bbs_result))
																{
																	$com_num = 0; //초기화
																	// 해당게시물 꼬릿말갯수
																	$com_qry = "SELECT idx from comment where boardidx=$bbs_row[idx]";
																	$com_num = $MySQL->articles($com_qry);
																	if ($com_num)
																	{
																		$com_qry = "SELECT writeday from comment where boardidx=$bbs_row[idx] order by idx desc limit 1";
																		$com_row = $MySQL->fetch_array($com_qry);
																		$time_limit = 60*60*24*1;  // 24시간 
																		$down_time = strtotime($com_row[writeday]);
																		$date_diff = time() - $down_time;
																		if ($date_diff > $time_limit) // 24시간 지남 
																		{
																			$com_num = "[".$com_num."]";
																		}
																		else $com_num = "<b>[".$com_num."]</b>";
																	}
																	else $com_num = "";
																	$encode_str = "idx=".$bbs_row[idx]."&pagecnt=".$pagecnt."&letter_no=".$s_letter."&offset=".$offset;
																	$encode_str.= "&search=".$search."&searchstring=".$searchstring."&present_num=".$letter_no;
																	$data=Encode64($encode_str);					//각 레코드 정보
																	//새글이미지
																	if(BetweenPeriod($bbs_row[writeday],$bbs_admin_row[newPeriod]) > 0) $newImg = "<img src='image/icon/icon_new.gif' width='30' height='10'>";
																	else $newImg = "";
																	//첨부파일
																	if(empty($bbs_row[up_file]))	$upImg	= "";
																	else $upImg	= "<img src='image/s_file.gif'>";
																	if($bbs_row[re_level]>0)
																	{
																		//답변
																		$wid=10*$bbs_row[re_level];              //레벨 이미지 길이
																		$level_img="<img src='admin/image/level.gif' width=".$wid." height=8><img src='image/board/btn_re.gif'>";
																	}
																	else
																	{
																		$level_img="";
																	}
																	if ($bbs_row[bLock]=="y") $lock_img = "<img src='image/lock.gif'>";
																	else $lock_img = "";
																	if($bbs_admin_row[rAct]==100)
																	{
																		?>
																<tr valign="middle" bgcolor="#ffffff"><?
																	}
																	else if($bbs_admin_row[rAct]==0 || ($bbs_admin_row[rAct]==10 && $_SESSION[GOOD_SHOP_PART]=='member'))
																	{
																		if ($bbs_row[bLock]=="y")
																		{
																			?>
																<tr valign="middle" bgcolor="ffffff" style='cursor:pointer;' onMouseOver="this.style.backgroundColor='#eeeeee'" onMouseOut="this.style.backgroundColor=''" onclick="location.href='board_lock.php?data=<?=$data?>&boardIndex=<?=$boardIndex?>'"><?
																		}
																		else
																		{
																		?>
																<tr valign="middle" bgcolor="#ffffff" style='cursor:pointer;' onMouseOver="this.style.backgroundColor='eeeeee'" onMouseOut="this.style.backgroundColor=''" onclick="location.href='board_view.php?data=<?=$data?>&boardIndex=<?=$boardIndex?>'"><?
																		}
																	}
																	else
																	{
																		//권한없음
																		?>
																<tr valign="middle" bgcolor="#ffffff" style='cursor:pointer;' onMouseOver="this.style.backgroundColor='eeeeee'" onMouseOut="this.style.backgroundColor=''" onclick="javascript:readLoginErr();"><?
																	}
																	?>
																	<td height="25" width="30" align="center"><?=$letter_no?></td>
																	<td height="25" width="2" ></td>
																	<td height="25" width="<?=$__TITLE_WIDTH?>">&nbsp;<?=$level_img?> <? if($bbs_row[re_level]>0) echo ""; ?> <?=StringCut($bbs_row[title],40)?> <?=$newImg?> <?=$com_num?> <?=$lock_img?> <? if($bbs_row[re_level]>0) echo ""; ?></td>
																	<td height="25" width="2" ></td>
																	<td height="25" align="center"><?=$bbs_row[name]?></td>
																	<td height="25" width="2" ></td>
																	<td height="25" align="center"><?=substr($bbs_row[writeday],0,10)?></td>
																	<td height="25" width="2"></td>
																	<td height="25" align="center"><?=$bbs_row[readnum]?></td><?
																	if($bbs_admin_row[part]==20)
																	{
																		//자료실
																		?>
																	<td height="25" width="2" align="center"></td><?
																		if(empty($bbs_row[up_file]))
																		{
																			//첨부파일 미존재
																			?>
																	<td height="25" align="center">&nbsp;</td><?
																		}
																		else
																		{
																			?>
																	<td height="22" width="30" align="center"><img src="image/icon/icon_10.gif" width="12" height="12"></td><?
																		}
																	}
																	?>
																</tr>
																<tr>
																	<td height="1" colspan="<?=$__TD_COLSPAN?>" bgcolor='e9e9e9'></td>
																</tr><?
																	$letter_no--;
																}
																?><!-- 게시판 글목록 끝 --><?
																/****************************************************************************************************************************
																CList(char* pagename,int pagecnt,int offset,int numrows,int pageblock,int limit,char* search,char* searchstring,char* option)
																putList( BOOL pniView, char* pre_icon, char* next_icon)
																****************************************************************************************************************************/
																$Obj=new CList("board_list.php",$pagecnt,$offset,$numrows,$PAGEBLOCK,$LIMIT,$search,$searchstring,"boardIndex=$boardIndex");
																?>
															</table>
														</td>
													</tr>
													<tr>
														<td height="3" bgcolor="#F4F4F4"></td>
													</tr>
													<tr>
														<td height='5'></td>
													</tr>
												</table>
												<form name="searchForm" action="board_list.php" method="post" onSubmit="return searchSendit();">
												<input type="hidden" name="boardIndex" value="<?=$boardIndex?>">
												<table width='670' border='0' cellpadding='0' cellspacing='3' bgcolor='dde9f2'>
													<tr>
														<td height="45" align="center" bgcolor='ffffff'>
															<table width="100%" border="0" cellspacing="0" cellpadding="0">
																<tr>
																	<td width="400" style='padding:0 0 0 5;'><?$Obj->putList(true,"<img src='image/board/btn_prev.gif'>","<img src='image/board/btn_next.gif'>");//이전다음 프린트?></td>
																	<td width="50"><select name="search"><option value="name">작성자</option><option value="title">제 목</option><option value="content">내 용</option></select></td>
																	<td width="100"><input class="box_s" type="text" name="searchstring" size="15"></td>
																	<td width="40"><input type="image" src="image/board/btn_search.gif" border="0"></td>
																</tr>
															</table>
														</td>
													</tr>
												</table>
												<table width='670' border='0' cellpadding='0' cellspacing='0'>
													<tr><?
														if($bbs_admin_row[wAct]==0 || ($bbs_admin_row[wAct]==10 && $_SESSION[GOOD_SHOP_PART]=='member'))
														{
															?>
														<td align='center' height='30'><a href="board_write.php?boardIndex=<?=$boardIndex?>"><img src="image/board/btn_write.gif" border="0"></a></td><?
														}
														else
														{
															//관리자
															?>
														<td align='center'><a href="javascript:writeErr();"><img src="image/board/btn_write.gif" border="0"></a></td><?
														}
														?>
													</tr>
												</table></form><!-- searchForm --><!-- 검색폼 끝 -->
											</td>
										</tr>
									</table>
								</td>
							</tr><!-- 일반게시판 끝 --><?
				}
				else
				{
					?>
				<!-- 갤러리 시작 -->
				<tr>
					<td width="2" valign="top"></td>
					<td valign="top">
						<table width="714" border="0" cellspacing="0" cellpadding="0">
							<tr><?
							if ($bbs_admin_row[img])
							{
								?>
								<td valign="top" align='center'> <img src="upload/bbs/<?=$bbs_admin_row[img]?>"></td><?
							}
							else
							{
								?>
								<td valign="top" align='center'> <img src="image/board/gallery_tit.gif" ></td><?
							}
							?>
							</tr>
						</table>
						<table width="650" border="0" cellspacing="0" cellpadding="0" align="center">
							<tr>
								<td align="center" bgcolor="#FFFFFF" valign="top">
									<table width="670" border="0" cellspacing="1" cellpadding="5" align="center">
										<tr>
											<td colspan="2" valign="top"><br>
												<table width="670" border="0" cellspacing="0" cellpadding="0" align="center">
													<tr>
														<td><?=$intro?></td>
													</tr>
													<tr>
														<td height='25'><img src='image/board/icon_tit.gif' align='absmiddle'> <B><?=$bbs_admin_row[name]?></B></td>
													</tr>
													<tr>
														<td bgcolor='dddddd' height='2'></td>
													</tr>
													<tr>
														<td><br>
															<table width="670" border="0" cellspacing="0" cellpadding="0" align="center">
																<tr><?
																$bbs_result=$MySQL->query($bbs_qry);
																$s_letter=$letter_no;								//페이지별 시작 글번호
																$gallery_cnt =0;
																while($bbs_row=mysql_fetch_array($bbs_result))
																{
																	// 해당게시물 꼬릿말갯수
																	$result = $MySQL->query("SELECT count(*) from comment where boardcode=$boardIndex and boardidx=$bbs_row[idx]");
																	$com_temp = mysql_result($result,0,0);
																	if ($com_temp == 0) $com_num = "";
																	else $com_num = "[".$com_temp."]";
																	$gallery_cnt++;
																	$encode_str = "idx=".$bbs_row[idx]."&pagecnt=".$pagecnt."&letter_no=".$s_letter."&offset=".$offset;
																	$encode_str.= "&search=".$search."&searchstring=".$searchstring."&present_num=".$letter_no;
																	$data=Encode64($encode_str);	// 각 레코드 정보
																	// 새글이미지
																	if(BetweenPeriod($bbs_row[writeday],$bbs_admin_row[newPeriod]) > 0) $newImg = "<img src='image/icon/icon_new.gif' width='30' height='10'>";
																	else $newImg = "";
																	if ($bbs_row[bLock]=="y") $lock_img = "<img src='image/lock.gif'>";
																	else $lock_img = "";
																	?>
																	<td valign="top">
																		<table width="130" border="0" cellspacing="0" cellpadding="0" align="center">
																			<tr>
																				<td>
																					<table width="110" border="0" cellspacing="1" cellpadding="0" height="90" align="center" background='image/board/gallery_bg.gif'>
																						<tr>
																							<td valign='center' bgcolor='ffffff'>
																								<table width="100" border="0" cellspacing="0" cellpadding="0" align="center" height="80"><?
																								// 잠금기능 사용시
																								if ($bbs_row[bLock]=="y")
																								{
																									?>
																									<tr valign="middle" bgcolor="ffffff" style='cursor:pointer;' onMouseOver="this.style.backgroundColor='#eeeeee'" onMouseOut="this.style.backgroundColor=''" onclick="location.href='board_lock.php?data=<?=$data?>&boardIndex=<?=$boardIndex?>'"><?
																								}
																								else if($bbs_admin_row[rAct]==0 || ($bbs_admin_row[rAct]==10 && $_SESSION[GOOD_SHOP_PART]=='member'))
																								{
																									?>
																									<tr valign="middle" bgcolor="#ffffff" style='cursor:pointer;' onMouseOver="this.style.backgroundColor='eeeeee'" onMouseOut="this.style.backgroundColor=''" onclick="location.href='board_view.php?data=<?=$data?>&boardIndex=<?=$boardIndex?>'"><?
																								}
																								else
																								{
																									//권한없음
																									?>
																									<tr valign="middle" bgcolor="#ffffff" style='cursor:pointer;' onMouseOver="this.style.backgroundColor='eeeeee'" onMouseOut="this.style.backgroundColor=''" onclick="javascript:readLoginErr();"><?
																								}
																								?>
																										<td align="center"><img src="upload/bbs/<?=$bbs_row[img1]?>" width="100" height="80" border="0"></td>
																									</tr>
																								</table>
																							</td>
																						</tr>
																					</table>
																				</td>
																			</tr>
																			<tr>
																				<td height="10"></td>
																			</tr><?
																			// 잠금기능 사용시
																			if ($bbs_row[bLock]=="y")
																			{
																				?>
																			<tr valign="middle" bgcolor="ffffff" style='cursor:pointer;' onMouseOver="this.style.backgroundColor='#eeeeee'" onMouseOut="this.style.backgroundColor=''" onclick="location.href='board_lock.php?data=<?=$data?>&boardIndex=<?=$boardIndex?>'"><?
																			}
																			else if($bbs_admin_row[rAct]==0 || ($bbs_admin_row[rAct]==10 && $_SESSION[GOOD_SHOP_PART]=='member'))
																			{
																				?>
																			<tr valign="middle" bgcolor="#ffffff" style='cursor:pointer;' onMouseOver="this.style.backgroundColor='eeeeee'" onMouseOut="this.style.backgroundColor=''" onclick="location.href='board_view.php?data=<?=$data?>&boardIndex=<?=$boardIndex?>'"><?
																			}
																			else
																			{
																				//권한없음
																				?>
																			<tr valign="middle" bgcolor="#ffffff" style='cursor:pointer;' onMouseOver="this.style.backgroundColor='eeeeee'" onMouseOut="this.style.backgroundColor=''" onclick="javascript:readLoginErr();"><?
																			}
																			?>
																				<td><div align="center"><FONT COLOR="009BD4"><?=StringCut($bbs_row[title],30)?></FONT>&nbsp;<?=$com_num?> <?=$lock_img?><br><font class='stext'><?=substr($bbs_row[writeday],0,10)?></font></div></td>
																			</tr>
																		</table>
																	</td><?
																			$letter_no--;
																			if($gallery_cnt%5 == 0)
																			{
																				?>
																</tr>
																<tr>
																	<td colspan="7" height="20">&nbsp;</td>
																</tr>
																<tr><?
																			}
																}
																$emptyTD = 5- $gallery_cnt%5;
																if($gallery_cnt%5)
																{
																	for($i=0;$i<$emptyTD;$i++)
																	{
																		?>
																	<td width="130">&nbsp;</td><?
																	}
																}
																?><!-- 게시판 글목록 끝 --><?
																/****************************************************************************************************************************
																CList(char* pagename,int pagecnt,int offset,int numrows,int pageblock,int limit,char* search,char* searchstring,char* option)
																putList( BOOL pniView, char* pre_icon, char* next_icon)
																****************************************************************************************************************************/
																$Obj=new CList("board_list.php",$pagecnt,$offset,$numrows,$PAGEBLOCK,$LIMIT,$search,$searchstring,"boardIndex=$boardIndex");
																?>
																</tr>
															</table><br>
														</td>
													</tr>
													<tr>
														<td bgcolor='dddddd' height='2'></td>
													</tr>
												</table><br>
												<table width='670' border='0' cellpadding='0' cellspacing='3' bgcolor='dde9f2'>
													<tr>
														<td height="50" bgcolor='FFFFFF'>
															<!-- 검색폼 시작 -->
															<form name="searchForm" action="board_list.php" method="post" onSubmit="return searchSendit();">
															<input type="hidden" name="boardIndex" value="<?=$boardIndex?>">
															<table width="100%" border="0" cellspacing="0" cellpadding="0">
																<tr>
																	<td height="25"><?$Obj->putList(true,"<img src='image/board/btn_prev.gif'>","<img src='image/board/btn_next.gif'>");//이전다음 프린트?></td>
																	<td width="60"><select name="search"><option value="name">작성자</option><option value="title">제 목</option><option value="content">내 용</option></select></td>
																	<td width="100"><input class="box_s" type="text" name="searchstring" size="15"></td>
																	<td width="30"><input type="image" src="image/board/btn_search.gif" border="0"></td>
																</tr>
															</table>
															</form><!-- searchForm --><!-- 검색폼 끝 -->
														</td>
													</tr>
												</table>
												<table width='670' border='0' cellpadding='0' cellspacing='0'>
													<tr><?
														if($bbs_admin_row[wAct]==0 || ($bbs_admin_row[wAct]==10 && $_SESSION[GOOD_SHOP_PART]=='member'))
														{
															?>
														<td align='center' height='30'><a href="board_write.php?boardIndex=<?=$boardIndex?>"><img src="image/board/btn_write.gif"" border="0"></a></td><?
														}
														else
														{
															//관리자
															?>
														<td align='center'><a href="javascript:writeErr();"><img src="image/board/btn_write.gif" border="0"></a></td><?
														}
														?>
													</tr>
												</table>
											</td>
										</tr>
									</table><br>
								</td>
							</tr><?
				}
				?>
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