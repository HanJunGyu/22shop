<?
session_start();
include "./lib/config.php";
include "./lib/function.php";

if(!defined(__DESIGN_GOODS_ROW))
{
	define(__DESIGN_GOODS_ROW,"TRUE");
	$design_goods=$MySQL->fetch_array("select *from design_goods limit 0,1");
}

$showArr = explode("|",$design_goods[memberJoinShow]);		//표시
$sureArr = explode("|",$design_goods[memberJoinSure]);		//필수
$member_row = $MySQL->fetch_array("select * from member where userid='$_SESSION[GOOD_SHOP_USERID]'");
$ceonum =  $ceonum1."-".$ceonum2."-".$ceonum3;
if($memberdel)
{
	// 탈퇴회원 목록에 추가
	$qry = "insert into member_withdraw(name,userid,pwd,";
	$qry.= "email,ssh,zip,address1,address2,city,tel,hand,bMail,writeday,point,bSms";
	$qry.= ")values(";
	$qry.= "'$member_row[name]',";			// 이름
	$qry.= "'$member_row[userid]',";			// 아이디
	$qry.= "('$member_row[pwd]'),";				// 비밀번호
	$qry.= "'$member_row[email]',";			// 이메일
	$qry.= "'$member_row[ssh]',";				// 주민등록번호
	$qry.= "'$member_row[zip]',";				// 우편번호
	$qry.= "'$member_row[address1]',";		// 주소
	$qry.= "'$member_row[address2]',";		// 상세주소
	$qry.= "'$member_row[city]',";			// 거주지방
	$qry.= "'$member_row[tel]',";				// 연락처
	$qry.= "'$member_row[hand]',";			// 휴대전화
	$qry.= "$member_row[bMail],";				// 메일링리스트 ex) 1:허용  0:미허용
	$qry.= "now(),";				// 가입일
	$qry.= "$member_row[point],";	// 가입 적립금
	$qry.= "'$member_row[bSms]'";
	$qry.= ")";
	$MySQL->query($qry);

	$MySQL->query("delete from cart where userid='$_SESSION[GOOD_SHOP_USERID]'");
	$MySQL->query("delete from member where userid='$_SESSION[GOOD_SHOP_USERID]'");
	$MySQL->query("delete from interest where userid='$_SESSION[GOOD_SHOP_USERID]'");
	$MySQL->query("delete from point_table where userid='$_SESSION[GOOD_SHOP_USERID]'");

	OnlyMsgView("탈퇴완료 하였습니다. \\n\\n그동안 저희 사이트를 이용해 주셔서 대단히 감사합니다.");
	ReFresh("login_ok.php?del=1");
}
else
{
	/*------------------------회원정보수정 ---------------------------------*/
	$pwd		=$pwd1;							// 비밀번호
	$zip		=$zip1."-".$zip2;				// 우편번호
	$tel		=$tel1."-".$tel2."-".$tel3;		// 연락처
	$hand		=$hand1."-".$hand2."-".$hand3;	// 휴대전화
	if (!isset($bMail))		$bMail	=1;			// 메일링리스트 ex) 1:허용  0:미허용
	$ceo_zip = $ceo_zip1."-".$ceo_zip2;
	$birth = $year."-".$month."-".$day;
	$birth2 = $year2."-".$month2."-".$day2;

	$qry = "update member set ";
	if ($pwd)	$qry.= "pwd		= password('$pwd'),";				// 비밀번호
	$qry.= "email	= '$email',";			// 이메일
	$qry.= "zip		= '$zip',";				// 우편번호
	$qry.= "address1= '$address1',";		// 주소
	$qry.= "address2= '$address2',";		// 상세주소
	$qry.= "city	= '$city',";			// 거주지방
	$qry.= "tel		= '$tel',";				// 연락처
	$qry.= "hand	= '$hand',";			// 휴대전화
	$qry.= "bMail	= $bMail,";				// 메일링리스트 ex) 1:허용  0:미허용
	$qry.= "bSms	= '$bSms',";
	$qry.= " companyname='$companyname', ";
	$qry.= " ceonum='$ceonum', ";
	$qry.= " ceoname='$ceoname', ";
	$qry.= " ceo_zip='$ceo_zip', ";
	$qry.= " ceo_address1='$ceo_address1', ";
	$qry.= " ceo_address2='$ceo_address2', ";
	$qry.= " upjongtype='$upjongtype', ";
	$qry.= " jongmok ='$jongmok', ";	
	$qry.= " birth='$birth', ";
	$qry.= " birth2='$birth2', ";
	$qry.= ",refund_bank	= '".addslashes($refund_bank)."'";
	$qry.= ",refund_name	= '".addslashes($refund_name)."'";
	$qry.= ",refund_account	= '".addslashes($refund_account)."'";
	$qry.= ",bDeal	= '".$bDeal."'";
	$qry.= " where userid='$_SESSION[GOOD_SHOP_USERID]' ";

	if($MySQL->query($qry))
	{
		OnlyMsgView("수정완료 하였습니다.");
		ReFresh("mypage_member.php");
	}
	else
	{
		echo "Err. : <p>$qry";
	}
}
?>