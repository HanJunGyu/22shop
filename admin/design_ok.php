<?
include "head.php";
if(!defined(__DESIGN_ROW))
{
	define(__DESIGN_ROW,"TRUE");
	$design=$MySQL->fetch_array("select *from design limit 0,1");
}
if($act == "design")
{
	$startday = $year."-".$month."-".$day;
	$endday = $year2."-".$month2."-".$day2;
	if (empty($bUnder)) $bUnder = 0;
	else
	{
		$bUnder = 1;
		if(!empty($underImg_name))
		{
			$underImg_info=@getimagesize($underImg);		//이미지1 정보
			if(($underImg_info[2]!=1) && ($underImg_info[2]!=2))
			{
				MsgView("이미지 형식을 gif , jpg 로 입력해 주세요", -1);
				exit;
			}
			$underImg_name ="under".substr(time(),5,5);
			@move_uploaded_file($underImg, "../upload/design/$underImg_name"); //파일복사
			@unlink($underImg);
			$qry="update design set underImg ='$underImg_name'";
			if (!$MySQL->query($qry)) @unlink("../upload/design/$underImg_name");
		}
	}
	$qry="update design set mainAlign ='$mainAlign',bUnder=$bUnder,startday='$startday',endday='$endday',css='$css'";
	if ($MySQL->query($qry)) OnlyMsgView("저장되었습니다.");
	else OnlyMsgView("저장에 실패하였습니다.");
	ReFresh($act.".php");
}
else if($act == "design_a")
{
	if($part ==41)
	{
		$MySQL->query("update design set topSkin = $topSkin");
	}
	else if($part ==1)
	{
		if(!empty($img_name))
		{
			$img_info=@getimagesize($img);
			$img_type=array_pop(explode(".",$img_name));
			if(($img_info[2]!=1) && ($img_info[2]!=2) && (strtolower($img_type)!="swf"))
			{
				MsgView("등록가능한 이미지 형식은 gif , jpg , swf 입니다.", -1);
				exit;
			}
			else
			{
				$img_name = date("YmdHis")."_".$img_name;
				if($img_type=="swf")	$mainLogoImg_type=4;
				else					$mainLogoImg_type=$img_info[2];
				@unlink("../upload/design/$design[mainLogoImg]");
				@move_uploaded_file($img, "../upload/design/$img_name"); //파일복사
				$MySQL->query("update design set mainLogoImg = '$img_name', mainLogoImg_type=$mainLogoImg_type");
			}
		}
	}
	else if($part ==38)
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
				@unlink("../upload/design/$design[mainFavorite]");
				@move_uploaded_file($img, "../upload/design/$img_name"); //파일복사
				$MySQL->query("update design set mainFavorite = '$img_name'");
			}
		}
	}
	else if($part ==42)
	{
		if(!empty($img_name))
		{
			$img_info=@getimagesize($img);
			if(($img_info[2]!=1) && ($img_info[2]!=2))
			{
				MsgView("등록가능한 이미지 형식은 gif , jpg 입니다.", -1);
				exit;
			}
			else
			{
				$img_name = date("YmdHis")."_".$img_name;
				@unlink("../upload/design/$design[mainGoodsSearchTitle]");
				@move_uploaded_file($img, "../upload/design/$img_name"); //파일복사
				@unlink($img);
				$MySQL->query("update design set mainGoodsSearchTitle = '$img_name'");
			}
		}
	}
	else if($part ==10)
	{
		if(!empty($img_name))
		{
			$img_info=@getimagesize($img);
			if(($img_info[2]!=1) && ($img_info[2]!=2))
			{
				MsgView("등록가능한 이미지 형식은 gif , jpg 입니다.", -1);
				exit;
			}
			else
			{
				$img_name = date("YmdHis")."_".$img_name;
				@unlink("../upload/design/$design[mainGoodsSearchButton]");
				@move_uploaded_file($img, "../upload/design/$img_name"); //파일복사
				@unlink($img);
				$MySQL->query("update design set mainGoodsSearchButton = '$img_name'");
			}
		}
	}
	else if($part ==11)
	{
		if(!empty($img_name))
		{
			$img_info=@getimagesize($img);
			if(($img_info[2]!=1) && ($img_info[2]!=2))
			{
				MsgView("등록가능한 이미지 형식은 gif , jpg 입니다.", -1);
				exit;
			}
			else
			{
				$img_name = date("YmdHis")."_".$img_name;
				@unlink("../upload/design/$design[mainGoodsSearchButton2]");
				@move_uploaded_file($img, "../upload/design/$img_name"); //파일복사
				@unlink($img);
				$MySQL->query("update design set mainGoodsSearchButton2 = '$img_name'");
			}
		}
	}
	else if($part ==14)
	{
		$MySQL->query("update design set bmainTopMenu=$bmainTopMenu");
	}
	else if($part ==12)
	{
		$banner_row = $MySQL->fetch_array("select *from banner where idx=$bannerIdx");
		if($del)
		{
			@unlink("../upload/design/$banner_row[img]");
			$MySQL->query("delete from banner where idx=$bannerIdx");
		}
		else
		{
			if(!empty($img_name))
			{
				$img_info=@getimagesize($img);
				$img_type=array_pop(explode(".",$img_name));
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
				}
			}
			if($img_type=="swf")	$banner_type =4;
			else			$banner_type =$img_info[2];
			$up_qry = "update banner set siteUrl='$siteUrl_str', siteTarget='$siteTarget'";
			if(!empty($img_name)) $up_qry.=  ",img = '$img_name', type=$banner_type ";
			$up_qry.= " where idx=$bannerIdx";
			$MySQL->query($up_qry) or Die("err:$up_qry");
		}
	}
	else if($part ==13)
	{
		if(!empty($img_name))
		{
			$img_info=@getimagesize($img);
			$img_type=array_pop(explode(".",$img_name));
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
		if($img_type=="swf")	$banner_type=4;
		else					$banner_type=$img_info[2];
		$up_qry = "insert into banner(position,siteUrl,siteTarget,img,type)values(";
		$up_qry.= "'topbanner','$siteUrl_str','$siteTarget',";
		$up_qry.=  "'$img_name',$banner_type)";
		$MySQL->query($up_qry);
	}
	else
	{
		$menuMoutIndex	= ($part-1)*2-1;
		$menuMoverIndex = ($part-1)*2;
		if(!empty($img1_name))
		{
			$img1_info=@getimagesize($img1);
			if(($img1_info[2]!=1) && ($img1_info[2]!=2))
			{
				MsgView("등록가능한 이미지 형식은 gif , jpg 입니다.", -1);
				exit;
			}
			else
			{
				$img1_name = time()+$menuMoutIndex;
				$img_index = "mainMenuImg".$menuMoutIndex;
				@unlink("../upload/design/$design[$img_index]");
				@move_uploaded_file($img1, "../upload/design/$img1_name"); //파일복사
				$MySQL->query("update design set mainMenuImg$menuMoutIndex = $img1_name");
			}
		}
		if(!empty($img2_name))
		{
			$img2_info=@getimagesize($img2);
			if(($img2_info[2]!=1) && ($img2_info[2]!=2))
			{
				MsgView("등록가능한 이미지 형식은 gif , jpg 입니다.", -1);
				exit;
			}
			else
			{
				$img2_name = time()+$menuMoverIndex;
				$img_index = "mainMenuImg".$menuMoverIndex;
				@unlink("../upload/design/$design[$img_index]");
				@move_uploaded_file($img2, "../upload/design/$img2_name"); //파일복사
				$MySQL->query("update design set mainMenuImg$menuMoverIndex = $img2_name");
			}
		}
	}
	ReFresh($act.".php");
}
else if($act == "design_b")
{
	if($part ==9)
	{
		$MySQL->query("UPDATE design SET design_b_layout=$design_b_layout");
	}
	else if($part ==1)
	{
		if(!empty($img_name))
		{
			$img_info=@getimagesize($img);
			if(($img_info[2]!=1) && ($img_info[2]!=2)  && ($img_info[2]!=6))
			{
				MsgView("등록가능한 이미지 형식은 gif , jpg ,  입니다.", -1);
				exit;
			}
			else
			{
				$img_name = date("YmdHis")."_".$img_name;
				@unlink("../upload/design/$design[noticeTitleImg]");
				@move_uploaded_file($img, "../upload/design/$img_name"); //파일복사
				$MySQL->query("update design set noticeTitleImg = '$img_name'");
			}
		}
	}
	else if($part ==4)
	{
		$MySQL->query("update design set mainnSubTitle2_url = '$mainnSubTitle2_url',mainnSubTitle2_target='$mainnSubTitle2_target'");
		if(!empty($img_name))
		{
			$img_info=@getimagesize($img);
			if(($img_info[2]!=1) && ($img_info[2]!=2)  && ($img_info[2]!=6))
			{
				MsgView("등록가능한 이미지 형식은 gif , jpg ,  입니다.", -1);
				exit;
			}
			else
			{
				$img_name = date("YmdHis")."_".$img_name;
				@unlink("../upload/design/$design[mainnSubTitle2]");
				@move_uploaded_file($img, "../upload/design/$img_name"); //파일복사
				$MySQL->query("update design set mainnSubTitle2 = '$img_name'");
			}
		}
	}
	else if($part ==2)
	{
		if(!empty($img_name))
		{
			$img_info=@getimagesize($img);
			$img_type=array_pop(explode(".",$img_name));
			if(strtolower($img_type) =="swf") $mainTitleImg_type = "4";
			else $mainTitleImg_type = $img_info[2];
			if(($img_info[2]!=1) && ($img_info[2]!=2)&& (strtolower($img_type)!="swf"))
			{
				MsgView("등록가능한 이미지 형식은 gif , jpg , swf 입니다.", -1);
				exit;
			}
			else
			{
				$img_name = date("YmdHis")."_".$img_name;
				@unlink("../upload/design/$design[mainTitleImg]");
				@move_uploaded_file($img, "../upload/design/$img_name"); //파일복사
				@unlink($img);
				$MySQL->query("update design set mainTitleImg = '$img_name', mainTitleImg_type=$mainTitleImg_type");
			}
		}
		$MySQL->query("update design set mainTitleImg_bhtml =$mainTitleImg_bhtml, mainTitleImg_content='$mainTitleImg_content'");
	}
	else if ($part==12)
	{
		$qry = "UPDATE design SET bScrollUse='$bScrollUse'";
		if ($designBwait) $qry.=" ,designBwait=$designBwait";
		$MySQL->query($qry);
	}
	else if($part ==10)
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
				if(strtolower($img_type)=="swf") $banner_type =4;
				else $banner_type =$img_info[2];
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
					$MySQL->query("update banner set img = '$img_name', type=$banner_type where idx=$bannerIdx");
				}
			}
			$up_qry = "update banner set gubun =$gubun,siteUrl='$siteUrl_str',siteTarget='$siteTarget',";
			$up_qry.= "goodsUrl=$goodsUrl_str";
			if(!empty($sunwi)) $up_qry.= ",sunwi=$sunwi";
			$up_qry.= " where idx=$bannerIdx";
			$MySQL->query($up_qry);
		}
	}
	else if($part ==11)
	{
		if(empty($goodsUrl_str)) $goodsUrl_str =0;
		if(!empty($img_name))
		{
			$img_info=@getimagesize($img);
			$img_type=array_pop(explode(".",$img_name));
			if(strtolower($img_type)=="swf") $banner_type =4;
			else $banner_type =$img_info[2];
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
		$up_qry.= "'$position',$gubun,'$siteUrl_str', $goodsUrl_str ";
		$up_qry.=  ",'$img_name',$banner_type,'$siteTarget')";
		$MySQL->query($up_qry);
	}
	ReFresh($act.".php");
}
else if($act == "design_b1" || $act == "design_b2" || $act == "design_b3")
{
	if ($part==3)
	{
		if ($position=="mainCenter1") $MySQL->query("UPDATE design SET mainCenter1_cols=$cols,mainCenter1_use='$bUse'");
		else if ($position=="mainCenter2") $MySQL->query("UPDATE design SET mainCenter2_cols=$cols,mainCenter2_use='$bUse'");
		else if ($position=="mainCenter3") $MySQL->query("UPDATE design SET mainCenter3_cols=$cols,mainCenter3_use='$bUse'");
	}
	else if($part ==1)
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
				else $banner_type =$img_info[2];
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
					$MySQL->query("update banner set img = '$img_name', type=$banner_type where idx=$bannerIdx");
				}
			}
			$up_qry = "update banner set gubun =$gubun,siteUrl='$siteUrl_str',siteTarget='$siteTarget',";
			$up_qry.= "goodsUrl=$goodsUrl_str";
			if(!empty($sunwi)) $up_qry.= ",sunwi=$sunwi";
			$up_qry.= " where idx=$bannerIdx";
			$MySQL->query($up_qry);
		}
	}
	else if($part ==2)
	{
		if(empty($goodsUrl_str)) $goodsUrl_str =0;
		if(!empty($img_name))
		{
			$img_info=@getimagesize($img);
			$img_type=array_pop(explode(".",$img_name));
			if(strtolower($img_type)=="swf")	$banner_type=4;
			else $banner_type=$img_info[2];
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
		$up_qry.= "'$position',$gubun,'$siteUrl_str', $goodsUrl_str ";
		$up_qry.=  ",'$img_name',$banner_type,'$siteTarget')";
		$MySQL->query($up_qry);
	}
	ReFresh($act.".php?position=$position");
}
else if($act == "design_c")
{
	if($part ==6)
	{
		$up_qry = "update design set bNoticeLeft = '$bNoticeLeft'";
		$MySQL->query($up_qry);
	}
	else if($part ==4)
	{
		$data_num = count($img);
		for ($i=0; $i<$data_num; $i++)
		{
			if ($img[$i])
			{
				$img_info=getimagesize($img[$i]);
				if(($img_info[2]!=1) && ($img_info[2]!=2))
				{
					MsgView("등록가능한 이미지 형식은 gif , jpg  입니다. ", -1);
					exit;
				}
				else
				{
					$img_name = date("YmdHis")."_".$img_name;
					@unlink("../upload/design/$design[$field]");
					move_uploaded_file($img[$i], "../upload/design/$img_name"); //파일복사
					@unlink($img[$i]);
				}
				$up_qry = "update design set $field = '$img_name'";
				$MySQL->query($up_qry) or die("err:$up_qry");
			}
		}
	}
	else if($part ==7)
	{
		$login_bgcolor = $t_no_font_color1;
		$up_qry = "update design set login_bgcolor = '$login_bgcolor'";
		$MySQL->query($up_qry);
	}
	else if($part ==5)
	{
		$up_qry = "update design set bLoginShow = '$bLoginShow'";
		$MySQL->query($up_qry);
	}
	else if($part ==8)
	{
		$up_qry = "update design set bLeftCategory = '$bLeftCategory'";
		$MySQL->query($up_qry);
	}
	else if($part ==1)
	{
		if(!empty($img_name))
		{
			$img_info=@getimagesize($img);
			if(($img_info[2]!=1) && ($img_info[2]!=2))
			{
				MsgView("등록가능한 이미지 형식은 gif , jpg 입니다.", -1);
				exit;
			}
			else
			{
				$img_name = date("YmdHis")."_".$img_name;
				@unlink("../upload/design/$design[mainCategoryTitle]");
				@move_uploaded_file($img, "../upload/design/$img_name"); //파일복사
				@unlink($img);
				$MySQL->query("update design set mainCategoryTitle = '$img_name'");
			}
		}
		if (empty($bmainCategoryTitle)) $bmainCategoryTitle = 0;
		$up_qry = "update design set bmainCategoryTitle=$bmainCategoryTitle";
		$MySQL->query($up_qry);
	}
	else if($part ==2)
	{
		$up_qry = "update design set mainMaxcateH = $mainMaxcateH , mainbMaxcateT =$mainbMaxcateT";
		$MySQL->query($up_qry);
	}
	ReFresh($act.".php");
}
else if($act == "design_d")
{
	if($part ==1)
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
				if(strtolower($img_type)=="swf") $banner_type =4;
				else $banner_type =$img_info[2];
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
	else if($part ==2)
	{
		if(empty($goodsUrl_str)) $goodsUrl_str =0;
		if(!empty($img_name))
		{
			$img_info=@getimagesize($img);
			$img_type=array_pop(explode(".",$img_name));
			if(strtolower($img_type)=="swf")	$banner_type=4;
			else $banner_type=$img_info[2];
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
		$up_qry.= "'left3',$gubun,'$siteUrl_str', $goodsUrl_str ";
		$up_qry.=  ",'$img_name',$banner_type,'$siteTarget')";
		$MySQL->query($up_qry);
	}
	else if($part ==3)
	{
		$MySQL->query("update design set bPoll=$bPoll");
	}
	else if($part ==4)
	{
		if(!empty($img_name))
		{
			$img_info=@getimagesize($img);
			if(($img_info[2]!=1) && ($img_info[2]!=2))
			{
				MsgView("등록가능한 이미지 형식은 gif , jpg 입니다.", -1);
				exit;
			}
			else
			{
				$img_name = date("YmdHis")."_".$img_name;
				@unlink("../upload/design/$design[mainPollTitle]");
				@move_uploaded_file($img, "../upload/design/$img_name"); //파일복사
				@unlink($img);
			}
			$up_qry = "update design set mainPollTitle = '$img_name'";
			$MySQL->query($up_qry);
		}
	}
	else if($part ==5)
	{
		if(!empty($img_name))
		{
			$img_info=@getimagesize($img);
			if(($img_info[2]!=1) && ($img_info[2]!=2))
			{
				MsgView("등록가능한 이미지 형식은 gif , jpg 입니다.", -1);
				exit;
			}
			else
			{
				$img_name = date("YmdHis")."_".$img_name;
				@unlink("../upload/design/$design[mainPollWrite]");
				@move_uploaded_file($img, "../upload/design/$img_name"); //파일복사
				@unlink($img);
			}
			$up_qry = "update design set mainPollWrite = '$img_name'";
			$MySQL->query($up_qry);
		}
	}
	else if($part ==6)
	{
		if(!empty($img_name))
		{
			$img_info=@getimagesize($img);
			if(($img_info[2]!=1) && ($img_info[2]!=2))
			{
				MsgView("등록가능한 이미지 형식은 gif , jpg 입니다.", -1);
				exit;
			}
			else
			{
				$img_name = date("YmdHis")."_".$img_name;
				@unlink("../upload/design/$design[mainPollResult]");
				@move_uploaded_file($img, "../upload/design/$img_name"); //파일복사
				@unlink($img);
			}
			$up_qry = "update design set mainPollResult = '$img_name'";
			$MySQL->query($up_qry);
		}
	}
	else if($part ==9)
	{
		if(!empty($img_name))
		{
			$img_info=@getimagesize($img);
			if(($img_info[2]!=1) && ($img_info[2]!=2))
			{
				MsgView("등록가능한 이미지 형식은 gif , jpg 입니다.", -1);
				exit;
			}
			else
			{
				$img_name = date("YmdHis")."_".$img_name;
				@unlink("../upload/design/$design[mainNewGoodsTitle]");
				@move_uploaded_file($img, "../upload/design/$img_name"); //파일복사
				@unlink($img);
			}
			$up_qry = "update design set mainNewGoodsTitle = '$img_name'";
			$MySQL->query($up_qry);
		}
	}
	else if($part ==8)
	{
		if(empty($mainNewGoodsList)) $mainNewGoodsList =0;
		$up_qry = "update design set mainNewGoodsList = $mainNewGoodsList";
		$MySQL->query($up_qry);
	}
	else if($part ==12)
	{
		if(!empty($img_name))
		{
			$img_info=@getimagesize($img);
			if(($img_info[2]!=1) && ($img_info[2]!=2))
			{
				MsgView("등록가능한 이미지 형식은 gif , jpg 입니다.", -1);
				exit;
			}
			else
			{
				$img_name = date("YmdHis")."_".$img_name;
				@unlink("../upload/design/$design[mainFreeTitle]");
				@move_uploaded_file($img, "../upload/design/$img_name"); //파일복사
				@unlink($img);
			}
			$up_qry = "update design set mainFreeTitle = '$img_name'";
			$MySQL->query($up_qry);
		}
		$up_qry = "update design set bmainFreeTitle = '$bmainFreeTitle',mainFreeGoodsList='$mainFreeGoodsList'";
		$MySQL->query($up_qry);
	}
	ReFresh($act.".php");
}
else if($act == "design_e")
{
	$MySQL->query("update design set mainBestApp =$mainBestApp");
	if($part ==1)
	{
		if(!empty($img_name))
		{
			$img_info=@getimagesize($img);
			if(($img_info[2]!=1) && ($img_info[2]!=2))
			{
				MsgView("등록가능한 이미지 형식은 gif , jpg 입니다.", -1);
				exit;
			}
			else
			{
				$img_name = date("YmdHis")."_".$img_name;
				@unlink("../upload/design/$design[mainBestGoodsTitle]");
				@move_uploaded_file($img, "../upload/design/$img_name"); //파일복사
				@unlink($img);
			}
			$up_qry = "update design set mainBestGoodsTitle = '$img_name'";
			$MySQL->query($up_qry);
		}
	}
	else if($part ==2)
	{
		if(empty($mainBestGoodsW)) $mainBestGoodsW =0;
		if(empty($mainBestGoodsH)) $mainBestGoodsH =0;
		if ($mainBestColsChange=="y")
		{
			$mainBestColsChangeValue = implode("/",$cols_arr);	/// 행마다 열 자유선택시 /로 묶음 (4/3/2)
		}
		$up_qry = "update design set mainBestGoodsW = $mainBestGoodsW, mainBestGoodsH = $mainBestGoodsH,mainBestColsChange='$mainBestColsChange',mainBestColsChangeValue='$mainBestColsChangeValue'";
		$up_qry.=" ,mainScrollWait=$mainScrollWait,mainScrollHeight = $mainScrollHeight,mainScrollSpeed=$mainScrollSpeed";
		$MySQL->query($up_qry);
	}
	else if($part ==3)
	{
		$up_qry = "update design set mainBestContent = '$mainBestContent'";
		$MySQL->query($up_qry);
	}
	else if($part ==4)
	{
		if(empty($mainBestGoodsIW)) $mainBestGoodsIW =0;
		if(empty($mainBestGoodsIH)) $mainBestGoodsIH =0;
		$up_qry = "update design set mainBestGoodsIW = $mainBestGoodsIW, mainBestGoodsIH = $mainBestGoodsIH";
		$MySQL->query($up_qry);
	}
	ReFresh($act.".php");
}
else if($act == "design_f")
{
	$MySQL->query("update design set mainHitApp =$mainHitApp");
	if($part ==1)
	{
		if(!empty($img_name))
		{
			$img_info=@getimagesize($img);
			if(($img_info[2]!=1) && ($img_info[2]!=2))
			{
				MsgView("등록가능한 이미지 형식은 gif , jpg 입니다.", -1);
				exit;
			}
			else
			{
				$img_name = date("YmdHis")."_".$img_name;
				@unlink("../upload/design/$design[mainHitGoodsTitle]");
				move_uploaded_file($img, "../upload/design/$img_name"); //파일복사
				@unlink($img);
			}
			$up_qry = "update design set mainHitGoodsTitle = '$img_name'";
			$MySQL->query($up_qry);
		}
	}
	else if($part ==2)
	{
		if(empty($mainHitGoodsW)) $mainHitGoodsW =0;
		if(empty($mainHitGoodsH)) $mainHitGoodsH =0;
		if ($mainHitColsChange=="y")
		{
			$mainHitColsChangeValue = implode("/",$cols_arr);	/// 행마다 열 자유선택시 /로 묶음 (4/3/2)
		}
		$up_qry = "update design set mainHitGoodsW = $mainHitGoodsW, mainHitGoodsH = $mainHitGoodsH,mainHitColsChange='$mainHitColsChange',mainHitColsChangeValue='$mainHitColsChangeValue'";
		$up_qry.=" ,mainScrollWait=$mainScrollWait,mainScrollHeight = $mainScrollHeight,mainScrollSpeed=$mainScrollSpeed";
		$MySQL->query($up_qry);
	}
	else if($part ==3)
	{
		$up_qry = "update design set mainHitContent = '$mainHitContent'";
		$MySQL->query($up_qry);
	}
	else if($part ==4)
	{
		if(empty($mainHitGoodsIW)) $mainHitGoodsIW =0;
		if(empty($mainHitGoodsIH)) $mainHitGoodsIH =0;
		$up_qry = "update design set mainHitGoodsIW = $mainHitGoodsIW, mainHitGoodsIH = $mainHitGoodsIH";
		$MySQL->query($up_qry);
	}
	ReFresh($act.".php");
}
else if($act == "design_g")
{
	if ($part ==1)
	{
		if(!empty($img_name))
		{
			$img_info=@getimagesize($img);
			if(($img_info[2]!=1) && ($img_info[2]!=2))
			{
				MsgView("등록가능한 이미지 형식은 gif , jpg 입니다.", -1);
				exit;
			}
			else
			{
				$img_name = date("YmdHis")."_".$img_name;
				@unlink("../upload/design/$design[copyLogo]");
				@move_uploaded_file($img, "../upload/design/$img_name"); //파일복사
				@unlink($img);
			}
			$up_qry = "update design set copyLogo = '$img_name'";
			$MySQL->query($up_qry);
		}
	}
	else if ($part==2)
	{
		$MySQL->query("update design set copyBC ='$copyBC' ,copyTC ='$copyTC'");
	}
	ReFresh($act.".php");
}
else if($act == "design_wing")
{
	if ($part==3)
	{
		$up_qry = "UPDATE design SET bwinguse='$bUse',wing_width='$wing_width',today_view='$today_view'";
		$MySQL->query($up_qry);
	}
	else if($part ==1)
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
					MsgView("등록가능한 이미지 형식은 gif , jpg  , swf 입니다.", -1);
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
			$up_qry = "update banner set gubun =$gubun,siteUrl='$siteUrl_str',siteTarget='$siteTarget',goodsUrl=$goodsUrl_str where idx=$bannerIdx";
			$MySQL->query($up_qry);
		}
	}
	else if($part ==2)
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
		$up_qry.= "'$position',$gubun,'$siteUrl_str', $goodsUrl_str ";
		$up_qry.=  ",'$img_name',$banner_type,'$siteTarget')";
		$MySQL->query($up_qry);
	}
	ReFresh($act.".php?position=$position");
}
?>