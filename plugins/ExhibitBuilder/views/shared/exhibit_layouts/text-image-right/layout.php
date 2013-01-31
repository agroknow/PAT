<!-- code added for natural europe project!!! -->
<?php 
$section=get_current_exhibit_section();
foreach ($section->Pages as $key => $page) { ?>
		
		<?php 
		$checki=0;
		for ($i=1; $i <= 12; $i++): 
		$item_page_id=$page->ExhibitPageEntry[$i]->Item->id;
		$text = exhibit_builder_page_text($i,$page);
			if(strlen($text)>0 || $item_page_id>0): ?>
        <?php 
		 $textcheck = $page->ExhibitPageEntry[$i]->text;
		 if (($textcheck!='<p>Put text here</p>' and $textcheck!='Put text here' and strlen($textcheck)>0) or $item_page_id>0){
		 $checki+=1; }
		 
		 ?>
        <?php endif;?>
		<?php endfor;?>

<div class="image-list-right">
				<?php //echo $checki; 
				if($checki>0){ ?>
<div id="title"><h3 style="background:none repeat scroll 0 0 #FFFFFF; width:600px; height:24px; margin:0 0 5px 0; font:15px/18px Arial,sans-serif; color:000000;"><?php echo __($page->title); ?></h3> </div>
		<?php for ($i=1; $i <= 12; $i++):
		$item_page_id=$page->ExhibitPageEntry[$i]->Item->id;
		$text = exhibit_builder_page_text($i,$page);
			if(strlen($text)>0 || $item_page_id>0): ?>
    		    <div class="exhibit-item">
               
    		        <div class="item-text">
					<?php $text = $page->ExhibitPageEntry[$i]->text;
	//$pieces = explode('h4',$text);
	//$text = substr($pieces[2],1);
	if ($text!='<p>Put text here</p>'){
	echo nls2p($text);} ?>
					</div>
                    
                     <?php  if($item =$page->ExhibitPageEntry[$i]->Item and $item['public']==1):?>
				<?php 
				$exhibit=exhibit_builder_get_current_exhibit();
				//print_r($exhibit);break;
				$item =$page->ExhibitPageEntry[$i]->Item;
				//echo $item->id;
				//echo exhibit_builder_exhibit_fullsize($item);
				echo "<span>";
				echo "<a href='".uri('items/show/')."".$item['id']."?eidteaser=".$exhibit->id."".target($start=0)."'>";
				echo viewhyperlinkimage($page->ExhibitPageEntry[$i]->Item->id);
				
				echo $page->ExhibitPageEntry[$i]->caption;
				echo "</a>";
				echo "</span>";
					//echo exhibit_builder_exhibit_display_item(array('imageSize'=>'fullsize'), array('class'=>'permalink'),$item); ?>
			<?php //echo exhibit_builder_exhibit_display_caption($i,$page); ?>
            <br>&nbsp;
				<?php endif;?>
                    
    		    </div>
    		<?php endif;?>
		<?php endfor;?>
        		<?php }//if checki>0 ?>
</div>
<?php } ?>

<!-- original code that omeka has!!! -->
<?php /* ?>
<div class="text-image-right">
	<div class="primary">
		<?php if(exhibit_builder_use_exhibit_page_item(1)):?>
		<div class="exhibit-item">
			<?php echo exhibit_builder_exhibit_display_item(array('imageSize'=>'fullsize'), array('class'=>'permalink')); ?>
			<?php echo exhibit_builder_exhibit_display_caption(1); ?>
		</div>
		<?php endif; ?>
	</div>
	<div class="secondary">		
		<div class="exhibit-text">
			<?php echo exhibit_builder_page_text(1); ?>
		</div>
	</div>
</div>
 * <?php */ ?>
 