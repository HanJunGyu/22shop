<?
include "head.php";
function _gm_counter($gm_year,$gm_month,$gm_day)
{
	global $MySQL;
	if($gm_year) $where_array[]="gm_year='$gm_year'";
	if($gm_month) $where_array[]="gm_month='$gm_month'";
	if($gm_day) $where_array[]="gm_day='$gm_day'";
	$where_qry=count($where_array)?"where ".implode(" and ",$where_array):"";
	$result=$MySQL->query("SELECT count(distinct(gm_session_id)) as a, gm_week as b FROM GM_Counter $where_qry GROUP BY gm_week ORDER BY gm_week ASC");
	while ($row = mysql_fetch_array($result))
	{
		$r[$row[b]] = $row[a];
		$r[7] += $row[a];
	}
	return $r;
}

if(date('Ymd')>$gm_year.$gm_month.$gm_day)
{
	$gm_year=$gm_year?$gm_year:date('Y');
	$gm_month=$gm_month?$gm_month:date('m');
	$gm_day=$gm_day?$gm_day:date('d');
}
else
{
	$gm_year=date('Y');
	$gm_month=date('m');
	$gm_day=date('d');
}
?>
<body bgcolor="#FFFFFF" text="#5A595A" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<? include "top_menu.php"; ?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr><?
	$__TOP_MENU = "gm_counter";     //왼쪽 소메뉴 설정 변수
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
								<td rowspan="3" width="200"><img src="image/log_tit_img.gif"></td>
								<td>&nbsp;</td>
							</tr>
							<tr>
								<td bgcolor="#E6E6E6" height='26'><div align='right'><font class='text1'>SHOP 접속통계 현황을 보실수 있습니다.&nbsp;</div></td>
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
								<td width='440'><img src="image/log_tit_week.gif"></td>
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
					<td valign="top"><form method='post' action="<?= $_SERVER[PHP_SELF]?>">
						<table width="700" border="0" cellspacing="0" cellpadding="0" align="center">
							<tr>
								<td align="right" style="padding:3 0 3 0"><img src="image/btn_month.gif" style='cursor:hand' onclick="document.location.href='<?= $_SERVER[PHP_SELF]?>'"> <select name="gm_year"><?
								for($i=date('Y');$i>date('Y')-6;$i--)
								{
									$gm_year_sel[$gm_year]="selected";
									?><option value="<?= $i?>" <?= $gm_year_sel[$i]?>><?= $i?>년</option><?
								}
								?></select> <select name="gm_month"><?
								for($i=1;$i<13;$i++)
								{

									$gm_month_sel[$gm_month]="selected";
									?><option value="<?= sprintf("%02d",$i)?>" <?= $gm_month_sel[sprintf("%02d",$i)]?>><?= sprintf("%02d",$i)?>월</option><?
								}
								?></select> <input type="image" src="image/goods_view_move.gif"></td>
							</tr>
						</table></form><?
						$mon1=$gm_year.$gm_month;
						$mon2=date("Ym",mktime(0,0,0,$gm_month-1, $gm_day, $gm_year));
						$mon3=date("Ym",mktime(0,0,0,$gm_month-2, $gm_day, $gm_year));

						$_mon1=_gm_counter(substr($mon1,0,4),substr($mon1,4,2),0);
						$_mon2=_gm_counter(substr($mon2,0,4),substr($mon2,4,2),0);
						$_mon3=_gm_counter(substr($mon3,0,4),substr($mon3,4,2),0);

						$_total=_gm_counter(0,0,0);
						?>
						<table width="700" border="0" cellspacing="1" cellpadding="0" align="center" bgcolor="#CCCCCC">
							<tr bgcolor="#FFFFFF" align="center">
								<td width='232' style="padding:5 0 5 0" bgcolor="#FFFFCC"><?=substr($mon1,0,4)?>-<?=substr($mon1,4,2)?></td>
								<td width='232' bgcolor="#EEEEEE"><?=substr($mon2,0,4)?>-<?=substr($mon2,4,2)?></td>
								<td width='232' bgcolor="#EEEEEE"><?=substr($mon3,0,4)?>-<?=substr($mon3,4,2)?></td>
							</tr>
							<tr>
								<td bgcolor="#FFFFCC" style='padding:8 11 8 11'>
									<table width="210" border="0" cellspacing="0" cellpadding="0">
										<tr>
											<td height='128' background="./image/gm_counter_week_bg.gif" valign='bottom'>
												<table border="0" cellspacing="0" cellpadding="0" height='128'>
													<tr><?
													for($h=0;$h<7;$h++)
													{
														$height=$_mon1[7]?round(($_mon1[$h]/$_mon1[7])*100)-8:'0';
														$img_top=$_mon1[$h]?"<img src='./image/gm_counter_week_top.gif' width='15' height='4' title='방문자 ".$_mon1[$h]."'>":"";
														$img_bottom=$_mon1[$h]?"<img src='./image/gm_counter_week_bottom.gif' width='15' height='4' title='방문자 ".$_mon1[$h]."'>":"";
														$img_mak=$_mon1[$h]?"<img src='./image/gm_counter_week_mak.gif' width='15' height='$height' title='방문자 ".$_mon1[$h]."'>":"";
														?>
														<td width='30' align='right' valign='bottom' style='padding:0 0 18 0'><?= $img_top?><br><?= $img_mak?><br><?= $img_bottom?></td><?
													}
													?>
													</tr>
												</table>
											</td>
										</tr>
									</table>
								</td>
								<td bgcolor="#EEEEEE" style='padding:8 11 8 11'>
									<table width="210" border="0" cellspacing="0" cellpadding="0">
										<tr>
											<td height='128' background="./image/gm_counter_week_bg.gif" valign='bottom'>
												<table border="0" cellspacing="0" cellpadding="0" height='128'>
													<tr><?
													for($h=0;$h<7;$h++)
													{
														$height=$_mon2[7]?round(($_mon2[$h]/$_mon2[7])*100)-8:'0';
														$img_top=$_mon2[$h]?"<img src='./image/gm_counter_week_top.gif' width='15' height='4' title='방문자 ".$_mon2[$h]."'>":"";
														$img_bottom=$_mon2[$h]?"<img src='./image/gm_counter_week_bottom.gif' width='15' height='4' title='방문자 ".$_mon2[$h]."'>":"";
														$img_mak=$_mon2[$h]?"<img src='./image/gm_counter_week_mak.gif' width='15' height='$height' title='방문자 ".$_mon2[$h]."'>":"";
														?>
														<td width='30' align='right' valign='bottom' style='padding:0 0 18 0'><?= $img_top?><br><?= $img_mak?><br><?= $img_bottom?></td><?
													}
													?>
													</tr>
												</table>
											</td>
										</tr>
									</table>
								</td>
								<td bgcolor="#EEEEEE" style='padding:8 11 8 11'>
									<table width="210" border="0" cellspacing="0" cellpadding="0">
										<tr>
											<td height='128' background="./image/gm_counter_week_bg.gif" valign='bottom'>
												<table border="0" cellspacing="0" cellpadding="0" height='128'>
													<tr><?
													for($h=0;$h<7;$h++)
													{
														$height=$_mon3[7]?round(($_mon3[$h]/$_mon3[7])*100)-8:'0';
														$img_top=$_mon3[$h]?"<img src='./image/gm_counter_week_top.gif' width='15' height='4' title='방문자 ".$_mon3[$h]."'>":"";
														$img_bottom=$_mon3[$h]?"<img src='./image/gm_counter_week_bottom.gif' width='15' height='4' title='방문자 ".$_mon3[$h]."'>":"";
														$img_mak=$_mon3[$h]?"<img src='./image/gm_counter_week_mak.gif' width='15' height='$height' title='방문자 ".$_mon3[$h]."'>":"";
														?>
														<td width='30' align='right' valign='bottom' style='padding:0 0 18 0'><?= $img_top?><br><?= $img_mak?><br><?= $img_bottom?></td><?
													}
													?>
													</tr>
												</table>
											</td>
										</tr>
									</table>
								</td>
							</tr>
						</table><br>
						<table width="232" border="0" cellspacing="1" cellpadding="0" align="center" bgcolor="#CCCCCC">
							<tr bgcolor="#FFFFFF" align="center">
								<td width='232' style="padding:5 0 5 0" bgcolor="#DBDBDB">전체</td>
							</tr>
							<tr>
								<td bgcolor="#DBDBDB" style='padding:8 11 8 11'>
									<table width="210" border="0" cellspacing="0" cellpadding="0">
										<tr>
											<td height='128' background="./image/gm_counter_week_bg.gif" valign='bottom'>
												<table border="0" cellspacing="0" cellpadding="0" height='128'>
													<tr><?
													for($h=0;$h<7;$h++)
													{
														$height=$_total[7]?round(($_total[$h]/$_total[7])*100)-4:'0';
														$img_top=$_total[$h]?"<img src='./image/gm_counter_week_top.gif' width='15' height='4' title='방문자 ".$_total[$h]."'>":"";
														$img_bottom=$_total[$h]?"<img src='./image/gm_counter_week_bottom.gif' width='15' height='4' title='방문자 ".$_total[$h]."'>":"";
														$img_mak=$_total[$h]?"<img src='./image/gm_counter_week_mak.gif' width='15' height='$height' title='방문자 ".$_total[$h]."'>":"";
														?>
														<td width='30' align='right' valign='bottom' style='padding:0 0 18 0'><?= $img_top?><br><?= $img_mak?><br><?= $img_bottom?></td><?
													}
													?>
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