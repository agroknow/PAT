<?php head(array('title'=>'Resources')); ?>
<div id="page-body" class="one_column">
<?php common('menu'); ?>
<div class="column" id="column-c">

		<h1 class="section_title">Resources
		<?php //if (isset($_GET["type"])) echo '&nbsp;&nbsp;&nbsp;Category: '.$_GET["type"].''; 
			if (isset($_GET["tags"])) echo ' tagged with: '.$_GET["tags"].'';?></h1>
		<?php // Check the target group
		if (isset($_GET["target"])){ $target_add = '&target='.$_GET["target"];}
		elseif (isset($_GET["section"])){ $target_add = '&section='.$_GET["section"];}
		 else $target_add='';?>
				
		<?php if($_GET["tags"]):?>
		<ul id="explore_home0">
		<li <?php if ($_GET["type"]=="Images") echo 'class="selected"'?>><a href="<?php echo 'resources?type=Images&tags='.$_GET["tags"].$target_add; ?>">Images</a></li>
		<li class="divider">|</li>
		<li <?php if ($_GET["type"]=="Video") echo 'class="selected"'?>><a href="<?php echo 'resources?type=Video&tags='.$_GET["tags"].$target_add; ?>">Video</a></li>
		<li class="divider">|</li>
		<li <?php if ($_GET["type"]=="Games/Activities") echo 'class="selected"'?>><a href="<?php echo 'resources?type=Games/Activities&tags='.$_GET["tags"].$target_add; ?>">Games/Activities</a></li>
		<li class="divider">|</li>
		<li <?php if ($_GET["type"]=="Links") echo 'class="selected"'?>><a href="<?php echo 'resources?type=Links&tags='.$_GET["tags"].$target_add; ?>">Links</a></li>
		
		</ul>
		<?php else: ?>
		
		<?php endif; ?>
		

		<?php 
			// Call the php file or the function that performs queries to retrieve all the content according to the type
			//$type='Video';
			// FOR PAGING
			if (isset($_GET["startPos"]))
			{
				$offset = $_GET["startPos"]-1;
				$startPos=$_GET["startPos"];
				$query_string =$_SERVER['REQUEST_URI'];				
				$query_string_array = explode("&",$query_string);
				$query_string = $query_string_array["0"].'&'.$query_string_array["1"];
			}
			else
			{ 
			  $offset=0;
			  $startPos=1;
			  $query_string=$_SERVER['REQUEST_URI'];
			}
			
			if (!$_GET["type"] && !$_GET["tags"])
			{
				$_GET["type"] = 'Images';
				$tags=recent_tags(250);
				$type = '?type='.$_GET["type"];
				if (isset($_GET["target"]) or isset($_GET["section"])) $type .= $target_add;
				echo tag_cloud($tags,uri('resources'.$type));
			}
			else if (($_GET["type"]=='Images') && ($_GET["tags"]))
			{
				//echo 'This page will be available soon. <br> Thank you for your understanding';
				$type=$_GET["type"];
				$tags=$_GET["tags"];
				$tot_num_res = return_tot_num_resources($type, $tags);
				$tot_num_res =return_image_resources($type, $tags, $startPos, $offset, $tot_num_res);
				//echo $tot_num_res;
				//else echo 'No <b>'.strtolower($_GET["type"]).'</b> resources were found for <b>'.$tags=$_GET["tags"].'</b> tag <br> Please <a href="http://education.natural-europe.eu/natural_europe/resources?type='.$_GET["type"].'">try a different tag</a>';
			}
			else if ($_GET["type"] && $_GET["tags"])
			{
				$type=$_GET["type"];
				$tags=$_GET["tags"];
				$tot_num_res = return_tot_num_resources($type, $tags);
				//$type='Interactives';
				if ($tot_num_res>0) return_video_resources($type, $tags, $startPos, $offset, $tot_num_res);
				else echo 'No <b>'.strtolower($_GET["type"]).'</b> resources were found for <b>'.$tags=$_GET["tags"].'</b> tag <br> Please <a href="http://education.natural-europe.eu/natural_europe/resources?type='.$_GET["type"].'">try a different tag</a>';
			}
			else
			{
				$tags=recent_tags(250);
				$type = '?type='.$_GET["type"];
				if (isset($_GET["target"]) or isset($_GET["section"])) $type .= $target_add; 
				echo tag_cloud($tags,uri('/resources'.$type));
			}
		?>
		<?php if (!($_GET["type"] && $_GET["tags"]))
			{ ?>
		<div id="browse_link"><a href="<?php echo uri('resources?type=Images&tags=all').$target_add;?>">Browse all resources</a></div>
		<?php } ?>
		
		<div id="page_navigation" class="page_navigation">
		<?php
			if ($_GET["type"] && $_GET["tags"]){ 
			if($_GET["type"]=='Images'){echo pageSplit($query_string, $startPos, 16,  $tot_num_res);}
			else{echo pageSplit($query_string, $startPos, 5,  $tot_num_res);}
			}
		?>
		</div>
		</div>
		
<br style="clear:both"/>
</div>	
<div class="clear"></div><!--clear DIV NEEDS TO BE ADDED TO ALL TEMPLATES-->
</div><!--end page-body div-->
<div class="clear"></div><!--clear DIV NEEDS TO BE ADDED TO ALL TEMPLATES-->
</div><!--end page-container div-->
	
<?php foot(); ?>