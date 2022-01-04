<?
include "head.php";
?>
<SCRIPT LANGUAGE="JavaScript">
<!--
function menu_show(cnt)
{
	obj = eval("document.getElementById('menu_id"+cnt+"')");
	td_obj = eval("document.getElementById('td_"+cnt+"')");
	if (obj.style.display == "")
	{
		obj.style.display = "none";
		td_obj.innerHTML = "▼";
	}
	else if (obj.style.display == "none")
	{
		obj.style.display = "";
		td_obj.innerHTML = "<font color=red>▲</font>";
	}
}
//-->
</SCRIPT>
<body bgcolor="#FFFFFF" text="#5A595A" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<? include "top_menu.php"; ?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr><?
	$__TOP_MENU = "help";     //왼쪽 소메뉴 설정 변수
	include "left_menu.php";
	if(!defined(__ADMIN_ROW))
	{
		define(__ADMIN_ROW,"TRUE");
		$admin_row=$MySQL->fetch_array("select *from admin limit 0,1"); //관리자 정보 배열
	}
	?>
		<td width="85%" valign="top" height='400'>
			<table width="100%" border="0" cellspacing="0" cellpadding="0" align='center'>
				<tr>
					<td height='5'></td>
				</tr>
				<tr>
					<td>
						<table width="95%" border="0" cellspacing="0" cellpadding="0" align='center'>
							<tr>
								<td rowspan="3" width="200"><img src="image/help_tit_img.gif"></td>
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
					<td height="2">
						<table width="95%" border="0" cellspacing="0" cellpadding="0" align="center">
							<tr>
								<td bgcolor='DADADA' height='1'></td>
							</tr>
							<tr>
								<td>
									<table width="95%" border="0" cellspacing="0" cellpadding="0" align="center">
										<tr>
											<td width='440' height=30><img src="image/adm_icon.gif"> 소스수정 이력관리</td>
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
								<td valign=top>
									<table width="95%"  border="0" cellspacing="1" cellpadding="3" align="center" bgcolor=''>
										<tr>
											<td colspan="2"> ※ 솔루션 이용 고객측의 프로그램 소스 수정사항을 기록하는 메뉴입니다. 추후 공개패치를 받을때 여기에 기록된 파일과 중복이 되지는 않는지 체크가 됩니다.</td>
										</tr>
										<tr>
											<td colspan="2">
												<form name="form1" method="post" action="help_src_ok.php">
												<table border=0 align="center" cellspacing="3" cellpadding="0" width="700" class="table_coll">
													<tr align="center">
														<td colspan="2" bgcolor="#3D179C" height=30><font color="white">소 스 수 정 내 역 &nbsp;&nbsp;신 규 등 록</font></td>
													</tr>
													<tr align="center" height="30">
														<td width="150" bgcolor="#eeeeee">작업제목</td>
														<td ><input type="text" class="box" name="title" size="40">&nbsp;예) 메인 상단 검색바 위치 이동</td>
													</tr>
													<tr align="center" height="30">
														<td width="150" bgcolor="#eeeeee">파일명</td>
														<td ><input type="text" class="box" name="filename" size="35">&nbsp;예) index.php , admin/goods_write.php</td>
													</tr>
													<tr align="center">
														<td width="150" bgcolor="#eeeeee">작업 상세내용</td>
														<td ><textarea class="box" name="content" rows="10" cols="50"></textarea></td>
													</tr>
													<tr align="center">
														<td width="150" bgcolor="#eeeeee">주의사항</td>
														<td ><textarea class="box" name="notice" rows="5" cols="50"></textarea></td>
													</tr>
													<tr align="center">
														<td colspan="2" bgcolor="#eeeeee" height><input type="button" class="button" value="등 록" onclick="document.form1.submit();"></td>
													</tr>
												</table></form>
											</td>
										</tr>
									</table>
								</td>
							</tr>
							<tr>
								<td valign=top><br>
									<table width="95%"  border="0" cellspacing="1" cellpadding="3" align="center" bgcolor=''>
										<tr>
											<td>
												<table border=0 align="center" cellspacing="3" cellpadding="0" width="800" class="table_coll">
													<tr align="center">
														<td colspan="6" bgcolor="#3D179C" height=30><font color="white">소 스 수 정 내 역 보 기&nbsp;&nbsp;</font></td>
													</tr>
													<tr align="center" bgcolor="#eeeeee" height="30">
														<td width="250">작업제목</td>
														<td width="250">파일명</td>
														<td width="100">날짜</td>
														<td width="80">작업상세내용 <br>주의사항보기</td>
														<td width="120">변 경</td>
													</tr><?
													$qry = "SELECT *from userSrcEdit order by idx desc";
													$result = $MySQL->query($qry);
													while ($row = mysql_fetch_array($result))
													{
														$cnt++;
														?>
													<form name="form_<?=$cnt?>" method="post" action="help_src_ok.php?edit=1">
													<input type="hidden" name="idx" value="<?=$row[idx]?>">
													<tr align="center" height="30">
														<td><input type="text" class="box" name="title" value="<?=$row[title]?>" size="35"></td>
														<td><input type="text" class="box" name="filename" value="<?=$row[filename]?>" size="35"></td>
														<td><?=substr($row[writeday],0,16)?></td>
														<td id="td_<?=$cnt?>" onclick="	menu_show(<?=$cnt?>);" style="cursor:pointer">▼</td>
														<td><img src="image/edit_btn.gif" onclick="document.form_<?=$cnt?>.submit();" style="cursor:pointer">&nbsp;&nbsp;&nbsp;<img src="image/delete_btn.gif" onclick="if (confirm('삭제하시겠습니까?')) { location.href='help_src_ok.php?del=1&idx=<?=$row[idx]?>' }" style="cursor:pointer"></td>
													</tr>
													<tr id="menu_id<?=$cnt?>" style="display:none";>
														<td colspan="5" bgcolor="ffffff">
															<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
																<tr align="center" height="25" >
																	<td width="50%" >작업 상세내역</td>
																	<td width="50%">주의사항</td>
																</tr>
																<tr align="center">
																	<td width=50%><textarea class="box" name="content" rows="10" cols="50"><?=$row[content]?></textarea></td>
																	<td width=50%><textarea class="box" name="notice" rows="10" cols="50"><?=$row[notice]?></textarea></td>
																</tr>
															</table>
														</td>
													</tr>
													</form><?
													}
													?>
												</table>
											</td>
										</tr>
									</table>
								</td>
							</tr>
						</table><br>
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>
<? include "copy.php";?>
</body>
</html>