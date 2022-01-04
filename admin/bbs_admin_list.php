<?
// 소스형상관리
// 20060724-1 파일추가 김성호
// 20060724-2 소스수정 김성호 : 설명문구수정
include "head.php";
if ($mode == "up")
{
	$temp_idx = $idx * (-1);
	$min_row = $MySQL->fetch_array("SELECT *from bbs_list WHERE  idx < $idx order by idx desc limit 1");
	if ($MySQL->query("UPDATE bbs_list SET idx=$temp_idx WHERE idx=$idx")) // 이동을 원하는 게시판의 idx 값을 임의로 바꿈
	{
		$qry = "UPDATE bbs_list SET idx=$idx WHERE idx=$min_row[idx]";
		if ($MySQL->query($qry))
		{
			$MySQL->query("UPDATE bbs_list SET idx=$min_row[idx] WHERE  idx=$temp_idx");
			$bbs_row = $MySQL->fetch_array("SELECT max(idx) from bbs_list");
			$MySQL->query("ALTER TABLE bbs_list AUTO_INCREMENT=$bbs_row[0]");
		}
	}
}
if ($mode == "down")
{
	$temp_idx = $idx * (-1);
	$min_row = $MySQL->fetch_array("SELECT *from bbs_list WHERE idx > $idx order by idx asc limit 1");
	if ($MySQL->query("UPDATE bbs_list SET idx=$temp_idx WHERE idx=$idx")) // 이동을 원하는 게시판의 idx 값을 임의로 바꿈
	{
		if ($MySQL->query("UPDATE bbs_list SET idx=$idx WHERE idx=$min_row[idx]"))
		{
			$MySQL->query("UPDATE bbs_list SET idx=$min_row[idx] WHERE idx=$temp_idx");
			$bbs_row = $MySQL->fetch_array("SELECT max(idx) from bbs_list");
			$MySQL->query("ALTER TABLE bbs_list AUTO_INCREMENT=$bbs_row[0]");
		}
	}
}
?>
<body bgcolor="#FFFFFF" text="#5A595A" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<? include "top_menu.php"; ?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr><?
	$__TOP_MENU = "board";     //왼쪽 소메뉴 설정 변수
	include "left_menu.php";
	$actArr		= array("10" => "제한없음", "20" => "회원,관리자", "30" => "관리자");	//게시판 권한 배열
	$actKey		= array_keys($actArr);												//게시판 권한 배열 키값 ex) array("10","20","30")
	$partArr	= array("10" => "일반게시판", "20" => "자료실", "30" => "갤러리");		//게시판 유형 배열
	$partKey	= array_keys($partArr);												//게시판 유형 배열 키값 ex) array("10","20","30")
	?>
		<td width="85%" valign="top" height="400">
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td height='5'></td>
				</tr>
				<tr>
					<td>
						<table width="750" border="0" cellspacing="0" cellpadding="0" align='center'>
							<tr>
								<td rowspan="3" width="200"><img src="image/board_tit.gif"></td>
								<td>&nbsp;</td>
							</tr>
							<tr>
								<td bgcolor="#E6E6E6" height='26'><div align='right'><font class='text1'>SHOP 게시판 수정을 하실수 있습니다.&nbsp;</div></td>
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
								<td width='1' bgcolor='dadada'></td>
							</tr>
							<tr>
								<td><img src="image/bbs_list_tit.gif"></td>
							</tr>
							<tr>
								<td width='1' bgcolor='dadada'></td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
				</tr>
				<tr>
					<td valign="top">
						<table width="750" border="0" cellspacing="1" cellpadding="0" align="center" bgcolor='cdcdcd'>
							<tr>
								<td colspan="8" bgcolor='ffffff' height='30'><font class="help">※ <b>사용자화면에서 관리자 로그인후</b> 게시물 수정/삭제도 가능합니다.<br>※ 아래 Idx는 베너등의 <b>게시판 바로가기 링크</b>를 걸때 사용하는 값입니다. 예) board_list.php?boardIndex = 1</font></td>
							</tr>
							<tr valign="middle">
								<td width="5%" height="30" bgcolor="#EBEBEB"> <div align="center"><img src="image/icon.gif" width="11" height="11"> 순서 </div></td>
								<td width="10%" height="30" bgcolor="#EBEBEB"> <div align="center"><img src="image/icon.gif" width="11" height="11"> Code </div></td>
								<td width="5%" height="30" bgcolor="#EBEBEB"> <div align="center"><img src="image/icon.gif" width="11" height="11"> Idx </div></td>
								<td width="20%" height="30" bgcolor="#EBEBEB"> <div align="center"><img src="image/icon.gif" width="11" height="11"> 게시판 이름</div></td>
								<td width="10%" height="30" bgcolor="#EBEBEB"> <div align="center"><img src="image/icon.gif" width="11" height="11"> 유형</div></td>
								<td width="7%" height="30" bgcolor="#EBEBEB"> <div align="center"><img src="image/icon.gif" width="11" height="11"> 정보</div></td>
								<td width="7%" height="30" bgcolor="#EBEBEB"> <div align="center"><img src="image/icon.gif" width="11" height="11">글</div></td>
								<td width="10%" height="30" bgcolor="#EBEBEB"> <div align="center"><img src="image/icon.gif" width="11" height="11"> 생성날짜</div></td>
							</tr><?
							$bbs_result=$MySQL->query("select * from bbs_list where gubun<>'B' order by idx asc");
							while($bbs_row=mysql_fetch_array($bbs_result))
							{
								$encode_str = "idx=".$bbs_row[idx];
								$data=Encode64($encode_str);	// 각 레코드 정보
								?>
							<tr valign="middle">
								<td height="25"  bgcolor="fafafa"> <div align="center"><a href="bbs_admin_list.php?idx=<?=$bbs_row[idx]?>&mode=up">△</a><br><a href="bbs_admin_list.php?idx=<?=$bbs_row[idx]?>&mode=down">▽</a></div> </td>
								<td height="25"  bgcolor="fafafa"> <div align="center"><FONT  COLOR="#6600FF"><B><?=$bbs_row[code]?></B></FONT></div></td>
								<td height="25"  bgcolor="fafafa"> <div align="center"><?=$bbs_row[idx]?></div></td>
								<td height="25"  bgcolor="fafafa"> <div align="center"><?=$bbs_row[name]?><? if ($bbs_row[bCommunity]=="y") echo "<BR><font color=#DC44F3>커뮤니티 노출함</font>"; ?></div></td>
								<td height="25"  bgcolor="fafafa"> <div align="center"><?=$partArr[$bbs_row[part]]?><br><? if ($bbs_row[gubun]=="D") echo "<b>[도매회원]</b>"; ?></div></td>
								<td height="25"  bgcolor="fafafa"> <div align="center"><a href="bbs_admin_edit.php?data=<?=$data?>"><img src="image/bbs_data_view.gif" width="54" height="33" border="0"></a></div></td>
								<td height="25" bgcolor="fafafa"> <div align="center"><a href="bbs_list.php?code=<?=$bbs_row[code]?>"><img src="image/bbs_write_view.gif" width="46" height="33" border="0"></a></div></td>
								<td height="25"  bgcolor="fafafa"> <div align="center"><?=str_replace("-","/",substr($bbs_row[writeday],0,10))?></div></td>
							</tr><?
							}
							?><!-- 게시판 목록 끝 -->
						</table><br>
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>
<? include "copy.php"; ?>
</body>
</html>