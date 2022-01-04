<?
include "./lib/config.php";
include "./lib/function.php";
include "./lib/class.php";
$goods_row = $MySQL->fetch_array("SELECT * FROM goods where idx=$idx");
$gprice = new CGoodsPrice( $goods_row[idx]);
$design = $MySQL->fetch_array("SELECT * FROM design limit 0,1");
$admin_row = $MySQL->fetch_array("SELECT * FROM admin limit 0,1");
?>
<html>
<head>
<title><?=$goods_row[name]?> 확대보기</title>
<style>
<?=$design[css]?>
</style>
<meta http-equiv="Content-Type" content="text/html; charset=euc-kr">
<script language=javascript src="./script/admin.js"></script>
<SCRIPT LANGUAGE="JavaScript">
<!--
function clear()
{
	window.close();
}
//-->
</script>
<?
if(!$admin_row[bMouseRB])
{
	?>
<body bgcolor="#FFFFFF" text="#666666" leftmargin="0" topmargin="0" oncontextmenu="return false" onselectstart="return false" ondragstart="return false"><?
}
else
{
	?>
<body bgcolor="#FFFFFF" text="#666666" leftmargin="0" topmargin="0" ><?
}
?>
<table width="100%" border="0" cellpadding="0" cellspacing="0">
	<tr>
		<td bgcolor='#81BACC'><img src='image/sub/zoom_top.gif'></td>
	</tr>
	<tr>
		<td bgcolor='#429DBA' height='2'></td>
	</tr>
</table>
<table width="100%" border="0" cellpadding="0" cellspacing="0">
	<tr>
		<td align="center" width='520' height='550'>
			<table width="100%" border="0" cellpadding="0" cellspacing="0">
				<tr>
					<td align="center"><?
					for($i=0; $i<6; $i++)
					{
						$num = $i+2;
						$img_num = $i+3;
						$img_name = "img".$img_num;
						if($goods_row[$img_name])
						{
							$img_info = @getimagesize("./upload/goods/$goods_row[$img_name]");		//이미지3 정보
							$wSize = $img_info[0];	//가로
							$hSize = $img_info[1];	//세로
							if($hSize<600) $top = (600 - $hSize)/2;
							else $top=10;
							if($top==0) $top=7;
							$left=10;
							if($img_num==3) $dis = "visible";
							else $dis = "hidden";
							$img_str2 = urlencode($goods_row[$img_name]);
							?><div id="Layer<?=$img_num?>" style="position:absolute; left:<?=$left?>px; top:<?=$top?>px; width:<?=$wSize?>; height:<?=$hSize?>px; visibility:<?=$dis?>;"><a href="javascript:clear();"><img src="./upload/goods/<?=$img_str2?>" width="<?=$wSize?>" height="<?=$hSize?>" border=0></a></div><?
						}
					}
					?></td>
				</tr>
			</table>
		</td>
		<td width="200" valign="top">
			<!-- 작은 이미지 -->
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td height="10"></td>
				</tr>
				<tr>
					<td valign="bottom"><?
					$MySQL->query("select *from goods where  idx=$idx and (img3<>'' or img4<>'' or img5<>'' or img6<>'' or img7<>'' or img8<>'')");
					if($MySQL->is_affected())
					{
						?>
						<table width="100%" border="0" cellspacing="3" cellpadding="0" align='center'  bgcolor='#E1E1E1'>
							<tr>
								<td>
									<table width="100%" border="0" cellspacing="0" cellpadding="0" align='center' >
										<tr align="left" height="40" bgcolor='#FFFFFF'>
											<td width="100%" colspan='2' bgcolor='#F4F4F4' style='padding:0 5 0 5'><font color="#000000"><b><?=$goods_row[name]?></b></font></td>
										</tr>
										<tr>
											<td colspan='2' bgcolor='#E1E1E1' height='1'></td>
										</tr>
										<tr align="left" height="25" bgcolor='#FFFFFF'>
											<td width="40%" style='padding:0 0 0 5'> 판매가격</td>
											<td width="60%">: <?=$gprice->PutPrice()?></td>
										</tr><?
										if($goods_row[company])
										{
											?>
										<tr align="left" height="25" bgcolor='#FFFFFF'>
											<td width="40%" style='padding:0 0 0 5'> 제조사</td>
											<td width="60%">: <?=$goods_row[company]?></td>
										</tr><?
										}
										?>
									</table>
								</td>
							</tr>
						</table>
						<table width="100%" border="0" cellspacing="0" cellpadding="0" align='center' >
							<tr>
								<td width="100%" valign="top" align="center" style='cursor:pointer;'><br><?
								for($i=0; $i<6; $i++)
								{
									$num = $i+2;
									$img_num = $i+3;
									$img_name = "img".$img_num;
									if($goods_row[$img_name])
									{
										$img_info = @getimagesize("./upload/goods/$goods_row[$img_name]");		//이미지3 정보
										$wSize = $img_info[0];	//가로
										$hSize = $img_info[1];	//세로

										//첫번째 확대보기는 창 뜨자마자 보이므로 다른이미지를 오버하면 없애줘야함
										if($img_num!=3) $IMG3_DEL = "MM_showHideLayers('Layer3','','hide');";
										else $IMG3_DEL = "";
										$img_str = urlencode($goods_row[$img_name]);
										?><a onMouseOver="MM_showHideLayers('Layer<?=$img_num?>','','show'); <?=$IMG3_DEL?>" onMouseOut="MM_showHideLayers('Layer<?=$img_num?>','','hide');MM_showHideLayers('Layer3','','show');"><img src="upload/goods/<?=$img_str?>" width="70" height="70" border="0"></a><?
										if($i%2==1) echo "<br><br>";
									}
								}
								?></td>
							</tr>
						</table><?
					}
					?>
					</td>
				</tr>
			</table>
			<!-- 작은 이미지 끝 -->
		</td>
	</tr>
	<tr>
		<td colspan='2' height="30" align="right" bgcolor='#F1F1F1'><a href="javascript:clear();"><img src="image/board/close2.gif" border="0" ></a></td>
	</tr>
</table>
</BODY>
</HTML>