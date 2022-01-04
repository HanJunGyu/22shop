<?
include "lib/config.php";
include "lib/function.php";
$MySQL->query("update notice set readNum=readNum +1 where idx=$idx");  //조회수 증가
$notice_row = $MySQL->fetch_array("select *from notice where idx=$idx");
$content = $notice_row[content];
$content	= str_replace("\n","<br>", $content); //글내용
$COOKIE_NAME="NOTICE_COOKIE_".$idx;
if($notice_row[part]=="notice")	 $noticeTitle = "공지사항";
else				     $noticeTitle = "이벤트";
if(!defined(__DESIGN_ROW))
{
	define(__DESIGN_ROW,"TRUE");
	$design=$MySQL->fetch_array("select *from design limit 0,1");
}
?>
<html>
<head>
<title>::::: <?=$noticeTitle?> :::::</title>
<style>
<?=$design[css]?>
</style>
<meta http-equiv="Content-Type" content="text/html; charset=euc-kr">
<script language=javascript src="./script/admin.js"></script>
</head>
<script language="JavaScript">
function closeWin()
{
	if ( document.forms[0].recruit.checked )
	{
		setCookie( "<?=$COOKIE_NAME?>", "no" ,1 );//쿠기 저장 기간은 1일로 한다.
	}
	window.close();
}
</script>
<body bgcolor="#ffffff" text="#999999" topmargin="0" leftmargin="0">
<form>
<table width="500" border="0" cellspacing="" cellpadding="" height="450">
	<tr>
		<td><?
		if($notice_row[part]=="notice")
		{
			?><img src="image/index/notice_title.gif" width="500" height="70"><?
		}
		else
		{
			?><img src="image/index/event_title.gif" width="500" height="70"><?
		}
		?></td>
	</tr>
	<tr>
		<td align="center">
			<table width="480" border="0" cellspacing="0" cellpadding="0" align="center" >
				<tr>
					<td height="25">
						<table width="450" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td width="379">&nbsp;&nbsp;<font color="#009BD4"><?=str_replace("-","/",substr($notice_row[writeday],0,10))?></font></td>
								<td width="97" align="right"><font color="#009BD4">조회수 : <?=$notice_row[readNum]?></font></td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td height="30"  background="image/board/notice_bg.gif"> <div align="LEFT">&nbsp;&nbsp;&nbsp; <B><font color="#233974">&gt;&gt;<?=$notice_row[title]?></font></B></div></td>
				</tr>
				<tr>
					<td>
						<table width="480" border="0" cellspacing="1" cellpadding="1" bgcolor="#E7E7E7">
							<tr>
								<td height="300" valign="top" bgcolor="fafafa" align="center" colspan="3">
									<table width="100%" border="0" cellspacing="15" cellpadding="0" align="center">
										<tr>
											<td><font color="00469C"><?=$content?></font></td>
										</tr>
									</table>
								</td>
							</tr>
						</table>
					</td>
				</tr>
			</table><br>
			<table width="480" border="0" cellspacing="0" cellpadding="0" bgcolor="#E7E7E7"><?
			if($bcook=="no")
			{
				?>
				<tr>
					<td height="25" bgcolor="f4f4f4" width="100%">
						<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
							<tr>
								<td width="0"><div align="center"><input type="checkbox" name="recruit"><img src="image/board/chang.gif"></div></td>
								<td><div align="right"><a href="javascript:window.close();"><img src="image/board/close2.gif" border="0"></a>&nbsp;&nbsp;&nbsp;</div></td>
							</tr>
						</table>
					</td>
				</tr><?
			}
			else
			{
				?>
				<tr>
					<td height="25" bgcolor="f4f4f4" width="100%">
						<table width="100%" border="0" cellspacing="0" cellpadding="0" align="right">
							<tr>
								<td width="0" bgcolor="f4f4f4"><div align="right" valign="middle"><input type="checkbox" name="recruit"><img src="image/board/cang.gif"></div></td>
								<td><div align="center"><b><a href="javascript:closeWin();"><img src="image/board/close2.gif" border="0"></a></div></td>
							</tr>
						</table>
					</td>
				</tr><?
			}
			?>
			</table>
		</td>
	</tr>
</table>
</form>
</body>
</html>