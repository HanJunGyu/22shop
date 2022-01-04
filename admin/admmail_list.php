<?
include "head.php";
if (__DEMOPAGE)
{
	$readonly = "readonly";
}
if(empty($mbox))
{
	OnlyMsgView("올바른 접근이 아닙니다.");
	ReFresh("admmail_adm.php");
	exit;
}
include "../lib/webmail_function.php";
?>
<SCRIPT LANGUAGE="JavaScript">
<!--
var idxArr;
var Index;
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
			location.href="admmail_list_ok.php?mbox=<?=$mbox?>&edit_part=alldel&idxStr=" + idxArr.join("-");
		}
		else
		{
			alert("선택한 메일이 없습니다.");
		}
	}
	else
	{
		alert("선택한 메일이 없습니다.");
	}
}
function allMove(movebox)
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
			location.href="admmail_list_ok.php?mbox=<?=$mbox?>&edit_part=allmove&movebox="+movebox+"&idxStr=" + idxArr.join("-");
		}
		else
		{
			alert("선택한 메일이 없습니다.");
			document.getElementById('move_mbox').selectedIndex =0;
		}
	}
	else
	{
		alert("선택한 메일이 없습니다.");
		document.getElementById('move_mbox').selectedIndex =0;
	}
}
function mailSearch()
{
	var form = document.mailSForm;
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
						<table width="750" border="0" cellspacing="0" cellpadding="0" align="center"><?
						$MySQL->query("select idx from webmail_mail where badmin=1 and mbox='$mbox' and bRead=0");
						$noread_mail_cnt = $MySQL->is_affected();
						$MySQL->query("select idx from webmail_mail where badmin=1 and mbox='$mbox'");
						$total_mail_cnt = $MySQL->is_affected();
						?>
							<tr>
								<td valign="top">
									<table width="100%" border="0" cellspacing="0" cellpadding="0"><?
									if($mbox <=4)
									{
										$icon = $mbox +1;
										?>
										<tr>
											<td height="30"><img src="image/webmail/left_icon<?=$icon?>.gif" align="absmiddle"> <?=$MBOX_NAME[$mbox]?> : 새편지 <?=$noread_mail_cnt?>통 / 전체 <?=$total_mail_cnt?>통</td>
										</tr><?
									}
									else
									{
										$icon =6;
										$mbox_name_row = $MySQL->fetch_array("select name from webmail_mbox where mbox='$mbox'");
										?>
										<tr>
											<td height="30"><img src="image/webmail/left_icon<?=$icon?>.gif" align="absmiddle"> <?=$mbox_name_row[name]?> : 새편지 <?=$noread_mail_cnt?>통 / 전체 <?=$total_mail_cnt?>통</td>
										</tr><?
									}
									?>
										<tr>
											<td bgcolor="D6EFE7">
												<table width="100%" border="0" cellspacing="0" cellpadding="0" height="30">
													<tr>
														<td width="70" align="center"><a href="javascript:allChek(true);"><img src="image/webmail/all_btn.gif" width="61" height="17" border="0"></a></div></td>
														<td width="70"><a href="javascript:allChek(false);"><img src="image/webmail/select_cancel.gif" width="61" height="17" border="0"></a></td>
														<td><a href="admmail_main.php?mbox=<?=$mbox?>"><img src='../image/webmail/replay.gif' border='0'></a></td>
														<td width="65">선택한 편지</td>
														<td width="45"> <div align="center"><a href="javascript:allDel();"><img src="image/webmail/delete_btn.gif" width="35" height="17" border="0"></a></div></td>
														<td width="170"> <div align="center"> <select name="move_mbox" onchange="javascript:allMove(this.value);"><option selected value="">-다른편지함으로옮기기-</option><?
														for($i=1;$i<=4;$i++)
														{
															if($mbox!=$i)
															{
																?><option value="<?=$i?>"><?=$MBOX_NAME[$i]?></option><?
															}
														}
														$my_mbox_result = $MySQL->query("select * from webmail_mbox where badmin=1");
														while($my_mbox_row = mysql_fetch_array($my_mbox_result))
														{
															if($my_mbox_row[mbox]!=$mbox)
															{
																?><option value="<?=$my_mbox_row[mbox]?>"><?=$my_mbox_row[name]?></option><?
															}
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
														<td height="30" width="40" bgcolor="f4f4f4">&nbsp;</td>
														<td height="30" width="40" bgcolor="f4f4f4"> <div align="center">첨부</div></td>
														<td height="30" width="100" bgcolor="f4f4f4"> <div align="center">&nbsp;보낸이</div></td>
														<td height="30" bgcolor="f4f4f4"> <div align="center">제목</div></td>
														<td height="30" width="120" bgcolor="f4f4f4"> <div align="center">받은날짜</div></td>
														<td height="30" width="60" bgcolor="f4f4f4"> <div align="center">크기</div></td>
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
														//검색
														$search=$data[search];
														$searchstring=$data[searchstring];
													}
													$cut_qry = "";
													$total_qry = "select * from webmail_mail where mbox='$mbox' and badmin=1";
													if($searchstring) $total_qry.=" and $search like '%$searchstring%'";
													$MySQL->query($total_qry);
													$numrows=$MySQL->is_affected();					//총 레코드수..
													$LIMIT		=10;								//페이지당 글 수
													$PAGEBLOCK	=10;								//블럭당 페이지 수
													if($pagecnt==""){$pagecnt=0;}						//페이지 번호 
													if(!$offset){$offset=$pagecnt*$LIMIT*$PAGEBLOCK;} //각 페이지의 시작 글  
													if(!$letter_no){$letter_no=$numrows;}				//글번호
													$bbs_qry = $total_qry." order by idx desc limit $offset,$LIMIT";
													$bbs_result=$MySQL->query($bbs_qry);
													$s_letter=$letter_no;								//페이지별 시작 글번호
													while($bbs_row=mysql_fetch_array($bbs_result))
													{
														$m_subject = htmlspecialchars($bbs_row[m_subject]);
														if(!$m_subject)
														{
															$m_subject = "(제목없음)";
														}
														if(!$bbs_row[bRead])
														{
															$m_subject = "<b>".$m_subject."</b>";
														}
														$m_from_arr = explode("<",$bbs_row[m_from]);
														$m_from = str_replace(" ","",$m_from_arr[0]);
														$m_from = str_replace("\"","",$m_from);
														if(!$m_from)
														{
															$m_from = str_replace(">","",str_replace("<","",$bbs_row[m_from]));
														}
														if($bbs_row[m_size] > 1024*1024)
														{
															$m_size = sprintf("%10.1f MB",$bbs_row[m_size]/1024/1024);
														}
														else
														{
															$m_size = sprintf("%10.1f KB",$bbs_row[m_size]/1024);
														}
														$w_to = EmailPickUp($bbs_row[m_from]);
														?>
													<tr>
														<td height="25"> <div align="center"> <input type="checkbox" name="chekidx" value="<?=$bbs_row[idx]?>"></div></td>
														<td height="25"> <div align="center"><?
														if($bbs_row[m_attach])
														{
															?><img src="image/webmail/add.gif" width="16" height="18" align="absmiddle"><?
														}
														?></div></td>
														<td height="25"> <div align="center"><a href="admmail_write.php?w_to=<?=$w_to?>"><?=$m_from?></a></div></td>
														<td height="25"> <div align="left">&nbsp;&nbsp;<a href="admmail_view.php?mbox=<?=$mbox?>&idx=<?=$bbs_row[idx]?>"><?=StringCut($m_subject,50)?></a></div></td>
														<td height="25"> <div align="center"><?=str_replace("-","/",$bbs_row[m_writeday])?></div></td>
														<td height="25"> <div align="right"><?=$m_size?>&nbsp;&nbsp;&nbsp;</div></td>
													</tr>
													<tr>
														<td colspan="6" height="1" background="image/webmail/bg2.gif"></td>
													</tr><?
														$letter_no--;
													}
													include "../lib/class.php";
													$Obj=new CList("admmail_list.php",$pagecnt,$offset,$numrows,$PAGEBLOCK,$LIMIT,$search,$searchstring,"mbox=$mbox");
													$pre_img = "<img src='image/webmail/prev_btn.gif' border='0' align='absmiddle'>";
													$next_img = "<img src='image/webmail/next_btn.gif' border='0' align='absmiddle'>";
													?>
												</table></form>
											</td>
										</tr>
										<tr>
											<td height="30" bgcolor="D6EFE7">
												<form name="mailSForm" method="get" action="admmail_list.php" onsubmit="return mailSearch();">
												<input type="hidden" name="mbox" value="<?=$mbox?>">
												<table width="100%" border="0" cellspacing="0" cellpadding="0">
													<tr>
														<td width="85"> <div align="center"><select name="search"><option value="m_subject" selected>메일제목</option><option value="m_from" >보낸이</option></select></div></td>
														<td width="85"> <input type="text" name="searchstring" size="20" class="box"></td>
														<td width="45"><div align="center"><input type="image" src="image/webmail/search_btn.gif" width="35" height="17" border="0" align='absmiddle'></div></td>
														<td>&nbsp;</td>
														<td width="220"><div align="center"><?$Obj->putList(true,$pre_img,$next_img);//이전다음 프린트?></div></td>
													</tr>
												</table></form>
											</td>
										</tr>
									</table>
								</td>
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