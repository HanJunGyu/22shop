<?
include "head.php";
$member_row = $MySQL->fetch_array("select *from member where userid='$_SESSION[GOOD_SHOP_USERID]'");
?>
<? include "top.php";?>
<table width="900" border="0" cellspacing="0" cellpadding="0" bgcolor="<?=$ALL_BGCOLOR?>">
	<tr>
		<? include "left_menu.php";?>
		<td height="51" valign="top" width="720" bgcolor="#FFFFFF">
			<table width="720" height="100%" border="0" cellspacing="0" cellpadding="0">
				<tr bgcolor="#FFFFFF" valign="top">
					<td colspan="2" height="51">
						<table width="720" height="35" border="0" cellspacing="0" cellpadding="0" ailgn='center'>
							<tr>
								<td width="2"  bgcolor="<?=$subdesign[bc5]?>" rowspan="2"></td>
								<td width="2"  bgcolor="<?=$subdesign[bc5]?>" rowspan="2"></td>
								<td width="220" height="27" bgcolor="<?=$subdesign[bc5]?>"><img src="./upload/design/<?=$subdesign[img5]?>" ></td>
								<td width="490" height="27" bgcolor="<?=$subdesign[bc5]?>"><div align="right"> &nbsp;<font color="<?=$subdesign[tc5]?>"> <img src='image/good/icon0.gif'>&nbsp;현재위치 : HOME &gt; Mypage(마이페이지)&gt;적립금조회하기 </font>&nbsp;</div></td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td valign="top"><br><? include "mypage_menu.php";?><?
					$plus_point = $MySQL->fetch_array("select sum(point) from point_table where userid='$member_row[userid]' and point >0");
					$minus_point = $MySQL->fetch_array("select sum(point) from point_table where userid='$member_row[userid]' and point <0");?><br><br>
						<table border='0' width='670' cellpadding='0' cellspacing='0' align='center'>
							<tr>
								<td><img src='image/member/my_tit3.gif'></td>
							</tr>
						</table><br>
						<table width="670" border="0" cellspacing="0" cellpadding="0" align="center">
							<tr>
								<td bgcolor='80c9d8' height='2' colspan='2'></td>
							</tr>
							<tr>
								<td height="25" width="170" bgcolor="edf7f9"> &nbsp;<font color='006676'> 총 적립금</font></td>
								<td height="25" width='500' style='padding:0 0 0 30'><FONT  COLOR="#6600FF"><?=PriceFormat($plus_point[0])?></FONT> 원</td>
							</tr>
							<tr>
								<td height="1" colspan="2" bgcolor='e1e1e1'></td>
							</tr>
							<tr>
								<td height="25" width="170" bgcolor="edf7f9"> &nbsp;<font color='006676'> 사용한 적립금</font></td>
								<td height="25" style='padding:0 0 0 30'><FONT  COLOR="#CC0000"><?=PriceFormat(abs($minus_point[0]))?></FONT> 원</td>
							</tr>
							<tr>
								<td height="1" colspan="2" bgcolor='e1e1e1'></td>
							</tr>
							<tr>
								<td height="25" width="170" bgcolor="edf7f9"> &nbsp;<font color='006676'> 사용가능한 적립금</font></td>
								<td height="25" style='padding:0 0 0 30'><B><?=PriceFormat($member_row[point])?> 원</B></td>
							</tr>
							<tr>
								<td height="1" colspan="2" bgcolor='e1e1e1'></td>
							</tr>
							<tr>
								<td height="20" colspan="2" bgcolor="ffffff"></td>
							</tr>
							<tr>
								<td colspan="2">
									<table width="670" border="0" cellspacing="0" cellpadding="0" align="center"><?
										$data=Decode64($data);
										$pagecnt=$data[pagecnt];
										$letter_no=$data[letter_no];
										$offset=$data[offset];
										$numresults=$MySQL->query("select idx from point_table where userid='$_SESSION[GOOD_SHOP_USERID]'");
										$numrows=mysql_num_rows($numresults);				//총 레코드수..
										$LIMIT		=10;								//페이지당 글 수
										$PAGEBLOCK	=10;								//블럭당 페이지 수
										if($pagecnt==""){$pagecnt=0;}						//페이지 번호 
										if(!$offset){$offset=$pagecnt*$LIMIT*$PAGEBLOCK;} //각 페이지의 시작 글  
										if(!$letter_no){$letter_no=$numrows;}				//글번호
										$bbs_qry = "select * from point_table where userid='$_SESSION[GOOD_SHOP_USERID]' order by idx desc limit $offset,$LIMIT";
										?>
										<tr>
											<td height="30" colspan="2" bgcolor="#f4f4f4">&nbsp;&nbsp;<img src='image/member/icon_my.gif' align='absmiddle'><b> 적립금 내역</b></td>
										</tr>
										<tr>
											<td colspan="2" valign="top">
												<!-- 적립금 목록 시작 -->
												<table width="670" border="0" cellspacing="0" cellpadding="0" align="center">
													<tr>
														<td colspan="9" height='25'>전체 [ <font color="#FF9900"><?=$numrows?></font> ]개<br></td>
													</tr>
													<tr>
														<td height="2" colspan="9" bgcolor="80c9d8"></td>
													</tr>
													<tr>
														<td height="1" colspan="9" bgcolor="ffffff"></td>
													</tr>
													<tr bgcolor="#edf7f9">
														<td height="30" width="30" align="center"><font color='006676'><b>번호</b></font></td>
														<td width='1'><img src='image/board/line.gif'></td>
														<td height="30" width="30" align="center"><font color='006676'><b>구분</b></font></td>
														<td width='1'><img src='image/board/line.gif'></td>
														<td height="30" align="center" width="100"><font color='006676'><b>적립금</b></font></td>
														<td width='1'><img src='image/board/line.gif'></td>
														<td height="30" align="center"><font color='006676'><b>내역</b></font></td>
														<td width='1'><img src='image/board/line.gif'></td>
														<td height="30" width="100" align="center"><font color='006676'><b>발생일자</b></font></td>
													</tr>
													<tr>
														<td height="1" colspan="9" align="center" bgcolor="ffffff"></td>
													</tr>
													<tr>
														<td height="1" colspan="9" align="center" bgcolor="80c9d8"></td>
													</tr><?
													$bbs_result=$MySQL->query($bbs_qry);
													$s_letter=$letter_no;								//페이지별 시작 글번호
													while($bbs_row=mysql_fetch_array($bbs_result))
													{
														if ($bbs_row[part]=="회수") $bbs_row[part]="주문취소";
														if($bbs_row[point] >=0) $part ="<FONT COLOR='#6600FF'>$bbs_row[part]</FONT>";
														else $part ="<FONT COLOR='#CC0000'>$bbs_row[part]</FONT>";
														?>
													<tr>
														<td align="center" height="25" width="30"><?=$letter_no?></td>
														<td align="center" height="25" width="2">&nbsp;</td>
														<td align="center" height="25" width="30"><font color="#0000FF"><?=$part?></font></td>
														<td align="center" height="25" width="2">&nbsp;</td>
														<td align="right" height="25" width="100"><?=PriceFormat($bbs_row[point])?> 원</td>
														<td align="center" height="25" width="2">&nbsp;</td>
														<td align="center" height="25" width="282"><?=$bbs_row[reason]?></td>
														<td align="center" height="25" width="2">&nbsp;</td>
														<td align="center" height="25" width="100"><?=str_replace("-","/",substr($bbs_row[writeday],0,16))?></td>
													</tr>
													<tr>
														<td align="center" colspan="9" height="1" bgcolor='e1e1e1'></td>
													</tr><?
														$letter_no--;
													}
													$Obj=new CList("mypage_point.php",$pagecnt,$offset,$numrows,$PAGEBLOCK,$LIMIT,"","","");
													?>
												</table>
												<!-- 적립금 목록 끝 --><br>
												<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
													<tr>
														<td height="25" colspan="5" align="center"><?$Obj->putList(true,"<img src='image/board/btn_prev.gif'>","<img src='image/board/btn_next.gif'>");//이전다음 프린트?></td>
													</tr>
													<tr>
														<td height="1" colspan="9" bgcolor="ffffff"></td>
													</tr>
												</table>
												<br><br>
												<table width="100%" border="0" cellspacing="0" cellpadding="0" align='center'>
													<tr>
														<td bgcolor='dadfe5' height='1'></td>
													</tr>
													<tr>
														<td height="30" bgcolor='eff3f4' style='padding:0 0 0 10'><img src='image/index/icon_cate00.gif'> <font color='3d5b75'><b>적립금정보</b></font></td>
													</tr>
													<tr>
														<td bgcolor='dadfe5' height='1'></td>
													</tr>
													<tr>
														<td valign="top">
															<table width="100%" border="0" cellspacing="0" cellpadding="10">
																<tr>
																	<td>&nbsp;&nbsp;<img src="image/icon/icon_8.gif">적립금은 물건 구매시 <?
																	if($admin_row[poMethod]=="t")
																	{
																		?><b><?=PriceFormat($admin_row[poTotal])?></b>원 <?
																	}
																	else
																	{
																		echo"<B>$admin_row[poUnit]%</B>";
																	}
																	?> 씩 적립됩니다. <br><br>&nbsp;&nbsp;<img src="image/icon/icon_8.gif">결제금액이 <b><?=PriceFormat($admin_row[popayM])?></b>원이상 일때 적립금을 사용 할 수 있습니다.<br><br><?
																	if ($admin_row[poMaxunlimit])
																	{
																		?>&nbsp;&nbsp;<img src="image/icon/icon_8.gif">적립금이 <b><?=PriceFormat($admin_row[poMin])?></b>원이상 일때 사용 할 수 있습니다.<br><br><?
																	}
																	else
																	{
																		?>&nbsp;&nbsp;<img src="image/icon/icon_8.gif">적립금이 <b><?=PriceFormat($admin_row[poMin])?></b>원이상 <B><?=PriceFormat($admin_row[poMax])?></B>원이하에서 사용 할 수 있습니다.<br><br><?
																	}
																	?>&nbsp;&nbsp;<img src="image/icon/icon_8.gif">최초 회원가입시 <B><?=PriceFormat($admin_row[poReg])?></B>원의 적립금이 주어집니다.</td>
																</tr>
															</table>
														</td>
													</tr>
													<tr>
														<td bgcolor='dadfe5' height='1'></td>
													</tr>
												</table>
											</td>
										</tr>
									</table>
									<br><br><br><br>
								</td>
							</tr>
						</table>
						<br>
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