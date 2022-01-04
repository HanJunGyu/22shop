<?
include "head.php";
$category_info = $MySQL->fetch_array("select * from category where idx=$Index limit 1"); //카테고리 정보

$total_qry ="select * from goods where bLimit<3 and category='$category_info[code]'";
$MySQL->query($total_qry);
$total_goods_cnt	= $MySQL->is_affected();   //분류내 상품수
$str_category =" <font color='$subdesign[tc1]'> &gt; ".$category_info[name];
// 카테고리 정보 끝
?>
<SCRIPT LANGUAGE="JavaScript">
<!--
function goodsSort()
{
	var form=document.sortForm;
	var Url = "goods_list.php?data=<?=$data?>&Index=<?=$Index?>&searchstring="+form.searchstring.value;
	if(form.Sort.selectedIndex == 1) Url+="&sortStr=name&sort=asc";
	else if(form.Sort.selectedIndex == 2) Url+="&sortStr=name&sort=desc";
	else if(form.Sort.selectedIndex == 3) Url+="&sortStr=price&sort=asc";
	else if(form.Sort.selectedIndex==4) Url+="&sortStr=price&sort=desc";
	location.href=Url;
}
function goodsSearch()
{
	var form=document.sortForm;
	form.submit();
}
//로그인 체크
function mypageLoginChek()
{
	<?if($GOOD_SHOP_PART =="member"){?>
	// 회원
	location.href	="mypage_member.php";
	<?}else{?>
	// 비회원
	alert("회원 메뉴입니다.\n\n로그인 해 주십시오.");
	location.href="login.php";
	<?}?>
}
function compare()
{
	var form = document.compareForm;
	var compareIdx = "";
	var comparechk_bLimit1="";
	var comparechk_limitCnt1="";
	if(form.comparechk.length>0)
	{
		for (var i=0; i<form.comparechk.length; i++)
		{
			if (form.comparechk[i].checked)
			{
				compareIdx += form.comparechk[i].value+"/";
				comparechk_bLimit1+=  form.comparechk_bLimit[i].value+"/";
				comparechk_limitCnt1+=  form.comparechk_limitCnt[i].value+"/";
			}
		}
	}
	else
	{
		compareIdx = form.comparechk.value + "/";
		comparechk_bLimit1 = form.comparechk_bLimit.value + "/";
		comparechk_limitCnt1 = form.comparechk_limitCnt.value + "/";
	}
	form.idxstr.value = compareIdx;
	form.bLimitstr.value = comparechk_bLimit1;
	form.limitCntstr.value = comparechk_limitCnt1;
}
function compareGo()
{
	var form = document.compareForm;
	var idxstr = form.idxstr.value;
	var bLimitstr = form.bLimitstr.value;
	var limitCntstr = form.limitCntstr.value;
	if (idxstr == "")
	{
		alert("비교품목에 담을 상품을 선택해 주세요.");
	}
	else
	{
		var idxstr_arr = idxstr.split("/");
		var bLimit_arr = bLimitstr.split("/");
		var limitCnt_arr = limitCntstr.split("/");
		for (var i=0; i<idxstr_arr.length; i++)
		{
			if ((bLimit_arr[i]==1 && limitCnt_arr[i]==0) || bLimit_arr[i]==2)
			{
				alert("품절인 상품은 비교품목에 담을수 없습니다.");
				return false;
			}
		}
		window.open("compare_ok.php?idxstr="+idxstr,"","scrollbars=no,width=450,height=235,top=300,left=300");
	}
}
function cartGo()
{
	var form = document.compareForm;
	var idxstr = form.idxstr.value;
	var bLimitstr = form.bLimitstr.value;
	var limitCntstr = form.limitCntstr.value;
	if (idxstr == "")
	{
		alert("장바구니에 담을 상품을 선택해 주세요.");
	}
	else
	{
		var idxstr_arr = idxstr.split("/");
		var bLimit_arr = bLimitstr.split("/");
		var limitCnt_arr = limitCntstr.split("/");
		for (var i=0; i<idxstr_arr.length; i++)
		{
			if ((bLimit_arr[i]==1 && limitCnt_arr[i]==0) || bLimit_arr[i]==2)
			{
				alert("품절인 상품은 장바구니에 담을수 없습니다.");
				return false;
			}
		}
		window.open("cart2_ok.php?idxstr="+idxstr,"","scrollbars=no,width=450,height=225,top=300,left=300");
	}
}
function interestGo()
{
	var form = document.compareForm;
	var idxstr = form.idxstr.value;
	var bLimitstr = form.bLimitstr.value;
	var limitCntstr = form.limitCntstr.value;
	if (idxstr == "")
	{
		alert("관심품목에 담을 상품을 선택해 주세요.");
	}
	else
	{
		var idxstr_arr = idxstr.split("/");
		var bLimit_arr = bLimitstr.split("/");
		var limitCnt_arr = limitCntstr.split("/");
		for (var i=0; i<idxstr_arr.length; i++)
		{
			if ((bLimit_arr[i]==1 && limitCnt_arr[i]==0) || bLimit_arr[i]==2)		
			{
				alert("품절인 상품은 관심품목에 담을수 없습니다.");
				return false;
			}
		}
		window.open("interest2_ok.php?idxstr="+idxstr,"","scrollbars=no,width=450,height=235,top=300,left=300");
	}
}
//-->
</SCRIPT>
<? include "top.php";?>
<table width="900" border="0" cellspacing="0" cellpadding="0" bgcolor="<?=$ALL_BGCOLOR?>">
	<tr>
		<? include "left_menu.php";?>
		<td  valign="top" width="720" bgcolor="#FFFFFF">
			<table width="720" border="0" cellspacing="0" cellpadding="0">
				<tr bgcolor="#FFFFFF" valign="top">
					<td colspan="4">
						<table width="720" height="30" border="0" cellspacing="0" cellpadding="0" align='center'>
							<tr><?
								if($category_info[img3])
								{
									// 카테고리 이미지3
									?>
								<td width="220" height="25" bgcolor="<?=$subdesign[bc1]?>"><img src="./upload/category/<?=$category_info[img3]?>"></td><?
								}
								else
								{
									?>
								<td width="310" height="25" bgcolor="<?=$subdesign[bc1]?>"><font color="<?=$subdesign[tc1]?>"> > <?=$category_info[name]?></font></td><?
								}
								?>
								<td height="25" bgcolor="<?=$subdesign[bc1]?>"><div align="right"> &nbsp;<font color="<?=$subdesign[tc1]?>"> <img src='image/good/icon0.gif'> 현재위치 : <a href="index.php"><font color="<?=$subdesign[tc1]?>">HOME</font></a><?=$str_category?></font>&nbsp;</div></td>
							</tr>
						</table>
					</td>
				</tr>
				<!-- 카테고리 이미지 시작 --><?
				if ($category_info[img4])
				{
					?>
				<tr>
					<td colspan="4"><img src="upload/category/<?=$category_info[img4]?>" width="720" height="200"></td>
				</tr><?
				}
				?>
				<!-- 카테고리 이미지 끝 -->
				<tr>
					<td colspan='4' height='5'></td>
				</tr>
				<!-- 카테고리 개별 중앙 베너 -->
				<tr>
					<td colspan='4'>
						<table width="720" border="0" cellspacing="0" cellpadding="0"><?
						$ban_qry = "select *from category_banner where position ='$category_info[code]' order by sunwi asc";
						$ban_result = @$MySQL->query($ban_qry) or die("Err. : $ban_qry");
						$ban_cnt =1;
						while($ban_row = mysql_fetch_array($ban_result))
						{
							if ($ban_cnt % $category_info[midBannerCols] == 1) echo "<tr>";
							$img = "upload/design/$ban_row[img]";
							if($ban_row[type]==4)
							{
								//플래시
								$img_info = @getimagesize($img);
								$swf_width = $img_info[0];
								$swf_height = $img_info[1];
								?>
								<td align="center">
									<script language='javascript'>
										getFlash("<?=$img?>", "<?=$swf_width?>", "<?=$swf_height?>");
									</script>
								</td><?
							}
							else
							{
								//이미지
								if($ban_row[gubun]==0)
								{
									if ($ban_row[siteTarget] == "_blank") $http = "http://";
									?><!-- 일반링크 -->
								<td align="center"><a href="<?=$http?><?=$ban_row[siteUrl]?>" target="<?=$ban_row[siteTarget]?>"> <img src="<?=$img?>" border="0"></a></td><?
								}
								else if($ban_row[gubun]==1)
								{
									?><!-- 상품 링크 -->
								<td align="center"><a href="goods_detail.php?goodsIdx=<?=$ban_row[goodsUrl]?>"><img src="<?=$img?>" border="0"></a></td><?
								}
								else
								{
									?><!-- 링크없음 -->
								<td align="center"><img src="<?=$img?>"></td><?
								}
							}
							if ($ban_cnt % $category_info[midBannerCols] == 0) echo "</tr>";
							$ban_cnt ++;
						}
						?>
						</table>
					</td>
				</tr>
				<!-- 카테고리 개별 중앙 베너 끝 -->
				<tr>
					<td width="720" valign="top"><?
					$re_com_qry = "select * from position where category='$category_info[code]' and part='recommend' limit 1";
					$best_qry = "select *from position where category='$category_info[code]' and part='best' order by sunwi asc";
					$re_com_articles=$MySQL->articles($re_com_qry);
					$best_articles=$MySQL->articles($best_qry);
					if($re_com_articles+$best_articles>0)
					{
					?>
						<table width="700" border="0" cellspacing="0" cellpadding="0" align="center">
							<tr>
								<td colspan='2' bgcolor="cccccc" height="1"></td>
							</tr>
							<tr>
								<td colspan='2' bgcolor="f2f2f2" height="1"></td>
							</tr>
							<tr>
								<td colspan='2'>&nbsp;</td>
							</tr>
							<tr>
								<td colspan="2">
									<table width="720" border="0" cellspacing="0" cellpadding="0">
										<tr><?
										$re_com_result = $MySQL->query($re_com_qry);
										$re_com_row = mysql_fetch_array($re_com_result);
										if ($re_com_row)
										{
											$goods_row = $MySQL->fetch_array("SELECT *from goods WHERE idx=$re_com_row[goodsIdx] limit 1");
											$gprice = new CGoodsPrice($goods_row[idx]);
											?>
											<td width="300">
												<!-- 베스트 상품(대) 시작 -->
												<table width="300" border="0" cellspacing="0" cellpadding="0" valign="middle">
													<tr>
														<td height="30">&nbsp;&nbsp;<img src="upload/catebest_img"></td>
													</tr><?
													$CATE_RECOM = 1;
													$LINK = "goods_detail.php?goodsIdx=$goods_row[idx]";
													include "goods_detail_inc.php";
													$CATE_RECOM = 0;
													?>
												</table>
												<!-- 베스트 상품(대) 끝 -->
											</td>
											<td background="image/index/dot_height2.gif" width="1"></td><?
										}
										if($best_articles>0)
										{
										?>
											<td valign="top">
												<!-- 베스트 상품 시작 -->
												<table width="390" border="0" cellspacing="0" cellpadding="0">
													<tr><?
													$best_result = $MySQL->query($best_qry);
													while ($best_row = mysql_fetch_array($best_result))
													{
														$goods_row = $MySQL->fetch_array("SELECT *from goods WHERE idx=$best_row[goodsIdx] limit 1");
														$gprice = new CGoodsPrice($goods_row[idx]);
														$best_cnt++;
														?>
														<td align="center">
															<table width="209" border="0" cellspacing="0" cellpadding="0"><?
															$CATE_BEST = 1;
															$LINK = "goods_detail.php?goodsIdx=$goods_row[idx]";
															include "goods_detail_inc.php";
															$CATE_BEST = 0;
															?>
															</table>
														</td><?
														if(!($best_cnt%2) && $best_cnt!=4)
														{
															?>
													</tr>
													<tr>
														<td colspan="2" height="1" background="image/index/dot_width.gif"></td>
													</tr>
													<tr><?
														}
													}
													if($best_cnt%2)
													{
														//빈칸
														?>
														<td align="center" width="209">&nbsp;</td><?
													}
													?>
													</tr>
												</table>
												<!-- 베스트 상품 끝 -->
											</td><?
										}
										?>
										</tr>
									</table>
								</td>
							</tr>
							<tr>
								<td colspan='2' height='15'></td>
							</tr>
						</table><?
					}
					?>
						<table width="700" border="0" cellspacing="0" cellpadding="0" align="center"><?
						if ($category_info[designType] && $design_goods[designTypeCommon]=="n")
						{
							$designType = $category_info[designType];
							$GOODS_LIST_COL		= $category_info[goodsListW];
							$GOODS_LIST_ROW		= $category_info[goodsListH];
						}
						else
						{
							$designType = $design_goods[designType];
							$GOODS_LIST_COL		= $design_goods[goodsListW];
							$GOODS_LIST_ROW		= $design_goods[goodsListH];
						}
						$GOODS_LIST_COL_PER        = $GOODS_LIST_COL-1;
						$LIST_LIMIT		= $GOODS_LIST_COL *$GOODS_LIST_ROW;
						$GOODS_LIST_WIDTH 		= 720 / $GOODS_LIST_COL;
						?>
							<tr valign="top">
								<td colspan="2">
									<table width="720" border="0" cellspacing="0" cellpadding="0" align='center'>
										<tr valign="middle">
											<td height="30" colspan="<?=$GOODS_LIST_COL?>" valign="middle">
												<form name="sortForm" method="post" action="goods_list.php">
												<input type="hidden" name="Index" value="<?=$Index?>">
												<table width="720" border="0" cellspacing="0" cellpadding="0" align='center' background='image/good/goods.gif'>
													<tr>
														<td height='50'>&nbsp;</td>
														<td width='300'>현 카테고리에서 상품검색&nbsp;<input type="text" class="box" name="searchstring" value="<?=$searchstring?>" size=15 onKeyPress="if (window.event.keyCode==13) goodsSearch();">&nbsp;<a href="javascript:goodsSort();"><img src="upload/design/<?=$design[mainGoodsSearchButton]?>" border=0 align='absmiddle'></a></td>
														<td width='100'><select name="Sort" onChange="javascript:goodsSort();" class="box"><option value="0">상품정렬기준</option><option value="1">이름순 △</option><option value="2">이름순 ▽</option><option value="3">가격순 △</option><option value="4">가격순 ▽</option></select></td>
													</tr>
												</table>
												</form>
											</td>
										</tr>
										<tr>
											<td bgcolor="f2f2f2" height="2" colspan="<?=$GOODS_LIST_COL?>"></td>
										</tr>
										<tr>
											<td bgcolor="cccccc" height="1" colspan="<?=$GOODS_LIST_COL?>"></td>
										</tr>
										<form name="compareForm" method="post">
										<input type="hidden" name="idxstr" value="">
										<input type="hidden" name="bLimitstr" value="">
										<input type="hidden" name="limitCntstr" value="">
										<!-- 상품 목록 시작 -->
										<tr valign="bottom"><?
										$data=Decode64($data);
										$pagecnt=$data[pagecnt];
										$offset=$data[offset];
										$new_str = SearchCheck($searchstring); // 검색어를 영문만 대문자로 바꾼 문자열 
										$total_list_qry = $total_qry;
										if($searchstring) $total_list_qry.=" and (name like '%$searchstring%' or name like '%$new_str%')";
										if(empty($sort)) $total_list_qry.= "order by setVal asc,idx desc";
										else $total_list_qry.= "order by $sortStr $sort,idx desc";
										$numresults=$MySQL->query($total_list_qry);
										$numrows=mysql_num_rows($numresults);				//총 레코드수..
										$LIMIT		=$LIST_LIMIT;    		//페이지당 글 수
										$PAGEBLOCK	=10;								//블럭당 페이지 수
										if($pagecnt==""){$pagecnt=0;}						//페이지 번호 
										if(!$offset){$offset=$pagecnt*$LIMIT*$PAGEBLOCK;} //각 페이지의 시작 글  
										if(!$letter_no){$letter_no=$numrows;}				//글번호
										$list_qry = $total_list_qry." limit $offset,$LIMIT";
										$goods_result=$MySQL->query($list_qry);
										$list_cnt =0;										//현재페이지 상품 카운트
										$GOODS_LIST_PAGE =1;
										include "goods_show_inc.php";
										?>
										</form><?
										$OptionStr = "Index=$Index&sort=$sort&sortStr=$sortStr&searchstring=$searchstring";
										$Obj=new CList("goods_list.php",$pagecnt,$offset,$numrows,$PAGEBLOCK,$LIMIT,$search,$searchstring,$OptionStr);
										?>
										</tr>
										<tr valign="bottom">
											<td colspan="<?=$GOODS_LIST_COL?>" height="20"></td>
										</tr>
										<tr valign="bottom">
											<td colspan="<?=$GOODS_LIST_COL?>" align=right><a href="#;" onclick="javascript:compareGo();"><img src='image/work/compare_btn.gif' border='0'></a>&nbsp;<a href="#;" onclick="javascript:cartGo();"><img src='image/work/cart_btn.gif' border='0'></a><?
											if ($_SESSION[GOOD_SHOP_PART]=="member")
											{
												?>&nbsp;<a href="#;" onclick="javascript:interestGo();"><img src='image/work/interest_btn.gif' border='0'></a><?
											}
											?></td>
										</tr>
										<tr valign="bottom">
											<td colspan="<?=$GOODS_LIST_COL?>" height="50"> <div align="center"><?$Obj->putList(false,"","");//이전다음 프린트?></div></td>
										</tr>
										<!-- 상품 목록 끝 -->
									</table>
								</td>
							</tr>
							<tr>
								<td colspan="2">&nbsp;</td>
							</tr>
						</table>
					</td>
					<td width="1" bgcolor="#dadada"></td>
				</tr>
			</table>
		</td>
	</tr>
</table>
<? include "copy.php"; ?>
</div>
</body>
</html>