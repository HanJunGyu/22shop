<?
session_start();
include "./lib/config.php";
include "./lib/function.php";
/*------------------------게시판 글 등록 ---------------------------------*/
$dataArr=Decode64($data);
//변수설정  :ref,re_level,re_step,content
if(!empty($data))
{
	$up_sql="update bbs_data set re_step=re_step+1 where ref=$ref and re_step > $re_step";
	$up_result=$MySQL->query($up_sql);
	$re_step++;
	$re_level++;
}
else
{
	$row=$MySQL->fetch_array("select max(ref) from bbs_data");
	$ref=$row[0]+1;
	$re_step=0;
	$re_level=0;
}
//파일첨부
if(!empty($up_file_name))
{
	if(file_exists("./upload/bbs/$up_file_name"))
	{
		//같은파일명 체크
		$up_file_name =substr(time(),5,5)."_".$up_file_name;
	}
	@copy($up_file, "./upload/bbs/$up_file_name"); //파일복사
	unlink($up_file);
}
if($bHtml==1) $content = $TextContent;
elseif($bHtml==2) $content = $HtmlContent;
else $content = $content;
$qry = "insert into bbs_data(code,name,email,content,bHtml,title,writeday,";
$qry.= "pwd,ref,re_step,re_level,userIp,up_file,userid)values(";
$qry.= "'person_ask',";			//게시판 코드
$qry.= "'$name',";			//작성자
$qry.= "'$email',";			//이메일
$qry.= "'$content',";		//글내용
$qry.= "'$bHtml',";			//글형식
$qry.= "'$title',";			//글제목
$qry.= "now(),";			//작서일
$qry.= "'$pwd',";			//비밀번호
$qry.= "$ref,";				//답변변수
$qry.= "$re_step,";			//답변변수
$qry.= "$re_level,";		//답변변수
$qry.= "'$REMOTE_ADDR',";	//아이피
$qry.= "'$up_file_name', ";	//첨부파일명
$qry.= "'$_SESSION[GOOD_SHOP_USERID]'";
$qry.= ")";
if($MySQL->query($qry))
{
	OnlyMsgView("등록완료 하였습니다.");
	ReFresh("ask_list.php");
}
else
{
	@unlink("./upload/bbs/$up_file_name");
	echo "$qry";
}
?>