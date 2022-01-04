<?
include "head.php";
if ($qry)
{
	$qry = str_replace("\\","",$qry);
	if ($MySQL->query($qry))
	{
		OnlyMsgView("실행 되었습니다.");
	}
	else
	{
		$errMsg =  "쿼리실행에러 : ".mysql_error();
		OnlyMsgView("실패 하였습니다.");
	}
}
?>
<SCRIPT LANGUAGE="JavaScript">
<!--
function qry_start()
{
	<? if (__DEMOPAGE) { ?>
	alert("데모페이지에서는 본기능이 제한되어있습니다.");
	<? }else { ?>
	if (confirm("쿼리를 실행하시겠습니까?"))
	{
		document.qry_form.submit();
	}
	<? } ?>
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
											<td width='440' height=30><img src="image/adm_icon.gif"> SQL 실행기</td>
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
											<td colspan="2"><br><? if ($errMsg) echo $errMsg."<BR>"; ?>
												<form name="qry_form" method="post" action="<?=$PHP_SELF?>">
												<table width="80%" border="0" align="center" cellpadding="3" cellspacing="1" bgcolor='E6E6E6'>
													<tr align="center">
														<td height="30" bgcolor='082042'><font color='ffffff'><b>S&nbsp;&nbsp;Q&nbsp;&nbsp;L&nbsp;&nbsp;쿼&nbsp;&nbsp;리&nbsp;&nbsp;실&nbsp;&nbsp;행&nbsp;&nbsp;기</b></td>
													<tr>
													<tr align="center">
														<td><textarea name="qry" cols="80" rows="10"><?=$qry?></textarea><br><input type="button" class="text" value=" 실 행 " onclick="qry_start();"></td>
													</tr>
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