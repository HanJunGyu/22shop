<?
include "head.php";
$bbs_admin_row = $MySQL->fetch_array("select *from bbs_list where code='$code'"); //게시판 정보
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
function checkAll()
{
	var form = document.form1;
	for (var i=0;i<form.elements.length;i++)
	{
		if (form.elements[i].checked == false) form.elements[i].checked = true;
		else form.elements[i].checked = false;
	}
}
function del()
{
	if (confirm("선택하신 자료를 삭제하시겠습니까?"))
	{
		var form = document.form1;
		var str = "";
		for (var i=0;i<form.elements.length;i++)
		{
			if (form.elements[i].checked == true)
			{
				if (str != "")
				{
					str = str + "/";
				}
				str = str + form.elements[i].value;
			}
		}
		if (str) location.href="bbs_del.php?mode=alldel&code=<?=$code?>&idx="+str;
		else alert('해당 게시물을 선택해주세요');
	}
}
//-->
</SCRIPT>
<body bgcolor="#FFFFFF" text="#5A595A" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<? include "top_menu.php"; ?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr><?
	$__TOP_MENU = "board";     //왼쪽 소메뉴 설정 변수
	include "left_menu.php";
	$actArr		= array("10" => "제한없음", "20" => "회원,관리자", "30" => "관리자");	//게시판 권한 배열
	$actKey		= array_keys($actArr);												//게시판 권한 배열 키값 ex) array("10","20","30")
	$partArr	= array("10" => "일반게시판", "20" => "자료실", "30" => "갤러리");		//게시판 유형 배열
	$partKey	= array_keys($partArr);												//게시판 유형 배열 키값 ex) array("10","20")
	if($bbs_admin_row[part]==30) $colspan = 7;	//갤러리
	else						 $colspan = 6;
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
								<td rowspan="3" width="200"><img src="image/board_tit.gif"></td>
								<td>&nbsp;</td>
							</tr>
							<tr>
								<td bgcolor="#E6E6E6" height='26'><div align='right'><font class='text1'>SHOP 게시판 추가,수정,삭제 등을 작성하실수 있습니다.&nbsp;</div></td>
							</tr>
							<tr>
								<td>&nbsp;</td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td valign="top">
						<form name="searchForm" action="bbs_list.php" method="post" onSubmit="return searchSendit();">
						<input type="hidden" name="code" value="<?=$code?>">
						<table width="750" border="0" cellspacing="0" cellpadding="0" align="center">
							<tr bgcolor="#FFFFFF">
								<td bgcolor="#FFFFFF">&nbsp;<B><?=$bbs_admin_row[name]?></B></td>
								<td width="10"> <select name="search"><option value="name">작성자</option><option value="title">제 목</option><option value="content">내 용</option></select></td>
								<td width="130"> <input class="box" type="text" name="searchstring" size="20"></td>
								<td width="71"><input type="image" src="image/bbs_search_btn.gif" width="41" height="23" border="0"></td>
							</tr>
						</table></form><!-- searchForm -->
						<form name="form1" method="post">
						<table width="750" border="0" cellspacing="1" cellpadding="0" align="center" bgcolor='cdcdcd'>
							<tr valign="middle">
								<td width="5%" height="30" bgcolor="#EBEBEB"> <div align="center"><a href="javascript:checkAll();">V</a></div></td>
								<td width="8%" height="30" bgcolor="#EBEBEB"> <div align="center"><img src="image/icon.gif" width="11" height="11"> 번호</div></td><?
								if($bbs_admin_row[part]==30)
								{
									?>
								<td width="14%" height="30" bgcolor="#EBEBEB"> <div align="center"><img src="image/icon.gif" width="11" height="11"> 이미지</div></td>
								<td width="40%" height="30" bgcolor="#EBEBEB"> <div align="center"><img src="image/icon.gif" width="11" height="11"> 제 목</div></td><?
								}
								else
								{
									?>
								<td width="44%" height="30" bgcolor="#EBEBEB"> <div align="center"><img src="image/icon.gif" width="11" height="11"> 제 목</div></td><?
								}
								?>
								<td width="12%" height="30" bgcolor="#EBEBEB"> <div align="center"><img src="image/icon.gif" width="11" height="11"> 작성일</div></td>
								<td width="15%" height="30" bgcolor="#EBEBEB"> <div align="center"><img src="image/icon.gif" width="11" height="11"> 작성자 / ID</div></td>
								<td width="9%" height="30" bgcolor="#EBEBEB"> <div align="center"><img src="image/icon.gif" width="11" height="11"> 조회수</div></td>
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
							if($searchstring) $numresults=$MySQL->query("select idx from bbs_data where code='$code' and gongji<>1 and $search like '%$searchstring%'");
							else $numresults=$MySQL->query("select idx from bbs_data where code='$code' and gongji<>1");
							$numrows=mysql_num_rows($numresults);				//총 레코드수..
							$LIMIT		=$admin_row[board_list_cnt];;								//페이지당 글 수
							$PAGEBLOCK	=10;								//블럭당 페이지 수
							if($pagecnt==""){$pagecnt=0;}						//페이지 번호 
							if(!$offset){$offset=$pagecnt*$LIMIT*$PAGEBLOCK;} //각 페이지의 시작 글  
							if(!$letter_no){$letter_no=$numrows;}				//글번호
							if($searchstring)
							{
								//검색
								$bbs_qry = "select * from bbs_data where code='$code' and gongji<>1 and $search like '%$searchstring%' ";
								$bbs_qry.= " order by ref desc,re_step asc limit $offset,$LIMIT";
							}
							else
							{
								$bbs_qry = "select * from bbs_data where code='$code' and gongji<>1 order by ref desc,re_step asc limit $offset,$LIMIT";
							}
							$bbs_result=$MySQL->query($bbs_qry);
							$s_letter=$letter_no;								//페이지별 시작 글번호
							$gongji_result = $MySQL->query("SELECT *from bbs_data where code='$code' and gongji=1 order by gongji_day desc");
							if (mysql_num_rows($gongji_result))
							{
								while ($gongji_row = mysql_fetch_array($gongji_result))
								{
									$encode_str = "idx=".$gongji_row[idx]."&pagecnt=".$pagecnt."&letter_no=".$s_letter."&offset=".$offset;
									$encode_str.= "&search=".$search."&searchstring=".$searchstring."&present_num=".$letter_no;
									$data=Encode64($encode_str);					//각 레코드 정보
									?>
							<tr valign="middle" bgcolor="#F4E5A9" onMouseOver="this.style.backgroundColor='#EBEBEB'" onMouseOut="this.style.backgroundColor=''">
								<td height="25"  ><div align="center"><input type="checkbox" name="boardno[]" value="<?=$gongji_row[idx]?>"></div></td>
								<td height="25"  > <div align="center"><b>공지</b></div></td><?
									if($bbs_admin_row[part]==30)
									{
										?>
								<td height="25" > <?
										if($gongji_row[img1])
										{
											?><div align="center"><img src="../upload/bbs/<?=$gongji_row[img1]?>" width="50" height="50"></div><?
										}
										else
										{
											?><div align="center" height="50">이미지없음</div><?
										}
										?></td>
								<td height="25" > <div align="left">&nbsp;<?=$level_img?> <a href="bbs_view.php?data=<?=$data?>&code=<?=$code?>"><b><?=StringCut($gongji_row[title],80)?></b></a> <?=$newImg?> <?=$upImg?></div></td><?
									}
									else
									{
										?>
								<td height="25" > <div align="left">&nbsp;<?=$level_img?> <a href="bbs_view.php?data=<?=$data?>&code=<?=$code?>"><b><?=StringCut($gongji_row[title],80)?></b></a> <?=$newImg?> <?=$upImg?></div></td><?
									}
									?>
								<td height="25" width="13%" > <div align="center"><?=str_replace("-","/",substr($gongji_row[gongji_day],0,10))?></div></td>
								<td height="25" > <div align="center"><?=$gongji_row[name]?></div></td>
								<td height="25" > <div align="center"><?=$gongji_row[readnum]?></div></td>
							</tr><?
								}
							}
							while($bbs_row=mysql_fetch_array($bbs_result))
							{
								$encode_str = "idx=".$bbs_row[idx]."&pagecnt=".$pagecnt."&letter_no=".$s_letter."&offset=".$offset;
								$encode_str.= "&search=".$search."&searchstring=".$searchstring."&present_num=".$letter_no;
								$data=Encode64($encode_str);					//각 레코드 정보
								$com_qry = "SELECT idx from comment where boardidx=$bbs_row[idx]";
								$com_num = $MySQL->articles($com_qry);
								if ($com_num)
								{
									$com_qry = "SELECT writeday from comment where boardidx=$bbs_row[idx] order by idx desc limit 1";
									$com_row = $MySQL->fetch_array($com_qry);
									$time_limit = 60*60*24*1;  // 24시간 
									$down_time = strtotime($com_row[writeday]);
									$date_diff = time() - $down_time;
									if ($date_diff > $time_limit) // 24시간 지남 
									{
										$com_num = "[".$com_num."]";
									}
									else $com_num = "<b>[".$com_num."]</b>";
								}
								else $com_num = "";
								//새글이미지
								if(BetweenPeriod($bbs_row[writeday],$bbs_admin_row[newPeriod]) > 0) $newImg = "<img src='image/new4.gif'>";
								else $newImg = "";
								//첨부파일
								if(empty($bbs_row[up_file]))	$upImg	= "";
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
								if ($bbs_row[bLock]=="y") $lock_img = "<img src='../image/lock.gif'>";
								else $lock_img = "";
								?>
							<tr valign="middle" bgcolor="fafafa" onMouseOver="this.style.backgroundColor='#EBEBEB'" onMouseOut="this.style.backgroundColor=''">
								<td height="25"  > <div align="center"><input type="checkbox" name="boardno[]" value="<?=$bbs_row[idx]?>"></div></td>
								<td height="25"  > <div align="center"><?=$letter_no?></div></td><?
								if($bbs_admin_row[part]==30)
								{
									?>
								<td height="25" ><?
									if($bbs_row[img1])
									{
										?><div align="center"><img src="../upload/bbs/<?=$bbs_row[img1]?>" width="50" height="50"></div><?
									}
									else
									{
										?><div align="center" height="50">이미지없음</div><?
									}
									?></td>
								<td height="25" ><div align="left">&nbsp;<?=$level_img?> <a href="bbs_view.php?data=<?=$data?>&code=<?=$code?>"><?=StringCut($bbs_row[title],80)?></a> <?=$com_num?> <?=$newImg?> <?=$upImg?> <?=$lock_img?></div></td><?
								}
								else
								{
									?>
								<td height="25" > <div align="left">&nbsp;<?=$level_img?> <a href="bbs_view.php?data=<?=$data?>&code=<?=$code?>"><?=StringCut($bbs_row[title],80)?></a> <?=$com_num?> <?=$newImg?> <?=$upImg?> <?=$lock_img?></div></td><?
								}
								?>
								<td height="25" width="13%" > <div align="center"><?=str_replace("-","/",substr($bbs_row[writeday],0,10))?></div></td>
								<td height="25" > <div align="center"><?=$bbs_row[name]?> / <?=$bbs_row[userid]?></div></td>
								<td height="25" > <div align="center"><?=$bbs_row[readnum]?></div></td>
							</tr><?
								$letter_no--;
							}
							include "../lib/class.php";
							$Obj=new CList("bbs_list.php",$pagecnt,$offset,$numrows,$PAGEBLOCK,$LIMIT,$search,$searchstring,"code=$code");
							$pre_icon_img="<img src='image/pre_btn.gif' width='40' height='17' border='0'>";		//이전아이콘
							$next_icon_img="<img src='image/next_btn.gif' width='40' height='17' border='0'>";	//다음아이콘
							?>
							<tr valign="middle">
								<td height="11" colspan="<?=$colspan?>" bgcolor="fafafa">
									<table width="100%" border="0" bgcolor="#FFFFFF">
										<tr bgcolor="#FFFFFF">
											<td width="43"><a href="bbs_write.php?code=<?=$code?>"><img src="image/bbs_write_btn.gif" width="46" height="17" border="0"></a></td>
											<td width="43" bgcolor="#FFFFFF"></td>
											<td width="43"><a href="javascript:del();"><img src="image/bbs_delete_btn.gif" border="0"></a></td>
											<td bgcolor="#FFFFFF">&nbsp;</td>
											<td width="81" bgcolor="#FFFFFF">&nbsp;</td>
											<td width="211"><div align="center"><font color="#0099CC"><?$Obj->putList(true,$pre_icon_img,$next_icon_img);//이전다음 프린트?></font></div></td>
										</tr>
									</table>
								</td>
							</tr>
						</table></form><!-- 게시판 글목록 끝 --><br>
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>
<? include "copy.php";?>
</body>
</html>