<?
include "head.php";
function imgalldel()
{
	global $img1_name,$img2_name,$img3_name,$img4_name;
	if(is_file("../upload/category/$img1_name")) @unlink("../upload/category/$img1_name");
	if(is_file("../upload/category/$img2_name")) @unlink("../upload/category/$img2_name");
	if(is_file("../upload/category/$img3_name")) @unlink("../upload/category/$img3_name");
	if(is_file("../upload/category/$img4_name")) @unlink("../upload/category/$img4_name");
}
if (!$name || !$_POST["name"])
{
	MsgViewHref("알수없는 문제로 정보가 넘어오지 않았습니다.","category_write.php");
	exit;
}
if(!empty($img1_name))
{
	$img1_info=@getimagesize($img1);		//이미지1 정보
	if(($img1_info[2]!=1) && ($img1_info[2]!=2))
	{
		MsgView("이미지1 형식을 gif , jpg 로 입력해 주세요", -1);
		exit;
	}
	$img1_name ="a".substr(time(),5,5)."_".$img1_name;	
	@copy($img1, "../upload/category/$img1_name"); //파일복사
	unlink($img1);
}
if(!empty($img2_name))
{
	$img2_info=@getimagesize($img2);		//이미지2 정보
	if(($img2_info[2]!=1) && ($img2_info[2]!=2))
	{
		imgalldel();
		MsgView("이미지2 형식을 gif , jpg 로 입력해 주세요", -1);
		exit;
	}
	$img2_name ="b".substr(time(),5,5)."_".$img2_name;	
	@copy($img2, "../upload/category/$img2_name"); //파일복사
	unlink($img2);
}
if(!empty($img3_name))
{
	$img3_info=@getimagesize($img3);		//이미지3 정보
	if(($img3_info[2]!=1) && ($img3_info[2]!=2))
	{
		imgalldel();
		MsgView("이미지3 형식을 gif , jpg 로 입력해 주세요", -1);
		exit;
	}
	$img3_name ="c".substr(time(),5,5)."_".$img3_name;	
	@copy($img3, "../upload/category/$img3_name"); //파일복사
	unlink($img3);
}
if(!empty($img4_name))
{
	$img4_info=@getimagesize($img4);		//이미지3 정보
	if(($img4_info[2]!=1) && ($img4_info[2]!=2))
	{
		imgalldel();
		MsgView("이미지4 형식을 gif , jpg 로 입력해 주세요", -1);
		exit;
	}
	$img4_name ="d".substr(time(),5,5)."_".$img4_name;	
	@copy($img4, "../upload/category/$img4_name"); //파일복사
	unlink($img4);
}
$total_category_row = $MySQL->fetch_array("select max(position) from category"); //현재등록된 모든 카테고리 수
$position = $total_category_row[0] +1;
$qry = "insert into category(code,name,img1,img2,img3,img4,position)values(";
$qry.= "'$code',";			//카테고리 코드
$qry.= "'$name',";			//카테고리명
$qry.= "'$img1_name',";		//이미지1
$qry.= "'$img2_name',";		//이미지2
$qry.= "'$img3_name',";		//이미지3
$qry.= "'$img4_name',";		//이미지4
$qry.= "$position";			//카테고리 일련순위번호	
$qry.= ")";

if($MySQL->query($qry))
{
	OnlyMsgView("등록완료 하였습니다.");
	ReFresh("category_write.php");
}
else
{
	imgalldel();
	echo "$qry";
}
?>