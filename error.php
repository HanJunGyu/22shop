<?
include "head.php";
?>
<SCRIPT LANGUAGE="JavaScript">
<!--
function winResize()
{
	window.resizeTo(430,270);
}
window.onload=winResize
//-->
</SCRIPT>
<table width="400" border="0" cellspacing="0" cellpadding="0" align="center">
	<tr>
		<td>
			<table width="400" border="0" cellspacing="0" cellpadding="0" background="image/webmail/error.gif" height="166" align="center">
				<tr>
					<td width="150">&nbsp;</td>
					<td><?=$err?></td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td><div align="center"><a href="javascript:window.close();"><img src="image/webmail/close.gif" width="58" height="23" border="0"></a></div></td>
	</tr>
</table>
</body>
</html>