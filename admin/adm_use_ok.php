<?
include "head.php";
if($editVar=="mapImg")
{
	if(!empty($mapImg_name))
	{
		$mapImgInfo=@getimagesize($mapImg);		//회사 지도 이미지 정보
		if(($mapImgInfo[2]!=1) && ($mapImgInfo[2]!=2)) MsgView("이미지 형식을 gif , jpg 로 입력해 주세요", -1);
		else
		{
			$mapImgName ="shop_map_img";
			if(file_exists("../upload/$mapImgName")) unlink("../upload/$mapImgName");
			@copy($mapImg, "../upload/$mapImgName");
			unlink($mapImg);
			@$MySQL->query("update admin set useShopmap=$useShopmap");
			ReFresh("adm_use.php");
		}
	}
	else
	{
		@$MySQL->query("update admin set useShopmap=$useShopmap");
		ReFresh("adm_use.php");
	}
}
else
{
	//개인보호정책,쇼핑몰이용약관,가입약관,회사소개 수정
	$content = ${$editVar};
	$content = addslashes_userfc($content);
	$qry = "update admin set ";
	$qry.= "$editVar   = '$content',";
	$qry.= $editVar."_bhtml = ".${$editVar."_bhtml"};
	if($MySQL->query($qry))
	{
		OnlyMsgView("수정완료 하였습니다.");
		ReFresh("adm_use.php");
	}
	else
	{
		ErrMsg($qry);
		ReFresh("adm_use.php");
	}
}
?>