<?php if(!defined('SCRIPT_BY_SIRGOFFAN')){
echo ('Выявлена попытка взлома!');
exit();
}
?>

<div class="linux">

 <table width="830" border="0" cellpadding="0" cellspacing="0" id="tables">
<thead>
  
  <tr bgcolor="#000" height="30">
    <th align="center" width="150px"><b>Дата вклада</b></th>
	<th align="center" width="100px"><b>Кошелек</b></th>
	<th align="center" width="100px"><b>Депозит</b></th>
	<th align="center" width="100px"><b>Осталось</b></th>
	<th align="center" width="100px"><b>На вывод</b></th>
  </tr>  
  
 </thead>

<? 


$checkdeps=$db->getOne("SELECT id FROM `deposits` WHERE status='0' LIMIT 1");
if($checkdeps>0){
$depositsrow=$db->query("SELECT * FROM `deposits` WHERE status='0' ORDER BY id DESC LIMIT 50");
  
while($deposits=$db->fetch($depositsrow)){?>  
	<tr>
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
	
	
	<td class="countdown" align="center"><?=$deptime;?></td>
	<td align="center"> <?=$deposits['summa']+($deposits['summa']*($percent_u/100))?> руб.</td>
  	</tr>
<?}}else{?>
<center>У вас нет открытых вкладов</center>	
<?}?> 
 
 </table>
 </div>
<br>

