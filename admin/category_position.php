<?
include "head.php";
$po_qry ="select *from category order by position asc";
$MySQL->query($po_qry);
$cate_cnt = $MySQL->is_affected();
if(empty($cate_cnt))
{
	MsgViewHref("설정할 카테고리가 존재하지 않습니다.","category_write.php");
	exit;
}
$po_result = $MySQL->query($po_qry);	//카테고리 정보
?>
<SCRIPT LANGUAGE="JavaScript">
<!--
var codeArr		= new Array();
var poArr		= new Array();
var clickCnt	= 0;		//클릭 수
<?
$po_cnt=0;		//카테고리 수량
while($po_row = mysql_fetch_array($po_result))
{
	echo "codeArr[$po_cnt] = \"$po_row[code]\";\n";
	$po_cnt++;
}
?>
//위치세팅
function positionSet(Index)
{
	var form=document.positionForm;
	if(form.po[Index].value =="")
	{
		clickCnt++;
		form.po[Index].value = clickCnt;
	}
}
//초기화
function positionReset()
{
	document.positionForm.reset();
	clickCnt = 0; //클릭 수 초기화
}
//위치등록
function positionSendit()
{
	var form=document.positionForm;
	if(clickCnt != <?=$po_cnt?>)
	{
		alert("모든 카테고리의 순위를 지정해주셔야 합니다.");
	}
	else
	{
		for(i=0;i<form.po.length;i++) poArr[i]= form.po[i].value-1;
		form.strCode.value		 = codeArr.join("-");  //코드정보
		form.strPosition.value	 = poArr.join("-");	   //위치정보
		form.submit();
	}
}
//-->
</SCRIPT>
<body bgcolor="#FFFFFF" text="#5A595A" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<? include "top_menu.php"; ?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr><?
	$__TOP_MENU = "category";     //왼쪽 소메뉴 설정 변수
	include "left_menu.php";
	?>
		<td width="85%" valign="top" height="400">
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td height='5'></td>
				</tr>
				<tr>
					<td>
						<table width="750" border="0" cellspacing="0" cellpadding="0" align='center'>
							<tr>
								<td rowspan="3" width="200"><img src="image/cate_tit.gif"></td>
								<td>&nbsp;</td>
							</tr>
							<tr>
								<td bgcolor="#E6E6E6" height='26'><div align='right'><font class='text1'>SHOP 카테고리 수정 삭제 등록 등을 하실수 있습니다.&nbsp;</div></td>
							</tr>
							<tr>
								<td>&nbsp;</td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td>
						<table width="750" border="0" cellspacing="0" cellpadding="0" align="center">
							<tr>
								<td width='1' bgcolor='dadada'></td>
							</tr>
							<tr>
								<td><img src="image/cate_posi_tit1.gif"></td>
							</tr>
							<tr>
								<td width='1' bgcolor='dadada'></td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
				</tr>
				<tr>
					<td valign="top">
						<table width="750" border="0" cellspacing="0" cellpadding="0" align="center" >
							<tr>
								<td colspan="2" height="30">&nbsp;&nbsp;&nbsp;<FONT COLOR="#993300">- 카테고리 순서대로 해당 카테고리를 클릭해 주십시오.</FONT></td>
							</tr>
							<tr>
								<td colspan="2" height="1" background="image/line_bg1.gif"></td>
							</tr>
							<form name ="positionForm" method="post" action="category_position_ok.php">
							<input type="hidden" name="strPosition">
							<input type="hidden" name="strCode">
							<input type="hidden" name="parentcode" value="<?=$parentcode?>"><?
							$cate_result	= $MySQL->query($po_qry);
							$cateCnt =0;
							while($cate_row = mysql_fetch_array($cate_result))
							{
								?>
							<tr valign="middle" onclick="javascript:positionSet('<?=$cateCnt?>');">
								<td width="150" height="30" bgcolor="#FAFAFA"> <div align="left">&nbsp;&nbsp;<img src="image/icon.gif" width="11" height="11"> <?=$cate_row[name]?></div></td>
								<td width="400" height="30" align="center">&nbsp;<input class="nonbox"  readonly type="text" name="po" size="30"></td>
							</tr>
							<tr>
								<td colspan="2" height="1" background="image/line_bg1.gif"></td>
							</tr><?
								$cateCnt ++;
							}
							?>
							</form><!-- positionForm -->
							<tr>
								<td colspan="2" height="40" bgcolor="#FAFAFA">
									<table width="300" border="0" align="center">
										<tr>
											<td><div align="center"><a href="javascript:positionSendit();"><img src="image/ok_btn.gif" width="40" height="17" border="0"></a></div></td>
											<td><div align="center"><a href="javascript:positionReset();"><img src="image/cancel_btn.gif" width="40" height="17" border="0"></a></div></td>
											<td><div align="center"><a href="javascript:history.go(-1);"><img src="image/pre_btn.gif"   border="0"></a></div></td>
										</tr>
									</table>
								</td>
							</tr>
							<tr>
								<td colspan="2" height="1" background="image/line_bg1.gif"></td>
							</tr>
						</table><br>
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>
<? include "copy.php";?>
</body>
</html>