<?
// 소스형상관리
// 20060718-1 소스수정 김성호 : 게시판 배열에 따라 2줄 날자표기 현상 수정
?>
<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center"><?
// 커뮤니티 게시판 최근게시물 뽑아오기
$result = $MySQL->query("SELECT *from bbs_list WHERE bCommunity='y' order by idx asc");
$bbs_list_cnt=1;
while ($row = mysql_fetch_array($result))
{
	$code=$row[code];
	$numresults=$MySQL->query("select idx from bbs_data where code='$code' order by idx desc limit 5");
	$numrows=mysql_num_rows($numresults);
	if(!$letter_no) { $letter_no = $numrows; }
	$bbs_qry = "select * from bbs_data where code='$code' order by ref desc,re_step asc limit 5";
	$bbs_result=$MySQL->query($bbs_qry);
	if ($bbs_list_cnt % $design[community_cols] == 1) echo "<TR>";
	$page_width = (720*0.9)/$design[community_cols];
	?>
		<td width="<?=$page_width?>" valign="top">
			<table border="0" cellspacing="0" cellpadding="0" align="center" width="90%" align='center'>
				<tr height="30">
					<td  colspan="2" align="center"><?
					if ($row[commnameimg])
					{
						?><a href="board_list.php?boardIndex=<?=$row[idx]?>"><img src="upload/bbs/<?=$row[commnameimg]?>"></a><?
					}
					else
					{
						?><table width='100%' height='30' border='0' bgcolor='cccccc' cellspacing='1' cellpadding='0'>
							<tr>
								<td bgcolor='f7f7f7' style='padding:0 0 0 10;'><img src='image/board/icon_cc.gif' align='absmiddle'> <a href="board_list.php?boardIndex=<?=$row[idx]?>"><?=$row[name]?></a></td>
							</tr>
						</table><?
					}
					?></td>
				</tr>
				<tr>
					<td height='5'></td>
				</tr><?
				while($bbs_row=mysql_fetch_array($bbs_result))
				{
					$encode_str = "idx=".$bbs_row[idx]."&pagecnt=".$pagecnt."&letter_no=".$s_letter."&offset=".$offset;
					$encode_str.= "&search=".$search."&searchstring=".$searchstring."&present_num=".$letter_no;
					$data=Encode64($encode_str);
					//새글이미지
					if(BetweenPeriod($bbs_row[writeday],1) > 0) $newImg = "<img src='image/icon/icon_new.gif' width='30' height='10'>";
					else $newImg = "";
					?>
				<tr height="20">
					<td width="<?=$page_width - 70?>" style='padding:0 5 0 5;'><img src="image/board/icon_cc0.gif"> <?
					// 이미지 갤러리//////////////////
					if ($row[part]==30)
					{
						if ($newImg) $title_width = (30/$design[community_cols]);
						else $title_width = (48/$design[community_cols]);
						?><img src="upload/bbs/<?=$bbs_row[img1]?>" width="25" height="25" align='absmiddle'> <?
					}
					else
					{
						if ($newImg) $title_width = (42/$design[community_cols]);
						else $title_width = (60/$design[community_cols]);
					}
					if ($bbs_row[bLock]=="y")
					{
						?><a href="board_lock.php?data=<?=$data?>&boardIndex=<?=$row[idx]?>"><?
					}
					else if($row[rAct]==0 || ($row[rAct]==10 && $_SESSION[GOOD_SHOP_PART]=='member'))
					{
						?><a href="board_view.php?data=<?=$data?>&boardIndex=<?=$row[idx]?>"><?
					}
					else
					{
						?><a href="#;" onclick="javascript:readLoginErr();"><?
					}
					?><?=StringCut($bbs_row[title],$title_width)?></a> <?=$newImg?></td>
					<td width="70" align="center"><?=substr($bbs_row[writeday],2,8)?></td>
				</tr><?
				}
				?>
			</table>
		</td><?
		if (!($bbs_list_cnt % $design[community_cols] == 0))
		{
			?>
		<td width=1></td><?
		}
		if ($bbs_list_cnt % $design[community_cols] == 0) echo "</TR><tr height=10><td></td></tr>";
		$bbs_list_cnt++;
}
?>
</table>
