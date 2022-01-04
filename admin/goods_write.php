<?
// 소스형상관리
// 20060720-1 파일추가 김성호 : 상품옵션 레이아웃수정
session_cache_limiter("no-cache, must-revalidate");
include "head.php";
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
	$admin_row=DBarray("select * from admin limit 0,1"); //관리자 정보 배열
}

// 총 카테고리 차수
$category_row = $MySQL->fetch_array("select * from category where code='$code'");
$str_category = $category_row[name];
$this_code = date("YmdHis").getmicrotime();
?>
<SCRIPT LANGUAGE="JavaScript">
<!--
// 시중가 사용 활성/비활성
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

// 제조사 사용 활성/비활성
function showCompany()
{
	var form= document.goodsForm;
	if(form.bCompany[0].checked) showObject(form.company,true);
	else showObject(form.company,false);
}

// 원산지 사용 활성/비활성
function showOrigin()
{
	var form= document.goodsForm;
	if(form.bOrigin[0].checked) showObject(form.origin,true);
	else showObject(form.origin,false);
}

// 재고수량 사용 활성/비활성
function showLimit()
{
	var form= document.goodsForm;
	if(form.bLimit[0].checked) showObject(form.limitCnt,true);
	else showObject(form.limitCnt,false);
}

// 활성/비활성 초기화
function showInit()
{
	showOldprice();		//시중가 사용 활성/비활성
	showCompany();		//제조사 사용 활성/비활성
	showOrigin();		//원산지 사용 활성/비활성
	showLimit();		//재고수량 사용 활성/비활성
	var form=document.goodsForm;	
	form.img_onetoall.value = 0;
}

// 상품옵션 설정
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
		window.open("goods_attribute.php?Val="+Obj.value+"&Index="+Index,"","scrollbars=yes,left=100,top=100,width=420,height=350");
	}
}

// 적립금 세팅
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
		<?
		if($admin_row[poMethod]=="t")
		{
			?>
		form.point.value = <?=$admin_row[poTotal]?>;<?
		}
		else
		{
			?>
		form.point.value = Math.round((goodsPrice *<?=$admin_row[poUnit]?>) /100);<?
		}
		?>
	}
	sale_per();
}

// 상품 등록
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
	form.action="goods_write_ok.php";
	form.target="";
	if(form.name.value=="")
	{
		alert("상품명을 입력해 주십시오.");
		form.name.focus();
	}
	else if(form.price.value=="")
	{
		alert("판매가를 입력해 주십시오.");
		form.price.focus();
	}
	else if(form.bOldPrice[0].checked && form.oldPrice.value=="")
	{
		alert("시중가를 입력해 주십시오.");
		form.oldPrice.focus();
	}
	else if(form.code.value=="")
	{
		alert("상품코드를 입력해 주십시오.");
		form.code.focus();
	}
	else if(form.bCompany[0].checked && form.company.value=="")
	{
		alert("제조/가원을 입력해 주십시오.");
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
		addAtt(form.partName2,2)	;
	}
	else if(form.partName3.value!="" &&form.strPart3.value=="")
	{
		alert("옵션을 입력해 주십시오.");
		addAtt(form.partName3,3);
	}
	else if (form.img_onetoall.value == 1 && form.img3.value =="")
	{
		alert("확대이미지를 입력해 주십시오.");
		form.img3.focus();
	}
	else if (form.img_onetoall.value != 1 && form.img1.value =="")
	{
		alert("작은이미지를 입력해 주십시오.");
		form.img1.focus();
	}
	else if (form.img_onetoall.value != 1 && form.img2.value =="")
	{
		alert("중간이미지를 입력해 주십시오.");
		form.img2.focus();
	}
	else
	{
		if (parseInt(form.price.value) < parseInt(form.supplyprice.value))
		{
			if (confirm("판매가가 공급가보다 작습니다. 현재 입력상태로 등록하시겠습니까?"))
			{
				form.str_oldPrice.value		=form.oldPrice.value;	//시중가
				form.str_company.value		=form.company.value;	//제조사
				form.str_origin.value		=form.origin.value;		//원산지
				form.str_limitCnt.value		=form.limitCnt.value;	//재고수량
				form.str_position.value		="0|0|0|0|0|0|0";		//특정위치정보 
				form.submit();//전송
			}
		}
		else
		{
			form.str_oldPrice.value		=form.oldPrice.value;	//시중가
			form.str_company.value		=form.company.value;	//제조사
			form.str_origin.value		=form.origin.value;		//원산지
			form.str_limitCnt.value		=form.limitCnt.value;	//재고수량
			form.str_position.value		="0|0|0|0|0|0|0";		//특정위치정보 
			form.submit();//전송
		}
	}
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

//시중가 사용시 할인률 계산
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

// 관련상품 찾기 
function addPosition(idx,part)
{
	window.open("goods_relation.php?idx="+idx+"&part="+part,"","scrollbars=yes,width=500,height=750,top=20,left=20");
}

function code_check() // 상품코드 수정시 중복검사 
{
	var form=document.goodsForm;
	var gcode = form.code.value;
	form.action="goods_code_check.php?gcode="+gcode;
	form.target = "ifrm";
	form.submit();
}
//-->
</SCRIPT>
<body bgcolor="#FFFFFF" text="#5A595A" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0"  onload="javascript:showInit();">
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
								<td width='440'><img src="image/good_entry_tit.gif"></td>
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
						<form name="goodsForm" method="post" action="goods_write_ok.php" enctype="multipart/form-data" >
						<input type="hidden" name="category" value="<?=$code?>"><!-- 상품카테고리 정보 -->
						<input type="hidden" name="code_num" value="<?=$new_g_num?>"><!-- 상품순번 정보 -->
						<!-- 이하 disabled 변수값 재설정 -->
						<input type="hidden" name="str_oldPrice"><!-- 시중가 -->
						<input type="hidden" name="str_company"><!-- 제조사 -->
						<input type="hidden" name="str_origin"><!-- 원산지 -->
						<input type="hidden" name="str_limitCnt"><!-- 재고수량 -->
						<input type="hidden" name="str_position"><!-- 특정위치 -->
						<table width="750" border="0" cellspacing="0" cellpadding="0" align="center">
							<tr valign="middle">
								<td colspan="4" height="50" bgcolor="#FAFAFA">
									<table width="200" border="0" align="center">
										<tr>
											<td><div align="center"><a href="javascript:goodsSendit();"><img src="image/entry_btn1.gif" width="40" height="17" border="0"></a></div></td>
											<td><div align="center"><a href="javascript:location.href='total_goods_list.php?code=<?=$code?>';"><img src="image/list_btn.gif" width="40" height="17" border="0"></a></div></td>
										</tr>
									</table>
								</td>
							</tr>
							<tr>
								<td colspan="4" height="1" background="image/line_bg1.gif" bgcolor="#F5F5F5"></td>
							</tr>
							<tr valign="middle">
								<td width="137" height="25" bgcolor="#FAFAFA"> <div align="left">&nbsp;&nbsp;<img src="image/icon.gif" width="11" height="11"> 상품 카테고리</div></td>
								<td height="25" colspan="3">&nbsp;&nbsp; <?=$str_category?></td>
							</tr>
							<tr>
								<td colspan="4" height="1" background="image/line_bg1.gif"></td>
							</tr>
							<tr>
								<td  colspan="4" height="30" align="center"  bgcolor="#051D55"><font color="white"><b>가 격 정 보</b></font></td>
							<tr>
							<!-- 일반가격 -->
							<tr>
								<td width="137" height="25" bgcolor="#E1DEFE">&nbsp;&nbsp;<img src="image/icon.gif" width="11" height="11"> <FONT  COLOR="#CC3300">판매가</FONT></td>
								<td height="25" colspan="3"> &nbsp;&nbsp; <input class="box" name="price" type="text" size="15" <?=__ONLY_NUM?> value="<?=$price?>" onblur="setOldprice();"></td>
							</tr>
							<tr>
								<td colspan="4" height="1" background="image/line_bg1.gif"></td>
							</tr>
							<tr id="idprice1">
								<td width="137" height="25" bgcolor="#E1DEFE">&nbsp;&nbsp;<img src="image/icon.gif" width="11" height="11"> 적립금</td>
								<td height="25" colspan="3"> &nbsp;&nbsp; <input class="box" name="point" type="text" size="15" <?=__ONLY_NUM?> value="<?=$point?>" ></td>
							</tr>
							<tr>
								<td colspan="4" height="1" background="image/line_bg1.gif"></td>
							</tr>
							<tr>
								<td width="137" height="25" bgcolor="#FAFAFA">&nbsp;&nbsp;<img src="image/icon.gif" width="11" height="11"> 마진</td>
								<td height="25" colspan="3">
									<table>
										<tr>
											<td>&nbsp;&nbsp;<input class="box" name="margin" value="" size='3' <?=__ONLY_NUM?>> %</td>
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
											<td>&nbsp; <input class="box" name="supplyprice" type="text" size="15" <?=__ONLY_NUM?>> 원 </td>
											<td><font class="help">※ 상품의 공급가 (실제 화면출력은 되지 않습니다.)</font></td>
										</tr>
									</table>
								</td>
							</tr>
							<tr>
								<td colspan="4" height="1" background="image/line_bg1.gif"></td>
							</tr>
							<tr>
								<td width="137" height="61" bgcolor="#FAFAFA" rowspan="3">&nbsp;&nbsp;<img src="image/icon.gif" width="11" height="11"> 시중가</td>
								<td height="25" colspan="3">
									<table width="250" border="0" cellspacing="0" cellpadding="0" align="left">
										<tr>
											<td width="12"> <div align="center"> </div></td>
											<td width="5%"> <input class="radio" type="radio" name="bOldPrice" value="1" onclick="javascript:showOldprice();" <?=$price_disabled?>></td>
											<td width="30%"> <div align="left">사용함</div></td>
											<td width="10%"> <div align="center"> <input class="radio" type="radio" name="bOldPrice" value="0" checked  onclick="javascript:showOldprice();" <?=$price_disabled?>></div></td>
											<td width="50%"> <div align="left">사용하지 않음</div></td>
										</tr>
									</table>&nbsp;<font class="help">※ 판매가격 표시위에 <strike>5,000 원</strike> 이런식으로 시중가가 표기됩니다.</font>
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
											<td width="300" height="20"> &nbsp;&nbsp; <input class="box" name="oldPrice" type="text" size="15" <?=__ONLY_NUM?> onBlur="javascript:sale_per();">&nbsp;&nbsp;<input name=sale type=text class="box" size=2 readonly>% <font class="help">&nbsp;※ 시중가사용시 할인율 </font>&nbsp;&nbsp;<input type="checkbox" name="bSaleper" value="1" <?=$price_disabled?>><font class="help">※사용자화면에 할인률표시 </td>
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
							<tr>
							<tr valign="middle">
								<td width="137" height="25" bgcolor="#FAFAFA"> <div align="left">&nbsp;&nbsp;<img src="image/icon.gif" width="11" height="11"> <FONT  COLOR="#CC3300">상품코드</FONT></div></td>
								<td height="25" colspan="3">&nbsp;&nbsp; <input class="box" name="code" type="text" size="30" value="<?=$this_code?>">&nbsp;<a href="javascript:code_check();"><img src="image/jungbok.gif" border=0 ></a></td>
							</tr>
							<tr>
								<td colspan="4" height="1" background="image/line_bg1.gif"></td>
							</tr>
							<tr>
								<td width="137" height="25" bgcolor="#FAFAFA">&nbsp;&nbsp;<img src="image/icon.gif" width="11" height="11"> <FONT  COLOR="#CC3300">상품명</FONT></td>
								<td height="25" colspan="3">&nbsp;&nbsp; <input class="box" name="name" type="text" size="60"></td>
							</tr>
							<tr>
								<td colspan="4" height="1" background="image/line_bg1.gif"></td>
							</tr>
							<tr>
								<td width="137" height="25" bgcolor="#FAFAFA">&nbsp;&nbsp;<img src="image/icon.gif" width="11" height="11"> 모델명</td>
								<td height="25" colspan="3">&nbsp;&nbsp; <input class="box" name="model" type="text" size="60"></td>
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
											<td width="5%"> <input class="radio" type="radio" name="bCompany" value="1"  onclick="javascript:showCompany();"></td>
											<td width="30%"> <div align="left">사용함</div></td>
											<td width="10%"> <div align="center"> <input class="radio" type="radio" name="bCompany" value="0" checked onclick="javascript:showCompany();"></div></td>
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
											<td width="172" height="20"> &nbsp;&nbsp; <input class="box" name="company" type="text" size="25"></td>
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
											<td width="5%"> <input class="radio" type="radio" name="bOrigin" value="1"  onclick="javascript:showOrigin();"></td>
											<td width="30%"> <div align="left">사용함</div></td>
											<td width="10%"> <div align="center"> <input class="radio" type="radio" name="bOrigin" value="0"  checked onclick="javascript:showOrigin();"></div></td>
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
											<td width="172" height="20"> &nbsp;&nbsp; <input class="box" name="origin" type="text" size="25"></td>
										</tr>
									</table>
								</td>
							</tr>
							<tr>
								<td colspan="4" height="1" background="image/line_bg1.gif"></td>
							</tr>
							<tr valign="middle">
								<td width="137" height="25" bgcolor="#FAFAFA">&nbsp;&nbsp;<img src="image/icon.gif" width="11" height="11"> 제품 상세 정보</td>
								<td height="25" colspan="3"> &nbsp;&nbsp; <INPUT TYPE="radio" NAME="bHtml" value='0' onclick="document.getElementById('nsText').style.display='block';document.getElementById('nsHtml').style.display='none';document.getElementById('nsEdit').style.display='none';">TEXT &nbsp; <INPUT TYPE="radio" NAME="bHtml" value='2' <?=$Os_Check?"":"checked"?> onclick="document.getElementById('nsText').style.display='none';document.getElementById('nsHtml').style.display='block';document.getElementById('nsEdit').style.display='none';">HTML &nbsp; <INPUT TYPE="radio" NAME="bHtml" value='1' <?=$Os_Check?"checked":""?> onclick="document.getElementById('nsText').style.display='none';document.getElementById('nsHtml').style.display='none';document.getElementById('nsEdit').style.display='block';" <?= $Use_Check?>>웹에디터</td>
							</tr>
							<tr>
								<td colspan="4" valign=top align='center'>
									<table width="600" cellpadding="0" cellspacing="0" border="0" id='nsText' style='display:none'>
										<tr>
											<td><textarea name="TextContent" style="width:100%" rows="20" cols="80"></textarea></td>
										</tr>
									</table>
									<table width="600" cellpadding="0" cellspacing="0" border="0" id='nsHtml' style='display:<?=$Os_Check?"none":"block"?>'>
										<tr>
											<td><textarea name="HtmlContent" style="width:100%" rows="20" cols="80"></textarea></td>
										</tr>
									</table>
									<table width="600" cellpadding="0" cellspacing="0" border="0" id='nsEdit' style='display:<?=$Os_Check?"block":"none"?>'>
										<tr>
											<td><?
											$form_name = "goodsForm";
											$dir_path = "..";
											include "../editor.php";
											?><textarea style="display:none" class="text" name="content" cols="90" rows="10"></textarea></td>
										</tr>
									</table>
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
											<td width="500" height="26"> <input class="box" type="file" name="detailimg1"></td>
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
											<td width="500" height="26"> <input class="box" type="file" name="detailimg2"></td>
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
											<td width="500" height="26"> <input class="box" type="file" name="detailimg3"></td>
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
											<td width="500" height="26"> <input class="box" type="file" name="detailimg4"></td>
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
											<td height="25" width="380" bgcolor='#FFFFFF'>
												<table width="100%" border="0" cellspacing="0" cellpadding="0">
													<tr>
														<td width="10" height="26">&nbsp;</td>
														<td width="70" height="26"> <input class="box" name="partName1" type="text" size="15" value="<?=$goods_row[partName1]?>"></td>
														<td height="26">&nbsp;<a href="javascript:addAtt(document.goodsForm.partName1,1);"><img src="image/ok_btn.gif" width="40" height="17" border="0"></a><font class="help">예) 색상</font></td>
													</tr>
												</table>
											</td>
										</tr>
										<tr valign="middle">
											<td height="25" bgcolor="#EBEBEB" width="100"> <div align="center"><font color="#424242">옵션 문자열</font></div></td>
											<td height="25" width="380" bgcolor='#FFFFFF'>&nbsp; <input class="nonbox" name="strPart1" type="text" size="50" readonly><br><font class="help">예) 옵션에 대한 선택사항 (빨강,파랑)</font></td>
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
											<td height="25" width="380" bgcolor='#FFFFFF'>
												<table width="100%" border="0" cellspacing="0" cellpadding="0">
													<tr>
														<td width="10" height="26">&nbsp;</td>
														<td width="70" height="26"> <input class="box" name="partName2" type="text" size="15"></td>
														<td height="26">&nbsp;<a href="javascript:addAtt(document.goodsForm.partName2,2);"><img src="image/ok_btn.gif" width="40" height="17" border="0"></a><font class="help">예) 크기</font> </td>
													</tr>
												</table>
											</td>
										</tr>
										<tr valign="middle">
											<td height="25" bgcolor="#EBEBEB" width="100"> <div align="center"><font color="#424242">옵션 문자열</font></div></td>
											<td height="25" width="380" bgcolor='#FFFFFF'>&nbsp; <input class="nonbox" name="strPart2" type="text" size="50" readonly><br><font class="help">예) 옵션에 대한 선택사항 (대,중,소)</font></td>
										</tr>
									</table>
									<table width="100%" border="0" cellspacing="0" cellpadding="0">
										<tr>
											<td height="2"></td>
										</tr>
									</table>
									<table width="480" border="0" cellspacing="1" cellpadding="0" bgcolor='#C2C2C2'>
										<tr valign="middle">
											<td width="100" height="25" bgcolor="#EBEBEB"> <div align="center"><font color="#424242">옵션명</font></div></td>
											<td width="380" height="25" bgcolor='#FFFFFF'>
												<table width="60%" border="0" cellspacing="0" cellpadding="0">
													<tr>
														<td width="10" height="26">&nbsp;</td>
														<td width="123" height="26"> <input class="box" name="partName3" type="text" size="15"></td>
														<td width="76" height="26"><a href="javascript:addAtt(document.goodsForm.partName3,3);"><img src="image/ok_btn.gif" width="40" height="17" border="0"></a></td>
													</tr>
												</table>
											</td>
										</tr>
										<tr valign="middle">
											<td width="100" height="25" bgcolor="#EBEBEB"> <div align="center"><font color="#424242">옵션 문자열</font></div></td>
											<td height="25" width="380" bgcolor='#FFFFFF'>&nbsp; <input class="nonbox" name="strPart3" type="text" size="50" readonly></td>
										</tr>
									</table>
								</td>
							</tr>
							<!-- 상품옵션 끝 -->
							<tr>
								<td  colspan="4" height="30" align="center"  bgcolor="#051D55"><font color="white"><b>배 송 / 재 고</b></font></td>
							</tr>
							<tr>
								<td width="137" height="30" bgcolor="#FAFAFA">&nbsp;&nbsp;<img src="image/icon.gif" width="11" height="11"> 배송료구분 설정</td>
								<td height="25" colspan="3"> &nbsp;&nbsp; <input name="size" type="checkbox" value="n" <? if ($goods_row[size]=="n") echo "checked";?>>무료배송</td>
							</tr>
							<tr>
								<td colspan="4" height="1" background="image/line_bg1.gif"></td>
							</tr>
							<tr>
								<td width="137" height="61" bgcolor="#FAFAFA" rowspan="3">&nbsp;&nbsp;<img src="image/icon.gif" width="11" height="11"> 재고수량</td>
								<td height="25" colspan="3">
									<table width="400" border="0" cellspacing="0" cellpadding="0" align="left">
										<tr>
											<td width="12"> <div align="center"> </div></td>
											<td> <input class="radio" type="radio" name="bLimit" value="1" onclick="javascript:showLimit();" <? if ($goods_row[bLimit]==1) echo "checked";?>>제한&nbsp;&nbsp;&nbsp;&nbsp; <input class="radio" type="radio" name="bLimit" value="0" onclick="javascript:showLimit();" <? if ($goods_row[bLimit]==0) echo "checked";?>>무제한&nbsp;&nbsp;&nbsp;&nbsp; <input class="radio" type="radio" name="bLimit" value="2" <? if ($goods_row[bLimit]==2) echo "checked";?>>품절&nbsp;&nbsp;&nbsp;&nbsp; <input class="radio" type="radio" name="bLimit" value="3" <? if ($goods_row[bLimit]==3) echo "checked";?>>보류&nbsp;&nbsp;&nbsp;&nbsp; <input class="radio" type="radio" name="bLimit" value="4" <? if ($goods_row[bLimit]==4) echo "checked";?>>단종&nbsp;&nbsp;&nbsp;&nbsp; <br>&nbsp;&nbsp;<font class="help">※ <b>품절</b>설정시 잔여재고에 상관없이 품절상태로 보여집니다.</font> <br>&nbsp;&nbsp;<font class="help">※ <b>보류,단종</b>설정시 쇼핑몰내에서 보여지지 않습니다.</font> <br>&nbsp;&nbsp;<font class="help">※ <b>옵션+재고연동</b> 기능사용시 제한,무제한 기능은 쓸수 없습니다.</font></td>
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
											<td width="172" height="20"> &nbsp;&nbsp; <input class="box" name="limitCnt" type="text" size="15" <?=__ONLY_NUM?> ></td>
										</tr>
									</table>
								</td>
							</tr>
							<tr>
								<td colspan="4" height="1" background="image/line_bg1.gif"></td>
							</tr>
							<tr>
								<td width="137" height="30" bgcolor="#FAFAFA">&nbsp;&nbsp;<img src="image/icon.gif" width="11" height="11"> 최소,최대 구매수량</td>
								<td height="25" colspan="3"> &nbsp;&nbsp; 최소 구매수량 <input class="box" name="minbuyCnt" type="text" value="<?=$goods_row[minbuyCnt]?>" size="5"> 개 &nbsp;&nbsp;<font class="help">※ 값 설정시 본상품을 최소구매수량 이하로 주문할수 없습니다.</font> <br>&nbsp;&nbsp; 최대 구매수량 <input class="box" name="maxbuyCnt" type="text" value="<?=$goods_row[maxbuyCnt]?>" size="5"> 개 &nbsp;&nbsp;<font class="help">※ 값 설정시 본상품을 최대구매수량 이상으로 주문할수 없습니다.</font></td>
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
											<td width="500" height="26"> <textarea name="trans_content" class="box" cols="90" rows="10"></textarea></td>
										</tr>
									</table>
								</td>
							</tr>
							<tr>
								<td colspan="4" height="1" background="image/line_bg1.gif"></td>
							</tr>
							<tr>
								<td width="137" height="25" bgcolor="#FAFAFA">&nbsp;&nbsp;<img src="image/icon.gif" width="11" height="11"> 창고지/진열대정보</td>
								<td height="25" colspan="3">&nbsp;&nbsp; <input class="box" name="chango" type="text" size="20"></td>
							</tr>
							<tr>
								<td colspan="4" height="1" background="image/line_bg1.gif"></td>
							</tr>
							<tr>
								<td  colspan="4" height="30" align="center"  bgcolor="#051D55"><font color="white"><b>이 미 지</b></font></td>
							<tr>
							<!-- 히트/뉴이미지 -->
							<tr valign="middle">
								<td width="137" height="25" bgcolor="#FAFAFA"> <div align="left">&nbsp;&nbsp;<img src="image/icon.gif" width="11" height="11"> HIT / NEW </div></td>
								<td height="25" colspan="3"> &nbsp;&nbsp;&nbsp; <input class="radio" type="checkbox" name="bHit" value="1" <?if(!$admin_row[bHit]){?>disabled<?}?>> <img src="../upload/goods_hit_img">&nbsp;&nbsp;&nbsp; <input class="radio" type="checkbox" name="bNew" value="1" <?if(!$admin_row[bNew]){?>disabled<?}?>> <img src="../upload/goods_new_img"></td>
							</tr>
							<tr>
								<td colspan="4" height="1" background="image/line_bg1.gif"></td>
							</tr>
							<!-- 기타이미지 -->
							<tr valign="middle">
								<td width="137" height="25" bgcolor="#FAFAFA"> <div align="left">&nbsp;&nbsp;<img src="image/icon.gif" width="11" height="11"> 기타 이미지 사용</div></td>
								<td height="25" colspan="3"> &nbsp;&nbsp;&nbsp; <input class="radio" type="checkbox" name="bEtc" value="1" <?if(!$admin_row[bEtc]){?>disabled<?}?>><img src="../upload/goods_etc_img"></td>
							</tr>
							<tr>
								<td colspan="4" height="1" background="image/line_bg1.gif"></td>
							</tr>
							<tr valign="middle">
								<td width="137" height="40" bgcolor="#FAFAFA"> <div align="left">&nbsp;&nbsp;<img src="image/icon.gif" width="11" height="11"> 워터마크 삽입</div></td>
								<td height="60" colspan="3">
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
											<td width="500" > <input type="checkbox" value=1  name="img_onetoall" onclick="javascript:image_multi();"> 확대이미지[1] 한개만 업로드하여 대,중,소 이미지를 같이 사용 <br>(GIF 애니메이션은 자동생성 안됨)</td>
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
											<td width="400" height="26"> <font class="help">※ 이미지파일명에는 <b>공백,특수문자</b>를 미리 제거해 주시기바랍니다. <br>※ 파일명에 <b>한글이 포함되었을시</b> 컴퓨터에 따라 화면출력에 문제가 발생할 수도 있습니다. </font> <br><input class="box" type="file" name="img1">&nbsp;(100*100)</td>
											<td width="111" height="26">&nbsp;</td>
										</tr>
									</table>
								</td>
							</tr>
							<tr>
								<td colspan="4" height="1" background="image/line_bg1.gif"></td>
							</tr>
							<tr valign="middle">
								<td width="137" height="25" bgcolor="#FAFAFA"> <div align="left">&nbsp;&nbsp;<img src="image/icon.gif" width="11" height="11"> <FONT  COLOR="#CC3300">큰 이미지</FONT></div> </td>
								<td height="25" colspan="3">
									<table border="0" cellspacing="0" cellpadding="0">
										<tr>
											<td width="12" height="26">&nbsp;</td>
											<td width="300" height="26"> <input class="box" type="file" name="img2">&nbsp;(240*240)</td>
											<td width="111" height="26">&nbsp;</td>
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
											<td width="300" height="26"> <input class="box" type="file" name="img3">&nbsp;(500*500)</td>
											<td width="111" height="26" align="center"></td>
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
								?>
							<tr valign="middle">
								<td width="137" height="25" bgcolor="#FAFAFA"> <div align="left">&nbsp;&nbsp;<img src="image/icon.gif" width="11" height="11"> 확대 이미지[<?=$num?>]</div></td>
								<td height="25" colspan="3">
									<table border="0" cellspacing="0" cellpadding="0">
										<tr>
											<td width="12" height="26">&nbsp;</td>
											<td width="227" height="26"> <input class="box" type="file" name="img<?=$img_num?>"></td>
											<td width="151" height="26">&nbsp;최적화 사이즈 (500 x 500) </td>
										</tr>
									</table>
								</td>
							</tr>
							<tr>
								<td colspan="4" height="1" background="image/line_bg1.gif"></td>
							</tr><?
							}
							?>
							<tr>
								<td  colspan="4" height="30" align="center"  bgcolor="#051D55"><font color="white"><b>기 타 설 정</b></font></td>
							</tr>
							<tr>
								<td width="137" height="25" bgcolor="#FAFAFA">&nbsp;&nbsp;<img src="image/icon.gif" width="11" height="11"> 상품 진열 순위</td>
								<td height="25" colspan="3"> &nbsp;&nbsp; <select name="setVal"><?
								for($i=1;$i<=10;$i++)
								{
									?><option value="<?=$i?>" <?if($i==5){echo"selected";}?>><?=$i?></option><?
								}
								?></select> &nbsp;&nbsp;     <FONT  COLOR="#993300">1  《《  높은순위 &nbsp;&nbsp;  낮은순위 》》 10</FONT></td>
							</tr>
							<tr>
								<td colspan="4" height="1" background="image/line_bg1.gif"></td>
							</tr>
							<tr valign="middle">
								<td width="137" height="25" bgcolor="#FAFAFA"> <div align="left">&nbsp;&nbsp;<img src="image/icon.gif" width="11" height="11"> 관련상품</div></td>
								<td colspan=3>&nbsp;&nbsp;<a href="javascript:addPosition('<?=$goods_row[idx]?>','write');"><img src="image/entry_btn1.gif" width="40" height="17" border="0"></a><input type="hidden" name="relation" value=""></td>
							</tr>
							<tr>
								<td colspan="4" height="1" background="image/line_bg1.gif"></td>
							</tr>
							<tr>
								<td width="137" height="30" bgcolor="#FAFAFA">&nbsp;&nbsp;<img src="image/icon.gif" width="11" height="11"> 제품성능 설정</td>
								<td height="25" colspan="3"> &nbsp;&nbsp; <input name="quality" type="radio" value="A" checked>A &nbsp;&nbsp;&nbsp;&nbsp;<input name="quality" type="radio" value="B" >B &nbsp;&nbsp;&nbsp;&nbsp;<input name="quality" type="radio" value="C" >C &nbsp;&nbsp;&nbsp;&nbsp;<br>&nbsp;<font class="help">※ 소비자페이지에 노출되지 않습니다. (자체관리조로 사용)</font></td>
							</tr>
							<tr>
								<td colspan="4" height="1" background="image/line_bg1.gif"></td>
							</tr>
							<tr valign="middle">
								<td colspan="4" height="50" bgcolor="#FAFAFA"> 
									<table width="200" border="0" align="center">
										<tr>
											<td><div align="center"><a href="javascript:goodsSendit();"><img src="image/entry_btn1.gif" width="40" height="17" border="0"></a></div></td>
											<td><div align="center"><a href="javascript:history.go(-1);"><img src="image/cancel_btn.gif" width="40" height="17" border="0"></a></div></td>
										</tr>
									</table>
								</td>
							</tr>
							<tr>
								<td colspan="4" height="1" background="image/line_bg1.gif" bgcolor="#F5F5F5"></td>
							</tr>
						</table></form><!-- goodsForm -->
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>
<? include "copy.php";?>
</body>
</html>