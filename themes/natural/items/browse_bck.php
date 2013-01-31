<?php head(array('title'=>'Browse Items')); ?>
<script type="text/javascript"">
	window.onload = function() {
		preloadAll();
		hideAll();
		show('m05');
	}
</script>

<?php
if (function_exists('COinSMultiple')):
    COinSMultiple($items);
endif;
?>
<script type="text/javascript" language="javascript" src="http://www.sciencetweets.eu/photochemistry/custom/glossary/jquery.js"></script>
<script type="text/javascript" language="javascript" src="http://www.sciencetweets.eu/photochemistry/custom/glossary/pager.js"></script>
<?php if($_GET["collection"]) echo '<div id="h4_wrapper"><h4>Collection: '.$_GET["title"].'</h4></div>';?>
<div id="content" style="overflow:auto; width:570px; height:310px; text-align:center;">
<div id='content_paging'>
	<div id="primary" class="browse">
		<?php echo htmlentities($_GET['tag']);?>
		<div class="pagination top"><?php echo pagination_links(); ?></div>
		<?php foreach($items as $key => $item): ?>
			<div class="glossary_results" style="text-align:left;">
				<div class="item-meta" style="border-bottom: 1px solid #D3EAF8;height: 150px;">
				<div style="width:250px;text-align:left;margin: 10px;font-weight:bold;"><?php echo link_to_item($item, 'show', null, array('class'=>'permalink')); ?></div>

				<?php if(has_thumbnail($item)): ?>
				<div class="item-img" style="text-align:left">
					<?php //echo link_to_square_thumbnail($item); 
					$id = $item->id;
					include('./custom/collections/item_photo.php'); echo $hmtl_photo;?>						
				</div>
				<? else: ?>
					<div class="item-description">
    				<p><?php echo //snippet($text,0,250); 
					$item->description ?></p>
    				</div>
					<div class="item-description">
    				<p><?php echo //snippet($text,0,250); 
					$item->links_to_collections ?></p>
    				</div>
				<?php endif; ?>

				<?php if($text = item_metadata($item,'Text')): ?>
	    			<div class="item-description">
    				<p><?php echo snippet($text,0,250); ?></p>
    				</div>
				<?php elseif(!empty($item->description)): ?>
    				<div class="item-description">
    				<?php echo nls2p(h(snippet($item->description, 0, 250))); ?>
    				</div>
				<?php endif; ?>

				<?php /*if(count($item->Tags)): ?>
				<div class="tags"><p><strong>Tags:</strong>
				<?php echo tag_string($item, uri('items/browse/tag/')); ?></p>
				</div>
				<?php endif;*/?>

				</div>
			</div>
		<?php endforeach; ?>
		<div class="pagination bottom"><?php echo pagination_links(); ?></div>
			
	</div>
	</div>
</div>
	<!-- An empty div which will be populated using jQuery -->
	<br>
	<div id='page_navigation' class="page_navigation" align="center"></div>
	
<div id="progressbar" style="position:absolute;top:430px;">
		<?php
			if ($_GET["type"] && $_GET["tags"] && $tot_num_res>0) echo pageSplit($query_string, $startPos, 5,  $tot_num_res);
		?>
		</div>
		<ul id="videolinks">
		<li><div class="dialog">
		 <div class="content">
		  <div class="t"></div>
			<a href="#"><img src="./themes/eknownetv2/images/videolink_01.jpg" width="48" height="48" alt="" class="corner iradius4"></a>
		 </div>
		 <div class="b"><div></div></div>
		</div></li>
		<li><div class="dialog">
		 <div class="content">
		  <div class="t"></div>
			<a href="#"><img src="./themes/eknownetv2/images/videolink_02.jpg" width="48" height="48" alt="" class="corner iradius4"></a>
		 </div>
		 <div class="b"><div></div></div>
		</div></li>
		<li><div class="dialog">
		 <div class="content">
		  <div class="t"></div>
			<a href="#"><img src="./themes/eknownetv2/images/videolink_03.jpg" width="48" height="48" alt="" class="corner iradius4"></a>
		 </div>
		 <div class="b"><div></div></div>
		</div></li>
		<li><div class="dialog">
		 <div class="content">
		  <div class="t"></div>
			<a href="#"><img src="./themes/eknownetv2/images/videolink_04.jpg" width="48" height="48" alt="" class="corner iradius4"></a>
		 </div>
		 <div class="b"><div></div></div>
		</div></li>
		</ul>
		
		<ul id="resources_home">
		<li><a onclick="getItemLinks(this)" id="tabLinks" name="Protein/p53/Other methods/p. protein representations/p. enzyme Adenylate Kinase"  href="javascript:void(0);">Links</a></li>
		<li><a onclick="getItemImages(this)" id="tabImages" name="Protein/p53/Other methods/p. protein representations/p. enzyme Adenylate Kinase" href="javascript:void(0);">Images</a></li>
		<li><a onclick="getItemVideo(this)" id="tabVideo" name="Protein/p53/Other methods/p. protein representations/p. enzyme Adenylate Kinases" href="javascript:void(0);">Video</a></li>
		<li><a onclick="getItemGames(this)" id="tabGames/Activities" name="Protein/p53/Other methods/p. protein representations/p. enzyme Adenylate Kinase" href="javascript:void(0);">Games/Activities</a></li>
		</ul>
		
		<div id="info_full">
		<p>"Voyage to the heart of a cell"<br />
		Structure / Shapes / Role<br />
		<a href="#">Proteins, the chemistry of life</a></p>
	</div>
<?php foot(); ?>