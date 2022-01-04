<?
include "head.php";
if (!empty($postcode) && $postcode!="none")
{
	if(!empty($postcode_name))
	{
		$postcode_info=explode(".",$postcode_name);
		if($postcode_info[1]!="txt")
		{
			MsgView("txt파일만 업로드 가능합니다.", -1);
			exit;
		}
		$postcode_name = str_replace(" ","",$postcode_name);
		@move_uploaded_file($postcode, "../upload/csv/$postcode_name"); //파일복사
		@unlink($postcode);
	}
	// 탭으로 분리된 우편번호 txt파일 DB입력
	$url = "../upload/csv/$postcode_name";
	$fp = fopen($url,"r");
	$arr=array();
	$cnt = 0 ;
	$buf ="";
	$str ="";
	$MySQL->query("TRUNCATE table postzip");
	$zip_cnt=0;
	while(!feof($fp))
	{
		$buf = fgets($fp); // 한라인을 읽음 
		$arr = explode("\t",$buf); // , 로 분리
		if ($zip_cnt>0)
		{
			if ($arr[0]) // NULL 값인 레코드 (맨마지막)는 입력안함 
			{
				$etc = $arr[4]." ".$arr[5]." ".$arr[6]." ".$arr[7]." ";
				$zip = $arr[0];
				$qry="INSERT INTO postzip (zip,city,goo,dong,etc) values ('$zip','$arr[1]','$arr[2]','$arr[3]','$etc')";
				if ($MySQL->query($qry))
				{
				}
				else echo $qry."<br>";
			}
		}
		$zip_cnt++;
	}
	if($MySQL->articles("select *from postzip limit 1"))
	{
		MsgViewHref("완료하였습니다.","adm_etc2.php");
	}
	else
	{
		MsgViewHref("우편번호 갱신에 실패하였습니다.","adm_etc2.php");
	}
	unlink($url.$postcode_file);
	exit;
}
else
{
	if(empty($good_cipher))	$good_cipher =1;
	if(empty($bStamp))	$bStamp =0;

	$qry = "update admin set ";
	$qry.= "bPersonask			= $bPersonask,";
	$qry.= "bTrade				= $bTrade,";
	$qry.= "bStamp				= $bStamp,  ";
	$qry.= "bGdset				= '$bGdset',  ";
	$qry.= "bMouseRB			= '$bMouseRB'  ";

	if($MySQL->query($qry))
	{
		OnlyMsgView("수정완료 하였습니다.");
		ReFresh("adm_etc2.php");
	}
	else
	{
		ErrMsg($qry);
		ReFresh("adm_etc2.php");
	}
}
?>