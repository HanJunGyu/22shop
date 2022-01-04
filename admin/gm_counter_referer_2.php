<?
include "head.php";
function _gm_counter($gm_year,$gm_month,$gm_day,$gm_http_referer)
{
	global $MySQL;
	if($gm_year) $where_array[]="gm_year='$gm_year'";
	if($gm_month) $where_array[]="gm_month='$gm_month'";
	if($gm_day) $where_array[]="gm_day='$gm_day'";
	if($gm_http_referer) $where_array[]="gm_http_referer='$gm_http_referer'";
	$where_qry=count($where_array)?"where ".implode(" and ",$where_array):"";
	$result=$MySQL->query("SELECT count(gm_http_referer_detail) as a, gm_http_referer_detail as b FROM GM_Counter $where_qry GROUP BY gm_http_referer_detail ORDER BY a DESC, binary(gm_http_referer_detail) ASC");
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

$_day1=_gm_counter(substr($day1,0,4),substr($day1,4,2),substr($day1,6,2),base64_decode($gm_http_referer));

$mon1=$gm_year.$gm_month;

$_mon1=_gm_counter(substr($mon1,0,4),substr($mon1,4,2),0,base64_decode($gm_http_referer));

$_total=_gm_counter(0,0,0,base64_decode($gm_http_referer));
if($day)
{
?>
<table width="502" border="0" cellspacing="1" cellpadding="0" align="center" bgcolor="#CCCCCC">
	<tr bgcolor="#FFFFFF" align="center">
		<td width='500' style="padding:5 0 5 0" bgcolor="#FFFFCC"><?= $week1?>요일 <?=substr($day1,4,2)?>-<?=substr($day1,6,2)?></td>
	</tr>
	<tr>
		<td bgcolor="#FFFFCC" style='padding:8 8 8 8' valign='top'>
			<table width="484" border="0" cellspacing="1" cellpadding="0" bgcolor="#CCCCCC"><?
			for($i=0;$i<count($_day1);$i++)
			{
				if($_day1[$i][a])
				{
					?>
				<tr bgcolor="#FFFFCC">
					<td width='30' style='padding:2 0 2 2'><?= $_day1[$i][a]?></td>
					<td width='32' style='padding:2 0 2 2'><?= round(($_day1[$i][a]/$_day1[total])*100)?>%</td>
					<td width='418' style='padding:2 0 2 2'><?= $_day1[$i][b]?$_day1[$i][b]:"직접입력"?></td>
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
<table width="502" border="0" cellspacing="1" cellpadding="0" align="center" bgcolor="#CCCCCC">
	<tr bgcolor="#FFFFFF" align="center">
		<td width='500' style="padding:5 0 5 0" bgcolor="#FFFFCC"><?=substr($mon1,0,4)?>-<?=substr($mon1,4,2)?></td>
	</tr>
	<tr>
		<td bgcolor="#FFFFCC" style='padding:8 8 8 8' valign='top'>
			<table width="484" border="0" cellspacing="1" cellpadding="0" bgcolor="#CCCCCC"><?
			for($i=0;$i<count($_mon1);$i++)
			{
				if($_mon1[$i][a])
				{
					?>
				<tr bgcolor="#FFFFCC">
					<td width='30' style='padding:2 0 2 2'><?= $_mon1[$i][a]?></td>
					<td width='32' style='padding:2 0 2 2'><?= round(($_mon1[$i][a]/$_mon1[total])*100)?>%</td>
					<td width='418' style='padding:2 0 2 2'><?= $_mon1[$i][b]?$_mon1[$i][b]:"직접입력"?></td>
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
<table width="502" border="0" cellspacing="1" cellpadding="0" align="center" bgcolor="#CCCCCC">
	<tr bgcolor="#FFFFFF" align="center">
		<td width='500' style="padding:5 0 5 0" bgcolor="#DBDBDB">전체</td>
	</tr>
	<tr>
		<td bgcolor="#DBDBDB" style='padding:8 8 8 8' valign='top'>
			<table width="484" border="0" cellspacing="1" cellpadding="0" bgcolor="#CCCCCC"><?
			for($i=0;$i<count($_total);$i++)
			{
				if($_total[$i][a])
				{
					?>
				<tr bgcolor="#DBDBDB">
					<td width='30' style='padding:2 0 2 2'><?= $_total[$i][a]?></td>
					<td width='32' style='padding:2 0 2 2'><?= round(($_total[$i][a]/$_total[total])*100)?>%</td>
					<td width='418' style='padding:2 0 2 2'><?= $_total[$i][b]?$_total[$i][b]:"직접입력"?></td>
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