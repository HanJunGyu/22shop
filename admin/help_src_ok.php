<?
include "head.php";
if ($edit)
{
	$qry="UPDATE userSrcEdit SET title='$title', filename='".trim($filename)."', content='$content', notice='$notice' WHERE idx=$idx";
	if($MySQL->query($qry)) ReFresh("help_src.php");
	exit;
}
else if ($del)
{
	$qry="DELETE from userSrcEdit WHERE idx=$idx";
	if($MySQL->query($qry)) ReFresh("help_src.php");
	exit;
}
else
{
	$qry = "INSERT INTO userSrcEdit SET title='$title', filename='".trim($filename)."', content='$content', notice='$notice', writeday=now()";
	if($MySQL->query($qry)) ReFresh("help_src.php");
	exit;
}
?>