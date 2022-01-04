<?
include "head.php";
?>
<script language="javascript">
<!--
function choice(f)
{
	<?if(empty($po)){?>//회원정보
	var opform =opener.document.admForm;
	opform.comAdr.value = f.add.value;
	opform.comZip1.value = f.zip1.value;
	opform.comZip2.value = f.zip2.value;
	<?}?>
	window.close();
}
function sendit()
{
	if(document.frmzipsearch.zipcode.value=="")
	{
		alert("동명을 입력하세요");
		document.frmzipsearch.zipcode.focus();
	}
	else document.frmzipsearch.submit();
}
function reSize()
{
	<?if(!empty($zipcode)){?>
	window.resizeTo(480,400);
	<?}?>
}
//-->
</script>
<body bgcolor="#FFFFFF" text="#000000" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onload="document.frmzipsearch.zipcode.focus();reSize();">
<table width="450" border="0" cellspacing="0" cellpadding="0" align="center">
	<tr>
		<td height="73" width="450"><img src="../image/member/zipcode_search_top.gif"></td>
	</tr>
	<tr>
		<td  width="450" valign="top">
			<table width="450" border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td valign="top"><br>
						<table width="98%" border="0" cellspacing="0" cellpadding="0" align="center">
							<tr>
								<td colspan="2" align="center">현재 거주하고 계시는 동명을 입력하세요.<br>(예, 서울시 강남구 역삼동은 역삼동 만 입력)<br><br></td>
							</tr>
							<form method="post" action="search_post.php" name="frmzipsearch">
							<input type="hidden" name="cnt" value="<?=$cnt?>">
							<input type="hidden" name="po" value="<?=$po?>">
							<tr>
								<td width="250" align="right"> <input class="box" type="text" name="zipcode" size="25"></td>
								<td width="200" align="center"><a href="javascript:sendit();"><img src="../image/icon/search_2.gif" width="54" height="19" border="0"></a> </td>
							</tr>
							</form><!-- post -->
							<tr>
								<td colspan="2" height="10"></td>
							</tr><?
							if($zipcode)
							{
								$result=$MySQL->query("select * from postzip where dong like '%$zipcode%'");
								?>
							<tr>
								<td colspan="2" align="center">
									<table width="98%" border="0" cellspacing="1" cellpadding="0" bgcolor='C1C1C1'>
										<tr>
											<td width="20%" align="center" height="20" bgcolor="#E3E3E3">우편번호</td>
											<td width="80%" align="center" height="20" bgcolor="#E3E3E3">주 소</td>
										</tr>
										<tr>
											<td colspan="2" height="5" bgcolor='ffffff'>&nbsp;</td>
										</tr><?
										$i=1;
										while($row=mysql_fetch_array($result))
										{
											$string=$row[zip];
											$szip1=substr($string,0,3);
											$szip2=substr($string,4,3);
											?>
										<form name="form<?=$i?>">
										<tr bgcolor="#F6F6F6"  valign="bottom" style="cursor:hand;" onMouseOver="this.style.backgroundColor='#E3E3E3'" onMouseOut="this.style.backgroundColor=''" onclick="javascript:choice(document.form<?=$i?>);" >
											<td width="20%" align="center" height="20"><?=$row[zip]?></td>
											<td width="80%" height="20">&nbsp;&nbsp;<?=$row[city]?> <?=$row[goo]?> <?=$row[dong]?>&nbsp;&nbsp;<?=$row[etc]?><input type="hidden" name="zip1" value="<?=$szip1?>"><input type="hidden" name="zip2" 	value="<?=$szip2?>"><input type="hidden" name="city" value="<?=$row[city]?>"><input type="hidden" name="add" value="<?=$row[city]?> <?=$row[goo]?> <?=$row[dong]?> <?=$row[etc]?>"></td>
										</tr>
										</form><?
											$i++;
										}
										?>
									</table>
								</td>
							</tr>
							<tr>
								<td colspan="2">&nbsp;</td>
							</tr><?
							}
							?>
						</table>
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td height="1" width="307"></td>
	</tr>
</table>
</body>
</html>