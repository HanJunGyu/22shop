<?
include "head.php";
if ($_POST["resetmall"])
{
	if ($part=="goods" || $part=="all")
	{
		// 전체 카테고리 삭제
		$_del_qry = "select * from category";
		$_del_result = $MySQL->query($_del_qry);
		while($_del_row = mysql_fetch_array($_del_result)) 
		{
			@unlink("../upload/category/$_del_row[img1]");
			@unlink("../upload/category/$_del_row[img2]");
			@unlink("../upload/category/$_del_row[img3]");
			@unlink("../upload/category/$_del_row[img4]");
		}
		$MySQL->query("DELETE from category");

		// 전체 상품 삭제
		$_del_qry = "select * from goods";
		$_del_result = $MySQL->query($_del_qry);
		while($_del_row = mysql_fetch_array($_del_result))
		{
			@unlink("../upload/goods/$_del_row[img1]");
			@unlink("../upload/goods/$_del_row[img2]");
			@unlink("../upload/goods/$_del_row[img3]");
			@unlink("../upload/goods/$_del_row[img4]");
			@unlink("../upload/goods/$_del_row[img5]");
			@unlink("../upload/goods/$_del_row[img6]");
			@unlink("../upload/goods/$_del_row[img7]");
			@unlink("../upload/goods/$_del_row[img8]");
			@unlink("../upload/goods/$_del_row[detailimg1]");
			@unlink("../upload/goods/$_del_row[detailimg2]");
			@unlink("../upload/goods/$_del_row[detailimg3]");
			@unlink("../upload/goods/$_del_row[detailimg4]");
		}
		$MySQL->query("DELETE from goods");

		//상품관련
		$MySQL->query("DELETE from goods_comment");
		$MySQL->query("DELETE from good_board");
		$MySQL->query("DELETE from good_board_comment");

		$MySQL->query("DELETE from position");
		$MySQL->query("DELETE from compare");
		$MySQL->query("DELETE from interest");
	}
	if ($part=="board" || $part=="all")
	{
		// 전체 게시판 글 삭제
		$result = $MySQL->query("SELECT * from bbs_data");
		while ($row = mysql_fetch_array($result))
		{
			@unlink("../upload/bbs/$row[up_file]");
			@unlink("../upload/bbs/$row[img1]");
			@unlink("../upload/bbs/$row[img2]");
		}
		$MySQL->query("DELETE from bbs_data");

		$MySQL->query("DELETE from comment");

		//공지사항 , 설문조사
		$MySQL->query("DELETE from notice");
		$MySQL->query("DELETE from poll");
	}
	if ($part=="member" || $part=="all")
	{
		$MySQL->query("DELETE from member");
		$MySQL->query("DELETE from member_withdraw");
		$MySQL->query("DELETE from point_table");
	}
	if ($part=="trade" || $part=="all")
	{
		//주문
		$MySQL->query("DELETE from trade");
		$MySQL->query("DELETE from trade_goods");
		$MySQL->query("DELETE from trade_temp");
		$MySQL->query("DELETE from cart");
		//추가배송비
		$MySQL->query("DELETE from trans_add");
	}
	if ($part=="stat" || $part=="all")
	{
		$MySQL->query("TRUNCATE TABLE GM_Counter");
	}
	if ($part=="design" || $part=="all")
	{
		// 전체 사용자정의페이지 삭제
		$result = $MySQL->query("SELECT * from page");
		while ($row = mysql_fetch_array($result))
		{
			@unlink("../upload/page/$row[img]");
		}
		$MySQL->query("DELETE from page");

		$result = $MySQL->query("SELECT *from banner where position<>'topbanner'");
		while ($row = mysql_fetch_array($result))
		{
			@unlink("../upload/design/$row[img]");   //상품이미지1 삭제
		}
		$MySQL->query("DELETE from banner where position<>'topbanner'");
		$MySQL->query("update design set bScrollUse='n'"); // 메인 타이틀이미지 슬라이드 효과 끄기 
		////디자인
		$MySQL->query("UPDATE design SET mainBestApp=1,mainHitApp=1"); //메인베스트,히트 자동스크롤일경우 1로 셋팅 
	}
	if ($part=="etc" || $part=="all")
	{
		$MySQL->query("DELETE from ipblock");
		$MySQL->query("DELETE from patch");
		$MySQL->query("DELETE from patchDetail");
		$MySQL->query("DELETE from userSrcEdit");
	}
	MsgViewHref("초기화 완료하였습니다.","adm_reset.php");
	exit;
}
?>