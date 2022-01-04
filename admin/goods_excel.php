<?
include "head.php";
?>
<SCRIPT LANGUAGE="JavaScript">
<!--
function etcSendit()
{
	if (document.adm_etcForm.csv_file.value=="")
	{
		alert("CSV 파일을 선택하여 주십시오.");
	}
	else
	{
		document.adm_etcForm.submit();
	}
}
//-->
</SCRIPT>
<body bgcolor="#FFFFFF" text="#5A595A" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<? include "top_menu.php"; ?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr><?
	$__TOP_MENU = "goods";     //왼쪽 소메뉴 설정 변수
	include "left_menu.php";
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
								<td rowspan="3" width="200"><img src="image/good_tit_img.gif"></td>
								<td>&nbsp;</td>
							</tr>
							<tr>
								<td bgcolor="#E6E6E6" height='26'><div align='right'><font class='text1'>SHOP 상품정보를 수정하실수 있습니다.&nbsp;</div></td>
							</tr>
							<tr>
								<td>&nbsp;</td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td>
						<table width="750" border="0" cellspacing="0" cellpadding="0" align="center">
							<tr>
								<td colspan="2">
									<table width="750" border="0" cellspacing="0" cellpadding="0" align="center">
										<tr>
											<td height='1' colspan='3' bgcolor='DADADA'></td>
										</tr>
										<tr>
											<td width='440'><img src="image/goods_excel.gif"></td>
										</tr>
										<tr>
											<td height='1' colspan='3' bgcolor='DADADA'></td>
										</tr>
									</table>
								</td>
							</tr>
							<tr>
								<td height='5' colspan="2"></td>
							</tr>
							<tr>
								<td valign="top">
									<form name="adm_etcForm" method="post" action="goods_excel_ok.php" enctype="multipart/form-data" >
									<table bgcolor="eeeeee" width="400" height="100" align="center">
										<tr align="center" >
											<td>CSV 파일 업로드</td>
											<td><input type="file" name="csv_file" class="box"> <img src="image/entry_btn.gif" align="absmiddle" onclick="etcSendit();" style="cursor:pointer"></td>
										</tr>
										<tr>
											<td colspan="2">※ 샘플 CSV파일 다운받기 ▷ <a href="csv_down.php"><img src="image/s_file.gif" align="absmiddle"></a></td>
										</tr>
										<tr>
											<td colspan="2">▶ 절 차 안 내 </td>
										</tr>
										<tr>
											<td colspan="2">1. 샘플파일 다운받음 (샘플로 상품1개의 정보가 입력되어있습니다.)<br>2. 첫행의 필드명은 남겨두고 2번째 행부터 해당되는 내용을 입력<br>3. 작업완료시 저장 - 파일형식은 CSV(쉼표로분리)형태로 저장<br>4. 굿모닝샵 관리자의 이곳에 오셔서 해당파일을 업로드 시킴<br>5. 업로드한 CSV파일에 문제가 있을경우 에러메세지 출력됨<br>6. CSV파일에 문제가 없을시 ○○건 완료 메세지 출력됨 <br>7. 실제 상품사진은 upload/goods 경로에 올려주시기 바랍니다. </td>
										</tr>
									</table></form>
								</td>
							</tr>
							<tr>
								<td colspan="2" height="20"></td>
							</tr>
							<tr>
								<td valign="top">
									<table bgcolor="eeeeee" width="600" align="center" border="1" style="border-collapse:collapse" bordercolor="#999999">
										<tr align="center">
											<td colspan="2" height="50"><font size="+1"><b>필 드 설 명</b></font><br>※ 가격과 관련된 데이터 입력시 <b>컴마 입력 금지</b></td>
										</tr>
										<tr align="left">
											<td width="100">code</td>
											<td bgcolor="ffffff">상품코드 (중복되지않는 40자 이내 문자)</td>
										</tr>
										<tr align="left">
											<td width="100">name</td>
											<td bgcolor="ffffff">상품명</td>
										</tr>
										<tr align="left">
											<td width="100">price</td>
											<td bgcolor="ffffff">판매가 </td>
										</tr>
										<tr align="left">
											<td width="100">bOldPrice</td>
											<td bgcolor="ffffff">시중가 표시여부 (0: 표시안함 1: 표시함)</td>
										</tr>
										<tr align="left">
											<td width="100">oldPrice</td>
											<td bgcolor="ffffff">시중가 </td>
										</tr>
										<tr align="left">
											<td width="100">point</td>
											<td bgcolor="ffffff">적립금</td>
										</tr>
										<tr align="left">
											<td width="100">bCompany</td>
											<td bgcolor="ffffff">제조사 표시여부 (0: 표시안함 1: 표시함)</td>
										</tr>
										<tr align="left">
											<td width="100">company</td>
											<td bgcolor="ffffff">제조사</td>
										</tr>
										<tr align="left">
											<td width="100">bOrigin</td>
											<td bgcolor="ffffff">원산지 표시여부 (0: 표시안함 1: 표시함)</td>
										</tr>
										<tr align="left">
											<td width="100">origin</td>
											<td bgcolor="ffffff">원산지</td>
										</tr>
										<tr align="left">
											<td width="100">bLimit</td>
											<td bgcolor="ffffff">재고상태 (0: 무제한, 1:제한 2: 품절, 3:보류 4:단종)</td>
										</tr>
										<tr align="left">
											<td width="100">limitCnt</td>
											<td bgcolor="ffffff">재고수량</td>
										</tr>
										<tr align="left">
											<td width="100">bHit</td>
											<td bgcolor="ffffff">히트이미지 사용여부 (0: 표시안함 1: 표시함)</td>
										</tr>
										<tr align="left">
											<td width="100">bNew</td>
											<td bgcolor="ffffff">뉴이미지 사용여부 (0: 표시안함 1: 표시함)</td>
										</tr>
										<tr align="left">
											<td width="100">bEtc</td>
											<td bgcolor="ffffff">기타이미지 사용여부 (0: 표시안함 1: 표시함)</td>
										</tr>
										<tr align="left">
											<td width="100">partName1</td>
											<td bgcolor="ffffff">첫번째 상품옵션명 (예: 색상, 사이즈)</td>
										</tr>
										<tr align="left">
											<td width="100">partName2</td>
											<td bgcolor="ffffff">두번째 상품옵션명</td>
										</tr>
										<tr align="left">
											<td width="100">partName3</td>
											<td bgcolor="ffffff">세번째 상품옵션명</td>
										</tr>
										<tr align="left">
											<td width="100">strPart1</td>
											<td bgcolor="ffffff">첫번째 상품옵션의 선택항목 (예: 흰색」「검은색」「파란색) , 항목사이에 반드시 특수문자 」「 를 기입</td>
										</tr>
										<tr align="left">
											<td width="100">strPart2</td>
											<td bgcolor="ffffff">두번째 상품옵션 선택항목</td>
										</tr>
										<tr align="left">
											<td width="100">strPart3</td>
											<td bgcolor="ffffff">세번째 상품옵션 선택항목</td>
										</tr>
										<tr align="left">
											<td width="100">img1</td>
											<td bgcolor="ffffff">상품이미지 (소)	[경로없이 파일명만 입력]</td>
										</tr>
										<tr align="left">
											<td width="100">img2</td>
											<td bgcolor="ffffff">상품이미지 (중)</td>
										</tr>
										<tr align="left">
											<td width="100">img3</td>
											<td bgcolor="ffffff">상품이미지 (대)</td>
										</tr>
										<tr align="left">
											<td width="100">img4</td>
											<td bgcolor="ffffff">상품이미지 (대) 사이즈의 추가이미지 1</td>
										</tr>
										<tr align="left">
											<td width="100">img5</td>
											<td bgcolor="ffffff">상품이미지 (대) 사이즈의 추가이미지 2</td>
										</tr>
										<tr align="left">
											<td width="100">img6</td>
											<td bgcolor="ffffff">상품이미지 (대) 사이즈의 추가이미지 3</td>
										</tr>
										<tr align="left">
											<td width="100">img7</td>
											<td bgcolor="ffffff">상품이미지 (대) 사이즈의 추가이미지 4</td>
										</tr>
										<tr align="left">
											<td width="100">img8</td>
											<td bgcolor="ffffff">상품이미지 (대) 사이즈의 추가이미지 5</td>
										</tr>
										<tr align="left">
											<td width="100">content</td>
											<td bgcolor="ffffff">상품설명</td>
										</tr>
										<tr align="left">
											<td width="100">writeday</td>
											<td bgcolor="ffffff">등록일</td>
										</tr>
										<tr align="left">
											<td width="100">readcnt</td>
											<td bgcolor="ffffff">조회수</td>
										</tr>
										<tr align="left">
											<td width="100">setVal</td>
											<td bgcolor="ffffff">진열순위 (1~10 의 값 입력, 클수록 앞쪽에 노출됨, 기본값 5)</td>
										</tr>
										<tr align="left">
											<td width="100">category</td>
											<td bgcolor="ffffff">카테고리코드</td>
										</tr>
										<tr align="left">
											<td width="100">detailimg1</td>
											<td bgcolor="ffffff">상품상세정보 밑에 부가적으로 등록되는 참고이미지 1</td>
										</tr>
										<tr align="left">
											<td width="100">detailimg2</td>
											<td bgcolor="ffffff">상품상세정보 밑에 부가적으로 등록되는 참고이미지 2</td>
										</tr>
										<tr align="left">
											<td width="100">detailimg3</td>
											<td bgcolor="ffffff">상품상세정보 밑에 부가적으로 등록되는 참고이미지 3</td>
										</tr>
										<tr align="left">
											<td width="100">detailimg4</td>
											<td bgcolor="ffffff">상품상세정보 밑에 부가적으로 등록되는 참고이미지 4</td>
										</tr>
										<tr align="left">
											<td width="100">margin</td>
											<td bgcolor="ffffff">마진률 (1~100%)</td>
										</tr>
										<tr align="left">
											<td width="100">supplyprice</td>
											<td bgcolor="ffffff">공급가</td>
										</tr>
										<tr align="left">
											<td width="100">meta_str</td>
											<td bgcolor="ffffff">브라우저 타이틀바에 나오는 문구 (검색엔진 로봇 데이터로 활용)</td>
										</tr>
										<tr align="left">
											<td width="100">chango</td>
											<td bgcolor="ffffff">창고나 진열대 위치정보 (상품주문시 발송준비자료 추출시에 나타납니다.)</td>
										</tr>
										<tr align="left">
											<td width="100">quality</td>
											<td bgcolor="ffffff">품질 (A,B,C 로 등록하고 관리자에게만 보입니다.)</td>
										</tr>
										<tr align="left">
											<td width="100">model</td>
											<td bgcolor="ffffff">모델명</td>
										</tr>
									</table>
								</td>
							</tr>
							<tr>
								<td colspan="2" height="20"></td>
							</tr>
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