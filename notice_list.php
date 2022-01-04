<?
include "head.php";
?>
<? include "top.php";?>
<table width="900" border="0" cellspacing="0" cellpadding="0" bgcolor="<?=$ALL_BGCOLOR?>">
	<tr>
		<? include "left_menu.php";?>
		<td   valign="top" width="720" bgcolor="#FFFFFF">
			<table width="720" height="100%" border="0" cellspacing="0" cellpadding="0">
				<tr bgcolor="#FFFFFF" valign="top">
					<td colspan="2" >
						<table width="720"   border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td width="2"  bgcolor="<?=$subdesign[bc16]?>" rowspan="2"></td>
								<td width="2"  bgcolor="<?=$subdesign[bc16]?>" rowspan="2"></td>
								<td width="220" height="30" bgcolor="<?=$subdesign[bc16]?>"><img src="./upload/design/<?=$subdesign[img16]?>" ></td>
								<td width="490" height="30" bgcolor="<?=$subdesign[bc16]?>"><div align="right"> &nbsp;<font color="<?=$subdesign[tc16]?>"> <img src='image/good/icon0.gif'>&nbsp;현재위치 : <a href="index.php"><font color="<?=$subdesign[tc16]?>">HOME</a> &gt; 공지사항</font>&nbsp;</div></td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td valign="top" width="712">
						<table width="714" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td><?
								if ($subdesign[titimg16])
								{
									?><img src="./upload/design/<?=$subdesign[titimg16]?>" ><?
								}
								else
								{
									?><img src="image/work/notice.gif" ><?
								}
								?></td>
							</tr>
						</table>
						<table width="714" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td valign="top" align="center">
									<table width="670" border="0" cellspacing="0" cellpadding="0" align="center">
										<tr>
											<td height="2" colspan="9" bgcolor="#1a0050"></td>
										</tr>
										<tr valign="middle" bgcolor="#f8f8f8">
											<td width="10%" height="30" align="center"><img src='image/board/t_number.gif'></td>
											<td height="30" width="2"><img src="image/board/line.gif"></td>
											<td width="50%" height="30" align="center"><img src='image/board/t_subject.gif'></td>
											<td height="30" width="2"><img src="image/board/line.gif"></td>
											<td width="10%" height="30" align="center"><img src='image/board/t_sub.gif'></td>
											<td height="30" width="2"><img src="image/board/line.gif"></td>
											<td width="20%" height="30" align="center"><img src='image/board/t_date.gif'></td>
											<td height="30" width="2"><img src="image/board/line.gif"></td>
											<td width="10%" height="30" align="center"><img src='image/board/t_click.gif'></td>
										</tr>
										<tr>
											<td colspan="9" height="1" bgcolor='dddddd'></td>
										</tr><?
										$data=Decode64($data);
										$pagecnt=$data[pagecnt];
										$letter_no=$data[letter_no];
										$offset=$data[offset]; 
										$numresults=$MySQL->query("select idx from notice");
										$numrows=mysql_num_rows($numresults);				//총 레코드수..
										$LIMIT		=20;								//페이지당 글 수
										$PAGEBLOCK	=10;								//블럭당 페이지 수
										if($pagecnt==""){$pagecnt=0;}						//페이지 번호 
										if(!$offset){$offset=$pagecnt*$LIMIT*$PAGEBLOCK;} //각 페이지의 시작 글  
										if(!$letter_no){$letter_no=$numrows;}				//글번호
										$notice_result=$MySQL->query("select * from notice order by idx desc limit $offset,$LIMIT");
										$s_letter=$letter_no;								//페이지별 시작 글번호
										while($notice_row=mysql_fetch_array($notice_result))
										{
											if ($notice_row[gubun]=="M" && ($GOOD_SHOP_PART_GUBUN=="M" || $GOOD_SHOP_PART_GUBUN!="D")) $read_able = true;
											else if ($notice_row[gubun]=="D" && $GOOD_SHOP_PART_GUBUN=="D") $read_able = true;
											else if (empty($notice_row[gubun])) $read_able = true;
											else $read_able = false;
											if ($read_able)
											{
												$encode_str = "idx=".$notice_row[idx]."&pagecnt=".$pagecnt."&letter_no=".$s_letter."&offset=".$offset;
												$encode_str.= "&search=".$search."&searchstring=".$searchstring;
												$data=Encode64($encode_str);					//각 레코드 정보
												?>
										<tr valign="middle" bgcolor="ffffff" style="cursor:pointer" onMouseOver="this.style.backgroundColor='#EBEBEB'" onMouseOut="this.style.backgroundColor=''" onclick="location.href='notice_view.php?&idx=<?=$notice_row[idx]?>'">
											<td height="30" align="center"><?=$letter_no?></td>
											<td height="30" width="2" ></td>
											<td height="25">&nbsp;&nbsp;<?=$notice_row[title]?></td>
											<td height="30" width="2" ></td>
											<td height="25">&nbsp;&nbsp;<?
											if ($notice_row[part]=="notice") echo "공지";
											else if($notice_row[part]=="event") echo "이벤트";
											?></td>
											<td height="30" width="2" ></td>
											<td height="25" align="center"><?=substr($notice_row[writeday],0,10)?></td>
											<td height="30" width="2" ></td>
											<td height="25" align="center"><?=$notice_row[readNum]?></td>
										</tr>
										<tr>
											<td colspan="9" height="1" bgcolor='dddddd'></td>
										</tr><?
												$letter_no--;
											}
										}
										?><!-- 공지사항 목록 끝 --><?
										$Obj=new CList("notice_list.php",$pagecnt,$offset,$numrows,$PAGEBLOCK,$LIMIT,"","","part=$part");
										?>
										<tr valign="middle" bgcolor="ffffff">
											<td height="30" colspan="9">
												<table width="100%" border="0" align="center">
													<tr>
														<td height="25" align="center"><?$Obj->putList(true,"<img src='image/board/btn_prev.gif'>","<img src='image/board/btn_next.gif'>");//이전다음 프린트?></td>
													</tr>
												</table>
											</td>
										</tr>
									</table>
								</td>
							</tr>
						</table><!--공지사항 테이블 끝-->
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