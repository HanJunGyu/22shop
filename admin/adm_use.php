<?
include "head.php";
?>
<SCRIPT LANGUAGE="JavaScript">
<!--
function useSendit(editVar)
{
	var form=document.adm_useForm;
	form.action="adm_use_ok.php?editVar="+editVar;
	form.submit();
}
//-->
</SCRIPT>
<body bgcolor="#FFFFFF" text="#5A595A" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<? include "top_menu.php"; ?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr><?
	$__TOP_MENU = "basic";		//왼쪽 소메뉴 설정 변수
	include "left_menu.php";
	if(!defined(__ADMIN_ROW))
	{
		define(__ADMIN_ROW,"TRUE");
		$admin_row=$MySQL->fetch_array("select *from admin limit 0,1"); //관리자 정보 배열
	}
	if($admin_row[useShopmap])
	{
		$true_useShopmap  = "checked";
		$false_useShopmap = "";
	}
	else
	{
		$true_useShopmap  = "";
		$false_useShopmap = "checked";
	}
	?>
		<td width="85%" valign="top">
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td height='5'></td>
				</tr>
				<tr>
					<td>
						<table width="750" border="0" cellspacing="0" cellpadding="0" align='center'>
							<tr>
								<td rowspan="3" width="200"><img src="image/account_tit_.gif"></td>
								<td>&nbsp;</td>
							</tr>
							<tr>
								<td bgcolor="#E6E6E6" height='26'><div align='right'><font class='text1'>SHOP 기본정보를 수정하실수 있습니다&nbsp;</div></td>
							</tr>
							<tr>
								<td>&nbsp;</td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td>
						<table width="750" border="0" cellspacing="0" cellpadding="0" align="center" height="900">
							<tr>
								<td colspan="2">
									<table width="750" border="0" cellspacing="1" cellpadding="0" bgcolor='cdcdcd'>
										<tr bgcolor='f6f6f6'>
											<td width="150" height="25" onMouseOver="this.style.backgroundColor='#FFFFFF'" onMouseOut="this.style.backgroundColor='#f6f6f6'"> <div align="center"><a href="#1" style="width:100%; padding:10 0 10 0">개인정보 보호정책</a></div></td>
											<td onMouseOver="this.style.backgroundColor='#FFFFFF'" onMouseOut="this.style.backgroundColor='#f6f6f6'"> <div align="center"><a href="#2" style="width:100%; padding:10 0 10 0">쇼핑몰 이용안내</a></div></td>
											<td onMouseOver="this.style.backgroundColor='#FFFFFF'" onMouseOut="this.style.backgroundColor='#f6f6f6'"> <div align="center"><a href="#3" style="width:100%; padding:10 0 10 0">회원가입혜택</a></div></td>
											<td onMouseOver="this.style.backgroundColor='#FFFFFF'" onMouseOut="this.style.backgroundColor='#f6f6f6'"> <div align="center"><a href="#4" style="width:100%; padding:10 0 10 0">회원가입 약관</a></div></td>
											<td onMouseOver="this.style.backgroundColor='#FFFFFF'" onMouseOut="this.style.backgroundColor='#f6f6f6'"> <div align="center"><a href="#10" style="width:100%; padding:10 0 10 0">가입완료 메세지</a></div></td>
											<td onMouseOver="this.style.backgroundColor='#FFFFFF'" onMouseOut="this.style.backgroundColor='#f6f6f6'"> <div align="center"><a href="#5" style="width:100%; padding:10 0 10 0">장바구니 이용안내</a></div></td>
										</tr>
										<tr bgcolor='f6f6f6'>
											<td height="25" onMouseOver="this.style.backgroundColor='#FFFFFF'" onMouseOut="this.style.backgroundColor='#f6f6f6'"> <div align="center"><a href="#6" style="width:100%; padding:10 0 10 0">배송정보</a></div></td>
											<td onMouseOver="this.style.backgroundColor='#FFFFFF'" onMouseOut="this.style.backgroundColor='#f6f6f6'"> <div align="center"><a href="#9" style="width:100%; padding:10 0 10 0">제휴안내</a></div></td>
											<td onMouseOver="this.style.backgroundColor='#FFFFFF'" onMouseOut="this.style.backgroundColor='#f6f6f6'"> <div align="center"><a href="#7" style="width:100%; padding:10 0 10 0">회사소개</a></div></td>
											<td onMouseOver="this.style.backgroundColor='#FFFFFF'" onMouseOut="this.style.backgroundColor='#f6f6f6'"> <div align="center"><a href="#8" style="width:100%; padding:10 0 10 0">약도</a></div></td>
											<td onMouseOver="this.style.backgroundColor='#FFFFFF'" onMouseOut="this.style.backgroundColor='#f6f6f6'"> <div align="center"><a href="#12" style="width:100%; padding:10 0 10 0">주문완료 페이지</a></div></td>
											<td></td>
										</tr>
									</table>
								</td>
							</tr>
							<tr>
								<td height='10' colspan='2'></td>
							</tr>
							<form name="adm_useForm" method="post" enctype="multipart/form-data" >
							<tr>
								<td colspan="2"><a name="1"></a>
									<table width="750" border="0" cellspacing="0" cellpadding="0" align="center">
										<tr>
											<td height='1' bgcolor='DADADA'></td>
										</tr>
										<tr>
											<td width='440'><img src="image/use_min_data.gif"></td>
										</tr>
										<tr>
											<td height='1' bgcolor='DADADA'></td>
										</tr>
									</table>
								</td>
							</tr>
							<tr>
								<td colspan="2" height="30" align="center"><input type="radio" name="xSave_bhtml" value="1" <?if($admin_row[xSave_bhtml]) echo"checked";?>> HTML&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="xSave_bhtml" value="0" <?if(!$admin_row[xSave_bhtml]) echo"checked";?>> TEXT </td>
							</tr>
							<tr>
								<td colspan="2" height="55" valign="top"> <div align="center"> <textarea name="xSave" cols="115" rows="10"  class="text"><?=$admin_row[xSave]?></textarea></div></td>
							</tr>
							<tr>
								<td colspan="2" height="30" valign="top"><br>
									<table width="50%" border="0" align="center" cellpadding="0" cellspacing="0">
										<tr>
											<td> <div align="center"><a href="javascript:useSendit('xSave');"><img src="image/ok_btn.gif" width="40" height="17" border="0"></a></div></td>
											<td> <div align="center"><a href="javascript:formClear(document.adm_useForm);"><img src="image/cancel_btn.gif" width="40" height="17" border="0"></a></div></td>
										</tr>
									</table>
								</td>
							</tr>
							<tr>
								<td colspan="2" height="50"><div align="center"><a name="2"></a>
									<table width="750" border="0" cellspacing="0" cellpadding="0" align="center">
										<tr>
											<td height='1' colspan='3' bgcolor='DADADA'></td>
										</tr>
										<tr>
											<td width='440'><img src="image/use_min_use.gif"></td>
										</tr>
										<tr>
											<td height='1' colspan='3' bgcolor='DADADA'></td>
										</tr>
									</table></div>
								</td>
							</tr>
							<tr>
								<td colspan="2" height="30" align="center"><input type="radio" name="xUse_bhtml" value="1" <?if($admin_row[xUse_bhtml]) echo"checked";?>> HTML&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="xUse_bhtml" value="0" <?if(!$admin_row[xUse_bhtml]) echo"checked";?>> TEXT </td>
							</tr>
							<tr>
								<td colspan="2" height="55" valign="top"><div align="center"> <textarea name="xUse" cols="115" rows="10"  class="text"><?=$admin_row[xUse]?></textarea></div></td>
							</tr>
							<tr>
								<td colspan="2" height="30" valign="middle">
									<table width="50%" border="0" align="center" cellpadding="0" cellspacing="0">
										<tr>
											<td> <div align="center"><a href="javascript:useSendit('xUse');"><img src="image/ok_btn.gif" width="40" height="17" border="0"></a></div></td>
											<td> <div align="center"><a href="javascript:formClear(document.adm_useForm);"><img src="image/cancel_btn.gif" width="40" height="17" border="0"></a></div></td>
										</tr>
									</table>
								</td>
							</tr>
							<tr>
								<td colspan="2" height="50"><a name="3"></a>
									<table width="750" border="0" cellspacing="0" cellpadding="0" align="center">
										<tr>
											<td height='1' colspan='3' bgcolor='DADADA'></td>
										</tr>
										<tr>
											<td width='440'><img src="image/use_min_benefit.gif"></td>
										</tr>
										<tr>
											<td height='1' colspan='3' bgcolor='DADADA'></td>
										</tr>
									</table>
								</td>
							</tr>
							<tr>
								<td colspan="2" height="30" align="center"><input type="radio" name="xProfit_bhtml" value="1" <?if($admin_row[xProfit_bhtml]) echo"checked";?>> HTML&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="xProfit_bhtml" value="0" <?if(!$admin_row[xProfit_bhtml]) echo"checked";?>> TEXT </td>
							</tr>
							<tr>
								<td colspan="2" height="55" valign="top"> <div align="center"> <textarea name="xProfit" cols="115" rows="10"  class="text"><?=$admin_row[xProfit]?></textarea></div></td>
							</tr>
							<tr>
								<td colspan="2" height="30" valign="middle">
									<table width="50%" border="0" align="center" cellpadding="0" cellspacing="0">
										<tr>
											<td> <div align="center"><a href="javascript:useSendit('xProfit');"><img src="image/ok_btn.gif" width="40" height="17" border="0"></a></div></td>
											<td> <div align="center"><a href="javascript:formClear(document.adm_useForm);"><img src="image/cancel_btn.gif" width="40" height="17" border="0"></a></div></td>
										</tr>
									</table>
								</td>
							</tr>
							<tr>
								<td colspan="2" height="50"><a name="4"></a>
									<table width="750" border="0" cellspacing="0" cellpadding="0" align="center">
										<tr>
											<td height='1' colspan='3' bgcolor='DADADA'></td>
										</tr>
										<tr>
											<td width='440'><img src="image/use_min_article.gif"></td>
										</tr>
										<tr>
											<td height='1' colspan='3' bgcolor='DADADA'></td>
										</tr>
									</table>
								</td>
							</tr>
							<tr>
								<td colspan="2" height="30" align="center">※ TEXTAREA 이므로 HTML사용 불가 <input type="hidden" name="xReg_bhtml" value="0" checked></td>
							</tr>
							<tr>
								<td colspan="2" height="55" valign="top"> <div align="center"> <textarea name="xReg" cols="115" rows="10"  class="text"><?=$admin_row[xReg]?></textarea></div></td>
							</tr>
							<tr>
								<td colspan="2" height="30" valign="middle">
									<table width="50%" border="0" align="center" cellpadding="0" cellspacing="0">
										<tr>
											<td> <div align="center"><a href="javascript:useSendit('xReg');"><img src="image/ok_btn.gif" width="40" height="17" border="0"></a></div></td>
											<td> <div align="center"><a href="javascript:formClear(document.adm_useForm);"><img src="image/cancel_btn.gif" width="40" height="17" border="0"></a></div></td>
										</tr>
									</table>
								</td>
							</tr>
							<tr>
								<td colspan="2" height="50"><a name="10"></a>
									<table width="750" border="0" cellspacing="0" cellpadding="0" align="center">
										<tr>
											<td height='1' colspan='3' bgcolor='DADADA'></td>
										</tr>
										<tr>
											<td width='440'><img src="image/use_min_end.gif"></td>
										</tr>
										<tr>
											<td height='1' colspan='3' bgcolor='DADADA'></td>
										</tr>
									</table>
								</td>
							</tr>
							<tr>
								<td colspan="2" height="30" align="center"><input type="radio" name="xJoin_bhtml" value="1" <?if($admin_row[xJoin_bhtml]) echo"checked";?>> HTML&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="xJoin_bhtml" value="0" <?if(!$admin_row[xJoin_bhtml]) echo"checked";?>> TEXT </td>
							</tr>
							<tr>
								<td colspan="2" height="55" valign="top"> <div align="center"> <textarea name="xJoin" cols="115" rows="10"  class="text"><?=$admin_row[xJoin]?></textarea></div></td>
							</tr>
							<tr>
								<td colspan="2" height="30" valign="middle">
									<table width="50%" border="0" align="center" cellpadding="0" cellspacing="0">
										<tr>
											<td> <div align="center"><a href="javascript:useSendit('xJoin');"><img src="image/ok_btn.gif" width="40" height="17" border="0"></a></div></td>
											<td> <div align="center"><a href="javascript:formClear(document.adm_useForm);"><img src="image/cancel_btn.gif" width="40" height="17" border="0"></a></div></td>
										</tr>
									</table>
								</td>
							</tr>
							<tr>
								<td colspan="2" height="50"><a name="5"></a>
									<table width="750" border="0" cellspacing="0" cellpadding="0" align="center">
										<tr>
											<td height='1' colspan='3' bgcolor='DADADA'></td>
										</tr>
										<tr>
											<td width='440'><img src="image/use_min_basket.gif"></td>
										</tr>
										<tr>
											<td height='1' colspan='3' bgcolor='DADADA'></td>
										</tr>
									</table>
								</td>
							</tr>
							<tr>
								<td colspan="2" height="30" align="center"><input type="radio" name="xCart_bhtml" value="1" <?if($admin_row[xCart_bhtml]) echo"checked";?>> HTML&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="xCart_bhtml" value="0" <?if(!$admin_row[xCart_bhtml]) echo"checked";?>> TEXT </td>
							</tr>
							<tr>
								<td colspan="2" height="55" valign="top"> <div align="center"> <textarea name="xCart" cols="115" rows="10"  class="text"><?=$admin_row[xCart]?></textarea></div></td>
							</tr>
							<tr>
								<td colspan="2" height="30" valign="middle">
									<table width="50%" border="0" align="center" cellpadding="0" cellspacing="0">
										<tr>
											<td> <div align="center"><a href="javascript:useSendit('xCart');"><img src="image/ok_btn.gif" width="40" height="17" border="0"></a></div></td>
											<td> <div align="center"><a href="javascript:formClear(document.adm_useForm);"><img src="image/cancel_btn.gif" width="40" height="17" border="0"></a></div></td>
										</tr>
									</table>
								</td>
							</tr>
							<tr>
								<td colspan="2" height="50"><a name="6"></a>
									<table width="750" border="0" cellspacing="0" cellpadding="0" align="center">
										<tr>
											<td height='1' colspan='3' bgcolor='DADADA'></td>
										</tr>
										<tr>
											<td width='440'><img src="image/use_min_send.gif"></td>
										</tr>
										<tr>
											<td height='1' colspan='3' bgcolor='DADADA'></td>
										</tr>
									</table>
								</td>
							</tr>
							<tr>
								<td colspan="2" height="30" align="center"><input type="radio" name="xTrans_bhtml" value="1" <?if($admin_row[xTrans_bhtml]) echo"checked";?>> HTML&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="xTrans_bhtml" value="0" <?if(!$admin_row[xTrans_bhtml]) echo"checked";?>> TEXT </td>
							</tr>
							<tr>
								<td colspan="2" height="55" valign="top"> <div align="center"> <textarea name="xTrans" cols="115" rows="10"  class="text"><?=$admin_row[xTrans]?></textarea></div></td>
							</tr>
							<tr>
								<td colspan="2" height="30" valign="middle">
									<table width="50%" border="0" align="center" cellpadding="0" cellspacing="0">
										<tr>
											<td> <div align="center"><a href="javascript:useSendit('xTrans');"><img src="image/ok_btn.gif" width="40" height="17" border="0"></a></div></td>
											<td> <div align="center"><a href="javascript:formClear(document.adm_useForm);"><img src="image/cancel_btn.gif" width="40" height="17" border="0"></a></div></td>
										</tr>
									</table>
								</td>
							</tr>
							<tr>
								<td colspan="2" height="50"><a name="9"></a>
									<table width="750" border="0" cellspacing="0" cellpadding="0" align="center">
										<tr>
											<td height='1' colspan='3' bgcolor='DADADA'></td>
										</tr>
										<tr>
											<td width='440'><img src="image/use_min_cooperation.gif"></td>
										</tr>
										<tr>
											<td height='1' colspan='3' bgcolor='DADADA'></td>
										</tr>
									</table>
								</td>
							</tr>
							<tr>
								<td colspan="2" height="30" align="center"><input type="radio" name="xCoop_bhtml" value="1" <?if($admin_row[xCoop_bhtml]) echo"checked";?>> HTML&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="xCoop_bhtml" value="0" <?if(!$admin_row[xCoop_bhtml]) echo"checked";?>> TEXT </td>
							</tr>
							<tr>
								<td colspan="2" height="55"> <div align="center"> <textarea name="xCoop" cols="115" rows="10"  class="text"><?=$admin_row[xCoop]?></textarea></div></td>
							</tr>
							<tr>
								<td colspan="2" height="30">
									<table width="50%" border="0" align="center" cellpadding="0" cellspacing="0">
										<tr>
											<td> <div align="center"><a href="javascript:useSendit('xCoop');"><img src="image/ok_btn.gif" width="40" height="17" border="0"></a></div></td>
											<td> <div align="center"><a href="javascript:formClear(document.adm_useForm);"><img src="image/cancel_btn.gif" width="40" height="17" border="0"></a></div></td>
										</tr>
									</table>
								</td>
							</tr>
							<tr>
								<td colspan="2" height="50"><a name="7"></a>
									<table width="750" border="0" cellspacing="0" cellpadding="0" align="center">
										<tr>
											<td height='1' colspan='3' bgcolor='DADADA'></td>
										</tr>
										<tr>
											<td width='440'><img src="image/use_min_com.gif"></td>
										</tr>
										<tr>
											<td height='1' colspan='3' bgcolor='DADADA'></td>
										</tr>
									</table>
								</td>
							</tr>
							<tr>
								<td colspan="2" height="30" align="center"><input type="radio" name="xCom_bhtml" value="1" <?if($admin_row[xCom_bhtml]) echo"checked";?>> HTML&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="xCom_bhtml" value="0" <?if(!$admin_row[xCom_bhtml]) echo"checked";?>> TEXT </td>
							</tr>
							<tr>
								<td colspan="2" height="55" valign="top"> <div align="center"> <textarea name="xCom" cols="115" rows="10"  class="text"><?=$admin_row[xCom]?></textarea></div></td>
							</tr>
							<tr>
								<td colspan="2" height="30" valign="middle">
									<table width="50%" border="0" align="center" cellpadding="0" cellspacing="0">
										<tr>
											<td> <div align="center"><a href="javascript:useSendit('xCom');"><img src="image/ok_btn.gif" width="40" height="17" border="0"></a></div></td>
											<td> <div align="center"><a href="javascript:formClear(document.adm_useForm);"><img src="image/cancel_btn.gif" width="40" height="17" border="0"></a></div></td>
										</tr>
									</table>
								</td>
							</tr>
							<tr>
								<td colspan="2" height="50"><a name="8"></a>
									<table width="750" border="0" cellspacing="0" cellpadding="0" align="center">
										<tr>
											<td height='1' colspan='3' bgcolor='DADADA'></td>
										</tr>
										<tr>
											<td width='440'><img src="image/use_min_map.gif"></td>
										</tr>
										<tr>
											<td height='1' colspan='3' bgcolor='DADADA'></td>
										</tr>
									</table>
								</td>
							</tr>
							<tr>
								<td colspan="2" height="100" valign="top">
									<table width="500" border="0" cellspacing="0" cellpadding="0" align="center">
										<tr>
											<td valign="top">
												<table width="100%" border="0" cellspacing="1" cellpadding="0" bgcolor="#CCCCCC">
													<tr>
														<td bgcolor="#FFFFFF" valign="top" align="center"> <img src="../upload/shop_map_img"  > </td>
													</tr>
												</table>
											</td>
										</tr>
										<tr height="60">
											<td height="60" valign="middle"> <input type="radio" class="radio" name="useShopmap" value="1" <?=$true_useShopmap?>> 사용&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" class="radip" name="useShopmap" value="0" <?=$false_useShopmap?>> 미사용</td>
										</tr>
										<tr height="30">
											<td height="30" valign="middle"> <input type="file" class="box" name="mapImg">&nbsp;&nbsp; <a href="javascript:useSendit('mapImg');"><img src="image/save_btn.gif" width="40" height="17" border="0"></a> </td>
										</tr>
									</table>
								</td>
							</tr>
							<tr>
								<td colspan="2" height="50"><a name="12"></a>
									<table width="750" border="0" cellspacing="0" cellpadding="0" align="center">
										<tr>
											<td height='1' colspan='3' bgcolor='DADADA'></td>
										</tr>
										<tr>
											<td width='440'><img src="image/use_min_order.gif"></td>
										</tr>
										<tr>
											<td height='1' colspan='3' bgcolor='DADADA'></td>
										</tr>
									</table>
								</td>
							</tr>
							<tr>
								<td colspan="2" height="30" align="center"><input type="radio" name="xOrder_bhtml" value="1" <?if($admin_row[xOrder_bhtml]) echo"checked";?>> HTML&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="xOrder_bhtml" value="0" <?if(!$admin_row[xOrder_bhtml]) echo"checked";?>> TEXT </td>
							</tr>
							<tr>
								<td colspan="2" height="55" valign="top"> <div align="center"> <textarea name="xOrder" cols="115" rows="10"  class="text"><?=$admin_row[xOrder]?></textarea></div></td>
							</tr>
							<tr>
								<td colspan="2" height="30" valign="middle">
									<table width="50%" border="0" align="center" cellpadding="0" cellspacing="0">
										<tr>
											<td> <div align="center"><a href="javascript:useSendit('xOrder');"><img src="image/ok_btn.gif" width="40" height="17" border="0"></a></div></td>
											<td> <div align="center"><a href="javascript:formClear(document.adm_useForm);"><img src="image/cancel_btn.gif" width="40" height="17" border="0"></a></div></td>
										</tr>
									</table>
								</td>
							</tr></form><!-- adm_useForm -->
						</table>
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>
<? include "copy.php";?>
</body>
</html>