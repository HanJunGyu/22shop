<?
include "head.php";
?>
<SCRIPT LANGUAGE="JavaScript">
<!--
//비밀번호 변경
function pwdSendit()
{
	<?if(__DEMOPAGE){?>
	alert("데모사이트 에서는 비밀번호 변경을 하실 수 없습니다.");
	<?}else{?>
	var form=document.pwdForm;
	if(form.pwd.value=="")
	{
		alert("변경할 비밀번호를 입력해 주십시오.");
		form.pwd.focus();
	}
	else
	{
		form.submit();
	}
	<?}?>
}
//적립금 변경
function pointSendit()
{
	var form=document.pointForm;
	if(form.point.value=="")
	{
		alert("적립금을 입력해 주십시오.");
		form.point.focus();
		return false;
	}
	else if(!numCheck(form.point.value))
	{
		alert("적립금 설정이 올바르지 않습니다.");
		form.point.focus();
		return false;
	}
	else
	{
		return true;
	}
}
//기본정보변경
function baseEdit()
{
	var form=document.baseForm;
	form.submit();
}
function editLevel()
{
	var form=document.levelForm;
	form.submit();
}
function member_view(data)
{
	window.open("member.php?data="+data,"","scrollbars=yes,left=10,top=10,width=800,height=700");
}
function point_detail(data)
{
	window.open("member_point.php?data2="+data,"","scrollbars=yes,left=10,top=10,width=700,height=500");
}
function trade(str)
{
	window.open("member_trade.php?userid="+str,"","scrollbars=yes,left=20,top=50,width=820,height=300");
}
//-->
</SCRIPT>
<body>
<?
$dataArr = Decode64($data);
$member_row = $MySQL->fetch_array("select *from member where idx=$dataArr[idx]");
if ($update_trade)
{
	//회원정보의 구매수,구매액 업데이트//
	$buyNum = $MySQL->fetch_array("select count(*) from trade where userid='$member_row[userid]' and bPay=1 and status<4");
	$buyMoney =$MySQL->fetch_array("select sum(totalM) from trade where userid='$member_row[userid]' and bPay=1 and status<4");
	//회원 구매수, 구매액 수정	 
	if(empty($buyNum[0])) $buyNum[0] =0;
	if(empty($buyMoney[0])) $buyMoney[0] =0;
	$editQry = "update member set buyNum=$buyNum[0],buyMoney=$buyMoney[0] where userid='$member_row[userid]'";
	$MySQL->query($editQry);
}
if($member_row[bMail])	$bMail = "수신";
else					$bMail = "거부";
$ssh= explode("-",$member_row[ssh]);
$zip= explode("-",$member_row[zip]);
$tel= explode("-",$member_row[tel]);
$hand= explode("-",$member_row[hand]);
$ceo_zip	 = explode("-",$member_row[ceo_zip]);
$birth= explode("-",$member_row[birth]);
$birth2= explode("-",$member_row[birth2]);
?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td height='5'></td>
	</tr>
	<tr>
		<td>
			<table width="750" border="0" cellspacing="0" cellpadding="0" align='center'>
				<tr>
					<td rowspan="3" width="200"><img src="image/member_tit.gif"></td>
					<td>&nbsp;</td>
				</tr>
				<tr>
					<td bgcolor="#E6E6E6" height='26'><div align='right'><font class='text1'>SHOP 회원전체목록 및 전체메일발송 등을 하실수 있습니다.&nbsp;</div></td>
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
					<td width='440'><img src="image/adm_mid_tit.gif"></td>
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
			<table width="700" border="0" bgcolor="#CCCCCC" cellpadding="0" cellspacing="0" align="center">
				<tr>
					<td>
						<table width="100%" align="center" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td bgcolor="#FFFFFF">
									<table width="98%" border="0" cellspacing="1" cellpadding="0" align="center">
										<tr valign="middle">
											<td width="103" height="25" bgcolor="#FAFAFA"> <div align="left">&nbsp;&nbsp;<img src="image/icon.gif" width="11" height="11"> <font color="#0099CC">이 름</font></div></td>
											<td width="447" height="25" colspan="3">&nbsp;<B><?=$member_row[name]?></B></td>
										</tr>
										<tr>
											<td colspan="4" height="1" background="image/line_bg1.gif" bgcolor="#FFFFFF"></td>
										</tr>
										<tr valign="middle">
											<td width="103" height="25" bgcolor="#FAFAFA"> <div align="left">&nbsp;&nbsp;<img src="image/icon.gif" width="11" height="11"> <font color="#0099CC">아이디</font></div></td>
											<td width="447" height="25" bgcolor="#FFFFFF" colspan="3">&nbsp;<FONT  COLOR="#6600FF"><?=$member_row[userid]?></FONT></td>
										</tr>
										<tr>
											<td colspan="4" height="1" background="image/line_bg1.gif" bgcolor="#FFFFFF"></td>
										</tr>
										<form name="pwdForm" method="post" action="member_edit_ok.php?pwdedit=1&data=<?=$data?>">
										<tr>
											<td width="103" height="25" bgcolor="#FAFAFA">&nbsp;&nbsp;<img src="image/icon.gif" width="11" height="11"> <font color="#0099CC">비밀번호</font></td>
											<td width="447" height="25" bgcolor="#FFFFFF" valign="middle" colspan="3">&nbsp;<input class="box" name="pwd" type="password" id="sday" size="20" value=""> <a href="#;" onclick="javascript:pwdSendit();"><img src="image/edit_btn.gif" width="40" height="17" border=0></a></td>
										</tr>
										</form><!-- pwdForm -->
										<tr>
											<td colspan="4" height="1" background="image/line_bg1.gif" bgcolor="#FFFFFF"></td>
										</tr>
										<tr>
											<td colspan="4" height="15" bgcolor="#FFFFFF"></td>
										</tr>
										<form name="levelForm" method="post" action="member_edit_ok.php?leveledit=1&data=<?=$data?>">
										<tr>
											<td width="103" height="25" bgcolor="#FAFAFA">&nbsp;&nbsp;<img src="image/icon.gif" width="11" height="11"> 분류</td>
											<td width="447" height="25" bgcolor="#FFFFFF" valign="middle" colspan="3">&nbsp;<select name="part"><option value="M" <? if ($member_row[part]=="M") echo "selected";?>>일반회원</option><option value="D" <? if ($member_row[part]=="D") echo "selected";?>>도매회원</option></select>&nbsp;<a href="#;" onclick="javascript:editLevel();"><img src="image/edit_btn.gif" width="40" height="17" border=0></a></td>
										</tr>
										</form><!-- pwdForm -->
										<tr>
											<td colspan="4" height="1" background="image/line_bg1.gif" bgcolor="#FFFFFF"></td>
										</tr>
										<tr>
											<td colspan="4" height="15" bgcolor="#FFFFFF"></td>
										</tr>
										<form name="baseForm" method="post" action="member_edit_ok.php?baseedit=1&data=<?=$data?>">
										<tr>
											<td colspan="4" height="1" background="image/line_bg1.gif" bgcolor="#FFFFFF"></td>
										</tr>
										<tr>
											<td width="103" height="25" bgcolor="#FAFAFA">&nbsp;&nbsp;<img src="image/icon.gif" width="11" height="11"> 이메일</td>
											<td width="447" height="25" bgcolor="#FFFFFF" colspan="3">&nbsp;<input name="email" type="text" id="sday" size="40" class="box" value="<?=$member_row[email]?>"></td>
										</tr>
										<tr>
											<td colspan="4" height="1" background="image/line_bg1.gif" bgcolor="#FFFFFF"></td>
										</tr>
										<tr>
											<td width="103" height="25" bgcolor="#FAFAFA">&nbsp;&nbsp;<img src="image/icon.gif" width="11" height="11"> 주민등록번호</td>
											<td width="447" height="25" bgcolor="#FFFFFF" colspan="3">&nbsp;<input name="ssh1" type="text" id="sday" size="6" class="box" value="<?=$ssh[0]?>" <?=__ONLY_NUM?>>-<input name="ssh2" type="text" id="sday" size="7" class="box" value="<?=$ssh[1]?>" <?=__ONLY_NUM?>></td>
										</tr>
										<tr>
											<td colspan="4" height="1" background="image/line_bg1.gif" bgcolor="#FFFFFF"></td>
										</tr>
										<tr>
											<td width="103" bgcolor="#FAFAFA">&nbsp;&nbsp;<img src="image/icon.gif" width="11" height="11"> 주 소</td>
											<td height="60" bgcolor="#FFFFFF" colspan="3">
												<table width="98%" border="0" cellspacing="1" cellpadding="0" align="center">
													<tr bgcolor="#F6F6F6">
														<td width="20%" height="25"> <div align="center">우편번호</div></td>
														<td width="80%" height="25"> <input name="zip1" type="text" id="sday" size="6" class="box" value="<?=$zip[0]?>" <?=__ONLY_NUM?>>-<input name="zip2" type="text" id="sday" size="7" class="box" value="<?=$zip[1]?>" <?=__ONLY_NUM?>></td>
													</tr>
													<tr bgcolor="#F6F6F6">
														<td width="20%" height="25"> <div align="center">주소</div></td>
														<td width="80%" height="25"> <input name="address1" type="text" id="sday" size="40" class="box" value="<?=$member_row[address1]?>"><br> <input name="address2" type="text" id="sday" size="30" class="box" value="<?=$member_row[address2]?>"></td>
													</tr>
												</table>
											</td>
										</tr>
										<tr>
											<td colspan="4" height="1" background="image/line_bg1.gif" bgcolor="#FFFFFF"></td>
										</tr>
										<tr>
											<td width="103" height="60" bgcolor="#FAFAFA">&nbsp;&nbsp;<img src="image/icon.gif" width="11" height="11"> 연 락 처</td>
											<td  height="60" colspan="3">
												<table width="98%" border="0" cellspacing="1" cellpadding="0" align="center">
													<tr bgcolor="#F6F6F6">
														<td width="20%" height="25"> <div align="center">집 / 사무실</div></td>
														<td width="80%" height="25"> <input name="tel1" type="text" id="sday" size="4" class="box" value="<?=$tel[0]?>" <?=__ONLY_NUM?>>-<input name="tel2" type="text" id="sday" size="4" class="box" value="<?=$tel[1]?>" <?=__ONLY_NUM?>>-<input name="tel3" type="text" id="sday" size="4" class="box" value="<?=$tel[2]?>" <?=__ONLY_NUM?>></td>
													</tr>
													<tr bgcolor="#F6F6F6">
														<td width="20%" height="25"> <div align="center">휴대폰</div></td>
														<td width="80%" height="25"> <input name="hand1" type="text" id="sday" size="4" class="box" value="<?=$hand[0]?>" <?=__ONLY_NUM?>>-<input name="hand2" type="text" id="sday" size="4" class="box" value="<?=$hand[1]?>" <?=__ONLY_NUM?>>-<input name="hand3" type="text" id="sday" size="4" class="box" value="<?=$hand[2]?>" <?=__ONLY_NUM?>></td>
													</tr>
												</table>
											</td>
										</tr>
										<tr>
											<td colspan="4" height="1" background="image/line_bg1.gif" bgcolor="#FFFFFF"></td>
										</tr>
										<tr>
											<td width="103" height="25" bgcolor="#FAFAFA">&nbsp;&nbsp;<img src="image/icon.gif" width="11" height="11"> 메일 수신여부</td>
											<td width="447" height="25" bgcolor="#FFFFFF" colspan="3">&nbsp;<input type="radio" class="radio" name="bMail" value="1" <?if($member_row[bMail])echo"checked";?>> 수신 <input type="radio" class="radio" name="bMail" value="0" <?if(!$member_row[bMail])echo"checked";?>> 수신거부</td>
										</tr>
										<tr>
											<td colspan="4" height="1" background="image/line_bg1.gif" bgcolor="#FFFFFF"></td>
										</tr>
										<tr>
											<td width="103" height="25" bgcolor="#FAFAFA">&nbsp;&nbsp;<img src="image/icon.gif" width="11" height="11"> SMS 수신여부</td>
											<td width="447" height="25" bgcolor="#FFFFFF" colspan="3">&nbsp;<input type="radio" class="radio" name="bSms" value="y" <?if($member_row[bSms]=="y") echo"checked";?>> 수신 <input type="radio" class="radio" name="bSms" value="n" <?if($member_row[bSms]=="n") echo"checked";?>> 수신거부</td>
										</tr>
										<tr>
											<td colspan="4" height="1" background="image/line_bg1.gif" bgcolor="#FFFFFF"></td>
										</tr>
										<tr>
											<td width="103" height="25" bgcolor="#FAFAFA">&nbsp;&nbsp;<img src="image/icon.gif" width="11" height="11"> 생년월일</td>
											<td width="447" height="25" bgcolor="#FFFFFF" colspan="3">&nbsp;<input class="box" type="text" name="year" size="4" value="<?=$birth[0]?>">  년&nbsp;&nbsp;<select name="month" class="box"><?
											for ($i=1; $i<13; $i++)
											{
												?><option value="<?=$i?>" <? if ($i == $birth[1]) echo "selected";?>><?=$i?></option><?
											}
											?></select> 월&nbsp;&nbsp;<select name="day" class="box"><?
											for ($i=1; $i<32; $i++)
											{
												?><option value="<?=$i?>" <? if ($i == $birth[2]) echo "selected";?>><?=$i?></option><?
											}
											?></select> 일</td>
										</tr>
										<tr>
											<td colspan="4" height="1" background="image/line_bg1.gif" bgcolor="#FFFFFF"></td>
										</tr>
										<tr>
											<td width="103" height="25" bgcolor="#FAFAFA">&nbsp;&nbsp;<img src="image/icon.gif" width="11" height="11"> 결혼기념일</td>
											<td width="447" height="25" bgcolor="#FFFFFF" colspan="3">&nbsp;<input class="box" type="text" name="year2" size="4" value="<?=$birth2[0]?>">  년&nbsp;&nbsp;<select name="month2" class="box"><?
											for ($i=1; $i<13; $i++)
											{
												?><option value="<?=$i?>" <? if ($i == $birth2[1]) echo "selected";?>><?=$i?></option><?
											}
											?></select> 월&nbsp;&nbsp;<select name="day2" class="box"><?
											for ($i=1; $i<32; $i++)
											{
												?><option value="<?=$i?>" <? if ($i == $birth2[2]) echo "selected";?>><?=$i?></option><?
											}
											?></select> 일</td>
										</tr>
										<tr>
											<td colspan="4" height="1" background="image/line_bg1.gif" bgcolor="#FFFFFF"></td>
										</tr>
										<tr>
											<td width="103" height="25" bgcolor="#FAFAFA">&nbsp;&nbsp;<img src="image/icon.gif" width="11" height="11"> 회원 메모</td>
											<td width="447" height="25" bgcolor="#FFFFFF" colspan="3">&nbsp;<textarea name="member_content" cols="50" rows="10" class="box"><?=$member_row[member_content]?></textarea></td>
										</tr>
										<tr>
											<td colspan="4" height="1" background="image/line_bg1.gif" bgcolor="#FFFFFF"></td>
										</tr>
										<tr>
											<td height="25" bgcolor="#FAFAFA">&nbsp;&nbsp;<img src="image/icon.gif" width="11" height="11"> 물품환불계좌</td>
											<td bgcolor="#FFFFFF" colspan="3">
												<table width="100%" border="0" cellspacing="0" cellpadding="0" align="left">
													<tr>
														<td width="100%">&nbsp;&nbsp;은행명 <input class="box1" type="text" name="refund_bank" value="<?=stripslashes($member_row[refund_bank])?>" size="10"> &nbsp;&nbsp;예금주 <input class="box1" type="text" name="refund_name" value="<?=stripslashes($member_row[refund_name])?>" size="10"> &nbsp;&nbsp;계좌 <input class="box1" type="text" name="refund_account" value="<?=stripslashes($member_row[refund_account])?>" size="20"></td>
													</tr>
												</table>
											</td>
										</tr>
										<tr>
											<td colspan="4" height="1" background="image/line_bg1.gif" bgcolor="#FFFFFF"></td>
										</tr>
										<tr>
											<td height="30" colspan="4" bgcolor="#F4F4F4"><b>&nbsp;&nbsp;사업자 정보</b> </td>
										</tr>
										<tr>
											<td colspan="4">
												<table width=100%>
													<tr>
														<td width="121" bgcolor="fafafa" height="30"> <div align="center">상호(법인명) <br></div></td>
														<td bgcolor="ffffff"> <input type="text" class="box" name="companyname" size="20" value="<?=$member_row[companyname]?>"></td>
														<td width="121" bgcolor="fafafa"> <div align="center">사업자번호<?//=$__SURELY_ICON?></div></td><?
														$ceonum = explode("-",$member_row[ceonum]);
														?>
														<td bgcolor="ffffff"> <input type="text" class="box" name="ceonum1" size="3" value="<?=$ceonum[0]?>" maxlength="3"> - <input type="text" class="box" name="ceonum2" size="2" value="<?=$ceonum[1]?>" maxlength="2"> - <input type="text" class="box" name="ceonum3" size="5" value="<?=$ceonum[2]?>" maxlength="5"></td>
													</tr>
													<tr>
														<td width="121" bgcolor="fafafa"> <div align="center">대표자 </div></td>
														<td bgcolor="ffffff"> <input type="text" class="box" name="ceoname" size="20" value="<?=$member_row[ceoname]?>"> </td>
													</tr>
													<tr>
														<td width="121" bgcolor="fafafa"> <div align="center">우편번호 </div></td>
														<td colspan="3" bgcolor="ffffff"> <input type="text" class="box" name="ceo_zip1" size="3" <?=__ONLY_NUM?> value="<?=$ceo_zip[0]?>"> - <input type="text" class="box" name="ceo_zip2" size="3" <?=__ONLY_NUM?> value="<?=$ceo_zip[1]?>"> </td>
													</tr>
													<tr>
														<td width="121" bgcolor="fafafa"> <div align="center">주소 </div></td>
														<td colspan="3" bgcolor="ffffff"> <input type="text" class="box" name="ceo_address1" size="55" value="<?=$member_row[ceo_address1]?>"></td>
													</tr>
													<tr>
														<td width="121" bgcolor="fafafa"> <div align="center">상세주소 </div></td>
														<td colspan="3" bgcolor="ffffff"> <input type="text" class="box" name="ceo_address2" size="55" value="<?=$member_row[ceo_address2]?>"></td>
													</tr>
													<tr>
														<td width="121" bgcolor="fafafa"> <div align="center">업태</div></td>
														<td bgcolor="ffffff"> <input type="text" class="box" name="upjongtype" size="30" value="<?=$member_row[upjongtype]?>"></td>
														<td width="121" bgcolor="fafafa"> <div align="center">업종</div></td>
														<td bgcolor="ffffff"> <p> <input type="text" class="box" name="jongmok" size="30" value="<?=$member_row[jongmok]?>"></p></td>
													</tr>
												</table>
											</td>
										</tr>
										<tr>
											<td colspan="4" height="25" align="center"  bgcolor="#fafafa"><a href="javascript:baseEdit();"><img src="image/edit_btn.gif" width="40" height="17" border="0"></a></td>
										</tr>
										</form>
										<tr>
											<td colspan="4" height="1" background="image/line_bg1.gif" bgcolor="#FFFFFF"></td>
										</tr>
										<tr>
											<td colspan="4" height="25"><br>
												<table width="750" border="0" cellspacing="0" cellpadding="0" align="center">
													<tr>
														<td width='1' bgcolor='dadada' colspan='3'></td>
													</tr>
													<tr>
														<td width='450'><img src="image/mem_save_tit.gif"></td>
													</tr>
													<tr>
														<td width='1' bgcolor='dadada' colspan='3'></td>
													</tr>
												</table>
											</td>
										</tr>
										<form name="pointForm" method="post" action="member_edit_ok.php?pointedit=1&data=<?=$data?>" onSubmit="return pointSendit();">
										<tr>
											<td width="103" height="25" bgcolor="#FAFAFA">&nbsp;&nbsp;<img src="image/icon.gif" width="11" height="11"> 적립금</td>
											<td width="447" height="25" bgcolor="#FFFFFF" colspan="3">총적립금&nbsp;<input name="point" type="text" id="sday" size="20" class="box" value="<?=$member_row[point]?>" <?=__ONLY_NUM?>> <input type="image" src="image/edit_btn.gif" width="40" height="17">&nbsp;&nbsp; <a href="#;" onclick="point_detail('<?=$data?>')"><img src="image/point_detail.gif"></a>&nbsp;&nbsp; <br>변경사유 <input type="text" class="box" size="50" name="reason"></td>
										</tr>
										</form><!-- pointForm -->
										<tr>
											<td colspan="4" height="1" background="image/line_bg1.gif" bgcolor="#FFFFFF"></td>
										</tr>
										<tr>
											<td colspan="4" height="15" ></td>
										</tr>
										<tr>
											<td colspan="4" height="25" bgcolor='FAFAFA'>
												<table width="750" border="0" cellspacing="0" cellpadding="0" align="center">
													<tr>
														<td width='1' bgcolor='dadada' colspan='3'></td>
													</tr>
													<tr>
														<td width='450'><img src="image/mem_data_tit.gif"></td>
													</tr>
													<tr>
														<td width='1' bgcolor='dadada' colspan='3'></td>
													</tr>
												</table>
											</td>
										</tr>
										<tr>
											<td width="103" height="25" bgcolor="#FAFAFA">&nbsp;&nbsp;<img src="image/icon.gif" width="11" height="11"> 가입일자</td>
											<td width="180" height="25" bgcolor="#FFFFFF" >&nbsp;<?=$member_row[writeday]?></td>
											<td width="103" height="25" bgcolor="#FAFAFA">&nbsp;&nbsp;<img src="image/icon.gif" width="11" height="11"> 최근접속일자</td>
											<td width="180" height="25" bgcolor="#FFFFFF">&nbsp;<?=$member_row[nearDay]?></td>
										</tr>
										<tr>
											<td colspan="4" height="1" background="image/line_bg1.gif" bgcolor="#FFFFFF"></td>
										</tr>
										<tr>
											<td width="103" height="25" bgcolor="#FAFAFA">&nbsp;&nbsp;<img src="image/icon.gif" width="11" height="11"> 방문회수</td>
											<td width="180" height="25" bgcolor="#FFFFFF">&nbsp;<B><?=$member_row[accNum]?></B></td>
											<td width="103" height="25" bgcolor="#FAFAFA">&nbsp;&nbsp;<img src="image/icon.gif" width="11" height="11"> 최근구매일자</td>
											<td width="180" height="25" bgcolor="#FFFFFF">&nbsp;<?=$member_row[nearBuy]?></td>
										</tr>
										<tr>
											<td colspan="4" height="1" background="image/line_bg1.gif" bgcolor="#FFFFFF"></td>
										</tr>
										<tr>
											<td width="103" height="25" bgcolor="#FAFAFA">&nbsp;&nbsp;<img src="image/icon.gif" width="11" height="11"> 구매수</td>
											<td width="180" height="25" bgcolor="#FFFFFF">&nbsp;<?=$member_row[buyNum]?></td>
											<td width="103" height="25" bgcolor="#FAFAFA">&nbsp;&nbsp;<img src="image/icon.gif" width="11" height="11">&nbsp;&nbsp;구매액</td>
											<td width="180" height="25" bgcolor="#FFFFFF">&nbsp;<?=PriceFormat($member_row[buyMoney])?></td>
										</tr>
										<tr>
											<td colspan="4" height="1" background="image/line_bg1.gif" bgcolor="#FFFFFF"></td>
										</tr>
										<tr>
											<td colspan="4" align=right><br><input type="button" value="구매수,구매액 최신정보로 갱신" class="text" onclick="location.href='member.php?update_trade=1&data=<?=$data?>'"></td>
										</tr>
										<tr>
											<td colspan="4" align=center><br><img src="image/close_btn.gif" border=0 onclick="javascript:self.close();" style="cursor:pointer;"></td>
										</tr>
									</table><br>
								</td>
							</tr>
						</table>
					</td>
				</tr>
			</table><br>
		</td>
	</tr>
</table>
<? include "copy.php";?>
</body>
</html>