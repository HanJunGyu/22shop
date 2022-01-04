<?
// 소스형상관리
// 20060714_1 소스수정 최호수 (통계 프로그램 수정으로 인한 소스 수정)
?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td bgcolor='C8D7DD'><iframe width=0 height=0 frameborder=0 src="SessionMaintain.php"></iframe>
			<table width="960" border="0" cellspacing="0" cellpadding="0">
				<tr><?
				if($design[mainLogoImg_type]==4)
				{
					$img = "../upload/design/".$design[mainLogoImg];
					$img_info = @getimagesize($img);
					$swf_width = $img_info[0];
					$swf_height = $img_info[1];
					?>
					<td height="50" width="155">
						<script language='javascript'>
							getFlash("<?=$img?>", "<?=$swf_width?>", "<?=$swf_height?>");
						</script>
					</td><?
				}
				else
				{
					?>
					<td><a href="adm.php"><img src="../upload/design/<?=$design[mainLogoImg]?>"></a></td><?
				}
				?>
					<td>
						<table width='400' cellpadding='0' cellspacing='0' border='0' align='right'>
							<tr>
								<td><a href="sale_status.php"><img src="image/top_1.gif" border="0"></a></td>
								<td><a href="http://<?=$admin_row[shopUrl]?>" target="_blank"><img src="image/top_2.gif" border="0"></a></td>
								<td><a href="login_ok.php?del=1"><img src="image/top_3.gif" border="0"></a></td>
								<td><a href="help_board.php" target=""><img src="image/top_4.gif" border="0"></a></td>
								<td><a href="help_manual.php" target=''><img src="image/top_5.gif"  border="0"></a></td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td>
			<table width="100%" height="96" border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td width='80'><a href="adm.php" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Image6','','image/basic_icon_1.gif',1)"><img name="Image6" border="0" src="image/basic_icon.gif" ></a></td>
					<td width='80'><a href="trade_order.php" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Image10','','image/order_icon_1.gif',1)"><img name="Image10" border="0" src="image/order_icon.gif" ></a></td>
					<td width='80'><a href="total_goods_list.php" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Image12','','image/goods_icon_1.gif',1)"><img name="Image12" border="0" src="image/goods_icon.gif" ></a></td>
					<td width='80'><a href="category_manage.php" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Image11','','image/category_icon_1.gif',1)"><img name="Image11" border="0" src="image/category_icon.gif" ></a></td>
					<td width='80'><a href="member_list.php" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Image9','','image/member_icon_1.gif',1)"><img name="Image9" border="0" src="image/member_icon.gif" ></a></td>
					<td width='80'><a href="design.php" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Image141','','image/design_icon_1.gif',1)"><img name="Image141" border="0" src="image/design_icon.gif"></a></td>
					<td width='80'><a href="sale_status.php" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Image13','','image/data_icon_1.gif',1)"><img name="Image13" border="0" src="image/data_icon.gif"></a></td>
					<td width='80'><a href="gm_counter.php" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Image1511','','image/log_icon_1.gif',1)"><img name="Image1511" border="0" src="image/log_icon.gif"></a></td>
					<td width='80'><a href="page_add.php" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Image1611','','image/defin_icon_1.gif',1)"><img name="Image1611" border="0" src="image/defin_icon.gif"></a></td>
					<td width='80'><a href="notice_list.php?part=notice" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Image7','','image/news_icon_1.gif',1)"><img name="Image7" border="0" src="image/news_icon.gif"></a></td>
					<td width='80'><a href="bbs_admin_list.php" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Image8','','image/board_icon_1.gif',1)"><img name="Image8" border="0" src="image/board_icon.gif" ></a></td>
					<td width='80'><a href="ask.php" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Image1191','','image/ask_icon_1.gif',1)"><img name="Image1191" border="0" src="image/ask_icon.gif"></a></td>
					<td background='image/menu_bg.gif'>&nbsp;</td>
				</tr>
				<tr>
					<td colspan='13' height='1'></td>
				</tr>
				<tr>
					<td width='80'><a href="sms.php" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Image117','','image/sms_icon_1.gif',1)"><img name="Image117" border="0" src="image/sms_icon.gif"></a></td>
					<td width='80' align=center><a href="javascript:inputImg_topmenu('page','<?=$this_imgcode?>');" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Image11913','','image/up_icon_1.gif',1)"><img name="Image11913" border="0" src="image/up_icon.gif"></a></td><?
					if($webmail_admin_row[adm_bWebmail])
					{
						?>
					<td width='80' align=center><a href="admmail_main.php" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Image1195','','image/admmail_icon_1.gif',1)"><img name="Image1195" border="0" src="image/admmail_icon.gif"></a></td><?
					}
					else
					{
						?>
					<td width='80' align=center><a href="admmail_adm.php" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Image1195','','image/admmail_icon_1.gif',1)"><img name="Image1195" border="0" src="image/admmail_icon.gif"></a></td><?
					}
					?>
					<td width='80' background='image/menu_bg.gif'>&nbsp;</td>
					<td width='80' background='image/menu_bg.gif'>&nbsp;</td>
					<td width='80' background='image/menu_bg.gif'>&nbsp;</td>
					<td width='80' background='image/menu_bg.gif'>&nbsp;</td>
					<td width='80' background='image/menu_bg.gif'>&nbsp;</td>
					<td background='image/menu_bg.gif'>&nbsp;</td>
					<td background='image/menu_bg.gif'>&nbsp;</td>
					<td background='image/menu_bg.gif'>&nbsp;</td>
					<td background='image/menu_bg.gif'>&nbsp;</td>
					<td background='image/menu_bg.gif'>&nbsp;</td>
				</tr>
			</table>
		</td>
	</tr>
</table>