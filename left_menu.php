<?
// 20060725-1 JGS : 웹프로그램 링크배너 삽입
?>
<td valign="top" width="180">
	<table width="180" border="0" cellspacing="0" cellpadding="0" align="center"><?
	if ($design[bLoginShow]=="y")
	{
		?>
		<tr>
			<td valign="top">
				<table width="175" border="0" cellspacing="0" cellpadding="0" align="center" height="100" background='image/login_bg.gif'><?
				if ($_SESSION[GOOD_SHOP_PART] == "member")
				{
					$member_row = $MySQL->fetch_array("SELECT *from member WHERE userid='$GOOD_SHOP_USERID' limit 1");
					?>
					<tr>
						<td valign="top" bgcolor="<?=$design[login_bgcolor]?>">
							<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
								<tr>
									<td height='25' align="center" ><b><?=$GOOD_SHOP_NAME?></b> 님 로그인중</td>
								</tr>
							</table>
						</td>
					</tr>
					<tr>
						<td valign="top" bgcolor="<?=$design[login_bgcolor]?>">
							<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
								<tr>
									<td align="center"><a href="login_ok.php?del=1"><img src="upload/design/<?=$design[LogoutBtn]?>"  border="0"></a></td>
									<td align="center"><a href="mypage_member.php"><img src="upload/design/<?=$design[EditBtn]?>" border="0"></a></td>
								</tr>
							</table>
						</td>
					</tr><?
				}
				else
				{
					?>
					<tr>
						<td><form name="loginmainForm" method="post" action="login_ok.php">
							<table width="95%" border="0" cellspacing="0" cellpadding="0" align="center">
								<tr>
									<td class="font11" height="30" align="center"><img src="upload/design/<?=$design[LoginIdBtn]?>"></td>
									<td><input autocomplete="off" class="text_l" type="text" name="userid" size="10" <? if (__DEMOPAGE) echo "value=test";?>></td>
									<td rowspan="2"><img style="cursor:pointer" onclick="left_login_check();" src="upload/design/<?=$design[LoginBtn]?>" border="0"></td>
								</tr>
								<tr>
									<td class="font11" height="30" align="center"><img style="cursor:pointer" src="upload/design/<?=$design[LoginPwBtn]?>"></td>
									<td><input autocomplete="off" class="text_l" type="password" name="pwd" size="10" <? if (__DEMOPAGE) echo "value=1111";?> onKeyDown="javascript:left_loginChek();"></td>
									<td></td>
								</tr>
							</table></form>
						</td>
					</tr>
					<tr>
						<td class="font11" height="25" valign='top'>
							<table width="160" border="0" cellspacing="0" cellpadding="0" align="center">
								<tr>
									<td align="center"><a href="member_article.php"><img src="upload/design/<?=$design[JoinBtn]?>"  border="0"></a></td>
									<td align="center"><a href="#;" onclick="searchId(1);"><img src="upload/design/<?=$design[IdlossBtn]?>"  border="0"></a></td>
								</tr>
							</table>
						</td>
					</tr><?
				}
				?>
				</table>
			</td>
		</tr><?
	}
	?>
	</table><?
	if ($COMMUNITY_PAGE) ////////////// 커뮤니티 페이지에서는 카테고리목록 위에 게시판 목록 노출
	{
		$MySQL->query("select *from bbs_list where bUse=1");
		if($MySQL->is_affected())
		{
			//사용중인 게시판이 있을 경우
			?>
	<table width="180" border="0" cellspacing="0" cellpadding="0" align="center">
		<tr>
			<td>
				<table width="175" border="0" cellspacing="0" cellpadding="0" align="center">
					<tr>
						<td bgcolor="#FFFFFF" valign="top"><a href='community.php'><img src="./upload/design/<?=$design_goods[SubBbsTitle]?>" border='0'></a></td>
					</tr>
					<tr>
						<td width="175">
							<table width="150" border="0" cellspacing="0" cellpadding="0" align="center"><?
								$left_menu_bbs_result =$MySQL->query("select * from bbs_list where bUse=1 order by idx asc");
								while($left_menu_bbs_row=mysql_fetch_array($left_menu_bbs_result))
								{
									if ($left_menu_bbs_row[gubun]=="D" && $GOOD_SHOP_PART_GUBUN=="D" || $left_menu_bbs_row[gubun]=="M")
									{
										?>
								<tr><?
										if ($left_menu_bbs_row[nameimg])
										{
											?>
									<td><a href="board_list.php?boardIndex=<?=$left_menu_bbs_row[idx]?>"><img src="upload/bbs/<?=$left_menu_bbs_row[nameimg]?>"></a></td><?
										}
										else
										{
											?>
									<td height="25">&nbsp;&nbsp;<a href="board_list.php?boardIndex=<?=$left_menu_bbs_row[idx]?>"><?=$left_menu_bbs_row[name]?></a></td><?
										}
										?>
								</tr><?
									}
								}
								?><!-- 게시판 끝 -->
								<tr>
									<td height="10"></td>
								</tr>
							</table>
						</td>
					</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td height='5'></td>
		</tr>
	</table><?
		}
	}
	if ($design[bLeftCategory]=="y")
	{
		?>
	<table width="180" border="0" cellspacing="0" cellpadding="0" align="center">
		<tr>
			<td valign="top"><!--  카테고리 시작  -->
				<table width="175" border="0" cellspacing="0" cellpadding="0" align='center'>
					<tr>
						<td bgcolor="#FFFFFF" valign="top">
							<table width="175" border="0" cellspacing="0" cellpadding="0" align='center'><?
							if (!$design[bmainCategoryTitle])
							{
								?>
								<tr>
									<td align="center"><img src="./upload/design/<?=$design[mainCategoryTitle]?>"></td>
								</tr><?
							}
							?>
								<tr>
									<td></td>
								</tr>
								<tr>
									<td valign="top">
										<table width="150" border="0" cellspacing="0" cellpadding="0" align="center"><?
										$LAYER_TOP_VALUE	= 2;
										$__MENU_HEIGHT	= $design[mainMaxcateH];
										$total_lay_cnt=0;
										$left_lay_cnt=0;		//레이어구별 카운트
										$left_menu_cate_result = $MySQL->query("select idx,code,name,img1,img2 from category where bHide<>'1' order by position asc");
										while($left_menu_cate_row = mysql_fetch_array($left_menu_cate_result))
										{
											$lay_top = ($__MENU_HEIGHT+1)*$left_lay_cnt+$LAYER_TOP_VALUE;   //레이어 시작 위치 설정
											$left_lay_cnt++;
											if($design[mainbMaxcateT] || empty($left_menu_cate_row[img1]))
											{
												?>
											<tr onMouseOut="MM_showHideLayers('Layer<?=$left_lay_cnt?>','','hide');bgcolorChange(this.style,'');" onMouseOver="MM_showHideLayers('Layer<?=$left_lay_cnt?>','','show');bgcolorChange(this.style,'#ddeff9');" style="cursor:pointer;" >
												<td height="<?=$__MENU_HEIGHT?>" onclick="location.href='goods_list.php?Index=<?=$left_menu_cate_row[idx]?>'"><?=$left_menu_cate_row[name]?></td><?
											}
											else
											{
												//이미지 사용
												if ($left_menu_cate_row[img2])
												{
													?>
											<tr onMouseOut="MM_showHideLayers('Layer<?=$left_lay_cnt?>','','hide');MM_swapImgRestore();" onMouseOver="MM_showHideLayers('Layer<?=$left_lay_cnt?>','','show');MM_swapImage('Image15<?=$left_lay_cnt?>','','upload/category/<?=$left_menu_cate_row[img2]?>',1);" style="cursor:pointer;" ><?
												}
												else
												{
													?>
											<tr onMouseOut="MM_showHideLayers('Layer<?=$left_lay_cnt?>','','hide');" onMouseOver="MM_showHideLayers('Layer<?=$left_lay_cnt?>','','show');" style="cursor:pointer;" ><?
												}
												?>
												<td height="<?=$__MENU_HEIGHT?>" onclick="location.href='goods_list.php?Index=<?=$left_menu_cate_row[idx]?>'"><img name="Image15<?=$left_lay_cnt?>" border="0" src="upload/category/<?=$left_menu_cate_row[img1]?>" height="<?=$__MENU_HEIGHT?>" width=175></td><?
											}
											?>
											</tr><?
											if($design[mainbMaxcateT] || empty($left_menu_cate_row[img1]))
											{
												?>
											<tr>
												<td background='image/index/dot_width.gif' height='1'></td>
											</tr><?
											}
										}
										?><!-- 왼쪽 카테고리 메뉴 끝 -->
										</table>
									</td>
								</tr>
							</table>
						</td>
					</tr>
				</table><!--  카테고리 끝  -->
			</td>
		</tr>
		<tr>
			<td height='5'></td>
		</tr>
	</table><?
	}
	////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	// 디자인관리 - 상품목록 C 부분에서 상품목록 페이지에서만 공통좌측메뉴(게시판,설문조사,공지사항 등) 사용안할때
	////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	if ($design_goods[bGoodsList_left]=="n" || !$category_info)
	{
		if ($design[bNoticeLeft]=="y")
		{
			?><!--  공지사항 시작  -->
	<table width="180" border="0" cellspacing="0" cellpadding="0" align="center">
		<tr>
			<td valign="top" width="175" align='center'>
				<table width="100%" border="0" cellspacing="0" cellpadding="0">
					<tr>
						<td valign="top" align='center'>
							<table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="dadada">
								<tr>
									<td valign="top">
										<table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#FFFFFF" align="center">
											<tr>
												<td><a href="notice_list.php"><img src="./upload/design/<?=$design[noticeTitleImg]?>" width="175"   border=0></a></td>
											</tr>
											<tr>
												<td height="5"></td>
											</tr>
											<tr>
												<td valign="top">
													<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center"><?
													$top_notice_result = $MySQL->query("select *from notice where part='notice' order by idx desc limit 0,5");
													while($top_notice_row = mysql_fetch_array($top_notice_result))
													{
														if ($top_notice_row[gubun]=="M" && ($GOOD_SHOP_PART_GUBUN=="M" || $GOOD_SHOP_PART_GUBUN!="D")) $read_able = true;
														else if ($top_notice_row[gubun]=="D" && $GOOD_SHOP_PART_GUBUN=="D") $read_able = true;
														else if (empty($top_notice_row[gubun])) $read_able = true;
														else $read_able = false;
														if ($read_able)
														{
															$java_str = $top_notice_row[idx].",".$top_notice_row[app].",".$top_notice_row[width].",".$top_notice_row[height];
															$java_str.= ",'".$top_notice_row[bPopup]."'";
															?>
														<tr>
															<td height="22">&nbsp;&nbsp;<a href="javascript:noticeView(<?=$java_str?>);"><font color="#818181"><?=StringCut($top_notice_row[title],24)?></font></a></td>
														</tr><?
														}
													}
													?>
													</table>
												</td>
											</tr>
										</table>
									</td>
								</tr>
							</table><!--  공지사항 끝  -->
						</td>
					</tr>
				</table>
			</td>
		</tr>
	</table><?
		}
		$MAIN_NEW_GOODS_ROW	=	 $design[mainNewGoodsList];
		$main_new_goods_qry = "select goods.*from goods,position as pos where pos.goodsIdx=goods.idx and pos.part='mainnew' and goods.bLimit<3 order by pos.sunwi asc limit $MAIN_NEW_GOODS_ROW";
		$main_new_goods_result= $MySQL->query($main_new_goods_qry);
		if (mysql_num_rows($main_new_goods_result))
		{
			?><!--  신상품전 시작  -->
	<table width="180" border="0" cellspacing="0" cellpadding="0" align="center">
		<tr bgcolor="#ddeff9">
			<td>
				<table width="175" border="0" cellspacing="0" cellpadding="0" align="center">
					<tr>
						<td><img src="./upload/design/<?=$design[mainNewGoodsTitle]?>"></td>
					</tr>
					<tr>
						<td>
							<table width="173" border="0" cellspacing="0" cellpadding="0" align="center" bgcolor="#ffffff"><?
							$main_new_goods_cnt =0;
							while($goods_row2 = mysql_fetch_array($main_new_goods_result))
							{
								if ($admin_row[bNew])
								{
									$bNew = limitday($goods_row2[writeday],$admin_row[new_day]);
									// 설정된 기간보다 지나서 new 마크가 붙지 않지만 임의로 상품정보에서 뉴마크 사용시/////
									if (empty($bNew) && $goods_row2[bNew]) $bNew = "<img src='upload/goods_new_img'>";
								}
								if($goods_row2[bHit]) $bHit ="<img src='upload/goods_hit_img'>";	//히트 이미지
								else $bHit ="";
								if($goods_row2[bEtc]) $bEtc ="<img src='upload/goods_etc_img' >";	//기타 이미지
								else $bEtc ="";
								$left_gprice = new CGoodsPrice($goods_row2[idx]);
								?>
								<tr>
									<td>
										<table width="173" border="0" cellspacing="0" cellpadding="0" align="center">
											<tr><?
											if (empty($GD_SET) && $goods_row2[img_onetoall]) $img_str = $goods_row2[img3];
											else if ($GD_SET && $goods_row2[img_onetoall] && empty($goods_row2[img1])) $img_str = $goods_row2[img3];
											else if ($GD_SET && empty($goods_row2[img_onetoall]) && empty($goods_row2[img1])) $img_str = $goods_row2[img3];
											else $img_str = $goods_row2[img1];
											$img_str = urlencode($img_str);
											?>
												<td width="50"><?
												if ($design_goods[bGoodsList_1]==1)
												{
													///상품설정에서  노출할때
													?><a href="goods_detail.php?goodsIdx=<?=$goods_row2[idx]?>"><img src="upload/goods/<?=$img_str?>" width="45" height="45" border="0"></a><?
												}
												?></td>
												<td><?
												if ($design_goods[bGoodsList_2]==1)
												{
													///상품설정에서  노출할때
													?><font color="<?=$design_goods[gname_color]?>"><a href="goods_detail.php?goodsIdx=<?=$goods_row2[idx]?>"><?=StringCut($goods_row2[name],16)?></a></font><?
												}
												?><br>
													<table>
														<tr><?
														if ($design_goods[bGoodsList_4]==1)
														{
															///상품설정에서  노출할때
															?>
															<td><img src="upload/goods_price_img"></td>
															<td><font color="<?=$design_goods[gprice_color]?>"><?=$left_gprice->PutPrice();?>원</font></td><?
														}
														?>
														</tr>
													</table>
												</td>
											</tr>
										</table>
									</td>
								</tr><?
									if($main_new_goods_cnt <$goods_row2)
									{
										?>
								<tr>
									<td background="image/work/bg.gif" height="1"></td>
								</tr><?
									}
							}
							?>
							</table>
						</td>
					</tr>
				</table>
			</td>
		</tr>
	</table><!-- 신상품전 끝  --><?
		}
		?><!-------무료배송------------><?
		if ($MySQL->articles("SELECT idx from goods WHERE size='N' and bLimit<3 limit 1") && $design[bmainFreeTitle]=="y")
		{
			?>
	<table width="180" border="0" cellspacing="0" cellpadding="0" align="center">
		<tr bgcolor="#ddeff9">
			<td>
				<table width="175" border="0" cellspacing="0" cellpadding="0" align="center"  >
					<tr>
						<td align="center"><img src="upload/design/<?=$design[mainFreeTitle]?>"   border=0></td>
					</tr>
					<tr>
						<td>
							<table width="173" border="0" cellspacing="0" cellpadding="0" align="center" bgcolor="#ffffff"><?
							$free_result = $MySQL->query("SELECT *from goods WHERE size='N' and bLimit<3 order by rand() limit $design[mainFreeGoodsList]");
							while ($free_row = mysql_fetch_array($free_result))
							{
								$left_gprice = new CGoodsPrice($free_row[idx]);
								?>
								<tr ><?
								if (empty($GD_SET) && $free_row[img_onetoall]) $img_str = $free_row[img3];
								else if ($GD_SET && $free_row[img_onetoall] && empty($free_row[img1])) $img_str = $free_row[img3];
								else if ($GD_SET && empty($free_row[img_onetoall]) && empty($free_row[img1])) $img_str = $free_row[img3];
								else $img_str = $free_row[img1];
								$img_str = urlencode($img_str);
								?>
									<td width="50" align="center"><?
									if ($design_goods[bGoodsList_1]==1)
									{
										///상품설정에서  노출할때
										?><a href="goods_detail.php?goodsIdx=<?=$free_row[idx]?>"><img src="upload/goods/<?=$img_str?>" width="45" height="45" border="0"></a><?
									}
									?></td>
									<td><?
									if ($design_goods[bGoodsList_2]==1)
									{
										///상품설정에서  노출할때
										?><font color="<?=$design_goods[gname_color]?>"><a href="goods_detail.php?goodsIdx=<?=$free_row[idx]?>"><?=StringCut($free_row[name],16)?></a></font><?
									}
									?><br>
										<table cellspacing="0" cellpadding="0" >
											<tr><?
											if ($design_goods[bGoodsList_4]==1)
											{
												///상품설정에서  노출할때
												?>
												<td><img src="upload/goods_price_img"></td>
												<td><font color="<?=$design_goods[gprice_color]?>">&nbsp;<?=$left_gprice->PutPrice();?>원</font></td><?
											}
											?>
											</tr>
										</table>
									</td>
								</tr>
								<tr>
									<td background="image/work/bg.gif" height="1" colspan="2"></td>
								</tr><?
							}
							?>
							</table>
						</td>
					</tr>
				</table>
			</td>
		</tr>
		<tr bgcolor="#ddeff9">
			<td height="3"></td>
		</tr>
		<tr>
			<td height="5"></td>
		</tr>
	</table><?
		}
		if ((!$LEFT_MAIN && !$COMMUNITY_PAGE) || $LEFT_MAIN)
		{
			?><!--  게시판 시작  --><?
			$MySQL->query("select *from bbs_list where bUse=1");
			if($MySQL->is_affected())
			{
				//사요중인 게시판이 있을 경우
				?>
	<table width="180" border="0" cellspacing="0" cellpadding="0" align="center">
		<tr>
			<td>
				<table width="175" border="0" cellspacing="0" cellpadding="0" align="center">
					<tr>
						<td bgcolor="#FFFFFF" valign="top"><a href='community.php'><img src="./upload/design/<?=$design_goods[SubBbsTitle]?>" border='0'></a></td>
					</tr>
					<tr>
						<td width="175" bgcolor="#FFFFFF">
							<table width="150" border="0" cellspacing="0" cellpadding="0" align="center">
							<!-- 게시판 시작 --><?
								////////일반회원 게시판
								$left_menu_bbs_result =$MySQL->query("select *from bbs_list where bUse=1 order by idx asc");
								while($left_menu_bbs_row=mysql_fetch_array($left_menu_bbs_result))
								{
									if ($left_menu_bbs_row[gubun]=="D" && $GOOD_SHOP_PART_GUBUN=="D" || $left_menu_bbs_row[gubun]=="M")
									{
										?>
								<tr><?
										if ($left_menu_bbs_row[nameimg])
										{
											?>
									<td><a href="board_list.php?boardIndex=<?=$left_menu_bbs_row[idx]?>"><img src="upload/bbs/<?=$left_menu_bbs_row[nameimg]?>"></a></td><?
										}
										else
										{
											?>
									<td height="25">&nbsp;&nbsp;<a href="board_list.php?boardIndex=<?=$left_menu_bbs_row[idx]?>"><?=$left_menu_bbs_row[name]?></a></td><?
										}
										?>
								</tr><?
									}
								}
								?><!-- 게시판 끝 -->
								<tr>
									<td height="10"></td>
								</tr>
							</table>
						</td>
					</tr>
				</table>
			</td>
		</tr>
	</table><?
			}
			?><!--  게시판  끝  --><?
		}
		?><!--  공통  배너 시작  -->
	<table width="180" border="0" cellspacing="0" cellpadding="0" align="center"> 
		<tr>
			<td valign="top">
				<table width="175" border="0" cellspacing="0" cellpadding="0" align="center"><!--   배너  시작 --><?
				if ($LEFT_MAIN) $BN_POSITION = "left3";
				else $BN_POSITION = "layer";

				//////////////////////////////////////////////////////////
				// 서브페이지일경우 레어어 베너 이미지 사용여부에 따라 
				// 메인페이지일경우는 그냥 출력
				//////////////////////////////////////////////////////////
				if($design_goods[layApp] && !$LEFT_MAIN || $LEFT_MAIN)
				{
					$right_ban_qry = "select *from banner where position ='$BN_POSITION' order by sunwi asc";
					$right_ban_result = $MySQL->query($right_ban_qry);
					$right_ban_cnt =0;
					while($right_ban_row = mysql_fetch_array($right_ban_result))
					{
						$img = "upload/design/$right_ban_row[img]";
						if($right_ban_row[type]==4)
						{
							//플래시
							$img_info = @getimagesize($img);
							$swf_width = $img_info[0];
							$swf_height = $img_info[1];
							?>
					<tr>
						<td align="center">
							<script language='javascript'>
								getFlash("<?=$img?>", "<?=$swf_width?>", "<?=$swf_height?>");
							</script>
						</td>
					</tr><?
						}
						else
						{
							//이미지
							?>
					<tr><?
							if($right_ban_row[gubun]==0)
							{
								if ($right_ban_row[siteTarget] == "_blank") $http = "http://";
								?><!-- 사이트 링크 -->
						<td><div align="center"><a href="<?=$http?><?=$right_ban_row[siteUrl]?>" target="<?=$right_ban_row[siteTarget]?>"><img src="<?=$img?>" width="175" border="0"></a></div></td><?
							}
							else if($right_ban_row[gubun]==1)
							{
								?><!-- 상품 링크 -->
						<td><div align="center"><a href="goods_detail.php?goodsIdx=<?=$right_ban_row[goodsUrl]?>"><img src="<?=$img?>" width="175"></a></div></td><?
							}
							else
							{
								?><!-- 링크없음 -->
						<td><div align="center"><img src="<?=$img?>" width="175"></div></td><?
							}
							?>
					</tr>
					<tr>
						<td height="5"></td>
					</tr><?
						}
					}
				}
				else
				{
					////////////////////////////////////////////////////////////////////////////레이어 : html 사용
					$layContent =$design_goods[layContent];
					?>
					<tr>
						<td><div align="center"><?=$layContent?></div></td>
					</tr><?
				}
				?><!-- 오른쪽 배너  끝 -->
				</table>
			</td>
		</tr>
	</table>
	<table width='180' border="0" cellspacing="0" cellpadding="0" align="center">
		<tr>
			<td><script language='javascript'>
				getFlash("image/index/banner.swf", "180", "57");
			</script></td>
		</tr>
	</table>
	<!--  공통 배너 끝  -->
	<!--  설문조사 시작  --><?
	if($design[bPoll] && $LEFT_MAIN)
	{
		//설문조사 사용할 경우
		?>
	<table width="180" border="0" cellspacing="0" cellpadding="0" align="center">
		<tr>
			<td valign="top">
				<table width="175" border="0" cellspacing="0" cellpadding="0">
					<tr>
						<td><!-- 설문 조사 시작 --><?
						$tday	= date("Ymd");	//오늘
						$btdayPoll = $MySQL->articles("select *from poll where sday <=$tday and eday >= $tday ");  //현재 진행중인 설문조사 존재 여부
						if($btdayPoll)
						{
							$poll_qry = "select *from poll where sday <=$tday and eday >=$tday ";				//현재 진행중인 설문조사
							$poll_status = "now";
						}
						else
						{
							$poll_qry = "select *from poll where eday <$tday  order by eday desc limit 0,1";	//만료된 설문조사
							$poll_status = "last";
						}
						$MySQL->query($poll_qry);
						if($MySQL->is_affected())
						{
							//설문조사 존재
							$poll_row = $MySQL->fetch_array($poll_qry);
							if ($poll_row[gubun]=="M" && ($GOOD_SHOP_PART_GUBUN=="M" || $GOOD_SHOP_PART_GUBUN!="D")) $read_able = true;
							else if ($poll_row[gubun]=="D" && $GOOD_SHOP_PART_GUBUN=="D") $read_able = true;
							else if (empty($poll_row[gubun])) $read_able = true;
							if ($read_able)
							{
								$answer = explode("「「",$poll_row[answer]);		//답변 목록
								$pollPeriod = substr($poll_row[sday],0,4)."/". substr($poll_row[sday],4,2)."/". substr($poll_row[sday],6,2)." ~ "; //투표기간
								$pollPeriod.= substr($poll_row[eday],0,4)."/". substr($poll_row[eday],4,2)."/". substr($poll_row[eday],6,2);
								$pollData = Encode64("idx=".$poll_row[idx]);
								?>
							<table width="170" border="0" cellspacing="1" cellpadding="0">
								<tr>
									<td bgcolor="#FFFFFF" valign="top">
										<table width="170" border="0" cellspacing="0" cellpadding="0">
											<tr>
												<td><img src="./upload/design/<?=$design[mainPollTitle]?>" width="175" ></td>
											</tr>
											<tr>
												<td height="5"></td>
											</tr>
											<tr>
												<td valign="top">
													<table width="155" border="0" cellspacing="0" cellpadding="3" align="center">
														<tr>
															<td height="35">&nbsp;&nbsp;<b><font color="#3399CC"><?=$poll_row[title]?></font></b></td>
														</tr>
														<tr>
															<td height="30"><div align="center"><?=$pollPeriod?></div></td>
														</tr><?
														if($poll_row[bPlu] >1)
														{
															?>
														<tr>
															<td align="center"><B><?=$poll_row[bPlu]?></B> 개의 복수응답가능</td>
														</tr><?
														}
														?>
														<tr>
															<td height="30">
																<form name="pollForm" method="post" action="poll_ok.php">
																<input type="hidden" name="pollIdx" value="<?=$poll_row[idx]?>"><!-- 설문조사 인덱스 -->
																<input type="hidden" name="voteArrstr"><!-- ex) 0|1|0|1|1 -->
																<table width="150" border="0" cellspacing="0" cellpadding="0" align="center"><?
																for($i=0;$i<count($answer);$i++)
																{
																	$voteValue=$i+1;
																	?>
																	<tr>
																		<td height="25" width="25"><?
																		if($poll_row[bPlu] ==1)
																		{
																			//복수응답 불가능
																			?><input type="radio" name="vote" value="<?=$voteValue?>"><?
																		}
																		else
																		{
																			//복수응답 가능
																			?><input type="checkbox" name="vote" value="<?=$voteValue?>"><?
																		}
																		?></td>
																		<td><?=$answer[$i]?></td>
																	</tr><?
																}
																?>
																</table></form>
															</td>
														</tr>
														<tr>
															<td height="25">
																<table width="155" border="0" cellspacing="0" cellpadding="0">
																	<tr>
																		<td align="center"><?
																		if(${POLL_COOKIE_.$poll_row[idx]} == "yes")
																		{
																			?><a href="javascript:pollErr();"><img src="./upload/design/<?=$design[mainPollWrite]?>" border="0"></a><?
																		}
																		else
																		{
																			?><a href="javascript:pollWrite('<?=$poll_status?>',<?=$poll_row[bPlu]?>,<?=$poll_row[reCan]?>);"><img src="./upload/design/<?=$design[mainPollWrite]?>" border="0"></a><?
																		}
																		?></td>
																		<td align="center"><a href="javascript:viewPoll('<?=$pollData?>');"><img src="./upload/design/<?=$design[mainPollResult]?>"  border="0"></a></td>
																	</tr>
																</table>
															</td>
														</tr>
													</table>
												</td>
											</tr>
											<tr>
												<td height="5"></td>
											</tr>
										</table>
									</td>
								</tr>
							</table><?
							}
						}
						?><!-- 설문 조사 끝 -->
						</td>
					</tr>
					<tr>
						<td valign="top" height="5"></td>
					</tr>
				</table>
			</td>
		</tr>
	</table><?
	}
}
////////////// 디자인관리 - 상품목록 C 부분에서 상품목록 페이지에서만 좌측메뉴 사용안할때 끝
///////////////// 상품목록 페이지에서만 좌측메뉴 사용안할때이면서 상품목록 페이지
if ($design_goods[bGoodsList_left]=="y" && $category_info[idx])
{
	// 해당카테고리 신규상품이 있을때
	if ($MySQL->articles("select idx from position where part='new' and category='$category_info[code]' limit 1"))
	{
		$main_new_goods_qry = "select *from position where part='new' and category='$category_info[code]' order by sunwi asc";
		$MAIN_NEW_GOODS_ROW	=	 20;
		$main_new_goods_result= $MySQL->query($main_new_goods_qry);
		$main_new_goods_num = mysql_num_rows($main_new_goods_result);
	}
}
if ($main_new_goods_num)
{
	?><!--  카테고리별 신상품전 시작  --><?
	if (!$LEFT_MAIN && $category_info)
	{
		?>
	<table width="180" border="0" cellspacing="0" cellpadding="0" align="center">
		<tr>
			<td>
				<table width="175" border="0" cellspacing="0" cellpadding="0" align="center">
					<tr>
						<td><img src="./upload/design/<?=$design[mainNewGoodsTitle]?>" width="175" ></td>
					</tr>
					<tr>
						<td>
							<table width="145" border="0" cellspacing="0" cellpadding="0" align="center"><?
							$main_new_goods_cnt =0;
							while($main_new_goods_row = mysql_fetch_array($main_new_goods_result))
							{
								$goods_row2 = $MySQL->fetch_array("SELECT *from goods WHERE idx=$main_new_goods_row[goodsIdx] and bLimit<3 limit 1");
								if($goods_row2[idx])
								{
									if ($admin_row[bNew])
									{
										$bNew = limitday($goods_row2[writeday],$admin_row[new_day]);
										/////설정된 기간보다 지나서 new 마크가 붙지 않지만 임의로 상품정보에서 뉴마크 사용시/////
										if (empty($bNew) && $goods_row2[bNew]) $bNew = "<img src='upload/goods_new_img'>";
									}
									if($goods_row2[bHit]) $bHit ="<img src='upload/goods_hit_img'>";		//히트 이미지
									else $bHit ="";
									if($goods_row2[bEtc]) $bEtc ="<img src='upload/goods_etc_img' >";	//기타 이미지
									else $bEtc ="";
									$left_gprice = new CGoodsPrice($goods_row2[idx]);
									?>
								<tr>
									<td>
										<table width="170" border="0" cellspacing="0" cellpadding="0" align="center">
											<tr><?
											if (empty($GD_SET) && $goods_row2[img_onetoall]) $img_str = $goods_row2[img3];
											else if ($GD_SET && $goods_row2[img_onetoall] && empty($goods_row2[img1])) $img_str = $goods_row2[img3];
											else if ($GD_SET && empty($goods_row2[img_onetoall]) && empty($goods_row2[img1])) $img_str = $goods_row2[img3];
											else $img_str = $goods_row2[img1];
											?>
												<td width="50"><a href="goods_detail.php?goodsIdx=<?=$goods_row2[idx]?>"><img src="upload/goods/<?=$img_str?>" width="40" height="40" border="0"></a></td>
												<td><font color="<?=$design_goods[gname_color]?>"><a href="goods_detail.php?goodsIdx=<?=$goods_row2[idx]?>"><?=$goods_row2[name]?></a></font><br>
													<table>
														<tr>
															<td><img src="upload/goods_price_img"></td>
															<td><font color="<?=$design_goods[gprice_color]?>"><b><?=$left_gprice->PutPrice();?>원</b></font></td>
														</tr>
													</table>
												</td>
											</tr>
										</table>
									</td>
								</tr><?
									if($main_new_goods_cnt <$MAIN_NEW_GOODS_ROW)
									{
										?>
								<tr>
									<td background="image/work/bg.gif" height="1"></td>
								</tr><?
									}
								}
							}
							?>
							</table>
						</td>
					</tr>
				</table><!-- 카테고리별 신상품전 끝  -->
			</td>
		</tr>
		<tr>
			<td height='10'></td>
		</tr>
	</table><?
	}
}
?><!--  카테고리별  배너 시작  --><?
//////////////// 상품목록 공통메뉴들 안보이는 기능사용시 /////////////////////////////
if ($design_goods[bGoodsList_left]=="y" && $category_info[idx])
{
	?>
	<table width="180" border="0" cellspacing="0" cellpadding="0" align="center">
		<tr>
			<td valign="top">
				<table width="175" border="0" cellspacing="0" cellpadding="0" align="center"><!-- 배너  시작 --><?
				$right_ban_qry = "select *from banner where position ='$category_info[code]' order by sunwi asc";
				$right_ban_result = @$MySQL->query($right_ban_qry);
				$right_ban_cnt =0;
				while($right_ban_row = mysql_fetch_array($right_ban_result))
				{
					$img = "upload/design/$right_ban_row[img]";
					if($right_ban_row[type]==4)
					{
						//플래시
						$img_info = @getimagesize($img);
						$swf_width = $img_info[0];
						$swf_height = $img_info[1];
						?>
					<tr>
						<td align="center">
							<script language='javascript'>
								getFlash("<?=$img?>", "<?=$swf_width?>", "<?=$swf_height?>");
							</script>
						</td>
					</tr><?
					}
					else
					{
						//이미지
						?>
					<tr><?
						if($right_ban_row[gubun]==0)
						{
							if ($right_ban_row[siteTarget] == "_blank") $http = "http://";
							?><!-- 사이트 링크 -->
						<td align="center"><a href="<?=$http?><?=$right_ban_row[siteUrl]?>" target="<?=$right_ban_row[siteTarget]?>"><img src="<?=$img?>" width="175" border="0"></a></td><?
						}
						else if($right_ban_row[gubun]==1)
						{
							?><!-- 상품 링크 -->
						<td align="center"><a href="goods_detail.php?goodsIdx=<?=$right_ban_row[goodsUrl]?>"><img src="<?=$img?>"  width="175"></a></td><?
						}
						else
						{
							?><!-- 링크없음 -->
						<td align="center"><img src="<?=$img?>" width="175"></td><?
						}
						?>
					</tr><?
					}
				}
				?><!-- 오른쪽 배너 끝 -->
				</table>
			</td>
		</tr>
	</table><!--  카테고리별 배너 끝  --><?
}
?>
</td>