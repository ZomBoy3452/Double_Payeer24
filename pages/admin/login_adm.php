<?php 

//if(empty($id) OR $login!=$adminname){die();}
/**//**//**//**//**//**//**//**//**//**//**/

if(!empty($_POST['adminsecretcode'])){
	$_SESSION['adminsecretcode']=sf($_POST['adminsecretcode']);
	?>
<script type="text/javascript">
	location.replace("/?page=<?=$adminadress?>&action=log");
</script>
<noscript>
	<meta http-equiv="refresh" content="0; url=/?page=<?=$adminadress?>&action=log">
</noscript>
	<?
}

?>
Для продолжения введите секретную фразу админа<br>

<form action="" method="POST">
<input type="text" name="adminsecretcode" value="">
<input type="submit" value="Продолжить">
</form>



