<?php if(!defined('ADMIN_SIBHYIP_'.$admintoken)){
echo ('Выявлена попытка взлома!');
exit();
}

//.if(empty($id) OR $login!=$adminname){die();}
/**//**//**//**//**//**//**//**//**//**//**/

$start=0;
$limit=15;

if(isset($_GET['p'])){
$p=(int)$_GET['p'];
$start=($limit*$p)-$limit;
}
$sql = "select max(id) as maxid from `log`";
$res = $db->query($sql); 
$row= $db->fetch($res);
$maxid=$row["maxid"]; 

$allpages=ceil($maxid/$limit);

$totaldeposited=0;

$sql = "select * from `log` ORDER BY id DESC LIMIT ".$start.",".$limit."";

$res = $db->query($sql); 
while($row=$db->fetch($res))
  {
$userid=$row["userid"]; 
 $errid=$row["id"];
 $etype=$row["type"]; 
 
if($etype==0){
	$blockcolor='#A5A1A1';
}else
if($etype==1){
	$blockcolor='#66F3AA';
}else	
if($etype==2){
	$blockcolor='#BD4A4A';
}else{
	$blockcolor='#CDF721';	
}



 
 
 $ecomment=$row["comment"];  
 $etimeunix=$row["timeunix"];   
 
 
 $sql2 = "select wallet from `ss_users` WHERE id='".$userid."'";
 $res2 = $db->query($sql2); 
 $row2=$db->fetch($res2);
 $wallet=$row2["wallet"];

 
 if($row['summa']<=0){$summa='NOT DEFINED OR NULL';}else{
$summa=number_format($row['summa'],2,'.',' '); 
 }
$opisanie=$row["description"];


 ?>
 
 

 
<hr>
<div style="width:100%; background-color:<?=$blockcolor?>;" >
<b><?=$errid?></b>.<br>
<table>
	<tr><td>Пользователь:</td><td><?=$wallet?></td></tr>
	<tr><td>Сумма:</td><td><?=$summa?><?=$m_curr?></td></tr>
	<tr><td>Описание:</td><td><?=$opisanie?></td></tr>
	<?if($etimeunix>0){?><tr><td>Дата:</td><td><?=date('d.m.Y H:m:i',$etimeunix)?></td></tr><?}?>
	<?if(!empty($ecomment)){ echo "<tr><td>Доп. Комментарий:</td><td>".$ecomment."</td></tr>";}?>
</table>
</div>
<?
}
?>
<br><hr>

<center>
<?
	if($allpages>1){
			$i=1;
		while($allpages>=$i){
			echo "<a href='/?page=".$adminadress."&action=log&p=".$i."'>".$i."</a>&nbsp;";
			$i++;
		}


	}

?></center>