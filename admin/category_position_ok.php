<?
include "head.php";
$codeArr = explode("-",$strCode);				//카테고리 코드 배열
$poArr	 = explode("-",$strPosition);			//카테고리 순위 배열
for($i=0;$i<count($codeArr);$i++)
{
	$cate_row = $MySQL->fetch_array("select *from category where code='$codeArr[$i]'");
	$positionArr[$i] = $cate_row[position];		//부모카테고리 현재 포지션 배열
}
$inv_poArr		 = array_flip($poArr);          //순위,키 바꿈
$sum_position =0;
for($i=0;$i<count($poArr);$i++)
{
	$inv_Index = $inv_poArr[$i]; 
	if($i==0) $__START = $positionArr[0];					//현재 카테고리 포지션 시작값 설정
	else	  $__START = $sum_position;
	$sum_position =$__START+1;		//다음 카테고리 포지션 시작값 설정
	$diver =$__START - $positionArr[$inv_Index];			// 포지션 변화값 
	//카테고리 모두 포지션 변경
	$MySQL->query("update category set position=position +$diver where code='$codeArr[$inv_Index]'");
}
if(empty($parentcode))
{
	ReFresh("category_position.php");
}
else
{
	ReFresh("category_position.php?parentcode=$parentcode");
}
?>