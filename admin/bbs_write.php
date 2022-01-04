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
$bbs_admin_row = $MySQL->fetch_array("select *from bbs_list where code='$code'"); //게시판 정보
$dataArr=Decode64($data);
if($data)
{
	$bbs_qry="select *from bbs_data where idx=$dataArr[idx]";
	$bbs_row=$MySQL->fetch_array($bbs_qry);
}
?>
<SCRIPT LANGUAGE="JavaScript">
<!--
function bbsSendit()
{
	var form=document.bbsForm;
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
	<?if($bbs_admin_row[part]==30){?>
	attach1 = form.img1.value;
	dot1 = attach1.lastIndexOf(".");
	ext1 = attach1.substring(dot1);
	attach2 = form.img2.value;
	dot2 = attach2.lastIndexOf(".");
	ext2 = attach2.substring(dot2);
	<?}?>
	<?if($bbs_admin_row[part]==20){?>
	attach = form.up_file.value;
	dot = attach.lastIndexOf(".");
	ext = attach.substring(dot);
	<?}?>
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
	else if(form.pwd.value=="")
	{
		alert("비밀번호를 입력해 주십시오.");
		form.pwd.focus();
		<?if($bbs_admin_row[part]==20){?>
		attach = form.up_file.value;
		dot = attach.lastIndexOf(".");
		ext = attach.substring(dot);
	}
	else if(filehanCheck(form.up_file.value))
	{
		alert("첨부파일은 영문명으로 등록해 주십시오.");
		form.up_file.focus();
	}
	else if(filehanCheck(form.up_file.value))
	{
		alert("첨부파일은 영문명으로 등록해 주십시오.");
		form.up_file.focus();
	}
	else if (ext==".php" || ext==".PHP" || ext==".php3" || ext==".htm" || ext==".html" || ext==".HTM" || ext==".HTML")
	{
		alert("PHP,HTML 파일은 보안상 업로드할수 없습니다.");
		form.up_file.focus();
		<?}?>
		<?if($bbs_admin_row[part]==30){?>
	}
	else if (ext1==".php" || ext1==".PHP" || ext1==".php3" || ext1==".htm" || ext1==".html" || ext1==".HTM" || ext1==".HTML")
	{
		alert("PHP,HTML 파일은 보안상 업로드할수 없습니다.");
		form.img1.focus();
	}
	else if (ext2==".php" || ext2==".PHP" || ext2==".php3" || ext2==".htm" || ext2==".html" || ext2==".HTM" || ext2==".HTML")
	{
		alert("PHP,HTML 파일은 보안상 업로드할수 없습니다.");
		form.img2.focus();
	}
	else if(form.img1.value=="")
	{
		alert("이미지1을 입력해 주십시오.");
		form.title.focus();
	}
	else if(form.img1.value=="")
	{
		alert("이미지2를 입력해 주십시오.");
		form.title.focus();
	}
	else if(filehanCheck(form.img1.value))
	{
		alert("첨부파일은 영문명으로 등록해 주십시오.");
		form.img1.focus();
		<? } ?>
	}
	else
	{
		form.submit();
	}
}
//-->
</SCRIPT>
<body bgcolor="#FFFFFF" text="#5A595A" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<? include "top_menu.php"; ?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr><?
	$__TOP_MENU = "board";     //왼쪽 소메뉴 설정 변수
	include "left_menu.php";
	$actArr		= array("10" => "제한없음", "20" => "회원,관리자", "30" => "관리자");	//게시판 권한 배열
	$actKey		= array_keys($actArr);												//게시판 권한 배열 키값 ex) array("10","20","30")
	$partArr	= array("10" => "일반게시판", "20" => "자료실", "30" => "갤러리");		//게시판 유형 배열
	$partKey	= array_keys($partArr);												//게시판 유형 배열 키값 ex) array("10","20")
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
								<td rowspan="3" width="200"><img src="image/board_tit.gif"></td>
								<td>&nbsp;</td>
							</tr>
							<tr>
								<td bgcolor="#E6E6E6" height='26'><div align='right'><font class='text1'>SHOP 게시판 추가,수정,삭제 등을 작성하실수 있습니다.&nbsp;</div></td>
							</tr>
							<tr>
								<td>&nbsp;</td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td align="left" height="30">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<B><?=$bbs_admin_row[name]?></B></td>
				</tr>
				<tr>
					<td valign="top">
						<table width="750" border="0" align="center" bgcolor="#EBEBEB" cellpadding="0" cellspacing="1" >
							<tr>
								<td>
									<form name="bbsForm" method="post" action="bbs_write_ok.php" enctype="multipart/form-data" >
									<input type="hidden" name="code" value="<?=$code?>"><!-- 게시판 코드 -->
									<input type="hidden" name="ref" value="<?=$bbs_row[ref]?>"><!-- 답변형게시판 변수 -->
									<input type="hidden" name="re_step" value="<?=$bbs_row[re_step]?>"><!-- 답변형게시판 변수 -->
									<input type="hidden" name="re_level" value="<?=$bbs_row[re_level]?>"><!-- 답변형게시판 변수 -->
									<input type="hidden" name="data" value="<?=$data?>"><!-- 답변형게시판 현재글 정보 -->
									<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center" height="420" bgcolor="#FFFFFF">
										<tr valign="middle">
											<td width="120" height="30" bgcolor="#FAFAFA"> <div align="left">&nbsp;&nbsp;<img src="image/icon.gif" width="11" height="11"> 제 목</div></td>
											<td width="387" height="30">&nbsp;&nbsp;<?
											if ($bbs_row[title])
											{
												?><input class="box" type="text" name="title" size="50" value="[RE] <?=$bbs_row[title]?>"><?
											}
											else
											{
												?><input class="box" type="text" name="title" size="50"><?
											}
											?></td>
										</tr>
										<tr>
											<td colspan="2" height="1" background="image/line_bg1.gif"></td>
										</tr>
										<tr valign="middle">
											<td width="120" height="30" bgcolor="#FAFAFA"> <div align="left">&nbsp;&nbsp;<img src="image/icon.gif" width="11" height="11"> 이 름</div></td>
											<td width="387" height="30">&nbsp;&nbsp;<input class="box" type="text" name="name" size="20" value="<?=$admin_row[shopName]?>"></td>
										</tr>
										<tr>
											<td colspan="2" height="1" background="image/line_bg1.gif"></td>
										</tr>
										<tr>
											<td width="120" height="30" bgcolor="#FAFAFA">&nbsp;&nbsp;<img src="image/icon.gif" width="11" height="11"> 이메일</td>
											<td width="387" height="30">&nbsp;&nbsp;<input class="box" type="text" name="email" size="30" value="<?=$admin_row[adminEmail]?>"></td>
										</tr>
										<tr>
											<td colspan="2" height="1" background="image/line_bg1.gif"></td>
										</tr><?
										if($bbs_admin_row[part]==30)
										{
											?>
										<tr>
											<td width="120" height="30" bgcolor="#FAFAFA">&nbsp;&nbsp;<img src="image/icon.gif" width="11" height="11"> 목록 이미지</td>
											<td width="387" height="30">&nbsp;&nbsp;<input class="box" type="file" name="img1" size="30"></td>
										</tr>
										<tr>
											<td colspan="2" height="1" background="image/line_bg1.gif"></td>
										</tr>
										<tr>
											<td width="120" height="30" bgcolor="#FAFAFA">&nbsp;&nbsp;<img src="image/icon.gif" width="11" height="11"> 글보기이미지</td>
											<td width="387" height="30">&nbsp;&nbsp;<input class="box" type="file" name="img2" size="30"></td>
										</tr>
										<tr>
											<td colspan="2" height="1" background="image/line_bg1.gif"></td>
										</tr><?
										}
										?>
										<tr>
											<td width="120" height="30" bgcolor="#FAFAFA">&nbsp;&nbsp;<img src="image/icon.gif" width="11" height="11"> 공지글로 등록</td>
											<td width="387" height="30">&nbsp;&nbsp;<input type="checkbox" name="gongji" value="1">&nbsp;</td>
										</tr>
										<tr>
											<td colspan="2" height="1" background="image/line_bg1.gif"></td>
										</tr>
										<tr>
											<td width="120" height="30" bgcolor="#FAFAFA">&nbsp;&nbsp;<img src="image/icon.gif" width="11" height="11"> 비밀번호</td>
											<td width="387" height="30" style="line-height:20px">&nbsp;&nbsp;<input class="box" type="password" name="pwd" size="20" value="<?=$bbs_row[pwd]?>"><?
											if ($bbs_row[bLock]=="y")
											{
												?><br>&nbsp;잠금기능이 설정된 게시물입니다. 원문의 비밀번호가 자동입력됩니다. <?
											}
											?><br><input type="checkbox" name="bLock" value="y" <? if ($bbs_row[bLock]=="y") echo "checked";?>> 게시물 잠금 (본인과 관리자만 열람가능)</td>
										</tr>
										<tr>
											<td colspan="2" height="1" background="image/line_bg1.gif"></td>
										</tr><?
										if($bbs_admin_row[part]==20)
										{
											?>
										<tr>
											<td width="120" height="30" bgcolor="#FAFAFA">&nbsp;&nbsp;<img src="image/icon.gif" width="11" height="11"> 파일첨부</td>
											<td width="387" height="30"> &nbsp;&nbsp;<input class="box" type="file" name="up_file"></td>
										</tr>
										<tr>
											<td colspan="2" height="1" background="image/line_bg1.gif"></td>
										</tr><?
										}
										?>
										<tr>
											<td width="120" height="30" bgcolor="#FAFAFA">&nbsp;&nbsp;<img src="image/icon.gif" width="11" height="11"> 내용입력 형식</td>
											<td width="387" height="30"> &nbsp;&nbsp;<INPUT TYPE="radio" NAME="bHtml" value='1' onclick="document.getElementById('nsText').style.display='block';document.getElementById('nsHtml').style.display='none';document.getElementById('nsEdit').style.display='none';">TEXT &nbsp; <INPUT TYPE="radio" NAME="bHtml" value='2' <?=$Os_Check?"":"checked"?> onclick="document.getElementById('nsText').style.display='none';document.getElementById('nsHtml').style.display='block';document.getElementById('nsEdit').style.display='none';">HTML &nbsp; <INPUT TYPE="radio" NAME="bHtml" value='0' <?=$Os_Check?"checked":""?> onclick="document.getElementById('nsText').style.display='none';document.getElementById('nsHtml').style.display='none';document.getElementById('nsEdit').style.display='block';" <?= $Use_Check?>>웹에디터</td>
										</tr>
										<tr>
											<td colspan="2" height="1" background="image/line_bg1.gif"></td>
										</tr>
										<tr>
											<td colspan="2" height="100" align="center">
												<table width="700" cellpadding="0" cellspacing="0" border="0" id='nsText' style='display:none'>
													<tr>
														<td><textarea name="TextContent" style="width:100%" rows="20" cols="80"><? if ($bbs_row[content]) echo "\n\n"."---------------------------------------- \n\n".htmlspecialchars($bbs_row[content]);?></textarea></td>
													</tr>
												</table>
												<table width="700" cellpadding="0" cellspacing="0" border="0" id='nsHtml' style='display:<?=$Os_Check?"none":"block"?>'>
													<tr>
														<td><textarea name="HtmlContent" style="width:100%" rows="20" cols="80"><? if ($bbs_row[content]) echo "\n\n"."---------------------------------------- <br>".htmlspecialchars($bbs_row[content]);?></textarea></td>
													</tr>
												</table>
												<table width="700" cellpadding="0" cellspacing="0" border="0" id='nsEdit' style='display:<?=$Os_Check?"block":"none"?>'>
													<tr>
														<td width='700'><?
														$form_name = "bbsForm";
														$dir_path = "..";
														include "../editor.php";
														if ($bbs_row[content])
														{
															?><textarea style="display:none" class="text" name="content"  cols="90" rows="13"><? echo "\n\n"."---------------------------------------- <br>".htmlspecialchars($bbs_row[content]);?></textarea><?
														}
														else
														{
															?><textarea style="display:none" class="text" name="content"  cols="90" rows="13"></textarea><?
														}
														?></td>
													</tr>
												</table>
											</td>
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
														<td width="10"><a href="bbs_list.php?code=<?=$code?>&data=<?=$data?>"><img src="image/bbs_list_btn.gif" width="41" height="23" border="0"></a></td>
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
<? include "copy.php";?>
</body>
</html>