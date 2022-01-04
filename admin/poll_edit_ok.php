<?
include "head.php";
$dataArr=Decode64($data);
if($del)
{
	$MySQL->query("delete from poll where idx =$dataArr[idx]");
	ReFresh("poll_list.php");
}
else
{
	$temp_sday	= $syday.$smday.$sdday;   //시작일
	$temp_eday	= $eyday.$emday.$edday;   //종료일
	$sday =min($temp_sday,$temp_eday);
	$eday =max($temp_sday,$temp_eday);
	//날짜중복 체크
	$chekqry = "select *from poll where ((sday >= $sday and sday <= $eday) or (eday >=$sday and eday <= $eday)) ";
	$chekqry.= " and idx<>$dataArr[idx]";
	$MySQL->query($chekqry);
	if($MySQL->is_affected())
	{
		MsgView("날짜 중복입니다. \\n\\n기존의 등록된 설문조사를 확인하십시오.",-1);
	}
	else
	{
		$qry = "update poll set ";
		$qry.= "sday	= '$sday',";
		$qry.= "eday	= '$eday',";
		$qry.= "title	= '$title',";
		$qry.= "answer	= '$answer_string',";
		$qry.= "bPlu	= $bPlu,";
		$qry.= "reCan	= $reCan, ";
		$qry.= "gubun	= '$gubun' ";
		$qry.= " where idx=$dataArr[idx]";
		if($MySQL->query($qry))
		{
			OnlyMsgView("수정완료 하였습니다.");
			ReFresh("poll_view.php?data=$data");
		}
		else
		{
			ErrMsg($qry);
			ReFresh("poll_edit.php?data=$data");
		}
	}
}
?>