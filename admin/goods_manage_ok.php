<?
include "head.php";
if ($perc && $bType)
{
	$perc = $perc * 0.01;
	if ($bType=="up")
	{
		$qry = "UPDATE goods SET price=price + round(price*$perc,-2), point=point + round(point*$perc,-1) ";
	}
	else
	{
		$qry = "UPDATE goods SET price=price - round(price*$perc,-2), point=point - round(point*$perc,-1) ";
	}
	if ($MySQL->query($qry))
	{
		OnlyMsgView("수정완료 하였습니다.");
		ReFresh("goods_manage.php");
		exit;
	}
	else
	{
		OnlyMsgView("실패하였습니다.");
		ReFresh("goods_manage.php");
		exit;
	}
}
else
{
	if(!empty($goodsPointImg_name))
	{
		$goodsPointImgInfo=@getimagesize($goodsPointImg);
		if(($goodsPointImgInfo[2]!=1) && ($goodsPointImgInfo[2]!=2)) MsgView("이미지 형식을 gif , jpg 로 입력해 주세요", -1);
		else
		{
			$goodsPointImgName ="goods_point_img";
			if(file_exists("../upload/$goodsPointImgName")) unlink("../upload/$goodsPointImgName");
			@move_uploaded_file($goodsPointImg, "../upload/$goodsPointImgName");
			@unlink($goodsPointImg);
		}
	}
	if(!empty($goodsEtcImg_name))
	{
		$goodsEtcImgInfo=@getimagesize($goodsEtcImg);		//상품 기타 이미지 정보
		if(($goodsEtcImgInfo[2]!=1) && ($goodsEtcImgInfo[2]!=2)) MsgView("이미지 형식을 gif , jpg 로 입력해 주세요", -1);
		else
		{
			$goodsEtcImgName ="goods_etc_img";
			if(file_exists("../upload/$goodsEtcImgName")) unlink("../upload/$goodsEtcImgName");
			@move_uploaded_file($goodsEtcImg, "../upload/$goodsEtcImgName");
			@unlink($goodsEtcImg);
		}
	}
	if(!empty($goodsHitImg_name))
	{
		$goodsHitImgInfo=@getimagesize($goodsHitImg);
		if(($goodsHitImgInfo[2]!=1) && ($goodsHitImgInfo[2]!=2)) MsgView("이미지 형식을 gif , jpg 로 입력해 주세요", -1);
		else
		{
			$goodsHitImgName ="goods_hit_img";
			if(file_exists("../upload/$goodsHitImgName")) unlink("../upload/$goodsHitImgName");
			@move_uploaded_file($goodsHitImg, "../upload/$goodsHitImgName");
			@unlink($goodsHitImg);
		}
	}
	if(!empty($goodsNewImg_name))
	{
		$goodsNewImgInfo=@getimagesize($goodsNewImg);
		if(($goodsNewImgInfo[2]!=1) && ($goodsNewImgInfo[2]!=2)) MsgView("이미지 형식을 gif , jpg 로 입력해 주세요", -1);
		else
		{
			$goodsNewImgName ="goods_new_img";
			if(file_exists("../upload/$goodsNewImgName")) unlink("../upload/$goodsNewImgName");
			@move_uploaded_file($goodsNewImg, "../upload/$goodsNewImgName");
			@unlink($goodsNewImg);
		}
	}
	if(!empty($goods_view_img_name))
	{
		$goods_view_imgInfo=@getimagesize($goods_view_img);		//상품 기타 이미지 정보
		if(($goods_view_imgInfo[2]!=1) && ($goods_view_imgInfo[2]!=2)) MsgView("이미지 형식을 gif , jpg 로 입력해 주세요", -1);
		else
		{
			$goods_view_imgName ="goods_view_img";
			if(file_exists("../upload/$goods_view_imgName")) unlink("../upload/$goods_view_imgName");
			@move_uploaded_file($goods_view_img, "../upload/$goods_view_imgName");
			@unlink($goods_view_img);
		}
	}
	if(!empty($goods_price_img_name))
	{
		$goods_price_imgInfo=@getimagesize($goods_price_img);		//상품 기타 이미지 정보
		if(($goods_price_imgInfo[2]!=1) && ($goods_price_imgInfo[2]!=2)) MsgView("이미지 형식을 gif , jpg 로 입력해 주세요", -1);
		else
		{
			$goods_price_imgName ="goods_price_img";
			if(file_exists("../upload/$goods_price_imgName")) unlink("../upload/$goods_price_imgName");
			@move_uploaded_file($goods_price_img, "../upload/$goods_price_imgName");
			@unlink($goods_price_img);
		}
	}
	if(!empty($no_good_img_name))
	{
		$no_good_imgInfo=@getimagesize($no_good_img);
		if(($no_good_imgInfo[2]!=1) && ($no_good_imgInfo[2]!=2)) MsgView("이미지 형식을 gif , jpg 로 입력해 주세요", -1);
		else
		{
			$no_good_imgName ="no_good_img";
			if(file_exists("../upload/$no_good_imgName")) unlink("../upload/$no_good_imgName");
			@move_uploaded_file($no_good_img, "../upload/$no_good_imgName");
			@unlink($no_good_img);
		}
	}
	if(!empty($catebest_img_name))
	{
		$catebest_imgInfo=@getimagesize($catebest_img);
		if(($catebest_imgInfo[2]!=1) && ($catebest_imgInfo[2]!=2)) MsgView("이미지 형식을 gif , jpg 로 입력해 주세요", -1);
		else
		{
			$catebest_imgName ="catebest_img";
			if(file_exists("../upload/$catebest_imgName")) unlink("../upload/$catebest_imgName");
			@move_uploaded_file($catebest_img, "../upload/$catebest_imgName");
			@unlink($catebest_img);
		}
	}
	if(!empty($watermark_img_name))
	{
		$watermark_imgInfo=@getimagesize($watermark_img);
		if(($watermark_imgInfo[2]!=1) && ($watermark_imgInfo[2]!=2)) MsgView("이미지 형식을 gif , jpg 로 입력해 주세요", -1);
		else
		{
			$watermark_imgName ="watermark_img";
			if(file_exists("../upload/$watermark_imgName")) unlink("../upload/$watermark_imgName");
			@move_uploaded_file($watermark_img, "../upload/$watermark_imgName");
			@unlink($watermark_img);
		}
	}
	if(empty($bNew))	$bNew =0;
	if(empty($bEtc))	$bEtc =0;
	if(empty($new_day))	$new_day =1; 
	$gname_color = $t_no_font_color1;
	$gprice_color = $t_no_font_color2;
	$gpoint_color = $t_no_font_color3;

	$qry = "update admin set ";
	$qry.= "bGoodsapp	= '$bGoodsapp', ";
	$qry.= "bNew		= $bNew , ";
	$qry.= "bEtc		= $bEtc,  ";
	$qry.= "new_day	= $new_day,  ";
	$qry.= "beditprice_warn	= '$beditprice_warn',  ";
	$qry.= "editprice_warn	= $editprice_warn,  ";
	$qry.= "bAskboard	= '$bAskboard',  ";
	$qry.= "wm_pos	= $wm_pos  ";

	$qry2 = "update design_goods set ";
	$qry2.= "gname_color	= '$gname_color',  ";
	$qry2.= "gprice_color	= '$gprice_color',  ";
	$qry2.= "gpoint_color	= '$gpoint_color',  ";
	$qry2.= "bGoodsList_1	= '$bGoodsList_1',  ";
	$qry2.= "bGoodsList_2	= '$bGoodsList_2',  ";
	$qry2.= "bGoodsList_4	= '$bGoodsList_4',  ";
	$qry2.= "bGoodsList_5	= '$bGoodsList_5',  ";
	$qry2.= "gdimg1_width	= '$gdimg1_width',  ";
	$qry2.= "gdimg1_height	= '$gdimg1_height',  ";
	$qry2.= "gdimg2_width	= '$gdimg2_width',  ";
	$qry2.= "gdimg2_height	= '$gdimg2_height'  ";

	if($MySQL->query($qry))
	{
		if($MySQL->query($qry2))
		{
			OnlyMsgView("수정완료 하였습니다.");
			ReFresh("goods_manage.php");
		}
	}
	else
	{
		ErrMsg($qry);
		ReFresh("goods_manage.php");
	}
}
?>