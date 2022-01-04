<?
session_start();
include "lib/config.php";
include "lib/function.php";
if(!defined(__INCLUDE_CLASS_PHP)) include "./lib/class.php";
if(!defined(__ADMIN_ROW))
{
	define(__ADMIN_ROW,"TRUE");
	$admin_row=$MySQL->fetch_array("select *from admin limit 0,1");
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
$__SITE_ALIGN = $design[mainAlign];			//사이트 정열방식 ex)left, center
?>
<html>
<head>
<title><?=$admin_row[shopTitle]?></title>
<style>
<?=$design[css]?>
</style>
<meta http-equiv="Content-Type" content="text/html; charset=euc-kr">
<script language=javascript src="./script/admin.js"></script>
<SCRIPT LANGUAGE="JavaScript">
<!--
function sendit()
{
	var form=document.writeForm;
	if(form.name.value=="")
	{
		alert("이름을 입력해 주십시오.");
		form.name.focus();
	}
	else if(!bsshChek(form.ssh1.value,form.ssh2.value))
	{
		alert("주민등록 번호가 올바르지 않습니다.");
		form.ssh1.focus();
	}
	else
	{
		form.submit();
	}
}
function sendit_pwd()
{
	var form=document.writeForm;
	if(form.new_pwd.value=="")
	{
		alert("새로운 비밀번호를 입력해주시기 바랍니다.");
		form.new_pwd.focus();
	}
	else if(form.new_pwd.value!=form.re_new_pwd.value)
	{
		alert("비밀번호 확인이 일치하지 않습니다.");
		form.new_pwd.focus();
	}
	else
	{
		form.submit();
	}
}
//-->
</SCRIPT>
</head>
<body bgcolor="#FFFFFF" topmargin='10' leftmargin='10' text='464646' marginwidth="10" marginheight="10">
<table width="310" border='0' cellpadding='0' cellspacing='0'>
	<tr>
		<td width='4'><img src='image/sub/table_tleft.gif'></td>
		<td width='302' background='image/sub/table_tbg.gif'></td>
		<td width='4'><img src='image/sub/table_tright.gif'></td>
	</tr>
	<tr>
		<td background='image/sub/id_loss_bg.gif' colspan='3' align='center'>
			<table width="305" border="0" cellspacing="0" cellpadding="0" align="center">
				<tr>
					<td colspan="2" align="center"><?
					if ($part == 1)
					{
						?><img src="image/login/id_search.gif"><?
					}
					else
					{
						?><img src="image/login/pw_search.gif" ><?
					}
					?></td>
				</tr>
				<tr>
					<td>
						<table width="220" border="0" cellspacing="0" cellpadding="0" align="center">
							<tr>
								<td colspan="2" height='60' valign='top' align='center' style='padding:5 5 5 5'><font color='2992CE'><b>아이디 및 비밀번호는 회원가입시 적어주신 이메일로 보내드립니다.</b></font></td>
							</tr><?
							if ($ssh1)
							{
								$ssh = $ssh1."-".$ssh2;
								$qry = "select * from member where name='$name' and ssh='$ssh'";
								$MySQL->query($qry);
								if($MySQL->is_affected())
								{
									$member_row = $MySQL->fetch_array($qry);
									if ($part==1) /// 아이디 찾기 
									{
										?>
							<tr align="center">
								<td colspan="2" align="center">ID 는 <b><?=$member_row[userid]?></b> 입니다.<br><Br><a href="javascript:window.close();"><img src="image/icon/close.gif" border="0"></a></td>
							</tr><?
									}
									else /// 패스워드 찾기 
									{
										?>
							<form name="writeForm" method="post" action="id_loss_ok.php">
							<input type="hidden" name="idx" value="<?=$member_row[idx]?>">
							<tr align="center">
								<td width="120">새로운 비밀번호</td>
								<td width="167"> <input type="password" name="new_pwd" size="15" class="box_s"></td>
							</tr>
							<tr align="center">
								<td width="120">&nbsp;</td>
								<td width="167">&nbsp;</td>
							</tr>
							<tr align="center">
								<td width="120">비밀번호 입력확인</td>
								<td width="167"> <input type="password" name="re_new_pwd" size="15" class="box_s"></td>
							</tr>
							</form>
							<tr>
								<td colspan="2"><br>
									<table width="150" border="0" cellspacing="0" cellpadding="0" align="center">
										<tr>
											<td align="right"><a href="javascript:sendit_pwd();"><img src="image/login/ok.gif" width="45" height="22" border="0"></a></td>
											<td align="right"><a href="javascript:window.close();"><img src="image/login/cancel.gif" width="45" height="22" border="0"></a></td>
										</tr>
									</table>
								</td>
							</tr><?
									}
								}
								else
								{
									OnlyMsgView("죄송합니다. \\n\\n해당 회원을 찾을 수 없습니다.");
									Refresh("id_loss.php?part=$part");
								}
							}
							else // 일반 
							{
								?>
							<form name="writeForm" method="post" action="id_loss.php">
							<input type="hidden" name="part" value="<?=$part?>">
							<tr>
								<td width="80" height='30'><img src="image/login/name.gif" ></td>
								<td width="150" height='30'> <input type="text" name="name" size="10" class="box_s"></td>
							</tr>
							<tr>
								<td width="80" height='30'><img src="image/login/num.gif"></td>
								<td width="150" height='30'> <input type="text" name="ssh1" size="6" class="box_s" maxlength="6" <?=__ONLY_NUM?>> - <input type="text" name="ssh2" size="7" class="box_s" maxlength="7" <?=__ONLY_NUM?>></td>
							</tr>
							</form>
							<tr>
								<td colspan="2"><br>
									<table width="150" border="0" cellspacing="0" cellpadding="0" align="center">
										<tr>
											<td align="center"><a href="javascript:sendit();"><img src="image/icon/ok.gif" border="0"></a></td>
											<td align="center"><a href="javascript:window.close();"><img src="image/icon/cancel.gif" border="0"></a></td>
										</tr>
									</table>
								</td>
							</tr>
							<tr>
								<td colspan='2' height='10'></td>
							</tr><?
							}
							?>
						</table>
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td><img src='image/sub/table_bleft.gif'></td>
		<td background='image/sub/table_bbg.gif'></td>
		<td><img src='image/sub/table_bright.gif'></td>
	</tr>
</table>
</body>
</html>