<?
session_start();
include "../lib/config.php";
include "../lib/function.php";
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
$subdesign=$MySQL->fetch_array("select * from sub_design limit 0,1");
if(!defined(__DESIGN_GOODS_ROW))
{
	define(__DESIGN_GOODS_ROW,"TRUE");
	$design_goods=$MySQL->fetch_array("select *from design_goods limit 0,1");
}
$admin_row = $MySQL->fetch_array("select *from admin");
if($GOOD_SHOP_USERID)
{
	$member_row = $MySQL->fetch_array("select *from member where userid='$GOOD_SHOP_USERID'");
	$name=$member_row[name];
	$email=$member_row[email];
}
if($From=="admin")
{
	$name="관리자";
	$email=$admin_row[adminEmail];
}
?>
<html>
<head>
<title>이메일 보내기</title>
<style>
<?=$design[css]?>
</style>
<meta http-equiv="Content-Type" content="text/html; charset=euc-kr">
<script language=javascript src="../script/admin.js"></script>
</head>
<SCRIPT LANGUAGE="JavaScript">
<!--
function mailSendit()
{
	cdiv.gogo();
	var form=document.mailForm;
	<?
	if (!$trade)
	{
		?>
	if(!isEmail(form.to.value))
	{
		alert("받는이의 이메일이 올바르지 않습니다.");
		form.to.focus();
	}
	else if(form.name.value=="")
	{
		alert("이름을 입력해 주십시오.");
		form.name.focus();
	}
	else if(!isEmail(form.from.value))
	{
		alert("보내는이의 이메일이 올바르지 않습니다.");
		form.from.focus();
	}
	else if(form.title.value=="")
	{
		alert("제목을 입력해 주십시오.");
		form.title.focus();
	}
	else if(form.auth_code.value=="")
	{
		alert("보안코드를 입력해 주세요.");
		form.auth_code.focus();
	}
	<?
	}
	else
	{
		?>
	if(form.title.value=="")
	{
		alert("제목을 입력해 주십시오.");
		form.title.focus();
	}
	<?
	}
	?>
	else
	{
		form.submit();
	}
}
//-->
</SCRIPT>
<body bgcolor="#FFFFFF" text="#464646" leftmargin="10" topmargin="10" marginwidth="10" marginheight="10">
<table width="610" border='0' cellpadding='0' cellspacing='0'>
	<tr>
		<td width='4'><img src='../image/sub/table_tleft.gif'></td>
		<td width='602' background='../image/sub/table_tbg.gif'></td>
		<td width='4'><img src='../image/sub/table_tright.gif'></td>
	</tr>
	<tr>
		<td background='../image/sub/email_bg.gif' colspan='3' align='center'>
			<table width="590" border="0" cellspacing="0" cellpadding="0" align='center'>
				<tr>
					<td align='center'><img src="image/top.gif"></td>
				</tr>
			</table>
			<table width="560" border="0" cellspacing="0" cellpadding="0" align='center'>
				<form name="mailForm" method="post" action="mail_ok.php" encType="multipart/form-data">
				<input type="hidden" name="trade" value="<?=$trade?>">
				<tr>
					<td valign="top"><br>
						<table width="590" border="0" cellspacing="0" cellpadding="0" align="center"><?
						if (!$trade)
						{
							?>
							<tr>
								<td width="100" height="25"><img src="image/tel.gif"></td>
								<td width="450" height="25">&nbsp;<input class="box_s" type="text" name="to" size="25" value="<?=$To?>" readonly></td>
							</tr>
							<tr>
								<td width="100" height="25"><img src="image/name.gif"></td>
								<td width="450" height="25">&nbsp;<input class="box_s" type="text" name="name" size="15" value="<?=$name?>"></td>
							</tr>
							<tr>
								<td width="100" height="25"><img src="image/mail.gif"></td>
								<td width="450" height="25">&nbsp;<input class="box_s" type="text" name="from" size="25" value="<?=$email?>"></td>
							</tr><?
						}
						?>
							<tr>
								<td width="100" height="25"><img src="image/title.gif"></td>
								<td width="450" height="25">&nbsp;<input class="box_s" type="text" name="title" size="57" value=""></td>
							</tr>
							<tr>
								<td width="100" height="25"><img src="../admin/auth_img/auth_code.gif"></td>
								<td width="258" height="25">
									<table width="100%" border="0" cellspacing="0" cellpadding="0">
										<tr>
											<td><? include "../lib/auth_img.php"; ?></td>
											<td><input class="box_s"type="text" name="auth_code" size="8" value=""></td>
										</tr>
									</table>
								</td>
							</tr>
							<tr>
								<td width="100" height="25"><img src='image/file.gif'></td>
								<td width="450" height="25">&nbsp;<input class="box_s" type="file" name="fileupload"></td>
							</tr>
							<tr>
								<td width="100" height="25"><img src="image/content.gif"></td>
								<td width="450" height="25" valign="bottom" align='right'><font class='stext' color='ff4800'>※ 아래 내용을 작성하신 후에 [메일보내기]를 누르세요.</font> <a href="javascript:mailSendit();"><img src="image/send2.gif" border="0" align='absmiddle'></a> </td>
							</tr>
						</table>
						<table width="550" border="0" cellspacing="0" cellpadding="0" align="center" height="230">
							<tr>
								<td height="240" style='padding:10 0 0 0'><?
							$form_name = "mailForm";
							$dir_path = "..";
							include "../editor.php";
							?><input type="hidden" name="bHtml" value="0"><textarea style="display:none" name="content" cols="95" rows="17" class="text"><?=$content?></textarea></td>
							</tr>
							</form>
						</table>
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td><img src='../image/sub/table_bleft.gif'></td>
		<td background='../image/sub/table_bbg.gif'></td>
		<td><img src='../image/sub/table_bright.gif'></td>
	</tr>
</table>
</body>
</html>