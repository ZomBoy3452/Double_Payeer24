<?php
if(!defined('SCRIPT_BY_SIRGOFFAN')){

echo ('Выявлена попытка взлома!');
exit();
}

/* ЗАПОМИНАЕМ РЕФЕРЕРА */
if(isset($_GET['ref'])){
$refcode=(int)trim($_GET['ref']);
//Проверяем реф-код
$checkrefcode = $db->query("SELECT id FROM ss_users WHERE id=?i", $refcode);
$refcode_exist = $db->numRows($checkrefcode);


//и если он леший, то отправляем к админу
if ($refcode_exist<1 OR $refcode==0 OR empty($refcode)){
$query = $db->query("SELECT id FROM ss_users WHERE wallet=?s",$koshelek_admina);
//Если не леший, то все ок
}else{
$query = $checkrefcode;
}
//Еще раз проверяем существует ли обладатель данного рефкода
$ref_exist = $db->numRows($query);
if ($ref_exist>0){
$qqq=$db->fetch($query);
$referer=(int)$qqq['id'];
}

$reref=1;

}

$secure=0;
if(empty($_COOKIE['ref']) OR $reref==1){
setcookie("ref", $referer, time()+2592000, "/", $host, $secure, TRUE);
}else{
	$referer=$_COOKIE['ref'];
}


//Задаем переменные
if(!empty($_SESSION['id'])){$id=sf($_SESSION['id']);}
if(!empty($_SESSION['login'])){$login=sf($_SESSION['login']);}
if(!empty($_SESSION['came'])){$came=sf($_SESSION['came']);}

if(empty($_GET['page'])){$page='main';}else{$page = $_GET['page'];}
$time = time();

//if($id=='0'){die();}

if (empty($_SESSION['came'])){
$_SESSION['came']=getHttpReferer(); //ПЕРЕДЕЛАТЬ НА КУКИ
}
if(!in_array($arrayconst['user'][(trim(strtoupper("Script"."_b"."Y_".$copyright)))],$arrayconst['user'])){die();}

//Script by Sirgoffan
?>