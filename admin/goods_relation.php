<?
include "head.php";
if ($update && !$part)
{
	if ($MySQL->query("UPDATE goods SET relation='$relation' where idx=$idx limit 1"))
	{
		OnlyMsgView("관련상품으로 추가되었습니다.");
	}
	else OnlyMsgView("관련상품 등록에 실패하였습니다.");
}
else if ($del && !$part)
{
	if ($MySQL->query("UPDATE goods SET relation='$relation' where idx=$idx limit 1"))
	{
		OnlyMsgView("관련상품이 삭제되었습니다.");
	}
	else OnlyMsgView("관련상품 삭제에 실패하였습니다.");
}
if ($idx)
{
	$goods_row = $MySQL->fetch_array("SELECT *from goods where idx=$idx limit 1");
	$relation_arr = explode("/",$goods_row[relation]);
}
if ($goods_row[relation]) $relation = $goods_row[relation];
else $relation_arr = explode("/",$relation);
?>
<SCRIPT LANGUAGE="JavaScript">
<!--
//엔터키 체크
function inputChek()
{
	if(event.keyCode==13) inputAtt();
}
function good_search()
{
	window.open("goods_total2.php?relation=<?=$goods_row[relation]?>","","scrollbars=yes,width=500,height=670,top=20,left=500");
}
function delete_good(idx,del_idx)
{
	var str = document.relationForm.relation.value;
	var str_arr = str.split("/");
	var temp=""; 
	for (var i=0; i<str_arr.length; i++)
	{
		if (str_arr[i] != del_idx)
		{
			if (temp=="")
			{
				temp = str_arr[i];
			}
			else
			{
				temp = temp+"/"+str_arr[i];
			}
		}
	}
	document.relationForm.relation.value = temp;
	opener.document.goodsForm.relation.value = document.relationForm.relation.value;
	document.relationForm.action="goods_relation.php?idx="+idx+"&relation="+temp+"&del=1";
	document.relationForm.submit();
}
//-->
</SCRIPT>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<form name="relationForm" method="post">
<input type="hidden" name="idx" value="<?=$goods_row[idx]?>">
<input type="hidden" name="relation" value="<?=$relation?>">
<input type="hidden" name="part" value="<?=$part?>">
<input type="hidden" name="data" value="<?=$data?>">
<script>
<!--
opener.document.goodsForm.relation.value = document.relationForm.relation.value;
//-->
</script>
<table width="100%" border="0" cellpadding="0" cellspacing="0" align="center">
	<tr>
		<td background='image/goods_relation.gif' height='50'><div align="right"><a href="javascript:self.close();"><img src="image/close_btn.gif" border=0></a>&nbsp;&nbsp;</div></td>
	</tr>
	<tr>
		<td height='5'></td>
	</tr>
	<tr>
		<td bgcolor='ffffff' valign="top">
			<table width="100%" border="0" align="center" cellpadding="3" cellspacing="0">
				<tr>
					<td height='1' bgcolor=cdcdcd colspan='4'></td>
				</tr>
				<tr>
					<td bgcolor=white height='30' colspan='4'><img src="image/goods_relation_tit.gif"></td>
				</tr>
				<tr>
					<td height='1' bgcolor=cdcdcd colspan='4'></td>
				</tr>
				<!-- 옵션 목록 시작 --><?
				if ($relation_arr[0])
				{
					for ($i=0; $i<count($relation_arr); $i++)
					{
						if (!empty($relation_arr[$i]))
						{
							$row = $MySQL->fetch_array("select *from goods where idx=$relation_arr[$i] limit 1");
							if ($row)
							{
								?>
				<tr>
					<td width="40" height="30" bgcolor="ffffff"> <div align="center"><?
								if ($row[img_onetoall])
								{
									?><img src="../upload/goods/<?=$row[img3]?>" border=0 width=40 height=30><?
								}
								else
								{
									?><img src="../upload/goods/<?=$row[img1]?>" border=0 width=40 height=30><?
								}
								?></div></td>
					<td width="200" height="30" bgcolor="fafafa"><div align="center"><?=$row[name]?></div></td>
					<td width="100" height="30" bgcolor="fafafa"> <div align="center"><?=PriceFormat($row[price]);?>원</div></td>
					<td width="50" height="30" bgcolor="fafafa"> <div align="center"><a href="javascript:delete_good('<?=$idx?>','<?=$row[idx]?>');"><img src="image/delete_btn.gif" border=0></a></div></td>
				</tr><?
							}
						}
					}
				}
				else
				{
					?>
				<tr>
					<td align=center>등록되어 있는 관련상품이 없습니다.</td>
				</tr><?
				}
				?>
				<!-- 옵션 목록 끝 -->
			</table>
		</td>
	</tr>
</table>
</form>
<table width="100%" border="0" cellpadding="0" cellspacing="0">
	<tr>
		<td height='1' bgcolor=cdcdcd></td>
	</tr>
	<tr>
		<td bgcolor=white height='30'><img src="image/good_list_tit.gif"></td>
	</tr>
	<tr>
		<td height='1' bgcolor=cdcdcd></td>
	</tr>
	<tr>
		<td><iframe name="" src="goods_total2.php?gidx=<?=$goods_row[idx]?>&part=<?=$part?>&data=<?=$data?>" width=100% height=550 frameborder=0 marginheight="0" marginwidth="0"></td>
	</tr>
</table>
</body>
</html>