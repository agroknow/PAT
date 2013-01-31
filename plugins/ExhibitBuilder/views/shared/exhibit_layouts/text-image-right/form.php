<fieldset class="<?php echo html_escape($layout); ?>">
	<?php for($i=1; $i<=4; $i++): ?>
	    <div class="section">
    	<?php 
		
		echo exhibit_builder_layout_form_item($i);
    	    echo exhibit_builder_layout_form_text($i);
    	    
    	?>
    	</div>
	<?php endfor; ?>
</fieldset>




<?php /* // regular code  ?>

<fieldset>
	<?php 
	    echo exhibit_builder_layout_form_item(1);
	    echo exhibit_builder_layout_form_text(1);
	?>
</fieldset>
 * <?php */ ?>
 
