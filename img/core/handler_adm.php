<?

if(!defined("ADMIN_SIBHYIP_".$admintoken)){
exit();
}

/*##// ИЗ АДМИНКИ //##*/
unset($_error);

//АНТИПОВТОРЯЛКА ПРИ ОБНОВЛЕНИИ СТРАНИЦЫ (при обновлении страницы, запрос не отправится повторно)
if($_REQUEST['antipovtor_adm']!=$_SESSION['antipovtor_adm'] OR !isset($_REQUEST['antipovtor_adm'])){
	
$_SESSION['antipovtor_adm']=$_REQUEST['antipovtor_adm'];

//Защита от CSFR
if(empty($_POST['admintoken'])){$_error='Токен отсутствует. Попробуйте снова.';}
//Токен админа меняется 1 раз в 24 часа
if(isset($_POST['admintoken']) AND $_POST['admintoken']!=md5($admintoken.$adminname.date('d.m.Y'))){
	$_error='Неверный токен. Попробуйте снова.';
}

//
if($id=='0' OR $id<0){
	?>
	<script type="text/javascript">
	location.replace("/?page=exit");
	</script>
	<noscript>
	<meta http-equiv="refresh" content="0; url=/?page=exit">
	</noscript>
<?	
	exit();
}

//Проверяем, что пользователь действительно админ
if(!empty($id)){


if($_POST['do']=='repay'){
	
$db->query("UPDATE deposits SET status='0' WHERE status=?i",2);	
echo 	"UPDATE deposits SET status='0' WHERE status=?i";
}


}//Закрытие проверки на логин админа
}//Закрытие "антиповторялки"
?>
<?/*-------------------*//*
Script by Sirgoffan
Skype: Sirgoffan
Web-site: php-market.ru
*//*-------------------*/?>