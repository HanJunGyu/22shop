<?
// 한글을 찍기위한 아스키값과 str2uni 함수가 들어있는 파일
include ("hangul.php");


// ==============================================================================
// =========================  원 그래프 함수 ====================================
// ==============================================================================

// $result : 숫자로 된 배열값
// $file_name : gif 로 만들어낼 파일이름
// $print_name : $result 값과 같이 찍어낼 '서울', '인천' 과 같은 문자 => 기본값 빈문자
// $imgSize : 이미지 사이즈	=> 기본값 250
function Circle_Graph($result, $file_name, $print_name="", $imgSize, $nameArr)
{
	// 원의크기
	$circleSize = $imgSize - 50;

	// 그림을 그리기위해 이미지사이즈와 색을 결정한다.
	$myImage = ImageCreate($imgSize, $imgSize);

	$white = ImageColorAllocate($myImage, 255, 255, 255);
	$black = ImageColorAllocate($myImage, 0, 0, 0);
	$gray = ImageColorAllocate($myImage, 204, 204, 204);

	// 칠할 색상 20가지를 미리 정해놓는다.
	$fillColor[0] = ImageColorAllocate($myImage, 255, 102, 0);		//주황  , 다음
	$fillColor[3] = ImageColorAllocate($myImage, 102, 102, 204);	//파랑 , 엠파스
	$fillColor[2] = ImageColorAllocate($myImage, 255, 204, 0);		//노랑  , 야후
	$fillColor[1] = ImageColorAllocate($myImage, 102, 204, 102);	//녹색 , 네이버

	$fillColor[4] = ImageColorAllocate($myImage, 255, 102, 153);
	$fillColor[5] = ImageColorAllocate($myImage, 102, 153, 255);
	$fillColor[6] = ImageColorAllocate($myImage, 255, 204, 153);
	$fillColor[7] = ImageColorAllocate($myImage, 153, 204, 153);
	$fillColor[8] = ImageColorAllocate($myImage, 230, 56, 19);
	$fillColor[9] = ImageColorAllocate($myImage, 102, 51, 204);
	$fillColor[10] = ImageColorAllocate($myImage, 213, 213, 0);
	$fillColor[11] = ImageColorAllocate($myImage, 51, 204, 0);
	$fillColor[12] = ImageColorAllocate($myImage, 204, 51, 102);
	$fillColor[13] = ImageColorAllocate($myImage, 51, 0, 255);
	$fillColor[14] = ImageColorAllocate($myImage, 255, 204, 204);
	$fillColor[15] = ImageColorAllocate($myImage, 102, 204, 204);
	$fillColor[16] = ImageColorAllocate($myImage, 153, 153, 153);
	$fillColor[17] = ImageColorAllocate($myImage, 0, 102, 153);
	$fillColor[18] = ImageColorAllocate($myImage, 204, 102, 255);
	$fillColor[19] = ImageColorAllocate($myImage, 153, 204, 102);

	// 랜덤함수를 초기화 한다.
	srand(time());

	// 만약 넘어온 배열변수가 여기서 미리 정해놓은 색상의 배열보다
	// 크다면 랜덤함수를 이용해 부족한 만큼 색상을 만들어낸다.
	if(sizeof($result)>sizeof($fillColor))
	{
		for($i=0; $i<(sizeof($result)-sizeof($fillColor)); $i++)
		{
			$fillValue1 = rand(0,255);
			$fillValue2 = rand(0,255);
			$fillValue3 = rand(0,255);

			$fillColor[20+$i] = ImageColorAllocate($myImage, $fillValue1, $fillValue2, $fillValue3);
		}
	}

	// 넘어온 값들의 총합을 구한다.
	for($i=0; $i<sizeof($result); $i++)
	{
		$sum = $sum + $result[$i];
	}

	$AngleForDraw[-1]=0;

	// 각 배열값들의 퍼센테이지와 차지하는 각도 그리고
	// 원의 영역을 그리기 위한 끝각도를 구한다.
	for($i=0; $i<sizeof($result); $i++)
	{
		if ($result[$i]) $percent[$i] = ($result[$i]/$sum)*100;	// 백분율을 구한다.
		else $percent[$i]=0;
		$Angle[$i] = $percent[$i]*3.6;			// 원에서 차지할 각도를 구한다.
		$AngleForDraw[$i] = $Angle[$i] + $AngleForDraw[$i-1];	// 영역을 그리기 위해 그려질 끝의 각도를 구한다.
	}

	// 그림을 그리기위해 필요한 좌표값을 구한다.
	for($i=0; $i<count($Angle); $i++)
	{
		// 조각을 내고 호를 그리기 위한 계산
		$radians = $AngleForDraw[$i] / 57.295779513082;			// 도수형식을 라디안으로 변환.
		$lineLength = $imgSize/2 - 25;
		$x2[$i] = $imgSize/2 + ($lineLength * cos($radians));	// x 좌표값을 구한다.
		$y2[$i] = $imgSize/2 + ($lineLength * sin($radians));	// y 좌표값을 구한다.

		// 색상을 칠하고 글자가 놓일 좌표 계산
		$fillAngle = $AngleForDraw[$i] - ($Angle[$i]/2);
		$fillradians = $fillAngle / 57.295779513082;			// 도수형식을 라디안으로 변환.
		$fillpoint = $imgSize/3;
		$fillx2[$i] = $imgSize/2 + ($fillpoint * cos($fillradians));	// 색상을 칠하고 , 글자가 놓여질 x,y 좌표값
		$filly2[$i] = $imgSize/2 + ($fillpoint * sin($fillradians));
	}

	// 원과 분류선을 그린다.
	// int imageline (int im, int x1, int y1, int x2, int y2, int col)
	// int imagearc (int im, int cx, int cy, int w, int h, int s, int e, int col)

	for($i=0; $i<count($Angle); $i++)
	{
		ImageLine($myImage, $imgSize/2, $imgSize/2, $x2[$i], $y2[$i], $gray);
		Imagearc($myImage, $imgSize/2, $imgSize/2, $circleSize, $circleSize, $AngleForDraw[$i-1] , $AngleForDraw[$i], $gray);
	}

	// 색상을 채운다.
	// int imagefill (int im, int x, int y, int col)

	for($i=0; $i<count($Angle); $i++)
	{
		ImageFill($myImage,$fillx2[$i], $filly2[$i] , $fillColor[$i]);
	}

	// 글자를 입힌다.
	for($i=0; $i<count($Angle); $i++)
	{
		$cutting = round($percent[$i], 2);		// 글자의 소수 2 자리까지
		$print = $print_name[$i] . " " . $result[$i] . " (" . $cutting . "%" . ")" ;	// 찍어낼 글자

		// 원을 중심으로 글을 찍어낼 위치설정
		// 한글을 찍기위해서는 ImageTTFText 를 사용하여야 하고
		// 또한 위에서 include 한 hangul.php 가 필요하다.
		// 이 파일에는 여기서 쓰이는 str2uni() 함수가 들어있다.
		if($filly2[$i]>($imgSize/2))
		{
			//ImageTTFText($myImage,12,0,$fillx2[$i]-40,$filly2[$i]-15,$black,"hangul.ttf",str2uni($print));
		}
		else
		{
			//ImageTTFText($myImage,12,0,$fillx2[$i]-30,$filly2[$i]+15,$black,"hangul.ttf",str2uni($print));
		}
	}

	/////////////////////////////////////////////////
	// 이미지를 출력하고, 이미지 핸들러를 삭제한다.
	/////////////////////////////////////////////////

	// 만들어낸 이미지를 gif 파일로 만들어낸다.
	Imagegif($myImage,$file_name);
	Imagedestroy($myImage);

	////// 함수에 기능추가  1 ~ 4 위까지 해당 항목이름과 색깔을 출력 /////
	echo "<p>";

	for($i=0; $i<count($nameArr); $i++)
	{
		$nameImage = ImageCreate(30,30);		// 추가소스 , 이름 색상이미지
		$fillColor_name[0] = ImageColorAllocate($nameImage, 255, 102, 0);
		$fillColor_name[3] = ImageColorAllocate($nameImage, 102, 102, 204);
		$fillColor_name[2] = ImageColorAllocate($nameImage, 255, 204, 0);
		$fillColor_name[1] = ImageColorAllocate($nameImage, 102, 204, 102);
		//ImageFill($nameImage,0,30, $fillColor_name[$i]);
		ImageFilledRectangle($nameImage, 0,0, 30, 30, $fillColor_name[$i]);
		Imagejpeg($nameImage,"../upload/nameImage$i.jpg");
		Imagedestroy($nameImage);
		echo $nameArr[$i]." : <img src='../upload/nameImage$i.jpg'> ".$result[$i]."% &nbsp;&nbsp;&nbsp;	";
	}
	echo "</p>";
}// function End.


// ==============================================================================
// =========================  선 그래프 함수 ====================================
// ==============================================================================

// data : 값을 가진 변수
// data_name : 값에 대한 이름
// file_name : 이미지를 저장할 파일 이름
// x_size : 이미지 가로크기
// y_size : 이미지 세로크기
// dot_num : 그래프에 찍을 점선개수
// color : 막대선의 색상, 1~20까지 정해져있다.

function Line_Graph($data, $data_name, $file_name, $x_size=400, $y_size=300, $dot_num=4, $color=15)
{
	$x_axis = $x_size - 80;		// 그래프를 그릴 영역을 구한다
	$y_axis = $y_size - 60;

	for($i=0; $i<sizeof($data); $i++)
	{
		$sum += $data[$i];
	}

	$first_gap = ($x_axis/sizeof($data))/2;					// 첫막대가 그려질 위치
	$print_gap = $first_gap / 5;							// 막대와 막대의 간격
	$line_width = ($x_axis-2*$first_gap-2*$print_gap)/sizeof($data);	// 막대의 폭

	for($i=0; $i<sizeof($data); $i++)
	{
		$line_rate[$i] = number_format(($data[$i]/$sum)*100,1);				// 막대들의 비율
		$line_height[$i] = number_format(($line_rate[$i]/100)*$y_axis,1);	// 막대의 길이
	}

	// 이미지를 생성한다.
	$image = ImageCreate($x_size,$y_size);

	$white = ImageColorAllocate($image , 255,255,255);
	$gray = ImageColorAllocate($image , 227,227,227);
	$dark_gray = ImageColorAllocate($image , 190,190,190);
	$black = ImageColorAllocate($image , 0,0,0);

	// 칠할 색상 20가지를 미리 정해놓는다.
	$fillColor[0] = ImageColorAllocate($image, 255, 102, 0);
	$fillColor[1] = ImageColorAllocate($image, 102, 102, 204);
	$fillColor[2] = ImageColorAllocate($image, 255, 204, 0);
	$fillColor[3] = ImageColorAllocate($image, 102, 204, 102);
	$fillColor[4] = ImageColorAllocate($image, 255, 102, 153);
	$fillColor[5] = ImageColorAllocate($image, 102, 153, 255);
	$fillColor[6] = ImageColorAllocate($image, 255, 204, 153);
	$fillColor[7] = ImageColorAllocate($image, 153, 204, 153);
	$fillColor[8] = ImageColorAllocate($image, 230, 56, 19);
	$fillColor[9] = ImageColorAllocate($image, 102, 51, 204);
	$fillColor[10] = ImageColorAllocate($image, 213, 213, 0);
	$fillColor[11] = ImageColorAllocate($image, 51, 204, 0);
	$fillColor[12] = ImageColorAllocate($image, 204, 51, 102);
	$fillColor[13] = ImageColorAllocate($image, 51, 0, 255);
	$fillColor[14] = ImageColorAllocate($image, 255, 204, 204);
	$fillColor[15] = ImageColorAllocate($image, 102, 204, 204);
	$fillColor[16] = ImageColorAllocate($image, 153, 153, 153);
	$fillColor[17] = ImageColorAllocate($image, 0, 102, 153);
	$fillColor[18] = ImageColorAllocate($image, 204, 102, 255);
	$fillColor[19] = ImageColorAllocate($image, 153, 204, 102);

	// 그래프가 그려질 영역을 연회색으로 칠한다
	ImageFilledRectangle($image , 60, 20, 60+$x_axis, 20+$y_axis, $gray);

	// 외곽 테두리 사각형 박스
	ImageRectangle($image , 0, 0, $x_size-1, $y_size-1, $black);

	// 그래프의 축 그리기. 두껍게 그리기위해 두줄을 긋는다.
	ImageLine($image, 60, 20, 60, 20+$y_axis, $black);	// Y 축
	ImageLine($image, 61, 20, 61, 20+$y_axis, $black);	// Y 축
	ImageLine($image, 60, 20+$y_axis, 60+$x_axis, 20+$y_axis, $black);	// X 축
	ImageLine($image, 60, 19+$y_axis, 60+$x_axis, 19+$y_axis, $black);	// X 축

	$dotgap = $y_axis/$dot_num;	// 점선간 간격
	$y_gap = 100/$dot_num;		// 점선에 찍을 퍼센트

	// 점선옆에 찍을 퍼센티지와 수 표시
	for($i=0; $i<$dot_num; $i++)
	{
		ImageDashedLine($image , 61, 20+($dotgap*$i), 60+$x_axis, 20+($dotgap*$i), $dark_gray);
		$sign_percent = 100-($y_gap*$i);				// Y 축의 좌표 퍼센트
		$sign_num = ($sum/$dot_num)*($dot_num-$i);		// Y 축의 좌표 퍼센트에 해당하는 수
		ImageString($image, 2, 20, 14+($i*$dotgap), $sign_percent ."%", $black);
		ImageString($image, 2, 20, 26+($i*$dotgap), "(".$sign_num .")", $black);
	}

	for($i=0; $i<sizeof($data); $i++)
	{
		if($i==0)
		{
			$x_pos[$i] = $first_gap;					// 처음 그래프가 그려질 X 좌표
		}
		else
		{
			$x_pos[$i] = $x2_pos[$i-1] + $print_gap;	// 처음이 아닌 그래프가 그려질 X 좌표
		}

		$x2_pos[$i] = $x_pos[$i] + $line_width;

		// 막대위에 쓰여질 data 의 값 쓰기
		imageString($image, 2, $x_pos[$i]+80, ($y_axis-$line_height[$i]), $data[$i], $black);

		// 막대아래에 쓰여질 data 이름 찍기
		// array imagettftext (int im, int size, int angle, int x, int y, int col, string fontfile, string text)

		//ImageTTFText($image,12,0, 40+$x_pos[$i]+($line_width/2), $y_axis+35, $black, "hangul.ttf", str2uni($data_name[$i]));

		// 사각형 그리기
		ImageFilledRectangle($image, $x_pos[$i]+60, 20+($y_axis-$line_height[$i]), $x2_pos[$i]+60, 20+$y_axis-2, $fillColor[$color]);
	}

	// 0 좌표 찍기
	ImageString($image ,2 ,50, 20+$y_axis-10, "0", $black);

	ImageGif($image,"$file_name");
	ImageDestroy($image);

}// function End.
?>