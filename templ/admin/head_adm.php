<?
if(!defined('SCRIPT_BY_SIRGOFFAN')){
exit();
}

?>
<!DOCTYPE html>
<html class="no-animation animated-content colorize js no-flexbox flexbox-legacy canvas canvastext webgl no-touch geolocation postmessage websqldatabase indexeddb hashchange history draganddrop websockets rgba hsla multiplebgs backgroundsize borderimage borderradius boxshadow textshadow opacity cssanimations csscolumns cssgradients cssreflections csstransforms csstransforms3d csstransitions fontface generatedcontent video audio localstorage sessionstorage webworkers applicationcache svg inlinesvg smil svgclippaths wf-brandongrotesque-n3-active wf-brandongrotesque-n4-active wf-brandongrotesque-n5-active wf-brandongrotesque-n7-active wf-active"><head>

<?=printMetaTag();?>

<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<link rel="stylesheet" id="bootstrap-css" href="/<?=$templ_dir.'/'.$templ_name?>/css/bootstrap.min.css" type="text/css" media="all">
<link rel="stylesheet" id="main-styles-css" href="/<?=$templ_dir.'/'.$templ_name?>/css/style.css" type="text/css" media="all">
<script type="text/javascript" src="/<?=$templ_dir.'/'.$templ_name?>/js/jquery.js"></script>
<script type="text/javascript" src="/<?=$templ_dir.'/'.$templ_name?>/js/jquery-migrate.min.js"></script>



<noscript>НЕОБХОДИМА ПОДДЕРЖКА JAVA</noscript> 








</head>









<body class="single single-post postid-1026 single-format-standard chrome linux wpb-js-composer js-comp-ver-3.6.2 vc_responsive">



<!-- Start Wrap All -->
<div class="wrap_all">

<!-- Header -->
<header id="menu">
	<a id="mobile-nav" class="menu-nav dJAX_internal desktop-view open" href="#"><span class="menu-icon"></span></a>
	<nav id="menu-pr" class="desktop-view animate" >
		<ul>
		




<li>
	<a href="/?page=<?=$adminadress?>&action=stats" class="dJAX_internal" style="width: 60px;">
		<img src="/<?=$templ_dir.'/'.$templ_name?>/img/stat.png" class="leftbuttons">
		<span class="menu_txt" style="display:none;">Статистика</span>
	</a>
</li>

<li>
	<a href="/?page=<?=$adminadress?>&action=traf" class="dJAX_internal" style="width: 60px;">
		<img src="/<?=$templ_dir.'/'.$templ_name?>/img/ie.png" class="leftbuttons">
		<span class="menu_txt" style="display:none;">Трафик</span>
	</a>
</li> 
						   						   
<li>
	<a href="/?page=<?=$adminadress?>&action=log" class="dJAX_internal" style="width: 60px;">
		<img src="/<?=$templ_dir.'/'.$templ_name?>/img/down.png" class="leftbuttons">
		<span class="menu_txt" style="display:none;">Финансы</span>
	</a>
</li> 





		</ul>
	</nav>
	<a class="logo dJAX_internal" style="z-index:-999;" href="http://php-market.ru" title="NICEHYIP | NICEHYIP" onload="changeblocks();">NICEHYIP</a>
</header>
<!-- End Header -->
<style>
.rightbuttons{
	left: 8px;
    margin: -8px 0 0 -6px;
    position: absolute;
    text-indent: 0;
    top: 10px;
    width: 25px;
    height: 25px;
background-repeat: no-repeat;}

.leftbuttons {
    left: 25px;
    margin: -8px 0 0 -6px;
    position: absolute;
    text-indent: 0;
    top: 15px;
    width: 25px;
    height: 25px;
    background-repeat: no-repeat;
}


  </style>
	<!-- Navigation Area -->
	<section class="navi-portfolio">
	    <ul>

	        <li class="back-portfolio"><a href="#" onclick="window.location = '<?=$http_s?>://<?=$host?>/'" title="В пользовательский раздел" class="dJAX_internal"><img src="/<?=$templ_dir.'/'.$templ_name?>/img/klient.png" class="rightbuttons"></a></li>
			
	        <li class="back-portfolio"><a href="javascript:alert('В целях безопасноти настройки хранятся в конфиге.');" title="Настройки проекта" class="dJAX_internal"><img src="/<?=$templ_dir.'/'.$templ_name?>/img/options.png" class="rightbuttons"></a></li>			
			
			
	    </ul>
	</section>
	<!-- End Navigation Area -->
	
	































<div id="main" class="ajaxable">
<?if(!empty($_error) OR !empty($_success)){?>
<div class='err_succ_msg'>
<table align="center">
<tr>
	<td>
		<!--img src="/<?=$templ_dir.'/'.$templ_name?>/img/logo_small.png" style="width:50px; height:50px;" /-->
	</td>
	<td>
	<?
		if(!empty($_error)){echo $_error;}
		if(!empty($_success)){echo $_success;}
	?>
	</td>
	<td>
		<!--img src="/<?=$templ_dir.'/'.$templ_name?>/img/logo_small.png" style="width:50px; height:50px;" /-->	
	</td>
</tr>
</table>
	</div>
<?}?>
<div id="content-blog-single" align="center">



<div class="sp_dial">


   <div class="sp_d_t" id="titleblock">&nbsp;Заголовок раздела</div>
   
   <div class="sp_d_b" onclick="jQuery('#descriptionblock').slideToggle('slow');" style="position:absolute;  padding: 2px; cursor:pointer;">&nbsp;&nbsp;?&nbsp;&nbsp;</div><br>
<div class="sp_d_b">






<div id="descriptionblock" style="display:none;" class="sp_d_b">Описание раздела</div>









