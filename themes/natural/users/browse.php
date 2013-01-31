<?php head();?>

<div id="page-body" class="one_column">
<?php include ("./themes/natural/common/menu.php") ?>
<div class="column" id="column-c">
 <h1 class="section_title">Natural Europe Registration Form</h1>
 <h2 class="section_sub_title">Enter your information below</h2>	
			<div id="form_container">
					<form id="new-user-form" action="<?php echo uri('users/add'); ?>" method="post" accept-charset="utf-8">
						<?php common('form', array(), 'users'); ?>
						
						<input class="submit" type="submit" name="submit" value="Register" />
					</form>
					
				</div>
			</div>
<div class="clear"></div><!--clear DIV NEEDS TO BE ADDED TO ALL TEMPLATES-->
</div><!--end page-body div-->
<div class="clear"></div><!--clear DIV NEEDS TO BE ADDED TO ALL TEMPLATES-->
</div><!--end page-container div-->
<?php foot(); ?>
