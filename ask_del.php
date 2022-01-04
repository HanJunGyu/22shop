<?
session_start();
include "./lib/config.php";
include "./lib/function.php";
/*------------------------게시판 비밀번호 체크 ---------------------------------*/
$dataArr = Decode64($data);
$bbs_row = $MySQL->fetch_array("select *from bbs_data where idx=$dataArr[idx]");
if($MySQL->query("delete from bbs_data where idx=$dataArr[idx]"))
{
	if(!empty($bbs_row[up_file])) @unlink("./upload/bbs/$bbs_row[up_file]"); //파일삭제
	OnlyMsgView("삭제 완료하였습니다.");
	ReFresh("ask_list.php");
}
else
{
	echo"delete Err. ";
}
?>