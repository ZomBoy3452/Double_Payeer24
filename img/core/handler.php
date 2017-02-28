<?
if(!defined('SCRIPT_BY_SIRGOFFAN')){
exit();
}

unset($_error);
//АНТИПОВТОРЯЛКА ПРИ ОБНОВЛЕНИИ СТРАНИЦЫ (при обновлении страницы, запрос не отправится повторно)
if($_REQUEST['antipovtor']!=$_SESSION['antipovtor'] OR !isset($_REQUEST['antipovtor'])){	
$_SESSION['antipovtor']=$_REQUEST['antipovtor'];

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

/*##// РЕГИСТРАЦИЯ - REGISTER do=reg //##*/

if(isset($_POST['do']) && $_POST['do']=='toaccount' && $itworks==1){
	
$stopit=0;
if($use_kapcha==1){
  if ( !empty($_POST['capcha']) )
  {
    $code = $_POST['capcha']; //Получаем переданную капчу

    if ( isset($_SESSION['capcha']) && strtoupper($_SESSION['capcha']) == strtoupper($code) ){ //сравниваем введенную капчу с сохраненной в переменной в сессии
	//Верно, скрипт регистрации не останавливается
     $stopit=0;
	  }
    else{
		if(empty($_SESSION['capcha'])){
	$_error="Непредвиденная ошибка. Возможно, у Вас отключены COOKIE";	

	//Не верно, скрипт регистрации следует остановить
     $stopit=1;
		}else{
	$_error="Код с картинки введён не верно!";

	//Не верно, скрипт регистрации следует остановить
     $stopit=1;
		}
	}
  }else{
	$_error="Вы не ввели код с картинки!";

	//Не верно, скрипт регистрации следует остановить
     $stopit=1;
  }
    //Удаляем капчу из сессии
	$_SESSION['capcha']="delmepls";
    unset($_SESSION['capcha']);
}





//Фильтруем посты с логином и перфектом
$_POST_wallet=strtoupper(trim(sf($_POST['wallet'])));



//Чтобы убрать лишние запросы в БД смотрим введена ли капча верно:
if($stopit!=1){

if(!empty($_COOKIE['ref'])){
$referer=(int)$_COOKIE['ref'];
}





if($referer<=$adminid OR empty($referer)){$referer=1;}

//Проверяем не пуст ли он
if(empty($_POST_wallet)){
	$_error="Вы не ввели кошелек";
}
//Простенькая валидация
if($_POST_wallet[0]!='P'){
	$_error="Кошелек Payeer имеет неверный формат!";	
}


}
//Если нет ни одной ошибки, регаем юзера
if(empty($_error)){
	
$nofoot=1;$nohead=1;	

$_POST_ip=getRealIP();

if(!empty($_COOKIE['ref'])){
$referer=(int)$_COOKIE['ref'];
}else
if(!empty($_SESSION['ref'])){
$referer=(int)$_SESSION['ref'];
}
	
$came=sf($_SESSION['came']);	
	
	
	
toaccount($_POST_wallet, $_POST_ip, $came, $referer);


?>
	<script type="text/javascript">
	location.replace("/?page=my");
	</script>
	<noscript>
	<meta http-equiv="refresh" content="0; url=/?page=my">
	</noscript>
<?
exit();

}
}else







	
	

	
if(isset($_POST['do']) && $_POST['do']=='payeer_pay'){

$m_amount = $_POST['m_amount'];
if($m_amount>0 AND $m_amount>=$mindep AND $m_amount<=$maxdep){


$m_amount = number_format($m_amount, 2, '.', '');
$m_desc = base64_encode($m_desc);
$m_orderid = $id;
//$m_curr='RUB';
$arHash = array(
	$m_shop,
	$m_orderid,
	$m_amount,
	$m_curr,
	$m_desc,
	$m_key
);


$sign = strtoupper(hash('sha256', implode(':', $arHash)));
?>
					<div style="display:none">
                        <form method="GET" id="payeer_form_real" action="//payeer.com/merchant/">
                        <input type="hidden" name="m_shop" value="<?=$m_shop?>">
                        <input type="hidden" name="m_orderid" value="<?=$m_orderid?>">
                        <input type="hidden" name="m_amount" value="<?=$m_amount?>">
                        <input type="hidden" name="m_curr" value="RUB">
                        <input type="hidden" name="m_desc" value="<?=$m_desc?>">
                        <input type="hidden" name="m_sign" value="<?=$sign?>">
                        <input type="submit" name="m_process"  value="Payeer" />
                        </form>
                    </div>

Redirecting...
<script>
document.getElementById('payeer_form_real').submit();
</script>


<?
$_success='Please wait...';

exit;
}else{
	if($m_amount<=0){
	$_error="Вы не указали сумму";
	}else{
	$_error="Вы указали неверную сумму";		
	}
}
}














}//ЭТУ ФИГНЮ НЕ УДАЛЯТЬ!!!
?>
<?/*-------------------*//*
Script by Sirgoffan
Skype: Sirgoffan
Web-site: php-market.ru
*//*-------------------*/?>