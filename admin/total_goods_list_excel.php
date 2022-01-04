<?
session_start();
$date = date("Ymd");
$time = date("His");
$f_name = "goods".$date."_".$time.".xls";
header( "Content-type: application/vnd.ms-excel; charset=ks_c_5601-1987");
header( "Content-Disposition: attachment; filename=$f_name");
header( "Content-Description: PHP4 Generated Data");
include "../lib/config.php";
include "../lib/function.php";
if(!defined(__ADMIN_ROW))
{
	define(__ADMIN_ROW,"TRUE");
	$admin_row=$MySQL->fetch_array("select *from admin limit 0,1");	//관리자 정보 배열
}
$EXCEL_STR = "<table><tr><td>상품코드</td><td>카테고리</td><td>상품명</td><td>모델명</td><td>제조사</td><td>원산지</td><td>재고상태</td><td>매입가</td><td>부가세</td><td>운송비</td><td>PG수수료</td><td>매입원가</td><td>판매가</td><td>마진율</td><td>상품이미지1</td><td>상품이미지2</td><td>상품이미지3</td><td>확대이미지1</td><td>확대이미지2</td><td>확대이미지3</td><td>확대이미지4</td><td>확대이미지5</td><td>상세이미지1</td><td>상세이미지2</td><td>상세이미지3</td><td>상세이미지4</td><td>상세설명</td><td>등록일</td><td>비고</td></tr></table>";
include "linkstr_goods.php";
$CATE_SEARCH_STR =" and category='$search_category' ";
//특정위치 Url 링크설정
///////////////////	0		  1			 2		    3	 //////////
$postrArr = Array("전체","메인 베스트","메인 히트","메인 신규");
// 카테고리 정보 
$data=Decode64($data);
$pagecnt=$data[pagecnt];
$letter_no=$data[letter_no];
$offset=$data[offset];
$new_str = SearchCheck($searchstring); // 검색어를 영문만 대문자로 바꾼 문자열
if(!$searchstring)
{			//검색
	$search=$data[search];
	$searchstring=$data[searchstring];
}
if($searchstring)
{//검색
	if($search=="price")
	{			//가격검색
	$searchLen = (strlen($searchstring) -1)*-1;		//가격 반올림설정
	$searchstring = round($searchstring,$searchLen);
	$total_qry ="select * from goods where truncate(price,$searchLen) = $searchstring ";
	}
	else
	{				//일반검색
		$total_qry.="select * from goods where ($search like '%$searchstring%' or upper($search) like '%$new_str%') $MALL_STR";
	}
}
else
{
	$total_qry ="select *from goods where 1=1 $MALL_STR ";
}
if($search_category)  $total_qry.=" $CATE_SEARCH_STR ";
if($etc)
{
	if($etc=="delay")  $total_qry.=" and delay=1 ";
	else if($etc=="stock") $total_qry.=" and ((bLimit=1 and limitCnt=0) or (bLimit=2)) ";
}
//////////메인페이지 특정위치///////////// 
if($best) $total_qry = "select goods.* from goods,position where goods.idx=position.goodsIdx and position.part='mainbest' ";
if($hit) $total_qry = "select goods.* from goods,position where goods.idx=position.goodsIdx and position.part='mainhit' ";
if($new) $total_qry = "select goods.* from goods,position where goods.idx=position.goodsIdx and position.part='mainnew' ";//order by position.sunwi asc

$numresults=@$MySQL->query($total_qry);
$numrows=mysql_num_rows($numresults);				//총 레코드수
$goods_qry = $total_qry." order by idx desc";
$goods_result=@$MySQL->query($goods_qry);
$s_letter=$letter_no;								//페이지별 시작 글번호
while($goods_row=mysql_fetch_array($goods_result))
{
	$encode_str = "idx=".$goods_row[idx]."&pagecnt=".$pagecnt."&letter_no=".$s_letter."&offset=".$offset;
	$encode_str.= "&search=".$search."&searchstring=".$searchstring."&present_num=".$letter_no;
	$data=Encode64($encode_str);
	///////////////카테고리 정보////////////////////
	$cate[0]="";
	$cate_row = $MySQL->fetch_array("select name from category where code='$goods_row[category]' limit 1");
	$cate[0] = $cate_row[name];
	/////////////재고상태////////////////// 
	if ($goods_row[bLimit]==0) $limitCnt="무제한";
	else if ($goods_row[bLimit]==1) $limitCnt="제한";
	else if ($goods_row[bLimit]==2) $limitCnt="품절";
	else if ($goods_row[bLimit]==3) $limitCnt="보류";
	else if ($goods_row[bLimit]==4) $limitCnt="단종";
	///////////////가격//////////////// 
	$price = $goods_row[price];	
	///////////////공급가//////////////// 
	if($goods_row[supplyprice]) $sprice = $goods_row[supplyprice];
	else		         $sprice = 0;

	$VAT = $sprice * 0.01;
	/////////////배송비/////////////
	if(empty($admin_row[bTrans]) && empty($admin_row[chakbul]))			{$transM = 0;	$transMstr = "무료"; }	//배송비미사용
	else if(empty($admin_row[bTrans]) && $admin_row[chakbul])			{$transM = 0;   $transMstr = "착불"; }	//배송비미사용&착불 
	else $transM = $admin_row[transMoney];
	/////////////참조상품있는지/////////
	$PG = $admin_row[pg_rate];
	//////////////매입원가//////////////// 공급가 + 부가세 + 배송비 * PG수수료 
	$real_sprice = round(($sprice + $VAT + $transM) * (1 + ($PG * 0.01))); 
	$EXCEL_STR ="<table><tr><td>$goods_row[code]</td>";
	$EXCEL_STR.="<td>$cate[0]</td>";
	$EXCEL_STR.="<td>$goods_row[name]</td>";
	$EXCEL_STR.="<td>$goods_row[model]</td>";
	$EXCEL_STR.="<td>$goods_row[company]</td>";
	$EXCEL_STR.="<td>$goods_row[origin]</td>";
	$EXCEL_STR.="<td>$limitCnt</td>";
	$EXCEL_STR.="<td>$sprice</td>";	 
	$EXCEL_STR.="<td>$VAT</td>";
	$EXCEL_STR.="<td>$transM</td>";
	$EXCEL_STR.="<td>$PG</td>";
	$EXCEL_STR.="<td>$real_sprice</td>";
	$EXCEL_STR.="<td>$price</td>";
	$EXCEL_STR.="<td>$goods_row[margin]</td>";
	$EXCEL_STR.="<td>http://$admin_row[shopUrl]/upload/goods/$goods_row[img1]</td>"; 
	$EXCEL_STR.="<td>http://$admin_row[shopUrl]/upload/goods/$goods_row[img2]</td>"; 
	$EXCEL_STR.="<td>http://$admin_row[shopUrl]/upload/goods/$goods_row[img3]</td>"; 
	$EXCEL_STR.="<td>http://$admin_row[shopUrl]/upload/goods/$goods_row[img4]</td>"; 
	$EXCEL_STR.="<td>http://$admin_row[shopUrl]/upload/goods/$goods_row[img5]</td>"; 
	$EXCEL_STR.="<td>http://$admin_row[shopUrl]/upload/goods/$goods_row[img6]</td>"; 
	$EXCEL_STR.="<td>http://$admin_row[shopUrl]/upload/goods/$goods_row[img7]</td>"; 
	$EXCEL_STR.="<td>http://$admin_row[shopUrl]/upload/goods/$goods_row[img8]</td>"; 
	$EXCEL_STR.="<td>http://$admin_row[shopUrl]/upload/goods/$goods_row[detailimg1]</td>"; 
	$EXCEL_STR.="<td>http://$admin_row[shopUrl]/upload/goods/$goods_row[detailimg2]</td>"; 
	$EXCEL_STR.="<td>http://$admin_row[shopUrl]/upload/goods/$goods_row[detailimg3]</td>"; 
	$EXCEL_STR.="<td>http://$admin_row[shopUrl]/upload/goods/$goods_row[detailimg4]</td>"; 
	$EXCEL_STR.="<td>".htmlspecialchars($goods_row[content])."</td>";
	$EXCEL_STR.="<td>$goods_row[writeday]</td></tr></table>";
	echo $EXCEL_STR;
}//while
?>