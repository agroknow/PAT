<?php if(isset($_GET['ajaxsection'])){
echo "<br><br>";
// echo "<br /><h1 class='section_title'>".$exhibitSection->title."</h1>"; 
exhibit_builder_render_exhibit_page();

}
else{ 
?>
<?php head(array('title'=>h($exhibit->title))); 
session_start();
$requested_path="http://".$_SERVER["HTTP_HOST"].$_SERVER["REQUEST_URI"];
$_SESSION["contact_for"]=$requested_path;
?>
<?php $eid = $exhibit->id; //echo $eid; break;?>
		<?php //$user = return_user(); ?>
		
		<div id="page-body" class="two_column">

<?php require_once('./application/views/scripts/common/menu.php'); ?>
<?php

$user_of_exhibit=return_user_of_exhibit($eid); if($user>0){$href_ask='/natural_europe/custom/contact/contact.php?id='.$user_of_exhibit.'';}else{$href_ask='/natural_europe/contact?id='.$user_of_exhibit.'';}

		require_once 'Omeka/Core.php';
$core = new Omeka_Core;

try {
    $db = $core->getDb();
	$db->query("SET NAMES 'utf8'");
   
    //Force the Zend_Db to make the connection and catch connection errors
    try {
        $mysqli = $db->getConnection()->getConnection();
    } catch (Exception $e) {
        throw new Exception("<h1>MySQL connection error: [" . mysqli_connect_errno() . "]</h1>" . "<p>" . $e->getMessage() . '</p>');
    }
} catch (Exception $e) {
	die($e->getMessage() . '<p>Please refer to <a href="http://omeka.org/codex/">Omeka documentation</a> for help.</p>');
}

?>


<div class="column" id="column-d">

<h1 class="section_title"><?php echo $exhibit->title;?><span class="last_modified"><?php echo __('Last Modified:'); ?> 
		 <?php $datetime = strtotime($exhibit->date_modified); $mysqldate = date("d/m/Y", $datetime); $exhibit->date_modified; echo  $mysqldate; ?></span></h1>

<div id="submenu10">
		<?php 
		if(!isset($_GET['ExhItm'])){ 
		echo exhibit_builder_section_nav(); } ?>
	</div>
	<br style="clear:both;">

		

<?php

if(isset($_GET['eid'])){ ?>

			<?php 
			//session_start();
			
			//echo $user;
			//if ($user>'0') echo $user;
			//else header('Location:http://education.natural-europe.eu/test/portal/admin/exhibits');
			// We have to make private some resources like rate, discussions
			 ?>
			 
			<div style="margin-left:10px;"><a class="lightview" rel="iframe" title=" ::  :: width: 680, height: 500" class="lightview" target="_blank" href="<?php echo uri('threads'); echo '?eid='.$eid.'&uid='.$user; ?>" >Add your comment</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<a href="javascript:history.go(-1)" title="Return to previous page">Return</a></div>
			
					<?php include('./custom/threads/threads_exhibit_posts.php');  
					
					
					
				 
			} 
			
			elseif(isset($_GET['ExhItm'])){ ?>
			<?php show_exhibititem($exhibit->id,$_GET['ExhItm']); ?> 
			<?php
			}
			
			else{
			?>
			<div id="section1">
			<?php

			 // Replace this function with one that will print the new text after excluding the teaser
			  echo "<br><br>";
			//echo "<br /><h1 class='section_title'>".$exhibitSection->title."</h1>";
			exhibit_builder_render_exhibit_page(); 
			//echo nls2p($exhibit->description);
			
			?>
            
			</div>
			

			<div style="clear:both;"></div>
			<?php
			}
			?>	
			
	
	
  </div><!-- end div #collumn-d -->

<div class="column" id="column-e">
	
	<div class="panel sidebar intro">
		<?php echo  exhibit_picture($exhibit->id,'220','show'); ?>
	

			        </div><!--end panel sidebar div-->
<div class="divider column-e"></div>
<script>
jQuery(function () {
  
  var msie6 = jQuery.browser == 'msie' && jQuery.browser.version < 7;
  
  if (!msie6) {
    var top = jQuery('#scroll').offset().top - parseFloat(jQuery('#scroll').css('margin-top').replace(/auto/, 0));
    jQuery(window).scroll(function (event) {
      // what the y position of the scroll is
      var y = jQuery(this).scrollTop();
      
      // whether that's below the form
      if (y >= top) {
        // if so, ad the fixed class
        jQuery('#panel-exhibit').addClass('fixed');
		jQuery('#metadata').addClass('metadatascroll');
		jQuery('#panel-exhibitlink').addClass('fixed');
      } else {
        // otherwise remove it
        jQuery('#panel-exhibit').removeClass('fixed');
		jQuery('#metadata').removeClass('metadatascroll');
		jQuery('#panel-exhibitlink').removeClass('fixed');
      }
    });
  }  
});
</script>

	<div class="panel-exhibit2">
	<?php include('./application/views/scripts/common/ratemenu.php'); ?>
	<div id="panel-exhibit">
	<div class="scroll-pane"><!--ADD SCROLL PANE DIV WITH JAVASCRIPT WHEN MENU SCROLLS WITH THE PAGE TO REPLACE DEFAULT SCROLLBAR?-->
	<div class="panel sidebar resources">
	<h2 class="title_sel" id="title"></h2>	
		<div id="item-tip" class="panel-intro">
			<!--Click on a keyword or a term of the exhibit and learn more by exploring: -->
		</div><!-- end div.panel-intro -->	
		
		<div id="panel-exhibit_gialink"><h4 class="panel-exhibit_gialink"><?php echo __('Supporting Materials'); ?></h4>	</div>
		<div class="panel-intro" id="text_resources">
			 	
			<?php
			
			$sectionid=$exhibitSection->id;
			teaser($eid,'resources',$sectionid); 
			 ?>
			 		</div><!-- end div.panel-intro -->	
<!--		<div id="panel-exhibit_gialink"><h4 class="panel-exhibit_gialink">Europeana</h4>	</div>
		<div class="panel-intro" id="text_europeana">	
		
			<?php
			//teaser($eid,'europeana',$sectionid); 
			
			 ?>
			 		</div> end div.panel-intro -->	
		<?php /*<div id="panel-exhibit_gialink"><h4 class="panel-exhibit_gialink"><a class="lightview" rel="iframe" title=" ::  :: width: 680, height: 600" class="lightview" target="_blank" href="<?php echo uri('socialtag'); echo '?eid='.$eid.'&uid='.$user; ?>"><?php echo __('Add your tag'); ?></a></h4>	</div> 
        */?>
	
		
		
	
			<div id="scroll" class="scroll"></div>
	</div><!-- end div.panel -->
	</div><!-- end div.panel -->
</div><!--end panel sidebar div-->
        </div><!--end scrollpane div-->
		</div><!--end columnE div-->

<div id="metadata">
<h4 style="border-bottom:1px solid #999999;">&nbsp;</h4> <br>
<h2 style="color:#90A886; font-size:13px;"><?php echo __('Given Metadata'); ?>:</h2> 
<?php
echo "<strong>".__('Creator')." : </strong>".return_user_of_exhibit2($exhibit->id)."<br>";

show_metadata_info($exhibit->id,'exhibit',$_SESSION['get_language']);


?>
</div>		
<div class="clear"></div><!--clear DIV NEEDS TO BE ADDED TO ALL TEMPLATES-->
</div><!--end page-body div-->
<div class="clear"></div><!--clear DIV NEEDS TO BE ADDED TO ALL TEMPLATES-->
</div><!--end page-container div-->

<?php foot(); 
} //else ajax section
?>

<?php /*  original code by omeka////////////////////////

<?php head(array('title' => html_escape(exhibit('title') . ' : '. exhibit_page('title')), 'bodyid'=>'exhibit','bodyclass'=>'show')); ?>
<div id="primary">
	<h1><?php echo link_to_exhibit(); ?></h1>

    <div id="nav-container">
    	<?php echo exhibit_builder_section_nav();?>
    	<?php echo exhibit_builder_page_nav();?>
    </div>

	<h2><?php echo exhibit_page('title'); ?></h2>
	
	<?php exhibit_builder_render_exhibit_page(); ?>
	
	<div id="exhibit-page-navigation">
	   	<?php echo exhibit_builder_link_to_previous_exhibit_page(); ?>
    	<?php echo exhibit_builder_link_to_next_exhibit_page(); ?>
	</div>
</div>	
<?php foot(); ?>
  */ ?>