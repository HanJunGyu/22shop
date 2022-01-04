<?
include "head.php";
if($colorIndex=="") $colorIndex=0;
elseif($colorIndex==0) $colorIndex=17;
?>
<SCRIPT LANGUAGE="JavaScript">
<!--
//윈도 사이즈 변경
function windowResize()
{
	<?if($colorIndex==17){//black?>
	window.resizeTo(350,220);
	<?}else if($colorIndex <17 && $colorIndex >0){?>
	window.resizeTo(350,460);
	<?}else{?>
	window.resizeTo(350,135);
	<?}?>
}

//색깔 선택
function Setting(color)
{
	<?
	if($part1=="mul")
	{
		if($part2=="bg")
		{
			?>
	opener.document.getElementById('<?=$target?>').bgColor =color;
	opener.<?=$tForm?>.copyBC.value = color;<?
		}
		else
		{
			?>
	opener.document.getElementById('<?=$target?>').style.color =color;
	opener.<?=$tForm?>.copyTC.value = color;<?
		}
	}
	else
	{
		if($part2=="bg")
		{
			?>
	opener.document.getElementById('<?=$target?>').bgColor =color;<?
		}
		else if($part2=="design_a")
		{
			?>
	opener.document.getElementById('<?=$target?>').bgColor =color;
	opener.<?=$tForm?>.t_no_font_color1.value =color;<?
		}
		else if($part2=="design_c")
		{
			?>
	opener.document.getElementById('<?=$target?>').bgColor =color;
	opener.<?=$tForm?>.t_no_font_color1.value =color;<?
		}
		else
		{
			?>
	opener.document.getElementById('<?=$target?>').style.color =color;<?
		}
	}
	?>
	window.close();
}
//-->
</SCRIPT>
<body bgcolor="#FFFFFF" text="#000000" onload="windowResize();">
<table width="300" border="0" cellspacing="0" cellpadding="0" align="center">
	<tr>
		<td height="70">
			<table width="300" border="0" cellspacing="0" cellpadding="0" height="70" background="image/color_bg.gif">
				<tr><?
				for($i=0;$i<18;$i++)
				{
					$img_num = $i;
					if(strlen($img_num)==1) $img_num="0".$img_num;
					?>
					<td><div align="center"><a href="sub_color.php?colorIndex=<?=$i?>&target=<?=$target?>&part1=<?=$part1?>&part2=<?=$part2?>&tForm=<?=$tForm?>"><img src="image/color_<?=$img_num?>.gif" width="21" height="21" border="0"></a></div></td><?
					if($i==8)
					{
						?>
				</tr>
				<tr><?
					}
				}
				?>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td>
			<table width="300" border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td><?
					if($colorIndex!=0)
					{
						?>
						<TABLE border="0">
							<TR><?
							$cnt =0;
							$j=0;
							$qry = "select *from color where color='$COLOR_ARR[$colorIndex]'";
							$result = $MySQL->query($qry);
							while($row = mysql_fetch_array($result))
							{
								$cnt++;
								?>
								<TD id="tdid" style="border:outset 1px;cursor:pointer;" onMouseover="this.style.borderStyle='inset'"  onMouseout="this.style.borderStyle='outset'" onclick="javascript:Setting('<?=chop($row[value])?>');" width="75" bgcolor="<?=chop($row[value])?>">&nbsp;</TD><?
								if(!($cnt%4))
								{
									?>
							</tr>
							<tr><?
								}
								$j++;
							}
							?>
							</TR>
						</TABLE><?
					}
					?>
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>
</body>
</html>