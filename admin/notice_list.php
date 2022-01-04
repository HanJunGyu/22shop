<?
include "head.php";
?>
<body bgcolor="#FFFFFF" text="#5A595A" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<? include "top_menu.php"; ?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr><?
	$__TOP_MENU = "news";     //왼쪽 소메뉴 설정 변수
	include "left_menu.php";
	?>
		<td width="85%" valign="top" height='400'>
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td height='5'></td>
				</tr>
				<tr>
					<td>
						<table width="750" border="0" cellspacing="0" cellpadding="0" align='center'>
							<tr>
								<td rowspan="3" width="200"><img src="image/notice_tit.gif"></td>
								<td>&nbsp;</td>
							</tr>
							<tr>
								<td bgcolor="#E6E6E6" height='26'><div align='right'><font class='text1'>SHOP 공지사항, 이벤트, 설문조사를 수정하실수 있습니다.&nbsp;</div></td>
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
								<td bgcolor='DADADA' height='1' colspan='3'></td>
							</tr>
							<tr>
								<td width='440'><img src="image/<?=$part?>_mid_tit.gif"></td>
							</tr>
							<tr>
								<td bgcolor='DADADA' height='1' colspan='3'></td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td height='10'></td>
				</tr>
				<tr>
					<td valign="top">
						<table width="750" border="0" cellspacing="1" cellpadding="0" align="center" bgcolor='cdcdcd'>
							<tr valign="middle" bgcolor="#EBEBEB">
								<td width="120" height="30"> <div align="center"><img src="image/icon.gif" width="11" height="11"> 작성일</div></td>
								<td height="30"><div align="center"><img src="image/icon.gif" width="11" height="11"> 제 목</div></td>
								<td width="100" height="30"><div align="center"><img src="image/icon.gif" width="11" height="11"> 구분</div></td>
								<td width="100" height="30"><div align="center"><img src="image/icon.gif" width="11" height="11"> 조회수</div></td>
							</tr><!-- 공지사항 목록 시작 --><?
							$data=Decode64($data);
							$pagecnt=$data[pagecnt];
							$letter_no=$data[letter_no];
							$offset=$data[offset];
							$numresults=$MySQL->query("select idx from notice where part='$part'");
							$numrows=mysql_num_rows($numresults);				//총 레코드수..
							$LIMIT		=15;								//페이지당 글 수
							$PAGEBLOCK	=10;								//블럭당 페이지 수
							if($pagecnt==""){$pagecnt=0;}						//페이지 번호 
							if(!$offset){$offset=$pagecnt*$LIMIT*$PAGEBLOCK;} //각 페이지의 시작 글  
							if(!$letter_no){$letter_no=$numrows;}				//글번호
							$notice_result=$MySQL->query("select * from notice where part='$part' order by idx desc limit $offset,$LIMIT");
							$s_letter=$letter_no;								//페이지별 시작 글번호
							while($notice_row=mysql_fetch_array($notice_result))
							{
								$encode_str = "idx=".$notice_row[idx]."&pagecnt=".$pagecnt."&letter_no=".$s_letter."&offset=".$offset;
								$encode_str.= "&search=".$search."&searchstring=".$searchstring;
								$data=Encode64($encode_str);					//각 레코드 정보
								?>
							<tr valign="middle" bgcolor="ffffff" style='cursor:pointer;' onMouseOver="this.style.backgroundColor='#EBEBEB'" onMouseOut="this.style.backgroundColor=''" onclick="location.href='notice_edit.php?data=<?=$data?>&part=<?=$part?>'">
								<td height="25"><div align="center"><?=substr($notice_row[writeday],0,10)?></div></td>
								<td height="25"><div align="left">&nbsp;&nbsp;<?=$notice_row[title]?></div></td>
								<td height="25"><div align="center"><? if ($notice_row[gubun]=="M") echo "회원"; else if ($notice_row[gubun]=="D") echo "도매회원"; ?></div></td>
								<td height="25"><div align="center"><?=$notice_row[readNum]?></div></td>
							</tr><?
							}
							?>
						</table><!-- 공지사항 목록 끝 --><?
						include "../lib/class.php";
						$Obj=new CList("notice_list.php",$pagecnt,$offset,$numrows,$PAGEBLOCK,$LIMIT,"","","part=$part");
						$pre_icon_img="<img src='image/pre_btn.gif' width='40' height='17' border='0'>";		//이전아이콘
						$next_icon_img="<img src='image/next_btn.gif' width='40' height='17' border='0'>";	//다음아이콘
						?>
						<table width="100%" border="0" align="center" height='50'>
							<tr>
								<td align="center"><?$Obj->putList(true,$pre_icon_img,$next_icon_img);//이전다음 프린트?></td>
								<td><a href="notice_write.php?part=<?=$part?>"><img src="image/write_btn.gif" width="40" height="17" border="0"></a></td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>
<? include "copy.php";?>
</body>
</html>