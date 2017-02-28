<?
if(!defined('SCRIPT_BY_SIRGOFFAN')){
exit();
}
?>
<html>
<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<link rel="shortcut icon" href="/favicon.ico?v=2">
        <link href="/style/style.css" rel="stylesheet" type="text/css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>

		<script>
		$(document).ready(function(){
			setInterval(function(){
				$('.countdown').each(function(){
					var time=$(this).text().split(':');
					var timestamp=time[0]*3600+ time[1]*60+ time[2]*1;timestamp-=timestamp>0;
					var hours=Math.floor(timestamp/3600);
					var minutes=Math.floor((timestamp- hours*3600)/ 60);
					var seconds=timestamp- hours*3600- minutes*60;if(hours<10){hours='0'+ hours;}
					
				if(minutes<10){minutes='0'+ minutes;}
				if(seconds<10){seconds='0'+ seconds;}
				if(timestamp>0){
				$(this).text(hours+':'+ minutes+':'+ seconds);
				}else{
				$(this).text('Выплачено');	
				}
				});
		},1000);

		})
		</script>
</head>
<body>﻿﻿

		<div id="menu_div">
			<div id="navigation">
					
				<div id="menu">
			<ul id="nav">
                        <a href="/"> <img src="/img/logo2.gif" style="float:left; margin-top:3px; opacity: 0.7;"></a>	
						<li><a href="/?page=referals">Партнерская программа</a></li>
						<li><a href="/?page=faq">Вопрос-Ответ</a></li>
						<li><a href="/?page=rules">Правила</a></li>
						<li><a href="/?page=payments">Выплаты</a></li>
					    <li><a href="/?page=about">О проекте</a></li>
					</ul>
					
					
					 
				</div>
			</div>
		</div>
		
 
<div class="dev_page_block dev_main_sections">
				
				<div class="layout">
				
			
				<div id="about-summary">
					<h2 id="about-summary-title">Устали от однодневных удвоителей?</h2>				
	
					<div id="about-summary-text">
						<p>Увеличивай свой депозит на 10% каждые сутки. Вклады от 1 до 30 000 рублей</p>
						<p>Приглашай рефералов! Партнерская программа 5%. Все выплаты автоматические!</p>
					    
					</div>
			</div>

				<div id="rbout-summary">
						
				</div>
				<div class="float-fix"><!-- --></div>
			
			</div>
	
	
</div>
 <?
$opened=$db->numRows($db->query("SELECT id FROM deposits WHERE status=?i",0));
$closed=$db->numRows($db->query("SELECT id FROM deposits WHERE status=?i",1));
$Users=$db->numRows($db->query("SELECT id FROM ss_users"));
$AmountDeposits = $db->fetch($db->query("SELECT SUM(summa) AS Summa FROM deposits WHERE status=?i",0));
?>
 <div class="included">
		<div class="layout">
		<ul><li><h4><span>Всего </span> <span>инвесторов </span></h4><div class="clr"></div><span class="include-icon"><?=$Users?> чел.</span></li><li><h4><span>Открытых депозитов </span></h4><div class="clr"></div><span class="include-icon"><?=$opened?> шт.</span></li><li><h4><span>Количество выплат </span></h4><div class="clr"></div><span class="include-icon"><?=$closed?> шт.</span></li><li><h4><span>Резерв проекта </span></h4><div class="clr"></div><span class="include-icon"><?=$AmountDeposits['Summa']+ 250?> руб.</span></li></ul>
		</div>
		</div>
 
 
<div class="main">
<table width="100%" border="0" cellpadding="0" cellspacing="0">
<tbody><tr>
	<td colspan="2">
		
	</td>
</tr>

<tr>
	<td colspan="2" height="30" width="930" valign="top">
	<center><br>
		
<?if(!empty($_error)){?><br><br><font color="red"><?=$_error?></font><br><br><?}?>
<?if(!empty($_success)){?><br><br><font color="green"><?=$_success?></font><br><br><?}?>				
<?if(empty($id)){?>		

		<form action="" method="post">	
		<input type="hidden" name="do" value="toaccount">
		<input type="hidden" name="antipovtor" value="<?=time();?>">
		
			<table width="930" height="21px" border="0" cellpadding="0" cellspacing="0">
			<tbody>
			
							
		
			<tr>
				<td align="center">
				<input name="wallet" type="text" size="23" maxlength="35" placeholder="Введите свой кошелек PAYEER.COM"><input type="submit" name="submit" id="form" value="Вход / Регистрация" class="reg"></td>
			</tr>
			
				
			
		  </tbody></table>
		</form>
<?}else{?>		
<?
if(!empty($id)){
$wallet=$db->getOne("SELECT wallet FROM ss_users WHERE id=?i",$id);
?>
<center>
<b style="font-size: 18px;">Ваш логин в системе: <font color="#FDA833"><?=$wallet?></font></b>	
</center>	<br>
<?}?>
<table width="300px" border="0">
	<tbody><tr>  
		 
		
		<td width="169"><a id="s" href="/?page=referals" style="text-decoration: none"><font>Рефералы</font></a></td>
		<td width="751"><a id="s" href="/?page=my" style="text-decoration: none"><font>Мои депозиты</font></a></td>
		<td width="751"><a id="s" href="/?page=payments" style="text-decoration: none"><font>Все выплаты проекта</font></a></td>
		<td width="751"> </td>
		<td width="180"><a id="s" href="/?page=exit" style="text-decoration: none"><font>Выход</font></a></td>		
	 
	</tr>
</tbody></table>



<form action="" method="post">	

		<input type="hidden" name="do" value="payeer_pay">
		<input type="hidden" name="antipovtor" value="<?=time();?>">


			<table width="930" height="21px" border="0" cellpadding="0" cellspacing="0">
			<tbody><tr>
				<td align="center">
				
				
								 <br><b>Введите сумму вклада (от <?=$mindep?> до <?=$maxdep?> рублей) </b> <br> <br><input style="text-align:center;" name="m_amount" type="text" value="100" size="5" maxlength="10"><input type="submit" name="submit2" value="Сделать вклад" class="reg"></td>
			</tr>
			
				
				
				
			
		  </tbody></table>
		</form>



<?}?>				
	</center><br>
	</td>
</tr>
</tbody></table>
</div>

<div class="main">


<?
$opened=$db->numRows($db->query("SELECT id FROM deposits WHERE status=?i",0));
$closed=$db->numRows($db->query("SELECT id FROM deposits WHERE status=?i",1));
?>

<style type="text/css">
<!--
.style1 {
	font-size: 14px;
	font-weight: bold;
}
-->
</style>



 