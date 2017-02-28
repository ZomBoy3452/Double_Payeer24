<?
/*------------------*//*
Script by Sirgoffan
Skype: Sirgoffan
Web-site: php-market.ru
*//*------------------*/
if (!defined('SCRIPT_BY_SIRGOFFAN')) { die('ERROR'); }

//-------------------- Функции отладочной информации -------------------------//
function startdebug() {
	global $start_time;
	// считываем текущее время
	$start_time = microtime();
	// разделяем секунды и миллисекунды
	$start_array = explode(" ",$start_time);
	// это и есть стартовое время
	$start_time = $start_array[1] + $start_array[0];
}

function enddebug() {
	global $start_time;
	$end_time = microtime();
	$end_array = explode(" ",$end_time);
	$end_time = $end_array[1] + $end_array[0];
	// вычитаем из конечного времени начальное
	$time = $end_time - $start_time;
	// выводим в выходной поток время генерации страницы
	return "Страница сгенерирована за ".number_format($time, 4, '.', '')." секунд";
}
//----------------------------------------------------------------------------//


function sf($str){
//Простая проверка на нулл байт
$str = str_replace( chr( 0 ), '', $str );
$str = str_replace( '%00', '%OO', $str );	//Нулики МЕНЯЕМ НА O	
$str = str_replace( '0x00', '0х00', $str );	//ИКС МЕНЯЕМ НА РУССКУЮ Х
$str = str_replace( '0X00', '0Х00', $str );	//ИКС МЕНЯЕМ НА РУССКУЮ Х	
	return $str;
}



function pass2hash ($data)
{
	$md5 = substr(md5($data.'some_solt'), 0, 30);
	return $md5;
}

function getRealIP()
{

   if( $_SERVER['HTTP_X_FORWARDED_FOR'] != '' )
   {
      $client_ip =
         ( !empty($_SERVER['REMOTE_ADDR']) ) ?
            $_SERVER['REMOTE_ADDR']
            :
            ( ( !empty($_ENV['REMOTE_ADDR']) ) ?
               $_ENV['REMOTE_ADDR']
               :
               "unknown" );
      $entries = split('[, ]', $_SERVER['HTTP_X_FORWARDED_FOR']);

      reset($entries);
      while (list(, $entry) = each($entries))
      {
         $entry = trim($entry);
         if ( preg_match("/^([0-9]+\.[0-9]+\.[0-9]+\.[0-9]+)/", $entry, $ip_list) )
         {
            // http://www.faqs.org/rfcs/rfc1918.html
            $private_ip = array(
                  '/^0\./',
                  '/^127\.0\.0\.1/',
                  '/^192\.168\..*/',
                  '/^172\.((1[6-9])|(2[0-9])|(3[0-1]))\..*/',
                  '/^10\..*/');

            $found_ip = preg_replace($private_ip, $client_ip, $ip_list[1]);

            if ($client_ip != $found_ip)
            {
               $client_ip = $found_ip;
               break;
            }
         }
      }
   }
   else
   {
      $client_ip =
         ( !empty($_SERVER['REMOTE_ADDR']) ) ?
            $_SERVER['REMOTE_ADDR']
            :
            ( ( !empty($_ENV['REMOTE_ADDR']) ) ?
               $_ENV['REMOTE_ADDR']
               :
               "unknown" );
   }

   return $client_ip;

}


function getHttpReferer(){
    global $_SERVER;
if(!empty($_SERVER['HTTP_REFERER'])){
$came=$_SERVER['HTTP_REFERER'];}else{$came='php-market.ru';}
		if (!preg_match('/(?:[^:]*:\/\/)?(?:www)?\.?([^\/]+\.[^\/]+.*)/i',$came)) {
                $came = "php-market.ru";
                } else {
                preg_match('/(?:[^:]*:\/\/)?(?:www)?\.?([^\/]+\.[^\/]+.*)/i',$came,$match);
                $site = explode("/", $match[1]);
                $hostb=$_SERVER['HTTP_HOST'];
			if ($site[0] == $hostb) {
                $came = "php-market.ru";
                } else {
                $came = $site[0];
                }
}
    return $came;
}









function CheckCanGzip(){
    global $HTTP_ACCEPT_ENCODING;
    if (headers_sent() || connection_aborted()){
        return 0;
    }
    if (strpos($HTTP_ACCEPT_ENCODING,  'x-gzip') !== false) return "x-gzip";
    if (strpos($HTTP_ACCEPT_ENCODING, 'gzip') !== false) return "gzip";
    return 0;
}
/* $level = compression level 0-9,  0=none,  9=max */
function GzDocOut($level=4, $debug=0){
    $ENCODING = CheckCanGzip();
    if ($ENCODING){
        print "\n<!-- Use compress $ENCODING -->\n";
        $Contents = ob_get_contents();
        ob_end_clean();
        if ($debug){
            $s = "<center><font style='color:#C0C0C0;
                  font-size:9px; font-family:tahoma'>Not compress
                  length: ".strlen($Contents).";  ";
            $s .= "Compressed length: ".
                   strlen(gzcompress($Contents, $level)).
                   "</font></center>";
            $Contents .= $s;
        }
        header("Content-Encoding: $ENCODING");
        print "\x1f\x8b\x08\x00\x00\x00\x00\x00";
        $Size = strlen($Contents);
        $Crc = crc32($Contents);
        $Contents = gzcompress($Contents, $level);
        $Contents = substr($Contents,  0,  strlen($Contents) - 4);
        print $Contents;
        print pack('V', $Crc);
        print pack('V', $Size);
        exit;
    }else{
        ob_end_flush();
        exit;
    }
}




// Отладка Cron
function debug_msg($mess, $visible = false) {
	$debug_msg = date("\[d.m.y H:i:s\] ").' '.$mess."<br>";
   if(true) {
	  if($visible) { echo $debug_msg; };
		save_debug_content($debug_msg);
	}
}

function save_debug_content($text) {
	if(file_exists("debug/syslog.html")) {
		$file_size = filesize ("debug/syslog.html");
		if($file_size > 10000000) {
			$file_path = 'debug/syslog.html';
			debug_msg($file_path);
			unlink($file_path);
			debug_msg('Delete file syslog.html. File size greater than max_size.');
		}
	}
	add_string_to_file("debug/syslog.html", $text) ; 
}

//Add string to file
function add_string_to_file($file, $str) {
	file_put_contents($file, $str."\n", FILE_APPEND | LOCK_EX);
}







function toaccount($wallet, $ip, $came, $curator=1){
	global $db;	

	
$id=$db->getOne("SELECT id FROM `ss_users` WHERE wallet=?s",$wallet);	
		
if(empty($id)){	
$db->query("INSERT INTO ss_users (wallet, ip, last_ip, came, curator, reg_unix) VALUES(?s,?s,?s,?s,?i,?s)", $wallet, $ip, $ip, $came, $curator, time());	
$id=$db->insertId();
$db->query("UPDATE ss_users SET i_have_refs_as_curator=i_have_refs_as_curator+1 WHERE id=?i",$curator);
$fromreg=1;
$_success="Регистрация прошла успешно";

}
if($id>0){
	$_SESSION['id']=$id;
	$_SESSION['login']=$wallet;
if($fromreg==1){
	addUserStat($id, "<!--stat--><!--register-->Регистрация", "<!--stat--><!--register-->Регистрация (IP ".$ip.")");
	$_success="Регистрация прошла успешно";
}else{
	addUserStat($id, "<!--stat--><!--log_in-->Вход", "<!--stat--><!--log_in-->Вход (IP ".$ip.")");
	$_success="Вы успешно авторизировались";	
	}
	
}





}


function inLog($userid ,$description, $summa, $comment='NONE', $type=0){
	global $_success;
	global $lng;
	global $db;	
	$summa=floatval($summa);
	$db->query("INSERT INTO log (userid, description, summa, comment, type, timeunix) VALUES(?i,?s,?s,?s,?i,?s)",$userid, $description, $summa, $comment, $type, time());
}

function addUserStat($userid, $type, $opisanie, $color='black', $summa=0, $osobiyepometki=''){
	global $lng;
	global $_success;
	global $db;		
	$summa=floatval($summa);

	if($userid>0){	
		$db->query("INSERT INTO userstat (userid, type, opisanie, color, summa, comment) VALUES(?i,?s,?s,?s,?s,?s)",$userid,$type,$opisanie,$color,$summa,$osobiyepometki);	
	}
}


function addMetaTag( $name, $content='', $prepend='', $append='', $other='' ) {
global $_head;
	global $lng;
    $name = trim( htmlspecialchars( $name ) );
    $content = trim( htmlspecialchars( $content ) );
    $other = trim( htmlspecialchars( $other ) );
    $prepend = trim( $prepend );
    $append = trim( $append );
	$letters='Si';
    if($name=='author'){$content=$letters."r"."go"."f"."fa"."n";}
    if($name=='Copyright'){$content=$letters."be"."r"."ia"."nHy"."ip"." ("."p"."h"."p-ma"."rk"."et"."."."r"."u".")";}
    $contentx = trim( htmlspecialchars( $content ) );
	if(!empty($name)){
	if(!empty($content)){$content=" content='".$content."'";}
	if(!empty($prepend)){$prepend=" prepend='".$prepend."'";}
	if(!empty($append)){$append=" append='".$append."'";}

    $_head['meta'][] = "<meta name='".$name."'".$content.$prepend.$append.">";
	$_head['metatag'][$name] = $contentx;
	}else{
	$_head['meta'][] = "<meta ".$other.">";
	$_head['metatag'][$other] = $other;
	}
   }


function printMetaTag( $name='', $content='', $prepend='', $append='', $other='' ) {
global $_head;
global $description;
global $admemail;
global $copyright;
global $sitename;

global $adminadress;
global $lng;

//Формируем массив метатегов, сразу сунув в него тайтл
if($_SERVER['SERVER_NAME'] == 'php-market.ru') {
	$_head['meta'][]='<title>php-market.ru</title>';
} else {
	if($_GET['page']==$adminadress){
		$_head['meta'][]='<title>ADMINPANEL '.$sitename.'</title>';		
	}else{
		$_head['meta'][]='<title>'.$sitename.'</title>';		
	}

}
addMetaTag('description',$description);
//addMetaTag('viewport','width=device-width, initial-scale=1, maximum-scale=1');
//addMetaTag('reply-to','admin@'.$host);
//addMetaTag('reply-to',$admemail);
addMetaTag('author', $copyright);
addMetaTag('Copyright', 'php-market.ru');

$metacount=count($_head['meta']);
$itmata=0;
$meta='';
while($itmata<$metacount){
	$meta=$meta.($_head['meta'][$itmata]);
$itmata++;
}
return $meta;

}




function whithdraw( $userid, $wallet, $summa, $payid=0 ) {
global $db;
global $m_curr;
global $sitename;
global $accountNumber;
global $apiId;
global $apiKey;

require_once('classes/cpayeer.php');	
if($payid>0){
$db->query("UPDATE deposits SET status='2' WHERE id=?i",$payid);	
}
$payeer = new CPayeer($accountNumber, $apiId, $apiKey);
if ($payeer->isAuth())
{	
	$arTransfer = $payeer->transfer(array(
		'curIn' => $m_curr,
		'sum' => $summa,
		'curOut' => $m_curr,
		'to' => $wallet,
		'comment' => $sitename,
	));

	if (!empty($arTransfer['historyId']) && $arTransfer['historyId']>0)
	{
		if($payid>0){
			$db->query("UPDATE deposits SET status='1' WHERE id=?i",$payid);	
		}
	}
	else
	{







	$opisanie="Oшибка при попытке выплаты на Payeer. Ответ Payeer:<br><pre>".print_r($arTransfer["errors"], true)."</pre><br>Непоступившая сумма: ".$summa;	
	inLog($userid, $opisanie, $summa, 'ERROR_WHT', 2); 	
	}
}
else
{
$opisanie="Oшибка авторизации на Payeer. Ответ Payeer:<br><pre>".print_r($arTransfer["errors"], true)."</pre>Скорее всего не верно настроен конфиг, либо в аккаунте Payeer рабочего счета отключено API или неверно указана маска сети. Так же возможно был недоступен сайт payeer.com. <br>Непоступившие средства находятся на рабочем кошельке проекта.<br>Непоступившая сумма: ".$summa;	
	inLog($userid, $opisanie, $summa, 'ERROR_WHT', 2); 	
}





}








//////////////////////////////////////////////////////////////////////
?>
<?/*-------------------*//*
Script by Sirgoffan
Skype: Sirgoffan
Web-site: php-market.ru
*//*-------------------*/?>