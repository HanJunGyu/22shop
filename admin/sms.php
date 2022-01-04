<?
include "head.php";
?>
<SCRIPT LANGUAGE="JavaScript">
<!--
function smsSendit(Part)
{
	//정보 전송
	var form=document.smsForm;
	form.part.value = Part;
	if(Part==1)
	{
		if(form.bSms[0].checked && form.userid.value=="")
		{
			alert("아이디를 입력해 주십시오.");
			form.userid.focus();
		}
		else if(form.bSms[0].checked && form.pwd.value=="")
		{
			alert("비밀번호를 입력해 주십시오.");
			form.pwd.focus();
		}
		else
		{
			form.submit();
		}
	}
	else if(Part==2)
	{
		if(form.bSend1.checked && form.msg1.value=="")
		{
			alert("메세지를 입력해 주십시오.");
			form.msg1.focus();
		}
		else if(form.bSend2.checked && form.msg2.value=="")
		{
			alert("메세지를 입력해 주십시오.");
			form.msg2.focus();
		}
		else
		{
			form.submit();
		}
	}
	else if(Part==3)
	{
		if(form.bSend3.checked && form.msg3.value=="")
		{
			alert("메세지를 입력해 주십시오.");
			form.msg3.focus();
		}
		else if(form.bSend4.checked && form.msg4.value=="")
		{
			alert("메세지를 입력해 주십시오.");
			form.msg4.focus();
		}
		else
		{
			form.submit();
		}
	}
	else if(Part==4)
	{
		if(form.bSend5.checked && form.msg5.value=="")
		{
			alert("메세지를 입력해 주십시오.");
			form.msg5.focus();
		}
		else
		{
			form.submit();
		}
	}
	else if(Part==6)
	{
		if(form.bSend8.checked && form.msg8.value=="")
		{
			alert("메세지를 입력해 주십시오.");
			form.msg8.focus();
		}
		else
		{
			form.submit();
		}
	}
}
function checklen(form,fieldname,flag) //flag : 1 회원전송, 2 : 관리자전송 
{
	var form=form;
	var msgtext, msglen;
	msgtext = eval("form."+fieldname).value;
	msglen = eval("form.msglen"+flag).value;
	var i=0,l=0;
	var temp,lastl;
	//길이를 구한다.
	while(i < msgtext.length)
	{
		temp = msgtext.charAt(i);
		if (escape(temp).length > 4) l+=2;
		else if (temp!='\r') l++;
		if (temp=='\r' && l>79)
		{
			msgtext = msgtext.substr(0,i);
		}
		// OverFlow
		if(l>80)
		{
			alert("메시지란에 허용 길이 이상의 글을 쓰셨습니다.\n메시지란에는 한글 40자, 영문80자까지만 쓰실 수 있습니다.");
			temp = msgtext.substr(0,i);
			msgtext = temp;
			l = lastl;
			i = msgtext.length;
			msglen=l;
			eval("form."+fieldname).focus();
			return;
			break;
		}
		lastl = l;
		i++;
	}
	eval("form.msglen"+flag).value = l;
}
//-->
</SCRIPT>
<body bgcolor="#FFFFFF" text="#5A595A" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<? include "top_menu.php"; ?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr><?
	$__TOP_MENU = "sms";     //왼쪽 소메뉴 설정 변수
	include "left_menu.php";
	$sms = $MySQL->fetch_array("select * from smsinfo limit 0,1");
	$retel  = explode("-",$sms[retel]);
	$adminTel  = explode("-",$sms[adminTel]);
	$retel  = explode("-",$sms[retel]);
	?>
		<td width="85%" valign="top">
			<table width="100%" border="0" cellspacing="0" cellpadding="0" height="400">
				<tr>
					<td height='5'></td>
				</tr>
				<tr>
					<td>
						<table width="750" border="0" cellspacing="0" cellpadding="0" align='center'>
							<tr>
								<td rowspan="3" width="200"><img src="image/sms_tit_l.gif"></td>
								<td>&nbsp;</td>
							</tr>
							<tr>
								<td bgcolor="#E6E6E6" height='26'><div align='right'><font class='text1'>SHOP SMS 휴대폰문자 서비스를 관리하실수 있습니다.&nbsp;</div></td>
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
						<form name="smsForm" method="post" action="sms_ok.php">
						<input type="hidden" name="part">
						<table width="796" border="0" cellspacing="0" cellpadding="0" align="center">
							<tr>
								<td valign="top" height="25">
									<table width="750" border="0" cellspacing="0" cellpadding="0" align="center">
										<tr>
											<td height="30" width="160" bgcolor="f2f2f2">&nbsp;&nbsp;<img src="image/icon.gif" width="11" height="11"> SMS 사용</td>
											<td height="30" colspan="3"> &nbsp; <input type="radio" name="bSms" value="1" <?if($sms[bSms])echo"checked";?>>사용함 <input type="radio" name="bSms" value="0" <?if(!$sms[bSms])echo"checked";?>>사용하지 않음</td>
										</tr>
										<tr>
											<td height="1" colspan="4" background="image/line_bg1.gif"></td>
										</tr>
										<tr>
											<td height="30" bgcolor="f2f2f2">&nbsp;&nbsp;<img src="image/icon.gif" width="11" height="11"> 서비스 업체</td>
											<td height="30" colspan="3"> &nbsp; <select name="company"><option value="icodekorea" <?if($sms[company]=="icodekorea") echo"selected";?>>icodekorea</option></select> <input type="radio" name="gubun" value="1" <?if($sms[gubun]==1)echo"checked";?>> 충전 <input type="radio" name="gubun" value="2" <?if($sms[gubun]==2)echo"checked";?>> 정액</td>
										</tr>
										<tr>
											<td height="1" colspan="4" background="image/line_bg1.gif"></td>
										</tr>
										<tr>
											<td height="30" bgcolor="f2f2f2">&nbsp;&nbsp;<img src="image/icon.gif" width="11" height="11"> 아이디</td>
											<td height="30" width="500"> &nbsp; <input type="text" class="box" name="userid" value="<?=$sms[userid]?>"> <font class="help">※(주)올플랜을 통해들어온곳은 아이디앞에 <b>apl_</b> 를 붙여주세요.</font></td>
										</tr>
										<tr>
											<td height="1" colspan="4" background="image/line_bg1.gif"></td>
										</tr>
										<tr>
											<td height="30" bgcolor="f2f2f2">&nbsp;&nbsp;<img src="image/icon.gif" width="11" height="11"> 비밀번호</td>
											<td height="30" width="225"> &nbsp; <input type="password" class="box" name="pwd" size="10" value="<?=$sms[pwd]?>"></td>
										</tr>
										<tr>
											<td height="1" colspan="4" background="image/line_bg1.gif"></td>
										</tr>
										<tr>
											<td height="30" bgcolor="f2f2f2">&nbsp;&nbsp;<img src="image/icon.gif" width="11" height="11"> 표시되는 관리자번호</td>
											<td height="30" colspan="3"> &nbsp; <input type="text" class="box" name="adminTel1" size="3" maxlength="3" <?=__ONLY_NUM?> value="<?=$adminTel[0]?>"> - <input type="text" class="box" name="adminTel2" size="4" maxlength="4" <?=__ONLY_NUM?> value="<?=$adminTel[1]?>"> - <input type="text" class="box" name="adminTel3" size="4" maxlength="4" <?=__ONLY_NUM?> value="<?=$adminTel[2]?>">&nbsp;<font class="help">※ 1588-1111 식의 두자리 번호는 맨앞자리 국번입력을 비워두세요</font></td>
										</tr>
										<tr>
											<td height="1" colspan="4" background="image/line_bg1.gif"></td>
										</tr>
										<tr>
											<td height="30" bgcolor="f2f2f2">&nbsp;&nbsp;<img src="image/icon.gif" width="11" height="11"> 관리자 수신용 휴대번호</td>
											<td height="30" colspan="3"> &nbsp; <input type="text" class="box" name="retel1" size="3" maxlength="3" <?=__ONLY_NUM?> value="<?=$retel[0]?>"> - <input type="text" class="box" name="retel2" size="4" maxlength="4" <?=__ONLY_NUM?> value="<?=$retel[1]?>"> - <input type="text" class="box" name="retel3" size="4" maxlength="4" <?=__ONLY_NUM?> value="<?=$retel[2]?>"></td>
										</tr>
										<tr>
											<td height="1" colspan="4" background="image/line_bg1.gif"></td>
										</tr>
									</table>
								</td>
							</tr>
							<tr>
								<td height="30"> <div align="center"><a href="javascript:smsSendit(1);"><img src="image/save_btn.gif" width="40" height="17" border="0"></a></div></td>
							</tr>
							<tr>
								<td>
									<table width="750" border="0" cellspacing="0" cellpadding="0" align="center">
										<tr>
											<td width='1' bgcolor='dadada' colspan='3'></td>
										</tr>
										<tr>
											<td width='440'><img src="image/sms_tit.gif"></td>
										</tr>
										<tr>
											<td width='1' bgcolor='dadada' colspan='3'></td>
										</tr>
									</table>
								</td>
							</tr>
							<tr>
								<td height="30">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<FONT  COLOR="#CC3300">- 메세지 내용이 <B>80 byte</B>(한글 40자)를 초과할 경우 메세지가 전송되지 않습니다.</FONT></td>
							</tr>
							<tr>
								<td valign="top">
									<table width="750" border="0" cellspacing="0" cellpadding="0" align="center">
										<tr>
											<td height="40"><img src="image/design_main_icon.gif" width="21" height="11"> 회원가입</td>
										</tr>
										<tr>
											<td>
												<table width="750" border="0" cellspacing="1" cellpadding="10" bgcolor="cdcdcd">
													<tr>
														<td bgcolor="f4f4f4"><B>__NAME</B> : 이름&nbsp;&nbsp;&nbsp;&nbsp;<B>__USERID</B> : 아이디&nbsp;&nbsp;&nbsp;&nbsp;<B>__SITE</B> : 사이트명</td>
													</tr>
												</table>
											</td>
										</tr>
										<tr>
											<td>&nbsp;</td>
										</tr>
										<tr>
											<td>
												<table width="750" border="0" cellspacing="1" cellpadding="0" bgcolor="cdcdcd">
													<tr>
														<td bgcolor="f2f2f2" height="30"> <div align="center"> <input type="checkbox" name="bSend1" value="1" <?if($sms[bSend1]) echo"checked";?>>회원 전송 &nbsp;&nbsp;<font color="blue">현재 글자 수 </font><font color="104E89"><input type="text" name="msglen1" class="nonbox" readonly value="<?=strlen($sms[msg1])?>" size="2"><input type="text" name="whole" class="nonbox" value="/ 80" readonly size="2" style="width:30;"></font></div></td>
														<td bgcolor="f2f2f2"> <div align="center"> <input type="checkbox" name="bSend2" value="1" <?if($sms[bSend2]) echo"checked";?>>관리자 전송 &nbsp;&nbsp;<font color="blue">현재 글자 수 </font><font color="104E89"><input type="text" name="msglen2" class="nonbox" readonly value="<?=strlen($sms[msg2])?>" size="2"><input type="text" name="whole2" class="nonbox" value="/ 80" readonly size="2" style="width:30;"></font></div></td>
													</tr>
													<tr bgcolor="#FFFFFF">
														<td height="30"> <div align="center"> <textarea name="msg1" rows="6" cols="40" onKeyUp="javascript:checklen(this.form,this.name,1);"><?=$sms[msg1]?></textarea></div></td>
														<td> <div align="center"> <textarea name="msg2" rows="6" cols="40" onKeyUp="javascript:checklen(this.form,this.name,2);"><?=$sms[msg2]?></textarea></div></td>
													</tr>
												</table>
											</td>
										</tr>
										<tr>
											<td height="30"> <div align="center"><a href="javascript:smsSendit(2);"><img src="image/save_btn.gif" width="40" height="17" border="0"></a></div></td>
										</tr>
									</table>
								</td>
							</tr>
							<tr>
								<td>
									<table width="750" border="0" cellspacing="0" cellpadding="0" align="center">
										<tr>
											<td height="40"><img src="image/design_main_icon.gif" width="21" height="11"> 상품구매</td>
										</tr>
										<tr>
											<td>
												<table width="750" border="0" cellspacing="1" cellpadding="10" bgcolor="cdcdcd">
													<tr>
														<td bgcolor="f4f4f4"><B>__WRITEDAY</B> : 구매날짜&nbsp;&nbsp;&nbsp;&nbsp;<B>__NAME</B> : 주문자명&nbsp;&nbsp;&nbsp;&nbsp;<B>__GOODS</B> : 상품명&nbsp;&nbsp;&nbsp;&nbsp;<B>__TRADECODE</B> : 주문코드<BR><B>__PAYMETHOD</B> : 결제방법&nbsp;&nbsp;&nbsp;&nbsp;<B>__PRICE</B> : 결제금액&nbsp;&nbsp;&nbsp;&nbsp;<B>__CNT</B> : 수량&nbsp;&nbsp;&nbsp;&nbsp;<B>__SITE</B> : 사이트명</td>
													</tr>
												</table>
											</td>
										</tr>
										<tr>
											<td>&nbsp;</td>
										</tr>
										<tr>
											<td>
												<table width="750" border="0" cellspacing="1" cellpadding="0" bgcolor="cdcdcd">
													<tr>
														<td bgcolor="f2f2f2" height="30"> <div align="center"> <input type="checkbox" name="bSend3" value="1" <?if($sms[bSend3]) echo"checked";?>>회원 전송&nbsp;&nbsp;<font color="blue">현재 글자 수 </font><font color="104E89"><input type="text" name="msglen3" class="nonbox" readonly value="<?=strlen($sms[msg3])?>" size="2"><input type="text" name="whole" class="nonbox" value="/ 80" readonly size="2" style="width:30;"></font></div></td>
														<td bgcolor="f2f2f2"> <div align="center"> <input type="checkbox" name="bSend4" value="1" <?if($sms[bSend4]) echo"checked";?>>관리자 전송&nbsp;&nbsp;<font color="blue">현재 글자 수 </font><font color="104E89"><input type="text" name="msglen4" class="nonbox" readonly value="<?=strlen($sms[msg4])?>" size="2"><input type="text" name="whole" class="nonbox" value="/ 80" readonly size="2" style="width:30;"></font></div></td>
													</tr>
													<tr bgcolor="#FFFFFF">
														<td height="30"> <div align="center"> <textarea name="msg3" rows="6" cols="40" onKeyUp="javascript:checklen(this.form,this.name,3);"><?=$sms[msg3]?></textarea></div></td>
														<td> <div align="center"> <textarea name="msg4" rows="6" cols="40" onKeyUp="javascript:checklen(this.form,this.name,4);"><?=$sms[msg4]?></textarea></div></td>
													</tr>
												</table>
											</td>
										</tr>
										<tr>
											<td height="30"> <div align="center"><a href="javascript:smsSendit(3);"><img src="image/save_btn.gif" width="40" height="17" border="0"></a></div></td>
										</tr>
									</table>
								</td>
							</tr>
							<tr>
								<td>
									<table width="750" border="0" cellspacing="0" cellpadding="0" align="center">
										<tr>
											<td height="40"><img src="image/design_main_icon.gif" width="21" height="11">상품배송</td>
										</tr>
										<tr>
											<td>
												<table width="750" border="0" cellspacing="1" cellpadding="10" bgcolor="cdcdcd">
													<tr>
														<td bgcolor="f4f4f4"><B>__SITE</B> : 사이트명&nbsp;&nbsp;&nbsp;&nbsp;<B>__NAME</B> : 주문자명&nbsp;&nbsp;&nbsp;&nbsp;<B>__GOODS</B> : 상품명&nbsp;&nbsp;&nbsp;&nbsp;<B>__TRANSNUM</B> : 송장번호&nbsp;&nbsp;&nbsp;&nbsp;<B>__SENDDAY</B> : 배송일</td>
													</tr>
												</table>
											</td>
										</tr>
										<tr>
											<td>&nbsp;</td>
										</tr>
										<tr>
											<td>
												<table width="750" border="0" cellspacing="1" cellpadding="0" bgcolor="cdcdcd">
													<tr>
														<td bgcolor="f2f2f2" height="30"> <div align="center"> <input type="checkbox" name="bSend5" value="1" <?if($sms[bSend5]) echo"checked";?>>회원 전송&nbsp;&nbsp;<font color="blue">현재 글자 수 </font><font color="104E89"><input type="text" name="msglen5" class="nonbox" readonly value="<?=strlen($sms[msg5])?>" size="2"><input type="text" name="whole" class="nonbox" value="/ 80" readonly size="2" style="width:30;"></font></div></td>
														<td bgcolor="f2f2f2"> <div align="center"> </div></td>
													</tr>
													<tr bgcolor="#FFFFFF">
														<td height="30"> <div align="center"> <textarea name="msg5" rows="6" cols="40" onKeyUp="javascript:checklen(this.form,this.name,5);"><?=$sms[msg5]?></textarea></div></td>
														<td width="50%"> <div align="center"> </div></td>
													</tr>
												</table>
											</td>
										</tr>
										<tr>
											<td height="30"> <div align="center"><a href="javascript:smsSendit(4);"><img src="image/save_btn.gif" width="40" height="17" border="0"></a></div></td>
										</tr>
									</table>
								</td>
							</tr>
							<tr>
								<td>
									<table width="750" border="0" cellspacing="0" cellpadding="0" align="center">
										<tr>
											<td height="40"><img src="image/design_main_icon.gif" width="21" height="11">주문취소</td>
										</tr>
										<tr>
											<td>
												<table width="750" border="0" cellspacing="1" cellpadding="10" bgcolor="cdcdcd">
													<tr>
														<td bgcolor="f4f4f4"><B>__SITE</B> : 사이트명&nbsp;&nbsp;&nbsp;&nbsp;<B>__NAME</B> : 주문자명&nbsp;&nbsp;&nbsp;&nbsp;<B>__GOODS</B> : 상품명&nbsp;&nbsp;&nbsp;&nbsp;<B>__PAYMETHOD</B> : 결제방법&nbsp;&nbsp;&nbsp;&nbsp;</td>
													</tr>
												</table>
											</td>
										</tr>
										<tr>
											<td>&nbsp;</td>
										</tr>
										<tr>
											<td>
												<table width="750" border="0" cellspacing="1" cellpadding="0" bgcolor="cdcdcd">
													<tr>
														<td bgcolor="f2f2f2" height="30"> <div align="center"> <input type="checkbox" name="bSend8" value="1" <?if($sms[bSend8]) echo"checked";?>>고객 전송&nbsp;&nbsp;<font color="blue">현재 글자 수 </font><font color="104E89"><input type="text" name="msglen8" class="nonbox" readonly value="<?=strlen($sms[msg8])?>" size="2"><input type="text" name="whole" class="nonbox" value="/ 80" readonly size="2" style="width:30;"></font></div></td>
														<td bgcolor="f2f2f2"> <div align="center"> </div></td>
													</tr>
													<tr bgcolor="#FFFFFF">
														<td height="30"> <div align="center"> <textarea name="msg8" rows="6" cols="40" onKeyUp="javascript:checklen(this.form,this.name,8);"><?=$sms[msg8]?></textarea></div></td>
														<td width="50%"> <div align="center"> </div></td>
													</tr>
												</table>
											</td>
										</tr>
										<tr>
											<td height="30"> <div align="center"><a href="javascript:smsSendit(6);"><img src="image/save_btn.gif" width="40" height="17" border="0"></a></div></td>
										</tr>
									</table>
								</td>
							</tr>
							<tr>
								<td>&nbsp;</td>
							</tr>
						</table></form>
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>
<? include "copy.php";?>
</body>
</html>