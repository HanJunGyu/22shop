<?
include "head.php";
if(!defined(__DESIGN_ROW))
{
	define(__DESIGN_ROW,"TRUE");
	$design_goods=$MySQL->fetch_array("select *from design_goods limit 0,1");
}
if($act == "design_good_a")
{
	if($part==1)
	{
		$qry = "update design_goods set goodsListW=$goodsListW, goodsListH=$goodsListH,";
		$qry.="goodsListIW=$goodsListIW, goodsListIH=$goodsListIH,";
		$qry.="goodsListIW1=$goodsListIW1, goodsListIH1=$goodsListIH1,";
		$qry.="goodsListIW2=$goodsListIW2, goodsListIH2=$goodsListIH2,";
		$qry.="  designType=$designType,";
		$qry.="  designTypeCommon='$designTypeCommon'";
		$MySQL->query($qry);
	}
	ReFresh($act.".php");
}
else if($act == "design_good_b")
{
	if($part ==6)
	{
		$MySQL->query("update design_goods set bGoodsList_left ='$bGoodsList_left'");
	}
	else if($part ==5)
	{
		if(!empty($img_name))
		{
			$img_info=@getimagesize($img);
			$img_type=array_pop(explode(".",$img_name));
			if(($img_info[2]!=1) && ($img_info[2]!=2))
			{
				MsgView("등록가능한 이미지 형식은 gif , jpg 입니다.", -1);
				exit;
			}
			else
			{
				$img_name = date("YmdHis")."_".$img_name;
				@move_uploaded_file($img, "../upload/design/$img_name"); //파일복사
				@unlink($img);
			}
			$MySQL->query("update design_goods set SubBbsTitle ='$img_name'");
		}
	}
	else if($part ==1)
	{
		$MySQL->query("update design_goods set layApp =$layApp");
	}
	else if($part ==2)
	{
		$banner_row = $MySQL->fetch_array("select *from banner where idx=$bannerIdx");
		if($del)
		{
			@unlink("../upload/design/$banner_row[img]");
			$MySQL->query("delete from banner where idx=$bannerIdx");
		}
		else
		{
			if(empty($goodsUrl_str)) $goodsUrl_str =0;
			if(!empty($img_name))
			{
				$img_info=@getimagesize($img);
				$img_type=array_pop(explode(".",$img_name));
				if(strtolower($img_type)=="swf")	$banner_type =4;
				else					$banner_type =$img_info[2];
				if(($img_info[2]!=1) && ($img_info[2]!=2) && (strtolower($img_type)!="swf"))
				{
					MsgView("등록가능한 이미지 형식은 gif , jpg , swf 입니다.", -1);
					exit;
				}
				else
				{
					$img_name = date("YmdHis")."_".$img_name;
					@unlink("../upload/design/$banner_row[img]");
					@move_uploaded_file($img, "../upload/design/$img_name"); //파일복사
					@unlink($img);
					$up_qry = "update banner set img = '$img_name', type=$banner_type where idx=$bannerIdx";
					$MySQL->query($up_qry);
				}
			}
			$up_qry = "update banner set gubun =$gubun,siteUrl='$siteUrl_str',siteTarget='$siteTarget',";
			$up_qry.= "goodsUrl=$goodsUrl_str";
			if(!empty($sunwi)) $up_qry.= ",sunwi=$sunwi";
			$up_qry.= " where idx=$bannerIdx";
			$MySQL->query($up_qry);
		}
	}
	else if($part ==3)
	{
		if(empty($goodsUrl_str)) $goodsUrl_str =0;
		if(!empty($img_name))
		{
			$img_info=@getimagesize($img);
			$img_type=array_pop(explode(".",$img_name));
			if(strtolower($img_type)=="swf")	$banner_type=4;
			else					$banner_type=$img_info[2];
			if(($img_info[2]!=1) && ($img_info[2]!=2) && (strtolower($img_type)!="swf"))
			{
				MsgView("등록가능한 이미지 형식은 gif , jpg , swf 입니다.", -1);
				exit;
			}
			else
			{
				$img_name = date("YmdHis")."_".$img_name;
				@move_uploaded_file($img, "../upload/design/$img_name"); //파일복사
				@unlink($img);
			}
		}
		$up_qry = "insert into banner(position,gubun,siteUrl,goodsUrl,img,type,siteTarget)values(";
		$up_qry.= "'layer',$gubun,'$siteUrl_str', $goodsUrl_str ";
		$up_qry.=  ",'$img_name',$banner_type,'$siteTarget')";
		$MySQL->query($up_qry);
	}
	else if($part ==4)
	{
		$MySQL->query("update design_goods set layContent ='$layContent'");
	}
	ReFresh($act.".php");
}
else if($act == "design_join")
{
	$MySQL->query("update design_goods set memberJoinShow ='$memberJoinShow', memberJoinSure ='$memberJoinSure'");
	ReFresh($act.".php");
}
?>