<?
include "head.php";
function _gm_counter($gm_year,$gm_month,$gm_day)
{
	global $MySQL;
	if($gm_year) $where_array[]="gm_year='$gm_year'";
	if($gm_month) $where_array[]="gm_month='$gm_month'";
	if($gm_day) $where_array[]="gm_day='$gm_day'";
	$where_qry=count($where_array)?"where ".implode(" and ",$where_array):"";
	$result=$MySQL->query("SELECT count(distinct(gm_session_id)) as a, gm_http_referer as b FROM GM_Counter $where_qry GROUP BY gm_http_referer ORDER BY a DESC, binary(gm_http_referer) ASC");
	$loop = 0;
	while ($row = mysql_fetch_array($result))
	{
		$r[$loop][a] = $row[a];
		$r[$loop][b] = $row[b];
		$r[total] += $row[a];
		$loop++;
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
								<td width='440'><img src="image/log_tit_referer.gif"></td>
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
								<td align="right" style="padding:3 0 3 0"><img src="image/btn_today.gif" style='cursor:hand' onclick="document.location.href='<?= $_SERVER[PHP_SELF]?>'"> <select name="gm_year"><?
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
								?></select> <select name="gm_day"><?
								for($i=1;$i<32;$i++)
								{

									$gm_day_sel[$gm_day]="selected";
									?><option value="<?= sprintf("%02d",$i)?>" <?= $gm_day_sel[sprintf("%02d",$i)]?>><?= sprintf("%02d",$i)?>일</option><?
								}
								?></select> <input type="image" src="image/goods_view_move.gif"></td>
							</tr>
						</table></form><?
						$day1=$gm_year.$gm_month.$gm_day;
						$week = date("w",mktime(0,0,0,$gm_month, $gm_day, $gm_year));
						$week1 = $WEEK_ARR[$week];

						$day2=date("Ymd",mktime(0,0,0,$gm_month, $gm_day-1, $gm_year));
						$week = date("w",mktime(0,0,0,$gm_month, $gm_day-1, $gm_year));
						$week2 = $WEEK_ARR[$week];

						$day3=date("Ymd",mktime(0,0,0,$gm_month, $gm_day-2, $gm_year));
						$week = date("w",mktime(0,0,0,$gm_month, $gm_day-2, $gm_year));
						$week3 = $WEEK_ARR[$week];

						$_day1=_gm_counter(substr($day1,0,4),substr($day1,4,2),substr($day1,6,2));
						$_day2=_gm_counter(substr($day2,0,4),substr($day2,4,2),substr($day2,6,2));
						$_day3=_gm_counter(substr($day3,0,4),substr($day3,4,2),substr($day3,6,2));

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
								<td width='232' style="padding:5 0 5 0" bgcolor="#FFFFCC"><?= $week1?>요일 <?=substr($day1,4,2)?>-<?=substr($day1,6,2)?></td>
								<td width='232' bgcolor="#EEEEEE"><?= $week2?>요일 <?=substr($day2,4,2)?>-<?=substr($day2,6,2)?></td>
								<td width='232' bgcolor="#EEEEEE"><?= $week3?>요일 <?=substr($day3,4,2)?>-<?=substr($day3,6,2)?></td>
							</tr>
							<tr>
								<td bgcolor="#FFFFCC" style='padding:8 8 8 8' valign='top'>
									<table width="216" border="0" cellspacing="1" cellpadding="0" bgcolor="#CCCCCC"><?
									for($i=0;$i<6;$i++)
									{
										if($_day1[$i][a])
										{
											?>
										<tr bgcolor="#FFFFCC">
											<td width='30' style='padding:2 0 2 2'><?= $_day1[$i][a]?></td>
											<td width='32' style='padding:2 0 2 2'><?= round(($_day1[$i][a]/$_day1[total])*100)?>%</td>
											<td width='150' style='padding:2 0 2 2'><?= $_day1[$i][b]?"<font onclick=\"window.open('gm_counter_referer_2.php?day=".$day1."&gm_http_referer=".base64_encode($_day1[$i][b])."','','scrollbars=1,resizable=1,width=520,height=300,top=100,left=200')\" style='cursor:pointer'>".$_day1[$i][b]."</font>":"직접입력"?></td>
										</tr><?
										}
									}
									?>
									</table><?
									if(7<count($_day1))
									{
										?>
									<table width="216" border="0" cellspacing="0" cellpadding="0">
										<tr>
											<td align="center"><img src='image/btn_view.gif' style='cursor:hand' onclick="window.open('gm_counter_referer_1.php?day=<?=$day1?>','','scrollbars=1,resizable=1,width=320,height=300,top=100,left=200')"></td>
										</tr>
									</table><?
									}
									?>
								</td>
								<td bgcolor="#EEEEEE" style='padding:8 8 8 8' valign='top'>
									<table width="216" border="0" cellspacing="1" cellpadding="0" bgcolor="#CCCCCC"><?
									for($i=0;$i<6;$i++)
									{
										if($_day2[$i][a])
										{
											?>
										<tr bgcolor="#EEEEEE">
											<td width='30' style='padding:2 0 2 2'><?= $_day2[$i][a]?></td>
											<td width='32' style='padding:2 0 2 2'><?= round(($_day2[$i][a]/$_day2[total])*100)?>%</td>
											<td width='150' style='padding:2 0 2 2'><?= $_day2[$i][b]?"<font onclick=\"window.open('gm_counter_referer_2.php?day=".$day2."&gm_http_referer=".base64_encode($_day2[$i][b])."','','scrollbars=1,resizable=1,width=520,height=300,top=100,left=200')\" style='cursor:pointer'>".$_day2[$i][b]."</font>":"직접입력"?></td>
										</tr><?
										}
									}
									?>
									</table><?
									if(7<count($_day2))
									{
										?>
									<table width="216" border="0" cellspacing="0" cellpadding="0">
										<tr>
											<td align="center"><img src='image/btn_view.gif' style='cursor:hand' onclick="window.open('gm_counter_referer_1.php?day=<?=$day2?>','','scrollbars=1,resizable=1,width=320,height=300,top=100,left=200')"></td>
										</tr>
									</table><?
									}
									?>
								</td>
								<td bgcolor="#EEEEEE" style='padding:8 8 8 8' valign='top'>
									<table width="216" border="0" cellspacing="1" cellpadding="0" bgcolor="#CCCCCC"><?
									for($i=0;$i<6;$i++)
									{
										if($_day3[$i][a])
										{
											?>
										<tr bgcolor="#EEEEEE">
											<td width='30' style='padding:2 0 2 2'><?= $_day3[$i][a]?></td>
											<td width='32' style='padding:2 0 2 2'><?= round(($_day3[$i][a]/$_day3[total])*100)?>%</td>
											<td width='150' style='padding:2 0 2 2'><?= $_day3[$i][b]?"<font onclick=\"window.open('gm_counter_referer_2.php?day=".$day3."&gm_http_referer=".base64_encode($_day3[$i][b])."','','scrollbars=1,resizable=1,width=520,height=300,top=100,left=200')\" style='cursor:pointer'>".$_day3[$i][b]."</font>":"직접입력"?></td>
										</tr><?
										}
									}
									?>
									</table><?
									if(7<count($_day3))
									{
										?>
									<table width="216" border="0" cellspacing="0" cellpadding="0">
										<tr>
											<td align="center"><img src='image/btn_view.gif' style='cursor:hand' onclick="window.open('gm_counter_referer_1.php?day=<?=$day3?>','','scrollbars=1,resizable=1,width=320,height=300,top=100,left=200')"></td>
										</tr>
									</table><?
									}
									?>
								</td>
							</tr>
						</table><br>
						<table width="700" border="0" cellspacing="1" cellpadding="0" align="center" bgcolor="#CCCCCC">
							<tr bgcolor="#FFFFFF" align="center">
								<td width='232' style="padding:5 0 5 0" bgcolor="#FFFFCC"><?=substr($mon1,0,4)?>-<?=substr($mon1,4,2)?></td>
								<td width='232' bgcolor="#EEEEEE"><?=substr($mon2,0,4)?>-<?=substr($mon2,4,2)?></td>
								<td width='232' bgcolor="#EEEEEE"><?=substr($mon3,0,4)?>-<?=substr($mon3,4,2)?></td>
							</tr>
							<tr>
								<td bgcolor="#FFFFCC" style='padding:8 8 8 8' valign='top'>
									<table width="216" border="0" cellspacing="1" cellpadding="0" bgcolor="#CCCCCC"><?
									for($i=0;$i<6;$i++)
									{
										if($_mon1[$i][a])
										{
											?>
										<tr bgcolor="#FFFFCC">
											<td width='30' style='padding:2 0 2 2'><?= $_mon1[$i][a]?></td>
											<td width='32' style='padding:2 0 2 2'><?= round(($_mon1[$i][a]/$_mon1[total])*100)?>%</td>
											<td width='150' style='padding:2 0 2 2'><?= $_mon1[$i][b]?"<font onclick=\"window.open('gm_counter_referer_2.php?month=".$mon1."&gm_http_referer=".base64_encode($_mon1[$i][b])."','','scrollbars=1,resizable=1,width=520,height=300,top=100,left=200')\" style='cursor:pointer'>".$_mon1[$i][b]."</font>":"직접입력"?></td>
										</tr><?
										}
									}
									?>
									</table><?
									if(7<count($_mon1))
									{
										?>
									<table width="216" border="0" cellspacing="0" cellpadding="0">
										<tr>
											<td align="center"><img src='image/btn_view.gif' style='cursor:hand' onclick="window.open('gm_counter_referer_1.php?month=<?=$mon1?>','','scrollbars=1,resizable=1,width=320,height=300,top=100,left=200')"></td>
										</tr>
									</table><?
									}
									?>
								</td>
								<td bgcolor="#EEEEEE" style='padding:8 8 8 8' valign='top'>
									<table width="216" border="0" cellspacing="1" cellpadding="0" bgcolor="#CCCCCC"><?
									for($i=0;$i<6;$i++)
									{
										if($_mon2[$i][a])
										{
											?>
										<tr bgcolor="#EEEEEE">
											<td width='30' style='padding:2 0 2 2'><?= $_mon2[$i][a]?></td>
											<td width='32' style='padding:2 0 2 2'><?= round(($_mon2[$i][a]/$_mon2[total])*100)?>%</td>
											<td width='150' style='padding:2 0 2 2'><?= $_mon2[$i][b]?"<font onclick=\"window.open('gm_counter_referer_2.php?month=".$mon2."&gm_http_referer=".base64_encode($_mon2[$i][b])."','','scrollbars=1,resizable=1,width=520,height=300,top=100,left=200')\" style='cursor:pointer'>".$_mon2[$i][b]."</font>":"직접입력"?></td>
										</tr><?
										}
									}
									?>
									</table><?
									if(7<count($_mon2))
									{
										?>
									<table width="216" border="0" cellspacing="0" cellpadding="0">
										<tr>
											<td align="center"><img src='image/btn_view.gif' style='cursor:hand' onclick="window.open('gm_counter_referer_1.php?month=<?=$mon2?>','','scrollbars=1,resizable=1,width=320,height=300,top=100,left=200')"></td>
										</tr>
									</table><?
									}
									?>
								</td>
								<td bgcolor="#EEEEEE" style='padding:8 8 8 8' valign='top'>
									<table width="216" border="0" cellspacing="1" cellpadding="0" bgcolor="#CCCCCC"><?
									for($i=0;$i<6;$i++)
									{
										if($_mon3[$i][a])
										{
											?>
										<tr bgcolor="#EEEEEE">
											<td width='30' style='padding:2 0 2 2'><?= $_mon3[$i][a]?></td>
											<td width='32' style='padding:2 0 2 2'><?= round(($_mon3[$i][a]/$_mon3[total])*100)?>%</td>
											<td width='150' style='padding:2 0 2 2'><?= $_mon3[$i][b]?"<font onclick=\"window.open('gm_counter_referer_2.php?month=".$mon3."&gm_http_referer=".base64_encode($_mon3[$i][b])."','','scrollbars=1,resizable=1,width=520,height=300,top=100,left=200')\" style='cursor:pointer'>".$_mon3[$i][b]."</font>":"직접입력"?></td>
										</tr><?
										}
									}
									?>
									</table><?
									if(7<count($_mon3))
									{
										?>
									<table width="216" border="0" cellspacing="0" cellpadding="0">
										<tr>
											<td align="center"><img src='image/btn_view.gif' style='cursor:hand' onclick="window.open('gm_counter_referer_1.php?month=<?=$mon3?>','','scrollbars=1,resizable=1,width=320,height=300,top=100,left=200')"></td>
										</tr>
									</table><?
									}
									?>
								</td>
							</tr>
						</table><br>
						<table width="232" border="0" cellspacing="1" cellpadding="0" align="center" bgcolor="#CCCCCC">
							<tr bgcolor="#FFFFFF" align="center">
								<td width='232' style="padding:5 0 5 0" bgcolor="#DBDBDB">전체</td>
							</tr>
							<tr>
								<td bgcolor="#DBDBDB" style='padding:8 8 8 8' valign='top'>
									<table width="216" border="0" cellspacing="1" cellpadding="0" bgcolor="#CCCCCC"><?
									for($i=0;$i<6;$i++)
									{
										if($_total[$i][a])
										{
											?>
										<tr bgcolor="#DBDBDB">
											<td width='30' style='padding:2 0 2 2'><?= $_total[$i][a]?></td>
											<td width='32' style='padding:2 0 2 2'><?= round(($_total[$i][a]/$_total[total])*100)?>%</td>
											<td width='150' style='padding:2 0 2 2'><?= $_total[$i][b]?"<font onclick=\"window.open('gm_counter_referer_2.php?gm_http_referer=".base64_encode($_day1[$i][b])."','','scrollbars=1,resizable=1,width=520,height=300,top=100,left=200')\" style='cursor:pointer'>".$_total[$i][b]."</font>":"직접입력"?></td>
										</tr><?
										}
									}
									?>
									</table><?
									if(7<count($_total))
									{
										?>
									<table width="216" border="0" cellspacing="0" cellpadding="0">
										<tr>
											<td align="center"><img src='image/btn_view.gif' style='cursor:hand' onclick="window.open('gm_counter_referer_1.php','','scrollbars=1,resizable=1,width=320,height=300,top=100,left=200')"></td>
										</tr>
									</table><?
									}
									?>
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