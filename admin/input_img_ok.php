<?
include "head.php";
if(!empty($delIdx))
{
	$infoRow = $MySQL->fetch_array("select *from up_file where idx=$delIdx");
	@unlink("../upload/$part/$infoRow[name]");
	if($MySQL->query("delete from up_file where idx=$delIdx"))
	{
		ReFresh("input_img.php?code=$code&part=$part");
	}
	else
	{
		ErrMsg("delete query Err.");
	}
}
else
{
	$upfileInfo=@getimagesize($file);		//공지사항 관련 이미지 정보
	if(($upfileInfo[2]!=1) && ($upfileInfo[2]!=2)) MsgView("이미지 형식을 gif , jpg 로 입력해 주세요", -1);
	else
	{
		$upfileName = $file_name;
		if(file_exists("../upload/$part/$upfileName"))
		{
			MsgView("동일 이름의 이미지가 현재 존재합니다. \\n\\n다른 이름으로 등록해 주십시오.\\n\\n파일명 : $upfileName",-1);
		}
		else
		{
			@copy($file, "../upload/$part/$upfileName");
			unlink($file);
			if($MySQL->query("insert into up_file(code,name)values('$code','$upfileName')"))
			{
				OnlyMsgView("업로드 완료 하였습니다.");
				ReFresh("input_img.php?code=$code&part=$part");
			}
			else ErrMsg("insert Err.");
		}
	}
}
?>