<?
// 소스형상관리
// 20060721-1 파일추가 김성호 : 전자결제 연동 설명문구 유상지원으로 변경
include "head.php";
if ($method =="all")
{
	if ($MySQL->query("UPDATE goods SET point=$p"))
	{
		OnlyMsgView("수정하였습니다.");
		$MySQL->query("UPDATE admin SET poTotal=$p");
	}
	Refresh("adm_account.php");
	exit;
}
else if ($method =="goods")
{
	if ($MySQL->query("UPDATE goods SET point=ROUND( price * ( $p /100 ), 0 )"))
	{
		OnlyMsgView("수정하였습니다.");
		$MySQL->query("UPDATE admin SET poUnit=$p");
	}
	Refresh("adm_account.php");
	exit;
}
?>
<SCRIPT LANGUAGE="JavaScript">
<!--
function enable_epay()
{
	var form=document.adm_accountForm;
	if(form.pgName.value == "none")
	{
		enable_pg_basic(false);
		enable_pg_rate('pg_rate', 0);
		enable_pg_rate('pg_rate_hand', 0);
		enable_pg_rate('pg_rate_iche', 0);
		enable_pg_rate('pg_rate_cyber', 0);
		enable_pg_etc(false, false, false, false);
	}
	else
	{
		enable_pg_basic(true);
		document.adm_accountForm.pG_test[0].style.background = "#dedede";
		document.adm_accountForm.pG_test[1].style.background = "#dedede";
		enable_pg_rate('pg_rate', form.bCardpay.value);
		enable_pg_rate('pg_rate_hand', form.bHpppay.value);
		enable_pg_rate('pg_rate_iche', form.bIchepay.value);
		enable_pg_rate('pg_rate_cyber', form.bCyberpay.value);
		check_Tmode();
	}
}

function check_Tmode()
{
	var form=document.adm_accountForm;
	if(form.pG_test[1].checked)	//실제연동
	{
		switch (form.pgName.value)
		{
			case "dacom" :	enable_pg_etc(true, false, true, false);	break;
			case "allat" :	enable_pg_etc(true, false, true, true);
				showObject(form.bHpppay, false);
				enable_pg_rate('pg_rate_hand', 0);
				break;
			case "inicis" :	enable_pg_etc(true, false, false, false);	break;
			default :		enable_pg_etc(true, false, false, false);	break;
		}
	}
	else	//테스트용
	{
		form.pG_test[0].checked = true;		//값이 널인 경우에 대한 처리 필요
		switch (form.pgName.value)
		{
			case "dacom" :	enable_pg_etc(true, false, true, false);	break;
			case "allat" :	enable_pg_etc(false, false, false, true);
				showObject(form.bHpppay, false);
				enable_pg_rate('pg_rate_hand', 0);
				break;
			case "inicis" :	enable_pg_etc(false, false, false, false);	break;
			default :		enable_pg_etc(false, false, false, false);	break;
		}
	}
}

function enable_pg_rate(rate_box, value)
{
	var target;
	switch (rate_box)
	{
		case "pg_rate"			: target=document.adm_accountForm.pg_rate;			break;
		case "pg_rate_hand"		: target=document.adm_accountForm.pg_rate_hand;		break;
		case "pg_rate_iche"		: target=document.adm_accountForm.pg_rate_iche;		break;
		case "pg_rate_cyber"	: target=document.adm_accountForm.pg_rate_cyber;	break;
	}
	var toggle = (value == 1) ? true:false;
	showObject(target, toggle);
}

function enable_pg_basic(bvalue)
{
	showObject(document.adm_accountForm.pG_test[0], bvalue);
	showObject(document.adm_accountForm.pG_test[1], bvalue);
	showObject(document.adm_accountForm.bCardpay, bvalue);
	showObject(document.adm_accountForm.bHpppay, bvalue);
	showObject(document.adm_accountForm.bIchepay, bvalue);
	showObject(document.adm_accountForm.bCyberpay, bvalue);
	showObject(document.adm_accountForm.pg_rate, bvalue);
	showObject(document.adm_accountForm.pg_rate_hand, bvalue);
	showObject(document.adm_accountForm.pg_rate_iche, bvalue);
	showObject(document.adm_accountForm.pg_rate_cyber, bvalue);
}

function enable_pg_etc(bShop_Id, bEscrow_Id, bPG_mertkey, bPG_encryption)
{
	showObject(document.adm_accountForm.shopId, bShop_Id);
	showObject(document.adm_accountForm.shop_Escrow_Id, bEscrow_Id);
	showObject(document.adm_accountForm.shop_pg_mertkey, bPG_mertkey);
	showObject(document.adm_accountForm.shop_pg_encryption, bPG_encryption);
}

function enable_bank()
{
	var form=document.adm_accountForm;
	var toggle = (form.bBankpay.value == 1) ? true:false;
	for(i=0; i<form.bBank.length; i++)
	{
		form.bBank[i].checked = toggle ? form.bBank[i].checked:false;
		showObject(form.bBank[i], toggle);
	}
	showBank();
}

//은행정보 disabled 토글 함수    변수 : bBank, bankName, bankId, bankOwn
function showBank()
{
	var form=document.adm_accountForm;
	for(i=0; i<form.bBank.length; i++)
	{
		if(form.bBank[i].checked)
		{
			//활성화
			showObject(form.bankName[i],true);
			showObject(form.bankId[i],true);
			showObject(form.bankOwn[i],true);
			document.getElementById('bankTr_'+i).style.backgroundColor = "#E3EDF6";
		}
		else
		{
			//비활성화
			showObject(form.bankName[i],false);
			showObject(form.bankId[i],false);
			showObject(form.bankOwn[i],false);
			document.getElementById('bankTr_'+i).style.backgroundColor = "#FAFAFA";
		}
	}
}

//적립금사용 disabled 토글 함수   변수 : bUsepoint, poReg, poMethod, poTotal, poUnit, poMin, poMax
function showPoint()
{
	var form=document.adm_accountForm;
	if(form.bUsepoint[0].checked)
	{
		//활성화
		showObject(form.poReg,true);
		showObject(form.poMethod[0],true);
		showObject(form.poMethod[1],true);
		showObject(form.poTotal,true);
		showObject(form.poUnit,true);
		showObject(form.poMin,true);
		showObject(form.poMax,true);
		showObject(form.poMaxunlimit,true);
		showObject(form.popayM,true);
		showMethod();	//적립금 발급 방식
		showPomax();	//적립금 최대 사용금액 한도, 무제한 여부
	}
	else
	{
		//비활설화
		showObject(form.poReg,false);
		showObject(form.poMethod[0],false);
		showObject(form.poMethod[1],false);
		showObject(form.poTotal,false);
		showObject(form.poUnit,false);
		showObject(form.poMin,false);
		showObject(form.poMax,false);
		showObject(form.poMaxunlimit,false);
		showObject(form.popayM,false);
	}
}

//제품구매시 적립금 발급 방식 disabled 토글 함수  변수 : poMethod, poTotal, poUnit
function showMethod()
{
	var form=document.adm_accountForm;
	if(form.poMethod[0].checked)
	{
		//일괄처리
		showObject(form.poTotal,true);
		showObject(form.poUnit,false);
	}
	else
	{
		//제품단위
		showObject(form.poTotal,false);
		showObject(form.poUnit,true);
	}
}

//적립금 최대 사용금액 한도, 무제한 여부
function showPomax()
{
	var form=document.adm_accountForm;
	if(form.poMaxunlimit.checked) showObject(form.poMax,false);
	else showObject(form.poMax,true);
}

//폼 전송
function accountSendit()
{
	//str_bBank str_bankName str_bankId str_bankOwn
	var form=document.adm_accountForm;
	var str_bBank		="";	//해당은행 사용여부
	var str_bankName	="";	//해당은행 명
	var str_bankId		="";	//해당은행 계좌번호
	var str_bankOwn		="";	//해당은행 예금주

	// hidden value 설정
	for(i=0;i<form.bBank.length;i++)
	{
		//각은행 사용여부,은행명,계좌번호,예금주 문자열
		if(form.bBank[i].checked)		//ex) 1|0|1|0|0|
			str_bBank+="1|";
		else
			str_bBank+="0|";
		str_bankName	+=form.bankName[i].value	+"|";	//ex) 국민은행||우리은행|||
		str_bankId		+=form.bankId[i].value	+"|";		//ex) 12341|123-1-1|1345|||
		str_bankOwn		+=form.bankOwn[i].value	+"|";		//ex) 홍길동|김길동|tom|||
	}
	form.str_bBank.value	=str_bBank;
	form.str_bankName.value	=str_bankName;
	form.str_bankId.value	=str_bankId;
	form.str_bankOwn.value	=str_bankOwn;
	/******* disabled 된 변수 재설정  : disabled 변수는 isset()에서 'false' return  *******/
	form.str_poReg.value		=form.poReg.value;
	if(form.poMethod[0].checked) form.str_poMethod.value = "t";
	else form.str_poMethod.value = "b";
	form.str_poTotal.value		=form.poTotal.value;
	form.str_poUnit.value		=form.poUnit.value;
	form.str_poMin.value		=form.poMin.value;
	form.str_poMax.value		=form.poMax.value;
	if(form.poMaxunlimit.checked) form.str_poMaxunlimit.value	="1";
	else form.str_poMaxunlimit.value	="0";

	if((form.pgName.value == "none") && (form.bBankpay.value == 0))
	{
		alert("결제 방법은 하나이상 선택하셔야 합니다.");
		form.bBankpay.value = 1;
		form.bBank[0].checked = true;
		enable_bank();
	}
	else if((form.bCardpay.value + form.bIchepay.value + form.bHpppay.value + form.bCyberpay.value + form.bBankpay.value) <= 0)
	{
		alert("결제 방법은 하나이상 선택하셔야 합니다.");
		form.bBankpay.value = 1;
		form.bBank[0].checked = true;
		enable_bank();
	}
	else
	{
		form.submit();	//폼전송
	}
}

function point_update()
{
	var form=document.adm_accountForm;
	if (form.poMethod[0].checked) 
	{
		location.href="adm_account.php?method=all&p="+form.poTotal.value;
	}
	else if(form.poMethod[1].checked) 
	{
		location.href="adm_account.php?method=goods&p="+form.poUnit.value;
	}
}
//-->
</SCRIPT>
<body bgcolor="#FFFFFF" text="#5A595A" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onload="javascript:enable_epay();enable_bank();showPoint();">
<? include "top_menu.php"; ?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr><?
	$__TOP_MENU = "basic";     //왼쪽 소메뉴 설정 변수
	include "left_menu.php";
	if(!defined(__ADMIN_ROW))
	{
		define(__ADMIN_ROW,"TRUE");
		$admin_row=$MySQL->fetch_array("select * from admin limit 0,1"); //관리자 정보 배열
	}
	$bBank		=explode("|",$admin_row[bBank]);		//은행사용여부 배열
	$bankName	=explode("|",$admin_row[bankName]);		//은행명 배열
	$bankId		=explode("|",$admin_row[bankId]);		//계좌번호 배열
	$bankOwn	=explode("|",$admin_row[bankOwn]);		//예금주 배열
	?>
		<td width="85%" valign="top">
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td height='5'></td>
				</tr>
				<tr>
					<td align="center">
						<table width="750" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td rowspan="3" width="200"><img src="image/account_tit_.gif"></td>
								<td>&nbsp;</td>
							</tr>
							<tr>
								<td bgcolor="#E6E6E6" height='26'><div align='right'><font class='text1'>SHOP 기본정보를 수정하실수 있습니다.&nbsp;</font></div></td>
							</tr>
							<tr>
								<td>&nbsp;</td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td align="center">
						<table width="750" border="0" cellspacing="0" cellpadding="0">
						<form name="adm_accountForm" method="post" action="adm_account_ok.php" enctype="multipart/form-data" >
						<input type="hidden" name="str_bBank"><!-- bBank 문자열 ex) 1|0|1|0|0| -->
						<input type="hidden" name="str_bankName"><!-- bankName 문자열 ex) 국민은행||우리은행|||  -->
						<input type="hidden" name="str_bankId"><!-- bankId 문자열 ex) 12341|123-1-1|1345||| -->
						<input type="hidden" name="str_bankOwn"><!-- bankOwn 문자열 ex) 홍길동|김길동|tom||| -->
						<!-- 이하 disabled 변수값 재설정 -->
						<input type="hidden" name="str_poReg">
						<input type="hidden" name="str_poMethod">
						<input type="hidden" name="str_poTotal">
						<input type="hidden" name="str_poUnit">
						<input type="hidden" name="str_poMin">
						<input type="hidden" name="str_poMax">
						<input type="hidden" name="str_poMaxunlimit">
						<input type="hidden" name="str_noTrans">
						<input type="hidden" name="str_transCom">
						<input type="hidden" name="str_transMoney">
						<!-- 이상 disabled 변수값 재설정 -->
							<tr>
								<td>
									<table width="750" border="0" cellspacing="0" cellpadding="0">
										<tr>
											<td height='1' bgcolor='DADADA'></td>
										</tr>
										<tr>
											<td><img src="image/account_min_tit.gif"></td>
										</tr>
										<tr>
											<td height='1' bgcolor='DADADA'></td>
										</tr>
									</table>
								</td>
							</tr>
							<tr>
								<td height="4"></td>
							</tr>
							<tr>
								<td>
									<table width="750" border="0" cellspacing="0" cellpadding="0">
										<tr>
											<td width="150" height="30" bgcolor="#FAFAFA">&nbsp;&nbsp;<img src="image/icon.gif" width="11" height="11"> PG 업체 선택</td>
											<td><select name="pgName" size="1" onchange="enable_epay();"><option value="none"<?if($admin_row[pgName]=="") echo " selected";?>>::: 지불대행사 선택 :::</option>
												<option value="dacom"<?if($admin_row[pgName]=="dacom") echo " selected";?>>데이콤</option>
												<option value="allat"<?if($admin_row[pgName]=="allat") echo " selected";?>>올앳</option>
												<option value="inicis"<?if($admin_row[pgName]=="inicis") echo " selected";?>>이니시스</option></select>&nbsp;&nbsp;<a href="http://webprogram.co.kr/faq_view.php?seq=10499&return_url=L2ZhcV9saXN0LnBocD9tYW5hZ2VyX3NlcT02" target="_blank"><img src='image/btn_pg.gif' border='0'></a><p>
												<table width="600" border="0" cellspacing="1" cellpadding="5" bgcolor='#898989'>
													<tr>
														<td width="150" bgcolor="#DEDEDE"><input type="radio" name="pG_test" value="y" onclick="check_Tmode();"<?if($admin_row[pG_test]=='y') echo " checked";?>>테스트만 원하는 경우</td>
														<td width="450" bgcolor="#FFFFFF">1.선택한 PG업체의 결제 모듈을 테스트할 수 있는 계정만 제공합니다.<br>2.테스트 모듈을 이용해 결제된 정보는 카드사로 제공되지 않습니다.<br>&nbsp;&nbsp;(단, <font color="#FF0000">계좌이체의 경우</font>에는 실제입금이 이루어질 수 있으므로 <font color="#FF0000">주의</font> 바랍니다.)</td>
													</tr>
													<tr>
														<td bgcolor="#DEDEDE"><input type="radio" name="pG_test" value="n" onclick="check_Tmode();"<?if($admin_row[pG_test]=='n') echo " checked";?>>PG 업체로 연동을<br>&nbsp;&nbsp;&nbsp;&nbsp;원하는 경우</td>
														<td width="450" bgcolor="#FFFFFF">1.선택한 PG업체의 결제 모듈을 사용할 수 있도록 연동합니다.<br>2.실제로 쇼핑몰 운영을 위한 PG업체의 결제 모듈을 연동하려면<br>&nbsp;&nbsp;1)PG사 계약 <a href="http://webprogram.co.kr/faq_view.php?seq=10499&return_url=L2ZhcV9saXN0LnBocD9tYW5hZ2VyX3NlcT02" target="_blank"><img src='image/btn_pg.gif' border='0'></a><br>&nbsp;&nbsp;2)PG사 승인 (연동관련 정보 통보)<br>&nbsp;&nbsp;3)PG사 등록정보와 동일하게 상점아이디와 결제방법 입력<br>&nbsp;&nbsp;&nbsp;&nbsp;<a href="http://webprogram.co.kr/service.php" target="_blank"><img src='image/btn_service2.gif' border='0'></a><br>&nbsp;&nbsp;4)카드사 심사(약 7일 소요 : PG사로 문의)</td>
													</tr>
												</table><br><font class="help">※ 정상적인 결제모듈 연동을 위해 <font color="#FF0000">반드시 전자지불연동 서비스 신청</font>을 해주시기 바랍니다.</font>&nbsp;<a href="http://webprogram.co.kr/service.php" target="_blank"><img src='image/btn_service.gif' border='0'></a><p><font class="help">※ 다음표에 정해진 서비스는 <b>모듈이 기본탑재</b> 되어 있습니다. 기술지원 필요시에는 <b>유료지원</b> 가능합니다.</font><br>
												<table width="600" border="0" cellspacing="1" cellpadding="0" bgcolor='#898989'>
													<tr align="center">
														<td height="25" bgcolor="#DEDEDE"></td>
														<td width="100" bgcolor="#DEDEDE">데이콤</td>
														<td width="100" bgcolor="#DEDEDE">올앳</td>
														<td width="100" bgcolor="#DEDEDE">이니시스</td>
														<td width="100" bgcolor="#DEDEDE">기타PG사</td>
													</tr>
													<tr bgcolor="#FFFFFF" align="center">
														<td height="25" bgcolor="#DEDEDE">카드결제</td>
														<td>기본탑재</td>
														<td>기본탑재</td>
														<td>기본탑재</td>
														<td><font color="#FF0000">별도견적</font></td>
													</tr>
													<tr bgcolor="#FFFFFF" align="center">
														<td height="25" bgcolor="#DEDEDE">핸 드 폰</td>
														<td>기본탑재</td>
														<td><font class="help">제공안함</font></td>
														<td>기본탑재</td>
														<td><font color="#FF0000">별도견적</font></td>
													</tr>
													<tr bgcolor="#FFFFFF" align="center">
														<td height="25" bgcolor="#DEDEDE">계좌이체</td>
														<td>기본탑재</td>
														<td>기본탑재</td>
														<td>기본탑재</td>
														<td><font color="#FF0000">별도견적</font></td>
													</tr>
													<tr bgcolor="#FFFFFF" align="center">
														<td height="25" bgcolor="#DEDEDE">가상계좌</td>
														<td>기본탑재</td>
														<td>기본탑재</td>
														<td>기본탑재</td>
														<td><font color="#FF0000">별도견적</font></td>
													</tr>
													<tr bgcolor="#FFFFFF" align="center">
														<td height="25" bgcolor="#DEDEDE">에스크로</td>
														<td><font color="#FF0000">유료지원</font></td>
														<td><font color="#FF0000">유료지원</font></td>
														<td><font color="#FF0000">유료지원</font></td>
														<td><font color="#FF0000">별도견적</font></td>
													</tr>
													<tr bgcolor="#FFFFFF" align="center">
														<td height="25" bgcolor="#DEDEDE">현금영수증</td>
														<td><font color="#FF0000">유료지원</font></td>
														<td><font color="#FF0000">유료지원</font></td>
														<td><font color="#FF0000">유료지원</font></td>
														<td><font color="#FF0000">별도견적</font></td>
													</tr>
												</table>
												<p><font class="help">※ <b>에스크로, 현금영수증</b> 및 <b>가상계좌 입금통보 수신모듈 연동</b>은 기본탑재 되어있지 않은 항목입니다.</font><p>
											</td>
										</tr>
									</table>
								</td>
							</tr>
							<tr>
								<td height="1" background="image/line_bg1.gif"></td>
							</tr>
							<tr>
								<td>
									<table width="750" border="0" cellspacing="0" cellpadding="0">
										<tr>
											<td width="150" height="25" bgcolor="#FAFAFA">&nbsp;&nbsp;<img src="image/icon.gif" width="11" height="11"> 상점 아이디</td>
											<td> <input class="box"type="text" name="shopId" size="20" value="<?=$admin_row[shopId]?>"></td>
										</tr>
									</table>
								</td>
							</tr>
							<tr>
								<td height="1" background="image/line_bg1.gif"></td>
							</tr>
							<tr>
								<td>
									<table width="750" border="0" cellspacing="0" cellpadding="0">
										<tr valign="middle">
											<td width="150" height="25" bgcolor="#FAFAFA">&nbsp;&nbsp;<img src="image/icon.gif" width="11" height="11"> 결제방법</td>
										</tr>
										<tr>
											<td height="1" background="image/line_bg1.gif"></td>
										</tr>
										<tr>
											<td height="5"></td>
										</tr>
									</table>
									<table width="750" border="0" cellspacing="1" cellpadding="0" bgcolor='#898989'>
										<tr align="center">
											<td width="150" height="25" bgcolor="#DEDEDE">결제방법</td>
											<td bgcolor="#DEDEDE">카드결제</td>
											<td bgcolor="#DEDEDE">핸드폰결제</td>
											<td bgcolor="#DEDEDE">계좌이체</td>
											<td bgcolor="#DEDEDE">가상계좌(PG사 무통장)</td>
										</tr>
										<tr align="center" bgcolor="#FFFFFF">
											<td height="25">사용여부</td>
											<td><select name="bCardpay" onchange="enable_pg_rate('pg_rate', this.value);"><option value="1" style="background-color:#4081b9;color:#FFFFFF;"<?if($admin_row[bCardpay] == 1) echo " selected";?>>사용함</option><option value="0" style="background-color:#CBC7C0;"<?if($admin_row[bCardpay] == 0) echo " selected";?>>사용안함</option></select></td>
											<td><select name="bHpppay" onchange="enable_pg_rate('pg_rate_hand', this.value);"><option value="1" style="background-color:#4081b9;color:#FFFFFF;"<?if($admin_row[bHpppay] == 1) echo " selected";?>>사용함</option><option value="0" style="background-color:#CBC7C0;"<?if($admin_row[bHpppay] == 0) echo " selected";?>>사용안함</option></select></td>
											<td><select name="bIchepay" onchange="enable_pg_rate('pg_rate_iche', this.value);"><option value="1" style="background-color:#4081b9;color:#FFFFFF;"<?if($admin_row[bIchepay] == 1) echo " selected";?>>사용함</option><option value="0" style="background-color:#CBC7C0;"<?if($admin_row[bIchepay] == 0) echo " selected";?>>사용안함</option></select></td>
											<td><select name="bCyberpay" onchange="enable_pg_rate('pg_rate_cyber', this.value);"><option value="1" style="background-color:#4081b9;color:#FFFFFF;"<?if($admin_row[bCyberpay] == 1) echo " selected";?>>사용함</option><option value="0" style="background-color:#CBC7C0;"<?if($admin_row[bCyberpay] == 0) echo " selected";?>>사용안함</option></select></td>
										</tr>
										<tr align="center" bgcolor="#FFFFFF">
											<td height="25" rowspan="2">PG사 수수료</td>
											<td><input class="box"type="text" name="pg_rate" size="4" style="text-align:right;" value="<?=$admin_row[pg_rate]?>"> %</td>
											<td><input class="box"type="text" name="pg_rate_hand" size="4" style="text-align:right;" value="<?=$admin_row[pg_rate_hand]?>"> %</td>
											<td><input class="box"type="text" name="pg_rate_iche" size="4" style="text-align:right;" value="<?=$admin_row[pg_rate_iche]?>"> %</td>
											<td><input class="box"type="text" name="pg_rate_cyber" size="4" style="text-align:right;" value="<?=$admin_row[pg_rate_cyber]?>"> %</td>
										</tr>
									</table>
								</td>
							</tr>
							<tr>
								<td height="40"><font class="help">※ 본 정보는 <b>정산관리 ,상품 엑셀다운받기</b> 및 <b>결제주문 발송자료</b>에서 계산되어집니다.<br>&nbsp;&nbsp;신용카드 ~ 가상계좌 수수료는 <b>전자지불대행(PG)사와 계약시</b>에만 입력합니다.</font></td>
							</tr>
							<tr>
								<td height="15"></td>
							</tr>
							<tr>
								<td>
									<table width="750" border="0" cellspacing="0" cellpadding="0">
										<tr>
											<td height='1' bgcolor='DADADA'></td>
										</tr>
										<tr>
											<td><img src="image/account_min_tit1.gif"></td>
										</tr>
										<tr>
											<td height='1' bgcolor='DADADA'></td>
										</tr>
									</table>
								</td>
							</tr>
							<tr>
								<td height="4"></td>
							</tr>
							<tr>
								<td>
									<table width="750" border="0" cellspacing="0" cellpadding="0">
										<tr>
											<td width="150" height="25" bgcolor="#FAFAFA">&nbsp;&nbsp;<img src="image/icon.gif" width="11" height="11"> 에스크로 아이디</td>
											<td><input class="box"type="text" name="shop_Escrow_Id" size="20" value="<?=$admin_row[shop_Escrow_Id]?>">&nbsp;<font class="help">※ <b>이니시스 에스크로 연동시</b>에만 입력하는 항목 입니다. </font></td>
										</tr>
										<tr>
											<td colspan="2" height="1" background="image/line_bg1.gif"></td>
										</tr>
										<tr>
											<td height="25" bgcolor="#FAFAFA">&nbsp;&nbsp;<img src="image/icon.gif" width="11" height="11"> 상점 보안키</td>
											<td><input class="box"type="text" name="shop_pg_mertkey" size="35" value="<?=$admin_row[shop_pg_mertkey]?>">&nbsp;<font class="help">※ 대상 : 데이콤, 올앳</font></td>
										</tr>
										<tr>
											<td colspan="2" height="1" background="image/line_bg1.gif"></td>
										</tr>
										<tr>
											<td height="25" bgcolor="#FAFAFA">&nbsp;&nbsp;<img src="image/icon.gif" width="11" height="11"> Open SSL</td>
											<td><select name="shop_pg_encryption" size="1"><option value="y"<?if($admin_row[shop_pg_encryption]=="y") echo " selected";?>>사용함</option><option value="n"<?if($admin_row[shop_pg_encryption]=="n") echo " selected";?>>사용안함</option></select>&nbsp;<font class="help">※ 대상 : 올앳 (<a style="cursor:pointer;" onclick="javascript:window.open('../AllplanPG/allat/ssltest.php');"><font class="help"><b>Open SSL 지원가능여부 확인하기</b></font></a>)</font></td>
										</tr>
										<tr>
											<td colspan="2" height="1" background="image/line_bg1.gif"></td>
										</tr>
									</table>
								</td>
							</tr>
							<tr>
								<td height="15"></td>
							</tr>
							<tr>
								<td>
									<table width="750" border="0" cellspacing="0" cellpadding="0">
										<tr>
											<td height='1' bgcolor='DADADA'></td>
										</tr>
										<tr>
											<td><img src="image/account_min_tit2.gif"></td>
										</tr>
										<tr>
											<td height='1' bgcolor='DADADA'></td>
										</tr>
									</table>
								</td>
							</tr>
							<tr>
								<td height="4"></td>
							</tr>
							<tr valign="middle">
								<td>
									<table width="750" border="0" cellspacing="0" cellpadding="0">
										<tr>
											<td width="150" height="25" bgcolor="#FAFAFA">&nbsp;&nbsp;<img src="image/icon.gif" width="11" height="11"> 상점 자체 무통장</td>
											<td><select name="bBankpay" onchange="enable_bank();"><option value="1" style="background-color:#4081b9;color:#FFFFFF;"<?if($admin_row[bBankpay] == 1) echo" selected";?>>사용함</option><option value="0" style="background-color:#CBC7C0;"<?if($admin_row[bBankpay] == 0) echo" selected";?>>사용안함</option></select></td>
										</tr>
									</table>
								</td>
							</tr>
							<tr>
								<td height="1" background="image/line_bg1.gif"></td>
							</tr>
							<tr>
								<td height="25">
									<table width="750" border="0" cellspacing="0" cellpadding="0"><?
									for($i=0;$i<10;$i++)
									{
										if($bBank[$i])	$bBank_chek =" checked";
										else			$bBank_chek ="";
										?>
										<tr id="bankTr_<?=$i?>">
											<td height='25'width="74" align="center">&nbsp;<input type="checkbox" name="bBank" onclick="javascript:showBank();"<?=$bBank_chek?>></td>
											<td width="53"><div align="center"><img src="image/icon.gif" width="11" height="11">은행명</div></td>
											<td width="77"><input class="box"name="bankName" type="text" id="bankName" size="10" value="<?=$bankName[$i]?>"></td>
											<td width="70"><div align="center"><img src="image/icon.gif" width="11" height="11">계좌번호</div></td>
											<td width="152"><input class="box"name="bankId" type="text" id="bankId" size="19" value="<?=$bankId[$i]?>"> </td>
											<td width="59"><div align="center"><img src="image/icon.gif" width="11" height="11">예금주</div></td>
											<td width="65"><input class="box"name="bankOwn" type="text" id="bankOwn" size="8" value="<?=$bankOwn[$i]?>"> </td>
										</tr><?
									}
									?>
									</table>
								</td>
							</tr>
							<tr>
								<td height="1" background="image/line_bg1.gif"></td>
							</tr>
							<tr>
								<td height="15"></td>
							</tr>
							<tr>
								<td>
									<table width="750" border="0" cellspacing="0" cellpadding="0">
										<tr>
											<td height='1' bgcolor='DADADA'></td>
										</tr>
										<tr>
											<td><img src="image/account_min_tit3.gif"></td>
										</tr>
										<tr>
											<td height='1' bgcolor='DADADA'></td>
										</tr>
									</table>
								</td>
							</tr>
							<tr>
								<td height="4"></td>
							</tr>
							<tr>
								<td>
									<table width="750" border="0" cellspacing="0" cellpadding="0">
										<tr>
											<td width="150" height="25" bgcolor="#FAFAFA">&nbsp;&nbsp;<img src="image/icon.gif" width="11" height="11"> 적립금 사용 </td>
											<td width="10"> <div align="center"> <input class="radio" type="radio" value="1" name="bUsepoint" onclick="javascript:showPoint();"<?if($admin_row[bUsepoint]) echo " checked";?>></div></td>
											<td> <div align="left">사용함</div></td>
											<td width="10"> <div align="center"> <input class="radio"type="radio" value="0" name="bUsepoint" onclick="javascript:showPoint();"<?if(!$admin_row[bUsepoint]) echo " checked";?>></div></td>
											<td> <div align="left">사용하지 않음</div></td>
										</tr>
									</table>
								</td>
							</tr>
							<tr>
								<td height="1" background="image/line_bg1.gif"></td>
							</tr>
							<tr>
								<td>
									<table width="750" border="0" cellspacing="0" cellpadding="0">
										<tr>
											<td width="150" height="25" bgcolor="#FAFAFA">&nbsp;&nbsp;<img src="image/icon.gif" width="11" height="11"> 회원가입시 (원)</td>
											<td><input class="box"type="text" name="poReg" size="10" <?=__ONLY_NUM?> style="text-align:right;" value="<?=$admin_row[poReg]?>"> </td>
										</tr>
									</table>
								</td>
							</tr>
							<tr>
								<td height="1" background="image/line_bg1.gif"></td>
							</tr>
							<tr>
								<td>
									<table width="750" border="0" cellspacing="0" cellpadding="0">
										<tr>
											<td width="150" height="25" bgcolor="#FAFAFA">&nbsp;&nbsp;<img src="image/icon.gif" width="11" height="11"> 제품 등록시<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;구매적립금 설정</td>
											<td valign="middle">
												<table width="600" border="0" cellspacing="0" cellpadding="0">
													<tr valign="middle">
														<td width="120"><input class="radio"type="radio" value="t" name="poMethod" onclick="javascript:showMethod();"<?if($admin_row[poMethod]=="t") echo " checked";?>>&nbsp;&nbsp; 일괄처리 (원)</td>
														<td width="120"><input class="box"type="text" name="poTotal" size="10" <?=__ONLY_NUM?> style="text-align:right;" value="<?=$admin_row[poTotal]?>"> </td>
														<td width="360" rowspan="2" valign=middle><a href="javascript:point_update();"><img src="image/point_update.gif" border=0></a></td>
													</tr>
													<tr valign="middle">
														<td><input class="radio"type="radio" value="b" name="poMethod" onclick="javascript:showMethod();"<?if($admin_row[poMethod]=="b") echo " checked";?>>&nbsp;&nbsp; 제품단위 (%) </div></td>
														<td><input class="box"type="text" name="poUnit" size="5" style="text-align:right;" value="<?=$admin_row[poUnit]?>"> </td>
													</tr>
													<tr>
														<td colspan="3" height=40 valign=middle><font class="help">※ 설정값을 바꾼후 <b>[조정하기]버튼클릭시</b> 현재 등록되어있는 상품에 현재설정대로 <b>일괄수정</b>됩니다.<br>※ 설정값만 바꾸고 저장을 하면 <b>앞으로 등록되는 상품</b>부터만 바뀐 설정값이 적용됩니다.<br>※ 회원 등급이 있다면 <b>회원등급관리</b>에서 적립금을 설정합니다. </font></td>
													</tr>
												</table>
											</td>
										</tr>
									</table>
								</td>
							</tr>
							<tr>
								<td height="1" background="image/line_bg1.gif"></td>
							</tr>
							<tr>
								<td>
									<table width="750" border="0" cellspacing="0" cellpadding="0">
										<tr>
											<td width="250" height="25" bgcolor="#FAFAFA">&nbsp;&nbsp;<img src="image/icon.gif" width="11" height="11"> 제품구매후기 작성시</td>
											<td width="500"> &nbsp;&nbsp; <input class="box"type="text" name="write_goodsP" size="10" <?=__ONLY_NUM?> style="text-align:right;" value="<?=$admin_row[write_goodsP]?>"> 원 지급 &nbsp;<font class="help">※ 고객이 수취완료 처리를 하면서 제품구매후기를 기재할때</font></td>
										</tr>
										<tr>
											<td colspan="2" height="1" background="image/line_bg1.gif"></td>
										</tr>
										<tr>
											<td height="35" bgcolor="#FAFAFA">&nbsp;&nbsp;<img src="image/icon.gif" width="11" height="11"> 적립금 사용가능한 구매금액 (원)</td>
											<td> &nbsp;&nbsp; 결제금액이 <input class="box"type="text" name="popayM" size="9" <?=__ONLY_NUM?> style="text-align:right;" value="<?=$admin_row[popayM]?>"> 원 이상부터 적립금 사용가능 </td>
										</tr>
										<tr>
											<td colspan="2" height="1" background="image/line_bg1.gif"></td>
										</tr>
										<tr>
											<td height="25" bgcolor="#FAFAFA">&nbsp;&nbsp;<img src="image/icon.gif" width="11" height="11"> 적립금 최소 사용가능 금액 (원)</td>
											<td> &nbsp;&nbsp; <input class="box"type="text" name="poMin" size="20" <?=__ONLY_NUM?> style="text-align:right;" value="<?=$admin_row[poMin]?>"> </td>
										</tr>
										<tr>
											<td colspan="2" height="1" background="image/line_bg1.gif"></td>
										</tr>
										<tr>
											<td height="35" bgcolor="#FAFAFA">&nbsp;&nbsp;<img src="image/icon.gif" width="11" height="11"> 적립금 최대 사용가능 금액 (원)</td>
											<td> &nbsp;&nbsp; <input class="box"type="text" name="poMax" size="20" <?=__ONLY_NUM?> style="text-align:right;" value="<?=$admin_row[poMax]?>"> &nbsp;&nbsp;<input class="radio"type="checkbox" value="1" name="poMaxunlimit" onclick="javascript:showPomax();"<?if($admin_row[poMaxunlimit]) echo " checked";?>> 무제한</td>
										</tr>
										<tr>
											<td colspan="2" height="1" background="image/line_bg1.gif"></td>
										</tr>
									</table>
								</td>
							</tr>
							<tr>
								<td height="8"></td>
							</tr>
							<tr>
								<td height="40" valign="middle">
									<table width="50%" border="0" align="center" cellpadding="0" cellspacing="0">
										<tr>
											<td><div align="center"><a href="javascript:accountSendit();"><img src="image/save_btn.gif" width="40" height="17" border="0"></a></div></td>
											<td><div align="center"><a href="javascript:formClear(document.adm_accountForm);"><img src="image/cancel_btn.gif" width="40" height="17" border="0"></a></div></td>
										</tr>
									</table>
								</td>
							</tr></form><!-- adm_accountForm -->
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