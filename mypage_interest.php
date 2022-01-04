<?
include "head.php";
$member_row = $MySQL->fetch_array("select *from member where userid='$_SESSION[GOOD_SHOP_USERID]'");
?>
<SCRIPT LANGUAGE="JavaScript">
<!--
var goodsIdxArr = new Array();
var goodsCntArr	= new Array();

//체크박스 모두 체크
function allCheck()
{
	var form=document.intForm;
	if(form.chek && form.chek.length)
	{
		//관심상품목록 2이상
		for(i=0;i<form.chek.length;i++)
		{
			if(form.allchek.checked)
			{
				form.chek[i].checked = true;
			}
			else
			{
				form.chek[i].checked = false;
			}
		}
	}
	else if(form.chek)
	{
		//관심상품 1개
		if(form.allchek.checked)
		{
			form.chek.checked = true;
		}
		else
		{
			form.chek.checked = false;
		}
	}
}

//장바구니 담기 전송
function cartSendit(goUrl)
{
	var form=document.intForm;
	form.idxStr.value = goodsIdxArr.join("」「");	//idx 정보
	form.cntStr.value = goodsCntArr.join("」「");	//수량 정보
	form.action = "mypage_interest_ok.php?act=cartadd&goUrl="+goUrl;
	form.submit();
}

//장바구니 이동
function moveCart(goUrl)
{
	//chek : 체크박스  intIdx : interest idx 
	var form=document.intForm;
	var selectErr = true;	//상품선택 에러
	var cntErr	  = false;	//상품구매수량 에러
	if(form.chek && form.chek.length)
	{
		//관심상품목록 2이상 
		for(i=0;i<form.chek.length;i++)
		{
			var cntValue = form.cnt[i].value;
			if(form.chek[i].checked) selectErr=false;//err
			if(form.chek[i].checked &&(cntValue <1)) cntErr =true;	//err
		}
		if(selectErr)
		{
			alert("상품을 선택해 주십시오.");
		}
		else if(cntErr)
		{
			alert("선택된 상품의 구매수량이 올바르지 않습니다.");
		}
		else
		{
			//장바구니 담기
			var goodsCnt =0;
			for(i=0;i<form.chek.length;i++)
			{
				var idxValue = form.intIdx[i].value;
				var cntValue = form.cnt[i].value;
				if(form.chek[i].checked)
				{
					goodsIdxArr[goodsCnt] = idxValue;	//관심품목 테이블 idx
					goodsCntArr[goodsCnt] = cntValue;	//구매 수량
					goodsCnt++;
				}
			}
			cartSendit(goUrl);//전송
		}
	}
	else if(form.chek)
	{
		//관심상품목록 1개
		var cntValue = form.cnt.value;
		if(form.chek.checked) selectErr=false;//err
		if(form.chek.checked &&(cntValue <1)) cntErr =true;	//err
		if(selectErr)
		{
			alert("상품을 선택해 주십시오.");
		}
		else if(cntErr)
		{
			alert("선택된 상품의 구매수량이 올바르지 않습니다.");
		}
		else
		{
			//장바구니 담기
			goodsIdxArr[0] = form.intIdx.value;	//관심품목 테이블 idx
			goodsCntArr[0] = form.cnt.value;	//구매 수량
			cartSendit(goUrl);	//전송
		}
	}
	else
	{
		alert("등록할 상품이 없습니다.");
	}
}

//관심품목 삭제 전송
function delSendit()
{
	var form=document.intForm;
	form.idxStr.value = goodsIdxArr.join("」「");	//idx 정보
	form.action = "mypage_interest_ok.php?act=selectdel";
	form.submit();
}

//관심품목 삭제
function delInter()
{
	var form=document.intForm;
	var selectErr = true;				//상품선택 에러
	if(form.chek && form.chek.length)
	{
		//관심상품목록 2이상 
		for(i=0;i<form.chek.length;i++)
		{
			var cntValue = form.cnt[i].value;
			if(form.chek[i].checked) selectErr=false;//err
		}
		if(selectErr)
		{
			alert("상품을 선택해 주십시오.");
		}
		else
		{
			//삭제
			var goodsCnt =0;
			for(i=0;i<form.chek.length;i++)
			{
				var idxValue = form.intIdx[i].value;
				if(form.chek[i].checked)
				{
					goodsIdxArr[goodsCnt] = idxValue;	//관심품목 테이블 idx
					goodsCnt++;
				}
			}
			delSendit();//전송
		}
	}
	else if(form.chek)
	{
		//관심상품목록 1개
		var cntValue = form.cnt.value;
		if(form.chek.checked) selectErr=false;//err
		if(selectErr)
		{
			alert("상품을 선택해 주십시오.");
		}
		else
		{
			//장바구니 담기
			goodsIdxArr[0] = form.intIdx.value;	//관심품목 테이블 idx
			delSendit();	//전송
		}
	}
	else
	{
		alert("삭제할 상품이 없습니다.");
	}
}
//-->
</SCRIPT>
<? include "top.php";?>
<table width="900" border="0" cellspacing="1" cellpadding="0" bgcolor="<?=$ALL_BGCOLOR?>">
	<tr>
		<? include "left_menu.php";?>
		<td height="51" valign="top" width="720" bgcolor="#FFFFFF">
			<table width="720" border="0" cellspacing="0" cellpadding="0">
				<tr bgcolor="#FFFFFF" valign="top">
					<td colspan="2">
						<table width="720" height="35" border="0" cellspacing="0" cellpadding="0" align='center'>
							<tr>
								<td width="2"  bgcolor="<?=$subdesign[bc5]?>" rowspan="2"></td>
								<td width="2"  bgcolor="<?=$subdesign[bc5]?>" rowspan="2"></td>
								<td width="220" height="27" bgcolor="<?=$subdesign[bc5]?>"><img src="./upload/design/<?=$subdesign[img5]?>" ></td>
								<td width="490" height="27" bgcolor="<?=$subdesign[bc5]?>"><div align="right"> &nbsp;<font color="<?=$subdesign[tc5]?>"> <img src='image/good/icon0.gif'>&nbsp;현재위치 : HOME &gt; Mypage(마이페이지)&gt;관심물품 보기</font>&nbsp;</div></td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td valign="top" width="720"><br><? include "mypage_menu.php";?><br><br>
						<table border='0' width='670' cellpadding='0' cellspacing='0' align='center'>
							<tr>
								<td><img src='image/member/my_tit4.gif'></td>
							</tr>
						</table>
						<form name="intForm" method="post">
						<input type="hidden" name="idxStr">
						<input type="hidden" name="cntStr">
						<table width="600" border="0" cellspacing="0" cellpadding="0" align="center">
							<tr>
								<td><br><br>
									<table width="670" border="0" cellspacing="0" cellpadding="0" height="30" align="center">
										<tr>
											<td bgcolor="80c9d8" height='2' colspan='12'></td>
										</tr>
										<tr>
											<td bgcolor="ffffff" height='1' colspan='12'></td>
										</tr>
										<tr bgcolor="#edf7f9">
											<td width="30" align="center"><input type="checkbox" name="allchek" value="checkbox" onclick="javascript:allCheck();"></td>
											<td width="38" align="center"><font color='006676'><b>번호</b></font></td>
											<td width='1'><img src='image/board/line.gif'></td>
											<td width="248" align="center"> <font color='006676'><b>상품명</b></font></td>
											<td width='1'><img src='image/board/line.gif'></td>
											<td width="100" align="center"> <font color='006676'><b>옵션</b></font></td>
											<td width='1'><img src='image/board/line.gif'></td>
											<td width="76" align="center"> <font color='006676'><b>가 격</b></font></td>
											<td width='1'><img src='image/board/line.gif'></td>
											<td width="44" align="center"> <font color='006676'><b>수량</b></font></td>
											<td width='1'><img src='image/board/line.gif'></td>
											<td width="56" align="center"><font color='006676'><b>삭제</b></font></td>
										</tr>
										<tr>
											<td bgcolor="ffffff" height='1' colspan='12'></td>
										</tr>
										<tr>
											<td bgcolor="80c9d8" height='1' colspan='12'></td>
										</tr>
									</table>
								</td>
							</tr>
							<tr>
								<td valign="top">
									<!-- 관심 상품 목록 시작 -->
									<table width="100%" border="0" cellspacing="0" cellpadding="0" height="25" align="center"><?
									$int_qry    = "select *from interest where userid='$_SESSION[GOOD_SHOP_USERID]'";
									$int_result = $MySQL->query($int_qry);
									$interest_goods_cnt = $MySQL->is_affected();	//관심 물품 개수
									$int_cnt =0;		//폼 카운트
									while($int_row = mysql_fetch_array($int_result))
									{
										$goods_row = $MySQL->fetch_array("select *from goods where idx=$int_row[goodsIdx]"); //상품정보
										//이미지사용
										if($goods_row[bHit]) $bHit ="<img src='admin/image/hit.gif'>";
										else				 $bHit ="";
										if ($admin_row[bNew])  $bNew = limitday($goods_row[writeday],$admin_row[new_day]);
										if($goods_row[bEtc]) $bEtc ="<img src='./upload/goods_etc_img' >";
										else				 $bEtc ="";
										$optionArr = Array("$int_row[option1]","$int_row[option2]","$int_row[option3]");   //옵션 배열
										if (empty($GD_SET) && $goods_row[img_onetoall]) $img_str = $goods_row[img3];
										else if ($GD_SET && $goods_row[img_onetoall] && empty($goods_row[img1])) $img_str = $goods_row[img3];
										else if ($GD_SET && empty($goods_row[img_onetoall]) && empty($goods_row[img1])) $img_str = $goods_row[img3];
										else $img_str = $goods_row[img1];
										?>
										<tr>
											<td width="30" height="25" align="center"> <input type="checkbox" name="chek" value="checkbox" ><input type="hidden" name="intIdx" value="<?=$int_row[idx]?>"></td>
											<td width="38" height="25" align="center"><?=$interest_goods_cnt?></td>
											<td width="45" height="25" align="center"><img src="upload/goods/<?=$img_str?>" width="45" height="45"></td>
											<td width="203" height="25" align="center"><a href="goods_detail.php?goodsIdx=<?=$goods_row[idx]?>"><?=$goods_row[name]?></a> <?=$bHit?> <?=$bNew?> <?=$bEtc?></td>
											<td width="100" height="25" align="center">
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
												</table>
											</td>
											<td width="76" height="25" align="center"><font color="ff0000"><?=PriceFormat($int_row[price])?> 원</font> </td>
											<td width="44" height="25" align="center"> <input type="text" name="cnt" size="2" value="1" <?=__ONLY_NUM?>></td>
											<td width="56" height="25" align="center"> <a href="mypage_interest_ok.php?act=del&intIdx=<?=$int_row[idx]?>"><img src="image/icon/btn_delete0.gif" border="0"></td>
										</tr>
										<tr>
											<td colspan="8" height="1" bgcolor='e1e1e1'></td>
										</tr><?
										$int_cnt ++;
										$interest_goods_cnt --;
									}
									?>
									</table>
									<!-- 관심 상품 목록 끝 -->
								</td>
							</tr>
							<tr>
								<td height="30"><br>
									<table width="400" border="0" cellspacing="2" cellpadding="0" align="center">
										<tr align="center">
											<td><a href="javascript:moveCart('cart');"><img src="image/icon/cart_btn.gif" border="0"></a></td>
											<td><a href="javascript:moveCart('order');"><img src="image/icon/order_btn.gif" border="0"></a></td>
											<td><a href="javascript:delInter();"><img src="image/icon/delete.gif" border="0"></a></td>
											<td><a href="index.php"><img src="image/icon/shopping_continue_btn.gif" border="0"></a></td>
										</tr>
									</table>
								</td>
							</tr>
						</table>
						</form><!-- intForm -->
						<br><br><br>
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