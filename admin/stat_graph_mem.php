<?
include "head.php";
?>
<body bgcolor="#FFFFFF" text="#5A595A" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<? include "top_menu.php"; ?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr><?
	$__TOP_MENU = "data";     //왼쪽 소메뉴 설정 변수
	include "left_menu.php";
	$MySQL->query("select *from member");
	$total_member = $MySQL->is_affected();
	?>
		<td width="85%" valign="top">
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td height='5'></td>
				</tr>
				<tr>
					<td>
						<table width="750" border="0" cellspacing="0" cellpadding="0" align='center'>
							<tr>
								<td rowspan="3" width="200"><img src="image/graph_tit_img.gif"></td>
								<td>&nbsp;</td>
							</tr>
							<tr>
								<td bgcolor="#E6E6E6" height='26'><div align='right'><font class='text1'>SHOP 회원통계, 판매현황, 기간별 결제통계, 지역별 통계등을 확인하실수 있습니다.&nbsp;</div></td>
							</tr>
							<tr>
								<td>&nbsp;</td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td height="2">
						<table width="750" border="0" cellspacing="0" cellpadding="0" align="center">
							<tr>
								<td bgcolor='DADADA' height='1'></td>
							</tr>
							<tr>
								<td>
									<table width="750" border="0" cellspacing="0" cellpadding="0" align="center">
										<tr>
											<td width='440'><img src="image/graph_mem.gif"></td>
										</tr>
									</table>
								</td>
							</tr>
							<tr>
								<td bgcolor='DADADA' height='1'></td>
							</tr>
							<tr>
								<td height='10'></td>
							</tr>
							<tr valign="middle">
								<td valign="top">
									<table width="100%" border="0" cellspacing="0" cellpadding="0">
										<tr>
											<td width="1%">&nbsp;</td>
											<td width="10%"> <div align="center"><a href="stat_graph_mem.php"><img src="image/graph_mem_year.gif" width="45" height="19" border="0"></a></div></td>
											<td width="10%"> <div align="center"><a href="stat_graph_mem_1.php"><img src="image/graph_mem_sex.gif" width="45" height="19" border="0"></a></div></td>
											<td width="70%">&nbsp;</td>
										</tr>
									</table>
								</td>
							</tr>
							<tr>
								<td height='5'></td>
							</tr>
							<tr>
								<td>
									<table width="100%" border="0" cellspacing="1" cellpadding="0" align="center" bgcolor='cdcdcd'>
										<tr>
											<td width="15%" height="30" valign="middle" bgcolor="#EBEBEB"> <div align="center"><img src="image/icon.gif" width="11" height="11"> 구분 </div></td>
											<td width="8%" valign="middle" bgcolor="#EBEBEB"> <div align="center"><img src="image/icon.gif" width="11" height="11"> 회원수 </div></td>
											<td width="15%" height="30" valign="middle" bgcolor="#EBEBEB"> <div align="center"><img src="image/icon.gif" width="11" height="11"> 구성비율 </div></td>
											<td width="17%" height="30" valign="middle" bgcolor="#EBEBEB"> <div align="center"><img src="image/icon.gif" width="11" height="11"> 매출액 </div></td>
											<td width="50%" height="30" valign="middle" bgcolor="#EBEBEB"> <div align="center"><img src="image/icon.gif" width="11" height="11"> 그래프</div></td>
										</tr>
										<!-- 연령대별 목록 시작 --><?
										$today_year = substr(date("Y"),2,2)+101;
										$qry = "select left($today_year-left(ssh,2),1)*10,count(1) from member group by left($today_year-left(ssh,2),1)";
										$result = @$MySQL->query($qry) or die("Err. : $qry");
										$total_payM_row = $MySQL->fetch_array("SELECT sum(trade.payM)  from trade,member WHERE trade.userid = member.userid and trade.bPay=1 and trade.status>0 and trade.status<4");
										$total_payM = $total_payM_row[0];
										while($row = mysql_fetch_array($result))
										{
											if(empty($total_member))	$percent =0;
											else				$percent = sprintf("%01.2f",($row[1] /$total_member*100));
											if(empty($total_member))	$img_percent =0;
											else				$img_percent = sprintf("%01.2f",($row[1] /$total_member*380));
											$age = $row[0]; /// 10,20,30 연령값 저장 
											///해당 회원의 매출액
											$sum_row = $MySQL->fetch_array("SELECT sum(trade.payM)  from trade,member WHERE trade.userid = member.userid and left($today_year-left(member.ssh,2),1)*10=$age  and trade.bPay=1 and trade.status>0 and trade.status<4"); 
											$sum_payM = $sum_row[0];
											if(empty($total_payM))
											{
												$payM_img_percent =0;
												$payM_percent=0;
											}
											else
											{
												$payM_percent = sprintf("%01.2f",($sum_payM /$total_payM*100));
												$payM_img_percent = sprintf("%01.2f",($sum_payM /$total_payM*380));
											}
											?>
										<tr>
											<td height="25" valign="middle" bgcolor="ffffff"> <div align="center"><?=$row[0]?>대</div></td>
											<td valign="middle" bgcolor="ffffff"> <div align="center"><?=$row[1]?></div></td>
											<td height="25" valign="middle" bgcolor="ffffff"> <div align="center"><?=$percent?>%</div></td>
											<td height="25" valign="middle" bgcolor="ffffff"> <div align="center"><?=PriceFormat($sum_payM)?> 원 <br><?=$payM_percent?> %</div></td>
											<td height="25" valign="middle" bgcolor="ffffff">
												<table width="100%" border="0" cellspacing="0" cellpadding="0">
													<tr>
														<td width="3" height="10"></td>
														<td width="380" height="10"><img src="image/graph_01.gif" width="<?=$img_percent?>" height="10"></td>
														<td width="2" height="10"></td>
													</tr>
													<tr>
														<td height="10"></td>
													</tr>
													<tr>
														<td width="3" height="10"></td>
														<td width="380" height="10"><img src="image/graph_02.gif" width="<?=$payM_img_percent?>" height="10"></td>
														<td width="2" height="10"></td>
													</tr>
												</table>
											</td>
										</tr><?
										}
										?>
										<tr>
											<td width="20%" height="25" valign="middle" bgcolor="ffffff"> <div align="center">합계</div></td>
											<td width="15%" valign="middle" bgcolor="ffffff"> <div align="center"><?=$total_member?></div></td>
											<td height="25" valign="middle" bgcolor="ffffff"> <div align="center">100%</div></td>
											<td height="25" valign="middle" bgcolor="ffffff"><div align="center"><?=PriceFormat($total_payM)?> 원</div></td>
											<td width="50%" height="25" valign="middle" bgcolor="ffffff">
												<table width="100%" border="0" cellspacing="0" cellpadding="0">
													<tr>
														<td width="3" height="10"></td>
														<td width="380" height="10"><img src="image/graph_03.gif" width="380" height="10"></td>
														<td width="2" height="10"></td>
													</tr>
												</table>
											</td>
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
<? include "copy.php";?>
</body>
</html>