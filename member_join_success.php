<?
include "head.php";
if(!defined(__ADMIN_ROW))
{
	define(__ADMIN_ROW,"TRUE");
	$admin_row=$MySQL->fetch_array("select *from admin limit 0,1");
}
$vars=explode("&",base64_decode($jdata));
$vars_num=count($vars);
for($i=0;$i<$vars_num;$i++)
{
	$elements=explode("=",$vars[$i]);
	$jdataArr[$elements[0]]=$elements[1];
}
if($admin_row[xJoin_bhtml])
{
	$xJoin = $admin_row[xJoin];
}
else
{
	$xJoin = nl2br(htmlspecialchars($admin_row[xJoin]));
}
?>
<? include "top.php";?>
<table width="900" border="0" cellspacing="0" cellpadding="0" bgcolor="<?=$ALL_BGCOLOR?>">
	<tr>
		<? include "left_menu.php";?>
		<td valign="top" bgcolor="#FFFFFF">
			<table width="720" height="100%" border="0" cellspacing="0" cellpadding="0">
				<tr bgcolor="#FFFFFF" valign="top">
					<td colspan="2" height="30">
						<table width="720" height="27" border="0" cellspacing="0" cellpadding="0" align='center'>
							<tr>
								<td width="2" bgcolor="<?=$subdesign[bc4]?>" rowspan="2"></td>
								<td width="2" bgcolor="<?=$subdesign[bc4]?>" rowspan="2"></td>
								<td width="220" height="27" bgcolor="<?=$subdesign[bc4]?>"><img src="./upload/design/<?=$subdesign[img4]?>" ></td>
								<td width="490" height="27" bgcolor="<?=$subdesign[bc4]?>"><div align="right"> &nbsp;<font color="<?=$subdesign[tc4]?>"> <img src='image/good/icon0.gif'>&nbsp;현재위치 : HOME &gt; 회원가입 완료&nbsp;</font></div></td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td valign="top"><br>
						<table border="0" cellspacing="1" cellpadding="0" align="center" bgcolor="#ffffff" align='center'>
							<tr>
								<td bgcolor="#FFFFFF" valign="top">
									<table width="650" height="300" border="0" cellspacing="0" cellpadding="0" background='image/index/search_bg.gif'>
										<tr>
											<td>&nbsp;</td>
										</tr>
										<tr>
											<td>
												<table width="550" border="0" cellspacing="0" cellpadding="5" align='center'>
													<tr>
														<td><font color="#FF9900"><b><?=$jdataArr[jName]?></b></font> 회원님!</td>
													</tr>
													<tr>
														<td><?=$xJoin?></td>
													</tr>
												</table>
											</td>
										</tr>
										<tr>
											<td>
												<table width="300" border="0" cellspacing="0" cellpadding="0" align='center'>
													<tr>
														<td>
															<table width="280" border="0" cellspacing="1" cellpadding="5" bgcolor='d7d7d7' align='center' height='80'>
																<tr>
																	<td bgcolor='f7f7f7'><div align="center">고객님의 회원 ID는 <b><font color="#FF9900"><?=$jdataArr[jUserid]?></font></b> 이며<br><br>비밀번호는 <b><font color="#FF9900"><?=substr($jdataArr[jPwd],0,1)?><?
																	for($i=0;$i<strlen($jdataArr[jPwd])-1;$i++)
																	{
																		echo "*";
																	}
																	?></font></b> 입니다.</div></td>
																</tr>
															</table>
														</td>
													</tr>
													<form method="post" action="login_ok.php">
													<input type="hidden" name="jdata" value="<?=$jdata?>">
													<tr>
														<td height="80"><div align="center"><input type="image" src="image/member/member_join_login.gif" border="0"></div></td>
													</tr></form>
												</table>
											</td>
										</tr>
										<tr>
											<td>&nbsp;</td>
										</tr>
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
<? include "copy.php"; ?>
</div>
</body>
</html>