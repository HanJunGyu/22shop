<?
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
?>
<SCRIPT LANGUAGE="JavaScript">
<!--
//파업창 사용여부 disabled 토글함수 
function showDay()
{
	var form=document.writeForm;
	if(form.bPopup[0].checked)
	{
		//활성
		showObject(form.sday,true);		//시작일
		showObject(form.eday,true);		//종료일
	}
	else
	{
		//비활성
		showObject(form.sday,false);
		showObject(form.eday,false);
	}
}
//공지사항 등록 
function noticeWriteSendit()
{
	var form=document.writeForm;
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
	var bPopup = form.bPopup[0].checked; //팝업창 사용
	if(form.title.value=="")
	{
		alert("제목을 입력해 주십시오.");
		form.title.focus();
	}
	else if(bPopup && form.sday.value=="")
	{
		alert("팝업 시작일을 입력해 주십시오.");
		form.sday.focus();
	}
	else if(bPopup && form.sday.value.length !=8)
	{
		alert("팝업 시작일이 올바르지 않습니다.");
		form.sday.focus();
	}
	else if(bPopup && form.eday.value=="")
	{
		alert("팝업 종료일을 입력해 주십시오.");
		form.eday.focus();
	}
	else if(bPopup && form.eday.value.length !=8)
	{
		alert("팝업 종료일이 올바르지 않습니다.");
		form.eday.focus();
	}
	else if(bPopup && form.width.value=="")
	{
		alert("팝업창 가로크기를 입력해 주십시오.");
		form.width.focus();
	}
	else if(bPopup && form.height.value=="")
	{
		alert("팝업창 세로크기를 입력해 주십시오.");
		form.height.focus();
	}
	else
	{
		/******* disabled 된 변수 재설정  : disabled 변수는 isset()에서 'false' return  *******/
		form.str_sday.value			=form.sday.value;		//시작일
		form.str_eday.value			=form.eday.value;		//종료일
		form.str_width.value		=form.width.value;		//가로크기
		form.str_height.value		=form.height.value;		//세로크기
		/***********************************************************************************/
		form.submit();
	}
}
//-->
</SCRIPT>
<body bgcolor="#FFFFFF" text="#5A595A" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<? include "top_menu.php"; ?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr><?
	$__TOP_MENU = "news";     //왼쪽 소메뉴 설정 변수
	include "left_menu.php";
	$this_code	= time();	  // 공지사항 코드값 ex) 183456789
	?>
		<td width="85%" valign="top" height="400">
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td height='5'></td>
				</tr>
				<tr>
					<td>
						<table width="750" border="0" cellspacing="0" cellpadding="0" align='center'>
							<tr>
								<td rowspan="3" width="200"><img src="image/notice_tit.gif"></td>
								<td>&nbsp;</td>
							</tr>
							<tr>
								<td bgcolor="#E6E6E6" height='26'><div align='right'><font class='text1'>SHOP 공지사항, 이벤트, 설문조사를 수정하실수 있습니다.&nbsp;</div></td>
							</tr>
							<tr>
								<td>&nbsp;</td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td height="2">
						<table width="750" border="0" cellspacing="0" cellpadding="0" align="center">
							<tr>
								<td bgcolor='DADADA' height='1'></td>
							</tr>
							<tr>
								<td>
									<table width="750" border="0" cellspacing="0" cellpadding="0" align="center">
										<tr>
											<td width='440'><img src="image/<?=$part?>_write_tit.gif"></td>
										</tr>
									</table>
								</td>
							</tr>
							<tr>
								<td bgcolor='DADADA' height='1'></td>
							</tr>
							<tr>
								<td valign="top">
									<form name="writeForm" method="post" action="notice_write_ok.php" enctype="multipart/form-data" >
									<input type="hidden" name="part" value="<?=$part?>"><!-- ex) notice,event -->
									<input type="hidden" name="code" value="<?=$this_code?>"><!-- ex) 18345689 -->
									<!-- 이하 disabled 변수값 재설정 -->
									<input type="hidden" name="str_sday">
									<input type="hidden" name="str_eday">
									<input type="hidden" name="str_width">
									<input type="hidden" name="str_height">
									<!-- 이상 disabled 변수값 재설정 -->
									<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center" height="420">
										<tr>
											<td colspan="2" height="10"></td>
										</tr>
										<tr valign="middle">
											<td width="150" height="30" bgcolor="#FAFAFA"> <div align="left">&nbsp;&nbsp;<img src="image/icon.gif" width="11" height="11"> 코 드</div></td>
											<td width="540" height="30"> &nbsp;&nbsp; <FONT  COLOR="#6600CC"><?=$this_code?></FONT></td>
										</tr>
										<tr>
											<td colspan="2" height="1" background="image/line_bg1.gif"></td>
										</tr>
										<tr valign="middle">
											<td width="153" height="30" bgcolor="#FAFAFA"> <div align="left">&nbsp;&nbsp;<img src="image/icon.gif" width="11" height="11"> 구 분</div></td>
											<td width="447" height="30"> &nbsp;&nbsp; <select name="gubun" class="box"><option value="">▶전체</option><option value="M">회원,비회원</option><option value="D">도매회원</option></select></td>
										</tr>
										<tr>
											<td colspan="2" height="1" background="image/line_bg1.gif"></td>
										</tr>
										<tr valign="middle">
											<td width="183" height="30" bgcolor="#FAFAFA"> <div align="left">&nbsp;&nbsp;<img src="image/icon.gif" width="11" height="11"> 제 목</div></td>
											<td width="540" height="30"> &nbsp;&nbsp; <input class="box"name="title" type="text" id="title" size="55"></td>
										</tr>
										<tr>
											<td colspan="2" height="1" background="image/line_bg1.gif"></td>
										</tr>
										<tr valign="middle">
											<td width="183" height="30" bgcolor="#FAFAFA"> <div align="left">&nbsp;&nbsp;<img src="image/icon.gif" width="11" height="11"> 팝업창 사용</div></td>
											<td width="540" height="30">
												<table width="251" border="0" cellspacing="0" cellpadding="0" align="left">
													<tr>
														<td width="10%"> <div align="center"> <input class="radio"type="radio" value="y" name="bPopup" onclick="javascript:showDay();"></div></td>
														<td width="25%"> <div align="left">사용함</div></td>
														<td width="10%"> <div align="center"> <input class="radio"type="radio" value="n" name="bPopup" checked onclick="javascript:showDay();"></div></td>
														<td width="25%"> <div align="left">사용하지 않음</div></td>
													</tr>
												</table>
											</td>
										</tr>
										<tr>
											<td colspan="2" height="1" background="image/line_bg1.gif"></td>
										</tr>
										<tr>
											<td width="183" height="30" bgcolor="#FAFAFA">&nbsp;&nbsp;<img src="image/icon.gif" width="11" height="11"> 팝업 시작일</td>
											<td width="540" height="25"> &nbsp;&nbsp; <input class="box"name="sday" type="text" id="sday" size="8" maxlength="8" <?=__ONLY_NUM?> style="background-color:#dddddd;" disabled><font color="#0099CC">(예 20030101)</font></td>
										</tr>
										<tr>
											<td colspan="2" height="1" background="image/line_bg1.gif"></td>
										</tr>
										<tr>
											<td width="183" height="30" bgcolor="#FAFAFA">&nbsp;&nbsp;<img src="image/icon.gif" width="11" height="11"> 팝업 종료일</td>
											<td width="540" height="25"> &nbsp;&nbsp; <input class="box"name="eday" type="text" id="eday" size="8" maxlength="8" <?=__ONLY_NUM?> style="background-color:#dddddd;" disabled> <font color="#0099CC">(예 20030131) </font></td>
										</tr>
										<tr>
											<td colspan="2" height="1" background="image/line_bg1.gif"></td>
										</tr>
										<tr valign="middle">
											<td width="153" height="30" bgcolor="#FAFAFA"> <div align="left">&nbsp;&nbsp;<img src="image/icon.gif" width="11" height="11"> 팝업창 기본틀 사용</div></td>
											<td width="447" height="25">
												<table width="251" border="0" cellspacing="0" cellpadding="0" align="left">
													<tr>
														<td width="10%"> <div align="center"> <input class="radio"type="radio" value="y" name="bBasicimg" checked></div></td>
														<td width="25%"> <div align="left">사용함</div></td>
														<td width="10%"> <div align="center"> <input class="radio"type="radio" value="n" name="bBasicimg"></div></td>
														<td width="25%"> <div align="left">사용하지 않음</div></td>
													</tr>
													<tr>
														<td colspan=4><font class="help">&nbsp;※ HTML을 사용하지 않는경우 고정틀 사용</font></td>
													</tr>
												</table>
											</td>
										</tr>
										<tr>
											<td colspan="2" height="1" background="image/line_bg1.gif"></td>
										</tr>
										<tr>
											<td width="183" rowspan="3" bgcolor="#FAFAFA">&nbsp;&nbsp;<img src="image/icon.gif" width="11" height="11"> 팝업창 크기</td>
											<td width="540" height="25"> &nbsp;&nbsp;<font color="#0099CC"> 가로크기</font> &nbsp; <input class="box"name="width" type="text" id="width" size="10" <?=__ONLY_NUM?>   value="520"> px</td>
										</tr>
										<tr>
											<td height="1" background="image/line_bg1.gif"></td>
										</tr>
										<tr>
											<td width="540" height="25"> &nbsp;&nbsp; <font color="#0099CC">세로크기</font> &nbsp; <input class="box"name="height" type="text" id="height" size="10" <?=__ONLY_NUM?>   value="470"> px</td>
										</tr>
										<tr>
											<td height="1" colspan="2" background="image/line_bg1.gif"></td>
										</tr>
										<tr>
											<td width="183" height="30" bgcolor="#FAFAFA">&nbsp;&nbsp;<img src="image/icon.gif" width="11" height="11"> 내용 형식</td>
											<td width="540" height="25"> &nbsp;&nbsp; <INPUT TYPE="radio" NAME="bHtml" value='1' onclick="document.getElementById('nsText').style.display='block';document.getElementById('nsHtml').style.display='none';document.getElementById('nsEdit').style.display='none';">TEXT &nbsp; <INPUT TYPE="radio" NAME="bHtml" value='2' <?=$Os_Check?"":"checked"?> onclick="document.getElementById('nsText').style.display='none';document.getElementById('nsHtml').style.display='block';document.getElementById('nsEdit').style.display='none';">HTML &nbsp; <INPUT TYPE="radio" NAME="bHtml" value='0' <?=$Os_Check?"checked":""?> onclick="document.getElementById('nsText').style.display='none';document.getElementById('nsHtml').style.display='none';document.getElementById('nsEdit').style.display='block';" <?= $Use_Check?>>웹에디터</td>
										</tr>
										<tr>
											<td colspan="2" height="1" background="image/line_bg1.gif"></td>
										</tr>
										<tr>
											<td width="183" height="20" bgcolor="#FAFAFA">&nbsp;&nbsp;<img src="image/icon.gif" width="11" height="11"> 내용</td>
											<td width="540" height="20" align="left">
												<table width="540" cellpadding="0" cellspacing="0" border="0" id='nsText' style='display:none'>
													<tr>
														<td><textarea name="TextContent" style="width:100%" rows="20" cols="80"></textarea></td>
													</tr>
												</table>
												<table width="540" cellpadding="0" cellspacing="0" border="0" id='nsHtml' style='display:<?=$Os_Check?"none":"block"?>'>
													<tr>
														<td><textarea name="HtmlContent" style="width:100%" rows="20" cols="80"></textarea></td>
													</tr>
												</table>
												<table width="540" cellpadding="0" cellspacing="0" border="0" id='nsEdit' style='display:<?=$Os_Check?"block":"none"?>'>
													<tr>
														<td width='540'><?
														$form_name = "writeForm";
														$dir_path = "..";
														include "../editor.php";
														?><textarea style="display:none" class="text" name="content" cols="90" rows="14"></textarea></td>
													</tr>
												</table><br><br>
											</td>
										</tr>
										<tr>
											<td width="720" height="20" align="left" colspan="2">
												<table width="200" border="0" align="center">
													<tr>
														<td><div align="center"><a href="javascript:noticeWriteSendit();"><img src="image/ok_btn.gif" width="40" height="17" border="0"></a></div></td>
														<td><div align="center"><a href="notice_list.php?part=<?=$part?>"><img src="image/cancel_btn.gif" width="40" height="17" border="0"></a></div></td>
													</tr>
												</table><br>
											</td>
										</tr>
										<tr>
											<td colspan="2" height="1" background="image/line_bg1.gif"></td>
										</tr></form><!-- writeForm -->
									</table>
								</td>
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