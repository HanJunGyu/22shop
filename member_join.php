<?
session_cache_limiter("no-cache, must-revalidate");
include "html_head.php";
if(!defined(__ADMIN_ROW))
{
	define(__ADMIN_ROW,"TRUE");
	$admin_row=$MySQL->fetch_array("select *from admin limit 0,1");
}
$__SURELY_ICON	= "<img src='image/member/star.gif' width='7' height='7' align='absmiddle'>";		//필수항목 아이콘
$showArr = explode("|",$design_goods[memberJoinShow]);			//표시
$sureArr = explode("|",$design_goods[memberJoinSure]);			//필수
for($i=0;$i<count($sureArr);$i++)
{
	//필수항목 아이콘 표시
	$sureArr[$i] ? $sureIcon[$i] = $__SURELY_ICON : $sureIcon[$i] = "";
}
$bDeal=in_array($bDeal,array(0,1))?$bDeal:0;
?>
<SCRIPT LANGUAGE="JavaScript">
<!--
function searchZip()
{
	window.open("search_post.php","","scrollbars=yes,width=490,height=200,left=250,top=250");
}

function searchZip_ceo()
{
	window.open("search_post_ceo.php?form=joinForm","","scrollbars=yes,width=490,height=200,left=250,top=250");
}

function joinSendit()
{
	var form=document.joinForm;
	if(form.userid.value=="")
	{
		alert("아이디를 입력해 주십시오.");
		form.userid.focus();
	}
	else if(checkSpace(form.userid.value) != "")
	{
		alert("아이디에 공백을 포함할수 없습니다.");
		form.userid.focus();
		form.userid.select();
	}
	else if(form.id_check.value =="")
	{
		alert("아이디 중복검색을 해주십시오");
		form.userid.focus();
	}
	else if(form.userid.value!=form.id_check.value)
	{
		alert("중복검색된 아이디를 수정하였습니다. 다시 중복검색을 해주십시오.");
		form.userid.focus();
	}
	else if(form.pwd1.value =="")
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
	else if(form.name.value =="")
	{
		alert("이름을 입력해 주십시오.");
		form.name.focus();
	}
	else if(checkSpace(form.name.value) != "")
	{
		alert("이름에 공백을 포함할수 없습니다.");
		form.name.focus();
		form.name.select();
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
	<?if($sureArr[5] && !$bDeal) {?>
	else if( !bsshChek(form.ssh1.value,form.ssh2.value) )
	{
		alert("주민등록번호가 올바르지 않습니다.");
		form.ssh1.focus();
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
	<?}?>
	<?if($showArr[12] && $sureArr[12]){?>
	else if(form.year.value=="")
	{
		alert("생년월일을 입력해 주십시오.");
		
	}
	<?}?>
	<?if($showArr[13] && $sureArr[13]){?>
	else if(form.year2.value=="")
	{
		alert("결혼기념일을 입력해 주십시오.");
	}
	<?}?>
	else
	{
		form.submit();
	}
}

function idsearch()
{
	var form=document.joinForm;
	if(form.userid.value=="")
	{
		alert("아이디를 입력해 주십시오.");
		form.userid.focus();
	}
	else
	{
		var userid = form.userid.value;
		window.open("idsearch.php?userid="+userid,"","scrollbars=no,width=300,height=150,left=250,top=250")
	}
}
//-->
</SCRIPT>
<? include "top.php";?>
<iframe width=0 height=0 name="ifrm" frameborder='0'></iframe>
<table width="900" border="0" cellspacing="0" cellpadding="0" bgcolor="<?=$ALL_BGCOLOR?>">
	<tr>
		<? include "left_menu.php";?>
		<td valign="top" bgcolor="#FFFFFF">
			<table width="720" height="100%" border="0" cellspacing="0" cellpadding="0">
				<tr bgcolor="#FFFFFF" valign="top">
					<td colspan="2">
						<table width="720" height="27" border="0" cellspacing="0" cellpadding="0" align='center'>
							<tr>
								<td width="2"  bgcolor="<?=$subdesign[bc4]?>" rowspan="2"></td>
								<td width="2"  bgcolor="<?=$subdesign[bc4]?>" rowspan="2"></td>
								<td width="220" height="27" bgcolor="<?=$subdesign[bc4]?>"><img src="./upload/design/<?=$subdesign[img4]?>" ></td>
								<td height="27" bgcolor="<?=$subdesign[bc4]?>"><div align="right"> &nbsp;<font color="<?=$subdesign[tc4]?>"> <img src='image/good/icon0.gif'>&nbsp;현재위치 : HOME &gt; 회원가입</font>&nbsp;</div></td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td width="2" bgcolor="#e6e6e6" valign="top"></td>
					<td valign="top" width="712" valign="top">
						<table width="714" border="0" cellspacing="0" cellpadding="0" valign="top">
							<tr>
								<td><?
								if ($subdesign[titimg3])
								{
									?><img src="./upload/design/<?=$subdesign[titimg4]?>" ><?
								}
								else
								{
									?><img src="image/index/member_article_img1.gif" ><?
								}
								?></td>
							</tr>
						</table><br>
						<form name="joinForm" method="post" action="member_join_ok.php">
						<input type="hidden" name="bDeal" value="<?=$bDeal?>">
						<input type="hidden" name="city"><!-- 회원거주지 -->
						<input type="hidden" name="id_check" value=""><!-- 아이디검색 ex)1:아이디검색  0:회원가입 -->
						<table width="650" border="0" cellspacing="1" cellpadding="0" align="center" bgcolor="#ffffff">
							<tr>
								<td align="center" bgcolor="ffffff" valign="top"><br>
								<!-- 기본정보 시작 -->
									<table width="630" border="0" cellspacing="1" cellpadding="10" valign="top" align='center' bgcolor='dadada'>
										<tr>
											<td bgcolor='ffffff'>
												<table width="600" border="0" cellspacing="1" cellpadding="0" valign="top">
													<tr>
														<td height="1" colspan="2" bgcolor="ffffff"></td>
													</tr>
													<tr>
														<td height="30" colspan="2" bgcolor="#f4f4f4" style="padding:5 5 5 5"><b>&nbsp;&nbsp;기본정보</b>&nbsp;&nbsp;&nbsp;&nbsp; <?=$__SURELY_ICON?> 필수항목</td>
													</tr>
													<tr>
														<td width="110" bgcolor="#fafafa" style="padding:5 5 5 5"><img src='image/mem_icon.gif'><font class='mem'>&nbsp;회원 아이디 <?=$sureIcon[0]?></font></td>
														<td width="480" bgcolor="#FFFFFF" valign="middle" style="padding:5 5 5 5"> <input class="box1" type="text" name="userid" size="15"> <a href="javascript:idsearch();"><img src="image/icon/duplicate.gif" border="0" align='absmiddle'></a></td>
													</tr>
													<tr>
														<td colspan="2" height="1" background="image/index/dot_width.gif" bgcolor="#FDFDFD"></td>
													</tr>
													<tr>
														<td width="110" bgcolor="#fafafa" style="padding:5 5 5 5"><img src='image/mem_icon.gif'><font class='mem'>&nbsp;비밀번호 <?=$sureIcon[1]?></font></td>
														<td width="480" bgcolor="#FFFFFF" style="padding:5 5 5 5"> <input class="box1" type="password" name="pwd1" size="15"></td>
													</tr>
													<tr>
														<td colspan="2" height="1" background="image/index/dot_width.gif" bgcolor="#FDFDFD"></td>
													</tr>
													<tr>
														<td width="110" bgcolor="#fafafa" style="padding:5 5 5 5"><img src='image/mem_icon.gif'><font class='mem'>&nbsp;비밀번호 확인 <?=$sureIcon[2]?></font></td>
														<td width="480" bgcolor="#FFFFFF" style="padding:5 5 5 5"> <input class="box1" type="password" name="pwd2" size="15"></td>
													</tr>
													<tr>
														<td colspan="2" height="1" background="image/index/dot_width.gif" bgcolor="#FDFDFD"></td>
													</tr>
													<tr>
														<td width="110" bgcolor="#fafafa" style="padding:5 5 5 5"> <img src='image/mem_icon.gif'><font class='mem'>&nbsp;이 름 <?=$sureIcon[3]?></font></td>
														<td width="480" bgcolor="#FFFFFF" style="padding:5 5 5 5"> <input class="box1" type="text" name="name" size="10"></td>
													</tr>
													<tr>
														<td colspan="2" height="1" background="image/index/dot_width.gif" bgcolor="#FDFDFD"></td>
													</tr>
													<?
													if($showArr[4])
													{
														?>
													<tr>
														<td width="110" bgcolor="#fafafa" style="padding:5 5 5 5"><img src='image/mem_icon.gif'><font class='mem'>&nbsp;이메일 <?=$sureIcon[4]?></font></td>
														<td width="480" bgcolor="#FFFFFF" style="padding:5 5 5 5"> <input class="box1" type="text" name="email" size="50"></td>
													</tr>
													<tr>
														<td colspan="2" height="1" background="image/index/dot_width.gif" bgcolor="#FDFDFD"></td>
													</tr><?
													}
													if($showArr[5] && !$bDeal)
													{
														?>
													<tr>
														<td width="110" bgcolor="#fafafa" style="padding:5 5 5 5"><img src='image/mem_icon.gif'><font class='mem'>&nbsp;주민등록 번호 <?=$sureIcon[5]?></font></td>
														<td width="480" bgcolor="#FFFFFF" style="padding:5 5 5 5"> <input class="box1" type="text" name="ssh1" size="6" maxlength="6" <?=__ONLY_NUM?>> - <input class="box1" type="text" name="ssh2" size="7" maxlength="7" <?=__ONLY_NUM?>></td>
													</tr>
													<tr>
														<td colspan="2" height="1" background="image/index/dot_width.gif" bgcolor="#FDFDFD"></td>
													</tr><?
													}
													if($showArr[5] && $bDeal==1)
													{
														?>
													<tr>
														<td width="110" bgcolor="#fafafa" style="padding:5 5 5 5"><img src='image/mem_icon.gif'><font class='mem'>&nbsp;법인 번호 <?=$sureIcon[5]?></font></td>
														<td width="480" bgcolor="#FFFFFF" style="padding:5 5 5 5"> <input class="box1" type="text" name="ssh1" size="6" maxlength="6" <?=__ONLY_NUM?>> - <input class="box1" type="text" name="ssh2" size="7" maxlength="7" <?=__ONLY_NUM?>></td>
													</tr>
													<tr>
														<td colspan="2" height="1" background="image/index/dot_width.gif" bgcolor="#FDFDFD"></td>
													</tr><?
													}
													if($showArr[6])
													{
														?>
													<tr>
														<td width="110" bgcolor="#fafafa" style="padding:5 5 5 5"><img src='image/mem_icon.gif'><font class='mem'>&nbsp;전화번호 <?=$sureIcon[6]?></font></td>
														<td width="480" bgcolor="#FFFFFF" style="padding:5 5 5 5"> <input class="box1" type="text" name="tel1" size="3" maxlength="3" <?=__ONLY_NUM?>> - <input class="box1" type="text" name="tel2" size="4" maxlength="4" <?=__ONLY_NUM?>> - <input class="box1" type="text" name="tel3" size="4" maxlength="4" <?=__ONLY_NUM?>></td>
													</tr>
													<tr>
														<td colspan="2" height="1" background="image/index/dot_width.gif" bgcolor="#FDFDFD"></td>
													</tr><?
													}
													if($showArr[7])
													{
														?>
													<tr>
														<td width="110" bgcolor="#fafafa" style="padding:5 5 5 5"><img src='image/mem_icon.gif'><font class='mem'>&nbsp;휴대폰 번호 <?=$sureIcon[7]?></font></td>
														<td width="480" bgcolor="#FFFFFF" style="padding:5 5 5 5"> <input class="box1" type="text" name="hand1" size="3" maxlength="3" <?=__ONLY_NUM?>> - <input class="box1" type="text" name="hand2" size="4" maxlength="4" <?=__ONLY_NUM?>> - <input class="box1" type="text" name="hand3" size="4" maxlength="4" <?=__ONLY_NUM?>></td>
													</tr>
													<tr>
														<td colspan="2" height="1" background="image/index/dot_width.gif" bgcolor="#FDFDFD"></td>
													</tr><?
													}
													if($showArr[8])
													{
														?>
													<tr>
														<td width="110" bgcolor="#fafafa" style="padding:5 5 5 5"><img src='image/mem_icon.gif'><font class='mem'>&nbsp;우편번호 <?=$sureIcon[8]?></font></td>
														<td width="480" bgcolor="#FFFFFF" style="padding:5 5 5 5"> <input class="box1" type="text" name="zip1" size="3" maxlength="3" <?=__ONLY_NUM?> > - <input class="box1" type="text" name="zip2" size="3" maxlength="3" <?=__ONLY_NUM?> > &nbsp;&nbsp; <a href="javascript:searchZip();"><img src="image/icon/post_search.gif" border="0" align='absmiddle'></a></td>
													</tr>
													<tr>
														<td colspan="2" height="1" background="image/index/dot_width.gif" bgcolor="#FDFDFD"></td>
													</tr>
													<tr>
														<td width="110" bgcolor="#fafafa" style="padding:5 5 5 5"><img src='image/mem_icon.gif'><font class='mem'>&nbsp;주소 <?=$sureIcon[8]?></font></td>
														<td width="480" bgcolor="#FFFFFF" style="padding:5 5 5 5"> <input class="box1" type="text" name="address1" size="50"></td>
													</tr>
													<tr>
														<td colspan="2" height="1" background="image/index/dot_width.gif" bgcolor="#FDFDFD"></td>
													</tr>
													<tr>
														<td width="110" bgcolor="#fafafa" style="padding:5 5 5 5"><img src='image/mem_icon.gif'><font class='mem'>&nbsp;상세 주소 </font></td>
														<td width="480" bgcolor="#FFFFFF" style="padding:5 5 5 5"> <input class="box1" type="text" name="address2" size="40"></td>
													</tr>
													<tr>
														<td colspan="2" height="1" background="image/index/dot_width.gif" bgcolor="#FDFDFD"></td>
													</tr><?
													}
													if($showArr[10])
													{
														?>
													<tr>
														<td width="110" bgcolor="#fafafa" style="padding:5 5 5 5"><img src='image/mem_icon.gif'><font class='mem'>&nbsp;메일링 서비스 <?=$sureIcon[10]?></font></td>
														<td width="480" bgcolor="#FFFFFF" style="padding:5 5 5 5">
															<table width="265" border="0" cellspacing="0" cellpadding="0" align="left">
																<tr>
																	<td width="79">&nbsp;&nbsp;&nbsp;신청합니다</td>
																	<td width="49"> <input class="radio" type="radio" name="bMail" value="1" checked></td>
																	<td width="110">신청하지 않습니다.</td>
																	<td width="27"> <input class="radio" type="radio" name="bMail" value="0"></td>
																</tr>
															</table>
														</td>
													</tr>
													<tr>
														<td colspan="2" height="1" background="image/index/dot_width.gif" bgcolor="#FDFDFD"></td>
													</tr><?
													}
													if($showArr[11])
													{
														?>
													<tr>
														<td width="110" bgcolor="#fafafa" style="padding:5 5 5 5"><img src='image/mem_icon.gif'><font class='mem'>&nbsp;SMS 서비스 <?=$sureIcon[11]?></font></td>
														<td width="480" bgcolor="#FFFFFF" style="padding:5 5 5 5">
															<table width="265" border="0" cellspacing="0" cellpadding="0" align="left">
																<tr>
																	<td width="79">&nbsp;&nbsp;&nbsp;신청합니다</td>
																	<td width="49"> <input class="radio" type="radio" name="bSms" value="y" checked></td>
																	<td width="110">신청하지 않습니다.</td>
																	<td width="27"> <input class="radio" type="radio" name="bSms" value="n"></td>
																</tr>
															</table>
														</td>
													</tr>
													<tr>
														<td colspan="2" height="1" background="image/index/dot_width.gif" bgcolor="#FDFDFD"></td>
													</tr><?
													}
													?>
												</table>
											</td>
										</tr>
									</table>
								</td>
							</tr>
						</table><br><?
						if ($bDeal==1)
						{
							?>
						<table width="630" border="0" cellspacing="1" cellpadding="10" valign="top" align='center' bgcolor='dadada'>
							<tr>
								<td bgcolor='ffffff'>
									<table width="600" border="0" cellspacing="0" cellpadding="0" valign="top" align='center'>
										<tr>
											<td height="30" colspan="2" bgcolor="#F4F4F4" style='padding:5 5 5 5'><b>&nbsp;&nbsp;사업자 정보</b></td>
										</tr>
										<tr>
											<td colspan="2">
												<table width=100% border="0" cellspacing="0" cellpadding="0" valign="top" align='center'>
													<tr>
														<td width="121" bgcolor="fafafa" height="30" style="padding:5 5 5 5"> <img src='image/mem_icon.gif'> <font class='mem'>상호(법인명)</font></td>
														<td bgcolor="ffffff" style="padding:5 5 5 5"> <input type="text" class="box1" name="companyname" size="20" value="<?=$member_row[companyname]?>"></td>
														<td width="121" bgcolor="fafafa" style="padding:5 5 5 5"> <img src='image/mem_icon.gif'><img src='image/mem_icon.gif'> <font class='mem'>사업자번호</font><?//=$__SURELY_ICON?></td><?
														$ceonum = explode("-",$member_row[ceonum]);
														?>
														<td bgcolor="ffffff" style="padding:5 5 5 5"> <input type="text" class="box1" name="ceonum1" size="3" value="<?=$ceonum[0]?>" maxlength="3" <?= __ONLY_NUM ?>> - <input type="text" class="box1" name="ceonum2" size="2" value="<?=$ceonum[1]?>" maxlength="2" <?= __ONLY_NUM ?>> - <input type="text" class="box1" name="ceonum3" size="5" value="<?=$ceonum[2]?>" maxlength="5" <?= __ONLY_NUM ?>></td>
													</tr>
													<tr>
														<td height="1" colspan="4" background="image/index/dot_width.gif"></td>
													</tr>
													<tr>
														<td width="121" bgcolor="fafafa" style="padding:5 5 5 5"> <img src='image/mem_icon.gif'> <font class='mem'>대표자</font></td>
														<td bgcolor="ffffff" style="padding:5 5 5 5"> <input type="text" class="box1" name="ceoname" size="20" value="<?=$member_row[ceoname]?>"></td>
													</tr>
													<tr>
														<td height="1" colspan="4" background="image/index/dot_width.gif"></td>
													</tr>
													<tr>
														<td width="121" bgcolor="fafafa" style="padding:5 5 5 5"> <img src='image/mem_icon.gif'> <font class='mem'>우편번호 </font></td>
														<td colspan="3" bgcolor="ffffff" style="padding:5 5 5 5"> <input type="text" class="box1" name="ceo_zip1" size="3" <?=__ONLY_NUM?> value="<?=$ceo_zip[0]?>"> - <input type="text" class="box1" name="ceo_zip2" size="3" <?=__ONLY_NUM?> value="<?=$ceo_zip[1]?>"> <a href="javascript:searchZip_ceo();"><img src="image/icon/post_search.gif" border='0'></a> </td>
													</tr>
													<tr>
														<td height="1" colspan="4" background="image/index/dot_width.gif"></td>
													</tr>
													<tr>
														<td width="121" bgcolor="fafafa" style="padding:5 5 5 5"> <img src='image/mem_icon.gif'> <font class='mem'>주소 </font></td>
														<td colspan="3" bgcolor="ffffff" style="padding:5 5 5 5"> <input type="text" class="box1" name="ceo_address1" size="55" value="<?=$member_row[ceo_address1]?>"></td>
													</tr>
													<tr>
														<td height="1" colspan="4" background="image/index/dot_width.gif"></td>
													</tr>
													<tr>
														<td width="121" bgcolor="fafafa" style="padding:5 5 5 5"> <img src='image/mem_icon.gif'> <font class='mem'>상세주소 </font></td>
														<td colspan="3" bgcolor="ffffff" style="padding:5 5 5 5"> <input type="text" class="box1" name="ceo_address2" size="55" value="<?=$member_row[ceo_address2]?>"></td>
													</tr>
													<tr>
														<td height="1" colspan="4" background="image/index/dot_width.gif"></td>
													</tr>
													<tr>
														<td width="121" bgcolor="fafafa" style="padding:5 5 5 5"> <img src='image/mem_icon.gif'> <font class='mem'>업태</font></td>
														<td bgcolor="ffffff" style="padding:5 5 5 5"> <input type="text" class="box1" name="upjongtype" size="20" value="<?=$member_row[upjongtype]?>"></td>
														<td width="121" bgcolor="fafafa" style="padding:5 5 5 5"> <img src='image/mem_icon.gif'> <font class='mem'>업종</font></td>
														<td bgcolor="ffffff" style="padding:5 5 5 5"> <input type="text" class="box1" name="jongmok" size="20" value="<?=$member_row[jongmok]?>"></td>
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
						</table><br><?
						}
						?>
						<table width="630" border="0" cellspacing="1" cellpadding="10" valign="top" align='center' bgcolor='dadada'>
							<tr>
								<td bgcolor='ffffff'>
									<table width="600" border="0" cellspacing="1" cellpadding="0" valign="top" align='center'>
										<tr>
											<td height="30" colspan="2" bgcolor="#f4f4f4"><b>&nbsp;&nbsp;부가정보</b>&nbsp;&nbsp;&nbsp;&nbsp; </td>
										</tr><?
										if($showArr[12])
										{
											?>
										<tr>
											<td width="110" bgcolor="#fafafa" style="padding:5 5 5 5"><img src='image/mem_icon.gif'><font class='mem'>&nbsp;생년월일 <?=$sureIcon[12]?></font></td>
											<td width="480" bgcolor="#FFFFFF" style="padding:5 5 5 5"> <input class="box1" type="text" name="year" size="4" maxlength='4' <?= __ONLY_NUM ?>> 년  &nbsp;&nbsp; <select name="month" class="box1"><?
											for ($i=1; $i<13; $i++)
											{
												?><option value="<?=$i?>" <? if ($i == $month) echo "selected";?>><?=$i?></option><?
											}
											?></select> 월&nbsp;&nbsp; <select name="day" class="box1"><?
											for ($i=1; $i<32; $i++)
											{
												?><option value="<?=$i?>" <? if ($i == $day) echo "selected";?>><?=$i?></option><?
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
											<td width="110" bgcolor="#fafafa" style="padding:5 5 5 5"><img src='image/mem_icon.gif'><font class='mem'>&nbsp;결혼기념일 <?=$sureIcon[13]?></font></td>
											<td width="480" bgcolor="#FFFFFF" style="padding:5 5 5 5"> <input class="box1" type="text" name="year2" size="4" maxlength='4' <?= __ONLY_NUM ?>> 년  &nbsp;&nbsp; <select name="month2" class="box1"><?
											for ($i=1; $i<13; $i++)
											{
												?><option value="<?=$i?>" <? if ($i == $month) echo "selected";?>><?=$i?></option><?
											}
											?></select> 월&nbsp;&nbsp; <select name="day2" class="box1"><?
											for ($i=1; $i<32; $i++)
											{
												?><option value="<?=$i?>" <? if ($i == $day) echo "selected";?>><?=$i?></option><?
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
						<table width="250" border="0" cellspacing="0" cellpadding="0" align="center">
							<tr align="center">
								<td><a href="javascript:joinSendit();"><img src="image/icon/ok2_btn.gif" border="0"></a></td>
								<td><a href="index.php"><img src="image/icon/cancel_lag.gif" border="0"></a></td>
							</tr>
						</table></form><!-- joinForm -->
					</td>
				</tr>
			</table><br>
		</td>
	</tr>
</table>
<? include "copy.php"; ?>
</body>
</html>