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
		if(!defined(__DESIGN_ROW))
		{
			define(__DESIGN_ROW,"TRUE");
			$design=$MySQL->fetch_array("select *from design limit 0,1");
		}
	}
}
else
{
	global $design;			//사이트로고 배열변수
	global $admin_row;		    //관리자 배열변수
	global $member_row;
	global $pwd;
	$email = $member_row[email];
}
//로고 설정
if($design[mainLogoImg_type]==4)
{
	$logo="<object classid='clsid:D27CDB6E-AE6D-11cf-96B8-444553540000' codebase='http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=5,0,0,0' width='155' height='70'>
	<param name=movie value='http://$admin_row[shopUrl]/upload/design/$design[mainLogoImg]'><param name=quality value=high><embed src='http://$admin_row[shopUrl]/upload/design/$design[mainLogoImg]' quality=high pluginspage='www.macromedia.com/shockwave/download/index.cgi?P1_Prod_Version=ShockwaveFlash' type='application/x-shockwave-flash' width='155' height='70'></embed></object>";
}
else
{
	$logo ="<img src='http://$admin_row[shopUrl]/upload/design/$design[mainLogoImg]'";
}
$body="
<html>
<head>
<title>비밀번호변경메일</title>
<meta http-equiv='Content-Type' content='text/html; charset=euc-kr'>
<style>
BODY {	FONT-SIZE: 9pt; LINE-HEIGHT: 160%; FONT-FAMILY: '돋움'}
TD {	FONT-SIZE: 9pt; LINE-HEIGHT: 140%; FONT-FAMILY: '돋움'}
A:link {    text-decoration:none;     color:#000000;} 
A:visited {    text-decoration:none;     color:#000000;}
A:hover {    text-decoration:underline;     Color:#6377DC;}
A:active {    text-decoration:underline;    Color:#6377DC;}
BODY {scrollbar-face-color: #ffffff; scrollbar-shadow-color: #000000; scrollbar-highlight-color: #ffffff; scrollbar-3dlight-color: #000000; scrollbar-darkshadow-color: #ffffff; scrollbar-track-color: #eeeeee; scrollbar-arrow-color: #000000}
.tbg {  background-image: url(http://$admin_row[shopUrl]/admin/image/mail_pw_bg.gif); background-repeat: no-repeat; background-position: left top}
</style>
</head>
<body bgcolor='#FFFFFF' text='#000000'>
<TABLE cellSpacing='0' cellPadding='0' width='700' align='center' border='0'>
	<TR>
		<TD background='http://$admin_row[shopUrl]/admin/image/good_mail_pw_tit.gif' style='padding:5 5 5 35' height='85'>$logo</TD>
	</TR>
</table>
<TABLE cellSpacing='0' cellPadding='0' width='700' align='center' border='0'>
	<tr>
		<td colspan='5' background='http://$admin_row[shopUrl]/admin/image/good_mail_pw_tit2.gif' style='padding:75 0 0 35' height='162'><b><font color='#FF4800'>$member_row[name]</font></b> 회원님의 비밀번호가 변경되었습니다.</td>
	</tr>
</table>
<table width='700' border='0' cellspacing='0' cellpadding='0' align='center'>
	<tr>
		<td background='http://$admin_row[shopUrl]/admin/image/good_mail_bg2.gif'>";
		$body_DB = $admin_row[mail_pwd];
		$body_DB = str_replace("__URL","http://$admin_row[shopUrl]",$body_DB);
		$body_DB = str_replace("__LOGO",$logo,$body_DB);
		$body_DB = str_replace("__ID",$member_row[userid],$body_DB);
		$body_DB = str_replace("__PW",$pwd,$body_DB);
		$body_DB = str_replace("__BOTTOM_HTML",$BOTTOM_HTML,$body_DB);
		$body .=$body_DB;
		$body.="
		</td>
	</tr>
</table>
<table width='700' border='0' cellpadding='0' cellspacing='0' align='center'>
	<tr>
		<td background='http://$admin_row[shopUrl]/admin/image/good_mail_bg.gif' style='padding:10 0 0 0' height='90'>";
		$BOTTOM_HTML = $admin_row[mail_bottom];
		$BOTTOM_HTML = str_replace("__comName",$admin_row[comName],$BOTTOM_HTML);
		$BOTTOM_HTML = str_replace("__adminEmail",$admin_row[adminEmail],$BOTTOM_HTML);
		$BOTTOM_HTML = str_replace("__esailNum",$admin_row[esailNum],$BOTTOM_HTML);
		$BOTTOM_HTML = str_replace("__comNum",$admin_row[comNum],$BOTTOM_HTML);
		$BOTTOM_HTML = str_replace("__comCeo",$admin_row[comCeo],$BOTTOM_HTML);
		$BOTTOM_HTML = str_replace("__comTel",$admin_row[comTel],$BOTTOM_HTML);
		$BOTTOM_HTML = str_replace("__comFax",$admin_row[comFax],$BOTTOM_HTML);
		$BOTTOM_HTML = str_replace("__comAdr",$admin_row[comAdr],$BOTTOM_HTML);
		$body.=$BOTTOM_HTML; 
		$body.="
		<br></td>
	</tr>
</table>
</body>
</html>";
if($_PRINT)
{
	echo "$body";
}
else
{
	$mime_type="text/html";
	$mail_body=($body);
	$date=date("D, d M Y H:i:s +0900");  
	$subject="$admin_row[comName] 비밀번호 변경";
	$MANAGEMENT_MAIL_ADDRESS=$admin_row[adminEmail];
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
}
?>