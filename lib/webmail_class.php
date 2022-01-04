<?
function qpDecode($in)
{
	if(preg_match("/=\?(.*)\?[qQ]\?(.*)\?=(.*)=\?(.*)\?[qQ]\?(.*)\?=/ei",$in,$regs)) return quoted_printable_decode($regs[2]).quoted_printable_decode($regs[5]);
	elseif(preg_match("/=\?(.*)\?[qQ]\?(.*)\?=/ei",$in,$regs)) return quoted_printable_decode($regs[2]);
	else return $in;
}

function qpDecode2($in)
{
	$in = str_replace("=\r\n","",$in);
	$in = str_replace("=\n","",$in);
	return quoted_printable_decode($in);
}

function b64Decode($in)
{
	if(preg_match("/=\?(.*)\?[bB]\?(.*)\?=(.*)=\?(.*)\?[bB]\?(.*)\?=/ei",$in,$regs)) return base64_decode($regs[2]).base64_decode($regs[5]);
	elseif(preg_match("/=\?(.*)\?[bB]\?(.*)\?=/ei",$in,$regs)) return base64_decode($regs[2]);
	else return $in;
}

function b64Decode2($in)
{
	$in = str_replace("\n","",$in);
	$in = str_replace("\r","",$in);
	return base64_decode($in);
}

function dbquote($input)
{
	return str_replace("\'","''",$input);
}

function dbquote_2($input)
{
	return str_replace("'","''",$input);
}

function inputquote($input)
{
	return str_replace("\"","&quot;",$input);
}

class CMail
{
	var $MySQL;
	/*	default value setting	*/
	var $Mail_Badmin		= 0;
	var $Mail_MessageID		= "(No Message ID)";
	var $Mail_From			= "(No From)";
	var $Mail_To			= "(No To)";
	var $Mail_Reply			= "(No Reply)";
	var $Mail_Subject		= "(No Subject)";
	var $Mail_Date			= "(No Date)";
	var $Mail_Folder		= "1";
	var $File_Write_Name	= "(No Data file)";
	var $Mail_Attach		= 0;
	var $Mail_Level			= "M";
	var $Mail_Auto_Reply	= "N";
	var $Mail_Size			= 0;
	var	$Mail_Eml_Name		= "";				//.eml 파일명
	var $User_Mail_Key		= "";

	var $MESSAGE_ID		= "/Message-ID: (.*)/i";
	var $FROM			= "/From: (.*)/i";
	var $TO				= "/To: (.*)/i";
	var $REPLY			= "/Return-Path: (.*)/i";
	var $SUBJECT		= "/Subject: (.*)/i";
	var $DATE			= "/Date: (.*)/i";
	var $ATTACHMENT		= "/attachment(.*)/i";
	var $FILENAME		= "/filename=(.*)/i";
	var $X_PRIOR1		= "/X-Priority: 1(.*)/i";
	var $X_PRIOR5		= "/X-Priority: 5(.*)/i";

	function InitMail($fp, $badmin)
	{
		global $MySQL;
		$this->MySQL=$MySQL;
		$t = microtime();
		$this->Mail_Eml_Name = str_replace(" ","",substr($t,2,19)).".eml";
		$this->Mail_Badmin = $badmin;

		if($this->Mail_Badmin)
		{
			$wp = fopen("../eml/".$this->Mail_Eml_Name,"w");
		}
		else
		{
			$wp = fopen("eml/".$this->Mail_Eml_Name,"w");
		}

		$exit = 1;
		while($exit)
		{
			$buffer = "";
			$buffer = fgets($fp,255);
			if(substr($buffer,0,1)=="." && substr($buffer,1,1) =="\n") $exit = 0;
			elseif(substr($buffer,0,1)=="." && substr($buffer,1,2) =="\r\n") $exit = 0;
			else
			{
				fputs($wp,$buffer);

				$this->Mail_Size = $this->Mail_Size + strlen($buffer);

				$buffer = str_replace("\n","",$buffer);
				$buffer = str_replace("\r","",$buffer);

				if($this->Mail_MessageID == "(No Message ID)" && preg_match("$this->MESSAGE_ID",$buffer,$regs))
				{
					$regs[1] = qpDecode($regs[1]);
					$this->Mail_MessageID = b64Decode($regs[1]);
					$this->Mail_MessageID = dbquote_2($this->Mail_MessageID);
				}

				if($this->Mail_From == "(No From)" && preg_match("$this->FROM ",$buffer,$regs))
				{
					$regs[1] = qpDecode($regs[1]);
					$this->Mail_From = b64Decode($regs[1]);
					$this->Mail_From = dbquote_2($this->Mail_From);
				}

				if($this->Mail_To == "(No To)" && preg_match("$this->TO ",$buffer,$regs))
				{
					$regs[1] = qpDecode($regs[1]);
					$this->Mail_To = b64Decode($regs[1]);
					$this->Mail_To = dbquote_2($this->Mail_To);
				}

				if($this->Mail_Reply == "(No Reply)" && preg_match("$this->REPLY ",$buffer,$regs))
				{
					$regs[1] = qpDecode($regs[1]);
					$this->Mail_Reply = b64Decode($regs[1]);
					$this->Mail_Reply = dbquote_2($this->Mail_Reply);
				}

				if($this->Mail_Subject == "(No Subject)" && preg_match("$this->SUBJECT",$buffer,$regs))
				{
					$regs[1] = qpDecode($regs[1]);
					$this->Mail_Subject_temp = b64Decode($regs[1]);
					$this->Mail_Subject = dbquote_2($this->Mail_Subject_temp);
				}

				if($this->Mail_Date == "(No Date)" && preg_match("$this->DATE",$buffer,$regs))
				{
					$regs[1] = qpDecode($regs[1]);
					$this->Mail_Date = b64Decode($regs[1]);
					$this->Mail_Date = dbquote_2($this->Mail_Date);
				}

				if(preg_match("$this->FILENAME",$buffer,$regs))
				{
					$this->Mail_Attach = 1;
				}

				if(preg_match("$this->ATTACHMENT",$buffer,$regs))
				{
					$this->Mail_Attach = 1;
				}

				if(preg_match("$this->X_PRIOR1",$buffer,$regs))
				{
					$this->Mail_Level = "H";
				}

				if(preg_match("$this->X_PRIOR5",$buffer,$regs))
				{
					$this->Mail_Level = "L";
				}
			}
		}
		fclose ($wp);
	}

	function MFileDelete()
	{
		if($this->Mail_Badmin)
		{
			if(file_exists("../eml/$this->Mail_Eml_Name"))	//같은파일명 체크
			{
				@unlink("../eml/$this->Mail_Eml_Name");
			}
		}
		else
		{
			if(file_exists("eml/$this->Mail_Eml_Name"))		//같은파일명 체크
			{
				@unlink("eml/$this->Mail_Eml_Name");
			}
		}
	}

	function DBinput($badmin,$user,$mbox)
	{
		$qry = "INSERT INTO webmail_mail(m_messageid,m_from,m_to,m_reply,m_subject,m_writeday,m_attach,";
		$qry.= "m_filename,m_size,m_level,userid,mbox,badmin)values(";
		$qry.= "'$this->Mail_MessageID',";
		$qry.= "'$this->Mail_From',";
		$qry.= "'$this->Mail_To',";
		$qry.= "'$this->Mail_Reply',";
		$qry.= "'$this->Mail_Subject',";
		$qry.= "now(),";
		$qry.= "$this->Mail_Attach,";
		$qry.= "'$this->Mail_Eml_Name',";
		$qry.= "$this->Mail_Size,";
		$qry.= "'$this->Mail_Level',";
		$qry.= "'$user',";
		$qry.= "'$mbox',$badmin)";

		if(!$this->MySQL->query($qry))
		{
			if($badmin)
			{
				@unlink("../eml/$this->Mail_Eml_Name");
			}
			else
			{
				@unlink("eml/$this->Mail_Eml_Name");
			}
		}
	}
}

class CWebMailServerConnect
{
	var $WebmailServer;
	var $WebmailPort;

	//default.conf 파일을 참조하여 기본값을 세팅한다.
	function InitDefaultconf($url)
	{
		$this->WebmailServer = $_SERVER['SERVER_ADDR'];

		$fp = fopen($url."default.conf","r");
		while(!feof($fp))
		{
			$buf = fgets($fp,1024);
			if(strlen($buf) >0 && substr($buf,0,1) !='#')
			{
				$token = strtok($buf," \t\n");
				if($token!="" && $token=="__allplan_GMNEO_server_port")
				{
					$token = strtok(" \t\n");
					$port = $token;
					break;
				}
			}
		}
		fclose($fp);
		$this->WebmailPort = $port;
	}

	//서버에 계정 존재 여부 체크
	function BExistId($userid,$err)
	{
		$socket = @fsockopen($this->WebmailServer, $this->WebmailPort, &$errno, &$errstr);
		@set_socket_blocking($socket, 1);

		if(!$socket)
		{
			$err = "-ERR 웹메일 서버 주소가 올바르지 않거나 서버에 접속할 수 없습니다. : $this->WebmailServer";
			return false;
		}
	
		fputs($socket,"B_EXIST_ID $userid");
		$buf = fgets($socket,255);
		fclose($socket);

		if(substr($buf,0,1)=='-')
		{
			$err = $buf;
			return false;
		}
		elseif(substr($buf,0,1)=='+' && substr($buf,4,1)=='1')
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	//서버에 계정 추가
	function UserAdd($userid,$pwd,$err)
	{
		$socket = @fsockopen($this->WebmailServer, $this->WebmailPort, &$errno, &$errstr);
		@set_socket_blocking($socket, 1);

		if(!$socket)
		{
			$err = "-ERR 웹메일 서버 주소가 올바르지 않거나 서버에 접속할 수 없습니다. : $this->WebmailServer";
			return false;
		}
	
		fputs($socket,"USER_ADD $userid $pwd");
		$buf = fgets($socket,255);
		fclose($socket);

		if(substr($buf,0,1)=='-')
		{
			$err = $buf;
			return false;
		}

		return true;
	}

	//서버에 계정 비밀번호 변경
	function PasswdEdit($userid,$pwd,$err)
	{
		$socket = @fsockopen($this->WebmailServer, $this->WebmailPort, &$errno, &$errstr);
		@set_socket_blocking($socket, 1);

		if(!$socket)
		{
			$err = "-ERR 웹메일 서버 주소가 올바르지 않거나 서버에 접속할 수 없습니다. : $this->WebmailServer";
			return false;
		}
	
		fputs($socket,"PASSWD_EDIT $userid $pwd");
		$buf = fgets($socket,255);
		fclose($socket);

		if(substr($buf,0,1)=='-')
		{
			$err = $buf;
			return false;
		}

		return true;
	}

	//서버에서 계정 삭제
	function UserDel($userid,$err)
	{
		$socket = @fsockopen($this->WebmailServer, $this->WebmailPort, &$errno, &$errstr);
		@set_socket_blocking($socket, 1);

		if(!$socket)
		{
			$err = "-ERR 웹메일 서버 주소가 올바르지 않거나 서버에 접속할 수 없습니다. : $this->WebmailServer";
			return false;
		}
	
		fputs($socket,"USER_DEL $userid");
		$buf = fgets($socket,255);
		fclose($socket);

		if(substr($buf,0,1)=='-')
		{
			$err = $buf;
			return false;
		}

		return true;
	}
}