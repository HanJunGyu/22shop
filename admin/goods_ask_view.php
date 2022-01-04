<?
include "head.php";
if ($del)
{
	if($MySQL->query("DELETE from good_board WHERE idx=$idx"))
	{
		OnlyMsgView("삭제하였습니다.");
		echo "<script>
		opener.location.reload();
		self.close();
		</script>";
		exit;
	}
	else
	{
		OnlyMsgView("삭제에 실패하였습니다.");
		echo "<script>
		opener.location.reload();
		self.close();
		</script>";
		exit;
	}
}
else if ($comment)
{
	if ($MySQL->query("INSERT INTO good_board_comment values('',$idx,'$re_name','$re_pwd','$re_content',now())"))
	{
		OnlyMsgView("등록하였습니다.");
		echo "<script>
		opener.location.reload();
		self.close();
		</script>";
		exit;
	}
	else
	{
		OnlyMsgView("등록에 실패하였습니다.");
		echo "<script>
		opener.location.reload();
		self.close();
		</script>";
		exit;
	}
}
$goods_board_row = $MySQL->fetch_array("SELECT *from good_board WHERE idx=$idx limit 1");	
$MySQL->query("UPDATE good_board SET readnum=readnum+1 WHERE idx=$idx"); // 조회수 증가 
?>
<SCRIPT LANGUAGE="JavaScript">
<!--
function write()
{
	var form = document.comment;
	if (form.name.value =="")
	{
		alert("이름을 입력하세요");
		form.name.focus();
	}
	else if (form.re_pwd.value =="")
	{
		alert("비밀번호를 입력하세요");
		form.re_pwd.focus();
	}
	else if (form.re_content.value =="")
	{
		alert("본문을 입력하세요");
		form.re_content.focus();
	}
	else
	{
		form.submit();
	}
}
function del(idx)
{
	location.href="goods_ask_view.php?del=1&idx="+idx;
}
function comment_del(idx)
{
	window.open("goods_ask_comment_del.php?idx="+idx,"","scrollbars=no,width=200,height=150,top=50,left=50");
}
//-->
</SCRIPT>
<body topmargin='10' leftmargin='10' text='464646'>
<table width="580" border='0' cellpadding='0' cellspacing='0'>
	<tr>
		<td width='4'><img src='../image/sub/table_tleft.gif'></td>
		<td width='572' background='../image/sub/table_tbg.gif'></td>
		<td width='4'><img src='../image/sub/table_tright.gif'></td>
	</tr>
	<tr>
		<td background='../image/sub/good_ask_bg.gif' colspan='3' align='center'>
			<table width="100%" border='0' cellpadding='0' cellspacing='0'>
				<tr>
					<td align='center'><img src='../image/work/good_ask.gif'></td>
				</tr>
			</table><br>
			<table width="560" border='0' cellpadding='3' cellspacing='0' align="center">
			<input type="hidden" name="userid" value="<?=$USERID?>">
			<input type="hidden" name="gidx" value="<?=$gidx?>">
				<tr>
					<td bgcolor='e1e1e1' height='1'></td>
				</tr>
				<tr bgcolor='e3edf6'>
					<td height='30' style='padding:0 0 0 10'><b><font color='13548c'>제목 : <?=$goods_board_row[title]?></font></b></td>
				</tr>
				<tr>
					<td bgcolor='e1e1e1' height='1'></td>
				</tr>
				<tr>
					<td bgcolor='ffffff' style='padding:10 10 10 10'><?=nl2br($goods_board_row[content])?></td>
				</tr>
				<tr>
					<td bgcolor='e1e1e1' height='1'></td>
				</tr>
			</table>
			<table width="560" border=0 align="center" cellpadding='0' cellspacing='0'>
				<tr>
					<td height='25'></td>
				</tr>
			</table>
			<table width="560" border=0 align="center" cellpadding='0' cellspacing='0'>
				<tr>
					<td height='1' bgcolor='e1e1e1'></td>
				</tr>
				<tr>
					<td height='25' bgcolor="#e1e1e1" style='padding:0 0 0 10'><img src='../image/sub/icon_00.gif' align='absmiddle'> <b>답글보기</b></td>
				</tr>
				<tr>
					<td height='1' bgcolor='e1e1e1'></td>
				</tr>
				<tr>
					<td>
						<table width=100% border='0' cellpadding='2' cellspacing='0'>
							<tr align='center' bgcolor='f7f7f7' height='30'>
								<td>이름</td>
								<td width='1'><img src='../image/board/line.gif'></td>
								<td>내용</td>
								<td width='1'><img src='../image/board/line.gif'></td>
								<td>날짜</td>
								<td width='1'><img src='../image/board/line.gif'></td>
								<td>삭제</td>
							</tr>
							<tr>
								<td colspan=7 bgcolor='e1e1e1'></td>
							</tr><?
							$reply_result = $MySQL->query("SELECT *from good_board_comment WHERE boardidx=$goods_board_row[idx] order by idx desc"); 
							while ($reply_row = mysql_fetch_array($reply_result))
							{
								?>
								
							<tr>
								<td width=70><b><?=$reply_row[re_name]?></b></td>
								<td width='1'><img src='../image/board/line.gif'></td>
								<td><?=nl2br($reply_row[re_content])?></td>
								<td width='1'><img src='../image/board/line.gif'></td>
								<td width=90 align=center><?=substr($reply_row[writeday],0,16)?></td>
								<td width='1'><img src='../image/board/line.gif'></td>
								<td width=35 align=center><a href="javascript:comment_del(<?=$reply_row[idx]?>);"><img src="../image/icon/btn_delete0.gif" border=0></a></td>
							</tr>
							<tr>
								<td colspan=7 bgcolor='e1e1e1'></td>
							</tr><?
							}
							?>
						</table>
					</td>
				</tr>
			</table>
			<table width="560" border=0 align="center" cellpadding='0' cellspacing='0'>
				<tr>
					<td height='25'></td>
				</tr>
			</table>
			<table width="560" border=0 align="center" cellpadding='0' cellspacing='0'>
				<tr>
					<td height='1' bgcolor='e1e1e1'></td>
				</tr>
				<tr>
					<td height='25' bgcolor="#e1e1e1" style='padding:0 0 0 10'><img src='../image/sub/icon_00.gif' align='absmiddle'> <b>답글작성</b></td>
				</tr>
				<tr>
					<td height='1' bgcolor='e1e1e1'></td>
				</tr>
				<tr>
					<td style='padding:10 5 10 5'>
						<form name="comment" method="post" action="goods_ask_view.php?comment=1">
						<input type="hidden" name="idx" value="<?=$goods_board_row[idx]?>">
						<table width='100%' border=0 align="center" cellpadding='0' cellspacing='0'>
							<tr><?
							$name = $_SESSION["GOOD_SHOP_NAME"];
							?>
								<td colspan='2'>이름 <input type="text" class="box_s" name="re_name" size="6" value="<?=$name?>">비밀번호 <input type="password" class="box_s" name="re_pwd" size="6"></td>
							</tr>
							<tr>
								<td><textarea class="box_s" name="re_content" rows="3" cols="70"></textarea></td>
								<td width='45' valign='bottom'><a href="javascript:write();"><img src="../image/icon/write.gif" border=0 align='absmiddle'></a></td>
							</tr>
						</table>
						</form>
					</td>
				</tr>
				<tr>
					<td height='1' bgcolor='e1e1e1'></td>
				</tr>
				<tr>
					<td align=right height='25'><?
					if ($USERID == $goods_board_row[userid])
					{
						?><a href="javascript:del(<?=$goods_board_row[idx]?>);"><img src="../image/icon/delete.gif" border=0></a><?
					}
					?><a href="javascript:self.close();"><img src="../image/icon/close.gif" border=0></a></td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td><img src='../image/sub/table_bleft.gif'></td>
		<td background='../image/sub/table_bbg.gif'></td>
		<td><img src='../image/sub/table_bright.gif'></td>
	</tr>
</table>
</body>
</html>