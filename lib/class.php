<?
define(__INCLUDE_CLASS_PHP, "TRUE");

if(!defined(__INCLUDE_FUNCTION_PHP)) include "function.php";

/*******************************************************************
목록 (_list.php) 이전다음 설정 class
◀ 1 [2][3][4][5] ▶
********************************************************************/
class CList
{
	var $g_pageName;		//설정파일명 ex) notice_list.php, qna_list.php
	var $g_pageCnt;			//현재페이지 번호
	var $g_offset;			//데이타베이스 시작 포인트 번호
	var $g_numRows;			//총게시물 수
	var $g_pageBlock;		//블럭당 페이지 수 ex) 5 : [1][2][3][4][5]
	var $g_limit;			//페이지당 출력 게시물 수
	var $g_search;			//검색 컬럼 ex)name,title,...
	var $g_searchstring;	//검색어
	var $g_option;			//추가 get 값  ex) &part=$part
	var $g_pniView;			//링크되지 않은 아이콘 표시 여부 ex) true,1 : 표시  false,0 : 미표시
	var $g_pIcon;			//이전 아이콘
	var $g_nIcon;			//다음 아이콘

	// 생성자
	// CList( char* pagename, int pagecnt, int offset, int numrows, int pageblock, int limit, char* search, char* searchstring, char* option)
	// CList(페이지명, 현재페이지번호, DB시작offset, 총게시물수, 블럭당페이지수, 페이지당게시물수, 검색컬럼, 검색어, 추가get값)
	function CList($pagename, $pagecnt, $offset, $numrows, $pageblock, $limit, $search, $searchstring, $option)
	{
		$this->g_pageName		= $pagename;
		$this->g_pageCnt		= $pagecnt;
		$this->g_offset			= $offset;
		$this->g_numRows		= $numrows;
		$this->g_pageBlock		= $pageblock;
		$this->g_limit			= $limit;
		$this->g_search			= $search;
		$this->g_searchstring	= $searchstring;
		$this->g_option			= $option;
	}

	// 아이콘 설정
	// putList( BOOL pniView, char* pre_icon, char* next_icon)
	// putList( 링크되지 않은 아이콘 표시 여부, 이전아이콘, 다음아이콘
	function putList($pniView,$pre_icon,$next_icon)
	{
		$this->g_pniView=$pniView;							//링크되지 않은 아이콘 표시 여부
		if(empty($pre_icon))	$this->g_pIcon="◁";			//이전 아이콘 설정
		else					$this->g_pIcon=$pre_icon;

		if(empty($next_icon))	$this->g_nIcon="▷";			//다음 아이콘 설정
		else					$this->g_nIcon=$next_icon;

		$this->pniPrint(); //화면 출력
	}

	// 화면 출력
	function pniPrint()
	{
		/*	이전	*/
		if($this->g_pageCnt>0)					//이전페이지 있음
		{
			$prepage = $this->g_pageCnt-1;		//이전블럭 시작페이지 설정.
			$pre_letter_no = $this->g_numRows-($this->g_pageCnt-1)*($this->g_pageBlock*$this->g_limit);	//이전블럭 시작글 번호 설정
			$data = Encode64("pagecnt=".$prepage."&letter_no=".$pre_letter_no."&search=".$this->g_search."&searchstring=".$this->g_searchstring);

			$pre_str = "<a href='".$this->g_pageName."?data=".$data;
			if(!empty($this->g_option))
				$pre_str.= "&".$this->g_option;
			$pre_str.= "'>".$this->g_pIcon."</a>&nbsp;&nbsp;&nbsp;";

			echo "$pre_str";		//이전아이콘 링크
		}
		else						//이전페이지 없음
		{
			if($this->g_pniView)	//아이콘 표시
				$empty_pre_str = $this->g_pIcon."&nbsp;&nbsp;&nbsp;";
			else					//아이콘 비표시
				$empty_pre_str = "&nbsp;&nbsp;&nbsp;";

			echo "$empty_pre_str";
		}

		/*	1 [2][3][4][5]	*/
		$chekpage = intval($this->g_numRows/($this->g_limit*$this->g_pageBlock));		//현제페이지 체크

		if($chekpage==$this->g_pageCnt)			//마지막 블럭일 경우....
		{
			$pCnt = (intval($this->g_numRows/$this->g_limit)%$this->g_pageBlock)+1;		//마지막 블럭 페이지수 계산
			if(!($this->g_numRows%($this->g_limit)))
			{
				$pCnt--;
			}
		}
		else
		{
			$pCnt = $this->g_pageBlock;
		}

		$l = 0;
		while($l<$pCnt)
		{
			$loffset = $l*($this->g_limit)+($this->g_pageCnt*$this->g_limit*$this->g_pageBlock);	//시작글 지정
			$lnum = $l + (($this->g_pageCnt)*$this->g_pageBlock) + 1;								//페이지 번호 설정
			$cu_letter_no = $this->g_numRows-(($lnum-1)*$this->g_limit);							//시작글 번호 지정
			$en_str = "offset=".$loffset."&letter_no=".$cu_letter_no."&pagecnt=".$this->g_pageCnt;
			$en_str.= "&search=".$this->g_search."&searchstring=".$this->g_searchstring;
			$data = Encode64($en_str);
			if($lnum==(($this->g_offset/$this->g_limit)+1))		//현재 페이지 일 경우....
			{
				echo " $lnum ";
			}
			else
			{
				$mid_str = "<a href='".$this->g_pageName."?data=".$data;
				if(!empty($this->g_option))
					$mid_str.= "&".$this->g_option;
				$mid_str.= "'>[".$lnum."]</a>";

				echo "$mid_str";
			}
			$l++;
		}

		/*	다음	*/
		if($this->g_pageCnt!=$chekpage)			//다음페이지 있음
		{
			echo "&nbsp;&nbsp;&nbsp; ";
			$newpagecnt = $this->g_pageCnt+1;		//다음 블럭 시작페이지 설정
			$newt = $cu_letter_no-$this->g_limit;	//다음 블럭 시작글 번호 설정
			$data = Encode64("pagecnt=".$newpagecnt."&letter_no=".$newt."&search=".$this->g_search."&searchstring=".$this->g_searchstring);

			$next_str = "<a href='".$this->g_pageName."?data=".$data;
			if(!empty($this->g_option))
				$next_str.= "&".$this->g_option;
			$next_str.= "'>".$this->g_nIcon."</a>";

			echo $next_str;			//다음 아이콘 링크
		}
		else									//다음페이지 없음
		{
			if($this->g_pniView)			//아이콘 표시
				echo "&nbsp;&nbsp;&nbsp;".$this->g_nIcon;
			else							//아이콘 비표시
				echo "&nbsp;&nbsp;&nbsp;";
		}
	}//function pniPrint()
}//class CList

/*******************************************************************
	상품 가격 설정 class
********************************************************************/
class CGoodsPrice
{
	var $MySQL;
	var $G	= "」「";		//구분자
	var $g_gPrice;			//상품가격
	var $g_gPoint;			//상품적립금
	var $g_optionPriceStr;
	var $g_optionPriceName;
	var $g_gOptionLength;

	// 생성자
	// CGoodsPrice( char* dbp, int idx)
	// CGoodsPrice( 데이타베이스 포인트, 상품일련번호)
	function CGoodsPrice($idx)
	{
		global $MySQL;
		$this->MySQL = $MySQL;
		global $GOOD_SHOP_PART_GUBUN;

		if($idx) $goods_row = $this->MySQL->fetch_array("SELECT * FROM goods WHERE idx=$idx");

		if($GOOD_SHOP_PART_GUBUN=="M")			//일반회원
		{
			$this->g_gPrice = $goods_row[price];
			$this->g_gPoint = $goods_row[point];
		}
		elseif($GOOD_SHOP_PART_GUBUN=="D")			//딜러
		{
			$this->g_gPrice = $goods_row[price];
			$this->g_gPoint = $goods_row[point];
		}
		else		//비회원이면
		{
			$this->g_gPrice = $goods_row[price];
			$this->g_gPoint = $goods_row[point];
		}
	}//function CGoodsPrice

	//상품 가격 출력(format)
	function PutPrice()
	{
		return PriceFormat($this->g_gPrice);
	}

	//상품 가격 출력
	function Price()
	{
		return $this->g_gPrice;
	}

	//상품 적립금 출력
	function PutPoint()
	{
		return $this->g_gPoint;
	}
	function PutPoint2()
	{
		return PriceFormat($this->g_gPoint);
	}

	//옵션별 가격 출력
	function PutOptionStr()
	{
		$temp_attArr = explode($this->G,$this->g_optionPriceStr);
		for($i=0; $i<count($temp_attArr); $i++)
		{
			$temp = explode("|",$temp_attArr[$i]);
			$attArr[$i][0] = $temp[0];
			$attArr[$i][1] = $temp[1];
			$attArr[$i][2] = $temp[2];
		}
		$this->g_gOptionLength = count($temp_attArr);

		return $attArr;
	}

	//
	function PutOptionLength()
	{
		return $this->g_gOptionLength;
	}
}//class CGoodsPrice
?>