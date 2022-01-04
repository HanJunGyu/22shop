<?
include "head.php";
?>
<? include "top.php";?>
<table width="900" border="0" cellspacing="1" cellpadding="0" bgcolor="<?=$ALL_BGCOLOR?>">
	<tr>
		<td  valign="top" width="900" bgcolor="#FFFFFF">
			<table width="900" height="100%" border="0" cellspacing="0" cellpadding="0"><?
			$img = "./upload/design/$design[mainnewTitleImg]";
			$type = $design[mainnewTitleImg_type];
			if($type==4)
			{
				$img_info = @getimagesize($img);
				$swf_width = $img_info[0];
				$swf_height = $img_info[1];
				?>
				<tr>
					<td align=center valign=top width="145">
						<script language='javascript'>
							getFlash("<?=$img?>", "<?=$swf_width?>", "<?=$swf_height?>");
						</script>
					</td>
				</tr><?
			}
			else
			{
				?>
				<tr>
					<td valign=top><img src="<?=$img?>"></td>
				</tr><?
			}
			?>
			</table><?
			if ($design[new_content])
			{
				?>
			<table width="900" height="100%" border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td><?=$design[new_content]?></td>
				</tr>
			</table><?
			}
			?>
			<table width="900" height="100%" border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td bgcolor="#5ab5c5" height="60">
						<table cellpadding='0' cellspacing='0' width="98%" align="center" border=0 height="50"><?
						// 카테고리 순차적 노출
						$cate_result = $MySQL->query("SELECT code,name from category WHERE bHide<>1 order by position asc");
						$cate_cnt=1;
						while ($cate_row = mysql_fetch_array($cate_result))
						{
							if ($cate_cnt%6==1) echo "<TR>";
							$href = "#".$cate_row[code];
							echo "<td style='padding:3 0 3 10'><img src='image/sub/icon_md.gif' align='absmiddle'> <a href='$href'><font color='#ffffff' style='line-height:22px'>".$cate_row[name]."</font></a></td>";
							if ($cate_cnt%6==0) echo "</TR>";
							$cate_cnt++;
						}
						?>
						</table>
					</td>
				</tr>
				<tr>
					<td><img src='image/sub/md_b.gif'></td>
				</tr>
			</table><?
			$cate_result = $MySQL->query("SELECT idx,code,name from category order by position asc");
			while ($cate_row = mysql_fetch_array($cate_result))
			{
				$search_category = $cate_row[code];
				$cate_num2 = $MySQL->articles("SELECT goods.idx from goods , position as pos WHERE goods.idx = pos.goodsIdx and pos.part='new' and goods.category='$cate_row[code]' and goods.bLimit<3");
				if ($cate_num2)
				{
					?>
			<table width="900" height="100%" border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td height='5'></td>
				</tr>
				<TR>
					<td height=30 bgcolor="#e3edf6">
						<table width=100%>
							<tr>
								<td style='padding:0 0 0 10'><img src='image/sub/icon_00.gif' align='absmiddle'> <a name="<?=$cate_row[code]?>"></a>&nbsp;<font color="13548c" style='line-height:20px'><b><?=$cate_row[name]?></b></font></td>
								<td width=3%><a href="goods_list.php?Index=<?=$cate_row[idx]?>"><img src="image/sub/goto_list.gif" border='0'></a></td>
								<td align="right" width='45'><a href='#top'><img src='image/sub/btn_top.gif' border='0'></a>&nbsp;</td>
							</tr>
						</table>
					</td>
				</tr><?
					$search_category = $cate_row[code];
					$pos_result = $MySQL->query("SELECT *from position WHERE category='$cate_row[code]' and part='new'");
					if (mysql_num_rows($pos_result))
					{
						// 카테고리 신규상품이 있을때만 아래모듈 수행
						?>
				<tr>
					<td>
						<table width="900" height="100%" border="0" cellspacing="0" cellpadding="0"><?
						// 카테고리 신규상품 바둑판식 나열
						$cnt=0;
						while ($pos_row = mysql_fetch_array($pos_result))
						{
							$goods_row = $MySQL->fetch_array("SELECT *from goods WHERE idx='$pos_row[goodsIdx]' limit 1");	 	
							$page_width = 900/$design[new_cols];
							$cnt++;
							if ($cnt % $design[new_cols] == 1) echo "<TR bgcolor='ffffff'>";
							?>
								<td width="<?=$page_width?>" valign="top">
									<table width=100% border=0 cellspacing="1" cellpadding="0" align="center">
										<tr>
											<td valign="top" align=center><?
											$gprice = new CGoodsPrice($goods_row[idx]);
											$LINK = "goods_detail.php?goodsIdx=$goods_row[idx]";
											$NEW_PAGE = 1;
											include "goods_detail_inc.php"; 
											$NEW_PAGE = 0;
											?></td>
										</tr>
									</table>
								</td><?
							if ($cnt % $design[new_cols] == 0) echo "</TR><tr height=5><td colspan=".($design[new_cols]*2 - 1)."></td></tr>";
							else echo "<td valign='top' width='1' background='image/index/dot_height2.gif'></td>";
						}
						$remain_cnt = (($cnt % $design[new_cols])*2);
						if($remain_cnt > 0)
						{
							for($i=($design[new_cols]*2 - 1); $i > $remain_cnt; $i--)
							{
								echo "<td></td>";
							}
						}
						?>
							</tr>
							<tr height=5>
								<td colspan="<?=($design[new_cols]*2 - 1)?>"></td>
							</tr>
						</table>
					</td>
				</tr><?
						// 신규상품목록 끝났을때 구분선
						if ($cnt>0)
						{
							?>
				<tr>
					<td height="1" background="image/index/dot_width.gif"></td>
				</tr><?
						}
					}
				}
			}
			?>
			</table>
		</td>
	</tr>
</table>
<? include "copy.php"; ?>
</div>
</body>
</html>