<?php 
session_start();
if(file_exists(dirname(__FILE__)."/core/ini.php")){define ("SCRIPT_BY_SIRGOFFAN" , dirname(__FILE__) ); $_SERVER['DOCUMENT_ROOT']=dirname(__FILE__);}else if(file_exists($_SERVER['DOCUMENT_ROOT']."/core/ini.php") && !empty($_SERVER['DOCUMENT_ROOT'])){define ("SCRIPT_BY_SIRGOFFAN" , $_SERVER['DOCUMENT_ROOT']);}else{die ("NOT_DEFINED_ROOT_DIR");}
define ("SUCCESSPAY" , 1);
error_reporting(0); // вывод ошибок
require_once('ini.php');




if(isset($_POST['currency2'])){
$_paysystem="CoinPayments";	
include_once('success_pay_coinp.php');	
}else

if(isset($_POST['ap_securitycode'])){
$_paysystem="Payza";	
include_once('success_pay_payza.php');	
}else

if(isset($_POST['ac_transfer'])){
$_paysystem="AdvCash";	
include_once('success_pay_advcash.php');	
}else
	
	
	
if(isset($_POST['IT_NIX'])){
$_paysystem="NIX";	
include_once('success_pay_nixmoney.php');	
}else	
	
	
if(isset($_POST['intid'])){
$_paysystem="Free-Kassa";	
include_once('success_pay_freekassa.php');	
}else
if(isset($_POST['order_id']) && isset($_POST['m']) && isset($_POST['amount']) && isset($_POST['from'])){
$_paysystem="OOOPay";
include_once('success_pay_ooopay.php');
}else
if(isset($_POST['PAYMENT_ID']) AND empty($_POST['IT_NIX'])){
$_paysystem="Perfect";	
include_once('success_pay_perfect.php');		
}else{
$_paysystem="Payeer";	
include_once('success_pay_payeer.php');	
}




?>
<?/*-------------------*//*
Script by Sirgoffan
Skype: Sirgoffan
Web-site: php-market.ru
*//*-------------------*/?>