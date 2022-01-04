<?
// 소스형상관리
// 20060714_1 소스수정 최호수 (통계 프로그램 수정으로 인한 소스 수정)
define(__INCLUDE_FUNCTION_PHP, "TRUE");
define(__POLL_ANSWER_CNT, 10);				//설문조사 답변 개수
if(!defined(__ONLY_NUM))					//숫자입력체크 스크립트
{
	define(__ONLY_NUM, "onKeyup=\"if(!Number(this.value) && this.value && this.value!='0'){ alert('숫자만 넣어주세요'); this.select(); this.focus(); return false; }\"");
}

$HAND_STR = "hand";			//핸드폰 결제의 payMethod 값  2006. 1. 24
$ALL_BGCOLOR = "#ffffff";

//구분자
$G = "」「";

//주문상태 배열			0			1		2			3			4		5
$TRADE_ARR = array("주문접수","결제확인","발송완료","수취완료","주문취소","반품처리");

//현재페이지
$__THIS_PAGE_NAME = array_pop(explode("/", $PHP_SELF));

//이전페이지
$__PRE_PAGE_NAME = array_pop(explode("/", $HTTP_REFERER));

//지역배열
$AREA_ARR = array("서울","인천","경기","강원","충남","충북","대전","경북","경남","전북","전남","대구","울산","부산","광주","제주");

//지역 이미지 배열
$AREA_ARR_MAP = array("graph_local_seoul","graph_local_inchun","graph_local_kyungi","graph_local_kang","graph_local_chungnam","graph_local_chungbuk","graph_local_deajun","graph_local_kyungbuk","graph_local_kyungnam","graph_local_junbuk","graph_local_junnam","graph_local_deagu","graph_local_woolsan","graph_local_busan","graph_local_kyungju","graph_local_jeju");

//컬러 배열
$COLOR_ARR = array("","red","orangered","orange","gold","yellow","yellowgreen","green","teal","darkcyan","skyblue","blue","mediumblue","blueviolet","purple","deeppink","fuchsia","black");

//회원가입폼 항목명 배열
$JOIN_FORM_ARR = array("회원아이디","비밀번호","비밀번호 확인","이 름","이메일","주민등록번호","전화번호","휴대폰번호","주소","--추후 사용--","메일링서비스","SMS서비스","생년월일","결혼기념일");

//회원가입폼 필수 초기화 배열 (1:필수  0:선택)
$JOIN_FORM_ARR_DEFAULT = array("1","1","1","1","0","0","0","0","0","0","0","0","0","0");

$SUB_ARR = array("상품목록","제품상세정보","이용약관","회원가입","마이페이지","장바구니","주문작성화면","","1:1문의","게시판","회사소개","이용안내","개인보호정책","제휴안내","상세검색","공지사항","결제화면","로그인");

//요일 배열
$WEEK_ARR = array("일","월","화","수","목","금","토");

$ADMIN_MENU_ARR = array("adm.php","trade_order.php","total_goods_list.php","category_manage.php","member_list.php","design.php","sale_status.php","log.php","page_add.php","notice_list.php","bbs_admin_list.php","ask.php","sms.php","admmail_main.php");
$menu_str_arr = array("기본정보","주문관리","상품관리","카테고리","회원관리","디자인","매출통계","접속통계","사용자정의페이지","공지사항","게시판","1:1문의","SMS관리","관리자메일");

$HAN_JA_ARR = array("ㄱ","ㄴ","ㄷ","ㄹ","ㅁ","ㅂ","ㅅ","ㅇ","ㅈ","ㅊ","ㅋ","ㅌ","ㅍ","ㅎ","기타");
$HAN_ARR = array("가","나","다","라","마","바","사","아","자","차","카","타","파","하");

$MBOX_NAME = array("","받은편지함","보낸편지함","임시편지함","휴지통");

//메일폼 하단 공통
$BOTTOM_HTML="<div align='center'><font color='#666666'>Copyright ⓒ $admin_row[comName] All Rights Reserved Anyquestions to <a href='mailto:$admin_row[adminEmail]'><U>$admin_row[adminEmail]</U></a> <br>공정거래 위원회에서 인증한 표준약관을 사용합니다. <br>통신판매업신고 제 $admin_row[esailNum] 호 <br>사업자등록번호 : $admin_row[comNum] 대표자 $admin_row[comCeo] <br>Tel : $admin_row[comTel], Fax : $admin_row[comFax]<br>주소 : $admin_row[comAdr] </font></div>";

//포스트 변수를 링크주소로 만듬
function PostToLink($array)
{
	if(is_array($array))
	{
		foreach($array as $key => $value)
		{
			$link_str.= $key."=".$value."&";
		}
		return Laststrcut($link_str);
	}
	else
	{
		return 0;
	}
}

//53200 원등의 숫자값을 한글 오만삼천이백원으로 변경
function PriceToHan($price)
{
	$key_arr = Array();
	$key_arr[0] = "";
	$key_arr[1] = "십";
	$key_arr[2] = "백";
	$key_arr[3] = "천";

	$position_arr = Array();
	$position_arr[0] = "원";
	$position_arr[4] = "만";
	$position_arr[8] = "억";

	$num_arr = Array();
	$num_arr[0] = "";
	$num_arr[1] = "일";
	$num_arr[2] = "이";
	$num_arr[3] = "삼";
	$num_arr[4] = "사";
	$num_arr[5] = "오";
	$num_arr[6] = "육";
	$num_arr[7] = "칠";
	$num_arr[8] = "팔";
	$num_arr[9] = "구";
	$totalM_len = strlen($price);
	$totalM_arr = Array();

	for($i=0; $i<$totalM_len; $i++)
	{
		$totalM_arr[(($totalM_len-1)-$i)] = substr($price,$i,1);
	}

	for($i=0; $i<count($totalM_arr); $i++)
	{
		$number = $totalM_arr[$i];			//1~0 숫자 추출
		$number_str = $num_arr[$number];	//이 ~ 구 문자로 추출
		//if($i != (count($totalM_arr)-1) && $number_str=="일") $number_str="";

		if($number != 0) $key_str = $key_arr[($i%4)];	//일,십,백,천 자릿수 추출 (만이던 억이던 공통의 4가지 조합)
		else $key_str = "";

		if($i>=4 && $i<=7 && $totalM_arr[4]==0 && $totalM_arr[5]==0 && $totalM_arr[6]==0 && $totalM_arr[7]==0)
		{
			//'만'은 빠져 할때가 있다 (만,십만,백만,천만이 모두 0일때) (예: 1억원이지 1억만원이 아님)
		}
		else
		{
			$position_str = $position_arr[$i];			//단위 (원,만,억)
		}
		
		if($key_arr[$i]=="백" && $number_str=="일") $number_str = "";

		$total_str = $number_str.$key_str.$position_str.$total_str;
		//echo $totalM_arr[$i]." ".$number_str." ".$key_str." ".$position_str."<br>";
	}

	return $total_str;
}

function addslashes_userfc($str)
{
	if(!get_magic_quotes_gpc())		//PHP의 magic_quotes 옵션이 Off 일때
	{
		return addslashes($str);
	}
	else
	{
		return $str;
	}
}

// NEW 아이콘  관리자가 책정한 기간내에 있으면 표시, 지났으면 표시안함
function limitday($day, $new_day)
{
	$predate = mktime(0,0,0, date('m'), date('d'), date('Y'));
	$strtime = substr(str_replace("-","",$day),0,8);
	$strtime = strtotime($strtime);
	$diff_time = $predate - $strtime;
	$limit_time = 86400 * $new_day;
	if($diff_time < $limit_time) $bNew ="<img src=upload/goods_new_img>";
	else $bNew ="";

	return $bNew;
}

// 문자열중 제일 마지막 1글자 자르기
function Laststrcut($str)
{
	$str = substr($str, 0, strlen($str)-1);

	return $str;
}

// 검색시 영어가 섞여있으면 영어만 upper적용하여 검색어 재조합
function SearchCheck($str)
{
	$str_len = strlen($str);
	$new_str = "";
	$one_str = "";

	for($i=0; $i<$str_len; $i++)
	{
		$one_str = (substr($str, $i, 1));
		if(ord($one_str) > 64 && ord($one_str) < 123) $new_str.= strtoupper($one_str);
		else $new_str.= $one_str;
	}

	return $new_str;
}

function getmicrotime()
{
	list($usec, $sec) = explode(" ", microtime());

	return (int)($usec*1000);
}

// Get 방식 변수 암호화 함수
function Encode64($data)
{
	return user_urlencode(($data));
}

function user_urlencode($str)
{
	return urlencode($str);
}

function user_urldecode($str)
{
	return urldecode($str);
}

// Get방식으로 넘어온 변수를 Decode하는 함수
function Decode64($sending_data)
{
	$sending_data = user_urldecode($sending_data);
	$vars = explode("&",(str_replace("||","",$sending_data)));
	$vars_num = count($vars);
	for($i=0; $i<$vars_num; $i++)
	{
		$elements = explode("=",$vars[$i]);
		$var[$elements[0]] = $elements[1];
	}

	return $var;
}

//상태바 표시 함수
function Status($status)
{
	echo " onMouseOver=\"javascript:window.status='$status';return true;\"";
}

// 열린창 닫고 부모창 리프레쉬
function close_par_refresh()
{
	echo "<script>self.close(); opener.location.reload();</script>";
}

// 자바스크립트 메시지 출력 함수
function MsgView($Msg, $go)
{
	echo "
		<script language='javascript'>
			alert(\"$Msg\");
			history.go($go);
		</script>
		";

		return true;
}

function OnlyMsgView($Msg)
{
	echo "
		<script language='javascript'>
			alert(\"$Msg\");
		</script>
		";
}

function MsgViewHref($Msg, $href)
{
	echo "
		<script language='javascript'>
			alert('$Msg');
			location.href='$href';
		</script>
		";

		return true;
}

function MsgViewClose($Msg)
{
	echo "
		<script language='javascript'>
			alert('$Msg');
			window.close();
		</script>
		";
}

function ErrMsg($Msg)
{
	$Msg = addslashes($Msg);
	$Msg = "Err. \\n\\n".$Msg;
	echo"
		<script language='javascript'>
			alert(\"$Msg\");
		</script>
		";
}

//$n 개의 문자열과 '...' 붙이기 함수 함수
function StringCut($string, $n)		//$n : Cutting String Number
{
	if($n%2)
		$n++;
	$len = strlen($string);		//string length
	if($len<$n)
	{
		return $string;
	}
	else
	{
		$OneNextN = $n + 1;
		$newstring = substr($string, 0, $n);
		$total = 0;
		for($i=0; $i<$n; $i++)
		{
			$asc = ord(substr($string, $i, 1));
			if($asc>128)
				$total++;
		}

		if($total%2)
		{
			$newstring = substr($string, 0, $OneNextN);
		}

		$newstring.= "...";

		return $newstring;
	}
}

//가격 출력 함수
// 1234566 -> 1,234,567
function PriceFormat($price)
{
	return number_format($price, 0);
}

function ReFresh($href)
{
	echo "<meta http-equiv='Refresh' content='0; URL=$href'>";
}

//현재시간과 특정일 사이의 기간
function BetweenPeriod($datetime, $periodDay)
{//2003-02-19 11:32:15
	$now = time();
	$timeArr = explode(":",substr($datetime,11,8));
	$dayArr = explode("-",substr($datetime,0,10));

	$mktime = mktime($timeArr[0],$timeArr[1],$timeArr[2],$dayArr[1],$dayArr[2],$dayArr[0]);
	$period = $periodDay*24*60*60;		//기간계산

	if($now >$mktime && $now < ($mktime+$period))
		return 1;
	elseif( ($mktime-$period) <$now && $now <$mktime )
		return -1;
	else
		return 0;
}

//상품확대이미지에 워터마크 입히기
function mergePix($sourcefile_id, $insertfile_id, $targetfile, $pos, $transition=100, $srcimg_type, $wmimg_type)
{
	//Get the resource id´s of the pictures

	//Get the sizes of both pix
	$sourcefile_width = imageSX($sourcefile_id);
	$sourcefile_height = imageSY($sourcefile_id);
	$insertfile_width = imageSX($insertfile_id);
	$insertfile_height = imageSY($insertfile_id);

	//middle
	if( $pos == 0 )
	{
		$dest_x = ( $sourcefile_width / 2 ) - ( $insertfile_width / 2 );
		$dest_y = ( $sourcefile_height / 2 ) - ( $insertfile_height / 2 );
	}

	//top left
	if( $pos == 1 )
	{
		$dest_x = 0;
		$dest_y = 0;
	}

	//top right
	if( $pos == 2 )
	{
		$dest_x = $sourcefile_width - $insertfile_width;
		$dest_y = 0;
	}

	//bottom right
	if( $pos == 3 )
	{
		$dest_x = $sourcefile_width - $insertfile_width;
		$dest_y = $sourcefile_height - $insertfile_height;
	}

	//bottom left
	if( $pos == 4 )
	{
		$dest_x = 0;
		$dest_y = $sourcefile_height - $insertfile_height;
	}

	//top middle
	if( $pos == 5 )
	{
		$dest_x = ( ( $sourcefile_width - $insertfile_width ) / 2 );
		$dest_y = 0;
	}

	//middle right
	if( $pos == 6 )
	{
		$dest_x = $sourcefile_width - $insertfile_width;
		$dest_y = ( $sourcefile_height / 2 ) - ( $insertfile_height / 2 );
	}

	//bottom middle
	if( $pos == 7 )
	{
		$dest_x = ( ( $sourcefile_width - $insertfile_width ) / 2 );
		$dest_y = $sourcefile_height - $insertfile_height;
	}

	//middle left
	if( $pos == 8 )
	{
		$dest_x = 0;
		$dest_y = ( $sourcefile_height / 2 ) - ( $insertfile_height / 2 );
	}

	//The main thing : merge the two pix
	imageCopyMerge($sourcefile_id, $insertfile_id,$dest_x,$dest_y,0,0,$insertfile_width,$insertfile_height,$transition);

	//Create a jpeg out of the modified picture
	if($srcimg_type == "jpg")
		imagejpeg($sourcefile_id,$targetfile,100);
	elseif($srcimg_type == "gif")
		imagegif($sourcefile_id,$targetfile,100);
}//function mergePix

//추가확대이미지에서 워터마크 생성 준비
function make_wmark($img_name, $img_info)
{
	global $targetfile;
	global $wm_type;
	global $insertfile_id;
	global $home_url;
	global $admin_row;

	$src_file = $img_name;
	$targetfile = $home_url.$img_name;

	if($img_info[2]==1)
	{
		$src_type = "gif";
		$sourcefile_id = imagecreatefromgif($home_url.$src_file);
	}
	elseif($img_info[2]==2)
	{
		$src_type = "jpg";
		$sourcefile_id = imagecreatefromjpeg($home_url.$src_file);
	}

	if($wm_type)
	{
		mergePix($sourcefile_id,$insertfile_id, $targetfile, $admin_row[wm_pos],$transition=50,$src_type,$wm_type);
	}
	else
	{
		OnlyMsgView("워터마크 이미지가 jpg,gif 가 아니거나 이미지가 없습니다.");
	}
}//function make_wmark

//해당배열내에 특정값 있는지
function array_search2($array, $str)
{
	foreach($array as $key => $value)
	{
		if($value==$str) $result = 1;
	}

	return $result;
}
?>