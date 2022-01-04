<?
include "head.php";
if(empty($_SESSION[GOOD_SHOP_USERID]))
{
	OnlyMsgView("회원메뉴입니다. 로그인 해주세요");
	ReFresh("login.php");
	exit;
}
$member_row   = $MySQL->fetch_array("select *from member where userid='$_SESSION[GOOD_SHOP_USERID]'");//회원정보
$ssh		= explode("-",$member_row[ssh]);	//주민등록번호
$tel		= explode("-",$member_row[tel]);	//연락처
$hand		= explode("-",$member_row[hand]);	//휴대전화
$zip		= explode("-",$member_row[zip]);	//우편번호
$ceo_zip	= explode("-",$member_row[ceo_zip]);
$birth		= explode("-",$member_row[birth]);
$birth2		= explode("-",$member_row[birth2]);
if($member_row[bMail])
{
	$true_bMail	= "checked";
	$false_bMail = "";
}
else
{
	$true_bMail	= "";
	$false_bMail = "checked";
}
if($member_row[bSms]=="y")
{
	$true_bSms	= "checked";
	$false_bSms = "";
}
else
{
	$true_bSms	= "";
	$false_bSms = "checked";
}
$__SURELY_ICON	= "<img src='image/member/star.gif' width='7' height'7' align='absmiddle'>";		//필수항목 아이콘
$showArr = explode("|",$design_goods[memberJoinShow]);			//표시
$sureArr = explode("|",$design_goods[memberJoinSure]);			//필수
for($i=0;$i<count($sureArr);$i++)
{
	//필수항목 아이콘 표시
	$sureArr[$i] ? $sureIcon[$i] = $__SURELY_ICON : $sureIcon[$i] = "";
}
?>
<SCRIPT LANGUAGE="JavaScript">
<!--
//우편번호 찾기
function searchZip()
{
	window.open("search_post.php","","scrollbars=yes,width=480,height=200,left=250,top=250");
}

function searchZip_ceo()
{
	window.open("search_post_ceo.php?form=joinForm","","scrollbars=yes,width=490,height=200,left=250,top=250");
}

//정보전송
function joinSendit()
{
	<?if(__DEMOPAGE){?>
	alert("데모사이트 에서는 정보를 수정하실 수 없습니다.");
	<?}else{?>
	var form=document.joinForm;

	if(form.pwd1.value =="")
	{
		alert("비밀번호를 입력해 주십시오.");
		form.pwd1.focus();
	}
	else if(form.pwd2.value =="")
	{
		alert("비밀번호 확인을 입력해 주십시오.");
		form.pwd2.focus();
	}
	else if(form.pwd1.value !=form.pwd2.value)
	{
		alert("비밀번호가 올바르지 않습니다.");
		form.pwd1.focus();
	}
		<?if($showArr[4] && $sureArr[4]){?>
	else if(form.email.value=="")
	{
		alert("이메일을 입력해 주십시오.");
		form.email.focus();
	}
	else if(! isEmail(form.email.value))
	{
		alert("이메일이 올바르지 않습니다.");
		form.email.focus();
	}
		<?}?>
		<?if($showArr[6] && $sureArr[6]){?>
	else if(!telCheck(form.tel1.value,form.tel2.value,form.tel3.value))
	{
		alert("연락처가 올바르지 않습니다.");
		form.tel1.focus();
	}
		<?}?>
		<?if($showArr[7] && $sureArr[7]){?>
	else if(!telCheck(form.hand1.value,form.hand2.value,form.hand3.value))
	{
		alert("휴대전화가 올바르지 않습니다.");
		form.hand1.focus();
	}
		<?}?>
		<?if($showArr[8] && $sureArr[8]){?>
	else if(form.zip1.value=="")
	{
		alert("주소를 입력해 주십시오.");
		searchZip();
	}
	else if(form.address2.value=="")
	{
		alert("상세주소를 입력해 주십시오.");
		form.address2.focus();
	}
		<?}?>
	else
	{
		form.submit();
	}
	<?}?>
}

//회원탈퇴
function memberDel()
{
	<?if(__DEMOPAGE){?>
	alert("데모사이트 에서는 정보를 수정하실 수 없습니다.");
	<?}else{?>
	var choose = confirm("회원정보가 영구 삭제됩니다.\n\n탈퇴 하시겠습니까?");
	if(choose)
	{
		location.href="mypage_member_ok.php?memberdel=1";
	}
	else return;
	<?}?>
}
//-->
</SCRIPT>
<? include "top.php";?>
<table width="900" border="0" cellspacing="1" cellpadding="0" bgcolor="<?=$ALL_BGCOLOR?>">
	<tr>
		<? include "left_menu.php";?>
		<td valign="top" width="720" bgcolor="#FFFFFF">
			<table width="720" height="100%" border="0" cellspacing="0" cellpadding="0">
				<tr bgcolor="#FFFFFF" valign="top">
					<td colspan="2">
						<table width="720" height="30" border="0" cellspacing="0" cellpadding="0" align='center'>
							<tr>
								<td width="2"  bgcolor="<?=$subdesign[bc5]?>" rowspan="2"></td>
								<td width="2"  bgcolor="<?=$subdesign[bc5]?>" rowspan="2"></td>
								<td width="220" height="30" bgcolor="<?=$subdesign[bc5]?>"><img src="./upload/design/<?=$subdesign[img5]?>" ></td>
								<td width="490" height="30" bgcolor="<?=$subdesign[bc5]?>"><div align="right"> &nbsp;<font color="<?=$subdesign[tc5]?>"> <img src='image/good/icon0.gif'>&nbsp;현재위치 : HOME &gt; Mypage(마이페이지)&gt;개인정보변경</font>&nbsp;</td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td valign="top"><br><? include "mypage_menu.php";?><br><br>
						<table border='0' width='660' cellpadding='0' cellspacing='0' align='center'>
							<tr>
								<td><img src='image/member/my_tit1.gif'></td>
							</tr>
						</table>
						<form name="joinForm" method="post" action="mypage_member_ok.php">
						<input type="hidden" name="city" value="<?=$member_row[city]?>"><!-- 회원거주지 -->
						<table width="660" border="0" cellspacing="1" cellpadding="10" valign="top" align='center' bgcolor='dadada'>
							<tr>
								<td bgcolor='ffffff'>
									<table width="630" border="0" cellspacing="1" cellpadding="0" align="center">
										<tr>
											<td height="2" colspan="2" bgcolor="#e1e1e1"></td>
										</tr>
										<tr>
											<td height="30" colspan="2" bgcolor="#F4F4F4"><b>&nbsp;&nbsp;기본 정보</b> <?=$__SURELY_ICON?> 필수항목</td>
										</tr>
										<tr>
											<td height="1" colspan="2" bgcolor="#e1e1e1"></td>
										</tr>
										<tr>
											<td height="25" width="110" bgcolor="#FAFAFA"><img src='image/mem_icon.gif'>  <font class='mem'>회원 아이디</font></td>
											<td height="25" width="480"> <B><FONT COLOR="#6600FF"><?=$member_row[userid]?></FONT></B></td>
										</tr>
										<tr>
											<td height="1" colspan="2" background="image/index/dot_width.gif"></td>
										</tr>
										<tr>
											<td height="25" width="110" bgcolor="#FAFAFA"><img src='image/mem_icon.gif'> <font class='mem'>성명</font></td>
											<td height="25" width="480"><?=$member_row[name]?></td>
										</tr>
										<tr>
											<td height="1" colspan="2" background="image/index/dot_width.gif"></td>
										</tr>
										<tr>
											<td height="25" width="110" bgcolor="#FAFAFA"><img src='image/mem_icon.gif'> <font class='mem'><?= !$member_row[bDeal]?"주민등록 번호":"법인 번호"?></font></td>
											<td height="25" width="480"><?=$ssh[0]?> - *******</td>
										</tr>
										<tr>
											<td height="1" colspan="2" background="image/index/dot_width.gif"></td>
										</tr>
										<tr>
											<td height="25" width="110" bgcolor="#FAFAFA"> <img src='image/mem_icon.gif'> <font class='mem'>비밀번호</font> <?=$__SURELY_ICON?></td>
											<td height="25" width="480"><input class="box1" type="password" name="pwd1" size="15" value=""> &nbsp;&nbsp; ※ 암호화 되어 저장되므로 관리자도 알수 없습니다.</td>
										</tr>
										<tr>
											<td height="1" colspan="2" background="image/index/dot_width.gif"></td>
										</tr>
										<tr>
											<td height="25" width="110" bgcolor="#FAFAFA"> <img src='image/mem_icon.gif'> <font class='mem'>비밀번호 확인</font> <?=$__SURELY_ICON?>&nbsp;</td>
											<td height="25" width="480"><input class="box1" type="password" name="pwd2" size="15" value=""></td>
										</tr>
										<tr>
											<td height="1" colspan="2" background="image/index/dot_width.gif"></td>
										</tr><?
										if($showArr[4])
										{
											?>
										<tr>
											<td height="25" width="110" bgcolor="#FAFAFA"><img src='image/mem_icon.gif'> <font class='mem'>이메일</font> <?=$sureIcon[4]?></td>
											<td height="25" width="480"><input class="box1" type="text" name="email" size="30" value="<?=$member_row[email]?>"></td>
										</tr>
										<tr>
											<td height="1" colspan="2" background="image/index/dot_width.gif"></td>
										</tr><?
										}
										if($showArr[6])
										{
											?>
										<tr>
											<td height="25" width="110" bgcolor="#FAFAFA"><img src='image/mem_icon.gif'> <font class='mem'>전화번호 <?=$sureIcon[6]?></font></td>
											<td height="25" width="480"><input class="box1" type="text" name="tel1" size="3" value="<?=$tel[0]?>" <?=__ONLY_NUM?> maxlength="3"> - <input class="box1" type="text" name="tel2" size="4" value="<?=$tel[1]?>" <?=__ONLY_NUM?> maxlength="4"> - <input class="box1" type="text" name="tel3" size="4" value="<?=$tel[2]?>" <?=__ONLY_NUM?> maxlength="4"></td>
										</tr>
										<tr>
											<td height="1" colspan="2" background="image/index/dot_width.gif"></td>
										</tr><?
										}
										if($showArr[7])
										{
											?>
										<tr>
											<td height="25" width="110" bgcolor="#FAFAFA"><img src='image/mem_icon.gif'> <font class='mem'>휴대폰 번호 <?=$sureIcon[7]?></font></td>
											<td height="25" width="480"><input class="box1" type="text" name="hand1" size="3" value="<?=$hand[0]?>" <?=__ONLY_NUM?> maxlength="3"> - <input class="box1" type="text" name="hand2" size="4" value="<?=$hand[1]?>" <?=__ONLY_NUM?> maxlength="4"> - <input class="box1" type="text" name="hand3" size="4" value="<?=$hand[2]?>" <?=__ONLY_NUM?> maxlength="4"></td>
										</tr>
										<tr>
											<td height="1" colspan="2" background="image/index/dot_width.gif"></td>
										</tr><?
										}
										if($showArr[8])
										{
											?>
										<tr>
											<td height="25" width="110" bgcolor="#FAFAFA"><img src='image/mem_icon.gif'> <font class='mem'>우편번호 <?=$sureIcon[8]?></font></td>
											<td height="25" width="480"><input class="box1" type="text" name="zip1" size="3" value="<?=$zip[0]?>" <?=__ONLY_NUM?> maxlength="3"> - <input class="box1" type="text" name="zip2" size="3" value="<?=$zip[1]?>" <?=__ONLY_NUM?> maxlength="3"> &nbsp;&nbsp; <a href="javascript:searchZip();"><img src="image/icon/post_search.gif" border="0" align="absmiddle"></a></td>
										</tr>
										<tr>
											<td height="1" colspan="2" background="image/index/dot_width.gif"></td>
										</tr>
										<tr>
											<td height="25" width="110" bgcolor="#FAFAFA"><img src='image/mem_icon.gif'> <font class='mem'>주 소 <?=$sureIcon[8]?></font></td>
											<td height="25" width="480"><input class="box1" type="text" name="address1" size="40" value="<?=$member_row[address1]?>"></td>
										</tr>
										<tr>
											<td height="1" colspan="2" background="image/index/dot_width.gif"></td>
										</tr>
										<tr>
											<td height="25" width="110" bgcolor="#FAFAFA"><img src='image/mem_icon.gif'> <font class='mem'>상세주소 <?=$sureIcon[8]?></font></td>
											<td height="25" width="480"><input class="box1" type="text" name="address2" size="40" value="<?=$member_row[address2]?>"></td>
										</tr>
										<tr>
											<td height="1" colspan="2" background="image/index/dot_width.gif"></td>
										</tr><?
										}
										if($showArr[10])
										{
											?>
										<tr>
											<td height="25" width="97" bgcolor="#FAFAFA"><img src='image/mem_icon.gif'> <font class='mem'>&nbsp;메일링 서비스</font></td>
											<td height="25" width="480" bgcolor="#FFFFFF">
												<table width="265" border="0" cellspacing="0" cellpadding="0" align="left">
													<tr>
														<td width="79">&nbsp;&nbsp;&nbsp;신청합니다</td>
														<td width="49"> <input class="radio" type="radio" name="bMail" value="1" <?=$true_bMail?>></td>
														<td width="110">신청하지 않습니다.</td>
														<td width="27"> <input class="radio" type="radio" name="bMail" value="0" <?=$false_bMail?>></td>
													</tr>
												</table>
											</td>
										</tr>
										<tr>
											<td height="1" colspan="2" background="image/index/dot_width.gif"></td>
										</tr><?
										}
										if($showArr[11])
										{
											?>
										<tr>
											<td height="25" width="97" bgcolor="#FAFAFA"><img src='image/mem_icon.gif'> <font class='mem'>&nbsp;SMS 서비스</font></td>
											<td height="25" width="480" bgcolor="#FFFFFF">
												<table width="265" border="0" cellspacing="0" cellpadding="0" align="left">
													<tr>
														<td width="79">&nbsp;&nbsp;&nbsp;신청합니다</td>
														<td width="49"> <input class="radio" type="radio" name="bSms" value="y" <?=$true_bSms?>></td>
														<td width="110">신청하지 않습니다.</td>
														<td width="27"> <input class="radio" type="radio" name="bSms" value="n" <?=$false_bSms?>></td>
													</tr>
												</table>
											</td>
										</tr>
										<tr>
											<td height="1" colspan="2" background="image/index/dot_width.gif"></td>
										</tr><?
										}
										if($showArr[12])
										{
											?>
										<tr>
											<td height="25" width="110" bgcolor="#fafafa"> <img src='image/mem_icon.gif'> <font class='mem'>&nbsp;생년월일 </font></td>
											<td height="25" width="480" bgcolor="#FFFFFF"> <input class="box1" type="text" name="year" size="4" value="<?=$birth[0]?>"> 년 &nbsp;&nbsp; <select name="month" class="box1"><?
											for ($i=1; $i<13; $i++)
											{
												?><option value="<?=$i?>" <? if ($i == $birth[1]) echo "selected";?>><?=$i?></option><?
											}
											?></select> 월&nbsp;&nbsp;<select name="day" class="box1"><?
											for ($i=1; $i<32; $i++)
											{
												?><option value="<?=$i?>" <? if ($i == $birth[2]) echo "selected";?>><?=$i?></option><?
											}
											?></select> 일</td>
										</tr>
										<tr>
											<td colspan="2" height="1" background="image/index/dot_width.gif" bgcolor="#FDFDFD"></td>
										</tr><?
										}
										if($showArr[13])
										{
											?>
										<tr>
											<td height="25" width="110" bgcolor="#fafafa"> <img src='image/mem_icon.gif'> <font class='mem'>&nbsp;결혼기념일</font></td>
											<td height="25" width="480" bgcolor="#FFFFFF"> <input class="box1" type="text" name="year2" size="4" value="<?=$birth2[0]?>"> 년 &nbsp;&nbsp; <select name="month2" class="box1"><?
											for ($i=1; $i<13; $i++)
											{
												?><option value="<?=$i?>" <? if ($i == $birth2[1]) echo "selected";?>><?=$i?></option><?
											}
											?></select> 월&nbsp;&nbsp;<select name="day2" class="box1"><?
											for ($i=1; $i<32; $i++)
											{
												?><option value="<?=$i?>" <? if ($i == $birth2[2]) echo "selected";?>><?=$i?></option><?
											}
											?></select> 일</td>
										</tr>
										<tr>
											<td colspan="2" height="1" background="image/index/dot_width.gif" bgcolor="#FDFDFD"></td>
										</tr><?
										}
										?>
									</table>
								</td>
							</tr>
						</table><br>
						<table width="660" border="0" cellspacing="1" cellpadding="10" valign="top" align='center' bgcolor='dadada'>
							<tr>
								<td bgcolor='ffffff'>
									<table width="630" border="0" cellspacing="1" cellpadding="0" align="center">
										<tr>
											<td height='2' bgcolor='e1e1e1' colspan='2'></td>
										</tr>
										<tr>
											<td height="30" colspan="2" bgcolor="#F4F4F4" style='padding:0 0 0 10'><b>&nbsp;&nbsp;추가입력사항</b></font></td>
										</tr>
										<tr>
											<td height='1' bgcolor='e1e1e1' colspan='2'></td>
										</tr><?
										if ($GOOD_SHOP_PART_GUBUN=="M")
										{
											?>
										<tr>
											<td height="25" width="110" bgcolor="#FAFAFA"><img src='image/mem_icon.gif'><font class='mem'>&nbsp;사업자회원 신청 </font></td>
											<td height="25" width="480" bgcolor="#FFFFFF"> <input type="radio" name="bDeal" value="1" <? if ($member_row[bDeal]) echo "checked";?>>신청합니다. &nbsp;&nbsp;<input type="radio" name="bDeal" <? if ($member_row[bDeal]!=1) echo "checked";?> value="0">신청하지 않습니다.</td>
										</tr>
										<tr>
											<td colspan="2" height="1" background="image/index/dot_width.gif" bgcolor="#FDFDFD"></td>
										</tr><?
										}
										?>
										<tr>
											<td height="25" width="97" bgcolor="#FAFAFA"><img src='image/mem_icon.gif'> <font class='mem'>&nbsp;물품환불계좌 </font></td>
											<td height="25" width="480" bgcolor="#FFFFFF">
												<table width="100%" border="0" cellspacing="0" cellpadding="0" align="left">
													<tr>
														<td width="100%">&nbsp;&nbsp;은행명 <input class="box1" type="text" name="refund_bank" value="<?=stripslashes($member_row[refund_bank])?>" size="10"> &nbsp;&nbsp;예금주 <input class="box1" type="text" name="refund_name" value="<?=stripslashes($member_row[refund_name])?>" size="10"> &nbsp;&nbsp;계좌 <input class="box1" type="text" name="refund_account" value="<?=stripslashes($member_row[refund_account])?>" size="20"></td>
													</tr>
												</table>
											</td>
										</tr>
										<tr>
											<td height="1" colspan="2" background="image/index/dot_width.gif"></td>
										</tr>
									</table>
								</td>
							</tr>
						</table><br>
						<table width="660" border="0" cellspacing="1" cellpadding="10" valign="top" align='center' bgcolor='dadada'>
							<tr>
								<td bgcolor='ffffff'>
									<table width="630" border="0" cellspacing="0" cellpadding="0" valign="top" align='center'>
										<tr>
											<td height='2' bgcolor='e1e1e1' colspan='2'></td>
										</tr>
										<tr>
											<td height="40" colspan="2" bgcolor="#F4F4F4" style='padding:0 0 0 10'><b>&nbsp;&nbsp;사업자 정보</b></td>
										</tr>
										<tr>
											<td height='1' bgcolor='e1e1e1' colspan='2'></td>
										</tr>
										<tr>
											<td colspan="2" valign='top'>
												<table width='100%' border="0" cellspacing="0" cellpadding="0" valign="top" align='center'>
													<tr>
														<td width="121" bgcolor="#FAFAFA" height="25"> <img src='image/mem_icon.gif'> <font class='mem'>상호(법인명)</font></td>
														<td><input type="text" class="box1" name="companyname" size="20" value="<?=$member_row[companyname]?>"></td>
														<td width="121" bgcolor="#FAFAFA"> <img src='image/mem_icon.gif'><img src='image/mem_icon.gif'> <font class='mem'>사업자번호</font></td><?
														$ceonum = explode("-",$member_row[ceonum]);
														?>
														<td><input type="text" class="box1" name="ceonum1" size="3" value="<?=$ceonum[0]?>" maxlength="3"> - <input type="text" class="box1" name="ceonum2" size="2" value="<?=$ceonum[1]?>" maxlength="2"> - <input type="text" class="box1" name="ceonum3" size="5" value="<?=$ceonum[2]?>" maxlength="5"></td>
													</tr>
													<tr>
														<td height="1" colspan="4" background="image/index/dot_width.gif"></td>
													</tr>
													<tr>
														<td width="121" bgcolor="#FAFAFA" height="25"> <img src='image/mem_icon.gif'> <font class='mem'>대표자</font></td>
														<td bgcolor="FFFFFF"><input type="text" class="box1" name="ceoname" size="20" value="<?=$member_row[ceoname]?>"></td>
													</tr>
													<tr>
														<td height="1" colspan="4" background="image/index/dot_width.gif"></td>
													</tr>
													<tr>
														<td width="121" bgcolor="#FAFAFA" height="25"> <img src='image/mem_icon.gif'> <font class='mem'>우편번호 </font></td>
														<td colspan="3"><input type="text" class="box1" name="ceo_zip1" size="3" <?=__ONLY_NUM?> value="<?=$ceo_zip[0]?>"> - <input type="text" class="box1" name="ceo_zip2" size="3" <?=__ONLY_NUM?> value="<?=$ceo_zip[1]?>"> <a href="javascript:searchZip_ceo();"><img src="image/icon/post_search.gif" border='0' align="absmiddle"></a></td>
													</tr>
													<tr>
														<td height="1" colspan="4" background="image/index/dot_width.gif"></td>
													</tr>
													<tr>
														<td width="121" bgcolor="#FAFAFA" height="25"> <img src='image/mem_icon.gif'> <font class='mem'>주소 </font></td>
														<td colspan="3"><input type="text" class="box1" name="ceo_address1" size="55" value="<?=$member_row[ceo_address1]?>"></td>
													</tr>
													<tr>
														<td height="1" colspan="4" background="image/index/dot_width.gif"></td>
													</tr>
													<tr>
														<td width="121" bgcolor="#FAFAFA" height="25"> <img src='image/mem_icon.gif'> <font class='mem'>상세주소 </font></td>
														<td colspan="3"><input type="text" class="box1" name="ceo_address2" size="55" value="<?=$member_row[ceo_address2]?>"></td>
													</tr>
													<tr>
														<td height="1" colspan="4" background="image/index/dot_width.gif"></td>
													</tr>
													<tr>
														<td width="121" bgcolor="#FAFAFA" height="25"> <img src='image/mem_icon.gif'> <font class='mem'>업태</font></td>
														<td><input type="text" class="box1" name="upjongtype" size="20" value="<?=$member_row[upjongtype]?>"></td>
														<td width="121" bgcolor="fafafa"> <img src='image/mem_icon.gif'> <font class='mem'>업종</font></td>
														<td><input type="text" class="box1" name="jongmok" size="20" value="<?=$member_row[jongmok]?>"></td>
													</tr>
													<tr>
														<td height="1" colspan="4" background="image/index/dot_width.gif"></td>
													</tr>
												</table>
											</td>
										</tr>
									</table>
								</td>
							</tr>
						</table>
						<br>
						<table width="250" border="0" cellspacing="2" cellpadding="0" align="center" height='50'>
							<tr align="center">
								<td><a href="javascript:joinSendit();"><img src="image/icon/change_lag.gif" border="0"></a></td>
								<td><a href="javascript:formClear(document.joinForm);"><img src="image/icon/cancel_lag.gif" border="0"></a></td>
								<td><a href="javascript:memberDel();"><img src="image/member/member_out.gif" border="0"></a></td>
							</tr>
						</table>
						</form><!-- joinForm --> 
						<br>
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