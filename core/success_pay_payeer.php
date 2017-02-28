<?php 
define('SCRIPT_BY_SIRGOFFAN',dirname(__FILE__));
require_once('classes/safemysql.php');
require_once('config.php');

$cmnt="none";

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
			'rej2982jhddd');
	$sign_hash = strtoupper(hash('sha256', implode(':', $arHash)));
if ($_POST['m_sign'] == $sign_hash && $_POST['m_status'] == 'success')
{
	

		
$referer=$db->getOne("SELECT curator FROM `ss_users` WHERE id=?i", $id);
$db->query("INSERT INTO deposits (userid, curatorid, summa, unixtime) VALUES(?i,?i,?s,?s)", $id, $referer, $sum, time());	
echo $_POST['m_orderid'].'|success';
exit;
}
echo $_POST['m_orderid'].'|error';

}
?>

