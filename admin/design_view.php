								<table width="100%" border="0" cellspacing="0" cellpadding="0" align='center'>
									<tr align=center><?
									if ($main)
									{
										$img = "image/design_navigation.swf";
										$img_info = @getimagesize($img);
										$swf_width = $img_info[0];
										$swf_height = $img_info[1];
										?>
										<td>
											<script language='javascript'>
												getFlash("<?=$img?>", "<?=$swf_width?>", "<?=$swf_height?>");
											</script>
										</td><?
									}
									else
									{
										?>
										<td><img src="image/design_view1.gif"></td>
										<td>
											<table width="100%" border="1" cellspacing="0" cellpadding="10" align="center" bordercolor="#FFD28E" bordercolordark="#ffffff" height="50">
												<tr>
													<td bgcolor="#FFF3E1" style="font-size: 9pt">
													A - 쇼핑몰 상단에 해당하며 상점로고 / 상단메뉴 / 검색 / 상단 배너<br><br>
													B - 쇼핑몰 타이틀 이미지 / 공지사항 <br><br>
													B-1 - 메인중앙 3개 영역 베너이미지 등록 <br><br>
													C - 상품 카테고리 / 로그인 관련 / 공지사항 <br><br>
													D - 신상품전 / 좌측 배너 / 설문조사  <br><br>
													E - 베스트 상품전 <br><br>
													F - 히트 상품전 / 고객맞춤상품 타이틀 이미지<br><br>
													G - 하단 메뉴 및 카피라이터 <br><br></td>
												</tr>
											</table>
										</td><?
									}
									?>
									</tr>
								</table>