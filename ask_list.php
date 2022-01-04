<?
include "head.php";
if(empty($GOOD_SHOP_USERID))
{
	OnlyMsgView("회원 로그인 해주십시오.");
	ReFresh("index.php");
	exit;
}
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
	location.href="login.php";
}
function writeErr()
{
	alert("쓰기 권한이 없습니다.");
}
function readLoginErr()
{
	alert("읽기 권한이 없습니다.\n\n로그인 해주십시오.");
	location.href="login.php";
}
function readErr()
{
	alert("읽기 권한이 없습니다.");
}
//-->
</SCRIPT>
<?
include "top.php";
?>
<table width="900" border="0" cellspacing="0" cellpadding="0" bgcolor="<?=$ALL_BGCOLOR?>">
	<tr>
		<? include "left_menu.php";?>
		<td height="51" valign="top" width="720" bgcolor="#FFFFFF">
			<table width="720" height="100%" border="0" cellspacing="0" cellpadding="0">
				<tr bgcolor="#FFFFFF" valign="top">
					<td colspan="2" height="30">
						<table width="720" height="35" border="0" cellspacing="0" cellpadding="0" align='center'>
							<tr>
								<td width="2"  bgcolor="<?=$subdesign[bc9]?>" rowspan="2"></td>
								<td width="2"  bgcolor="<?=$subdesign[bc9]?>" rowspan="2"></td>
								<td width="220" height="30" bgcolor="<?=$subdesign[bc9]?>"><img src="./upload/design/<?=$subdesign[img9]?>" ></td>
								<td width="490" height="30" bgcolor="<?=$subdesign[bc9]?>"><div align="right"> &nbsp;<font color="<?=$subdesign[tc9]?>"> &nbsp;현재위치 : HOME &gt; 1:1문의</font>&nbsp;</div></td>
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
						$code="person_ask";
						$__TD_COLSPAN = 11; $__TITLE_WIDTH = 275;		//글목록 크기 설정 
						$data=Decode64($data);
						$pagecnt=$data[pagecnt];
						$letter_no=$data[letter_no];
						$offset=$data[offset];
						if(!$searchstring)
						{
							//검색
							$search=$data[search];
							$searchstring=$data[searchstring];
						}
						if($searchstring) $numresults=$MySQL->query("select idx from bbs_data where code='$code' and userid='$GOOD_SHOP_USERID' and $search like '%$searchstring%'");
						else $numresults=$MySQL->query("select idx from bbs_data where code='$code' and userid='$GOOD_SHOP_USERID'");
						$numrows=mysql_num_rows($numresults);				//총 레코드수..
						$LIMIT		=12;								//페이지당 글 수
						$PAGEBLOCK	=10;								//블럭당 페이지 수
						if($pagecnt==""){$pagecnt=0;}						//페이지 번호 
						if(!$offset){$offset=$pagecnt*$LIMIT*$PAGEBLOCK;} //각 페이지의 시작 글  
						if(!$letter_no){$letter_no=$numrows;}				//글번호
						if($searchstring)
						{
							$bbs_qry = "select * from bbs_data where code='$code' and userid='$_SESSION[GOOD_SHOP_USERID]' and $search like '%$searchstring%' ";
							$bbs_qry.= " order by ref desc,re_step asc limit $offset,$LIMIT";
						}
						else
						{
							$bbs_qry = "select * from bbs_data where code='$code' and userid='$_SESSION[GOOD_SHOP_USERID]'  order by ref desc,re_step asc limit $offset,$LIMIT";
						}
						?>
						<table width="670" border="0" cellspacing="1" cellpadding="0" align="center" bgcolor="#ffffff">
							<tr>
								<td align="center" bgcolor="#FFFFFF" valign="top">
									<table width="670" border="0" cellspacing="1" cellpadding="5" align="center">
										<tr>
											<td colspan="2" valign="top"><br>
												<table width="670" border="0" cellspacing="0" cellpadding="0" align="center">
													<tr>
														<td>
															<table width="670" border="0" cellspacing="0" cellpadding="0">
																<tr>
																	<td colspan="5">전체 [ <font color="#FF9900"><?=$numrows?></font> ]개&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<B><?=$bbs_admin_row[name]?></B><br></td>
																</tr>
																<tr>
																	<td height="2" colspan="<?=$__TD_COLSPAN?>" bgcolor="#1a0050"></td>
																</tr>
																<tr bgcolor='#f8f8f8'>
																	<td height="22" width="30" align="center"><img src='image/board/t_number.gif'></td>
																	<td height="30" width="2"><img src="image/board/line.gif"></td>
																	<td height="22" width="<?=$__TITLE_WIDTH?>" align="center"><img src='image/board/t_subject.gif'></td>
																	<td height="30" width="2"><img src="image/board/line.gif"></td>
																	<td height="22" width="75" align="center"><img src='image/board/t_writer.gif'></td>
																	<td height="30" width="2"><img src="image/board/line.gif"></td>
																	<td height="22" width="75" align="center"><img src='image/board/t_date.gif'></td>
																	<td height="30" width="2"><img src="image/board/line.gif"></td>
																	<td height="22" width="45" align="center"><img src='image/board/t_click.gif'></td>
																	<td height="30" width="2"><img src="image/board/line.gif"></td>
																	<td height="22" width="30" align="center"><img src='image/board/t_data.gif'></td>
																</tr>
																<tr>
																	<td valign="top" height="2" colspan="<?=$__TD_COLSPAN?>" bgcolor="#dddddd"></td>
																</tr><?
																$bbs_result=$MySQL->query($bbs_qry);
																$s_letter=$letter_no;								//페이지별 시작 글번호
																while($bbs_row=mysql_fetch_array($bbs_result))
																{
																	$encode_str = "idx=".$bbs_row[idx]."&pagecnt=".$pagecnt."&letter_no=".$s_letter."&offset=".$offset;
																	$encode_str.= "&search=".$search."&searchstring=".$searchstring."&present_num=".$letter_no;
																	$data=Encode64($encode_str);					//각 레코드 정보
																	//새글이미지
																	if(BetweenPeriod($bbs_row[writeday],$bbs_admin_row[newPeriod]) > 0) $newImg = "<img src='image/icon/icon_new.gif' width='30' height='10'>";
																	else $newImg = "";
																	//첨부파일
																	if(empty($bbs_row[up_file])) $upImg	= "";
																	else $upImg	= "<img src='image/s_file.gif'>";
																	if($bbs_row[re_level]>0)
																	{
																		//답변
																		$wid=10*$bbs_row[re_level];              //레벨 이미지 길이
																		$level_img="<img src='admin/image/level.gif' width=".$wid." height=8><img src='image/icon/board_re.gif' width='10' height='10'>";
																	}
																	else
																	{
																		$level_img="";
																	}
																	?>
																<tr valign="middle" bgcolor="ffffff" style='cursor:pointer;' onMouseOver="this.style.backgroundColor='#FAFAFA'" onMouseOut="this.style.backgroundColor=''" onclick="location.href='ask_view.php?data=<?=$data?>&boardIndex=<?=$boardIndex?>'">
																	<td height="22" width="30" align="center"><?=$letter_no?></td>
																	<td height="22" width="2" ></td>
																	<td height="22" width="<?=$__TITLE_WIDTH?>">&nbsp;<?=$level_img?> <?=StringCut($bbs_row[title],40)?> <?=$newImg?></td>
																	<td height="22" width="2" ></td>
																	<td height="22" width="75" align="center"><?=$bbs_row[name]?></td>
																	<td height="22" width="2" ></td>
																	<td height="22" width="75" align="center"><?=substr($bbs_row[writeday],0,10)?></td>
																	<td height="22" width="2"></td>
																	<td height="22" width="45" align="center"><?=$bbs_row[readnum]?></td>
																	<td height="22" width="2" align="center"></td><?
																	if(empty($bbs_row[up_file]))
																	{
																		?>
																	<td height="22" width="30" align="center">&nbsp;</td><?
																	}
																	else
																	{
																		?>
																	<td height="22" width="30" align="center"><img src="image/icon/icon_10.gif" width="12" height="12"></td><?
																	}
																	?>
																</tr><?
																	$letter_no--;
																}//while
																?><!-- 게시판 글목록 끝 --><?
																/****************************************************************************************************************************
																CList(char* pagename,int pagecnt,int offset,int numrows,int pageblock,int limit,char* search,char* searchstring,char* option)
																putList( BOOL pniView, char* pre_icon, char* next_icon)
																****************************************************************************************************************************/
																$Obj=new CList("ask_list.php",$pagecnt,$offset,$numrows,$PAGEBLOCK,$LIMIT,$search,$searchstring,"boardIndex=$boardIndex");
																?>
															</table>
														</td>
													</tr>
													<tr>
														<td height="2" bgcolor="#f4f4f4"></td>
													</tr>
													<tr>
														<td height='5'></td>
													</tr>
												</table><br>
												<table width='670' border='0' cellpadding='0' cellspacing='3' bgcolor='dde9f2'>
													<tr>
														<td height="50" bgcolor='FFFFFF'>
															<!-- 검색폼 시작 -->
															<form name="searchForm" action="ask_list.php" method="post" onSubmit="return searchSendit();">
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
												<table width='670' border='0' cellpadding='0' cellspacing='3'>
													<tr>
														<td height="25" align="center"><a href="ask_write.php"><img src="image/board/btn_write.gif" border="0"></a></td>
													</tr>
												</table>
											</td>
										</tr>
									</table><br>
								</td>
							</tr><!-- 일반게시판 끝 -->
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