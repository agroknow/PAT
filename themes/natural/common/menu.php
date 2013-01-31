<div id="nav-breadcrumbs"> You are here:
      <ul id="nav-breadcrumbs-menu">
	  <li>
		<?php include('./custom/breadcrump/breadcrump.php'); ?>  </li>  

        </ul>	
</div>
<?php
				$targetteam="";
if(isset($_GET["target"])){$targetteam="&target=".$_GET["target"]."";}
if(isset($_GET["section"])){$targetteam="&section=".$_GET["section"]."";}
  ?>
<!-- EDUCATORS -->
<?php if(!(stripos($_SERVER['REQUEST_URI'],'/to-begin-with')>0 and stripos($_SERVER['REQUEST_URI'],'exhibits')>0)){ ?>
<div id="nav-content">
	<ul id="nav-content-level1" class="menu">
		
		<li><a href="<?php echo uri('exhibits')?>" <?php if(stripos($_SERVER['REQUEST_URI'],'exhibits')>0 or stripos($_SERVER['REQUEST_URI'],'eidteaser')>0){?>class="current-item" <?php } ?>>Pathways</a></li>
        <li><a href="http://62.217.124.204:8080/naturaleurope_sciencetweets/search.html" target="_blank">Learning Material Search</a></li>
		
			</ul>
				
		
</div>

<?php } ?>
