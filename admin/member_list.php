<?
include "head.php";
?>
<SCRIPT LANGUAGE="JavaScript">
<!--
//소팅 전송   (정렬기준,방법)
function Sort(sortStr,sort)
{
	var form=document.sortForm;
	form.sort.value		=sort;
	form.sortStr.value	=sortStr;
	form.submit();
}
function searchSendit()
{
	var form=document.searchForm;
	if(form.searchstring.value=="")
	{
		alert("검색 내용을 입력해 주십시오.");
		form.searchstring.focus();
	}
	else
	{
		form.submit();
	}
}
function memberDel(Data)
{
	var choose = confirm("회원 정보가 삭제됩니다.\n\n삭제 하시겠습니까?");
	if(choose)
	{
		location.href="member_edit_ok.php?del=1&data="+Data;
	}
	else return;
}
function memberPermail(To)
{
	if(To=="")
	{
		alert("회원 메일이 없습니다.");
	}
	else
	{
		window.open("../email/mail.php?To="+To+"&From=admin","","scrollbars=yes,left=200,top=100,width=620,height=483");
	}
}
function memberPersms(Hand,Err)
{
	if(Err)
	{
		alert("회원의 휴대전화 정보가 올바르지 않습니다.");
	}
	else
	{
		window.open("../sms/sms.php?hand="+Hand,"","scrollbars=yes,left=200,top=200,width=400,height=350");
	}
}
function smsErr()
{
	alert("SMS 미사용 상태 이거나 혹은 SMS 정보가 올바르지 않습니다.\n\nSMS 관리의 정보를 확인 하시기 바랍니다.");
}
function trade(str)
{
	window.open("member_trade.php?userid="+str,"","scrollbars=yes,left=20,top=50,width=880,height=300");
}
function trade_all()
{
	window.open("member_trade.php?all=1","","scrollbars=yes,left=20,top=20,width=880,height=700");
}
function mail_send_all(str)
{
	location.href="member_sendmail.php?idx_arr="+str; 
}
function sms_send_all(str)
{
	location.href="member_sms.php?idx_arr="+str; 
}
function excel(str)
{
	var form=document.searchForm;
	form.action = "member_list_excel.php";
	form.submit();
	form.action = "member_list.php";
}
function member(data)
{
	window.open("member.php?data="+data,"","scrollbars=yes,left=10,top=10,width=800,height=700");
}
function point_detail()
{
	window.open("member_point.php","","scrollbars=yes,left=10,top=10,width=700,height=700");
}
/////////생일메일////////////// 
function birth_send_all(str)
{
	location.href="member_sendmail.php?idx_arr="+str+"&birth=1"; 
}
function birth_send_all2(str)
{
	location.href="member_sendmail.php?idx_arr="+str+"&birth2=1"; 
}
//-->
</SCRIPT>
<body bgcolor="#FFFFFF" text="#5A595A" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<? include "top_menu.php"; ?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr><?
	$__TOP_MENU = "member";     //왼쪽 소메뉴 설정 변수
	include "left_menu.php";
	$sms=$MySQL->fetch_array("select *from smsinfo limit 0,1"); //sms 정보 배열
	?>
<form name="sortForm" method="post" action="member_list.php">
<input type="hidden" name="sort"><!-- 정렬방법 ex)asc:오름차순  desc:내림차순 -->
<input type="hidden" name="sortStr"><!-- 정렬기준 ex)name:이름  price:가격 -->
<input type="hidden" name="position" value="<?=$position?>"><!-- 위치 -->
<input type="hidden" name="search" value="<?= $search?>">
<input type="hidden" name="searchstring" value="<?= $searchstring?>">
<input type="hidden" name="gubun" value="<?= $gubun?>">
<input type="hidden" name="sex" value="<?= $sex?>">
<input type="hidden" name="age" value="<?= $age?>">
<input type="hidden" name="money" value="<?= $money?>">
<input type="hidden" name="price" value="<?= $price?>">
<input type="hidden" name="updown" value="<?= $updown?>">
<input type="hidden" name="break" value="<?= $break?>">
<input type="hidden" name="what" value="<?= $what?>">
<input type="hidden" name="data" value="<?=$sortData?>">
</form>
		<td width="85%" valign="top" height="400">
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td height='5'></td>
				</tr>
				<tr>
					<td>
						<table width="750" border="0" cellspacing="0" cellpadding="0" align='center'>
							<tr>
								<td rowspan="3" width="200"><img src="image/member_tit.gif"></td>
								<td>&nbsp;</td>
							</tr>
							<tr>
								<td bgcolor="#E6E6E6" height='26'><div align='right'><font class='text1'>SHOP 회원전체목록 및 전체메일발송 등을 하실수 있습니다.&nbsp;</div></td>
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
								<td width='0' bgcolor='dadada' colspan='3'></td>
							</tr>
							<tr>
								<td width='430'><img src="image/member_list.gif"></td>
							</tr>
							<tr>
								<td width='1' bgcolor='dadada' colspan='3'></td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
				</tr>
				<tr>
					<td valign="top">
						<table width="800" border="0" cellspacing="3" cellpadding="0" align="center">
							<tr>
								<td>
									<!-- 검색폼 시작 -->
									<form name="searchForm" action="member_list.php" method="post">
									<table width="800" cellspacing="0" cellpadding='0' border='0' class="table"  bgcolor='f6f6f6'>
										<tr>
											<td>
												<table cellspacing=3>
													<tr>
														<td bgcolor="D6E3E7" width="60" align="center"><b>일 반</b></td>
														<td bgcolor="D6E3E7"><select name="search"><option value="name">성명</option><option value="userid">아이디</option></select></td>
														<td><input class="box" type="text" name="searchstring" size="15"></td>
														<td bgcolor="D6E3E7" width="60" align="center"><b>분 류</b></td>
														<td bgcolor="D6E3E7"><select name="gubun"><option value="0">#분 류#</option><option value="M" <? if ($gubun=="M") echo "selected";?>>일반회원</option><option value="D" <? if ($gubun=="D") echo "selected";?>>도매회원</option></select></td>
													</tr>
												</table>
											</td>
										</tr>
										<tr>
											<td>
												<table cellspacing=3>
													<tr>
														<td bgcolor="D6E3E7" width=60 align=center><b>성 별</b></td>
														<td><select name="sex"><option value="0">#성별#</option><option value="1" <? if ($sex=="1") echo "selected";?>>남성회원</option><option value="2" <? if ($sex=="2") echo "selected";?>>여성회원</option></select></td>
														<td  bgcolor="D6E3E7" width=60 align=center><b>연 령</b></td>
														<td><select name="age"><option value="0">#연령별#</option><option value="10" <? if ($age=="10") echo "selected";?>>10대</option><option value="20" <? if ($age=="20") echo "selected";?>>20대</option><option value="30" <? if ($age=="30") echo "selected";?>>30대</option><option value="40" <? if ($age=="40") echo "selected";?>>40대</option><option value="50" <? if ($age=="50") echo "selected";?>>50대</option><option value="60" <? if ($age=="60") echo "selected";?>>60대</option><option value="70" <? if ($age=="70") echo "selected";?>>70대</option></select></td>
														<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
														<td bgcolor="D6E3E7" width=60 align=center><b>금 액</b></td>
														<td><select name="money"><option value="0">#금액분류#</option><option value="point" <? if ($money=="point") echo "selected";?>>적립금이</option><option value="buyMoney" <? if ($money=="buyMoney") echo "selected";?>>구매금액이</option></select>&nbsp;<input type="text" class="box" name="price" size="10" value="<?=$price?>"> 원 <select name="updown"><option value="up" <? if ($updown=="up") echo "selected";?>>이상</option><option value="down" <? if ($updown=="down") echo "selected";?>>이하</option></select></td>
													</tr>
												</table>
											</td>
										</tr>
										<tr>
											<td height='1' bgcolor='cdcdcd'></td>
										</tr>
										<tr>
											<td>
												<table cellspacing=3>
													<tr>
														<td bgcolor="D6E3E7" width="60" align="center"><b>휴면고객</b></td>
														<td><select name="break"><?
														for ($i=1; $i<13; $i++)
														{
															?><option value="<?=$i?>" <? if ($break==$i) echo "selected";?>><?=$i."개월간"?></option><?
														}
														?></select> <input type="radio" name="what" value="buy" <? if ($what=="buy") echo "checked";?>>구매  <input type="radio" name="what" value="visit" <? if ($what=="visit") echo "checked";?>>방문 &nbsp;없는 고객 </td>
														<td width=350 align='right'><font class='text1'>(* 검색 항목을 선택하신후 검색버튼을 클릭하세요.) </font></td>
														<td width='50'>&nbsp;<input type="image" src="image/bbs_search_btn.gif" width="41" height="23"></td>
													</tr>
												</table>
											</td>
										</tr>
										<tr>
											<td height='1' bgcolor='cdcdcd'></td>
										</tr>
										<tr>
											<td bgcolor='ffffff'>
												<table cellspacing="0" cellpadding='3' border='0' width="100%" >
													<tr>
														<td align="left"><input type="button" class="text" value="적립금내역 전체보기" onclick="point_detail()">&nbsp;<input type="button" class="text" value="회원구매정보 전체보기" onclick="trade_all();"></td>
													</tr>
													<tr>
														<td colspan=3><input type="button" class="text" value="금일 생일회원 검색" onclick="location.href='member_list.php?birthmail=1';">&nbsp;&nbsp;<input type="button" class="text" value="금일 결혼기념일 회원 검색" onclick="location.href='member_list.php?birthmail2=1';"></td>
													</tr>
												</table>
											</td>
										</tr>
									</table></form><!-- searchForm --><!-- 검색폼 끝 -->
								</td>
							</tr>
							<tr>
								<td height='15'></td>
							</tr>
						</table>
						<table width="800" cellspacing="1" cellpadding='0' border='0'  bgcolor='cdcdcd' align='center'>
							<tr valign="middle">
								<td width="7%" height="30" bgcolor="#EBEBEB" background="image/bbs_tit_bg.jpg"> <div align="center"> 번호</div></td>
								<td width="15%" height="30" bgcolor="#EBEBEB" background="image/bbs_tit_bg.jpg"> <div align="center">등급 </div></td>
								<td width="10%" height="30" bgcolor="#EBEBEB" background="image/bbs_tit_bg.jpg"> <div align="center">ID </div></td>
								<td width="8%" height="30" bgcolor="#EBEBEB"> <div align="center"> 성명</div></td>
								<td width="9%" height="30" bgcolor="#EBEBEB"> <div align="center"> 가입일자</div></td>
								<td width="9%" height="30" bgcolor="#EBEBEB"> <div align="center"> 구매금액<br><a href="javascript:Sort('buyMoney','asc');">△</a> <a href="javascript:Sort('buyMoney','desc');">▽</a></div></td>
								<td width="7%" height="30" bgcolor="#EBEBEB"> <div align="center"> 적립금<br><a href="javascript:Sort('point','asc');">△</a> <a href="javascript:Sort('point','desc');">▽</a></div></td>
								<td width="8%" height="30" bgcolor="#EBEBEB"> <div align="center"> 방문수<br><a href="javascript:Sort('accNum','asc');">△</a> <a href="javascript:Sort('accNum','desc');">▽</a></div></td>
								<td width="10%" height="30" bgcolor="#EBEBEB"> <div align="center"> 구매정보보기</div></td>
								<td width="7%" height="30" bgcolor="#EBEBEB"> <div align="center"> 메일</div></td>
								<td width="7%" height="30" bgcolor="#EBEBEB"> <div align="center"> SMS</div></td>
								<td width="7%" height="30" bgcolor="#EBEBEB"> <div align="center"> 삭제</div></td>
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
							if(empty($sort1))
							{
								$sort1= "writeday";
								$sort2= "desc";
							}
							if ($gubun) //////// 분류검색이 있을땐 기본적으로 회원,딜러만 가져오는 쿼리부분을 쓰면 중복된다.
							{
								$GUBUN_QRY = "1=1  ";
							}
							else
							{
								$GUBUN_QRY = "(part='M' or part='D')  ";
							}
							if($searchstring) $qry="select * from member where  $GUBUN_QRY and $search like '%$searchstring%'";
							else $qry="select * from member where $GUBUN_QRY ";
							if($what=="visit")
							{
								$now = date("Y-m-d",strtotime ("-$break months"));
								$qry.=" and (nearDay < '$now' or nearDay is NULL)";
							}
							if($what=="buy")
							{
								$now = date("Y-m-d",strtotime ("-$break months"));
								$qry.=" and (nearBuy < '$now' or nearBuy is Null)";
							}
							if($sex==1) $qry.=" and (mid(ssh,8,1)=1 or mid(ssh,8,1)=3)";
							if($sex==2) $qry.=" and (mid(ssh,8,1)=2 or mid(ssh,8,1)=4)";
							$today_year = substr(date("Y"),2,2)+101;
							if($age)
							{
								$start_age = $age/10;
								$end_age = $start_age+1;
								$qry.=" and (left($today_year-left(ssh,2),1)>=$start_age and left($today_year-left(ssh,2),1)<$end_age)";
							}
							if($money)
							{
								if ($updown == "up") $qry.=" and $money >= '$price'";
								else if ($updown == "down") $qry.=" and $money <= '$price'";
							}
							if($birthmail)
							{
								$tomonth = date("n");
								$today = date("j");
								$str = $tomonth."-".$today;
								$qry.= " and birth like '%-$str'";
							}
							if($birthmail2)
							{
								$tomonth = date("n");
								$today = date("j");
								$str = $tomonth."-".$today;
								$qry.= " and birth2 like '%-$str'";
							}
							if($gubun)
							{
								if($gubun=="M") $qry.=" and part='$gubun'";  
								else if($gubun=="D") $qry.=" and part='$gubun'";  
							}
							$numresults = $MySQL->query($qry);
							$numrows=mysql_num_rows($numresults);				//총 레코드수..
							while ($idx_row = mysql_fetch_array($numresults))
							{
								$idx_arr.= $idx_row[idx]."/";
							}
							$LIMIT		=$admin_row[member_list_cnt];;								//페이지당 글 수
							$PAGEBLOCK	=10;								//블럭당 페이지 수
							if($pagecnt==""){$pagecnt=0;}						//페이지 번호 
							if(!$offset){$offset=$pagecnt*$LIMIT*$PAGEBLOCK;} //각 페이지의 시작 글  
							if(!$letter_no){$letter_no=$numrows;}				//글번호
							if($sort)     $qry.= " order by $sortStr $sort ";
							else		$qry.= " order by writeday desc";
							$bbs_qry = $qry."  limit $offset,$LIMIT";
							$bbs_result=$MySQL->query($bbs_qry);
							$s_letter=$letter_no;								//페이지별 시작 글번호
							while($bbs_row=mysql_fetch_array($bbs_result))
							{
								$encode_str = "idx=".$bbs_row[idx]."&pagecnt=".$pagecnt."&letter_no=".$s_letter."&offset=".$offset;
								$encode_str.= "&search=".$search."&searchstring=".$searchstring."&present_num=".$letter_no;
								$data=Encode64($encode_str);					//각 레코드 정보
								$hand = explode("-",$bbs_row[hand]);
								if( ($hand[0]=="010" || $hand[0]=="011" ||$hand[0]=="016" ||$hand[0]=="017" ||$hand[0]=="018" ||$hand[0]=="019") && (strlen($hand[1])==3 || strlen($hand[1])==4) && strlen($hand[2]) ==4) $handErr =0;
								else					$handErr =1;
								?>
							<tr valign="middle" bgcolor="fafafa" onMouseOver="this.style.backgroundColor='#EBEBEB'" onMouseOut="this.style.backgroundColor=''" style="cursor:pointer">
								<td height="20" onclick="javascript:member('<?=$data?>');"> <div align="center"><?=$letter_no?></div></td>
								<td height="20" onclick="javascript:member('<?=$data?>');"> <div align="center"><?
								if ($bbs_row[part]=="M")
								{
									echo "회원";
								}
								else if ($bbs_row[part]=="D")
								{
									echo "<font color=green>도매회원</font>";
								}
								if ($bbs_row[bDeal]==1 && $bbs_row[part]=="M")
								{
									echo "<BR><font color=brown>사업자회원신청</font>";
								}
								?></div></td>
								<td height="20"  onclick="javascript:member('<?=$data?>');"> <div align="center"> <FONT COLOR="#6600FF"><u><?=$bbs_row[userid]?></u></FONT></div></td>
								<td height="20" onclick="javascript:member('<?=$data?>');"> <div align="center"><B><?=$bbs_row[name]?></B></div></td>
								<td height="20" onclick="javascript:member('<?=$data?>');"> <div align="center"><?=str_replace("-","/",substr($bbs_row[writeday],0,10))?></div></td>
								<td height="20" onclick="javascript:member('<?=$data?>');"> <div align="center"><?=PriceFormat($bbs_row[buyMoney])?></div></td>
								<td height="20" onclick="javascript:member('<?=$data?>');"> <div align="center"><?=PriceFormat($bbs_row[point])?></div></td>
								<td height="20" onclick="javascript:member('<?=$data?>');"> <div align="center"><?=$bbs_row[accNum]?></div></td>
								<td height="20"> <div align="center"><a href="javascript:trade('<?=$bbs_row[userid]?>');"><img src="image/bbs_search_btn.gif" border=0></a></div></td>
								<td height="20" bgcolor="fafafa"><div align="center"> <a href="javascript:memberPermail('<?=$bbs_row[email]?>');"><img src="image/mail_btn.gif" border="0"></a></div></td><?
								if($sms[bSms] && !empty($sms[userid]) && !empty($sms[pwd]))
								{
									?>
								<td height="20"  bgcolor="fafafa"><div align="center"> <a href="javascript:memberPersms('<?=$bbs_row[hand]?>',<?=$handErr?>);"><img src="image/sms_btn.gif" border="0"></a></div></td><?
								}
								else
								{
									?>
								<td height="20"  bgcolor="fafafa"><div align="center"> <a href="javascript:smsErr();"><img src="image/sms_btn.gif" border="0"></a></div></td><?
								}
								?>
								<td height="20" bgcolor="fafafa"><div align="center"> <a href="javascript:memberDel('<?=$data?>');"><img src="image/bbs_delete_btn.gif" width="40" height="17" border="0"></a></div></td>
							</tr><?
								$letter_no--;
							}
							$idx_arr = Laststrcut($idx_arr);
							include "../lib/class.php";
							$Obj=new CList("member_list.php",$pagecnt,$offset,$numrows,$PAGEBLOCK,$LIMIT,$search,$searchstring,"sortStr=$sortStr&sort=$sort&what=$what&sex=$sex&age=$age&money=$money&break=$break&&updown=$updown&price=$price");
							?>
						</table>
					</td>
				</tr>
				<tr valign="middle" bgcolor="ffffff">
					<td height="11" colspan="11">
						<table width="750" border="0" height='35' align=center>
							<tr>
								<td align="right"><img align="absmiddle" src="image/webmail/left_icon4.gif"> <a href="javascript:mail_send_all('<?=$idx_arr?>')"><b><u>검색된 회원에게 단체메일 보내기</u></b></a><br><img align="absmiddle" src="image/webmail/left_icon4.gif"> <a href="javascript:birth_send_all('<?=$idx_arr?>')"><b><u>검색된 생일회원에게 단체축하메일 보내기</u></b></a><br><img align="absmiddle" src="image/webmail/left_icon4.gif"> <a href="javascript:birth_send_all2('<?=$idx_arr?>')"><b><u>검색된 결혼기념일 회원에게 단체축하메일 보내기</u></b></a><br><br><a href="javascript:sms_send_all('<?=$idx_arr?>')"><b><u>검색된 회원에게 단체SMS 보내기</u></b></a><br><br><a href="javascript:excel();"><b><u>검색된 회원 EXCEL 다운로드</u></b></a></td>
							</tr>
							<tr>
								<td colspan=2 align="center"><?$Obj->putList(true,"","");//이전다음 프린트?></td>
							</tr>
						</table>
					</td>
				</tr>
			</table><br>
		</td>
	</tr>
</table>
<? include "copy.php";?>
</body>
</html>