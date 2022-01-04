<?
include "head.php";
$qry = "DELETE from comment where idx=$idx";
if ($MySQL->query($qry))
{
	echo "<script>alert('꼬릿말이 삭제되었습니다') 
	location.href='bbs_view.php?data=$data&code=$code';
	</script>";
}
?>