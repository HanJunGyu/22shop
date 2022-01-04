<?
session_cache_limiter("no-cache, must-revalidate");
include "head.php";
$dataArr=Decode64($data);
$pagecnt=$dataArr[pagecnt];
$offset=$dataArr[offset];
if($dataArr[searchstring]) $searchstring=$dataArr[searchstring];
if ($searchstring)
{
	$total_qry ="select * from goods where name like '%$searchstring%' $MALL_STR";
}
else
{
	$total_qry ="select * from goods where 1=1 $MALL_STR";
}
$numresults=$MySQL->query($total_qry);
$numrows=mysql_num_rows($numresults);				//총 레코드수..
$LIMIT		=10;								//페이지당 글 수
$PAGEBLOCK	=10;								//블럭당 페이지 수
if($pagecnt==""){$pagecnt=0;}						//페이지 번호 
if(!$offset){$offset=$pagecnt*$LIMIT*$PAGEBLOCK;} //각 페이지의 시작 글  
if(!$letter_no){$letter_no=$numrows;}				//글번호
$goods_qry = $total_qry;
if($sort) $goods_qry.= " order by $sortStr $sort ";
else $goods_qry.= " order by idx desc ";
$goods_qry.=" limit $offset,$LIMIT";
$goods_result=$MySQL->query($goods_qry);
$s_letter=$letter_no;								//페이지별 시작 글번호
?>
<!-- -----------------------------------상품 정렬 방식 폼 시작-------------------------------------------------------------- -->
<SCRIPT LANGUAGE="JavaScript">
<!--
function select_goods(idx)
{
	if (parent.document.relationForm.relation.value == "")
	{
		parent.document.relationForm.relation.value = idx +"/";
	}
	else
	{
		parent.document.relationForm.relation.value = parent.document.relationForm.relation.value +idx+"/";
	}
	complete();
}
function complete()
{
	<? if ($part=="write")  { ?> ///상품등록시에는 DB업데이트 안하는 모듈 구현 
	alert("선택되었습니다.");
	parent.document.relationForm.action = "goods_relation.php?write_update=1&part=<?=$part?>";
	parent.document.relationForm.submit();
	<? }else{ ?>
	parent.document.relationForm.data.value = "<?=$data?>";
	parent.document.relationForm.action = "goods_relation.php?update=1";
	parent.document.relationForm.submit();
	<? } ?>
}
//-->
</SCRIPT>
<body bgcolor="#FFFFFF" text="#000000">
<?
$encode_str = "pagecnt=".$pagecnt."&letter_no=".$s_letter."&offset=".$offset;
$encode_str.= "&search=".$search."&searchstring=".$searchstring."&present_num=".$letter_no;
$sortData=Encode64($encode_str);					//각 레코드 정보
?>
<table width="450" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td>
			<table width="450" border="0" cellspacing="0" cellpadding="0">  
				<tr>
					<td>
						<form name="searchform" method="post" action="goods_total2.php?part=<?=$part?>">
						<input type="hidden" name="code" value="<?=$code?>"><!-- 분류 -->
						<table border=0>
							<tr>
								<td width="50">상품명</td>
								<td width="120"><input class="box" type="text" name="searchstring" size="20"></td>
								<td width="50"><input type="image" src="image/bbs_search_btn.gif" border=0></td>
							</tr>
							<tr>
								<td colspan=3><font color="#999999">※ 상품클릭시마다 관련상품으로 등록됩니다.</font></td>
							</tr>
						</table>
						</form>
					</td>
				</tr>
			</table>
		</td>
	</tr><?
	if($numrows)
	{
		?>
	<tr>
		<td>
			<table width="450" border="0" cellspacing="2" cellpadding="0">
				<tr>
					<td height="30" bgcolor="#EBEBEB" background="image/bbs_tit_bg.jpg" width="60"> <div align="center"><img src="image/icon.gif" width="11" height="11"> 상품</div></td>
					<td height="30" bgcolor="#EBEBEB" background="image/bbs_tit_bg.jpg" width="110"> <div align="center"><img src="image/icon.gif" width="11" height="11"> 분류명</div></td>
					<td height="30" bgcolor="#EBEBEB" background="image/bbs_tit_bg.jpg" width="180"> <div align="center"><img src="image/icon.gif" width="11" height="11"> 상품명 <a href="javascript:Sort('name','asc');">△</a><a href="javascript:Sort('name','desc');">▽</a></div></td>
					<td height="30" bgcolor="#EBEBEB" background="image/bbs_tit_bg.jpg" width="100"> <div align="center"><img src="image/icon.gif" width="11" height="11"> 등록일 <a href="javascript:Sort('writeday','asc');">△</a><a href="javascript:Sort('writeday','desc');">▽</a></div></td>
				</tr>
				<tr>
					<td height="1" colspan="4" background="image/line_bg1.gif"></td>
				</tr><?
				while($goods_row=mysql_fetch_array($goods_result))
				{
					$encode_str = "idx=".$goods_row[idx]."&pagecnt=".$pagecnt."&letter_no=".$s_letter."&offset=".$offset;
					$encode_str.= "&search=".$search."&searchstring=".$searchstring."&present_num=".$letter_no;
					$data=Encode64($encode_str);					//각 레코드 정보
					//카테고리 정보
					$cate_row = $MySQL->fetch_array("select *from category where code='$goods_row[category]'");
					$str_category = $cate_row[name];
					?>
				<tr valign="middle" bgcolor="fafafa" style='cursor:pointer;' onMouseOver="this.style.backgroundColor='#EBEBEB'" onMouseOut="this.style.backgroundColor=''"  onclick="javascript:select_goods('<?=$goods_row[idx]?>');"><?
					if (empty($GD_SET) && $goods_row[img_onetoall]) $img_str = $goods_row[img3];
					else if ($GD_SET && $goods_row[img_onetoall] && empty($goods_row[img1])) $img_str = $goods_row[img3];
					else if ($GD_SET && empty($goods_row[img_onetoall]) && empty($goods_row[img1])) $img_str = $goods_row[img3];
					else $img_str = $goods_row[img1];
					?>
					<td height="45"  width="60"> <div align="center"><img src="../upload/goods/<?=$img_str?>" width="40" height="40"></div></td>
					<td height="45"  width="110"> <div align="center"><b><?=$str_category?></b></div></td>
					<td height="45" width="180"> <div align="center"><?=$goods_row[name]?></div></td>
					<td height="45" width="100"> <div align="center"><?=str_replace("-","/",substr($goods_row[writeday],0,10))?><br><?=substr($goods_row[writeday],11,8)?></div></td>
				</tr>
				<tr>
					<td height="1" colspan="4" background="image/line_bg1.gif"></td>
				</tr><?
					$letter_no--;
				}
				include "../lib/class.php";
				$optionStr = "part=$part";
				$Obj=new CList("goods_total2.php",$pagecnt,$offset,$numrows,$PAGEBLOCK,$LIMIT,$search,$searchstring,$optionStr);
				$pre_icon_img="<img src='image/pre_btn.gif' width='40' height='17' border='0'>";		//이전아이콘
				$next_icon_img="<img src='image/next_btn.gif' width='40' height='17' border='0'>";	//다음아이콘
				?>
			</table>
		</td>
	</tr>
	<tr>
		<td height="50">
			<table width="100%" border="0" align="center">
				<tr>
					<td align="center"><?$Obj->putList(true,$pre_icon_img,$next_icon_img);//이전다음 프린트?></td>
				</tr>
			</table>
		</td>
	</tr><?
	}
	else
	{
		?>
	<tr>
		<td height="50">
			<table width="100%" border="0" align="center">
				<tr>
					<td><FONT COLOR="#993300">- 등록할 상품이 없습니다.</FONT></td>
				</tr>
			</table>
		</td>
	</tr><?
	}
	?>
</table>
</body>
</html>