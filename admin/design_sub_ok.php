<?
include "head.php";
$row = $MySQL->fetch_array("select * from sub_design");
$pre_img = "img".$part;
$pre_titimg = "titimg".$part;
if(!empty($img_name))
{
	$img_info=@getimagesize($img);		//이미지1 정보
	if(($img_info[2]!=1) && ($img_info[2]!=2))
	{
		MsgView("이미지 형식을 gif , jpg 로 입력해 주세요", -1);
		exit;
	}
	$img_name =time();
	@move_uploaded_file($img, "../upload/design/$img_name"); //파일복사
	@unlink($img);
	@unlink("../upload/design/$row[$pre_img]");
	$qry = "update sub_design set img$part	= '$img_name'";
	$MySQL->query($qry);
}
if(!empty($titimg_name))
{
	$titimg_info=@getimagesize($titimg);		//이미지1 정보
	if(($titimg_info[2]!=1) && ($titimg_info[2]!=2))
	{
		MsgView("이미지 형식을 gif , jpg 로 입력해 주세요", -1);
		exit;
	}
	$titimg_name =time() + 1;
	@move_uploaded_file($titimg, "../upload/design/$titimg_name"); //파일복사
	@unlink($titimg);
	@unlink("../upload/design/$row[$pre_titimg]");
	$qry = "update sub_design set titimg$part	= '$titimg_name'";
	$MySQL->query($qry);
}
$qry = "update sub_design set bc$part='$copyBC' , tc$part='$copyTC' ";
if($MySQL->query($qry))
{
	OnlyMsgView("등록 완료");
	ReFresh("design_sub.php");
}
else
{
	echo"Err. : $qry";
}
?>