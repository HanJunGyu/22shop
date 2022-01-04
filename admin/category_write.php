<?
include "head.php";
$this_code = time();
?>
<SCRIPT LANGUAGE="JavaScript">
<!--
//대분류 입력
function cateSendit()
{
	var form=document.cateForm;
	if(form.name.value =="")
	{
		alert("카테고리명을 입력해 주십시오.");
		form.name.focus();
		return false;
	}
	else if(filehanCheck(form.img1.value))
	{
		alert("이미지1 을 영문명으로 등록해 주십시오.");
		form.img1.focus();
		return false;
	}
	else if(filehanCheck(form.img2.value))
	{
		alert("이미지2 을 영문명으로 등록해 주십시오.");
		form.img2.focus();
		return false;
	}
	else if(filehanCheck(form.img3.value))
	{
		alert("이미지3 을 영문명으로 등록해 주십시오.");
		form.img3.focus();
		return false;
	}
	else
	{
		return true;
	}
}
//-->
</SCRIPT>
<body bgcolor="#FFFFFF" text="#5A595A" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<? include "top_menu.php"; ?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr><?
	$__TOP_MENU = "category";     //왼쪽 소메뉴 설정 변수
	include "left_menu.php";
	?>
		<td width="85%" valign="top" height="400">
			<table width="100%"  border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td height='5'></td>
				</tr>
				<tr>
					<td>
						<table width="750" border="0" cellspacing="0" cellpadding="0" align='center'>
							<tr>
								<td rowspan="3" width="200"><img src="image/cate_tit.gif"></td>
								<td>&nbsp;</td>
							</tr>
							<tr>
								<td bgcolor="#E6E6E6" height='26'><div align='right'><font class='text1'>SHOP 카테고리 수정 삭제 등록 등을 하실수 있습니다.&nbsp;</div></td>
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
								<td width='1' bgcolor='dadada'></td>
							</tr>
							<tr>
								<td><img src="image/cate_magic_tit.gif"></td>
							</tr>
							<tr>
								<td width='1' bgcolor='dadada'></td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
				</tr>
				<tr>
					<td valign="top">
						<table width="750" border="0" cellspacing="0" cellpadding="0" align="center" height="420">
							<tr>
								<td><div align='center'></div></td>
							</tr>
							<tr valign="middle">
								<td height="200" valign="top">
									<table width="90%" border="0" cellspacing="1" cellpadding="0" bgcolor="#CCCCCC" align="center">
										<tr>
											<td bgcolor="#FFFFFF">
												<form name="cateForm" method="post" action="category_write_ok.php?part=parent" enctype="multipart/form-data" onSubmit="return cateSendit();">
												<input type="hidden" name="code" value="<?=$this_code?>">
												<table width="98%" border="0" cellspacing="0" cellpadding="0" align="center">
													<tr>
														<td colspan="3" height="30" background="image/mem_data_bg.gif"><img src="image/cate_lag_tit.gif" width="90" height="20"></td>
													</tr>
													<tr>
														<td colspan="3" height="1" background="image/line_bg1.gif"></td>
													</tr>
													<tr>
														<td width="27%" height="30" bgcolor="#F5F5F5">&nbsp;<img src="image/icon.gif" width="11" height="11"> 코드</td>
														<td height="30" colspan="2"> &nbsp;&nbsp;<FONT  COLOR="#6600FF"><B><?=$this_code?></B></FONT></td>
													</tr>
													<tr>
														<td colspan="3" height="1" background="image/line_bg1.gif"></td>
													</tr>
													<tr>
														<td width="27%" height="30" bgcolor="#F5F5F5">&nbsp;<img src="image/icon.gif" width="11" height="11"> 분류명</td>
														<td height="30" colspan="2"> &nbsp;&nbsp; <input class="box" type="text" name="name" size="30"></td>
													</tr>
													<tr>
														<td colspan="3" height="1" background="image/line_bg1.gif"></td>
													</tr>
													<tr bgcolor="#E7E7E7">
														<td colspan="3" height="30"> <div align="center"><img src="image/icon.gif" width="11" height="11"> 분류 이미지&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<A href="#go1"><font color="#FF0000">(이미지 적용위치는 아래를 참고하세요)</font></a></div></td>
													</tr>
													<tr>
														<td width="27%" height="30" bgcolor="#F5F5F5"> <div align="center">이미지1</div></td>
														<td width="60%" height="30" valign="middle"> <input class="box" type="file" name="img1"> <BR><FONT COLOR="#993300">- 왼쪽 카테고리출력시 기본이미지 (170 x 30)</FONT> <br><font class="help">이미지 1,2의 세로사이즈는 <a href="design_c.php"><B>디자인관리 C</B></a> 에서 변경가능합니다.</font></td>
													</tr>
													<tr>
														<td width="27%" height="30" bgcolor="#F5F5F5"> <div align="center">이미지2</div></td>
														<td width="50%" height="30" valign="middle"> <input class="box" type="file" name="img2"> <BR><FONT COLOR="#993300">- 왼쪽 카테고리출력시 MOUSE OVER (170 x 30)</FONT></td>
														<td height="30" valign="middle" width="23%">&nbsp;</td>
													</tr>
													<tr>
														<td width="27%" height="30" bgcolor="#F5F5F5"> <div align="center">이미지3</div></td>
														<td width="50%" height="30" valign="middle"> <input class="box" type="file" name="img3"> <BR><FONT COLOR="#993300">- 상품목록내 카테고리 타이틀 (세로 53pixel)</FONT></td>
														<td height="30" valign="middle" width="23%">&nbsp;</td>
													</tr>
													<tr>
														<td width="27%" height="30" bgcolor="#F5F5F5"> <div align="center">이미지4</div></td>
														<td width="50%" height="30" valign="middle"> <input class="box" type="file" name="img4"> <BR><FONT COLOR="#993300">- 상품목록내 카테고리 이미지 (720 x 200)</FONT></td>
														<td height="30" valign="middle" width="23%">&nbsp;</td>
													</tr>
													<tr>
														<td colspan="3" height="45">
															<table width="200" border="0" align="center">
																<tr>
																	<td> <div align="center"><input type="image" src="image/entry_btn1.gif" width="40" height="17" border="0"></div></td>
																	<td> <div align="center"><a href="javascript:formClear(document.cateForm);"><img src="image/cancel_btn.gif" width="40" height="17" border="0"></a></div></td>
																</tr>
															</table>
														</td>
													</tr>
												</table></form><!-- cateForm -->
											</td>
										</tr>
									</table>
									<a name=go1> <br></a><br>
									<img src='image/design_good_view2.gif'></td>
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