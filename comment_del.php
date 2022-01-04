<?
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
if(!defined(__DESIGN_GOODS_ROW))
{
	define(__DESIGN_GOODS_ROW,"TRUE");
	$design_goods=$MySQL->fetch_array("select *from design_goods limit 0,1");
}
$__SITE_ALIGN = $design[mainAlign];			//사이트 정열방식 ex)left, center
$result = $MySQL->query("SELECT *from comment where idx=$idx");
$row = mysql_fetch_array($result);
if ($com_del)
{
	$MySQL->query("SELECT *from comment where idx=$idx and re_pwd='$re_pwd' limit 1");
	if ($MySQL->is_affected())
	{
		if ($MySQL->query("DELETE from comment where idx=$idx"))
		{
			echo "<script>alert('꼬릿말이 삭제되었습니다') 
			opener.location.href='board_view.php?data=$data&boardIndex=$boardIndex';
			self.close();</script>";
		}
	}
	else
	{
		MsgView("비밀번호가 일치하지 않습니다.",-1);
		exit;
	}
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
<script language="javascript">
function submit2()
{
	document.form.com_del.value = 1;
	document.form.submit();
}
</script>
</head>
<body topmargin='10' leftmargin='10' text='464646'>
<table width="280" border='0' cellpadding='0' cellspacing='0'>
	<tr>
		<td width='4'><img src='image/sub/table_tleft.gif'></td>
		<td width='272' background='image/sub/table_tbg.gif'></td>
		<td width='4'><img src='image/sub/table_tright.gif'></td>
	</tr>
	<tr>
		<td background='image/sub/idsearch_bg.gif' colspan='3' align='center'>
			<table border="0" width=100% cellspacing=0 cellpadding='0' align="center">
				<tr>
					<td colspan="2" align="center" valign='top'><img src='image/work/comment.gif'></td>
				</tr>
				<tr>
					<td>
						<form name="form" method="post" action="comment_del.php" onsubmit="javascript:submit2();">
						<input type="hidden" name="com_del">
						<input type="hidden" name="idx" value="<?=$idx?>">
						<input type="hidden" name="data" value="<?=$data?>">
						<input type="hidden" name="boardIndex" value="<?=$boardIndex?>">
						<table border="0" width=90% cellspacing=0 cellpadding='0' align="center">
							<tr>
								<td align="center" valign="middle" width='70' height='40'>비밀번호</td>
								<td><input type="password" name="re_pwd" size=15 onKeyPress="javascript:if(event.keyCode==13) {submit2();}" class='box_s'>&nbsp;</td>
								<td colspan='2' align='center'><a href="javascript:submit2();"><img src='image/icon/ok.gif' border='0'></a></td>
							</tr>
							<tr>
								<td colspan='3' height='20' align='center'><font class='stext'>코멘트작성시 적어주신 비밀번호입니다.</font></td>
							</tr>
						</table>
						</form>
					</td>
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