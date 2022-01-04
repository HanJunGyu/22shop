<?
// 소스형상관리
// 20060714-1 파일추가 최호수

include "head.php";
$syear = $syear?$syear:date('Y');
$smonth = $smonth?$smonth:date('m');

$totalDays = date("t",mktime(0,0,1,$smonth,1,$syear));

function _get_sale($syear,$smonth,$sday)
{
	global $MySQL;
	if($sday) $where_array[]="sday4 like '%-$sday %'";
	if($smonth) $where_array[]="sday4 like '%-$smonth-%'";
	if($syear) $where_array[]="sday4 like '$syear%'";
	$where_array[]="sday4 IS NOT NULL";
	$where_qry=count($where_array)?"where ".implode(" and ",$where_array):"";
	$result=$MySQL->query("SELECT price, sday4 FROM trade_goods $where_qry ORDER BY sday4 ASC");
	while ($row = mysql_fetch_array($result))
	{
		$r[substr($row[sday4],0,10)][a] += $row[price];
	}
	return $r;
}

$PrevMonth = _get_sale(($smonth=='01')?$syear-1:$syear,($smonth=='01')?'12':sprintf('%02d',$smonth-1),0);
$CurMonth = _get_sale($syear,$smonth,0);
$NextMonth = _get_sale(($smonth=='12')?$syear+1:$syear,($smonth=='12')?'01':sprintf('%02d',$smonth+1),0);

function showCalendar($syear,$smonth,$totalDays)
{
	global $PrevMonth, $NextMonth, $CurMonth;
	$firstDay = date('w',mktime(0,0,0,$smonth,1,$syear));
	$htmlCode = "
<table width='100%' border='0' cellspacing='1' cellpadding='2' bgcolor='#cdcdcd'>
	<tr bgcolor='#FBF0E2'>
		<td align='center' width='14%'><font color='red'>일요일</font></td>
		<td align='center' width='14%'>월요일</td>
		<td align='center' width='14%'>화요일</td>
		<td align='center' width='14%'>수요일</td>
		<td align='center' width='14%'>목요일</td>
		<td align='center' width='14%'>금요일</td>
		<td align='center' width='14%'><font color='blue'>토요일</font></td>
	</tr>
	<tr bgcolor='#FFFFFF'>";
	$col = 0;
	for($i = 0; $i < $firstDay; $i++)
	{
		$prev_day = date("Y-m-d",mktime(0,0,0,$smonth, 1-($firstDay-$i), $syear));
		$goyear = substr($prev_day,0,4);
		$gomonth = substr($prev_day,5,2);
		$goday = substr($prev_day,8,2);
		$htmlCode .= "<td bgcolor='#FFFFFF' valign='top' style='cursor:pointer' onclick=\"document.location.href='sale_status_day.php?syear=$goyear&smonth=$gomonth&sday=$goday'\"><font color='#CCCCCC'>".substr($prev_day,5,5)."</font>";
		if($prev_day<date('Y-m-d') || $prev_day==date('Y-m-d'))
		{
			$htmlCode .= "
				<table cellpadding='0' cellspacing='0' border='0'>
					<tr>
						<td style='padding:4 0 2 2'><font color='#CCCCCC'>합계 ".number_format($PrevMonth[$prev_day][a])."</font></td>
					</tr>
				</table>";
		}
		$htmlCode .= "</td>";
		$col++;
	}
	for($j = 1; $j <= $totalDays; $j++)
	{
		$day=sprintf("%02d",$j);
		if ($col==0) $jday = "<font color='red'>$day</font>";
		else if ($col==6) $jday = "<font color='blue'>$day</font>";
		else $jday = "$day";
		$str = $syear."-".$smonth."-".$day;
		$goyear = substr($str,0,4);
		$gomonth = substr($str,5,2);
		$goday = substr($str,8,2);
		$TdColor = ($str==date('Y-m-d'))?'#FFFFCC':'#FAFAFA';
		$htmlCode .= "<td bgcolor='$TdColor' height='50' valign='top' style='cursor:pointer'  onclick=\"document.location.href='sale_status_day.php?syear=$goyear&smonth=$gomonth&sday=$goday'\"><b>$jday</b>";
		if($str<date('Y-m-d') || $str==date('Y-m-d'))
		{
			$htmlCode .= "
			<table cellpadding='0' cellspacing='0' border='0'>
				<tr>
					<td style='padding:4 0 2 2'>합계 ".number_format($CurMonth[$str][a])."</td>
				</tr>
			</table>";
		}
		$htmlCode .= "</td>";
		$col++;
		if($col == 7)
		{
			$htmlCode .= "</tr>";
			if($j != $totalDays)
			{
				$htmlCode .= "<tr>";
			}
			$col = 0;
		}
	}
	while($col > 0 && $col < 7)
	{
		$reday++;
		$prev_day = date("Y-m-d",mktime(0,0,0,$smonth, $day+$reday, $syear));
		$goyear = substr($prev_day,0,4);
		$gomonth = substr($prev_day,5,2);
		$goday = substr($prev_day,8,2);
		$htmlCode .= "<td bgcolor='#FFFFFF' valign='top' style='cursor:pointer' onclick=\"document.location.href='sale_status_day.php?syear=$goyear&smonth=$gomonth&sday=$goday'\"><font color='#CCCCCC'>".substr($prev_day,5,5)."</font>";
		if(substr($prev_day,0,7)<date('Y-m') || substr($prev_day,0,7)==date('Y-m'))
		{
			$htmlCode .= "
				<table cellpadding='0' cellspacing='0' border='0'>
					<tr>
						<td style='padding:4 0 2 2'><font color='#CCCCCC'>합계 ".number_format($NextMonth[$prev_day][a])."</font></td>
					</tr>
				</table>";
		}
		$htmlCode .= "</td>";
		$col++;
	}
	$htmlCode .= "</tr>";
	$htmlCode .= "</table>";
	return $htmlCode;
}
?>
<head>
</head>
<body bgcolor="#FFFFFF" text="#5A595A" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<?  include "top_menu.php";?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr><?
	$__TOP_MENU = "sale";     //왼쪽 소메뉴 설정 변수
	include "left_menu.php";
	if(!defined(__ADMIN_ROW))
	{
		define(__ADMIN_ROW,"TRUE");
		$admin_row=$MySQL->fetch_array("select *from admin limit 0,1"); //관리자 정보 배열
	}
	?>
		<td width="85%" valign="top">
			<table width="100%" border="0" cellspacing="0" cellpadding="0" align='center'>
				<tr>
					<td>
						<table width="750" border="0" cellspacing="0" cellpadding="0" align='center'>
							<tr>
								<td rowspan="3" width="200"><img src='image/sale_tit_img.gif'></td>
								<td>&nbsp;</td>
							</tr>
							<tr>
								<td bgcolor="#E6E6E6" height='26'><div align='right'><font class='text1'>사이트의 매출통계를 확인하실수 있습니다.&nbsp;</div></td>
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
								<td width='440'><img src='image/sale_tit2.gif'></td>
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
				<form name="form" method="post" action="<?= $_SERVER[PHP_SELF]?>">
				<tr>
					<td align='center'><select name="syear"><?
					for ($i=$syear-5; $i<$syear+5; $i++)
					{
						$syear_sel[$syear]="selected";
						?><option value="<?=$i?>" <?= $syear_sel[$i]?>><?=$i?>년</option><?
					}
					?></select> <select name="smonth"><?
					for ($i=1; $i<13; $i++)
					{
						$smonth_sel[$smonth]="selected";
						?><option value="<?=sprintf("%02d",$i)?>" <?= $smonth_sel[sprintf("%02d",$i)]?>><?=sprintf("%02d",$i)?>월</option><?
					}
					?></select> <input type='image' src='image/view_btn.gif' border='0' align='absmiddle'>&nbsp;&nbsp;&nbsp;&nbsp;<a href="<?= $_SERVER[PHP_SELF]?>?syear=<?=($smonth=='01')?$syear-1:$syear;?>&smonth=<?=($smonth=='01')?'12':sprintf('%02d',$smonth-1);?>"><img src='image/pre_mon.gif' border='0' align='absmiddle'></a>&nbsp;&nbsp;<a href="<?= $_SERVER[PHP_SELF]?>?syear=<?=($smonth=='12')?$syear+1:$syear;?>&smonth=<?=($smonth=='12')?'01':sprintf('%02d',$smonth+1);?>"><img src='image/next_mon.gif' border='0' align='absmiddle'></a></td>
				</tr>
				</form>
				<tr>
					<td><br>
						<table width="750" border="0" cellspacing="0" cellpadding="0" align="center">
							<tr>
								<td><? print(showCalendar($syear, $smonth, $totalDays)); ?></td>
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