<?php
if($_GET['e']==1){
if($itworks>0){
	echo "<font color='green'>КОНФИГ ПРИИНКЛЮДЕН =)</font><BR>";
}else{
		echo "<font color='red'>КОНФИГ не ПРИИНКЛЮДЕН =(</font><BR>";
}
}

 if (isset($_POST['token'])){
session_start();
define ("SCRIPT_BY_SIRGOFFAN" , "ajax");
error_reporting(0); // вывод ошибок
/*require('config.php'); // конфиг
include('cache_stat.php');
include('functions.php');
include('techvars.php');
include('defines.php');*/
include_once('config.php');
include_once('sql_security.php');
include_once('techvars.php');
include_once('functions.php');
include_once('langvars.php');
include_once('defines.php');
include_once('cache_stat.php');

if(!empty($_SESSION['id'])){
echo "autherr1";	
	exit();
}
$mysqli = new mysqli($bd_host, $bd_user, $bd_password, $bd_base);
mysqli_set_charset ($mysqli, "utf8");

if (mysqli_connect_errno()) {
//    printf("Не удалось подключиться: %s\n", mysqli_connect_error());
 printf("Не удалось подключиться");
    exit();
	
}	
	


        $token = $_POST['token'];

        $result = false;

        //проверяем, доступна ли функция file_get_contents. она необходима для получения данных
        if (function_exists('file_get_contents') && ini_get('allow_url_fopen')) {
			$result = file_get_contents('http://ulogin.ru/token.php?token=' . $token .
			'&host=' . $_SERVER['HTTP_HOST']);
			//если недоступна file_get_contents, пробуем использовать curl
        } elseif (in_array('curl', get_loaded_extensions())) {
			$request = curl_init('http://ulogin.ru/token.php?token=' . $token . '&host=' . $_SERVER['HTTP_HOST']);
			curl_setopt($request, CURLOPT_RETURNTRANSFER, 1);
			$result = curl_exec($request);
        }

        $data = $result ? json_decode($result, true) : array();

        //проверяем, чтобы в ответе были данные, и не было ошибки
        if (!empty($data) and !isset($data['error'])){

        $id = 0;

        //проверяем, существует ли такой пользователь в базе
        if($q = $mysqli->query("SELECT user_id, seed, email, ident, avatarka FROM ulogin where ident='{$data['identity']}'")) {
			$user = $q->fetch_assoc();
			if(!$q = $mysqli->query("SELECT id FROM ss_users where id='{$user['user_id']}'")) {
				$mysqli->query("DELETE from ulogin where ident='{$data['identity']}'");
			} else {
			$id = $user['user_id'];
			}
        }

        //добавляем нового пользователя
        if(!$id){

        //генерируем соль
        $seed = sha1(mt_rand());
        //генерируем хеш пароля. паролем служит строка $data['identity'].$seed
        $password = md5($data['identity'].$seed);

		
$city=sf($data['city']);
$country=sf($data['country']);
$email=sf($data['email']);
$first_name=sf($data['first_name']);
$last_name=sf($data['last_name']);
$ava=sf($data['photo']);
$profile=sf($data['profile']);
$sex=(int)$data['sex'];


//$login=$first_name." ".$last_name;
$login=sf($data['uid']);

$ip=getRealIP();
//$came=sf($_GET['came']);
//$curator=(int)$_GET['referer'];	
			
$came=sf($_COOKIE ['came']);
$curator=(int)$_COOKIE ['ref'];
			
$download_ava=download_ava($ava, 'avatars');
	


$refcodex=rand(10000000, 999999999);
$check = mysql_query("SELECT id, refcode FROM ss_users WHERE refcode = '$refcodex'");
$exist = mysql_num_rows($check);

while($exist==1){
$refcodex=rand(10000000, 999999999);
$check = mysql_query("SELECT id, refcode FROM ss_users WHERE refcode = '$refcodex'");
$exist = mysql_num_rows($check);
}




	
        //добавляем пользователя в таблицу ss_users сайта и получаем id новой записи
 /*       if($q = $mysqli->query("INSERT INTO ss_users (imya, familiya, password, email, city, country, profile, sex, login, ip, came, curator, refcode)
        
VALUES ('{$data['first_name']}','{$data['last_name']}','$password','{$data['email']}','$city','$country','$profile','$sex','$login','$ip','$came','$curator','$refcodex')")){
	
*/	


$login="#".$login;
$dataemail="#".$data['email'];




	$query = mysql_query("SELECT curator FROM ss_users WHERE id = '".$curator."'");
	$www=mysql_fetch_array($query);
	$curator2=$www['curator'];

if($q = $mysqli->query("INSERT INTO ss_users (imya, familiya, password, email, profile, sex, login, ip, came, curator, refcode, ava)       
VALUES ('{$data['first_name']}','{$data['last_name']}','$password','$dataemail','$profile','$sex','$login','$ip','$came','$curator','$refcodex','$download_ava')")){
        $id = $mysqli->insert_id;

if($q = $mysqli->query("INSERT INTO ulogin (user_id, ident, email, avatarka, seed)
        
VALUES ('$id','{$data['identity']}','{$data['email']}','$download_ava','$seed')")){

        //подготовим юзера к авторизации
 		$user = array(
			'ident'     => $data['identity'],
			'email'     => $data['email'],
			'first_name' => $first_name,
			'seed'      => $seed,
			'user_id'   => $id,	
			'avatarka' => $download_ava		
		);
        }
        }

		
//Добавляем куратору рефа в личники
mysql_query("UPDATE ss_users SET i_have_refs_as_curator=i_have_refs_as_curator+1 WHERE id='".$curator."'");
//И в "всего рефов"		
mysql_query("UPDATE ss_users SET i_have_refs_all=i_have_refs_all+1 WHERE id='".$curator."'");		



//Во второй уровень тоже.
	mysql_query("UPDATE `ss_users` SET i_have_refs_all=i_have_refs_all+1 WHERE id='".$curator2."'");












		
		
$user['agree'] = 0;		
		
        }
        $user['agree_text'] = $agree_text;
        $user['first_name'] = $data['first_name'];
        $user['avatarka'] = $user['avatarka'];
        //проводим авторизацию пользователя штатными средствами своего сайта
        //паролем в данном примере служит строка $user['ident'].$user['seed']	
		$user['money'] = loginFunction($user);
		$user['token'] = $_SESSION['token'] = md5(uniqid(mt_rand() . microtime()));
        }
		
$out_json = $user;
		
		
        //отправляем пользователя после авторизации в корень сайта (либо, при необходимости, на любую другую страницу)
   //     header('Location: /');
}else

if(isset($_POST['ajax_do'])){
//AJAX как страница (используется для обработки форм, аналог файла deystviya, но на аяксе, ajax_do)	
if(isset($_POST['ajax_do']) && $_POST['ajax_do']=='login'){
if(!defined('SCRIPT_BY_SIRGOFFAN')){
echo ('Выявлена попытка взлома!');
exit();
}

if($use_kapcha==1){
  if ( !empty($_POST['capcha']) )
  {
    $code = sf($_POST['capcha']); //Получаем переданную капчу

	/*if (isset($_SESSION['capcha_ajax'])) { addProblem(0, 0, mb_strtoupper($_SESSION['capcha_ajax'], 'UTF-8').' == '.mb_strtoupper($code, 'UTF-8')); }*/

    if ( isset($_SESSION['capcha_ajax']) && mb_strtoupper($_SESSION['capcha_ajax'],'UTF-8') == mb_strtoupper($code,'UTF-8') ){ //сравниваем введенную капчу с сохраненной в переменной в сессии
	//Верно, скрипт регистрации не останавливается
     $stopit=0;
	  }
    else{
	$_error="Код с картинки введён не верно!";
$_error=printlng("De ingevoerde tekst uit de afbeelding is onjuist!","The text entered from the image is incorrect!","Код с картинки введён не верно!","","","",$lng);
	//Не верно, скрипт регистрации следует остановить
     $stopit=1;
	}
  }else{
	$_error="Вы не ввели код с картинки!";
$_error=printlng("U heeft de tekst uit de afbeelding niet ingevoerd!","You did not enter the text from the image!","Вы не ввели код с картинки!","","","",$lng);
	//Не верно, скрипт регистрации следует остановить
     $stopit=1;
  }
    //Удаляем капчу из сессии
    unset($_SESSION['capcha_ajax']);
}
	if($use_kapcha==0){$stopit=0;}

//Чтобы убрать лишние запросы в БД смотрим введена ли капча верно:
if($stopit!=1){
//Фильтруем пост с логином
$_POST_email=trim(sf($_POST['email']));
//Проверяем логин на занятость
$checklogin = mysql_query("SELECT id FROM ss_users WHERE email='$_POST_email'");
$login_exist = mysql_num_rows($checklogin);


//Проверяем не пуст ли он
if(empty($_POST_email)){$_error="Вы не ввели email";}else

//Проверяем @
$pieces = explode("@", $_POST_email);
if(!empty($pieces[2])){
$_error="Введите корректную почту!";
$_error=printlng("Geef het juiste e-mail adres in!","Enter the correct e-mail!","Введите корректную почту!","","","",$lng);	
}else
if(empty($pieces[1])){
$_error="Вы ввели логин вместо почты, введите Вашу почту.";
$_error=printlng("U heeft de gebruikersnaam ingevoerd in plaats van de e-mail. Vul uw e-mail in.","You entered the username instead of the e-mail. Enter your e-mail.","Вы ввели логин вместо почты, введите Вашу почту.","","","",$lng);
}else


if ($login_exist<1){$_error="Указанный пользователь не зарегистрирован<br>(проверьте правильность почты)";
$_error=printlng("Deze gebruiker is niet geregistreerd<br>(controleer de geldigheid van het e-mail adres)","This user is not registered<br>(check the e-mail’s validity)","Указанный пользователь не зарегистрирован<br>(проверьте правильность почты)","","","",$lng);
}

//Фильтруем посты с паролями
$_POST_pass=sf($_POST['pass']);
//Генерируем хеш
$_POST_password=pass2hash($_POST_pass);
//Проверяем его на валидность
$checkloginandpass = mysql_query("SELECT id FROM ss_users WHERE email='$_POST_email' AND password='$_POST_password'");
$loginandpass_exist = mysql_num_rows($checkloginandpass);
if ($loginandpass_exist<1){
	if(empty($_error)){
	$_error="Не верно введен пароль";
$_error=printlng("Het door u ingevoerde wachtwoord is onjuist.","The password you entered is incorrect.","Не верно введен пароль","","","",$lng);	
	}

}
}
/*$_POST_ip=getRealIP();
if($_POST_ip=='85.26.234.164'){
$_error="Не верно введен пароль";
if($lng==='en'){$_error="Incorrect password";}
}*/

//Если нет ни одной ошибки, входим
if(empty($_error)){
$_POST_password=pass2hash($_POST_pass);

login($_POST_email, $_POST_password, $_POST_ip);
$notpl=1;
$otvet=1; //Все норм, редиректим в кабинет

}else{
$otvet=$_error;	//Ошибка. Текст
	
}
echo $otvet;
}else
/*##// ОТПРАВКА ЗАПРОСА НА ВОССТАНОВЛЕНИЕ ПАРОЛЯ //##*/
if(isset($_POST['ajax_do']) && $_POST['ajax_do']=='forgotpass'){
    
$restoremail=trim(sf($_POST['mail']));
	if(empty($restoremail))
	{
		$_error = "Ошибка! Укажите Ваш контактный E-Mail!";
$_error=printlng("Fout! Vul uw contact e-mail in!","Error! Enter your contact e-mail!","Ошибка! Укажите Ваш контактный E-Mail!","","","",$lng);			
	}

$result=mysql_query("select id, restorecode, restore_last_time, restore_ones from ss_users WHERE email='".$restoremail."'");
$check=mysql_fetch_array($result);
$restorecode=$check['restorecode'];
$restore_last_time=$check['restore_last_time'];
$restore_ones=$check['restore_ones'];
$userid=$check['id'];


if(($restorecode!=0 AND !empty($restorecode)) AND ($restore_ones>=2 AND $restore_last_time>time() ))	{
$_error = "Инструкции уже были отправлены на Ваш Email<br>Проверьте папку \"спам\"";

$_error=printlng("Instructies zijn reeds verzonden naar uw e-mail adres <br> Controleer uw ”spam” folder ","Instructions have already been sent to your e-mail<br> Check your ”spam” folder ","Инструкции уже были отправлены на Ваш Email<br>Проверьте папку ”спам” ","","","",$lng);

	
}




//Проверяем не пуст ли он
if(empty($restoremail)){
	$_error="Вы не ввели email";
$_error=printlng("U heeft uw e-mail niet ingevoerd!","You did not enter your e-mail!","Вы не ввели email","","","",$lng);	
	}else

//Проверяем @
$pieces = explode("@", $restoremail);
if(!empty($pieces[2])){
$_error="Введите корректную почту!";
$_error=printlng("Geef het juiste e-mail adres in!","Enter the correct e-mail!","Введите корректную почту!","","","",$lng);
}else
if(empty($pieces[1])){
$_error="Вы ввели логин вместо почты, введите Вашу почту.";
$_error=printlng("U heeft uw gebruikersnaam ingevoerd in plaats van uw e-mail. Vul uw e-mail in.","You entered your username instead of your e-mail. Enter your e-mail.","Вы ввели логин вместо почты, введите Вашу почту.","","","",$lng);
}else

	
$checklogin = mysql_query("SELECT id FROM ss_users WHERE email='$restoremail'");
$login_exist = mysql_num_rows($checklogin);
if ($login_exist<1){
	$_error="Указанный пользователь не зарегистрирован<br>(проверьте правильность почты)";
$_error=printlng("Deze gebruiker is niet geregistreerd <br> (controleer de geldigheid van de e-mail)","This user is not registered<br>(check the e-mail’s validity)","Указанный пользователь не зарегистрирован<br>(проверьте правильность почты)","","","",$lng);
}



//Если нет ни одной ошибки
if(empty($_error)){
$gencode=rand(111111,999999);
mysql_query("UPDATE `ss_users` SET `restorecode` = '$gencode', restore_ones=restore_ones+1, restore_last_time='".(time()+(60*60*24))."' WHERE email='$restoremail'");
	// $secretlinkk="".$http_s."://".$host."/?page=forgot&secretcode=".$gencode."&email=".$restoremail."&newpass";
	$secretlinkk = "$http_s://$host/?page=forgot&secretcode=$gencode&email=$restoremail&newpass";

	$subject = "Восстановление пароля в ".$sitename;
$subject=printlng("Wachtwoord herstellen over ".$sitename,"Password restore in ".$sitename,"Восстановление пароля в ".$sitename,"","","",$lng);	

	//$message = 'Ваш код восстановления: '.$gencode.'<br>Или используйте ссылку: '.$secretlinkk.' ';
	$message = 'Ваш код восстановления: '.$gencode.'';
$message=printlng("Uw herstel code: ".$gencode,"Your restore code: ".$gencode,"Ваш код восстановления: ".$gencode,"","","",$lng);

$mailresult = sendmail($restoremail, $subject, $message);
if($lng==='en'){$mailresult = sendmail($restoremail, $subject, $message);}



//Этот текст можно вывести на экран, если пришло ОК:
//	$_success="<br>".$infstart_ok."Дальнейшие инструкции отправлены Вам на почту".$infend_ok;
//if($lng==='en'){$_success="Further instructions have been sent to your email";}
$otvet=1; //Все норм, редиректим в кабинет




}else{

$otvet=$_error; //Все норм, редиректим в кабинет	
}

echo $otvet;

}else
/*##// ВОССТАНОВЛЕНИЕ ПАРОЛЯ (ШАГ 2)//##*/
if(isset($_POST['ajax_do']) && $_POST['ajax_do']=='forgotpassstep2'){

if(empty($_POST['newpass'])){
	$_error = "Вы не ввели пароль!";
$_error=printlng("U heeft uw wachtwoord niet ingevoerd!","You did not enter your password!","Вы не ввели пароль!","","","",$lng);
}
if(empty($_POST['cnewpass'])){
	$_error = "Вы не ввели пароль!";
$_error=printlng("U heeft uw wachtwoord niet ingevoerd!","You did not enter your password!","Вы не ввели пароль!","","","",$lng);
}
$___code=(int)$_GET['secretcode'];

if(!isset($_POST['restoremail'])){
	$_error = "Ошибка! Неверный запрос!";
$_error=printlng("Fout! Ongeldig verzoek!","Error! Invalid request!","Ошибка! Неверный запрос!","","","",$lng);
}

if($_POST['newpass']!=$_POST['cnewpass']){
	$_error = "Пароли не совпадают";
$_error=printlng("Wachtwoorden komen niet overeen","Passwords do not match","Пароли не совпадают","","","",$lng);
}

$newwpass=$_POST['newpass'];
$newpasswordd=pass2hash($newwpass);

$restoredmail=sf($_POST['restoremail']);
$restorecode=sf($_POST['code']);

$result=mysql_query("select id from ss_users WHERE restorecode='".$restorecode."' AND email='".$restoredmail."' AND  restorecode!='0'");

$code_exist = mysql_num_rows($result);
	 if ($code_exist<1){
		$_error="<br>".$infstart_err."Неверный код".$infend_err;
		$_error=printlng("Foute code","Incorrect code","Неверный код","","","",$lng);
	 }



//Если нет ни одной ошибки
if(empty($_error)){
	mysql_query("UPDATE `ss_users` SET `restorecode` = 0 WHERE email='$restoredmail'");
	mysql_query("UPDATE `ss_users` SET `password` = '$newpasswordd' WHERE email='$restoredmail'");

$_t=printlng("Herstellen","Restore","Восстановление","","","",$lng);	
$_d=printlng("Wachtwoord herstellen. Wachtwoord is gewijzigd.","Password restore. Password has been changed.","Восстановление пароля. Пароль изменен","","","",$lng);		
addUserStat($id, $_t, $_d);

	$_success="<br>".$infstart_ok."Пароль изменен!<br>Вы можете войти, используя новые данные".$infend_ok;
$_success=printlng("Wachtwoord is gewijzigd! <br> U kunt inloggen met uw nieuwe informatie.","Password has been changed! <br> You can log in using your new information","Пароль изменен!<br>Вы можете войти, используя новые данные","","","",$lng);
$otvet=1;		
}else{

$otvet=$_error; //Все норм, редиректим в кабинет	
}

echo $otvet;
}
}else


///////////
//Вывод сообщений
if(isset($_POST['sid'])){
session_start();
define ("SCRIPT_BY_SIRGOFFAN" , "ajax");
error_reporting(0); // вывод ошибок
/*require('config.php'); // конфиг
include('cache_stat.php');
include('functions.php');
include('techvars.php');
include('defines.php');
*/

include_once('config.php');
include_once('sql_security.php');
include_once('techvars.php');
include_once('functions.php');
include_once('langvars.php');
include_once('defines.php');
include_once('cache_stat.php');

if(session_id() != $_POST['sid']) die('Wrong Request');

$dialog=(int)$_POST['dialog'];


//Задаем $id (id текущего юзера)
$id=(int)$_SESSION['id'];
if($id<1) {die('Wrong Request');}


$secrethash=$_POST['secrethash'];
$secrethashadmin=md5($adminadress.$admintoken.$sitename.$description.$bd_base);


if($secrethash==$secrethashadmin){$id=1;}



//Берем все сообщухи и выводим на экран
$query = mysql_query("SELECT * FROM `messages` WHERE (collocutor_id='$id' OR author_id='$id') AND dialog_id='".$dialog."' ORDER BY id DESC");
while($qqq=mysql_fetch_array($query)){
$mid=$qqq['id'];
$dialog_id=$qqq['dialog_id'];	
$author_id=$qqq['author_id'];
$collocutor_id=$qqq['collocutor_id'];
$mess=$qqq['mess'];

$mess = stripslashes($mess);
$mess = nl2br($mess);

$postunix=$qqq['postunix'];

$collocutorst=$qqq['collocutorst'];
$authorst=$qqq['authorst'];


$thismess='';
if($author_id==$id){	
	$mmmmmmmmm=$collocutor_id;	
	$authorstP=1;
	if($authorst==0){
		$thismess='<span style="color:red;">NEW</span>';
		mysql_query("UPDATE `messages` SET `authorst` = '1' WHERE id='$mid'");
		mysql_query("UPDATE `dialogs` SET `person1st` = '1' WHERE id='$dialog_id' AND person1='".$id."'");mysql_query("UPDATE `dialogs` SET `person2st` = '1' WHERE id='$dialog_id' AND person2='".$id."'");	
	}	
	$suniversalname="You";
}else{
	$mmmmmmmmm=$author_id;	
	$collocutorstP=1;
	if($collocutorst==0){	
		$thismess='<span style="color:red;">NEW</span>';
		mysql_query("UPDATE `messages` SET `collocutorst` = '1' WHERE id='$mid'");	
		mysql_query("UPDATE `dialogs` SET `person1st` = '1' WHERE id='$dialog_id' AND person1='".$id."'");mysql_query("UPDATE `dialogs` SET `person2st` = '1' WHERE id='$dialog_id' AND person2='".$id."'");		
	}
	
	//Определяем данные собеседника
	$queryzz = mysql_query("SELECT imya, familiya, login FROM `ss_users` WHERE id = '$mmmmmmmmm'");			
	$qqqzz=mysql_fetch_array($queryzz);

	$slogin=$qqqzz['login'];
	$sfamiliya=$qqqzz['familiya'];
	$simya=$qqqzz['imya'];

	if(!empty($sfamiliya) OR !empty($simya)){
		$suniversalname=$sfamiliya." ".$simya;	
	}else{
		$suniversalname=$slogin;
	}	
		
}



?>                

<hr>
    <?=printlng("Datum","Date","Сообщение отправлено","","","",$lng);?>: <?=date("Y.m.d H:i:s",$postunix)?><br>
    <?=printlng("Auteur","Autor","Автор сообщения","","","",$lng);?>: <?=$suniversalname?> <?=$thismess?><br>
	<?=printlng("Bericht","Message","Сообщение","","","",$lng);?>: <?=$suniversalname?> <?=$thismess?>: <?=$mess?><br>
					
					
					
					
					
<?}







}else{










//Прочие функции AJAX
session_start();
define ("SCRIPT_BY_SIRGOFFAN" , 1);
error_reporting(0); // вывод ошибок
include_once('config.php'); // конфиг
include_once('cache_stat.php');

/* Автообновление. Последние регистрации */
if(isset($_GET['regs'])){
	echo $_last_regs_table_li;
}else
/* Динамический поиск (в админке) */
if(isset($_GET['search'])){

function filterr($str){
 return trim(mysql_real_escape_string(strip_tags(htmlspecialchars($str)))); 
}

$search = filterr($_POST['search']);
	if($search == ''){
		exit("<br>");
	}
	$i=0;
	$query = mysql_query("SELECT * FROM ss_users WHERE login LIKE '".$search."%'");
	$mysql_num_rows_query=mysql_num_rows($query);
	if($mysql_num_rows_query > 0){
		$sql = mysql_fetch_array($query);
		do{
			if($i<5){
			if($i!=4 && $i!=($mysql_num_rows_query-1)){$sep=',';}else{$sep='';}
				if(($sql['act_1']+$sql['act_1_t2']+$sql['act_1_t3'])>=1){
					$colr='green';
				}else{$colr='red';}
				echo "<a href='/?page=promo&referal=".$sql['id']."' target='_blank'><font color='".$colr."'>".$sql['login']."</font></a>".$sep." ";
			}
			$i++;
		}while($sql = mysql_fetch_array($query));
		$ii=$i-5;
		if($ii>0){
			echo "AND ".$ii."...";
		}
	}else{
		echo "NO_RESULT";
	}
	 
}
else{
echo "AJAX_ERROR";		
exit;
}


}

















/*-------------------*//*
Script by Sirgoffan
Skype: Sirgoffan
Web-site: php-market.ru
*//*-------------------*/?>