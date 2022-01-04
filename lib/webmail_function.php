<?
$__WEBMAIL_VERSION = "ver GoodMorningMail 1.0";

define(__LIST_MBOX,		1);		//받은편지함
define(__SEND_MBOX,		2);		//보낸편지함
define(__TEMP_MBOX,		3);		//임시편지함
define(__RECYCLE_MBOX,	4);		//휴지통

define(__MAIL_DEL,		1);		//서버에서 메일 삭제
define(__NOT_MAIL_DEL,	0);		//서버에서 메일 미삭제

//이메일 추출 함수
function EmailPickUp($str)
{
	ereg('[_a-zA-z0-9\-]+(\.[_a-zA-z0-9\-]+)*\@' . '[_a-zA-z0-9\-]+(\.[a-zA-z]{1,3})+',$str,$reg);
	return $reg[0];
}

//pop3 서버로 부터 메일 가져 오기
function GetPop3($badmin,$session_id,$server,$user,$pass,$mbox,$bdel,$err)
{
	global $MySQL;
	//서버접속
	$fp = @fsockopen($server, 110, &$errno, &$errstr);
	@set_socket_blocking($fp, 1);
	if(!$fp)
	{
		$err = "-ERR pop3 서버 주소가 올바르지 않습니다. : $server $errstr";
		return false;
	}

	//서버접속후 메세지 받아오기
	$buf=fgets($fp,255);
	if(substr($buf,0,1) != '+')
	{
		$err = "-ERR pop3 서버에 접속 할 수 없습니다. : $server";
		return false;
	}

	//아이디 입력
	fputs($fp,"user $user\n");
	$buf = fgets($fp,255);

	//비밀번호 입력
	fputs($fp,"pass $pass\n");
	$buf = fgets($fp,255);
	if(substr($buf,0,1) != '+')
	{
		$err = "-ERR 아이디 또는 비밀번호가 올바르지 않습니다. : $server";
		return false;
	}

	//메일목록 가져오기
	fputs($fp,"list\n");
	$buf = fgets($fp,255);
	
	$msg = 0;

	// 'list' 프로토콜 명령후 정상적인 출력일 경우 다음과 같이 메세지 보내옴
	// 메일번호와 메일용량 정보 출력, '.' 이면 완료
	//
	// +OK Mailbox scan listing follows
	// 1 1494
	// 2 2976
	// .

	while(substr($buf,0,1) != '.')
	{
		$buf = fgets($fp,255);

		if(substr($buf,0,1) != '.')
		{
			//공백으로 구분후 번호와 용량 저장
			list($mail_num[$msg],$mail_size[$msg]) = split(" ",$buf); 
			$mail_num[$msg] = (int)($mail_num[$msg]);
			$msg++;
		}
	}

	// 'retr' 프로토콜 명령으로 메일정보 가져옴
	// mail class 로 해당 메일 분석후 데이타베이스에 저장 - 메일헤더 정보만 데이타베이스에 저장.
	// 이유 : 메일본문 내용까지 저장하게 되면 데이타베이스 용량을 과도하게 사용할 수 있기 때문에.
	// 메일원본은 './eml' 폴더에 따로 저장 - 추후 메일보기에서 다시 사용하기 위해...

	if($msg > 0) 
	{
		for($j=0; $j < $msg; $j++)
		{
			fputs($fp,"retr $mail_num[$j]\n");
			$buffer=fgets($fp,255);
		
			if(substr($buffer,0,1) == '+')
			{
				global $dbp;
				$MailObj = new CMail;
				$MailObj -> InitMail($fp,$badmin);

				//수신거부 메일 여부 체크
				$from_mail = EmailPickUp($MailObj ->Mail_From);

				if($badmin)
				{
					$_reject_qry = "SELECT idx FROM webmail_reject WHERE badmin=$badmin and rej_email='$from_mail'";
				}
				else
				{
					$_reject_qry = "SELECT idx FROM webmail_reject WHERE userid='$session_id' and rej_email='$from_mail'";
				}
				$MySQL->query($_reject_qry);
				if($MySQL->is_affected())
				{
					$MailObj -> MFileDelete();
				}
				else
				{
					$MailObj -> DBinput($badmin,$session_id,$mbox);
				}
			}
		}

		//$bdel ==1 이면 서버에서 메일 읽은후 모두 삭제
		if($bdel)
		{
			for($j=0; $j < $msg; $j++)
			{
				fputs($fp,"dele $mail_num[$j]\n");
				$buf=fgets($fp,255);
			}
		}
	}
	
	//서버접속 종료
	fputs($fp,"quit\n");
	fclose($fp);

	return true;
}


//pop3 서버 체크하기
function CheckPop3($server,$user,$pass,$err)
{
	//서버접속
	$fp = @fsockopen($server, 110, &$errno, &$errstr);
	@set_socket_blocking($fp, 1);
	if(!$fp)
	{
		$err = "-ERR pop3 서버 주소가 올바르지 않습니다. : $server";
		return false;
	}

	//서버접속후 메세지 받아오기
	$buf = fgets($fp,255);
	if(substr($buf,0,1) != '+')
	{
		$err = "-ERR pop3 서버에 접속 할 수 없습니다. : $server";
		return false;
	}

	//아이디 입력
	fputs($fp,"user $user\n");
	$buf = fgets($fp,255);

	//비밀번호 입력
	fputs($fp,"pass $pass\n");
	$buf = fgets($fp,255);
	if(substr($buf,0,1) != '+')
	{
		$err = "-ERR 아이디 또는 비밀번호가 올바르지 않습니다. : $server";
		return false;
	}

	//서버접속 종료
	fputs($fp,"quit\n");
	fclose($fp);

	return true;
}

//pop3 서버 간단 체크하기
function SimpleCheckPop3($server,$err)
{
	//서버접속
	$fp = @fsockopen($server, 110, &$errno, &$errstr);
	@set_socket_blocking($fp, 1);
	if(!$fp)
	{
		$err = "-ERR pop3 서버 주소가 올바르지 않습니다. : $server";
		return false;
	}

	//서버접속후 메세지 받아오기
	$buf = fgets($fp,255);
	if(substr($buf,0,1) != '+')
	{
		$err = "-ERR pop3 서버에 접속 할 수 없습니다. : $server";
		return false;
	}

	//서버접속 종료
	fputs($fp,"quit\n");
	fclose($fp);

	return true;
}

//smtp 서버 체크하기
function CheckSmtp($server,$err)
{
	$CheckSmtp_RETURN = chr(13).chr(10);	// \r\n
	$fp = @fsockopen($server,25,&$errno, &$errstr, 30);
	if(!$fp)
	{
		$err = "-ERR smtp 서버 주소가 올바르지 않습니다. : $server";
		return false;
	}
	set_socket_blocking($fp,1);
	$smtp_msg = fgets($fp,255);

	fputs($fp,"QUIT$CheckSmtp_RETURN");
	$smtp_msg = fgets($fp,255);

	fclose($fp);

	return true;
}