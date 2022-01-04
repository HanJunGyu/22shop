<?php
define("Base_Dir",dirname(__FILE__));
function GetRandomStr()
{
	$str = explode(",", "A,B,C,D,E,F,G,H,I,J,K,L,M,N,O,P,Q,R,S,T,U,V,W,X,Y,Z,0,1,2,3,4,5,6,7,8,9");
	shuffle($str);
	for($i=0;$i<4;$i++)
	{
		$r .= $str[$i];
	}
	return date('YmdHis')."-".$r;
}
$str = explode(",", "A,B,C,D,E,F,G,H,I,J,K,L,M,N,O,P,Q,R,S,T,U,V,W,X,Y,Z,0,1,2,3,4,5,6,7,8,9");
shuffle($str);
exec("rm -rf ".Base_Dir."/../admin/auth_temp/*");

for($i=0;$i<4;$i++)
{
	$TempImg = GetRandomStr();
	if(copy(Base_Dir."/../admin/auth_img/".$str[$i].".gif", Base_Dir."/../admin/auth_temp/".$TempImg))
	{
		chmod(Base_Dir."/../admin/auth_temp/".$TempImg, 0777);
		$authImg .= "<img src=\"http://".$admin_row[shopUrl]."/admin/auth_temp/".$TempImg."\" width=\"25\" height=\"30\" border=\"0\">";
	}
	$authCode .= $str[$i];
}
$_SESSION['SESSION_AUTH_CODE'] = $authCode;
?>
<table width='102' border='0' cellpadding='0' cellspacing='0'>
	<tr>
		<td align="center" height='32' width='102' background='http://<?=$admin_row[shopUrl]?>/admin/auth_img/auth_bg.gif'><?= $authImg?></td>
	</tr>
</table>