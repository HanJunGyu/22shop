<?
include "head.php";
if($part=="page") $title = "사용자페이지";
else			  $title = "공지사항";
?>
<SCRIPT LANGUAGE="JavaScript">
<!--
function uploadFile()
{
	var form=document.uploadForm;
	if(form.file.value=="")
	{
		alert("파일을 선택해 주십시오.");
	}
	else form.submit();
}
function winresize()
{
	window.resizeTo(635,375);
}
function send2CB(lee)
{
	var doc = eval('document.uploadForm.'+ lee +'.createTextRange()');
	doc.execCommand('copy');
	alert("클립보드에 저장되었습니다 Ctrl+v로 붙여넣기 하세요"); 
}
//-->
</SCRIPT>
<body bgcolor="#FFFFFF" text="#000000" topmargin='0' leftmargin='0' onload="javascript:winresize();">
<table width="600" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td align="center"><img src="image/upload_tit.gif" width="600" height="100"></td>
	</tr>
	<tr>
		<td height="60">
			<form name="uploadForm" method="post" action="input_img_ok.php" enctype="multipart/form-data" >
			<input type="hidden" name="code" value="<?=$code?>"><!-- ex) 12345689 -->
			<input type="hidden" name="part" value="<?=$part?>">
			<table width="500" border="0" cellspacing="1" cellpadding="0" align="center" bgcolor="#D7D7D7" height="50">
				<tr>
					<td bgcolor="fafafa" width="400" align="center"> <input type="file" name="file" size="30"></td>
					<td bgcolor="#FFFFFF"> <div align="center"><a href="javascript:uploadFile();"><img src="image/save_btn.gif" width="40" height="17" border="0"></a></div></td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td height="80">
			<table width="450" border="0" cellspacing="0" cellpadding="0" align="center">
				<tr>
					<td height="20"><font color="#006DC1"><?=$title?> 이미지 코드 : <?=$code?></FONT></td>
				</tr>
				<tr>
					<td height="30"><font color="#009BD4">이미지를 업로드 한후에 나타나는 이미지를 <b><font color=red size=3>클릭</font></b>하신후에 붙여넣으시면 됩니다.<br>※ 클릭시 Ctrl+C 에 기능이 자동으로 됩니다.</font></td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td height="80">
			<table width="550" border="0" cellspacing="0" cellpadding="5" align="center">
			<!-- 업로드된 파일 목록 시작 --><?
			$qry = "select *from up_file where code='$code' order by name asc";
			$result = $MySQL->query($qry);
			$cnt=0;
			while($up_row=mysql_fetch_array($result))
			{
				$cnt++;
				$size_up_img	=@getimagesize("../upload/$part/$up_row[name]");   //이미지 정보
				$wSize	=$size_up_img[0];	//가로
				$hSize	=$size_up_img[1];	//세로
				?>
				<tr>
					<td width="60" height="30" bgcolor="fafafa"> <div align="center"><a  href="javascript:zoom('../upload/<?=$part?>/<?=$up_row[name]?>','<?=$wSize?>','<?=$hSize?>');"><img src="../upload/<?=$part?>/<?=$up_row[name]?>" width="30" height="30" border="0"></a></div></td>
					<td width="450" height="30" bgcolor="fafafa"class="blue"> <a href="#" onClick="javascript:send2CB('copyform_<?=$cnt?>');">&lt;img src="http://<?=$admin_row[shopUrl]?>/upload/<?=$part?>/<?=$up_row[name]?>"&gt;</a></td>
					<input type='hidden' name='copyform_<?=$cnt?>' value="<img src=http://<?=$admin_row[shopUrl]?>/upload/<?=$part?>/<?=$up_row[name]?>>">
					<td width="40" height="30" bgcolor="fafafa"> <div align="center"><a href="input_img_ok.php?delIdx=<?=$up_row[idx]?>&code=<?=$code?>&part=<?=$part?>"><img src="image/delete_btn.gif" width="40" height="17" border="0"></a></div><!-- 관련이미지 삭제 --></td>
				</tr><?
			}
			?>
			<!-- 업로드된 파일 목록 끝 -->
			</table>
		</td>
	</tr>
	<tr>
		<td height="25" bgcolor="#EBEBEB"> <div align="center"><a href="javascript:window.close();">창닫기</a></div></td>
	</tr>
</table>
</form>
</body>
</html>