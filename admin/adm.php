<?
include "head.php";
?>
<SCRIPT LANGUAGE="JavaScript">
<!--
function admSendit()
{
	var form=document.admForm;
	if(form.adminId.value=="")
	{
		alert("관리자 아이디를 입력해 주십시오.");
		form.adminId.focus();
	}
	else if(form.adminPwd.value=="")
	{
		alert("관리자 비밀번호를 입력해 주십시오.");
		form.adminPwd.focus();
	}
	else if(form.adminPwd.value!=form.adminPwd2.value)
	{
		alert("관리자 비밀번호 확인을 입력해주세요.");
		form.adminPwd2.focus();
	}
	else form.submit();
}
//우편번호 찾기
function searchZip()
{
	window.open("search_post.php","","scrollbars=yes,width=480,height=200,left=250,top=250");
}
//-->
</SCRIPT>
<body bgcolor="#FFFFFF" text="#5A595A" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<? include "top_menu.php";?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr><?
	$__TOP_MENU = "basic";     //왼쪽 소메뉴 설정 변수
	include "left_menu.php";
	if(!defined(__ADMIN_ROW))
	{
		define(__ADMIN_ROW,"TRUE");
		$admin_row=$MySQL->fetch_array("select *from admin limit 0,1"); //관리자 정보 배열
	}
	$comNum = explode("-",$admin_row[comNum]);				//사업자 등록번호
	$comTel = explode("-",$admin_row[comTel]);				//사업장 연락처
	$comFax = explode("-",$admin_row[comFax]);				//사업장 팩스번호
	$comZip = explode("-",$admin_row[comZip]);
	?>
		<td width="85%" valign="top">
			<table width="100%" border="0" cellspacing="0" cellpadding="0" align='center'>
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
							<tr>
								<td colspan=2>
									<table width="300" cellspacing="2" cellpadding="2">
										<tr align="center">
											<td width=50% bgcolor="#CBCCF8">기본정보 최근수정날짜</td>
											<td><b><?=$admin_row[editDay]?></b></td>
										</tr>
										<tr align="center" >
											<td width=50% bgcolor="#CBCCF8">최근접속날짜</td>
											<td><b><?=$admin_row[nearDay]?></b></td>
										</tr>
									</table>
								</td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td height="2">
						<table width="750" border="0" cellspacing="0" cellpadding="0" align="center">
							<tr>
								<td bgcolor="f5f5f5" colspan="3" height="40" valign="middle">
									<table width="50%" border="0" align="center" cellpadding="0" cellspacing="0">
										<tr>
											<td><div align="center"><a href="javascript:admSendit();"><img src="image/save_btn.gif" width="40" height="17" border="0"></a></div></td>
											<td><div align="center"><a href="javascript:formClear(document.admForm);"><img src="image/cancel_btn.gif" width="40" height="17" border="0"></a></div></td>
										</tr>
									</table>
								</td>
							</tr>
							<tr>
								<td bgcolor='DADADA' height='1'></td>
							</tr>
							<tr>
								<td>
									<table width="750" border="0" cellspacing="0" cellpadding="0" align="center">
										<tr>
											<td width='440'><img src="image/adm_mid_tit.gif"></td>
										</tr>
									</table>
								</td>
							</tr>
							<tr>
								<td bgcolor='DADADA' height='1'></td>
							</tr>
							<tr>
								<td height='10'></td>
							</tr>
							<tr>
								<td>
									<form name="admForm" method="post" action="adm_ok.php" enctype="multipart/form-data" >
									<table width="750" border="0" cellspacing="0" cellpadding="0" align="center">
										<tr valign="middle">
											<td width="20%" height="25" bgcolor="#FAFAFA"><div align="left">&nbsp;&nbsp;<img src="image/icon.gif" width="11" height="11"> 쇼핑몰 주소</div></td>
											<td width="80%" height="25"> &nbsp;&nbsp;<font color="#996600">http://</font> <input class="box" type="text" name="shopUrl" size="50" value="<?=$admin_row[shopUrl]?>" <?=$demo_readonly?>><br>&nbsp;&nbsp;<font class="help">※ 반드시 <b>현재 연결되어 있는 도메인</b>으로 입력해주시기 바랍니다.</font></td>
										</tr>
										<tr>
											<td colspan="2" height="1" background="image/line_bg1.gif"></td>
										</tr>
										<tr valign="middle">
											<td width="20%" height="25" bgcolor="#FAFAFA"> <div align="left">&nbsp;&nbsp;<img src="image/icon.gif" width="11" height="11"> 쇼핑몰 이름</div></td>
											<td width="80%" height="25">&nbsp;&nbsp;<input class="box"type="text" name="shopName" size="30" value="<?=$admin_row[shopName]?>"></td>
										</tr>
										<tr>
											<td colspan="2" height="1" background="image/line_bg1.gif"></td>
										</tr>
										<tr valign="middle">
											<td width="20%" height="25" bgcolor="#FAFAFA"> <div align="left">&nbsp;&nbsp;<img src="image/icon.gif" width="11" height="11"> 쇼핑몰 제목<br><font class="help">※ 브라우저 상단 타이틀바에 표시됩니다. </font></div></td>
											<td width="80%" height="25">&nbsp;&nbsp;<input class="box"type="text" name="shopTitle" size="90" value="<?=$admin_row[shopTitle]?>"></td>
										</tr>
										<tr>
											<td colspan="2" height="1" background="image/line_bg1.gif"></td>
										</tr>
										<tr valign="middle">
											<td width="20%" height="25" bgcolor="#FAFAFA"> <div align="left">&nbsp;&nbsp;<img src="image/icon.gif" width="11" height="11"> 검색 키워드<br><font class="help">※ 검색엔진에 검색되어질 검색어 (<b>컴마</b>로 분리해서 입력합니다.)</font></div></td>
											<td width="80%" height="25">&nbsp;<textarea class="box" name="shopKeyword" cols="60" rows="5"><?=$admin_row[shopKeyword]?></textarea></td>
										</tr>
										<tr>
											<td colspan="2" height="1" background="image/line_bg1.gif"></td>
										</tr>
										<tr valign="middle">
											<td width="20%" height="25" bgcolor="#FAFAFA"> <div align="left">&nbsp;&nbsp;<img src="image/icon.gif" width="11" height="11"> 정보 보호 담당자</div></td>
											<td width="80%" height="25">&nbsp;&nbsp;<input class="box"type="text" name="guard" size="10" value="<?=$admin_row[guard]?>"></td>
										</tr>
										<tr>
											<td colspan="2" height="1" background="image/line_bg1.gif"></td>
										</tr>
										<tr valign="middle">
											<td width="20%" height="25" bgcolor="#FAFAFA"> <div align="left">&nbsp;&nbsp;<img src="image/icon.gif" width="11" height="11"> 로그인후 첫페이지</div></td>
											<td width="80%" height="25"> &nbsp;&nbsp;<font color="#996600"><select name="startpage_adm"><?
											foreach ($menu_str_arr as $key => $value)
											{
												?><option value="<?=$ADMIN_MENU_ARR[$key]?>" <? if ($ADMIN_MENU_ARR[$key] == $admin_row[startpage_adm]) echo "selected";?>><?=$menu_str_arr[$key]?></option><?
											}
											?></select></td>
										</tr>
										<tr>
											<td colspan="2" height="1" background="image/line_bg1.gif"></td>
										</tr>
										<tr>
											<td colspan="2" height="15"></td>
										</tr>
										<tr>
											<td colspan="2">
												<table width="750" border="0" cellspacing="0" cellpadding="0" align="center">
													<tr>
														<td height='1' bgcolor='DADADA'></td>
													</tr>
													<tr>
														<td width='440'><img src="image/adm_mid_tit1.gif"></td>
													</tr>
													<tr>
														<td height='1' bgcolor='DADADA'></td>
													</tr>
												</table>
											</td>
										</tr>
										<tr>
											<td width="20%" height="25" bgcolor="#FAFAFA">&nbsp;&nbsp;<img src="image/icon.gif" width="11" height="11"> 관리자 아이디 </td>
											<td width="80%" height="25">&nbsp;&nbsp;<input class="box"type="text" name="adminId" size="20" value="<?=$admin_row[adminId]?>" <?=$demo_readonly?>></td>
										</tr>
										<tr>
											<td colspan="2" height="1" background="image/line_bg1.gif"></td>
										</tr>
										<tr>
											<td width="20%" height="25" bgcolor="#FAFAFA">&nbsp;&nbsp;<img src="image/icon.gif" width="11" height="11"> 관리자 비밀번호</td>
											<td width="80%" height="25">&nbsp;&nbsp;<input class="box"type="password" name="adminPwd" size="20" value="<?=$admin_row[adminPwd]?>" <?=$demo_readonly?>></td>
										</tr>
										<tr>
											<td colspan="2" height="1" background="image/line_bg1.gif"></td>
										</tr>
										<tr>
											<td width="20%" height="25" bgcolor="#FAFAFA">&nbsp;&nbsp;<img src="image/icon.gif" width="11" height="11"> 관리자 비밀번호 확인</td>
											<td width="80%" height="25">&nbsp;&nbsp;<input class="box"type="password" name="adminPwd2" size="20" value=""> &nbsp;<font class="help">※ 비밀번호에 오타가 입력되서 추후 로그인이 안되는 문제 방지를 위해 항상 입력</font></td>
										</tr>
										<tr>
											<td colspan="2" height="1" background="image/line_bg1.gif"></td>
										</tr>
										<tr>
											<td width="20%" height="25" bgcolor="#FAFAFA">&nbsp;&nbsp;<img src="image/icon.gif" width="11" height="11"> 관리자 발송이메일</td>
											<td width="80%" height="25">&nbsp;&nbsp;<input class="box"type="text" name="adminEmail" size="35" value="<?=$admin_row[adminEmail]?>"></td>
										</tr>
										<tr>
											<td colspan="2" height="1" background="image/line_bg1.gif"></td>
										</tr>
										<tr>
											<td width="20%" height="25" bgcolor="#FAFAFA">&nbsp;&nbsp;<img src="image/icon.gif" width="11" height="11"> 관리자 회신이메일</td>
											<td width="80%" height="25">&nbsp;&nbsp;<input class="box"type="text" name="adminEmail2" size="35" value="<?=$admin_row[adminEmail2]?>"></td>
										</tr>
										<tr>
											<td colspan="2" height="1" background="image/line_bg1.gif"></td>
										</tr>
										<tr>
											<td colspan="2" height="15"></td>
										</tr>
										<tr>
											<td colspan="2">
												<table width="750" border="0" cellspacing="0" cellpadding="0" align="center">
													<tr>
														<td height='1' colspan='3' bgcolor='DADADA'></td>
													</tr>
													<tr>
														<td width='440'><img src="image/adm_mid_tit2.gif"></td>
													</tr>
													<tr>
														<td height='1' colspan='3' bgcolor='DADADA'></td>
													</tr>
												</table>
											</td>
										</tr>
										<tr>
											<td width="20%" height="25" bgcolor="#FAFAFA">&nbsp;&nbsp;<img src="image/icon.gif" width="11" height="11"> 상 호</td>
											<td width="80%" height="25">&nbsp;&nbsp;<input class="box"type="text" name="comName" size="30" value="<?=$admin_row[comName]?>"></td>
										</tr>
										<tr>
											<td colspan="2" height="1" background="image/line_bg1.gif"></td>
										</tr>
										<tr>
											<td width="20%" height="25" bgcolor="#FAFAFA">&nbsp;&nbsp;<img src="image/icon.gif" width="11" height="11"> 사업자 등록번호</td>
											<td width="80%" height="25">&nbsp;&nbsp;<input class="box"type="text" name="comNum1" size="3" maxlength="3" <?=__ONLY_NUM?> value="<?=$comNum[0]?>"> - <input class="box"type="text" name="comNum2" size="2" maxlength="2" <?=__ONLY_NUM?> value="<?=$comNum[1]?>"> - <input class="box"type="text" name="comNum3" size="5" maxlength="5" <?=__ONLY_NUM?> value="<?=$comNum[2]?>"></td>
										</tr>
										<tr>
											<td colspan="2" height="1" background="image/line_bg1.gif"></td>
										</tr>
										<tr>
											<td width="20%" height="25" bgcolor="#FAFAFA">&nbsp;&nbsp;<img src="image/icon.gif" width="11" height="11"> 업 태</td>
											<td width="80%" height="25"> &nbsp;&nbsp;<input class="box"type="text" name="comCon" size="30" value="<?=$admin_row[comCon]?>"></td>
										</tr>
										<tr>
											<td colspan="2" height="1" background="image/line_bg1.gif"></td>
										</tr>
										<tr>
											<td width="20%" height="25" bgcolor="#FAFAFA">&nbsp;&nbsp;<img src="image/icon.gif" width="11" height="11"> 종 목</td>
											<td width="80%" height="25">&nbsp;&nbsp;<input class="box"type="text" name="comItem" size="30" value="<?=$admin_row[comItem]?>"></td>
										</tr>
										<tr>
											<td colspan="2" height="1" background="image/line_bg1.gif"></td>
										</tr>
										<tr>
											<td width="20%" height="25" bgcolor="#FAFAFA">&nbsp;&nbsp;<img src="image/icon.gif" width="11" height="11"> 통신판매업 신고번호</td>
											<td width="80%" height="25">&nbsp;&nbsp;<input class="box"type="text" name="esailNum" size="30" value="<?=$admin_row[esailNum]?>"></td>
										</tr>
										<tr>
											<td colspan="2" height="1" background="image/line_bg1.gif"></td>
										</tr>
										<tr>
											<td width="20%" height="25" bgcolor="#FAFAFA">&nbsp;&nbsp;<img src="image/icon.gif" width="11" height="11"> 대표자명</td>
											<td width="80%" height="25">&nbsp;&nbsp;<input class="box"type="text" name="comCeo" size="30" value="<?=$admin_row[comCeo]?>"></td>
										</tr>
										<tr>
											<td colspan="2" height="1" background="image/line_bg1.gif"></td>
										</tr>
										<tr>
											<td width="20%" height="25" bgcolor="#FAFAFA">&nbsp;&nbsp;<img src="image/icon.gif" width="11" height="11"> 우편번호</td>
											<td width="80%" height="25">&nbsp;&nbsp;<input class="box"type="text" name="comZip1" size="3" maxlength="10"  value="<?=$comZip[0]?>"> - <input class="box"type="text" name="comZip2" size="3" maxlength="10"  value="<?=$comZip[1]?>"> &nbsp;<img src="../image/icon/post_search.gif" onclick="searchZip();" style="cursor:pointer"></td>
										</tr>
										<tr>
											<td colspan="2" height="1" background="image/line_bg1.gif"></td>
										</tr>
										<tr>
											<td width="20%" height="25" bgcolor="#FAFAFA">&nbsp;&nbsp;<img src="image/icon.gif" width="11" height="11"> 사업장 주소</td>
											<td width="80%" height="25">&nbsp;&nbsp;<input class="box"type="text" name="comAdr" size="80" value="<?=$admin_row[comAdr]?>"></td>
										</tr>
										<tr>
											<td colspan="2" height="1" background="image/line_bg1.gif"></td>
										</tr>
										<tr>
											<td width="20%" height="25" bgcolor="#FAFAFA">&nbsp;&nbsp;<img src="image/icon.gif" width="11" height="11"> 연 락 처</td>
											<td width="80%" height="25">&nbsp;&nbsp;<input class="box"type="text" name="comTel" size="20" maxlength="20"  value="<?=$admin_row[comTel]?>"></td>
										</tr>
										<tr>
											<td colspan="2" height="1" background="image/line_bg1.gif"></td>
										</tr>
										<tr>
											<td width="20%" height="25" bgcolor="#FAFAFA">&nbsp;&nbsp;<img src="image/icon.gif" width="11" height="11"> 팩 스</td>
											<td width="80%" height="25">&nbsp;&nbsp;<input class="box"type="text" name="comFax" size="20" maxlength="20" value="<?=$admin_row[comFax]?>"></td>
										</tr>
										<tr bgcolor="#FAFAFA">
											<td colspan="2" height="1" background="image/line_bg1.gif"></td>
										</tr>
										<tr>
											<td bgcolor="f5f5f5" colspan="2" height="40" valign="middle">
												<table width="50%" border="0" align="center" cellpadding="0" cellspacing="0">
													<tr>
														<td><div align="center"><a href="javascript:admSendit();"><img src="image/save_btn.gif" width="40" height="17" border="0"></a></div></td>
														<td><div align="center"><a href="javascript:formClear(document.admForm);"><img src="image/cancel_btn.gif" width="40" height="17" border="0"></a></div></td>
													</tr>
												</table>
											</td>
										</tr>
										</form><!-- admForm -->
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