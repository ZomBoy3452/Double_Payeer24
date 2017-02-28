<?php if(!defined('SCRIPT_BY_SIRGOFFAN')){
echo ('Выявлена попытка взлома!');
exit();
}
?>

 <div align="center"><span class="style1"><?=$privetstvie?></span>
 </div>


 <table width="930" border="0" cellpadding="0" cellspacing="0" id="tables">
  <tbody><tr bgcolor="#000" height="30" style="text-transform: uppercase;text-shadow: 0 1px 1px #333;font-weight: bold;color:#FFFFFF;">
    <td align="center" width="150px"><b>Дата</b></td>
	<td align="center" width="100px"><b>Система</b></td>
	<td align="center" width="100px"><b>Кошелёк</b></td>
	<td align="center" width="100px"><b>Выплата</b></td>
	<td align="center" width="100px"><b>Статус</b></td>
  </tr>
  


<? 
$depositsrow=$db->query("SELECT * FROM `deposits` WHERE status='1' ORDER BY id DESC LIMIT 50");
  
while($deposits=$db->fetch($depositsrow)){?>  


<tr class="htt">
	<td align="center"> <?=date('d.m.Y H:i',$deposits['unixtime'])?></td>
	<td align="center"> <b>PAY<font color="#FDA833">EER</b></font></td>
<?
$wallet=substr($db->getOne("SELECT wallet FROM `ss_users` WHERE id=?i",$deposits['userid']), 0, -3); 
?>
   	<td align="center"> <b><?=$wallet?><font color="#FDA833">XXX</font></b></td>
	<td align="center"> <?=($deposits['summa']+($deposits['summa']*($percent_u/100)))?> руб.</td>
	<td align="center"><font color="#FDA833"><b>Выплачено</b></font></td>
  	</tr>

<?}?> 
  </tbody>
 </table>
 
<br>

