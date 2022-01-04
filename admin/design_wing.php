<?
include "head.php";
if (empty($position)) $position="left_wing";
?>
<SCRIPT LANGUAGE="JavaScript">
<!--
//사이트경로,상품코드 활성/비활성
function showSiteUrl(Obj)
{
	if(Obj.gubun[0].checked)
	{
		showObject(Obj.siteUrl,true);
		showObject(Obj.goodsUrl,false);
	}
	else if(Obj.gubun[1].checked)
	{
		showObject(Obj.siteUrl,false);
		showObject(Obj.goodsUrl,true);
	}
	else
	{
		showObject(Obj.siteUrl,false);
		showObject(Obj.goodsUrl,false);
	}
}

//정보 전송
function bannerwriteSendit(Obj)
{
	if(Obj.gubun[0].checked && Obj.siteUrl.value=="")
	{
		alert("사이트 경로를 입력해 주십시오.");
		Obj.siteUrl.focus();
	}
	else if(Obj.gubun[1].checked &&Obj.goodsUrl.value=="")
	{
		alert("상품 배너입니다. 상품을 선택해 주십시오.");
	}
	else if(Obj.img.value=="")
	{
		alert("이미지를 선택해 주십시오.");
	}
	else
	{
		Obj.siteUrl_str.value = Obj.siteUrl.value;
		Obj.goodsUrl_str.value = Obj.goodsUrl.value;
		Obj.submit();
	}
}

//정보 전송
function bannerSendit(Obj,Url)
{
	if(Obj.gubun[0].checked && Obj.siteUrl.value=="")
	{
		alert("사이트 경로를 입력해 주십시오.");
		Obj.siteUrl.focus();
	}
	else if(Obj.gubun[1].checked &&Obj.goodsUrl.value=="")
	{
		alert("상품 배너입니다. 상품을 선택해 주십시오.");
	}
	else
	{
		Obj.siteUrl_str.value = Obj.siteUrl.value;
		Obj.goodsUrl_str.value = Obj.goodsUrl.value;
		Obj.action +=Url;
		Obj.submit();
	}
}
//-->
</SCRIPT>
<body bgcolor="#FFFFFF" text="#000000" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<? include "top_menu.php"; ?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr><?
	$__TOP_MENU = "design";     //왼쪽 소메뉴 설정 변수
	include "left_menu.php";
	?>
		<td width="85%" valign="top">
			<table width="100%" height="500" border="0" cellspacing="0" cellpadding="0" align="center">
				<tr>
					<td height='5'></td>
				</tr>
				<tr>
					<td valign="top">
						<table width="750" border="0" cellspacing="0" cellpadding="0" align="center">
							<tr>
								<td rowspan="3" width="200"><img src="image/design_tit_img.gif"></td>
								<td>&nbsp;</td>
							</tr>
							<tr>
								<td bgcolor="#E6E6E6" height='26'><div align='right'><font class='text1'>SHOP 디자인을 변경하실수 있습니다.&nbsp;</div></td>
							</tr>
							<tr>
								<td>&nbsp;</td>
							</tr>
							<tr>
								<td colspan="2" height="25">&nbsp;</td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td colspan="2" height="70">
						<table width="450" border="1" cellspacing="0" cellpadding="2" align="center" bordercolor="#FFD28E" bordercolordark="#ffffff">
							<tr>
								<td bgcolor="#FFF3E1" align="center" height="40">
									<table width="430" border="0" cellspacing="0" cellpadding="0" align="center">
										<tr>
											<td height="40"> * 페이지 좌우측 날개 배너 - 상품 배너 또는 타사이트 배너<br> * 쇼핑몰 정렬이 가운데 일때만 사용 가능합니다. </td>
										</tr>
									</table>
								</td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td colspan="2" valign="top">&nbsp;</td>
				</tr>
				<tr>
					<td height=40 colspan="2" valign="top" align="center"><input class="text" type="button" value="좌측부분" onclick="location.href='design_wing.php?position=left_wing'">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input class="text" type="button" value="우측부분" onclick="location.href='design_wing.php?position=right_wing'"></td>
				</tr>
				<form name="baseForm" method="post" action="design_ok.php?act=design_wing&part=3">
				<input type="hidden" name="position" value="<?=$position?>">
				<tr>
					<td colspan="2" valign="top" height="35"><img src="image/design_main_icon.gif" width="21" height="11">레이어 사용 여부 <b>(좌우측 통합)</b><br>
						<table border="1" cellspacing="0" cellpadding="2" align="center" bordercolor="#FFD28E" bordercolordark="#ffffff">
							<tr>
								<td align=center bgcolor=eeeeee width=100>기능 사용여부</td>
								<td width=300 align=center> <input type="radio" name="bUse" value="y" <? if ($design[bwinguse]=="y") echo "checked";?>>사용함&nbsp;&nbsp; <input type="radio" name="bUse" value="n" <? if ($design[bwinguse]!="y") echo "checked";?>>사용안함 </td>
								<td><img style="cursor:pointer" src="image/design_save_i.gif" width="46" height="18" border="0" onclick="document.baseForm.submit();"></td>
							</tr>
							<tr>
								<td colspan="3">※ 등록한 <b>좌측베너이미지</b> 중 가장 큰 이미지의 가로 픽셀수치를 입력<input type="text" class="box" name="wing_width" size="5" value="<?=$design[wing_width]?>"> px</td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td colspan="2" valign="top">&nbsp;</td>
				</tr>
				<tr>
					<td colspan="2" valign="top" height="35"><img src="image/design_main_icon.gif" width="21" height="11"> <? if ($position=="left_wing") echo "좌측 날개 베너"; else echo "우측 날개 베너"; ?></td>
				</tr>
				<tr>
					<td colspan="2" height="70">
						<table width="500" border="1" cellspacing="0" cellpadding="2" align="center" bordercolor="#FFD28E" bordercolordark="#ffffff">
							<tr>
								<td align="center">우측 날개베너 대신 <b>오늘 본 상품 기능</b> </td>
								<td width=200 align=center> <input type="radio" name="today_view" value="y" <? if ($design[today_view]=="y") echo "checked";?>>사용함&nbsp;&nbsp; <input type="radio" name="today_view" value="n" <? if ($design[today_view]!="y") echo "checked";?>>사용안함</td>
							</tr>
							<tr>
								<td colspan="2" align="center"><img style="cursor:pointer" src="image/design_save_i.gif" width="46" height="18" border="0" onclick="document.baseForm.submit();"></td>
							</tr>
						</table>
					</td>
				</tr>
				</form><?
				$ban_qry = "select *from banner where position ='$position'";
				$ban_result = $MySQL->query($ban_qry);
				$ban_cnt =0;
				while($ban_row = mysql_fetch_array($ban_result))
				{
					$ban_cnt ++;
					if($ban_row[gubun]==0)
					{
						$site_color = "white";
						$goods_color = "#dddddd";
						$site_disabled = "";
						$goods_disabled = "disabled";
					}
					else if($ban_row[gubun]==1)
					{
						$site_color = "#dddddd";
						$goods_color = "white";
						$site_disabled = "disabled";
						$goods_disabled = "";
					}
					else
					{
						$site_color = "#dddddd";
						$goods_color = "#dddddd";
						$site_disabled = "disabled";
						$goods_disabled = "disabled";
					}
					?>
				<form name="bannerForm3<?=$ban_cnt?>" method="post" action="design_ok.php?act=design_wing&part=1"  enctype="multipart/form-data" >
				<input type="hidden" name="siteUrl_str">
				<input type="hidden" name="goodsUrl_str">
				<input type="hidden" name="bannerIdx" value="<?=$ban_row[idx]?>">
				<input type="hidden" name="position" value="<?=$position?>">
				<tr>
					<td colspan="2" height="70">
						<table width="500" border="1" cellspacing="0" cellpadding="2" align="center" bordercolor="#FFD28E" bordercolordark="#ffffff">
							<tr>
								<td width="150"><?
								if($ban_row[type]==4)
								{
									$img = "../upload/design/".$ban_row[img];
									$img_info = @getimagesize($img);
									$swf_width = $img_info[0];
									$swf_height = $img_info[1];
									?><div align="center">
										<script language='javascript'>
											getFlash("<?=$img?>", "<?=$swf_width?>", "<?=$swf_height?>");
										</script>
									</div><?
								}
								else
								{
									?><div align="center"><img src="../upload/design/<?=$ban_row[img]?>"> </div><?
								}
								?></td>
								<td width="350">
									<table width="100%" border="0" cellspacing="0" cellpadding="0">
										<tr>
											<td width="33%" height="25"> <div align="center"> <input class="radio" type="radio" name="gubun" value="0" <?if($ban_row[gubun]==0)echo"checked";?> onClick="javascript:showSiteUrl(document.bannerForm3<?=$ban_cnt?>);">사이트 URL</div></td>
											<td height="33%"> <div align="center"> <input class="radio" type="radio" name="gubun" value="1" <?if($ban_row[gubun]==1)echo"checked";?> onClick="javascript:showSiteUrl(document.bannerForm3<?=$ban_cnt?>);">상품 URL</div></td>
											<td width="33%" height="25"> <div align="center"> <input class="radio" type="radio" name="gubun" value="2" <?if($ban_row[gubun]==2)echo"checked";?> onClick="javascript:showSiteUrl(document.bannerForm3<?=$ban_cnt?>);">Not URL</div></td>
										</tr>
										<tr>
											<td colspan="3">
												<table width="100%" border="0" cellspacing="0" cellpadding="0">
													<tr>
														<td> <div align="center">http:// <input type="text" name="siteUrl" value="<?=$ban_row[siteUrl]?>"  size="20" style="BORDER-RIGHT: gray 1px solid; BORDER-TOP: gray  1px solid; FONT-SIZE: 9pt; BORDER-LEFT: gray 1px solid; BORDER-BOTTOM: gray  1px solid; FONT-FAMILY: gulim; HEIGHT: 19px; BACKGROUND-COLOR: <?=$site_color?>" <?=$site_disabled?>><br><input type="radio" name="siteTarget" value="_parent" <? if ($ban_row[siteTarget] == "_parent") echo "checked";?>>현재창 <input type="radio" name="siteTarget" value="_blank" <? if ($ban_row[siteTarget] == "_blank") echo "checked";?>>새창 </div> </td>
														<td rowspan="2" width="60"> <div align="center"><a href="javascript:bannerSendit(document.bannerForm3<?=$ban_cnt?>,'&edit=1');"><img src="image/design_save_i.gif" width="46" height="18" border="0"></a> <a href="javascript:bannerSendit(document.bannerForm3<?=$ban_cnt?>,'&del=1');"><img src="image/design_delete.gif" width="46" height="18" border="0"></a></div></td>
													</tr>
													<tr>
														<td > <div align="center"> <input type="text" name="goodsUrl" value="<?=$ban_row[goodsUrl]?>" readonly size="18" style="BORDER-RIGHT: gray 1px solid; BORDER-TOP: gray  1px solid; FONT-SIZE: 9pt; BORDER-LEFT: gray 1px solid; BORDER-BOTTOM: gray  1px solid; FONT-FAMILY: gulim; HEIGHT: 19px; BACKGROUND-COLOR: <?=$goods_color?>" <?=$goods_disabled?>> <a href="javascript:selectGoods('document.bannerForm3<?=$ban_cnt?>.goodsUrl');"><img src="image/design_good.gif" width="46" height="18" border="0"></a></div></td>
													</tr>
												</table>
											</td>
										</tr>
										<tr>
											<td colspan="3"> <div align="center"> <input type="file" name="img" size="25" style="BORDER-RIGHT: gray 1px solid; BORDER-TOP: gray  1px solid; FONT-SIZE: 9pt; BORDER-LEFT: gray 1px solid; BORDER-BOTTOM: gray  1px solid; FONT-FAMILY: gulim; HEIGHT: 19px; BACKGROUND-COLOR: white"></div></td>
										</tr>
									</table>
								</td>
							</tr>
						</table>
					</td>
				</tr>
				</form><!-- bannerForm1 --><?
				}
				?>
				<tr>
					<td colspan="2">&nbsp;</td>
				</tr>
				<form name="bannerwriteForm3" method="post" action="design_ok.php?act=design_wing&part=2"  enctype="multipart/form-data" >
				<input type="hidden" name="siteUrl_str">
				<input type="hidden" name="goodsUrl_str">
				<input type="hidden" name="position" value="<?=$position?>">
				<tr>
					<td colspan="2">
						<table width="500" border="1" cellspacing="0" cellpadding="2" align="center" bordercolor="#FFD28E" bordercolordark="#ffffff">
							<tr>
								<td width="166" bgcolor="#FFF3E1"> <div align="center"> <input type="radio" name="gubun" value="0" onClick="javascript:showSiteUrl(document.bannerwriteForm3);">사이트 URL</div></td>
								<td width="166" bgcolor="#FFF3E1"> <div align="center"> <input type="radio" name="gubun" value="1" onClick="javascript:showSiteUrl(document.bannerwriteForm3);">상품 URL</div></td>
								<td width="166" bgcolor="#FFF3E1"> <div align="center"> <input type="radio" name="gubun" value="2" checked  onClick="javascript:showSiteUrl(document.bannerwriteForm3);">Not URL</div></td>
							</tr>
							<tr>
								<td colspan="3"> <div align="center"> 
									<table width="100%" border="0" cellspacing="0" cellpadding="0">
										<tr>
											<td> <div align="center">http:// <input type="text" name="siteUrl"  size="20" style="BORDER-RIGHT: gray 1px solid; BORDER-TOP: gray  1px solid; FONT-SIZE: 9pt; BORDER-LEFT: gray 1px solid; BORDER-BOTTOM: gray  1px solid; FONT-FAMILY: gulim; HEIGHT: 19px; BACKGROUND-COLOR: #dddddd" disabled><input type="radio" name="siteTarget" value="_parent" checked>현재창 <input type="radio" name="siteTarget" value="_blank">새창 <br><input type="text" name="goodsUrl"  size="18" style="BORDER-RIGHT: gray 1px solid; BORDER-TOP: gray  1px solid; FONT-SIZE: 9pt; BORDER-LEFT: gray 1px solid; BORDER-BOTTOM: gray  1px solid; FONT-FAMILY: gulim; HEIGHT: 19px; BACKGROUND-COLOR: #dddddd" readonly disabled><a href="javascript:selectGoods('document.bannerwriteForm3.goodsUrl');"><img src="image/design_good.gif" width="46" height="18" border="0"></a></div></td>
											<td rowspan="2" width="60"> <div align="center"><a href="javascript:bannerwriteSendit(document.bannerwriteForm3);"><img src="image/design_save_i.gif" width="46" height="18" border="0"></a></div></td>
										</tr>
										<tr>
											<td> <div align="center"> <input type="file" name="img"  size="25" style="BORDER-RIGHT: gray 1px solid; BORDER-TOP: gray  1px solid; FONT-SIZE: 9pt; BORDER-LEFT: gray 1px solid; BORDER-BOTTOM: gray  1px solid; FONT-FAMILY: gulim; HEIGHT: 19px; BACKGROUND-COLOR: white"></div></td>
										</tr>
									</table></div>
								</td>
							</tr>
							<tr>
								<td colspan="3" bgcolor="#FFF3E1"> <div align="center">gif , jpg , swf</div></td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td colspan="2">&nbsp;</td>
				</tr>
				</form><!-- bannerwriteForm3 -->
			</table>
		</td>
	</tr>
</table>
<? include "copy.php";?>
</body>
</html>