<?
include "head.php";
$num = $MySQL->articles("select idx from goods where code like '%$gcode%' limit 1");
if ($num)
{
	OnlyMsgView("이미 등록된 코드입니다.");
}
else OnlyMsgView("입력 가능한 코드입니다.");
?>