<?

if(!defined('SCRIPT_BY_SIRGOFFAN')){
exit();
}

require_once($_SERVER['DOCUMENT_ROOT'].'/core/cache_stat.php');

/*КЕШ ДЛЯ СТАТИСТИКИ*/
if($lastupd_stat+10<time()) //10 секунд - через какой промежуток времени следует обновлять кеш
{
$lastupd_stat=time();	
$content_stats = "<?\n
\$lastupd_stat = \"{$lastupd_stat}\";\n
?>";


$nocron=1;
include_once('cron.php');


$lastupd_stat=time();	
$content_stats = "<?\n
\$lastupd_stat = \"{$lastupd_stat}\";\n
?>";

$fstats = @fopen($_SERVER['DOCUMENT_ROOT']."/core/cache_stat.php","w+");
@fwrite($fstats,$content_stats);
@fclose($fstats);
}




?>

<?/*-------------------*//*
Script by Sirgoffan
Skype: Sirgoffan
Web-site: php-market.ru
*//*-------------------*/?>