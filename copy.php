<?
// 20060721 정규순 : powered by 이미지 추가
if(!defined(__ADMIN_ROW))
{
	define(__ADMIN_ROW,"TRUE");
	$admin_row=$MySQL->fetch_array("select *from admin limit 0,1");
}
?>
<table width="900" border가0" cellspacing="0" cellpadding="0">
	<tr>
		<td colspan='2' height='1' bgcolor='e1e1e1'></td>
	</tr>
</table>
<table width="900" border="0" cellspacing="0" cellpadding="0">
	<tr bgcolor="<?=$design[copyBC]?>">
		<td colspan='2' height="35" style='padding:0 0 0 15'> <a href="company.php"><img src='image/index/copy01.gif' border='0' align='absmiddle'></a>  <a href="use_guide.php"><img src='image/index/copy02.gif' border='0' align='absmiddle'></a>  <a href="member_article.php"><img src='image/index/copy03.gif' border='0' align='absmiddle'></a>  <a href="person_guard.php"><img src='image/index/copy04.gif' border='0' align='absmiddle'></a>  <a href="cooperation.php"><img src='image/index/copy05.gif' border='0' align='absmiddle'></a><a href="ask_list.php"><img src='image/index/copy09.gif' border='0' align='absmiddle'></a></td>
		<td width='60'><a href='#top'><img src='image/index/btn_top.gif' border='0'></a></td>
	</tr>
</table>
<table width="900" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td height='1' bgcolor='e1e1e1'></td>
	</tr>
	<tr>
		<td height="80" valign="top" style='padding:5 0 0 0'>
			<table width="800" border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td align='center'><img src="upload/design/<?=$design[copyLogo]?>"></td>
					<td align='center'><font class='stext' color="<?=$design[copyTC]?>">Copyright ⓒ <?=$admin_row[comName]?> All Rights Reserved Any questions to <a href="javascript:sendMail('<?=$admin_row[adminEmail2]?>');"><U><?=$admin_row[adminEmail2]?></U></a><br><br>공정거래 위원회에서 인증한 표준약관을 사용합니다. <br>통신판매업신고 제 <?=$admin_row[esailNum]?> 호,정보 보호 담당자 : <?=$admin_row[guard]?>, 사업자등록번호 : <?=$admin_row[comNum]?> 대표자 <?=$admin_row[comCeo]?> <br>Tel : <?=$admin_row[comTel]?>, Fax : <?=$admin_row[comFax]?>, 주소 : <?=$admin_row[comAdr]?> [<?=$admin_row[comZip]?> ]</font></td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td align='right'><a href='http://webprogram.co.kr' target='_blank'><img src='image/index/poweredby.gif' border='0'></a></td>
	</tr>
</table>