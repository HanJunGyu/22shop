<?
// �ҽ��������
// 20060720-1 ���ϱ�ü �輺ȣ : 1.�����õ���� ����, 2.�ڷ����� ���� ����������� ����
include "head.php";
// ��ҹ�ư Ŭ����
if ($orderCancel=="y")
{
	$MySQL->query("DELETE from trade_goods WHERE tradecode='$tradecode'");
	$MySQL->query("DELETE from trade WHERE tradecode='$tradecode'");
	$MySQL->query("DELETE from cart WHERE userid='$GOOD_SHOP_USERID'");
	Refresh("index.php");
	exit;
}
if (empty($tradecode))
{
	MsgViewHref("�ֹ���ȣ�� �������� �ʽ��ϴ�.","cart.php");
	exit;
}
if (!$MySQL->articles("SELECT idx from cart WHERE userid='$GOOD_SHOP_USERID' limit 1"))
{
	MsgViewHref("��ٱ��Ͽ� ��ǰ�� �������� �ʽ��ϴ�.","cart.php");
	exit;
}
if($GOOD_SHOP_PART =="member")
{
	$member_row = $MySQL->fetch_array("select *from member where userid='$GOOD_SHOP_USERID'");
	$ssh = explode("-",$member_row[ssh]);		//ȸ�� �ֹε�Ϲ�ȣ
}
if(!defined(__ADMIN_ROW))
{
	define(__ADMIN_ROW,"TRUE");
	$admin_row=$MySQL->fetch_array("select *from admin limit 0,1");//����������
}
if($admin_row[xTrans_bhtml])
{
	$xTrans = $admin_row[xTrans];
}
else
{
	$xTrans = nl2br(htmlspecialchars($admin_row[xTrans]));
}
if($admin_row[bUsepoint] && $GOOD_SHOP_PART=="member")
{
	//������ ���
	$__TNAME_TD_WIDTH =267;	//��ǰ�� Ÿ��Ʋ TD ����
	$__VNAME_TD_WIDTH =173; //��ǰ�� TD ����
}
else
{
	$__TNAME_TD_WIDTH =334;
	$__VNAME_TD_WIDTH =239;
}
//�������Ա� ����
$bBank		=explode("|",$admin_row[bBank]);		//�����뿩�� �迭
$bankName	=explode("|",$admin_row[bankName]);		//����� �迭
$bankId		=explode("|",$admin_row[bankId]);		//���¹�ȣ �迭
$bankOwn	=explode("|",$admin_row[bankOwn]);		//������ �迭

// �ֹ��� ���� �ӽ� ���̺� ���� ����

$tel	= $tel1."-".$tel2."-".$tel3;
$hand	= $hand1."-".$hand2."-".$hand3;
$zip	= $zip1."-".$zip2;
$rtel	= $rtel1."-".$rtel2."-".$rtel3;
$rhand	= $rhand1."-".$rhand2."-".$rhand3;
$rzip	= $rzip1."-".$rzip2;
$ceo_zip= $ceo_zip1."-".$ceo_zip2;
$ceonum =  $ceonum1."-".$ceonum2."-".$ceonum3;
$goodsIdx =0;
$cnt	  =0;

$MySQL->query("select idx from trade_temp where tradecode='$tradecode' limit 1");
if(!empty($tradecode) && !$MySQL->is_affected())
{
	//�ֹ���ȣ ���� &&�ֹ���ȣ�ߺ�����
	$content = addslashes($content);
	$adr1 = addslashes($adr1);
	$adr2 = addslashes($adr2);
	$radr1 = addslashes($radr1);
	$radr2 = addslashes($radr2);
	$temp_qry = "insert into trade_temp (tradecode,userid,userid_part,name,email,tel,hand,";
	$temp_qry.= "zip,adr1,adr2,city,rname,remail,rtel,rhand,rzip,radr1,radr2,writeday,content,";
	$temp_qry.= "goodsIdx,cnt,tprice_array,code_array,bTax,level_gubun,transM_array) values(";
	$temp_qry.= "'$tradecode','$GOOD_SHOP_USERID','$GOOD_SHOP_PART','$name','$email','$tel','$hand','$zip',";
	$temp_qry.= "'$adr1','$adr2','$city','$rname','$remail','$rtel','$rhand','$rzip','$radr1','$radr2',";
	$temp_qry.= "now(),'$content',$goodsIdx,$cnt,'$tprice_array','$code_array','$bTax','$GOOD_SHOP_PART_GUBUN','$transM_array')";
	$MySQL->query($temp_qry);
}

$MySQL->query("select idx from trade where tradecode='$tradecode' limit 1");
if(!empty($tradecode) && !$MySQL->is_affected() )
{
	//�ֹ���ȣ ���� &&�ֹ���ȣ�ߺ�����
	$temp_row = $MySQL->fetch_array("select * from trade_temp where tradecode='$tradecode'");
	$qry = "insert into trade(tradecode,userid,userid_part,name,email,tel,hand,zip,adr1,";
	$qry.= "adr2,city,rname,remail,rtel,rhand,rzip,radr1,radr2,writeday,content,bPsupply,tprice_array,code_array,sday1,bTax,level_gubun,userIp,transM_array";
	$qry.= ")values(";
	$qry.= "'$tradecode',";
	$qry.= "'$temp_row[userid]',";
	$qry.= "'$temp_row[userid_part]',";
	$qry.= "'$temp_row[name]',";
	$qry.= "'$temp_row[email]',";
	$qry.= "'$temp_row[tel]',";
	$qry.= "'$temp_row[hand]',";
	$qry.= "'$temp_row[zip]',";
	$qry.= "'$temp_row[adr1]',";
	$qry.= "'$temp_row[adr2]',";
	$qry.= "'$temp_row[city]',";
	$qry.= "'$temp_row[rname]',";
	$qry.= "'$temp_row[remail]',";
	$qry.= "'$temp_row[rtel]',";
	$qry.= "'$temp_row[rhand]',";
	$qry.= "'$temp_row[rzip]',";
	$qry.= "'$temp_row[radr1]',";
	$qry.= "'$temp_row[radr2]',";
	$qry.= "now(),";
	$qry.= "'$temp_row[content]',";
	$qry.= "1,";
	$qry.= "'$temp_row[tprice_array]', ";
	$qry.= "'$temp_row[code_array]', ";
	$qry.= "now(),";
	$qry.= "'$bTax',";
	$qry.= "'$temp_row[level_gubun]', ";
	$qry.= "'$REMOTE_ADDR',";
	$qry.= "'$transM_array'";
	$qry.= ")";

	if($MySQL->query($qry))
	{
		$cart_result = $MySQL->query("select * from cart where userid='$temp_row[userid]'");
		$inSuccess =true;
		while($cart_row = mysql_fetch_array($cart_result))
		{
			$qry = "select idx,name,supplyprice,code,category,img1,img3,img_onetoall from goods where idx=$cart_row[goodsIdx] limit 1";
			$goods_row = $MySQL->fetch_array($qry);
			$gname=$goods_row[name];
			if (empty($goods_row[supplyprice])) $sprice = 0;
			else $sprice = $goods_row[supplyprice];

			if ($MySQL->articles("SELECT idx from position WHERE goodsIdx=$goods_row[idx] limit 1"))
			{
				$pos_row = $MySQL->fetch_array("SELECT part from position WHERE goodsIdx=$goods_row[idx] limit 1");
				$goods_row[goodtype] = $pos_row[part];
			}
			$in_qry = "insert into trade_goods(tradecode,goodsIdx,goodsP,cnt,";
			$in_qry.= "option1, option2, option3, price,sday1,name,img1,code,category,sprice,userid,goodtype";
			$in_qry.= ") values('$tradecode',";
			$in_qry.= "$cart_row[goodsIdx],";
			$in_qry.= "$cart_row[point],";
			$in_qry.= "$cart_row[cnt],";
			$in_qry.= "'$cart_row[option1]',";
			$in_qry.= "'$cart_row[option2]',";
			$in_qry.= "'$cart_row[option3]',";
			$in_qry.= "$cart_row[price], ";
			$in_qry.= "now(), ";
			$in_qry.= "'$gname',"; // ������ ��ǰ�� �´� ��ǰ�� 			
			if (empty($GD_SET) && $goods_row[img_onetoall]) $img_str = $goods_row[img3];
			else if ($GD_SET && $goods_row[img_onetoall] && empty($goods_row[img1])) $img_str = $goods_row[img3];
			else if ($GD_SET && empty($goods_row[img_onetoall]) && empty($goods_row[img1])) $img_str = $goods_row[img3];
			else $img_str = $goods_row[img1];
			$in_qry.= "'$img_str',"; // ������ ��ǰ�� �´� ��ǰ�̹��� 
			$in_qry.= "'$goods_row[code]',"; // ������ ��ǰ�� �´� ��ǰ�ڵ� 
			$in_qry.= "'$goods_row[category]',"; // ī�װ��� 
			$in_qry.= "$sprice,"; // ���ް� 
			$in_qry.= "'$GOOD_SHOP_USERID',"; //������ ID 
			$in_qry.= "'$goods_row[goodtype]'";
			$in_qry.= ")";
			if(!$MySQL->query($in_qry)) $inSuccess = false;
		}
	}
	else
	{
		echo"Err. : $qry";
	}
}
$temp_row = $MySQL->fetch_array("select * from trade_temp where tradecode='$tradecode'");
?>
<SCRIPT LANGUAGE="JavaScript">
<!--
//������� Ȯ��
function ch_payMethod()
{
	var Arr_payM = document.payForm.payMethod;
	var ch_payM = "";

	//������� Ȯ��
	if(document.usePform.pay_ready.value == '')	// ���� �غ��۾� ������
	{
		alert("������ ���� �غ��۾� ���Դϴ�.\n\n��ø� ��ٷ� �ֽʽÿ�.");
		return false;
	}
	else if(Arr_payM == null)	// �������� ������ ���� ����� ���� ���
	{
		alert("��밡���� ��������� �����ϴ�.\n\n���������ڿ��� ���� �ٶ��ϴ�.");
		return false;
	}
	else if(Arr_payM.length == undefined)	// ��������� �Ѱ����� ���
	{
		ch_payM = Arr_payM.value;
	}
	else									// ��������� ���������� ���
	{
		for(i=0; i < Arr_payM.length; i++)
		{
			if(Arr_payM[i].checked)
			{
				ch_payM = Arr_payM[i].value;
			}
		}
	}

	if(ch_payM == "")		//���õ� ��������� ���� ���
	{
		alert("��������� ������ �ֽñ� �ٶ��ϴ�.");
		return false;
	}
	else
	{
		return ch_payM;
	}
}

function viewAct(state)
{
	document.getElementById('nsPre').style.display='none';
	document.getElementById('nsAct').style.display='none';
	document.getElementById('nsWait').style.display='none';
	document.getElementById(state).style.display='block';
}

function bank_select()
{
	var form=document.payForm;
	var usePform=document.usePform;

	<?if($admin_row[bBankpay]){?>
	//������� Ȯ��
	var ch_payM = ch_payMethod();
	if(ch_payM != false)	//�����۾� ���� �߰� �Է»��� �ʿ�
	{
		usePform.payMethod.value = ch_payM;
		if(ch_payM == "bank")	//�����۾� ���� �߰� �Է»��� �ʿ�
		{
			showObject(form.bankInfo,true);		//������ü ������
		}
		else
		{
			showObject(form.bankInfo,false);	//PG�� �������
		}
	}
	<? } ?>
}

function trade_update() // �ֹ����� IFRAME ���� DB�� ���� 
{
	<?if($admin_row[pG_test]=="y"){//�׽�Ʈ?>
	alert('ī����� �ý��� �������Դϴ�.\n�ǰ����� ���� ������ ������ �Ա��� �̿����ּ���');
	<? } ?>

	var form=document.payForm;
	var usePform=document.usePform;
	usePform.target = "ifrm";
	usePform.payM.value = form.payM.value;
	usePform.useP.value = form.useP.value;
	usePform.transM.value = form.transM.value;
	usePform.totalM.value = form.totalM.value;
	<? if ($admin_row[bTransmethod]=="y"){ /// ��۹�� ����?>
	usePform.transMethod.value = form.transMethod.value;
	<? } ?>
	<?
	switch($admin_row[pgName])
	{
		case 'dacom':
			echo "document.dacomForm.amount.value = form.payM.value;";
			break;
		case 'allat':
			echo "document.allatForm.allat_amt.value = form.payM.value;";
			break;
		case 'inicis':
			echo "document.ini.price.value = form.payM.value;";
			break;
	}
	?>

	usePform.submit();
}

//������ ���
function setPaymoney(possP,payM)
{
	var popayM = <?=$admin_row[popayM]?>;
	
	var form=document.payForm;
	var usePform=document.usePform;
	var usePoint = form.usePoint.value;
	if(!numCheck(usePoint))
	{
		alert("��� �������� �ùٸ��� �ʽ��ϴ�.");
		form.usePoint.focus();
	}
	else if(usePoint > possP)
	{
		alert("��밡�� �������� �ʰ��Ͽ����ϴ�.\n\n��밡�� ������ : "+possP);
		form.usePoint.focus();
	}
	else if(payM <usePoint)
	{
		alert("���Ұ��� �̻��� �������� ����� �� �����ϴ�.");
		form.usePoint.focus();
	}
	else if(payM <popayM)
	{
		alert("������ ����� ���űݾ��� "+popayM+"�� �̻��϶� ��밡���մϴ�");
		form.usePoint.focus();
	}
	else if(usePoint < <?=$admin_row[poMin]?>)
	{
		alert("�������� <?=$admin_row[poMin]?>�� �̻��϶� ��밡���մϴ�.");
		form.usePoint.focus();
	}
	else
	{
		alert("�������� ���Ǿ����ϴ�.");
		usePform.pay_ready.value = "usePoint";
		form.useP.value=usePoint;
		form.payM.value=payM - usePoint;
		trade_update();
	}
}

function paySendit(str,str2)
{
	var form=document.payForm;
	var ch_payM = false;
	var paybtn_Status = 'nsWait';
	viewAct(paybtn_Status);		//������ư �����
	if(str ==1)
	{
		// ���ǰ��
		var tell = "�˼��մϴ�. ("+str2+") ��ǰ�� ������ ����� �������� ���ŵǾ����ϴ�.";
		alert(tell);
		paybtn_Status = 'nsAct';
		location.href="cart.php";
	}
	else if(str ==2)
	{
		// ����ʰ� 
		var tell = "�˼��մϴ�. ("+str2+") ";
		alert(tell);
		paybtn_Status = 'nsAct';
		location.href="cart.php";
	}
<?
	if($admin_row[pgName]=="allat")	//allat �ҽ�
	{
		echo "	document.allatForm.allat_card_yn.value = 'N';\n";
		echo "	document.allatForm.allat_bank_yn.value = 'N';\n";
		echo "	document.allatForm.allat_vbank_yn.value = 'N';\n";
	}
?>
	//������� Ȯ��
	var ch_payM = ch_payMethod();
	if(ch_payM == false)	// �����۾� ���� �߰� �Է»��� �ʿ�
	{
		paybtn_Status = 'nsAct';
	}
	else if(ch_payM == "card")						//�ſ�ī��
	{
<?		//PG�纰 �ſ�ī�� ���� �ɼ�ó��
		if($admin_row[pgName]=="dacom")			//dacom �ҽ�
		{
			if($admin_row[pG_test]=="y")	echo "		document.dacomForm.action = 'http://pg.dacom.net:7080/card/cardAuthAppInfo.jsp';\n";
			else							echo "		document.dacomForm.action = 'http://pg.dacom.net/card/cardAuthAppInfo.jsp';\n";
		}
		else if($admin_row[pgName]=="allat")	//allat �ҽ�
		{
			echo "		document.allatForm.allat_card_yn.value = 'Y';\n";
		}
		else if($admin_row[pgName]=="inicis")	//inicis �ҽ�
		{
			echo "		document.ini.mid.value = '".($admin_row[pG_test]=="y" ? "INIpayTest":$admin_row[shopId])."';\n";
			echo "		document.ini.gopaymethod.value = 'onlycard';\n";
		}
		else
		{
			echo "		alert('�ش� PG���� ī������� �غ��� �Դϴ�');\n";
			echo "		paybtn_Status = 'nsAct';\n";
		}
		//PG�纰 �ſ�ī�� ���� �ɼ�ó�� ��
?>
	}
	else if(ch_payM == "hand")					//�ڵ���
	{
<?		//PG�纰 �ڵ��� ���� �ɼ�ó��
		if($admin_row[pgName]=="dacom")			//dacom �ҽ�
		{
			if($admin_row[pG_test]=="y")	echo "		document.dacomForm.action = 'http://pg.dacom.net:7080/wireless/wirelessAuthAppInfo1.jsp';\n";
			else							echo "		document.dacomForm.action = 'https://pg.dacom.net/wireless/wirelessAuthAppInfo1.jsp';\n";
		}
		else if($admin_row[pgName]=="allat")	//allat �ҽ�
		{
			echo "		alert('�ش� PG���� �ڵ��� ������ �������� �ʴ� ���� �Դϴ�');\n";
			echo "		paybtn_Status = 'nsAct';\n";
		}
		else if($admin_row[pgName]=="inicis")	//inicis �ҽ�
		{
			echo "		document.ini.mid.value = '".($admin_row[pG_test]=="y" ? "INIpayTest":$admin_row[shopId])."';\n";
			echo "		document.ini.gopaymethod.value = 'onlyhpp';\n";
		}
		else
		{
			echo "		alert('�ش� PG���� �ڵ��� ������ �غ��� �Դϴ�');\n";
			echo "		paybtn_Status = 'nsAct';\n";
		}
		//PG�纰 �ڵ��� ���� �ɼ�ó�� ��
?>
	}
	else if(ch_payM == "iche")					//������ü
	{
<?		//PG�纰 ������ü ���� �ɼ�ó��
		if($admin_row[pgName]=="dacom")			//dacom �ҽ�
		{
			if($admin_row[pG_test]=="y")	echo "		document.dacomForm.action = 'http://pg.dacom.net:7080/transfer/transferSelectBank.jsp';\n";
			else							echo "		document.dacomForm.action = 'http://pg.dacom.net/transfer/transferSelectBank.jsp';\n";
			echo "		document.dacomForm.buyerssn.value = form.ssh1.value + form.ssh2.value;\n";
			echo "		document.dacomForm.pid.value = form.ssh1.value + form.ssh2.value;\n";
		}
		else if($admin_row[pgName]=="allat")	//allat �ҽ�
		{
			echo "		document.allatForm.allat_bank_yn.value = 'Y';\n";
		}
		else if($admin_row[pgName]=="inicis")	//inicis �ҽ�
		{
			echo "		document.ini.mid.value = '".($admin_row[pG_test]=="y" ? "INIpayTest":$admin_row[shopId])."';\n";
			echo "		document.ini.gopaymethod.value = 'onlydbank';\n";
		}
		else
		{
			echo "		alert('�ش� PG���� ������ü ������ �غ��� �Դϴ�');\n";
			echo "		paybtn_Status = 'nsAct';\n";
		}
		//PG�纰 ������ü ���� �ɼ�ó�� ��
?>
	}
	else if(ch_payM == "cyber")					//������(�������)
	{
<?		//PG�纰 ������� ���� �ɼ�ó��
		if($admin_row[pgName]=="dacom")			//dacom �ҽ�
		{
			if($admin_row[pG_test]=="y")	echo "		document.dacomForm.action = 'http://pg.dacom.net:7080/cas/casRequestSA.jsp';\n";
			else							echo "		document.dacomForm.action = 'http://pg.dacom.net/cas/casRequestSA.jsp';\n";
			echo "		document.dacomForm.buyerssn.value = form.ssh1.value + form.ssh2.value;\n";
			echo "		document.dacomForm.pid.value = form.ssh1.value + form.ssh2.value;\n";
		}
		else if($admin_row[pgName]=="allat")	//allat �ҽ�
		{
			echo "		document.allatForm.allat_vbank_yn.value = 'Y';\n";
		}
		else if($admin_row[pgName]=="inicis")	//inicis �ҽ�
		{
			echo "		document.ini.mid.value = '".($admin_row[pG_test]=="y" ? "INIpayTest":$admin_row[shopId])."';\n";
			echo "		document.ini.gopaymethod.value = 'onlyvbank';\n";
			echo "		document.ini.INIregno.value = form.ssh1.value + form.ssh2.value;\n";
		}
		else
		{
			echo "		alert('�ش� PG���� ������� ������ �غ��� �Դϴ�');\n";
			echo "		paybtn_Status = 'nsAct';\n";
		}
		//PG�纰 ������� ���� �ɼ�ó�� ��
?>
	}
	else if(ch_payM == "bank")					//������(������)
	{
		if(form.bankInfo.selectedIndex==0)		//������ ���¼��ÿ��� Ȯ��
		{
			alert("������ ������ �ֽʽÿ�.");
			form.bankInfo.focus();
			paybtn_Status = 'nsAct';
		}
	}

	if(paybtn_Status == 'nsAct')
	{
		viewAct(paybtn_Status);		//������ư ���̱�
	}
	else
	{
		trade_update();
	}
}

//ī����� ���� 
function go_card()
{
	//ī����� �ϰ�ó�� �ҽ� ���� 
	<?
	if($admin_row[pgName]=="dacom")
	{
		//������ �ҽ�
		?>
	var popWindow = window.open("","Window","width=470, height=500, menubar=no, status, scrollbars");
	if(popWindow == null)
	{
		var g_fIgSP2 = false;
		g_fIgSP2 = (window.navigator.appMinorVersion.indexOf("SP2") != -1);
		if (g_fIgSP2)
		{
			alert("�������� ������ ������ ���Ͽ� ������ ��ȣȭ ���α׷��� ��ġ�� �ʿ��մϴ�.\n\n�������� ��ǻ�� ȯ���� Windows XP(SP2)�̹Ƿ� "
					+ "���� �ܰ迡 ���� �����Ͻʽÿ�.\n\n\n"
					+ "1. ������(���ͳ� �ͽ��÷ξ�) ����� ����� �˸� ǥ������ ���콺�� Ŭ�� �Ͻʽÿ�.\n\n"
					+ "2. 'ActiveX ��Ʈ�� ��ġ'�� �����Ͻʽÿ�.\n\n"
					+ "3. ���� ���â�� ��Ÿ���� '��ġ'�� ������ �����Ͻʽÿ�.\n");
			viewAct('nsAct');		//������ư ���̱�
		}
	}
	else
	{
		document.dacomForm.target = "Window";
		document.dacomForm.submit();
	}<?

	}
	elseif($admin_row[pgName]=="allat")
	{
		//allat �ҽ�
		?>
	var rtn=ftn_approval(document.allatForm);
	if(rtn == false)
	{
		viewAct('nsAct');		//������ư ���̱�
	}<?

	}
	elseif($admin_row[pgName]=="inicis")
	{
		//inicis �ҽ�
		?>
	var aa=pay(document.ini);
	///////////////////////////////////////////////////////////////
	//pay�Լ��� ���� ��Ʈ���� ����ǥ�ø� ������ false�� �ݳ��Ѵ�.//
	//���������� ��� ������Ű�� true�� �ݳ��Ѵ�.//////////////////
	///////////////////////////////////////////////////////////////

	if (aa == true)
	{
		document.ini.submit();
	}
	else
	{
		viewAct('nsAct');		//������ư ���̱�
	}
	<? } ?>
}
//-->
</SCRIPT><?
if($admin_row[pgName]=="inicis") $modOnload="onload='trade_update();enable_click()'";
else $modOnload="onload='trade_update();'"
?>
<? include "top.php";?>
<table width="900" border="0" cellspacing="0" cellpadding="0" bgcolor="<?=$ALL_BGCOLOR?>">
	<tr>
		<? include "left_menu.php";?>
		<td valign="top" width="720" bgcolor="#FFFFFF">
			<table width="720" height="100%" border="0" cellspacing="0" cellpadding="0">
				<tr bgcolor="#FFFFFF" valign="top">
					<td colspan="2">
						<table width="720" height="30" border="0" cellspacing="0" cellpadding="0" align='center'>
							<tr>
								<td width="2"  bgcolor="<?=$subdesign[bc17]?>" rowspan="2"></td>
								<td width="2"  bgcolor="<?=$subdesign[bc17]?>" rowspan="2"></td>
								<td width="220" bgcolor="<?=$subdesign[bc17]?>"><img src="./upload/design/<?=$subdesign[img17]?>" ></td>
								<td bgcolor="<?=$subdesign[bc17]?>"><div align="right"> &nbsp;<font color="<?=$subdesign[tc17]?>"> <img src='image/good/icon0.gif'>&nbsp; ������ġ : HOME &gt; ��������</font>&nbsp;</div></td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td valign="top" width="720">
						<table width="700" border="0" cellspacing="0" cellpadding="0" align="center">
							<tr>
								<td><?
								if ($subdesign[titimg17])
								{
									?><img src="./upload/design/<?=$subdesign[titimg17]?>" ><?
								}
								else
								{
									?><img src="image/work/order_end.gif" ><?
								}
								?></td>
							</tr>
							<tr>
								<td align=center><img src="image/sub/order_03.gif"></td>
							</tr>
						</table>
						<br>
						<table width="670" border="0" cellspacing="0" cellpadding="0" align="center">
							<tr>
								<td height='2' bgcolor='80c9d8'></td>
							</tr>
							<tr>
								<td>
									<table width="670" border="0" cellspacing="0" cellpadding="0" height="30" align="center">
										<tr bgcolor="#edf7f9" align="center">
											<td width="40"><font color='006676'><b>��ȣ</b></font></td>
											<td width='1'><img src='image/board/line.gif'></td>
											<td width="<?=$__TNAME_TD_WIDTH?>"><font color='006676'><b>��ǰ��</b></font></td>
											<td width='1'><img src='image/board/line.gif'></td>
											<td width="100"><font color='006676'><b>�ɼ�</b></font></td>
											<td width='1'><img src='image/board/line.gif'></td>
											<td width="70"><font color='006676'><b>��ǰ��</b></font></td>
											<td width='1'><img src='image/board/line.gif'></td>
											<?if($admin_row[bUsepoint] && $GOOD_SHOP_PART=="member"){?>
											<td width="66"><font color='006676'><b>������</b></font></td>
											<td width='1'><img src='image/board/line.gif'></td>
											<?}?>
											<td width="41"><font color='006676'><b>����</b></font></td>
											<td width='1'><img src='image/board/line.gif'></td>
											<td width="80"><font color='006676'><b>�հ� (��)</b></font></td>
										</tr>
									</table>
								</td>
							</tr>
							<tr>
								<td height='1' bgcolor='80c9d8'></td>
							</tr>
							<tr>
								<td valign="top">
									<table width="670" border="0" cellspacing="0" cellpadding="0" height="25" align="center"><?
									$cart_qry = "select * from cart where userid='$GOOD_SHOP_USERID' order by goodsIdx desc";
									$cart_result	 = $MySQL->query($cart_qry);
									$cart_goods_cnt = $MySQL->is_affected();
									$total_price = 0;
									$total_point = 0;
									while($cart_row = mysql_fetch_array($cart_result))
									{
										$goods_row = $MySQL->fetch_array("select * from goods where idx=$cart_row[goodsIdx]"); //��ǰ����
										$gname = addslashes($goods_row[name]);
										$gprice = new CGoodsPrice($goods_row[idx]);
										if ($admin_row[bNew])
										{
											$bNew = limitday($goods_row[writeday],$admin_row[new_day]);
											if (empty($bNew) && $goods_row[bNew]) $bNew = "<img src='upload/goods_new_img'>";
										}
										$bHit =$goods_row[bHit]?"<img src='upload/goods_hit_img'>":"";
										$bEtc =$goods_row[bEtc]?"<img src='upload/goods_etc_img'>":"";
										$optionArr = Array("$cart_row[option1]","$cart_row[option2]","$cart_row[option3]");
										$tprice = $cart_row[price] * $cart_row[cnt];
										$total_point += $cart_row[point];
										if ($goods_row[bLimit]==1)
										{
											if (empty($goods_row[limitCnt]))
											{
												$limit = 1;	// ǰ���̸� 1
												$limit_good = $goods_row[name];
											}
											else if ($goods_row[limitCnt] < $cart_row[cnt])	// ǰ���� �ƴѵ� ���ż����� ��������� �Ѿ��
											{
												$limit = 2; // ����ʰ��̸� 2 
												$over_cnt = $cart_row[cnt] - $goods_row[limitCnt];
												$limit_good = $goods_row[name]."��ǰ�� ����� $over_cnt �� �ʰ��Ͽ����ϴ�.";
											}
										}
										else if ($goods_row[bLimit]>1)
										{
											$limit = $goods_row[bLimit]; // ����ǰ�� 2, ���� 3 , ���� 4 
											$limit_good = "��ǰ�� ���� �Ǵ� ������ �����Դϴ�.";
										}
										$bLimit	   = $goods_row[bLimit];
										$limitCnt  = $goods_row[limitCnt];
										if (empty($GD_SET) && $goods_row[img_onetoall]) $img_str = $goods_row[img3];
										else if ($GD_SET && $goods_row[img_onetoall] && empty($goods_row[img1])) $img_str = $goods_row[img3];
										else if ($GD_SET && empty($goods_row[img_onetoall]) && empty($goods_row[img1])) $img_str = $goods_row[img3];
										else $img_str = $goods_row[img1];
										?>
										<tr>
											<td width="41" height="25" align="center"><?=$cart_goods_cnt?></td>
											<td width="45" height="25" align="center"><img src="./upload/goods/<?=$img_str?>" width="40" height="40"></td>
											<td width="<?=$__TNAME_TD_WIDTH-44?>" height="25" align="left"><?=$goods_row[name]?> <?=$bHit?> <?=$bNew?> <?=$bEtc?></td>
											<td width="101" height="25" align="center" align="center">
												<table width="100" border="0" cellspacing="0" cellpadding="0"><?
												for($i=0;$i<count($optionArr);$i++)
												{
													if(!empty($optionArr[$i]))
													{
														$option = explode("����",$optionArr[$i]);
														?>
													<tr>
														<td width="45"  bgcolor="#F7F7F7"> <div align="center"><?=$option[0]?> </div></td>
														<td bgcolor="#DDFFFB"> <div align="left"> : <?=$option[1]?></div></td>
													</tr>
													<tr bgcolor="#CCCCCC">
														<td colspan="2" height="1"></td>
													</tr><?
													}
												}
												?>
												</table>
											</td>
											<td width="71" height="25" align="right"><?=$gprice->PutPrice();?>&nbsp;</td><?
											if($admin_row[bUsepoint] && $GOOD_SHOP_PART=="member")
											{
												?><!-- �����������ݻ�� && ȸ�� -->
											<td width="67" height="25" align="right"><?=PriceFormat($cart_row[point])?>&nbsp;</td><?
											}
											?>
											<td width="42" height="25" align="center"><?=$cart_row[cnt]?></td>
											<td width="80" height="25" align="right"> <FONT COLOR="#990000"><?=PriceFormat($tprice)?></FONT>&nbsp;</td>
										</tr>
										<tr>
											<td colspan="8" height="1" bgcolor='e1e1e1'></td>
										</tr><?
											$total_price +=$tprice;	//�ѱ��Ű���
											$cart_goods_cnt --;
									}
									?>
									</table>
								</td>
							</tr><?
							if(empty($admin_row[bTrans]) && empty($admin_row[chakbul]))
							{
								$transM = 0;
								$transMstr = "����";
							}
							else if(empty($admin_row[bTrans]) && $admin_row[chakbul])	//��ۺ�̻��
							{
								$transM = 0;
								$transMstr = "����";
							}
							else
							{
								if($admin_row[noTrans] <=$total_price)
								{
									$transM = 0;
									$transMstr=PriceFormat($transM)." ��";
								}
								else	//��ۺ񹫷� ����ݾ�
								{
									$transM = $admin_row[transMoney];
									$transMstr=PriceFormat($transM)." ��";
								}
								//��ۺ�����
							}
							if ($MySQL->articles("SELECT idx from cart WHERE userid='$GOOD_SHOP_USERID'")==1) // ��ٱ��Ͽ� ��ǰ�� 1���϶� 
							{
								$cart_row = $MySQL->fetch_array("SELECT goodsIdx from cart WHERE userid='$GOOD_SHOP_USERID' limit 1");
								$goods_row = $MySQL->fetch_array("SELECT size from goods WHERE idx=$cart_row[goodsIdx] limit 1");
								if ($goods_row[size]=="n") //������ ��ǰ�̸� 
								{
									$transM = 0;
									$transMstr=PriceFormat($transM)." ��";
								}
							}
							// �߰���ۺ� ���
							$trans_row = $MySQL->fetch_array("SELECT transP from trans_add WHERE first_zip<='$rzip' and last_zip>='$rzip' limit 1");
							if ($trans_row)
							{
								$MySQL->query("UPDATE trade SET trans_add='y' WHERE tradecode='$tradecode'");
								$MySQL->query("UPDATE trade_temp SET trans_add='y' WHERE tradecode='$tradecode'");
								$transM+= $trans_row[transP];
								// �����϶� �߰���ۺ� ������ �߰�
								if ($transMstr=="����") $transMstr = "</font>�����갣 �߰���ۺ� <font color=green>".PriceFormat($trans_row[transP])." ��";
								// �Ϲ����� �ݾ��϶� �Ϲݹ�ۺ� �߰���ۺ� ���ڿ��߰�///// 
								else if ($transMstr!="����" && $transMstr!="����")  $transMstr.= " </font>+ �����갣 �߰���ۺ� <font color=green>".PriceFormat($trans_row[transP])." ��";
							}
							if (!$transMstr) $transMstr=PriceFormat($transM)." ��";
							$payMoney = $total_price +$transM;  ///////////////// ���� �ݾ�
							$MySQL->query("update  trade set payM=$payMoney,transM='$transM',totalM=$total_price where tradecode='$tradecode'");
							?>
							<tr>
								<td height="30">
									<table width="670" border="0" cellspacing="1" cellpadding="0">
										<tr>
											<td bgcolor="fafafa" height="30" align="right">[ ��ۺ� : <font color="#FF0000"><?=$transMstr?></font> <?
											if($admin_row[bUsepoint] && $GOOD_SHOP_PART=="member")
											{
												?>, ������ <?=PriceFormat($total_point)?>��<?}?> ] <B>�����ݾ�</B> : <b><font color="#FF0000"><?=PriceFormat($total_price+$transM)?>��</font></b></td>
										</tr>
									</table>
								</td>
							</tr>
						</table>
						<br>
						<!-- �����ݻ��� ���Ǵ� �� �� ī������� ���-->
						<form name="usePform" method="post" action="card_update.php">
						<input type="hidden" name="useP">
						<input type="hidden" name="tradecode" value="<?=$tradecode?>">
						<input type="hidden" name="payM">
						<input type="hidden" name="transM">
						<input type="hidden" name="totalM">
						<input type="hidden" name="transMethod">
						<input type="hidden" name="pay_ready">
						<input type="hidden" name="payMethod">
						</form>
						<iframe name="ifrm" width='0' height='0' frameborder='0'></iframe>
						<!-- ������ ���Ҹ� ������ ���� ��-->
						<form name="dealform" method="post" action="order_table.php">
						<input type="hidden" name="deal" value=""> <!-- so : �Ҹ� do : ����-->
						<input type="hidden" name="tradecode" value="<?=$tradecode?>">
						</form>
						<form name="payForm" method="post" action="order_table_ok.php">
						<input type="hidden" name="GM_Shop_PayMethod" value="OffBank"><!-- ������ ���� Ȯ�� -->
						<input type="hidden" name="useP"><!-- ����� ������ -->
						<input type="hidden" name="tradecode" value="<?=$tradecode?>"><!-- �ֹ��ڵ� -->
						<input type="hidden" name="channel" value="<?=$channel?>"><!--ex)cart:��ٱ��Ͽ������� direct:�ٷα����ϱ� --><?
						if($admin_row[bUsepoint] && $GOOD_SHOP_PART=="member")
						{
							if($member_row[point] < $admin_row[poMin])
							{
								$possPoint	= 0;
							}
							else if($member_row[point] >=$admin_row[poMin] && $member_row[point] <$admin_row[poMax])
							{
								$possPoint  = $member_row[point];
							}
							else
							{
								if($admin_row[poMaxunlimit]) $possPoint = $member_row[point];
								else $possPoint = $admin_row[poMax];
							}
							if($admin_row[poMaxunlimit])	$maxPointStr="<FONT COLOR='blue'>������</FONT>";
							else							$maxPointStr="<FONT COLOR='blue'>".PriceFormat($admin_row[poMax])."</FONT> ������";
							?>
						<table width="670" border="0" cellspacing="0" cellpadding="0" align="center">
							<tr>
								<td height="30" colspan="3">&nbsp;<img src='image/member/icon_my.gif' align='absmiddle'><b>&nbsp;������ ����</b></td>
							</tr>
							<tr>
								<td colspan='3' bgcolor='80c9d8' height='2'></td>
							</tr>
							<tr>
								<td height="25" width="180" bgcolor="edf7f9"> &nbsp;&nbsp;<font color='006676'>������</font></td>
								<td height="25" colspan="2" > &nbsp;&nbsp;<?=PriceFormat($member_row[point])?> ��</td>
							</tr>
							<tr>
								<td height="1" colspan="3" bgcolor='e1e1e1'></td>
							</tr>
							<tr>
								<td height="25" width="180" bgcolor="edf7f9"> &nbsp;&nbsp;<font color='006676'>��밡�� ������</font></td>
								<td height="25" colspan="2">&nbsp;&nbsp;<?=PriceFormat($possPoint)?> �� </td>
							</tr>
							<tr>
								<td height="1" colspan="3" bgcolor='e1e1e1'></td>
							</tr>
							<tr>
								<td height="25" width="180" bgcolor="edf7f9"> &nbsp;&nbsp;<font color='006676'>������ ���</font></td>
								<td height="25" width="490" align="center"> ����� ������ �Է� : <input class="box" type="text" name="usePoint" size="15" <?=__ONLY_NUM?>></td>
								<td  valign="middle" align="left" width="386"><a href="javascript:setPaymoney(<?=$possPoint?>,<?=$payMoney?>);"><img src="image/icon/point_use.gif" border="0"></a></td>
							</tr>
							<tr>
								<td height="1" colspan="3" bgcolor='e1e1e1'></td>
							</tr>
							<tr>
								<td height="25" colspan="3">&nbsp;&nbsp;&nbsp;<FONT  COLOR="#993300">�� �����ݾ��� <FONT COLOR="blue"><?=PriceFormat($admin_row[popayM])?></FONT> �� �̻��̸� �������� <FONT COLOR="blue"><?=PriceFormat($admin_row[poMin])?></FONT>�� �̻��϶� <?=$maxPointStr?> ��� �����մϴ�.</FONT></td>
							</tr>
						</table><br><?
						}
						?>
						<table width="670" border="0" cellspacing="0" cellpadding="0" align="center">
							<tr>
								<td height="30" colspan="2">&nbsp;<img src='image/member/icon_my.gif' align='absmiddle'><b>&nbsp;���űݾ�����</b></td>
							</tr>
							<tr>
								<td colspan='3' bgcolor='80c9d8' height='2'></td>
							</tr>
							<tr>
								<td height="25" width="104" bgcolor="edf7f9"> &nbsp;&nbsp;&nbsp;<font color='006676'>��ǰ�ݾ�</font></td>
								<td height="25" width="496"> &nbsp;&nbsp;<input class="box_s" type="text" name="totalM" size="15" style="font-size: 9pt; border:0 solid #000000;background-color:white;text-align:right;" readonly value="<?=$total_price?>"> �� &nbsp; </td>
							</tr>
							<tr>
								<td height="1" colspan="2" bgcolor='e1e1e1'></td>
							</tr>
							<tr>
								<td height="25" width="104" bgcolor="edf7f9">&nbsp;&nbsp;&nbsp;<font color='006676'>�� �� ��</font></td>
								<td height="25" width="496"> &nbsp;&nbsp;<input class="box_s" type="text" name="transM" size="15" style="font-size: 9pt; border:0 solid #000000;background-color:white;text-align:right;" readonly value="<?=$transM?>"> ��&nbsp;&nbsp; </td>
							</tr>
							<tr>
								<td height="1" colspan="2" bgcolor='e1e1e1'></td>
							</tr>
							<tr>
								<td height="25" width="104" bgcolor="edf7f9">&nbsp;&nbsp;&nbsp;<font color='006676'>�����ݾ�</font></td>
								<td height="25" width="496"> &nbsp;&nbsp;<input class="box_s" type="text" name="payM" size="15" style="font-size: 9pt; border:0 solid #000000;background-color:white;text-align:right;color:red;" readonly value="<?=$payMoney?>"> ��&nbsp; &nbsp;&nbsp;&nbsp; </td>
							</tr>
							<tr>
								<td height="1" colspan="2" bgcolor='e1e1e1'></td>
							</tr>
							<tr>
								<td colspan="2"><br><br></td>
							</tr>
							<tr>
								<td height="1" colspan="2" bgcolor="ffffff"></td>
							</tr><!-- ��۹�� --><?
							if ($admin_row[bTransmethod]=="y")
							{
								?>
							<tr>
								<td height="1" colspan="2" bgcolor="ffffff"></td>
							</tr>
							<tr>
								<td height="30" colspan="2">&nbsp;<img src='image/member/icon_my.gif' align='absmiddle'><b>&nbsp;��۹������</b></td>
							</tr>
							<tr>
								<td colspan='2' bgcolor='80c9d8' height='2'></td>
							</tr>
							<tr>
								<td height="25" width="496"  colspan="2">
									<table width="100%" border="0" cellspacing="0" cellpadding="0">
										<tr>
											<td align="center" width="30"><input type="radio" name="transMethod" value="t" checked></td>
											<td align="left" width="80">�ù�߼� </td>
											<td><?=nl2br($admin_row[method_1])?></td>
										</tr>
									</table>
								</td>
							</tr>
							<tr>
								<td height="1" colspan="2" bgcolor='e1e1e1'></td>
							</tr>
							<tr>
								<td height="25" width="496"  colspan="2">
									<table width="100%" border="0" cellspacing="0" cellpadding="0">
										<tr>
											<td align="center" width="30"><input type="radio" name="transMethod" value="k" ></td>
											<td align="left" width="80">�浿ȭ�� </td>
											<td><?=nl2br($admin_row[method_2])?></td>
										</tr>
									</table>
								</td>
							</tr>
							<tr>
								<td height="1" colspan="2" bgcolor='e1e1e1'></td>
							</tr>
							<tr>
								<td height="25" width="496"  colspan="2">
									<table width="100%" border="0" cellspacing="0" cellpadding="0">
										<tr>
											<td align="center" width="30"><input type="radio" name="transMethod" value="q" ></td>
											<td align="left" width="80">����� </td>
											<td><?=nl2br($admin_row[method_3])?></td>
										</tr>
									</table>
								</td>
							</tr>
							<tr>
								<td height="1" colspan="2" bgcolor='e1e1e1'></td>
							</tr>
							<tr>
								<td colspan="2"><br><br></td>
							</tr>
							<tr>
								<td height="1" colspan="2" bgcolor="ffffff"></td>
							</tr><!-- ��۹�� --><?
							}
							else
							{
								$transMethod="t";
							}
							?>
							<tr>
								<td height="30" colspan="2">&nbsp;<img src='image/member/icon_my.gif' align='absmiddle'><b>&nbsp;�����������</b></td>
							</tr><?
							if(0 < ($admin_row[bCardpay] + $admin_row[bIchepay] + $admin_row[bHpppay] + $admin_row[bCyberpay]))
							{
								?>
							<tr>
								<td colspan='2' bgcolor='80c9d8' height='2'></td>
							</tr>
							<tr>
								<td width="496" colspan="2">
									<table width="100%" border="0" cellspacing="0" cellpadding="0">
										<tr><?
										if($admin_row[bCardpay])
										{
											?>
											<td align="center" height="25" width="30"><input type="radio" name="payMethod" value="card" onclick="javascript:bank_select();" checked></td>
											<td align="left">�ſ�ī�� </td><?
										}
										if($admin_row[bHpppay])
										{
											?>
											<td align="center" height="25" width="30"><input type="radio" name="payMethod" value="hand" onclick="javascript:bank_select();"></td>
											<td align="left">�ڵ���</td><?
										}
										if($admin_row[bIchepay])
										{
											?>
											<td align="center" height="25" width="30"><input type="radio" name="payMethod" value="iche" onclick="javascript:bank_select();"></td>
											<td align="left">������ü</td><?
										}
										if($admin_row[bCyberpay])
										{
											?>
											<td align="center" height="25" width="30"><input type="radio" name="payMethod" value="cyber" onclick="javascript:bank_select();"></td>
											<td align="left">������(�������)</td><?
										}
											?>
										</tr><?
										if(0 < ($admin_row[bIchepay] + $admin_row[bCyberpay]))	//�ǽð�/������� ������ �ֹι�ȣ �Է¿䱸
										{
											?>
										<tr>
											<td height="30" align='center' colspan="<?=($admin_row[bCardpay] + $admin_row[bIchepay] + $admin_row[bHpppay] + $admin_row[bCyberpay]) * 2?>"><input type=text name=ssh1 size=6 maxlength=6 value="<?=$ssh[0]?>">-<input type=password name=ssh2 size=7 maxlength=7 value="<?=$ssh[1]?>"> ��ȸ�� �ֹι�ȣ�Է�(�ʼ�)</td>
										</tr><?
										}
											?>
									</table>
								</td>
							</tr>
							<tr>
								<td height="1"  colspan="2" bgcolor='e1e1e1'></td>
							</tr><?
							}
							if($admin_row[bBankpay])
							{
								?>
							<tr>
								<td height="25" width="496"  colspan="2">
									<table width="100%" border="0" cellspacing="0" cellpadding="0">
										<tr>
											<td align="center" width="30" height="30"><input type="radio" name="payMethod" value="bank" onclick="javascript:bank_select();" <?if(empty($admin_row[bCardpay])) echo"checked";?>></td>
											<td align="left" width="120" >�������Ա� </td>
											<td align="left"><select name="bankInfo">
											<option value="0">.................���� ����...................</option><?
											for($i=1,$j=0;$i<=10;$i++,$j++)
											{
												//���� 1 ~ 10
												if($bBank[$j])
												{
													?><option style="background-color:#E3E3F8;" <? if ($i==1) echo "selected";?> value="<?=$bankName[$j]?> <?=$bankId[$j]?> (<?=$bankOwn[$j]?>)"><?=$bankName[$j]?> <?=$bankId[$j]?> (<?=$bankOwn[$j]?>)</option><?
												}
											}
											?></select><?
											$now = time();
											$now = date("Y-m-d",$now);
											$now = explode("-",$now);
											?><br>�Աݿ����� &nbsp;&nbsp;<select name="year"><?
											for ($i=$now[0]; $i<$now[0]+1; $i++)
											{
												?><option value="<?=$i?>"><?=$i?></option><?
											}
											?></select>�� <select name="month"><?
											for ($i=1; $i<13; $i++)
											{
												?><option value="<?=$i?>" <? if ($i == $now[1]) echo "selected";?>><?=$i?></option><?
											}
											?></select>�� <select name="day"><?
											for ($i=1; $i<32; $i++)
											{
												?><option value="<?=$i?>" <? if ($i == $now[2]) echo "selected";?>><?=$i?></option><?
											}
											?></select>��<br> �Ա��ڸ� <input type="text" class="box_s" name="payer" size=10 value="<?=$name?>"></td>
										</tr>
									</table>
								</td>
							</tr><?
							}
							?>
							<tr>
								<td height="1" colspan="2" bgcolor='e1e1e1'></td>
							</tr>
							<tr align="center">
								<td colspan="2" height="30"><br>������ <B><?=date("Y�� m�� d��")?></B> �Դϴ�.<br><br></td>
							</tr>
							<tr align="center">
								<td colspan="2">
									<table width="250" border="0" cellspacing="0" cellpadding="0" align="center" id='nsPre' style='display:block'>
										<tr align="center">
											<td colspan="2">���� �غ��� �Դϴ�. ��ø� ��ٷ� �ֽʽÿ�.</td>
										</tr>
									</table>
									<table width="250" border="0" cellspacing="0" cellpadding="0" align="center" id='nsAct' style='display:none'>
										<tr align="center">
											<td><img src="image/icon/account.gif" border="0" onclick="javascript:paySendit('<?=$limit?>','<?=$limit_good?>');" style="cursor:pointer;"></td>
											<td><a href="order_table.php?orderCancel=y&tradecode=<?=$tradecode?>"><img src="image/icon/cancel_lag.gif" border="0"></a></td>
										</tr>
									</table>
									<table width="480" border="0" cellspacing="0" cellpadding="0" align="center" id='nsWait' style='display:none'>
										<tr align="center">
											<td colspan="2">������ ������ �Դϴ�. ����â�� ������ ��쿡�� ������ ���ΰ�ħ�� �Ͽ� �ֽʽÿ�.</td>
										</tr>
									</table><br>
								</td>
							</tr>
							<tr>
								<td colspan="2" bgcolor='dadfe5' height='1'></td>
							</tr>
							<tr>
								<td colspan="2" height="30" bgcolor='eff3f4' style='padding:0 0 0 10'><img src='image/index/icon_cate00.gif'> <font color='3d5b75'><b>��ٱ��� �̿�ȳ�</b></font></td>
							</tr>
							<tr>
								<td colspan="2" bgcolor='dadfe5' height='1'></td>
							</tr>
							<tr valign="top">
								<td colspan="2" style='padding:10 10 10 10'><?=$xTrans?></td>
							</tr>
							<tr>
								<td colspan="2" bgcolor='dadfe5' height='1'></td>
							</tr>
						</table>
						</form><!-- payForm --><br>
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<?
	$cart_result = @$MySQL->query("select *from cart where userid='$_SESSION[GOOD_SHOP_USERID]'");
	$inSuccess =true;
	while($cart_row = mysql_fetch_array($cart_result))
	{
		$qry = "select code, name from goods where idx=$cart_row[goodsIdx] limit 1";
		$goods_row = $MySQL->fetch_array($qry);
		$gname = addslashes($goods_row[name]);
	}
	?>
</table>
<? include "copy.php"; ?>
<?
$_SELF=explode("/",$_SERVER[PHP_SELF]);
$_SELF[count($_SELF)-1]="";
$_PAY_OK_FILE=implode("/", $_SELF);
$_This_folder="http://".$_SERVER[HTTP_HOST].$_PAY_OK_FILE;

if($admin_row[pgName]=="dacom")	// ������ �ҽ�
{
	//��ȣȭ ��� ����
	$hashdata = md5($admin_row[shopId].$tradecode.$payMoney.$admin_row[shop_pg_mertkey]);	//��ȣȭ�� hashdata �����
	?>
<form name="dacomForm" method="POST" action="">
<input type="hidden" name="mid" value="<?=$admin_row[shopId]?>">
<input type="hidden" name="oid" value="<?=$tradecode?>">
<input type="hidden" name="amount" value="<?=$payMoney?>">
<input type="hidden" name="note_url" value="<?= $_This_folder?>AllplanPG/dacom/normal_note_url.php">
<input type="hidden" name="ret_url" value="<?= $_This_folder?>order_table_ok.php">
<input type="hidden" name="fail_url" value="<?= $_This_folder?>cart.php">
<input type="hidden" name="hashdata" value="<?=$hashdata?>">
<input type="hidden" name="buyer" value="<?=$temp_row[name]?>">
<input type="hidden" name="productinfo" value="<?=$goods_row[name]?>">
<!-- ��輭�񽺸� ���� �������� hidden���� -->
<input type="hidden" name="producttype" value="">
<input type="hidden" name="productcode" value="">
<input type="hidden" name="productinfo" value="">
<input type="hidden" name="buyerid" value="<?=$GOOD_SHOP_USERID?>">
<input type="hidden" name="buyerip" value="<?=$REMOTE_ADDR?>">
<input type="hidden" name="buyerssn" value="">
<input type="hidden" name="pid" value="<?=$ssh[0]?><?=$ssh[1]?>">
<input type="hidden" name="buyeraddress" value="<?=$temp_row[adr1] ." " .$temp_row[adr2]?>">
<input type="hidden" name="buyeremail" value="<?=$temp_row[email]?>">
<input type="hidden" name="buyerphone" value="<?=$temp_row[hand]?>">
<input type="hidden" name="deliveryinfo" value="<?=$temp_row[radr1] ." " .$temp_row[radr2]?>">
<input type="hidden" name="receiver" value="<?=$temp_row[rname]?>">
<input type="hidden" name="receiverphone" value="<?=$temp_row[rhand]?>">
<!-- �Һΰ��� ����â ��� ���� �������� hidden���� -->
<input type="hidden" name="install_fr" value="">
<input type="hidden" name="install_to" value="">
<input type="hidden" name="install_range" value="">
<!-- ������ �Һ� ���θ� �����ϴ� hidden���� -->
<input type="hidden" name="nointerest" value="0">
<input type="hidden" name="escrowflag" value=""><?//����ũ�� �ŷ����δ� �ΰ� : �������� ����â���� �����ڿ��� ����ũ�ΰŷ����� ����â�� �����ܵ��� ��?>
</form><?

}
elseif($admin_row[pgName]=="allat")	//allat
{
	$pG_shopId = ($admin_row[pG_test]=="y") ? "allat_test02":$admin_row[shopId];
	?>
<script language=JavaScript src="https://tx.allatpay.com/common/allatpayX.js"></script>
<script language=Javascript>
function ftn_approval(dfm)
{
	var ret;
	ret = visible_Approval(dfm);	//Function ���ο��� submit�� �ϰ� �Ǿ�����.
	if( ret.substring(0,4)!="0000" && ret.substring(0,4)!="9999")
	{
		// ���� �ڵ� : 0001~9998 �� ������ ���ؼ� ������ ó���� ���ֽñ� �ٶ��ϴ�.
		alert(ret.substring(4,ret.length));		// Message ��������
		return false;
	}
	if( ret.substring(0,4)=="9999" )
	{
		// ���� �ڵ� : 9999 �� ����(����� ���)�� ���ؼ� ������ ó���� ���ֽñ� �ٶ��ϴ�.
		alert(ret.substring(8,ret.length));		// Message ��������
		return false;
	}
}
</script>
<form name="allatForm"  method=POST action="order_table_ok.php">
<?//�ʼ����� :���� �ʼ� �׸�?>
<?//���� ID?><input type='hidden' name="allat_shop_id" value="<?=$pG_shopId?>">
<?//�ֹ���ȣ?><input type='hidden' name="allat_order_no" value="<?=$tradecode?>">
<?//�����ݾ�?><input type='hidden' name="allat_amt" value="<?=$payMoney?>">
<?//ȸ��ID?><input type='hidden' name="allat_pmember_id" value="<?=$GOOD_SHOP_USERID?>">
<?//��ǰ�ڵ�?><input type='hidden' name="allat_product_cd" value="<?=$goods_row[code]?>">
<?//��ǰ��?><input type='hidden' name="allat_product_nm" value="<?=$goods_row[name]?>">
<?//�����ڼ���?><input type='hidden' name="allat_buyer_nm" value="<?=$temp_row[name]?>">
<?//�����μ���?><input type='hidden' name="allat_recp_nm" value="<?=$temp_row[rname]?>">
<?//�������ּ�?><input type='hidden' name="allat_recp_addr" value="<?=$temp_row[radr1]." ".$temp_row[radr2]?>">
<?//�������� : Y(����), N(�����)?><input type='hidden' name="allat_tax_yn" value="Y">
<?//�ֹ�������ȣȭ�ʵ�?><input type='hidden' name=allat_enc_data value="">
<?//�þ������ʵ�?><input type='hidden' name=allat_opt_pin value="VIEW">
<?//�þ������ʵ�?><input type='hidden' name=allat_opt_mod value="WEB">

<?//�ɼ����� : D���̳� �ʵ尡 ���� ��� ���� �Ӽ��� �ݿ���, ���(Y),������� ����(N),���� �Ӽ�(D)?>
<?//�ſ�ī�� ���� ��� ����?><input type='hidden' name="allat_card_yn" value="N">
<?//������ü ���� ��� ����?><input type='hidden' name="allat_bank_yn" value="N">
<?//������(�������) ���� ��� ����?><input type='hidden' name="allat_vbank_yn" value="N">
<?//������(�������) ���� Key : ���� ä������� Key�� ����� ���� �����?><input type='hidden' name="allat_account_key" value="">
<?//�Ϲ�/������ �Һ� ��뿩�� : �Ϲ�(N), ������ �Һ�(Y), ���� �Ӽ�(D)?><input type='hidden' name="allat_zerofee_yn" value="D">
<?//ī�� ���� ���� : ����(Y), ���� ������(N), ������ ���(X)?><input type='hidden' name="allat_cardcert_yn" value="N">
<?//�ڵ� ���� ��� ���� : �ڵ�����(Y), ���� ����(N), �����Ӽ�(D)?><input type='hidden' name="allat_sanction_yn" value="D">
<?//���ʽ�����Ʈ ��� ���� : ���(Y), ��� ����(N)?><input type='hidden' name="allat_bonus_yn" value="N">
<?//���� ������ �߱� ����?><input type='hidden' name="allat_cash_yn" value="D">
<?//��ǰ�̹��� URL?><input type='hidden' name="allat_product_img" value="">
<?//���� ���� ���� E-mail : ����ũ�� ���� ���ÿ� �ʼ� �ʵ���?><input type='hidden' name="allat_email_addr" value="<?=$temp_row[email]?>">
<?//�׽�Ʈ ���� : �׽�Ʈ(Y),����(N)?><input type='hidden' name="allat_test_yn" value="<?=$admin_row[pG_test]=="y"?"Y":"N"?>">
<?//��ǰ �ǹ� ���� : �ǹ�(Y), �ǹ��ƴ�(N), ��ǰ�� �ǹ��̰�, 10���� �̻� ������ü�� ����ũ�� ���뿩�� �̿�
?><input type='hidden' name="allat_real_yn" value="Y">
</form><?

}
elseif($admin_row[pgName]=="inicis")	//�̴Ͻý��ҽ�
{
	$pG_shopId = ($admin_row[pG_test]=="y") ? "INIpayTest":$admin_row[shopId];
	?>
<!-------------------------------------->
<!-�̴Ͻý� �ҽ� �߰� ����(JAVASCRIPT)-->
<!-------------------------------------->
<script language=javascript src="http://plugin.inicis.com/pay40.js">
</script>
<script language=javascript>
StartSmartUpdate();

var openwin;

function pay(frm)
{
	// MakePayMessage()�� ȣ�������ν� �÷������� ȭ�鿡 ��Ÿ����, Hidden Field
	// �� ������ ä������ �˴ϴ�. �Ϲ����� ���, �÷������� ����ó���� �����ϴ� ����
	// �ƴ϶�, �߿��� ������ ��ȣȭ �Ͽ� Hidden Field�� ������ ä��� �����ϸ�,
	// ���� �������� INIsecurepay.php�� �����Ͱ� ����Ʈ �Ǿ� ���� ó������ �����Ͻñ� �ٶ��ϴ�.

	if(document.ini.clickcontrol.value == "enable")
	{
		
		if(document.ini.goodname.value == "")  // �ʼ��׸� üũ (��ǰ��, ��ǰ����, �����ڸ�, ������ �̸����ּ�, ������ ��ȭ��ȣ)
		{
			alert("��ǰ���� �������ϴ�. �ʼ��׸��Դϴ�.");
			return false;
		}
		else if(document.ini.price.value == "")
		{
			alert("��ǰ������ �������ϴ�. �ʼ��׸��Դϴ�.");
			return false;
		}
		else if(document.ini.buyername.value == "")
		{
			alert("�����ڸ��� �������ϴ�. �ʼ��׸��Դϴ�.");
			return false;
		} 
		else if(document.ini.buyeremail.value == "")
		{
			alert("������ �̸����ּҰ� �������ϴ�. �ʼ��׸��Դϴ�.");
			return false;
		}
		else if(document.ini.buyertel.value == "")
		{
			alert("������ ��ȭ��ȣ�� �������ϴ�. �ʼ��׸��Դϴ�.");
			return false;
		}
		else if(document.INIpay == null || document.INIpay.object == null)  // �÷����� ��ġ���� üũ
		{
			alert("\n�̴����� �÷����� 128�� ��ġ���� �ʾҽ��ϴ�. \n\n������ ������ ���Ͽ� �̴����� �÷����� 128�� ��ġ�� �ʿ��մϴ�. \n\n�ٽ� ��ġ�Ͻ÷��� Ctrl + F5Ű�� �����ðų� �޴��� [����/���ΰ�ħ]�� �����Ͽ� �ֽʽÿ�.");
			return false;
		}
		else
		{
			/******
			 * �÷������� �����ϴ� ���� �����ɼ��� �̰����� ������ �� �ֽ��ϴ�.
			 * (�ڹٽ�ũ��Ʈ�� �̿��� ���� �ɼ�ó��)
			 */
			
			/*
			50000�� �̸��� �ҺκҰ�, �ϽúҸ� �÷����ο��� ���� �����ϱ� ���� ����
			*/

			if(parseInt(frm.price.value) < 50000)
			{
				/****  �� ���� ��  - ������ �������� ���� ���� nointerest ���� "yes"�� ���� 
									 �� �ܿ��� �Ϲ������� "no"���� ����
				****/
				frm.nointerest.value = "no"; 
				frm.quotabase.value = "�Ͻú�";
			}
			else
			{
				/*
					�� ���� �� - ���� 5�����̸� ���ǿ� ���� �������� �� ������ ���� �ʵ�(nointerest, quotabase)�� 
						 ���������� �״�� ������ �� �ֵ��� �Ʒ� �ҽ� �߿� nointerest, quotabase ���� �����ϰ� ���� 
				*/

				frm.nointerest.value = "no";
				frm.quotabase.value = "����:�Ͻú�:3����:4����:5����:6����:7����:8����:9����:10����:11����:12����";
			}

			if (MakePayMessage(frm))
			{
				disable_click();
				openwin = window.open("AllplanPG/inicis/INIpay41/sample/childwin.html","childwin",
												"width=299,height=149");
				return true;
			}
			else
			{
				alert("������ ����ϼ̽��ϴ�.");
				return false;
			}
		}
	}
	else
	{
		return false;
	}
}


function enable_click()
{
	document.ini.clickcontrol.value = "enable"
}

function disable_click()
{
	document.ini.clickcontrol.value = "disable"
}

function focus_control()
{
	if(document.ini.clickcontrol.value == "disable")
		openwin.focus();
}
</script>
<!-- pay()�� "true"�� ��ȯ�ϸ� post�ȴ� -->
<form name="ini" method=post action="order_table_ok.php" onSubmit="return pay(this)">
<input type=hidden name=gopaymethod value="onlycard">
<input type=hidden name=goodname value="<?=$goods_row[name]?>">
<input type=hidden name=oid value="<?=$tradecode?>">
<input type=hidden name=price value="<?=$payMoney?>">
<input type=hidden name=buyername value="<?=$temp_row[name]?>">
<input type=hidden name=buyeremail value="<?=$temp_row[email]?>">	
<input type=hidden name=buyertel value="<?=$temp_row[hand]?>">
<input type=hidden name=INIregno value="">
<input type=hidden name=mid value="<?=$pG_shopId?>">
<input type=hidden name=currency value="WON">
<input type=hidden name=nointerest value="no">
<input type=hidden name=quotabase value="����:�Ͻú�:3����:4����:5����:6����:7����:8����:9����:10����:11����:12����">
<input type=hidden name=acceptmethod value="HPP(1):NEMO(1)">
<input type=hidden name=quotainterest value="">
<input type=hidden name=paymethod value="">
<input type=hidden name=ini_escrow_dlv  value="5">
<input type=hidden name=recvname value="<?=$temp_row[rname]?>">
<input type=hidden name=recvtel value="<?=$temp_row[rtel]?>">
<input type=hidden name=recvaddr value="<?=$temp_row[radr1] ." " .$temp_row[radr2]?>">
<input type=hidden name=recvpostnum value="<?=$temp_row[rzip]?>">
<input type=hidden name=recvmsg value="<?=$temp_row[content]?>">
<input type=hidden name=cardcode value="">
<input type=hidden name=cardquota value="">
<input type=hidden name=rbankcode value="">
<input type=hidden name=reqsign value="DONE">
<input type=hidden name=encrypted value="">
<input type=hidden name=sessionkey value="">
<input type=hidden name=uid value="">
<input type=hidden name=sid value="">
<input type=hidden name=version value=4000>
<input type=hidden name=clickcontrol value="">
</form>
<!-------------------------->
<!-�̴Ͻý� �ҽ� �߰� ����-->
<!--------------------------><?

}
?>
</div>
</body>
</html>