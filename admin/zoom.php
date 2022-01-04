<?
include "head.php";
if(!$title) $title="확대 이미지";
?>
<HTML>
<HEAD>
<TITLE> <?=$img?> <?=$title?> </TITLE>
</HEAD>
<SCRIPT LANGUAGE="JavaScript">
<!--
function clear()
{
	window.close();
}
//-->
</SCRIPT>
<body bgcolor="E6E6E6" text="#666666" leftmargin="0" topmargin="0">
	<a href="javascript:clear();"><img src="<?=$img?>" border="0"></a>
</BODY>
</HTML>