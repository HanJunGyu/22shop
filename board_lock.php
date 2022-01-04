<?
include "head.php";
$bbs_admin_row = $MySQL->fetch_array("select *from bbs_list where idx='$boardIndex'"); //게시판 정보
$dataArr=Decode64($data);
if($data)
{
	$bbs_qry="select *from bbs_data where idx=$dataArr[idx]";
	$bbs_row=$MySQL->fetch_array($bbs_qry);
}
?>
<SCRIPT LANGUAGE="JavaScript">
<!--
function confirm()
{
	var form = document.lockForm;
	if (form.lock_pwd.value == "")
	{
		alert("비밀번호를 입력해주시기 바랍니다.");
	}
	else
	{
		form.submit();
	}
}
//-->
</SCRIPT>
<? include "top.php";?>
<table width="900" border="0" cellspacing="0" cellpadding="0" bgcolor="<?=$ALL_BGCOLOR?>">
	<tr>
		<?
		$COMMUNITY_PAGE = 1;
		include "left_menu.php";
		?>
		<td  valign="top" width="720" bgcolor="#FFFFFF">
			<table width="720" height="100%" border="0" cellspacing="0" cellpadding="0">
				<tr bgcolor="#FFFFFF" valign="top">
					<td colspan="2" >
						<table width="720"   border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td width="2"  bgcolor="<?=$subdesign[bc10]?>" rowspan="2"></td>
								<td width="2"  bgcolor="<?=$subdesign[bc10]?>" rowspan="2"></td>
								<td width="220" height="30" bgcolor="<?=$subdesign[bc10]?>"><img src="./upload/design/<?=$subdesign[img10]?>" ></td>
								<td width="490" height="30" bgcolor="<?=$subdesign[bc10]?>"><div align="right"> &nbsp;<font color="<?=$subdesign[tc10]?>"> &nbsp;현재위치 : <a href="index.php"><font color="<?=$subdesign[tc10]?>">HOME</a> &gt; 게시판</font>&nbsp;</div></td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td valign="top" width="720">
						<table width="720" border="0" cellspacing="0" cellpadding="0" align="center">
							<tr>
								<td><img src="image/index/board.gif"></td>
							</tr>
						</table><br>
						<form name="lockForm" method="post" action="board_view.php">
						<input type="hidden" name="data" value="<?=$data?>">
						<input type="hidden" name="boardIndex" value="<?=$boardIndex?>">
						<table width="340" border="0" cellspacing="0" cellpadding="0" align="center">
							<tr height="30">
								<td><img src='image/board/key_t.gif'></td>
							</tr>
							<tr height="40" width='340'>
								<td background='image/board/key_bg.gif' align="center"><font color='876f17'><b>비밀번호</b></font> <input type="password" class="box_s" name="lock_pwd" size="15">&nbsp;&nbsp;<img src='image/board/btn_ok.gif' onclick="confirm();" align='absmiddle' style="cursor:pointer"></td>
							</tr>
							<tr>
								<td><img src='image/board/key_b.gif'></td>
							</tr>
						</table>
						</form>
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>
<? include "copy.php"; ?>
</div>
</body>
</html>