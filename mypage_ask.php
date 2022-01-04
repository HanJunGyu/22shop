<?
include "head.php";
$member_row = $MySQL->fetch_array("select *from member where userid='$_SESSION[GOOD_SHOP_USERID]'");
?>
<SCRIPT LANGUAGE="JavaScript">
<!--
function ask_view(idx)
{
	window.open("goods_ask_view.php?idx="+idx,"","scrollbars=yes,width=620,height=400,top=50,left=300");
}
//-->
</SCRIPT>
<? include "top.php"; ?>
<table width="900" border="0" cellspacing="0" cellpadding="0" bgcolor="<?=$ALL_BGCOLOR?>">
	<tr>
		<? include "left_menu.php"; ?>
		<td valign="top" width="720" bgcolor="#ffffff">
			<table width="720" height="100%" border="0" cellspacing="0" cellpadding="0">
				<tr bgcolor="#FFFFFF" valign="top">
					<td colspan="2">
						<table width="720" height="30" border="0" cellspacing="0" cellpadding="0" align='center'>
							<tr>
								<td width="2" bgcolor="<?=$subdesign[bc5]?>" rowspan="2"></td>
								<td width="2" bgcolor="<?=$subdesign[bc5]?>" rowspan="2"></td>
								<td width="220" height="27" bgcolor="<?=$subdesign[bc5]?>"><img src="./upload/design/<?=$subdesign[img5]?>" ></td>
								<td width="490" height="27" bgcolor="<?=$subdesign[bc5]?>"><div align="right"> &nbsp;<font color="<?=$subdesign[tc5]?>"> <img src='image/good/icon0.gif'>&nbsp;현재위치 : HOME &gt; Mypage(마이페이지)&gt;나의질문내역 </font>&nbsp;</div></td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td valign="top"><br><? include "mypage_menu.php";?><br>
						<table border='0' width='670' cellpadding='0' cellspacing='0' align='center'>
							<tr>
								<td><img src='image/member/my_tit7.gif'></td>
							</tr>
						</table>
						<table width="670" border="0" cellspacing="0" cellpadding="0" align="center"><?
							$data=Decode64($data);
							$pagecnt=$data[pagecnt];
							$letter_no=$data[letter_no];
							$offset=$data[offset];
							$numresults_qry = "SELECT * from good_board WHERE userid='$_SESSION[GOOD_SHOP_USERID]'";
							$MySQL->query($numresults_qry);
							$numrows=$MySQL->is_affected();				//총 레코드수..
							$LIMIT		=15;								//페이지당 글 수
							$PAGEBLOCK	=10;								//블럭당 페이지 수
							if($pagecnt==""){$pagecnt=0;}						//페이지 번호 
							if(!$offset){$offset=$pagecnt*$LIMIT*$PAGEBLOCK;} //각 페이지의 시작 글  
							if(!$letter_no){$letter_no=$numrows;}				//글번호
							$bbs_qry = $numresults_qry." order by idx desc limit $offset,$LIMIT";
							$bbs_result=$MySQL->query($bbs_qry);
							$s_letter=$letter_no;								//페이지별 시작 글번호
							?>
							<tr>
								<td colspan="2" valign="top"><br>
									<!-- 주문 목록 시작 -->
									<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
										<tr>
											<td colspan="6">전체 [ <font color="#FF9900"><?=$numrows?></font> ]개<br></td>
										</tr>
										<tr>
											<td height="2" colspan="11" bgcolor="80c9d8"></td>
										</tr>
										<tr>
											<td height="1" colspan="11" bgcolor="ffffff"></td>
										</tr>
										<tr bgcolor="edf7f9" align="center">
											<td width="40" height=30><font color='006676'><b>번호</b></font></td>
											<td width='1'><img src='image/board/line.gif'></td>
											<td><font color='006676'><b>질문내용</b></font></td>
											<td width='1'><img src='image/board/line.gif'></td>
											<td width="100"><font color='006676'><b>글쓴이</b></font></td>
											<td width='1'><img src='image/board/line.gif'></td>
											<td width="100"><font color='006676'><b>날짜</b></font></td>
											<td width='1'><img src='image/board/line.gif'></td>
											<td width="50"><font color='006676'><b>조회</b></font></td>
											<td width='1'><img src='image/board/line.gif'></td>
											<td width="50"><font color='006676'><b>답글</b></font></td>
										</tr>
										<tr>
											<td height="1" colspan="11" align="center" bgcolor="ffffff"></td>
										</tr>
										<tr>
											<td height="1" colspan="11" align="center" bgcolor="80c9d8"></td>
										</tr><?
										$gb_cnt = mysql_num_rows($bbs_result);
										if ($gb_cnt)
										{
											while ($good_board_row = mysql_fetch_array($bbs_result))
											{
												$reply_num = $MySQL->articles("SELECT idx from good_board_comment WHERE boardidx=$good_board_row[idx]");
												$encode_str = "idx=".$bbs_row[idx]."&pagecnt=".$pagecnt."&letter_no=".$s_letter."&offset=".$offset;
												$encode_str.= "&search=".$search."&searchstring=".$searchstring."&present_num=".$letter_no;
												$data=Encode64($encode_str);					//각 레코드 정보 
												?>
										<tr style='cursor:pointer;' onMouseOver="this.style.backgroundColor='#F2F2F2'" onMouseOut="this.style.backgroundColor=''" onclick="javascript:ask_view(<?=$good_board_row[idx]?>);">
											<td align="center" height='25'><?=$letter_no?></td>
											<td width='1'></td>
											<td><?=$good_board_row[title]?></td>
											<td width='1'></td>
											<td align="center"><?=$good_board_row[name]?></td>
											<td width='1'></td>
											<td align="center"><?=substr($good_board_row[writeday],0,10)?></td>
											<td width='1'></td>
											<td align="center"><?=$good_board_row[readnum]?></td>
											<td width='1'></td>
											<td align="center"><?=$reply_num?></td>
										</tr>
										<tr>
											<td align="center" colspan="11" height="1" bgcolor='e1e1e1'></td>
										</tr><?
												$letter_no--; 
											}
										}
										else
										{
											// 상품질문 없을때
											?>
										<tr>
											<td colspan="11" height='35' align="center">해당 상품에 관련된 상품 Q&A가 없습니다.</td>
										</tr>
										<tr>
											<td align="center" colspan="11" height="1" bgcolor='e1e1e1'></td>
										</tr><?
										}
										$Obj=new CList("mypage_ask.php",$pagecnt,$offset,$numrows,$PAGEBLOCK,$LIMIT,"","","");
										?>
									</table><!-- 주문 목록 끝 -->
									<br>
									<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
										<tr>
											<td height="25" align="center"><?$Obj->putList(true,"<img src='image/board/btn_prev.gif'>","<img src='image/board/btn_next.gif'>");//이전다음 프린트?></td>
										</tr>
									</table>
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
</body>
</html>