<?
// 소스형상관리
// 20060724-1 파일교체 김성호
// 20060724-2 소스수정 김성호 : [상품관리] (버그패치) 상품상세보기 상품질문 목록 글번호 중복
session_start();
include "./lib/config.php";
include "./lib/function.php";
if(!defined(__INCLUDE_CLASS_PHP)) include "./lib/class.php";
if(!defined(__ADMIN_ROW))
{
	define(__ADMIN_ROW,"TRUE");
	$admin_row=$MySQL->fetch_array("select *from admin limit 0,1");
}
if(!defined(__DESIGN_ROW))
{
	define(__DESIGN_ROW,"TRUE");
	$design=$MySQL->fetch_array("select *from design limit 0,1");
}
if(!defined(__DESIGN_GOODS_ROW))
{
	define(__DESIGN_GOODS_ROW,"TRUE");
	$design_goods=$MySQL->fetch_array("select *from design_goods limit 0,1");
}
$__SITE_ALIGN = $design[mainAlign];			//사이트 정열방식 ex)left, center
?>
<html>
<head>
<title><?=$admin_row[shopTitle]?></title>
<style>
<?=$design[css]?>
</style>
<meta http-equiv="Content-Type" content="text/html; charset=euc-kr">
<script language=javascript src="./script/admin.js"></script>
<SCRIPT LANGUAGE="JavaScript">
<!--
function goods_ask(gidx)
{
	<?if($GOOD_SHOP_PART=="member"){?>
	var userid = "<?=$GOOD_SHOP_USERID?>";
	if (userid=="")
	{
		userid = "guest";
	}
	window.open("goods_ask.php?gidx="+gidx+"&userid="+userid,"","scrollbars=yes,width=620,height=400,top=50,left=300");
	<?}else{?>
	alert("회원 로그인후 이용하실수 있습니다.");
	<?}?>
}
function ask_view(idx)
{
	window.open("goods_ask_view.php?idx="+idx,"","scrollbars=yes,width=620,height=400,top=50,left=300");
}
//-->
</SCRIPT>
</head>
<table width="630" border="0" cellspacing="1" cellpadding="0" align="center">
	<tr>
		<td colspan='6' bgcolor='cdcdcd'></td>
	</tr>
	<tr bgcolor="f1f1f1">
		<td align="center" width="40" height=30>번호</td>
		<td align="center" >질문내용</td>
		<td align="center" width="100">글쓴이</td>
		<td align="center" width="100">날짜</td>
		<td align="center" width="50">조회</td>
		<td align="center" width="50">답글</td>
	</tr>
	<tr>
		<td colspan='6' bgcolor='cdcdcd'></td>
	</tr><?
	$data=Decode64($data);
	$pagecnt=$data[pagecnt];
	$offset=$data[offset];
	$total_list_qry = "SELECT * from good_board WHERE gidx=$gidx";
	$numresults=$MySQL->query($total_list_qry);
	$numrows=mysql_num_rows($numresults);
	$LIMIT		=5;										//페이지당 글 수
	$PAGEBLOCK	=10;									//블럭당 페이지 수
	if($pagecnt==""){$pagecnt=0;}						//페이지 번호
	if(!$offset){$offset=$pagecnt*$LIMIT*$PAGEBLOCK;}	//각 페이지의 시작 글
	$letter_no=$numrows - $offset;						//시작글 번호
	$list_qry = $total_list_qry." order by idx desc limit $offset,$LIMIT";
	$good_board_result=$MySQL->query($list_qry);
	if ($numrows)
	{
		while ($good_board_row = mysql_fetch_array($good_board_result))
		{
			$reply_num = $MySQL->articles("SELECT idx from good_board_comment WHERE boardidx=$good_board_row[idx]");
			?>
	<tr bgcolor='ffffff' height='25'>
		<td align="center"><?=$letter_no?></td>
		<td align="center"><a href="#;" onclick="javascript:ask_view(<?=$good_board_row[idx]?>);"><?=$good_board_row[title]?></a></td>
		<td align="center"><?=$good_board_row[name]?></td>
		<td align="center"><?=substr($good_board_row[writeday],0,10)?></td>
		<td align="center"><?=$good_board_row[readnum]?></td>
		<td align="center"><?=$reply_num?></td>
	</tr>
	<tr>
		<td colspan='6' bgcolor='cdcdcd'></td>
	</tr><?
			$letter_no--;
		}
	}
	else
	{
		// 상품질문 없을때
		?>
	<tr>
		<td colspan="5" align=center>해당 상품에 관련된 상품 Q&A가 없습니다.</td>
	</tr><?
	}
	?>
</table><?
$OptionStr = "gidx=$gidx";
$Obj=new CList("goods_board.php",$pagecnt,$offset,$numrows,$PAGEBLOCK,$LIMIT,$search,$searchstring,$OptionStr);
?>
<table width="600" border="0" cellspacing="0" cellpadding="2" align="center">
	<tr>
		<td align="center"><?$Obj->putList(false,"<img src='image/board/btn_prev.gif'>","<img src='image/board/btn_next.gif'>");//이전다음 프린트?></td>
	</tr>
</table>
<table width="600" border="0" cellspacing="0" cellpadding="2" align="center">
	<tr>
		<td align="right"><a href="javascript:goods_ask('<?=$gidx?>');"><img src='image/work/ask_write.gif' border='0'></a></td>
	</tr>
</table>
</body>
</html>