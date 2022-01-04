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

if($day)
{
	if(date('Ymd')>$day)
	{
		$gm_year=substr($day,0,4);
		$gm_month=substr($day,4,2);
		$gm_day=substr($day,6,2);
	}
	else
	{
		$gm_year=date('Y');
		$gm_month=date('m');
		$gm_day=date('d');
	}
}
else if($month)
{
	if(date('Ym')>$month)
	{
		$gm_year=substr($day,0,4);
		$gm_month=substr($day,4,2);
	}
	else
	{
		$gm_year=date('Y');
		$gm_month=date('m');
	}
}
?>
<body bgcolor="#FFFFFF" text="#5A595A" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<?
$day1=$gm_year.$gm_month.$gm_day;
$week = date("w",mktime(0,0,0,$gm_month, $gm_day, $gm_year));
$week1 = $WEEK_ARR[$week];

$_day1=_gm_counter(substr($day1,0,4),substr($day1,4,2),substr($day1,6,2));

$mon1=$gm_year.$gm_month;

$_mon1=_gm_counter(substr($mon1,0,4),substr($mon1,4,2),0);

$_total=_gm_counter(0,0,0);
if($day)
{
?>
<table width="302" border="0" cellspacing="1" cellpadding="0" align="center" bgcolor="#CCCCCC">
	<tr bgcolor="#FFFFFF" align="center">
		<td width='300' style="padding:5 0 5 0" bgcolor="#FFFFCC"><?= $week1?>요일 <?=substr($day1,4,2)?>-<?=substr($day1,6,2)?></td>
	</tr>
	<tr>
		<td bgcolor="#FFFFCC" style='padding:8 8 8 8' valign='top'>
			<table width="284" border="0" cellspacing="1" cellpadding="0" bgcolor="#CCCCCC"><?
			for($i=0;$i<count($_day1);$i++)
			{
				if($_day1[$i][a])
				{
					?>
				<tr bgcolor="#FFFFCC">
					<td width='30' style='padding:2 0 2 2'><?= $_day1[$i][a]?></td>
					<td width='32' style='padding:2 0 2 2'><?= round(($_day1[$i][a]/$_day1[total])*100)?>%</td>
					<td width='218' style='padding:2 0 2 2'><?= $_day1[$i][b]?"<font onclick=\"window.open('gm_counter_referer_2.php?day=".$day1."&gm_http_referer=".base64_encode($_day2[$i][b])."','','scrollbars=1,resizable=1,width=520,height=300,top=100,left=200')\" style='cursor:pointer'>".$_day1[$i][b]."</font>":"직접입력"?></td>
				</tr><?
				}
			}
			?>
			</table>
		</td>
	</tr>
</table><?
}
elseif($month)
{
	?>
<table width="302" border="0" cellspacing="1" cellpadding="0" align="center" bgcolor="#CCCCCC">
	<tr bgcolor="#FFFFFF" align="center">
		<td width='300' style="padding:5 0 5 0" bgcolor="#FFFFCC"><?=substr($mon1,0,4)?>-<?=substr($mon1,4,2)?></td>
	</tr>
	<tr>
		<td bgcolor="#FFFFCC" style='padding:8 8 8 8' valign='top'>
			<table width="284" border="0" cellspacing="1" cellpadding="0" bgcolor="#CCCCCC"><?
			for($i=0;$i<count($_mon1);$i++)
			{
				if($_mon1[$i][a])
				{
					?>
				<tr bgcolor="#FFFFCC">
					<td width='30' style='padding:2 0 2 2'><?= $_mon1[$i][a]?></td>
					<td width='32' style='padding:2 0 2 2'><?= round(($_mon1[$i][a]/$_mon1[total])*100)?>%</td>
					<td width='218' style='padding:2 0 2 2'><?= $_mon1[$i][b]?"<font onclick=\"window.open('gm_counter_referer_2.php?month=".$mon1."&gm_http_referer=".base64_encode($_mon1[$i][b])."','','scrollbars=1,resizable=1,width=520,height=300,top=100,left=200')\" style='cursor:pointer'>".$_mon1[$i][b]."</font>":"직접입력"?></td>
				</tr><?
				}
			}
			?>
			</table>
		</td>
	</tr>
</table><?
}
else
{
	?>
<table width="302" border="0" cellspacing="1" cellpadding="0" align="center" bgcolor="#CCCCCC">
	<tr bgcolor="#FFFFFF" align="center">
		<td width='300' style="padding:5 0 5 0" bgcolor="#DBDBDB">전체</td>
	</tr>
	<tr>
		<td bgcolor="#DBDBDB" style='padding:8 8 8 8' valign='top'>
			<table width="284" border="0" cellspacing="1" cellpadding="0" bgcolor="#CCCCCC"><?
			for($i=0;$i<count($_total);$i++)
			{
				if($_total[$i][a])
				{
					?>
				<tr bgcolor="#DBDBDB">
					<td width='30' style='padding:2 0 2 2'><?= $_total[$i][a]?></td>
					<td width='32' style='padding:2 0 2 2'><?= round(($_total[$i][a]/$_total[total])*100)?>%</td>
					<td width='218' style='padding:2 0 2 2'><?= $_total[$i][b]?"<font onclick=\"window.open('gm_counter_referer_2.php?gm_http_referer=".base64_encode($_day1[$i][b])."','','scrollbars=1,resizable=1,width=520,height=300,top=100,left=200')\" style='cursor:pointer'>".$_total[$i][b]."</font>":"직접입력"?></td>
				</tr><?
				}
			}
			?>
			</table>
		</td>
	</tr>
</table><?
}
?>
<br>
<table align='center'>
	<tr>
		<td><input type="button" value="창닫기" onclick="self.close();"></td>
	</tr>
</table>
</body>
</html>