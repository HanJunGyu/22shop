<?
include "head.php";
$start_counter = $MySQL->fetch_array("SELECT min(concat(gm_year,gm_month,gm_day,gm_hour)) FROM GM_Counter");
function _gm_counter($gm_year,$gm_month,$gm_day,$gm_week)
{
	global $MySQL;
	if($gm_year) $where_array[]="gm_year='$gm_year'";
	if($gm_month) $where_array[]="gm_month='$gm_month'";
	if($gm_day) $where_array[]="gm_day='$gm_day'";
	if($gm_week) $where_array[]="gm_week='$gm_week'";
	$where_qry=count($where_array)?"where ".implode(" and ",$where_array):"";
	$r=$MySQL->fetch_array("SELECT count(distinct(gm_session_id)) as a, sum(gm_page_view) as b FROM GM_Counter $where_qry");
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

if($init)
{
	$MySQL->query("TRUNCATE TABLE GM_Counter");
}
?>
<SCRIPT LANGUAGE="JavaScript">
<!--
function initLog()
{
	var choose = confirm("현재 까지의 모든 로그가 삭제됩니다.\n\n삭제 하시겠습니까?");
	if(choose)
	{
		location.href="<?= $_SERVER[PHP_SELF]?>?init=1";
	}
}
//-->
</SCRIPT>
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
								<td width='440'><img src="image/log_tit.gif"></td>
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
								<td align="right" style="padding:3 0 3 0"><img src="image/btn_today.gif" onclick="document.location.href='<?= $_SERVER[PHP_SELF]?>'" style='cursor:hand'> <select name="gm_year"><?
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

						$_day1=_gm_counter(substr($day1,0,4),substr($day1,4,2),substr($day1,6,2),0);
						$_day2=_gm_counter(substr($day2,0,4),substr($day2,4,2),substr($day2,6,2),0);
						$_day3=_gm_counter(substr($day3,0,4),substr($day3,4,2),substr($day3,6,2),0);

						$ctime1 = ($day1==date('Ymd'))?date('G')+1:24;
						if($day1==substr($start_counter[0],0,8))
						{
							$ctime1 = $ctime1-substr($start_counter[0],8,2);
						}
						$ctime2 = ($day2==date('Ymd'))?date('G')+1:24;
						if($day2==substr($start_counter[0],0,8))
						{
							$ctime2 = $ctime2-substr($start_counter[0],8,2);
						}
						$ctime3 = ($day3==date('Ymd'))?date('G')+1:24;
						if($day3==substr($start_counter[0],0,8))
						{
							$ctime3 = $ctime3-substr($start_counter[0],8,2);
						}
						$mon1=$gm_year.$gm_month;
						$cday1 = ($mon1==date('Ym'))?date('j'):date("t",mktime(0,0,0,$gm_month, $gm_day, $gm_year));
						if($mon1==substr($start_counter[0],0,6))
						{
							$cday1 = $cday1-substr($start_counter[0],6,2)+1;
							$cdayt1 = (24*($cday1-1))+(date('G')-substr($start_counter[0],8,2)+1);
						}
						else
						{
							$cdayt1 = 24*$cday1;
						}

						$mon2=date("Ym",mktime(0,0,0,$gm_month-1, $gm_day, $gm_year));
						$cday2 = ($mon2==date('Ym'))?date('j'):date("t",mktime(0,0,0,$gm_month-1, $gm_day, $gm_year));
						if($mon2==substr($start_counter[0],0,6))
						{
							$cday2 = $cday2-substr($start_counter[0],6,2)+1;
							$cdayt2 = (24*($cday2-1))+(date('G')-substr($start_counter[0],8,2)+1);
						}
						else
						{
							$cdayt2 = 24*$cday2;
						}

						$mon3=date("Ym",mktime(0,0,0,$gm_month-2, $gm_day, $gm_year));
						$cday3 = ($mon3==date('Ym'))?date('j'):date("t",mktime(0,0,0,$gm_month-2, $gm_day, $gm_year));
						if($mon3==substr($start_counter[0],0,6))
						{
							$cday3 = $cday3-substr($start_counter[0],6,2)+1;
							$cdayt3 = (24*($cday3-1))+(date('G')-substr($start_counter[0],8,2)+1);
						}
						else
						{
							$cdayt3 = 24*$cday3;
						}

						$_mon1=_gm_counter(substr($mon1,0,4),substr($mon1,4,2),0,0);
						$_mon2=_gm_counter(substr($mon2,0,4),substr($mon2,4,2),0,0);
						$_mon3=_gm_counter(substr($mon3,0,4),substr($mon3,4,2),0,0);

						$_total=_gm_counter(0,0,0,0);
						$start_date = substr($start_counter[0],0,4)."-".substr($start_counter[0],4,2)."-".substr($start_counter[0],6,2);
						$_total_day=((strtotime(date('Y-m-d'))-strtotime($start_date))/86400)+1;
						$_total_time = (24*($_total_day-1))+(date('G')-substr($start_counter[0],8,2)+1);
						?>
						<table width="700" border="0" cellspacing="1" cellpadding="0" align="center" bgcolor="#CCCCCC">
							<tr bgcolor="#FFFFFF" align="center">
								<td width='165' style="padding:5 0 5 0">&nbsp;</td>
								<td width='80' bgcolor="#FFFFCC"><?= $week1?>요일 <?=substr($day1,4,2)?>-<?=substr($day1,6,2)?></td>
								<td width='80' bgcolor="#EEEEEE"><?= $week2?>요일 <?=substr($day2,4,2)?>-<?=substr($day2,6,2)?></td>
								<td width='80' bgcolor="#EEEEEE"><?= $week3?>요일 <?=substr($day3,4,2)?>-<?=substr($day3,6,2)?></td>
								<td width='20'></td>
								<td width='60' bgcolor="#FFFFCC"><?=substr($mon1,0,4)?>-<?=substr($mon1,4,2)?></td>
								<td width='60' bgcolor="#EEEEEE"><?=substr($mon2,0,4)?>-<?=substr($mon2,4,2)?></td>
								<td width='60' bgcolor="#EEEEEE"><?=substr($mon3,0,4)?>-<?=substr($mon3,4,2)?></td>
								<td width='20'></td>
								<td width='75' bgcolor="#DBDBDB">전체</td>
							</tr>
							<tr>
								<td bgcolor="#FFFFFF" align="right" style="padding:4 5 4 0">고유방문자</td>
								<td bgcolor="#FFFFCC" style="padding:4 0 4 5"><?= number_format($_day1[a])?></td>
								<td bgcolor="#EEEEEE" style="padding:4 0 4 5"><?= number_format($_day2[a])?></td>
								<td bgcolor="#EEEEEE" style="padding:4 0 4 5"><?= number_format($_day3[a])?></td>
								<td bgcolor="#FFFFFF"></td>
								<td bgcolor="#FFFFCC" style="padding:4 0 4 5"><?= number_format($_mon1[a])?></td>
								<td bgcolor="#EEEEEE" style="padding:4 0 4 5"><?= number_format($_mon2[a])?></td>
								<td bgcolor="#EEEEEE" style="padding:4 0 4 5"><?= number_format($_mon3[a])?></td>
								<td bgcolor="#FFFFFF"></td>
								<td bgcolor="#DBDBDB" style="padding:4 0 4 5"><?= number_format($_total[a])?></td>
							</tr>
							<tr>
								<td bgcolor="#FFFFFF" align="right" style="padding:4 5 4 0">페이지뷰</td>
								<td bgcolor="#FFFFCC" style="padding:4 0 4 5"><?= number_format($_day1[b])?></td>
								<td bgcolor="#EEEEEE" style="padding:4 0 4 5"><?= number_format($_day2[b])?></td>
								<td bgcolor="#EEEEEE" style="padding:4 0 4 5"><?= number_format($_day3[b])?></td>
								<td bgcolor="#FFFFFF"></td>
								<td bgcolor="#FFFFCC" style="padding:4 0 4 5"><?= number_format($_mon1[b])?></td>
								<td bgcolor="#EEEEEE" style="padding:4 0 4 5"><?= number_format($_mon2[b])?></td>
								<td bgcolor="#EEEEEE" style="padding:4 0 4 5"><?= number_format($_mon3[b])?></td>
								<td bgcolor="#FFFFFF"></td>
								<td bgcolor="#DBDBDB" style="padding:4 0 4 5"><?= number_format($_total[b])?></td>
							</tr>
							<tr>
								<td bgcolor="#FFFFFF" align="right" style="padding:4 5 4 0">방문자당 평균 페이지뷰</td>
								<td bgcolor="#FFFFCC" style="padding:4 0 4 5"><?= $_day1[a]?number_format(round($_day1[b]/$_day1[a])):0?></td>
								<td bgcolor="#EEEEEE" style="padding:4 0 4 5"><?= $_day2[a]?number_format(round($_day2[b]/$_day2[a])):0?></td>
								<td bgcolor="#EEEEEE" style="padding:4 0 4 5"><?= $_day3[a]?number_format(round($_day3[b]/$_day3[a])):0?></td>
								<td bgcolor="#FFFFFF"></td>
								<td bgcolor="#FFFFCC" style="padding:4 0 4 5"><?= $_mon1[a]?number_format(round($_mon1[b]/$_mon1[a])):0?></td>
								<td bgcolor="#EEEEEE" style="padding:4 0 4 5"><?= $_mon2[a]?number_format(round($_mon2[b]/$_mon2[a])):0?></td>
								<td bgcolor="#EEEEEE" style="padding:4 0 4 5"><?= $_mon3[a]?number_format(round($_mon3[b]/$_mon3[a])):0?></td>
								<td bgcolor="#FFFFFF"></td>
								<td bgcolor="#DBDBDB" style="padding:4 0 4 5"><?= $_total[a]?number_format(round($_total[b]/$_total[a])):0?></td>
							</tr>
							<tr>
								<td bgcolor="#FFFFFF" align="right" style="padding:4 5 4 0">하루 평균 고유방문자</td>
								<td bgcolor="#FFFFCC" style="padding:4 0 4 5">-</td>
								<td bgcolor="#EEEEEE" style="padding:4 0 4 5">-</td>
								<td bgcolor="#EEEEEE" style="padding:4 0 4 5">-</td>
								<td bgcolor="#FFFFFF"></td>
								<td bgcolor="#FFFFCC" style="padding:4 0 4 5"><?= number_format(round($_mon1[a]/$cday1))?></td>
								<td bgcolor="#EEEEEE" style="padding:4 0 4 5"><?= number_format(round($_mon2[a]/$cday2))?></td>
								<td bgcolor="#EEEEEE" style="padding:4 0 4 5"><?= number_format(round($_mon3[a]/$cday3))?></td>
								<td bgcolor="#FFFFFF"></td>
								<td bgcolor="#DBDBDB" style="padding:4 0 4 5"><?= number_format(round($_total[a]/$_total_day))?></td>
							</tr>
							<tr>
								<td bgcolor="#FFFFFF" align="right" style="padding:4 5 4 0">하루 평균 페이지뷰</td>
								<td bgcolor="#FFFFCC" style="padding:4 0 4 5">-</td>
								<td bgcolor="#EEEEEE" style="padding:4 0 4 5">-</td>
								<td bgcolor="#EEEEEE" style="padding:4 0 4 5">-</td>
								<td bgcolor="#FFFFFF"></td>
								<td bgcolor="#FFFFCC" style="padding:4 0 4 5"><?= number_format(round($_mon1[b]/$cday1))?></td>
								<td bgcolor="#EEEEEE" style="padding:4 0 4 5"><?= number_format(round($_mon2[b]/$cday2))?></td>
								<td bgcolor="#EEEEEE" style="padding:4 0 4 5"><?= number_format(round($_mon3[b]/$cday3))?></td>
								<td bgcolor="#FFFFFF"></td>
								<td bgcolor="#DBDBDB" style="padding:4 0 4 5"><?= number_format(round($_total[b]/$_total_day))?></td>
							</tr>
							<tr>
								<td bgcolor="#FFFFFF" align="right" style="padding:4 5 4 0">시간당 평균 고유방문자</td>
								<td bgcolor="#FFFFCC" style="padding:4 0 4 5"><?= number_format(round($_day1[a]/$ctime1))?></td>
								<td bgcolor="#EEEEEE" style="padding:4 0 4 5"><?= number_format(round($_day2[a]/$ctime2))?></td>
								<td bgcolor="#EEEEEE" style="padding:4 0 4 5"><?= number_format(round($_day3[a]/$ctime3))?></td>
								<td bgcolor="#FFFFFF"></td>
								<td bgcolor="#FFFFCC" style="padding:4 0 4 5"><?= number_format(round($_mon1[a]/$cdayt1))?></td>
								<td bgcolor="#EEEEEE" style="padding:4 0 4 5"><?= number_format(round($_mon2[a]/$cdayt2))?></td>
								<td bgcolor="#EEEEEE" style="padding:4 0 4 5"><?= number_format(round($_mon3[a]/$cdayt3))?></td>
								<td bgcolor="#FFFFFF"></td>
								<td bgcolor="#DBDBDB" style="padding:4 0 4 5"><?= number_format(round($_total[a]/$_total_time))?></td>
							</tr>
							<tr>
								<td bgcolor="#FFFFFF" align="right" style="padding:4 5 4 0">시간당 평균 페이지뷰</td>
								<td bgcolor="#FFFFCC" style="padding:4 0 4 5"><?= number_format(round($_day1[b]/$ctime1))?></td>
								<td bgcolor="#EEEEEE" style="padding:4 0 4 5"><?= number_format(round($_day2[b]/$ctime2))?></td>
								<td bgcolor="#EEEEEE" style="padding:4 0 4 5"><?= number_format(round($_day3[b]/$ctime3))?></td>
								<td bgcolor="#FFFFFF"></td>
								<td bgcolor="#FFFFCC" style="padding:4 0 4 5"><?= number_format(round($_mon1[b]/$cdayt1))?></td>
								<td bgcolor="#EEEEEE" style="padding:4 0 4 5"><?= number_format(round($_mon2[b]/$cdayt2))?></td>
								<td bgcolor="#EEEEEE" style="padding:4 0 4 5"><?= number_format(round($_mon3[b]/$cdayt3))?></td>
								<td bgcolor="#FFFFFF"></td>
								<td bgcolor="#DBDBDB" style="padding:4 0 4 5"><?= number_format(round($_total[b]/$_total_time))?></td>
							</tr>
						</table><br>
						<table width="250" border="0" cellspacing="0" cellpadding="0" align="center">
							<tr>
								<td><div align="center"><a href="javascript:initLog();"><img src="image/log_btn1.gif" width="83" height="31" border="0"></a></div></td>
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