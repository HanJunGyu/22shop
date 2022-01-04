<?
include "head.php";
?>
<SCRIPT LANGUAGE="JavaScript">
<!--
function searchSendit()
{
	var form=document.searchForm;
	if(form.searchstring.value=="")
	{
		alert("검색 내용을 입력해 주십시오.");
		form.searchstring.focus();
		return false;
	}
	else
	{
		return true;
	}
}
//-->
</SCRIPT>
<body bgcolor="#FFFFFF" text="#5A595A" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<? include "top_menu.php"; ?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr><?
	$__TOP_MENU = "ask";     //왼쪽 소메뉴 설정 변수
	include "left_menu.php";
	$colspan = 5;
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
								<td rowspan="3" width="200"><img src="image/ask_tit_l.gif"></td>
								<td>&nbsp;</td>
							</tr>
							<tr>
								<td bgcolor="#E6E6E6" height='26'><div align='right'><font class='text1'>SHOP 1:1문의게시판 등록 수정 하실수 있습니다.&nbsp;</div></td>
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
								<td width='440'><img src="image/ask_tit3.gif"></td>
							</tr>
							<tr>
								<td width='1' bgcolor='dadada'></td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td height='10'></td>
				</tr>
				<tr>
					<td>
						<form name="searchForm" action="ask.php" method="post" onSubmit="return searchSendit();">
						<table width="750" border="0" bgcolor="#FFFFFF" align="center">
							<tr bgcolor="#FFFFFF">
								<td bgcolor="#FFFFFF"></td>
								<td width="10"><select name="search"><option value="name">작성자</option><option value="title">제 목</option><option value="content">내 용</option></select></td>
								<td width="130"><input class="box" type="text" name="searchstring" size="20"></td>
								<td width="71"><input type="image" src="image/bbs_search_btn.gif" width="41" height="23" border="0"></td>
							</tr>
						</table></form><!-- searchForm -->
					</td>
				</tr>
				<tr>
					<td valign="top">
						<table width="750" border="0" cellspacing="1" cellpadding="0" align="center" bgcolor='cdcdcd'>
							<tr valign="middle">
								<td width="10%" height="30" bgcolor="#EBEBEB" background="image/bbs_tit_bg.jpg"> <div align="center"><img src="image/icon.gif" width="11" height="11"> 번호</div></td>
								<td width="54%" height="30" bgcolor="#EBEBEB" background="image/bbs_tit_bg.jpg"> <div align="center"><img src="image/icon.gif" width="11" height="11"> 제 목</div></td>
								<td width="13%" height="30" bgcolor="#EBEBEB"> <div align="center"><img src="image/icon.gif" width="11" height="11"> 작성일</div></td>
								<td width="13%" height="30" bgcolor="#EBEBEB"> <div align="center"><img src="image/icon.gif" width="11" height="11"> 작성자</div></td>
								<td width="10%" height="30" bgcolor="#EBEBEB"> <div align="center"><img src="image/icon.gif" width="11" height="11"> 조회수</div></td>
							</tr><?
							$data=Decode64($data);
							$pagecnt=$data[pagecnt];
							$letter_no=$data[letter_no];
							$offset=$data[offset];
							if(!$searchstring)
							{
								$search=$data[search];
								$searchstring=$data[searchstring];
							}
							if($searchstring) $numresults=$MySQL->query("select idx from bbs_data where code='person_ask' and $search like '%$searchstring%'");
							else $numresults=$MySQL->query("select idx from bbs_data where code='person_ask'");
							$numrows=mysql_num_rows($numresults);				//총 레코드수..
							$LIMIT		=15;								//페이지당 글 수
							$PAGEBLOCK	=10;								//블럭당 페이지 수
							if($pagecnt==""){$pagecnt=0;}						//페이지 번호 
							if(!$offset){$offset=$pagecnt*$LIMIT*$PAGEBLOCK;} //각 페이지의 시작 글  
							if(!$letter_no){$letter_no=$numrows;}				//글번호
							if($searchstring)
							{
								$bbs_qry = "select * from bbs_data where code='person_ask' and $search like '%$searchstring%' ";
								$bbs_qry.= " order by ref desc,re_step asc limit $offset,$LIMIT";
							}
							else
							{
								$bbs_qry = "select * from bbs_data where code='person_ask'  order by ref desc,re_step asc limit $offset,$LIMIT";
							}
							$bbs_result=$MySQL->query($bbs_qry);
							$s_letter=$letter_no;								//페이지별 시작 글번호
							while($bbs_row=mysql_fetch_array($bbs_result))
							{
								$encode_str = "idx=".$bbs_row[idx]."&pagecnt=".$pagecnt."&letter_no=".$s_letter."&offset=".$offset;
								$encode_str.= "&search=".$search."&searchstring=".$searchstring."&present_num=".$letter_no;
								$data=Encode64($encode_str);					//각 레코드 정보
								//새글이미지
								if(BetweenPeriod($bbs_row[writeday],1) > 0) $newImg = "<img src='image/new4.gif'>";
								else $newImg = "";
								//첨부파일
								if(empty($bbs_row[up_file])) $upImg	= "";
								else $upImg	= "<img src='image/s_file.gif'>";
								if($bbs_row[re_level]>0)
								{
									//답변
									$wid=5*$bbs_row[re_level];              //레벨 이미지 길이
									$level_img="<img src=image/level.gif width=".$wid." height=8><img src='image/re2.gif' width='14' height='10'>";
								}
								else
								{
									$level_img="";
								}
								if(!$bbs_row[badmin] && !$bbs_row[bRead])
								{
									$title = "<b>".StringCut($bbs_row[title],80)."</b>";
								}
								else
								{
									$title = StringCut($bbs_row[title],80);
								}
								?>
							<tr valign="middle" bgcolor="fafafa" style='cursor:pointer;' onMouseOver="this.style.backgroundColor='#EBEBEB'" onMouseOut="this.style.backgroundColor=''" onclick="location.href='ask_view.php?data=<?=$data?>&code=<?=$code?>'">
								<td height="25" width="10%" > <div align="center"><?=$letter_no?></div></td>
								<td height="25" width="54%" > <div align="left">&nbsp;<?=$level_img?> <?=$title?> <?=$newImg?> <?=$upImg?></div></td>
								<td height="25" width="13%" > <div align="center"><?=str_replace("-","/",substr($bbs_row[writeday],0,10))?></div></td>
								<td height="25" width="13%" > <div align="center"><?=$bbs_row[name]?></div></td>
								<td height="25" width="10%" > <div align="center"><?=$bbs_row[readnum]?></div></td>
							</tr><?
								$letter_no--;
							}
							include "../lib/class.php";
							$Obj=new CList("ask.php",$pagecnt,$offset,$numrows,$PAGEBLOCK,$LIMIT,$search,$searchstring,"code=$code");
							$pre_icon_img="<img src='image/pre_btn.gif' width='40' height='17' border='0'>";		//이전아이콘
							$next_icon_img="<img src='image/next_btn.gif' width='40' height='17' border='0'>";	//다음아이콘
							?>
						</table><br>
						<table width="100%" border="0" bgcolor="#FFFFFF">
							<tr bgcolor="#FFFFFF">
								<td ><div align="center"><font color="#0099CC"><?$Obj->putList(true,$pre_icon_img,$next_icon_img);//이전다음 프린트?></font></div></td>
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