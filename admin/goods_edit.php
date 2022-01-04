<?
// 소스형상관리
// 20060720-1 파일추가 김성호 : 상품옵션 레이아웃수정
include "head.php";
include "linkstr_goods.php";

$getArrayOS = explode(";", $_SERVER[HTTP_USER_AGENT]);
$BROWGER = trim($getArrayOS[1]);
$OS = trim($getArrayOS[2]);
if(preg_match("/Windows/", $OS) && preg_match("/MSIE/", $BROWGER))
{
	$Os_Check=1;
	$Use_Check="";
}
else
{
	$Os_Check=0;
	$Use_Check="disabled";
}

if(!defined(__ADMIN_ROW))
{
	define(__ADMIN_ROW,"TRUE");
	$admin_row=DBarray("select *from admin limit 0,1"); //관리자 정보 배열
}

$dataArr= Decode64($data);
$goods_row = $MySQL->fetch_array("select * from goods where idx=$dataArr[idx] limit 1");  //상품정보

$category_row = $MySQL->fetch_array("select *from category where code='$goods_row[category]' limit 1");
$str_category = $category_row[name];

// 카테고리 정보 끝
if($goods_row[bOldPrice])
{
	$true_oldPrice		="checked";
	$false_oldPrice		="";
}
else
{
	$true_oldPrice		="";
	$false_oldPrice		="checked";
}

//제조/판매원사용
if($goods_row[bCompany])
{
	$true_bCompany		="checked";
	$false_bCompany		="";
}
else
{
	$true_bCompany		="";
	$false_bCompany		="checked";
}

//원산지
if($goods_row[bOrigin])
{
	$true_bOrigin		="checked";
	$false_bOrigin		="";
}
else
{
	$true_bOrigin		="";
	$false_bOrigin		="checked";
}

//이미지사용 설정
if($goods_row[bHit])	$bHit = "checked";
else					$bHit = "";
if($goods_row[bNew])	$bNew = "checked";
else					$bNew = "";
if($goods_row[bEtc])	$bEtc = "checked";
else					$bEtc = "";

$wSize = array();
$hSize = array();
for ($i=1; $i<=8; $i++)
{
	$str = "img".$i;
	if ($goods_row[$str]) // 해당 이미지가 존재하면 
	{
		$info = @getimagesize("../upload/goods/$goods_row[$str]");
		$wSize[$i] = $info[0];
		$hSize[$i] = $info[1];
	}
}
$content = $goods_row[content];
$trans_content = $goods_row[trans_content];
?>
<SCRIPT LANGUAGE="JavaScript">
<!--
//시중가 사용 활성/비활성
function showOldprice()
{
	var form= document.goodsForm;
	if(form.bOldPrice[0].checked)
	{
		showObject(form.oldPrice,true);
		showObject(form.sale,true);
	}
	else
	{
		showObject(form.oldPrice,false);
		showObject(form.sale,false);
	}
}

//제조사 사용 활성/비활성
function showCompany()
{
	var form= document.goodsForm;
	if(form.bCompany[0].checked) showObject(form.company,true);
	else showObject(form.company,false);
}

//원산지 사용 활성/비활성
function showOrigin()
{
	var form= document.goodsForm;
	if(form.bOrigin[0].checked) showObject(form.origin,true);
	else showObject(form.origin,false);
}

//재고수량 사용 활성/비활성
function showLimit()
{
	var form= document.goodsForm;
	if(form.bLimit[0].checked) showObject(form.limitCnt,true);
	else showObject(form.limitCnt,false);
}

//활성/비활성 초기화
function showInit()
{
	showOldprice();		//시중가 사용 활성/비활성	
	showCompany();		//제조사 사용 활성/비활성
	showOrigin();		//원산지 사용 활성/비활성
	showLimit();		//재고수량 사용 활성/비활성
	var form=document.goodsForm;
	<? if ($goods_row[img_onetoall]==1) { ?>
	form.img_onetoall.value = 1;
	showObject(form.img1,false);
	showObject(form.img2,false);
	<? }else { ?>
	form.img_onetoall.value = 0;
	showObject(form.img1,true);
	showObject(form.img2,true);
	<? } ?>
}
function delAtt(partName,strPart)
{
	partName.value = "";
	strPart.value = "";
}
//상품옵션 설정
function addAtt(Obj,Index)
{
	var form=document.goodsForm;
	if(Obj.value=="")
	{
		alert("분류명을 입력해 주십시오.");
		Obj.focus();
	}
	else
	{
		window.open("goods_attribute.php?Val="+Obj.value+"&Index="+Index,"","scrollbars=yes,left=50,top=100,width=420,height=350");
	}
}
//적립금 세팅
function setOldprice()
{
	var form=document.goodsForm;
	var goodsPrice = form.price.value;
	if(hanCheck(goodsPrice))
	{
		alert("상품 가격이 올바르지 않습니다.");
		form.price.focus();
	}
	else
	{
		<? if($admin_row[poMethod]=="t"){?>
		form.point.value = <?=$admin_row[poTotal]?>;
		<?}else{?>
		form.point.value = Math.round(goodsPrice *<?=$admin_row[poUnit]?> /100);
		<?}?>
	}
}

//상품 등록
function goodsSendit()
{
	var form=document.goodsForm;
	if(form.bHtml[2].checked==true)
	{
		<?
		if(!$Os_Check)
		{
			?>
		alert('웹에디터를 지원하지 않습니다.');<?
		}
		?>
		cdiv.gogo();
	}
	form.action = "goods_edit_ok.php";
	form.target="";
	if(form.name.value=="")
	{
		alert("상품명을 입력해 주십시오.");
		form.name.focus();
	}
	else if(form.price.value=="")
	{
		alert("상품 가격을 입력해 주십시오.");
		form.price.focus();
	}
	else if(hanCheck(form.price.value))
	{
		alert("상품 가격이 올바르지 않습니다.");
		form.price.focus();
	}
	else if(form.bOldPrice[0].checked && form.oldPrice.value=="")
	{
		alert("시중가를 입력해 주십시오.");
		form.oldPrice.focus();
	}
	else if(form.bCompany[0].checked && form.company.value=="")
	{
		alert("제조/판매원을 입력해 주십시오.");
		form.company.focus();
	}
	else if(form.bOrigin[0].checked && form.origin.value=="")
	{
		alert("원산지를 입력해 주십시오.");
		form.origin.focus();
	}
	else if(form.bLimit[0].checked && form.limitCnt.value=="")
	{
		alert("재고수량을 입력해 주십시오.");
		form.limitCnt.focus();
	}
	else if(form.partName1.value!="" &&form.strPart1.value=="")
	{
		alert("옵션을 입력해 주십시오.");
		addAtt(form.partName1,1);
	}
	else if(form.partName2.value!="" &&form.strPart2.value=="")
	{
		alert("옵션을 입력해 주십시오.");
		addAtt(form.partName2,2);
	}
	else if(form.partName3.value!="" &&form.strPart3.value=="")
	{
		alert("옵션을 입력해 주십시오.");
		addAtt(form.partName3,3);
	}
	else
	{
		form.str_oldPrice.value		=form.oldPrice.value;	//시중가
		form.str_company.value		=form.company.value;	//제조사
		form.str_origin.value		=form.origin.value;		//원산지
		form.str_limitCnt.value		=form.limitCnt.value;	//재고수량
		form.submit();//전송
	}
}

// 관련상품 찾기 
function addPosition(idx)
{
	window.open("goods_relation.php?idx="+idx,"","scrollbars=yes,width=500,height=750,top=20,left=20");
}

function image_multi()
{
	var form=document.goodsForm; 
	if (form.img_onetoall.value == 0)
	{
		showObject(form.img1,false);
		showObject(form.img2,false);
		form.img_onetoall.value = 1;
	}
	else if (form.img_onetoall.value == 1)
	{
		showObject(form.img1,true);
		showObject(form.img2,true);
		form.img_onetoall.value = 0;
	}
}
///////////시중가 퍼센트 계산 
function sale_per()
{
	var form = document.goodsForm;
	var oPrice = form.oldPrice.value;
	var Price = form.price.value;
	if(!oPrice || oPrice==0)
	{
		var sale_per = "";
	}
	else
	{
		var sale_per = Math.round(((oPrice-Price) / oPrice) * 100);
	}
	form.sale.value = sale_per;
}

function code_check() // 상품코드 수정시 중복검사 
{
	var form=document.goodsForm;
	var gcode = form.goodcode.value;
	form.action="goods_code_check.php?gcode="+gcode;
	form.target = "ifrm";
	form.submit();
}

function code_edit() // 상품코드 수정
{
	var form=document.goodsForm;
	var gcode = form.goodcode.value;
	location.href="goods_edit_ok.php?codeedit=1&data=<?=$data?>&code="+gcode;
}

function list_edit(obj)
{
	<? if ($admin_row[beditprice_warn]=="y"){ ?>
	var last_price = obj.lastprice.value;
	var diff_price = obj.price.value - last_price;
	var warn_price = <?=$admin_row[editprice_warn]?>;
	if (diff_price<0) diff_price = diff_price * (-1);
	if (diff_price >= warn_price)
	{
		if (confirm("이전가와 "+warn_price+"원 이상 차이가 납니다. 수정하시겠습니까?"))
		{
			goodsSendit();
		}
	}
	else
	{
		goodsSendit();
	}
	<? }else { ?>
	goodsSendit();
	<? } ?>
}
//-->
</SCRIPT>
<body text="#000000" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onload="javascript:showInit();">
<? include "top_menu.php"; ?>
<iframe name="ifrm" width=0 height=0 frameborder=0></iframe>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr><?
	$__TOP_MENU = "goods";     //왼쪽 소메뉴 설정 변수
	include "left_menu.php";
	if(!defined(__ADMIN_ROW))
	{
		define(__ADMIN_ROW,"TRUE");
		$admin_row=DBarray("select *from admin limit 0,1"); //관리자 정보 배열
	}
	?>
		<td width="85%" valign="top">
			<table width="100%" height="500" border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td height='5'></td>
				</tr>
				<tr>
					<td>
						<table width="750" border="0" cellspacing="0" cellpadding="0" align='center'>
							<tr>
								<td rowspan="3" width="200"><img src="image/good_tit_img.gif"></td>
								<td>&nbsp;</td>
							</tr>
							<tr>
								<td bgcolor="#E6E6E6" height='26'><div align='right'><font class='text1'>SHOP 상품등록 수정 삭제 등을 하실수 있습니다.&nbsp;</div></td>
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
								<td width='1' bgcolor='dadada' colspan='3'></td>
							</tr>
							<tr>
								<td width='440'><img src="image/goods_data_tit2.gif"></td>
							</tr>
							<tr>
								<td width='1' bgcolor='dadada' colspan='3'></td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td height='10'></td>
				</tr>
				<tr>
					<td valign="top">
						<form name="goodsForm" method="post" action="goods_edit_ok.php" enctype="multipart/form-data" >
						<input type="hidden" name="code" value="<?=$goods_row[category]?>"><!-- 카테고리 코드 -->
						<input type="hidden" name="sort" value="<?=$sort?>"><!-- 정렬방법 ex)asc:오름차순  desc:내림차순 -->
						<input type="hidden" name="sortStr" value="<?=$sortStr?>"><!-- 정렬기준 ex)name:이름  price:가격 -->
						<input type="hidden" name="view_position" value="<?=$position?>"><!-- 위치 -->
						<input type="hidden" name="data" value="<?=$data?>"><!-- 상품정보 -->
						<input type="hidden" name="returnPage" value="<?=$returnPage?>"><!-- 목록파일명 -->
						<!-- 이하 disabled 변수값 재설정 -->
						<input type="hidden" name="str_oldPrice"><!-- 시중가 -->
						<input type="hidden" name="str_company"><!-- 제조사 -->
						<input type="hidden" name="str_origin"><!-- 원산지 -->
						<input type="hidden" name="str_limitCnt"><!-- 재고수량 -->
						<input type="hidden" value="<?=$LINK_STR?>" name="LINK_STR"><!-- 링크정보 -->
						<table width="750" border="0" cellspacing="0" cellpadding="0" align="center">
							<tr valign="middle">
								<td colspan="4" height="50" bgcolor="#FAFAFA">
									<table width="200" border="0" align="center">
										<tr>
											<td> <div align="center"><a href="javascript:list_edit(document.goodsForm);"><img src="image/entry_btn1.gif" width="40" height="17" border="0"></a></div></td>
											<td> <div align="center"><a href="javascript:goodsDel('goods_edit_ok.php?del=1');"><img src="image/delete_btn.gif" width="40" height="17" border="0"></a></div></td>
											<td> <div align="center"><a href="javascript:goUrl('total_goods_list.php?<?=$LINK_STR?>');"><img src="image/list_btn.gif" width="40" height="17" border="0"></a></div></td>
										</tr>
									</table>
								</td>
							</tr>
							<tr>
								<td colspan="4">
									<table width="300" cellspacing="2" cellpadding="2" align="left" border='0'>
										<tr align="center">
											<td width=50% bgcolor="#CBCCF8">상품정보 등록날짜</td>
											<td><b><?=$goods_row[writeday]?></b></td>
										</tr>
										<tr align="center">
											<td width=50% bgcolor="#CBCCF8">상품정보 최근수정날짜</td>
											<td><b><?=$goods_row[editday]?></b></td>
										</tr>
										<tr align="center" >
											<td width=50% bgcolor="#CBCCF8">판매사이트 미리보기</td>
											<td><a href="http://<?=$admin_row[shopUrl]?>/goods_detail.php?goodsIdx=<?=$goods_row[idx]?>" target="_blank"><u><b>미리보기</b></u></a></td>
										</tr>
									</table>
								</td>
							</tr>
							<tr>
								<td colspan="4" height="1" background="image/line_bg1.gif" bgcolor="#F5F5F5"></td>
							</tr>
							<tr>
								<td colspan="4" height="10"></td>
							</tr>
							<tr valign="middle">
								<td width="150" height="25" bgcolor="#FAFAFA"> <div align="left">&nbsp;&nbsp;<img src="image/icon.gif" width="11" height="11"> 상품 카테고리</div></td>
								<td height="25" colspan="3">&nbsp;&nbsp; <B><?=$str_category?></B> </td>
							</tr>
							<tr>
								<td colspan="4" height="1" background="image/line_bg1.gif"></td>
							</tr>
							<tr>
								<td  colspan="4" height="30" align="center"  bgcolor="#051D55"><font color="white"><b>가 격 정 보</b></font></td>
							<tr>
							<tr>
								<td width="137" height="61" bgcolor="#FAFAFA" rowspan="3">&nbsp;&nbsp;<img src="image/icon.gif" width="11" height="11"> 시중가</td>
								<td height="25" colspan="3">
									<table width="250" border="0" cellspacing="0" cellpadding="0" align="left">
										<tr>
											<td width="12"> <div align="center"> </div></td>
											<td width="5%"> <input class="radio" type="radio" name="bOldPrice" value="1" onclick="javascript:showOldprice();" <?=$true_oldPrice?> <?=$price_disabled?>></td>
											<td width="30%"> <div align="left">사용함</div></td>
											<td width="10%"> <div align="center"> <input class="radio" type="radio" name="bOldPrice" value="0" onclick="javascript:showOldprice();" <?=$false_oldPrice?> <?=$price_disabled?>></div></td>
											<td width="50%"> <div align="left">사용하지 않음</div></td>
										</tr>
									</table>&nbsp;&nbsp;<font class="help">※ 판매가격 표시위에 <strike>5,000</strike> 이런식으로 시중가가 표기됩니다.</font>
								</td>
							</tr>
							<tr>
								<td height="1" background="image/line_bg1.gif" colspan="3"></td>
							</tr>
							<tr>
								<td height="25" colspan="3">
									<table width="100%" border="0" cellspacing="0" cellpadding="0">
										<tr>
											<td width="12" height="20">&nbsp;</td>
											<td width="70" height="20" bgcolor="#F5F5F5"> <div align="center"><font color="#0099CC">시 중 가</font></div></td>
											<td width="300" height="20"> &nbsp;&nbsp; <input class="box" name="oldPrice" type="text" id="eday" size="15" <?=__ONLY_NUM?> value="<?=$goods_row[oldPrice]?>" onBlur="javascript:sale_per();" <?=$price_readonly?>>&nbsp;&nbsp;<input name=sale type=text class="box" value="<?=$goods_row[sale]?>" size=2 <?=$price_readonly?>>% <font class="help">&nbsp;※ 시중가사용시 할인율 </font>&nbsp;&nbsp;<input type="checkbox" name="bSaleper" value="1" <? if ($goods_row[bSaleper]) echo "checked";?> <?=$price_disabled?>><font class="help">※사용자화면에 할인률표시 </td>
										</tr>
									</table>
								</td>
							</tr>
							<tr>
								<td colspan="4" height="1" background="image/line_bg1.gif"></td>
							</tr>
							<!-- 일반가격 -->
							<tr>
								<td width="137" height="25" bgcolor="#E1DEFE">&nbsp;&nbsp;<img src="image/icon.gif" width="11" height="11"> <FONT  COLOR="#CC3300">판매가</FONT></td>
								<td height="25" colspan="3"> &nbsp;&nbsp; <input class="box" name="price" type="text" id="eday" size="15" <?=__ONLY_NUM?> value="<?=$goods_row[price]?>" <? if ($admin_row[bUsepoint]){ ?> onblur="setOldprice()" <?}?>></td>
							</tr>
							<tr>
								<td colspan="4" height="1" background="image/line_bg1.gif"></td>
							</tr>
							<tr>
								<td width="137" height="25" bgcolor="#E1DEFE">&nbsp;&nbsp;<img src="image/icon.gif" width="11" height="11"> <FONT  COLOR="#CC3300">이전가</FONT></td>
								<td height="25" colspan="3"><div align="left"><FONT COLOR="#990000">&nbsp;&nbsp;&nbsp;<?=PriceFormat($goods_row[lastprice])?></FONT>&nbsp;원&nbsp;</div> <input type="hidden" name="lastprice" value="<?=$goods_row[lastprice]?>"></td>
							</tr>
							<tr>
								<td colspan="4" height="1" background="image/line_bg1.gif"></td>
							</tr>
							<tr  id="idprice1">
								<td width="137" height="25" bgcolor="#E1DEFE">&nbsp;&nbsp;<img src="image/icon.gif" width="11" height="11"> 적립금</td>
								<td height="25" colspan="3"> &nbsp;&nbsp; <input class="box" name="point" type="text" id="eday" size="15" <?=__ONLY_NUM?>  value="<?=$goods_row[point]?>" ></td>
							</tr>
							<tr>
								<td colspan="4" height="1" background="image/line_bg1.gif"></td>
							</tr>
							<tr>
								<td width="137" height="25" bgcolor="#FAFAFA">&nbsp;&nbsp;<img src="image/icon.gif" width="11" height="11"> 마진</td>
								<td height="25" colspan="3">
									<table>
										<tr>
											<td>&nbsp;&nbsp;<input class="box" name="margin" value="<?=$goods_row[margin]?>" size='3' <?=__ONLY_NUM?>> %</td>
										</tr>
									</table>
								</td>
							</tr>
							<tr>
								<td colspan="4" height="1" background="image/line_bg1.gif"></td>
							</tr>
							<tr>
								<td width="137" height="25" bgcolor="#FAFAFA">&nbsp;&nbsp;<img src="image/icon.gif" width="11" height="11"> 공급가</td>
								<td height="25" colspan="3">
									<table>
										<tr>
											<td>&nbsp; <input class="box" name="supplyprice" type="text" id="eday" size="15" <?=__ONLY_NUM?> value="<?=$goods_row[supplyprice]?>"> 원 </td>
											<td><font class="help">※ 상품의 공급가 (실제 화면출력은 되지 않습니다.)</font></td>
										</tr>
									</table>
								</td>
							</tr>
							<tr>
								<td colspan="4" height="1" background="image/line_bg1.gif"></td>
							</tr>
							<tr>
								<td colspan="4" height="10">&nbsp;</td>
							</tr>
							<tr>
								<td  colspan="4" height="30" align="center"  bgcolor="#051D55"><font color="white"><b>기 본 정 보</b></font></td>
							</tr>
							<tr valign="middle">
								<td width="137" height="25" bgcolor="#FAFAFA"> <div align="left">&nbsp;&nbsp;<img src="image/icon.gif" width="11" height="11"> <FONT  COLOR="#CC3300">상품코드</FONT></div></td>
								<td height="25" colspan="3">&nbsp;&nbsp; <FONT  COLOR="#6600FF"><input class="box" name="goodcode" type="text" id="eday" size="20" value="<?=$goods_row[code]?>">&nbsp;<a href="javascript:code_check();"><img src="image/jungbok.gif" border=0 ></a>&nbsp;<a href="javascript:code_edit();"><img src="image/edit_btn.gif" border=0 ></a> &nbsp;<font class="help">※ 상품코드를 다른것으로 수정할때 <b>중복검색 클릭</b></font></td>
							</tr>
							<tr>
								<td colspan="4" height="1" background="image/line_bg1.gif"></td>
							</tr>
							<tr>
								<td width="137" height="25" bgcolor="#FAFAFA">&nbsp;&nbsp;<img src="image/icon.gif" width="11" height="11"> <FONT  COLOR="#CC3300">상품명</FONT></td>
								<td height="25" colspan="3">&nbsp;&nbsp; <input class="box" name="name" type="text" id="eday" size="60" value="<?=htmlspecialchars($goods_row[name])?>"></td>
							</tr>
							<tr>
								<td colspan="4" height="1" background="image/line_bg1.gif"></td>
							</tr>
							<tr>
								<td width="137" height="25" bgcolor="#FAFAFA">&nbsp;&nbsp;<img src="image/icon.gif" width="11" height="11"> 모델명</td>
								<td height="25" colspan="3">&nbsp;&nbsp; <input class="box" name="model" type="text" id="eday" size="60" value="<?=htmlspecialchars($goods_row[model])?>"></td>
							</tr>
							<tr>
								<td colspan="4" height="1" background="image/line_bg1.gif"></td>
							</tr>
							<tr>
								<td width="137" height="25" bgcolor="#FAFAFA">&nbsp;&nbsp;<img src="image/icon.gif" width="11" height="11"> 검색 키워드</td>
								<td height="25" colspan="3">&nbsp;&nbsp; <textarea class="box" name="meta_str" cols="60" rows="5"><?=$goods_row[meta_str]?></textarea></td>
							</tr>
							<tr>
								<td colspan="4" height="1" background="image/line_bg1.gif"></td>
							</tr>
							<tr>
								<td width="137" height="61" bgcolor="#FAFAFA" rowspan="3">&nbsp;&nbsp;<img src="image/icon.gif" width="11" height="11"> 제조/판매원</td>
								<td height="25" colspan="3">
									<table width="250" border="0" cellspacing="0" cellpadding="0" align="left">
										<tr>
											<td width="12"> <div align="center"> </div></td>
											<td width="5%"> <input class="radio" type="radio" name="bCompany" value="1" onclick="javascript:showCompany();" <?=$true_bCompany?>></td>
											<td width="30%"> <div align="left">사용함</div></td>
											<td width="10%"> <div align="center"> <input class="radio" type="radio" name="bCompany" value="0" onclick="javascript:showCompany();" <?=$false_bCompany?>></div></td>
											<td width="50%"> <div align="left">사용하지 않음</div></td>
										</tr>
									</table>
								</td>
							</tr>
							<tr>
								<td height="1" background="image/line_bg1.gif" colspan="3"></td>
							</tr>
							<tr>
								<td height="25" colspan="3">
									<table width="73%" border="0" cellspacing="0" cellpadding="0">
										<tr>
											<td width="12" height="20">&nbsp;</td>
											<td width="70" height="20" bgcolor="#F5F5F5"> <div align="center"><font color="#0099CC">제조/판매원</font></div></td>
											<td width="172" height="20"> &nbsp;&nbsp; <input class="box" name="company" type="text" id="eday" size="25" value="<?=$goods_row[company]?>"></td>
										</tr>
									</table>
								</td>
							</tr>
							<tr>
								<td colspan="4" height="1" background="image/line_bg1.gif"></td>
							</tr>
							<tr>
								<td width="137" height="61" bgcolor="#FAFAFA" rowspan="3">&nbsp;&nbsp;<img src="image/icon.gif" width="11" height="11"> 원산지</td>
								<td height="25" colspan="3">
									<table width="250" border="0" cellspacing="0" cellpadding="0" align="left">
										<tr>
											<td width="12"> <div align="center"> </div></td>
											<td width="5%"> <input class="radio" type="radio" name="bOrigin" value="1" onclick="javascript:showOrigin();" <?=$true_bOrigin?>></td>
											<td width="30%"> <div align="left">사용함</div></td>
											<td width="10%"> <div align="center"> <input class="radio" type="radio" name="bOrigin" value="0" onclick="javascript:showOrigin();" <?=$false_bOrigin?>></div></td>
											<td width="50%"> <div align="left">사용하지 않음</div></td>
										</tr>
									</table>
								</td>
							</tr>
							<tr>
								<td height="1" background="image/line_bg1.gif" colspan="3"></td>
							</tr>
							<tr>
								<td height="25" colspan="3">
									<table width="73%" border="0" cellspacing="0" cellpadding="0">
										<tr>
											<td width="12" height="20">&nbsp;</td>
											<td width="70" height="20" bgcolor="#F5F5F5"> <div align="center"><font color="#0099CC">원 산 지</font></div></td>
											<td width="172" height="20"> &nbsp;&nbsp; <input class="box" name="origin" type="text" id="eday" size="25" value="<?=$goods_row[origin]?>"></td>
										</tr>
									</table>
								</td>
							</tr>
							<tr>
								<td colspan="4" height="1" background="image/line_bg1.gif"></td>
							</tr><?
							$bHtml_chk[$goods_row[bHtml]]="checked";
							?>
							<tr valign="middle">
								<td width="137" height="25" bgcolor="#FAFAFA">&nbsp;&nbsp;<img src="image/icon.gif" width="11" height="11"> 제품 상세 정보</td>
								<td height="25" colspan="3"> &nbsp;&nbsp; <INPUT TYPE="radio" NAME="bHtml" value='0' onclick="document.getElementById('nsText').style.display='block';document.getElementById('nsHtml').style.display='none';document.getElementById('nsEdit').style.display='none';" <?= $bHtml_chk[0]?>>TEXT &nbsp; <INPUT TYPE="radio" NAME="bHtml" value='2' onclick="document.getElementById('nsText').style.display='none';document.getElementById('nsHtml').style.display='block';document.getElementById('nsEdit').style.display='none';" <?= $bHtml_chk[2]?>>HTML &nbsp; <INPUT TYPE="radio" NAME="bHtml" value='1' onclick="document.getElementById('nsText').style.display='none';document.getElementById('nsHtml').style.display='none';document.getElementById('nsEdit').style.display='block';" <?= $Use_Check?> <?= $bHtml_chk[1]?>>웹에디터</td>
							</tr>
							<tr valign="middle">
								<td colspan="4" valign=top align="center" width="600">
									<table width="600" cellpadding="0" cellspacing="0" border="0" id='nsText' style='display:<?=!$goods_row[bHtml]?"block":"none"?>'>
										<tr>
											<td><textarea name="TextContent" style="width:100%" rows="25" cols="80"><?=htmlspecialchars($content)?></textarea></td>
										</tr>
									</table>
									<table width="600" cellpadding="0" cellspacing="0" border="0" id='nsHtml' style='display:<?=$goods_row[bHtml]==2?"block":"none"?>'>
										<tr>
											<td><textarea name="HtmlContent" style="width:100%" rows="25" cols="80"><?=htmlspecialchars($content)?></textarea></td>
										</tr>
									</table>
									<table width="600" cellpadding="0" cellspacing="0" border="0" id='nsEdit' style='display:<?=$goods_row[bHtml]==1?"block":"none"?>'>
										<tr>
											<td width="600"><?
											$form_name = "goodsForm";
											$dir_path = "..";
											include "../editor.php";
											?><textarea style="display:none" class="text" name="content" cols="90" rows="10"><?=htmlspecialchars($content)?></textarea></td>
										</tr>
									</table><br><br>
								</td>
							</tr>
							<tr>
								<td colspan="4" height="1" background="image/line_bg1.gif"></td>
							</tr>
							<tr valign="middle">
								<td width="137" height="25" bgcolor="#FAFAFA"> <div align="left">&nbsp;&nbsp;<img src="image/icon.gif" width="11" height="11"> 상세이미지 1</div></td>
								<td height="25" colspan="3">
									<table border="0" cellspacing="0" cellpadding="0">
										<tr>
											<td width="12" height="26">&nbsp;</td>
											<td width="500" height="26"> <input class="box" type="file" name="detailimg1">&nbsp;&nbsp;<a href="javascript:zoom('../upload/goods/<?=$goods_row[detailimg1]?>','<?=$wdSize[1]?>','<?=$hdSize[1]?>');"><u><?=$goods_row[detailimg1]?></u></a>&nbsp;<a href="goods_edit_ok.php?detailimgdel=1&img_num=1&data=<?=$data?>&returnPage=<?=$returnPage?>"><img src="image/delete_btn.gif" border=0></a></td>
										</tr>
									</table>
								</td>
							</tr>
							<tr>
								<td colspan="4" height="1" background="image/line_bg1.gif"></td>
							</tr>
							<tr valign="middle">
								<td width="137" height="25" bgcolor="#FAFAFA"> <div align="left">&nbsp;&nbsp;<img src="image/icon.gif" width="11" height="11"> 상세이미지 2</div></td>
								<td height="25" colspan="3">
									<table border="0" cellspacing="0" cellpadding="0">
										<tr>
											<td width="12" height="26">&nbsp;</td>
											<td width="500" height="26"> <input class="box" type="file" name="detailimg2">&nbsp;&nbsp;<a href="javascript:zoom('../upload/goods/<?=$goods_row[detailimg2]?>','<?=$wdSize[2]?>','<?=$hdSize[2]?>');"><u><?=$goods_row[detailimg2]?></u></a> <a href="goods_edit_ok.php?detailimgdel=1&img_num=2&data=<?=$data?>&returnPage=<?=$returnPage?>"><img src="image/delete_btn.gif" border=0></a>&nbsp;&nbsp;</td>
										</tr>
									</table>
								</td>
							</tr>
							<tr>
								<td colspan="4" height="1" background="image/line_bg1.gif"></td>
							</tr>
							<tr valign="middle">
								<td width="137" height="25" bgcolor="#FAFAFA"> <div align="left">&nbsp;&nbsp;<img src="image/icon.gif" width="11" height="11"> 상세이미지 3</div></td>
								<td height="25" colspan="3">
									<table border="0" cellspacing="0" cellpadding="0">
										<tr>
											<td width="12" height="26">&nbsp;</td>
											<td width="500" height="26"> <input class="box" type="file" name="detailimg3">&nbsp;&nbsp;<a href="javascript:zoom('../upload/goods/<?=$goods_row[detailimg3]?>','<?=$wdSize[3]?>','<?=$hdSize[3]?>');"><u><?=$goods_row[detailimg3]?></u></a> &nbsp;<a href="goods_edit_ok.php?detailimgdel=1&img_num=3&data=<?=$data?>&returnPage=<?=$returnPage?>"><img src="image/delete_btn.gif" border=0></a></td>
										</tr>
									</table>
								</td>
							</tr>
							<tr>
								<td colspan="4" height="1" background="image/line_bg1.gif"></td>
							</tr>
							<tr valign="middle">
								<td width="137" height="25" bgcolor="#FAFAFA"> <div align="left">&nbsp;&nbsp;<img src="image/icon.gif" width="11" height="11"> 상세이미지 4</div></td>
								<td height="25" colspan="3">
									<table border="0" cellspacing="0" cellpadding="0">
										<tr>
											<td width="12" height="26">&nbsp;</td>
											<td width="500" height="26"> <input class="box" type="file" name="detailimg4">&nbsp;&nbsp;<a href="javascript:zoom('../upload/goods/<?=$goods_row[detailimg4]?>','<?=$wdSize[4]?>','<?=$hdSize[4]?>');"><u><?=$goods_row[detailimg4]?></u></a> &nbsp;<a href="goods_edit_ok.php?detailimgdel=1&img_num=4&data=<?=$data?>&returnPage=<?=$returnPage?>"><img src="image/delete_btn.gif" border=0></a></td>
										</tr>
									</table>
								</td>
							</tr>
							<tr>
								<td colspan="4" height="1" background="image/line_bg1.gif"></td>
							</tr>
							<tr>
								<td  colspan="4" height="30" align="center"  bgcolor="#051D55"><font color="white"><b>옵 션 정 보</b></font></td>
							</tr>
							<!-- 상품옵션 시작 -->
							<tr valign="middle">
								<td width="137" bgcolor="#FAFAFA"> <div align="left">&nbsp;&nbsp;<img src="image/icon.gif" width="11" height="11"> 상품옵션사용<br><font class="help">&nbsp;판매가변동없음<br>&nbsp;재고관리 없음</font></div></td>
								<td height="25" width="12"> </td>
								<td style='padding:5 0 5 0;'>
									<table width="480" border="0" cellspacing="1" cellpadding="0" bgcolor='#C2C2C2'>
										<tr>
											<td bgcolor="#EBEBEB" height="25" width="100"> <div align="center"><font color="#424242">옵션명</font></div></td>
											<td height="25" bgcolor='#FFFFFF' width="380">
												<table width="90%" border="0" cellspacing="0" cellpadding="0">
													<tr>
														<td width="70" height="26" style='padding:0 0 0 5;'> <input class="box" name="partName1" type="text" id="eday" size="15" value="<?=$goods_row[partName1]?>"></td>
														<td height="26"><a href="javascript:addAtt(document.goodsForm.partName1,1);"> <img src="image/ok_btn.gif" width="40" height="17" border="0"></a><img src="image/delete_btn.gif" onclick="delAtt(document.goodsForm.partName1,document.goodsForm.strPart1);"><font class="help">예) 색상</font></td>
													</tr>
												</table>
											</td>
										</tr>
										<tr valign="middle">
											<td bgcolor="#EBEBEB" height="25" width="100"> <div align="center"><font color="#424242">옵션 문자열</font></div></td>
											<td height="25" bgcolor='#FFFFFF' width="380">&nbsp; <input class="nonbox" name="strPart1" type="text" id="eday" size="50" readonly value="<?=$goods_row[strPart1]?>"><br><font class="help">예) 옵션에 대한 선택사항 (빨강,파랑)</font></td>
										</tr>
									</table>
									<table width="100%" border="0" cellspacing="0" cellpadding="0">
										<tr>
											<td height="2"></td>
										</tr>
									</table>
									<table width="480" border="0" cellspacing="1" cellpadding="0" bgcolor='#C2C2C2'>
										<tr valign="middle">
											<td bgcolor="#EBEBEB" height="25" width="100"> <div align="center"><font color="#424242">옵션명</font></div></td>
											<td height="25" bgcolor='#FFFFFF' width="380">
												<table width="90%" border="0" cellspacing="0" cellpadding="0">
													<tr>
														<td width="100" height="26" style='padding:0 0 0 5;'> <input class="box" name="partName2" type="text" id="eday" size="15" value="<?=$goods_row[partName2]?>"></td>
														<td height="26"><a href="javascript:addAtt(document.goodsForm.partName2,2);"><img src="image/ok_btn.gif" width="40" height="17" border="0"></a><img src="image/delete_btn.gif" onclick="delAtt(document.goodsForm.partName2,document.goodsForm.strPart2);"><font class="help">예) 크기</font></td>
													</tr>
												</table>
											</td>
										</tr>
										<tr valign="middle">
											<td bgcolor="#EBEBEB" height="25" width="100"> <div align="center"><font color="#424242">옵션 문자열</font></div></td>
											<td height="25" bgcolor='#FFFFFF' width="380">&nbsp; <input class="nonbox" name="strPart2" type="text" id="eday" size="50" readonly value="<?=$goods_row[strPart2]?>"><br><font class="help">예) 옵션에 대한 선택사항 (대,중,소)</font></td>
										</tr>
									</table>
									<table width="100%" border="0" cellspacing="0" cellpadding="0">
										<tr>
											<td height="2"></td>
										</tr>
									</table>
									<table width="480" border="0" cellspacing="1" cellpadding="0" bgcolor='#C2C2C2'>
										<tr valign="middle">
											<td bgcolor="#EBEBEB" height="25" width="100"> <div align="center"><font color="#424242">옵션명</font></div></td>
											<td height="25" bgcolor='#FFFFFF' width="380">
												<table width="90%" border="0" cellspacing="0" cellpadding="0">
													<tr>
														<td width="100" height="26" style='padding:0 0 0 5;'> <input class="box" name="partName3" type="text" id="eday" size="15" value="<?=$goods_row[partName3]?>"></td>
														<td height="26"><a href="javascript:addAtt(document.goodsForm.partName3,3);"><img src="image/ok_btn.gif" width="40" height="17" border="0"></a>&nbsp;<img src="image/delete_btn.gif" onclick="delAtt(document.goodsForm.partName3,document.goodsForm.strPart3);"></td>
													</tr>
												</table>
											</td>
										</tr>
										<tr valign="middle">
											<td bgcolor="#EBEBEB" height="25" width="100"> <div align="center"><font color="#424242">옵션 문자열</font></div></td>
											<td height="25" bgcolor='#FFFFFF' width="380">&nbsp; <input class="nonbox" name="strPart3" type="text" id="eday" size="50" readonly value="<?=$goods_row[strPart3]?>"></td>
										</tr>
									</table>
								</td>
							</tr>
							<tr valign="middle">
								<td height="1" background="image/line_bg1.gif" colspan="3"></td>
							</tr>
							<!-- 상품옵션 끝 -->
							<tr>
								<td  colspan="4" height="30" align="center"  bgcolor="#051D55"><font color="white"><b>배 송 / 제 고 설 정</b></font></td>
							</tr>
							<tr>
								<td width="137" height="30" bgcolor="#FAFAFA">&nbsp;&nbsp;<img src="image/icon.gif" width="11" height="11"> 배송구분 설정</td>
								<td height="25" colspan="3"> &nbsp;&nbsp; <input name="size" type="checkbox" value="N" <? if ($goods_row[size]=="N") echo "checked";?>>무료배송</td>
							</tr>
							<tr>
								<td colspan="4" height="1" background="image/line_bg1.gif"></td>
							</tr>
							<tr>
								<td width="137" height="61" bgcolor="#FAFAFA" rowspan="3">&nbsp;&nbsp;<img src="image/icon.gif" width="11" height="11"> 재고수량</td>
								<td height="25" colspan="3">
									<table width="400" border="0" cellspacing="0" cellpadding="0" align="left">
										<tr>
											<td width="12"> <div align="center"></div></td>
											<td> <input class="radio" type="radio" name="bLimit" value="1" onclick="javascript:showLimit();" <? if ($goods_row[bLimit]==1) echo "checked";?>>제한&nbsp;&nbsp;&nbsp;&nbsp;<input class="radio" type="radio" name="bLimit" value="0" onclick="javascript:showLimit();" <? if ($goods_row[bLimit]==0) echo "checked";?>>무제한&nbsp;&nbsp;&nbsp;&nbsp;<input class="radio" type="radio" name="bLimit" value="2" <? if ($goods_row[bLimit]==2) echo "checked";?>>품절&nbsp;&nbsp;&nbsp;&nbsp;<input class="radio" type="radio" name="bLimit" value="3" <? if ($goods_row[bLimit]==3) echo "checked";?>>보류&nbsp;&nbsp;&nbsp;&nbsp;<input class="radio" type="radio" name="bLimit" value="4" <? if ($goods_row[bLimit]==4) echo "checked";?>>단종&nbsp;&nbsp;&nbsp;&nbsp;<br>&nbsp;&nbsp;<font class="help">※ <b>품절</b>설정시 잔여재고에 상관없이 품절상태로 보여집니다.</font><br>&nbsp;&nbsp;<font class="help">※ <b>보류,단종</b>설정시 쇼핑몰내에서 보여지지 않습니다.</font><br>&nbsp;&nbsp;<font class="help">※ <b>옵션+재고연동</b> 기능사용시 제한,무제한 기능은 쓸수 없습니다.</font></td>
										</tr>
									</table>
								</td>
							</tr>
							<tr>
								<td height="1" background="image/line_bg1.gif" colspan="3"></td>
							</tr>
							<tr>
								<td height="25" colspan="3">
									<table width="73%" border="0" cellspacing="0" cellpadding="0">
										<tr>
											<td width="12" height="20">&nbsp;</td>
											<td width="70" height="20" bgcolor="#F5F5F5"> <div align="center"><font color="#0099CC">재고수량</font></div></td>
											<td width="172" height="20"> &nbsp;&nbsp; <input class="box" name="limitCnt" type="text" id="eday" size="15" <?=__ONLY_NUM?> value="<?=$goods_row[limitCnt]?>" ></td>
										</tr>
									</table>
								</td>
							</tr>
							<tr>
								<td colspan="4" height="1" background="image/line_bg1.gif"></td>
							</tr>
							<tr>
								<td width="137" height="30" bgcolor="#FAFAFA">&nbsp;&nbsp;<img src="image/icon.gif" width="11" height="11"> 최소,최대 구매수량</td>
								<td height="25" colspan="3"> &nbsp;&nbsp;최소 구매수량 <input class="box" name="minbuyCnt" type="text" value="<?=$goods_row[minbuyCnt]?>" size="5"> 개 &nbsp;&nbsp;<font class="help">※ 값 설정시 본상품을 최소구매수량 이하로 주문할수 없습니다.</font><br>&nbsp;&nbsp; 최대 구매수량 <input class="box" name="maxbuyCnt" type="text" value="<?=$goods_row[maxbuyCnt]?>" size="5"> 개 &nbsp;&nbsp;<font class="help">※ 값 설정시 본상품을 최대구매수량 이상으로 주문할수 없습니다.</font></td>
							</tr>
							<tr>
								<td colspan="4" height="1" background="image/line_bg1.gif"></td>
							</tr>
							<tr valign="middle">
								<td width="137" height="25" bgcolor="#FAFAFA"> <div align="left">&nbsp;&nbsp;<img src="image/icon.gif" width="11" height="11"> 제품 배송정보<br>※ 본제품에만 특별히 다른 배송정보를 기재할때만 사용 </div></td>
								<td height="25" colspan="3">
									<table border="0" cellspacing="0" cellpadding="0">
										<tr>
											<td width="12" height="26">&nbsp;</td>
											<td width="500" height="26"> <textarea name="trans_content" class="box" cols="90" rows="10"><?=htmlspecialchars($trans_content)?></textarea></td>
										</tr>
									</table>
								</td>
							</tr>
							<tr>
								<td colspan="4" height="1" background="image/line_bg1.gif"></td>
							</tr>
							<tr>
								<td width="137" height="25" bgcolor="#FAFAFA">&nbsp;&nbsp;<img src="image/icon.gif" width="11" height="11"> 창고지/진열대정보</td>
								<td height="25" colspan="3">&nbsp;&nbsp; <input class="box" name="chango" type="text" id="eday" size="20" value="<?=htmlspecialchars($goods_row[chango])?>"></td>
							</tr>
							<tr>
								<td colspan="4" height="1" background="image/line_bg1.gif"></td>
							</tr>
							<tr>
								<td  colspan="4" height="30" align="center"  bgcolor="#051D55"><font color="white"><b>이 미 지 설 정</b></font></td>
							</tr>
							<!-- 히트이미지 -->
							<tr valign="middle">
								<td width="137" height="25" bgcolor="#FAFAFA"> <div align="left">&nbsp;&nbsp;<img src="image/icon.gif" width="11" height="11"> HIT 이미지 사용</div></td>
								<td height="25" colspan="3"> &nbsp;&nbsp;&nbsp; <input class="radio" type="checkbox" name="bHit" value="1" <?if(!$admin_row[bHit]){?>disabled<?}?> <?=$bHit?>><img src="../upload/goods_hit_img"></td>
							</tr>
							<tr>
								<td colspan="4" height="1" background="image/line_bg1.gif"></td>
							</tr>
							<!-- 뉴이미지 -->
							<tr valign="middle">
								<td width="137" height="25" bgcolor="#FAFAFA"> <div align="left">&nbsp;&nbsp;<img src="image/icon.gif" width="11" height="11"> NEW 이미지 사용</div></td>
								<td height="25" colspan="3"> &nbsp;&nbsp;&nbsp; <input class="radio" type="checkbox" name="bNew" value="1"  <?=$bNew?>> <img src="../upload/goods_new_img"></td>
							</tr>
							<tr>
								<td colspan="4" height="1" background="image/line_bg1.gif"></td>
							</tr>
							<!-- 기타이미지 -->
							<tr valign="middle">
								<td width="137" height="25" bgcolor="#FAFAFA"> <div align="left">&nbsp;&nbsp;<img src="image/icon.gif" width="11" height="11"> 기타 이미지 사용</div></td>
								<td height="25" colspan="3"> &nbsp;&nbsp;&nbsp; <input class="radio" type="checkbox" name="bEtc" value="1" <?if(!$admin_row[bEtc]){?>disabled<?}?> <?=$bEtc?>> <img src="../upload/goods_etc_img"  ></td>
							</tr>
							<tr>
								<td colspan="4" height="1" background="image/line_bg1.gif"></td>
							</tr>
							<tr valign="middle">
								<td width="137" height="60" bgcolor="#FAFAFA"> <div align="left">&nbsp;&nbsp;<img src="image/icon.gif" width="11" height="11"> 워터마크 삽입</div></td>
								<td height="25" colspan="3">
									<table border="0" cellspacing="0" cellpadding="0">
										<tr>
											<td width="12" >&nbsp;</td>
											<td width="500"> <input type="checkbox" value="y"  name="bWmark" <?if ($goods_row[bWmark]=="y") echo "checked"; ?>> 확대이미지에만 이미지 무단도용을 방지하는 워터마크 삽입 <br><a href="goods_manage.php"><u><b>워터마크 이미지 설정 바로가기</b></u></a></td>
										</tr>
									</table>
								</td>
							</tr>
							<tr>
								<td colspan="4" height="1" background="image/line_bg1.gif"></td>
							</tr>
							<tr valign="middle">
								<td width="137" height="50" bgcolor="#FAFAFA"> <div align="left">&nbsp;&nbsp;<img src="image/icon.gif" width="11" height="11"> 상품이미지 처리</div></td>
								<td height="25" colspan="3">
									<table border="0" cellspacing="0" cellpadding="0">
										<tr>
											<td width="12" >&nbsp;</td>
											<td width="500" > <input type="checkbox" value=1  name="img_onetoall" onclick="javascript:image_multi();" <?if ($goods_row[img_onetoall]==1) echo "checked"; ?>> 확대이미지[1] 한개만 업로드하여 대,중,소 이미지를 같이 사용<br>(GIF 애니메이션은 자동생성 안됨)</td>
										</tr>
									</table>
								</td>
							</tr>
							<tr>
								<td colspan="4" height="1" background="image/line_bg1.gif"></td>
							</tr>
							<tr valign="middle">
								<td width="137" height="25" bgcolor="#FAFAFA"> <div align="left">&nbsp;&nbsp;<img src="image/icon.gif" width="11" height="11"> <FONT  COLOR="#CC3300">작은 이미지</FONT></div></td>
								<td height="25" colspan="3">
									<table border="0" cellspacing="0" cellpadding="0">
										<tr>
											<td width="12" height="26">&nbsp;</td>
											<td width="500" height="26"> <? if ($goods_row[img1]) { ?><img align="absmiddle" style="border-width:1px;border-color:#eeeeee;border-style:solid;" src="../upload/goods/<?=$goods_row[img1]?>" width="50" height="50">&nbsp;&nbsp;&nbsp;<a href="javascript:zoom('../upload/goods/<?=$goods_row[img1]?>','<?=$wSize[1]?>','<?=$hSize[1]?>');"><u><?=$goods_row[img1]?></u></a><br><? } ?><input class="box" type="file" name="img1">&nbsp;<a href="goods_edit_ok.php?imgdel=1&img_num=1&data=<?=$data?>&returnPage=<?=$returnPage?>"><img src="image/delete_btn.gif" border=0></a>(100*100)</td>
										</tr>
									</table>
								</td>
							</tr>
							<tr>
								<td colspan="4" height="1" background="image/line_bg1.gif"></td>
							</tr>
							<tr valign="middle">
								<td width="137" height="25" bgcolor="#FAFAFA"><div align="left">&nbsp;&nbsp;<img src="image/icon.gif" width="11" height="11"> <FONT  COLOR="#CC3300">큰 이미지</FONT></div></td>
								<td height="25" colspan="3">
									<table border="0" cellspacing="0" cellpadding="0">
										<tr>
											<td width="12" height="26">&nbsp;</td>
											<td width="500" height="26"> <? if ($goods_row[img2]) { ?><img align="absmiddle" style="border-width:1px;border-color:#eeeeee;border-style:solid;" src="../upload/goods/<?=$goods_row[img2]?>" width="75" height="75">&nbsp;&nbsp;&nbsp;<a href="javascript:zoom('../upload/goods/<?=$goods_row[img2]?>','<?=$wSize[2]?>','<?=$hSize[2]?>');"><u><?=$goods_row[img2]?></u></a><br><? } ?><input class="box" type="file" name="img2">&nbsp;<a href="goods_edit_ok.php?imgdel=1&img_num=2&data=<?=$data?>&returnPage=<?=$returnPage?>"><img src="image/delete_btn.gif" border=0></a>(240*240)</td>
										</tr>
									</table>
								</td>
							</tr>
							<tr>
								<td colspan="4" height="1" background="image/line_bg1.gif"></td>
							</tr>
							<tr valign="middle">
								<td width="137" height="25" bgcolor="#FAFAFA"> <div align="left">&nbsp;&nbsp;<img src="image/icon.gif" width="11" height="11"> <FONT  COLOR="#CC3300">확대 이미지[1]</FONT></div></td>
								<td height="25" colspan="3">
									<table border="0" cellspacing="0" cellpadding="0">
										<tr>
											<td width="12" height="26">&nbsp;</td>
											<td width="500" height="26"><?
											if ($goods_row[img3])
											{
												?><img align="absmiddle" style="border-width:1px;border-color:#eeeeee;border-style:solid;" src="../upload/goods/<?=$goods_row[img3]?>" width="100" height="100">&nbsp;&nbsp;&nbsp;<a href="javascript:zoom('../upload/goods/<?=$goods_row[img3]?>','<?=$wSize[3]?>','<?=$hSize[3]?>');"><u><?=$goods_row[img3]?></u></a><br><?
											}
											?><input class="box" type="file" name="img3">&nbsp;<a href="goods_edit_ok.php?imgdel=1&img_num=3&data=<?=$data?>&returnPage=<?=$returnPage?>"><img src="image/delete_btn.gif" border=0></a>&nbsp;(500*500)</td>
										</tr>
									</table>
								</td>
							</tr>
							<tr>
								<td colspan="4" height="1" background="image/line_bg1.gif"></td>
							</tr><?
							for($i=0;$i<5;$i++)
							{
								$num = $i+2;
								$img_num = $i+4;
								$img_str = "img".$img_num;
								?>
							<tr valign="middle" id="add_max_img">
								<td width="137" height="25" bgcolor="#FAFAFA"><div align="left">&nbsp;&nbsp;<img src="image/icon.gif" width="11" height="11"> 확대 이미지[<?=$num?>]</div></td>
								<td height="25" colspan="3">
									<table border="0" cellspacing="0" cellpadding="0">
										<tr>
											<td width="12" height="26">&nbsp;</td>
											<td width="220" height="26"><?
											if ($goods_row[$img_str])
											{
												?><img align="absmiddle" style="border-width:1px;border-color:#eeeeee;border-style:solid;" src="../upload/goods/<?=$goods_row[$img_str]?>" width="100" height="100">&nbsp;&nbsp;&nbsp;<a href="javascript:zoom('../upload/goods/<?=$goods_row[$img_str]?>','<?=$wSize[$img_num]?>','<?=$hSize[$img_num]?>');"><u><?=$goods_row[$img_str]?></u></a><br><?
											}
											?><input class="box" type="file" name="img<?=$img_num?>"></td>
											<td width="350" height="26" align=left>&nbsp;<a href="goods_edit_ok.php?imgdel=1&img_num=<?=$img_num?>&data=<?=$data?>&returnPage=<?=$returnPage?>"><img src="image/delete_btn.gif" border=0></a>(500 x 500)</td>
										</tr>
									</table>
								</td>
							</tr>
							<tr id="add_max_img">
								<td colspan="4" height="1" background="image/line_bg1.gif"></td>
							</tr><?
							}
							?>
							<tr>
								<td  colspan="4" height="30" align="center"  bgcolor="#051D55"><font color="white"><b>기 타 설 정</b></font></td>
							<tr>
							<tr>
								<td width="137" height="25" bgcolor="#FAFAFA">&nbsp;&nbsp;<img src="image/icon.gif" width="11" height="11"> 상품 진열 순위</td>
								<td height="25" colspan="3"> &nbsp;&nbsp; <select name="setVal"><?
								for($i=1;$i<=10;$i++)
								{
									?><option value="<?=$i?>" <?if($i==$goods_row[setVal]){echo"selected";}?>><?=$i?></option><?
								}
								?></select> &nbsp;&nbsp;     <FONT  COLOR="#993300">1  《《  높은순위 &nbsp;&nbsp;  낮은순위 》》 10</FONT></td>
							</tr>
							<tr>
								<td colspan="4" height="1" background="image/line_bg1.gif"></td>
							</tr>
							<tr valign="middle">
								<td width="137" height="25" bgcolor="#FAFAFA"> <div align="left">&nbsp;&nbsp;<img src="image/icon.gif" width="11" height="11"> 관련상품</div></td>
								<td>&nbsp;&nbsp;<a href="javascript:addPosition('<?=$goods_row[idx]?>');"><img src="image/entry_btn1.gif" width="40" height="17" border="0"></a><input type="hidden" name="relation" value="<?=$goods_row[relation]?>"></td>
							</tr>
							<tr>
								<td colspan="4" height="1" background="image/line_bg1.gif"></td>
							</tr>
							<tr>
								<td width="137" height="30" bgcolor="#FAFAFA">&nbsp;&nbsp;<img src="image/icon.gif" width="11" height="11"> 제품성능 설정</td>
								<td height="25" colspan="3"> &nbsp;&nbsp; <input name="quality" type="radio" value="A" <? if ($goods_row[quality]=="A") echo "checked";?>>A &nbsp;&nbsp;&nbsp;&nbsp;<input name="quality" type="radio" value="B" <? if ($goods_row[quality]=="B") echo "checked";?>>B &nbsp;&nbsp;&nbsp;&nbsp;<input name="quality" type="radio" value="C" <? if ($goods_row[quality]=="C") echo "checked";?>>C &nbsp;&nbsp;&nbsp;&nbsp;<br>&nbsp;<font class="help">※ 소비자페이지에 노출되지 않습니다. (자체관리조로 사용)</font></td>
							</tr>
							<tr>
								<td colspan="4" height="1" background="image/line_bg1.gif"></td>
							</tr>
							<tr valign="middle">
								<td colspan="4" height="50" bgcolor="#FAFAFA"> 
									<table width="200" border="0" align="center">
										<tr>
											<td><div align="center"><a href="javascript:list_edit(document.goodsForm);"><img src="image/entry_btn1.gif" width="40" height="17" border="0"></a></div></td>
											<td><div align="center"><a href="javascript:goodsDel('goods_edit_ok.php?del=1');"><img src="image/delete_btn.gif" width="40" height="17" border="0"></a></div></td>
											<td><div align="center"><a href="javascript:goUrl('total_goods_list.php?<?=$LINK_STR?>');"><img src="image/list_btn.gif" width="40" height="17" border="0"></a></div></td>
										</tr>
									</table>
								</td>
							</tr>
							<tr>
								<td colspan="4" height="1" background="image/line_bg1.gif" bgcolor="#F5F5F5"></td>
							</tr>
							</form><!-- goodsForm -->
							<SCRIPT LANGUAGE="JavaScript">
							<!--
							function goUrl(url)
							{
								var form=document.viewForm;
								form.action=url;
								form.submit();
							}
							//상품삭제
							function goodsDel(url)
							{
								var form=document.viewForm;
								var choose = confirm("상품이 삭제됩니다.\n\n삭제 하시겠습니까?");
								if(choose)
								{
									form.action=url;
									form.submit();
								}
								else return;
							}
							//-->
							</SCRIPT>
							<form name="viewForm" method="post">
							<input type="hidden" name="catePart" value="<?=$catePart?>"><!-- ex) maxCate:대분류  minCate:중분류 -->
							<input type="hidden" name="cateCode" value="<?=$cateCode?>"><!-- 카테고리 코드 -->
							<input type="hidden" name="sort" value="<?=$sort?>"><!-- 정렬방법 ex)asc:오름차순  desc:내림차순 -->
							<input type="hidden" name="sortStr" value="<?=$sortStr?>"><!-- 정렬기준 ex)name:이름  price:가격 -->
							<input type="hidden" name="position" value="<?=$position?>"><!-- 위치 -->
							<input type="hidden" name="data" value="<?=$data?>"><!-- 상품정보 -->
							<input type="hidden" name="returnPage" value="<?=$returnPage?>"><!-- 목록파일명 -->
							</form>
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