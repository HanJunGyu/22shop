<?
// 소스형상관리
// 20060720-1 소스수정 김성호 : 결제방식 정보 세분화(카드, 핸드폰, 계좌이체, 가상계좌, 무통장)
include "head.php";
?>
<SCRIPT LANGUAGE="JavaScript">
<!--
// 회원이 배송완료 처리
function trans_comple(tradecode)
{
	var form = document.form1;
	var form2 = document.form2;
	var good_arr = new Array();
	var comment_arr = new Array();
	var good_str = "";
	var comment_str = "";
	if (confirm("본 주문을 배송완료 처리하시겠습니까?"))
	{
		form.tradecode.value = tradecode;	
		num = form2.elements["goodsIdx"].length;
		// 상품이 여러개일때 
		if (num>1)
		{
			for (var i=0; i<num; i++)
			{
				good_arr[i] = form2.goodsIdx[i].value;
				comment_arr[i] = form2.comment[i].value;
				if (comment_arr[i]=="")
				{
					alert("제품평을 남겨주시면 감사하겠습니다.");
					form2.comment[i].focus();
					return false;
				}
			}
			good_str = good_arr.join("//");
			comment_str = comment_arr.join("//");
		}
		else
		{
			good_str = form2.goodsIdx.value;
			comment_str = form2.comment.value;
			if (comment_str=="")
			{
				alert("제품평을 남겨주시면 감사하겠습니다.");
				form2.comment.focus();
				return false;
			}
		}
		form.good_str.value = good_str;
		form.comment_str.value = comment_str;
		form.submit();
	}
}
function trade_cancel(tradecode)
{
	if (confirm("본 주문을 취소하시겠습니까?"))
	{
		var form = document.form1;
		form.tradecode.value = tradecode;
		form.cancel.value = "y";
		form.submit();
	}
	else
	{
	}
}
//-->
</SCRIPT>
<? include "top.php";?>
<form name="form1" action="mypage_order_status.php" method="post">
<input type="hidden" name="tradecode" value="">
<input type="hidden" name="guest" value="y">
<input type="hidden" name="good_str" value="">
<input type="hidden" name="comment_str" value="">
<input type="hidden" name="cancel" value="">
</form>
<table width="900" border="0" cellspacing="0" cellpadding="0" bgcolor="<?=$ALL_BGCOLOR?>">
	<tr>
		<? include "left_menu.php";?>
		<td height="51" valign="top" width="720" bgcolor="#FFFFFF">
			<table width="720" height="100%" border="0" cellspacing="0" cellpadding="0">
				<tr bgcolor="#FFFFFF" valign="top">
					<td colspan="2" height="51">
						<table width="720" height="35" border="0" cellspacing="0" cellpadding="0" align='center'>
							<tr>
								<td width="2"  bgcolor="<?=$subdesign[bc7]?>" rowspan="2"></td>
								<td width="2"  bgcolor="<?=$subdesign[bc7]?>" rowspan="2"></td>
								<td width="220" height="27" bgcolor="<?=$subdesign[bc7]?>"><img src="./upload/design/<?=$subdesign[img7]?>" ></td>
								<td width="490" height="27" bgcolor="<?=$subdesign[bc7]?>"><div align="right">&nbsp;<font color="<?=$subdesign[tc7]?>"> &nbsp; 현재위치 : HOME &gt; 주문내역조회</font>&nbsp;</div></td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td valign="top">
						<table width="670" border="0" cellspacing="0" cellpadding="0" align="center">
							<tr>
								<td><img src='image/sub/img_order.gif'></td>
							</tr>
						</table>
						<table width="670" border="0" cellspacing="0" cellpadding="0" align="center">
							<tr>
								<td>
									<table width="670" border="0" cellspacing="0" cellpadding="0" height="25" align="center">
										<tr>
											<td colspan='11' bgcolor='80c9d8' height='2'></td>
										</tr>
										<tr>
											<td colspan='11' bgcolor='ffffff' height='1'></td>
										</tr>
										<tr bgcolor="edf7f9" align="center" height='30'>
											<td width="240"><font color='006676'><b>상품명</b></font></td>
											<td width='1'><img src='image/board/line.gif'></td>
											<td width="100" align="center"><font color='006676'><b>옵션</b></font></td>
											<td width='1'><img src='image/board/line.gif'></td>
											<td width="100" align="center"><font color='006676'><b>구입가</b></font></td>
											<td width='1'><img src='image/board/line.gif'></td>
											<td width="38" align="center"><font color='006676'><b>수량</b></font></td>
											<td width='1'><img src='image/board/line.gif'></td>
											<td width="76" align="center"><font color='006676'><b>합계</b></font></td>
											<td width='1'><img src='image/board/line.gif'></td>
											<td width="80" align="center"><font color='006676'><b>주문상태</b></font></td>
										</tr>
										<tr>
											<td colspan='11' bgcolor='ffffff' height='1'></td>
										</tr>
										<tr>
											<td colspan='11' bgcolor='80c9d8' height='1'></td>
										</tr>
									</table>
								</td>
							</tr>
							<tr>
								<td valign="top">
									<table width="670" border="0" cellspacing="0" cellpadding="0" height="25" align="center"><?
									$trade_row = $MySQL->fetch_array("select *from trade where tradecode='$tradecode'");
									if($trade_row[payMethod] =="card") $payMethod="<B>카드결제</B> [".$trade_row[bankInfo]."]";
									elseif($trade_row[payMethod] =="hand") $payMethod="<B>휴대폰</B> [".$trade_row[bankInfo]."]";
									elseif($trade_row[payMethod] =="iche") $payMethod="<B>계좌이체</B> [".$trade_row[bankInfo]."]";
									elseif($trade_row[payMethod] =="cyber") $payMethod="<B>가상계좌</B> [".$trade_row[bankInfo]."]";
									elseif($trade_row[payMethod] =="bank") $payMethod="<B>무통장</B> [".$trade_row[bankInfo]."]";
									$encode_str = "idx=".$trade_row[idx]."&pagecnt=".$pagecnt."&letter_no=".$s_letter."&offset=".$offset;
									$encode_str.= "&search=".$search."&searchstring=".$searchstring."&present_num=".$letter_no;
									$data=Encode64($encode_str);					//각 레코드 정보
									$trade_goods_qry ="select *from trade_goods where tradecode='$trade_row[tradecode]'";
									$trade_goods_result = $MySQL->query($trade_goods_qry);
									$formCnt =0;
									while($trade_goods_row = mysql_fetch_array($trade_goods_result))
									{
										$formCnt++;
										$goods_qry    = "select *from goods where idx=$trade_goods_row[goodsIdx]";
										$goods_result = $MySQL->query($goods_qry);
										$goods_row    = mysql_fetch_array($goods_result);	//상품정보
										$optionArr = Array("$trade_goods_row[option1]","$trade_goods_row[option2]","$trade_goods_row[option3]");   //옵션 배열
										$tprice = $trade_goods_row[price]*$trade_goods_row[cnt]; //상품합가격 
										if (empty($GD_SET) && $goods_row[img_onetoall]) $img_str = $goods_row[img3];
										else if ($GD_SET && $goods_row[img_onetoall] && empty($goods_row[img1])) $img_str = $goods_row[img3];
										else if ($GD_SET && empty($goods_row[img_onetoall]) && empty($goods_row[img1])) $img_str = $goods_row[img3];
										else $img_str = $goods_row[img1];

										// 배송사, 송장번호 저장
										if ($trade_goods_row[trans_company]) $trans_info[$formCnt].= $trade_goods_row[trans_company].":".$trade_goods_row[trans_num];
										if ($trade_goods_row[status]==2 || $trade_goods_row[status]==3) /// 배송중,배송완료일때 배송추적 링크생김
										{
											$trans_com_url = $admin_row[trans_com_url];
											if ($trans_com_url)
											{
												$trans_info[$formCnt].= "&nbsp;&nbsp;&nbsp;<a href='http://$trans_com_url' target='_blank'><b>[배송추적]</b></a>";
											}
										}
										?>
										<tr>
											<td width="50" height="25" align="center"><img src="./upload/goods/<?=$img_str?>" width="40" height="40"></td>
											<td width="190" height="25" align="center"><?=$trade_goods_row[name]?></td>
											<td width="100" height="25" align="center"><div align="center">
												<table width="100" border="0" cellspacing="0" cellpadding="0"><?
												for($i=0;$i<count($optionArr);$i++)
												{
													if(!empty($optionArr[$i]))
													{
														$option = explode("」「",$optionArr[$i]);
														?>
													<tr>
														<td width="45"  bgcolor="#F7F7F7"> <div align="center"><?=$option[0]?> </div></td>
														<td   bgcolor="#DDFFFB"> <div align="left"> : <?=$option[1]?></div></td>
													</tr>
													<tr  bgcolor="#CCCCCC">
														<td colspan="2" height="1"></td>
													</tr><?
													}
												}
												?>
												</table></div>
											</td>
											<td width="100" height="25" align="right"><?=PriceFormat($trade_goods_row[price])?> 원</td>
											<td width="38" height="25" align="center"><?=$trade_goods_row[cnt]?></td>
											<td width="76" height="25" align="right"><FONT COLOR="#ff4800"><b><?=PriceFormat($tprice)?> 원</b></FONT></td>
											<td width="80" height="25" align="center"><B><?=$TRADE_ARR[$trade_goods_row[status]]?></B></td>
										</tr>
										<tr>
											<td colspan="7" height="1" bgcolor='e1e1e1'></td>
										</tr><?
									}
									?>
									</table>
								</td>
							</tr>
							<tr>
								<td height="30">
									<table width="670" border="0" cellspacing="1" cellpadding="0">
										<tr>
											<td height="30" align="right"> 총 합계 : <b><font color="#FF0000"><?=PriceFormat($trade_row[totalM])?> 원</font></b> [배송비 : <font color="#FF0000"><?=PriceFormat($trade_row[transM])?></font> , 사용적립금 <font color="#FF0000"><?=PriceFormat($trade_row[useP])?></font> 원] </td>
										</tr>
									</table>
								</td>
							</tr>
						</table><br><br>
						<table width="670" border="0" cellspacing="0" cellpadding="0" align="center">
							<tr>
								<td colspan='2' bgcolor='80c9d8' height='2'></td>
							</tr>
							<tr>
								<td colspan='2' bgcolor='ffffff' height='1'></td>
							</tr>
							<tr>
								<td height="30" colspan="2" bgcolor="#edf7f9"><b><font color='006676'> &nbsp;&nbsp;주문 정보</b></font></td>
							</tr>
							<tr>
								<td colspan='2' bgcolor='80c9d8' height='1'></td>
							</tr>
							<tr>
								<td height="25" width="150" bgcolor="f4f4f4" align="center"> &nbsp;주문코드</td>
								<td height="25"> &nbsp;&nbsp;<FONT COLOR="#76872e"><B><?=$trade_row[tradecode]?></B></FONT></td>
							</tr>
							<tr>
								<td height="1" colspan="2" bgcolor='e1e1e1'></td>
							</tr>
							<tr>
								<td height="25" width="150" bgcolor="f4f4f4" align="center"> &nbsp;주문일자</td>
								<td height="25"> &nbsp;&nbsp;<?=$trade_row[writeday]?></td>
							</tr>
							<tr>
								<td height="1" colspan="2" bgcolor='e1e1e1'></td>
							</tr>
							<tr>
								<td height="25" width="150" bgcolor="f4f4f4" align="center"> &nbsp;배송사/송장번호</td>
								<td height="25"> &nbsp;&nbsp;<?
								if (sizeof($trans_info))
								{
									foreach ($trans_info as $key => $value)
									{
										echo $value."&nbsp;&nbsp;";
									}
								}
								?></td>
							</tr>
							<tr>
								<td height="1" colspan="2" bgcolor='e1e1e1'></td>
							</tr>
						</table><br><br>
						<table width="670" border="0" cellspacing="0" cellpadding="0" align="center">
							<tr>
								<td colspan='2' bgcolor='80c9d8' height='2'></td>
							</tr>
							<tr>
								<td colspan='2' bgcolor='ffffff' height='1'></td>
							</tr>
							<tr>
								<td height="30" colspan="2" bgcolor="#edf7f9"><font color='006676'><b> &nbsp;&nbsp;결제 정보</b></font></td>
							</tr>
							<tr>
								<td colspan='2' bgcolor='80c9d8' height='1'></td>
							</tr>
							<tr>
								<td height="25" width="150" bgcolor="f4f4f4" align="center"> &nbsp;총상품 금액</td>
								<td height="25"> &nbsp;&nbsp;<?=PriceFormat($trade_row[totalM])?> 원</td>
							</tr>
							<tr>
								<td height="1" colspan="2" bgcolor='e1e1e1'></td>
							</tr>
							<tr>
								<td height="25" width="150" bgcolor="f4f4f4" align="center"> &nbsp;사용 적립금</td>
								<td height="25"> &nbsp;&nbsp;<?=PriceFormat($trade_row[useP])?> 원</td>
							</tr>
							<tr>
								<td height="1" colspan="2" bgcolor='e1e1e1'></td>
							</tr>
							<tr>
								<td height="25" width="150" bgcolor="f4f4f4" align="center"> &nbsp;배 송 비</td>
								<td height="25"> &nbsp;&nbsp;<?=PriceFormat($trade_row[transM])?> 원</td>
							</tr>
							<tr>
								<td height="1" colspan="2" bgcolor='e1e1e1'></td>
							</tr>
							<tr>
								<td height="25" width="150" bgcolor="f4f4f4" align="center"> &nbsp;총 결제 금액</td>
								<td height="25"> &nbsp;&nbsp;<FONT COLOR="#ff4800"><B><?=PriceFormat($trade_row[payM])?></B> 원</FONT></td>
							</tr>
							<tr>
								<td height="1" colspan="2" bgcolor='e1e1e1'></td>
							</tr>
							<tr>
								<td height="25" width="150" bgcolor="f4f4f4" align="center"> &nbsp;결제 방법</td>
								<td height="25"> &nbsp;&nbsp;<?=$payMethod?></td>
							</tr>
							<tr>
								<td height="1" colspan="2" bgcolor='e1e1e1'></td>
							</tr>
						</table><br><br>
						<table width="670" border="0" cellspacing="0" cellpadding="0" align="center">
							<tr>
								<td colspan='4' bgcolor='80c9d8' height='2'></td>
							</tr>
							<tr>
								<td colspan='4' bgcolor='ffffff' height='1'></td>
							</tr>
							<tr>
								<td height="30" bgcolor="#edf7f9" colspan="2"><font color='006676'><b> &nbsp;&nbsp;주문자 정보</b></font></td>
								<td height="30" bgcolor="#edf7f9" colspan="2"><font color='006676'><b> &nbsp;&nbsp;수령자 정보</b></font></td>
							</tr>
							<tr>
								<td colspan='4' bgcolor='80c9d8' height='1'></td>
							</tr>
							<tr>
								<td height="25" width="100" bgcolor="f4f4f4">&nbsp;&nbsp;&nbsp;성 명</td>
								<td height="25" width="200"> &nbsp;<?=$trade_row[name]?></td>
								<td height="25" width="100" bgcolor="f4f4f4">&nbsp;&nbsp;&nbsp;성 명</td>
								<td height="25" width="200"> &nbsp;<?=$trade_row[rname]?></td>
							</tr>
							<tr>
								<td height="1" colspan="4" bgcolor='e1e1e1'></td>
							</tr>
							<tr>
								<td height="25" width="100" bgcolor="f4f4f4">&nbsp;&nbsp;&nbsp;이 메 일</td>
								<td height="25" width="200"> &nbsp;<?=$trade_row[email]?></td>
								<td height="25" width="100" bgcolor="f4f4f4">&nbsp;&nbsp;&nbsp;이 메 일</td>
								<td height="25" width="200"> &nbsp;<?=$trade_row[remail]?></td>
							</tr>
							<tr>
								<td height="1" colspan="4" bgcolor='e1e1e1'></td>
							</tr>
							<tr>
								<td height="25" width="100" bgcolor="f4f4f4">&nbsp;&nbsp;&nbsp;전화번호</td>
								<td height="25" width="200"> &nbsp;<?=$trade_row[tel]?></td>
								<td height="25" width="100" bgcolor="f4f4f4">&nbsp;&nbsp;&nbsp;전화번호</td>
								<td height="25" width="200"> &nbsp;<?=$trade_row[rtel]?></td>
							</tr>
							<tr>
								<td height="1" colspan="4" bgcolor='e1e1e1'></td>
							</tr>
							<tr>
								<td height="25" width="100" bgcolor="f4f4f4">&nbsp;&nbsp;&nbsp;휴대폰번호</td>
								<td height="25" width="200"> &nbsp;<?=$trade_row[hand]?> &nbsp;&nbsp;&nbsp; </td>
								<td height="25" width="100" bgcolor="f4f4f4">&nbsp;&nbsp;&nbsp;휴대폰번호</td>
								<td height="25" width="200"> &nbsp;<?=$trade_row[rhand]?>&nbsp;&nbsp; </td>
							</tr>
							<tr>
								<td height="1" colspan="4" bgcolor='e1e1e1'></td>
							</tr>
							<tr>
								<td height="25" width="100" bgcolor="f4f4f4">&nbsp;&nbsp;&nbsp;주 소</td>
								<td height="25" width="200"> &nbsp;[<?=$trade_row[zip]?>]<br> &nbsp;<?=$trade_row[adr]?> <?=$trade_row[adr1]?> </td>
								<td height="25" width="100" bgcolor="f4f4f4">&nbsp;&nbsp;&nbsp;주 소</td>
								<td height="25" width="200"> &nbsp;[<?=$trade_row[rzip]?>]<br> &nbsp;<?=$trade_row[radr1]?> <?=$trade_row[radr2]?> </td>
							</tr>
							<tr>
								<td height="1" colspan="4" bgcolor="e1e1e1"></td>
							</tr>
						</table><?
						/////////////////// 주문접수일때 주문취소 기능///////////////////// 
						if ($trade_row[status]==0)
						{
							?><br><br>
						<table width="670" border="0" cellspacing="0" cellpadding="0" align="center">
							<tr>
								<td bgcolor='80c9d8' height='2'></td>
							</tr>
							<tr>
								<td bgcolor='ffffff' height='1'></td>
							</tr>
							<tr>
								<td height="30" bgcolor="#edf7f9"><font color='006676'><b>&nbsp;&nbsp;주문취소</b></font></td>
							</tr>
							<tr>
								<td bgcolor='80c9d8' height='1'></td>
							</tr>
							<tr>
								<td height="30" bgcolor="#ffffff"><b> &nbsp;&nbsp;<img src='image/icon/order_cancel.gif' onclick="trade_cancel('<?=$trade_row[tradecode]?>');" style='cursor:pointer' align='absmiddle'>&nbsp;※ 결제확인이 되기전에는 주문을 취소하실수 있습니다. </b></td>
							</tr>
							<tr>
								<td bgcolor='e1e1e1' height='1'></td>
							</tr>
						</table><?
						}
						/////////////////// 배송중일때 ///////////////////// 
						if ($MySQL->articles("SELECT idx from trade_goods WHERE tradecode='$trade_row[tradecode]' and status=2 limit 1"))
						{
							?><br><br>
						<table width="600" border="1" cellspacing="0" cellpadding="0" align="center" class="table_coll">
							<tr>
								<td>
									<form name="form2" method="post">
									<table width=100% cellspacing="0" cellpadding="5" border=0>
										<tr align="center" bgcolor="f4f4f4">
											<td colspan="3" height="30"><b>제 품 구 매 후 기</b></td>
										</tr><?
										$trade_goods_qry ="select *from trade_goods where tradecode='$trade_row[tradecode]'";
										$trade_goods_result = $MySQL->query($trade_goods_qry);
										$formCnt =0; 
										while($trade_goods_row = mysql_fetch_array($trade_goods_result))
										{
											$goods_row    = $MySQL->fetch_array("select *from goods where idx=$trade_goods_row[goodsIdx]");
											if (empty($GD_SET) && $goods_row[img_onetoall]) $img_str = $goods_row[img3];
											else if ($GD_SET && $goods_row[img_onetoall] && empty($goods_row[img1])) $img_str = $goods_row[img3];
											else if ($GD_SET && empty($goods_row[img_onetoall]) && empty($goods_row[img1])) $img_str = $goods_row[img3];
											else $img_str = $goods_row[img1];
											?>
										<input type="hidden" name="goodsIdx" value="<?=$trade_goods_row[goodsIdx]?>">
										<tr>
											<td width="50" height="25" align="center"><img src="./upload/goods/<?=$img_str?>" width="60" height="60"></td>
											<td width="180" height="25" align="center"><?=$trade_goods_row[name]?></td>
											<td><textarea name="comment" class="box" rows="5" cols="60"></textarea></td>
										</tr><?
										}
										?>
									</table>
								</td>
							</tr>
							<tr align="center">
								<td height="50"><b>주문하신 제품을 정상적으로 배송 받으셨다면 여기를 클릭해주시기 바랍니다.▶▶</b>&nbsp;<img align="absmiddle" src="image/trans_comple.jpg" style="cursor:pointer" onclick="trans_comple('<?=$trade_row[tradecode]?>');"><br><img src="image/icon/blue_bullet.gif"><font color="#999999"> 배송완료 처리가 되어야만 <b><? if ($admin_row[bUsepoint] && $GOOD_SHOP_PART=="member"){ ?>적립금 적립 및 <? } ?> 최종적으로 주문완료처리</b>가 되어집니다.</font> <?
								if ($admin_row[bUsepoint] && $admin_row[write_goodsP] && $GOOD_SHOP_PART=="member")
								{
									?><br><img src="image/icon/blue_bullet.gif"><font color="#999999"> 구매후기 작성시 <b><?=PriceFormat($admin_row[write_goodsP])?> 원</b> 의 적립금이 지급됩니다.</font> <?
								}
								?></td>
							</tr>
							</form>
						</table><?
						}
						?>
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