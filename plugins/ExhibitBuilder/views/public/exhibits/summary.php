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
		<div id="panel-exhibit_gialink"><h4 class="panel-exhibit_gialink"><a class="lightview" rel="iframe" title=" ::  :: width: 680, height: 600" class="lightview" target="_blank" href="<?php echo uri('socialtag'); echo '?eid='.$eid.'&uid='.$user; ?>"><?php echo __('Add your tag'); ?></a></h4>	</div> 
        
	
		
		
	
			<div id="scroll" class="scroll"></div>
	</div><!-- end div.panel -->
	</div><!-- end div.panel -->
</div><!--end panel sidebar div-->
        </div><!--end scrollpane div-->
		</div><!--end columnE div-->

<div id="metadata">
<h4 style="border-bottom:1px solid #999999;">&nbsp;</h4> <br>
<h2 style="color:#90A886; font-size:13px;"><?php echo __('Given Metadata:'); ?></h2> 
<?php
echo "<strong>Creator : </strong>".return_user_of_exhibit2($exhibit->id)."<br>";
//query for all values
$sql="SELECT * FROM metadata_record WHERE object_id=".$exhibit->id." and object_type='exhibit'";
$execrecord=$db->query($sql);
$datarecord=$execrecord->fetchAll();
foreach($datarecord as $datarecord){$datarecord['id']=$datarecord['id'];}
$sql="SELECT a.*,c.labal_name FROM metadata_element_value a join metadata_element_hierarchy b ON b.id=a.element_hierarchy join metadata_element_label c ON b.element_id=c.element_id WHERE a.record_id=".$datarecord['id']." ORDER BY b.pelement_id ASC, b.sequence ASC";
$exec5=$db->query($sql);
$data51=$exec5->fetchAll();

$output='';
foreach($data51 as $data5){

if($data5['labal_name']=='Are commercial uses of this resource allowed?'){

$right1=$data5['value'];
}

elseif($data5['labal_name']=='Are modifications of your work of this resource by other people allowed?'){

$right2=$data5['value'];
}
 else{


if($data5['language_id']=='en' or $data5['language_id']=='none'){
if(strlen($data5['value'])>1){
if($data5['labal_name']=='Please elaborate'){
$output.= $data5['value']." , ";
} else{
$output.= "<strong>".$data5['labal_name']."</strong> : ".$data5['value']." , ";}
}
}
}

} 
$output2='';
if($right1=='yes' and $right2=='yes'){$output2.= '<br><a href="http://www.creativecommons.org/licenses/by/3.0" target="_blank"><img src="'.uri('themes/natural/images/cc/cc-by.png').'"></a>';}
elseif($right1=='yes' and $right2=='no'){$output2.= '<br><a href="http://www.creativecommons.org/licenses/by-nd/3.0" target="_blank"><img src="'.uri('themes/natural/images/cc/cc-by-nd.png').'"></a>';}
elseif($right1=='yes' and $right2=='Yes, if others share alike'){$output2.= '<br><a href="http://www.creativecommons.org/licenses/by-sa/3.0" target="_blank"><img src="'.uri('themes/natural/images/cc/cc-by-sa.png').'"></a>';}
elseif($right1=='no' and $right2=='yes'){$output2.= '<br><a href="http://www.creativecommons.org/licenses/by-nc/3.0" target="_blank"><img src="'.uri('themes/natural/images/cc/cc-by-nc.png').'"></a>';}
elseif($right1=='no' and $right2=='no'){$output2.= '<br><a href="http://www.creativecommons.org/licenses/by-nc-nd/3.0" target="_blank"><img src="'.uri('themes/natural/images/cc/cc-by-nc-nd.png').'"></a>';}
elseif($right1=='no' and $right2=='Yes, if others share alike'){$output2.= '<br><a href="http://www.creativecommons.org/licenses/by-nc-sa/3.0" target="_blank"><img src="'.uri('themes/natural/images/cc/cc-by-nc-sa.png').'"></a>';}
else{echo ' ';}

$len=strlen($output);
$test=substr($output,0,($len-2));
echo $test;
echo $output2;
//end
?>
</div>		
<div class="clear"></div><!--clear DIV NEEDS TO BE ADDED TO ALL TEMPLATES-->
</div><!--end page-body div-->
<div class="clear"></div><!--clear DIV NEEDS TO BE ADDED TO ALL TEMPLATES-->
</div><!--end page-container div-->

<?php foot(); 
} //else ajax section
?>



<?php /*   orignial code from omeka
<?php head(array('title' => html_escape('Summary of ' . exhibit('title')),'bodyid'=>'exhibit','bodyclass'=>'summary')); ?>
<div id="primary">
<h1><?php echo html_escape(exhibit('title')); ?></h1>
<?php echo exhibit_builder_section_nav(); ?>

<h2><?php echo __('Description'); ?></h2>
<?php echo exhibit('description'); ?>

<h2><?php echo __('Credits'); ?></h2>
<p><?php echo html_escape(exhibit('credits')); ?></p>

<div id="exhibit-sections">	
	<?php set_exhibit_sections_for_loop_by_exhibit(get_current_exhibit()); ?>
	<h2><?php echo __('Sections'); ?></h2>
	<?php while(loop_exhibit_sections()): ?>
	<?php if (exhibit_builder_section_has_pages()): ?>
    <h3><a href="<?php echo exhibit_builder_exhibit_uri(get_current_exhibit(), get_current_exhibit_section()); ?>"><?php echo html_escape(exhibit_section('title')); ?></a></h3>
	<?php echo exhibit_section('description'); ?>
	<?php endif; ?>
	<?php endwhile; ?>
</div>
</div>
<?php foot(); ?>
 * 
 * 
 */ ?>
