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
<!--
function choice(f)
{
	<?if(empty($po)){?>//회원정보
	var opform =opener.document.joinForm;
	opform.address1.value = f.add.value;
	opform.zip1.value = f.zip1.value;
	opform.zip2.value=f.zip2.value;
	opform.city.value=f.city.value;
	opform.address2.focus();
	<?}else if($po==1){?>//구매자 정보
	var opform =opener.document.orderForm;
	opform.adr1.value = f.add.value;
	opform.zip1.value = f.zip1.value;
	opform.zip2.value=f.zip2.value;
	opform.city.value=f.city.value;
	opform.adr2.value="";
	opform.adr2.focus();
	<?}else if($po=="webmail"){?>//구매자 정보
	var opform =opener.document.adrWForm;
	opform.adr1.value = f.add.value;
	opform.zip1.value = f.zip1.value;
	opform.zip2.value=f.zip2.value;
	opform.adr2.value="";
	opform.adr2.focus();
	<?}else{?>			//배송지정보
	var opform =opener.document.orderForm;
	opform.radr1.value = f.add.value;
	opform.rzip1.value = f.zip1.value;
	opform.rzip2.value=f.zip2.value;
	opform.radr2.value="";
	opform.radr2.focus();
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
//-->
</script>
</head>
<body bgcolor="#FFFFFF" text="#464646" leftmargin="10" topmargin="10" marginwidth="10" marginheight="10" onload="document.frmzipsearch.zipcode.focus();">
<table width="450" border='0' cellpadding='0' cellspacing='0'>
	<tr>
		<td width='4'><img src='image/sub/table_tleft.gif'></td>
		<td width='442' background='image/sub/table_tbg.gif'></td>
		<td width='4'><img src='image/sub/table_tright.gif'></td>
	</tr>
	<tr>
		<td background='image/sub/searchpost_bg.gif' colspan='3' align='center'>
			<table width="430" border="0" cellspacing="0" cellpadding="0" align='center'>
				<tr>
					<td align='center'><img src="image/member/zipcode_search_top.gif"></td>
				</tr>
				<tr>
					<td  width="450" valign="top">
						<table width="450" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td valign="top"><br>
									<form method="post" action="search_post.php" name="frmzipsearch">
									<input type="hidden" name="cnt" value="<?=$cnt?>">
									<input type="hidden" name="po" value="<?=$po?>">
									<table width="98%" border="0" cellspacing="0" cellpadding="0" align="center">
										<tr>
											<td colspan="2" align="center">현재 거주하고 계시는 동명을 입력하세요.<br>(예, 서울시 강남구 역삼동은 역삼동 만 입력)<br><br></td>
										</tr>
										<tr>
											<td align="right"> <input class="box_s" type="text" name="zipcode" size="25"></td>
											<td width="170" style='padding:0 0 0 5'> <a href="javascript:sendit();"><img src="image/icon/search.gif" border="0"></a></form><!-- post --></td>
										</tr>
										<tr>
											<td colspan="2" height="10"></td>
										</tr><?
										if($zipcode)
										{
											$qry = "select * from postzip where dong like '%".$zipcode."%' or etc like '%".$zipcode."%'";
											$result=$MySQL->query($qry);
											?>
										<tr>
											<td colspan="2" align="center">
												<table width="95%" border="0" cellspacing="1" cellpadding="0" bgcolor='C1C1C1'>
													<tr>
														<td width="20%" align="center" height="20" bgcolor="#E3E3E3">우편번호</td>
														<td width="80%" align="center" height="20" bgcolor="#E3E3E3">주 소</td>
													</tr>
													<tr>
														<td colspan="2" height="1" bgcolor='ffffff'></td>
													</tr><?
													$i=1;
													while($row=mysql_fetch_array($result))
													{
														$string=$row[zip];
														$szip1=substr($string,0,3);
														$szip2=substr($string,4,3);
														?>
													<form name="form<?=$i?>">
													<tr bgcolor="#F6F6F6"  valign="bottom" style="cursor:pointer;" onMouseOver="this.style.backgroundColor='#E3E3E3'" onMouseOut="this.style.backgroundColor=''" onclick="javascript:choice(document.form<?=$i?>);" >
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