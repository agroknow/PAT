<?php head(array('title'=>'Science Educators | Mapping Study and Survey')); ?>
<div id="page-body" class="one_column">
<?php common('menu'); ?>

<div class="column" id="column-c">
<h1 class="section_title">Useful links</h1>
<script type="text/javascript" language="javascript" src="<?php echo uri('themes/natural/jcarousel/lib/jquery-1.2.3.pack.js'); ?>"></script>
<script type="text/javascript" language="javascript" src="<?php echo uri('themes/natural/material/pager.js'); ?>"></script>
<!-- the input fields that will hold the variables we will use -->
	<input type='hidden' id='current_page' />
	<input type='hidden' id='show_per_page' />
		<?php 
require_once("./custom/general_content/func.php");
	print_r (item_select("21","Useful links")); 
		 ?>
		 <!--div gia paging -->
		<div id='page_navigation' class="page_navigation"></div>
		 <!--end div gia paging -->
		 </div>
<div class="clear"></div><!--clear DIV NEEDS TO BE ADDED TO ALL TEMPLATES-->
</div><!--end page-body div-->
<div class="clear"></div><!--clear DIV NEEDS TO BE ADDED TO ALL TEMPLATES-->
</div><!--end page-container div-->
<?php foot(); ?>