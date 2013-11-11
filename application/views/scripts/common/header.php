<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Natural Europe Pathways <?php echo isset($title) ? ' | ' . strip_formatting($title) : ''; ?></title>
<!-- Meta -->
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="description" content="Pathway test!" />
<meta name="Keywords" content="pathways">

<?php //echo auto_discovery_link_tag(); ?>
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
<?php if(isset($_GET['nhm']) and $_GET['nhm']=='MNHN'){ ?>
<link rel="stylesheet" type="text/css" href="<?php echo uri('themes/natural/css/page_mnhn.css'); ?>"/> 
<?php } elseif(isset($_GET['nhm']) and $_GET['nhm']=='TNHM'){ ?>
<link rel="stylesheet" type="text/css" href="<?php echo uri('themes/natural/css/page_tnhm.css'); ?>"/> 
<?php } elseif(isset($_GET['nhm']) and $_GET['nhm']=='NHMC'){ ?>
<link rel="stylesheet" type="text/css" href="<?php echo uri('themes/natural/css/page_tnhm.css'); ?>"/> 
<?php } elseif(isset($_GET['nhm']) and $_GET['nhm']=='HNHM'){ ?>
<link rel="stylesheet" type="text/css" href="<?php echo uri('themes/natural/css/page_tnhm.css'); ?>"/> 
<?php } elseif(isset($_GET['nhm']) and $_GET['nhm']=='JME'){ ?>
<link rel="stylesheet" type="text/css" href="<?php echo uri('themes/natural/css/page_tnhm.css'); ?>"/> 
<?php } elseif(isset($_GET['nhm']) and $_GET['nhm']=='AC'){ ?>
<link rel="stylesheet" type="text/css" href="<?php echo uri('themes/natural/css/page_tnhm.css'); ?>"/> 
				<?php } else{ ?>
<link rel="stylesheet" type="text/css" href="<?php echo uri('themes/natural/css/page.css'); ?>"/> 
				<?php } ?>
<link rel="shortcut icon" href="./images/fav.ico" />

<link rel="stylesheet" type="text/css" href="<?php echo uri('themes/natural/lightview/css/lightview.css');?>" />
 
<link rel="stylesheet" type="text/css" href="<?php echo uri('themes/natural/css/typography.css');?>"/>
<!--[if lt IE 8]><link href="<?php echo uri('themes/natural/css/page_ie7.css');?>" rel="stylesheet" type="text/css" media="screen" /><![endif]--> 

<!-- JavaScripts -->
<script type="text/javascript" src="<?php echo uri('themes/natural/scripts/ajax/ajax.js');?>"></script>
<script type="text/javascript" src="<?php echo uri('themes/natural/scripts/ajax/ajax_chained.js');?>"></script>
<?php if ($pos_collections>'0'){ } else{
	echo '<script type="text/javascript" src="'.uri('themes/natural/lightview/prototype.js').'"></script>
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/scriptaculous/1.8.2/scriptaculous.js"></script>';
}
?>



<script type='text/javascript' src="<?php echo uri('themes/natural/lightview/js/lightview.js');?>"></script>
<script type='text/javascript' src="<?php echo uri('themes/natural/scripts/functions.js');?>"></script>


<?php if ($pos_exhib2>0){ ?>
<link rel="stylesheet" type="text/css" href="<?php echo uri('themes/natural/css/jquery.jscrollpane.css'); ?>"/>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
	<script>jQuery.noConflict();</script>
<?php } else{ ?>
	<script type="text/javascript" language="javascript" src="<?php echo uri('themes/natural/javascripts/jquery.js'); ?>"></script>
	 <script>
		 jQuery.noConflict();
	   </script>
	 <?php } ?>  
	<script type="text/javascript" language="javascript" src="<?php echo uri('themes/natural/javascripts/main_tooltip.js'); ?>"></script>
<!-- Plugin Stuff -->
<?php echo plugin_header(); ?>

<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-28875549-1']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>
</head>
<body>
<?php
session_start();
// store session data

$locale = Zend_Registry::get('Zend_Locale');
$_SESSION['get_language']=get_language_for_switch();
$_SESSION['get_language_omeka']=get_language_for_omeka_switch();
$_SESSION['get_language_for_internal_xml']=get_language_for_internal_xml();
?>    
<div id="page-container">

				<?php if(isset($_GET['nhm']) and ($_GET['nhm']=='MNHN' or $_GET['nhm']=='TNHM' or $_GET['nhm']=='NHMC' or $_GET['nhm']=='JME' or $_GET['nhm']=='HNHM' or $_GET['nhm']=='AC')){ ?>

				<?php } else{ ?>
                
<div id="page-header">
    
    
<div style="float:left;"><h1><a href="<?php echo uri('index');?>"><img src="<?php echo uri('themes/natural/images/interface/logonatural.png'); ?>"></a></a></h1></div><!--end rx div-->
   <div id="nav-site-supplementary" class="menubar">
    	<ul id="nav-site-supplementary-menu">
		<li><a href="<?php echo uri('admin/users/login');?>" title="Sign-in"><?php echo __('Sign-in'); ?></a></li>
	</ul><!--end nav-site-supplementary-menu ul-->
    </div><!--end nav-site-supplementary div-->
   
</div><!--end page-header div-->
<div id="languages" style="position: absolute; top: 150px; right: 10px; width: 200px;">
                        <?php echo language_switcher(); ?>
                    </div>

				<?php } ?>



