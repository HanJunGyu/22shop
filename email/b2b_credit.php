<?
global $design;			//사이트로고 배열변수
global $admin_row;		    //관리자 배열변수
global $trade_row; 
global $goods_row; 
$trade_payM = $trade_row[payM];
$trade_goods_num = $trade_goods_num - 1 ; // 배열인덱스는 0,1,2... 
$client_email = $trade_row[email];
$goods_name = $goods_name; // status_change에서 받아온것 바로 사용 	 
$trade_payM_str = PriceFormat($trade_payM);
if($design[mainLogoImg_type]==4)
{
	$logo="<object classid='clsid:D27CDB6E-AE6D-11cf-96B8-444553540000' codebase='http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=5,0,0,0' width='155' height='70'><param name=movie value='http://$admin_row[shopUrl]/upload/design/$design[mainLogoImg]'><param name=quality value=high><embed src='http://$admin_row[shopUrl]/upload/design/$design[mainLogoImg]' quality=high pluginspage='www.macromedia.com/shockwave/download/index.cgi?P1_Prod_Version=ShockwaveFlash' type='application/x-shockwave-flash' width='155' height='70'></embed></object>";
}
else
{
	$logo ="<img src='http://$admin_row[shopUrl]/upload/design/$design[mainLogoImg]'>";
}
$BOTTOM_HTML = $admin_row[mail_bottom];
$BOTTOM_HTML = str_replace("__comName",$admin_row[comName],$BOTTOM_HTML);
$BOTTOM_HTML = str_replace("__adminEmail",$admin_row[adminEmail],$BOTTOM_HTML);
$BOTTOM_HTML = str_replace("__esailNum",$admin_row[esailNum],$BOTTOM_HTML);
$BOTTOM_HTML = str_replace("__comNum",$admin_row[comNum],$BOTTOM_HTML);
$BOTTOM_HTML = str_replace("__comCeo",$admin_row[comCeo],$BOTTOM_HTML);
$BOTTOM_HTML = str_replace("__comTel",$admin_row[comTel],$BOTTOM_HTML);
$BOTTOM_HTML = str_replace("__comFax",$admin_row[comFax],$BOTTOM_HTML);
$BOTTOM_HTML = str_replace("__comAdr",$admin_row[comAdr],$BOTTOM_HTML);
$body="
<html>
<head>
<title>결제확인 메일</title>
<meta http-equiv='Content-Type' content='text/html; charset=euc-kr'>
<style>
BODY {	FONT-SIZE: 9pt; LINE-HEIGHT: 160%; FONT-FAMILY: '돋움'}
TD {	FONT-SIZE: 9pt; LINE-HEIGHT: 140%; FONT-FAMILY: '돋움'}
A:link {    text-decoration:none;     color:#000000;} 
A:visited {    text-decoration:none;     color:#000000;}
A:hover {    text-decoration:underline;     Color:#6377DC;}
A:active {    text-decoration:underline;    Color:#6377DC;}
BODY {scrollbar-face-color: #ffffff; scrollbar-shadow-color: #000000; scrollbar-highlight-color: #ffffff; scrollbar-3dlight-color: #000000; scrollbar-darkshadow-color: #ffffff; scrollbar-track-color: #eeeeee; scrollbar-arrow-color: #000000}
.tbg {  background-image: url(http://$admin_row[shopUrl]/admin/image/good_mail_d_bg.gif); background-repeat: no-repeat; background-position: left top}
</style>
</head>
<body bgcolor='#FFFFFF' text='#000000'>
<TABLE cellSpacing='0' cellPadding='0' width='700' align='center' border='0'>
	<TR>
		<TD background='http://$admin_row[shopUrl]/admin/image/good_mail_account_tit.gif' style='padding:5 5 5 35' height='85'>$logo</TD>
	</TR>
</table>
<TABLE cellSpacing='0' cellPadding='0' width='700' align='center' border='0'>
	<tr>
		<td colspan='5' background='http://$admin_row[shopUrl]/admin/image/good_mail_account_tit2.gif' style='padding:75 0 0 35' height='162'><b><font color='#FF4800'>$trade_row[name]</font></b> 회원님의 결제내역입니다.<br>결제하여 주셔서 감사합니다. 바로 배송준비하겠습니다.</td>
	</tr>
</table>
<table width='700' border='0' cellspacing='0' cellpadding='0' align='center'>
	<tr>
		<td background='http://$admin_row[shopUrl]/admin/image/good_mail_bg2.gif'>
			<table width='660' border='0' cellspacing='0' cellpadding='0' align='center'>
				<tr>
					<td><img src='http://$admin_row[shopUrl]/admin/image/good_mail_account_tit3.gif'></td>
				</tr>
			</table><br>
			<table width='660' border='0' cellspacing='1' cellpadding='0' align='center' bgcolor='#DADADA'>
				<tr>
					<td bgcolor='#F4F4F4' height='30' width='180' align='center'><b>주문상품</b></td>
					<td bgcolor='#FFFFFF' width='380' style='padding:0 0 0 10'>$goods_name</td>
				</tr>
				<tr>
					<td bgcolor='#F4F4F4' height='30' align='center'><b>결제금액</b></td>
					<td bgcolor='#FFFFFF' style='padding:0 0 0 10'>$trade_payM_str 원</td>
				</tr>
				<tr>
					<td bgcolor='#F4F4F4' height='30' align='center'><b>배 송 지</b></td>
					<td bgcolor='#FFFFFF' style='padding:0 0 0 10'>[$trade_row[rzip]] $trade_row[radr1] $trade_row[radr2]</td>
				</tr>
				<tr>
					<td bgcolor='#F4F4F4' height='30' align='center'><b>받는 사람</b></td>
					<td bgcolor='#FFFFFF' style='padding:0 0 0 10'>$trade_row[rname]</td>
				</tr>
				<tr>
					<td bgcolor='#F4F4F4' height='30' align='center'><b>받는사람 연락처</b></td>
					<td bgcolor='#FFFFFF' style='padding:0 0 0 10'>$trade_row[rtel]</td>
				</tr>
			</table><br>
		</td>
	</tr>
</table>
<table width='700' border='0' cellpadding='0' cellspacing='0' align='center'>
	<tr>
		<td background='http://$admin_row[shopUrl]/admin/image/good_mail_bg.gif' style='padding:10 0 0 0' height='90'>";
		$body.=$BOTTOM_HTML; 
		$body.="
		</td>
	</tr>
</table>
</body>
</html>
";
$mime_type="text/html";
$mail_body=($body);
$date=date("D, d M Y H:i:s +0900");
$MANAGEMENT_MAIL_ADDRESS=$admin_row[adminEmail];
$client_email = trim($client_email);

// 고객에 결제확인 메일발송
$subject="[".$admin_row[comName]."] 정상적으로 결제되었습니다.";
$pp=popen(escapeshellcmd("$SENDMAIL_PATH -t -f $MANAGEMENT_MAIL_ADDRESS"),"w");
fputs($pp,"Date: $date\n");
fputs($pp,"From: $admin_row[comName]<$MANAGEMENT_MAIL_ADDRESS>\n");
fputs($pp,"Subject: $subject\n");
fputs($pp,"Sender: $MANAGEMENT_MAIL_ADDRESS\n");
fputs($pp,"To: $client_email\n"); // 변경 
fputs($pp,"Reply-To: $MANAGEMENT_MAIL_ADDRESS\n");
fputs($pp,"MIME-Version: 1.0\n");
fputs($pp,"Content-Type: $mime_type; charset=euc_kr\n");
fputs($pp,$mail_body);
pclose($pp);
?>