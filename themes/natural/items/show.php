<?php head(array('title' => h($item->title))); ?>

<?php // echo '<div id="h4_wrapper"><h4>Collection: <a href="'.uri('items/browse/collection/?').'collection='.$item->Collection->id.'&title='.$item->Collection->name.'">'.$item->Collection->name.'</a></h4></div>';?>

<?php if ($_GET["eidteaser"]){ ?>
<div id="page-body" class="two_column">
<?php } else{ ?>
<div id="page-body" class="one_column">
<?php } ?>
<?php require_once('./themes/natural/common/menu.php'); ?>

<?php if ($_GET["eidteaser"]){ ?>
<div class="column" id="column-d">
<?php } else{ ?>
<div class="column" id="column-c">
<?php } ?>

<?php if($_GET["collection"]){ 

echo '<h1 class="section_title">WEB COLLECTIONS<br />'.$_GET["collection"].'</h1>';
?>
<div style="float:left; width:320px;">

<?php if($item->source): ?>
	        <div id="source" class="field">
            <div class="field-value"><a href="<?php echo $item->source;?>" target="_blank"><img src="http://www.sciencetweets.eu/photochemistry/custom/phpThumb/phpThumb.php?src=<?php echo $item->source; ?>&amp;w=135"></a></div>
            </div>
	    <?php endif; ?>
		
		<div id="extended-metadata">
	    <?php if(has_type($item)): ?>
            
            <!-- This loop outputs all of the extended metadata -->
            <?php foreach( $item->TypeMetadata as $field => $text ): ?>
                <div id="<?php echo text_to_id($field); ?>" class="field">
				<?php if (strlen(nls2p($text))>2):?>
				<?php if (h($field)!='Tip'):?>
                    <h2>Caption</h2>
				<?php endif; ?>
                    <div class="field-value"><?php 
					
					$itemt = str_replace("[M]", $iconM, $text);
			$itemt = str_replace("[E]", $iconE, $itemt);
			$itemt = str_replace("[A]", $iconA, $itemt);
			$itemt = addExternalIcon($itemt);
					
					echo nls2p($itemt); ?></div>
				<?php endif; ?>
                </div>
            <?php endforeach; ?>
            
	    <?php endif; ?>

	</div>

		
		
</div>
<div style="float:left;width:320px;">	

<?php if($item->description && h($item->Type->name)=='e-knownet collection item'): ?>
            <div class="field">
            <h3>More...</h3>
            <div class="field-value"><?php echo html_entity_decode(h($item->description)); ?></div>
            </div>
        <?php endif; ?>
		
				

</div>	
<div style="clear:both;"></div>
<div>

<?php if($item->creator): ?>
	        <div id="creator" class="field" style="float:left;width:320px;">
            <h3>Created by</h3>
            <div class="field-value"><?php echo nls2p(h($item->creator)); ?></div>
            </div>
	    <?php endif; ?>

<?php if($item->source): ?>
	        <div id="source" class="field" style="float:left;width:320px;">
            <h2>Source</h2>
            <div class="field-value"><p><?php echo $item->source; ?></p></div>
            </div>
	    <?php endif; ?>
</div>	
		
		
		
<?php } else{ ?>



<h1 class="section_title">

 
		 <?php $datetime = strtotime($exhibitteaser->date_modified); $mysqldate = date("d/m/Y", $datetime); $exhibitteaser->date_modified; //echo  $mysqldate; ?>
<?php 
if($exhibitteaser->title){ echo h($exhibitteaser->title).'<span class="last_modified">Last Modified:'.$mysqldate.' </span>'; }
if($item->title) echo "<h2 class='section_sub_title'> ".$item->title."</h2>"; else echo 'Untitled'; ?></h1>
<!--  The following is extended metadata that is assigned based on the Type that is assigned to an item -->
			<?php 
	$iconM = '<img alt=""  class="level_bullets" src="'.uri('themes/natural/images/bullet_medium.gif').'"/>';
	$iconE = '<img alt=""  class="level_bullets" src="'.uri('themes/natural/images/bullet_easy.gif').'"/>';
	$iconA = '<img alt=""  class="level_bullets" src="'.uri('themes/natural/images/bullet_advanced.gif').'"/>';
	        ?>
	<!--<div id="extended-metadata">
	    <?php //if(has_type($item)): ?>
	        <div id="item-type">
            <h2>Item Type</h2>
            <div class="field-value"><//?php echo h($item->Type->name); ?></div>
            </div>-->
            <!-- This loop outputs all of the extended metadata -->
			

            <?php //foreach( $item->TypeMetadata as $field => $text ): ?>
			
			<!--Link to web collection -->
			<?php // if (h($field)=='Link to web collection'): ?>
               <!-- <div id="<?php //echo text_to_id($field); ?>" class="field">
                    <h3><?php //echo h($field); ?></h3>
                    <div class="field-value"><?php //echo nls2p($text); ?></div>
                </div>
			<?php //endif;?>
            <?php //endforeach; ?>
            
	    <?php //endif; ?>

	</div>-->
	
	    <?php if(has_type($item)): ?>
            
            <!-- This loop outputs all of the extended metadata -->
            <?php foreach( $item->TypeMetadata as $field => $text ): ?>
               
				<?php if (strlen(nls2p($text))>2):?>
				<?php if (h($field)!='Tip'):?>
                    <h4 class="panel-exhibit_gialink"><?php echo h($field); ?></h4>
				<?php endif; ?>
                    <ul class="resource_list" id="content_paging"><?php 
					
					$itemt = str_replace("[M]", $iconM, $text);
			$itemt = str_replace("[E]", $iconE, $itemt);
			$itemt = str_replace("[A]", $iconA, $itemt);
			$itemt = addExternalIcon($itemt);
					
					echo "<li>".nls2p($itemt)."</li>"; ?>
					 </ul>
				<?php endif; ?>
               
            <?php endforeach; ?>
            
	    <?php endif; ?>

	
	<?php if(!$exhibitteaser->title){ ?>
	<div id="itemfiles" >
		<?php echo display_files($item->Files); ?>
		<?php echo nls2p(h($item->File->Description)); ?>
	</div>
	<?php  } ?>
	
	
	<div id="item-metadata">

<!-- The following is dublin core metadata.  You can remove these fields if you do not wish
    to display that data on the public theme -->

	    <?php if($item->publisher): ?>
	        <div id="publisher" class="field">
            <h3>Publisher</h3>
            <div class="field-value"><?php echo nls2p(h($item->publisher)); ?></div> 
            </div>   
	    <?php endif; ?>
	
	    <?php if($item->creator): ?>
	        <div id="creator" class="field">
            <h3>Creator</h3>
            <div class="field-value"><?php echo nls2p(h($item->creator)); ?></div>
            </div>
	    <?php endif; ?>
	

        <?php if($item->description && h($item->Type->name)=='e-knownet collection item'): ?>
            <div class="field">
            <h3>Description</h3>
            <div class="field-value"><?php echo html_entity_decode(h($item->description)); ?></div>
            </div>
        <?php endif; ?>
	    	    
	    <?php if($item->relation): ?>
	        <div id="relation" class="field">
            <h2>Relation</h2>
            <div class="field-value"><?php echo nls2p(h($item->relation)); ?></div>
            </div>
	    <?php endif; ?>
	    
	    <?php if($item->spatial_coverage): ?>
	        <div id="spatial-coverage" class="field">
            <h2>Spatial Coverage</h2>
            <div class="field-value"><?php echo nls2p(h($item->spatial_coverage)); ?></div>
            </div>
	    <?php endif; ?>
	    
	    <?php if($item->rights): ?>
	        <div id="rights" class="field">
            <h2>Rights</h2>
            <div class="field-value"><?php echo nls2p(h($item->rights)); ?></div>
            </div>
	    <?php endif; ?>
	    
	    <?php if($item->source): ?>
	        <div id="source" class="field">
            <h2>Source</h2>
            <div class="field-value"><?php echo $item->source; ?></div>
            </div>
	    <?php endif; ?>
	    
	    <?php if($item->subject): ?>
	        <div id="subject" class="field">
            <h2>Subject</h2>
            <div class="field-value"><?php echo nls2p(h($item->subject)); ?></div>
            </div>
	    <?php endif; ?>
	    
	    <?php if($item->additional_creator): ?>
	        <div id="additional-creator" class="field">
            <h2>Additional Creator</h2>
            <div class="field-value"><?php echo nls2p(h($item->additional_creator)); ?></div>
            </div>
	    <?php endif; ?>
	    
	    <?php if($item->format): ?>
	        <div id="format" class="field">
            <h2>Format</h2>
            <div class="field-value"><?php echo nls2p(h($item->format)); ?></div>
            </div>
	    <?php endif; ?>
	    
	    <?php if($item->contributor): ?>
	        <div id="contributor" class="field">
            <h2>Contributor</h2>
            <div class="field-value"><?php echo nls2p(h($item->contributor)); ?></div>
            </div>
	    <?php endif; ?>
	    
	    <?php if($item->rights_holder): ?>
	        <div id="rights-holder" class="field">
            <h2>Rights Holder</h2>
            <div class="field-value"><?php echo nls2p(h($item->rights_holder)); ?></div>
            </div>
	    <?php endif; ?>
	    
	    <?php if($item->provenance): ?>
	        <div id="provenance" class="field">
            <h2>Provenance</h2>
            <div class="field-value"><?php echo nls2p(h($item->provenance)); ?></div>
            </div>
	    <?php endif; ?>
	    
	    <?php if($item->date): ?>
	        <div id="date" class="field">
            <h2>Date</h2>
            <div class="field-value"><?php echo nls2p(date('m.d.Y', strtotime($item->date))); ?></div>
            </div>
	    <?php endif; ?>
	    
	    <?php if($item->temporal_coverage_start): ?>
	        <div id="temporal-coverage" class="field">
            <h2>Temporal Coverage</h2>
            <div class="field-value">
                <?php echo date('m.d.Y', strtotime($item->temporal_coverage_start)); ?> 
                - <?php echo date('m.d.Y', strtotime($item->temporal_coverage_end)); ?></div>
            </div>
	    <?php endif; ?>
	    
		<!-- 
	    <div id="date-added" class="field">
        <h2>Date Added</h2>
        <div class="field-value"><?php //echo nls2p(date('m.d.Y', strtotime($item->added))); ?></div>
	    </div>-->
	    <?php // $height = 250; $id = $item->id; include('./custom/collections/item_photo.php'); echo $hmtl_photo;?>
	    <?php if ( has_collection($item) ): ?>
    	    <!--<div id="collection" class="field">
            <h3>Collection</h3>
            <div class="field-value"><p><a href="<?php //echo uri('items/browse/collection/?').'collection='.$item->Collection->id.'&title='.$item->Collection->name.'';?>"><?php //echo $item->Collection->name?></a></p></div>
            </div>-->
    	<?php endif;?>
	
	</div> <!--End Dublin Core metadata -->

	
	

	<?php //if(count($item->Tags)): ?>
	<!--<div class="tags">
		<h3>Tags:</h3>
	   <?php //echo tag_string($item->Tags, uri('items/browse/tag/'), "\n"); ?>	
	</div>-->
	<?php //endif;?>
	
	<!-- <div id="citation" class="field">
    	<h2>Citation</h2>
    	<div id="citation-value" class="field-value"><?php //echo nls2p($item->getCitation()); ?></div>
	</div> -->
<?php } //else collection?>	

</div><!-- column d -->
<?php if ($_GET["eidteaser"]){ ?>


<div class="column" id="column-e">


	<div class="panel-exhibit">
<?php echo  exhibit_picture($exhibitteaser->id,'220','show'); ?>
			<?php
			echo "<ul>";
				teaser('1',$exhibitteaser->id,'Teaser'); 
				teaser('2',$exhibitteaser->id,'Teaser'); 
				teaser('3',$exhibitteaser->id,'Teaser');
				teaser('4',$exhibitteaser->id,'Teaser');
				echo "</ul>";
			 ?>

	</div><!-- end div.panel -->
	
	
	<div class="divider column-e"></div>
	<div class="panel sidebar intro">
	<a id="panel-exhibitlink" onclick='clearItemInfo();' href="javascript:void(0);"></a>
	<div class="scroll-pane"><!--ADD SCROLL PANE DIV WITH JAVASCRIPT WHEN MENU SCROLLS WITH THE PAGE TO REPLACE DEFAULT SCROLLBAR?-->
	<div class="panel sidebar resources">
	<h2 class="title_sel" id="title">Explore further</h2>	
		<div class="panel-intro" id="item-tip">
			Click on a term of the exhibit and learn more by exploring:
		</div><!-- end div.panel-intro -->	
		<div id="panel-exhibit_gialink"><h4 class="panel-exhibit_gialink">Images</h4>	</div>
		<div class="panel-intro" id="image-resources">
		</div><!-- end div.panel-intro -->	
		<div id="panel-exhibit_gialink"><h4 class="panel-exhibit_gialink">Videos</h4>	</div>
		<div class="panel-intro" id="video-resources">	
		</div><!-- end div.panel-intro -->	
		<div id="panel-exhibit_gialink"><h4 class="panel-exhibit_gialink">Links</h4>	</div>
		<div class="panel-intro" id="links-resources">
			
		</div><!-- end div.panel-intro -->
		
	
		<?php
		
		
					if(isset($_GET['target'])){
			
				if($_GET['target']=='students'){ 
				
				$data7=get_db()->getTable('Teasers')->findBySql('exhibit_id = ? and type = ?',
				array($exhibitteaser->id,'Testtime'),true); 
				if(isset($data7['id'])){echo "<br /><h3 class='title_sel'>Test time</h3>";}
				echo "<ul>";
			teaser('1',$exhibitteaser->id,'Testtime'); 
			teaser('2',$exhibitteaser->id,'Testtime'); 
			teaser('3',$exhibitteaser->id,'Testtime');
			teaser('4',$exhibitteaser->id,'Testtime');
			echo "</ul>";
			
			$data7=get_db()->getTable('Teasers')->findBySql('exhibit_id = ? and type = ?',
				array($exhibitteaser->id,'Students reality'),true); 
				if(isset($data7['id'])){echo "<br /><h3 class='title_sel'>Links to students reality</h3>";}
			echo "<ul>";
			teaser('1',$exhibitteaser->id,'Students reality'); 
			teaser('2',$exhibitteaser->id,'Students reality'); 
			teaser('3',$exhibitteaser->id,'Students reality');
			teaser('4',$exhibitteaser->id,'Students reality');
			echo "</ul>";
				}
			}
			else {
			
			$data7=get_db()->getTable('Teasers')->findBySql('exhibit_id = ? and type = ?',
				array($exhibitteaser->id,'self evaluation activities'),true); 
				if(isset($data7['id'])){echo "<br /><h3 class='title_sel'>Self evaluation activities</h3>";}
			echo "<ul>";
			teaser('1',$exhibitteaser->id,'self evaluation activities'); 
			teaser('2',$exhibitteaser->id,'self evaluation activities'); 
			teaser('3',$exhibitteaser->id,'self evaluation activities');
			teaser('4',$exhibitteaser->id,'self evaluation activities');
			echo "</ul>";
			}
			 ?>
</div><!-- end div.panel -->
	</div>
	</div>
	</div>
	<?php }//if get eidteaser?>

		<div class="clear"></div><!--clear DIV NEEDS TO BE ADDED TO ALL TEMPLATES-->
</div><!--end page-body div-->
<div class="clear"></div><!--clear DIV NEEDS TO BE ADDED TO ALL TEMPLATES-->
</div><!--end page-container div-->
<?php foot(); ?>
