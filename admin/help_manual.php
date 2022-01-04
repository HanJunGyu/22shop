<?
// 소스형상관리
// 20060714_1 소스수정 최호수 (통계 프로그램 수정으로 인한 소스 수정)
include "head.php";
?>
<body bgcolor="#FFFFFF" text="#5A595A" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<? include "top_menu.php"; ?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr><?
	$__TOP_MENU = "help";     //왼쪽 소메뉴 설정 변수
	include "left_menu.php";
	if(!defined(__ADMIN_ROW))
	{
		define(__ADMIN_ROW,"TRUE");
		$admin_row=$MySQL->fetch_array("select *from admin limit 0,1"); //관리자 정보 배열
	}
	?>
		<td width="85%" valign="top" height='400'>
			<table width="100%" border="0" cellspacing="0" cellpadding="0" align='center'>
				<tr>
					<td height='5'></td>
				</tr>
				<tr>
					<td>
						<table width="95%" border="0" cellspacing="0" cellpadding="0" align='center'>
							<tr>
								<td rowspan="3" width="200"><img src="image/help_tit_img.gif"></td>
								<td>&nbsp;</td>
							</tr>
							<tr>
								<td bgcolor="#E6E6E6" height='26'><div align='right'><font class='text1'>SHOP 기본정보를 수정하실수 있습니다.&nbsp;</div></td>
							</tr>
							<tr>
								<td>&nbsp;</td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td height="2">
						<table width="95%" border="0" cellspacing="0" cellpadding="0" align="center">
							<tr>
								<td bgcolor='DADADA' height='1'></td>
							</tr>
							<tr>
								<td>
									<table width="95%" border="0" cellspacing="0" cellpadding="0" align="center">
										<tr>
											<td width='440' height=30><img src="image/adm_icon.gif"> 메뉴설명</td>
										</tr>
									</table>
								</td>
							</tr>
							<tr>
								<td bgcolor='DADADA' height='1'></td>
							</tr>
							<tr>
								<td height='10'></td>
							</tr>
							<tr>
								<td height='20'>Ctrl + F 를 누르셔서 특정메뉴를 검색할수 있습니다.</td>
							</tr>
							<tr>
								<td height='10'></td>
							</tr>
							<tr>
								<td valign=top>
									<table width="95%"  border="1" cellspacing="1" cellpadding="3" align="center" bgcolor='' class="table_coll">
										<tr align="center" height=30 bgcolor='#CBCCF8'>
											<td width=13%><b>메뉴이름</b></td>
											<td width=14%><b>하부메뉴</b></td>
											<td width=73%><b>설정가능 내용</b></td>
										</tr>
										<tr align="center">
											<td  rowspan=7 bgcolor="#3D179C"><font color=white><b>기본정보</b></font></td>
											<TD bgcolor="#eeeeee">관리자 기본정보</TD>
											<TD align="left" style="line-height:18px">*기본정보 설정 - 쇼핑몰주소, 쇼핑몰이름, 쇼핑몰제목, 정보보호담당자, 로그인후 첫페이지 <br>*관리자정보 설정 - 관리자 아이디, 비밀번호, 발송이메일, 회신이메일<br>*사업자정보 - 상호, 사업자등록번호, 업태, 종목, 통신판매업 신고번호, 대표자명, 우편번호, 사업장주소, 연락처, 팩스</TD>
										</TR>
										<TR align="center">
											<TD bgcolor="#eeeeee">전자결제 설정</TD>
											<TD align="left" style="line-height:18px">*결제방법, PG사, 상점아이디, PG사 수수료, 무통장입금 계좌정보<br>*적립금제도 사용여부, 회원가입적립금, 제품구매적립금, 제품구매후기 적립금, 적립금사용 가능한 구매금액한도, 적립금사용 최소/최대금액 </TD>
										</TR>
										<TR align="center">
											<TD bgcolor="#eeeeee">배송 설정</TD>
											<TD align="left" style="line-height:18px">*배송비 설정 - 배송비제도 사용설정 및 착불 또는 무료배송금액 설정, 배송방법 설정, 배송업체설정 <br>*도서산간 배송비설정 - 제주,울릉도 같은 배송비가 좀더 비싼 지역을 설정합니다.</TD>
										</TR>
										<TR align="center">
											<TD bgcolor="#eeeeee">이용안내 설정</TD>
											<TD align="left" style="line-height:18px">*개인보호정책, 쇼핑몰이용안내, 회원가입혜택, 회원가입약관, 가입완료페이지 메세지, 장바구니 이용안내, 배송정보(주문시노출), 제휴안내, 회사소개, 약도, 주문완료페이지 메시지를 설정합니다.</TD>
										</TR>
										<TR align="center">
											<TD bgcolor="#eeeeee">메일 및 목록 설정</TD>
											<TD align="left" style="line-height:18px">*가입축하메일, 상품구매메일, 상품배송메일, 주문취소메일, 비밀번호 변경메일, 메일하단 의 메일폼 디자인 설정<br>*상품관리목록 노출수, 주문관리목록 노출수, 회원관리목록 노출수, 게시판목록 노출수(소비자화면), 검색결과목록 노출수(소비자화면)</TD>
										</TR>
										<TR align="center">
											<TD bgcolor="#eeeeee">몰초기화 관리</TD>
											<TD align="left" style="line-height:18px">*쇼핑몰 전체초기화 및 부분초기화, 어제정보까지의 장바구니, 관심품목 수동삭제 기능.</TD>
										</TR>
										<TR align="center">
											<TD bgcolor="#eeeeee">기타설정</TD>
											<TD align="left" style="line-height:18px">*상품등록시 확대이미지 1개로 작은,중간이미지 자동생성 기능설정, 1:1문의게시판, 마우스오른쪽 버튼허가여부, 주문목록 자동새로고침, 우편번호 업데이트</TD>
										</TR>
										<tr align="center">
											<td  rowspan=7 bgcolor="#3D179C"><font color=white><b>주문관리</b></font></td>
											<TD bgcolor="#eeeeee">주문통합	 목록</TD>
											<TD align="left" style="line-height:18px">*전체 주문목록 추출</TD>
										</TR>
										<TR align="center">
											<TD bgcolor="#eeeeee"><?=$TRADE_ARR[0]?> 목록</TD>
											<TD align="left" style="line-height:18px">*<?=$TRADE_ARR[0]?> 상태주문만 추출</TD>
										</TR>
										<TR align="center">
											<TD bgcolor="#eeeeee"><?=$TRADE_ARR[1]?> 목록</TD>
											<TD align="left" style="line-height:18px">*<?=$TRADE_ARR[1]?> 상태주문만 추출</TD>
										</TR>
										<TR align="center">
											<TD bgcolor="#eeeeee"><?=$TRADE_ARR[2]?> 목록</TD>
											<TD align="left" style="line-height:18px">*<?=$TRADE_ARR[2]?> 상태주문만 추출</TD>
										</TR>
										<TR align="center">
											<TD bgcolor="#eeeeee"><?=$TRADE_ARR[3]?> 목록</TD>
											<TD align="left" style="line-height:18px">*<?=$TRADE_ARR[3]?> 상태주문만 추출</TD>
										</TR>
										<TR align="center">
											<TD bgcolor="#eeeeee"><?=$TRADE_ARR[4]?> 목록</TD>
											<TD align="left" style="line-height:18px">*<?=$TRADE_ARR[4]?> 상태주문만 추출</TD>
										</TR>
										<TR align="center">
											<TD bgcolor="#eeeeee"><?=$TRADE_ARR[5]?> 목록</TD>
											<TD align="left" style="line-height:18px">*<?=$TRADE_ARR[5]?> 상태주문만 추출</TD>
										</TR>
										<tr align="center">
											<td  rowspan=7 bgcolor="#3D179C"><font color=white><b>상품관리</b></font></td>
											<TD bgcolor="#eeeeee">특정위치등록</TD>
											<TD align="left" style="line-height:18px">*메인베스트, 메인히트, 메인신규, 카테고리별 베스트,신규 위치에 등록된 상품지정 </TD>
										</TR>
										<TR align="center">
											<TD bgcolor="#eeeeee">상품목록</TD>
											<TD align="left" style="line-height:18px">*등록되어 있는 상품목록을 보는 페이지, 상품의 이동/참조는 목록상에서 할수있습니다.</TD>
										</TR>
										<TR align="center">
											<TD bgcolor="#eeeeee">상품목록 디자인</TD>
											<TD align="left" style="line-height:18px">*디자인관리의 상품목록 관리를 바로갈수있는 링크입니다.</TD>
										</TR>
										<TR align="center">
											<TD bgcolor="#eeeeee">상품평 관리</TD>
											<TD align="left" style="line-height:18px">*고객이 제품에 대한 제품평을 기재한 내역을 열람하는 페이지 입니다.</TD>
										</TR>
										<TR align="center">
											<TD bgcolor="#eeeeee">상품문의</TD>
											<TD align="left" style="line-height:18px">*고객이 제품에 대한 질문을 기재한 내역을 열람하는 페이지 입니다.</TD>
										</TR>
										<TR align="center">
											<TD bgcolor="#eeeeee">상품설정 관리</TD>
											<TD align="left" style="line-height:18px">*상품평/상품질문 사용여부, 상품목록상에서 판매가 수정시 경고메세지창 설정<br>NEW / 기타 / HIT / 판매가 / 적립금 / 확대보기 / 품절표시 / 카테고리베스트상품 이미지등록<br>상품목록 폰트설정, 워터마크 이미지설정</TD>
										</TR>
										<TR align="center">
											<TD bgcolor="#eeeeee">상품엑셀등록</TD>
											<TD align="left" style="line-height:18px">*샘플엑셀파일 다운받기, 작성한 상품정보엑셀파일 업로드하기, 상품DB필드 설명</TD>
										</TR>
										<tr align="center">
											<td  rowspan=3 bgcolor="#3D179C"><font color=white><b>카테고리</b></font></td>
											<TD bgcolor="#eeeeee">카테고리 관리</TD>
											<TD align="left" style="line-height:18px">*카테고리의 숨김, 카테고리 디자인</TD>
										</TR>
										<TR align="center">
											<TD bgcolor="#eeeeee">카테고리 등록</TD>
											<TD align="left" style="line-height:18px">*카테고리를 등록하는 화면입니다. 이름과 이미지1~6 을 등록합니다.</TD>
										</TR>
										<TR align="center">
											<TD bgcolor="#eeeeee">카테고리 순위</TD>
											<TD align="left" style="line-height:18px">*소비자 화면에 표시할 카테고리의 노출되는 우선순위를 설정합니다.</TD>
										</TR>
										<tr align="center">
											<td  rowspan=4 bgcolor="#3D179C"><font color=white><b>회원관리</b></font></td>
											<TD bgcolor="#eeeeee">회원목록</TD>
											<TD align="left" style="line-height:18px">*가입한 회원의 목록을 열람하는 페이지 입니다. 적립금,구매정보 전체열람 기능과 생일회원/결혼기념일 회원검색 등이 가능합니다.</TD>
										</TR>
										<TR align="center">
											<TD bgcolor="#eeeeee">회원전체 메일보내기</TD>
											<TD align="left" style="line-height:18px">*메일수신여부를 체크한 회원에게 전체메일을 발송합니다.</TD>
										</TR>
										<TR align="center">
											<TD bgcolor="#eeeeee">발송메일현황</TD>
											<TD align="left" style="line-height:18px">*발송된 메일내역을 열람합니다. 메일발송에 문제가 있어 발송되지 않은 메일을 재발송 할수도 있습니다.</TD>
										</TR>
										<TR align="center">
											<TD bgcolor="#eeeeee">회원전체 SMS보내기</TD>
											<TD align="left" style="line-height:18px">*SMS수신여부를 체크한 회원에게 전체SMS를 발송합니다.(SMS 업체와 계약이 되있어야 합니다.)</TD>
										</TR>
										<tr align="center">
											<td  rowspan=6 bgcolor="#3D179C"><font color=white><b>디자인관리</b></font></td>
											<TD bgcolor="#eeeeee">메인화면</TD>
											<TD align="left" style="line-height:18px">*A - 상단부분 레이아웃 2가지설정, 로고 / 즐겨찾기 / 회원가입~주문조회, 상품검색~고객지원센터 탑 이미지 등록<br>*B - 레이아웃 2가지설정, 메인타이틀 / 공지사항 / 공지사항 밑베너 이미지등록, 메인타이틀 슬라이드효과 설정<br>*B-1 -메인페이지 중앙부분 3개의 영역에 베너이미지 등록, 각 영역별로 1 ~ 4 열의 단을 나눌수 있음 <br>*C - 상품 카테고리 타이틀이미지 등록, 대분류/중분류 높이설정, 공지사항 좌측노출여부, 로그인폼 좌측노출여부<br>*D - 좌측메뉴 베너 / 설문조사 사용여부 및 이미지 등록. 신규상품전 타이틀이미지등록 및 목록수 설정<br>*E - 베스트상품전 가로x세로배열 / HTML직접입력 / 자동스크롤 설정, 타이틀이미지등록, 목록수 및 이미지 크기 설정<br>*F - 히트상품전 가로x세로배열 / HTML직접입력 / 자동스크롤 설정, 타이틀이미지등록, 목록수 및 이미지 크기 설정<br>*G - 메인 하단부분 카테고리별 이미지 사용여부<br>*H - 메인 하단부분 게시판, 이벤트 타이틀 이미지 등록 및 사용설정, 1:1문의게시판~회사소개 베너이미지 등록<br>*I  - 메인하단 협력사베너 등록<br>*J - 메인최하단 로고이미지, 회사정보노출되는부분 배경,색상설정</TD>
										</TR>
										<TR align="center">
											<TD bgcolor="#eeeeee">상품목록</TD>
											<TD align="left" style="line-height:18px">*B - 상품 진열방식 적용 여부 - 카테고리 개별적용 또는 모든 카테고리 일괄적용, 상품 진열방식 - 일반적인 바둑판식배열과 게시판식 배열, 상품 리스트  목록,이미지크기 설정<br>*C -상품목록화면에서 카테고리 이하 메뉴들 사용여부 설정, 게시판타이틀이미지 / 배너 등록</TD>
										</TR>
										<TR align="center">
											<TD bgcolor="#eeeeee">서브페이지</TD>
											<TD align="left" style="line-height:18px">* 상품목록 / 제품상세정보 / 이용약관 / 회원가입 / 마이페이지 / 장바구니 / 주문정보 / 1:1문의 / 게시판 / 회사소개 / 이용안내 / 개인보호정책 / 상세검색 / 공지사항</TD>
										</TR>
										<TR align="center">
											<TD bgcolor="#eeeeee">회원가입</TD>
											<TD align="left" style="line-height:18px">*회원가입 폼에서 필수사항 및 표시할 항목 설정</TD>
										</TR>
										<TR align="center">
											<TD bgcolor="#eeeeee">양측면 레이어베너</TD>
											<TD align="left" style="line-height:18px">*페이지 좌우측 날개 배너 (쇼핑몰 정렬이 가운데 일때만 사용 가능합니다.)<br>*우측 날개베너 대신 오늘 본 상품 기능 설정</TD>
										</TR>
										<TR align="center">
											<TD bgcolor="#eeeeee">커뮤니티</TD>
											<TD align="left" style="line-height:18px">*커뮤니티 타이틀 이미지 등록, 커뮤니티 게시판 진열 설정, 커뮤니티 게시판 메인페이지 노출 설정</TD>
										</TR>
										<tr align="center">
											<td  rowspan=5 bgcolor="#3D179C"><font color=white><b>매출통계</b></font></td>
											<TD bgcolor="#eeeeee">일반통계</TD>
											<TD align="left" style="line-height:18px">*월별 매출통계(수취완료된 날짜기준)를 한눈에 볼수 있도록 달력형식으로 표시</TD>
										</TR>
										<TR align="center">
											<TD bgcolor="#eeeeee">일일통계</TD>
											<TD align="left" style="line-height:18px">*일별 매출통계(카테고리, 상품, 회원별 구분되어있음)</TD>
										</TR>
										<TR align="center">
											<TD bgcolor="#eeeeee">월간통계</TD>
											<TD align="left" style="line-height:18px">*월별 매출통계(카테고리, 상품, 회원별 구분되어있음)</TD>
										</TR>
										<TR align="center">
											<TD bgcolor="#eeeeee">년간통계</TD>
											<TD align="left" style="line-height:18px">*년별 매출통계(카테고리, 상품, 회원별 구분되어있음)</TD>
										</TR>
										<TR align="center">
											<TD bgcolor="#eeeeee">특정기간통계</TD>
											<TD align="left" style="line-height:18px">*원하는 특정기간 매출통계(카테고리, 상품, 회원별 구분되어있음)</TD>
										</TR>
										<tr align="center">
											<td  rowspan=6 bgcolor="#3D179C"><font color=white><b>접속통계</b></font></td>
											<TD bgcolor="#eeeeee">일반통계</TD>
											<TD align="left" style="line-height:18px">*날짜, 월, 전체기준 접속통계</TD>
										</TR>
										<TR align="center">
											<TD bgcolor="#eeeeee">시간통계</TD>
											<TD align="left" style="line-height:18px">*날짜, 월, 전체기준 매시간별 접속통계</TD>
										</TR>
										<TR align="center">
											<TD bgcolor="#eeeeee">주간통계</TD>
											<TD align="left" style="line-height:18px">*월, 전체기준 요일별 접속통계</TD>
										</TR>
										<TR align="center">
											<TD bgcolor="#eeeeee">접속경로</TD>
											<TD align="left" style="line-height:18px">*어떤 사이트를 통해 본 사이트에 접속했는지 통계</TD>
										</TR>
										<TR align="center">
											<TD bgcolor="#eeeeee">브라우저</TD>
											<TD align="left" style="line-height:18px">*본 사이트를 접속한 사용자의 PC 브라우저 정보</TD>
										</TR>
										<TR align="center">
											<TD bgcolor="#eeeeee">운영체제</TD>
											<TD align="left" style="line-height:18px">*본 사이트를 접속한 사용자의 PC 운영체제 정보</TD>
										</TR>
										<tr align="center">
											<td  rowspan=1 bgcolor="#3D179C"><font color=white><b>사용자정의페이지</b></font></td>
											<TD bgcolor="#eeeeee">사용자정의페이지</TD>
											<TD align="left" style="line-height:18px">*쇼핑몰내에 없는 새로운 페이지를 만들고자 할때 이 기능을 사용합니다.</TD>
										</TR>
										<tr align="center">
											<td  rowspan=3 bgcolor="#3D179C"><font color=white><b>공지사항</b></font></td>
											<TD bgcolor="#eeeeee">공지사항</TD>
											<TD align="left" style="line-height:18px">*공지사항을 등록하면 자동으로 메인페이지 우측에 표시되며 동시에 자동으로 팝업창을 띄울수도 있습니다.</TD>
										</TR>
										<TR align="center">
											<TD bgcolor="#eeeeee">이벤트</TD>
											<TD align="left" style="line-height:18px">*공지사항을 등록하면 자동으로 메인페이지 하단에 표시되며 동시에 자동으로 팝업창을 띄울수도 있습니다.</TD>
										</TR>
										<TR align="center">
											<TD bgcolor="#eeeeee">설문조사</TD>
											<TD align="left" style="line-height:18px">*설문조사를 실시할수 있습니다. 조사중인 설문조사는 도중에 수정할수 없습니다.</TD>
										</TR>
										<tr align="center">
											<td  rowspan=1 bgcolor="#3D179C"><font color=white><b>게시판</b></font></td>
											<TD bgcolor="#eeeeee">게시판</TD>
											<TD align="left" style="line-height:18px">*등록된 게시판 관리 및 등록, 수정을 할수 있습니다. (읽기/쓰기/답변 권한, 꼬릿말 기능여부, 커뮤니티페이지에 노출설정, 소개문구, 이미지 등록)</TD>
										</TR>
										<tr align="center">
											<td  rowspan=1 bgcolor="#3D179C"><font color=white><b>1:1문의게시판</b></font></td>
											<TD bgcolor="#eeeeee">1:1문의게시판</TD>
											<TD align="left" style="line-height:18px">*1:1문의게시판 목록열람 및 답변, 삭제를 할수 있습니다. 1:1문의게시판은 회원만 이용가능하며 타인이 쓴 글은 회원이 볼수없습니다.</TD>
										</TR>
										<tr align="center">
											<td  rowspan=1 bgcolor="#3D179C"><font color=white><b>SMS관리</b></font></td>
											<TD bgcolor="#eeeeee">SMS관리</TD>
											<TD align="left" style="line-height:18px">*SMS업체와 계약된 경우 이곳에 ID,PW를 기재하며, 회원가입 / 상품구매 / 배송 시에 보낼 문자내용을 설정합니다.</TD>
										</TR>
										<tr align="center">
											<td  rowspan=1 bgcolor="#3D179C"><font color=white><b>이미지업로드</b></font></td>
											<TD bgcolor="#eeeeee">이미지업로드</TD>
											<TD align="left" style="line-height:18px">*FTP접속하여 업로드 할필요 없이 이곳에서 이미지를 업로드 할수있습니다. upload/page 폴더에 저장됩니다.</TD>
										</TR>
										<tr align="center">
											<td  rowspan=5 bgcolor="#3D179C"><font color=white><b>관리자메일</b></font></td>
											<TD bgcolor="#eeeeee">기본설정</TD>
											<TD align="left" style="line-height:18px">*OUTLOOK EXPRESS 프로그램과 유사한 웹메일 기능이며 기본설정메뉴에서 먼저 올바른 정보를 등록해야 하부메뉴들이 보여집니다.</TD>
										</TR>
										<TR align="center">
											<TD bgcolor="#eeeeee">편지쓰기</TD>
											<TD align="left" style="line-height:18px">*메일을 발송하는 메뉴입니다. 3개까지 파일첨부를 할수있으며 함께받는이 참조 또는 주소록에서 불러오는 기능이 있습니다.</TD>
										</TR>
										<TR align="center">
											<TD bgcolor="#eeeeee">편지함관리</TD>
											<TD align="left" style="line-height:18px">*받은편지함, 보낸편지함, 임시보관함을 관리합니다.</TD>
										</TR>
										<TR align="center">
											<TD bgcolor="#eeeeee">주소록</TD>
											<TD align="left" style="line-height:18px">*개인메일등록 및 그룹설정이 가능합니다.</TD>
										</TR>
										<TR align="center">
											<TD bgcolor="#eeeeee">환경설정</TD>
											<TD align="left" style="line-height:18px">*받고싶지않은 메일의 수신거부설정 및 외부POP3 설정이 가능합니다.</TD>
										</tr>
									</table>
								</td>
							</tr>
						</table><br>
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>
<? include "copy.php";?>
</body>
</html>