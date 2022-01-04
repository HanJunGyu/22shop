<?
include "head.php";
?>
<form name="viewForm" method="post">
<input type="hidden" name="sort" value="<?=$sort?>"><!-- 정렬방법 ex)asc:오름차순  desc:내림차순 -->
<input type="hidden" name="sortStr" value="<?=$sortStr?>"><!-- 정렬기준 ex)name:이름  price:가격 -->
<input type="hidden" name="position" value="<?=$view_position?>"><!-- 위치 -->
<input type="hidden" name="data" value="<?=$data?>">
<input type="hidden" name="returnPage" value="<?=$returnPage?>"><!-- 목록파일명 -->
<input type="hidden" name="code" value="<?=$code?>"><!-- 카테고리 코드 -->
</form>
<?
if(!defined(__ADMIN_ROW))
{
	define(__ADMIN_ROW,"TRUE");
	$admin_row=$MySQL->fetch_array("select *from admin limit 0,1");//관리자정보
}
if(!$bHtml) $content = $TextContent;
elseif($bHtml==2) $content = $HtmlContent;
else $content = $content;
$GD_SET = $admin_row[bGdset];

$SCRIPT_FILENAME_ARR = explode("admin",$_SERVER["SCRIPT_FILENAME"]);
$host = $SCRIPT_FILENAME_ARR[0];
if (substr($host,-1)=="/") $host = Laststrcut($host);
if (substr($admin_row[shopUrl],-1)=="/") $admin_row[shopUrl] = Laststrcut($admin_row[shopUrl]);
$home_url = $host."/upload/goods/";
$http_url = "http://$admin_row[shopUrl]"."/upload/goods/";
if ($bWmark=="y")
{
	$wm_info = getimagesize("../upload/watermark_img");
	$wm_file = "/upload/watermark_img";
	$targetfile = $home_url.$src_file;
	if ($wm_info[2]==2)
	{
		$wm_type = "jpg";
		$insertfile_id = ImageCreateFromJPEG($host.$wm_file);
	}
	else if ($wm_info[2]==1)
	{
		$wm_type = "gif";
		$insertfile_id = ImageCreateFromGIF($host.$wm_file);
	}
	else $wm_type="";
}
$dataArr = Decode64($data);
$goods_row = $MySQL->fetch_array("select *from goods where idx='$dataArr[idx]' limit 1");  //상품정보
include "linkstr_goods.php";
if ($listedit)
{
	$qry="UPDATE goods SET ";
	if ($limitCnt || $limitCnt>=0) $qry.=" limitCnt=$limitCnt,";
	if (isset($bHit)) $qry.=" bHit='$bHit',";
	if (isset($bEtc)) $qry.=" bEtc='$bEtc',";
	$qry.=" margin = '$margin',point = '$point',supplyprice = '$supplyprice', price='$pricebox' ,bLimit = '$bLimit',size='$size',editday=now(),lastprice=$goods_row[price] WHERE idx=$goods_row[idx]";
	if ($goods_row[price] != $pricebox) // 가격이 바뀌었을시  관심품목 업데이트 
	{
		$num = $MySQL->articles("SELECT idx from interest WHERE goodsIdx=$goods_row[idx]");
		if($num)
		{
			if ($MySQL->query("UPDATE interest SET price=$pricebox,point=$point WHERE goodsIdx=$goods_row[idx]"))
			{
				OnlyMsgView("현재 이상품을 관심품목으로 담고있는 $num 개의 가격,적립금이 수정되었습니다.");
			}
		}
	}
	if ($MySQL->query($qry))
	{
		OnlyMsgView("수정되었습니다.");
	}
	exit;
}
// LIST 상에서 전체선택 삭제
if ($selectAll_del)
{
	$str = Laststrcut($str);
	$str_arr = explode("/",$str);
	if (count($str_arr)<2) $str_arr[0] = $str;
	for ($i=0; $i<count($str_arr); $i++)
	{
		$goods_row = $MySQL->fetch_array("SELECT * from goods WHERE idx=$str_arr[$i] limit 1");
		if ($goods_row[idx])
		{
			$img1= "../upload/goods/$goods_row[img1]";
			$img2= "../upload/goods/$goods_row[img2]";
			$img3= "../upload/goods/$goods_row[img3]";
			$img4= "../upload/goods/$goods_row[img4]";
			$img5= "../upload/goods/$goods_row[img5]";
			$img6= "../upload/goods/$goods_row[img6]";
			$img7= "../upload/goods/$goods_row[img7]";
			$img8= "../upload/goods/$goods_row[img8]";
			@unlink($img1);
			@unlink($img2);
			@unlink($img3);
			@unlink($img4);
			@unlink($img5);
			@unlink($img6);
			@unlink($img7);
			@unlink($img8);
			$detailimg1= "../upload/goods/$goods_row[detailimg1]";
			$detailimg2= "../upload/goods/$goods_row[detailimg2]";
			$detailimg3= "../upload/goods/$goods_row[detailimg3]";
			$detailimg4= "../upload/goods/$goods_row[detailimg4]";
			@unlink($detailimg1);
			@unlink($detailimg2);
			@unlink($detailimg3);
			@unlink($detailimg4);
			$MySQL->query("DELETE from position where goodsIdx=$goods_row[idx]");
			$MySQL->query("DELETE from compare where goodsIdx=$goods_row[idx]");
			$MySQL->query("DELETE from goods WHERE idx=$str_arr[$i]");
		}
	}
	OnlyMsgView("삭제 완료하였습니다.");
	Refresh($returnPage."?$LINK_STR");
	exit;
}
// LIST 상에서 선택상품 판매가 일괄변경
if ($price_change)
{
	$succ_cnt = 0;
	$str = Laststrcut($str);
	$str_arr = explode("/",$str);
	if (count($str_arr)<2) $str_arr[0] = $str;
	for ($i=0; $i<count($str_arr); $i++)
	{
		$goods_row = $MySQL->fetch_array("SELECT *from goods WHERE idx=$str_arr[$i] limit 1");
		$price = $goods_row[price];
		$change = round($goods_row[price] * $price_percent * 0.01);
		if ($price_change=="up") $price = $price + $change;
		else if ($price_change=="dn") $price = $price - $change;
		if ($bPoint_stop=="y") { $POINT_QRY = ""; }
		else  ////////// 적립금도 반영할때 /////////// 
		{
			if($admin_row[poMethod]!="t")
			{
				$point = round($price * $admin_row[poUnit] * 0.01);
				$POINT_QRY = ",point = $point";
			}
		}
		$qry = "UPDATE goods SET price=$price $POINT_QRY WHERE idx=$goods_row[idx]";
		if ($MySQL->query($qry))
		{
			$succ_cnt++;
		}
	}
	OnlyMsgView("가격수정 $succ_cnt 건 완료하였습니다.");
	Refresh("total_goods_list.php?$LINK_STR");
	exit;
}
if ($codeedit)
{
	if ($MySQL->query("UPDATE goods SET code='$code', editday=now() WHERE idx=$goods_row[idx]"))
	{
		MsgViewHref("코드를 수정하였습니다.","goods_edit.php?data=$data&returnPage=$returnPage&$LINK_STR");
	}
	else
	{
		MsgViewHref("코드수정에 문제가 발생하였습니다.","goods_edit.php?data=$data&returnPage=$returnPage&$LINK_STR");
	}
	exit;
}
if ($imgdel) // 추가확대이미지 삭제
{
	$img = "img$img_num";
	$img_url = "../upload/goods/$goods_row[$img]";
	@unlink($img_url);
	$MySQL->query("UPDATE goods SET $img = '' WHERE idx=$dataArr[idx]");
	echo"<script language='javascript'>
	function Auto_Submit()
	{
		alert('삭제완료 하였습니다.');
		document.viewForm.action='goods_edit.php?$LINK_STR';
		document.viewForm.submit();
	}
	</script>
	<body onload='Auto_Submit()'></body>";
	exit;
}
if ($detailimgdel) // 상세정보이미지 삭제
{
	$img = "detailimg$img_num";
	$img_url = "../upload/goods/$goods_row[$img]";
	@unlink($img_url);
	$MySQL->query("UPDATE goods SET $img = '', editday=now() WHERE idx=$dataArr[idx]");
	echo"<script language='javascript'>
	function Auto_Submit()
	{
		alert('삭제완료 하였습니다.');
		document.viewForm.action='goods_edit.php?$LINK_STR';
		document.viewForm.submit();
	}
	</script>
	<body onload='Auto_Submit()'></body>";
	exit;
}
if($del)
{
	$img1= "../upload/goods/$goods_row[img1]";
	$img2= "../upload/goods/$goods_row[img2]";
	$img3= "../upload/goods/$goods_row[img3]";
	$img4= "../upload/goods/$goods_row[img4]";
	$img5= "../upload/goods/$goods_row[img5]";
	$img6= "../upload/goods/$goods_row[img6]";
	$img7= "../upload/goods/$goods_row[img7]";
	$img8= "../upload/goods/$goods_row[img8]";
	@unlink($img1);
	@unlink($img2);
	@unlink($img3);
	@unlink($img4);
	@unlink($img5);
	@unlink($img6);
	@unlink($img7);
	@unlink($img8);
	$detailimg1= "../upload/goods/$goods_row[detailimg1]";
	$detailimg2= "../upload/goods/$goods_row[detailimg2]";
	$detailimg3= "../upload/goods/$goods_row[detailimg3]";
	$detailimg4= "../upload/goods/$goods_row[detailimg4]";
	@unlink($detailimg1);
	@unlink($detailimg2);
	@unlink($detailimg3);
	@unlink($detailimg4);
	if($MySQL->articles("SELECT *from position WHERE goodsIdx=$goods_row[idx]"))
	{
		$up_qry = "DELETE from position WHERE goodsIdx=$goods_row[idx]";
		$MySQL->query($up_qry);
	}
	$qry = "delete from goods where idx=$dataArr[idx]";
	if($MySQL->query($qry))
	{
		OnlyMsgView("삭제완료 하였습니다.");
		$MySQL->query("DELETE from compare where goodsIdx=$dataArr[idx]"); // 비교상품 테이블에서도 해당상품 삭제 
		ReFresh($returnPage."?code=$code&$LINK_STR");
	}
	else
	{
		echo"Err. : $qry";
	}
}
else
{
	if(empty($price))			$price =0;
	if(empty($bOldPrice))		$bOldPrice=0;
	if(empty($str_oldPrice))	$str_oldPrice =0;
	if(empty($point))			$point=0;
	if(empty($bCompany))		$bCompany=0;
	if(empty($bOrigin))			$bOrigin =0;
	if(empty($bLimit))			$bLimit=0;
	if(empty($str_limitCnt))	$str_limitCnt=0;
	if(empty($bHit))			$bHit =0;
	if(empty($bNew))			$bNew =0;
	if(empty($bEtc))			$bEtc =0;
	if(empty($bHtml))			$bHtml=0;
	if(empty($img_onetoall))		$img_onetoall=0;
	if(empty($bSaleper))			$bSaleper=0; // 할인률 사용자 표시여부 
	if(empty($sale))			$sale=0; // 할인률 
	if(empty($margin))			$margin=0;
	if(empty($supplyprice))			$supplyprice=0;
	if (strlen($month)==1) $month = "0".$month;
	if (strlen($month2)==1) $month2 = "0".$month2;
	if (strlen($day)==1) $day = "0".$day;
	if (strlen($day2)==1) $day2 = "0".$day2;
	if(!empty($img1_name))
	{
		$img1_info=@getimagesize($img1);		//이미지1 정보
		if(($img1_info[2]!=1) && ($img1_info[2]!=2))
		{
			MsgView("이미지1 형식을 gif , jpg 로 입력해 주세요", -1);
			exit;
		}
		$img1_name ="a".substr(time(),5,5)."_".$img1_name;	
		@move_uploaded_file($img1, "../upload/goods/$img1_name"); //파일복사
		@unlink($img1);
		@unlink("../upload/goods/$goods_row[img1]");		//본이미지 삭제
		$MySQL->query("update goods set img1= '$img1_name' where idx=$dataArr[idx]");
	}
	if(!empty($img2_name))
	{
		$img2_info=@getimagesize($img2);		//이미지2 정보
		if(($img2_info[2]!=1) && ($img2_info[2]!=2))
		{
			MsgView("이미지2 형식을 gif , jpg 로 입력해 주세요", -1);
			exit;
		}
		$img2_name ="b".substr(time(),5,5)."_".$img2_name;
		@move_uploaded_file($img2, "../upload/goods/$img2_name"); //파일복사
		@unlink($img2);
		@unlink("../upload/goods/$goods_row[img2]");        //본이미지 삭제
		$MySQL->query("update goods set img2= '$img2_name' where idx=$dataArr[idx]");
	}
	if(!empty($img3_name))
	{
		$img3_info=@getimagesize($img3);		//이미지3 정보
		if(($img3_info[2]!=1) && ($img3_info[2]!=2))
		{
			MsgView("이미지3 형식을 gif , jpg 로 입력해 주세요", -1);
			exit;
		}
		$img3_name ="c".substr(time(),5,5)."_".$img3_name;	
		@move_uploaded_file($img3, "../upload/goods/$img3_name"); //파일복사
		@unlink($img3);
		@unlink("../upload/goods/$goods_row[img3]");		//본이미지 삭제
		$MySQL->query("update goods set img3= '$img3_name' where idx=$dataArr[idx]");
	}
	if(!empty($img4_name))
	{
		$img4_info=@getimagesize($img4);
		if(($img4_info[2]!=1) && ($img4_info[2]!=2))
		{
			MsgView("확대이미지[2] 형식을 gif , jpg 로 입력해 주세요", -1);
			exit;
		}
		$img4_name ="d".substr(time(),5,5)."_".$img4_name;
		@move_uploaded_file($img4, "../upload/goods/$img4_name"); //파일복사
		//////////워터마크 삽입 사용시////////// 
		if ($bWmark=="y")
		{
			make_wmark($img4_name,$img4_info);
		}
		@unlink($img4);
		@unlink("../upload/goods/$goods_row[img4]");		//본이미지 삭제
		$MySQL->query("update goods set img4= '$img4_name' where idx=$dataArr[idx]");
	}
	if(!empty($img5_name))
	{
		$img5_info=@getimagesize($img5);
		if(($img5_info[2]!=1) && ($img5_info[2]!=2))
		{
			MsgView("확대이미지[3] 형식을 gif , jpg 로 입력해 주세요", -1);
			exit;
		}
		$img5_name ="e".substr(time(),5,5)."_".$img5_name;
		@move_uploaded_file($img5, "../upload/goods/$img5_name"); //파일복사
		//////////워터마크 삽입 사용시////////// 
		if ($bWmark=="y")
		{
			make_wmark($img5_name,$img5_info);
		}
		@unlink($img5);
		@unlink("../upload/goods/$goods_row[img5]");		//본이미지 삭제
		$MySQL->query("update goods set img5= '$img5_name' where idx=$dataArr[idx]");
	}
	if(!empty($img6_name))
	{
		$img6_info=@getimagesize($img6);
		if(($img6_info[2]!=1) && ($img6_info[2]!=2))
		{
			MsgView("확대이미지[4] 형식을 gif , jpg 로 입력해 주세요", -1);
			exit;
		}
		$img6_name ="f".substr(time(),5,5)."_".$img6_name;	
		@move_uploaded_file($img6, "../upload/goods/$img6_name"); //파일복사
		//////////워터마크 삽입 사용시////////// 
		if ($bWmark=="y")
		{
			make_wmark($img6_name,$img6_info);
		}
		@unlink($img6);
		@unlink("../upload/goods/$goods_row[img6]");		//본이미지 삭제
		$MySQL->query("update goods set img6= '$img6_name' where idx=$dataArr[idx]");
	}
	if(!empty($img7_name))
	{
		$img7_info=@getimagesize($img7);
		if(($img7_info[2]!=1) && ($img7_info[2]!=2))
		{
			MsgView("확대이미지[5] 형식을 gif , jpg 로 입력해 주세요", -1);
			exit;
		}
		$img7_name ="g".substr(time(),5,5)."_".$img7_name;
		@move_uploaded_file($img7, "../upload/goods/$img7_name"); //파일복사
		//////////워터마크 삽입 사용시////////// 
		if ($bWmark=="y")
		{
			make_wmark($img7_name,$img7_info);
		}
		@unlink($img7);
		@unlink("../upload/goods/$goods_row[img7]");		//본이미지 삭제
		$MySQL->query("update goods set img7= '$img7_name' where idx=$dataArr[idx]");
	}
	if(!empty($img8_name))
	{
		$img8_info=@getimagesize($img8);
		if(($img8_info[2]!=1) && ($img8_info[2]!=2))
		{
			MsgView("확대이미지[6] 형식을 gif , jpg 로 입력해 주세요", -1);
			exit;
		}
		$img8_name ="h".substr(time(),5,5)."_".$img8_name;	
		@move_uploaded_file($img8, "../upload/goods/$img8_name"); //파일복사
		//////////워터마크 삽입 사용시////////// 
		if ($bWmark=="y")
		{
			make_wmark($img8_name,$img8_info);
		}
		@unlink($img8);
		@unlink("../upload/goods/$goods_row[img8]");		//본이미지 삭제
		$MySQL->query("update goods set img8= '$img8_name' where idx=$dataArr[idx]");
	}
	if(!empty($detailimg1_name))
	{
		$detailimg1_info=@getimagesize($detailimg1);
		if(($detailimg1_info[2]!=1) && ($detailimg1_info[2]!=2))
		{
			MsgView("상세이미지[1] 형식을 gif , jpg 로 입력해 주세요", -1);
			exit;
		}
		$detailimg1_name ="h".substr(time(),5,5)."_".$detailimg1_name;	
		@move_uploaded_file($detailimg1, "../upload/goods/$detailimg1_name"); //파일복사
		@unlink($detailimg1);
		@unlink("../upload/goods/$goods_row[detailimg1]");		//본이미지 삭제
		$MySQL->query("update goods set detailimg1= '$detailimg1_name' where idx=$dataArr[idx]");
	}
	if(!empty($detailimg2_name))
	{
		$detailimg2_info=@getimagesize($detailimg2);
		if(($detailimg2_info[2]!=1) && ($detailimg2_info[2]!=2))
		{
			MsgView("상세이미지[2] 형식을 gif , jpg 로 입력해 주세요", -1);
			exit;
		}
		$detailimg2_name ="h".substr(time(),5,5)."_".$detailimg2_name;	
		@move_uploaded_file($detailimg2, "../upload/goods/$detailimg2_name"); //파일복사
		@unlink($detailimg2);
		@unlink("../upload/goods/$goods_row[detailimg2]");		//본이미지 삭제
		$MySQL->query("update goods set detailimg2= '$detailimg2_name' where idx=$dataArr[idx]");
	}
	if(!empty($detailimg3_name))
	{
		$detailimg3_info=@getimagesize($detailimg3);
		if(($detailimg3_info[2]!=1) && ($detailimg3_info[2]!=2))
		{
			MsgView("상세이미지[3] 형식을 gif , jpg 로 입력해 주세요", -1);
			exit;
		}
		$detailimg3_name ="h".substr(time(),5,5)."_".$detailimg3_name;	
		@move_uploaded_file($detailimg3, "../upload/goods/$detailimg3_name"); //파일복사
		@unlink($detailimg3);
		@unlink("../upload/goods/$goods_row[detailimg3]");		//본이미지 삭제
		$MySQL->query("update goods set detailimg3= '$detailimg3_name' where idx=$dataArr[idx]");
	}
	if(!empty($detailimg4_name))
	{
		$detailimg4_info=@getimagesize($detailimg4);
		if(($detailimg4_info[2]!=1) && ($detailimg4_info[2]!=2))
		{
			MsgView("상세이미지[4] 형식을 gif , jpg 로 입력해 주세요", -1);
			exit;
		}
		$detailimg4_name ="h".substr(time(),5,5)."_".$detailimg4_name;	
		@move_uploaded_file($detailimg4, "../upload/goods/$detailimg4_name"); //파일복사
		@unlink($detailimg4);
		@unlink("../upload/goods/$goods_row[detailimg4]");		//본이미지 삭제
		$MySQL->query("update goods set detailimg4= '$detailimg4_name' where idx=$dataArr[idx]");
	}
	$name = addslashes_userfc(trim($name));
	$meta_str = addslashes_userfc(trim($meta_str));
	$content = addslashes_userfc(trim($content));
	$company = addslashes_userfc($company);
	if (strlen($sale)>3) $sale=0;
	$qry = "update goods set ";
	$qry.= "margin		= $margin,";
	$qry.= "bSaleper	= $bSaleper,";
	$qry.= "sale		= $sale,";
	$qry.= "setVal		= $setVal,";				//상품진열 우선순위 ex)1~10		
	$qry.= "price		= $price,";					//가격
	$qry.= "bOldPrice	= $bOldPrice,";				//시중가사용 ex)1:사용  0:미사용
	$qry.= "oldPrice	= $str_oldPrice,";			//시중가
	$qry.= "point		= $point,";					//적립금
	$qry.= "name		= '$name',";				//상품명
	$qry.= "bCompany	= $bCompany,";				//제조사사용 ex)1:사용  0:미사용
	$qry.= "company		= '$company',";			//제조사
	$qry.= "bOrigin		= $bOrigin,";				//원산지사용 ex)1:사용  0:미사용
	$qry.= "origin		= '$origin',";			//원산지
	$qry.= "bLimit		= $bLimit,";				//재고수량사용 ex)1:사용  0:미사용
	$qry.= "limitCnt	= $str_limitCnt,";			//재고수량
	$qry.= "bHit		= $bHit,";					//hit 이미지사용	ex)1:사용  0:미사용
	$qry.= "bNew		= $bNew,";					//new 이미지사용  ex)1:사용  0:미사용
	$qry.= "bEtc		= $bEtc,";					//etc 이미지사용  ex)1:사용  0:미사용
	$qry.= "partName1	= '$partName1',";			//
	$qry.= "partName2	= '$partName2',";			//속성명  ex)'색깔','사이즈',....
	$qry.= "partName3	= '$partName3',";			//
	$qry.= "strPart1	= '$strPart1',";			//
	$qry.= "strPart2	= '$strPart2',";			//속성   ex)노랑」「빨강」「파랑」「검정
	$qry.= "strPart3	= '$strPart3',";			//
	$qry.= "bHtml		= $bHtml,";					//상품상세 정보 html사용  1:사용  0:미사용
	$qry.= "content		= '$content',";				//상품상세 정보
	$qry.= "img_onetoall	= $img_onetoall,";
	$qry.= "supplyprice	= $supplyprice,";
	$qry.= "meta_str	= '$meta_str',";	
	$qry.= "editday	= now(),";	
	$qry.= "size	= '$size',";	
	$qry.= "model	= '$model',";	
	$qry.= "chango	= '$chango',";	
	$qry.= "quality	= '$quality',";	
	$qry.= "bWmark	= '$bWmark',";	
	$qry.= "minbuyCnt	= '$minbuyCnt',";	
	$qry.= "maxbuyCnt	= '$maxbuyCnt',";
	$qry.= "trans_content	= '$trans_content'";
	$qry.= " where idx=$dataArr[idx]";
	if($MySQL->query($qry))
	{
		OnlyMsgView("수정완료 하였습니다.");
		if ($goods_row[price] != $price) // 가격이 바뀌었을시  
		{
			if($MySQL->articles("SELECT idx from interest WHERE goodsIdx=$dataArr[idx]"))
			{
				$num = $MySQL->articles("SELECT idx from interest WHERE goodsIdx=$dataArr[idx]");
				if ($MySQL->query("UPDATE interest SET price=$price,point=$point WHERE goodsIdx=$dataArr[idx]"))
				{
					OnlyMsgView("현재 이상품을 관심품목으로 담고있는 $num 개의 가격,적립금이 수정되었습니다.");
				}
			}
		}

		if ($img_onetoall && $GD_SET=="y")
		{
			if ($img3_name) // 이미지3이 교체될때 1,2,3 GD설정 
			{
				if(!defined(__DESIGN_GOODS_ROW))
				{
					define(__DESIGN_GOODS_ROW,"TRUE");
					$design_goods=$MySQL->fetch_array("select *from design_goods limit 0,1");
				}
				$GDIMG1_WIDTH = $design_goods[gdimg1_width];
				$GDIMG1_HEIGHT = $design_goods[gdimg1_height];
				$GDIMG2_WIDTH = $design_goods[gdimg2_width];
				$GDIMG2_HEIGHT = $design_goods[gdimg2_height];
				if (!$GDIMG1_WIDTH) $GDIMG1_WIDTH = 100;
				if (!$GDIMG1_HEIGHT) $GDIMG1_HEIGHT = 100;
				if (!$GDIMG2_WIDTH) $GDIMG2_WIDTH = 240;
				if (!$GDIMG2_HEIGHT) $GDIMG2_HEIGHT = 240;
				$src_file = $img3_name;
				
				//100사이즈 
				$tmp_src = explode(".",$src_file);
				$tmp_src[0] = "gd_".$tmp_src[0];
				$dst_file = join(".",$tmp_src);
				
				//240 사이즈 
				$tmp_src = explode(".",$src_file);
				$tmp_src[0] = "gd240_".$tmp_src[0];
				$dst_file240 = join(".",$tmp_src);
				
				if ($tmp_src[1] == "jpg" || $tmp_src[1] == "JPG")
				{
					if ($bWmark=="y")
					{
						$sourcefile_id = ImageCreateFromJPEG($home_url.$src_file);
						$targetfile = $home_url.$src_file;
						if ($wm_type)
						{
							mergePix($sourcefile_id,$insertfile_id, $targetfile, $admin_row[wm_pos],$transition=50,"jpg",$wm_type);
						}
						else
						{
							OnlyMsgView("워터마크 이미지가 jpg,gif 가 아니거나 이미지가 없습니다.");
						}
					}
					$src = imagecreatefromjpeg($home_url.$src_file); 
					$dst = imagecreatetruecolor($GDIMG1_WIDTH, $GDIMG1_HEIGHT); //GD 2.0
					$dst240 = imagecreatetruecolor($GDIMG2_WIDTH, $GDIMG2_HEIGHT); //GD 2.0
					ImageColorAllocate($dst, 255, 255, 255); 
					ImageColorAllocate($dst240, 255, 255, 255); 
					imagecopyresampled($dst, $src, 0, 0, 0, 0, $GDIMG1_WIDTH, $GDIMG1_HEIGHT, imagesx($src), imagesy($src)); //GD 2.0 이상 
					imagejpeg($dst, $home_url.$dst_file, 100);
					ImageDestroy($dst);
					imagecopyresampled($dst240, $src, 0, 0, 0, 0, $GDIMG2_WIDTH, $GDIMG2_HEIGHT, imagesx($src), imagesy($src)); //GD 2.0 이상 
					imagejpeg($dst240, $home_url.$dst_file240, 100);
					ImageDestroy($dst240);
					ImageDestroy($src);
				}
				else if ($tmp_src[1] == "gif" || $tmp_src[1] == "GIF")
				{
					if ($bWmark=="y")
					{
						$sourcefile_id = ImageCreateFromGIF($home_url.$src_file);
						$targetfile = $home_url.$src_file;
						if ($wm_type)
						{
							mergePix($sourcefile_id,$insertfile_id, $targetfile, $admin_row[wm_pos],$transition=50,"gif",$wm_type);
						}
						else
						{
							OnlyMsgView("워터마크 이미지가 jpg,gif 가 아니거나 이미지가 없습니다.");
						}
					}
					$src = ImageCreateFromGIF($home_url.$src_file);
					$dst = imagecreatetruecolor($GDIMG1_WIDTH, $GDIMG1_HEIGHT); //GD 2.0
					$dst240 = imagecreatetruecolor($GDIMG2_WIDTH, $GDIMG2_HEIGHT); //GD 2.0
					ImageColorAllocate($dst, 255, 255, 255); 
					ImageColorAllocate($dst240, 255, 255, 255);
					imagecopyresampled($dst, $src, 0, 0, 0, 0, $GDIMG1_WIDTH, $GDIMG1_HEIGHT, imagesx($src), imagesy($src)); //GD 2.0 이상 
					imagegif($dst, $home_url.$dst_file, 100);
					imagecopyresampled($dst240, $src, 0, 0, 0, 0, $GDIMG2_WIDTH, $GDIMG2_HEIGHT, imagesx($src), imagesy($src)); //GD 2.0 이상 
					imagegif($dst240, $home_url.$dst_file240, 100); 
					ImageDestroy($dst); 
					ImageDestroy($dst240);
					ImageDestroy($src); 
				}
				$qry ="UPDATE goods SET img1='$dst_file',img2='$dst_file240' WHERE code='$goodcode'";
				if ($MySQL->query($qry))
				{
					unlink("../upload/goods/$goods_row[img1]");        //본이미지 삭제
					unlink("../upload/goods/$goods_row[img2]");        //본이미지 삭제
				}
			}
		}
		echo"<script language='javascript'>
		function Auto_Submit()
		{
			document.viewForm.action='goods_edit.php?$LINK_STR';
			document.viewForm.submit();
		}
		</script>
		<body onload='Auto_Submit()'></body>";
	}
	else
	{
		echo "$qry";
	}
}
?>