<?
// 소스형상관리
// 20060714-1 파일추가 최호수

include "head.php";
$syear1 = $syear1?$syear1:date('Y');
$smonth1 = $smonth1?$smonth1:date('m');
$sday1 = $sday1?$sday1:date('d');
$syear2 = $syear2?$syear2:date('Y');
$smonth2 = $smonth2?$smonth2:date('m');
$sday2 = $sday2?$sday2:date('d');

// 카테고리 그룹화
$result=$MySQL->query("SELECT code,name FROM category ORDER BY position ASC");
while ($row = mysql_fetch_array($result))
{
	$CategoryGroup[$row[code]] = $row[code];
}
// 카테고리 그룹화 끝

function _get_sale($syear1,$smonth1,$sday1,$syear2,$smonth2,$sday2)
{
	global $MySQL, $CategoryGroup;
	$sdate1 = $syear1.$smonth1.$sday1;
	$sdate2 = $syear2.$smonth2.$sday2;
	if($sdate1>$sdate2)
	{
		$where_array[]="DATE_FORMAT(sday4,'%Y%m%d') BETWEEN $sdate2 AND $sdate1";
	}
	elseif($sdate1<$sdate2)
	{
		$where_array[]="DATE_FORMAT(sday4,'%Y%m%d') BETWEEN $sdate1 AND $sdate2";
	}
	else
	{
		$where_array[]="DATE_FORMAT(sday4,'%Y%m%d') BETWEEN $sdate1 AND $sdate2";
	}
	$where_qry=count($where_array)?"where ".implode(" and ",$where_array):"";
	$result=$MySQL->query("SELECT price,category,goodsIdx,userid FROM trade_goods $where_qry");
	while ($row = mysql_fetch_array($result))
	{
		$r[$row[category]][a] += $row[price];
		$r[$CategoryGroup[$row[category]]][a_t] += $row[price];
		$r[$CategoryGroup[$row[category]]][a_1]++;
		$r[goods][$row[goodsIdx]][a] += $row[price];
		$r[goods][$row[goodsIdx]][a_1]++;
		if(strlen($row[userid])=='10' && is_numeric($row[userid]))
		{
			$r[bmember][a] += $row[price];
			$r[bmember][a_1]++;
		}
		else
		{
			$r[member][$row[userid]][a] += $row[price];
			$r[member][$row[userid]][a_1]++;
		}
		$r[ea][a]++;
	}
	return $r;
}
$CurMonth = _get_sale($syear1,$smonth1,$sday1,$syear2,$smonth2,$sday2);
?>
<style>
.ea_class {width:80px;text-align:right}
.money_class {width:100px;text-align:right}
</style>
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
								<td width='440'><img src='image/sale_tit5.gif'></td>
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
					<td align='center'><select name="syear1"><?
					for ($i=$syear1-5; $i<$syear1+5; $i++)
					{
						$syear1_sel[$syear1]="selected";
						?><option value="<?=$i?>" <?= $syear1_sel[$i]?>><?=$i?>년</option><?
					}
					?></select> <select name="smonth1"><?
					for ($i=1; $i<13; $i++)
					{
						$smonth1_sel[$smonth1]="selected";
						?><option value="<?=sprintf("%02d",$i)?>" <?= $smonth1_sel[sprintf("%02d",$i)]?>><?=sprintf("%02d",$i)?>월</option><?
					}
					?></select> <select name="sday1"><?
					for ($i=1; $i<32; $i++)
					{
						$sday1_sel[$sday1]="selected";
						?><option value="<?=sprintf("%02d",$i)?>" <?= $sday1_sel[sprintf("%02d",$i)]?>><?=sprintf("%02d",$i)?>일</option><?
					}
					?></select> ~ <select name="syear2"><?
					for ($i=$syear2-5; $i<$syear2+5; $i++)
					{
						$syear2_sel[$syear2]="selected";
						?><option value="<?=$i?>" <?= $syear2_sel[$i]?>><?=$i?>년</option><?
					}
					?></select> <select name="smonth2"><?
					for ($i=1; $i<13; $i++)
					{
						$smonth2_sel[$smonth2]="selected";
						?><option value="<?=sprintf("%02d",$i)?>" <?= $smonth2_sel[sprintf("%02d",$i)]?>><?=sprintf("%02d",$i)?>월</option><?
					}
					?></select> <select name="sday2"><?
					for ($i=1; $i<32; $i++)
					{
						$sday2_sel[$sday2]="selected";
						?><option value="<?=sprintf("%02d",$i)?>" <?= $sday2_sel[sprintf("%02d",$i)]?>><?=sprintf("%02d",$i)?>일</option><?
					}
					?></select> <input type='image' src='image/view_btn.gif' border='0' align='absmiddle'></td>
				</tr>
				</form>
				<tr>
					<td align='center'><br>
						<table width='750' border='0' cellspacing='1' cellpadding='2'>
							<tr>
								<td width='1' bgcolor='dadada'></td>
							</tr>
							<tr>
								<td><a href='#01'><img src='image/sale_b1.gif'></a> <a href='#02'><img src='image/sale_b2.gif'></a> <a href='#03'><img src='image/sale_b3.gif'></a></td>
							</tr>
						</table>
						<a name="01" id="01"></a>
						<table width='750' border='0' cellspacing='1' cellpadding='2'>
							<tr>
								<td><img src='image/sale_01.gif'></td>
							</tr>
						</table>
						<table width='750' border='0' cellspacing='1' cellpadding='2' bgcolor='#C7C7C7'>
							<tr bgcolor='#e9e6dd'>
								<td align='center' width='60%'><b>카테고리별</b></td>
								<td align='center' width='20%'><b>합계</b></td>
								<td align='center' width='20%'><b>운영</b></td>
							</tr><?
							$result=$MySQL->query("SELECT code, name FROM category ORDER BY position ASC");
							while ($row = mysql_fetch_array($result))
							{
								?>
							<tr bgcolor='#FFFFFF'>
								<td bgcolor='#FBF0E2' style='padding:2 0 2 5'><?= $row[name]?></td>
								<td style='padding:2 0 2 5'><font class='ea_class'><?= number_format($CurMonth[$row[code]][a_1])?></font></td>
								<td><font class='money_class'><?= number_format($CurMonth[$row[code]][a_t])?> 원</font></td>
							</tr><?
								$a_t += $CurMonth[$row[code]][a_t];
							}
							?>
							<tr bgcolor='#FBF0E2'>
								<td align='center' style='padding:2 0 2 5'><b>합계</b></td>
								<td style='padding:2 0 2 5'><font class='ea_class'><?= number_format($CurMonth[ea][a])?></font></td>
								<td><font class='money_class'><?= number_format($a_t)?> 원</font></td>
							</tr>
						</table><br><br>
						<a name="02" id="02"></a>
						<table width='750' border='0' cellspacing='1' cellpadding='2'>
							<tr>
								<td><img src='image/sale_02.gif'></td>
							</tr>
						</table>
						<table width='750' border='0' cellspacing='1' cellpadding='2' bgcolor='#C7C7C7'>
							<tr bgcolor='#e9e6dd'>
								<td align='center' width='60%'><b>상품별</b></td>
								<td align='center' width='20%'><b>합계</b></td>
								<td align='center' width='20%'><b>운영</b></td>
							</tr><?
							$result=$MySQL->query("SELECT idx, name FROM goods ORDER BY binary(name) ASC");
							while ($row = mysql_fetch_array($result))
							{
								if($CurMonth[goods][$row[idx]][a_1])
								{
								?>
							<tr bgcolor='#FFFFFF'>
								<td bgcolor='#F7F7F7' style='padding:2 0 2 5'><?= $row[name]?></td>
								<td style='padding:2 0 2 5'><font class='ea_class'><?= number_format($CurMonth[goods][$row[idx]][a_1])?></font></td>
								<td> <font class='money_class'><?= number_format($CurMonth[goods][$row[idx]][a])?> 원</font></td>
							</tr><?
								$a += $CurMonth[goods][$row[idx]][a];
								}
							}
							?>
							<tr bgcolor='#FBF0E2'>
								<td align='center' style='padding:2 0 2 5'><b>합계</b></td>
								<td style='padding:2 0 2 5'><font class='ea_class'><?= number_format($CurMonth[ea][a])?></font></td>
								<td><font class='money_class'><?= number_format($a)?> 원</font></td>
							</tr>
						</table><br><br>
						<a name="03" id="03"></a>
						<table width='750' border='0' cellspacing='1' cellpadding='2'>
							<tr>
								<td><img src='image/sale_03.gif'></td>
							</tr>
						</table>
						<table width='750' border='0' cellspacing='1' cellpadding='2' bgcolor='#C7C7C7'>
							<tr bgcolor='#e9e6dd'>
								<td align='center' width='60%'><b>회원별</b></td>
								<td align='center' width='20%'><b>합계</b></td>
								<td align='center' width='20%'><b>운영</b></td>
							</tr><?
							$result=$MySQL->query("SELECT userid, name FROM member ORDER BY binary(name) ASC");
							while ($row = mysql_fetch_array($result))
							{
								if($CurMonth[member][$row[userid]][a])
								{
								?>
							<tr bgcolor='#FFFFFF'>
								<td bgcolor='#F7F7F7' style='padding:2 0 2 5'><?= $row[userid]?>(<?= $row[name]?>)</td>
								<td style='padding:2 0 2 5'><font class='ea_class'><?= number_format($CurMonth[member][$row[userid]][a_1])?></font></td>
								<td><font class='money_class'><?= number_format($CurMonth[member][$row[userid]][a])?> 원</font></td>
							</tr><?
									$member_a += $CurMonth[member][$row[userid]][a];
								}
							}
							if($CurMonth[bmember][a])
							{
							?>
							<tr bgcolor='#FFFFFF'>
								<td bgcolor='#F7F7F7' style='padding:2 0 2 5'>비회원</font></td>
								<td style='padding:2 0 2 5'><font class='ea_class'><?= number_format($CurMonth[bmember][a_1])?></font></td>
								<td><font class='money_class'><?= number_format($CurMonth[bmember][a])?> 원</font></td>
							</tr><?
								$member_a += $CurMonth[bmember][a];
							}
							?>
							<tr bgcolor='#FBF0E2'>
								<td align='center' style='padding:2 0 2 5'><b>합계</b></td>
								<td style='padding:2 0 2 5'><font class='ea_class'><?= number_format($CurMonth[ea][a])?></font></td>
								<td><font class='money_class'><?= number_format($member_a)?> 원</font></td>
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