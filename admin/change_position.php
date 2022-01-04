<?
include "head.php";
$dataArr[idx]=$idx;
$goods_row = $MySQL->fetch_array("SELECT * from goods WHERE idx=$dataArr[idx] limit 1");
if(empty($category))
{
	if($del)
	{
		$up_qry = "DELETE from position WHERE idx=$dataArr[idx]";
	}
	else	// 추가 
	{
		if ($MySQL->articles("SELECT idx from position WHERE part='$part'"))
		{
			$po_row = $MySQL->fetch_array("SELECT *from position WHERE part='$part' order by sunwi desc");
		}
		if (empty($po_row[sunwi])) $po_row[sunwi]=0;
		$new_sunwi = $po_row[sunwi]+1;
		$up_qry = "INSERT INTO position values('','','$part',$goods_row[idx],$new_sunwi)";
	}
	if($MySQL->query($up_qry))
	{
		if($del)
		{
			ReFresh("goods_position.php?position=$position&part=$part");
		}
		else
		{
			echo"<script language='javascript'>
			parent.opener.location.href='goods_position.php?position=$position&part=$part';
			parent.location.href='goods_total.php?position=$position&part=$part';
			alert('추가되었습니다.');
			</script>";
		}
	}
	else
	{
		echo"Err. : $up_qry";
	}
}
else
{
	$cate_row = $MySQL->fetch_array("select *from category where code='$category'");
	if($del)
	{
		$up_qry = "DELETE from position where idx=$dataArr[idx]";
		if($MySQL->query($up_qry))
		{
			ReFresh("goods_position.php?position=$position&category=$category&part=$part");
		}
		else
		{
			echo"Err. : $up_qry";
		}
	}
	else	// 등록
	{
		$po_row = $MySQL->fetch_array("SELECT *from position WHERE part='$part' and category='$category' order by sunwi desc");
		if (!isset($po_row)) $po_row[sunwi]=0;
		$new_sunwi = $po_row[sunwi]+1;
		$up_qry = "INSERT INTO position values('','$category','$part',$goods_row[idx],$new_sunwi)";
		if($MySQL->query($up_qry))
		{
			echo"<script language='javascript'>
			parent.opener.location.href='goods_position.php?position=$position&category=$category&part=$part';
			parent.location.href='goods_total.php?position=$position&category=$category&part=$part&code=$category';
			alert('추가되었습니다.');
			</script>";
		}
		else
		{
			echo"Err. : $up_qry";
		}
	}
}
?>