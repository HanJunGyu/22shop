<?
include "head.php";
$dataArr = Decode64($data);
$view_row = $MySQL->fetch_array("select *from bbs_data where idx=$dataArr[idx]"); //게시판 정보
?>
<SCRIPT LANGUAGE="JavaScript">
<!--
function bbsSendit()
{
	var form=document.bbsForm;
	if(form.title.value=="")
	{
		alert("제목을 입력해 주십시오.");
		form.title.focus();
	}
	else if(form.name.value=="")
	{
		alert("이름을 입력해 주십시오.");
		form.name.focus();
	}
	else if(filehanCheck(form.up_file.value))
	{
		alert("첨부파일은 영문명으로 등록해 주십시오.");
		form.up_file.focus();
	}
	else
	{
		form.submit();
	}
}
//-->
</SCRIPT>
<body bgcolor="#FFFFFF" text="#000000" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<? include "top_menu.php"; ?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr><?
	$__TOP_MENU = "ask";     //왼쪽 소메뉴 설정 변수
	include "left_menu.php";
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
								<td rowspan="3" width="200"><img src="image/ask_tit_l.gif"></td>
								<td>&nbsp;</td>
							</tr>
							<tr>
								<td bgcolor="#E6E6E6" height='26'><div align='right'><font class='text1'>SHOP 1:1문의게시판 등록 수정 하실수 있습니다.&nbsp;</div></td>
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
								<td width='440'><img src="image/ask_tit3.gif"></td>
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
					<td align="left" height="30">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<B><?=$bbs_admin_row[name]?></B></td>
				</tr>
				<tr>
					<td valign="top">
						<table width="750" border="0" align="center" bgcolor="#EBEBEB" cellpadding="0" cellspacing="1" >
							<tr>
								<td>
									<form name="bbsForm" method="post" action="ask_edit_ok.php" enctype="multipart/form-data" >
									<input type="hidden" name="data" value="<?=$data?>"><!-- 답변형게시판 현재글 정보 -->
									<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center" height="420" bgcolor="#FFFFFF">
										<tr valign="middle">
											<td width="80" height="30" bgcolor="#FAFAFA"> <div align="left">&nbsp;&nbsp;<img src="image/icon.gif" width="11" height="11"> 제 목</div></td>
											<td width="427" height="30">&nbsp;&nbsp;<input class="box" type="text" name="title" size="50" value="<?=$view_row[title]?>"></td>
										</tr>
										<tr>
											<td colspan="2" height="1" background="image/line_bg1.gif"></td>
										</tr>
										<tr valign="middle">
											<td width="80" height="30" bgcolor="#FAFAFA"> <div align="left">&nbsp;&nbsp;<img src="image/icon.gif" width="11" height="11"> 이 름</div></td>
											<td width="427" height="30">&nbsp;&nbsp;<input class="box" type="text" name="name" size="20" value="<?=$view_row[name]?>"></td>
										</tr>
										<tr>
											<td colspan="2" height="1" background="image/line_bg1.gif"></td>
										</tr>
										<tr>
											<td width="80" height="30" bgcolor="#FAFAFA">&nbsp;&nbsp;<img src="image/icon.gif" width="11" height="11"> 이메일</td>
											<td width="427" height="30">&nbsp;&nbsp;<input class="box" type="text" name="email" size="30" value="<?=$view_row[email]?>"></td>
										</tr>
										<tr>
											<td colspan="2" height="1" background="image/line_bg1.gif"></td>
										</tr>
										<tr bgcolor="#FAFAFA">
											<td colspan="2" height="30"> <div align="left">&nbsp;&nbsp;<img src="image/icon.gif" width="11" height="11"> 내 용</div></td>
										</tr>
										<tr>
											<td colspan="2" height="1" background="image/line_bg1.gif"></td>
										</tr>
										<tr>
											<td colspan="2" height="180"> <div align="center"><textarea  name="content" cols="82" rows="10" wrap="hard" class="text"><?=stripslashes($view_row[content])?></textarea></div></td>
										</tr>
										<tr>
											<td colspan="2" height="1" background="image/line_bg1.gif"></td>
										</tr><?
										if(!empty($view_row[up_file]))
										{
											?><!-- 첨부파일 존재 -->
										<tr>
											<td width="80" height="30" bgcolor="#FAFAFA">&nbsp;&nbsp;<img src="image/icon.gif" width="11" height="11"> 첨부파일</td>
											<td width="427" height="30">&nbsp;&nbsp;<img src="image/s_file.gif" border="0"> <a href="../upload/bbs/<?=$view_row[up_file]?>"><?=$view_row[up_file]?></a></td>
										</tr>
										<tr>
											<td colspan="2" height="1" background="image/line_bg1.gif"></td>
										</tr><?
										}
										?>
										<tr>
											<td width="80" height="30" bgcolor="#FAFAFA">&nbsp;&nbsp;<img src="image/icon.gif" width="11" height="11"> 파일첨부</td>
											<td width="427" height="30"> &nbsp;&nbsp;<input class="box" type="file" name="up_file"></td>
										</tr>
										<tr>
											<td colspan="2" height="1" background="image/line_bg1.gif"></td>
										</tr>
										<tr>
											<td colspan="2" height="20">
												<table width="30%" border="0" bgcolor="#FFFFFF" height="50" align="center">
													<tr bgcolor="#FFFFFF">
														<td width="87"><a href="javascript:bbsSendit();"><img src="image/bbs_ok_btn.gif" width="41" height="23" border="0"></a></td>
														<td width="87"><a href="javascript:formClear(document.bbsForm);"><img src="image/bbs_cancel_btn.gif" width="41" height="23" border="0"></a></td>
														<td width="10"><a href="ask.php?data=<?=$data?>"><img src="image/bbs_list_btn.gif" width="41" height="23" border="0"></a></td>
													</tr>
												</table>
											</td>
										</tr>
									</table></form><!-- bbsForm -->
								</td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>
<? include "copy.php"; ?>
</body>
</html>