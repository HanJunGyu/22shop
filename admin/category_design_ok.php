<?
include "head.php";
$cate_row = $MySQL->fetch_array("select *from category where code='$parentcode' limit 1");
if ($part==1)
{
	$qry = "update category set goodsListW=$goodsListW, goodsListH=$goodsListH,";
	$qry.="goodsListIW=$goodsListIW, goodsListIH=$goodsListIH,";
	$qry.="goodsListIW1=$goodsListIW1, goodsListIH1=$goodsListIH1,";
	$qry.="goodsListIW2=$goodsListIW2, goodsListIH2=$goodsListIH2,";
	$qry.="  designType=$designType";
	$qry.="  WHERE code='$parentcode'";
	if ($MySQL->query($qry))
	{
		OnlyMsgView("수정 완료하였습니다.");
		Refresh("category_design.php?parentcode=$parentcode");
	}
	else
	{
		OnlyMsgView("수정 실패하였습니다.");
		Refresh("category_design.php?parentcode=$parentcode");
	}
}
else if($part ==2)
{
	$banner_row = $MySQL->fetch_array("select *from banner where idx=$bannerIdx");
	if($del)
	{
		@unlink("../upload/design/$banner_row[img]");
		$MySQL->query("delete from banner where idx=$bannerIdx");
		Refresh("category_design.php?parentcode=$parentcode");
	}
	else
	{
		if(empty($goodsUrl_str)) $goodsUrl_str =0;
		if(!empty($img_name))
		{
			$img_info=@getimagesize($img);
			$img_type=array_pop(explode(".",$img_name));
			if($img_type=="swf") $banner_type =4;
			else $banner_type =$img_info[2];
			if(($img_info[2]!=1) && ($img_info[2]!=2) && ($img_type!="swf")  && ($img_info[2]!=6) )
			{
				MsgView("등록가능한 이미지 형식은 gif , jpg ,  , swf 입니다. $img_name", -1);
				exit;
			}
			$img_name = date("YmdHis")."_".$img_name;
			@unlink("../upload/design/$banner_row[img]");
			@move_uploaded_file($img, "../upload/design/$img_name"); //파일복사
			@unlink($img);
			$MySQL->query("update banner set img = '$img_name', type=$banner_type where idx=$bannerIdx");
		}
		$up_qry = "update banner set gubun =$gubun,siteUrl='$siteUrl_str',siteTarget='$siteTarget',";
		$up_qry.= "goodsUrl=$goodsUrl_str";
		if(!empty($sunwi)) $up_qry.= ",sunwi=$sunwi";
		$up_qry.= " where idx=$bannerIdx";
		$MySQL->query($up_qry);
		Refresh("category_design.php?parentcode=$parentcode");
	}
}
else if($part ==3)
{
	if(empty($goodsUrl_str)) $goodsUrl_str =0;
	if(!empty($img_name))
	{
		$img_info=@getimagesize($img);
		$img_type=array_pop(explode(".",$img_name));
		if(($img_info[2]!=1) && ($img_info[2]!=2) && ($img_type!="swf")  && ($img_info[2]!=6) )
		{
			MsgView("등록가능한 이미지 형식은 gif , jpg ,  , swf 입니다. $img_name", -1);
			exit;
		}
		else
		{
			$img_name = date("YmdHis")."_".$img_name;
			@move_uploaded_file($img, "../upload/design/$img_name"); //파일복사
			@unlink($img);
		}
	}
	if($img_type=="swf")	$banner_type=4;
	else					$banner_type=$img_info[2];
	$up_qry = "insert into banner(position,gubun,siteUrl,goodsUrl,img,type,siteTarget)values(";
	$up_qry.= "'$parentcode',$gubun,'$siteUrl_str', $goodsUrl_str ";
	$up_qry.=  ",'$img_name',$banner_type,'$siteTarget')";
	if($MySQL->query($up_qry))
	{
		Refresh("category_design.php?parentcode=$parentcode");
	}
	else
	{
		if(is_file("../upload/design/$img_name")) @unlink("../upload/design/$img_name");
	}
}
else if($part ==4)
{
	$banner_row = $MySQL->fetch_array("select *from category_banner where idx=$bannerIdx");
	if($del)
	{
		@unlink("../upload/design/$banner_row[img]");
		$MySQL->query("delete from category_banner where idx=$bannerIdx");
		Refresh("category_design.php?parentcode=$parentcode");
	}
	else
	{
		if(empty($goodsUrl_str)) $goodsUrl_str =0;
		if(!empty($img_name))
		{
			$img_info=@getimagesize($img);
			$img_type=array_pop(explode(".",$img_name));
			if($img_type=="swf")	$banner_type =4;
			else					$banner_type =$img_info[2];
			if(($img_info[2]!=1) && ($img_info[2]!=2) && ($img_type!="swf")  && ($img_info[2]!=6) )
			{
				MsgView("등록가능한 이미지 형식은 gif , jpg ,  , swf 입니다. $img_name", -1);
				exit;
			}
			$img_name = date("YmdHis")."_".$img_name;
			@unlink("../upload/design/$banner_row[img]");
			@move_uploaded_file($img, "../upload/design/$img_name"); //파일복사
			@unlink($img);
			$MySQL->query("update banner set img = '$img_name', type=$banner_type where idx=$bannerIdx");
		}
		$up_qry = "update category_banner set gubun =$gubun,siteUrl='$siteUrl_str',siteTarget='$siteTarget',";
		$up_qry.= "goodsUrl=$goodsUrl_str";
		if(!empty($sunwi)) $up_qry.= ",sunwi=$sunwi";
		$up_qry.= " where idx=$bannerIdx";
		$MySQL->query($up_qry);
		Refresh("category_design.php?parentcode=$parentcode");
	}
}
else if($part ==5)
{
	if(empty($goodsUrl_str)) $goodsUrl_str =0;
	if(!empty($img_name))
	{
		$img_info=@getimagesize($img);
		$img_type=array_pop(explode(".",$img_name));
		if(($img_info[2]!=1) && ($img_info[2]!=2) && ($img_type!="swf")  && ($img_info[2]!=6) )
		{
			MsgView("등록가능한 이미지 형식은 gif , jpg ,  , swf 입니다. $img_name", -1);
			exit;
		}
		else
		{
			$img_name = date("YmdHis")."_".$img_name;
			@move_uploaded_file($img, "../upload/design/$img_name"); //파일복사
			@unlink($img);
		}
	}
	if($img_type=="swf")	$banner_type=4;
	else					$banner_type=$img_info[2];
	$up_qry = "insert into category_banner(position,gubun,siteUrl,goodsUrl,img,type,siteTarget)values(";
	$up_qry.= "'$parentcode',$gubun,'$siteUrl_str', $goodsUrl_str ";
	$up_qry.=  ",'$img_name',$banner_type,'$siteTarget')";
	if($MySQL->query($up_qry))
	{
		Refresh("category_design.php?parentcode=$parentcode");
	}
	else
	{
		if(is_file("../upload/design/$img_name")) @unlink("../upload/design/$img_name");
	}
	
}
else if($part ==6)
{
	$MySQL->query("UPDATE category SET midBannerCols=$val WHERE code='$parentcode'");
	Refresh("category_design.php?parentcode=$parentcode");
}
?>