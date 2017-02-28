<?

if(file_exists(dirname(__FILE__)."/core/ini.php")){
define ("SCRIPT_BY_SIRGOFFAN" , dirname(__FILE__) );
$_SERVER['DOCUMENT_ROOT']=dirname(__FILE__);}
else if(file_exists($_SERVER['DOCUMENT_ROOT']."/core/ini.php") && !empty($_SERVER['DOCUMENT_ROOT'])){define ("SCRIPT_BY_SIRGOFFAN" , $_SERVER['DOCUMENT_ROOT']);}else{die ("NOT_DEFINED_ROOT_DIR");}
define ("CRON" , 1);
error_reporting(0); // вывод ошибок
if(empty($nocron)){
require_once('ini.php');
$nocron=1;
}



if($nocron==1) 
{
	
$mintime=time()-(60*60*$depperiod);
$ocherr=$db->getRow("SELECT * FROM deposits WHERE status='0' AND unixtime<?s ORDER BY id ASC LIMIT 1",$mintime);

if($ocherr['id']>0){

if($ocherr['status']!=2){

$wallet=$db->getOne("SELECT wallet FROM ss_users WHERE id=?i", $ocherr['userid']);		
$psumma=$ocherr['summa']+($ocherr['summa']*($percent_u/100));



whithdraw( $ocherr['userid'], $wallet, $psumma, $ocherr['id'] );
addUserStat($ocherr['userid'], "<!--stat--><!--whithdraw--><!--fromdeposit-->Выплата", "<!--stat--><!--whithdraw--><!--fromdeposit-->Выплата по депозиту (".$psumma." руб.)");


//Затем рефские.
$referer=$db->getOne("SELECT curator FROM `ss_users` WHERE id=?i", $ocherr['userid']);	
$refererwallet=strtoupper($db->getOne("SELECT wallet FROM `ss_users` WHERE id=?i", $referer));
$referersum=$ocherr['summa']*($refpercent/100);
if($referer>0 && $refererwallet[0]=='P'){
whithdraw($referer,$refererwallet,$referersum);		
addUserStat($referer, "<!--stat--><!--whithdraw--><!--fromreferal-->Выплата", "<!--stat--><!--whithdraw--><!--fromreferal-->Выплата реферальных (".$referersum." руб.)");
}



}
}


}


?>

<?/*-------------------*//*
Script by Sirgoffan
Skype: Sirgoffan
Web-site: php-market.ru
*//*-------------------*/?>