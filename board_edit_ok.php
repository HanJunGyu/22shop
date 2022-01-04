<?
include "./lib/config.php";
include "./lib/function.php";
/*------------------------게시판 글 수정,삭제 ---------------------------------*/
$dataArr=Decode64($data);
$view_row = $MySQL->fetch_array("select *from bbs_data where idx=$dataArr[idx]"); //게시판 정보
$bbs_admin_row = $MySQL->fetch_array("select *from bbs_list where idx='$boardIndex'"); //게시판 정보

if(!empty($up_file_name))
{
	if(!empty($view_row[up_file])) @unlink("./upload/bbs/$view_row[up_file]");
	if(file_exists("./upload/bbs/$up_file_name")) $up_file_name =substr(time(),5,5)."_".$up_file_name;
	@copy($up_file, "./upload/bbs/$up_file_name"); //파일복사
	unlink($up_file);
	$qry = "update bbs_data set up_file = '$up_file_name' where idx=$dataArr[idx]";
	$MySQL->query($qry);
}
if(!empty($img1_name))
{
	if(file_exists("./upload/bbs/$img1_name")) $img1_name =substr(time(),5,5)."_".$img1_name;
	@copy($img1, "./upload/bbs/$img1_name"); //파일복사
	@unlink("./upload/bbs/$view_row[img1]");
	unlink($img1);
	$qry = "update bbs_data set img1 = '$img1_name' where idx=$dataArr[idx]";
	$MySQL->query($qry);
}
if(!empty($img2_name))
{
	if(file_exists("./upload/bbs/$img2_name")) $img2_name =substr(time(),5,5)."_".$img2_name;
	@copy($img2, "./upload/bbs/$img2_name"); //파일복사
	@unlink("./upload/bbs/$view_row[img2]");
	unlink($img2);
	$qry = "update bbs_data set img2 = '$img2_name' where idx=$dataArr[idx]";
	$MySQL->query($qry);
}
if($bHtml==1) $content = $TextContent;
elseif($bHtml==2) $content = $HtmlContent;
else $content = $content;

$qry = "update bbs_data set ";
$qry.= "name	= '$name',";			//작성자
$qry.= "email	= '$email',";			//이메일
$qry.= "content = '$content',";			//글내용
$qry.= "bHtml   = $bHtml,";			//글내용
$qry.= "bLock	= '$bLock',";
$qry.= "title	= '$title',";			//글제목
$qry.= "pwd		= '$pwd'";				//비밀번호
$qry.= " where idx=$dataArr[idx]";
if($MySQL->query($qry))
{
	OnlyMsgView("수정완료 하였습니다.");
	ReFresh("board_view.php?boardIndex=$boardIndex&data=$data");
}
else
{
	echo "$qry";
}
?>