<?
if(!defined('SCRIPT_BY_SIRGOFFAN')){
exit();
}
	unset($_SESSION["login"]);
	unset($_SESSION["password"]);
	unset($_SESSION["id"]);

?>
	<script type="text/javascript">
	location.replace("/");
	</script>
	<noscript>
	<meta http-equiv="refresh" content="0; url=/">
	</noscript>
<?
exit();
?>
