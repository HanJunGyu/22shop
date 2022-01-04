<?
include "head.php";
$gd_array = @gd_info();
//////////본 페이지가 열리지 않는 고객은 위 한줄을 주석처리해야함. GD 자체가 서버에 없는 경우 그러함. 
?>
<SCRIPT LANGUAGE="JavaScript">
<!--
function postcode()
{
	<? if (__DEMOPAGE){ ?>
	alert("데모페이지는 기능이 제한되어 있습니다.");
	<? }else{ ?>
	if (confirm("업데이트 하시겠습니까?"))
	{
		document.adm_etcForm.submit();
	}
	<? } ?> 
}

function etcSendit()
{
	<? if (__DEMOPAGE){ ?>
	alert("데모페이지는 기능이 제한되어 있습니다.");
	<? }else{ ?>
	document.adm_etcForm.submit();
	<? } ?>
}
//-->
</SCRIPT>
<body bgcolor="#FFFFFF" text="#5A595A" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<? include "top_menu.php";?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr><?
	$__TOP_MENU = "basic";     //왼쪽 소메뉴 설정 변수
	include "left_menu.php";
	?>
		<td width="85%" valign="top">
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td height='5'></td>
				</tr>
				<tr>
					<td>
						<table width="750" border="0" cellspacing="0" cellpadding="0" align='center'>
							<tr>
								<td rowspan="3" width="200"><img src="image/account_tit_.gif"></td>
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
						<form name="adm_etcForm" method="post" action="adm_etc2_ok.php" enctype="multipart/form-data" >
						<table width="800" border="0" cellspacing="0" cellpadding="0" align="center">
							<tr>
								<td colspan="2">
									<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
										<tr>
											<td height='1' colspan='3' bgcolor='DADADA'></td>
										</tr>
										<tr>
											<td width='440'><img src="image/etc_mid_etc.gif"></td>
										</tr>
										<tr>
											<td height='1' colspan='3' bgcolor='DADADA'></td>
										</tr>
									</table>
								</td>
							</tr>
							<tr>
								<td height='5' colspan="2"></td>
							</tr>
							<tr>
								<td colspan="2" height="1" background="image/line_bg1.gif"></td>
							</tr>
							<tr>
								<td bgcolor="f5f5f5" colspan="2" height="40" valign="middle">
									<table width="50%" border="0" align="center" cellpadding="0" cellspacing="0">
										<tr>
											<td><div align="center"><a href="javascript:etcSendit();"><img src="image/save_btn.gif" width="40" height="17" border="0"></a></div></td>
											<td><div align="center"><a href="javascript:formClear(document.adm_etcForm);"><img src="image/cancel_btn.gif" width="40" height="17" border="0"></a></div></td>
										</tr>
									</table>
								</td>
							</tr>
							<tr>
								<td colspan="2" height="1" background="image/line_bg1.gif"></td>
							</tr>
							<tr>
								<td width="300" height="25" bgcolor="#FAFAFA">&nbsp;&nbsp;<img src="image/icon.gif" width="11" height="11"> 상품등록시 한개이미지 등록으로<br> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;소,중,대 자동생성 기능</td>
								<td width="450" height="25">
									<table width="430" border="0" cellspacing="0" cellpadding="0" align="center">
										<tr>
											<td width="10%"> <div align="center"> <input type="radio" name="bGdset" value="y" <?if($admin_row[bGdset]=="y"){echo"checked";}?>></div></td>
											<td width="25%"> <div align="left">사용함</div></td>
											<td width="10%"> <div align="center"> <input type="radio" name="bGdset" value="n" <?if($admin_row[bGdset]=="n" || !$gd_array["GIF Create Support"]){echo"checked";}?>></div></td>
											<td width="25%"> <div align="left">사용하지 않음</div></td>
										</tr>
										<tr>
											<td colspan=4><font class="help">※ 호스팅 서버에 <b>GD LIBRARY 버젼 2.0</b> 설치되었을시 사용가능 (JPG만) <br>※ <b>GD 2.0.28 버젼</b> 이상부터 GIF 이미지도 압축가능합니다.<br>※ 저희쪽 <b>호스팅 서버</b>에는 2004년 11월22일 2.08 버젼이 설치되었습니다.</font><?
											if ($gd_array["GD Version"]) echo "<BR><b> 고객님의 GD버젼 : ".$gd_array["GD Version"]."</b>";
											else echo "<BR><font color=red><b>고객님의 GD버젼이 확인되지 않습니다. 호스팅업체 확인요망.</b></font>";
											if ($gd_array["GIF Create Support"]) echo "<BR><b> GIF 사용가능</b>";
											else echo "<BR><font color=red><b>고객님의 GIF 사용가능여부가 확인되지 않습니다. 호스팅업체 확인요망.</b></font>";
											if ($gd_array["JPG Support"]) echo "<BR><b> JPG 사용가능</b>";
											else echo "<BR><font color=red><b>고객님의 JPG 사용가능여부가 확인되지 않습니다. 호스팅업체 확인요망.</b></font>";
											?></td>
										</tr>
									</table>
								</td>
							</tr>
							<tr>
								<td colspan="2" height="1" background="image/line_bg1.gif"></td>
							</tr>
							<tr>
								<td width="300" height="25" bgcolor="#FAFAFA">&nbsp;&nbsp;<img src="image/icon.gif" width="11" height="11"> 1:1문의 사용여부</td>
								<td width="450" height="25">
									<table width="430" border="0" cellspacing="0" cellpadding="0" align="center">
										<tr>
											<td width="10%"> <div align="center"> <input type="radio" name="bPersonask" value="1" <?if($admin_row[bPersonask]){echo"checked";}?>></div></td>
											<td width="25%"> <div align="left">사용함</div></td>
											<td width="10%"> <div align="center"> <input type="radio" name="bPersonask" value="0" <?if(!$admin_row[bPersonask]){echo"checked";}?>></div></td>
											<td width="25%"> <div align="left">사용하지 않음</div></td>
										</tr>
									</table>
								</td>
							</tr>
							<tr>
								<td colspan="2" height="1" background="image/line_bg1.gif"></td>
							</tr>
							<tr>
								<td width="300" height="25" bgcolor="#FAFAFA">&nbsp;&nbsp;<img src="image/icon.gif" width="11" height="11"> 마우스 오른쪽버튼 사용허가여부</td>
								<td width="450" height="25">
									<table width="430" border="0" cellspacing="0" cellpadding="0" align="center">
										<tr>
											<td width="10%"> <div align="center"> <input type="radio" name="bMouseRB" value="1" <?if($admin_row[bMouseRB]){echo"checked";}?>></div></td>
											<td width="25%"> <div align="left">허가함</div></td>
											<td width="10%"> <div align="center"> <input type="radio" name="bMouseRB" value="0" <?if(!$admin_row[bMouseRB]){echo"checked";}?>></div></td>
											<td width="25%"> <div align="left">허가하지 않음</div></td>
										</tr>
									</table>
								</td>
							</tr>
							<tr>
								<td colspan="2" height="1" background="image/line_bg1.gif"></td>
							</tr>
							<tr>
								<td width="300" height="25" bgcolor="#FAFAFA">&nbsp;&nbsp;<img src="image/icon.gif" width="11" height="11"> 주문목록 자동새로고침(매 2분30초)</td>
								<td width="450" height="25">
									<table width="430" border="0" cellspacing="0" cellpadding="0" align="center">
										<tr>
											<td width="10%"> <div align="center"> <input type="radio" name="bTrade" value="1" <?if($admin_row[bTrade]){echo"checked";}?>></div></td>
											<td width="25%"> <div align="left">사용함</div></td>
											<td width="10%"> <div align="center"> <input type="radio" name="bTrade" value="0" <?if(!$admin_row[bTrade]){echo"checked";}?>></div></td>
											<td width="25%"> <div align="left">사용하지 않음</div></td>
										</tr>
									</table>
								</td>
							</tr>
							<tr>
								<td colspan="2" height="1" background="image/line_bg1.gif"></td>
							</tr>
							<tr>
								<td width="300" height="50" bgcolor="#FAFAFA">&nbsp;&nbsp;<img src="image/icon.gif" width="11" height="11"> 우편번호 업데이트</td>
								<td><input type="file" name="postcode"><a href="javascript:postcode();"><img src="image/save_btn.gif" width="40" height="17" border="0"></a> <br><font color="#999999"><b>정기적으로 우편번호 패치TXT 파일이 공개되며</b> 그 우편번호 TXT파일을 다운로드하여 이곳에 등록하면 갱신됩니다.</font></td>
							</tr>
							<tr>
								<td colspan="2" height="1" background="image/line_bg1.gif"></td>
							</tr>
							<tr>
								<td bgcolor="f5f5f5" colspan="2" height="40" valign="middle">
									<table width="50%" border="0" align="center" cellpadding="0" cellspacing="0">
										<tr>
											<td><div align="center"><a href="javascript:etcSendit();"><img src="image/save_btn.gif" width="40" height="17" border="0"></a></div></td>
											<td><div align="center"><a href="javascript:formClear(document.adm_etcForm);"><img src="image/cancel_btn.gif" width="40" height="17" border="0"></a></div></td>
										</tr>
									</table>
								</td>
							</tr></form><!-- adm_etcForm -->
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