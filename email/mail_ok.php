<?
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
if (empty($_POST[auth_code]) || strtoupper($_POST[auth_code]) != $_SESSION['SESSION_AUTH_CODE'])
{
	MsgView("보안코드가 일치하지 않습니다.",-1);
	exit;
}
/*------------------------회원전체 메일 보내기 ---------------------------------*/
$admin_row=$MySQL->fetch_array("select *from admin where idx=1");
$BOTTOM_HTML = $admin_row[mail_bottom];
$BOTTOM_HTML = str_replace("__comName",$admin_row[comName],$BOTTOM_HTML);
$BOTTOM_HTML = str_replace("__adminEmail",$admin_row[adminEmail],$BOTTOM_HTML);
$BOTTOM_HTML = str_replace("__esailNum",$admin_row[esailNum],$BOTTOM_HTML);
$BOTTOM_HTML = str_replace("__comNum",$admin_row[comNum],$BOTTOM_HTML);
$BOTTOM_HTML = str_replace("__comCeo",$admin_row[comCeo],$BOTTOM_HTML);
$BOTTOM_HTML = str_replace("__comTel",$admin_row[comTel],$BOTTOM_HTML);
$BOTTOM_HTML = str_replace("__comFax",$admin_row[comFax],$BOTTOM_HTML);
$BOTTOM_HTML = str_replace("__comAdr",$admin_row[comAdr],$BOTTOM_HTML);

if($design[mainLogoImg_type]==4)
{
	$logo="<object classid='clsid:D27CDB6E-AE6D-11cf-96B8-444553540000' codebase='http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=5,0,0,0' width='155' height='70'><param name=movie value='http://$admin_row[shopUrl]/upload/design/$design[mainLogoImg]'><param name=quality value=high><embed src='http://$admin_row[shopUrl]/upload/design/$design[mainLogoImg]' quality=high pluginspage='www.macromedia.com/shockwave/download/index.cgi?P1_Prod_Version=ShockwaveFlash' type='application/x-shockwave-flash' width='155' height='70'></embed></object>";
}
else
{
	$logo ="<img src='http://$admin_row[shopUrl]/upload/design/$design[mainLogoImg]'>";
}
if ($bHtml) { $content = str_replace("\\","",$content); }
else $content=str_replace("\n","<br>",$content);
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
<TABLE cellSpacing='0' cellPadding='0' width='700' align='center' border='0'>
	<TR>
		<TD background='http://$admin_row[shopUrl]/admin/image/mail_mem_tit.gif' style='padding:5 5 5 35' height='85'>$logo</TD>
	</TR>
</table>
<TABLE cellSpacing='0' cellPadding='0' width='700' align='center' border='0'>
	<tr>
		<td colspan='5' background='http://$admin_row[shopUrl]/admin/image/mail_mem_tit2.gif' style='padding:75 0 0 35' height='162'><b><font color='#FF4800'>$admin_row[comName]</font></b>에서 고객님께 발송하는 메일입니다..</td>
	</tr>
</table>
<table width='700' border='0' cellspacing='0' cellpadding='0' align='center'>
	<tr>
		<td background='http://$admin_row[shopUrl]/admin/image/good_mail_bg2.gif'>
			<table width='660' border='0' cellspacing='0' cellpadding='0' align='center'>
				<tr>
					<td height='300' valign='top'>&nbsp;$content</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
				</tr>
				<tr>
					<td bgcolor='#F4f4f4' height='50'> <div align='center'><font color='#666666'>본메일은 정보통신망 이용촉진 및 정보보호 등에 관한 법률 시행규칙 제11조 제3항에 의거 2003년 3월 12일 기준 회원님의 광고메일 수신동의 여부를 확인한 결과 회원님께서 수신을 동의 하셨기에 발송되었습니다. </font></div></td>
				</tr>
				<tr>
					<td height='2'></td>
				</tr>
				<tr>
					<td bgcolor='#F4f4f4' height='30'> <div align='center'><font color='#666666'>메일을 원하지 않으실 경우에는 로그인 하신 후에 [정보수정]에서 [e-mail 수신여부]를 변경해 주세요.</font></div></td>
				</tr>
				<tr>
					<td height='2'></td>
				</tr>
			</table>
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
		</td>
	</tr>
</table>
</body>
</html>";
if ($fileupload)
{
	$filename =basename($fileupload_name); 
	$result = fopen($fileupload,"r"); 
	$file = fread($result,$fileupload_size); 
	fclose($result);
	$temp_file = explode(".",$fileupload_name);
	if ($temp_file[1]=="zip" || $temp_file[1]=="ZIP") $fileupload_type = "application/octet-stream"; 
	if ($fileupload_type == "")
	$fileupload_type = "application/octet-stream"; 
	//OnlyMsgView($fileupload_type);
	$boundary = "--------" . uniqid("part"); 
}
$mime_type="text/html";
$mail_body=($body);
$date=date("D, d M Y H:i:s +0900");  
$subject=$title;
$MANAGEMENT_MAIL_ADDRESS=$admin_row[adminEmail];

if($trade)
{
	$qry = "select distinct email from trade";
	$result = $MySQL->query($qry);
	while($row = mysql_fetch_array($result))
	{
		$email=$row[0];
		$pp=popen(escapeshellcmd("$SENDMAIL_PATH -t -f $MANAGEMENT_MAIL_ADDRESS"),"w");
		fputs($pp,"Date: $date\n");
		fputs($pp,"From: $name <$MANAGEMENT_MAIL_ADDRESS>\n");
		fputs($pp,"Subject: $subject\n");
		fputs($pp,"Sender: $MANAGEMENT_MAIL_ADDRESS\n");
		fputs($pp,"To: $email\n");
		fputs($pp,"Reply-To: $MANAGEMENT_MAIL_ADDRESS\n");
		fputs($pp,"MIME-Version: 1.0\n");
		fputs($pp,"Content-Type: $mime_type; charset=euc_kr\n\n");
		fputs($pp,$mail_body);
		pclose($pp);
	}
}
else
{
	// 개별 보내기
	$email=$to;
	$pp=popen(escapeshellcmd("$SENDMAIL_PATH -t -f $MANAGEMENT_MAIL_ADDRESS"),"w");
	fputs($pp,"MIME-Version: 1.0\n");
	fputs($pp,"Date: $date\n");
	fputs($pp,"From: $name <$from>\n");
	fputs($pp,"Subject: $subject\n");
	fputs($pp,"Sender: $MANAGEMENT_MAIL_ADDRESS\n");
	fputs($pp,"To: $email\n");
	fputs($pp,"Reply-To: $from\n");
	if ($filename)
	{
		fputs($pp,"Content-Type: multipart/mixed; boundary=\"$boundary\"");
		fputs($pp,"\nX-Priority: 3\n");
		fputs($pp,"This is a multi-part message in MIME format.\n\n");
		fputs($pp,"--$boundary\n");
	}
	fputs($pp,"Content-Type: text/html; charset=euc-kr\n");
	fputs($pp,"Content-Transfer-Encoding: 8bit\n\n");
	fputs($pp,$mail_body);
	
	if ($filename)	fputs($pp,"\n--$boundary\n");
	
	if ($filename)
	{
		fputs($pp,"\n--$boundary\n");
		fputs($pp,"Content-Type: $fileupload_type; name=\"$filename\"\n");
		fputs($pp,"Content-Transfer-Encoding: base64\n"); 
		fputs($pp,"Content-Disposition: attachment; filename=$filename\n\n");
		fputs($pp,ereg_replace("(.{80})","\\1\n",base64_encode($file)));
		fputs($pp,"\n\n--$boundary--\n");
	}
	pclose($pp);
}
MsgViewClose("메일 전송을 완료 하였습니다.");
?>