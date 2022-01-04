<?
include "head.php";
if (empty($gongji)) $gongji=0;
$dataArr=Decode64($data);
$view_row = $MySQL->fetch_array("select *from bbs_data where idx=$dataArr[idx]"); //게시판 정보
$bbs_admin_row = $MySQL->fetch_array("select *from bbs_list where code='$code'"); //게시판 정보
//첨부파일 삭제 
if ($del_file)
{
	if (unlink("../upload/bbs/$view_row[up_file]"))
	{
		$MySQL->query("UPDATE bbs_data SET up_file='' WHERE idx=$dataArr[idx]");
		MsgViewHref("첨부파일을 삭제하였습니다.","bbs_view.php?data=$data");
	}
	else
	{
		MsgViewHref("첨부파일삭제에 실패하였습니다.","bbs_view.php?data=$data");
	}
	exit;
}

if($del)
{
	if(!empty($view_row[up_file]))
	{
		@unlink("../upload/bbs/$view_row[up_file]"); //파일삭제
	}
	if(!empty($view_row[img1]))
	{
		@unlink("../upload/bbs/$view_row[img1]");
	}
	if(!empty($view_row[img2]))
	{
		@unlink("../upload/bbs/$view_row[img2]");
	}
	$del_qry = "delete from bbs_data where idx=$dataArr[idx]";
	if($MySQL->query($del_qry))
	{
		$MySQL->query("DELETE from comment where boardidx=$dataArr[idx]");
		ReFresh("bbs_list.php?code=$code");
	}
}
else
{
	if(!empty($up_file_name))
	{
		if(!empty($view_row[up_file])) @unlink("../upload/bbs/$view_row[up_file]");
		if(file_exists("../upload/bbs/$up_file_name")) $up_file_name =substr(time(),5,5)."_".$up_file_name;
		@copy($up_file, "../upload/bbs/$up_file_name"); //파일복사
		unlink($up_file);
		$qry = "update bbs_data set up_file = '$up_file_name' where idx=$dataArr[idx]";
		$MySQL->query($qry);
	}
	if($bbs_admin_row[part]==30)
	{
		if(!empty($img1_name))
		{
			if(file_exists("../upload/bbs/$img1_name"))
			{
				$img1_name =substr(time(),5,5)."_".$img1_name;	
			}
			@copy($img1, "../upload/bbs/$img1_name"); //파일복사
			@unlink("../upload/bbs/$view_row[img1]");
			unlink($img1);
			$qry = "update bbs_data set img1 = '$img1_name' where idx=$dataArr[idx]";
			$MySQL->query($qry);
		}
		if(!empty($img2_name))
		{
			if(file_exists("../upload/bbs/$img2_name"))
			{
				$img2_name =substr(time(),5,5)."_".$img2_name;	
			}
			@copy($img2, "../upload/bbs/$img2_name"); //파일복사
			@unlink("../upload/bbs/$view_row[img2]");
			unlink($img2);
			$qry = "update bbs_data set img2 = '$img2_name' where idx=$dataArr[idx]";
			$MySQL->query($qry);
		}
	}
	if($bHtml==1) $content = $TextContent;
	elseif($bHtml==2) $content = $HtmlContent;
	else $content = $content;
	$qry = "update bbs_data set ";
	$qry.= "name	= '$name',";			//작성자
	$qry.= "email	= '$email',";			//이메일
	$qry.= "content = '$content',";			//글내용
	$qry.= "bHtml	= $bHtml,";			//글내용
	$qry.= "title	= '$title',";			//글제목
	$qry.= "pwd		= '$pwd',bLock='$bLock',";				//비밀번호
	$qry.= "gongji		= $gongji";
	if (!empty($gongji))	$qry.= ",gongji_day	= now()";
	$qry.= " where idx=$dataArr[idx]";
	if($MySQL->query($qry))
	{
		OnlyMsgView("수정완료 하였습니다.");
		ReFresh("bbs_view.php?code=$code&data=$data");
	}
}
?>