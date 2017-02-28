<?php 
$cmnt="none";
if(!defined('SUCCESSPAY')){
echo ('Выявлена попытка взлома!');
exit();
}
$sum=$_POST['m_amount']; //Сумма, поступившая от клиента
$id=$_POST['m_orderid'];

	
if (isset($_POST['m_operation_id']) && isset($_POST['m_sign']))
{
	$arHash = array($_POST['m_operation_id'],
			$_POST['m_operation_ps'],
			$_POST['m_operation_date'],
			$_POST['m_operation_pay_date'],
			$_POST['m_shop'],
			$_POST['m_orderid'],
			$_POST['m_amount'],
			$_POST['m_curr'],
			$_POST['m_desc'],
			$_POST['m_status'],
			$m_key);
	$sign_hash = strtoupper(hash('sha256', implode(':', $arHash)));
if ($_POST['m_sign'] == $sign_hash && $_POST['m_status'] == 'success')
{
	
//Проверка по номеру батча
$batch=$_paysystem."_".$_POST['m_operation_id'];
$batchid=$db->getOne("SELECT id FROM batches WHERE batchpm=?s",$batch);

	if(empty($batchid))
	{		
		$db->query("INSERT INTO batches (batchpm, vremya, userid, summa, segodnya) VALUES(?s,?s,?i,?s,?s)",$batch, time(), $id, $sum, date('d.m.Y'));

		$logdescription='<!--ps_success--><!--'.$_paysystem.'-->Пополнение через <font color=green>'.$_paysystem.'</font>. ID плательщика:'.$id;
		inLog($id ,$logdescription, $sum, 'Пополнение', 1);
	echo $_POST['m_orderid'].'|error';		
	}else{
		
		$logdescription='<!--ps_error--><!--'.$_paysystem.'-->Ошибка ввода средств через <font color=red>'.$_paysystem.'</font>. ID плательщика:'.$id;
		inLog($id ,$logdescription, $sum, 'Ошибка пополнения средств', 2);
	echo $_POST['m_orderid'].'|error';		
		exit;
	}	
		
		
	if($_POST['m_curr']!=$m_curr){
		inLog($id ,$logdescription, $sum, 'Ошибка валюты', 2);	
		
		exit;
	}		
		

		include_once('success_pay_result.php');
	echo $_POST['m_orderid'].'|success';
	exit;
}


	echo $_POST['m_orderid'].'|error';
exit;
}else{
	//Перекидываем на главную.
 header('Location: '.$http_s.'://'.$host.'/'); exit;
}
?>
<?/*-------------------*//*
Script by Sirgoffan
Skype: Sirgoffan
Web-site: php-market.ru
*//*-------------------*/?>
