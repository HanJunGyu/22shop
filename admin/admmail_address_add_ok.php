<?
include "head.php";
if($write_part=="fast")
{
	$tel = $tel1."-".$tel2."-".$tel3;
	$qry = "insert into webmail_adr(grp,badmin,name,email,tel)values(";
	$qry.= "'$grp',1,'$name','$email','$tel')";
	if($MySQL->query($qry))
	{
		ReFresh("admmail_address.php");
	}
	else
	{
		echo"Err : $qry";
	}
}
else
{
	$tel = $tel1."-".$tel2."-".$tel3;
	$birth = $birth1."-".$birth2."-".$birth3;
	$zip = $zip1."-".$zip2;
	$qry = "insert into webmail_adr(grp,badmin,name,email,tel,birth,zip,adr1,adr2,content)values(";
	$qry.= "'$grp',1,'$name','$email','$tel','$birth','$zip','$adr1','$adr2','$content')";
	if($MySQL->query($qry))
	{
		ReFresh("admmail_address.php");
	}
	else
	{
		echo"Err : $qry";
	}
}
?>