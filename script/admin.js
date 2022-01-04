/*
// 소스형상관리
// 20060722-1 파일추가 김성호
// 20060722-2 소스수정 김성호 : 주민번호(bsshChek) 체크변경
*/
var isDOM = (document.getElementById ? true : false);
var isIE4 = ((document.all && !isDOM) ? true : false);
var isNS4 = (document.layers ? true : false);

function getRef(id)
{
	if (isDOM) return document.getElementById(id);
	if (isIE4) return document.all[id];
	if (isNS4) return document.layers[id];
}
var isNS = navigator.appName == "Netscape";
function moveRightEdge()
{
	var yMenuFrom, yMenuTo, yOffset, timeoutNextCheck;
	if (isNS4)
	{
		yMenuFrom   = divMenu.top;
		yMenuTo     = windows.pageYOffset + 0;   // 위쪽 위치
	}
	else if (isDOM)
	{
		yMenuFrom   = parseInt (divMenu.style.top, 10);
		yMenuTo     = (isNS ? window.pageYOffset : document.body.scrollTop) + 0; // 위쪽 위치
		if(yMenuTo >158)
			yMenuTo-=158;
		else yMenuTo=0;
	}
	timeoutNextCheck = 500;
	if (yMenuFrom != yMenuTo)
	{
		yOffset = Math.ceil(Math.abs(yMenuTo - yMenuFrom) / 20);
		if (yMenuTo < yMenuFrom)
			yOffset = -yOffset;
		if (isNS4)
			divMenu.top += yOffset;
		else if (isDOM)
			divMenu.style.top = parseInt (divMenu.style.top, 10) + yOffset;
			timeoutNextCheck = 10;
	}
	setTimeout ("moveRightEdge()", timeoutNextCheck);
}

function MM_swapImgRestore()
{
	//v3.0
	var i,x,a=document.MM_sr; for(i=0;a&&i<a.length&&(x=a[i])&&x.oSrc;i++) x.src=x.oSrc;
}

function MM_preloadImages() { //v3.0
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}

function MM_findObj(n, d) { //v4.0
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && document.getElementById) x=document.getElementById(n); return x;
}

function MM_swapImage() { //v3.0
  var i,j=0,x,a=MM_swapImage.arguments; document.MM_sr=new Array; for(i=0;i<(a.length-2);i+=3)
   if ((x=MM_findObj(a[i]))!=null){document.MM_sr[j++]=x; if(!x.oSrc) x.oSrc=x.src; x.src=a[i+2];}
}

function MM_showHideLayers() { //v6.0
  var i,p,v,obj,args=MM_showHideLayers.arguments;
  for (i=0; i<(args.length-2); i+=3) if ((obj=MM_findObj(args[i]))!=null) { v=args[i+2];
    if (obj.style) { obj=obj.style; v=(v=='show')?'visible':(v=='hide')?'hidden':v; }
    obj.visibility=v; }
}

// form.reset
function formClear(Obj)
{
	Obj.reset();
}

//객체 활성,비활성 설정 함수
function showObject(Obj,Boolen)
{
	if(Boolen)
	{
		//활성화
		Obj.disabled = false;
		Obj.style.background = "#ffffff";
	}
	else
	{
		//비활성화
		Obj.disabled = true;
		Obj.style.background = "#dddddd";
	}
}

//객체 활성,비활성 설정 함수
function checkshowObject(Obj,Boolen)
{
	Boolen ? Obj.disabled = false: Obj.disabled = true;
}

function addArray(Obj,Val)
{
	var arrLength= Obj.length;
	Obj[arrLength] = Val;
}

//삭제
function delArray(Obj,Index)
{
	var temp=new Array();
	var nextIndex = Index +1;
	for(i=0,j=0;i<Obj.length;i++)
	{
		if(i!=Index)
		{
			temp[j] = Obj[i];
			j++;
		}
	}
	for(i=0;i<temp.length;i++) Obj[i]=temp[i];
	return temp.length;
}

//정렬   0:내림차순  1:오름차순
function sortArray(Obj,Method)
{
	Obj.sort();
	if(!Method) Obj.reverse();
}

//한글체크
function hanCheck(Str)
{
	var Re=false;
	for(i=0;i<Str.length;i++)
	{
		var a=Str.charCodeAt(i);
		if (a > 128)
		{
			Re=true;
		}
	}
	return Re;
}

//파일명 한글 체크
function filehanCheck(Str)
{
	var Arr = new Array();
	var Re=false;
	Arr=Str.split("\\");
	return hanCheck(Arr[Arr.length-1]);
}

//숫자체크
function numCheck(Str)
{
	var Re=true;
	for(i=0;i<Str.length;i++)
	{
		var a=Str.charCodeAt(i);
		if(a<48 || a>57) Re=false;
	}
	return Re;
}

//연락처체크
function telCheck(Tel1, Tel2, Tel3)
{
	var Re=true;
	if(!numCheck(Tel1) ||!numCheck(Tel2) ||!numCheck(Tel3) ) Re = false;
	else if(Tel1.length <2 || Tel1.length >3) Re = false;
	else if(Tel2.length <3 || Tel2.length >4) Re = false;
	else if(Tel3.length <4 || Tel3.length >4) Re = false;
	return Re;
}

//이미지확대
function zoom(File,Width,Height)
{
	if(!Width || !Height)
	{
		alert("이미지가 존재하지 않거나 이미지 크기정보가 올바르지 않습니다.");
	}
	else
	{
		window.open("zoom.php?img="+File,"","scrollbars=no,width="+Width+",height="+Height+",top=100,left=200");
	}
}

function zoom2(File,Width,Height)
{
	if(!Width || !Height)
	{
		alert("이미지가 존재하지 않거나 이미지 크기정보가 올바르지 않습니다.");
	}
	else
	{
		window.open("zoom2.php?idx="+File,"","scrollbars=no,width="+Width+",height="+Height+",top=50,left=200");
	}
}

//이미지확대 (타이틀)
function zoomTitle(File,Width,Height,Title)
{
	if(!Width || !Height)
	{
		alert("이미지가 존재하지 않거나 이미지 크기정보가 올바르지 않습니다.");
	}
	else
	{
		window.open("zoom.php?img="+File+"&title="+Title,"","scrollbars=no,width="+Width+",height="+Height+",top=200,left=200");
	}
}

//<tr> 배경색 바꾸기
function bgcolorChange(Obj,Color)
{
	Obj.backgroundColor = Color;
}

//주민등록번호 체크
function bsshChek(str_jumin1,str_jumin2)
{
	var resno = str_jumin1 + str_jumin2;
	var fmt = /^\d{6}[1234]\d{6}$/;
	if (!fmt.test(resno))
		return false;

	birthYear = parseInt(resno.charAt(6)) <= 2 ? "19" : "20";	//1900년대 : 1,2	2000년대 : 3,4
	birthYear += resno.substr(0, 2);
	birthMonth = resno.substr(2, 2) - 1;
	birthDate = resno.substr(4, 2);
	birth = new Date(birthYear, birthMonth, birthDate);
	if (birth.getFullYear() % 100 != resno.substr(0, 2) || birth.getMonth() != birthMonth || birth.getDate() != birthDate)
		return false;

	var sum = 0;
	for (i = 0; i < 12; i++) sum += parseInt(resno.charAt(i)) * (i%8 + 2);
	if ((11 - (sum % 11)) % 10 != resno.charAt(12))
		return false;

	return true;
}

//만나이 체크
function manChek(ssh1)
{
	var today = new Date();
	var day = today.getDate();
	var month = today.getMonth()+1;
	var year = today.getFullYear();

	ssh=year*10000+month*100+day;
	ssh=ssh-ssh1-19000000;
	return ssh;
}

//이메일체크
function isEmail(str)
{
	var supported = 0;
	if (window.RegExp)
	{
		var tempStr = "a";
		var tempReg = new RegExp(tempStr);
		if (tempReg.test(tempStr)) supported = 1;
	}
	if (!supported) return (str.indexOf(".") > 2) && (str.indexOf("@") > 0);
	var r1 = new RegExp("(@.*@)|(\\.\\.)|(@\\.)|(^\\.)");
	var r2 = new RegExp("^.+\\@(\\[?)[a-zA-Z0-9\\-\\.]+\\.([a-zA-Z]{2,3}|[0-9]{1,3})(\\]?)$");
	return (!r1.test(str) && r2.test(str));
}

//상품 선택
function selectGoods(Obj)
{
	Action="goods_select.php?Obj="+Obj;
	window.open(Action,"","scrollbars=yes,width=500,height=670,top=20,left=150");
}

//쿠키저장
function setCookie( name, value, expiredays )
{
	var todayDate = new Date();
	todayDate.setDate( todayDate.getDate() + expiredays );
	document.cookie = name + "=" + escape( value ) + "; path=/; expires=" + todayDate.toGMTString() + ";"
	//document.cookie = name + "=" + escape( value ) + "; path=/;";
}

//칼러 박스
function setColor(Part1,Part2,Obj)
{
	window.open("color.php?part1="+Part1+"&part2="+Part2+"&target="+Obj,"","scrollbars=yes,width=350,height=110,left=300,top=300");
}

function subsetColor(Part1,Part2,Obj,tForm)
{
	window.open("sub_color.php?part1="+Part1+"&part2="+Part2+"&target="+Obj+"&tForm="+tForm,"","scrollbars=yes,width=350,height=110,left=300,top=300");
}

//카테고리 마우스 아웃 설정
function layerImgOut(Name,Src)
{
	Name.src=Src;
}

//상품 검색 폼
function goodsSearchSendit(Obj)
{
	if(Obj.searchstring.value=="")
	{
		alert("검색어를 입력해 주십시오.");
		Obj.searchstring.focus();
	}
	else if(Obj.search.selectedIndex==1 && !numCheck(Obj.searchstring.value))
	{
		alert("가격 설정이 올바르지 않습니다.");
		Obj.searchstring.focus();
	}
	else
	{
		Obj.submit();
	}
}

//메일보내기
function sendMail(To)
{
	window.open("./email/mail.php?To="+To,"","scrollbars=yes,left=200,top=20,width=650,height=790");
}

//관련이미지 올리기 새창
function inputImg(Part,Code)
{
	var form=document.writeForm;
	window.open("input_img.php?part="+Part+"&code="+Code,"","scrollbars=yes,left=200,top=200,width=700,height=500");
}

function inputImg_topmenu(Part,Code)
{
	var form=document.writeForm;
	window.open("input_img.php?part="+Part+"&code="+Code,"","scrollbars=yes,left=200,top=200,width=700,height=500");
}

function askloginErr()
{
	alert("회원메뉴입니다. 로그인 해주십시오.");
	location.href="login.php";
}

function login_err()
{
	alert("회원 로그인 해주십시오.");
	//location.href="login.php";
}

function str_replace(obj,str,replace_str)
{
	/////// 1차 필터  '/'를 뒤에 포함하여  
	var goods = obj.value;
	var idx_str1 = str + "/";	
	Result = goods.replace(idx_str1,replace_str);	
	obj.value = Result;
	/////// 2차 필터  '/'를 앞에 포함하여  
	var goods = obj.value;
	var idx_str2 = "/" + str;
	Result = goods.replace(idx_str2,replace_str);	
	obj.value = Result;
	////// 3차 필터 '/'를 포함안하여 
	var goods = obj.value;
	var idx_str3 = str;
	Result = goods.replace(idx_str3,replace_str);	
	obj.value = Result;
}

function setColor_new(obj, iColor)
{
	var colorTextBox = eval("document.getElementById('t_" + obj.id+"')");
	var sColor = callColorDlgNGetColor(iColor);
	if (!sColor) return;
	sColor = "#" + sColor;
	obj.bgColor = sColor;
	colorTextBox.value = sColor;
}

function setChangedColor(obj)
{
	if (!obj.value) return;
	var cCTName = obj.name.substr(2);
	var cTableName = eval("document.getElementById('" + cCTName + "')");
	cTableName.bgColor = obj.value;
}

function callColorDlgNGetColor(sInitColor)
{
	if (sInitColor == null)
	{
		var sColor = document.getElementById('dlgHelper').ChooseColorDlg();
	}
	else
	{
		var sColor = document.getElementById('dlgHelper').ChooseColorDlg(sInitColor);
	}
	alert(1);
	sColor = sColor.toString(16);
	if (sColor.length < 6)
	{
		var sTempString = "000000".substring(0,6-sColor.length);
		sColor = sTempString.concat(sColor);
	}
	sInitColor = sColor;
	return sColor;
}

function my_round(num, round_num)
{
	// 반올림할 위치와 소숫점을 맞추기 위해 숫자를 알맞게 가공
	tmp_num1=num*Math.pow(10, round_num);
	
	// 가공된 숫자를 반올림
	tmp_num2=Math.round(tmp_num1);
	
	// 역순으로 다시 가공
	result=tmp_num2/Math.pow(10, round_num);
	
	return result;
}

function radio_arrnum(Obj)
{
	for (var i=0; i<Obj.length; i++)
	{
		if (Obj[i].checked == true)
		{
			var value = Obj[i].value;
		}
	}
	return value;
}

function design_view() //디자인관리에서 전체영역 보기 팝업 
{
	window.open("design_view.php","","scrollbars=no,width=700,height=700,top=0,left=0");
}

function getObject(data)
{
	document.write (data);
}

function getFlash(src, width, height)
{
	if(!src || !width || !height)
	{
		return null;
	}
	var classid  = "clsid:d27cdb6e-ae6d-11cf-96b8-444553540000";
	var codebase = "http://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,0,0";
	var wmode    = "transparent";
	var quality  = "high";
	var plugin   = "http://www.macromedia.com/go/getflashplayer";
	var type     = "application/x-shockwave-flash";
	var html = "<object classid='" + classid + "' "
			 + "codebase='" + codebase + "' "
			 + "width='" + width + "' height='" + height + "'>"
			 + "<param name='wmode' value='" + wmode + "'>"
			 + "<param name='movie' value='" + src + "'>"
			 + "<param name='quality' value='" + quality + "'>"
			 + "<embed src='" + src + "' "
			 + "quality='" + quality + "' pluginspage='" + plugin + "' type='" + type + "' "
			 + "width='" + width + "' height='" + height + "'></embed></object>";
	getObject(html);
}

/* 공백문자가 하나도 없이 정상적이면 ""을 리턴함 */
function checkSpace( str )
{
	if(str.search(/\s/) != -1) return 1;
	else return "";
}
