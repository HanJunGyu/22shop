<?
include "head.php";
if($bHtml==1) $content = $TextContent;
elseif($bHtml==2) $content = $HtmlContent;
else $content = $content;
if(empty($str_width))		$str_width			=0;		//팝업창 가로크기
if(empty($str_height))		$str_height			=0;		//팝업창 세로크기
$qry = "insert into notice(part,code,writeday,readNum,title,bBasicimg,bPopup,";
$qry.= "sday,eday,app,width,height,content,bHtml,gubun)values(";
$qry.= "'$part',";		//part ex)notice,event
$qry.= "'$code',";		//코드
$qry.= "now(),";		//등록일
$qry.= "0,";			//조회수
$qry.= "'$title',";		//제목	
$qry.= "'$bBasicimg',";
$qry.= "'$bPopup',";	//팝업여부  ex) y:사용  n:미사용
$qry.= "'$str_sday',";	//팝업 시작일 ex) 20030101
$qry.= "'$str_eday',";  //팝업 종료일 ex) 20030201
$qry.= "$bHtml,";			//HTML 적용  ex) 1:HTML 0:TEXT
$qry.= "$str_width,";	//팝업창 가로크기
$qry.= "$str_height,";	//팝업창 세로크기
$qry.= "'$content',";	//내용
$qry.= "'$bHtml',";	//내용
$qry.= "'$gubun'";
$qry.= ")";

if($MySQL->query($qry))
{
	OnlyMsgView("등록완료 하였습니다.");
	ReFresh("notice_list.php?part=$part");
}
else
{
	OnlyMsgView("등록에 문제가 발생하였습니다.");
	ReFresh("notice_list.php?part=$part");
}
?>