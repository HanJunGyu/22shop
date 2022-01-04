<?
// 소스형상관리
// 20060720-1 소스수정 김성호 : 결제방식 정보 세분화(카드, 핸드폰, 계좌이체, 가상계좌, 무통장)
//								결제관련 정보($pG_Cracked)내용기록 강화
include "head.php";
if ($credit)	// 미결제 -> 결제
{
	$dataArr = Decode64($data);
	$trade_row = $MySQL->fetch_array("select *from trade where idx=$dataArr[idx]");
	$t_g_result = $MySQL->query("SELECT *from trade_goods WHERE tradecode='$trade_row[tradecode]'");
	while ($t_g_row = mysql_fetch_array($t_g_result))
	{
		$tp+= ($t_g_row[price] * $t_g_row[cnt]);
	}
	if(empty($admin_row[bTrans]))				$transM = 0;	//배송비미사용
	else														//배송비사용
	{
		if($admin_row[noTrans] <$tp)	$transM = 0;	//배송비무료 적용금액
		else						$transM = $admin_row[transMoney];	//배송비적용
	}
	$totalM = $tp;
	$payM = $tp + $transM;
	if ($credit == 1) $payMethod = "bank";
	else if ($credit == 2) $payMethod = "card";
	else if ($credit == 3) $payMethod = "hand";
	else if ($credit == 4) $payMethod = "iche";
	else if ($credit == 5) $payMethod = "cyber";
	$MySQL->query("UPDATE trade SET bPay=1,payMethod='$payMethod',totalM=$totalM,transM=$transM,payM=$payM WHERE idx=$trade_row[idx]");
}

////////////////주문취소 상품제외하여 상품금액,결제금액 갱신////////////////
if ($re_calc)
{
	$dataArr = Decode64($data);
	$trade_row = $MySQL->fetch_array("select *from trade where idx=$dataArr[idx]");
	$result = $MySQL->query("SELECT sum(price*cnt) from trade_goods WHERE tradecode='$trade_row[tradecode]' and status<4");
	$normal_totalM =  mysql_result($result,0);	//정상주문금액합
	$nomral_payM = $normal_totalM + $trade_row[transM] - $trade_row[useP];
	$MySQL->query("UPDATE trade SET payM=$nomral_payM,totalM=$normal_totalM where tradecode='$trade_row[tradecode]'");
}

$start=0;
?>
<SCRIPT LANGUAGE="JavaScript">
<!--
//주문정보 삭제
var tradeArr = new Array();
<?
	for($i=0;$i<count($TRADE_ARR);$i++)
	{
		?>
tradeArr[<?=$i?>] = "<?=$TRADE_ARR[$i]?>";<?
	}
?>

function tradeDel()
{
	var choose = confirm("주문정보가 영구 삭제됩니다.\n\n삭제 하시겠습니까?");
	if(choose)
	{
		location.href="trade_edit_ok.php?del=1&data=<?=$data?>";
	}
	else return;
}

//거래상태 변경
// 거래상태 일괄변경
function goodsChangeStatus2()
{
	var Obj = document.statusForm;
	var changeIndex = Obj.status.selectedIndex;

	changeIndex = changeIndex -1;
	var trans_Index = 2;
	var trans_Index2 = 3;
	var transForm = document.transForm;
	var tc = transForm.trans_company.value;
	var tn = transForm.trans_num.value;

	if((changeIndex==trans_Index || changeIndex==trans_Index2)&& (transForm.trans_company.value=="" || transForm.trans_num.value==""))
	{
		alert("배송사 또는 송장번호가 올바르지 않습니다.");
		Obj.reset();
		document.transForm.trans_num.focus();
	}
	else
	{
		//CONFIRM WINDOW
		var choose = confirm("거래상태를 변경합니다. \n\n["+tradeArr[changeIndex]+"] 상태로 변경하시겠습니까?");
		if(choose)
		{
			Obj.tc.value = tc;
			Obj.tn.value = tn;
			Obj.submit();
		}
		else
		{
			Obj.reset();
			return;
		}
	}
}

////////////개별상품 상태변경///////////////
function gaebyul_change(Obj)
{
	var changeIndex = Obj.status.value;
	var trans_Index = 2;
	var trans_Index2 = 3;
	var choose = confirm("거래상태를 변경합니다. \n\n["+tradeArr[changeIndex]+"] 상태로 변경하시겠습니까?");
	if((changeIndex==trans_Index || changeIndex==trans_Index2) && (Obj.tc.value=="" || Obj.tn.value==""))
	{
		alert("배송사 또는 송장번호가 올바르지 않습니다.");
		Obj.reset();
	}
	else
	{
		if(choose)
		{
			Obj.submit();
		}
		else
		{
			Obj.reset();
			return;
		}
	}
}

function showtip(current,e,num)
{
	if (document.layers) // Netscape 4.0+
	{
		theString="<DIV CLASS='ttip'>"+tip[num]+"</DIV>";
		document.tooltip.document.write(theString);
		document.tooltip.document.close();
		document.tooltip.left=e.pageX+14;
		document.tooltip.top=e.pageY+2;
		document.tooltip.visibility="show";
	}
	else
	{
		if(document.getElementById) // Netscape 6.0+ , Internet Explorer 5.0+
		{
			elm=document.getElementById(num);
			elml=current;
	//		elm.innerHTML=tip[num];
			elm.style.width=300;
	//		elm.style.h=200;
			elm.style.top=parseInt(elml.offsetTop+elml.offsetHeight+250);
			elm.style.left=parseInt(elml.offsetLeft+elml.offsetWidth+10);
			elm.style.visibility = "visible";
		}
	}
}

function hidetip()
{
	if (document.layers) // Netscape 4.0+
	{
		document.tooltip.visibility="hidden";
	}
	else
	{
		if(document.getElementById) // Netscape 6.0+ , Internet Explorer 5.0+
		{
			elm.style.visibility="hidden";
		}
	}
}

function tradeEdit()
{
	var form=document.tradeForm;
	form.submit();
}

function tradePermail()
{
	var form=document.tradeForm;
	if(form.email.value=="")
	{
		alert("주문자 메일이 없습니다.");
	}
	else
	{
		window.open("../email/mail.php?To="+form.email.value+"&From=admin","","scrollbars=yes,left=200,top=50,width=620,height=550");
	}
}

function print(File)
{
	var form=document.tradeForm;
	window.open("print.php?date="+File,"","scrollbars=yes,left=50,top=50,width=660,height=600");
}

function credit(num)
{
	location.href="trade_order_view.php?data=<?=$data?>&credit="+num;
}

function trans_edit(data)
{
	var form = document.transForm;
	form.action="trade_edit_ok.php?trans_edit=1&data="+data;
	form.submit();
}

function re_calc()
{
	location.href="trade_order_view.php?data=<?=$data?>&re_calc=1";
}
//-->
</SCRIPT>
<body bgcolor="#FFFFFF" text="#5A595A" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<table width="100%" border="0" cellspacing="0" cellpadding="0" align="left">
	<tr>
		<td bgcolor="#FFFFFF">
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
				<tr>
				<?
				$dataArr = Decode64($data);
				$trade_row = $MySQL->fetch_array("select *from trade where idx=$dataArr[idx]");
				if($trade_row[payMethod] =="card") $payMethod="<B>카드결제</B> [".$trade_row[bankInfo]."]";
				elseif($trade_row[payMethod] =="hand") $payMethod="<B>휴대폰</B> [".$trade_row[bankInfo]."]";
				elseif($trade_row[payMethod] =="iche") $payMethod="<B>계좌이체</B> [".$trade_row[bankInfo]."]";
				elseif($trade_row[payMethod] =="cyber") $payMethod="<B>가상계좌</B> [".$trade_row[bankInfo]."]";
				elseif($trade_row[payMethod] =="bank") $payMethod="<B>무통장</B> [".$trade_row[bankInfo]."]";
				if($trade_row[pG_Cracked] != "") $payMethod.="&nbsp;(".$trade_row[pG_Cracked].")";
				$content	= str_replace("\n","<br>", $trade_row[content]);	//전할말
				$tel=explode("-",$trade_row[tel]);
				$hand=explode("-",$trade_row[hand]);
				$zip=explode("-",$trade_row[zip]);
				$rtel=explode("-",$trade_row[rtel]);
				$rhand=explode("-",$trade_row[rhand]);
				$rzip=explode("-",$trade_row[rzip]);
				$trans_company = $admin_row[transCom];
				if($trade_row[status]>=2)	// 배송중 이상의 주문상태일때 송장번호 미리추출 // 상단 박스에 송장번호 미리입력시키도록하기위함
				{
					$tg_row = $MySQL->fetch_array("SELECT trans_num from trade_goods WHERE tradecode='$trade_row[tradecode]' $MALL_STR limit 1");
					$trade_row[trans_num] = $tg_row[trans_num];
				}
				$DEL_ABLE = 1;
					?>
					<td width="85%" valign="top" height="400">
						<table width="100%" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td height='5'></td>
							</tr>
							<tr>
								<td>
									<table width="750" border="0" cellspacing="0" cellpadding="0" align='center'>
										<tr>
											<td rowspan="3" width="200"><img src="image/order_tit_img.gif"></td>
											<td>&nbsp;</td>
										</tr>
										<tr>
											<td bgcolor="#E6E6E6" height='26'><div align='right'><font class='text1'>SHOP 주문내역 수정 삭제 등록 등을 하실수 있습니다.&nbsp;</div></td>
										</tr>
										<tr>
											<td>&nbsp;</td>
										</tr>
									</table>
								</td>
							</tr>
							<tr>
								<td>
									<table width="750" border="0" cellspacing="0" cellpadding="0" align="center">
										<tr>
											<td width='1' bgcolor='dadada'></td>
										</tr>
										<tr>
											<td width='440'><img src="image/order_tit_img_1.gif"></td>
										</tr>
										<tr>
											<td width='1' bgcolor='dadada'></td>
										</tr>
									</table>
								</td>
							</tr>
							<tr>
								<td>&nbsp;</td>
							</tr>
							<tr>
								<td valign="top">
									<table width="750" border="0" cellspacing="0" cellpadding="0" align="center">
										<tr>
											<td valign="top" align="left">
												<table width="750" border="0" cellspacing="1" bgcolor='cdcdcd' cellpadding="0">
													<tr align="center">
														<td bgcolor="#EBEBEB" height="31" width="130"><div align="center"><img src="image/icon.gif" width="11" height="11"> 주 문 번 호</div></td>
														<td bgcolor="#EBEBEB" width="200" height="31"><div align="center"><img src="image/icon.gif" width="11" height="11"> 주 문 접 수 일</div></td>
														<td bgcolor="#EBEBEB" width="130" height="31"><img src="image/icon.gif" width="11" height="11"> 주문자 아이디/이름</td>
														<td bgcolor="#EBEBEB" width="80"  height="31"><div align="center"><img src="image/icon.gif" width="11" height="11"> 삭제</div></td>
														<td bgcolor="#EBEBEB" width="80" height="31"><div align="center"><img src="image/icon.gif" width="11" height="11"> 메일</div></td>
													</tr>
													<tr bgcolor="ffffff">
														<td height="25" width="130"><div align="center"><B><?=$trade_row[tradecode]?></B></div></td>
														<td  height="25" bgcolor="ffffff"><div align="center"><?=$trade_row[writeday]?></div></td>
														<td height="25" width="130"><div align="center"><B><?=$trade_row[userid]?> / <?=$trade_row[name]?></B></div></td>
														<td  height="25" bgcolor="ffffff"><div align="center"><a href="javascript:tradeDel();"><img src="image/bbs_delete_btn.gif" border="0"></a></div></td>
														<td   height="25" bgcolor="ffffff"><div align="center"><a href="javascript:tradePermail();"><img src="image/mail_btn.gif" border="0"></a></div></td>
													</tr>
												</table>
											</td>
										</tr>
										<tr>
											<td valign="top" height="20">&nbsp; </td>
										</tr>
										<tr>
											<td>
												<table width="750" border="0" cellspacing="0" cellpadding="0" align="center">
													<tr>
														<td width='1' bgcolor='dadada'></td>
													</tr>
													<tr>
														<td width='440'><img src="image/order_view_m2.gif"></td>
													</tr>
													<tr>
														<td width='1' bgcolor='dadada'></td>
													</tr>
												</table>
											</td>
										</tr>
										<tr valign="middle">
											<td valign="top">
												<table width="750" border="0" cellspacing="2" cellpadding="0">
													<tr valign="middle">
														<td valign="top">
															<table width="750" border="0" cellspacing="2" cellpadding="0">
																<tr>
																	<td height="25" width="144" bgcolor='f7f7f7'><div align="center"><img src="image/icon.gif" width="11" height="11"> 거래상태 일괄변경</div></td>
																	<td height="25">
																		<table width="550" border="0" cellspacing="0" cellpadding="0">
																			<tr>
																				<form name="statusForm" method="post" action="status_change.php">
																				<input type="hidden" name="data" value="<?=$data?>">
																				<input type="hidden" name="tc" >
																				<input type="hidden" name="tn" >
																				<td width="30">&nbsp;</td>
																				<td><select name="status" onChange="javascript:goodsChangeStatus2();"><option value="0">##거래상태변경##</option><?
																				for($i=$start;$i<count($TRADE_ARR);$i++)
																				{
																					?><option value="<?=$i?>"><?=$TRADE_ARR[$i]?></option><?
																				}
																				?></select></td>
																				</form>
																				<td>
																					<form name="transForm" method="post">
																					<table class="table_coll">
																						<tr>
																							<td bgcolor="#EBEBEB" width="150"  height="31"><div align="center"><img src="image/icon.gif" width="11" height="11"> 배송사</div></td>
																							<td bgcolor="#EBEBEB" width="150"  height="31"><div align="center"><img src="image/icon.gif" width="11" height="11"> 송장번호</div></td>
																						</tr>
																						<tr>
																							<td height="25" bgcolor="ffffff"><div align="center"><input type="text" class="box" name="trans_company" value="<?=$trans_company?>"></div></td>
																							<td height="25" bgcolor="ffffff"><div align="center"><input type="text" class="box" name="trans_num" value="<?=$trade_row[trans_num]?>"></div></td>
																						</tr>
																						<tr>
																							<td colspan="2"><font class="help">※ <b>결제확인주문->배송중으로 변경시</b>에는 송장번호를 먼저 입력해주세요.<br>주문상품내역에 <b>일괄적용</b>하려면 이곳에 입력하시고 <br> <b>개별처리</b>는 아래항목에서 개별입력해주세요.</font></td>
																						</tr>
																					</table>
																					</form>
																				</td>
																			</tr>
																		</table>
																	</td>
																</tr>
																<tr>
																	<td height="1" colspan="2" background="image/line_bg1.gif"></td>
																</tr><?
																$pay_price = $trade_row[totalM];
																?>
																<tr>
																	<td height="25" width="144" bgcolor='f7f7f7'><div align="center"><img src="image/icon.gif" width="11" height="11"> 총 상품 금액</div></td>
																	<td height="25" width="401">
																		<table width="400" border="0" cellspacing="0" cellpadding="0">
																			<tr>
																				<td width="30">&nbsp;</td>
																				<td><?=PriceFormat($pay_price)?> 원</td>
																			</tr>
																		</table>
																	</td>
																</tr>
																<tr>
																	<td height="1" colspan="2" background="image/line_bg1.gif"> </td>
																</tr>
																<tr>
																	<td height="25" width="144" bgcolor='f7f7f7'><div align="center"><img src="image/icon.gif" width="11" height="11"> 사용 적립금</div></td>
																	<td height="25" width="401">
																		<table width="400" border="0" cellspacing="0" cellpadding="0">
																			<tr>
																				<td width="30">&nbsp;</td>
																				<td><?=PriceFormat($trade_row[useP])?> 원<?
																				if ($trade_row[userid_part]=="member")
																				{
																					$mem_re = $MySQL->query("SELECT point from member WHERE userid='$trade_row[userid]' limit 1");
																					?>
																					&nbsp;[ 회원 현재보유적립금 <?=PriceFormat(@mysql_result($mem_re,0))?> 원 ]<?
																				}
																					?>
																					</td>
																			</tr>
																		</table>
																	</td>
																</tr>
																<tr>
																	<td height="1" colspan="2" background="image/line_bg1.gif"> </td>
																</tr>
																<tr>
																	<td height="25" width="144" bgcolor='f7f7f7'><div align="center"><img src="image/icon.gif" width="11" height="11"> 배송비</div></td>
																	<td height="25" width="401">
																		<table width="400" border="0" cellspacing="0" cellpadding="0">
																			<tr>
																				<td width="30">&nbsp;</td>
																				<td><?=PriceFormat($trade_row[transM])?> 원</td>
																			</tr>
																		</table>
																	</td>
																</tr>
																<tr>
																	<td height="1" colspan="2" background="image/line_bg1.gif"> </td>
																</tr>
																<tr>
																	<td height="25" width="144"  bgcolor='f7f7f7'><div align="center"><img src="image/icon.gif" width="11" height="11"> 총 결제 금액</div></td>
																	<td height="25"  width="401">
																		<table width="450" border="0" cellspacing="0" cellpadding="0">
																			<tr>
																				<td width="30">&nbsp;</td>
																				<td><font color="#FF0000"><b><?=PriceFormat($trade_row[payM])?> 원</b></font></td>
																				<td>&nbsp;※ 주문취소,반품상품 제외하여 <br><b>상품금액,결제금액 재계산</b><input type="button" value="재계산" onclick="re_calc();"></td>
																			</tr>
																		</table>
																	</td>
																</tr>
																<tr>
																	<td height="1" colspan="2" background="image/line_bg1.gif"> </td>
																</tr>
																<tr>
																	<td height="25" width="144" bgcolor='f7f7f7'><div align="center"><img src="image/icon.gif" width="11" height="11"> 결제 방법</div></td>
																	<td height="25" width="401">
																		<table width="400" border="0" cellspacing="0" cellpadding="0">
																			<tr>
																				<td width="30">&nbsp;</td>
																				<td><?=$payMethod?></td>
																			</tr>
																		</table>
																	</td>
																</tr>
																<tr>
																	<td height="1" colspan="2" background="image/line_bg1.gif"> </td>
																</tr><?
																if ($trade_row[payMethod]=="bank")
																{
																	?>
																<tr>
																	<td height="25" width="144" bgcolor='f7f7f7'><div align="center"><img src="image/icon.gif" width="11" height="11"> 입금예정일</div></td>
																	<td height="25" width="401">
																		<table width="400" border="0" cellspacing="0" cellpadding="0">
																			<tr>
																				<td width="30">&nbsp;</td>
																				<td><?=$trade_row[bankDay]?>&nbsp;[입금자명 : <?=$trade_row[payer]?>]</td>
																			</tr>
																		</table>
																	</td>
																</tr>
																<tr>
																	<td height="1" colspan="2" background="image/line_bg1.gif"> </td>
																</tr><?
																}

																if (empty($trade_row[bPay]))
																{
																	?>
																<tr>
																	<td height="25" width="144" bgcolor='F8CBCC'><div align="center"><img src="image/icon.gif" width="11" height="11"> 미결제 -> 결제처리</div></td>
																	<td height="25" width="401">
																		<table width="400" border="0" cellspacing="0" cellpadding="0">
																			<tr>
																				<td width="30">&nbsp;</td>
																				<td><font class="help"><b>※ 본 기능은 정상주문이 미결제로 접수됐을때만 사용합니다.</b></font><a href="javascript:credit(1);"><u>결제처리실행(무통장)</u></a>&nbsp;&nbsp;&nbsp;<a href="javascript:credit(2);"><u>결제처리실행(카드결제)</u></a>&nbsp;&nbsp;&nbsp;<br><a href="javascript:credit(3);"><u>결제처리실행(휴대폰)</u></a>&nbsp;&nbsp;&nbsp;<a href="javascript:credit(4);"><u>결제처리실행(계좌이체)</u></a>&nbsp;&nbsp;&nbsp;<br><a href="javascript:credit(5);"><u>결제처리실행(가상계좌)</u></a></td>
																			</tr>
																		</table>
																	</td>
																</tr>
																<tr>
																	<td height="1" colspan="2" background="image/line_bg1.gif"> </td>
																</tr><?
																}
																	?>
															</table>
														</td>
													</tr>
													<tr valign="middle">
														<td valign="top" height="20">&nbsp;</td>
													</tr>
													<tr>
														<td>
															<table width="750" border="0" cellspacing="0" cellpadding="0" align="center">
																<tr>
																	<td width='1' bgcolor='dadada' colspan='3'></td>
																</tr>
																<tr>
																	<td width='440'><img src="image/order_view_m1.gif"></td>
																</tr>
																<tr>
																	<td width='1' bgcolor='dadada' colspan='3'></td>
																</tr>
															</table>
														</td>
													</tr>
													<tr>
														<td height='5'></td>
													</tr>
													<tr valign="middle">
														<td valign="top">
															<table width="750" border="0" cellspacing="1" cellpadding="0" bgcolor='cdcdcd'>
																<tr>
																	<td height="25" colspan="2" bgcolor='ebebeb'><div align="center"><img src="image/icon.gif" width="11" height="11"> 상품명 / 상품코드 사용</div></td>
																	<td height="25" bgcolor='ebebeb' width="90"><div align="center"><img src="image/icon.gif" width="11" height="11"> 옵션</div></td>
																	<td height="25"  bgcolor='ebebeb' width="80"><div align="center"><img src="image/icon.gif" width="11" height="11"><FONT COLOR="#993300">가격</FONT>/<FONT COLOR="#6633FF">수량</FONT></div></td>
																	<td height="25" bgcolor='ebebeb' width="70"><div align="center"><img src="image/icon.gif" width="11" height="11"> 합계(원)</div></td>
																	<td height="25" bgcolor='ebebeb' width="110"><div align="center"><img src="image/icon.gif" width="11" height="11"> 배송정보</div></td>
																	<td height="25" bgcolor='ebebeb' width="80"><div align="center"><img src="image/icon.gif" width="11" height="11" colspan="2"> 거래상태</div></td>
																</tr><?
																$trade_goods_qry ="select *from trade_goods where tradecode='$trade_row[tradecode]' $MALL_STR order by goodsIdx asc";
																$trade_goods_result = @$MySQL->query($trade_goods_qry) or die("Err. : $trade_goods_qry");
																$formCnt =0;
																$cnt=0;
																while($trade_goods_row = mysql_fetch_array($trade_goods_result))
																{
																	$trans_com_url = $admin_row[trans_com_url];
																	$formCnt++;
																	$top =$formCnt*60-280;
																	$goods_qry    = "select *from goods where idx=$trade_goods_row[goodsIdx] limit 1";
																	$goods_result = $MySQL->query($goods_qry);
																	$goodsChek    = $MySQL->is_affected();
																	$goods_row    = mysql_fetch_array($goods_result);	//상품정보
																	$optionArr = Array("$trade_goods_row[option1]","$trade_goods_row[option2]","$trade_goods_row[option3]"); //옵션 배열
																	$tprice = $trade_goods_row[price]*$trade_goods_row[cnt]; //상품합가격
																	$sday1= $trade_goods_row[sday1]; if(empty($sday1)) $sday1="정보 없음";
																	$sday2= $trade_goods_row[sday2]; if(empty($sday2)) $sday2="정보 없음";
																	$sday3= $trade_goods_row[sday3]; if(empty($sday3)) $sday3="정보 없음";
																	$sday4= $trade_goods_row[sday4]; if(empty($sday4)) $sday4="정보 없음";
																	$sday5= $trade_goods_row[sday5]; if(empty($sday5)) $sday5="정보 없음";
																	$sday6= $trade_goods_row[sday6]; if(empty($sday6)) $sday6="정보 없음";
																	$tg_status = $trade_goods_row[status];

																	/////////주문상품이 2개 이상일 경우만 개별상태변경 기능부여/////////////
																	////////택배사,송장번호 직접입력 활성화 및 비활성화/////////////////////
																	if (mysql_num_rows($trade_goods_result)>1)
																	{
																		$MANAGE_GOOD_SELECT = 1;
																		$MANAGE_GOOD_TRANS = "box";
																	}
																	else
																	{
																		$MANAGE_GOOD_SELECT = 0;
																		$MANAGE_GOOD_TRANS = "nonbox";
																	}
																	?>
																<form name="gaebyul_statForm<?=$formCnt?>" method="post" action="status_change.php">
																<tr height="60">
																	<td width="50" bgcolor="ffffff" valign="middle"><div align="center"><?
																	if (empty($GD_SET) && $goods_row[img_onetoall]) $img_str = $goods_row[img3];
																	else if ($GD_SET && $goods_row[img_onetoall] && empty($goods_row[img2])) $img_str = $goods_row[img3];
																	else if ($GD_SET && empty($goods_row[img_onetoall]) && empty($goods_row[img2])) $img_str = $goods_row[img3];
																	else $img_str = $goods_row[img2];
																	$img_info	=@getimagesize("../upload/goods/$img_str");	//이미지정보
																	$wSize	=$img_info[0];	//가로
																	$hSize	=$img_info[1];	//세로
																	?><a onclick="zoom('../upload/goods/<?=$img_str?>',<?=$wSize?>,<?=$hSize?>)" onfocus="this.blur()" style="cursor:pointer"><img src="../upload/goods/<?=$img_str?>" width="40" height="40" align="middle"   onMouseOut="MM_showHideLayers('Layer<?=$formCnt?>','','hide')" onMouseOver="MM_showHideLayers('Layer<?=$formCnt?>','','show')" ><br><u>확대보기</u></a></div></td>
																	<td  bgcolor="ffffff" valign="middle"   onMouseOut="MM_showHideLayers('Layer<?=$formCnt?>','','hide')" onMouseOver="MM_showHideLayers('Layer<?=$formCnt?>','','show')" ><div align="center"><?=$trade_goods_row[name]?><br><B>[<?=$trade_goods_row[code]?>]</B></div></td>
																	<td  bgcolor="ffffff" width="110"  onMouseOut="MM_showHideLayers('Layer<?=$formCnt?>','','hide')" onMouseOver="MM_showHideLayers('Layer<?=$formCnt?>','','show')" ><div align="center">
																		<table width="100%" border="0" cellspacing="0" cellpadding="0"><?
																			for($i=0;$i<count($optionArr);$i++)
																			{
																				if(!empty($optionArr[$i]))
																				{
																					$option = explode("」「",$optionArr[$i]);
																					?>
																			<tr>
																				<td width="45"  bgcolor="#F7F7F7"><div align="center"><?=$option[0]?> </div></td>
																				<td   bgcolor="#DDFFFB"><div align="left"> : <?=$option[1]?></div></td>
																			</tr>
																			<tr  bgcolor="#CCCCCC">
																				<td colspan="2" height="1"></td>
																			</tr><?
																				}
																			}
																			?>
																		</table></div>
																	</td>
																	<td bgcolor="ffffff" onMouseOut="MM_showHideLayers('Layer<?=$formCnt?>','','hide')" onMouseOver="MM_showHideLayers('Layer<?=$formCnt?>','','show')" ><div align="center"><FONT COLOR="#993300"><?=PriceFormat($trade_goods_row[price])?></font><br><FONT COLOR="#6633FF"><?=$trade_goods_row[cnt]?></font></div></td>
																	<td  bgcolor="ffffff" onMouseOut="MM_showHideLayers('Layer<?=$formCnt?>','','hide')" onMouseOver="MM_showHideLayers('Layer<?=$formCnt?>','','show')" ><div align="right"><FONT COLOR="#990000"><?=PriceFormat($tprice)?></FONT></div></td>
																	<td  bgcolor="ffffff" onMouseOut="MM_showHideLayers('Layer<?=$formCnt?>','','hide')" onMouseOver="MM_showHideLayers('Layer<?=$formCnt?>','','show')" ><div align="center"><FONT COLOR="#990000">배송사</FONT><br><input class="<?=$MANAGE_GOOD_TRANS?>" type="text" name="tc" size="12" value="<?=$trade_goods_row[trans_company]?>" ><br><FONT COLOR="#990000">송장번호</FONT><br><input class="<?=$MANAGE_GOOD_TRANS?>" type="text" name="tn" size="12" value="<?=$trade_goods_row[trans_num]?>"><? if ($trade_goods_row[trans_num] && $trans_com_url){ ?><br><a href="http://<?=$trans_com_url?>" target="_blank"><b><font color="#3D179C"><u>배송추적</u></font></b></a><? } ?></div></td>
																	<td <? if ($trade_goods_row[status]>3) echo "bgcolor='pink'"; else echo "bgcolor='#ffffff'";?>><div align="center"><b><?if ($trade_row[bPay]==0) echo "미결제"; else echo $TRADE_ARR[$trade_goods_row[status]]; ?></b><?
																		if ($trade_goods_row[status]>0 && $MANAGE_GOOD_SELECT)
																		{
																			?><input type="hidden" name="tgidx" value="<?=$trade_goods_row[idx]?>"><input type="hidden" name="data" value="<?=$data?>">
																		<select name="status" onchange="gaebyul_change(this.form)">
																			<option style="background-color:#eeeeee">▶개별상태변경</option>
																			<option value=0><?=$TRADE_ARR[0]?></option>
																			<option value=1><?=$TRADE_ARR[1]?></option>
																			<option value=2><?=$TRADE_ARR[2]?></option>
																			<option value=3><?=$TRADE_ARR[3]?></option>
																			<option value=4><?=$TRADE_ARR[4]?></option>
																			<option value=5><?=$TRADE_ARR[5]?></option>
																		</select><?
																		}
																		?></div></td>
																	<!-------------------------------------------------- 날짜 정보 시작  ---------------------------------------------------->
																	<td bgcolor="ffffff" width="1"  style="position:absolute"><div id="Layer<?=$formCnt?>" style="position:absolute;visibility:hidden; z-index:1;left:100px;top:<?=$top?>px;" onMouseOut="MM_showHideLayers('Layer<?=$formCnt?>','','hide')" onMouseOver="MM_showHideLayers('Layer<?=$formCnt?>','','show')">
																		<table width="250" border="1" cellspacing="0" cellpadding="0" bgcolor="#FEFEFE">
																			<tr>
																				<td height="30"> <div align="center"><b><font color="#3898B8">◎ 날짜정보 ◎</font></b></div></td>
																			</tr>
																			<tr>
																				<td height="1" bgcolor="#3898B8"> </td>
																			</tr>
																			<tr>
																				<td height="170">
																					<table width="230" border="0" cellspacing="0" cellpadding="0" align="center">
																						<tr>
																							<td width="90" height="25" bgcolor="add8e6"><div align="left">&nbsp;&nbsp;→ 주문접수일</div></td>
																							<td height="25">
																								<table width="140" border="0" cellspacing="0" cellpadding="0">
																									<tr>
																										<td width="10">&nbsp;</td>
																										<td><?=$sday1?></td>
																									</tr>
																								</table>
																							</td>
																						</tr>
																						<tr>
																							<td colspan="2" height="1" background="image/line_bg1.gif"></td>
																						</tr>
																						<tr>
																							<td height="25" bgcolor="add8e6"> <div align="left">&nbsp;&nbsp;→ 결제확인일</div></td>
																							<td height="25">
																								<table width="140" border="0" cellspacing="0" cellpadding="0">
																									<tr>
																										<td width="10">&nbsp;</td>
																										<td><?=$sday2?></td>
																									</tr>
																								</table>
																							</td>
																						</tr>
																						<tr>
																							<td colspan="2" height="1" background="image/line_bg1.gif"></td>
																						</tr>
																						<tr>
																							<td height="25" bgcolor="add8e6"> <div align="left">&nbsp;&nbsp;→ 배송일</div></td>
																							<td height="25">
																								<table width="140" border="0" cellspacing="0" cellpadding="0">
																									<tr>
																										<td width="10">&nbsp;</td>
																										<td><?=$sday3?></td>
																									</tr>
																								</table>
																							</td>
																						</tr>
																						<tr>
																							<td colspan="2" height="1" background="image/line_bg1.gif"></td>
																						</tr>
																						<tr>
																							<td height="25" bgcolor="add8e6"> <div align="left">&nbsp;&nbsp;→ 배송완료일</div></td>
																							<td height="25">
																								<table width="140" border="0" cellspacing="0" cellpadding="0">
																									<tr>
																										<td width="10">&nbsp;</td>
																										<td><?=$sday4?></td>
																									</tr>
																								</table>
																							</td>
																						</tr>
																						<tr>
																							<td colspan="2" height="1" background="image/line_bg1.gif"></td>
																						</tr>
																						<tr>
																							<td height="25" bgcolor="add8e6"> <div align="left">&nbsp;&nbsp;→ 주문취소일</div></td>
																							<td height="25">
																								<table width="140" border="0" cellspacing="0" cellpadding="0">
																									<tr>
																										<td width="10">&nbsp;</td>
																										<td><?=$sday5?></td>
																									</tr>
																								</table>
																							</td>
																						</tr>
																						<tr>
																							<td colspan="2" height="1" background="image/line_bg1.gif"></td>
																						</tr>
																						<tr>
																							<td height="25" bgcolor="add8e6"> <div align="left">&nbsp;&nbsp;→ 반품처리일</div></td>
																							<td height="25">
																								<table width="140" border="0" cellspacing="0" cellpadding="0">
																									<tr>
																										<td width="10">&nbsp;</td>
																										<td><?=$sday6?></td>
																									</tr>
																								</table>
																							</td>
																						</tr>
																						<tr>
																							<td colspan="2" height="1" background="image/line_bg1.gif"></td>
																						</tr>
																					</table>
																				</td>
																			</tr>
																		</table></div>
																	</td>
																	<!-------------------------------------------------- 날짜 정보 끝  ---------------------------------------------------->
																</tr>
																</form><?
																	$cnt++;
																}//while
																?>
															</table>
														</td>
													</tr>
													<tr valign="middle">
														<td valign="top" height="10">&nbsp;</td>
													</tr>
													<tr>
														<td>
															<table width="750" border="0" cellspacing="0" cellpadding="0" align="center">
																<tr>
																	<td width='1' bgcolor='dadada' colspan='3'></td>
																</tr>
																<tr>
																	<td width='440'><img src="image/order_view_m3.gif"></td>
																</tr>
																<tr>
																	<td width='1' bgcolor='dadada' colspan='3'></td>
																</tr>
															</table>
														</td>
													</tr>
													<form name="tradeForm" method="post" action="trade_order_view_ok.php">
													<input type="hidden" value="<?=$data?>" name="data">
													<tr valign="middle">
														<td valign="top">
															<table width="750" border="0" cellspacing="2" cellpadding="0">
																<tr>
																	<td height="25" width="144" bgcolor='f7f7f7'><div align="center"><img src="image/icon.gif" width="11" height="11"> 이 름</div></td>
																	<td height="25" width="401">
																		<table width="400" border="0" cellspacing="0" cellpadding="0">
																			<tr>
																				<td width="30">&nbsp;</td>
																				<td><input class="box"name="name" type="text" id="title" size="20" value="<?=$trade_row[name]?>">&nbsp; <img src="image/icon.gif" width="11" height="11"> 주문자 접속 IP 주소 : <?=$trade_row[userIp]?></td>
																			</tr>
																		</table>
																	</td>
																</tr>
																<tr>
																	<td height="1" colspan="2" background="image/line_bg1.gif"> </td>
																</tr>
																<tr>
																	<td height="25" width="144" bgcolor='f7f7f7'><div align="center"><img src="image/icon.gif" width="11" height="11"> 전화번호</div></td>
																	<td height="25" width="401">
																		<table width="400" border="0" cellspacing="0" cellpadding="0">
																			<tr>
																				<td width="30">&nbsp;</td>
																				<td><input class="box"name="tel1" type="text" id="title" size="4" value="<?=$tel[0]?>">-<input class="box"name="tel2" type="text" id="title" size="4" value="<?=$tel[1]?>">-<input class="box"name="tel3" type="text" id="title" size="4" value="<?=$tel[2]?>"></td>
																			</tr>
																		</table>
																	</td>
																</tr>
																<tr>
																	<td height="1" colspan="2" background="image/line_bg1.gif"> </td>
																</tr>
																<tr>
																	<td height="25" width="144" bgcolor='f7f7f7'><div align="center"><img src="image/icon.gif" width="11" height="11"> 휴대폰 번호</div></td>
																	<td height="25" width="401">
																		<table width="400" border="0" cellspacing="0" cellpadding="0">
																			<tr>
																				<td width="30">&nbsp;</td>
																				<td><input class="box"name="hand1" type="text" id="title" size="4" value="<?=$hand[0]?>">-<input class="box"name="hand2" type="text" id="title" size="4" value="<?=$hand[1]?>">-<input class="box"name="hand3" type="text" id="title" size="4" value="<?=$hand[2]?>"></td>
																			</tr>
																		</table>
																	</td>
																</tr>
																<tr>
																	<td height="1" colspan="2" background="image/line_bg1.gif"> </td>
																</tr>
																<tr>
																	<td height="25" width="144" bgcolor='f7f7f7'><div align="center"><img src="image/icon.gif" width="11" height="11"> 우편번호</div></td>
																	<td height="25"  width="401">
																		<table width="400" border="0" cellspacing="0" cellpadding="0">
																			<tr>
																				<td width="30">&nbsp;</td>
																				<td><input class="box"name="zip1" type="text" id="title" size="3" value="<?=$zip[0]?>">-<input class="box"name="zip2" type="text" id="title" size="3" value="<?=$zip[1]?>"></td>
																			</tr>
																		</table>
																	</td>
																</tr>
																<tr>
																	<td height="1" colspan="2" background="image/line_bg1.gif"> </td>
																</tr>
																<tr>
																	<td height="25" width="144" bgcolor='f7f7f7'><div align="center"><img src="image/icon.gif" width="11" height="11"> 주 소</div></td>
																	<td height="25" width="401">
																		<table width="400" border="0" cellspacing="0" cellpadding="0">
																			<tr>
																				<td width="30">&nbsp;</td>
																				<td><input class="box"name="adr1" type="text" id="title" size="55" value="<?=$trade_row[adr1]?>"></td>
																			</tr>
																		</table>
																	</td>
																</tr>
																<tr>
																	<td height="1" colspan="2" background="image/line_bg1.gif"> </td>
																</tr>
																<tr>
																	<td height="25" width="144" bgcolor='f7f7f7'><div align="center"><img src="image/icon.gif" width="11" height="11"> 상세 주소</div></td>
																	<td height="25"  width="401">
																		<table width="400" border="0" cellspacing="0" cellpadding="0">
																			<tr>
																				<td width="30">&nbsp;</td>
																				<td><input class="box"name="adr2" type="text" id="title" size="40" value="<?=$trade_row[adr2]?>"></td>
																			</tr>
																		</table>
																	</td>
																</tr>
																<tr>
																	<td height="1" colspan="2" background="image/line_bg1.gif"> </td>
																</tr>
																<tr>
																	<td height="25" width="144" bgcolor='f7f7f7'><div align="center"><img src="image/icon.gif" width="11" height="11"> E-mail </div></td>
																	<td height="25" width="401">
																		<table width="400" border="0" cellspacing="0" cellpadding="0">
																			<tr>
																				<td width="30">&nbsp;</td>
																				<td><input class="box"name="email" type="text" id="title" size="55" value="<?=$trade_row[email]?>"></td>
																			</tr>
																		</table>
																	</td>
																</tr>
																<tr>
																	<td height="1" colspan="2" background="image/line_bg1.gif"> </td>
																</tr>
															</table>
														</td>
													</tr>
													<tr valign="middle">
														<td valign="top" height="10">&nbsp;</td>
													</tr>
													<tr>
														<td>
															<table width="750" border="0" cellspacing="0" cellpadding="0" align="center">
																<tr>
																	<td width='1' bgcolor='dadada' colspan='3'></td>
																</tr>
																<tr>
																	<td width='440'><img src="image/order_view_m4.gif"></td>
																</tr>
																<tr>
																	<td width='1' bgcolor='dadada' colspan='3'></td>
																</tr>
															</table>
														</td>
													</tr>
													<tr valign="middle">
														<td valign="top">
															<table width="750" border="0" cellspacing="2" cellpadding="0">
																<tr>
																	<td height="25" width="144" bgcolor='f7f7f7'><div align="center"><img src="image/icon.gif" width="11" height="11"> 이 름</div></td>
																	<td height="25" width="401">
																		<table width="400" border="0" cellspacing="0" cellpadding="0">
																			<tr>
																				<td width="30">&nbsp;</td>
																				<td><input class="box"name="rname" type="text" id="title" size="20" value="<?=$trade_row[rname]?>"></td>
																			</tr>
																		</table>
																	</td>
																</tr>
																<tr>
																	<td height="1" colspan="2" background="image/line_bg1.gif"> </td>
																</tr>
																<tr>
																	<td height="25" width="144" bgcolor='f7f7f7'><div align="center"><img src="image/icon.gif" width="11" height="11"> 전화번호</div></td>
																	<td height="25" width="401">
																		<table width="400" border="0" cellspacing="0" cellpadding="0">
																			<tr>
																				<td width="30">&nbsp;</td>
																				<td><input class="box"name="rtel1" type="text" id="title" size="4" value="<?=$rtel[0]?>">-<input class="box"name="rtel2" type="text" id="title" size="4" value="<?=$rtel[1]?>">-<input class="box"name="rtel3" type="text" id="title" size="4" value="<?=$rtel[2]?>"></td>
																			</tr>
																		</table>
																	</td>
																</tr>
																<tr>
																	<td height="1" colspan="2" background="image/line_bg1.gif"> </td>
																</tr>
																<tr>
																	<td height="25" width="144" bgcolor='f7f7f7'><div align="center"><img src="image/icon.gif" width="11" height="11"> 휴대폰 번호</div></td>
																	<td height="25" width="401">
																		<table width="400" border="0" cellspacing="0" cellpadding="0">
																			<tr>
																				<td width="30">&nbsp;</td>
																				<td><input class="box"name="rhand1" type="text" id="title" size="4" value="<?=$rhand[0]?>">-<input class="box"name="rhand2" type="text" id="title" size="4" value="<?=$rhand[1]?>">-<input class="box"name="rhand3" type="text" id="title" size="4" value="<?=$rhand[2]?>"></td>
																			</tr>
																		</table>
																	</td>
																</tr>
																<tr>
																	<td height="1" colspan="2" background="image/line_bg1.gif"> </td>
																</tr>
																<tr>
																	<td height="25" width="144" bgcolor='f7f7f7'><div align="center"><img src="image/icon.gif" width="11" height="11"> 우편번호</div></td>
																	<td height="25" width="401">
																		<table width="400" border="0" cellspacing="0" cellpadding="0">
																			<tr>
																				<td width="30">&nbsp;</td>
																				<td><input class="box"name="rzip1" type="text" id="title" size="3" value="<?=$rzip[0]?>">-<input class="box"name="rzip2" type="text" id="title" size="3" value="<?=$rzip[1]?>"></td>
																			</tr>
																		</table>
																	</td>
																</tr>
																<tr>
																	<td height="1" colspan="2" background="image/line_bg1.gif"> </td>
																</tr>
																<tr>
																	<td height="25" width="144" bgcolor='f7f7f7'><div align="center"><img src="image/icon.gif" width="11" height="11"> 주 소</div></td>
																	<td height="25" width="401">
																		<table width="400" border="0" cellspacing="0" cellpadding="0">
																			<tr>
																				<td width="30">&nbsp;</td>
																				<td><input class="box"name="radr1" type="text" id="title" size="55" value="<?=$trade_row[radr1]?>"></td>
																			</tr>
																		</table>
																	</td>
																</tr>
																<tr>
																	<td height="1" colspan="2" background="image/line_bg1.gif"> </td>
																</tr>
																<tr>
																	<td height="25" width="144" bgcolor='f7f7f7'><div align="center"><img src="image/icon.gif" width="11" height="11"> 상세 주소</div></td>
																	<td height="25" width="401">
																		<table width="400" border="0" cellspacing="0" cellpadding="0">
																			<tr>
																				<td width="30">&nbsp;</td>
																				<td><input class="box"name="radr2" type="text" id="title" size="40" value="<?=$trade_row[radr2]?>"></td>
																			</tr>
																		</table>
																	</td>
																</tr>
																<tr>
																	<td colspan="2" height="1" background="image/line_bg1.gif"> </td>
																</tr>
																<tr>
																	<td height="25" width="144" bgcolor='f7f7f7'><div align="center"><img src="image/icon.gif" width="11" height="11"> E-mail </div></td>
																	<td height="25" width="401">
																		<table width="400" border="0" cellspacing="0" cellpadding="0">
																			<tr>
																				<td width="30">&nbsp;</td>
																				<td><input class="box"name="remail" type="text" id="title" size="55" value="<?=$trade_row[remail]?>"></td>
																			</tr>
																		</table>
																	</td>
																</tr>
																<tr>
																	<td height="1" colspan="2" background="image/line_bg1.gif"> </td>
																</tr>
																<tr>
																	<td width="150" height="25" bgcolor='f7f7f7'><div align="center"><img src="image/icon.gif" width="11" height="11"> 전할말</div></td>
																	<td>
																		<table width="400" border="0" cellspacing="0" cellpadding="0">
																			<tr>
																				<td width="30">&nbsp;</td>
																				<td><textarea name="content" cols="55" rows="3"  class="text" ><?=$trade_row[content]?></textarea></td>
																			</tr>
																		</table>
																	</td>
																</tr>
																<tr>
																	<td colspan="2" height="1" background="image/line_bg1.gif"> </td>
																</tr>
																<tr>
																	<td width="150" height="25"  bgcolor='f7f7f7'><div align="center"><img src="image/icon.gif" width="11" height="11"> 주문관리<br>(관리자화면에서만 보입니다. 간단한 메모 및 취소/반품 사유 기록 등으로 쓰임)</div></td>
																	<td>
																		<table width="400" border="0" cellspacing="0" cellpadding="0">
																			<tr>
																				<td width="30">&nbsp;</td>
																				<td><textarea name="manaContent" cols="55" rows="10"  class="text" ><?=$trade_row[manaContent]?></textarea></td>
																			</tr>
																		</table>
																	</td>
																</tr>
																<tr>
																	<td colspan="2" height="1" background="image/line_bg1.gif"> </td>
																</tr>
															</table>
														</td>
													</tr>
													<tr valign="middle">
														<td>&nbsp;</td>
													</tr>
													</form>
													<tr valign="middle">
														<td height="50"><div align="center"><a href="javascript:tradeEdit();"><img src="image/btn_modify00.gif" border="0"></a>&nbsp;&nbsp;&nbsp;<a href="javascript:self.close();"><img src="image/bbs_list_btn.gif" width="41" height="23" border="0"></a>&nbsp;&nbsp;&nbsp;<a href="javascript:print('<?=$dataArr[idx]?>');"><img src="image/print_btn.gif" border="0"></a></div></td>
													</tr>
													<tr valign="middle">
														<td>&nbsp;</td>
													</tr>
												</table>
											</td>
										</tr>
									</table>
								</td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>
</body>
</html>