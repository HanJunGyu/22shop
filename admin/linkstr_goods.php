<?
// 검색링크문자열 생성
if($search) $LINK_STR.="search=$search&";
if($searchstring) $LINK_STR.="searchstring=$searchstring&";
if($search_category)  $LINK_STR.="search_category=$search_category&"; 
if($etc)
{
	if($etc=="sp_search") $LINK_STR.="etc=sp_search&";
	else if($etc=="delay")  $LINK_STR.="etc=delay&";
	else if($etc=="stock") $LINK_STR.="etc=stock&";
}
if($size) $total_qry.="size=$size&";
if($best) $LINK_STR.="best=1" ;
if($hit) $LINK_STR.="hit=1" ;
if($new) $LINK_STR.="new=1" ;
// 검색링크문자열 생성 끝
?>