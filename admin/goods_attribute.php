<?
include "head.php";
?>
<SCRIPT LANGUAGE="JavaScript">
<!--
var targetObj = opener.document.goodsForm.strPart<?=$Index?>;  //옵션문자열
if(targetObj.value =="")
{
	//옵션배열 초기화
	var attArr = new Array();
	var attCnt =0;
}
else
{
	var attArr = targetObj.value.split("」「");
	var attCnt = attArr.length;
}

//옵션문자열 입력
function attSendit()
{
	targetObj.value = attArr.join("」「");
	window.close();
}

//옵션배열 입력
function inputAtt()
{
	var form=document.attForm;
	if(form.att_str.value=="")
	{
		alert("옵션을 입력해 주십시오.");
		form.att_str.focus();
	}
	else
	{
		attArr[attCnt]= form.att_str.value;		//옵션입력
		attCnt++;								//옵션카운트 증가
		showAttribute();
		form.att_str.value ="";
		form.att_str.focus();
	}
}

//옵션삭제
function delAtt(Index)
{
	attCnt = delArray(attArr,Index);
	attArr=attArr.slice(0,attCnt);			//삭제후 배열 리메이크
	showAttribute();
}

//옵션 열거
function showAttribute()
{
	var form=document.attForm;
	for(i=0;i<20;i++)
	{
		var id_att_f=eval("document.getElementById('id_att_"+i+"').style");
		if(attArr[i])
		{
			form.attribute[i].value = attArr[i];
			id_att_f.display = "block";
		}
		else
		{
			id_att_f.display = "none";
		}
	}
	form.att_str.focus();
}

//엔터키 체크
function inputChek()
{
	if(event.keyCode==13) inputAtt();
}
//-->
</SCRIPT>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onload="javascript:showAttribute();">
<form name="attForm" method="post">
<table width="400" border="0" cellpadding="0" cellspacing="1" bgcolor="#B6B6B6" align="center">
	<tr>
		<td valign="top" bgcolor="#FFFFFF"><img src="image/goods_pup.gif" width="398" height="29"><br><br>
			<table width="380" border="0" align="center">
				<tr bgcolor="#EFEFEF">
					<td height="30" colspan="2"><div align="center"><font color="#6666FF">상품 옵션명 : <B><?=$Val?></B></font></div></td>
				</tr>
				<tr bgcolor="#EFEFEF">
					<td colspan="2"><?
						for($i=0;$i<20;$i++)
						{
							?>
						<table width="380" border='0' cellpadding='0' cellspacing='0' id="id_att_<?= $i?>" style="display:none;">
							<tr>
								<td width="300" height="30" bgcolor="ffffff"> <div align="center"><input class="nonbox" type="text" size="20" name="attribute" readonly></div></td>
								<td width="80" height="30" bgcolor="fafafa"> <div align="center"><a href="javascript:delAtt(<?=$i?>);"><img src="image/delete_btn.gif" width="40" height="17" border="0"></a></div></td>
							</tr>
						<table><?
						}
						?>
					</td>
				</tr>
				<tr>
					<td width="300" height="30" bgcolor="fafafa"> <div align="center"><input class="box" type="text" size="20" name="att_str"  onkeydown="javascript:inputChek();"></div></td>
					<td width="80" height="30" bgcolor="fafafa"> <div align="center"><a href="javascript:inputAtt();"><img src="image/insert_btn.gif" width="70" height="22" border="0"></a></div></td>
				</tr>
				<tr bgcolor="#D9D9D9">
					<td height="24" colspan="2"><div align="center"><br>
						<table width="50%" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td><a href="javascript:attSendit();"><img src="image/complete.gif" border="0"></a></td>
								<td><a href="javascript:window.close();"><img src="image/cancel_btn.gif" width="40" height="17" border="0"></a></td>
							</tr>
						</table><br><br></div>
					</td>
				</tr>
				<tr bgcolor="#ffffff">
					<td height="24" colspan="2">&nbsp;</td>
				</tr>
			</table>
		</td>
	</tr>
</table>
</form>
</body>
</html>