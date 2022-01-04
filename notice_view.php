<?
include "head.php";
?>
<? include "top.php";?>
<table width="900" border="0" cellspacing="0" cellpadding="0" bgcolor="<?=$ALL_BGCOLOR?>">
	<tr>
		<? include "left_menu.php";?>
		<td  valign="top" width="720" bgcolor="#FFFFFF">
			<table width="720" height="100%" border="0" cellspacing="0" cellpadding="0" align='center'>
				<tr bgcolor="#FFFFFF" valign="top">
					<td colspan="2" >
						<table width="720"   border="0" cellspacing="0" cellpadding="0" align='center'>
							<tr>
								<td width="2"  bgcolor="<?=$subdesign[bc16]?>" rowspan="2"></td>
								<td width="2"  bgcolor="<?=$subdesign[bc16]?>" rowspan="2"></td>
								<td width="220" height="30" bgcolor="<?=$subdesign[bc16]?>"><img src="./upload/design/<?=$subdesign[img16]?>" ></td>
								<td width="490" height="30" bgcolor="<?=$subdesign[bc16]?>"><div align="right"> &nbsp;<font color="<?=$subdesign[tc16]?>"> &nbsp;현재위치 : <a href="index.php"><font color="<?=$subdesign[tc16]?>">HOME</a> &gt; 공지사항</font>&nbsp;</div></td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td valign="top" width="720">
						<table width="720" border="0" cellspacing="0" cellpadding="0" align='center'>
							<tr>
								<td><img src="image/work/notice.gif" ></td>
							</tr>
						</table>
						<!-- 공지사항 보기 시작 -->
						<table width="670" border="0" cellspacing="0" cellpadding="0" align='center'><?
						$notice_row = $MySQL->fetch_array("select * from notice where idx=$idx");
						$MySQL->query("update notice set readNum=readNum +1 where idx=$idx"); //조회수 증가
						if(!$notice_row[app]) $content = str_replace("\n","<br>", htmlspecialchars($notice_row[content]));
						else $content = $notice_row[content];
						?>
							<tr>
								<td height="25">
									<table width="100%" border="0" cellspacing="0" cellpadding="10">
										<tr>
											<td align="right">&nbsp;&nbsp;<font color="#279DC4"><?=str_replace("-","/",substr($notice_row[writeday],0,10))?></font></td>
										</tr>
									</table>
								</td>
							</tr>
							<tr>
								<td height='2' bgcolor='1a0050'></td>
							</tr>
							<tr>
								<td>
									<table width="670" border="0" cellspacing="0" cellpadding="0" height="30">
										<tr>
											<td width="100" bgcolor="f8f8f8"><div align="center"><img src='image/board/t_subject.gif'></div></td>
											<td width='1' bgcolor='dddddd'></td>
											<td><font color="00469C">&nbsp;&nbsp;<B><?=$notice_row[title]?></B></font></td>
										</tr>
									</table>
								</td>
							</tr>
							<tr>
								<td bgcolor="dddddd" height="1"></td>
							</tr>
							<tr>
								<td valign="top"><!--목록 타이틀과 내용 나오는 테이블 시작-->
									<table width="100%" border="0" cellspacing="0" cellpadding="15" bgcolor="#E7E7E7" align="center">
										<tr>
											<td valign="top" bgcolor="fafafa"><?=$content?></td>
										</tr>
									</table><!--목록 타이틀과 내용 나오는 테이블 끝-->
								</td>
							</tr>
							<tr>
								<td bgcolor="dddddd" height="1"></td>
							</tr>
							<tr valign="middle" bgcolor="ffffff">
								<td height="80" colspan="8">
									<table width="100%" border="0" align="center">
										<tr>
											<td height="25" align="center"><a href="notice_list.php"><img src="image/board/btn_list.gif"
											border="0" alt="목록으로"></a></td>
										</tr>
									</table>
								</td>
							</tr>
						</table>
						<!-- 공지사항 보기 끝 -->
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>
<? include "copy.php"; ?>
</body>
</html>