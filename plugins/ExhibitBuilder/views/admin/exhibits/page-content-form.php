<script type="text/javascript" src="<?php  $uri = WEB_ROOT; echo $uri; ?>/themes/natural/scripts/ajax/ajax.js"></script>
<?php
require_once 'Omeka/Core.php';
$core = new Omeka_Core;

try {
    $db = $core->getDb();
   
    //Force the Zend_Db to make the connection and catch connection errors
    try {
        $mysqli = $db->getConnection()->getConnection();
    } catch (Exception $e) {
        throw new Exception("<h1>MySQL connection error: [" . mysqli_connect_errno() . "]</h1>" . "<p>" . $e->getMessage() . '</p>');
    }
} catch (Exception $e) {
	die($e->getMessage() . '<p>Please refer to <a href="http://omeka.org/codex/">Omeka documentation</a> for help.</p>');
}
?>
<?php
$exhibitPageTitle = __('Edit Page Content: "%s"', $exhibitPage->title);
?>
<?php head(array('title'=> html_escape($exhibitPageTitle), 'bodyclass'=>'exhibits')); ?>

<script type="text/javascript" charset="utf-8">
//<![CDATA[

    jQuery(document).ready(function(){

        var exhibitBuilder = new Omeka.ExhibitBuilder();        
		
		// Add styling
		exhibitBuilder.addStyling();
		
		// Set the exhibit item uri
		exhibitBuilder.itemContainerUri = <?php echo js_escape(uri('exhibits/item-container')); ?>;
		
		// Set the paginated exhibit items uri
		exhibitBuilder.paginatedItemsUri = <?php echo js_escape(uri('exhibits/items')); ?>;
		
		// Set the remove item background image uri
		exhibitBuilder.removeItemBackgroundImageUri = <?php echo js_escape(img('silk-icons/delete.png')); ?>;

        exhibitBuilder.removeItemText = <?php echo js_escape(__('Remove This Item')); ?>;        
		// Get the paginated items
		exhibitBuilder.getItems();

    	jQuery(document).bind('omeka:loaditems', function() {
   	        // Hide the page search form
    	    jQuery('#page-search-form').hide();

            jQuery('#show-or-hide-search').click( function(){
                var searchForm = jQuery('#page-search-form');
                if (searchForm.is(':visible')) {
                    searchForm.hide();
                } else {
                    searchForm.show();
                }
                
                var showHideLink = jQuery(this);
                showHideLink.toggleClass('show-form');
                if (showHideLink.hasClass('show-form')) {
                    showHideLink.text('Show Search Form');
                } else {
                    showHideLink.text('Hide Search Form');
                }
                return false;
            });
    	});
    	    	
    	// Search Items Dialog Box
         jQuery('#search-items').dialog({
     		autoOpen: false,
     		width: 820,
     		height: 500,
            title: <?php echo js_escape(__('Attach an Item')); ?>,
     		modal: true,
     		buttons: {
                <?php echo js_escape(__('Attach Selected Item')); ?>: function() { 
                    exhibitBuilder.attachSelectedItem();
     				jQuery(this).dialog('close'); 
     			} 
     		}
     	});
	});
	
    jQuery(window).load(function() {
        Omeka.ExhibitBuilder.wysiwyg();
        Omeka.ExhibitBuilder.addNumbers();
    });
    jQuery(document).bind('exhibitbuilder:attachitem', function (event) {
        // Add tinyMCE to all textareas in the div where the item was attached.
        jQuery(event.target).find('textarea').each(function () {
            tinyMCE.execCommand('mceAddControl', false, this.id);
        });
    });
//]]>    
</script>
<h1><?php echo html_escape($exhibitPageTitle); ?></h1>

<div id="primary">
<?php echo flash(); ?>

<div id="page-builder">
	<div id="exhibits-breadcrumb">
		<a href="<?php echo html_escape(uri('exhibits')); ?>"><?php echo __('Pathways'); ?></a> &gt;
        <a href="<?php echo html_escape(uri('exhibits/edit/' . $exhibit['id']));?>"><?php echo html_escape($exhibit['title']); ?></a>  &gt;
        <a href="<?php echo html_escape(uri('exhibits/edit-section/' . $exhibitSection['id']));?>"><?php echo __(html_escape($exhibitSection['title'])); ?></a>  &gt;
        <?php echo __(html_escape($exhibitPageTitle)); ?>
	</div>
    
    <?php //This item-select div must be outside the <form> tag for this page, b/c IE7 can't handle nested form tags. ?>
	<div id="search-items" style="display:none;">
		<div id="item-select"></div>
    </div>
    
    <form id="page-form" method="post" action="<?php echo html_escape(uri(array('module'=>'exhibit-builder', 'controller'=>'exhibits', 'action'=>'edit-page-content', 'id'=>$exhibitPage->id))); ?>">
           <div style="float:left; width:auto;float:left;">
   <div style=" text-align:left; width:auto;float:left;"><?php echo exhibit_builder_link_to_exhibit(NULL,''.__('Preview Pathway').'',$props= array('target' => 'blank','class' => 'button'),'to-begin-with'); ?></div>
   <br>
   <div style=""><a class="button" href="<?php $uri = WEB_ROOT; echo $uri; ?>/quality" target="_blank"><?php echo __('Quality Criteria for Natural Europe Pathways'); ?></a></div><br>
   </div>
     <?php $user = current_user(); ?>
<script language="javascript" type="text/javascript">
function addobject(){window.open('<?php echo $uri; ?>/custom/exhibits/teaser_add.php?ex_id=<?php echo $exhibit->id; ?>&sec_id=<?php echo $exhibitSection->id; ?>&pg_id=<?php echo $exhibitPage->id; ?>&uid=<?php echo $user['id']; ?>&entityid=<?php echo $user['entity_id']; ?>','mywindow','width=500,height=300')}
function addeuropeanaobject(){window.open('<?php echo $uri; ?>/europeanaapi?ex_id=<?php echo $section->exhibit_id; ?>&sec_id=<?php echo $section->id; ?>&pg_id=<?php echo $page->id; ?>','mywindow','width=640,height=600,resizable=yes,scrollbars=yes')}
</script>
<script type="text/javascript">
var ajax = new Array();

function deleteObject(id){
var index = ajax.length;
		ajax[index] = new sack();
		ajax[index].requestFile = '<?php echo $uri; ?>/custom/exhibits/deleteobjects.php?ts_id='+id+'';
		//portal/themes/eknownetv3
		ajax[index].onCompletion = function(){ showItemInfo(index) };	// Specify function that will be executed after file has been found
		ajax[index].runAJAX();		// Execute AJAX function
}
function showItemInfo(index)
{
	var obj = document.getElementById('text_supporting');
	//alert(eval(ajax[index].response));
	document.getElementById('text_supporting').innerHTML=ajax[index].response;

}
</script>

    <div style="margin-top:0px; min-height:100px; background:none repeat scroll 0 0 #F0F0F0; float:right; width:378px; text-align:left;">
	<div style=" float:left; padding-left:12px;"><a href="javascript:addobject();" onclick="javascript:addobject();" class="button" style=""><?php echo __('Click to add Supporting Materials'); ?></a>
	</div>
	<div style="padding-left:12px; text-align:left; clear:both;font-style:italic;"><?php echo __('Resources that will be added here serve as <br> complementary to the items attached on the pathway'); ?></div>
	<hr style="border:1px dotted #CCCCCC; clear:both;"><br>	
	<div id="text_supporting">
	<?php 
$sql2="SELECT a.*,c.text FROM omeka_teasers a JOIN omeka_items b ON a.item_id=b.id JOIN omeka_element_texts c ON a.item_id=c.record_id WHERE a.exhibit_id=".$exhibit->id." and a.pg_id=".$exhibitPage->id." and a.type!='europeana' and c.element_id=68";
$exec2=$db->query($sql2); 
while ($data2=$exec2->fetch()){
	//echo $data2['title'];
		?>
		<div id="pagedelete" style="padding-top:6px;">
		<a href="javascript:deleteObject(<?php echo $data2['id']; ?>);"  class="delete" ><span class="section-delete">&nbsp;</span></a>
	
	<?php	echo "<a style='padding-left:10px;' target='_new' href='".uri('')."items/edit/".$data2['item_id']."'>".$data2['text']."</a>";
   echo '</div>';
		}
	 ?>
	</div>
		
</div>
        
        
        
            <?php /*
             * <div id="page-metadata-list">
             * <h2><?php echo __('Page Layout'); ?></h2>
            <div id="layout-metadata">
                <?php 
                    $imgFile = web_path_to(EXHIBIT_LAYOUTS_DIR_NAME ."/$exhibitPage->layout/layout.gif"); 
                	echo '<img src="'. html_escape($imgFile) .'" alt="' . html_escape($exhibitPage->layout) . '"/>';
                ?>
                <ul>
                 <li><strong><?php echo __($layoutName); ?></strong></li>
                 <li><?php echo __($layoutDescription); ?></li>
                 </ul>
            </div>

    <button id="page_metadata_form" name="page_metadata_form" type="submit"><?php echo __('Edit Page'); ?></button>
        </div> */ ?>
    
	<div id="layout-all">
	    <h2><?php echo __('Page Content'); ?></h2>
	<div id="layout-form">
	<?php exhibit_builder_render_layout_form($exhibitPage->layout); ?>
	</div>

	</div>
    <fieldset>
		<p id="exhibit-builder-save-changes">
            <input id="section_form" name="section_form" type="submit" value="<?php echo __('Save and Return to Section'); ?>" /> <?php echo __('or'); ?> 
            <input id="page_form" name="page_form" type="submit" value="<?php echo __('Save and Add Another Page'); ?>" /> <?php echo __('or'); ?>
            <a href="<?php echo html_escape(uri(array('module'=>'exhibit-builder', 'controller'=>'exhibits', 'action'=>'edit-section', 'id'=>$exhibitPage->section_id))); ?>"><?php echo __('Cancel'); ?></a>
		</p>
	</fieldset>
	<fieldset>
	<?php echo __v()->formHidden('slug', $exhibitPage->slug); // Put this here to fool the form into not overriding the slug. ?>	
	</fieldset>
	</form>
</div>
</div>
<?php foot(); ?>
