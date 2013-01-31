<?php head(array('title'=>'Browse Collections')); ?>
<div id="page-body" class="one_column">
<?php require_once('./themes/natural/common/menu.php'); ?>

<div class="column <?php if(isset($_GET['target']) and $_GET['target']=='students'){ echo "students";} elseif(isset($_GET['target']) and $_GET['target']=='educators'){ echo "science_educators";} elseif(isset($_GET['target']) and $_GET['target']=='researchers'){ echo "researchers";} elseif(!(isset($_GET['target']) or isset($_GET['section']) or stripos($_SERVER['REQUEST_URI'],'/home')>0 or stripos($_SERVER['REQUEST_URI'],'/project')>0  or stripos($_SERVER['REQUEST_URI'],'/intro')>0 or stripos($_SERVER['REQUEST_URI'],'/users/add')>0 or stripos($_SERVER['REQUEST_URI'],'/contactus')>0)){ echo "lifelong_learners";} ?>" id="column-c">

<h1 class="section_title">Web Collections</h1>
			
<p>Here you will find interesting collections of digital photographs reflecting on Photochemistry related issues.
A simple software is provided to the users who wish to develop their own web collection.</p>
<div id="thumbs" class="navigation">
	<script type="text/javascript" language="javascript" src="<?php echo uri('themes/natural/javascripts/jquery.js'); ?>"></script>
 <script>
     jQuery.noConflict();
   </script>
<script type="text/javascript" language="javascript" src="<?php echo uri('themes/natural/pager.js'); ?>"></script>
<script type="text/javascript">
var show_per_page =10;
</script>
<!-- the input fields that will hold the variables we will use -->
	<input type='hidden' id='current_page' />
	<input type='hidden' id='show_per_page' />				

				<ul class="thumbs noscript" id="content_paging">
				<?php 
				$targetteam="";
if(isset($_GET["target"])){$targetteam="&target=".$_GET["target"]."";}
if(isset($_GET["section"])){$targetteam="&section=".$_GET["section"]."";}
				
				foreach ($collections as $collection ): ?>
						<li>								
								<div class="image-title"><?php echo $collection->name;//echo link_to_collection($collection);?></div>
								
								<?php $id = h($collection->id); $hmtl_photo='';?>
							<?php include('./custom/collections/collection_photo.php'); echo $hmtl_photo;?>
								
								<div class="image-desc"><?php $output=h($collection->description); echo html_entity_decode($output); ?></div>
								 
								<div class="image-credits"><p>The Collection was created by:
								<?php $count=1; foreach($collection->Collectors as $collector):?>
										<?php if($count>'1') echo ', '; ++$count;?>
									<?php echo "<strong>".h($collector->name)."</strong>";?>
									<?php endforeach; ?></p>
									</div>
									<div class="image-link"><p><a href="<?php $uri_part1 = uri('items/browse/', array('collection'=>$collection->id)); $uri_part2 = '&title='.h($collection->name); echo $uri_part1.$uri_part2.$targetteam; ?>">View the &quot;<?php echo h($collection->name); ?>&quot; collection</a></p>
								</div>
								
								
								</li>
				<?php endforeach; ?>
				</ul>
				</div><!--thumbs class="navigation"-->
				<div style="clear: both;"></div>
</div><!--div class="column" id="column-c"-->
<div class="clear"></div><!--clear DIV NEEDS TO BE ADDED TO ALL TEMPLATES-->
</div><!--end page-body div-->
<div class="clear"></div><!--clear DIV NEEDS TO BE ADDED TO ALL TEMPLATES-->
</div><!--end page-container div-->
		

<?php foot(); ?>