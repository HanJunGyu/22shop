<?
if(!defined(__ADMIN_ROW))
{
	define(__ADMIN_ROW,"TRUE");
	$admin_row=$MySQL->fetch_array("select * from admin limit 0,1");
}
if($form_name == "mWForm" || $form_name == "goodsForm" || $form_name == "mainForm" || $form_name == "pageForm" || $form_name == "adm_etcForm")
{
	$table_size = "100%";
}
else
{
	$table_size = 600;
}
if (empty($form_content)) $form_content="content";
if (empty($cdiv)) $cdiv="cdiv";
?>
<table width="<?=$table_size?>" border="0" cellspacing="0" cellpadding="0" align='center'>
	<tr>
		<td valign='top' align='center' width="<?=$table_size?>"><iframe height="480" id="<?=$cdiv?>" marginheight="0" marginwidth="0" name="iframeArea1" FRAMEBORDER=0 src="<?=$dir_path?>/editor_in.php?form_name=<?=$form_name?>&dir_path=<?=$dir_path?>&form_content=<?=$form_content?>" width=100% ></iframe></td>
	</tr>
</table>