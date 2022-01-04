<?
session_start();
include "./lib/config.php";
include "./lib/function.php";
if(!defined(__INCLUDE_CLASS_PHP)) include "./lib/class.php";
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
?>
<html>
<head>
<title><?=$admin_row[shopTitle]?></title>
<style>
<?=$design[css]?>
</style>
<meta http-equiv="Content-Type" content="text/html; charset=euc-kr">
<script language=javascript src="./script/admin.js"></script>
<SCRIPT LANGUAGE="JavaScript">
<!--
function write()
{
	var form = document.askForm;
	if (form.title.value =="")
	{
		alert("제목을 입력하세요");
		form.title.focus();
	}
	else if (form.content.value =="")
	{
		alert("본문을 입력하세요");
		form.content.focus();
	}
	else
	{
		form.submit();
	}
}
//-->
</SCRIPT>
</head>
<body topmargin='10' leftmargin='10' text='464646'>
<table width="580" border='0' cellpadding='0' cellspacing='0'>
	<tr>
		<td width='4'><img src='image/sub/table_tleft.gif'></td>
		<td width='572' background='image/sub/table_tbg.gif'></td>
		<td width='4'><img src='image/sub/table_tright.gif'></td>
	</tr>
	<tr>
		<td background='image/sub/good_ask_bg.gif' colspan='3' align='center'>
			<table width="100%" border='0' cellpadding='0' cellspacing='0'>
				<tr>
					<td align='center'><img src='image/work/good_ask.gif'></td>
				</tr>
			</table><br>
			<form name="askForm" method="post" action="goods_ask_ok.php">
			<input type="hidden" name="userid" value="<?=$userid?>">
			<input type="hidden" name="gidx" value="<?=$gidx?>">
			<table width="95%" border='0' cellpadding='0' cellspacing='0' align="center">
				<tr>
					<td height='1' bgcolor='e1e1e1' colspan='3'></td>
				</tr>
				<tr>
					<td height='30' width='100' style='padding:5 10 5 10' bgcolor='f7f7f7'><b>제 목</b></td>
					<td width='1' bgcolor='e1e1e1' height='1'></td>
					<td style='padding:5 10 5 10'><input type="text" class="box1" name="title" size="40"></td>
				</tr>
				<tr>
					<td height='1' bgcolor='e1e1e1' colspan='3'></td>
				</tr>
				<tr>
					<td height='30' width='100' style='padding:5 10 5 10' bgcolor='f7f7f7'><b>내 용</b></td>
					<td width='1' bgcolor='e1e1e1' height='1'></td>
					<td style='padding:5 10 5 10'><textarea name="content" class="box1" cols="70" rows="15"></textarea></td>
				</tr>
				<tr>
					<td height='1' bgcolor='e1e1e1' colspan='3'></td>
				</tr>
				<tr>
					<td align='right' height='45' colspan='3'><a href="javascript:write();"><img src="image/icon/write.gif" border='0'></a> <a href="javascript:self.close();"><img src="image/icon/close.gif" border=0></a></td>
				</tr>
			</table>
			</form>
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