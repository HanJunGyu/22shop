<?
if($_GET[_PRINT] || $_POST[_PRINT])
{
	session_start();
	include "../lib/config.php";
	include "../lib/function.php";
	if(!defined(__ADMIN_ROW))
	{
		define(__ADMIN_ROW,"TRUE");
		$admin_row=$MySQL->fetch_array("select *from admin limit 0,1");//관리자정보
	}
	if(!defined(__DESIGN_ROW))
	{
		define(__DESIGN_ROW,"TRUE");
		$design=$MySQL->fetch_array("select *from design limit 0,1");
	}
}
else
{
	global $design;			//사이트로고 배열변수
	global $admin_row;		    //관리자 배열변수
	global $GOOD_SHOP_USERID;
	global $temp_row;
	$email = $temp_row[email];
	$trans_add = $temp_row[trans_add];
	$trade_row = $MySQL->fetch_array("SELECT name, payM,payMethod,bankInfo from trade WHERE tradecode='$temp_row[tradecode]' limit 1");
	$trade_payM = $trade_row[payM];
}

//로고 설정
if($design[mainLogoImg_type]==4)
{
	$logo="<object classid='clsid:D27CDB6E-AE6D-11cf-96B8-444553540000' codebase='http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=5,0,0,0' width='155' height='70'><param name=movie value='http://$admin_row[shopUrl]/upload/design/$design[mainLogoImg]'><param name=quality value=high><embed src='http://$admin_row[shopUrl]/upload/design/$design[mainLogoImg]' quality=high pluginspage='www.macromedia.com/shockwave/download/index.cgi?P1_Prod_Version=ShockwaveFlash' type='application/x-shockwave-flash' width='155' height='70' ></embed></object>";
}
else
{
	$logo ="<img src='http://$admin_row[shopUrl]/upload/design/$design[mainLogoImg]' width='120'>";
}
$body="
<html>
<head>
<title>상품구매 메일</title>
<meta http-equiv='Content-Type' content='text/html; charset=euc-kr'>
<style>
BODY {	FONT-SIZE: 9pt; LINE-HEIGHT: 160%; FONT-FAMILY: '돋움'}
TD {	FONT-SIZE: 9pt; LINE-HEIGHT: 140%; FONT-FAMILY: '돋움'}
A:link {    text-decoration:none;     color:#000000;} 
A:visited {    text-decoration:none;     color:#000000;}
A:hover {    text-decoration:underline;     Color:#6377DC;}
A:active {    text-decoration:underline;    Color:#6377DC;}
BODY {scrollbar-face-color: #ffffff; scrollbar-shadow-color: #000000; scrollbar-highlight-color: #ffffff; scrollbar-3dlight-color: #000000; scrollbar-darkshadow-color: #ffffff; scrollbar-track-color: #eeeeee; scrollbar-arrow-color: #000000}
.tbg {  background-image: url(image/good_mail_bg.gif); background-repeat: no-repeat; background-position: left top}
</style>
</head>";
$BOTTOM_HTML = $admin_row[mail_bottom];
$BOTTOM_HTML = str_replace("__comName",$admin_row[comName],$BOTTOM_HTML);
$BOTTOM_HTML = str_replace("__adminEmail",$admin_row[adminEmail],$BOTTOM_HTML);
$BOTTOM_HTML = str_replace("__esailNum",$admin_row[esailNum],$BOTTOM_HTML);
$BOTTOM_HTML = str_replace("__comNum",$admin_row[comNum],$BOTTOM_HTML);
$BOTTOM_HTML = str_replace("__comCeo",$admin_row[comCeo],$BOTTOM_HTML);
$BOTTOM_HTML = str_replace("__comTel",$admin_row[comTel],$BOTTOM_HTML);
$BOTTOM_HTML = str_replace("__comFax",$admin_row[comFax],$BOTTOM_HTML);
$BOTTOM_HTML = str_replace("__comAdr",$admin_row[comAdr],$BOTTOM_HTML);

$body_DB.= "
<body bgcolor='#FFFFFF' text='#000000'>
<TABLE cellSpacing='0' cellPadding='0' width='700' align='center' border='0'>
	<TR>
		<TD background='http://$admin_row[shopUrl]/admin/image/good_mail_tit.gif' style='padding:5 5 5 35' height='85'>$logo</TD>
	</TR>
</table>
<TABLE cellSpacing='0' cellPadding='0' width='700' align='center' border='0'>
	<tr>
		<td colspan='5' background='http://$admin_row[shopUrl]/admin/image/good_mail_tit2.gif' style='padding:75 0 0 35' height='162'><b><font color='#FF4800'>$trade_row[name]</font></b> 회원님의 주문내역입니다. <br>주문하여 주셔서 감사합니다. 결제가 확인되는 대로 빠른시간내에 배송하겠습니다.</td>
	</tr>
</table>
<TABLE cellSpacing='0' cellPadding='0' width='700' align='center' border='0'>
	<TR>
		<td background='http://$admin_row[shopUrl]/admin/image/good_mail_bg2.gif'>";
			$body_DB.= $admin_row[mail_buy];
			$body_DB = str_replace("__URL","http://$admin_row[shopUrl]",$body_DB);
			$body_DB = str_replace("__LOGO",$logo,$body_DB);
			$body_DB = str_replace("__Name",$trade_row[name],$body_DB);
			// 주문 상품 목록 설정
			if($_PRINT) $cart_qry	 = "select *from trade_goods limit 1";
			else $cart_qry		 = "select *from cart where userid='$temp_row[userid]'";
			$cart_result	 = $MySQL->query($cart_qry);
			$cart_goods_cnt	= $MySQL->is_affected();
			$total_price = 0;		//총구매가격
			$total_point = 0;		//적립금 총합
			$i = 1;
			while($cart_row = mysql_fetch_array($cart_result))
			{
				$goods_row = $MySQL->fetch_array("select *from goods where idx=$cart_row[goodsIdx] limit 1"); //상품정보
				$optionArr = Array("$cart_row[option1]","$cart_row[option2]","$cart_row[option3]");   //옵션 배열
				$tprice = $cart_row[price] * $cart_row[cnt];  //상품별구매가격  = 상품별가격 X수량
				$total_point += $goods_row[point];		//적립금 총합
				if (empty($GD_SET) && $goods_row[img_onetoall]) $img_str = $goods_row[img3];
				else if ($GD_SET && $goods_row[img_onetoall] && empty($goods_row[img1])) $img_str = $goods_row[img3];
				else if ($GD_SET && empty($goods_row[img_onetoall]) && empty($goods_row[img1])) $img_str = $goods_row[img3];
				else $img_str = $goods_row[img1];
				$body_DB.="
			<table cellSpacing='0' cellPadding='0' width='660' align='center' >
				<tr>
					<td height='2'></td>
				</tr>
			</table>
			<table cellSpacing='1' cellPadding='0' width='660' align='center' bgcolor='dadada'>
				<tr align='center' bgcolor='#FFFFFF'>
					<td height='70' width='70'><img src='http://$admin_row[shopUrl]/upload/goods/$img_str' width='50' height='50'></td>
					<td height='70' width='220'>$goods_row[name]</td>
					<td height='70' width='150'>
						<table width='140' border='0' cellspacing='0' cellpadding='0'>";
						for($i=0;$i<count($optionArr);$i++)
						{
							if(!empty($optionArr[$i]))
							{
								$option = explode("」「",$optionArr[$i]);
								$body_DB.="
							<tr>
								<td width='45'  bgcolor='#F7F7F7' align='center'>$option[0]</td>
								<td bgcolor='#DDFFFB' align='left'> : $option[1]</td>
							</tr>";
							}
						}
						$str_tprice = PriceFormat($tprice);
						$body_DB.="
						</table>
					</td>
					<td height='70' width='70'>$cart_row[cnt]</td>
					<td height='70' width='150' align='right'>$str_tprice</td>
				</tr>";
				$total_price +=$tprice;					//총구매가격
				$cart_goods_cnt --;
			}
			$trade_payM_str = PriceFormat($trade_payM);
			$body_DB.="
			</table><br>
			<TABLE cellSpacing='1' cellPadding='0' width='660' align='center' border='0' bgcolor='#E1E1E1'>
				<tr>
					<td height='30' align='center' width='180' bgcolor='#F4F4F4'>결제 금액</td>
					<td style='padding:0 0 0 10' bgcolor='#FFFFFF'><b><font color='#FF0000'>$trade_payM_str</font></b> 원</td>
				</tr>
				<tr>
					<td height='30' align='center' bgcolor='#F4F4F4'>주문코드</td>
					<td style='padding:0 0 0 10' bgcolor='#FFFFFF'><b><font color='#FF0000'>$temp_row[tradecode]</font></b></td>
				</tr>";
			if ($trade_row[payMethod]=="bank")
			{
				$body_DB.="
				<tr>
					<td height='30' align='center' bgcolor='#F4F4F4'>입금정보</td>
					<td style='padding:0 0 0 10' bgcolor='#FFFFFF'><b><font color='#FF0000'>$trade_row[bankInfo]</font></b></td>
				</tr>";
			}
			$body_DB.="
			</table><br>
		</td>
	</tr>
</table>
<table width='700' border='0' cellpadding='0' cellspacing='0' align='center'>
	<tr>
		<td background='http://$admin_row[shopUrl]/admin/image/good_mail_bg.gif' style='padding:10 0 0 0' height='90'>";
					$body_DB.=$BOTTOM_HTML; 
					$body_DB.="
		</td>
	</tr>
</table>

";
$body.= $body_DB ."</body></html>";

if($_PRINT)
{
	echo "$body";
}
else
{
	$mime_type="text/html";
	$mail_body=($body);
	$date=date("D, d M Y H:i:s +0900");  
	$subject="상품구매에 감사드립니다.";
	$MANAGEMENT_MAIL_ADDRESS=$admin_row[adminEmail];
	$MANAGEMENT_RECVMAIL_ADDRESS=$admin_row[adminEmail2];

	//해당회원
	$pp=popen(escapeshellcmd("$SENDMAIL_PATH -t -f $MANAGEMENT_MAIL_ADDRESS"),"w");
	fputs($pp,"Date: $date\n");
	fputs($pp,"From: $admin_row[comName] 관리자 <$MANAGEMENT_MAIL_ADDRESS>\n");
	fputs($pp,"Subject: $subject\n");
	fputs($pp,"Sender: $MANAGEMENT_MAIL_ADDRESS\n");
	fputs($pp,"To: $email\n");
	fputs($pp,"Reply-To: $MANAGEMENT_MAIL_ADDRESS\n");
	fputs($pp,"MIME-Version: 1.0\n");
	fputs($pp,"Content-Type: $mime_type; charset=euc_kr\n");
	fputs($pp,$mail_body);
	pclose($pp);
}

//관리자
$pp=popen(escapeshellcmd("$SENDMAIL_PATH -t -f $MANAGEMENT_MAIL_ADDRESS"),"w");
fputs($pp,"Date: $date\n");
fputs($pp,"From: $admin_row[comName] 관리자 <$MANAGEMENT_MAIL_ADDRESS>\n");
fputs($pp,"Subject: 상품이 판매되었습니다.\n");
fputs($pp,"Sender: $MANAGEMENT_MAIL_ADDRESS\n");
fputs($pp,"To: $MANAGEMENT_RECVMAIL_ADDRESS\n");
fputs($pp,"Reply-To: $MANAGEMENT_MAIL_ADDRESS\n");
fputs($pp,"MIME-Version: 1.0\n");
fputs($pp,"Content-Type: $mime_type; charset=euc_kr\n");
fputs($pp,$mail_body);
pclose($pp);
?>