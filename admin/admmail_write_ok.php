<?
include "head.php";
include "../lib/webmail_class.php";
include "../lib/webmail_function.php";

if($bHtml==1) $content=nl2br(htmlspecialchars($TextContent));
elseif($bHtml==2) $content = stripslashes($HtmlContent);
else $content = $content;

$RETURN = chr(13).chr(10);	// \r\n

//보내는 사람 메일 주소
$w_from = $webmail_admin_row[adm_email];

$w_to_cnt = 0;
$w_cc_cnt = 0;

$w_to_arr = explode(";",$w_to);
$w_to_cnt = count($w_to_arr);	//받는 사람 수
if($w_cc)
{
	$w_cc_arr = explode(";",$w_cc);	//참조 수
	$w_cc_cnt = count($w_cc_arr);
}
$to = join(" ,",$w_to_arr);
if($w_cc)
{
	$cc = join(" ,",$w_cc_arr);
}
if(empty($b_send_save))
{
	$b_send_save = 0;
}
$b_attach = 0;

if (!empty($w_attach1)) $b_attach=1;
if (!empty($w_attach2)) $b_attach=1;
if (!empty($w_attach3)) $b_attach=1;

$LEVEL="X-Priority: $LEVEL$RETURNX-MSMail-Priority: Normal$RETURN";

// 메일본문 설정
$body = str_replace(chr(13).chr(10),chr(10),$content);
$body = str_replace(chr(13),chr(10),$body);
$body = str_replace(chr(10),$RETURN,$body);
$message_body = $body."$RETURN$RETURN$RETURN";
$ContentType = "Content-Type: text/html;$RETURN\tcharset=ks_c_5601-1987$RETURN";
$message_body_stand=$message_body;
$message_body_stand=str_replace("\'","'",$message_body_stand);
$message_body_stand=str_replace(chr(92).chr(34),chr(34),$message_body_stand);
$message_body_stand=str_replace(chr(92).chr(92).chr(34),chr(34),$message_body_stand);
$db_message_body_stand = $message_body_stand;

// 보낸편지함 서장일 경우 메일 원보파일을 생성하기 위한 파일포인트 생성
if($b_send_save)
{
	$t = microtime();
	$msg_id = str_replace(" ","",substr($t,2,19));
	$m_filename = $msg_id.".eml";
	$wp = fopen("../eml/".$m_filename,"w");
}

$fp = fsockopen($webmail_admin_row[adm_smtp],25,&$errno, &$errstr, 30);
if(!$fp)
{
	echo"-ERR smtp 서버 주소가 올바르지 않습니다. : $webmail_admin_row[adm_smtp]";
	exit;
}
set_socket_blocking($fp,1);
$smtp_msg = fgets($fp,255);
fputs($fp,"HELO $webmail_admin_row[adm_smtp]$RETURN");
$smtp_msg = fgets($fp,255);

// from
fputs($fp,"MAIL from: $w_from$RETURN");
$smtp_msg = fgets($fp,255);

// to
for($i=0;$i<count($w_to_arr); $i++) 
{
	fputs($fp,"RCPT to: $w_to_arr[$i]$RETURN");
	$smtp_msg = fgets($fp,255);
}

// cc
for($i=0;$i<count($w_cc_arr); $i++) 
{
	fputs($fp,"RCPT to: $w_cc_arr[$i]$RETURN");
	$smtp_msg = fgets($fp,255);
}

// 여기서 부터 메일 원본 메세지를 smtp 서버로 보낸다.
// $b_send_save 가 "1" 이면 보낸편지함에 저장하기 위해 메일 원본파일 포인터에 값을 저장한다.
// "." 문자를 입력하게 되면 메일원본 메세지 입력을 마친다.
fputs($fp,"DATA$RETURN");	//메일 데이타가 시작됨
$smtp_msg = fgets($fp,255);

fputs($fp,"From: $webmail_admin_row[adm_name] <$w_from> $RETURN");
if($b_send_save) fputs($wp, "From: $webmail_admin_row[adm_name] <$w_from> $RETURN");

fputs($fp,"Return-Path: $w_from$RETURN");
if($b_send_save) fputs($wp, "Return-Path: $w_from$RETURN");

fputs($fp,"To: $to$RETURN");
if($b_send_save) fputs($wp, "To: $to$RETURN");

if($cc) 
{
	fputs($fp,"Cc: $cc$RETURN");
	if($b_send_save) fputs($wp,"Cc: $cc$RETURN");
}

fputs($fp,"Subject: $w_subject$RETURN");
if($b_send_save) fputs($wp, "Subject: $w_subject$RETURN");

fputs($fp,"X-Originating-IP:  [$REMOTE_ADDR]$RETURN");
if($b_send_save) fputs($wp, "X-Originating-IP:  [$REMOTE_ADDR]$RETURN");

fputs($fp,"$LEVEL");
if($b_send_save) fputs($wp, "$LEVEL");

fputs($fp,"X-mailer: [$__WEBMAIL_VERSION] http://$admin_row[shopUrl]/ $RETURN");
if($b_send_save) fputs($wp, "X-mailer: [$__WEBMAIL_VERSION] http://$admin_row[shopUrl]/ $RETURN");

// 첨부파일 설정 시작
if($b_attach) 
{
	$boundary = "----=_NextPart_".uniqid("");

	fputs($fp, "Content-Type: multipart/mixed;$RETURN");
	if($b_send_save) fputs($wp, "Content-Type: multipart/mixed;$RETURN");

	fputs($fp, "		boundary=\"----=$boundary\"$RETURN");
	if($b_send_save) fputs($wp, "		boundary=\"----=$boundary\"$RETURN");

	fputs($fp, "$RETURN");
	if($b_send_save) fputs($wp, "$RETURN");

	fputs($fp, "This is a multi-part message in MIME format.$RETURN");
	if($b_send_save) fputs($wp, "This is a multi-part message in MIME format.$RETURN");

	fputs($fp, "$RETURN");
	if($b_send_save) fputs($wp, "$RETURN");

	fputs($fp, "------=$boundary$RETURN");
	if($b_send_save) fputs($wp, "------=$boundary$RETURN");

	fputs($fp, "$ContentType");
	if($b_send_save) fputs($wp, "$ContentType");

	fputs($fp, "$RETURN");
	if($b_send_save) fputs($wp, "$RETURN");

	fputs($fp, $message_body_stand);
	if($b_send_save) fputs($wp, $db_message_body_stand);

	fputs($fp, "$RETURN");
	if($b_send_save) fputs($wp, "$RETURN");

	$MAX_ATTACH=3;
	for($att=1; $att <= $MAX_ATTACH; $att++) 
	{
		if(${"w_attach".$att} != "")
		{
			$attach_type = ${"w_attach".$att."_type"};
			$attach_name = ${"w_attach".$att."_name"};
			$file_size = filesize(${"w_attach".$att});
			$fhandle = fopen(${"w_attach".$att},"r");
			$attach_body = fread($fhandle, $file_size);
			fclose($fhandle);

			if(empty($attach_type))	$attach_type = "application/octet-stream";

			fputs($fp,"------=$boundary$RETURN");
			if($b_send_save) fputs($wp,"------=$boundary$RETURN");
	
			fputs($fp, "Content-Type: $attach_type;$RETURN");
			if($b_send_save) fputs($wp, "Content-Type: $attach_type;$RETURN");
	
			fputs($fp, "    name=\"$attach_name\"$RETURN");
			if($b_send_save) fputs($wp, "    name=\"$attach_name\"$RETURN");

			fputs($fp, "Content-Transfer-Encoding: base64$RETURN");
			if($b_send_save) fputs($wp, "Content-Transfer-Encoding: base64$RETURN");

			fputs($fp, "Content-Disposition: attachment;$RETURN");
			if($b_send_save) fputs($wp, "Content-Disposition: attachment;$RETURN");

			fputs($fp, "    filename=\"$attach_name\"$RETURN");
			if($b_send_save) fputs($wp, "    filename=\"$attach_name\"$RETURN");

			fputs($fp, "$RETURN");
			if($b_send_save) fputs($wp, "$RETURN");

			$attach_body = chunk_split(base64_encode($attach_body));
			fputs($fp, $attach_body);
			if($b_send_save) fputs($wp, $attach_body);

			fputs($fp, "$RETURN");
			if($b_send_save) fputs($wp, "$RETURN");
		}
	}

	fputs($fp,"$RETURN");
	if($b_send_save) fputs($wp, "$RETURN");

	fputs($fp, "------=$boundary"."--$RETURN");
	if($b_send_save) fputs($wp, "------=$boundary"."--$RETURN");
}
else
{
	fputs($fp, "$ContentType");
	if($b_send_save) fputs($wp, "$ContentType");

	fputs($fp, "Content-Transfer-Encoding: 8bit$RETURN");
	if($b_send_save) fputs($wp, "Content-Transfer-Encoding: 8bit$RETURN");

	fputs($fp, "$RETURN");	
	if($b_send_save) fputs($wp, "$RETURN");

	fputs($fp, "$RETURN");
	if($b_send_save) fputs($wp, "$RETURN");

	fputs($fp, $message_body_stand);
	if($b_send_save) fputs($wp, $db_message_body_stand);

	fputs($fp, "$RETURN");
	if($b_send_save) fputs($wp, "$RETURN");
}

if($b_send_save) fclose($wp);

if($b_send_save) //보낸편지함 저장일 경우 데이타베이스에 해당 메일 저장
{
	$size     = filesize("../eml/".$m_filename);
	$datestr  = date('Y/m/d H:i:s', time());

	$qry = "insert into webmail_mail(m_messageid,m_from,m_to,m_reply,m_subject,m_writeday,m_attach,";
	$qry.= "m_filename,m_size,m_level,badmin,mbox,bRead)values(";
	$qry.= "'$msg_id',";
	$qry.= "'$webmail_admin_row[adm_name] <$w_from>',";
	$qry.= "'$to',";
	$qry.= "'<$w_from>',";
	$qry.= "'$w_subject',";
	$qry.= "now(),";
	$qry.= "$b_attach,";
	$qry.= "'$m_filename',";
	$qry.= "$size,";
	$qry.= "'M',";
	$qry.= "1,";
	$qry.= "'2',1)";
	$MySQL->query($qry);
}
fputs($fp,"$RETURN.$RETURN");
$smtp_msg = fgets($fp,255);

fputs($fp,"QUIT$RETURN");
$smtp_msg = fgets($fp,255);

fclose($fp);
OnlyMsgView("메일전송을 완료 하였습니다.");
ReFresh("admmail_list.php?mbox=1");
?>