<table width=100% cellspacing=0 cellpadding=0 border=0>
	<tr>
		<td><?
		$result = $MySQL->query("select * from banner where position ='mainScroll' order by sunwi asc"); 
		?>
		<script>
		var IE_chk = (navigator.appName == "Microsoft Internet Explorer" && navigator.appVersion.substring(0,1) >= "4");
		var bannimg = new Array;
		var bannurl = new Array;
		var numimg = new Array;
		var target = new Array;
		var gubun = new Array;
		var goodsUrl = new Array;
		<?
		$main_bann_cnt=0;
		$total_main_hotline_row_cnt = (mysql_num_rows($result)-1);
		while ($main_bann_row = mysql_fetch_array($result))
		{
			?>
		bannimg[<?=$main_bann_cnt?>] = './upload/design/<?=$main_bann_row[img]?>';
		bannurl[<?=$main_bann_cnt?>] = '<?=$main_bann_row[siteUrl]?>';
		numimg[<?=$main_bann_cnt?>] = './upload/design/<?=$main_bann_row[img]?>';
		target[<?=$main_bann_cnt?>] = '<?=$main_bann_row[siteTarget]?>';
		gubun[<?=$main_bann_cnt?>] = '<?=$main_bann_row[gubun]?>';
		goodsUrl[<?=$main_bann_cnt?>] = '<?=$main_bann_row[goodsUrl]?>';<?
			$main_bann_cnt++;
		}
		?>
		var cliImg = '';
		var cliImgSrc = '';
		var n = Math.round(Math.random() * 5);
		var interval = <?=$design[designBwait]?> * 1000;
		var setTimeId = '';

		function rotateStop()
		{
			clearTimeout(setTimeId);
		}

		function rotateStart()
		{
			rotate();
		}

		function rotate()
		{
			n = (n >= <?=$total_main_hotline_row_cnt?>) ? 0 : n+1;
			setimgurl();
			setTimeId=setTimeout("rotate()",interval);
		}

		function setimgurl()
		{
			if (IE_chk) document.getElementById('ProImg').filters.blendTrans.apply();
			document.getElementById('ProUrl').target=target[n];
			if (gubun[n]==0)
			{
				document.getElementById('ProUrl').href="http://" + bannurl[n];
			}
			else if (gubun[n]==1)
			{
				document.getElementById('ProUrl').href="goods_detail.php?goodsIdx=" + goodsUrl[n];
			}
			document.getElementById('ProImg').src=bannimg[n];
			if (IE_chk) document.getElementById('ProImg').filters.blendTrans.play();
		}
		setTimeId=setTimeout("rotate()",interval);
		</script><?
		$row = $MySQL->fetch_array("select *from banner where position ='mainScroll' order by sunwi asc limit 1");
		if ($row[gubun]==0)
		{
			$url = "http://".$row[siteUrl];
		}
		else if ($row[gubun]==1)
		{
			$url = "goods_detail.php".$row[goodsUrl];
		}
		?><a href="<?=$url?>" name="ProUrl" id="ProUrl"><img src="./upload/design/<?=urlencode($row[img])?>" target="<?=$row[siteTarget]?>" width="<?=$mainTitleImg_width?>" border="0" id="ProImg" name="ProImg" style="filter:blendTrans(duration=1);"></td>
	</tr>
</table>