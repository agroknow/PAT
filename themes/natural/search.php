<?php head(array('title'=>'About')); ?>
<div id="page-body" class="one_column">
<?php common('menu'); ?>

		


	<div class="column" id="column-c">
<h1 class="section_title">Search</h1>
	
	<script type="text/javascript" language="javascript" src="<?php echo uri('themes/natural/javascripts/jquery.js'); ?>"></script>
	 <script>
		 jQuery.noConflict();
	   </script>
	<script type="text/javascript" language="javascript" src="<?php echo uri('themes/natural/pager.js'); ?>"></script>
	<script type="text/javascript" language="javascript" src="<?php echo uri('themes/natural/javascripts/main_tooltip.js'); ?>"></script>
	<!-- the input fields that will hold the variables we will use -->
		<input type='hidden' id='current_page' />
		<input type='hidden' id='show_per_page' />
		<div class="search_results_container">
		<?php 
	
	function giasql($string){
		//This function removes all characters we do not want
	
		$string = preg_replace("/[^0-9αβγδεζηθικλμνξοπρστυφχψωςόάέίύήϊΑ-Ωa-zA-Z-\/_ ]/", "", $string);
		return $string;
	}	
	
	
	if(isset($_GET['srch_wrd'])){
	
	  $search=giasql($_GET["srch_wrd"]);
	  $search = strtoupper($search);
	$search = strip_tags($search);
	$search = trim ($search); 
	$search = stripslashes($search);}
	
	elseif(isset($_POST['srch_wrd'])){
	
	  $search=giasql($_POST["srch_wrd"]);
	  $search = strtoupper($search);
	$search = strip_tags($search);
	$search = trim ($search);
	$search = stripslashes($search); }
	
	else {$search='protein';}
	
				   if(isset($search)){
	if(isset($_GET['collection'])){search_word_exhibit($search,collection);}
	elseif(isset($_GET['exhibit'])){search_word_exhibit($search,exhibit);}
	elseif(isset($_GET['image'])){search_word_exhibit($search,image);}
	elseif(isset($_GET['video'])){search_word_exhibit($search,video);}
	elseif(isset($_GET['Interactives'])){search_word_exhibit($search,Interactives);}
	elseif(isset($_GET['Links'])){search_word_exhibit($search,Links);}
	elseif(isset($_GET['Definition'])){search_word_exhibit($search,Definition);}
	elseif(isset($_GET['Games/Activities'])){search_word_exhibit($search,'Games/Activities');}
	else{	search_word_exhibit($search);}
					 }
					 else{
					 echo ("There is no word to search.");
					 }
	
		?>
		</div>
</div>

<div class="clear"></div><!--clear DIV NEEDS TO BE ADDED TO ALL TEMPLATES-->
</div><!--end page-body div-->
<div class="clear"></div><!--clear DIV NEEDS TO BE ADDED TO ALL TEMPLATES-->
</div><!--end page-container div-->
<?php foot(); ?>