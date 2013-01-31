<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Natural Europe Pathways</title>
<!-- Meta -->
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="description" content="Pathway test!" />
<meta name="Keywords" content="pathways">

<?php echo auto_discovery_link_tag(); ?>
<?php 
	$findme="students"; $pos = stripos($_SERVER['REQUEST_URI'],$findme);
	$findme_exh="exhibits"; $pos_exhib = stripos($_SERVER['REQUEST_URI'],$findme_exh);
	$findme_exh2="/exhibits/"; $pos_exhib2 = stripos($_SERVER['REQUEST_URI'],$findme_exh2);
	$findme_resources = "resources"; $pos_resources = stripos($_SERVER['REQUEST_URI'],$findme_resources);
	$findme_home = "home"; $pos_home = stripos($_SERVER['REQUEST_URI'],$findme_home);
	$findme_collections = "collection"; $pos_collections  = 0; $pos_collections = stripos($_SERVER['REQUEST_URI'],$findme_collections);
	$findme_edu="educators"; $pos_edu = stripos($_SERVER['REQUEST_URI'],$findme_edu);
	$findme_search="search"; $pos_search = stripos($_SERVER['REQUEST_URI'],$findme_search);
	$findme_users="users"; $pos_users = stripos($_SERVER['REQUEST_URI'],$findme_users);
	$findme_glos="glossary"; $pos_glos = stripos($_SERVER['REQUEST_URI'],$findme_glos);
	$findme_res="research"; $pos_res = stripos($_SERVER['REQUEST_URI'],$findme_res);
	$findme_disc="eid"; $pos_disc = stripos($_SERVER['REQUEST_URI'],$findme_disc);
?>
<!-- Stylesheets -->
<link rel="stylesheet" type="text/css" href="<?php if ($_GET["target"]=='students') echo uri('themes/natural/css/page.css'); else echo uri('themes/natural/css/page.css')  ?>"/> 
<link rel="shortcut icon" href="./images/fav.ico" />
<!--<link rel="stylesheet" type="text/css" href="<?php //echo uri('themes/natural/scripts/roundcorners.css');?>" /> -->
<link rel="stylesheet" type="text/css" href="<?php echo uri('themes/natural/lightview/css/lightview.css');?>" />
 
<link rel="stylesheet" type="text/css" href="<?php echo uri('themes/natural/css/typography.css');?>"/>
<!--[if lt IE 8]><link href="<?php echo uri('themes/natural/css/page_ie7.css');?>" rel="stylesheet" type="text/css" media="screen" /><![endif]--> 

<!-- JavaScripts -->
<script type="text/javascript" src="<?php echo uri('themes/natural/scripts/ajax/ajax.js');?>"></script>
<script type="text/javascript" src="<?php echo uri('themes/natural/scripts/ajax/ajax_chained.js');?>"></script>
<?php if ($pos_collections>'0'){ } else{
	echo '<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/prototype/1.6.1/prototype.js"></script>
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/scriptaculous/1.8.2/scriptaculous.js"></script>';
}
?>

<script type="text/javascript" src="<?php if ($pos_users>'0') echo uri('themes/natural/javascripts/jquery.js');?>"></script>

<script type='text/javascript' src="<?php echo uri('themes/natural/lightview/js/lightview.js');?>"></script>
<script type='text/javascript' src="<?php echo uri('themes/natural/scripts/functions.js');?>"></script>
<!--<script type='text/javascript' src="<?php //echo uri('themes/natural/scripts/corner.js');?>"></script> -->

<script type="text/javascript" src="<?php if (($pos_resources>'0') || $_SERVER["REQUEST_URI"] == "/natural_europe/exhibits/browse?target=students") echo ('http://'.$_SERVER['HTTP_HOST'].'/natural_europe/themes/natural/jcarousel/lib/jquery-1.2.3.pack.js')?>"></script>

<script type="text/javascript" src="<?php if (($pos_resources>'0') || $_SERVER["REQUEST_URI"] == "/natural_europe/exhibits/browse?target=students") echo ('http://'.$_SERVER['HTTP_HOST'].'/natural_europe/themes/natural/jcarousel/lib/jquery.jcarousel.pack.js')?>"></script>

<?php if ($_SERVER["REQUEST_URI"] == "/natural_europe/exhibits/" || ($pos_res>'0') || ($pos_resources>'0') || $_SERVER["REQUEST_URI"] == "/natural_europe/exhibits/browse?target=students"){ ?><script  type="text/javascript">jQuery.noConflict();</script> <?php } ?>

<link rel="stylesheet" type="text/css" href="<?php if ($_SERVER["REQUEST_URI"] == "/natural_europe/exhibits/" || ($pos_resources>'0') || $_SERVER["REQUEST_URI"] == "/natural_europe/exhibits/browse?target=students") echo ('http://'.$_SERVER['HTTP_HOST'].'/natural_europe/themes/natural/jcarousel/lib/jquery.jcarousel.css')?>" />

<link rel="stylesheet" type="text/css" href="<?php echo uri('themes/natural/jcarousel/skins/tango/skin.css');?>" />
<?php if ($pos_collections>'0')
{
		echo '	<link rel="stylesheet" href="'.uri('themes/natural/galleriffic2.0/css/galleriffic-2.css').'" type="text/css" />
				<script type="text/javascript" src="'.uri('themes/natural/galleriffic2.0/js/jquery-1.3.2.js').'"></script>
				<script type="text/javascript" src="'.uri('themes/natural/galleriffic2.0/js/jquery.galleriffic.js').'"></script>
				<script type="text/javascript" src="'.uri('themes/natural/galleriffic2.0/js/jquery.opacityrollover.js').'"></script>';
}
?>

<?php if ($pos_exhib2>0){ ?>
<!--<link rel="stylesheet" type="text/css" href="<?php // echo uri('themes/natural/css/jquery.jscrollpane.css'); ?>"/> -->
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
	<script>jQuery.noConflict();</script>
<!--<script type="text/javascript" src="<?php //echo uri('themes/natural/js/jquery.jscrollpane.js'); ?>"></script> -->
<!--<script type="text/javascript" src="<?php //echo uri('themes/natural/js/jquery.mousewheel.js'); ?>"></script> -->
<?php } ?>
	<script type="text/javascript" language="javascript" src="<?php echo uri('themes/natural/javascripts/jquery.js'); ?>"></script>
	 <script>
		 jQuery.noConflict();
	   </script>
	<script type="text/javascript" language="javascript" src="<?php echo uri('themes/natural/javascripts/main_tooltip.js'); ?>"></script>
<!-- Plugin Stuff -->
<?php echo plugin_header(); ?>

</head>
<body>
<div id="page-container">

<div id="page-header">
<div style="float:left;"><h1><a href="<?php echo uri('index');?>"><img src="<?php echo uri('themes/natural/images/interface/logonatural.png'); ?>"></a></a></h1></div><!--end rx div-->
   <div id="nav-site-supplementary" class="menubar">
    	<ul id="nav-site-supplementary-menu">
		<li><a href="<?php echo uri('admin/users/login');?>" title="Sign-in">Sign-in</a></li>
	</ul><!--end nav-site-supplementary-menu ul-->
    </div><!--end nav-site-supplementary div-->
   
</div><!--end page-header div-->




