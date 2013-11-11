<script type="text/javascript">
    function toggleDiv2(divId,divIdHide,adivId,adivIdHide,butsh,buthd,buthd2) {
        var divIdtext = document.getElementById(divId);
        var divIdHidetext = document.getElementById(divIdHide);
        var adivIdtext = document.getElementById(adivId);
        var adivIdHidetext = document.getElementById(adivIdHide);
        var butshtext = document.getElementById(butsh);
        var buthdtext = document.getElementById(buthd);
        var buthdtext2 = document.getElementById(buthd2);
        divIdtext.style.display = "block";
        divIdHidetext.style.display = "none";
        butshtext.style.display = "block";
        buthdtext.style.display = "none";
        buthdtext2.style.display = "none";
        adivIdtext.classList.add("current");
        adivIdHidetext.classList.remove("current");
    }

</script>
<ul id="tertiary-nav" class="navigation">
    <li id="stepbutton1" ><a class="current" id="stepahref3" href="javascript:toggleDiv2('addfromcollection2','addnew2','stepahref3','stepahref4','buttonfrommycollection2','buttonfromnew2','buttonfromnew3');" style="float: left; font-size: 14px;"><?php echo __('Find from your collection'); ?></a></li>
    <li id="stepbutton2" ><a id="stepahref4" href="javascript:toggleDiv2('addnew2','addfromcollection2','stepahref4','stepahref3','buttonfromnew2','buttonfrommycollection2','buttonfromnew3');" style="float: left; clear: none; margin-left: 2px; font-size: 14px;"><?php echo __('Add new resource to your collection'); ?></a></li>
</ul>
<br style="clear:both;">

<div id="addfromcollection2">
    <a href="" id="show-or-hide-search2" class="show-form2"><?php echo __('Show Search Form'); ?></a>
    <div id="page-search-form2">
        <?php
        $uri = uri(array('controller' => 'exhibits', 'action' => 'items', 'page' => null));
        $formAttributes = array('id' => 'search2');
        echo items_search_form($formAttributes);
        ?>
    </div>
    <div id="pagination2" class="pagination">
        <?php
        echo pagination_links(array('url' => uri(array('controller' => 'exhibits',
                'action' => 'items2', 'page' => null), 'exhibitItemPagination2') . '/'));
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
<div id="addnew2" style="display:none;">
    <div style="position: relative; top: 10px;">
    <span style="font-size: 10px;"><?php echo __('Important info: When you are inserting a new external resource please make sure you saved all the changes in your pathway.'); ?></span><br>
    <span style="font-size: 10px;"><?php echo __('Inserting a new external resource will reload your pathway page and all the unsaved changes will be lost.'); ?></span>
    </div>
    <div style="width: 150px; float: left;">
        <ul id="supporting-nav" class="navigation tabs" style="position:relative; top: 20px;">
        
        <li id="stepbutton1" ><a class="current" id="stepahref5" href="javascript:toggleDiv2('addnew3','addnew4','stepahref5','stepahref6','buttonfromnew2','buttonfromnew3','buttonfrommycollection2');" style="float: left; font-size: 14px;"><?php echo __('Add a File'); ?></a></li>
        <li id="stepbutton2" ><a id="stepahref6" href="javascript:toggleDiv2('addnew4','addnew3','stepahref6','stepahref5','buttonfromnew3','buttonfromnew2','buttonfrommycollection2');" style="float: left; clear: none; margin-left: 2px; font-size: 14px;"><?php echo __('Add a Hyperlink'); ?></a></li>    
       
    </ul>
    </div>
    <div style="float:left; ">
    
    <div id="addnew3" style="display:block;position:relative; top: 20px;">
    <script TYPE="text/javascript">
        <!--
        // check that they entered an amount tested, an amount passed,
        // and that they didn't pass units than they more than tested

        function check2()
        {
            var artitle =document.testform2.title.value;
            var ardescription =document.testform2.description.value;
            var arlink =document.getElementById("file-0").value


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
    <form method="post" enctype="multipart/form-data" id="item-form2" action="" name="testform2" onSubmit="return check2();">
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
        <input name="file[0]" id="file-0" type="file" class="fileinput" />          
    </div>
    <?php //endfor; ?>
</div>
<?php fire_plugin_hook('admin_append_to_items_form_files', $item); ?>

        <div>
           
        </div>
<input type="hidden" name="public" id="public" value="1">
<input type="hidden" name="add_new_item" id="add_item" value="add_new_item">
    </form>
    </div>
    <div id="addnew4" style="display:none;position:relative; top: 20px;">

<script TYPE="text/javascript">
        <!--
        // check that they entered an amount tested, an amount passed,
        // and that they didn't pass units than they more than tested

        function check3()
        {
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
return returnval;

}
// -->
    </script>
    <form method="post" enctype="multipart/form-data" id="item-form3" action="" name="testform3" onSubmit="return check3();">
         <div class="field">
        <label for="title" id="title"><b>*<?php echo __('Title'); ?></b></label>
    <?php //$title=item('Dublin Core', 'Title');  ?>
        <textarea rows="3" cols="70" class="textinput" name="title" id="titleforitem" style="width: 395px;" /></textarea>
    <?php //echo form_error('title');  ?>
    </div> 

    <div class="field">
        <label for="title" id="title"><b>*<?php echo __('Description'); ?></b></label>
    <?php //$title=item('Dublin Core', 'Title');  ?>
        <textarea rows="3" cols="70" class="textinput" name="description" id="titleforitem"  style="width: 395px;"/></textarea>
    <?php //echo form_error('title');  ?>
    </div>
<div class="field">
		<label for="title" id="title"><b>*URL</b></label>
        <?php //$title=item('Dublin Core', 'Title'); ?>
		<textarea rows="4" cols="70" class="textinput" name="link"  id="linkforitem"  style="width: 395px;"/></textarea>
		<?php //echo form_error('title'); ?>
<!--<a href="javascript:void(0);" onclick="suggestmetadata(document.getElementById('link').value);return false;" class="submit" style="font-size: 13px; clear: none; float: none; left:15px; top: 5px; position: relative;"><?php //echo __('Suggest Metadata'); ?></a>-->
</div> 
<input type="hidden" name="type" value="11">
<input type="hidden" name="public" id="public" value="1">
<input type="hidden" name="add_new_item_link" id="add_item" value="add_new_item_links">
    </form>        
        
        
    </div>
    </div>
    <br style="clear:both;">
</div>
