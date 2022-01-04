<?
include "head.php";
?>
<SCRIPT LANGUAGE="JavaScript">
<!--
function thisSelect(email)
{
	var obj = opener.<?=$obj?>;
	if(obj.value=="")
	{
		obj.value = email;
	}
	else
	{
		objArr = obj.value.split(";");
		objArr[objArr.length] = email;
		obj.value = objArr.join(";");
	}
	window.close();
}
//-->
</SCRIPT>
<body bgcolor="#FFFFFF" text="#000000" topmargin='0' leftmargin='0'>
<table width="500" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td><img src="../image/webmail/address_top2.gif" width="500" height="60"></td>
	</tr>
	<tr>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td height="100">
			<table width="480" border="0" cellspacing="0" cellpadding="0" align="center">
				<tr>
					<td height="35"><div align="center">*원하시는 메일주소를 클릭하십시오.</div></td>
				</tr>
				<tr>
					<td bgcolor="7DBA0C" height="35"> <div align="center"><font color="#FFFFFF">|</font> <?
					if($han=="")
					{
						?><a href="admmail_address_select.php?obj=<?=$obj?>"><FONT  COLOR="#000000"><B>전체</B></FONT></a><?
					}
					else
					{
						?><a href="admmail_address_select.php?obj=<?=$obj?>"><FONT  COLOR="#FFFFFF">전체</FONT></a><?
					}
					?><font color="#FFFFFF">|</font><?
					for($i=0;$i<count($HAN_JA_ARR);$i++)
					{
						if($han==$i && $han!="")
						{
							?><a href="admmail_address_select.php?han=<?=$i?>&obj=<?=$obj?>"><B><FONT COLOR="#000000" size="3"><?=$HAN_JA_ARR[$i]?></FONT></B></a><FONT COLOR="ffffff">|</FONT><?
						}
						else
						{
							?><a href="admmail_address_select.php?han=<?=$i?>&obj=<?=$obj?>"><FONT COLOR="ffffff"><?=$HAN_JA_ARR[$i]?></FONT></a><FONT COLOR="ffffff">|</FONT><?
						}
					}
					?></div></td>
				</tr>
				<tr>
					<td>
						<table width="100%" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td colspan="3" height="1" bgcolor="cdcdcd"></td>
							</tr>
							<tr>
								<td height="30" width="100" bgcolor="f4f4f4"> <div align="center">이름 </div></td>
								<td height="30" bgcolor="f4f4f4"> <div align="center">이메일</div></td>
								<td height="30" width="150" bgcolor="f4f4f4"> <div align="center">연락처</div></td>
							</tr>
							<tr>
								<td colspan="3" height="1" bgcolor="cdcdcd"></td>
							</tr>
							<tr>
								<td colspan="3" height="2" bgcolor="f4f4f4"></td>
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
							$LIMIT		= 8;
							$PAGEBLOCK	= 10;								//블럭당 페이지 수
							if($pagecnt==""){$pagecnt=0;}						//페이지 번호 
							if(!$offset){$offset=$pagecnt*$LIMIT*$PAGEBLOCK;} //각 페이지의 시작 글  
							if(!$letter_no){$letter_no=$numrows;}				//글번호
							if($searchstring)
							{
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
							<tr valign="middle" bgcolor="ffffff" style='cursor:pointer;' onMouseOver="this.style.backgroundColor='#FAFAFA'" onMouseOut="this.style.backgroundColor=''" onclick="javascript:thisSelect('<?=$bbs_row[email]?>');">
								<td height="20"> <div align="center"><?=$bbs_row[name]?></div></td>
								<td height="20"> <div align="center"><?=$bbs_row[email]?></div></td>
								<td height="20"> <div align="center"><?=$bbs_row[tel]?></div></td>
							</tr>
							<tr>
								<td colspan="3" height="1" background="../image/webmail/bg2.gif"></td>
							</tr><?
								$letter_no--;
							}
							include "../lib/class.php";
							$Obj=new CList("admmail_address_select.php",$pagecnt,$offset,$numrows,$PAGEBLOCK,$LIMIT,$search,$searchstring,"obj=$obj&han=$han");
							$pre_img = "<img src='../image/webmail/prev_btn.gif' border='0'>";
							$next_img = "<img src='../image/webmail/next_btn.gif' border='0'>";
							?>
						</table>
					</td>
				</tr>
				<tr>
					<td height="35">
						<table width="260" border="0" cellspacing="0" cellpadding="0" align="center">
							<tr>
								<td align="center"><?$Obj->putList(true,$pre_img,$next_img);//이전다음 프린트?></td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td bgcolor="7DBA0C" height="40"> <div align="center"><a href="javascript:window.close();"><img src="../image/webmail/close.gif" width="58" height="23" border="0"></a>  </div></td>
	</tr>
</table>
</body>
</html>