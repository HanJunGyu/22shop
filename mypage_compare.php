<?
include "head.php";
$member_row = $MySQL->fetch_array("select *from member where userid='$_SESSION[GOOD_SHOP_USERID]'");
?>
<SCRIPT LANGUAGE="JavaScript">
<!--
function compare()
{
	var form = document.compareForm;
	var compareIdx = "";
	if (form.comparechk.length>1)
	{
		for (var i=0; i<form.comparechk.length; i++)
		{
			if (form.comparechk[i].checked)
			{
				compareIdx += form.comparechk[i].value+"/";
			}
			else
			{
			}
		}
	}
	else
	{
		compareIdx = form.comparechk.value+"/";
	}
	form.idxstr.value = compareIdx;
}
function delInter()
{
	var form = document.compareForm;
	var idxstr = form.idxstr.value;
	if (idxstr == "")
	{
		alert("상품을 선택해주세요.");
	}
	else
	{
		location.href="mypage_compare_ok.php?del=1&idxstr="+idxstr;
	}
}
function moveCart(st)
{
	var form = document.compareForm;
	var idxstr = form.idxstr.value;
	if (idxstr == "")
	{
		alert("상품을 선택해주세요.");
	}
	else
	{
		location.href="mypage_compare_ok.php?cartadd=1&idxstr="+idxstr+"&st="+st;
	}
}
//-->
</SCRIPT>
<? include "top.php";?>
<table width="900" border="0" cellspacing="1" cellpadding="0" bgcolor="<?=$ALL_BGCOLOR?>">
	<tr>
		<? include "left_menu.php";?>
		<td height="51" valign="top" width="720" bgcolor="#FFFFFF">
			<table width="720" border="0" cellspacing="0" cellpadding="0">
				<tr bgcolor="#FFFFFF" valign="top">
					<td colspan="2">
						<table width="720" height="35" border="0" cellspacing="0" cellpadding="0" align='center'>
							<tr>
								<td width="2"  bgcolor="<?=$subdesign[bc5]?>" rowspan="2"></td>
								<td width="2"  bgcolor="<?=$subdesign[bc5]?>" rowspan="2"></td>
								<td width="220" height="27" bgcolor="<?=$subdesign[bc5]?>"><img src="./upload/design/<?=$subdesign[img5]?>" ></td>
								<td width="490" height="27" bgcolor="<?=$subdesign[bc5]?>"><div align="right"> &nbsp;<font color="<?=$subdesign[tc5]?>"> <img src='image/good/icon0.gif'>&nbsp;현재위치 : HOME &gt; Mypage(마이페이지)&gt;상품비교 </font>&nbsp;</div></td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td valign="top" width="720"><br><?
					if ($_SESSION[GOOD_SHOP_PART]=="member")
					{
						include "mypage_menu.php";
					}
					?><br><br>
						<table border='0' width='670' cellpadding='0' cellspacing='0' align='center'>
							<tr>
								<td><img src='image/member/my_tit6.gif'></td>
							</tr>
						</table>
						<form name="compareForm" method="post">
						<input type="hidden" name="idxstr" value="">
						<table width="670" border="0" cellspacing="0" cellpadding="0" align="center">
							<tr>
								<td height="2" bgcolor="80c9d8"></td>
							</tr>
							<tr>
								<td valign="top">
									<!-- 관심 상품 목록 시작 -->
									<table width="670" border="0" cellspacing="0" cellpadding="0" height="25" align="center"><?
									$int_qry    = "select * from compare where userid='$_SESSION[GOOD_SHOP_USERID]'";
									$int_result = $MySQL->query($int_qry);
									$interest_goods_cnt = $MySQL->is_affected();
									$int_cnt =1;		//폼 카운트
									while($int_row = mysql_fetch_array($int_result))
									{
										$goods_row = $MySQL->fetch_array("select *from goods where idx=$int_row[goodsIdx] limit 1"); //상품정보
										$gprice = new CGoodsPrice($goods_row[idx]);
										//이미지사용
										if($goods_row[bHit]) $bHit ="<img src='admin/image/hit.gif'>";
										else $bHit ="";
										if ($admin_row[bNew])  $bNew = limitday($goods_row[writeday],$admin_row[new_day]);
										if($goods_row[bEtc]) $bEtc ="<img src='./upload/goods_etc_img' >";
										else $bEtc ="";
										$optionArr = Array("$int_row[option1]","$int_row[option2]","$int_row[option3]");   //옵션 배열
										if ($int_cnt%4 ==1)
										{
											echo "<TR>";
										}
										$td_width = 650 / 4;
										if (empty($GD_SET) && $goods_row[img_onetoall]) $img_str = $goods_row[img3];
										else if ($GD_SET && $goods_row[img_onetoall] && empty($goods_row[img1])) $img_str = $goods_row[img3];
										else if ($GD_SET && empty($goods_row[img_onetoall]) && empty($goods_row[img1])) $img_str = $goods_row[img3];
										else $img_str = $goods_row[img1];
										?>
											<td width="<?=$td_width?>" valign=top>
												<table width=100%>
													<tr>
														<td align=center><input type="checkbox" name="comparechk" onclick="javascript:compare();" value="<?=$int_row[idx]?>"><img src="upload/goods/<?=$img_str?>" width="<?=$td_width-70?>" height="<?=$td_width-70?>" align='absmiddle'></td>
													</tr>
													<tr>
														<td align=center><b><?=$goods_row[name]?></b> <?=$bHit?> <?=$bNew?> <?=$bEtc?></td>
													</tr><?
													if($goods_row[bOldPrice])
													{
														//시중가표시
														?>
													<tr>
														<td align=center><?
														if ($goods_row[bSaleper] && $goods_row[sale])
														{
															echo "<font color=#D83232>($goods_row[sale]%)</font>"; 
														}
														?></td>
													</tr><?
													}
													?>
													<tr>
														<td align=center><font color="ff0000"><?=$gprice->PutPrice();?> 원</font> </td>
													</tr><?
													if($admin_row[bUsepoint])
													{
														?>
													<tr>
														<td align=center><img src="upload/goods_point_img"> <?=$gprice->PutPoint2()." 원"?></td>
													</tr><?
													}
													if($goods_row[bCompany])
													{
														//제조원표시
														?>
													<tr>
														<td align=center><font color="0633F5">제조원: <?=$goods_row[company]?></font></td>
													</tr><?
													}
													if($goods_row[bOrigin])
													{
														//원산지표시
														?>
													<tr>
														<td align=center><font color="6E1D93">원산지: <?=$goods_row[origin]?></font></td>
													</tr><?
													}
													?>
													<tr>
														<td align=center><font color="83821B">조회수: <?=$goods_row[readCnt]?></font></td>
													</tr><?
													if ($goods_row[bLimit])
													{
														if(empty($goods_row[limitCnt]) || $goods_row[bLimit]==2) $limitCnt="품절";
														elseif($goods_row[bLimit]==3) $limitCnt="보류";
														elseif($goods_row[bLimit]==4) $limitCnt="단종";
														?>
													<tr>
														<td><div align="center"><font color="#CA59D1"><?= $limitCnt?></font></div></td>
													</tr><?
													}
													?>
												</table>
											</td><?
											if ($int_cnt%4 == 0) echo "</tr>";
											$int_cnt++;
									}
									if ($int_cnt<4) $empty = $int_cnt;
									else $empty = ($int_cnt+1)%4;
									if ($empty)
									{
										for ($j=0; $j<$empty; $j++)
										{
											echo "<td width=$td_width>&nbsp;</td>";
										}
									}
									?>
									</table>
									<!-- 관심 상품 목록 끝 -->
								</td>
							</tr>
							<tr>
								<td height="1" bgcolor="80c9d8"></td>
							</tr>
							<tr>
								<td height="30"><br>
									<table width="457" border="0" cellspacing="2" cellpadding="0" align="center">
										<tr align="center">
											<td><a href="javascript:moveCart('cart');"><img src="image/icon/cart_btn.gif" border="0"></a></td>
											<td><a href="javascript:moveCart('order');"><img src="image/icon/order_btn.gif" border="0"></a></td>
											<td><a href="javascript:delInter();"><img src="image/icon/delete.gif" border="0"></a></td>
											<td><a href="javascript:history.go(-1);"><img src="image/icon/shopping_continue_btn.gif" border="0"></a></td>
										</tr>
									</table>
								</td>
							</tr>
						</table>
						</form><!-- compareForm -->
						<br><br><br>
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>
<? include "copy.php"; ?>
</div>
</body>
</html>