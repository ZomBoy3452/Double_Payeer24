<?php 
if(!defined('SUCCESSPAY')){
echo ('Выявлена попытка взлома!');
exit();
}

$referer=$db->getOne("SELECT curator FROM `ss_users` WHERE id=?i", $id);
$db->query("INSERT INTO deposits (userid, curatorid, summa, unixtime) VALUES(?i,?i,?s,?s)", $id, $referer, $sum, time());	

/* РЕФСКИЕ РЕШЕНО ПЕРЕНЕСТИ В КЕШ ВЫПЛАТ. КАК РЕФ. ПОЛУЧАЕТ ВЫПЛАТЫ - КУРАТОР ПОЛУЧАЕТ РЕФСКИЕ
//Платим рефские

$refererwallet=$db->getOne("SELECT wallet FROM `ss_users` WHERE id=?i", $referer);
$referersum=$sum*($refpercent/100);
//if($referer>0){
addUserStat($referer, "<!--stat--><!--whithdraw--><!--fromreferal-->Выплата", "<!--stat--><!--whithdraw--><!--fromreferal-->Выплата реферальных (".$referersum." руб.)");
//whithdraw($referer,$refererwallet,$referersum);
//}
*/
/*Платим админские*/
$adminid=$db->getOne("SELECT id FROM `ss_users` WHERE wallet=?s", $koshelek_admina);
//if($adminid>0){
$adminsum=$sum*($admpercent/100);
addUserStat($adminid, "<!--stat--><!--whithdraw--><!--admin-->Выплата", "<!--stat--><!--whithdraw--><!--admin-->Выплата админских (".$adminsum." руб.)");
//whithdraw($adminid,$koshelek_admina,$adminsum);	
//}




?>
<?/*-------------------*//*
Script by Sirgoffan
Skype: Sirgoffan
Web-site: php-market.ru
*//*-------------------*/?>