<?
include "head.php";
$cate_row=$MySQL->fetch_array("select *from category where code='$parentcode'");  //현재 카테고리 정보
if (__DEMOPAGE && $del)
{
	MsgViewHref("데모페이지는 삭제권한이 제한되었습니다.","category_edit.php?parentcode=$parentcode");
	exit;
}
if ($del) // 이미지삭제
{
	$cate_row=$MySQL->fetch_array("select *from category where idx=$idx");  //현재 카테고리 정보
	@unlink("../upload/category/$cate_row[$img]");
	$MySQL->query("UPDATE category SET $img='' WHERE idx=$idx");
	if ($MySQL->query("UPDATE category SET $img='' WHERE idx=$idx"))
	{
		OnlyMsgView("이미지를 삭제하였습니다.");
		ReFresh("category_edit.php?parentcode=$parentcode");
		exit;
	}
	else
	{
		OnlyMsgView("이미지 삭제에 실패 하였습니다.다시 시도해주세요");
		ReFresh("category_edit.php?parentcode=$parentcode");
		exit;
	}
}
if(!empty($img1_name))
{
	$img1_info=@getimagesize($img1);		//이미지1 정보
	if(($img1_info[2]!=1) && ($img1_info[2]!=2))
	{
		MsgView("이미지1 형식을 gif , jpg 로 입력해 주세요", -1);
		exit;
	}
	if(!empty($cate_row[img1]))
	{
		@unlink("../upload/category/$cate_row[img1]");
	}
	$img1_name ="a".substr(time(),5,5)."_".$img1_name;
	@copy($img1, "../upload/category/$img1_name"); //파일복사
	unlink($img1);
	$MySQL->query("update category set img1= '$img1_name' where code='$parentcode'");
}
if(!empty($img2_name))
{
	$img2_info=@getimagesize($img2);		//이미지2 정보
	if(($img2_info[2]!=1) && ($img2_info[2]!=2))
	{
		MsgView("이미지2 형식을 gif , jpg 로 입력해 주세요", -1);
		exit;
	}
	if(!empty($cate_row[img2]))
	{
		@unlink("../upload/category/$cate_row[img2]");
	}
	$img2_name ="b".substr(time(),5,5)."_".$img2_name;	
	@copy($img2, "../upload/category/$img2_name"); //파일복사
	unlink($img2);
	$MySQL->query("update category set img2= '$img2_name' where code='$parentcode'");
}
if(!empty($img3_name))
{
	$img3_info=@getimagesize($img3);		//이미지3 정보
	if(($img3_info[2]!=1) && ($img3_info[2]!=2))
	{
		MsgView("이미지3 형식을 gif , jpg 로 입력해 주세요", -1);
		exit;
	}
	if(!empty($cate_row[img3]))
	{
		@unlink("../upload/category/$cate_row[img3]");
	}
	$img3_name ="c".substr(time(),5,5)."_".$img3_name;
	@copy($img3, "../upload/category/$img3_name"); //파일복사
	unlink($img3);
	$MySQL->query("update category set img3= '$img3_name' where code='$parentcode'");
}
if(!empty($img4_name))
{
	$img4_info=@getimagesize($img4);		//이미지3 정보
	if(($img4_info[2]!=1) && ($img4_info[2]!=2))
	{
		MsgView("이미지4 형식을 gif , jpg 로 입력해 주세요", -1);
		exit;
	}
	if(!empty($cate_row[img4]))
	{
		@unlink("../upload/category/$cate_row[img4]");
	}
	$img4_name ="d".substr(time(),5,5)."_".$img4_name;	
	@copy($img4, "../upload/category/$img4_name"); //파일복사
	unlink($img4);
	$MySQL->query("update category set img4= '$img4_name' where code='$parentcode'");
}
$good_code = strtoupper($good_code);
$qry = "update category set ";
$qry.= "name = '$name', ";
$qry.= "bHide = '$bHide', ";
$qry.= "editday = now()";
$qry.= " where code='$parentcode'";
if($MySQL->query($qry))
{
	OnlyMsgView("수정완료 하였습니다.");
	ReFresh("category_edit.php?parentcode=$parentcode");
}
else
{
	echo "$qry";
}
?>