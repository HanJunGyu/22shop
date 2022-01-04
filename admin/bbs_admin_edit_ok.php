<?
include "head.php";
$dataArr=Decode64($data);
$bbs_row = $MySQL->fetch_array("select *from bbs_list where idx=$dataArr[idx]");
if ($commnameimg_del=="y")
{
	@unlink("../upload/bbs/$bbs_row[commnameimg]");
	$MySQL->query("UPDATE bbs_list SET commnameimg='' where idx=$dataArr[idx]");
}
if ($nameimg_del=="y")
{
	@unlink("../upload/bbs/$bbs_row[nameimg]");
	$MySQL->query("UPDATE bbs_list SET nameimg='' where idx=$dataArr[idx]");
}
if ($img_del=="y")
{
	@unlink("../upload/bbs/$bbs_row[img]");
	$MySQL->query("UPDATE bbs_list SET img='' where idx=$dataArr[idx]");
}
if(empty($newPeriod))		$newPeriod			=1;		//게시판 새글 이미지 표시기간(일)
if(empty($bUse))			$bUse				=0;		//게시판 사용여부 ex) 0:비사용  1:사용
if(empty($intro_html)) $intro_html = 0;
if(empty($bComment)) $bComment = 0;
if(!empty($img1_name))
{
	$img1_info=@getimagesize($img1);		//이미지1 정보
	if(($img1_info[2]!=1) && ($img1_info[2]!=2))
	{
		MsgView("타이틀이미지 형식을 gif , jpg 로 입력해 주세요", -1);
		exit;
	}
	$img1_name ="title".substr(time(),5,5)."_".$img1_name;	
	@move_uploaded_file($img1, "../upload/bbs/$img1_name"); //파일복사
	@unlink($img1);
	@unlink("../upload/bbs/$bbs_row[img]");		//본이미지 삭제
	$MySQL->query("update bbs_list set img= '$img1_name' where idx=$dataArr[idx]");
}
if(!empty($nameimg_name))
{
	$nameimg_info=@getimagesize($nameimg);
	if(($nameimg_info[2]!=1) && ($nameimg_info[2]!=2))
	{
		MsgView("제목이미지 형식을 gif , jpg 로 입력해 주세요", -1);
		exit;
	}
	$nameimg_name ="name".substr(time(),5,5)."_".$nameimg_name;	
	@move_uploaded_file($nameimg, "../upload/bbs/$nameimg_name"); //파일복사
	@unlink($nameimg);
	@unlink("../upload/bbs/$bbs_row[nameimg]");		//본이미지 삭제
	$MySQL->query("update bbs_list set nameimg= '$nameimg_name' where idx=$dataArr[idx]");
}
if(!empty($commnameimg_name))
{
	$commnameimg_info=@getimagesize($commnameimg);	 
	if(($commnameimg_info[2]!=1) && ($commnameimg_info[2]!=2))
	{
		MsgView("커뮤니티 제목이미지 형식을 gif , jpg 로 입력해 주세요", -1);
		exit;
	}
	$commnameimg_name ="comname".substr(time(),5,5)."_".$commnameimg_name;	
	@move_uploaded_file($commnameimg, "../upload/bbs/$commnameimg_name"); //파일복사
	@unlink($commnameimg);
	@unlink("../upload/bbs/$bbs_row[commnameimg]");		//본이미지 삭제
	$MySQL->query("update bbs_list set commnameimg= '$commnameimg_name' where idx=$dataArr[idx]");
}
$qry = "update bbs_list set ";
$qry.= "name	  = '$name',";		//게시판명
$qry.= "rAct	  = $rAct,";		//읽기권한    ex) 10:제한없음  20:회원,관리자  30: 관리자
$qry.= "wAct	  = $wAct,";		//쓰기권한                  "
$qry.= "cAct	  = $cAct,";		//답변권한				   "
$qry.= "part	  = $part,";		//유형      ex) 10:일반게시판  20:자료실
$qry.= "newPeriod = $newPeriod,";	//새글이미지 표시기간
$qry.= "bUse	  = $bUse, ";		//사용여부
$qry.= "bComment	  = $bComment, ";
$qry.= "bCommunity	  = '$bCommunity', ";
$qry.= "intro_html	  = $intro_html, ";
$qry.= "gubun	  = '$gubun', ";
$qry.= "intro	  = '$intro' ";
$qry.= " where idx=$dataArr[idx]";
if($MySQL->query($qry))
{
	OnlyMsgView("수정완료 하였습니다.");
	ReFresh("bbs_admin_edit.php?data=$data");
}
else
{
	ErrMsg($qry);
	ReFresh("bbs_admin_edit.php?data=$data");
}
?>