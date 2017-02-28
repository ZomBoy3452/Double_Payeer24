<?session_start(); 
define('SCRIPT_BY_SIRGOFFAN',dirname(__FILE__)); 
include(dirname(__FILE__).'/core/ini.php'); 
include(dirname(__FILE__).'/core/cache.php'); 

$page = $_GET['page']; 

include('templ/main/head.php'); 
if(isset($page)){ 
if(file_exists(dirname(__FILE__)."/pages/".$page.".php")){ 
include(dirname(__FILE__)."/pages/".$page.'.php'); 
}else{ 
include(dirname(__FILE__).'/pages/404.php'); 
} 
}else{ 
include(dirname(__FILE__).'/pages/main.php'); 
}
include('templ/main/foot.php'); 
