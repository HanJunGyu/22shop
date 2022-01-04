<?
include "head.php";
?>
<SCRIPT LANGUAGE="JavaScript">
<!--
var arr=new Array();
//답변 추가
function answerAdd()
{
	var form=document.pollForm;
	var addStr = form.answer_str.value;  //추가답변 문자열
	if(addStr =="")
	{
		alert("답변을 입력해 주십시오.");
		form.answer_str.focus();
	}
	else if(arr.length >= <?=__POLL_ANSWER_CNT?>)	//답변 개수 제한
		alert("답변등록은 <?=__POLL_ANSWER_CNT?> 개 까지만 가능합니다.");
	else
	{
		addArray(arr,addStr);		//배열추가
		showAnswer();				//답변목록 보기
		form.answer_str.value ="";
		form.answer_str.focus();
	}
}
//답변 삭제
function answerDel()
{
	var form=document.pollForm;
	var returnSize=0;						//삭제후 배열길이
	delIndex =form.answer.selectedIndex;	//삭제 인덱스
	returnSize=delArray(arr,delIndex);		//삭제
	arr=arr.slice(0,returnSize);			//삭제후 배열 리메이크
	showAnswer();							//답변 목록 보기
}
//답변 목록 보기
function showAnswer()
{
	var form= document.pollForm;
	for ( i = form.answer.length-1 ; i > -1 ; i--)
	{
		//option 삭제
		form.answer.options[i].value = null; 
		form.answer.options[i] = null; 
	}
	for(i=0;i<arr.length;i++)
	{
		//option 추가
		form.answer.options[i] = new Option(arr[i],1);
		form.answer.options[i].value = arr[i];
	}
}
//엔터키 체크
function answerChek(aEvent)
{
	var myEvent = aEvent ? aEvent : window.event;
	if(myEvent.keyCode==13) answerAdd();
}
//설문조사 전송
function pollSendit()
{
	var form=document.pollForm;
	if(form.title.value=="")
	{
		alert("질문을 입력해 주십시오.");
		form.title.focus();
	}
	else if(arr.length < 2)
	{
		alert("둘 이상의 답변을 입력해 주십시오.");
		form.answer_str.focus();
	}
	else
	{
		form.answer_string.value= arr.join("「「");
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
	$now = date("Y-m-d",time());
	$now_arr = explode("-",$now);
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
								<td bgcolor="#E6E6E6" height='26'><div align='right'><font class='text1'>SHOP 기본정보를 수정하실수 있습니다.&nbsp;</div></td>
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
								<td width='440'><img src="image/poll_write.gif"></td>
							</tr>
							<tr>
								<td width='1' bgcolor='dadada' colspan='3'></td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td valign="top">
						<form name="pollForm" method="post" action="poll_ok.php" enctype="multipart/form-data" >
						<input type="hidden" name="answer_string"><!-- 답변 문자열 ex)예「「아니오「「기타 -->
						<table width="750" border="0" cellspacing="0" cellpadding="0" align="center">
							<tr valign="middle">
								<td width="103" height="25" bgcolor="#FAFAFA"> <div align="left">&nbsp;&nbsp;<img src="image/icon.gif" width="11" height="11"> 시작일</div></td>
								<td width="447" height="25">
									<table width="432" border="0" align="center">
										<tr>
											<td width="30" bgcolor="#F6F6F6"> <div align="center">년도</div></td>
											<td width="50"> <select class="box" name="syday"><?
											for($i=$now_arr[0];$i<$now_arr[0]+5;$i++)
											{
												?><option value="<?=$i?>"><?=$i?></option><?
											}
											?></select></td>
											<td width="24" bgcolor="#F6F6F6"> <div align="center">월</div></td>
											<td width="40"> <select class="box" name="smday"><?
											for($i=1;$i<13;$i++)
											{
												if($i<10) $i="0".$i;
												?><option value="<?=$i?>"><?=$i?></option><?
											}
											?></select></td>
											<td width="24" bgcolor="#F6F6F6"> <div align="center">일</div></td>
											<td width="40"> <select class="box" name="sdday"><?
											for($i=1;$i<32;$i++)
											{
												if($i<10) $i="0".$i;
												?><option value="<?=$i?>"><?=$i?></option><?
											}
											?></select></td>
											<td>&nbsp;</td>
										</tr>
									</table>
								</td>
							</tr>
							<tr>
								<td colspan="2" height="1" background="image/line_bg1.gif"></td>
							</tr>
							<tr valign="middle">
								<td width="103" height="25" bgcolor="#FAFAFA"> <div align="left">&nbsp;&nbsp;<img src="image/icon.gif" width="11" height="11"> 종료일</div></td>
								<td width="447" height="25">
									<table width="432" border="0" align="center">
										<tr>
											<td width="30" bgcolor="#F6F6F6"> <div align="center">년도</div></td>
											<td width="50"> <select class="box" name="eyday"><?
											for($i=$now_arr[0];$i<$now_arr[0]+5;$i++)
											{
												?><option value="<?=$i?>"><?=$i?></option><?
											}
											?></select></td>
											<td width="24" bgcolor="#F6F6F6"> <div align="center">월</div></td>
											<td width="40"> <select class="box" name="emday"><?
											for($i=1;$i<13;$i++)
											{
												if($i<10) $i="0".$i;
												?><option value="<?=$i?>"><?=$i?></option><?
											}
											?></select></td>
											<td width="24" bgcolor="#F6F6F6"> <div align="center">일</div></td>
											<td width="40"> <select class="box" name="edday"><?
											for($i=1;$i<32;$i++)
											{
												if($i<10) $i="0".$i;
												?><option value="<?=$i?>"><?=$i?></option><?
											}
											?></select></td>
											<td>&nbsp;</td>
										</tr>
									</table>
								</td>
							</tr>
							<tr>
								<td colspan="2" height="1" background="image/line_bg1.gif"></td>
							</tr>
							<tr valign="middle">
								<td width="103" height="30" bgcolor="#FAFAFA"> <div align="left">&nbsp;&nbsp;<img src="image/icon.gif" width="11" height="11"> 구 분</div></td>
								<td width="447" height="30"> &nbsp;&nbsp; <select name="gubun" class="box"><option value="">▶전체</option><option value="M">회원,비회원</option><option value="D">거래처</option></select></td>
							</tr>
							<tr>
								<td colspan="2" height="1" background="image/line_bg1.gif"></td>
							</tr>
							<tr>
								<td width="103" height="25" bgcolor="#FAFAFA">&nbsp;&nbsp;<img src="image/icon.gif" width="11" height="11"> 질 문</td>
								<td width="447" height="25"> &nbsp;&nbsp; <input class="box"name="title" type="text" id="sday" size="50"></td>
							</tr>
							<tr>
								<td colspan="2" height="1" background="image/line_bg1.gif"></td>
							</tr>
							<tr>
								<td width="103" height="25" bgcolor="#FAFAFA">&nbsp;&nbsp;<img src="image/icon.gif" width="11" height="11"> 답변목록</td>
								<td width="447" height="25"> &nbsp;&nbsp; <select name="answer" size="10"  style="width:310;" ondblclick="javascript:answerDel();"></select> <a href="javascript:answerDel();"><img src="image/good_position_delete.gif" border="0"></a></td>
							</tr>
							<tr>
								<td width="103" height="25" bgcolor="#FAFAFA">&nbsp;&nbsp;<img src="image/icon.gif" width="11" height="11"> 답변추가</td>
								<td width="447" height="25"> &nbsp;&nbsp; <input class="box"name="answer_str" type="text" id="AnswerAdd" size="50" onkeypress="answerChek(event)"> <a href="javascript:answerAdd();"><img src="image/poll_add.gif" width="41" height="23" border="0"></a> </td>
							</tr>
							<tr>
								<td colspan="2" height="1" background="image/line_bg1.gif"></td>
							</tr>
							<tr>
								<td width="103" height="25" bgcolor="#FAFAFA">&nbsp;&nbsp;<img src="image/icon.gif" width="11" height="11"> 복수응답</td>
								<td width="447" height="25"> &nbsp;&nbsp;&nbsp; <select class="box" name="bPlu"><?
								for($i=1;$i<11;$i++)
								{
									?><option value="<?=$i?>"><?=$i?></option><?
								}
								?></select></td>
							</tr>
							<tr>
								<td colspan="2" height="1" background="image/line_bg1.gif"></td>
							</tr>
							<tr>
								<td width="103" bgcolor="#FAFAFA">&nbsp;&nbsp;<img src="image/icon.gif" width="11" height="11"> 답변 가능자</td>
								<td height="25"> &nbsp;&nbsp;&nbsp; <select class="box" name="reCan"><option selected value="1">회원, 비회원</option><option value="2">회원전용</option></select>&nbsp;&nbsp;</td>
							</tr>
							<tr>
								<td colspan="2" height="1" background="image/line_bg1.gif"></td>
							</tr>
							<tr>
								<td colspan="2" height="30">
									<table width="100" border="0" align="center">
										<tr>
											<td width="70"><a href="javascript:pollSendit();"><img src="image/entry_btn.gif" width="57" height="17" border="0"></a></td>
											<td width="20">&nbsp;</td>
										</tr>
									</table>
								</td>
							</tr>
						</table></form><!-- pollForm --><br>
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>
<? include "copy.php";?>
</body>
</html>