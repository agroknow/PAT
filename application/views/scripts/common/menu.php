<?php if(stripos($_SERVER['REQUEST_URI'],'/to-begin-with')>0 or stripos($_SERVER['REQUEST_URI'],'exhibits/show/')>0 or stripos($_SERVER['REQUEST_URI'],'items/show')>0){ ?>
<div id="nav-breadcrumbs"> <?php echo __('You are here'); ?>:
      <ul id="nav-breadcrumbs-menu">
	  <li>
		<?php include('./custom/breadcrump/breadcrump.php'); ?>  </li>  

        </ul>	
</div>
<?php } ?>


<?php if(isset($_GET['nhm']) and ($_GET['nhm']=='MNHN' or $_GET['nhm']=='TNHM' or $_GET['nhm']=='NHMC' or $_GET['nhm']=='JME' or $_GET['nhm']=='HNHM' or $_GET['nhm']=='AC')){ ?>


<?php if(!(stripos($_SERVER['REQUEST_URI'],'/to-begin-with')>0 or stripos($_SERVER['REQUEST_URI'],'exhibits/show/')>0) and stripos($_SERVER['REQUEST_URI'],'items/show/')>0 ){ ?>
<div id="nav-content">
<?php if(!(stripos($_SERVER['REQUEST_URI'],'/to-begin-with')>0 or stripos($_SERVER['REQUEST_URI'],'exhibits/show/')>0)){ ?>
	<ul id="nav-content-level1" class="menu" style="margin-top:50px;">
	
		<?php /*<li><a href="http://www.natural-europe.eu" target="_top"><img src="<?php echo uri('application/views/scripts/images/natural_europe_banner.gif'); ?>"></a></li>*/ ?>
                        <li><a href="<?php echo uri('index'.target().'');?>" <?php if(stripos($_SERVER['REQUEST_URI'],'exhibits')>0 or stripos($_SERVER['REQUEST_URI'],'eidteaser')>0){?>class="current-item" <?php } ?>>Pathways</a></li>
		
			</ul>
	<?php } ?>			
<?php if(stripos($_SERVER['REQUEST_URI'],'items/show/')>0){  include('./application/views/scripts/common/ratemenu.php');   }?>		
</div>

<?php } ?>

<?php } else{ ?>

<?php if(!(stripos($_SERVER['REQUEST_URI'],'/to-begin-with')>0 or stripos($_SERVER['REQUEST_URI'],'exhibits/show/')>0)){ ?>
<div id="nav-content">
	<ul id="nav-content-level1" class="menu">
	
		<li><a href="<?php echo uri('index'.target().'');?>" <?php if(stripos($_SERVER['REQUEST_URI'],'exhibits')>0 or stripos($_SERVER['REQUEST_URI'],'eidteaser')>0){?>class="current-item" <?php } ?>><?php echo __('Pathways'); ?></a></li>
        <!--<li><a href="http://62.217.124.204:8080/naturaleurope_sciencetweets/search.html" target="_blank">Learning Material Search</a></li> -->
		
			</ul>
				
<?php if(stripos($_SERVER['REQUEST_URI'],'items/show/')>0){  include('./application/views/scripts/common/ratemenu.php');   }?>		
</div>

<?php } ?>


<?php } ?>



