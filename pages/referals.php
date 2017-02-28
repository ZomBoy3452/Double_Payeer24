<?php if(!defined('SCRIPT_BY_SIRGOFFAN')){
echo ('Выявлена попытка взлома!');
exit();
}
if(empty($id)){?>
<p style="height:100px; padding-top:50px; text-align:center;"><span class="style2">Для доступа к данному разделу Вам необходимо пройти авторизацию!</span><br>
<?}else{?>



<table width="930" border="0" cellpadding="3" cellspacing="2">
<tbody><tr><td align="center">

<h1 style="text-align:center">Партнерская программа</h1>
<br />

Приглашайте в проект своих друзей и знакомых, Вы будете получать <b>5%</b> от каждого вклада приглашенного Вами пользователя <b>сразу на Ваш Payeer кошелёк</b>!
Ниже представлена ссылка для привлечения и количество приглашенных Вами людей.<br />
Автоматическая выплата в порядке очереди срабатывает от 1 рубля.
<br />
<br>
<center>Партнерская ссылка: <input value=" <?=$http_s?>://<?=$host?>/?ref=<?=$id?>" onClick="select()" size="30" type="text"></center>
<br />

<?
$ihr=$db->getOne("SELECT i_have_refs_as_curator FROM ss_users WHERE id=?i",$id);

$refsprofit=$db->query("SELECT SUM(summa) as payed FROM deposits WHERE curatorid=?i",$id);
$refsprofit=$db->fetch($refsprofit);
$payed=$refsprofit['payed']*($refpercent/100);

$refsprofit=$db->query("SELECT SUM(summa) as waited FROM deposits WHERE status=?i AND curatorid=?i",0,$id);
$refsprofit=$db->fetch($refsprofit);
$waited=$refsprofit['waited']*($refpercent/100);


?> 
<p><center>Рефералов: <b><font color="#000;"> <?=$ihr?> чел.</b> 
Реф. доход: <b><?=$payed?> руб. </b> 
В ожидании выплат:<b> <?=$waited?> руб.</b>

</font></center></p>


<table cellpadding='3' cellspacing='0' border='0' bordercolor='#336633' align='center' width='100%'>
<tr bgcolor="#000" height="30" valign="middle" align="center" style="text-transform: uppercase;text-shadow: 0 1px 1px #333;font-weight: bold;color:#FFFFFF;">
	<td align="Center"> Логин </td>
	<td align="Center"> Дата регистрации </td>
	<td align="Center"> Доход от партнера </td>
</tr>
<? if($ihr>0){
$myrefsrow=$db->query("SELECT * FROM ss_users WHERE curator=?i ORDER BY id DESC",$id); 
while($myrefs=$db->fetch($myrefsrow)){?> 
<tr class="htt">
<td align="center"><?=$myrefs['wallet']?></td>
<td align="center"><?=date('d.m.Y H:i:s',$myrefs['reg_unix'])?></td>
<?
$refprofit=$db->query("SELECT SUM(summa) as personalprofit FROM deposits WHERE userid=?i",$myrefs['id']);
$refprofit=$db->fetch($refprofit);
?>
<td align="center"><?=($refprofit['personalprofit']*($refpercent/100))?></td>
</tr>
<?}}else{?>
<tr class="htt"><td align="center" colspan="3">У вас нет рефералов</td></tr>
<?}?>
</table>


</td></tr></tbody>
</table>
<br>













<?}?>
