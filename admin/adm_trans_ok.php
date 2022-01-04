<?
include "head.php";
if ($part==1)
{
	if(empty($bTrans))		$bTrans				=0;		//배송비 사용여부
	if(empty($noTrans))		$noTrans		=0;		//무료배송 적용금액
	if(empty($transMoney))		$transMoney		=0;		//배송비
	if(empty($chakbul)) 		$chakbul=0;
	if($transCom2) $transCom = $transCom2;

	$qry = "update admin set ";
	$qry.= "bTrans		= $bTrans,";				//배송비 사용여부
	$qry.= "noTrans		= $noTrans,";			//무려배송 적용금액
	$qry.= "transMoney	= $transMoney,";		//배송비
	$qry.= "transCom    = '$transCom', ";		//기본배송회사
	$qry.= "chakbul    = $chakbul, ";
	$qry.= "trans_etc    = '$trans_etc', ";
	$qry.= "trans_content    = '$trans_content', ";
	$qry.= "trans_goodname    = '$trans_goodname', ";
	$qry.= "bTransmethod    = '$bTransmethod', ";
	$qry.= "method_1    = '$method_1', ";
	$qry.= "method_2    = '$method_2', ";
	$qry.= "method_3    = '$method_3', ";
	$qry.= "trans_com_url    = '$trans_com_url' ";

	if($MySQL->query($qry))
	{
		OnlyMsgView("수정완료 하였습니다.");
	}
	else
	{
		ErrMsg($qry);
	}
}
else if ($part==2)
{
	$qry = "INSERT INTO trans_add (addr,first_zip,last_zip,transP) values(";
	$qry.= "'$addr',";
	$qry.= "'$first_zip',";
	$qry.= "'$last_zip',";
	$qry.= "$transP";
	$qry.= ")";
	if($MySQL->query($qry))
	{
		OnlyMsgView("등록완료 하였습니다.");
	}
	else
	{
		ErrMsg($qry);
	}
}
else if ($part==3)
{
	$qry = "update trans_add set ";
	$qry.= "addr='$addr',";
	$qry.= "first_zip='$first_zip',";
	$qry.= "last_zip='$last_zip',";
	$qry.= "transP=$transP";
	$qry.= " where idx=$idx";
	if($MySQL->query($qry))
	{
		OnlyMsgView("수정완료 하였습니다.");
	}
	else
	{
		ErrMsg($qry);
	}
}
else if ($part==4)
{
	$qry = "DELETE from trans_add WHERE idx=$idx ";
	if($MySQL->query($qry))
	{
		OnlyMsgView("삭제완료 하였습니다.");
	}
	else
	{
		ErrMsg($qry);
	}
}
ReFresh("adm_trans.php");
?>