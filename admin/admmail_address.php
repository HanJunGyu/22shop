<?
include "head.php";
if (__DEMOPAGE) $readonly = "readonly";
?>
<SCRIPT LANGUAGE="JavaScript">
<!--
var idxArr;
var Index;
function adrDel(idx)
{
	var choose = confirm("해당주소록 정보가 삭제됩니다.\n\n삭제 하시겠습니까?");
	if(choose)
	{
		location.href="admmail_address_edit_ok.php?edit_part=del&idx=" + idx;
	}
	else return;
}
function adrSearch()
{
	var form = document.adrSearchForm;
	if(form.searchstring.value=="")
	{
		alert("검색어를 입력해 주십시오.");
		form.searchstring.focus();
		return false;
	}
	else
	{
		return true;
	}
}
function allChek(part)
{
	o = document.f.chekidx;
	if ( o != null )
	{
		if ( o.length != null ) 
		{
			for ( var i = 0 ; i < o.length ; i++ )
			{
				o[i].checked = part;
			}
		}
		else 
		{
			o.checked = part;
		}
	}
}
function allDel()
{
	idxArr = new Array();
	Index = 0;
	o = document.f.chekidx;
	if ( o != null )
	{
		if ( o.length != null ) 
		{
			for ( var i = 0 ; i < o.length ; i++ )
			{
				if(o[i].checked)
				{
					idxArr[Index] = o[i].value;
					Index++;
				}
			}
		}
		else 
		{
			if(o.checked)
			{
				idxArr[Index] = o.value;
				Index++;
			}
		}
		if(Index)
		{
			location.href="admmail_address_edit_ok.php?edit_part=alldel&idxStr=" + idxArr.join("-");
		}
		else
		{
			alert("선택한 개인이 없습니다.");
		}
	}
	else
	{
		alert("선택한 개인이 없습니다.");
	}
}
function allMailSend()
{
	idxArr = new Array();
	Index = 0;
	o = document.f.chekidx;
	if ( o != null )
	{
		if ( o.length != null ) 
		{
			for ( var i = 0 ; i < o.length ; i++ )
			{
				if(o[i].checked)
				{
					idxArr[Index] = o[i].value;
					Index++;
				}
			}
		}
		else 
		{
			if(o.checked)
			{
				idxArr[Index] = o.value;
				Index++;
			}
		}
		if(Index)
		{
			location.href="admmail_write.php?w_to_idxStr=" + idxArr.join("-");
		}
		else
		{
			alert("선택한 개인이 없습니다.");
		}
	}
	else
	{
		alert("선택한 개인이 없습니다.");
	}
}
function grpSearch(sgrp)
{
	location.href="admmail_address.php?sgrp=" + sgrp;
}
//-->
</SCRIPT>
<body bgcolor="#FFFFFF" text="#5A595A" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<? include "top_menu.php"; ?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr><?
	$__TOP_MENU = "admmail";     //왼쪽 소메뉴 설정 변수
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
					<td height='5'></td>
				</tr>
				<tr>
					<td>
						<table width="750" border="0" cellspacing="0" cellpadding="0" align='center'>
							<tr>
								<td rowspan="3" width="200"><img src="image/admmail_tit_img.gif"></td>
								<td>&nbsp;</td>
							</tr>
							<tr>
								<td bgcolor="#E6E6E6" height='26'><div align='right'><font class='text1'>SHOP 관리자메일 설정을 하실수 있습니다.&nbsp;</div></td>
							</tr>
							<tr>
								<td>&nbsp;</td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td height="2" valign="top">
						<table width="750" border="0" cellspacing="0" cellpadding="0" align="center">
							<tr>
								<td bgcolor='DADADA' height='1'></td>
							</tr>
							<tr>
								<td>
									<table width="750" border="0" cellspacing="0" cellpadding="0" align="center">
										<tr>
											<td width='440'><img src="image/admmail_tit_5.gif"></td>
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
								<td valign="top" align="center">
									<table width="100%" border="0" cellspacing="0" cellpadding="0">
										<? include "admmail_address_top.php";?>
										<tr>
											<td>&nbsp;</td>
										</tr>
										<tr>
											<td>
												<table width="100%" border="0" cellspacing="0" cellpadding="0">
													<tr>
														<td width="83"><a href="admmail_address.php"><img src="image/webmail/menu_1.gif" width="83" height="28" border="0"></a></td>
														<td width="83"><a href="admmail_group.php"><img src="image/webmail/menu_2_1.gif" width="83" height="28" border="0"></a></td>
														<td>&nbsp;</td>
														<td width="85"><a href="admmail_address_add.php"><img src="image/webmail/person_btn.gif" width="77" height="23" border="0"></a></td>
														<td width="80"><a href="admmail_group_add.php"><img src="image/webmail/group_btn.gif" width="77" height="23" border="0"></a></td>
													</tr>
												</table>
											</td>
										</tr>
										<tr>
											<td bgcolor="7DBA0C" height="35">
												<form name="adrSearchForm" method="post" action="admmail_address.php" onsubmit="return adrSearch();">
												<table width="100%" border="0" cellspacing="0" cellpadding="0">
													<tr>
														<td width="10">&nbsp;</td>
														<td><font color="#FFFFFF">|</font><?
														for($i=0;$i<count($HAN_JA_ARR);$i++)
														{
															if($han==$i && $han!="")
															{
																?><a href="admmail_address.php?han=<?=$i?>"><B><FONT COLOR="#000000" size="3"><?=$HAN_JA_ARR[$i]?></FONT></B></a><FONT COLOR="ffffff">|</FONT><?
															}
															else
															{
																?><a href="admmail_address.php?han=<?=$i?>"><FONT COLOR="ffffff"><?=$HAN_JA_ARR[$i]?></FONT></a><FONT COLOR="ffffff">|</FONT><?
															}
														}
														?></td>
														<td width="70"> <div align="center"> <select name="search"><option selected value="name">이름</option><option value="email">이메일</option></select></div></td>
														<td width="85"> <input type="text" name="searchstring" size="12"></td>
														<td width="45"> <div align="center"><input type="image" src="image/webmail/search_btn.gif" width="35" height="17" border="0"></div></td>
													</tr>
												</table>
												</form>
											</td>
										</tr>
										<tr>
											<td bgcolor="D6EFE7">
												<table width="100%" border="0" cellspacing="0" cellpadding="0" height="30">
													<tr>
														<td width="70"> <div align="center"><a href="javascript:allChek(true);"><img src="image/webmail/all_btn.gif" width="61" height="17" border="0"></a></div></td>
														<td width="70"><a href="javascript:allChek(false);"><img src="image/webmail/select_cancel.gif" width="61" height="17" border="0"></a></td>
														<td width="80">선택한 주소를</td>
														<td width="40"><a href="javascript:allDel();"><img src="image/webmail/delete_btn.gif" width="35" height="17" border="0"></a></td>
														<td><a href="javascript:allMailSend();"><img src="image/webmail/send_mail.gif" width="71" height="17" border="0"></a></td>
														<td align="right"><select name="sgrp" onchange="javascript:grpSearch(this.value);"><option value="">그룹전체</option><?
														$grp_result = $MySQL->query("select * from webmail_adr_grp where badmin=1");
														while($grp_row = mysql_fetch_array($grp_result))
														{
															?><option value="<?=$grp_row[code]?>" <?if($sgrp==$grp_row[code]){echo"selected";}?>><?=$grp_row[name]?></option><?
														}
														?></select></td>
													</tr>
												</table>
											</td>
										</tr>
										<tr>
											<td valign="top"><FORM NAME="f">
												<table width="100%" border="0" cellspacing="0" cellpadding="0">
													<tr>
														<td colspan="6" height="1" bgcolor="cdcdcd"></td>
													</tr>
													<tr>
														<td height="30" width="40" bgcolor="f4f4f4"></td>
														<td height="30" width="100" bgcolor="f4f4f4"> <div align="center">이름</div></td>
														<td height="30" width="200" bgcolor="f4f4f4"> <div align="center">이메일</div></td>
														<td height="30" bgcolor="f4f4f4" width="130"> <div align="center">그룹</div></td>
														<td height="30" bgcolor="f4f4f4"> <div align="center">전화번호</div></td>
														<td height="30" width="120" bgcolor="f4f4f4"> <div align="center">수정 | 삭제</div></td>
													</tr>
													<tr>
														<td colspan="6" height="1" bgcolor="cdcdcd"></td>
													</tr>
													<tr>
														<td colspan="6" height="2" bgcolor="f4f4f4"></td>
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
													$cut_qry = " ";
													if($sgrp)
													{
														$cut_qry.= " and grp='$sgrp'";
													}
													if($han!="")
													{
														if($han <13)
														{
															$next_han = $han+1;
															$cut_qry.=" and ascii(name) >= ascii('$HAN_ARR[$han]') and ascii(name) < ascii('$HAN_ARR[$next_han]')";
														}
														else if($han==13)
														{
															$cut_qry.=" and ascii(name) >= ascii('$HAN_ARR[$han]')";
														}
														else
														{
															$cut_qry.=" and ascii(name) < ascii('$HAN_ARR[0]') ";
														}
													}
													if($searchstring) $numresults=$MySQL->query("select idx from webmail_adr where badmin=1 and $search like '%$searchstring%' ".$cut_qry);
													else $numresults=$MySQL->query("select idx from webmail_adr where badmin=1 ".$cut_qry);
													$numrows=mysql_num_rows($numresults);				//총 레코드수..
													$LIMIT		= 15;
													$PAGEBLOCK	= 10;								//블럭당 페이지 수
													if($pagecnt==""){$pagecnt=0;}						//페이지 번호 
													if(!$offset){$offset=$pagecnt*$LIMIT*$PAGEBLOCK;} //각 페이지의 시작 글  
													if(!$letter_no){$letter_no=$numrows;}				//글번호
													if($searchstring)
													{
														//검색
														$bbs_qry = "select * from webmail_adr where badmin=1 and $search like '%$searchstring%' ".$cut_qry;
														$bbs_qry.= " order by name asc limit $offset,$LIMIT";
													}
													else
													{
														$bbs_qry = "select * from webmail_adr where badmin=1 ".$cut_qry." order by name asc limit $offset,$LIMIT";
													}
													$bbs_result=$MySQL->query($bbs_qry);
													$s_letter=$letter_no;								//페이지별 시작 글번호
													while($bbs_row=mysql_fetch_array($bbs_result))
													{
														if($bbs_row[grp])
														{
															$group_info = $MySQL->fetch_array("select name from webmail_adr_grp where code='$bbs_row[grp]'");
															$group_name = $group_info[name];
														}
														else
														{
															$group_name = "";
														}
														?>
													<tr>
														<td height="25"> <div align="center"> <input type="checkbox" name="chekidx" value="<?=$bbs_row[idx]?>"></div></td>
														<td height="25"> <div align="center"><?=$bbs_row[name]?></div></td>
														<td height="25"> <div align="center"><?=$bbs_row[email]?></div></td>
														<td height="25"> <div align="center"><?=$group_name?></div></td>
														<td height="25"> <div align="center"><?=$bbs_row[tel]?></div></td>
														<td height="25"> <div align="center"><a href="admmail_address_edit.php?idx=<?=$bbs_row[idx]?>"><img src="image/webmail/edit_btn.gif" width="35" height="17" border="0"></a> <a href="javascript:adrDel(<?=$bbs_row[idx]?>);"><img src="image/webmail/delete_btn.gif" width="35" height="17" border="0"></a> </div></td>
													</tr>
													<tr>
														<td colspan="6" height="1" background="image/webmail/bg2.gif"></td>
													</tr><?
														$letter_no--;
													}
													include "../lib/class.php";
													$Obj=new CList("admmail_address.php",$pagecnt,$offset,$numrows,$PAGEBLOCK,$LIMIT,$search,$searchstring,"sgrp=$sgrp&han=$han");
													$pre_img = "<img src='image/webmail/prev_btn.gif' border='0'>";
													$next_img = "<img src='image/webmail/next_btn.gif' border='0'>";
													?>
												</table></form>
											</td>
										</tr>
										<tr>
											<td height="30" bgcolor="D6EFE7">
												<table width="70%" border="0" cellspacing="0" cellpadding="0" align="center">
													<tr>
														<td> <div align="center"><?$Obj->putList(true,$pre_img,$next_img);//이전다음 프린트?></div></td>
													</tr>
												</table>
											</td>
										</tr>
									</table></div>
								</td>
							</tr>
							<tr>
								<td valign="top">&nbsp;</td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>
<? include "copy.php"; ?>
</body>
</html>