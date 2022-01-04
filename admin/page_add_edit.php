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
//사용자정의 페이지 정보 전송
function pageSendit()
{
	var form=document.pageForm;
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
	if(form.title.value=="")
	{
		alert("제목을 입력해 주십시오.");
		form.title.focus();
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
	$__TOP_MENU = "page";     //왼쪽 소메뉴 설정 변수
	include "left_menu.php";
	$qry= "select *from page where idx=$pageIdx";
	$result= $MySQL->query($qry);
	$page_row = mysql_fetch_array($result);
	?>
		<td width="85%" valign="top" height='400'>
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td height='5'></td>
				</tr>
				<tr>
					<td>
						<table width="750" border="0" cellspacing="0" cellpadding="0" align='center'>
							<tr>
								<td rowspan="3" width="200"><img src="image/page_img.gif"></td>
								<td>&nbsp;</td>
							</tr>
							<tr>
								<td bgcolor="#E6E6E6" height='26'><div align='right'><font class='text1'>SHOP 새로운 페이지를 생성하실수 있습니다.&nbsp;</div></td>
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
								<td width='440'><img src="image/page_tit.gif"></td>
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
					<td valign="top"><br>
						<table width="750" border="0" cellspacing="0" cellpadding="0" align="center">
							<tr>
								<td valign="top"><img src="image/page_tit.gif" height="26"></td>
							</tr>
							<tr>
								<td>&nbsp;</td>
							</tr>
							<tr>
								<td valign="top">
									<form name="pageForm" method="post" action="page_add_edit_ok.php" enctype="multipart/form-data" >
									<input type="hidden" name="pageIdx" value="<?=$pageIdx?>">
									<table width="750" border="0" cellspacing="2" cellpadding="0" align="center">
										<tr>
											<td width="150" height="30" valign="middle" bgcolor="#EBEBEB"> <div align="center"><img src="image/icon.gif" width="11" height="11"> 페이지 코드</div></td>
											<td valign="middle"> <B><FONT  COLOR="#CC0000"><?=$page_row[code]?></FONT></B></td>
										</tr>
										<tr>
											<td colspan="2" height="1" background="image/line_bg1.gif"></td>
										</tr>
										<tr>
											<td width="150" height="30" valign="middle" bgcolor="#EBEBEB"> <div align="center"><img src="image/icon.gif" width="11" height="11"> 페이지 제목</div></td>
											<td height="30" valign="middle" bgcolor="fafafa"> <input class="box" type="text" name="title" size="50" value="<?=$page_row[title]?>"></td>
										</tr>
										<tr >
											<td height="1" colspan="2" background="image/line_bg1.gif"> </td>
										</tr>
										<tr>
											<td width="150" height="30" valign="middle" bgcolor="#EBEBEB"> <div align="center"><img src="image/icon.gif" width="11" height="11"> 제목 이미지</div></td>
											<td height="30" valign="middle" bgcolor="fafafa"> <input class="box" type="file" name="img" size="25"><?
											if($page_row[img])
											{
												$img_info	=@getimagesize("../upload/page/$page_row[img]");   //이미지3 정보
												$wSize	=$img_info[0];	//가로
												$hSize	=$img_info[1];	//세로
												?>&nbsp;&nbsp;&nbsp;<a href="javascript:zoom('../upload/page/<?=$page_row[img]?>','<?=$wSize?>','<?=$hSize?>');"><FONT COLOR="blue"><u><?=$page_row[img]?></u></FONT></a>&nbsp;삭제시 이곳을 선택후 저장하기 클릭 <input type="checkbox" name="imgdel" value="1"><?
											}
											?></td>
										</tr>
										<tr >
											<td height="1" colspan="2" background="image/line_bg1.gif"> </td>
										</tr>
										<tr>
											<td width="150" height="30" valign="middle" bgcolor="#EBEBEB"> <div align="center"><img src="image/icon.gif" width="11" height="11"> 페이지 설정</div></td>
											<td height="30" valign="middle" bgcolor="fafafa"> <input type="radio" name="bPopup" value="0" <?if(!$page_row[bPopup])echo"checked";?>> 지정된 페이지 사용 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="bPopup" value="1" <?if($page_row[bPopup])echo"checked";?>> 완전한 새 페이지</td>
										</tr>
										<tr >
											<td height="1" colspan="2" background="image/line_bg1.gif"> </td>
										</tr>
										<tr>
											<td width="150" height="30" valign="middle" bgcolor="#EBEBEB"> <div align="center"><img src="image/icon.gif" width="11" height="11"> 관련 이미지</div></td>
											<td height="30" valign="middle" bgcolor="fafafa"> <a href="javascript:inputImg('page','<?=$page_row[imgcode]?>');"><img src="image/upload_btn1.gif" width="73" height="17" border="0"></a></td>
										</tr>
										<tr >
											<td height="1" colspan="2" background="image/line_bg1.gif"> </td>
										</tr><?
										$bHtml_chk[$page_row[bHtml]]="checked";
										?>
										<tr align="center">
											<td height="30" colspan="2" bgcolor="#EBEBEB"> 내용입력 형식 : <INPUT TYPE="radio" NAME="bHtml" value='1' onclick="document.getElementById('nsText').style.display='block';document.getElementById('nsHtml').style.display='none';document.getElementById('nsEdit').style.display='none';" <?= $bHtml_chk[1]?>>TEXT &nbsp; <INPUT TYPE="radio" NAME="bHtml" value='2' onclick="document.getElementById('nsText').style.display='none';document.getElementById('nsHtml').style.display='block';document.getElementById('nsEdit').style.display='none';" <?= $bHtml_chk[2]?>>HTML &nbsp; <INPUT TYPE="radio" NAME="bHtml" value='0' onclick="document.getElementById('nsText').style.display='none';document.getElementById('nsHtml').style.display='none';document.getElementById('nsEdit').style.display='block';" <?= $Use_Check?> <?= $bHtml_chk[0]?>>웹에디터</td>
										</tr>
										<tr align="center">
											<td colspan="2" bgcolor="#FFFFFF">
												<table width="700" cellpadding="0" cellspacing="0" border="0" id='nsText' style='display:<?=$page_row[bHtml]==1?"block":"none"?>'>
													<tr>
														<td><textarea name="TextContent" style="width:100%" rows="20" cols="80"><?=htmlspecialchars($page_row[content])?></textarea></td>
													</tr>
												</table>
												<table width="700" cellpadding="0" cellspacing="0" border="0" id='nsHtml' style='display:<?=$page_row[bHtml]==2?"block":"none"?>'>
													<tr>
														<td><textarea name="HtmlContent" style="width:100%" rows="20" cols="80"><?=htmlspecialchars($page_row[content])?></textarea></td>
													</tr>
												</table>
												<table width="700" cellpadding="0" cellspacing="0" border="0" id='nsEdit' style='display:<?=!$page_row[bHtml]?"block":"none"?>'>
													<tr>
														<td width='700'><?
														$form_name = "pageForm";
														$dir_path = "..";
														include "../editor.php";
														?><textarea style="display:none" class="text" name="content" cols="90" rows="12"><?=htmlspecialchars($page_row[content])?></textarea></td>
													</tr>
												</table>
											</td>
										</tr>
										<tr>
											<td height="1" colspan="2" background="image/line_bg1.gif"> </td>
										</tr>
									</table></form>
								</td>
							</tr>
							<tr>
								<td height="40"><div align="center"><a href="javascript:pageSendit();"><img src="image/page_save.gif" width="70" height="26" border="0"></a></div></td>
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