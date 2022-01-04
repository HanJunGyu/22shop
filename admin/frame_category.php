<?
include "head.php";
if ($write_code)
{
	$code = $write_code;
	$cate_row = $MySQL->fetch_array("SELECT code,name from category WHERE code='$code' limit 1"); // 선택한 code의 카테정보	 
	$parentcode=$code;
}
?>
<html>
<head>
<SCRIPT LANGUAGE="JavaScript">
<!--
function goods_write()
{
	if (!f.code.value)
	{
		alert("카테고리를 선택해 주세요.");
	}
	else
	{
		parent.location.href="goods_write.php?code="+f.code.value;
	}
}
function goods_position(part)
{
	if (part!="recommend" && part!="best" && part!="new")
	{
		alert("베스트(대), 베스트, 신규 위치를 먼저 선택해주세요.");
	}
	else if (!f.code.value)
	{
		alert("카테고리를 선택해 주세요.");
	}
	else
	{
		parent.document.positionForm.category.value = f.code.value;
		parent.document.positionForm.submit();
	}
}
//-->
</SCRIPT>
</head>
<body bgcolor="#F5F5F5">
<form name='f' method='post'>
<select style='background-color:#FAD5F6' name="code"><option value="">▷카테고리</option><?
$result = $MySQL->query("SELECT code,name from category $par_cate_search order by position asc");
while ($cate_row = mysql_fetch_array($result))
{
	echo "<option value='$cate_row[code]'>$cate_row[name]</option>";
}
echo "</select>";
if ($type=="goods_position")
{
	?>&nbsp;<input type="button" value="확 인" class="button" onclick="goods_position('<?=$part?>')" onfocus="this.blur();"><?
}
else
{
	?>&nbsp;<img src="../admin/image/goods_write.gif" align="absmiddle" onclick="goods_write()" style="cursor:pointer;" onfocus="this.blur();"><?
}
?>
</body>
</html>