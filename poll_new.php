<?
session_start();
include "lib/config.php";
include "lib/function.php";
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
$dataArr= Decode64($data);
$poll_row = $MySQL->fetch_array("select *from poll where idx=$dataArr[idx]");
$answer = explode("「「",$poll_row[answer]);		//답변 목록
$numArr = explode("「「",$poll_row[answer_num]);	//답변 수
$pollPeriod = substr($poll_row[sday],0,4)."/". substr($poll_row[sday],4,2)."/". substr($poll_row[sday],6,2)." ~ "; //투표기간
$pollPeriod.= substr($poll_row[eday],0,4)."/". substr($poll_row[eday],4,2)."/". substr($poll_row[eday],6,2);
?>
<html>
<head>
<title><?=$admin_row[shopTitle]?></title>
<style>
<?=$design[css]?>
</style>
<meta http-equiv="Content-Type" content="text/html; charset=euc-kr">
<script language=javascript src="./script/admin.js"></script>
</head>
<body bgcolor="#FFFFFF" topmargin='10' leftmargin='10' text='464646' marginwidth="0" marginheight="0">
<table width="280" border='0' cellpadding='0' cellspacing='0'>
	<tr>
		<td width='4'><img src='image/sub/table_tleft.gif'></td>
		<td width='272' background='image/sub/table_tbg.gif'></td>
		<td width='4'><img src='image/sub/table_tright.gif'></td>
	</tr>
	<tr>
		<td background='image/sub/idsearch_bg.gif' colspan='3' align='center'>
			<table width="260" border="0" cellspacing="0" cellpadding="0" align="center">
				<tr>
					<td align="center"><img src="image/index/poll_result.gif"></td>
				</tr>
				<tr>
					<td valign="top">
						<table width="240" border="0" cellspacing="0" cellpadding="0" height="250" align='center'>
							<tr>
								<td height='30'>설문조사기간 : &nbsp;<?=$pollPeriod?></td>
							</tr>
							<tr>
								<td height="30" align="center"><font color='458fa6'><b><?=$poll_row[title]?></b></font></td>
							</tr>
							<tr>
								<td height='20' align='right'>&nbsp;총 답변수 : <B><?=$poll_row[total_num]?></B></td>
							</tr><?
							for($i=0;$i<count($answer);$i++)
							{
								$num = $i+1;		//질문번호
								//표수,퍼센트 설정
								if($poll_row[total_num] ==0)
								{
									$vote=0;
									$percent =0.00;
								}
								else
								{
									$vote =$numArr[$i];
									$percent =($vote / $poll_row[total_num] * 100);
								}
								$percent = sprintf("%01.2f",$percent);
								?>
							<tr>
								<td height="20"><?=$num?>. <?=$answer[$i]?> </td>
							</tr>
							<tr>
								<td>
									<table width="240" border="0" cellspacing="0" cellpadding="0">
										<tr>
											<td height="15" bgcolor='f1f1f1'><img src="image/index/poll_bg.gif"  width="<?=$percent?>%" height="15"></td>
										</tr>
										<tr>
											<td align='right' height='20'><?=$numArr[$i]?>명 (<?=$percent?>%)</td>
										</tr>
									</table>
								</td>
							</tr><?
							}
							?>
						</table>
					</td>
				</tr>
				<tr>
					<td align='right' style='padding:0 10 0 0'><a href="poll_last.php"><img src="image/index/poll_icon.gif" border="0"></a> <a href='javascript:window.close(); opener.location.reload();'><img src="image/icon/close.gif" border="0"></a></td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td><img src='image/sub/table_bleft.gif'></td>
		<td background='image/sub/table_bbg.gif'></td>
		<td><img src='image/sub/table_bright.gif'></td>
	</tr>
</table>
</body>
</html>