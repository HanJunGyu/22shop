<?
include "head.php";
$result = $MySQL->query("SELECT *from good_board_comment where idx=$idx");
$row = mysql_fetch_array($result);
$qry = "DELETE from good_board_comment where idx=$idx";
if ($MySQL->query($qry))
{
	echo "<script>alert('답글이 삭제되었습니다')
	opener.location.reload();
	self.close();</script>";
	exit;
}?>