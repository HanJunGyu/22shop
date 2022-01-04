<?
session_start();
include "lib/config.php";
include "lib/function.php";
if(!defined(__ADMIN_ROW))
{
	define(__ADMIN_ROW,"TRUE");
	$admin_row=$MySQL->fetch_array("select *from admin limit 0,1");
}
if(!defined(__DESIGN_ROW))
{
	define(__DESIGN_ROW,"TRUE");
	$design=$MySQL->fetch_array("select *from design limit 0,1");
}
if(!defined(__DESIGN_GOODS_ROW))
{
	define(__DESIGN_GOODS_ROW,"TRUE");
	$design_goods=$MySQL->fetch_array("select *from design_goods limit 0,1");
}
?>
<html>
<head>
<title><?=$admin_row[shopTitle]?></title>
<style>
<?=$design[css]?>
</style>
<meta http-equiv="Content-Type" content="text/html; charset=euc-kr">
<script language=javascript src="./script/admin.js"></script>
</head>
<body bgcolor="#FFFFFF" topmargin='10' leftmargin='10' text='464646' marginwidth="0" marginheight="0">
<table width="280" border='0' cellpadding='0' cellspacing='0'>
	<tr>
		<td width='4'><img src='image/sub/table_tleft.gif'></td>
		<td width='272' background='image/sub/table_tbg.gif'></td>
		<td width='4'><img src='image/sub/table_tright.gif'></td>
	</tr>
	<tr>
		<td background='image/sub/idsearch_bg.gif' colspan='3' align='center'><img src="image/index/poll_last.gif" width="270" height="45">
			<table width="260" border="0" cellspacing="0" cellpadding="0">
				<tr valign="top">
					<td valign="top">
						<table width="260" border="0" cellspacing="0" cellpadding="0" height="265" valign="top" align='center'>
							<tr>
								<td valign="top"><br>
									<table width="260" border="0" cellspacing="0" cellpadding="0" valign="top">
										<tr>
											<td colspan='3' bgcolor='e1e1e1' height='2'></td>
										</tr>
										<tr height='25' bgcolor='f4f4f4' align='center'>
											<td width="50">날짜</td>
											<td width='1' bgcolor='e1e1e1'></td>
											<td width='160'>설문조사항목</td>
										</tr>
										<tr>
											<td colspan='3' bgcolor='e1e1e1' height='1'></td>
										</tr><?
									$data=Decode64($data);
									$pagecnt=$data[pagecnt];
									$letter_no=$data[letter_no];
									$offset=$data[offset];
									$today = date("Ymd");
									$numresults=$MySQL->query("select idx from poll where sday <$today");
									$numrows=mysql_num_rows($numresults);				//총 레코드수..
									$LIMIT		=7;									//페이지당 글 수
									$PAGEBLOCK	=10;								//블럭당 페이지 수
									if($pagecnt==""){$pagecnt=0;}						//페이지 번호 
									if(!$offset){$offset=$pagecnt*$LIMIT*$PAGEBLOCK;} //각 페이지의 시작 글  
									if(!$letter_no){$letter_no=$numrows;}				//글번호
									$bbs_qry = "select * from poll where sday <$today order by sday desc limit $offset,$LIMIT";
									$bbs_result=$MySQL->query($bbs_qry);
									$s_letter=$letter_no;								//페이지별 시작 글번호
									while($poll_row=mysql_fetch_array($bbs_result))
									{
										$encode_str = "idx=".$poll_row[idx]."&pagecnt=".$pagecnt."&letter_no=".$s_letter."&offset=".$offset;
										$data=Encode64($encode_str);					//각 레코드 정보
										$pollPeriod = substr($poll_row[eday],0,4).".". substr($poll_row[eday],4,2).".". substr($poll_row[eday],6,2);
										?>
										<tr>
											<td width="50" height='25' align='center'><font color="#FF6600" class='stext'><?=$pollPeriod?></font></td>
											<td width='1' bgcolor='e1e1e1'></td>
											<td width='160' style='padding:3 3 3 3'><a href="poll_new.php?data=<?=$data?>"><font class='stext'><?=$poll_row[title]?></font></a></td>
										</tr>
										<tr>
											<td colspan='3' bgcolor='e1e1e1' height='1'></td>
										</tr><?
									}
									include "lib/class.php";
									$Obj=new CList("poll_last.php",$pagecnt,$offset,$numrows,$PAGEBLOCK,$LIMIT,"","","");
									?>
										<tr>
											<td colspan="3" height="30" align="center"><?$Obj->putList(true,"<img src='image/board/btn_prev.gif'>","<img src='image/board/btn_next.gif'>");//이전다음 프린트?></td>
										</tr>
									</table>
								</td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td align='right' style='padding:0 10 0 0'><a href='javascript:window.close(); opener.location.reload();'><img src="image/icon/close.gif" border="0"></a></td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td><img src='image/sub/table_bleft.gif'></td>
		<td background='image/sub/table_bbg.gif'></td>
		<td><img src='image/sub/table_bright.gif'></td>
	</tr>
</table>
</body>
</html>