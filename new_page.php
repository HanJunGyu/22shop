<?
session_start();
include "./lib/config.php";
include "./lib/function.php";
$qry = "select * from page where code='$code'";
$page_row = $MySQL->fetch_array($qry);
if(!$page_row)
{
	// 페이지 코드 에러
	echo"<B>- 페이지 코드 입력이 올바르지 않습니다.<P>- 해당페이지 링크방법 : ./new_page.php?code=<FONT COLOR='#CC0000'>해당코드</FONT></B>";
	exit;
}
else
{
	if($page_row[bPopup])
	{
		// 페이지 팝업창 사용 [빈페이지]
		if (!$admin_row[bMouseRB])
		{
			?>
<body oncontextmenu="return false" onselectstart="return false" ondragstart="return false"><?
		}
		else
		{
			?>
<body topmargin='0' leftmargin='0'><?
		}
		echo"$page_row[content]";
	}
	else
	{
		// 페이지 지정페이지 사용
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
<title><?=$page_row[title]?></title>
<style>
<?=$design[css]?>
</style>
<meta http-equiv="Content-Type" content="text/html; charset=euc-kr">
<script language=javascript src="./script/admin.js"></script>
</head>
<? include "top.php";?>
<table width="900" border="0" cellspacing="0" cellpadding="0" bgcolor="<?=$ALL_BGCOLOR?>">
	<tr>
		<? include "left_menu.php";?>
		<td  valign="top" width="714" bgcolor="#FFFFFF">
			<table width="714" height="100%" border="0" cellspacing="0" cellpadding="0">
				<tr bgcolor="#FFFFFF" valign="top">
					<td colspan="2" >
						<table width="714" border="0" cellspacing="0" cellpadding="0">
							<tr><?
							if($page_row[img])
							{
								// 사용자 페이지 타이틀 이미지
								?>
								<td width="220" height="27" bgcolor="#ffffff"><img src="upload/page/<?=$page_row[img]?>"></td><?
							}
							else
							{
								?><?
							}
							?>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td valign="top" width="712"><?=$page_row[content]?></td>
				</tr>
			</table>
		</td>
	</tr>
</table>
<? include "copy.php"; ?>
</div>
</body>
</html><?
	}
}
?>