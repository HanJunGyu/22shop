<?
include "head.php";
if ($del)
{
	if ($MySQL->query("DELETE from goods_comment where idx=$idx limit 1"))
	{
		OnlyMsgView("상품평이 삭제되었습니다.");
	}
	else OnlyMsgView("상품평 삭제에 실패하였습니다.");
}
?>
<SCRIPT LANGUAGE="JavaScript">
<!--
function member(data)
{
	window.open("member.php?data="+data,"","scrollbars=yes,left=10,top=10,width=800,height=700");
}
//-->
</SCRIPT>
<body bgcolor="#FFFFFF" text="#5A595A" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<? include "top_menu.php"; ?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr><?
	$__TOP_MENU = "goods";     //왼쪽 소메뉴 설정 변수
	include "left_menu.php";
	$data=Decode64($data);
	$pagecnt=$data[pagecnt];
	$letter_no=$data[letter_no];
	$offset=$data[offset];
	$total_qry = "SELECT *from goods_comment where 1=1 $MALL_STR";
	if ($searchstring) $total_qry.= " and $search like '%$searchstring%'";
	$numresults=$MySQL->query($total_qry);
	$numrows=mysql_num_rows($numresults);				//총 레코드수..
	$LIMIT		=20;								//페이지당 글 수
	$PAGEBLOCK	=10;								//블럭당 페이지 수
	if($pagecnt==""){$pagecnt=0;}						//페이지 번호 
	if(!$offset){$offset=$pagecnt*$LIMIT*$PAGEBLOCK;} //각 페이지의 시작 글  
	if(!$letter_no){$letter_no=$numrows;}				//글번호
	$comment_qry = "SELECT *from goods_comment where 1=1 $MALL_STR";
	if ($searchstring) $comment_qry.= " and $search like '%$searchstring%'";
	$comment_qry.=" order by idx desc limit $offset,$LIMIT";
	$comment_result=$MySQL->query($comment_qry);
	$s_letter=$letter_no;								//페이지별 시작 글번호
	?>
		<td width="85%" valign="top">
			<table width="100%" height="500" border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td height='5'></td>
				</tr>
				<tr>
					<td>
						<table width="750" border="0" cellspacing="0" cellpadding="0" align='center'>
							<tr>
								<td rowspan="3" width="200"><img src="image/good_tit_img.gif"></td>
								<td>&nbsp;</td>
							</tr>
							<tr>
								<td bgcolor="#E6E6E6" height='26'><div align='right'><font class='text1'>SHOP 상품관리를 하실수 있습니다.&nbsp;</div></td>
							</tr>
							<tr>
								<td>&nbsp;</td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td height="2">
						<table width="750" border="0" cellspacing="0" cellpadding="0" align="center">
							<tr>
								<td bgcolor='DADADA' height='1'></td>
							</tr>
							<tr>
								<td>
									<table width="750" border="0" cellspacing="0" cellpadding="0" align="center">
										<tr>
											<td width='440'><img src="image/good_list_tit01.gif"></td>
										</tr>
									</table>
								</td>
							</tr>
							<tr>
								<td bgcolor='DADADA' height='1'></td>
							</tr>
							<tr>
								<td height='10'></td>
							</tr>
							<tr>
								<td valign="top">
									<table width="750" border="0" cellspacing="0" cellpadding="0" align="center" height="420">
										<tr>
											<td colspan="2" height="2">
												<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
													<tr>
														<td height="40" bgcolor="#F5F5F5">
															<table width="100%" border="0" bgcolor="#FAFAFA" align="center">
															<form name="searchForm" method="post" action="goods_comment.php">
																<tr bgcolor="#F5F5F5">
																	<td align="right"> <select name="search"><option value="name">상품명</option><option value="userid">작성자ID</option></select></td>
																	<td width="130" align="left"> <input class="box" type="text" name="searchstring" size="20"></td>
																	<td width="71"><input type="image"src="image/bbs_search_btn.gif" width="41" height="23" border="0"></td>
																</tr>
															</table></form><!-- searchForm -->
														</td>
													</tr>
												</table>
											</td>
										</tr>
										<tr>
											<td colspan="2" height="1" background="image/line_bg1.gif" bgcolor="#F5F5F5"></td>
										</tr>
										<tr>
											<td colspan="2" height="20"><font class="help">※ 아이디 클릭 - 회원정보 열람<br>※ 상품명 클릭 - 상품정보 열람 </font></td>
										</tr>
										<tr valign="middle">
											<td height="200" valign="top" colspan="2">
												<table width="100%" border="0" cellspacing="2" cellpadding="0" align="center" height="162">
													<tr>
														<td colspan="6" height="15"></td>
													</tr>
													<tr valign="middle">
														<td width="12%" height="30" bgcolor="#EBEBEB" background="image/goods_tit_bg.jpg"> <div align="center">카테고리</div></td>
														<td width="12%" height="30" bgcolor="#EBEBEB" background="image/goods_tit_bg.jpg"> <div align="center">상품명</div></td>
														<td width="8%" height="30" bgcolor="#EBEBEB" background="image/goods_tit_bg.jpg"> <div align="center">아이디</div></td>
														<td height="30" bgcolor="#EBEBEB"> <div align="center">상품평</div></td>
														<td width="12%" height="30" bgcolor="#EBEBEB"> <div align="center">날짜</div></td>
														<td width="8%" height="30" bgcolor="#EBEBEB"> <div align="center">삭제</div></td>
													</tr>
													<tr>
														<td colspan="6" height="1" background="image/line_bg1.gif"></td>
													</tr><?
													while($comment_row=mysql_fetch_array($comment_result))
													{
														$encode_str = "idx=".$comment_row[idx]."&pagecnt=".$pagecnt."&letter_no=".$s_letter."&offset=".$offset;
														$encode_str.= "&search=".$search."&searchstring=".$searchstring."&present_num=".$letter_no;
														$data=Encode64($encode_str);					//각 레코드 정보
														$goods_row = $MySQL->fetch_array("select idx,category,name from goods where idx=$comment_row[gidx] limit 1");
														$encode_str2 = "idx=".$goods_row[idx];
														$data2=Encode64($encode_str2);
														//카테고리 정보
														$cate_row = $MySQL->fetch_array("select *from category where code='$goods_row[category]'");
														$category = $cate_row[name];
														$member_row = $MySQL->fetch_array("SELECT idx from member WHERE userid='$comment_row[userid]' limit 1");
														$encode_str_mem =  "idx=".$member_row[idx];
														$data_mem=Encode64($encode_str_mem);
														?>
													<tr valign="middle" bgcolor="fafafa">
														<td height="25"><div align="center"><B><?=$category?></b></div></td>
														<td height="25" > <div align="center"><a href="goods_edit.php?data=<?=$data2?>&returnPage=goods_comment.php" target="_blank"><?=$comment_row[name]?></a></div></td>
														<td height="25" > <div align="center"><?
														if($member_row[idx])
														{
															?><a href="#;" onclick="member('<?=$data_mem?>')"><?=$comment_row[userid]?></a><?
														}
														else
														{
															?><?=$comment_row[userid]?><?
														}
														?></div></td>
														<td height="25" > <div align="left"><?=nl2br($comment_row[content])?></div></td>
														<td height="25" > <div align="center"><?=Substr($comment_row[writeday],0,10)?></div></td>
														<td height="25" > <div align="center"><a href="goods_comment.php?del=1&idx=<?=$comment_row[idx]?>"><img src="image/delete_btn.gif" border=0></a></div></td>
													</tr>
													<tr>
														<td colspan="6" height="1" background="image/line_bg1.gif"></td>
													</tr><?
														$letter_no--;
													}
													include "../lib/class.php";
													$Obj=new CList("goods_comment.php",$pagecnt,$offset,$numrows,$PAGEBLOCK,$LIMIT,$search,$searchstring,$optionStr);
													$pre_icon_img="<img src='image/pre_btn.gif' width='40' height='17' border='0'>";		//이전아이콘
													$next_icon_img="<img src='image/next_btn.gif' width='40' height='17' border='0'>";	//다음아이콘
													?>
													<tr valign="middle">
														<td height="11" colspan="6">
															<table width="80%" border="0" bgcolor="#FFFFFF" align="center">
																<tr bgcolor="#FFFFFF">
																	<td ><div align="center"><font color="#0099CC"><?$Obj->putList(true,$pre_icon_img,$next_icon_img);//이전다음 프린트?></font></div></td>
																</tr>
															</table>
														</td>
													</tr>
												</table>
											</td>
										</tr>
									</table><br>
								</td>
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