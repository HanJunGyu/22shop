<?
include "./lib/config.php";
include "./lib/function.php";
if (empty($_POST)) exit;
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
if(!defined(__DESIGN_GOODS_ROW))
{
	define(__DESIGN_GOODS_ROW,"TRUE");
	$design_goods=$MySQL->fetch_array("select *from design_goods limit 0,1");
}
$sms = $MySQL->fetch_array("select * from smsinfo");
$showArr = explode("|",$design_goods[memberJoinShow]);			//표시
$sureArr = explode("|",$design_goods[memberJoinSure]);			//필수
$bDeal=in_array($bDeal,array(0,1))?$bDeal:0;
$pwd		=$pwd1;							// 비밀번호
$ssh		=$ssh1."-".$ssh2;				// 주민등록번호
$zip		=$zip1."-".$zip2;				// 우편번호
$tel		=$tel1."-".$tel2."-".$tel3;		// 연락처
$hand		=$hand1."-".$hand2."-".$hand3;	// 휴대전화
if(!$showArr[10] && !$sureArr[10])
{
	//메일수신여부 사용안할때 자동으로 수신으로 설정 
	if($bMail==1) $bMail	=1;			// 메일링리스트 ex) 1:허용  0:미허용
	else $bMail = 0;
}
if (!isset($bMail)) $bMail = 1;

$id_qry		="select *from member where userid='$userid' and part='M'";
$MySQL->query($id_qry);
$id_numrows	=$MySQL->is_affected();		//해당아이디 존재여부 ex) 존재 : 1이상
if (!$bDeal && ($showArr[5] || $sureArr[5]))
{
	$ssh_qry		="select *from member where ssh='$ssh' and part='M'";
	$MySQL->query($ssh_qry);
	$ssh_numrows	=$MySQL->is_affected();		//해당주민번호 존재여부 ex) 존재 : 1이상
}
$birth = $year."-".$month."-".$day; //생일 
$birth2 = $year2."-".$month2."-".$day2; //결혼기념일 
$ceo_zip = $ceo_zip1."-".$ceo_zip2;
$ceonum =  $ceonum1."-".$ceonum2."-".$ceonum3;
if($id_numrows)
{
	MsgView("이미 존재하는 아이디 입니다.\\n\\n다른 아이디를 입력해 주십시오.",-1);
	exit;
}
if($showArr[5] || $sureArr[5])
{
	if($ssh_numrows && $ssh!='-')
	{
		MsgView("기존의 아이디가 존재하는 주민등록번호 입니다.",-1);	 //주민등록번호 존재
		exit;
	}
}
$address1 = str_replace(",","",$address1);
$address2 = str_replace(",","",$address2);
$name = trim($name);
$userid = trim($userid);
$qry = "insert into member(name,userid,pwd,";
$qry.= "email,ssh,zip,address1,address2,city,tel,hand,bMail,writeday,point,bSms,bDeal,nearDay,birth,birth2,companyname,ceonum,ceoname,ceo_zip,ceo_address1,ceo_address2,upjongtype,jongmok";
$qry.= ")values(";
$qry.= "'$name',";			// 이름
$qry.= "'$userid',";			// 아이디
$qry.= "password('$pwd'),";		// 비밀번호
$qry.= "'$email',";			// 이메일
$qry.= "'$ssh',";				// 주민등록번호
$qry.= "'$zip',";				// 우편번호
$qry.= "'$address1',";		// 주소
$qry.= "'$address2',";		// 상세주소
$qry.= "'$city',";			// 거주지방
$qry.= "'$tel',";				// 연락처
$qry.= "'$hand',";			// 휴대전화
$qry.= "$bMail,";				// 메일링리스트 ex) 1:허용  0:미허용
$qry.= "now(),";				// 가입일
$qry.= "$admin_row[poReg],";	// 가입 적립금
$qry.= "'$bSms',";
$qry.= "$bDeal,";
$qry.= "now(),'$birth','$birth2'";
$qry.= ",'$companyname','$ceonum','$ceoname','$ceo_zip','$ceo_address1','$ceo_address2','$upjongtype','$jongmok'";
$qry.= ")";
if($MySQL->query($qry))
{
	//적립금 지급/////////////////////////////////////////////////////////////////////////////
	if ($admin_row[bUsepoint])
	{
		$pqry = "insert into point_table(part,userid,point,reason,writeday)values(";
		$pqry.= "'지급','$userid',$admin_row[poReg],'회원가입 지급',now())";
		@$MySQL->query($pqry) or die("Err. :$pqry");
	}
	// 메일 보내기 시작
	if($admin_row[bRegmail]=="y")
	{
		//가입메일 보내기
		include "email/member_join_success.php";
	}

	// sms 보내기 시작
	if ($bSms=="y")
	{
		if($sms[bSms] && !empty($sms[userid]) && !empty($sms[pwd]))
		{
			// 가입sms 보내기
			$SMS_PART = "member_join";
			include "sms/smsclient.php";
		}
	}
	$jdata = base64_encode("jName=$name&jUserid=$userid&jPwd=$pwd");
	ReFresh("member_join_success.php?jdata=$jdata");
}
else
{
	echo "Err. : <p>$qry";
}
?>