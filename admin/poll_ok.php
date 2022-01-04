<?
include "head.php";
$temp_sday	= $syday.$smday.$sdday;   //시작일
$temp_eday	= $eyday.$emday.$edday;   //종료일
$sday =min($temp_sday,$temp_eday);
$eday =max($temp_sday,$temp_eday);
$chekqry = "select *from poll where (sday >= $sday and sday <= $eday) or (eday >=$sday and eday <= $eday)";
$MySQL->query($chekqry);
if($MySQL->is_affected())
{
	MsgView("날짜 중복입니다. \\n\\n기존의 등록된 설문조사를 확인하십시오.",-1);
}
else
{
	$qry = "insert into poll(sday,eday,title,answer,bPlu,reCan,gubun)values(";
	$qry.= "'$sday',";			//시작일 ex)20030101
	$qry.= "'$eday',";			//종료일 ex)20030201
	$qry.= "'$title',";			//질문
	$qry.= "'$answer_string',";	//답변 목록 ex) "예「「아니오「「무답"
	$qry.= "$bPlu,";			//복수 응답 1~10
	$qry.= "$reCan,";			//답변가능자  ex)1:회원,비회원  2:회원전용
	$qry.= "'$gubun'";
	$qry.= ")";
	if($MySQL->query($qry))
	{
		OnlyMsgView("등록완료 하였습니다.");
		ReFresh("poll_list.php");
	}
	else
	{
		ErrMsg($qry);
		ReFresh("poll_list.php");
	}
}
?>