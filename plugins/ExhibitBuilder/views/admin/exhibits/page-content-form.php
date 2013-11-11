<?php echo js('prototype'); ?>
<?php echo js('tooltip_pathways'); ?>
<script type="text/javascript" src="<?php $uri = WEB_ROOT;
echo $uri;
?>/themes/natural/scripts/ajax/ajax.js"></script>
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
$exhibitPageTitle = __('Edit Page Content: \"%s\"', __($exhibitPage->title));
$exhibitPageTitle=stripslashes($exhibitPageTitle);
?>
<?php head(array('title' => html_escape($exhibitPageTitle), 'bodyclass' => 'exhibits')); ?>

<script type="text/javascript" charset="utf-8">
    //<![CDATA[

    jQuery(document).ready(function(){

        var exhibitBuilder = new Omeka.ExhibitBuilder();    
        var exhibitBuilder2 = new Omeka.ExhibitBuilder2();   
		
        // Add styling
        exhibitBuilder.addStyling();
        exhibitBuilder2.addStyling();
		
        // Set the exhibit item uri
        exhibitBuilder.itemContainerUri = <?php echo js_escape(uri('exhibits/item-container')); ?>;
        //exhibitBuilder2.itemContainerUri = <?php echo js_escape(uri('exhibits/item-container')); ?>;
		
        // Set the paginated exhibit items uri
        exhibitBuilder.paginatedItemsUri = <?php echo js_escape(uri('exhibits/items')); ?>;
        exhibitBuilder2.paginatedItemsUri = <?php echo js_escape(uri('exhibits/items2')); ?>;
		
        // Set the remove item background image uri
        exhibitBuilder.removeItemBackgroundImageUri = <?php echo js_escape(img('silk-icons/delete.png')); ?>;

        exhibitBuilder.removeItemText = <?php echo js_escape(__('Remove This Item')); ?>;        
        // Get the paginated items
        exhibitBuilder.getItems();
        exhibitBuilder2.getItems();

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
        jQuery(document).bind('omeka:loaditems2', function() {
            jQuery('#page-search-form2').hide();

            jQuery('#show-or-hide-search2').click( function(){
                var searchForm2 = jQuery('#page-search-form2');
                if (searchForm2.is(':visible')) {
                    searchForm2.hide();
                } else {
                    searchForm2.show();
                }
                
                var showHideLink2 = jQuery(this);
                showHideLink2.toggleClass('show-form2');
                if (showHideLink2.hasClass('show-form2')) {
                    showHideLink2.text('Show Search Form');
                } else {
                    showHideLink2.text('Hide Search Form');
                }
                return false;
            });
        });

        jQuery('#add_supporting_material').click(function() {
            jQuery('#search-items-supporting').dialog('open');
            return false;
        }); 
        //search soupporting items dialog box
        jQuery('#search-items-supporting').dialog({
            autoOpen: false,
            width: 820,
            height: 500,
            title: <?php echo js_escape(__('Add supporting material')); ?>,
            modal: true,
            buttons: [{
                    text:<?php echo js_escape(__('Insert Supporting Material')); ?>,"id":"buttonfrommycollection2",click: function() { 
                        exhibitBuilder2.attachSelectedItem2('<?php echo $exhibitSection->id; ?>','<?php echo $exhibitPage->id; ?>','<?php echo $exhibit->id; ?>');
                        jQuery(this).dialog('close'); 
                        
                    } 
                },{
                    text:<?php echo js_escape(__('Insert new file to your collection')); ?>,"id":"buttonfromnew2",click: function() { 
                        //var asd=jQuery("#item-form'").serializeArray();
                        //alert(asd);
                    
                        var artitle =document.testform2.title.value;
                        var ardescription =document.testform2.description.value;
                        var arlink =document.getElementById("file-0").value


                        var returnval=false;


 
                        if((ardescription=="") || (artitle=="")) {
                            alert("<?php echo __('You must fill all the mandatory fields (*)'); ?>");
                            returnval = false;
                        }
                        else
                        {
                            if(arlink=="") {
                                alert("<?php echo __("Keep in mind that you didn't select a file to upload."); ?>");
                                returnval = false;
                            }else{
                                returnval = true;
                            }
                        }
                        

                        if(returnval==true){
                            jQuery('#item-form2').submit();
                            document.getElementById('loadertoopenpage_div').style.display='block';
                            document.getElementById('loadertoopenpage_img').style.display='block';
                            //exhibitBuilder.attachNewItem();
                            //exhibitBuilder.uploadNewItem(title,description,file);
                    
                            jQuery(this).dialog('close'); 
                        }
                    } 
                },{
                    text:<?php echo js_escape(__('Insert new hyperlink to your collection')); ?>,"id":"buttonfromnew3",click: function() { 
                        //var asd=jQuery("#item-form'").serializeArray();
                        //alert(asd);
                    
                        var artitle =document.testform3.title.value;
                        var ardescription =document.testform3.description.value;
                        var arlink =document.testform3.link.value;


                        var returnval;

                        if((ardescription=="") || (arlink=="") || (artitle=="")) {
                            alert("<?php echo __('You must fill all the mandatory fields (*)'); ?>");
                            returnval = false;
                        }
                        else
                        {
                            returnval = true;
                        }
                        

                        if(returnval==true){
                            jQuery('#item-form3').submit();
                            document.getElementById('loadertoopenpage_div').style.display='block';
                            document.getElementById('loadertoopenpage_img').style.display='block';
                            //exhibitBuilder.attachNewItem();
                            //exhibitBuilder.uploadNewItem(title,description,file);
                    
                            jQuery(this).dialog('close'); 
                        }
                    } 
                }]
        });
        // Search Items Dialog Box
        jQuery('#search-items').dialog({
            autoOpen: false,
            width: 820,
            height: 500,
            title: <?php echo js_escape(__('Insert Image')); ?>,
            modal: true,
            buttons: [{
                    text:<?php echo js_escape(__('Insert Selected Image')); ?>,"id":"buttonfrommycollection",click: function() { 
                        exhibitBuilder.attachSelectedItem();
                        jQuery(this).dialog('close'); 
                    } 
                },{
                    text:<?php echo js_escape(__('Insert new image to your collection')); ?>,"id":"buttonfromnew",click: function() { 
                        //var asd=jQuery("#item-form'").serializeArray();
                        //alert(asd);
                    
                        var artitle =document.testform.title.value;
                        var ardescription =document.testform.description.value;
                        var arlink =document.getElementById("file-1").value


                        var returnval=false;


 
                        if((ardescription=="") || (artitle=="")) {
                            alert("<?php echo __('You must fill all the mandatory fields (*)'); ?>");
                            returnval = false;
                        }
                        else
                        {
                            if(arlink=="") {
                                alert("<?php echo __("Keep in mind that you didn't select a file to upload."); ?>");
                                returnval = false;
                            }else{
                                returnval = true;
                            }
                        }
                        
                        
                        if(returnval==true){
                            jQuery('#item-form').append('<input type="hidden" name="order" value="'+exhibitBuilder.getorder()+'" />');


                            jQuery('#item-form').submit();
                            document.getElementById('loadertoopenpage_div').style.display='block';
                            document.getElementById('loadertoopenpage_img').style.display='block';
                            //exhibitBuilder.attachNewItem();
                            //exhibitBuilder.uploadNewItem(title,description,file);
                    
                            jQuery(this).dialog('close'); 
                        }
                    } 
                }]
        });
    });
	
    jQuery(window).load(function() {
        Omeka.ExhibitBuilder.wysiwyg();
        //Omeka.ExhibitBuilder.addNumbers();
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
    <div id="loadertoopenpage_div" style="display: none; position: fixed; top: 0px; left: 0px; width:100%; height: 100%;  text-align: center; 
         background-color: silver;
         opacity:0.3;
         filter:alpha(opacity=30); z-index: 999;">
    </div>
    <div id="loadertoopenpage_img" style="display: none; position: fixed; top: 0px; left: 0px; width:100%; height: 100%;  text-align: center; 
         background-image: url(<?php echo uri('themes/default/images/loader.gif') ?>);
         background-position: center center;
         background-repeat: no-repeat; z-index: 1000;">

    </div>
    <div id="page-builder">
        <div id="exhibits-breadcrumb">
            <a href="<?php echo html_escape(uri('exhibits')); ?>"><?php echo __('Pathways'); ?></a> &gt;
            <a href="<?php echo html_escape(uri('exhibits/edit/' . $exhibit['id'])); ?>"><?php echo html_escape($exhibit['title']); ?></a>  &gt;
            <a href="<?php echo html_escape(uri('exhibits/edit-section/' . $exhibitSection['id'])); ?>"><?php echo __(html_escape($exhibitSection['title'])); ?></a>  &gt;
<?php echo __(html_escape($exhibitPageTitle)); ?>
        </div>

<?php //This item-select div must be outside the <form> tag for this page, b/c IE7 can't handle nested form tags.   ?>
        <div id="search-items" style="display:none;">
            <div id="item-select"></div>
        </div>
        <div id="search-items-supporting" style="display:none;">
            <div id="item-select-supporting"></div>
        </div>

        <form id="page-form" method="post" action="<?php echo html_escape(uri(array('module' => 'exhibit-builder', 'controller' => 'exhibits', 'action' => 'edit-page-content', 'id' => $exhibitPage->id))); ?>">
            <div style="float:left; width:auto;float:left;">
                <div style=" text-align:left; width:auto;float:left;"><?php echo exhibit_builder_link_to_exhibit(NULL, '' . __('Preview Pathway') . '', $props = array('target' => 'blank', 'class' => 'button'), 'to-begin-with'); ?></div>
                <br>
                <div style=""><a class="button" href="<?php $uri = WEB_ROOT;
echo $uri;
?>/quality" target="_blank"><?php echo __('Quality Criteria for Natural Europe Pathways'); ?></a> 
                </div><br>
            </div>
            <?php $user = current_user(); ?>
            <?php /* <script language="javascript" type="text/javascript">
              function addobject(){window.open('<?php echo $uri; ?>/custom/exhibits/teaser_add.php?ex_id=<?php echo $exhibit->id; ?>&sec_id=<?php echo $exhibitSection->id; ?>&pg_id=<?php echo $exhibitPage->id; ?>&uid=<?php echo $user['id']; ?>&entityid=<?php echo $user['entity_id']; ?>','mywindow','width=500,height=300')}
              function addeuropeanaobject(){window.open('<?php echo $uri; ?>/europeanaapi?ex_id=<?php echo $section->exhibit_id; ?>&sec_id=<?php echo $section->id; ?>&pg_id=<?php echo $page->id; ?>','mywindow','width=640,height=600,resizable=yes,scrollbars=yes')}
              </script> */ ?>
            <script type="text/javascript">
                var ajax = new Array();

                function deleteObject(id){
                    var index = ajax.length;
                    ajax[index] = new sack();
                    ajax[index].requestFile = '<?php echo uri('exhibits/deleteteasers'); ?>?ts_id='+id+'';
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
                <div style="margin:20px; padding:10px; min-height:100px; background:none repeat scroll 0 0 #F0F0F0; position:relative; text-align:left;">
<?php /* <div style=" float:left; padding-left:12px;"><span style="position:relative; top: 14px;"> <?php echo __('Click to add a supporting material.'); ?></span> <a href="javascript:addobject();" onclick="javascript:addobject();" class="button" style="position: relative; margin-left: 5px;"><?php echo __('Attach a Resource'); ?></a>
  </div> */ ?>
                    <div style=" float:left; padding-left:12px;"><?php echo '<a href="#" class="button" id="add_supporting_material">' . __('Insert Supporting Material') . '</a>' . "\n"; ?></div>
                    <div style="padding-left:12px; text-align:left; clear:both;font-style:italic; position: relative; left: 120px; min-height: 80px; width:500px;">
                              <?php echo __('Add one of your resources as supporting material for this page. Resources that will be added here serve as complementary to the items attached on the pathway'); ?></div>
<?php ////////////////////////ONLINE VIDEO HELP FOR SUPPORTING MATERIAL////////////////////// ?>
                    <script type="text/javascript"> 
 jQuery(function() {
	 jQuery("#youtube_show_sp_mat").click(function() {
jQuery("#youtube_sup_mat").dialog('open');
});
jQuery("#youtube_sup_mat").dialog({
            autoOpen: false,
            width: 655,
            height: 452,
            title: '<?php echo __('Insert Supporting Material') ?>',
            modal: true,
			close: CloseFunction

});
 })
function CloseFunction(){
	//reload iframe in order to stop the youtube video
var iframe = document.getElementById('supporting_material_iframe');
    iframe.src = iframe.src;
}
</script>
                    <a href="javascript:void(0);" id="youtube_show_sp_mat"><img width="100" height="75" src="<?php echo uri('themes/default/images/add_supporting_material.png');?>" style="position:absolute; left: 22px; top:50px;"></a>
                    <div id="youtube_sup_mat" style="display:none; width:560px;">
<iframe id="supporting_material_iframe" width="640" height="392" src="//www.youtube.com/embed/SK5LapigmMA" frameborder="0" allowfullscreen></iframe>
</div>
                    <hr style="border:1px dotted #CCCCCC; clear:both;"><br>	
                    <div id="text_supporting">
                        <?php
                        $sql2 = "SELECT a.*,c.text FROM omeka_teasers a JOIN omeka_items b ON a.item_id=b.id JOIN omeka_element_texts c ON a.item_id=c.record_id WHERE a.exhibit_id=" . $exhibit->id . " and a.pg_id=" . $exhibitPage->id . " and a.type!='europeana' and c.element_id=68";
                        $exec2 = $db->query($sql2);
                        while ($data2 = $exec2->fetch()) {
                            //echo $data2['title'];
                            ?>
                            <div id="pagedelete" style="padding-top:6px;">
                                <a href="javascript:deleteObject(<?php echo $data2['id']; ?>);"  class="delete" ><span class="section-delete">&nbsp;</span></a>

                            <?php echo "<a style='padding-left:10px;' target='_new' href='" . uri('') . "items/edit/" . $data2['item_id'] . "'>" . $data2['text'] . "</a>";
                            ?>
                            </div> 
<?php } ?>
                    </div>


                </div>
                
<?php ////////////////////////ONLINE VIDEO HELP FOR INSERT IMAGE////////////////////// ?>
                    <script type="text/javascript"> 
 jQuery(function() {
	 jQuery("#youtube_show_in_im_1,#youtube_show_in_im_2,#youtube_show_in_im_3,#youtube_show_in_im_4").click(function() {
jQuery("#youtube_in_im").dialog('open');
});
jQuery("#youtube_in_im").dialog({
            autoOpen: false,
            width: 655,
            height: 452,
            title: '<?php echo __('Insert Image') ?>',
            modal: true,
			close: CloseFunction

});
 })
function CloseFunction(){
	//reload iframe in order to stop the youtube video
var iframe = document.getElementById('insert_image_iframe');
    iframe.src = iframe.src;
}
</script>
                    <?php /*
                     * The link added in exhibitFunctions -> exhibit_builder_exhibit_form_item
                     * <a href="#" id="youtube_show_in_im"><img width="100" height="75" src="<?php echo uri('themes/default/images/add_supporting_material.png');?>" style="position:absolute; left: 22px; top:50px;"></a> */ ?>
                    <div id="youtube_in_im" style="display:none; width:560px;">
<iframe id="insert_image_iframe" width="640" height="392" src="//www.youtube.com/embed/CaZMU2hblj8" frameborder="0" allowfullscreen></iframe>
</div>                
                
                <h2><?php echo __('Page Content'); ?></h2>
                <div id="layout-form">
<?php exhibit_builder_render_layout_form($exhibitPage->layout); ?>
                </div>

            </div>
            <fieldset>
                <p id="exhibit-builder-save-changes">
                    <input id="section_form" name="section_form" type="submit" value="<?php echo __('Save'); ?>" /> <?php echo __('or'); ?> 
                    <input id="section_form_ret" name="section_form_ret_to_path" type="submit" value="<?php echo __('Save and Return to Pathway'); ?>" /> <?php echo __('or'); ?> 
<?php /* <input id="page_form" name="page_form" type="submit" value="<?php echo __('Save and Add Another Page'); ?>" /> <?php echo __('or'); ?> */ ?>
                    <a href="<?php echo html_escape(uri(array('module' => 'exhibit-builder', 'controller' => 'exhibits', 'action' => 'edit', 'id' => $exhibit->id))); ?>"><?php echo __('Cancel'); ?></a>
                </p>
            </fieldset>
            <fieldset>
                                            <div id="section_form_help" style="display:none; position:absolute;top:0px; border:1px solid #333;background:#f7f5d1;padding:2px 5px; color:#333;z-index:100;">
        <?php echo __('Save and remain in the same page'); ?>
    </div>
            <div id="section_form_ret_help" style="display:none; position:absolute;top:0px; border:1px solid #333;background:#f7f5d1;padding:2px 5px; color:#333;z-index:100;">
        <?php echo __('Save and go back to the main page of pathway'); ?>
    </div>
                        <script type="text/javascript">
var my_tooltip = new Tooltip_gen('section_form', 'section_form_help');
var my_tooltip = new Tooltip_gen('section_form_ret', 'section_form_ret_help');
    </script>
<?php echo __v()->formHidden('slug', $exhibitPage->slug); // Put this here to fool the form into not overriding the slug.   ?>	
            </fieldset>
        </form>
    </div>
</div>
<?php foot(); ?>
