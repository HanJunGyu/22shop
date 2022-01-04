<?
// 소스형상관리
// 20060720-1 소스수정 김성호 : 결제방식 정보 세분화(카드, 핸드폰, 계좌이체, 가상계좌, 무통장)
//								결제관련 정보($pG_Cracked)내용기록 강화
// 20060724-1 파일추가 김성호 : 설명문구수정
include "head.php";
/////////선택한 주문 삭제///////////
if ($select_del=="y")
{
	$str_arr = explode("/",$str);
	for ($i=0; $i<count($str_arr); $i++)
	{
		$row = $MySQL->fetch_array("SELECT tradecode from trade WHERE idx='$str_arr[$i]' limit 1");
		if ($row[tradecode])
		{
			$qry="DELETE from trade WHERE tradecode='$row[tradecode]'";
			$MySQL->query($qry);		
			$qry="DELETE from trade_goods WHERE tradecode='$row[tradecode]'";
			$MySQL->query($qry);
		}
	}
	OnlyMsgView("완료하였습니다.");
	Refresh("trade_order.php");
	exit;
}

include "../lib/class.php";
$trans_start=0;	// 주문상태 일괄변경 시작위치 (주문접수)
$trans_company = $admin_row[transCom];	//배송사

$now = time();
$now = date("Y-m-d",$now);
$now = explode("-",$now);

if (!$year) // 날짜조건없을떄
{
	$year = $now[0] - 1;
	$month = $now[1];
	$day = $now[2];
	$year2 = $now[0];
	$month2 = $now[1];
	$day2 = $now[2];

	if (strlen($day)==1) $day = "0".$day;
	if (strlen($month)==1) $month = "0".$month;
	if (strlen($day2)==1) $day2 = "0".$day2;
	if (strlen($month2)==1) $month2 = "0".$month2;
	$start = $year."-".$month."-".$day;
	$end = $year2."-".$month2."-".$day2;
}
else // 날짜조건있을때
{
	if (strlen($day)==1) $day = "0".$day;
	if (strlen($month)==1) $month = "0".$month;
	if (strlen($day2)==1) $day2 = "0".$day2;
	if (strlen($month2)==1) $month2 = "0".$month2;
	$start = $year."-".$month."-".$day;
	$end = $year2."-".$month2."-".$day2;
}
?>
<SCRIPT LANGUAGE="JavaScript">
<!--
var tradeArr = new Array();
<?
for($i=0;$i<count($TRADE_ARR);$i++)
{
	?>
tradeArr[<?=$i?>] = "<?=$TRADE_ARR[$i]?>";
<?
}
?>

//////////////////// 거래상태 일괄변경
function goodsChangeStatus2(changeIndex)
{
	changeIndex = changeIndex -1;

	var trans_Index = 2;
	var trans_Index2 = 3;
	if (document.all.status_id.selectedIndex == 0)
	{
		alert("변경할 거래상태를 선택해주십시오.");
	}
	else if (document.viewForm.select_str.value == "")
	{
		alert("변경할 주문목록을 선택해주십시오.");
	}
	else if (changeIndex==trans_Index || changeIndex==trans_Index2)	//////////// 배송중,배송완료로 바꿀때만 선택한 항목들의 송장번호 체크함
	{
		var selectstr_Arr = new Array();
		var err_form="";
		var selectstr_Arr = document.viewForm.select_str.value.split("/");
		var formno_Arr = document.viewForm.formno_str.value.split("/");
		var tn;
		for (var i=0; i < selectstr_Arr.length -1 ; i++)
		{
			var transForm = eval("document.goodtype_form"+formno_Arr[i]);
			if (transForm.trans_num.value)
			{
				tn = transForm.trans_num.value;
			}
			else
			{
				tn = 0;
			}
			if (transForm.trans_num.value=="" || transForm.trans_num.value==0)
			{
				err_form = err_form + (parseInt(formno_Arr[i])+1) + ", ";	///////////// 송장번호 입력안된 목록상의 번호들 저장
				transForm.idxno.checked = false;
				idxno_click("false",selectstr_Arr[i],formno_Arr[i],tn);	//////// 추후 송장번호를 입력하면 갱신이 안되므로 체크박스를 강제로 끈다
			}
		}
		if (err_form)  ///////////// 배송사,송장번호 입력안된 목록상의 번호들 경고창으로 출력
		{
			alert(err_form + "번 항목의 배송사 또는 송장번호가 입력되지 않았습니다. 입력후 해당 체크박스를 다시 선택해주십시오.");
		}
		else
		{
			//CONFIRM WINDOW
			var choose = confirm("선택한 항목의 거래상태를 변경합니다. \n\n["+tradeArr[changeIndex]+"] 상태로 변경하시겠습니까?");
			if(choose)
			{
				document.viewForm.status.value = changeIndex;
				document.viewForm.target = "ifrm";
				document.viewForm.submit();
			}
			else
			{
				return;
			}
		}
	}
	else
	{
		document.viewForm.status.value = changeIndex;
		document.viewForm.target = "ifrm";
		document.viewForm.submit();
	}
}

//////////일괄선택한 주문 삭제////
function del_select_item()
{
	if (confirm("선택하신 주문서를 영구 삭제하시겠습니까?"))
	{
		location.href="trade_order.php?select_del=y&str="+document.viewForm.select_str.value;	
	}
}

///////////일괄선택//////////////////
function checkAll()
{
	var str="";
	var formno="";
	var transnum_str="";
	for (var i=0; i<document.forms.length; i++)
	{
		var formname = document.forms[i].name;
		var formname_str = formname.substring(0,13);
		if (formname_str == "goodtype_form")
		{
			for (var j=0;j<document.forms[i].elements.length -1 ;j++)
			{
				if (document.forms[i].elements[j].name == "idxno")
				{
					if (document.forms[i].elements["idxno"].checked == true)
					{
						document.forms[i].elements["idxno"].checked = false;
						str="";
						formno="";
						transnum_str="";
					}
					else
					{
						document.forms[i].elements["idxno"].checked = true;
						str = document.forms[i].elements["idxno"].value + "/" + str;
						formno = document.forms[i].elements["formno"].value + "/" + formno;
						transnum_str = document.forms[i].elements["trans_num"].value + "/" + transnum_str;
					}
				}
			}
		}
	}
	document.viewForm.select_str.value = str;
	document.viewForm.formno_str.value = formno;
	document.viewForm.transnum_str.value = transnum_str;
}

///////////////개별선택/////////////////////
function idxno_click(bCheck,val,formcnt,transnum)
{
	if (bCheck == true && document.all.status_id.value=="" && document.all.sel_del.selectedIndex==0)
	{
		alert("먼저 변경할 거래상태를 체크 또는 \n주문서 삭제시에는 위의 선택부분을 삭제로 선택해 주십시오.");
		var Obj = eval("document.goodtype_form"+formcnt);
		Obj.idxno.checked = false;
	}
	else if (bCheck == true)
	{
		/// 거래상태를 배송중,배송완료로 바꾸려고 할때 체크박스를 먼저 눌르면 (송장번호 입력안한채) 경고
		if ((document.all.status_id.value==2 || document.all.status_id.value==3) && transnum==0)
		{
			var Obj = eval("document.goodtype_form"+formcnt);
			alert("거래상태를 배송중, 배송완료로 바꾸려면 체크박스에 표시전에 미리 송장번호를 입력해야 합니다.");
			Obj.idxno.checked = false;
			var tgood_obj = eval("document.all.tgood_id"+formcnt);
			tgood_obj.style.display = "inline";
			Obj.trans_num.focus();
		}
		else
		{
			var str= document.viewForm.select_str.value;
			var formno= document.viewForm.formno_str.value;
			var transnum_str= document.viewForm.transnum_str.value;
			str = val + "/" + str;
			formno = formcnt + "/" + formno;
			transnum_str = transnum + "/" + transnum_str;
			document.viewForm.select_str.value = str;
			document.viewForm.formno_str.value = formno;
			document.viewForm.transnum_str.value = transnum_str;
		}
	}
	else ////////// 체크해제시 해당 내용 제거 ( '/' 문자열 체크)
	{
		var str="";
		var formno="";
		var transnum_str="";
		for (var i=0; i<document.forms.length; i++)
		{
			var formname = document.forms[i].name;
			var formname_str = formname.substring(0,13);
			if (formname_str == "goodtype_form")
			{
				for (var j=0;j<document.forms[i].elements.length -1 ;j++)
				{
					if (document.forms[i].elements[j].name == "idxno")
					{
						if (document.forms[i].elements["idxno"].checked == true)
						{
							str = document.forms[i].elements["idxno"].value + "/" + str;
							formno = document.forms[i].elements["formno"].value + "/" + formno;
							transnum_str = document.forms[i].elements["trans_num"].value + "/" + transnum_str;
						}
						else
						{
						}
					}
				}
			}
		}
		document.viewForm.select_str.value = str;
		document.viewForm.formno_str.value = formno;
		document.viewForm.transnum_str.value = transnum_str;
	}
}

function searchSendit()
{
	var form=document.searchForm;
	form.bSearch.value = "true";
	form.submit();
}

function tradeTotalMail()
{
	window.open("../email/mail.php?trade=1","","scrollbars=yes,left=200,top=50,width=620,height=530");
}

function del_trade(year,month,day)
{
	var tmp_day = year+"年"+month+"月"+day+"日";
	if (confirm(tmp_day + " 이전의 주문정보를 삭제하시겠습니까?"))
	{
		document.delForm.submit();
	}
}

function trade_order_view(data)
{
	window.open("trade_order_view.php?data="+data,"","scrollbars=yes,left=10,top=10,width=800,height=700");
}

function trade_goods()
{
	window.open("trade_goods.php","","scrollbars=yes,left=10,top=10,width=800,height=700");
}

function trade_goods_trans()
{
	window.open("trade_goods_trans.php","","scrollbars=yes,left=10,top=10,width=1000,height=700");
}

function trade_trans()
{
<?
	switch($admin_row[transCom])
	{
		case '대한통운':
			echo "	location.href='trade_trans_dh.php';\n";
			break;
		case '우체국':
			echo "	location.href='trade_trans_post.php';\n";
			break;
		case 'CJ GLS택배':
			echo "	location.href='trade_trans_cj.php';\n";
			break;
		case '현대택배':
			echo "	location.href='trade_trans_hd.php';\n";
			break;
		case '한진택배':
			echo "	location.href='trade_trans_hd.php';\n";
			break;
		case '삼성택배':
			echo "	location.href='trade_trans_sam.php';\n";
			break;
		case '트라넷택배':
			echo "	location.href='trade_trans_tranet.php';\n";
			break;
		default :
			echo "	alert('해당업체에 관련된 송장엑셀파일은 구현되어 있지 않습니다.');\n";
			break;
	}
?>
}

function tg_show(cnt)
{
	obj = eval("document.getElementById('tgood_id"+cnt+"')");
	obj1 = eval("document.getElementById('tgood_id"+cnt+"_1')");
	if (obj.style.display == "block")
	{
		obj.style.display = "none";
		obj1.style.display = "block";
	}
	else if (obj.style.display == "none")
	{
		obj.style.display = "block";
		obj1.style.display = "none";
	}
}
//-->
</SCRIPT>
<?
if ($admin_row[bTrade])
{
	?>
<meta http-equiv='refresh' content='120'>
<?
}
	?>
<body bgcolor="#FFFFFF" text="#5A595A" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<? include "top_menu.php"; ?>
<form name="viewForm" method="post" action="status_change.php">
<input type="hidden" name="status_list_change" value="y">	<!-- 목록상에서 거래상태변경임을 status_change.php 에 통보 -->
<input type="hidden" name="select_str" value="">	<!-- 주문 idx 저장문자 -->
<input type="hidden" name="formno_str" value="">	<!-- goodType_form $cnt 번호 저장문자-->
<input type="hidden" name="transnum_str" value="">	<!-- 송장번호 저장문자 -->
<input type="hidden" name="status" value="">	<!--  바꿀 거래상태 -->
</form>
<iframe name="ifrm" frameborder=0 width=0 height=0></iframe>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr><?
	$__TOP_MENU = "order";     //왼쪽 소메뉴 설정 변수
	include "left_menu.php";
		?>
		<td width="85%" valign="top" height="400">
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td height='5'></td>
				</tr>
				<tr>
					<td>
						<table width="800" border="0" cellspacing="0" cellpadding="0" align='center'>
							<tr>
								<td rowspan="3" width="200"><img src="image/order_tit_img.gif"></td>
								<td>&nbsp;</td>
							</tr>
							<tr>
								<td bgcolor="#E6E6E6" height='26'><div align='right'><font class='text1'>SHOP 주문내역 수정 삭제 등을 하실수 있습니다.&nbsp;</div></td>
							</tr>
							<tr>
								<td>&nbsp;</td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td>
						<table width="800" border="0" cellspacing="0" cellpadding="0" align="center">
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
						<table width="800" border="0" cellspacing="0" cellpadding="0" align="center">
							<tr>
								<td valign="top">
									<form name="searchForm" method="post" action="trade_order.php">
									<input type='hidden' name='bSearch' value='<?=$bSearch?>'>
									<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
										<!-- -------------------------------------------------주문 검색 시작----------------------------------------------------------- -->
										<tr>
											<td height="30"  width="90%">
												<table width="800" border="0" align="center" bgcolor="#F5F5F5">
													<tr>
														<td valign=middle colspan="5">
														<select name="paym">
															<option value="0" <? if (!$paym) echo "selected";?>>▶결제방법</option>
															<option value="card" <? if ($paym=="card") echo "selected";?>>카드결제</option>
															<option value="hand" <? if ($paym=="hand") echo "selected";?>>핸드폰</option>
															<option value="iche" <? if ($paym=="iche") echo "selected";?>>계좌이체</option>
															<option value="cyber" <? if ($paym=="cyber") echo "selected";?>>가상계좌</option>
															<option value="bank" <? if ($paym=="bank") echo "selected";?>>무통장입금</option>
														</select>
														<select name="status">
															<option value="6" <? if (!isset($status)) echo "selected";?>>▶거래상태</option>
															<option value="0" <? if (isset($status) && $status==0) echo "selected";?>><?=$TRADE_ARR[0]?></option>
															<option value="1" <? if ($status==1) echo "selected";?>><?=$TRADE_ARR[1]?></option>
															<option value="2" <? if ($status==2) echo "selected";?>><?=$TRADE_ARR[2]?></option>
															<option value="3" <? if ($status==3) echo "selected";?>><?=$TRADE_ARR[3]?></option>
															<option value="4" <? if ($status==4) echo "selected";?>><?=$TRADE_ARR[4]?></option>
															<option value="5" <? if ($status==5) echo "selected";?>><?=$TRADE_ARR[5]?></option>
														</select>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
														<select name="search">
															<!--<option value="0" selected>▶기본검색</option>-->
															<option value="name" <? if ($search=="name") echo "selected";?>>주문자명</option>
															<option value="tradecode" <? if ($search=="tradecode") echo "selected";?>>주문코드</option>
															<option value="userid" <? if ($search=="userid") echo "selected";?>>주문자아이디</option>
															<option value="rname" <? if ($search=="rname") echo "selected";?>>수령인</option>
														</select>
														<input class="box" type="text" name="searchstring" size="15" value="<?=$searchstring?>">
														<!--<a href="javascript:searchSendit();"><img src="image/bbs_search_btn.gif" width="41" height="23" border="0"></a>-->
														<input onfocus="this.blur()" value="검 &nbsp;&nbsp;색" type="button" style="font-weight:bold;background-color:black;color:white" onclick="searchSendit()">
														</td>
													</tr>
												</table>
											</td>
										</tr>
										<tr>
											<td height="30" bgcolor="#ffffff">
												<table width="800" border="0" align="center">
													<tr bgcolor="#F5F5F5">
														<td width="680">
															<select name="year"><?
															for ($i=$now[0]; $i>1999; $i--)
															{
																if(strlen($i)==1) $real_date_data = "0".$i;
																else		$real_date_data = $i;
																?>
																<option value="<?=$real_date_data?>" <? if ($real_date_data == $year) echo "selected";?>><?=$i?></option><?
															}
																?>
															</select>년
															<select name="month"><?
															for ($i=1; $i<13; $i++)
															{
																if(strlen($i)==1) $real_date_data = "0".$i;
																else		$real_date_data = $i;
																?>
																<option value="<?=$real_date_data?>" <? if ($real_date_data == $month) echo "selected";?>><?=$i?></option><?
															}
																?>
															</select>월
															<select name="day"><?
															for ($i=1; $i<32; $i++)
															{
																if(strlen($i)==1) $real_date_data = "0".$i;
																else		$real_date_data = $i;
																?>
																<option value="<?=$real_date_data?>" <? if ($real_date_data == $day) echo "selected";?>><?=$i?></option><?
															}
																?>
															</select>일 ~ 
															<select name="year2"><?
															for ($i=$now[0]; $i>1999; $i--)
															{
																if(strlen($i)==1) $real_date_data = "0".$i;
																else		$real_date_data = $i;
															?>
																<option value="<?=$real_date_data?>" <? if ($real_date_data == $year2) echo "selected";?>><?=$i?></option><?
															}
																?>
															</select>년
															<select name="month2"><?
															for ($i=1; $i<13; $i++)
															{
																if(strlen($i)==1) $real_date_data = "0".$i;
																else		$real_date_data = $i;
																?>
																<option value="<?=$real_date_data?>" <? if ($real_date_data == $month2) echo "selected";?>><?=$i?></option><?
															}
																?>
															</select>월
															<select name="day2"><?
															for ($i=1; $i<32; $i++)
															{
																if(strlen($i)==1) $real_date_data = "0".$i;
																else		$real_date_data = $i;
																?>
																<option value="<?=$real_date_data?>" <? if ($real_date_data == $day2) echo "selected";?>><?=$i?></option><?
															}
																?>
															</select>일&nbsp;&nbsp;<a href="javascript:tradeTotalMail();"><img src="image/mail_all.gif" height="23" border="0"></a><?
															if ($status==6 || !isset($status))
															{
																?>&nbsp;<a href="trade_order_excel.php?paym=<?=$paym?>&search=<?=$search?>&searchstring=<?=$searchstring?>&start=<?=$start?>&end=<?=$end?>"><img src='image/excel_down.gif' border='0'></a><?
															}
															else
															{
																?>&nbsp;<a href="trade_order_excel.php?status=<?=$status?>&paym=<?=$paym?>&search=<?=$search?>&searchstring=<?=$searchstring?>&start=<?=$start?>&end=<?=$end?>"><img src='image/excel_down.gif' border='0'></a><?
															}
																?>
														</td>
													</tr>
													<tr>
														<td>
															<table>
																<tr>
																	<td><a href="#;" onclick="trade_goods();"><img src="../admin/image/trade_goods.gif"></a></td>
																	<td>&nbsp;&nbsp;▷&nbsp;&nbsp;</td>
																	<td><a href="#;" onclick="trade_goods_trans();"><img src="../admin/image/trade_goods_trans.gif"></a></td>
																	<td>&nbsp;&nbsp;▷&nbsp;&nbsp;</td>
																	<td><a href="#;" onclick="trade_trans();"><img src="../admin/image/trade_trans.gif"></a></td>
																	<td>&nbsp;&nbsp;&nbsp;&nbsp;<A href="adm_trans.php"><img src="../admin/image/go_admtrans.gif"></a></td>
																</tr>
															</table>
														</td>
													</tr>
												</table>
											</td>
										</tr>
									</table>
									</form>
									<!-- -------------------------------------------------주문 검색 끝----------------------------------------------------------- -->
								</td>
							</tr><?
							///////////오늘의 주문,배송 설정//////////////////////////////
							$today = date("Y-m-d");
							$todayTrade_qry = "select idx from trade_goods where left(sday1,10)='$today' $MALL_STR group by tradecode ";
							$todayTradeCnt	= $MySQL->articles($todayTrade_qry);		//오늘의 주문
							?>
							<tr>
								<td>
									<table width=100% border=0>
										<tr>
											<td width="80%"><font color="#0000FF">선택한 항목의 주문상태를 모두 </font>
												<select name="status" id="status_id">
													<option value="">▶거래상태변경</option><?
													for($i=$trans_start;$i<count($TRADE_ARR);$i++)
													{
														?>
													<option value="<?=$i?>"><?=$TRADE_ARR[$i]?></option><?
													}//for
														?>
												</select>로 변경합니다.
												&nbsp;<img align="absmiddle" src="../admin/image/price_change.jpg" onclick="goodsChangeStatus2(document.all.status_id.selectedIndex);" style="cursor:pointer;">
											</td>
											<td align="right"><font color="#0000FF">→ 오늘의 주문 :<b> <?=$todayTradeCnt?> </b>건 </font></td>
										</tr>
										<tr>
											<td colspan="2"><font color="#0000FF">선택한 항목의 주문상태를 모두 </font>
												<select name="sel_del" id="sel_del">
													<option>▶선택</option>
													<option>삭제</option>
												</select>&nbsp;<img align="absmiddle" src="../admin/image/price_change.jpg" onclick="del_select_item();" style="cursor:pointer;">
											</td>
										</tr>
									</table>
								</td>
							</tr>
							<tr valign="middle">
								<td valign="top">
									<table width="800" border="0" cellspacing="1" cellpadding="0" align='center' bgcolor='#cdcdcd'>
										<tr height="25">
											<td width="30"  bgcolor="#EBEBEB"><div align="center"><input type="checkbox" onclick="checkAll();"></a></div></td>
											<td width="150" bgcolor="#ebebeb"><div align="center">주문정보</div></td>
											<td width="110" bgcolor="#ebebeb" align="center">주문날짜</td>
											<td width="100" bgcolor="#ebebeb"><div align="center">주문자/입금자</div></td>
											<td width="90" bgcolor="#ebebeb"><div align="center">회원구분</div></td>
											<td width="130" bgcolor="#ebebeb"><div align="center">결제금액</div></td>
											<td width="70" bgcolor="#ebebeb"><div align="center">결제방식</div></td>
											<td width="70" bgcolor="#ebebeb"><div align="center">거래상태</div></td><?
											if ($admin_row[bTransmethod]=="y")	/// 배송방법 사용시
											{
											?>
											<td  width="70"  bgcolor="#ebebeb"><div align="center">배송방법</div></td><?
											}
											?>
										</tr>
										<!-- 주문 목록 시작 --><?
										$data=Decode64($data);
										$pagecnt=$data[pagecnt];
										$letter_no=$data[letter_no];
										$offset=$data[offset];
										if(!$searchstring)			//검색
										{
											$search=$data[search];
											$searchstring=$data[searchstring];
										}
										if (!isset($status) || $status==6) $status_str="1=1";
										else if ($status == 0) $status_str = "status=$status";
										else $status_str = "status=$status";
										if($searchstring)//검색
											$numresults_qry = "select * from trade where $status_str and $search like '%$searchstring%' $MALL_SEARCH_STR";
										else
											$numresults_qry = "select * from trade where $status_str $MALL_SEARCH_STR";
										if(!empty($paym))
											$numresults_qry.= " and payMethod='$paym'";
										if (!empty($start)) $numresults_qry.= " and left(writeday,10) between '$start' and '$end' ";
										if($gubun)
										{
											if($gubun=="M") $numresults_qry.=" and level_gubun='$gubun'";
											else if($gubun=="D") $numresults_qry.=" and level_gubun='$gubun'";
										}
										$numrows=$MySQL->articles($numresults_qry);
										if ($numrows)
										{
											if($searchstring)//검색
											$qry = "select sum(payM) from trade where $status_str and $search like '%$searchstring%' ";
											else
												$qry = "select sum(payM) from trade where $status_str";
											if(!empty($paym))
												$qry.= " and payMethod='$paym'";
											if (!empty($start)) $qry.= " and left(writeday,10) between '$start' and '$end'";
											if($gubun)
											{
												if($gubun=="M") $qry.=" and level_gubun='$gubun'";
												else if($gubun=="D") $qry.=" and level_gubun='$gubun'";
											}
											$total_price = mysql_result($MySQL->query($qry),0);
										}
										// 총 결과에 따른 페이징 나누기 시작
										$LIMIT		= $admin_row[trade_list_cnt];							//페이지당 글 수
										//$LIMIT=5;
										$PAGEBLOCK	=10;								//블럭당 페이지 수
										$total_page = ceil($numrows / $LIMIT);
										if($pagecnt==""){$pagecnt=0;}						//페이지 번호
										if(!$offset){$offset=$pagecnt*$LIMIT*$PAGEBLOCK;} //각 페이지의 시작 글
										if(!$letter_no){$letter_no=$numrows;}				//글번호
										//////////결제확인 목록일경우 입금일 순으로 정렬////////////
										if ($status==1) $bbs_qry = $numresults_qry." order by sday2 desc limit $offset,$LIMIT";
										else $bbs_qry = $numresults_qry." order by idx desc limit $offset,$LIMIT";
										$bbs_result=$MySQL->query($bbs_qry);
										$now2 = time();
										$now2 = date("Y-m-d",$now2);
										$cnt = 0;
										while($bbs_row=mysql_fetch_array($bbs_result))
										{
											$encode_str = "idx=".$bbs_row[idx]."&pagecnt=".$pagecnt."&letter_no=".$s_letter."&offset=".$offset;
											$encode_str.= "&search=".$search."&searchstring=".$searchstring."&present_num=".$letter_no;
											$data=Encode64($encode_str);					//각 레코드 정보
											if($bbs_row[payMethod] =="card")		$payMethod="<font color=red>카드결제</font>";
											else if($bbs_row[payMethod] =="hand")	$payMethod="<font color=red>핸드폰</font>";
											else if($bbs_row[payMethod] =="iche")	$payMethod="<font color=red>계좌이체</font>";
											else if($bbs_row[payMethod] =="cyber")	$payMethod="<font color=green>가상계좌</font>";
											else if($bbs_row[payMethod] =="bank")	$payMethod="<font color=green>무통장</font>";
											else if($bbs_row[payMethod] =="point")	$payMethod="적립금";
											//else					 $payMethod="미결제";
											if($bbs_row[pG_Cracked] != "") $payMethod.="<br>(".$bbs_row[pG_Cracked].")";
											if ($bbs_row[payMethod] =="bank") $payer = "/<font color=green>$bbs_row[payer]</font>";
											else $payer = "";
											$name = "<FONT  COLOR='#6600FF'>".$bbs_row[name]."</FONT>";
											if ($bbs_row[level_gubun]=="M")
											{
												$level_gubun = "일반회원";
											}
											else if ($bbs_row[level_gubun]=="D")
											{
												$level_gubun = "딜러";
											}
											else
											{
												$level_gubun = "비회원";
											}

											/////////주문상품정보////////////
											$tg_row=$MySQL->fetch_array("select status,name from trade_goods where tradecode='$bbs_row[tradecode]' $MALL_STR limit 1");
											$tg_num = $MySQL->articles("select idx from trade_goods where tradecode='$bbs_row[tradecode]' $MALL_STR");
											$tg_status = $tg_row[status];
											if ($tg_row[status]==0) $st_str = $TRADE_ARR[$tg_status];
											else if ($tg_row[status]==1) $st_str = "<font color=brown>$TRADE_ARR[$tg_status]</font>";
											else if ($tg_row[status]==2) $st_str = "<font color=blue>$TRADE_ARR[$tg_status]</font>";
											else if ($tg_row[status]==3) $st_str = "<font color=green>$TRADE_ARR[$tg_status]</font>";
											else if ($tg_row[status]==4) $st_str = "<font color=red>$TRADE_ARR[$tg_status]</font>";
											else if ($tg_row[status]==5) $st_str = "<font color=red>$TRADE_ARR[$tg_status]</font>";
											else $st_str ="";
											$trans_ing_num = $MySQL->articles("SELECT idx from trade_goods WHERE tradecode='$bbs_row[tradecode]' and status=2 $MALL_STR");	//배송중인것
											$trans_cancel_num = $MySQL->articles("SELECT idx from trade_goods WHERE tradecode='$bbs_row[tradecode]' and status=4 $MALL_STR");	//주문취소인것
											$trans_bp_num = $MySQL->articles("SELECT idx from trade_goods WHERE tradecode='$bbs_row[tradecode]' and status=5 $MALL_STR");//반품인것
											if(!$bbs_row[bPay])	/// 주문접수완료 전일때
											{
												$order_diff_time = time() - strtotime($bbs_row[writeday]);	// 현재시간 - 주문시간 차이
												if ($order_diff_time < 1800)	/// 주문접수한지 30분지 넘지 않았을땐
												{
													$st_str="주문진행중";
												}
												else
												{
													$st_str="미결제";
												}
											}
											if ($tg_num>1)  $tgood_intro = StringCut($tg_row[name],10)."상품 외".($tg_num-1);
											else $tgood_intro = StringCut($tg_row[name],18);
											$tprice = $bbs_row[payM];
											if (strlen($bbs_row[hand])>3) $tel = $bbs_row[hand];
											else $tel = $bbs_row[tel];

											/////오늘주문 색상처리//////
											if ($now2 == substr($bbs_row[writeday],0,10)) $NEW_IMG = "<img src='../upload/goods_new_img'>";
											else $NEW_IMG = "";
											?>
										<form name="goodtype_form<?=$cnt?>" method="post">
										<tr bgcolor="fafafa">
											<td><div align="center"><input type="checkbox" name="idxno" value="<?=$bbs_row[idx]?>" onclick="idxno_click(this.checked,this.value,<?=$cnt?>,this.form.trans_num.value)"><input type="hidden" name="formno" value="<?=$cnt?>"></div></td>
											<td>
												<table width=100%>
													<tr>
														<td align="left" height="15" onMouseOver="this.style.backgroundColor='#9ED6C0'" onMouseOut="this.style.backgroundColor=''"><a href="javascript:trade_order_view('<?=$data?>');"><FONT  COLOR="#000000"><B><u><?=$bbs_row[tradecode]?></u></B></FONT></a>&nbsp;<?=$NEW_IMG?></td>
													</tr>
													<tr>
														<td align="left" onMouseOver="this.style.backgroundColor='#ffd700'" onMouseOut="this.style.backgroundColor=''"><a onclick="tg_show(<?=$cnt?>);" style="cursor:pointer"><u><b><?=$tgood_intro?> ▼</b></u></a></td>
													</tr>
												</table>
											</td>
											<td><div align="center"><?=str_replace("-",".",$bbs_row[writeday])?><?
											if ($bbs_row[status]==1) echo "<br><b>결제날짜<BR>".$bbs_row[sday2]."</b>";
											?></div></td>
											<td><div align="center"><?=$name?><?=$payer?></div></td>
											<td><div align="center"><?=$level_gubun?></div></td>
											<td align=right><?
											if ($bbs_row[useP])
											{
												?><img src="../upload/goods_point_img"><?
											}
											if ($bbs_row[useP] && !$bbs_row[payM])
											{
												?><font style="font-size:11px">적립금전액결제</font> &nbsp;<FONT  COLOR="#CC0000">(<?=PriceFormat($bbs_row[useP])?>)</FONT>&nbsp;<?
											}
											else
											{
												?>&nbsp;<FONT  COLOR="#CC0000"><?=PriceFormat($tprice)?></FONT>&nbsp;&nbsp;<?
											}
											?></td>
											<td><div align="center"><B><?=$payMethod?></B></div></td>
											<td><div align="center"><?=$st_str?><? if ($trans_ing_num) echo "<br>배송중 : ".$trans_ing_num; if ($trans_cancel_num) echo "<br><font color=red><b>취소 : ".$trans_cancel_num."</b></font>"; if ($trans_bp_num) echo "<br><font color=red><b>반품 : ".$trans_bp_num."</b></font>"; ?></div></td>
											<?
											if ($admin_row[bTransmethod]=="y")	/// 배송방법 사용시
											{
												?>
											<td ><div align="center"><?
											if ($bbs_row[transMethod]=="T") echo "택배";
											else if ($bbs_row[transMethod]=="K") echo "경동화물";
											else if ($bbs_row[transMethod]=="Q") echo "퀵배송";
											?></div></td><?
											}
											?>
										</tr>
										<tr>
											<td colspan="9" bgcolor="#FFFFFF" align="center">
												<table width="750" border="0" cellspacing="0" cellpadding="0" id="tgood_id<?=$cnt?>_1" style="display:block";>
													<tr>
														<td height="25" width="800">▲ 주문상품명을 클릭하세요.</td>
													</tr>
												</table>
												<table width="750" border="0" cellspacing="1" cellpadding="0" bgcolor='#000000' id="tgood_id<?=$cnt?>" style="display:none">
													<tr>
														<td height="20" bgcolor='ebebeb' width="250"><div align="center"><img src="image/icon.gif" width="11" height="11"> 상품명</div></td>
														<td bgcolor='ebebeb' width="150"><div align="center"><img src="image/icon.gif" width="11" height="11"> 옵션</div></td>
														<td bgcolor='ebebeb' width="100"><div align="center"><img src="image/icon.gif" width="11" height="11"> <FONT COLOR="#993300">가격</FONT>/<FONT COLOR="#6633FF">수량</FONT></div></td>
														<td bgcolor='ebebeb' width="100"><div align="center"><img src="image/icon.gif" width="11" height="11"> 상품합계(원)</div></td>
														<td bgcolor='ebebeb' width="100"><div align="center"><img src="image/icon.gif" width="11" height="11"> 거래상태</div></td>
													</tr><?
													$trade_goods_qry ="select * from trade_goods where tradecode='$bbs_row[tradecode]' $MALL_STR";
													$trade_goods_result = @$MySQL->query($trade_goods_qry) or die("Err. : $trade_goods_qry");
													while($trade_goods_row = mysql_fetch_array($trade_goods_result))
													{
														$goods_row = $MySQL->fetch_array("SELECT *from goods WHERE idx=$trade_goods_row[goodsIdx] limit 1");
														$optionArr = Array("$trade_goods_row[option1]","$trade_goods_row[option2]","$trade_goods_row[option3]");	//옵션 배열
														$tg_tprice = $trade_goods_row[price]*$trade_goods_row[cnt];	//상품합가격
														?>
													<tr height="30">
														<td  bgcolor="ffffff" valign="middle"><div align="center"><?=$trade_goods_row[name]?></div></td>
														<td  bgcolor="ffffff"><div align="center">
															<table width="100%" border="0" cellspacing="0" cellpadding="0"><?
															for($i=0;$i<count($optionArr);$i++)
															{
																if(!empty($optionArr[$i]))
																{
																	$option = explode("」「",$optionArr[$i]);
																	?>
																<tr>
																	<td width="100"  bgcolor="#F7F7F7"><div align="center"><?=$option[0]?> </div></td>
																	<td   bgcolor="#DDFFFB"><div align="left"> : <?=$option[1]?></div></td>
																</tr>
																<tr bgcolor="#CCCCCC">
																	<td colspan="2" height="1"></td>
																</tr><?
																}
															}
															?>
															</table></div>
														</td>
														<td bgcolor="ffffff"><div align="center"><FONT COLOR="#993300"><?=PriceFormat($trade_goods_row[price])?></font> / <FONT COLOR="#6633FF"><?=$trade_goods_row[cnt]?></font></div></td>
														<td  bgcolor="ffffff"><div align="right"><FONT COLOR="#990000"><?=PriceFormat($tg_tprice)?></FONT></div></td>
														<td  bgcolor="ffffff"><div align="right"><?
															if ($bbs_row[bPay]==0) echo "미결제";
															else  echo $TRADE_ARR[$trade_goods_row[status]];
															?></div></td>
													</tr><?
															if ($trade_goods_row[trans_num]) $trans_num = $trade_goods_row[trans_num];
															else $trans_num = 0;
														}//while
														if ($bbs_row[payMethod]=="bank")
														{
															?>
													<tr height="30" bgcolor="#ffffff">
														<td colspan="6">[입금통장 : <?=$bbs_row[bankInfo]?>] &nbsp;[입금예정일 : <?=$bbs_row[bankDay]?>] &nbsp;[입금자명 : <?=$bbs_row[payer]?>]</td>
													</tr><?
														}
															?>
													<tr height="30" bgcolor="#ffffff">
														<td colspan="6">송장번호 <input style="background-color:#CBCCF8" type="text" class="box" name="trans_num" value="<?=$trans_num?>">&nbsp;&nbsp;<font class="help">※ 목록상에서 <b>거래상태일괄 발송완료 또는 수취완료로 변경시에만</b> 미리 입력해놓아야 합니다.</font></td>
													</tr>
												</table>
											</td>
										</tr>
										</form><?
											$cnt++;
										}//while
										?>
										<!-- 주문 목록 끝 --><?
										/****************************************************************************************************************************
										CList(char* pagename,int pagecnt,int offset,int numrows,int pageblock,int limit,char* search,char* searchstring,char* option)
										putList( BOOL pniView, char* pre_icon, char* next_icon)
										****************************************************************************************************************************/
										if (isset($status) && ($status>0 || $status==0)) $optionStr="paym=$paym&start=$start&end=$end&status=$status&year=$year&month=$month&day=$day&year2=$year2&month2=$month2&day2=$day2";
										else $optionStr="paym=$paym&start=$start&end=$end&year=$year&month=$month&day=$day&year2=$year2&month2=$month2&day2=$day2";
										$Obj=new CList("trade_order.php",$pagecnt,$offset,$numrows,$PAGEBLOCK,$LIMIT,$search,$searchstring,$optionStr);
										?>
									</table>
								</td>
							</tr>
							<form name="delForm" method="post" action="trade_edit_ok.php">
							<input type="hidden" name="del_trade" value="1">
							<tr valign="middle">
								<td valign="top" align="center"><br>
									<table width="100%" border="0" bgcolor="#FFFFFF" align="center" cellspacing=0>
										<tr bgcolor="#D7F0FA">
											<td width="50%" align="left" height=30>
												<select name="ye"><?
												for ($i=$now[0]; $i>$now[0]-5; $i--)
												{
													?>
													<option value="<?=$i?>"><?=$i?></option><?
												}
													?>
												</select>년
												<select name="mo"><?
												for ($i=1; $i<13; $i++)
												{
													?>
													<option value="<?=$i?>" <? if ($i == $month) echo "selected";?>><?=$i?></option><?
												}
												?>
												</select>월
												<select name="da">
												<?
												for ($i=1; $i<32; $i++)
												{
													?>
													<option value="<?=$i?>" <? if ($i == $day) echo "selected";?>><?=$i?></option><?
												}
													?>
												</select>일 이전의 주문정보
												<a href="javascript:del_trade(document.delForm.ye.value,document.delForm.mo.value,document.delForm.da.value);"><img src="image/delete_btn.gif" border=0></a></td>
											<td align=right>총 <?=$total_page?> pages / 자료 <?=$numrows?>건 / 합계금액 : <?=PriceFormat($total_price)?> 원</td>
										</tr>
										<tr>
											<td colspan=2 height=30><div align="center"><?$Obj->putList(true,"","");//이전다음 프린트?> </div></td>
										</tr>
									</table>
								</td>
							</tr>
							</form>
							<tr valign="middle">
								<td valign="top">&nbsp;</td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>
<? include "copy.php";?>
</body>
</html>