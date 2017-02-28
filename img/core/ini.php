<?
/*------------------*//*
Script by Sirgoffan
Skype: Sirgoffan
Web-site: php-market.ru
*//*------------------*/



/* ВКЛЮЧАЕМ КЕШИРОВАНИЕ */
header("Cache-control: public");

header("Expires: " . gmdate("D, d M Y H:i:s", time() + 60*60*24*30) . " GMT");

/* ПРОВЕРЯЕМ, ВКЛЮЧЕНО ЛИ GZIP И, В ЗАВИСИМОСТИ, ОТ ОТВЕТА ВЫБИРАЕМ ТИП СЖАТИЯ */

if(isset($_SERVER['HTTP_ACCEPT_ENCODING']) && substr_count($_SERVER['HTTP_ACCEPT_ENCODING'], 'gzip'))
{
	if(!ob_start("ob_gzhandler")){ob_start();$gzipoff=1;}else{$gzipoff=0;}
}else{
ob_start();
ob_implicit_flush(0); 
$gzipoff=1;
} 

if(!defined('SCRIPT_BY_SIRGOFFAN')){
echo ('Выявлена попытка взлома!');
exit();
}

$page='main';$id=NULL;$login=NULL;$notpl=0;$alttpl=0;$itsmain=0;$nohead=0;$nofoot=0;$alttpl=0;$copyright='Sirgoffan';$tarif=2;

/* ПОДКЛЮЧАЕМ КЛАСС РАБОТЫ С БД */
require_once(SCRIPT_BY_SIRGOFFAN.'/core/classes/safemysql.php');

/* ПОДКЛЮЧАЕМ ФАЙЛ НАСТРОЕК */
require_once(SCRIPT_BY_SIRGOFFAN.'/core/config.php');

		if (($_SERVER['HTTP_X_FORWARDED_PROTO']=='http') and $http_s == 'https' ) {
           $redirect_url = "https://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
           header("Location: $redirect_url");
           exit();
       }
	   
$arrayconst=get_defined_constants(true);
$host=$_SERVER["HTTP_HOST"]; 
$copyright='Sirgoffan';

/* ПОДКЛЮЧАЕМ ФУНКЦИИ */
require_once(SCRIPT_BY_SIRGOFFAN."/core/functions.php");
/* ПОДКЛЮЧАЕМ */
require_once(SCRIPT_BY_SIRGOFFAN.'/core/defines.php');
/* ПОДКЛЮЧАЕМ ФАЙЛЫ КЕША */
require_once(SCRIPT_BY_SIRGOFFAN.'/core/cache.php');
/* ПОДКЛЮЧАЕМ ОБРАБОТЧИК */
require_once(SCRIPT_BY_SIRGOFFAN.'/core/handler.php');

?>