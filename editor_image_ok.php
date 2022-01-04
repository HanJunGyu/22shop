<?
include "head.php";
$_SELF=explode("/",$_SERVER[PHP_SELF]);
$_SELF[count($_SELF)-1]="";
$_IMG_OK_FILE=implode("/", $_SELF);
$_This_folder="http://".$_SERVER[HTTP_HOST].$_IMG_OK_FILE;
if(!empty($file_name))
{
	if(file_exists("./upload/editor/$file_name"))
	{
		//같은파일명 체크
		$file_name =substr(time(),5,5)."_".$file_name;
	}
	@move_uploaded_file($file, "./upload/editor/$file_name"); //파일복사
	@unlink($file);
}
$file_name = urlencode($file_name);
$IMG_LINK = "<img src='".$_This_folder."upload/editor/".$file_name."' align='absbottom'>";
?>
<script language="javascript">
var coll = opener.iframeArea.document.selection.createRange();
coll.pasteHTML("<?=$IMG_LINK?>");
coll.pasteHTML("<BR>");
coll.select();
opener.iView.focus();
self.close();
</script>