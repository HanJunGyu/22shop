<?
include "head.php";
?>
<body bgcolor="#FFFFFF" text="#5A595A" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<? include "top_menu.php"; ?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr><?
	$__TOP_MENU = "data";     //왼쪽 소메뉴 설정 변수
	include "left_menu.php";
	?>
		<td width="85%" valign="top">
			<table width="100%" border="0" cellspacing="0" cellpadding="0" align='center'>
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
											<td width='440'><img src="image/graph_local.gif"></td>
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
							<tr>
								<td>
									<table width="100%" border="0" cellspacing="0" cellpadding="0" align='center'>
										<tr>
											<td width="80">&nbsp;</td>
											<td width="350" height="400" valign="top">
												<table width="300" border="0" cellspacing="0" cellpadding="0" align="center">
													<tr>
														<td>
															<table border="0" cellspacing="0" cellpadding="0" align="center">
																<tr>
																	<td width="162"><img src="image/graph_map_01.gif" width="162" height="76"></td>
																	<td width="32"><a href="#" onMouseOut="MM_swapImgRestore();MM_showHideLayers('Layer4','','hide');" onMouseOver="MM_swapImage('Image701','','image/graph_map_02_1.gif',1);MM_showHideLayers('Layer4','','show');"><img name="Image701" border="0" src="image/graph_map_02.gif" width="32" height="76"></a></td><!-- 강원도 -->
																	<td width="106"><img src="image/graph_map_03.gif" width="106" height="76"></td>
																</tr>
															</table>
															<table border="0" cellspacing="0" cellpadding="0" width="300" align="center">
																<tr>
																	<td width="91"><a href="#" onMouseOut="MM_swapImgRestore();MM_showHideLayers('Layer2','','hide');" onMouseOver="MM_swapImage('Image711','','image/graph_map_04_1.gif',1);MM_showHideLayers('Layer2','','show');"><img name="Image711" border="0" src="image/graph_map_04.gif" width="91" height="26"></a></td><!-- 인천광역시 -->
																	<td width="60"><a href="#" onMouseOut="MM_swapImgRestore();MM_showHideLayers('Layer1','','hide');" onMouseOver="MM_swapImage('Image721','','image/graph_map_05_1.gif',1);MM_showHideLayers('Layer1','','show');"><img name="Image721" border="0" src="image/graph_map_05.gif" width="60" height="26"></a></td><!-- 서울특별시 -->
																	<td width="151"><img src="image/graph_map_06.gif" width="151" height="26"></td>
																</tr>
															</table>
															<table width="300" border="0" cellspacing="0" cellpadding="0" align="center">
																<tr>
																	<td><img src="image/graph_map_07.gif" width="95" height="17"></td>
																	<td><a href="#" onMouseOut="MM_swapImgRestore();MM_showHideLayers('Layer3','','hide');" onMouseOver="MM_swapImage('Image70','','image/graph_map_08_1.gif',1);MM_showHideLayers('Layer3','','show');"><img name="Image70" border="0" src="image/graph_map_08.gif" width="36" height="17"></a></td><!-- 경기도 -->
																	<td><img src="image/graph_map_09.gif" width="169" height="17"></td>
																</tr>
															</table>
															<table width="300" border="0" cellspacing="0" cellpadding="0" align="center">
																<tr>
																	<td><img src="image/graph_map_10.gif" width="131" height="18"></td>
																	<td><a href="#" onMouseOut="MM_swapImgRestore();MM_showHideLayers('Layer6','','hide');" onMouseOver="MM_swapImage('Image71','','image/graph_map_11_1.gif',1);MM_showHideLayers('Layer6','','show');"><img name="Image71" border="0" src="image/graph_map_11.gif" width="39" height="18"></a></td><!-- 충청북도 -->
																	<td><img src="image/graph_map_12.gif" width="130" height="18"></td>
																</tr>
															</table>
															<table width="300" border="0" cellspacing="0" cellpadding="0" align="center">
																<tr>
																	<td><img src="image/graph_map_13.gif" width="74" height="15"></td>
																	<td><a href="#" onMouseOut="MM_swapImgRestore();MM_showHideLayers('Layer5','','hide');" onMouseOver="MM_swapImage('Image72','','image/graph_map_14_1.gif',1);MM_showHideLayers('Layer5','','show');"><img name="Image72" border="0" src="image/graph_map_14.gif" width="42" height="15"></a></td><!-- 충청남도 -->
																	<td><img src="image/graph_map_15.gif" width="184" height="15"></td>
																</tr>
															</table>
															<table width="300" border="0" cellspacing="0" cellpadding="0" align="center">
																<tr>
																	<td><img src="image/graph_map_16.gif" width="184" height="14"></td>
																	<td><a href="#" onMouseOut="MM_swapImgRestore();MM_showHideLayers('Layer8','','hide');" onMouseOver="MM_swapImage('Image73','','image/graph_map_17_1.gif',1);MM_showHideLayers('Layer8','','show');"><img name="Image73" border="0" src="image/graph_map_17.gif" width="40" height="14"></a></td><!-- 경상북도 -->
																	<td><img src="image/graph_map_18.gif" width="76" height="14"></td>
																</tr>
															</table>
															<table width="300" border="0" cellspacing="0" cellpadding="0" align="center">
																<tr>
																	<td><img src="image/graph_map_19.gif" width="104" height="16"></td>
																	<td><a href="#" onMouseOut="MM_swapImgRestore();MM_showHideLayers('Layer7','','hide');" onMouseOver="MM_swapImage('Image74','','image/graph_map_20_1.gif',1);MM_showHideLayers('Layer7','','show');"><img name="Image74" border="0" src="image/graph_map_20.gif" width="53" height="16"></a></td><!-- 대전광역시 -->
																	<td><img src="image/graph_map_21.gif" width="143" height="16"></td>
																</tr>
															</table>
															<table width="300" border="0" cellspacing="0" cellpadding="0" align="center">
																<tr>
																	<td><img src="image/graph_map_22.gif" width="167" height="17"></td>
																	<td><a href="#" onMouseOut="MM_swapImgRestore();MM_showHideLayers('Layer12','','hide');" onMouseOver="MM_swapImage('Image75','','image/graph_map_23_1.gif',1);MM_showHideLayers('Layer12','','show');"><img name="Image75" border="0" src="image/graph_map_23.gif" width="57" height="17"></a></td><!-- 대구광역시 -->
																	<td><img src="image/graph_map_24.gif" width="76" height="17"></td>
																</tr>
															</table>
															<table width="300" border="0" cellspacing="0" cellpadding="0" align="center">
																<tr>
																	<td><img src="image/graph_map_25.gif" width="90" height="23"></td>
																	<td><a href="#" onMouseOut="MM_swapImgRestore();MM_showHideLayers('Layer10','','hide');" onMouseOver="MM_swapImage('Image76','','image/graph_map_26_1.gif',1);MM_showHideLayers('Layer10','','show');"><img name="Image76" border="0" src="image/graph_map_26.gif" width="41" height="23"></a></td><!-- 전라북도 -->
																	<td><img src="image/graph_map_27.gif" width="74" height="23"></td>
																	<td><a href="#" onMouseOut="MM_swapImgRestore();MM_showHideLayers('Layer13','','hide');" onMouseOver="MM_swapImage('Image77','','image/graph_map_28_1.gif',1);MM_showHideLayers('Layer13','','show');"><img name="Image77" border="0" src="image/graph_map_28.gif" width="53" height="23"></a></td><!-- 울산광역시 -->
																	<td><img src="image/graph_map_29.gif" width="42" height="23"></td>
																</tr>
															</table>
															<table width="300" border="0" cellspacing="0" cellpadding="0" align="center">
																<tr>
																	<td><img src="image/graph_map_30.gif" width="149" height="13"></td>
																	<td><a href="#" onMouseOut="MM_swapImgRestore();MM_showHideLayers('Layer9','','hide');" onMouseOver="MM_swapImage('Image78','','image/graph_map_31_1.gif',1);MM_showHideLayers('Layer9','','show');"><img name="Image78" border="0" src="image/graph_map_31.gif" width="45" height="13"></a></td><!-- 경상남도 -->
																	<td><img src="image/graph_map_32.gif" width="106" height="13"></td>
																</tr>
															</table>
															<table width="300" border="0" cellspacing="0" cellpadding="0" align="center">
																<tr>
																	<td><img src="image/graph_map_33.gif" width="89" height="21"></td>
																	<td><a href="#" onMouseOut="MM_swapImgRestore();MM_showHideLayers('Layer15','','hide');" onMouseOver="MM_swapImage('Image79','','image/graph_map_34_1.gif',1);MM_showHideLayers('Layer15','','show');"><img name="Image79" border="0" src="image/graph_map_34.gif" width="60" height="21"></a></td><!-- 광주광역시 -->
																	<td><img src="image/graph_map_35.gif" width="56" height="21"></td>
																	<td><a href="#" onMouseOut="MM_swapImgRestore();MM_showHideLayers('Layer14','','hide');" onMouseOver="MM_swapImage('Image80','','image/graph_map_36_1.gif',1);MM_showHideLayers('Layer14','','show');"><img name="Image80" border="0" src="image/graph_map_36.gif" width="53" height="21"></a></td><!-- 부산광역시 -->
																	<td><img src="image/graph_map_37.gif" width="42" height="21"></td>
																</tr>
															</table>
															<table width="300" border="0" cellspacing="0" cellpadding="0" align="center">
																<tr>
																	<td><img src="image/graph_map_38.gif" width="74" height="22"></td>
																	<td><a href="#" onMouseOut="MM_swapImgRestore();MM_showHideLayers('Layer11','','hide');" onMouseOver="MM_swapImage('Image81','','image/graph_map_39_1.gif',1);MM_showHideLayers('Layer11','','show');"><img name="Image81" border="0" src="image/graph_map_39.gif" width="42" height="22"></a></td><!-- 전라남도 -->
																	<td><img src="image/graph_map_40.gif" width="184" height="22"></td>
																</tr>
															</table>
															<table width="300" border="0" cellspacing="0" cellpadding="0" align="center">
																<tr>
																	<td><img src="image/graph_map_41.gif" width="300" height="34"></td>
																</tr>
															</table>
															<table width="300" border="0" cellspacing="0" cellpadding="0" align="center">
																<tr>
																	<td><img src="image/graph_map_42.gif" width="59" height="32"></td>
																	<td><a href="#" onMouseOut="MM_swapImgRestore();MM_showHideLayers('Layer16','','hide');" onMouseOver="MM_swapImage('Image82','','image/graph_map_43_1.gif',1);MM_showHideLayers('Layer16','','show');"><img name="Image82" border="0" src="image/graph_map_43.gif" width="50" height="32"></a></td><!-- 제주도 -->
																	<td><img src="image/graph_map_44.gif" width="191" height="32"></td>
																</tr>
															</table>
														</td>
													</tr>
												</table>
											</td>
											<td width="120" style="position:absolute">&nbsp;<?
											for($i=0;$i<count($AREA_ARR);$i++)
											{
												$layCnt=$i+1;
												?><!-- -------------------------레이어 시작 ------------------------------------------>
												<div id="Layer<?=$layCnt?>" style="position:absolute; left:400px; top:100px; width:190px; z-index:1; visibility:hidden"  onMouseOut="MM_showHideLayers('Layer<?=$layCnt?>','','hide')" onMouseOver="MM_showHideLayers('Layer<?=$layCnt?>','','show')"><?
												$area_qry ="select count(idx),sum(totalM) from trade ";
												$area_qry.=" where city='$AREA_ARR[$i]'";		//지역별 판매금,판매수
												$area_result = $MySQL->query($area_qry);
												$area_row = mysql_fetch_array($area_result);
												$MySQL->query("select *from member  where city='$AREA_ARR[$i]'");
												$area_member_cnt =$MySQL->is_affected();
												?>
												<table width="140" border="0" cellspacing="0" cellpadding="0" height="130" background="image/<?=$AREA_ARR_MAP[$i]?>.gif">
													<tr>
														<td colspan="3" height="15"></td>
													</tr>
													<tr>
														<td width="15">&nbsp;</td>
														<td valign="top">
															<table width="130" border="0" cellpadding="0" cellspacing="0" bordercolordark="#FFFFFF" height="95">
																<tr>
																	<td colspan="2" height="35"> <div align="center"><b><img src="image/icon_3.gif" width="10" height="10"> <font color="#FF0066"><?=$AREA_ARR[$i]?></font></b></div></td>
																</tr>
																<tr>
																	<td width="50%" height="20"> <div align="center"><b>판매수 :</b></div></td>
																	<td height="20" width="50%"> <div align="center"><?=$area_row[0]?> EA</div></td>
																</tr>
																<tr>
																	<td width="50%" height="20"> <div align="center"><b>판매금 :</b></div></td>
																	<td height="20" width="50%"> <div align="center" align="right"><?=PriceFormat($area_row[1])?> 원</div></td>
																</tr>
																<tr>
																	<td width="50%" height="20"> <div align="center"><b>회원수 :</b></div></td>
																	<td height="20" width="50%"> <div align="center"><?=$area_member_cnt?> 명</div></td>
																</tr>
															</table>
														</td>
														<td width="15">&nbsp;</td>
													</tr>
													<tr>
														<td colspan="3" height="20"></td>
													</tr>
												</table></div><?
											}
											?>
											</td>
										</tr>
										<tr>
											<td colspan="3" height="30">&nbsp;</td>
										</tr>
										<tr>
											<td width="80">&nbsp;</td>
											<td width="350"><?
											$area_qry ="select count(idx),sum(totalM) from trade ";
											$area_qry.=" where 1=1 ";
											for($i=0;$i<count($AREA_ARR);$i++) $area_qry.=" and trade.city <>'$AREA_ARR[$i]'";		//대한민국 지역이 아님.
											$area_result = $MySQL->query($area_qry);
											$area_row = mysql_fetch_array($area_result);
											$area_mem_qry ="select * from member where 1=1 ";
											for($i=0;$i<count($AREA_ARR);$i++) $area_mem_qry.=" and city <>'$AREA_ARR[$i]'";		//대한민국 지역이 아님.
											$MySQL->query($area_mem_qry);
											$area_member_cnt =$MySQL->is_affected();
											?>
												<table width="70%" border="1" cellpadding="2" cellspacing="0" bordercolor="#BCA4D5" bordercolordark="#FFFFFF" bgcolor="#FFFFFF" align="center">
													<tr bgcolor="#E2D4F1">
														<td colspan="2" height="25"> <div align="center"><b>기타지역(해외 또는 주소지미상)</b></div></td>
													</tr>
													<tr>
														<td width="40%" height="25" bgcolor="EEE6F7"> <div align="center">판 매 수 :</div></td>
														<td height="25" bgcolor="#F5F5FA" width="60%"> <div align="center"><?=$area_row[0]?> EA</div></td>
													</tr>
													<tr>
														<td width="40%" height="25" bgcolor="EEE6F7"> <div align="center">판 매 금 액 :</div></td>
														<td height="25" bgcolor="#F5F5FA" width="60%"> <div align="center"><?=PriceFormat($area_row[1])?> 원</div></td>
													</tr>
													<tr>
														<td width="40%" height="25" bgcolor="EEE6F7"> <div align="center">회 원 수 :</div></td>
														<td height="25" bgcolor="#F5F5FA" width="60%"> <div align="center"><?=$area_member_cnt?> 명</div></td>
													</tr>
												</table>
											</td>
											<td width="120">&nbsp;</td>
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