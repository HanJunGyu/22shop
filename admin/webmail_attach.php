<?
session_start();
include "../lib/config.php";
include "../lib/function.php";
include("../lib/webmail_view_class.php");
$f=urldecode($f);
$filename=urldecode($filename);
$MP = new CMailObject;
$MP->InitMailObject($f,1);
$MP->Attach($p,$filename);
?>