<?
include "head.php";
if(!defined(__ADMIN_ROW))
{
	define(__ADMIN_ROW,"TRUE");
	$admin_row=$MySQL->fetch_array("select *from admin limit 0,1");
}
if($part=="copy2")
{
	if ($change_code) $new_ca = $change_code;//대상 카테고리코드
	$str = Laststrcut($str);
	$str_arr = explode("/",$str);
	if (count($str_arr)<2) $str_arr[0] = $str;
	for ($j=0; $j<count($str_arr); $j++)
	{
		if ($str_arr[$j])
		{
			$this_code = date("YmdHis").getmicrotime();
			$goods_row = $MySQL->fetch_array("SELECT *from goods WHERE idx=$str_arr[$j] limit 1");
			for($z=1; $z<9; $z++)
			{
				$img = $goods_row["img".$z];
				if(is_file("../upload/goods/".$img))
				{
					$arrimg=explode(".", $img);
					${"newimg".$z} = $z.date("YmdHis").$str_arr[$j].".".array_pop($arrimg);
					copy("../upload/goods/".$img, "../upload/goods/".${"newimg".$z});
				}
			}
			for($z=1; $z<5; $z++)
			{
				$detailimg = $goods_row["detailimg".$z];
				if(is_file("../upload/goods/".$detailimg))
				{
					$arrdetailimg=explode(".", $detailimg);
					${"newdetailimg".$z} = date("YmdHis").$str_arr[$j].$z.".".array_pop($arrdetailimg);
					copy("../upload/goods/".$detailimg, "../upload/goods/".${"newdetailimg".$z});
				}
			}
			$qry = "INSERT INTO goods (code, name, price, bOldPrice, oldPrice, point, bCompany, company, bOrigin, origin, bLimit, limitCnt, bHit, bNew, bEtc, partName1, partName2, partName3, strPart1, strPart2, strPart3, img1, img2, img3, bHtml, content, writeday, position, readCnt, setVal, category, optionPriceName, optionPriceStr, img4, img5, img6, img7, img8, editday, relation, img_onetoall, detailimg1, detailimg2, detailimg3, detailimg4, sale, bSaleper, margin, supplyprice, meta_str, size, lastprice, model, chango, bWmark, quality, minbuyCnt, maxbuyCnt, trans_content) select '$this_code', name, price, bOldPrice, oldPrice, point, bCompany, company, bOrigin, origin, bLimit, limitCnt, bHit, bNew, bEtc, partName1, partName2, partName3, strPart1, strPart2, strPart3, '$newimg1', '$newimg2', '$newimg3', bHtml, content, writeday, '0|0|0|0|0|0|0', '0', setVal, '$new_ca', optionPriceName, optionPriceStr, '$newimg4', '$newimg5', '$newimg6', '$newimg7', '$newimg8', editday, relation, img_onetoall, '$newdetailimg1', '$newdetailimg2', '$newdetailimg3', '$newdetailimg4', sale, bSaleper, margin, supplyprice, meta_str, size, lastprice, model, chango, bWmark, quality, minbuyCnt, maxbuyCnt, trans_content from goods where idx=$str_arr[$j]";
			if (!$MySQL->query($qry)) echo "$qry";
		}
	}
	OnlyMsgView("복사를 완료 하였습니다.");
	ReFresh("total_goods_list.php?code=$new_ca");
}
?>