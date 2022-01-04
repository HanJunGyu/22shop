<?
include "head.php";
if(!empty($csv_file_name))
{
	$csv_file_info=explode(".",$csv_file_name);
	if($csv_file_info[1]!="csv")
	{
		MsgView("csv파일만 업로드 가능합니다.", -1);
		exit;
	}
	$csv_file_name = date("Ymd",time())."_".trim($csv_file_name);
	@move_uploaded_file($csv_file, "../upload/csv/$csv_file_name");	//파일복사
	@unlink($csv_file);
}
else
{
	MsgViewHref("CSV파일이 없습니다.","goods_excel.php");
	exit;
}
$url = "../upload/csv/$csv_file_name";
$array = file($url);
for($i=0;$i<count($array);$i++)
{
	if ($length < strlen($array[$i]))
	{
		$length = strlen($array[$i]);
	}
}
unset($array);
$error_occur = false;
$row = 1;
$error_row = 0;
$handle = fopen($url, "r");
while(($data = fgetcsv($handle, $length, ",")) !== FALSE)
{
	if($row == 1)	//헤더라인 제거
	{
		$row++;
	}
	elseif($row>1 && $data[1]!="")	//헤더라인 및 Null 라인 제거(상품명 필수입력이므로)
	{
		if(!$data[0]) $this_code = date("YmdHis").getmicrotime();
		else $this_code = $data[0];
		if(!$data[30]) $writeday = date("Y-m-d",time());
		else $writeday = $data[30];

		$qry = "INSERT INTO goods SET ";
		$qry.="code='".addslashes($this_code)."',";				//상품코드
		$qry.="name='".addslashes($data[1])."',";				//상품명
		$qry.="price='".addslashes($data[2])."',";				//판매가
		$qry.="bOldPrice='".addslashes($data[3])."',";			//시중가 사용여부
		$qry.="oldPrice='".addslashes($data[4])."',";			//시중가
		$qry.="point='".addslashes($data[5])."',";				//적립금
		$qry.="bCompany='".addslashes($data[6])."',";			//제조/판매원 사용여부
		$qry.="company='".addslashes($data[7])."',";			//제조/판매원
		$qry.="bOrigin='".addslashes($data[8])."',";			//원산지 사용여부
		$qry.="origin='".addslashes($data[9])."',";				//원산지
		$qry.="bLimit='".addslashes($data[10])."',";			//재고형태 구분
		$qry.="limitCnt='".addslashes($data[11])."',";			//재고수량
		$qry.="bHit='".addslashes($data[12])."',";				//HIT 이미지 사용여부
		$qry.="bNew='".addslashes($data[13])."',";				//NEW 이미지 사용여부
		$qry.="bEtc='".addslashes($data[14])."',";				//기타 이미지 사용여부
		$qry.="partName1='".addslashes($data[15])."',";			//상품옵션1
		$qry.="partName2='".addslashes($data[16])."',";			//상품옵션2
		$qry.="partName3='".addslashes($data[17])."',";			//상품옵션3
		$qry.="strPart1='".addslashes($data[18])."',";			//상품옵션 문자열1
		$qry.="strPart2='".addslashes($data[19])."',";			//상품옵션 문자열2
		$qry.="strPart3='".addslashes($data[20])."',";			//상품옵션 문자열3
		$qry.="img1='".addslashes($data[21])."',";				//작은이미지
		$qry.="img2='".addslashes($data[22])."',";				//큰이미지
		$qry.="img3='".addslashes($data[23])."',";				//확대이미지[1]
		$qry.="img4='".addslashes($data[24])."',";				//확대이미지[2]
		$qry.="img5='".addslashes($data[25])."',";				//확대이미지[3]
		$qry.="img6='".addslashes($data[26])."',";				//확대이미지[4]
		$qry.="img7='".addslashes($data[27])."',";				//확대이미지[5]
		$qry.="img8='".addslashes($data[28])."',";				//확대이미지[6]
		$qry.="content='".addslashes($data[29])."',";			//제품상세정보
		$qry.="writeday='".addslashes($writeday)."',";			//상품등록날짜
		$qry.="readCnt='".addslashes($data[31])."',";			//상품조회수
		$qry.="setVal='".addslashes($data[32])."',";			//상품진열순위
		$qry.="category='".addslashes($data[33])."',";			//카테고리코드
		$qry.="detailimg1='".addslashes($data[34])."',";		//상세이미지1
		$qry.="detailimg2='".addslashes($data[35])."',";		//상세이미지2
		$qry.="detailimg3='".addslashes($data[36])."',";		//상세이미지3
		$qry.="detailimg4='".addslashes($data[37])."',";		//상세이미지4
		$qry.="margin='".addslashes($data[38])."',";			//상품마진
		$qry.="supplyprice='".addslashes($data[39])."',";		//공급가
		$qry.="meta_str='".addslashes($data[40])."',";			//검색키워드
		$qry.="chango='".addslashes($data[41])."',";			//창고지/진열대정보
		$qry.="quality='".addslashes($data[42])."',";			//제품성능설정
		$qry.="model='".addslashes($data[43])."',";				//모델명
		$qry.="trans_content=''";								//배송관련 정보 : 공백문자열 입력으로 초기화

		if ($MySQL->query($qry))
		{
			$row++;		//성공시 입력건 카운트 증가
			echo $row." | ".$this_code."<br>";
		}
		else
		{
			echo "쿼리에러 발생!!! 엑셀파일 내용이 올바른지 확인 바랍니다<BR> : $qry <BR>";
			$error_occur = true;
			$error_row++;
		}
	}//if
}//while
fclose($handle);

if($error_occur)
{
	echo $error_row." 건의 입력 에러가 발생하였습니다.<p>";
	echo "<a href='goods_excel.php'>엑셀등록 페이지로 이동하기</a>";
}
else
{
	MsgViewHref(($row-2)." 건 완료하였습니다.","goods_excel.php");
}
?>