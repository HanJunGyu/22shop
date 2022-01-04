<?
include "head.php";
$dataArr= Decode64($data);
if($del)
{
	$qry = "delete from notice where idx=$dataArr[idx]";
	if($MySQL->query($qry))
	{
		$file_result = $MySQL->query("select *from up_file where code='$code'");
		while($file_row = mysql_fetch_array($file_result))
		{
			@unlink("../upload/notice/$file_row[name]");
		}
		$del_qry = "delete from up_file where code = '$code'";
		if($MySQL->query($del_qry))
		{
			OnlyMsgView("삭제완료 하였습니다.");
			ReFresh("notice_list.php?part=$part");
		}
		else
		{
			ErrMsg("파일삭제, 디비삭제실패 : $del_qry");
			ReFresh("notice_edit.php?data=$data&part=$part");
		}
	}
	else
	{
		ErrMsg($qry);
		ReFresh("notice_edit.php?data=$data&part=$part");
	}
}
else
{
	if(empty($str_width))		$str_width			=0;		//팝업창 가로크기
	if(empty($str_height))		$str_height			=0;		//팝업창 세로크기
	if($bHtml==1) $content = $TextContent;
	elseif($bHtml==2) $content = $HtmlContent;
	else $content = $content;
	if($bHtml==1) $app = 0;
	elseif($bHtml==2) $app = 1;
	else $app = 1;
	$qry = "update notice set ";
	$qry.= "title	='$title',";		//제목
	$qry.= "bPopup	='$bPopup',";		//팝업여부  ex) y:사용  n:미사용
	$qry.= "bBasicimg='$bBasicimg',";		//팝업 기본틀여부  ex) y:사용  n:미사용
	$qry.= "sday	='$str_sday',";		//팝업 시작일 ex) 20030101
	$qry.= "eday	='$str_eday',";		//팝업 종료일 ex) 20030201
	$qry.= "app		=$app,";			//HTML 적용  ex) 1:HTML 0:TEXT
	$qry.= "width	=$str_width,";		//팝업창 가로크기
	$qry.= "height	=$str_height,";		//팝업창 세로크기
	$qry.= "content	='$content',";		//내용
	$qry.= "bHtml	='$bHtml',";		//내용
	$qry.= "gubun	='$gubun'"; // 회원,거래처 구분 
	$qry.= " where idx=$dataArr[idx]";
	if($MySQL->query($qry))
	{
		OnlyMsgView("등록완료 하였습니다.");
		ReFresh("notice_edit.php?data=$data&part=$part");
	}
	else
	{
		ErrMsg($qry);
		ReFresh("notice_edit.php?data=$data&part=$part");
	}
}
?>