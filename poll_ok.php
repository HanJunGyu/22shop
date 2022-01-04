<?
include "head.php";
$poll_row = $MySQL->fetch_array("select *from poll where idx=$pollIdx");

$answer_num_arr = explode("「「",$poll_row[answer_num]);		//지금까지 득표수 배열  ex)1「「3「「9「「6「「1
$voteArr = explode("|",$voteArrstr);						//현재 득표 배열  ex) 0|1|0|1|1 

$voteCnt =0;
for($i=0;$i<count($voteArr);$i++)
{
	$answer_num_arr[$i]+=$voteArr[$i];
	if($voteArr[$i])	$voteCnt++;
}

$new_answer_num	= join($answer_num_arr,"「「");
$COOKIE_NAME= "POLL_COOKIE_".$pollIdx;

if($MySQL->query("update poll set answer_num='$new_answer_num', total_num=total_num+$voteCnt where idx=$pollIdx"))
{
	echo"<script language='javascript'>
	setCookie('$COOKIE_NAME','yes', 1000);
	</script>";
	$data=Encode64("idx=".$pollIdx);
	ReFresh("poll_new.php?data=$data");
}
else
{
	echo"update Err.";
}
?>