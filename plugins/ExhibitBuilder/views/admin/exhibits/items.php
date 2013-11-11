<script type="text/javascript">
    function toggleDiv(divId,divIdHide,adivId,adivIdHide,butsh,buthd) {
        var divIdtext = document.getElementById(divId);
        var divIdHidetext = document.getElementById(divIdHide);
        var adivIdtext = document.getElementById(adivId);
        var adivIdHidetext = document.getElementById(adivIdHide);
        var butshtext = document.getElementById(butsh);
        var buthdtext = document.getElementById(buthd);
        divIdtext.style.display = "block";
        divIdHidetext.style.display = "none";
        butshtext.style.display = "block";
        buthdtext.style.display = "none";
        adivIdtext.classList.add("current");
        adivIdHidetext.classList.remove("current");
    }
</script>
<ul id="tertiary-nav" class="navigation">
    <li id="stepbutton1" ><a class="current" id="stepahref1" href="javascript:toggleDiv('addfromcollection','addnew','stepahref1','stepahref2','buttonfrommycollection','buttonfromnew');" style="float: left; font-size: 14px;"><?php echo __('Find from your collection'); ?></a></li>
    <li id="stepbutton2" ><a id="stepahref2" href="javascript:toggleDiv('addnew','addfromcollection','stepahref2','stepahref1','buttonfromnew','buttonfrommycollection');" style="float: left; clear: none; margin-left: 2px; font-size: 14px;"><?php echo __('Add new image to your collection'); ?></a></li>
</ul>
<br style="clear:both;">

<div id="addfromcollection">
    <a href="" id="show-or-hide-search" class="show-form"><?php echo __('Show Search Form'); ?></a>
    <div id="page-search-form">
        <?php
        $uri = uri(array('controller' => 'exhibits', 'action' => 'items', 'page' => null));
        $formAttributes = array('id' => 'search');
        echo items_search_form($formAttributes);
        ?>
    </div>
    <div id="pagination" class="pagination">
        <?php
        echo pagination_links(array('url' => uri(array('controller' => 'exhibits',
                'action' => 'items', 'page' => null), 'exhibitItemPagination') . '/'));
        // The extra slash is a hack, the pagination should be fixed to work
        // without the extra slash being there. Also, I get the feeling that being
        // forced to set the 'page' parameter to null is also a hack.
        ?>

    </div>
    <div id="item-list">
        <?php if (!has_items_for_loop()): ?>
            <p><?php echo __('There are no items to choose from.  Please refine your search or %s.', '<a href="' . html_escape(uri('items/add')) . '">' . __('add some items') . '</a>') ?></p>
        <?php endif; ?>
        <?php while ($item = loop_items()): ?>
            <?php echo exhibit_builder_exhibit_form_item($item, null, null, false); ?>
        <?php endwhile; ?>
    </div>
</div>
<div id="addnew" style="display:none;position:relative; top: 20px;">
    <span style="font-size: 10px;"><?php echo __('Important info: When you are inserting a new external resource please make sure you saved all the changes in your pathway.'); ?></span><br>
    <span style="font-size: 10px;"><?php echo __('Inserting a new external resource will reload your pathway page and all the unsaved changes will be lost.'); ?></span>
    <script TYPE="text/javascript">
        <!--
        // check that they entered an amount tested, an amount passed,
        // and that they didn't pass units than they more than tested

        function check()
        {
            var artitle =document.testform.title.value;
            var ardescription =document.testform.description.value;
            var arlink =document.getElementById("file-1").value


            var returnval;


 
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
            return returnval;

        }
        // -->
    </script>
    <form method="post" enctype="multipart/form-data" id="item-form" action="" name="testform" onSubmit="return check();">
         <div class="field">
        <label for="title" id="title"><b>*<?php echo __('Title'); ?></b></label>
    <?php //$title=item('Dublin Core', 'Title');  ?>
        <textarea rows="3" cols="70" class="textinput" name="title" id="titleforitem"  style="width: 395px;"/></textarea>
    <?php //echo form_error('title');  ?>
    </div> 

    <div class="field">
        <label for="title" id="title"><b>*<?php echo __('Description'); ?></b></label>
    <?php //$title=item('Dublin Core', 'Title');  ?>
        <textarea rows="3" cols="70" class="textinput" name="description" id="titleforitem"  style="width: 395px;"/></textarea>
    <?php //echo form_error('title');  ?>
    </div>
<?php 
$pathToConvert = get_option('path_to_convert');
if (empty($pathToConvert) && has_permission('Settings', 'edit')): ?>
    <div class="error">The path to Image Magick has not been set. No derivative images will be created. If you would like Omeka to create derivative images, please add the path to your settings form.</div>
<?php endif; ?>
<h3 style="font-weight:bold;"><?php echo __('Upload a File'); ?></h3>

<div >
   <!-- <label>Find a File</label> -->
        
    <?php //for($i=0;$i<$numFiles;$i++): ?>
    <div class="">
        <input name="file[0]" id="file-1" type="file" class="fileinput" />          
    </div>
    <?php //endfor; ?>
</div>
<?php fire_plugin_hook('admin_append_to_items_form_files', $item); ?>

        <div>
           
        </div>
<input type="hidden" name="public" id="public" value="1">
<input type="hidden" name="add_new_item2" id="add_item" value="add_new_item2">
    </form>
</div>
