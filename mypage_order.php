<?
// 소스형상관리
// 20060720-1 소스수정 김성호 : 결제방식 정보 세분화(카드, 핸드폰, 계좌이체, 가상계좌, 무통장)
include "head.php";
$member_row = $MySQL->fetch_array("select *from member where userid='$_SESSION[GOOD_SHOP_USERID]'");
?>
<? include "top.php";?>
<table width="900" border="0" cellspacing="0" cellpadding="0" bgcolor="<?=$ALL_BGCOLOR?>">
	<tr>
		<? include "left_menu.php";?>
		<td valign="top" width="720" bgcolor="#ffffff">
			<table width="720" height="100%" border="0" cellspacing="0" cellpadding="0">
				<tr bgcolor="#FFFFFF" valign="top">
					<td colspan="2">
						<table width="720" height="30" border="0" cellspacing="0" cellpadding="0" align='center'>
							<tr>
								<td width="2"  bgcolor="<?=$subdesign[bc5]?>" rowspan="2"></td>
								<td width="2"  bgcolor="<?=$subdesign[bc5]?>" rowspan="2"></td>
								<td width="220" height="27" bgcolor="<?=$subdesign[bc5]?>"><img src="./upload/design/<?=$subdesign[img5]?>" ></td>
								<td width="490" height="27" bgcolor="<?=$subdesign[bc5]?>"><div align="right"> &nbsp;<font color="<?=$subdesign[tc5]?>"> <img src='image/good/icon0.gif'>&nbsp;현재위치 : HOME &gt; Mypage(마이페이지)&gt;주문내역조회하기</font>&nbsp;</div></td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td valign="top"><br><? include "mypage_menu.php";?><br><br>
						<table border='0' width='670' cellpadding='0' cellspacing='0' align='center'>
							<tr>
								<td><img src='image/member/my_tit2.gif'></td>
							</tr>
						</table>
						<table width="670" border="0" cellspacing="0" cellpadding="0" align="center"><?
							$data=Decode64($data);
							$pagecnt=$data[pagecnt];
							$letter_no=$data[letter_no];
							$offset=$data[offset];
							$numresults_qry = "select * from trade where userid='$_SESSION[GOOD_SHOP_USERID]' and bPay=1";
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
							$colspan = 13;
							?>
							<tr>
								<td colspan="2" valign="top"><br>
									<!-- 주문목록 시작 -->
									<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
										<tr>
											<td colspan="<?=$colspan?>">전체 [ <font color="#FF9900"><?=$numrows?></font> ]개<br></td>
										</tr>
										<tr>
											<td height="2" colspan="<?=$colspan?>" bgcolor="80C9D8"></td>
										</tr>
										<tr>
											<td height="1" colspan="<?=$colspan?>" bgcolor="FFFFFF"></td>
										</tr>
										<tr align="center" bgcolor="#EDF7F9">
											<td height="30" width="30"><font color='006676'><b>번호</b></font></td>
											<td width='1'><img src='image/board/line.gif'></td>
											<td width="70"><font color='006676'><b>주문일</b></font></td>
											<td width='1'><img src='image/board/line.gif'></td>
											<td width="130" ><font color='006676'><b>주문코드</b></font></td>
											<td width='1'><img src='image/board/line.gif'></td>
											<td><font color='006676'><b>결제금액</b></font></td>
											<td width='1'><img src='image/board/line.gif'></td>
											<td width="100"><font color='006676'><b>배송방법</b></font></td>
											<td width='1'><img src='image/board/line.gif'></td>
											<td width="80"><font color='006676'><b>결제방법</b></font></td>
											<td width='1'><img src='image/board/line.gif'></td>
											<td width="80"><font color='006676'><b>주문상태</b></font></td>
										</tr>
										<tr>
											<td height="1" colspan="<?=$colspan?>" align="center" bgcolor="ffffff"></td>
										</tr>
										<tr>
											<td height="1" colspan="<?=$colspan?>" align="center" bgcolor="80c9d8"></td>
										</tr><?
										while($bbs_row=mysql_fetch_array($bbs_result))
										{
											$encode_str = "idx=".$bbs_row[idx]."&pagecnt=".$pagecnt."&letter_no=".$s_letter."&offset=".$offset;
											$encode_str.= "&search=".$search."&searchstring=".$searchstring."&present_num=".$letter_no;
											$data=Encode64($encode_str);					//각 레코드 정보
											if($bbs_row[payMethod] =="card") $payMethod="카드결제";
											elseif($bbs_row[payMethod] =="hand") $payMethod="휴대폰";
											elseif($bbs_row[payMethod] =="iche") $payMethod="계좌이체";
											elseif($bbs_row[payMethod] =="cyber") $payMethod="가상계좌";
											elseif($bbs_row[payMethod] =="bank") $payMethod="무통장";
											?>
										<tr height="30" align="center" bgcolor="ffffff" style='cursor:pointer;' onMouseOver="this.style.backgroundColor='#F2F2F2'" onMouseOut="this.style.backgroundColor=''" onclick="location.href='mypage_order_detail.php?data=<?=$data?>'">
											<td><?=$letter_no?></td>
											<td width='1'></td>
											<td><?=str_replace("-","/",substr($bbs_row[writeday],0,10))?></td>
											<td width='1'></td>
											<td><B><?=$bbs_row[tradecode]?></B></td>
											<td width='1'></td>
											<td><b><FONT  COLOR="#ff4800"><?=PriceFormat($bbs_row[payM])?> 원</FONT></b></td>
											<td width='1'></td>
											<td><?
												if ($bbs_row[transMethod]=="T") echo "택배";
												else if ($bbs_row[transMethod]=="K") echo "경동화물";
												else if ($bbs_row[transMethod]=="Q") echo "퀵배송";
												else echo "&nbsp;";
												?></td>
											<td width='1'></td>
											<td><?=$payMethod?></td>
											<td width='1'></td>
											<td><?
											$tg_row=$MySQL->fetch_array("select status from trade_goods where tradecode='$bbs_row[tradecode]' limit 1");
											if ($tg_row[status]==0) $st_str = "주문접수";
											else if ($tg_row[status]==1) $st_str = "<font color=brown>".$TRADE_ARR[$tg_row[status]]."</font>";
											else if ($tg_row[status]==2) $st_str = "<font color=blue>".$TRADE_ARR[$tg_row[status]]."</font>";
											else if ($tg_row[status]==3) $st_str = "<font color=green>".$TRADE_ARR[$tg_row[status]]."</font>";
											else if ($tg_row[status]==4) $st_str = "<font color=red>".$TRADE_ARR[$tg_row[status]]."</font>";
											else if ($tg_row[status]==5) $st_str = "<font color=red>".$TRADE_ARR[$tg_row[status]]."</font>";
											else $st_str ="&nbsp;";
											?><?=$st_str?></td>
										</tr>
										<tr>
											<td align="center" colspan="<?=$colspan?>" height="1" background="image/index/dot_width.gif"></td>
										</tr><?
											$letter_no--;
										}
										$Obj=new CList("mypage_order.php",$pagecnt,$offset,$numrows,$PAGEBLOCK,$LIMIT,"","","");
										?>
									</table>
									<br>
									<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
										<tr>
											<td height="25" colspan="5" align="center"><?$Obj->putList(true,"<img src='image/board/btn_prev.gif'>","<img src='image/board/btn_next.gif'>");//이전다음 프린트?></td>
										</tr>
										<tr>
											<td height="1" colspan="9" bgcolor="ffffff"></td>
										</tr>
									</table>
									<br><br>
									<table width="670" border="0" cellspacing="0" cellpadding="0" align='center'>
										<tr>
											<td bgcolor='dadfe5' height='1'></td>
										</tr>
										<tr>
											<td height="30" bgcolor='eff3f4' style='padding:0 0 0 10'><img src='image/index/icon_cate00.gif'> <font color='3d5b75'><b>주문내역조회</b></font></td>
										</tr>
										<tr>
											<td bgcolor='dadfe5' height='1'></td>
										</tr>
										<tr>
											<td valign="top">
												<table width="670" border="0" cellspacing="0" cellpadding="10">
													<tr>
														<td>&nbsp;&nbsp;<img src="image/icon/icon_8.gif">&nbsp;더 자세한 정보를 알고 싶으시면 주문코드를 누르시면 됩니다.<br>&nbsp;&nbsp;<img src="image/icon/icon_8.gif">&nbsp;번호<br>&nbsp;&nbsp;&nbsp;&nbsp;최근 주문한 목록이 상위부터 나열됩니다.<br>&nbsp;&nbsp;&nbsp;&nbsp;- 주문번호<br>&nbsp;&nbsp;&nbsp;&nbsp;- 주문시 자동생성된 번호로 알아두시면 나중에 확인하시기 편리합니다.<br>&nbsp;&nbsp;<img src="image/icon/icon_8.gif">&nbsp;배송중<br>&nbsp;&nbsp;&nbsp;&nbsp;- 배송중인 상품은 결제를 확인하고 지금 배송이 시작된 상태 입니다.<br>&nbsp;&nbsp;&nbsp;&nbsp;- 단, 일부상품의 경우 제조업체의 사정에 따라 배송이 다소 늦어질 수 있음을 알려드립니다.<br>&nbsp;&nbsp;<img src="image/icon/icon_8.gif">&nbsp;배송완료<br>&nbsp;&nbsp;&nbsp;&nbsp;- 배송완료중인 상품은 이미 배송이 완료된 상태 입니다. 아직 못 받으셨다면 고객센터로 연락 주세요</td>
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