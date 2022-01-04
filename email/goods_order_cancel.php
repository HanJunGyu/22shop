<?
if($_GET[_PRINT] || $_POST[_PRINT])
{
	session_start();
	include "../lib/config.php";
	include "../lib/function.php";
	if(!defined(__ADMIN_ROW))
	{
		define(__ADMIN_ROW,"TRUE");
		$admin_row=$MySQL->fetch_array("select *from admin limit 0,1");	//관리자정보
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
	global $admin_row;		//관리자 배열변수
	global $trade_row;
	global $trade_goods_row;
	global $goods_row;
	$email = $trade_row[email];
	$trade_payM = $trade_row[payM];
}
// 로고 설정
if($design[mainLogoImg_type]==4)
{
	$logo = "<object classid='clsid:D27CDB6E-AE6D-11cf-96B8-444553540000' codebase='http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=5,0,0,0' width='155' height='70'><param name=movie value='http://$admin_row[shopUrl]/upload/design/$design[mainLogoImg]'><param name=quality value=high><embed src='http://$admin_row[shopUrl]/upload/design/$design[mainLogoImg]' quality=high pluginspage='www.macromedia.com/shockwave/download/index.cgi?P1_Prod_Version=ShockwaveFlash' type='application/x-shockwave-flash' width='155' height='70'></embed></object>";
}
else
{
	$logo = "<img src='http://$admin_row[shopUrl]/upload/design/$design[mainLogoImg]'>";
}
$body = "
<html>
<head>
<title>주문취소메일</title>
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
</head>
<body bgcolor='#FFFFFF' text='#000000'>
<TABLE cellSpacing='0' cellPadding='0' width='700' align='center' border='0'>
	<TR>
		<TD background='http://$admin_row[shopUrl]/admin/image/good_mail_can_tit.gif' style='padding:5 5 5 35' height='85'>$logo</TD>
	</TR>
</table>
<TABLE cellSpacing='0' cellPadding='0' width='700' align='center' border='0'>
	<tr>
		<td colspan='5' background='http://$admin_row[shopUrl]/admin/image/good_mail_can_tit2.gif' style='padding:75 0 0 35' height='162'><b><font color='#FF4800'>$trade_row[name]</font></b> 회원님의 주문취소내역입니다.</td>
	</tr>
</table>
<TABLE cellSpacing='0' cellPadding='0' width='700' align='center' border='0'>
	<TR>
		<td background='http://$admin_row[shopUrl]/admin/image/good_mail_bg2.gif'>";
		$body_DB = $admin_row[mail_cancel];
		$body_DB = str_replace("__URL","http://$admin_row[shopUrl]",$body_DB);
		$body_DB = str_replace("__LOGO",$logo,$body_DB);
		$BOTTOM_HTML = $admin_row[mail_bottom];
		$BOTTOM_HTML = str_replace("__comName",$admin_row[comName],$BOTTOM_HTML);
		$BOTTOM_HTML = str_replace("__adminEmail",$admin_row[adminEmail],$BOTTOM_HTML);
		$BOTTOM_HTML = str_replace("__esailNum",$admin_row[esailNum],$BOTTOM_HTML);
		$BOTTOM_HTML = str_replace("__comNum",$admin_row[comNum],$BOTTOM_HTML);
		$BOTTOM_HTML = str_replace("__comCeo",$admin_row[comCeo],$BOTTOM_HTML);
		$BOTTOM_HTML = str_replace("__comTel",$admin_row[comTel],$BOTTOM_HTML);
		$BOTTOM_HTML = str_replace("__comFax",$admin_row[comFax],$BOTTOM_HTML);
		$BOTTOM_HTML = str_replace("__comAdr",$admin_row[comAdr],$BOTTOM_HTML);
			// 주문 상품 목록 설정
			if($type) $result = $MySQL->query("SELECT * FROM trade_goods WHERE tradecode='$trade_row[tradecode]'");
			elseif($_PRINT) $result = $MySQL->query("SELECT * FROM trade_goods limit 1");
			else $result = $MySQL->query("SELECT * FROM trade_goods WHERE idx=$tgidx");
			while($trade_goods_row = mysql_fetch_array($result))	//해당 주문번호에 대한 전체상품 처리
			{
				$goods_row = $MySQL->fetch_array("SELECT * FROM goods WHERE idx=$trade_goods_row[goodsIdx]"); //상품정보
				// 이미지사용
				$optionArr = Array();
				for($i=0; $i<3; $i++)
				{
					$j = $i + 1;
					$optionstr = "option$j";
					$optionArr[$i] = $trade_goods_row[$optionstr];
				}
				$tprice = $trade_goods_row[price] * $trade_goods_row[cnt];		//상품별구매가격 = 상품별가격 X 수량
				$total_point += $goods_row[point];		//적립금 총합
				if(empty($GD_SET) && $goods_row[img_onetoall]) $img_str = $goods_row[img3];
				elseif($GD_SET && $goods_row[img_onetoall] && empty($goods_row[img2])) $img_str = $goods_row[img3];
				elseif($GD_SET && empty($goods_row[img_onetoall]) && empty($goods_row[img2])) $img_str = $goods_row[img3];
				else $img_str = $goods_row[img1];
				$str_tprice = PriceFormat($tprice);
				$body_DB.= "
			<table cellSpacing='0' cellPadding='0' width='660' align='center' >
				<tr>
					<td height='2'></td>
				</tr>
			</table>
			<TABLE cellSpacing='1' cellPadding='0' width='660' align='center' border='0' bgcolor='#DADADA'>
				<tr bgcolor='ffffff' height='70' align='center'>
					<td width='70'><img src='http://$admin_row[shopUrl]/upload/goods/$img_str' width='50' height='50'></td>
					<td width='80'>$trade_row[tradecode]</td>
					<td width='190'>$goods_row[name]</td>
					<td width='150'>
						<table width='100' border='0' cellspacing='0' cellpadding='0'>";
						for($i=0;$i<count($optionArr);$i++)
						{
							if(!empty($optionArr[$i]))
							{
								$option = explode("」「",$optionArr[$i]);
								$body_DB.="
							<tr>
								<td width='45'  bgcolor='#F7F7F7'><div align='center'>$option[0]</div></td>
								<td bgcolor='#DDFFFB'><div align='left'> : $option[1]</div></td>
							</tr>
							<tr  bgcolor='#CCCCCC'>
								<td colspan='2' height='1'></td>
							</tr>";
							}
						}
						$body_DB.= "
						</table>
					</td>
					<td width='70'>$trade_goods_row[cnt]</td>
					<td width='100'>$str_tprice</td>
				</tr>";
				$total_price +=$tprice;					//총구매가격
			}
			$trade_payM_str = PriceFormat($trade_payM);
			$body_DB.= "
			</table><br>
			<table cellSpacing='1' cellPadding='0' width='660' align='center' border='0' bgcolor='#DADADA'>
				<tr>
					<td bgcolor='#F4F4F4' height='30' align='center' width='180'>결제 금액</td>
					<td bgcolor='#FFFFFF' style='padding:0 0 0 10'><b><font color='#FF0000'>$trade_payM_str</font></b> 원</td>
				</tr>
				<tr>
					<td bgcolor='#F4F4F4' height='30' align='center' width='180'>구매일</td>
					<td bgcolor='#FFFFFF' style='padding:0 0 0 10'>$trade_row[writeday]</td>
				</tr>
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
<p class='tbg'>&nbsp;</p>";
$body.= $body_DB ."</body></html>";

if($_PRINT)
{
	echo "$body";
}
else
{
	$mime_type = "text/html";
	$mail_body = ($body);
	$date = date("D, d M Y H:i:s +0900");  
	$subject = "$admin_row[comName] 주문취소 내역";
	$MANAGEMENT_MAIL_ADDRESS = $admin_row[adminEmail];

	$pp = popen(escapeshellcmd("$SENDMAIL_PATH -t -f $MANAGEMENT_MAIL_ADDRESS"),"w");
	fputs($pp,"Date: $date\n");
	fputs($pp,"From: $admin_row[comName] 관리자 <$MANAGEMENT_MAIL_ADDRESS>\n");
	fputs($pp,"Subject: $subject\n");
	fputs($pp,"Sender: $MANAGEMENT_MAIL_ADDRESS\n");
	fputs($pp,"To: $email\n");
	fputs($pp,"Reply-To: $MANAGEMENT_MAIL_ADDRESS\n");
	fputs($pp,"MIME-Version: 1.0\n");
	fputs($pp,"Content-Type: $mime_type; charset=euc_kr\n\n");
	fputs($pp,$mail_body);
	pclose($pp);
}
?>