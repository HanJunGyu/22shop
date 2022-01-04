<?
if(count($_GET)) extract($_GET); 
if($form_name == "mWForm" || $form_name == "goodsForm" || $form_name == "mainForm" || $form_name == "pageForm" || $form_name == "adm_etcForm")
{
	$frame_size = "680";
}
else
{
	$frame_size = "540";
}
?>
<HTML>
<HEAD>
<TITLE></TITLE>
<link rel="stylesheet" href="style.css">
<style>
body { font-size: 9pt; font-family:굴림; color: #333333; text-decoration: none; }
td { font-size: 9pt; color: #333333; text-decoration: none; }
select    { font-size: 9pt; color: black;   background-color:#FFFfF8;border:1px solid #333333; }
A:link    { font-size: 9pt; color: #336699; text-decoration: none; }
A:active  { font-size: 9pt; color: #336699; text-decoration: none; }
A:visited { font-size: 9pt; color: #336699; text-decoration: none; }
A:hover   { font-size: 9pt; color: #ffaa00; text-decoration: none; }
</style>
<SCRIPT language=JavaScript>
<!--
var viewMode = parent.document.<?=$form_name?>.bHtml.value; // WYSIWYG 
var bold_flag =0;
var italic_flag =0;
var underline_flag =0;

function MM_swapImgRestore() 
{
	var i,x,a=document.MM_sr; for(i=0;a&&i<a.length&&(x=a[i])&&x.oSrc;i++) x.src=x.oSrc;
}
function MM_preloadImages() 
{
	var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
	var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
	if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}
function MM_findObj(n, d) 
{
	var p,i,x;
	if(!d) d=document; 
	if((p=n.indexOf("?"))>0&&parent.frames.length) 
	{
		d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);
	}
	if(!(x=d[n])&&d.all) x=d.all[n];
	for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
	for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
	if(!x && document.getElementById) x=document.getElementById(n); return x;
}
function MM_swapImage() 
{
	var i,j=0,x,a=MM_swapImage.arguments; document.MM_sr=new Array; for(i=0;i<(a.length-2);i+=3)
	if ((x=MM_findObj(a[i]))!=null){document.MM_sr[j++]=x; if(!x.oSrc) x.oSrc=x.src; x.src=a[i+2];}
}
var lastd = 0;
function keyDown()
{
	var form = document.apply;
	var keyValue = iframeArea.event.keyCode;
	if(viewMode == 0)	//html 편집기 모드에서 특정문자 html 타입으로 변환
	{
		var insChar, flgChange;
		switch (keyValue)
		{
			case 55 :	insChar = "&amp;";	flgChange = true;	//'&'
			case 32 :	insChar = "&nbsp;";	flgChange = true;	//' '
			case 188 :	insChar = "&lt;";	flgChange = true;	//'<'
			case 190 :	insChar = "&gt;";	flgChange = true;	//'>'
			default :	flgChange = false;
		}
		if(flgChange)
		{
			var coll = TargetDoc.selection.createRange();
			coll.pasteHTML(insChar);
			form.RetVal.value = "1";
			return false;
		}
	}
	else if(keyValue == 13)
	{
		var coll = TargetDoc.selection.createRange();
		coll.pasteHTML("<br>");
		iframeArea.event.keyCode=40;
		if (form.RetVal.value == "0")
			return false;
		form.RetVal.value = "0";
		return true;
	}
	form.RetVal.value = "1";
	return true;
}
function FontSize_onchange(size)
{
	iView.document.execCommand('FontSize', '', size);
	iView.focus();
}
function FontName_onchange(fname)
{
	iView.document.execCommand('FontName', '', fname);
	iView.focus();
}
function BOLD_onclick()
{
	if (bold_flag == 1)
	{
		MM_swapImage('Image1','','./images/bold0.gif',1)
			bold_flag=0;
	}
	else
	{
		MM_swapImage('Image1','','./images/bold1.gif',1)
		bold_flag=1;
	}
	iView.document.execCommand('Bold',false,null);
	iView.focus();
}
function ITALIC_onclick()
{
	if (italic_flag == 1)
	{
		MM_swapImage('Image2','','./images/italic0.gif',1)
		italic_flag=0;
	}
	else
	{
		MM_swapImage('Image2','','./images/italic1.gif',1)
		italic_flag=1;
	}
	iView.document.execCommand('Italic');
	iView.focus();
}
function UNDERLINE_onclick()
{
	if (underline_flag == 1)
	{
		MM_swapImage('Image3','','./images/underline0.gif',1)
		underline_flag=0;
	}
	else
	{
		MM_swapImage('Image3','','./images/underline1.gif',1)
		underline_flag=1;
	}
	iView.document.execCommand('Underline');
	iView.focus();
}
function LEFT_onclick()
{
	iView.document.execCommand('JustifyLeft');
	iView.focus();
}
function CENTER_onclick()
{
	iView.document.execCommand('JustifyCenter');
	iView.focus();
}
function RIGHT_onclick()
{
	iView.document.execCommand('JustifyRight');
	iView.focus();
}
function LINK_onclick()
{
	iView.document.execCommand('CreateLink',1,"");
	iView.focus();
}
function SETFORECOLOR_onclick()
{
	var color = showModalDialog("ColorChart.html",0,"dialogHeight=200px;dialogWidth=250px; scrollbars=no; status=0; help=0");
	if (color != null)
	{
		iView.focus();
		iView.document.execCommand('ForeColor', '', color);
	}
	iView.focus();
}
function CHAR_onclick()
{
	iView.focus();
	var charac = showModalDialog("char_sel.html",0,"dialogheight=230px; dialogwidth=160px;scrollbars=no;status=0;help=0");
	if (charac != null) 
	{
		var sel = TargetDoc.selection.createRange();
		sel.pasteHTML(charac);
		sel.select();
	}
	iView.focus();
}
function getElem(sTag,start)
{
	while ((start != null) && (start.tagName != sTag)) start = start.parentElement;
	return start;
}
function create_table()
{
	iView.focus();
	var table = showModalDialog("c_table.html",0,"dialogheight=145px; dialogwidth=340px;scrollbars=no;status=0;help=1");
	if (table != null) 
	{
		var sel = TargetDoc.selection.createRange();
		sel.pasteHTML(table);
		sel.select();
	}
	iView.focus();
}
function load_in()
{
	abc = parent.document.<?=$form_name?>.<?=$form_content?>.value;
	if (abc)
	{
		iframeArea.document.open();
		iframeArea.document.write("<style> body { font-size:10pt ; } </style>");
		iframeArea.document.close();
		Ifdoc.designMode = 'on';
		TargetDoc=iframeArea.document;
		TargetDoc.onkeydown = keyDown;
		viewMode = 0;
		iView.document.body.innerText = abc;
		iText = iView.document.body.innerText;
		iView.document.body.innerHTML = iText;
	}
	else
	{
		iframeArea.document.open();
		iframeArea.document.write("<style> body { font-size:10pt ; } </style>");
		iframeArea.document.close();
		viewMode = 0;
		Ifdoc=window.frames.iframeArea.document;
		Ifdoc.designMode = 'on';
		TargetDoc=iframeArea.document;
		TargetDoc.onkeydown = keyDown;
	}
}
function status_view_onload()
{
	if (viewMode == 1)
	{
		document.getElementById('a').innerHTML ="<font color=red>HTML 보기</font>";
	}
	else
	{
		document.getElementById('a').innerHTML ="<font color=blue>내용보기</font>";
	}
}
function status_view()
{
	if (viewMode == 1)
	{
		document.getElementById('a').innerHTML ="<font color=red>HTML 보기</font>";
	}
	else
	{
		document.getElementById('a').innerHTML ="<font color=blue>내용보기</font>";
	}
	iView.focus();
}
function doToggleView()
{
	if(viewMode == 0) //내용보기상태 -> HTML보기 
	{
		iHTML = iView.document.body.innerHTML;
		iView.document.body.innerText = iHTML;
		viewMode = 1; // Code  
		status_view();
	}
	else // HTML보기 -> 내용보기상태 
	{
		iText = iView.document.body.innerText;
		iView.document.body.innerHTML = iText;
		viewMode = 0; // WYSIWYG
		status_view();
	}
}
function gogo()
{
	if (viewMode ==0)
	{
		// 편집상태가 소스보기가 아닐때는 HTML로 변경
		iHTML = iView.document.body.innerHTML;
		parent.document.<?=$form_name?>.<?=$form_content?>.value=iHTML;
	}
	else
	{
		// 편집상태가 소스보기일때는 소스그대로 유지 
		iText = iView.document.body.innerText;
		parent.<?=$form_name?>.<?=$form_content?>.value=iText;
	}
	parent.document.<?=$form_name?>.bHtml.value = 1;
}
//-->
</SCRIPT>
</head>
<BODY aLink=red bgColor=white onload='load_in(); status_view_onload();' >
<form method=post action="" name=apply enctype="multipart/form-data">
<input type=hidden name="RetVal" value="0">
<table border="0" cellpadding="1" width="556" bgcolor="#ECF6FD" class="table" align=center>
	<tr>
		<td valign=top>
			<table width="550" border="0"  cellpadding="0" cellspacing="0" align=center>
				<tr align=left >
					<td width="241"><select name="Font Name" size="1" style="width:90px; left:155px;" onchange="FontName_onchange(this[this.selectedIndex].value);" LANGUAGE="javascript"><option value="굴림" selected>기본체</option><option value="굴림체">굴림체</option><option value="바탕체">바탕체</option><option value="돋움체">돋움체</option><option value="궁서체">궁서체</option><option value="Arial">Arial </option><option value="Tahoma">Tahoma </option><option value="Courier New">Courier New </option><option value="Times New Roman">New Roman </option><option value="Wingdings">Wingdings</option><option value="SimSun">SimSun</option><option value="NSimSun">NSimSun</option><option value="SimHei">SimHei</option></select> <select LANGUAGE="javascript" onchange="FontSize_onchange(this[this.selectedIndex].value);" name="size" style="width:35px;" size="1"><option value="1">1 </option><option value="2">2 </option><option value="3">3 </option><option value="4">4 </option><option value="5">5 </option><option value="6">6 </option><option value="7">7</option></select></td>
					<td width="2"><div align="left"><img src="images/line.gif"></div></td>
					<td width="23"><a onClick="javascript:return BOLD_onclick()"  style="cursor:pointer"><img src="./images/bold0.gif" alt="굵게"  name="Image1"  border="0"></a></td>
					<td width="23"><a onClick="javascript:return ITALIC_onclick()" style="cursor:pointer"><img src="./images/italic0.gif" alt="기울림"  name="Image2" border="0"></a></td>
					<td width="23"><a onClick="javascript:return UNDERLINE_onclick()" style="cursor:pointer"><img src="./images/underline0.gif" alt="밑줄"  name="Image3"  border="0"></a></td>
					<td width="2"><div align="left"><img src="images/line.gif"></div></td>
					<td width="23"><a onClick="javascript:return SETFORECOLOR_onclick()" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Image4','','./images/color1.gif',1)"><img src="./images/color0.gif" alt="문자색"  name="Image4"  border="0"></a></td>
					<td width="2"><div align="left"><img src="images/line.gif"></div></td>
					<td width="23"><a onClick="javascript:return LEFT_onclick()" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Image5','','./images/left1.gif',1)"><img src="./images/left0.gif" alt="왼쪽 정렬"  name="Image5"  border="0"></a></td>
					<td width="23"><a onClick="javascript:return CENTER_onclick()" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Image6','','./images/center1.gif',1)"><img src="./images/center0.gif" alt="가운데 정렬"  name="Image6"  border="0"></a></td>
					<td width="23"><a onClick="javascript:return RIGHT_onclick()" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Image7','','./images/right1.gif',1)"><img src="./images/right0.gif" alt="오른쪽 정렬"  name="Image7"  border="0"></a></td>
					<td width="2"><div align="left"><img src="images/line.gif"></div></td>
					<td width="68" ><a onClick="javascript:return create_table()" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Image8','','./images/table1.gif',1)"><img src="./images/table0.gif" alt="표 작성" name="Image8"  border="0"></a></td>
					<td width="2"><div align="left"><img src="images/line.gif"></div></td>
					<td width="68"><a onClick="javascript:return LINK_onclick()" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Image9','','./images/link1.gif',1)"><img src="./images/link0.gif" alt="링크" name="Image9"   border="0"></a></td>
					<td width="2">&nbsp;</td>
				</tr>
				<tr>
					<td colspan="16" height=2></td>
				</tr>
				<tr>
					<td colspan="16">&nbsp;&nbsp;※ 에디터 툴을 사용한후 본문저장시 HTML 모드로 자동변환되어 저장됩니다.&nbsp;<img src="images/line.gif" align='absmiddle'>&nbsp;<a onClick="iView.focus(); window.open('editor_image.php','','scrollbars=yes,left=100,top=50,width=600,height=550');" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Image20','','./images/img_1.gif',1)"><img src="./images/img.gif" alt="링크" name="Image20"   border="0" align="absmiddle"></a></td>
				</tr><?
				if($form_name == "mWForm" || $form_name == "pageForm")
				{
					$frame_size = "680";
				}
				else
				{
					$frame_size = "540";
				}
				?>
				<tr>
					<td colspan="16"><IFRAME id="iView" name="iframeArea" size="2" width="<?=$frame_size?>" height="380"  FRAMEBORDER=0 style="left:0px; top:0px;  background-color:#FFFFFF; border-width:1; border-color:#45250C; border-style:solid;  visibility: visible;"></IFRAME></td>
				</tr>
			</table>
			<table>
				<tr>
					<td><a onclick="doToggleView()"><img src="image/text_html.gif" border=0></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
					<td id="a"></td>
				</tr>
			</table>
		</td>
	</tr>
</table>
</form>
</BODY>
</HTML>
<SCRIPT language=JavaScript>
<!--
Ifdoc=window.frames.iframeArea.document;
Ifdoc.designMode = 'on';
TargetDoc=iframeArea.document;
TargetDoc.onkeydown = keyDown;
//-->
</SCRIPT>