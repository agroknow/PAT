<?php head(array('title'=>'Browse Items')); ?>

<!-- Gia pagging -->
<script type="text/javascript" language="javascript" src="http://www.sciencetweets.eu/photochemistry/themes/natural/jcarousel/lib/jquery-1.2.3.pack.js"></script>
<script type="text/javascript" language="javascript" src="http://www.sciencetweets.eu/photochemistry/themes/natural/items/pager.js"></script>

<!-- the input fields that will hold the variables we will use -->
	<input type='hidden' id='current_page' />
	<input type='hidden' id='show_per_page' />
<!-- end gia pagging -->	
<div id="page-body" class="one_column">
<?php require_once('./themes/natural/common/menu.php'); 

				$targetteam="";
if(isset($_GET["target"])){$targetteam="&target=".$_GET["target"]."";}
if(isset($_GET["section"])){$targetteam="&section=".$_GET["section"]."";}
?>

<div class="column" id="column-c">
<?php if($_GET["collection"]){ echo '<h1 class="section_title">Collection: '.$_GET["title"].'</h1>';?>

		<ul id="content_paging" class="wc_listing"><!-- Gia pagging -->
		
		<?php foreach($items as $key => $item): ?>
		<li>
							
			<div class="wc_photo">
			<?php if($item->source){ 
			if(stripos($item->source,'.jpg')>0 or stripos($item->source,'.jpeg')>0 or stripos($item->source,'.gif')>0 or stripos($item->source,'.png')>0 or stripos($item->source,'.bmp')>0){
			?>
			<img src="http://www.sciencetweets.eu/photochemistry/custom/phpThumb/phpThumb.php?src=<?php echo $item->source; ?>&amp;w=135" border="0">
			<?php } } ?>
			<p class="wc_photo-caption">
			
								    <?php if(has_type($item)): ?>
            
            <!-- This loop outputs all of the extended metadata -->
            <?php foreach( $item->TypeMetadata as $field => $text ): ?>
              
				
				<?php if (strlen(nls2p($text))>2):
					
					$itemt = str_replace("[M]", $iconM, $text);
			$itemt = str_replace("[E]", $iconE, $itemt);
			$itemt = str_replace("[A]", $iconA, $itemt);
			$itemt = addExternalIcon($itemt);
					
					echo strip_tags(nls2p($itemt),'<b><i>'); ?>
				<?php endif; ?>
           
            <?php endforeach; ?>
            
	    <?php endif; ?>  
			
			</p>
			</div>
			<div class="wc_metadata">
			 <div class="wc_description">
			 <?php if($item->description && h($item->Type->name)=='e-knownet collection item'): ?>
            <?php echo html_entity_decode(h($item->description)); ?>
        <?php endif; ?></div>
		
            <p class="wc_created-by">Created by: <strong>
			<?php if($item->creator): ?>

            <?php echo nls2p(h($item->creator)); ?>
	    <?php endif; ?>
			</strong></p>
			
			
			
            <p class="wc_source">Source<br />
			<?php if($item->source): ?>
			<a href="<?php echo $item->source; ?>" title="<?php echo $item->source; ?>">
	        <?php echo $item->source; ?>
			</a>
	    <?php endif; ?>
			
			</div>
			
				
					
    
		
    				
				
</li>


		<?php endforeach; ?>
		</ul>  <!-- //end content_paging -->
				<!--  Gia pagging  An empty div which will be populated using jQuery -->





<?php } else{?>
		<?php echo htmlentities($_GET['tag']);?>
		<!--<div class="pagination top"><?php //echo pagination_links(); ?></div> -->
		<div id='content_paging'><!-- Gia pagging -->
		
		<?php foreach($items as $key => $item): ?>
		<div>
				<div style="text-align:left;font-weight:bold;"><a href="<?php echo uri('items/show/').$item->id.$targetteam; ?>"><?php echo $item->title; ?></a></div>

			
			<div style="float:left;">
			<?php if($item->source){ ?>
			<a href="<?php echo uri('items/show/').$item->id.$targetteam; ?>"><img src="http://www.sciencetweets.eu/photochemistry/custom/phpThumb/phpThumb.php?src=<?php echo $item->source; ?>&amp;w=135" border="0"></a>
			<?php } ?>
			</div>
			<div style="float:left;">
				
					<div class="item-description">
    				<p><?php echo //snippet($text,0,250); 
					$item->description ?></p>
    				</div>
					<div class="item-description2">
    				<p><?php echo //snippet($text,0,250); 
					$item->links_to_collections ?></p>
    				</div>
				
				<?php if($text = item_metadata($item,'Text')): ?>
	    			<div class="item-description">
    				<p><?php echo snippet($text,0,250); ?></p>
    				</div>
				<?php elseif(!empty($item->description)): ?>
    				<div class="item-description">
    				<?php if (!$_GET["collection"]) echo nls2p(h(snippet($item->description, 0, 250))); ?>
    				</div>
				<?php endif; ?>

				<?php /*if(count($item->Tags)): ?>
				<div class="tags"><p><strong>Tags:</strong>
				<?php echo tag_string($item, uri('items/browse/tag/')); ?></p>
				</div>
				<?php endif;*/?>
</div>
<div style="clear:both;"></div>
</div>

		<?php endforeach; ?>
		</div>  <!-- //end content_paging -->
				<!--  Gia pagging  An empty div which will be populated using jQuery -->
				
				
				<?php } ?>

			<div id='page_navigation' class="page_navigation"></div>
			


<div id="progressbar" style="position:absolute;top:430px;">
		<?php
			if ($_GET["type"] && $_GET["tags"] && $tot_num_res>0) echo pageSplit($query_string, $startPos, 5,  $tot_num_res);
		?>
		</div>
		<div class="clear"></div><!--clear DIV NEEDS TO BE ADDED TO ALL TEMPLATES-->
</div><!--end page-body div-->
<div class="clear"></div><!--clear DIV NEEDS TO BE ADDED TO ALL TEMPLATES-->
</div><!--end page-container div-->

<?php foot(); ?>