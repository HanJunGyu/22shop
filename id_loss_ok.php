<?
include "./lib/config.php";
include "./lib/function.php";
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
/*------------------------아이디 비번 찾기---------------------------------*/
$idx = $_POST['idx'];
$MySQL->query("UPDATE member SET pwd=password('$new_pwd') WHERE idx=$idx");
$member_row = $MySQL->fetch_array("SELECT *from member WHERE idx=$idx limit 1");
$pwd = $new_pwd;
include "./email/pwd_edit.php";
echo "<script>self.close();</script>";
?>