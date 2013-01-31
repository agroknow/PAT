<?php head();?>
<div id="page-body" class="one_column">
<?php include ("common/menu.php") ?>
<script type="text/javascript" language="javascript" src="<?php echo uri('themes/natural/javascripts/jquery.js');?>"></script>
 <script>
     jQuery.noConflict();
   </script>
<script type="text/javascript" language="javascript" src="<?php echo uri('themes/natural/pager.js');?>"></script>
<!-- the input fields that will hold the variables we will use -->
	<input type='hidden' id='current_page' />
	<input type='hidden' id='show_per_page' />		
		

					<div class="column" id="column-c">
			
			
			<div class="quick_links exhibits">
        	<h2 class="section_sub_title">Pathways Repository</h2>
						<script>
					var show_per_page = 15;
				</script>
				<ul id="content_paging" class="digital_exhibits">
			
			
	
								<?php 
		if($menuexhibits):
		$o=0;
		foreach( $menuexhibits as $key=>$exhibits2 ): 
		//check the target group of the exhibit

			
		 $o+=1;
			$exhibits2_id = (string) $exhibits2['id'];


				?>
				
						
			
            	<li>
                	<a href="<?php echo uri('exhibits/'.$exhibits2['slug']."/to-begin-with"); ?>" class="block"></a>
                    <?php echo  exhibit_picture($exhibits2['id'],'135','indexstund'); ?>
                    <div class="exhibit-data">
                    	<p><?php echo $exhibits2['title']; ?></p>
                    </div>
                    <a href="<?php echo uri('exhibits/'.$exhibits2['slug']."/to-begin-with"); ?>" class="more">GO NOW!</a>
                </li>
				
				
				
												
				<?php 
			

		endforeach; ?>
		<?php endif; ?>
		
</ul>
</div>
		<div id='page_navigation' class='page_navigation' ></div>		
		
		</div>
			
			
		</div><!-- end div.column #column-c -->
		
<div class="clear"></div><!--clear DIV NEEDS TO BE ADDED TO ALL TEMPLATES-->
</div><!--end page-body div-->
<div class="clear"></div><!--clear DIV NEEDS TO BE ADDED TO ALL TEMPLATES-->
</div><!--end page-container div-->
<?php foot(); ?>