<?
include "head.php";

/*------------------------공지사항 수정,삭제 ---------------------------------*/
$dataArr= Decode64($data);
$tel	= $tel1."-".$tel2."-".$tel3;		//주문자
$hand	= $hand1."-".$hand2."-".$hand3;		
$zip	= $zip1."-".$zip2;					
$rtel	= $rtel1."-".$rtel2."-".$rtel3;		//배송지
$rhand	= $rhand1."-".$rhand2."-".$rhand3;
$rzip	= $rzip1."-".$rzip2;

$qry = "update trade set ";
$qry.= "name = '$name',";
$qry.= "tel = '$tel',";
$qry.= "hand = '$hand',";
$qry.= "zip = '$zip',";
$qry.= "adr1 = '$adr1',";
$qry.= "adr2 = '$adr2',";
$qry.= "email = '$email',";
$qry.= "rname = '$rname',";
$qry.= "rtel = '$rtel',";
$qry.= "rhand = '$rhand',";
$qry.= "rzip = '$rzip',";
$qry.= "radr1 = '$radr1',";
$qry.= "radr2 = '$radr2',";
$qry.= "remail = '$remail',";
$qry.= "content = '$content',";
$qry.= "manaContent = '$manaContent' ";
$qry.= "where idx=$dataArr[idx]";

if($MySQL->query($qry))
{
	ReFresh("trade_order_view.php?data=$data");
}
else
{
	echo"Err. : $qry";
}
?>