<?
include "head.php";
$TOTAL_SIZE = laststrcut(get_cfg_var("upload_max_filesize"));
?>
<script language="javascript">
<!--
function preview(uploadFlag)
{
	var totalSize = <?=$TOTAL_SIZE?> *1024*1024;
	var bytevalue = 0;
	var target_img = null;
	var objViewMag = null;
	var imageurl = document.getElementsByName("imageurl").item(0);
	var file = document.getElementsByName("file").item(0);
	if (uploadFlag == "imageurl")
	{
		if (imageurl.value == "" || imageurl.value.indexOf("http://") != 0)
		{
			alert("http:// 로 시작되는 주소를 입력하셔야 합니다.");
			return;
		}
		if (!isImgType(imageurl.value.replace( /%/,"%25")))
		{
			alert("이미지 파일(GIF, JPG, BMP)만 삽입이 가능합니다.");
			return;
		}
		target_img = document.getElementById("preview_linkImg");
		target_img.src = imageurl.value.replace( /%/,"%25");
	}
	else if (uploadFlag == "file")
	{
		if (file.value == "")
		{
			alert("이미지를 선택해 주세요.");
			return;
		}
		if (!isImgType(file.value.replace( /%/,"%25")))
		{
			alert("이미지 화일만 업로드 할 수 있습니다.");
			return;
		}
		target_img = document.getElementById("preview_fileImg");
		target_img.src = "file:///" + file.value.replace( /%/,"%25");
	}
	newImg = new Image();
	if (uploadFlag == "imageurl")
	{
		newImg.src = imageurl.value.replace( /%/,"%25");
	}
	else if (uploadFlag == "file")
	{
		newImg.onload = function()
		{
			bytevalue = this.fileSize;
			document.getElementsByName("TOTAL").item(0).innerText = Math.round(bytevalue/1024);
		}
		newImg.src = "file:///" + file.value.replace( /%/,"%25");
		if (newImg.fileSize > totalSize)
		{
			alert("최대 업로드 용량을 초과하였습니다.\n 파일을 다시 선택해주세요.");
		}
	}
}
function isImgType(fileName)
{
	if ( fileName.substr(fileName.lastIndexOf(".")+1).toUpperCase() == "JPG" || fileName.substr(fileName.lastIndexOf(".")+1).toUpperCase() == "GIF" || fileName.substr(fileName.lastIndexOf(".")+1).toUpperCase() == "BMP")
	{
		return true;
	}
	else
	{
		return false;
	}
}
function sendIt()
{
	var form = document.imgForm;
	if (form.file.value == "")
	{
		alert("이미지를 선택해 주세요");
		form.file.focus();
	}
	else
	{
		form.submit();
	}
}
function sendIt2()
{
	var form = document.imgForm2;
	if (form.imageurl.value == "")
	{
		alert("이미지 경로를 선택해 주세요");
		form.imageurl.focus();
	}
	else
	{
		var img_url = "<img src="+form.imageurl.value+" align=absbottom>";
		var coll = opener.iframeArea.document.selection.createRange();
		coll.pasteHTML(img_url);
		coll.pasteHTML("<BR>");
		coll.select();
		opener.iView.focus();
		self.close();
	}
}
function mode(num)
{
	if (num==2)
	{
		link.style.display = "inline";
		mycom.style.display = "none";
	}
	else
	{
		link.style.display = "none";
		mycom.style.display = "inline";
	}
}
//-->
</script>
<body leftmargin=0 topmargin=0>
<table width="100%" border="0" cellspacing="0" cellpadding="0" align='center'>
	<tr>
		<td valign=middle align=left height=30 bgcolor="#BFE3F9">&nbsp;&nbsp;<img src='./image/img1.gif' align='absmiddle'> &nbsp;<b>이미지 삽입</b></td>
	</tr>
	<tr>
		<td height=2 bgcolor="#40AFF3"></td>
	</tr>
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="0" align='center'>
	<tr>
		<td valign=top align=left height=30>
			<table width=250 cellspacing="3" cellpadding="5">
				<tr bgcolor="E4E4E4">
					<td><a href="#;" onclick="javascript:mode(1);"><div align='center'>· 내 컴퓨터에서</div></a></td>
					<td height=30><a href="#;" onclick="javascript:mode(2);"><div align='center'>· 외부링크에서 </div></a></td>
				</tr>
			</table>
		</td>
	</tr>
	<tr id="mycom">
		<td valign='top'>
			<form name="imgForm" enctype="multipart/form-data" method="post" action="editor_image_ok.php">
			<table width=100% border="0" cellspacing="3" cellpadding="5">
				<tr bgcolor="EEEEEE" >
					<td><b>◎ 내 컴퓨터에서 파일찾기</b><br><input type="file" name="file" class="box" size=30 onchange="javascript:preview('file');"> 현재용량 <input type="text" class="text" name="TOTAL" value="" size=6 readonly> Kb / 최대 <font color=red><?=$TOTAL_SIZE?>M</font> 까지 업로드 </td>
				</tr>
				<tr>
					<td valign=top align=center height=20><img src="image/icon/save.gif" border=0 onclick="javascript:sendIt();" alt="저장버튼을 누르시면 약간의 이미지 저장시간이 소요됩니다.">&nbsp;&nbsp;&nbsp;&nbsp;<img src="image/icon/close.gif" border=0 onclick="javascript:self.close();"></td>
				</tr>
				<tr>
					<td valign=top align=center>
						<table border=0 class="box" width=100% height=350>
							<tr>
								<td align="center"><img  id="preview_fileImg" src="image/album4.gif"></td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
			</form>
		</td>
	</tr>
	<tr id="link"  style="display:none">
		<td>
			<form name="imgForm2" method="post">
			<table width=100% border="0" cellspacing="3" cellpadding="5">
				<tr bgcolor="EEEEEE">
					<td><b>◎ 외부에서 링크걸기</b><br><input type="text" name="imageurl" class="box" size=60 value="http://" > <input type="button" value="미리보기" onclick="javascript:preview('imageurl');" class="text">&nbsp;</td>
				</tr>
				<tr>
					<td valign=top align=center>
						<table border=0 class="box" width=100% height=300>
							<tr>
								<td align="center"><img  id="preview_linkImg" src="image/album4.gif"></td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td valign=top align=center><img src="image/icon/save.gif" border=0 onclick="javascript:sendIt2();" alt="저장버튼을 누르시면 약간의 이미지 저장시간이 소요됩니다.">&nbsp;&nbsp;&nbsp;&nbsp;<img src="image/icon/close.gif" border=0 onclick="javascript:self.close();"></td>
				</tr>
			</table>
			</form>
		</td>
	</tr>
</table>
</body>
</html>