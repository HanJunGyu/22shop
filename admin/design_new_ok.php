<?
include "head.php";
if(!defined(__DESIGN_ROW))
{
	define(__DESIGN_ROW,"TRUE");
	$design=$MySQL->fetch_array("select *from design limit 0,1");
}
if ($act == "design_new")
{
	if($part ==1)
	{
		if(!empty($img_name))
		{
			$img_info=@getimagesize($img);
			$img_type=array_pop(explode(".",$img_name));
			if(strtolower($img_type) =="swf") $mainnewTitleImg_type = "4";
			else		      $mainnewTitleImg_type = $img_info[2];
			if(($img_info[2]!=1) && ($img_info[2]!=2) && (strtolower($img_type)!="swf"))
			{
				MsgView("등록가능한 이미지 형식은 gif , jpg , swf 입니다.", -1);
				exit;
			}
			else
			{
				$img_name = date("YmdHis")."_".$img_name;
				@unlink("../upload/design/$design[mainnewTitleImg]");
				@move_uploaded_file($img, "../upload/design/$img_name") or die("move_uploaded_file Err"); //파일복사
				@unlink($img);
				$up_qry = "update design set mainnewTitleImg ='$img_name', mainnewTitleImg_type=$mainnewTitleImg_type";
				$MySQL->query($up_qry);
			}
		}
		if($new_type==1) $content = $TextContent;
		elseif($new_type==2) $content = $HtmlContent;
		else $content = $content;
		$up_qry = "update design set new_content ='$content', new_type ='$new_type',new_img_width=$new_img_width,new_img_height=$new_img_height,new_cols=$new_cols,new_img_select='$new_img_select' ";
		if ($MySQL->query($up_qry)) {}
		else echo $up_qry;
	}
	ReFresh($act.".php");
}
?>