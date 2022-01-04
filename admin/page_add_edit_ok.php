<?
include "head.php";
$page_qry ="select *from page where idx=$pageIdx";
$page_result = $MySQL->query($page_qry);
$page_row = mysql_fetch_array($page_result);
if ($imgdel)
{
	@unlink("../upload/page/$page_row[img]");
	$MySQL->query("UPDATE page SET img='' WHERE idx =$pageIdx");
	Refresh("page_add_edit.php?pageIdx=$pageIdx");
}
if($del)
{
	if($page_row[img]) @unlink("../upload/page/$page_row[img]");
	$qry = "select *from up_file where code='$page_row[imgcode]'";
	$result = $MySQL->query($qry);
	while($row= mysql_fetch_array($result))
	{
		@unlink("../upload/page/$row[name]");
	}
	$MySQL->query("delete from page where idx =$pageIdx");
	ReFresh("page_add.php");
}
else
{
	if(!empty($img_name))
	{
		$img_info=@getimagesize($img);
		$img_type=array_pop(explode(".",$img_name));
		if(($img_info[2]!=1) && ($img_info[2]!=2)  && ($img_info[2]!=6) )
		{
			MsgView("등록가능한 이미지 형식은 gif , jpg , bmp  입니다.", -1);
			exit;
		}
		else
		{
			$img_name = time();
			@unlink("../upload/page/$page_row[img]");
			@copy($img, "../upload/page/$img_name"); //파일복사
			$qry = "update page set img = '$img_name' where idx=$pageIdx";
			$MySQL->query($qry);
		}
	}
	if(empty($bPopup)) $bPopup=0;
	if($bHtml==1) $content = $TextContent;
	elseif($bHtml==2) $content = $HtmlContent;
	else $content = $content;
	$qry = "update page set ";
	$qry.= "title='$title',";
	$qry.= "bPopup=$bPopup,";
	$qry.= "content='$content', ";
	$qry.= "bHtml='$bHtml' ";
	$qry.= " where idx=$pageIdx";
	if($MySQL->query($qry))
	{
		OnlyMsgView("수정완료 하였습니다.");
		ReFresh("page_add.php");
	}
	else
	{
		echo"Err. : $qry";
	}
}
?>