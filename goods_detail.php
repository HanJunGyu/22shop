<?
// 소스형상관리
// 20060718-1 소스수정 김성호 : 확대이미지 전체(6개) 입력시 화면 깨짐 방지
include "head.php";
if (empty($goodsIdx))
{
	MsgViewHref("상품정보가 정상적으로 넘어오지 않았습니다.","index.php");
	exit;
}
if($admin_row[xTrans_bhtml])
{
	$xTrans = $admin_row[xTrans];
}
else
{
	$xTrans = nl2br(htmlspecialchars($admin_row[xTrans]));
}
//조회수 증가
$MySQL->query("update goods set readCnt=readCnt+1 where idx=$goodsIdx ");
$goods_row = $MySQL->fetch_array("select *from goods where idx=$goodsIdx limit 1");//상품정보
if ($design[today_view]) /// 오늘본상품 기능사용시 
{
	if(empty($_SESSION[GOOD_SHOP_USERID]))
	{
		//비회원 세션 아이디 등록
		$GOOD_SHOP_USERID	= time();
		$GOOD_SHOP_NAME		= "비회원";
		$GOOD_SHOP_PART		= "guest";
		$GOOD_SHOP_CART		= time();
		$GOOD_SHOP_PART_GUBUN	= "G";
		$_SESSION['GOOD_SHOP_USERID'] = "$GOOD_SHOP_USERID";
		$_SESSION['GOOD_SHOP_NAME'] = "$GOOD_SHOP_NAME";
		$_SESSION['GOOD_SHOP_PART'] = "$GOOD_SHOP_PART";	
		$_SESSION['GOOD_SHOP_CART'] = "$GOOD_SHOP_CART";
		$_SESSION['GOOD_SHOP_PART_GUBUN'] = "$GOOD_SHOP_PART_GUBUN";
	}
	$today = date("Y-m-d",time());
	if (!$MySQL->articles("SELECT idx from today_view WHERE userid='$_SESSION[GOOD_SHOP_USERID]' and left(writeday,10)='$today' and goodsIdx=$goodsIdx limit 1"))
	{
		$qry = "INSERT INTO today_view values ('','$goodsIdx','$goods_row[img1]',now(),'$_SESSION[GOOD_SHOP_USERID]')";
		$MySQL->query($qry);
	}
}
$category_info = $MySQL->fetch_array("select * from category where code='$goods_row[category]' limit 1");	//분류 정보
//다음상품
$next_goods_qry = "select max(idx) from goods where idx < $goods_row[idx] and bLimit<3";	//현재 idx 보다 큰 idx 중 가장 작은값
$next_goods_qry.= " and category ='$category_info[code]'";
$next_goods_idx = $MySQL->fetch_array($next_goods_qry);
//이전상품
$pre_goods_qry = "select min(idx) from goods where idx > $goods_row[idx] and bLimit<3";	//현재 idx 보다 작은 idx 중 가장 큰값
$pre_goods_qry.= " and category='$category_info[code]'";
$pre_goods_idx = $MySQL->fetch_array($pre_goods_qry);

$img1_info	=@getimagesize("./upload/goods/$goods_row[img3]");   //확대 이미지 정보
$wSize1	=$img1_info[0];	//가로
$hSize1	=$img1_info[1];	//세로
//제품정보
if($goods_row[bHtml])	$content =$goods_row[content];					//태그사용
else
{
	$content=nl2br(htmlspecialchars($goods_row[content]));	//태그미사용
}
if($goods_row[bLimit])
{
	if(empty($goods_row[limitCnt]) || $goods_row[bLimit]==2) $limitCnt ="<FONT COLOR='#990000'>품절</FONT>";
	else if($goods_row[bLimit]==3) $limitCnt ="<FONT COLOR='#990000'>보류</FONT>";
	else if($goods_row[bLimit]==4) $limitCnt ="<FONT COLOR='#990000'>단종</FONT>";
}

// 판매가 계산 클래스
$gprice = new CGoodsPrice($goods_row[idx]);
// 카테고리 정보 시작
$str_category = " <font color='$subdesign[tc1]'> &gt; ".$category_info[name];

// 관련상품 존재여부 체크
$relation_cnt = 0;
if ($goods_row[relation])
{
	$relation = Laststrcut($goods_row[relation]);
	$relation = explode("/",$relation);
	if(!empty($relation[0]))
	{
		$relation_qry = $relation[0];
		for ($j=1; $j<count($relation); $j++)
		{
			$relation_qry.= ", ".$relation[$j];
		}
	}
	$row = $MySQL->fetch_array("select count(*) as cnt from goods where idx in (".$relation_qry.") and bLimit<3");
	$relation_cnt = $row[cnt];	//표시 가능한 관련상품수
}
?>
<SCRIPT LANGUAGE="JavaScript">
<!--
var optionArr = new Array();
optionArr[0] ="<?=$goods_row[partName1]?>";
optionArr[1] ="<?=$goods_row[partName2]?>";
optionArr[2] ="<?=$goods_row[partName3]?>";

// 장바구니 담기
function addCart(Channel)
{
	var form=document.goodsForm;
	var Cnt	= form.cnt.value;
	var bLimit = <?=$goods_row[bLimit]?>;   //재고량  ex)1:재고량사용  0:무제한
	var limitCnt =<?=$goods_row[limitCnt]?>;//현재재고럏
	var minbuyCnt =<?=$goods_row[minbuyCnt]?>;// 최소구매수량 
	var maxbuyCnt =<?=$goods_row[maxbuyCnt]?>;// 최대구매수량
	if(Cnt=="" || Cnt=="0" ||Cnt==0 || !numCheck(Cnt))
	{
		alert("구매수량이 올바르지 않습니다.");
		form.cnt.focus();
	}
	else if(bLimit  && !limitCnt || bLimit==2)
	{
		alert("죄송합니다. 현재 품절된 상품입니다.");
	}
	else if(bLimit	 && limitCnt < Cnt)
	{
		alert("죄송합니다. 재고수량이 부족합니다.\n\n재고량 : "+limitCnt);
		form.cnt.focus();
	}
	else if(minbuyCnt!=0 && Cnt<minbuyCnt)
	{
		alert("본 상품의 최소구매수량은 "+minbuyCnt+ " 개 입니다.");
		form.cnt.value = minbuyCnt;
		form.cnt.focus();
	}
	else if(maxbuyCnt!=0 && Cnt>maxbuyCnt)
	{
		alert("본 상품의 최대구매수량은 "+maxbuyCnt+ " 개 입니다.");
		form.cnt.value = maxbuyCnt;
		form.cnt.focus();
	}
	else if(optionArr[0].length && form.option1.selectedIndex==0)
	{
		alert(optionArr[0]+"을 선택해 주십시오.");
		form.option1.focus();
	}
	else if(optionArr[1].length && form.option2.selectedIndex==0)
	{
		alert(optionArr[1]+"을 선택해 주십시오.");
		form.option2.focus();
	}
	else if(optionArr[2].length && form.option3.selectedIndex==0)
	{
		alert(optionArr[2]+"을 선택해 주십시오.");
		form.option3.focus();
	}
	else
	{
		form.action="cart_ok.php?act=add&channel="+Channel;
		<? if ($relation_cnt > 0){ ?>
		form.action = form.action + "&gidx_total=" + document.relationForm.gidx_total.value;
		<? } ?>
		form.target="";
		form.submit();
	}
}
//관심품목등록
function addInter()
{
	var form=document.goodsForm;
	if(optionArr[0].length && form.option1.selectedIndex==0)
	{
		alert(optionArr[0]+"을 선택해 주십시오.");
		form.option1.focus();
	}
	else if(optionArr[1].length && form.option2.selectedIndex==0)
	{
		alert(optionArr[1]+"을 선택해 주십시오.");
		form.option2.focus();
	}
	else if(optionArr[2].length && form.option3.selectedIndex==0)
	{
		alert(optionArr[2]+"을 선택해 주십시오.");
		form.option3.focus();
	}
	else
	{
		interwindow = window.open("","intfee","scrollbars=no,width=450,height=225 top=300,left=300");
		form.target="intfee";
		form.action="interest_ok.php?goodsIdx=<?=$goodsIdx?>";
		form.submit();
		interwindow.focus();
	}
}
//상품평 쓰기
function commentSendit()
{
	<?
	if($GOOD_SHOP_PART=="member")
	{
		?>
	var form=document.commentForm;
	if(form.content.value=="")
	{
		alert("상품평을 입력해 주십시오.");
		form.content.focus();
	}
	else
	{
		form.submit();
	}
	<?
	}
	else
	{
	?>
	alert("로그인 해주십시오.");
	document.detail.submit();
	<?
	}
	?>
}

function commentDel(com_idx)
{
	document.commentForm.del.value = 1;
	document.commentForm.com_idx.value = com_idx;
	document.commentForm.submit();
}

//상품가격 세팅
function setPrice()
{
	var form=document.goodsForm;
	var new_p = SetComma(form.price);
	form.price2.value = new_p;
	<? if ($relation_cnt > 0){ ?>
	update_price();
	<? } ?>
	// 옵션 변경시 적립금은 변동을 주지 않음.
	/*
	<?
	if ($admin_row[bUsepoint]) 
	{
		// 적립금 재설정
		?>
	var point_per = "<?=$admin_row[poUnit]?>";
	<?
		if ($admin_row[poMethod]=="b")//퍼센트일때만 적립금변경 
		{
			?>
	form.point.value = Math.round(point_per * 0.01 * parseInt(form.price.value));
	<?
		}
	}
	?>
	var new_point = SetComma(form.point);
	form.point2.value = new_point;
	*/
}

// 콤마 넣기 //////////////////////////////////////////
function SetComma(frm) 
{
	var rtn = "";
	var val = "";
	var j = 0;
	x = frm.value.length;
	for(i=x; i>0; i--) 
	{
		if(frm.value.substring(i,i-1) != ",") 
		{
			val = frm.value.substring(i,i-1)+val;
		}
	}
	x = val.length;
	for(i=x; i>0; i--) 
	{
		if(j%3 == 0 && j!=0) 
		{
			rtn = val.substring(i,i-1)+","+rtn;  
		}
		else 
		{
			rtn = val.substring(i,i-1)+rtn;
		}
		j++;
	}
	return rtn;
}

function changeImageThumb(simg)
{
	document.PicMedium.src = "upload/goods/"+simg;
	return;
}

function relation_select(count)
{
	var form = document.relationForm;
	if (count==1) // 관련상품이 단 1개일때 
	{
		if (form.gidx.checked == true)
		{
			form.gidx_total.value = form.gidx.value;
			document.goodsForm.temp_price.value = parseInt(form.price.value);
		}
		else
		{
			form.gidx_total.value = "";
			document.goodsForm.temp_price.value = 0;
		}
	}
	else
	{
		var gidx_array = new Array();
		var gidx_str = "";
		var temp_price = 0;
		for (var i=0; i<count; i++)
		{
			if (form.gidx[i].checked == true)
			{
				gidx_array[i] = form.gidx[i].value;
				temp_price += parseInt(form.price[i].value);
			}
			else
			{
				gidx_array[i] = "";
			}
		}
		document.goodsForm.temp_price.value = temp_price;
		var gidx_str = gidx_array.join("/");
		form.gidx_total.value = gidx_str;
	}
	update_price();
}

function update_price()
{
	document.goodsForm.preview_price.value=parseInt(document.goodsForm.temp_price.value) + parseInt(document.goodsForm.price.value);
	document.goodsForm.preview_price.value=SetComma(document.goodsForm.preview_price);
}

function only_num(str) ////// 문자열중 숫자만 남기고 삭제
{
	var tmp = "";
	var num2=str.length;
	for (var i=0; i<num2; i++)
	{
		var chk_str = str.substr(i,1); //앞자리씩 가져옴
		if (chk_str.match(/[0-9]/i))
		{
			tmp=tmp+str.substr(i,1);
		}
	}
	return tmp;
}
//-->
</SCRIPT>
<?
include "top.php";
?>
<!-- mypage 로그인 체크시 referer값 셋팅--> 
<form name="detail" method="post" action="login.php"><input type="hidden" name="referer" value="<?= $_SERVER[PHP_SELF]?>?goodsIdx=<?=$goodsIdx?>"></form>
<iframe name="ifrm" width='0' height='0' frameborder='0'></iframe>
<table width="900" border="0" cellspacing="0" cellpadding="0" bgcolor="<?=$ALL_BGCOLOR?>">
	<tr>
		<? include "left_menu.php"; ?>
		<td valign="top" bgcolor="#FFFFFF">
			<table width="720" border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td width="2" bgcolor="<?=$subdesign[bc2]?>" rowspan="2"></td>
					<td width="2" bgcolor="<?=$subdesign[bc2]?>" rowspan="2"></td>
					<td width="220" height="30" bgcolor="<?=$subdesign[bc2]?>"><img src="./upload/design/<?=$subdesign[img2]?>"></td>
					<td width="490" height="30" bgcolor="<?=$subdesign[bc2]?>"><div align="right"> &nbsp;<font color="<?=$subdesign[tc2]?>"> <img src='image/good/icon0.gif'>&nbsp;현재위치 : <a href="index.php"><font color="<?=$subdesign[tc2]?>">HOME</font></a><?=$str_category?></font>&nbsp;</div></td>
				</tr>
			</table>
			<table width="720" border="0" cellspacing="0" cellpadding="0" align="center">
				<tr>
					<td height="310" valign="top">
						<table width="720" border="0" cellspacing="0" cellpadding="0" align="center">
							<tr>
								<td width="43%" valign="top">
									<table width="100%" border="0" cellspacing="0" cellpadding="2" align="center">
										<tr><?
										if (empty($GD_SET) && $goods_row[img_onetoall]) $img_str = $goods_row[img3];
										else if ($GD_SET && $goods_row[img_onetoall] && empty($goods_row[img2])) $img_str = $goods_row[img3];
										else if ($GD_SET && empty($goods_row[img_onetoall]) && empty($goods_row[img2])) $img_str = $goods_row[img3];
										else $img_str = $goods_row[img2];
										$info = @getimagesize("./upload/goods/$goods_row[img3]");
										$wSize = $info[0]+250;
										$hSize = $info[1]+120;
										if ($wSize<500) $wSize=600;
										if ($hSize<500) $hSize=600;
										?>
											<td align="center"><a href="javascript:zoom2('<?=$goods_row[idx]?>',<?=$wSize?>,<?=$hSize?>);"><img name="PicMedium" src="upload/goods/<?=$img_str?>" width="<?=$design_goods[goodsListIW1]?>" height="<?=$design_goods[goodsListIH1]?>" border="0"></a></td>
										</tr>
										<tr>
											<td>
												<table bgcolor='E6E6E6' border="0" cellspacing="1" cellpadding="0" align='center'>
													<tr>
														<?
														for ($i=3; $i<=8; $i++)
														{
															if ($i==3) $big_img_str = "img".($i-1);
															else $big_img_str = "img$i";
															if ($goods_row[$big_img_str])
															{
																?>
														<td bgcolor='ffffff'><img src="upload/goods/<?=urlencode($goods_row[$big_img_str])?>" border=0 width=50 height=50 onmouseover="javascript:changeImageThumb('<?=urlencode($goods_row[$big_img_str])?>');"></td><?
															}
														}
														?>
													</tr>
												</table>
											</td>
										</tr>
										<tr>
											<td height="30">
												<table width="200" border="0" cellspacing="0" cellpadding="0" align='center'>
													<tr>
														<td><div align="center"><a href="javascript:zoom2('<?=$goods_row[idx]?>',<?=$wSize?>,<?=$hSize?>);"><img src="image/good/enlarge_btn.gif" border="0"></a></div></td>
													</tr>
												</table>
											</td>
										</tr>
										<tr>
											<td height="30">
												<table width="57%" border="0" cellspacing="0" cellpadding="0" align="center">
													<tr><?
													if(!empty($pre_goods_idx[0]))
													{
														//이전상품보기
														?>
														<td width="55%"><div align="center"><a href="goods_detail.php?goodsIdx=<?=$pre_goods_idx[0]?>"><img src="image/good/back.gif" border="0"></a></div></td><?
													}
													else
													{
														?>
														<td width="55%"><div align="center"><img src="image/good/back.gif"></div></td><?
													}
													if(!empty($next_goods_idx[0]))
													{
														//다음상품보기
														?>
														<td width="45%"><a href="goods_detail.php?goodsIdx=<?=$next_goods_idx[0]?>"><img src="image/good/front.gif"  border="0"></a></td><?
													}
													else
													{
														?>
														<td width="45%"><img src="image/good/front.gif"></td><?
													}
													?>
													</tr>
												</table>
											</td>
										</tr>
									</table>
								</td>
								<td width="1"></td>
								<td valign="top"><br>
									<table width="380" border="0" cellspacing="3" cellpadding="0" align="center" bgcolor='e1e1e1'>
										<tr>
											<td bgcolor='ffffff'>
												<form name="goodsForm" method="post">
												<input type="hidden" name="goodsIdx" value="<?=$goodsIdx?>"><!-- 상품 idx -->
												<input type="hidden" name="optionName1" value="<?=$goods_row[partName1]?>"><!-- 상품 idx -->
												<input type="hidden" name="optionName2" value="<?=$goods_row[partName2]?>"><!-- 상품 idx -->
												<input type="hidden" name="optionName3" value="<?=$goods_row[partName3]?>"><!-- 상품 idx -->
												<input type="hidden" name="temp_price" value="0"><!-- 관련상품 임시가격 -->
												<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
													<tr>
														<td colspan="3"><?
														//이미지사용
														if ($admin_row[bNew])  $bNew = limitday($goods_row[writeday],$admin_row[new_day]);
														if($goods_row[bHit]) $view_bHit ="<img src='./upload/goods_hit_img'>"; else $view_bHit="";
														if($goods_row[bEtc]) $view_bEtc ="<img src='./upload/goods_etc_img' >"; else $view_bEtc="";
														?>
															<table width="100%" border="0" cellspacing="0" cellpadding="0" height="30" align="center">
																<tr>
																	<td height="40" bgcolor="#f4f4f4" style="line-height:20px" style='padding:0 0 0 10'><font color="#000000" size="3"><b><?=$goods_row[name]?></b></font> <?=$view_bHit?> <?=$bNew?> <?=$view_bEtc?></td>
																</tr>
																<tr>
																	<td height="30" style='padding:0 0 0 3'>&nbsp;<img src="image/notice_icon.gif"> <font color="#464646">판매가격 &nbsp;&nbsp;&nbsp;</font> <input class="nonbox" type="hidden" size="18" name="price" value="<?=$gprice->Price();?>"><input class="nonbox" type="text" size="12" name="price2" readonly style="color:red;text-align:right;" value="<?=$gprice->PutPrice();?>"> 원&nbsp;&nbsp;<?
																	//////////무료배송 상품일때 이미지표시////
																	if ($goods_row[size]=="N")
																	{
																		?><img src="image/icon/free_delivery.gif"><?
																	}
																	?></td>
																</tr><?
																if ($relation_cnt > 0)
																{
																	?>
																<tr>
																	<td height="30">&nbsp;<img src="image/notice_icon.gif">&nbsp;<font color="#464646">관련상품 포함가</font><input size="8" class="nonbox" type="text" name="preview_price"  style="color:red;text-align:right;font-weight:700;" value="<?=$gprice->PutPrice();?>"> 원 <!-- 관련상품 있을 때 판매가 변경 미리보여줌 --></td>
																</tr><?
																}
																?>
															</table>
														</td>
													</tr>
													<tr>
														<td bgcolor="d7d7d7" height="1" colspan="3"></td>
													</tr><?
													for($i=1;$i<=3;$i++)
													{
														$partName	="partName$i";//옵션명
														$strPart	="strPart$i"; //옵션 구분
														if(!empty( $goods_row[$partName] ))
														{
															$strArr = explode("」「",$goods_row[$strPart]);
															?>
													<tr>
														<td colspan="3">
															<table width="370" border="0" cellspacing="0" cellpadding="0" height="30" align="center">
																<tr>
																	<td width="110" height="30">&nbsp;<img src="image/notice_icon.gif">&nbsp;<font color="#464646"><?=$goods_row[$partName]?></font></td>
																	<td width='1' bgcolor='e1e1e1'></td>
																	<td height="30" style='padding:0 0 0 10'><select name="option<?=$i?>"><option value="0"><?=$goods_row[$partName]?></option><?
																	for($j=0;$j<count($strArr);$j++)
																	{
																		?><option value="<?=$strArr[$j]?>"><?=$strArr[$j]?></option><?
																	}
																	?></select></td>
																</tr>
															</table>
														</td>
													</tr><?
														}
													}
													?>
													<tr>
														<td colspan="3">
															<table width="370" border="0" cellspacing="0" cellpadding="0" height="30" align="center"><?
															if($goods_row[bOldPrice])
															{
																//시중가표시
																?>
																<tr>
																	<td width="110" height="30">&nbsp;<img src="image/notice_icon.gif">&nbsp;<font color="#464646">시중가</font></td>
																	<td width='1' bgcolor='e1e1e1'></td>
																	<td height="30" style='padding:0 0 0 10'> <strike><?=PriceFormat($goods_row[oldPrice])?>원</strike> <?
																	if ($goods_row[bSaleper] && $goods_row[sale])
																	{
																		echo "<font color=#D83232>($goods_row[sale]%)</font>"; 
																	}
																	?></td>
																</tr><?
															}
															if($goods_row[model])
															{
																//제조원표시
																?>
																<tr>
																	<td width="110" height="30">&nbsp;<img src="image/notice_icon.gif">&nbsp;<font color="#464646">모델명</font></td>
																	<td width='1' bgcolor='e1e1e1'></td>
																	<td height="30" style='padding:0 0 0 10'> <?=$goods_row[model]?></td>
																</tr><?
															}
															if($goods_row[bCompany])
															{
																//제조원표시
																?>
																<tr>
																	<td width="110" height="30">&nbsp;<img src="image/notice_icon.gif">&nbsp;<font color="#464646">제조원</font></td>
																	<td width='1' bgcolor='e1e1e1'></td>
																	<td height="30" style='padding:0 0 0 10'> <?=$goods_row[company]?></td>
																</tr><?
															}
															if($goods_row[bOrigin])
															{
																//원산지표시
																?>
																<tr>
																	<td width="110" height="30">&nbsp;<img src="image/notice_icon.gif">&nbsp;<font color="#464646">원산지</font></td>
																	<td width='1' bgcolor='e1e1e1'></td>
																	<td height="30" style='padding:0 0 0 10'> <?=$goods_row[origin]?></td>
																</tr><?
															}
															if($admin_row[bUsepoint])
															{
																?>
																<tr>
																	<td width="110" height="30">&nbsp;<img src="image/notice_icon.gif">&nbsp;<font color="#464646">구매 적립금</font></td>
																	<td width='1' bgcolor='e1e1e1'></td>
																	<td height="30" style='padding:0 0 0 10'> <input type="hidden" name="point" readonly style="text-align:right;" value="<?=$gprice->PutPoint();?>"><input class="nonbox" type="text" size="8" name="point2" readonly style="text-align:right;" value="<?=$gprice->PutPoint2();?>"> 원</td>
																</tr><?
															}
															else
															{
																?>
																<input type="hidden" name="point" value="0"><input type="hidden" name="point2" value="0"><?
															}
															?>
																<tr>
																	<td width="110" height="30">&nbsp;<img src="image/notice_icon.gif">&nbsp;<font color="#464646">재고</font></td>
																	<td width='1' bgcolor='e1e1e1'></td>
																	<td  height="30" style='padding:0 0 0 10'> <?
																	if (($goods_row[bLimit]==1 && !$goods_row[limitCnt]) || $goods_row[bLimit]==2)
																	{
																		if (file_exists("./upload/no_good_img"))
																		{
																			?><img src="./upload/no_good_img" align="absmiddle"><?
																		}
																		else
																		{
																			?><FONT COLOR='#990000'>품절</FONT><?
																		}
																	}
																	else if($goods_row[bLimit]==3)
																	{
																		?><FONT COLOR='#990000'>보류</FONT><?
																	}
																	else if($goods_row[bLimit]==4)
																	{
																		?><FONT COLOR='#990000'>단종</FONT><?
																	}
																	else
																	{
																		echo "판매중";
																	}
																	?></td>
																</tr>
																<tr>
																	<td width="110" height="30">&nbsp;<img src="image/notice_icon.gif">&nbsp;<font color="#464646">구매수량</font></td>
																	<td width='1' bgcolor='e1e1e1'></td>
																	<td height="30" style='padding:0 0 0 10'> <?
																	//////////// 최소구매수량 설정시 기본으로 수량설정함 //////////// 
																	if ($goods_row[minbuyCnt]) $buyCnt = $goods_row[minbuyCnt];
																	else $buyCnt = 1;
																	?><input type="text" name="cnt" size="3" <?=__ONLY_NUM?> value="<?=$buyCnt?>" class='box_s'> <font class='stext'>EA</font> &nbsp;<?=$limitCnt?></td>
																</tr>
															</table>
														</td>
													</tr>
													<tr>
														<td bgcolor="d7d7d7" height="1" colspan="3"></td>
													</tr>
													<tr>
														<td  colspan='3' height='10'></td>
													</tr>
													<tr>
														<td colspan="3" align=center> <a href="#;" onclick="addCart('cart');"><img src="image/work/cart_btn1.gif" border="0"></a> <a href="javascript:addCart('direct');"><img src="image/work/order_btn.gif" border="0"></a>&nbsp;&nbsp;<?
														if($_SESSION[GOOD_SHOP_PART]=="member")
														{
															?><a href="#;" onclick="addInter();"><img src="image/work/inter_btn.gif"  border="0"></a><?
														}
														?></td>
													</tr>
												</table>
												</form><!-- //goodsForm -->
											</td>
										</tr>
									</table>
								</td>
							</tr>
							<tr>
								<td colspan="3" height="25" bgcolor="ffffff"></td>
							</tr>
						</table>
					</td>
				</tr><?
				if($relation_cnt > 0)
				{
					?>
				<tr>
					<td>
						<table width="690" border="0" cellspacing="0" cellpadding="0" align="center" style="table-layout:fixed;">
							<tr>
								<td rowspan='3' width='66' bgcolor='ebeaea' valign='top'><img src="image/good/good_info.gif"></td>
								<td><img src='image/good/good_info_t.gif'></td>
							</tr>
							<tr>
								<td background='image/good/good_info_bg.gif' align='center'>
									<form name="relationForm" method="post">
									<input type="hidden" name="gidx_total" value=""> <!-- 관련상품 idx 모음 -->
									<table width="600" border=0 cellspacing="0" cellpadding="0"><?
											$for_cnt = 1;
											if(!empty($relation[0]))
											{
												for ($j=0; $j<count($relation); $j++)
												{
													$row = $MySQL->fetch_array("select * from goods where idx=$relation[$j] and bLimit<3 limit 1");
													if (empty($GD_SET) && $row[img_onetoall]) $img_str = $row[img3];
													else if ($GD_SET && $row[img_onetoall] && empty($row[img1])) $img_str = $row[img3];
													else if ($GD_SET && empty($row[img_onetoall]) && empty($row[img1])) $img_str = $row[img3];
													else $img_str = $row[img1];
													if ($row[idx])
													{
														if ($admin_row[bNew])
														{
															$bNew = limitday($row[writeday],$admin_row[new_day]);
															/////설정된 기간보다 지나서 new 마크가 붙지 않지만 임의로 상품정보에서 뉴마크 사용시///// 
															if (empty($bNew) && $row[bNew]) $bNew = "<img src='upload/goods_new_img'>";
														}
														if($row[bHit]) $bHit ="<img src='upload/goods_hit_img'>";		//히트 이미지
														else			$bHit ="";
														if($row[bEtc]) $bEtc ="<img src='upload/goods_etc_img' >";	//기타 이미지
														else			$bEtc ="";
														$rel_gprice = new CGoodsPrice($row[idx]);
														if(($for_cnt%5) == 1)
														{

															echo "\n										<tr>\n";
															if($for_cnt != 1)
															{
																echo "\n										<tr>\n";
																echo "\n										<td colspan='5' bgcolor='e1e1e1' height='1'></td>\n";
																echo "\n										</tr>\n";
															}
														}
														?>
											<td align="center" valign='top'>
												<table width="100" border=0 cellspacing="0" cellpadding="0">
													<input type="hidden" name="price" value="<?=$rel_gprice->Price();?>"><!-- 관련상품 가격저장 -->
													<tr>
														<td width=100 align="center"><a href="javascript:zoom2('<?=$row[idx]?>',750,620);"><img src="upload/goods/<?=$img_str?>" width="70" height="70" border="0"></a></td>
													</tr>
													<tr>
														<td align="center"><input onfocus="this.blur();" type="checkbox" name="gidx" onclick="javascript:relation_select(<?=$relation_cnt?>);" value="<?=$row[idx]?>">함께구매 </td>
													</tr>
													<tr>
														<td align=center valign=middle style='padding:5 0 0 0'><a href="goods_detail.php?goodsIdx=<?=$row[idx]?>"><font color="<?=$design_goods[gname_color]?>">&nbsp;<?=$row[name]?></font></a><br><?=$bHit?> <?=$bNew?> <?=$bEtc?><br><?
															if ($row[strPart1])
															{
																?>&nbsp;<img src="admin/image/option.gif"><?
															}
															?></td>
													</tr>
													<tr>
														<td align=center><?
															if(false)	//if($row[bOldPrice])
															{
																?><font color='ff4800'><?=PriceFormat($row[oldPrice])?> 원</font><?
																if ($row[bSaleper] && $row[sale])
																{
																	echo "<font color=#D83232>($row[sale]%할인)</font>";
																}
																?><br><?
															}
															?><font color="<?=$design_goods[gprice_color]?>"><b><?=$rel_gprice->PutPrice();?>원 </b> </font><br><?
															if (($row[bLimit]==1 && !$row[limitCnt]) || $row[bLimit]==2)
															{
																if (file_exists("./upload/no_good_img"))
																{
																	?><img src="./upload/no_good_img" align="absmiddle"><?
																}
																else
																{
																	?><FONT COLOR='#990000'>품절</FONT><?
																}
															}
															?></td>
													</tr>
												</table>
											</td><?
														if(($for_cnt%5) == 0) echo "\n										</tr>\n";
														$for_cnt++;
													}
												}
												if(1 < $for_cnt)	//여백 td추가
												{
													for ($j=($for_cnt%5); $j<=5; $j++)
													{
														echo "<td></td>";
													}
													echo "\n										</tr>\n";
												}
											}
											?>
									</table></form>
								</td>
							</tr>
							<tr>
								<td><img src='image/good/good_info_b.gif'></td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td height="15"></td>
				</tr><?
				}
				?>
				<tr>
					<td><a name="01" id="01"></a>
						<table width="690" border="0" cellspacing="0" cellpadding="0" align="center" style="table-layout:fixed;">
							<tr>
								<td><img src="image/good/tit_detail01.gif" usemap="#Map1"></td>
							</tr>
						</table>
						<map name="Map1" id="Map1"><area shape="rect" coords="198,5,317,39" href="#02"><area shape="rect" coords="326,6,445,39" href="#03"><area shape="rect" coords="455,7,572,40" href="#04"></map>
						<table width="690" border="0" cellspacing="0" cellpadding="0" align="center" style="table-layout:fixed;">
							<tr>
								<td style="word-break:break-all" background='image/good/tit_detail_bg.gif'>
									<table width="680" border="0" cellspacing="0" cellpadding="10" align="center">
										<tr>
											<td style="word-break:break-all"><?=$content?><br></td>
										</tr><?
										for ($i=1; $i<5; $i++)
										{
											$str = "detailimg$i"; 
											if ($goods_row[$str]) 
											{
												?>
										<tr>
											<td><img src="upload/goods/<?=$goods_row[$str]?>"></td>
										</tr>
										<tr>
											<td height=5></td>
										</tr><?
											}
										}
										?>
									</table>
								</td>
							</tr>
							<tr>
								<td><img src='image/good/tit_detail_b.gif'></td>
							</tr>
						</table><br>
					</td>
				</tr><?
				if ($xTrans)
				{
					?>
				<tr valign="top">
					<td>
						<a name="02" id="02"></a>
						<table width="690" border="0" cellspacing="0" cellpadding="0" align="center" style="table-layout:fixed;">
							<tr>
								<td><img src="image/good/tit_detail02.gif" usemap="#Map2"></td>
							</tr>
						</table>
						<map name="Map2" id="Map2"><area shape="rect" coords="9,2,134,38" href="#01"><area shape="rect" coords="323,4,442,38" href="#03"><area shape="rect" coords="447,5,569,36" href="#04"></map>
						<table width="690" border="0" cellspacing="0" cellpadding="0" align="center">
							<tr>
								<td background='image/good/tit_detail_bg.gif'>
									<table width="680" border="0" cellspacing="0" cellpadding="10" align="center">
										<tr>
											<td><?
											if ($goods_row[trans_content])
											{
												echo nl2br($goods_row[trans_content]);
											}
											else
											{
												echo $xTrans;
											}
											?></td>
										</tr>
									</table>
								</td>
							</tr>
							<tr>
								<td><img src='image/good/tit_detail_b.gif'></td>
							</tr>
						</table><br>
					</td>
				</tr><?
				}
				?>
				<!-- 상품문의 --><?
				if ($admin_row[bAskboard]=="y")
				{
					?>
				<tr>
					<td>
						<a name="03" id="03"></a>
						<table width="690" border="0" cellspacing="0" cellpadding="0" align="center" style="table-layout:fixed;">
							<tr>
								<td><img src="image/good/tit_detail03.gif" usemap="#Map3"></td>
							</tr>
						</table>
						<map name="Map3" id="Map3"><area shape="rect" coords="13,2,132,38" href="#01"><area shape="rect" coords="141,4,262,39" href="#02"><area shape="rect" coords="468,4,590,39" href="#04"></map>
						<table width="690" border="0" cellspacing="0" cellpadding="0" align="center">
							<tr>
								<td background='image/good/tit_detail_bg.gif'><div align='center'><iframe src="goods_board.php?gidx=<?=$goods_row[idx]?>" frameborder=0 width=670 height=250 scrolling=auto></iframe></div></td>
							</tr>
							<tr>
								<td><img src='image/good/tit_detail_b.gif'></td>
							</tr>
						</table><br>
					</td>
				</tr><?
				}
				?><!-- 상품평 시작 --><?
				if($admin_row[bGoodsapp]=="y")
				{
					?>
				<tr>
					<td>
						<a name="04" id="04"></a>
						<table width="690" border="0" cellspacing="0" cellpadding="0" align="center" style="table-layout:fixed;">
							<tr>
								<td><img src="image/good/tit_detail04.gif" usemap="#Map4"></td>
							</tr>
						</table>
						<map name="Map4" id="Map4"><area shape="rect" coords="11,3,133,38" href="#01"><area shape="rect" coords="139,0,262,39" href="#02"><area shape="rect" coords="272,6,393,39" href="#03"></map>
						<table width="690" border="0" cellspacing="0" cellpadding="0" align="center" style="table-layout:fixed;">
							<tr>
								<td background='image/good/tit_detail_bg.gif'>
									<form name="commentForm" method="post" action="goods_comment_ok.php">
									<input type="hidden" name="goodsIdx" value="<?=$goodsIdx?>">
									<input type="hidden" name="name" value="<?=$goods_row[name]?>">
									<input type="hidden" name="del" value="">
									<input type="hidden" name="com_idx" value="">
									<table width="680" border="0" cellspacing="0" cellpadding="0" align="center">
										<tr>
											<td><div align='center'><textarea class='box1' name="content" cols="100" rows="5"></textarea></div></td>
										</tr>
										<tr>
											<td height="2">&nbsp;</td>
										</tr>
										<tr>
											<td align="right" valign="middle"><a href="javascript:commentSendit();"><img src="image/good/good_write.gif" border="0"></a>&nbsp;&nbsp;&nbsp;</td>
										</tr>
										<tr>
											<td>&nbsp;</td>
										</tr>
										<tr>
											<td><!-- 상품평 목록 시작 --><?
											$data=Decode64($data);
											$pagecnt=$data[pagecnt];
											$offset=$data[offset];
											$numresults=$MySQL->query("select idx from goods_comment where gidx=$goodsIdx");
											$numrows=mysql_num_rows($numresults);				//총 레코드수..
											$LIMIT		=5;								//페이지당 글 수
											$PAGEBLOCK	=10;								//블럭당 페이지 수
											if($pagecnt==""){$pagecnt=0;}						//페이지 번호 
											if(!$offset){$offset=$pagecnt*$LIMIT*$PAGEBLOCK;} //각 페이지의 시작 글
											$com_qry = "select * from goods_comment where gidx=$goodsIdx order by idx desc limit $offset,$LIMIT";
											$com_result=$MySQL->query($com_qry);
											while($com_row=mysql_fetch_array($com_result))
											{
												$content	= str_replace("\n","<br>", htmlspecialchars($com_row[content])); //글내용
												?>
												<table width="650" border="0" cellspacing="0" cellpadding="0" align='center'>
													<tr>
														<td height='1' bgcolor='E1E1E1' colspan='2'></td>
													</tr>
													<tr>
														<td bgcolor="f4f4f4" height="20" colspan='2'> <font color="#0D78C8">&nbsp;<img src='image/notice_icon.gif'> <b><?=$com_row[userid]?></b></font> 님</td>
													</tr>
													<tr>
														<td height='1' bgcolor='E1E1E1' colspan='2'></td>
													</tr>
													<tr>
														<td bgcolor="fafafa" height='35'> <p><?=$content?></td>
														<td width=55 bgcolor="fafafa"><?
														if ($com_row[userid]==$GOOD_SHOP_USERID)
														{
															?><a href="#;" onclick="commentDel('<?=$com_row[idx]?>')"><img src="image/icon/btn_delete0.gif"></a><?
														}
														?></td>
													</tr>
												</table><?
											}
											?>
											<!-- 상품평 목록 끝 --><?
											$Obj=new CList("goods_detail.php",$pagecnt,$offset,$numrows,$PAGEBLOCK,$LIMIT,"","","goodsIdx=$goodsIdx");
											?></td>
										</tr>
										<tr valign="bottom">
											<td colspan="2" height="30" align="center"><?if($numrows){?><?$Obj->putList(true,"<img src='image/board/btn_prev.gif'>","<img src='image/board/btn_next.gif'>");//이전다음 프린트?><?}?></td>
										</tr>
									</table></form><!-- commentForm -->
								</td>
							</tr><?
							}
							?>
							<!-- 상품평 끝 -->
							<tr>
								<td><img src='image/good/tit_detail_b.gif'></td>
							</tr>
						</table>
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