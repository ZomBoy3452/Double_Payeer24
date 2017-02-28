<?php if(!defined('SCRIPT_BY_SIRGOFFAN')){
echo ('Выявлена попытка взлома!');
exit();
}
?>



<font color="#FDA833"><center>
Внимание!</font> Выплаты идут в порядке очереди. <?/*Без очереди нажмите <a href="vivod.php">здесь</a> */?>
</center></font><br>
<span class="style3" ><center>
	
Мои открытые депозиты
</center></span><br>








 <table width="930" border="0" cellpadding="0" cellspacing="0" id="tables">
  <tbody>
  
  <tr bgcolor="#000" height="30" style="text-transform: uppercase;text-shadow: 0 1px 1px #333;font-weight: bold;color:#FFFFFF;">
    <td align="center" width="150px"><b>Дата вклада</b></td>
	<td align="center" width="100px"><b>Кошелек</b></td>
	<td align="center" width="100px"><b>Сумма</b></td>
	<td align="center" width="100px"><b>Осталось</b></td>
	<td align="center" width="100px"><b>Доход</b></td>
  </tr>  
  
 

<? 

$checkdeps=$db->getOne("SELECT id FROM `deposits` WHERE userid=?i LIMIT 1",$id);
if($checkdeps>0){
$depositsrow=$db->query("SELECT * FROM `deposits` WHERE userid=?i ORDER BY id DESC LIMIT 50",$id);
  
while($deposits=$db->fetch($depositsrow)){?>  
	<tr class="htt">
	<td align="center"> <?=date('d.m.Y H:i',$deposits['unixtime'])?></td>
	
<?
$wallet=substr($db->getOne("SELECT wallet FROM `ss_users` WHERE id=?i",$deposits['userid']), 0, -3); 
?>	
	
	
	<td align="center"> <b><?=$wallet?><font color="#FDA833">XXX</b></font></td>
    <td align="center"> <?=$deposits['summa']?> руб.</td>
	
<?
$seconds = time()-$deposits['unixtime'];

if($seconds>(3600*$depperiod)){
	$deptime="Выплачено";
}else{
	
$hours = floor($seconds/3600);
$seconds = $seconds-($hours*3600);
$minutes = floor($seconds/60);
$seconds = $seconds-($minutes*60);
$seconds = floor($seconds);



$h=$depperiod-($hours+1);
if($h<10){$h='0'.$h;}
$m=60-($minutes+1);
if($m<10){$m='0'.$m;}
$s=60-($seconds+1);
if($s<10){$s='0'.$s;}
	$deptime=$h.":".$m.":".$s;
}
?>	
	
	<td class="countdown" align="center"><?=$deptime?></td>
	<td align="center"> <?=$deposits['summa']+($deposits['summa']*($percent_u/100))?> руб.</td>
  	</tr>
<?}}else{?> 
<center>У вас нет открытых вкладов</center>
<?}?>

  </tbody>
 </table>
 
<br>

