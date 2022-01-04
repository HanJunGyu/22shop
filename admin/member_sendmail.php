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
if ($birth)
{
	$content="
<table width=600 border=0 align=center>
	<tr>
		<td align=center><img src='http://$admin_row[shopUrl]/upload/birth_img'></td>
	</tr>
	<tr>
		<td height=200 valign=middle align=center><b>고객님의 생일을 진심으로 축하드립니다.<p>앞으로도 많은 관심과 사랑 부탁드립니다.</b></td>
	</tr>
</table>";
	$title="고객님의 생일을 축하드립니다";
}
/////결혼기념일단체메일////////
if ($birth2)
{
	$content="
<table width=600 border=0 align=center>
	<tr>
		<td align=center><img src='http://$admin_row[shopUrl]/upload/birth2_img'></td>
	</tr>
	<tr>
		<td height=200 valign=middle align=center><b>고객님의 결혼기념일을 진심으로 축하드립니다.<p>앞으로도 많은 관심과 사랑 부탁드립니다.</b></td>
	</tr>
</table>";
	$title="고객님의 결혼기념일을 축하드립니다";
}
?>
<SCRIPT LANGUAGE="JavaScript">
<!--
function mailSendit()
{
	<? if ($demo_readonly) { ?>
	alert("데모페이지를 통한 스팸메일 발송을 막기위해\n 기능제한을 두었습니다. 죄송합니다.");
	<? }else { ?>
	var form=document.mailForm;
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
	else if(form.auth_code.value=="")
	{
		alert("보안코드를 입력해 주십시오.");
		form.auth_code.focus();
	}
	else
	{
		form.submit();
	}
	<? } ?>
}
//-->
</SCRIPT>
<body bgcolor="#FFFFFF" text="#5A595A" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<? include "top_menu.php"; ?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr><?
	$__TOP_MENU = "member";     //왼쪽 소메뉴 설정 변수
	include "left_menu.php";
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
								<td width='440'><img src="image/member_send.gif"></td>
							</tr>
							<tr>
								<td width='1' bgcolor='dadada' colspan='3'></td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
				</tr>
				<tr>
					<td align=center><b>※ 이메일 발송 전문프로그램이 아닌 웹상에서의 단체메일 발송은 서버에 많은 부하를 가져올수 있습니다.<br>또한 대부분의 호스팅업체 서버의 PHP 실행시간이 1분미만으로 설정되어 있기때문에 메일발송량의 한계가 있습니다.</b></td>
				</tr>
				<tr>
					<td valign="top">
						<form name="mailForm" method="post" action="member_sendmail_ok.php">
						<input type="hidden" name="idx_arr" value="<?=$idx_arr?>">
						<table width="750" border="0" cellspacing="0" cellpadding="0" align="center" height="420">
							<tr valign="middle">
								<td width="103" height="40" bgcolor="#FAFAFA"> <div align="left">&nbsp;&nbsp;<img src="image/icon.gif" width="11" height="11"> 제 목</div></td>
								<td width="447" height="40"> &nbsp;&nbsp; <input class="box" name="title" type="text" id="title" size="50" value="<?=$title?>"></td>
							</tr>
							<tr>
								<td colspan="2" height="1" background="image/line_bg1.gif"></td>
							</tr>
							<tr valign="middle">
								<td width="103" height="40" bgcolor="#FAFAFA"><div align="left">&nbsp;&nbsp;<img src="image/icon.gif" width="11" height="11"> 보안코드</div></td>
								<td width="447" height="40">
									<table cellpadding=0 cellspacing=0 cellpadding=0 border=0>
										<tr>
											<td width="10"></td>
											<td><? include "../lib/auth_img.php"; ?></td>
											<td>&nbsp; <input class="box" name="auth_code" type="text" id="auth_code" size="10"> 왼편에 보이는 보안코드를 입력하세요</td>
										</tr>
									</table>
								</td>
							</tr>
							<tr>
								<td colspan="2" height="1" background="image/line_bg1.gif"></td>
							</tr>
							<tr valign="middle">
								<td width="103" height="40" bgcolor="#FAFAFA"><div align="left">&nbsp;&nbsp;<img src="image/icon.gif" width="11" height="11"> 내용형식</div></td>
								<td width="447" height="40"> &nbsp;&nbsp; <INPUT TYPE="radio" NAME="bHtml" value='1' onclick="document.getElementById('nsText').style.display='block';document.getElementById('nsHtml').style.display='none';document.getElementById('nsEdit').style.display='none';">TEXT &nbsp; <INPUT TYPE="radio" NAME="bHtml" value='2' <?=$Os_Check?"":"checked"?> onclick="document.getElementById('nsText').style.display='none';document.getElementById('nsHtml').style.display='block';document.getElementById('nsEdit').style.display='none';">HTML &nbsp; <INPUT TYPE="radio" NAME="bHtml" value='0' <?=$Os_Check?"checked":""?> onclick="document.getElementById('nsText').style.display='none';document.getElementById('nsHtml').style.display='none';document.getElementById('nsEdit').style.display='block';" <?= $Use_Check?>>웹에디터</td>
							</tr>
							<tr>
								<td colspan="2" height="1" background="image/line_bg1.gif"></td>
							</tr>
							<tr>
								<td width="103" height="20" bgcolor="#FAFAFA">&nbsp;&nbsp;<img src="image/icon.gif" width="11" height="11"> 내용</td>
								<td width="447" height="20" align="left"><br>
									<table width="600" cellpadding="0" cellspacing="0" border="0" id='nsText' style='display:none'>
										<tr>
											<td><textarea name="TextContent" style="width:100%" rows="25" cols="80"><?=$content?></textarea></td>
										</tr>
									</table>
									<table width="600" cellpadding="0" cellspacing="0" border="0" id='nsHtml' style='display:<?=$Os_Check?"none":"block"?>'>
										<tr>
											<td><textarea name="HtmlContent" style="width:100%" rows="25" cols="80"><?=$content?></textarea></td>
										</tr>
									</table>
									<table width="600" cellpadding="0" cellspacing="0" border="0" id='nsEdit' style='display:<?=$Os_Check?"block":"none"?>'>
										<tr>
											<td><?
											$form_name = "mailForm";
											$dir_path = "..";
											include "../editor.php";
											?><textarea style="display:none" class="text" name="content" cols="90" rows="15"><?=$content?></textarea></td>
										</tr>
									</table><?
									if ($idx_arr)
									{
										$temp = explode("/",$idx_arr);
										$temp_cnt = count($temp);
										?><br><br>검색대상 메일보내기 [ <b><?=$temp_cnt?></b> 건 ]<?
									}
									?>
								</td>
							</tr>
							<tr>
								<td colspan="2" height="1" background="image/line_bg1.gif"></td>
							</tr>
							<tr>
								<td colspan="2" height="20"><br>
									<table width="200" border="0" align="center">
										<tr>
											<td><div align="center"><a href="javascript:mailSendit();"><img src="image/ok_btn.gif" width="40" height="17" border="0"></a></div></td>
											<td><div align="center"><a href="javascript:formClear(document.mailForm);"><img src="image/cancel_btn.gif" width="40" height="17" border="0"></a></div></td>
										</tr>
									</table><br>
								</td>
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