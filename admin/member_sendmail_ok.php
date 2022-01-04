<?
include "head.php";
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
if (empty($_POST['mail_list'])) //발송메일 현황에서 넘어올때
{
}
else if (empty($_POST[auth_code]) || strtoupper($_POST[auth_code]) != $_SESSION['SESSION_AUTH_CODE'])
{
	MsgView("보안코드가 일치하지 않습니다.",-1);
	exit;
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

if ($re_send)
{
	$send_result=@$MySQL->query("select *from mailing_list where sending='N' order by idx asc");
	while($row=@mysql_fetch_array($send_result))
	{
		ob_start();
		include "./mail_content/".$row[file_num];
		$mail_body=ob_get_contents();
		ob_end_clean();
		$subject=$row[subject];
		$email = $row[to2];
		$idx = $row[idx];
		$mime_type="text/html";
		$date=date("D, d M Y H:i:s +0900");  
		$MANAGEMENT_MAIL_ADDRESS=$admin_row[adminEmail];
		$idx=$row[idx];
		$pp=popen(escapeshellcmd("$SENDMAIL_PATH -t -f $MANAGEMENT_MAIL_ADDRESS"),"w");
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
		$MySQL->query("update mailing_list set sending='Y', send_day=now() where idx=$idx");
		///////////// 발송도중에 PHP 파일이 죽어버리면 sending을 Y로 업데이트 못하므로 발송못한 내역을 볼수있다. 
	}
	MsgViewHref("메일 전송을 완료 하였습니다. 발송현황관리에서 확인하시기 바랍니다. ","mailing_list.php");
	exit;
}

if($design[mainLogoImg_type]==4)
{
	$logo="<object classid='clsid:D27CDB6E-AE6D-11cf-96B8-444553540000' codebase='http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=5,0,0,0' width='155' height='70'><param name=movie value='http://$admin_row[shopUrl]/upload/design/$design[mainLogoImg]'><param name=quality value=high><embed src='http://$admin_row[shopUrl]/upload/design/$design[mainLogoImg]' quality=high pluginspage='www.macromedia.com/shockwave/download/index.cgi?P1_Prod_Version=ShockwaveFlash' type='application/x-shockwave-flash' width='155' height='70'></embed></object>";
}
else
{
	$logo ="<img src='http://$admin_row[shopUrl]/upload/design/$design[mainLogoImg]'>";
}
if($bHtml==2) $content=stripslashes($HtmlContent);
if($bHtml==1) $content=nl2br(htmlspecialchars($TextContent));
$now=date("Y년 m월 d일");
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
.tbg {  background-image: url(http://$admin_row[shopUrl]/admin/image/good_mail_bg.gif); background-repeat: no-repeat; background-position: left top}
</style>
</head>
<body bgcolor='#FFFFFF' text='#000000'>
<table width='600' border='0' cellspacing='0' cellpadding='0' align='center'>
	<tr>
		<td>$logo</td>
	</tr>
	<tr>
		<td valign='top'>
			<table width='600' border='0' cellspacing='0' cellpadding='0'>
				<tr>
					<td><img src='http://$admin_row[shopUrl]/admin/image/good_mail_t.gif' width='600' height='10'></td>
				</tr>
				<tr>
					<td background='http://$admin_row[shopUrl]/admin/image/good_mail_tbg.gif' valign='top'>
						<table width='594' border='0' cellspacing='0' cellpadding='0' align='center'>
							<tr>
								<td height='300' valign='top'>&nbsp;$content</td>
							</tr>
							<tr>
								<td>&nbsp;</td>
							</tr>
							<tr>
								<td bgcolor='e6e6e6' height='50'><div align='center'><font color='#666666'>본메일은 정보통신망 이용촉진 및 정보보호 등에 관한 법률 시행규칙 제11조 제3항에 의거 2003년 3월 12일 기준 회원님의 광고메일 수신동의 여부를 확인한 결과 회원님께서 수신을 동의 하셨기에 발송되었습니다. </font></div></td>
							</tr>
							<tr>
								<td height='2'></td>
							</tr>
							<tr>
								<td bgcolor='e6e6e6' height='30'><div align='center'><font color='#666666'>메일을 원하지 않으실 경우에는 로그인 하신 후에 [정보수정]에서 [e-mail 수신여부]를 변경해 주세요.</font></div></td>
							</tr>
							<tr>
								<td height='2'></td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td height='110' bgcolor='EAEAEA'>";
					$body.=$BOTTOM_HTML;
					$body.="
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>
</body>
</html>";
if(trim($body))
{
	$mail_file = date('YmdHis');
	$fh = fopen("mail_content/".$mail_file, 'w+');
	fwrite($fh, stripslashes($body));
	fclose($fh);
}

ob_start();
include "./mail_content/".$mail_file;
$mail_body=ob_get_contents();
ob_end_clean();

$mime_type="text/html";
$date=date("D, d M Y H:i:s +0900");  
$subject="$admin_row[comName] ".$title;
$MANAGEMENT_MAIL_ADDRESS=$admin_row[adminEmail];

if ($idx_arr)
{
	$temp = explode("/",$idx_arr);
	for ($i=0; $i<count($temp); $i++)
	{
		$row = $MySQL->fetch_array("SELECT email from member WHERE idx=$temp[$i] and bMail=1 limit 1");
		$email = $row[email];
		if($email) $MySQL->query("insert into mailing_list set subject='$subject', `from2`='관리자', `to2`='$email', file_num='$mail_file', sending='N'");
	}
	$send_result=@$MySQL->query("select * from mailing_list where sending='N' and file_num='$mail_file' order by idx asc");
	while($row=@mysql_fetch_array($send_result))
	{
		$email=$row[to2];
		$idx=$row[idx];
		$pp=popen(escapeshellcmd("$SENDMAIL_PATH -t -f $MANAGEMENT_MAIL_ADDRESS"),"w");
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
		$MySQL->query("update mailing_list set sending='Y', send_day=now() where idx='$idx'");
		///////////// 발송도중에 PHP 파일이 죽어버리면 sending을 Y로 업데이트 못하므로 발송못한 내역을 볼수있다. 
	}
	MsgViewHref("메일 전송을 완료 하였습니다.","mailing_list.php");
}
else
{
	$qry="select *from member where bMail=1";
	$result=$MySQL->query($qry);
	while($row=mysql_fetch_array($result))
	{
		$email=$row[email];
		$MySQL->query("insert into mailing_list set subject='$subject', from2='관리자', to2='$email', file_num='$mail_file', sending='N'");
	}
	$send_result=@$MySQL->query("select *from mailing_list where sending='N' and file_num='$mail_file' order by idx asc");
	while($row=@mysql_fetch_array($send_result))
	{
		$email=$row[to2];
		$pp=popen(escapeshellcmd("$SENDMAIL_PATH -t -f $MANAGEMENT_MAIL_ADDRESS"),"w");
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
		$MySQL->query("update mailing_list set sending='Y', send_day=now() where idx='$row[idx]'");
		///////////// 발송도중에 PHP 파일이 죽어버리면 sending을 Y로 업데이트 못하므로 발송못한 내역을 볼수있다. 
	}
	MsgViewHref("메일 전송을 완료 하였습니다. 발송현황관리에서 확인하시기 바랍니다. ","mailing_list.php");
}
?>