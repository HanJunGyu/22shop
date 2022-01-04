<?
// 소스형상관리
// 20060714_1 소스수정 최호수 (통계 프로그램 수정으로 인한 소스 수정)
/*************************************************
관리자 왼쪽 소메뉴 ($__TOP_MENU)

basic		: 기본정보
order		: 주문관리
goods		: 상품관리
category	: 카테고리
member		: 회원관리
design		: 디자인관리
sale		: 매출통계
gm_counter	: 접속통계 수정
page		: 사용자정의페이지
news		: 공지사항
board		: 게시판
ask			: 1:1문의게시판
sms			: SMS관리
이미지업로드(새창)
admmail		: 관리자메일
help		: 고객지원센터
**************************************************/
?>
		<td valign="top" bgcolor='EFF2F3' width='170'>
			<table width='170' border="0" cellspacing="0" cellpadding="0" align="center">
				<tr>
					<td height='15'></td>
				</tr>
				<tr><?
				if($__TOP_MENU=="basic")
				{
					?>
					<td width="170" valign="top">
						<table width="160" border="0" cellspacing="0" cellpadding="0" align="center">
							<tr>
								<td background='image/left_line.gif' height='2'></td>
							</tr>
							<tr>
								<td height='30'>&nbsp;&nbsp;<img src="image/left_icon.gif"> <a href='adm.php'>관리자 기본정보</a></td>
							</tr>
							<tr>
								<td background='image/left_line.gif' height='2'></td>
							</tr>
							<tr>
								<td height='30'>&nbsp;&nbsp;<img src="image/left_icon.gif"> <a href='adm_account.php'>전자결제 설정</a></td>
							</tr>
							<tr>
								<td background='image/left_line.gif' height='2'></td>
							</tr>
							<tr>
								<td height='30'>&nbsp;&nbsp;<img src="image/left_icon.gif"> <a href='adm_trans.php'>배송 설정</a></td>
							</tr>
							<tr>
								<td background='image/left_line.gif' height='2'></td>
							</tr>
							<tr>
								<td height='30'>&nbsp;&nbsp;<img src="image/left_icon.gif"> <a href='adm_use.php'>이용안내 설정</a></td>
							</tr>
							<tr>
								<td background='image/left_line.gif' height='2'></td>
							</tr>
							<tr>
								<td height='30'>&nbsp;&nbsp;<img src="image/left_icon.gif"> <a href='adm_etc.php'>메일 및 목록 설정</a></td>
							</tr>
							<tr>
								<td background='image/left_line.gif' height='2'></td>
							</tr>
							<tr>
								<td height='30'>&nbsp;&nbsp;<img src="image/left_icon.gif"> <a href='adm_reset.php'>몰 초기화 관리</a></td>
							</tr>
							<tr>
								<td background='image/left_line.gif' height='2'></td>
							</tr>
							<tr>
								<td height='30'>&nbsp;&nbsp;<img src="image/left_icon.gif"> <a href='adm_etc2.php'>기타 설정</a></td>
							</tr>
							<tr>
								<td background='image/left_line.gif' height='2'></td>
							</tr>
						</table>
					</td><?
				}
				else if($__TOP_MENU=="order")
				{
					?>
					<td width="170" valign="top">
						<table width="160" border="0" cellspacing="0" cellpadding="0" align="center">
							<tr>
								<td background='image/left_line.gif' height='2'></td>
							</tr>
							<tr>
								<td height='30'>&nbsp;&nbsp;<img src="image/left_icon.gif"> <a href='trade_order.php'>주문통합 목록</a></td>
							</tr>
							<tr>
								<td background='image/left_line.gif' height='2'></td>
							</tr>
							<tr>
								<td height='30'>&nbsp;&nbsp;<img src="image/left_icon.gif"> <a href='trade_order.php?status=0'><?=$TRADE_ARR[0]?> 목록</a></td>
							</tr>
							<tr>
								<td background='image/left_line.gif' height='2'></td>
							</tr>
							<tr>
								<td height='30'>&nbsp;&nbsp;<img src="image/left_icon.gif"> <a href='trade_order.php?status=1'><?=$TRADE_ARR[1]?> 목록</a></td>
							</tr>
							<tr>
								<td background='image/left_line.gif' height='2'></td>
							</tr>
							<tr>
								<td height='30'>&nbsp;&nbsp;<img src="image/left_icon.gif"> <a href='trade_order.php?status=2'><?=$TRADE_ARR[2]?> 목록</a></td>
							</tr>
							<tr>
								<td background='image/left_line.gif' height='2'></td>
							</tr>
							<tr>
								<td height='30'>&nbsp;&nbsp;<img src="image/left_icon.gif"> <a href='trade_order.php?status=3'><?=$TRADE_ARR[3]?> 목록</a></td>
							</tr>
							<tr>
								<td background='image/left_line.gif' height='2'></td>
							</tr>
							<tr>
								<td height='30'>&nbsp;&nbsp;<img src="image/left_icon.gif"> <a href='trade_order.php?status=4'><?=$TRADE_ARR[4]?> 목록</a></td>
							</tr>
							<tr>
								<td background='image/left_line.gif' height='2'></td>
							</tr>
							<tr>
								<td height='30'>&nbsp;&nbsp;<img src="image/left_icon.gif"> <a href='trade_order.php?status=5'><?=$TRADE_ARR[5]?> 목록</a></td>
							</tr>
							<tr>
								<td background='image/left_line.gif' height='2'></td>
							</tr>
						</table>
					</td><?
				}
				else if($__TOP_MENU=="goods")
				{
					?>
					<td width="170" valign="top">
						<table width="160" border="0" cellspacing="0" cellpadding="0" align="center">
							<tr>
								<td background='image/left_line.gif' height='2'></td>
							</tr>
							<tr>
								<td height='30'>&nbsp;&nbsp;<img src="image/left_icon.gif"> <a href='goods_position.php'>특정위치등록</a></td>
							</tr>
							<tr>
								<td background='image/left_line.gif' height='2'></td>
							</tr>
							<tr>
								<td height='30'>&nbsp;&nbsp;<img src="image/left_icon.gif"> <a href='total_goods_list.php'>상품목록</a></td>
							</tr>
							<tr>
								<td background='image/left_line.gif' height='2'></td>
							</tr>
							<tr>
								<td height='30'>&nbsp;&nbsp;<img src="image/left_icon.gif"> <a href='design_good_a.php'>상품목록 디자인<br>(디자인 관리메뉴 바로가기)</a></td>
							</tr>
							<tr>
								<td background='image/left_line.gif' height='2'></td>
							</tr>
							<tr>
								<td height='30'>&nbsp;&nbsp;<img src="image/left_icon.gif"> <a href='goods_comment.php'>상품평 관리</a></td>
							</tr>
							<tr>
								<td background='image/left_line.gif' height='2'></td>
							</tr>
							<tr>
								<td height='30'>&nbsp;&nbsp;<img src="image/left_icon.gif"> <a href='goods_ask.php'>상품문의</a></td>
							</tr>
							<tr>
								<td background='image/left_line.gif' height='2'></td>
							</tr>
							<tr>
								<td height='30'>&nbsp;&nbsp;<img src="image/left_icon.gif"> <a href='goods_manage.php'>상품설정 관리</a></td>
							</tr>
							<tr>
								<td background='image/left_line.gif' height='2'></td>
							</tr>
							<tr>
								<td height='30'>&nbsp;&nbsp;<img src="image/left_icon.gif"> <a href='goods_excel.php'>상품엑셀등록</a></td>
							</tr>
							<tr>
								<td background='image/left_line.gif' height='2'></td>
							</tr>
							<tr>
								<td><br>
									<table width="90%" border="0" cellspacing="0" cellpadding="0" align="center" bgcolor="#FFFFFF">
										<tr>
											<td><?
											$left_menu_cate_result = $MySQL->query("select name,code,bHide from category order by position asc");
											$cnt = 0;
											while($left_menu_cate_row = mysql_fetch_array($left_menu_cate_result))
											{
												if($left_menu_cate_row[bHide]) echo "<font color=red>숨김기능적용</font>";
												?><a href="total_goods_list.php?code=<?=$left_menu_cate_row[code]?>"><b><?=$left_menu_cate_row[name]?></b></a><br><br><?
												$cnt++;
											}
											?>
											</td>
										</tr>
									</table>
								</td>
							</tr>
						</table>
					</td><?
				}
				else if($__TOP_MENU=="category")
				{
					?>
					<td width="170" valign="top">
						<table width="160" border="0" cellspacing="0" cellpadding="0" align="center">
							<tr>
								<td background='image/left_line.gif' height='2'></td>
							</tr>
							<tr>
								<td height='30'>&nbsp;&nbsp;<img src="image/left_icon.gif"> <a href='category_manage.php'>카테고리 관리</a></td>
							</tr>
							<tr>
								<td background='image/left_line.gif' height='2'></td>
							</tr>
							<tr>
								<td height='30'>&nbsp;&nbsp;<img src="image/left_icon.gif"> <a href='category_write.php'>카테고리 등록</a></td>
							</tr>
							<tr>
								<td background='image/left_line.gif' height='2'></td>
							</tr>
							<tr>
								<td height='30'>&nbsp;&nbsp;<img src="image/left_icon.gif"> <a href='category_position.php'>카테고리 순위</a></td>
							</tr>
							<tr>
								<td background='image/left_line.gif' height='2'></td>
							</tr>
							<tr>
								<td valign="top" align="center"><br>
									<table width="90%" border="0" cellspacing="0" cellpadding="4" align="center" bgcolor="#ffffff">
										<tr>
											<td><?
											$left_menu_cate_result = $MySQL->query("select name,code,bHide from category order by position asc");
											$cnt = 0;
											while($left_menu_cate_row = mysql_fetch_array($left_menu_cate_result))
											{
												if($left_menu_cate_row[bHide]) echo "<font color=red>숨김기능적용</font>";
												?><a href="category_edit.php?parentcode=<?=$left_menu_cate_row[code]?>"><b><?=$left_menu_cate_row[name]?></b></a><br><br><?
												$cnt++;
											}
											?>
											</td>
										</tr>
									</table>
								</td>
							</tr>
						</table>
					</td><?
				}
				else if($__TOP_MENU=="member")
				{
					?>
					<td width="170" valign="top">
						<table width="160" border="0" cellspacing="0" cellpadding="0" align="center">
							<tr>
								<td background='image/left_line.gif' height='2'></td>
							</tr>
							<tr>
								<td height='30'>&nbsp;&nbsp;<img src="image/left_icon.gif"> <a href='member_list.php'>회원목록</a></td>
							</tr>
							<tr>
								<td background='image/left_line.gif' height='2'></td>
							</tr>
							<tr>
								<td height='30'>&nbsp;&nbsp;<img src="image/left_icon.gif"> <a href='member_sendmail.php'>회원전체 메일보내기</a></td>
							</tr>
							<tr>
								<td background='image/left_line.gif' height='2'></td>
							</tr>
							<tr>
								<td height='30'>&nbsp;&nbsp;<img src="image/left_icon.gif"> <a href='mailing_list.php'>발송메일 현황</a></td>
							</tr>
							<tr>
								<td background='image/left_line.gif' height='2'></td>
							</tr>
							<tr>
								<td height='30'>&nbsp;&nbsp;<img src="image/left_icon.gif"> <a href='member_sms.php'>회원전체 SMS보내기</a></td>
							</tr>
							<tr>
								<td background='image/left_line.gif' height='2'></td>
							</tr>
						</table>
					</td><?
				}
				else if($__TOP_MENU=="design")
				{
					?>
					<td width="170" valign="top">
						<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
							<tr>
								<td background='image/left_line.gif' height='2'></td>
							</tr>
							<tr>
								<td height='30'>&nbsp;&nbsp;<img src="image/left_icon.gif"> <a href='design.php'>메인화면</a></td>
							</tr>
							<tr>
								<td background='image/left_line.gif' height='2'></td>
							</tr>
							<tr>
								<td height='30'>&nbsp;&nbsp;<img src="image/left_icon.gif"> <a href='design_good.php'>상품 목록</a></td>
							</tr>
							<tr>
								<td background='image/left_line.gif' height='2'></td>
							</tr>
							<tr>
								<td height='30'>&nbsp;&nbsp;<img src="image/left_icon.gif"> <a href='design_sub.php'>서브 페이지</a></td>
							</tr>
							<tr>
								<td background='image/left_line.gif' height='2'></td>
							</tr>
							<tr>
								<td height='30'>&nbsp;&nbsp;<img src="image/left_icon.gif"> <a href='design_join.php'>회원가입</a></td>
							</tr>
							<tr>
								<td background='image/left_line.gif' height='2'></td>
							</tr>
							<tr>
								<td height='30'>&nbsp;&nbsp;<img src="image/left_icon.gif"> <a href='design_wing.php'>양 측면 레이어베너</a></td>
							</tr>
							<tr>
								<td background='image/left_line.gif' height='2'></td>
							</tr>
							<tr>
								<td height='30'>&nbsp;&nbsp;<img src="image/left_icon.gif"> <a href='design_community.php'>커뮤니티</a></td>
							</tr>
							<tr>
								<td background='image/left_line.gif' height='2'></td>
							</tr>
							<tr>
								<td height='30'>&nbsp;&nbsp;<img src="image/left_icon.gif"> <a href='design_new.php'>신규상품전</a></td>
							</tr>
							<tr>
								<td background='image/left_line.gif' height='2'></td>
							</tr>
							<tr>
								<td></td>
							</tr>
						</table>
					</td><?
				}
				else if($__TOP_MENU=="sale")
				{
					?>
					<td width="170" valign="top">
						<table width="160" border="0" cellspacing="0" cellpadding="0" align="center">
							<tr>
								<td background='image/left_line.gif' height='2'></td>
							</tr>
							<tr>
								<td height='30'>&nbsp;&nbsp;<img src="image/left_icon.gif"> <a href='sale_status.php'>일반 통계</a></td>
							</tr>
							<tr>
								<td background='image/left_line.gif' height='2'></td>
							</tr>
							<tr>
								<td height='30'>&nbsp;&nbsp;<img src="image/left_icon.gif"> <a href='sale_status_day.php'>일일 통계</a></td>
							</tr>
							<tr>
								<td background='image/left_line.gif' height='2'></td>
							</tr>
							<tr>
								<td height='30'>&nbsp;&nbsp;<img src="image/left_icon.gif"> <a href='sale_status_month.php'>월간 통계</a></td>
							</tr>
							<tr>
								<td background='image/left_line.gif' height='2'></td>
							</tr>
							<tr>
								<td height='30'>&nbsp;&nbsp;<img src="image/left_icon.gif"> <a href='sale_status_year.php'>년간 통계</a></td>
							</tr>
							<tr>
								<td background='image/left_line.gif' height='2'></td>
							</tr>
							<tr>
								<td height='30'>&nbsp;&nbsp;<img src="image/left_icon.gif"> <a href='sale_status_all.php'>특정기간 통계</a></td>
							</tr>
							<tr>
								<td background='image/left_line.gif' height='2'></td>
							</tr>
							<tr>
								<td>&nbsp;</td>
							</tr>
						</table>
					</td><?
				}
				else if($__TOP_MENU=="gm_counter")
				{
					?>
					<td width="170" valign="top">
						<table width="160" border="0" cellspacing="0" cellpadding="0" align="center">
							<tr>
								<td background='image/left_line.gif' height='2'></td>
							</tr>
							<tr>
								<td height='30'>&nbsp;&nbsp;<img src="image/left_icon.gif"> <a href='gm_counter.php'>일반통계</a></td>
							</tr>
							<tr>
								<td background='image/left_line.gif' height='2'></td>
							</tr>
							<tr>
								<td height='30'>&nbsp;&nbsp;<img src="image/left_icon.gif"> <a href='gm_counter_time.php'>시간통계</a></td>
							</tr>
							<tr>
								<td background='image/left_line.gif' height='2'></td>
							</tr>
							<tr>
								<td height='30'>&nbsp;&nbsp;<img src="image/left_icon.gif"> <a href='gm_counter_week.php'>주간통계</a></td>
							</tr>
							<tr>
								<td background='image/left_line.gif' height='2'></td>
							</tr>
							<tr>
								<td height='30'>&nbsp;&nbsp;<img src="image/left_icon.gif"> <a href='gm_counter_referer.php'>접속경로</a></td>
							</tr>
							<tr>
								<td background='image/left_line.gif' height='2'></td>
							</tr>
							<tr>
								<td height='30'>&nbsp;&nbsp;<img src="image/left_icon.gif"> <a href='gm_counter_brower.php'>브라우저</a></td>
							</tr>
							<tr>
								<td background='image/left_line.gif' height='2'></td>
							</tr>
							<tr>
								<td height='30'>&nbsp;&nbsp;<img src="image/left_icon.gif"> <a href='gm_counter_os.php'>시스템</a></td>
							</tr>
							<tr>
								<td background='image/left_line.gif' height='2'></td>
							</tr>
						</table>
					</td><?
				}
				else if($__TOP_MENU=="page")
				{
					?>
					<td width="170" valign="top">
						<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
							<tr>
								<td>&nbsp;</td>
							</tr>
						</table>
					</td><?
				}
				else if($__TOP_MENU=="news")
				{
					?>
					<td width="170" valign="top">
						<table width="160" border="0" cellspacing="0" cellpadding="0" align="center">
							<tr>
								<td background='image/left_line.gif' height='2'></td>
							</tr>
							<tr>
								<td height='30'>&nbsp;&nbsp;<img src="image/left_icon.gif"> <a href='notice_list.php?part=notice'>공지사항</a></td>
							</tr>
							<tr>
								<td background='image/left_line.gif' height='2'></td>
							</tr>
							<tr>
								<td height='30'>&nbsp;&nbsp;<img src="image/left_icon.gif"> <a href='notice_list.php?part=event'>이벤트</a></td>
							</tr>
							<tr>
								<td background='image/left_line.gif' height='2'></td>
							</tr>
							<tr>
								<td height='30'>&nbsp;&nbsp;<img src="image/left_icon.gif"> <a href='poll_list.php'>설문조사</a></td>
							</tr>
							<tr>
								<td background='image/left_line.gif' height='2'></td>
							</tr>
						</table>
					</td><?
				}
				else if($__TOP_MENU=="board")
				{
					?>
					<td width="170" valign="top">
						<table width="160" border="0" cellspacing="0" cellpadding="0" align="center">
							<tr>
								<td background='image/left_line.gif' height='2'></td>
							</tr>
							<tr>
								<td height='30'>&nbsp;&nbsp;<img src="image/left_icon.gif"> <a href='bbs_admin_list.php'>게시판 관리</a></td>
							</tr>
							<tr>
								<td background='image/left_line.gif' height='2'></td>
							</tr>
							<tr>
								<td height="5" align="center">&nbsp;</td>
							</tr>
							<tr>
								<td valign="top" align="center">
									<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center" bgcolor="#FFFFFF"><?
									$left_menu_bbs_today = date("Y-m-d");
									$left_menu_bbs_result =$MySQL->query("select *from bbs_list where gubun<>'B' order by idx asc");
									while($left_menu_bbs_row=mysql_fetch_array($left_menu_bbs_result))
									{
										$bbs_num = $MySQL->articles("SELECT idx from bbs_data WHERE code='$left_menu_bbs_row[code]'");
										$bbs_new_num = $MySQL->articles("SELECT idx from bbs_data WHERE code='$left_menu_bbs_row[code]' and left(writeday,10)='$left_menu_bbs_today' limit 1");
										if($bbs_new_num) $newImg = "<img src='../image/icon/icon_new.gif' width='30' height='10'>";
										else $newImg = "";
										?>
										<tr>
											<td height="30" ><img src="image/icon.gif" width="11" height="11"> <a href="bbs_list.php?code=<?=$left_menu_bbs_row[code]?>"><u><font color="#000099"><?=$left_menu_bbs_row[name]?></font></a> [<?=$bbs_num?>] <?=$newImg?></td>
										</tr><?
									}
									?>
									</table>
								</td>
							</tr>
						</table>
					</td><?
				}
				else if($__TOP_MENU=="ask")
				{
					?>
					<td width="170" valign="top">
						<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
							<tr>
								<td>&nbsp;</td>
							</tr>
						</table>
					</td><?
				}
				else if($__TOP_MENU=="sms")
				{
					?>
					<td width="170" valign="top">
						<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
							<tr>
								<td>&nbsp;</td>
							</tr>
						</table>
					</td><?
				}
				else if($__TOP_MENU=="admmail")
				{
					?>
					<td width="170" valign="top">
						<table width="160" border="0" cellspacing="0" cellpadding="0" align="center">
							<tr>
								<td background='image/left_line.gif' height='2'></td>
							</tr>
							<tr>
								<td height='30'>&nbsp;&nbsp;<img src="image/left_icon.gif"> <a href='admmail_adm.php'>기본설정</a></td>
							</tr>
							<tr>
								<td background='image/left_line.gif' height='2'></td>
							</tr><?
							if($webmail_admin_row[adm_bWebmail])
							{
								?>
							<tr>
								<td height='30'>&nbsp;&nbsp;<img src="image/left_icon.gif"> <a href='admmail_write.php'>편지쓰기</a></td>
							</tr>
							<tr>
								<td background='image/left_line.gif' height='2'></td>
							</tr>
							<tr>
								<td height='30'>&nbsp;&nbsp;<img src="image/left_icon.gif"> <a href='admmail_mbox.php'>편지함 관리</a></td>
							</tr>
							<tr>
								<td background='image/left_line.gif' height='2'></td>
							</tr><?
								$MySQL->query("select idx from webmail_mail where mbox='1' and badmin=1 and bRead=0");
								$left_menu_noread_cnt = $MySQL->is_affected();
								if($left_menu_noread_cnt)
								{
									$left_menu_noread_cnt_str = "[<B>$left_menu_noread_cnt</B>]";
								}
								else
								{
									$left_menu_noread_cnt_str = "";
								}
								?>
							<tr>
								<td height='25' bgcolor="ffffff">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img src="../image/webmail/left_icon2.gif" width="17" height="17" align="absmiddle"> <a href='admmail_list.php?mbox=1'>받은편지함 <?=$left_menu_noread_cnt_str?></a></td>
							</tr>
							<tr>
								<td background='image/left_line.gif' height='2'></td>
							</tr><?
								$MySQL->query("select idx from webmail_mail where mbox='2' and badmin=1 and bRead=0");
								$left_menu_noread_cnt = $MySQL->is_affected();
								if($left_menu_noread_cnt)
								{
									$left_menu_noread_cnt_str = "[<B>$left_menu_noread_cnt</B>]";
								}
								else
								{
									$left_menu_noread_cnt_str = "";
								}
								?>
							<tr>
								<td height='25' bgcolor="ffffff">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img src="../image/webmail/left_icon3.gif" width="17" height="17" align="absmiddle"> <a href='admmail_list.php?mbox=2'>보낸편지함 <?=$left_menu_noread_cnt_str?></a></td>
							</tr>
							<tr>
								<td background='image/left_line.gif' height='2'></td>
							</tr><?
								$MySQL->query("select idx from webmail_mail where mbox='3' and badmin=1 and bRead=0");
								$left_menu_noread_cnt = $MySQL->is_affected();
								if($left_menu_noread_cnt)
								{
									$left_menu_noread_cnt_str = "[<B>$left_menu_noread_cnt</B>]";
								}
								else
								{
									$left_menu_noread_cnt_str = "";
								}
								?>
							<tr>
								<td height='25' bgcolor="ffffff">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img src="../image/webmail/left_icon4.gif" width="17" height="17" align="absmiddle"> <a href='admmail_list.php?mbox=3'>임시편지함 <?=$left_menu_noread_cnt_str?></a></td>
							</tr>
							<tr>
								<td background='image/left_line.gif' height='2'></td>
							</tr><?
								$MySQL->query("select idx from webmail_mail where mbox='4' and badmin=1 and bRead=0");
								$left_menu_noread_cnt = $MySQL->is_affected();
								if($left_menu_noread_cnt)
								{
									$left_menu_noread_cnt_str = "[<B>$left_menu_noread_cnt</B>]";
								}
								else
								{
									$left_menu_noread_cnt_str = "";
								}
								?>
							<tr>
								<td height='25' bgcolor="ffffff">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img src="../image/webmail/left_icon5.gif" width="17" height="17" align="absmiddle"> <a href='admmail_list.php?mbox=4'>휴지통 <?=$left_menu_noread_cnt_str?></a></td>
							</tr>
							<tr>
								<td background='image/left_line.gif' height='2'></td>
							</tr><?
								$left_menu_mbox_qry = "select * from webmail_mbox where badmin=1 order by idx asc";
								$left_menu_mbox_result = $MySQL->query($left_menu_mbox_qry);
								while($left_menu_mbox_row = mysql_fetch_array($left_menu_mbox_result))
								{
									$MySQL->query("select idx from webmail_mail where mbox='$left_menu_mbox_row[mbox]' and badmin=1 and bRead=0");
									$left_menu_noread_cnt = $MySQL->is_affected();
									if($left_menu_noread_cnt)
									{
										$left_menu_noread_cnt_str = "[<B>$left_menu_noread_cnt</B>]";
									}
									else
									{
										$left_menu_noread_cnt_str = "";
									}
									?>
							<tr>
								<td height='25' bgcolor="ffffff">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img src="../image/webmail/left_icon6.gif" width="17" height="17" align="absmiddle"> <a href='admmail_list.php?mbox=<?=$left_menu_mbox_row[mbox]?>'><?=$left_menu_mbox_row[name]?> <?=$left_menu_noread_cnt_str?></a></td>
							</tr>
							<tr>
								<td background='image/left_line.gif' height='2'></td>
							</tr><?
								}
								?>
							<tr>
								<td height='30'>&nbsp;&nbsp;<img src="image/left_icon.gif"> <a href='admmail_address.php'>주소록</a></td>
							</tr>
							<tr>
								<td background='image/left_line.gif' height='2'></td>
							</tr>
							<tr>
								<td height='30'>&nbsp;&nbsp;<img src="image/left_icon.gif"> <a href='admmail_manager.php'>환경설정</a></td>
							</tr>
							<tr>
								<td background='image/left_line.gif' height='2'></td>
							</tr><?
							}
							?>
						</table>
					</td><?
				}
				else if($__TOP_MENU=="help")
				{
					?>
					<td width="170" valign="top">
						<table width="160" border="0" cellspacing="0" cellpadding="0" align="center">
							<tr>
								<td background='image/left_line.gif' height='2'></td>
							</tr>
							<tr>
								<td height='30'>&nbsp;&nbsp;<img src="image/left_icon.gif"> <a href='help_board.php'>고객지원센터</a></td>
							</tr>
							<tr>
								<td background='image/left_line.gif' height='2'></td>
							</tr>
							<tr>
								<td height='30'>&nbsp;&nbsp;<img src="image/left_icon.gif"> <a href='help_sql.php'>SQL 실행기</a></td>
							</tr>
							<tr>
								<td background='image/left_line.gif' height='2'></td>
							</tr>
							<tr>
								<td height='30'>&nbsp;&nbsp;<img src="image/left_icon.gif"> <a href='help_manual.php'>메뉴설명</a></td>
							</tr>
							<tr>
								<td background='image/left_line.gif' height='2'></td>
							</tr>
							<tr>
								<td height='30'>&nbsp;&nbsp;<img src="image/left_icon.gif"> <a href='help_src.php'>소스수정 이력관리</a></td>
							</tr>
							<tr>
								<td background='image/left_line.gif' height='2'></td>
							</tr>
						</table>
					</td><?
				}
				?>
				</tr>
				<tr>
					<td>&nbsp;</td>
				</tr>
			</table>
		</td>