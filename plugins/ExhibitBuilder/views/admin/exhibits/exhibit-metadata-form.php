<?php
if ($exhibit->title) {
    $exhibitTitle = __('Edit Pathway: %s', $exhibit->title);
} else {
    $exhibitTitle = ($actionName == 'Add') ? __('Add Pathway') : __('Edit Pathway');
}
?>
<?php head(array('title' => html_escape($exhibitTitle), 'bodyclass' => 'exhibits')); ?>
<?php echo js('listsort'); ?>
<?php echo js('prototype'); ?>
<?php echo js('scriptaculous'); ?>
<?php echo js('items'); ?>
<?php echo js('tooltip_pathways'); ?>
<?php echo flash(); ?>
<script type="text/javascript">

    jQuery(function(){
        jQuery('#show_optional').click(function(){
            var value=jQuery('.optional_element').css("display");
            if(value=='none'){
                jQuery('.optional_element').css("display", "block"); 
                jQuery('#show_optional').css("background-color", "#E9F6DA");
                jQuery('#show_optional').text("Only recommended");

 
            }else{
                jQuery('.optional_element').css("display", "none"); 
                jQuery('#show_optional').css("background-color", "#E9F6DA");
                jQuery('#show_optional').text("Enrich Metadata");


            }
              


        });


    });

</script>

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

<script type="text/javascript" charset="utf-8"> 
    //<![CDATA[
    var listSorter = {};
    
    function makeSectionListDraggable()
    {
        // var sectionList = jQuery('.section-list');
        var sectionList = jQuery('.no-drag-section');
        var sectionListSortableOptions = {axis:'y', forcePlaceholderSize: true};
        var sectionListOrderInputSelector = '.section-info input';
        
        var sectionListDeleteLinksSelector = '.section-delete a';
        var sectionListDeleteConfirmationText = 'Are you sure you want to delete this section?';
        var sectionListFormSelector = '#exhibit-metadata-form';
        var sectionListCallback = Omeka.ExhibitBuilder.addStyling;
        makeSortable(sectionList, 
        sectionListSortableOptions,
        sectionListOrderInputSelector,
        sectionListDeleteLinksSelector, 
        sectionListDeleteConfirmationText, 
        sectionListFormSelector, 
        sectionListCallback);

        var pageListSortableOptions = {axis:'y', connectWith:'.page-list'};
        var pageListOrderInputSelector = '.page-info input';
        var pageListDeleteLinksSelector = '.page-delete a';
        var pageListDeleteConfirmationText = 'Are you sure you want to delete this page?';
        var pageListFormSelector = '#exhibit-metadata-form';
        var pageListCallback = Omeka.ExhibitBuilder.addStyling;
        
        // var pageLists = jQuery('.page-list');
        var pageLists = jQuery('.no-drag-page');
        jQuery.each(pageLists, function(index, pageList) {
            makeSortable(jQuery(pageList), 
            pageListSortableOptions,
            pageListOrderInputSelector, 
            pageListDeleteLinksSelector, 
            pageListDeleteConfirmationText, 
            pageListFormSelector, 
            pageListCallback);
            
            // Make sure the order inputs for pages change the names to reflect their new
            // section when moved to another section           
            jQuery(pageList).bind('sortreceive', function(event, ui) {                
                var pageItem = jQuery(ui.item);
                var orderInput = pageItem.find(pageListOrderInputSelector);              
                var pageId = orderInput.attr('name').match(/(\d+)/g)[1];                
                var nSectionId = pageItem.closest('li.exhibit-section-item').attr('id').match(/(\d+)/g)[0];
                var nInputName = 'Pages['+ nSectionId + ']['+ pageId  + '][order]';
                orderInput.attr('name', nInputName);
            });
        });
    }
    
    jQuery(window).load(function() {
        /* Omeka.ExhibitBuilder.wysiwyg(); */
        Omeka.ExhibitBuilder.addStyling();
        
        <!--makeSectionListDraggable();  -->
        
        // Fixes jQuery UI sortable bug in IE7, where dragging a nested sortable would
        // also drag its container. See http://dev.jqueryui.com/ticket/4333
        jQuery(".page-list li").hover(
        function(){
            jQuery(".section-list").sortable("option", "disabled", true);
        },
        function(){
            jQuery(".section-list").sortable("option", "disabled", false);
        }
    );
    });
    //]]>   
</script>

<h1><?php echo html_escape($exhibitTitle); ?></h1>

<div id="primary">
    <div id="exhibits-breadcrumb">
        <a href="<?php echo html_escape(uri('exhibits')); ?>"><?php echo __('Pathways'); ?></a> &gt; <?php echo html_escape($exhibitTitle); ?>
    </div>

    <?php echo flash(); ?>
    <?php if (isset($exhibit['id'])) { ?>
        <form id="exhibit-metadata-form" method="post" class="exhibit-builder">

            <div style="float:left;">
                <div style=" text-align:left; width:auto;float:left;"><?php echo exhibit_builder_link_to_exhibit(NULL, '' . __('Preview Pathway') . '', $props = array('target' => 'blank', 'class' => 'button'), 'to-begin-with'); ?></div>
                <br>
                <div style=""><a class="button" href="<?php
    $uri = WEB_ROOT;
    echo $uri;
    ?>/quality" target="_blank"><?php echo __('Quality Criteria for Natural Europe Pathways'); ?></a></div><br>
            </div>
            <br style="clear:both;">

            <?php } else { ?>
            <form id="exhibit-metadata-form" method="post" action="bypass" class="exhibit-builder">
<?php } ?>

            <div style="border-bottom:solid; position:relative;"></div>
            <br style="clear:both;">



            <fieldset>



                    <?php if (!isset($exhibit['id'])) { ?>
                    <div class="field">
                        <?php echo text(array('name' => 'title', 'class' => 'textinput', 'id' => 'title', 'style' => 'width:195px'), $exhibit->title, '' . __('Pathway Title') . ''); ?>
    <?php echo form_error('title'); ?>
                    </div>

                    <div class="field">
                        <label><?php echo __('Description'); ?></label>
                        <?php echo '<textarea rows="4" cols="30" class="textinput" name="description" id="description"></textarea>&nbsp;&nbsp';
                        ?>
    <?php //echo form_error('title');    ?>
                    </div>

                    <div class="field">
                        <label><?php echo __('Language'); ?></label>
                        <?php
//query for all languages
                        $sqllan = "SELECT * FROM metadata_language WHERE is_active=1 ORDER BY (case WHEN id='en' THEN 1 ELSE 2 END) ASC";
                        $execlan = $db->query($sqllan);
                        $datalan = $execlan->fetchAll();
//end

                        echo '<select name="language">';
                        foreach ($datalan as $datalan1) {
                            echo '<option value="' . $datalan1['id'] . '" ';
//if($datarecordvalue===$datalan1['id']){echo 'selected=selected';}
                            echo '>' . $datalan1['locale_name'] . '</option>';
                        }
                        echo '</select>';
                        ?>
                    <?php //echo form_error('title');   ?>
                    </div>
<?php } ?>

                <!-- <div class="field">
<?php //echo text(array('name'=>'credits', 'id'=>'credits', 'class'=>'textinput'), $exhibit->credits,'Exhibit Credits');    ?>
                 </div>
                 <div class="field">
                <?php //echo textarea(array('name'=>'description', 'id'=>'description', 'class'=>'textinput','rows'=>'10','cols'=>'40'), $exhibit->description, 'Exhibit Description');   ?>
                 </div>   
                <?php //$exhibitTagList = join(', ', pluck('name', $exhibit->Tags));   ?>
                 <div class="field">
<?php //echo text(array('name'=>'tags', 'id'=>'tags', 'class'=>'textinput'), $exhibitTagList, 'Exhibit Tags');    ?>
                 </div>
                 <div class="field">
                     <label for="featured">Exhibit is featured:</label>
                     <div class="radio"><?php //echo checkbox(array('name'=>'featured', 'id'=>'featured'), $exhibit->featured);    ?></div>
                 </div> -->

                <!-- <div class="field">
                     <label for="theme">Exhibit Theme</label>            
                <?php //$values = array('' => 'Current Public Theme') + exhibit_builder_get_ex_themes();   ?>
                     <div class="select"><?php //echo __v()->formSelect('theme', $exhibit->theme, array('id'=>'theme'), $values);  ?>
<?php //if ($theme && $theme->hasConfig):    ?><a href="<?php //echo html_escape(uri("exhibits/theme-config/$exhibit->id"));    ?>" class="configure-button button">Configure</a><?php //endif;   ?>
                     </div> 
                 </div>-->
            </fieldset>



            <script type="text/javascript" charset="utf-8">
                //<![CDATA[
                // TinyMCE hates document.ready.
                jQuery(window).load(function () {
                    Omeka.Items.initializeTabs();

                });
                function check()

                {
                    if(document.getElementById('6_1').value.length == 0){
                        alert('Please enter a title.');
                        document.getElementById('6_1').focus();
                        return false;
                    }
                    return true;
                }

                //]]>   
            </script>

            <?php
            //Metadata start 
            if (isset($exhibit['id'])) {
                ?>

                <div class="field">
                    <?php echo text(array('name' => 'slug', 'id' => 'slug', 'class' => 'textinput'), $exhibit->slug, 'Pathway Slug (' . __('no spaces or special characters') . ')'); ?>
                <?php echo form_error('slug'); ?>
                </div>
    <?php if (has_permission('ExhibitBuilder_Exhibits', 'makepublic')) { ?>
                    <div class="field">
                        <label for="featured"><?php echo __('Pathway ready for validation'); ?>:</label>
                        <div class="radio"><?php echo checkbox(array('name' => 'public', 'id' => 'public'), $exhibit->public); ?></div>
                    </div>
    <?php } ?>


                <div style="border-bottom:solid; position:relative;"></div>
                <br style="clear:both;">
                <script type="text/javascript">
function toggleDiv(divId) {
   jQuery("#"+divId).toggle();
}
</script>
                <a href="javascript:toggleDiv('metadata_text');" style="color: #446677;text-decoration:none;font-size: 1.8em;font-weight: normal;line-height: 1.2em"><?php echo __('Describe your pathway'); ?></a>	
                <div id="metadata_text" style="clear:both; display: none;">
                    <div>
                        <a style="position:relative; float:right; right:0px; background-color: #E9F6DA;" id="show_optional" >Enrich Metadata</a>
                    </div>

                    <div class="vertical-nav" id="content" style=" left:-38px;position:relative; float:left; width:200px;">
                        <ul id="section-nav" class="navigation tabs">
                            <?php
                            //query for creating general elements pelement=0		 
                            $sql3 = "SELECT DISTINCT b.id FROM metadata_element_label a LEFT JOIN metadata_element b ON a.element_id = b.id LEFT JOIN metadata_element_hierarchy c 
			ON c.element_id = b.id WHERE c.pelement_id=0 and c.is_visible=1 ORDER BY (case WHEN c.sequence IS NULL THEN '9999' ELSE c.sequence END) ASC;";
                            $exec3 = $db->query($sql3);
                            $datageneral3 = $exec3->fetchAll();
                            $step = 0;
                            foreach ($datageneral3 as $datageneral3) {
                                $step+=1;

                                //end
                                $datageneral['labal_name'] = return_multi_language_label_name($datageneral3['id']);

                                $sql4 = "SELECT * FROM  metadata_element_hierarchy  WHERE element_id=" . $datageneral3['id'] . " ;";
                                $exec4 = $db->query($sql4);
                                $datageneralqw = $exec4->fetch();
                                if ($datageneralqw['min_occurs'] > 0) {
                                    echo '<li id="stepbutton' . $step . '" class="mandatory_element"><a href="#step' . $step . '">' . $datageneral['labal_name'] . '</a></li>';
                                } elseif ($datageneralqw['is_recommented'] == 1) {
                                    echo '<li id="stepbutton' . $step . '" class="recommented_element"><a href="#step' . $step . '">' . $datageneral['labal_name'] . '</a></li>';
                                } else {
                                    echo '<li id="stepbutton' . $step . '" class="optional_element"><a href="#step' . $step . '" >' . $datageneral['labal_name'] . '</a></li>';
                                }
                            }//foreach datageneral3
                            ?>

                        </ul>

                    </div>


                    <div id="item-metadata" style="position:relative; left:5px; top:33px; float:left; width:790px;">
                        <div id="item-metadata">

                            <?php if (isset($exhibit->id)) { ?>
                                <?php
                                //query for creating general elements pelement=0		 
                                $sql2 = "SELECT a.*,c.*,b.* FROM metadata_element_label a LEFT JOIN metadata_element b ON a.element_id = b.id LEFT JOIN metadata_element_hierarchy c 
			ON c.element_id = b.id WHERE c.pelement_id=0 and c.is_visible=1 GROUP BY a.element_id ORDER BY (case WHEN c.sequence IS NULL THEN '9999' ELSE c.sequence END) ASC;";
                                $exec2 = $db->query($sql2);
                                $step = 0;
                                $exec3 = $db->query($sql2);
                                //end




                                $data2 = $exec3->fetchAll(); //again to query gia ola ta parent =0 gia create step div
//query for all elements without asking pelement
                                $sql = "SELECT f.*,e.vocabulary_id,e.id as elm_id FROM  metadata_element e  RIGHT JOIN metadata_element_hierarchy f ON f.element_id = e.id WHERE f.is_visible=1 GROUP BY e.id  ORDER BY (case WHEN f.sequence IS NULL THEN '9999' ELSE f.sequence END) ASC";
/////////////////query for translate specific elements//////////
                                if (isset($_POST['submit_language'])) {
                                    $sql = "SELECT f.*,e.vocabulary_id,e.id as elm_id FROM  metadata_element e  RIGHT JOIN metadata_element_hierarchy f ON f.element_id = e.id WHERE (f.id=6 or f.id=8 or f.id=35) and f.is_visible=1 GROUP BY e.id  ORDER BY (case WHEN f.sequence IS NULL THEN '9999' ELSE f.sequence END) ASC";
                                }
                                $exec4 = $db->query($sql);
                                $data4 = $exec4->fetchAll();
//end
//query for all values
                                $sql = "SELECT * FROM metadata_record WHERE object_id=" . $exhibit->id . " and object_type='exhibit'";
                                $execrecord = $db->query($sql);
                                $record = $execrecord->fetch();

                                $record_id = $record['id'];
                                $sql = "SELECT * FROM metadata_element_value WHERE record_id=" . $record_id . " ";
/////////////////query for translate specific elements//////////
                                if (isset($_POST['submit_language'])) {
                                    $sql = "SELECT * FROM metadata_element_value WHERE  (element_hierarchy=6 or element_hierarchy=8 or element_hierarchy=35) and record_id=" . $record_id . " ";
                                }
//echo $sql;
                                $exec5 = $db->query($sql);
                                $data5 = $exec5->fetchAll();
//end
//query for all languages
                                $sqllan = "SELECT * FROM metadata_language WHERE is_active=1 ORDER BY (case WHEN id='en' THEN 1 ELSE 2 END) ASC";
                                $execlan = $db->query($sqllan);
                                $datalan = $execlan->fetchAll();
                                libxml_use_internal_errors(false);
                                $uri = WEB_ROOT;
                                $xmlvoc = '' . $uri . '/archive/xmlvoc/iso_languages.xml';
                                $datalan = @simplexml_load_file($xmlvoc, NULL, LIBXML_NOERROR | LIBXML_NOWARNING);
//end
//query for selecting vocabulary
                                $sqlvoc = "SELECT e.value,d.id,f.label,e.id as vov_rec_id FROM metadata_vocabulary d JOIN metadata_vocabulary_record e ON d.id = e.vocabulary_id JOIN metadata_vocabulary_value f ON f.vocabulary_rid = e.id and e.public=1  and f.language_id='" . get_language_for_switch() . "' where e.public=1  ORDER BY (case WHEN e.sequence IS NULL THEN '99999' END),e.sequence,f.label ASC";
                                $execvoc = $db->query($sqlvoc);
                                $datavoc = $execvoc->fetchAll();
//end query for selecting vocabulary









                                foreach ($data2 as $data) {  //for every element general
                                    $step+=1;
                                    echo '<div class="toggle" id="step' . $step . '">'; //create div for toggle
//if($step==9){echo createlomlabel('Under Construction!','style="width:158px;"');}
//
/////////////////if translation no central description//////////
                                    if (!isset($_POST['submit_language'])) {
                                        $label_description = return_label_description($data['element_id']);
                                    }

                                    if (strlen($label_description) > 0) {
                                        echo "<p style='padding:2px;border:solid 1px #76BB5F; color: #76BB5F;'><strong><i>" . $label_description . "</i></strong></p>";
                                    }
                                    foreach ($data4 as $dataform) {  //for every element under general
                                        if ($data['element_id'] === $dataform['pelement_id']) { //if pelement tou hierarchy = element general
                                            if (!isset($_POST['submit_language'])) {
                                                checkelement($dataform, $datalan, $record);
                                            } else {
                                                checkelement($dataform, $datalan, $record, 0, NULL, NULL, 1);
                                            }
                                        }//if $data['element_id']===$dataform['pelement_id']
                                    }//if pelement tou hierarchy = element general (dataform)

                                    echo '</div>';  //close div general
                                }//end for every element general  (data)
                                ?>

                                <script type="text/javascript">
                                    function addFormField(multi,divid,iddiv) {
                                        var id = document.getElementById(''+iddiv+'').value;
                                        id = (id - 1) + 2;
                                        document.getElementById(''+iddiv+'').value = id;
                    	
                                        jQuery('#'+divid+'_inputs').append("<div id='"+divid+"_"+id+"_field' style='clear:both;'><textarea cols='60' rows='4' class='textinput' name='"+divid+"_"+id+"' id='txt" + id + "' style='float:left;'></textarea>&nbsp;&nbsp<div style='position:relative; left:5px; top:2px; float:left;'><select style='vertical-align:top;' name='"+divid+"_"+id+"_lan' class='combo'><option value='none'>Select </option><?php foreach ($datalan as $datalan1) { ?><option value='<?php echo $datalan1->identifier; ?>'><?php echo $datalan1->name; ?></option><?php } ?></select>&nbsp;&nbsp;<br><a class='lom-remove' style='float:right;' href='#' onClick='removeFormField(\"#"+divid+"_"+id+"_field\"); return false;'>Remove Language</a></div><div>");

                    	
                                    }

                                    function addFormvcard(multi,divid,iddiv,label) {
                                        var id = document.getElementById(''+iddiv+'').value;
                                        id = (id - 1) + 2;
                                        document.getElementById(''+iddiv+'').value = id;

                                        jQuery('#'+divid+'').append("<div id='"+divid+"_"+id+"' style='float:left;border-bottom:1px solid #d7d5c4;padding-right:9px; margin-right:5px;padding-bottom:9px; margin-bottom:5px;width:100%;'><input name='vcard_general_"+divid+"_"+id+"' id='vcard_general_"+divid+"_"+id+"' type='hidden' value=''><div style='float:left;'><label style='width:158px;'>"+label+"&nbsp;&nbsp;<a class='lom-remove' href='#' onClick='removedivid(\""+divid+"_"+id+"\"); return false;'>Remove</a></label></div><br><div style='float:left;'><span style='float:left; width:70px;'>Name: </span><input type='text' value='' name='vcard_name_"+divid+"_"+id+"' style='float:left;width:200px;' id='"+divid+"_"+id+"' class='textinput'><br><br><span style='float:left; width:70px;'>Surname: </span><input type='text' value='' name='vcard_surname_"+divid+"_"+id+"' style='float:left;width:200px;' id='"+divid+"_"+id+"' class='textinput'><br><br><span style='float:left; width:70px;'>Email: </span><input type='text' value='' name='vcard_email_"+divid+"_"+id+"' style='float:left;width:200px;' id='"+divid+"_"+id+"' class='textinput'><br><br><span style='float:left; width:70px;'>Organization: </span><input type='text' value='' name='vcard_organization_"+divid+"_"+id+"' style='float:left;width:200px;' id='"+divid+"_"+id+"' class='textinput'><br><br><div></div>");

                    	
                                    }

                                    function removeFormvcardExisted(divid,element_hierarchy,record_id,multi,vcard,parent_indexer) {

                                        var answer = confirm("Are you sure you want to DELETE it?")
                                        if (answer){

                                            jQuery.post("<?php echo uri('exhibit/deleteelementvalue'); ?>", { element_hierarchy: element_hierarchy, record_id: record_id, multi: multi, vcard: vcard, parent_indexer: parent_indexer },
                                            function(data) {

                                                jQuery('#'+divid).remove();
                                            });

                                        } 
                                    }



                                    function removeFormmultiParent(divid,element_hierarchy,record_id,multi,parent_element) {

                                        var answer = confirm("Are you sure you want to DELETE it?")
                                        if (answer){

                                            jQuery.post("<?php echo uri('exhibits/deleteelementvalue'); ?>", { element_hierarchy: element_hierarchy, record_id: record_id, multi: multi, parent_element: parent_element},
                                            function(data) {

                                                jQuery('#'+divid).remove();
                                            });

                                        } 
                                    }

                                    function addFormFieldText(multi,divid,iddiv) {
                                        var id = document.getElementById(''+iddiv+'').value;
                                        id = (id - 1) + 2;
                                        document.getElementById(''+iddiv+'').value = id;
                    	
                                        jQuery('#'+divid+'_inputs').append("<div id='"+divid+"_"+id+"_field' style='margin-top:15px;style='clear:both;''><input type='text' class='textinput' style='width:200px;' name='"+divid+"_"+id+"' id='txt" + id + "' value=''>&nbsp;&nbsp<select style='vertical-align:top;' name='"+divid+"_"+id+"_lan' class='combo'><option value='none'>Select </option><?php foreach ($datalan as $datalan1) { ?><option value='<?php echo $datalan1->identifier; ?>'><?php echo $datalan1->name; ?></option><?php } ?></select>&nbsp;&nbsp;<a class='lom-remove' style='float:right;' href='#' onClick='removeFormField(\"#"+divid+"_"+id+"_field\"); return false;'>Remove Language</a><div>");

                    	
                                    }




                                    function addFormmultiParent(multi,divid,iddiv,label) {
                                        var id = document.getElementById(''+iddiv+'').value;
                                        id = (id - 1) + 2;
                                        document.getElementById(''+iddiv+'').value = id;


                                        jQuery.post("<?php echo uri('exhibits/childsfromparentelement'); ?>", { element_hierarchy: divid, multi: id},
                                        function(data) {

                                            jQuery('#'+divid+'').append(data);
                                        });


                                    }


                                    function addFormTotalField(multi,divid,iddiv,label) {
                                        var id = document.getElementById(''+iddiv+'').value;
                                        id = (id - 1) + 2;
                                        document.getElementById(''+iddiv+'').value = id;

                                        jQuery('#'+divid+'_inputs').append("<div id='"+divid+"_"+id+"_inputs'><hr style='clear:both;'><a class='lom-add-new' href='#' onClick='addFormField(\"0\",\""+divid+"_"+id+"\",\"hdnLine_"+divid+"_"+id+"\"); return false;'>Add Language</a>&nbsp;&nbsp;<a class='lom-remove' href='#' onClick='removeFormFieldTotal(\""+divid+"_"+id+"\"); return false;'>Remove "+label+"</a><br><br><div id='"+divid+"_"+id+"_1_field'><textarea cols='60' rows='4' class='textinput' name='"+divid+"_"+id+"_1' id='txt1'></textarea>&nbsp;&nbsp<select style='vertical-align:top;' name='"+divid+"_"+id+"_1_lan' class='combo'><option value='none'>Select </option><?php foreach ($datalan as $datalan1) { ?><option value='<?php echo $datalan1->identifier; ?>'><?php echo $datalan1->name; ?></option><?php } ?></select>&nbsp;&nbsp;<a class='lom-remove' style='float:right;' href='#' onClick='removeFormField(\"#"+divid+"_"+id+"_1_field\"); return false;'>Remove Language</a><div><input type='hidden' name='hdnLine_"+divid+"_"+id+"' id='hdnLine_"+divid+"_"+id+"' value='1'></div>");

                    	
                                    }

                                    function addFormTotalFieldText(multi,divid,iddiv,label) {
                                        var id = document.getElementById(''+iddiv+'').value;
                                        id = (id - 1) + 2;
                                        document.getElementById(''+iddiv+'').value = id;

                                        jQuery('#'+divid+'_inputs').append("<div id='"+divid+"_"+id+"_inputs'><hr style='clear:both;'><a class='lom-add-new' href='#' onClick='addFormFieldText(\"0\",\""+divid+"_"+id+"\",\"hdnLine_"+divid+"_"+id+"\"); return false;'>Add Language</a>&nbsp;&nbsp;<a class='lom-remove' href='#' onClick='removeFormFieldTotal(\""+divid+"_"+id+"\"); return false;'>Remove "+label+"</a><br><br><div id='"+divid+"_"+id+"_1_field'><input type='text' class='textinput' style='width:200px;' name='"+divid+"_"+id+"_1' id='txt1' value=''>&nbsp;&nbsp<select style='vertical-align:top;' name='"+divid+"_"+id+"_1_lan' class='combo'><option value='none'>Select </option><?php foreach ($datalan as $datalan1) { ?><option value='<?php echo $datalan1->identifier; ?>'><?php echo $datalan1->name; ?></option><?php } ?></select>&nbsp;&nbsp;<a class='lom-remove' style='float:right;' href='#' onClick='removeFormField(\"#"+divid+"_"+id+"_1_field\"); return false;'>Remove Language</a><div><input type='hidden' name='hdnLine_"+divid+"_"+id+"' id='hdnLine_"+divid+"_"+id+"' value='1'></div>");

                    	
                                    }

                                    function addFormTotalFieldTextnolan(multi,divid,iddiv,label) {
                                        var id = document.getElementById(''+iddiv+'').value;
                                        id = (id - 1) + 2;
                                        document.getElementById(''+iddiv+'').value = id;

                                        jQuery('#'+divid+'_inputs').append("<div id='"+divid+"_"+id+"_inputs'><hr style='clear:both;'><div id='"+divid+"_"+id+"_1_field'><input type='text' class='textinput' style='width:200px;' name='"+divid+"_"+id+"_1' id='txt1' value=''><a class='lom-remove' href='#' onClick='removeFormFieldTotal(\""+divid+"_"+id+"\"); return false;'>Remove </a></div>");

                    	
                                    }

                                    function addFormFieldSelect(multi,divid,iddiv,vocabulary_id) {
                                        var id = document.getElementById(''+iddiv+'').value;
                                        id = (id - 1) + 2;
                                        document.getElementById(''+iddiv+'').value = id;
                                        var selectoption="<div id='row" + id + "'><select name='"+divid+"_"+id+"' class='combo' style='width:300px;float:left;'>";
                                        selectoption+="<option value=''>Select</option>";
                    	
        <?php foreach ($datavoc as $datavoc1) { ?>
                        var vocabulary=<?php echo $datavoc1['id']; ?>; 	
                        if(vocabulary_id==vocabulary){	
                            selectoption+="<option value='<?php echo $datavoc1['vov_rec_id']; ?>'><?php echo voc_multi_label($datavoc1['vov_rec_id']); ?></option>"; }	
        <?php } ?>
                    selectoption+="</select> <a class='lom-remove' style='float:left;' href='#' onClick='removeFormField(\"#row" + id + "\"); return false;'>Remove</a></div><br><br style='clear:both;'>";
                    	
                    jQuery('#'+divid+'_inputs').append(selectoption);

                    	
                }

                function addFormFieldSelectXml(multi,divid,iddiv,vocabulary_id) {
                    var id = document.getElementById(''+iddiv+'').value;
                    id = (id - 1) + 2;
                    document.getElementById(''+iddiv+'').value = id;
                    	
                    jQuery.post("<?php echo uri('exhibits/xmlselectbox'); ?>", { vocabulary_id: vocabulary_id, id: id,  divid:divid, ontology:0},
                    function(data) {

                        jQuery('#'+divid+'_inputs').append(data);
                    });
                    	
                }

                function addFormFieldSelectXmlOntology(multi,divid,iddiv,vocabulary_id) {
                    var id = document.getElementById(''+iddiv+'').value;
                    id = (id - 1) + 2;
                    document.getElementById(''+iddiv+'').value = id;
                    	
                    jQuery.post("<?php echo uri('exhibits/xmlselectbox'); ?>", { vocabulary_id: vocabulary_id, id: id,  divid:divid,  ontology:1},
                    function(data) {

                        jQuery('#'+divid+'_inputs').append(data);
                    });
                    	
                }


                function removeFormFieldExisted(id,element_hierarchy,language_id,record_id,multi) {

                    var answer = confirm("Are you sure you want to DELETE it?")
                    if (answer){

                        jQuery.post("<?php echo uri('exhibits/deleteelementvalue'); ?>", { element_hierarchy: element_hierarchy, language_id: language_id, record_id: record_id, multi: multi },
                        function(data) {

                            jQuery('#'+id).remove();
                        });

                    } 
                }


                function removeFormFieldTotalExisted(id,element_hierarchy,record_id,multi,allvalues) {

                    var answer = confirm("Are you sure you want to DELETE it?")
                    if (answer){

                        jQuery.post("<?php echo uri('exhibits/deleteelementvalue'); ?>", { element_hierarchy: element_hierarchy, record_id: record_id, multi: multi, allvalues: allvalues },
                        function(data) {

                            jQuery('#'+id+'_inputs').remove();
                        });

                    } 
                }

                function removeFormFieldTotal(id) {

                    var answer = confirm("Are you sure you want to DELETE it?")
                    if (answer){

                        jQuery('#'+id+'_inputs').remove();
                    } 
                }

                function UpdateLangstringFormFieldExisted(element_hierarchy,record_id,multi,language_id_old,language_id,id) {

                    var answer = confirm("Are you sure you want to CHANGE the language? This action will be SAVED!");
                    if (answer){

                        jQuery.post("<?php echo uri('exhibits/updatelangstringelementvalue'); ?>", { element_hierarchy: element_hierarchy, language_id: language_id, language_id_old: language_id_old, record_id: record_id, multi: multi },
                        function(data) {


                        });

                    }else{document.getElementById(id).value=language_id_old;} 
                }


                function removedivid(id) {

                    var answer = confirm("Are you sure you want to DELETE it?")
                    if (answer){

                        jQuery('#'+id+'').remove();
                    } 
                }

                function removeFormField(id) {
                    jQuery(id).remove();

                }

                function change49(value){

                }
                                </script>


                            </div><br style="clear:both;">
        <?php $date_modified = date("Y-m-d H:i:s"); ?>
                            <input type="hidden" name="date_modified" id="date_modified" value="<?php echo $date_modified; ?>" />
                            <input type="hidden" name="exhibit_id" id="exhibit_id" value="<?php echo $exhibit->id; ?>" />
    <?php } ?>
                    </div>  
                </div>

                <br style="clear:both;">  
                <?php /* ?>
                  <div id="item-metadata" style="position:relative; left:5px; top:33px; float:left; width:550px;">



                  <?php
                  $step=0;
                  $exec3=$db->query($sql2);




                  $data2=$exec3->fetchAll();//again to query gia ola ta parent =0 gia create step div



                  //query for all elements without asking pelement
                  $sql="SELECT d.element_id,d.labal_name,d.language_id,f.*,e.vocabulary_id FROM metadata_element_label d RIGHT JOIN metadata_element e ON d.element_id = e.id RIGHT JOIN metadata_element_hierarchy f ON f.element_id = e.id WHERE f.is_visible=1  and f.element_id!=32 ORDER BY (case WHEN f.sequence IS NULL THEN '9999' ELSE f.sequence END) ASC";
                  $exec4=$db->query($sql);
                  $data4=$exec4->fetchAll();
                  //end



                  //query for all values
                  $sql="SELECT * FROM metadata_record WHERE object_id=".$exhibit->id." and object_type='exhibit'";
                  $execrecord=$db->query($sql);
                  $datarecord=$execrecord->fetchAll();
                  foreach($datarecord as $datarecord){
                  $sql="SELECT * FROM metadata_element_value WHERE record_id=".$datarecord['id']." ";
                  }
                  $exec5=$db->query($sql);
                  $data5=$exec5->fetchAll();
                  //end



                  //query for all languages
                  $sqllan="SELECT * FROM metadata_language WHERE is_active=1 ORDER BY (case WHEN id='en' THEN 1 ELSE 2 END) ASC";
                  $execlan=$db->query($sqllan);
                  $datalan=$execlan->fetchAll();
                  //end

                  //query for selecting vocabulary
                  $sqlvoc="SELECT f.value,d.id FROM metadata_vocabulary d RIGHT JOIN metadata_vocabulary_record e ON d.id = e.vocabulary_id RIGHT JOIN metadata_vocabulary_value f ON f.vocabulary_rid = e.id";
                  $execvoc=$db->query($sqlvoc);
                  $datavoc=$execvoc->fetchAll();
                  //end query for selecting vocabulary


                  foreach($data2 as $data){  //for every element general
                  $step+=1; echo '<div class="toggle" id="step'.$step.'">'; //create div for toggle

                  foreach($data4 as $dataform){  //for every element under general
                  if($data['element_id']===$dataform['pelement_id']){ //if pelement tou hierarchy = element general





                  //if hierarchy form name = radio
                  if($dataform['form_type_id']===4){
                  foreach($data5 as $datarecord){ if($datarecord['element_hierarchy']===$dataform['id']){
                  $datarecordvalue=$datarecord['value'];}}//select the value for more than one foreach
                  echo '<label for="theme">'.$dataform['labal_name'].'</label>';

                  echo '<input type="radio" name="'.$dataform['id'].'" ';
                  if($datarecordvalue==='yes'){echo 'checked=checked ';}
                  echo 'value="yes"> Yes &nbsp;&nbsp;';

                  echo '<input type="radio" name="'.$dataform['id'].'" ';
                  if($datarecordvalue==='no'){echo 'checked=checked ';}
                  echo 'value="no"> No ';

                  if($dataform['id']===23){

                  echo '<input type="radio" name="'.$dataform['id'].'" ';
                  if($datarecordvalue==='Yes, if others share alike'){echo 'checked=checked ';}
                  echo 'value="Yes, if others share alike"> Yes, if others share alike ';

                  }

                  echo '<br style="clear:both"><br>';
                  } //end form name = radio






                  //if hierarchy form name = select
                  elseif($dataform['form_type_id']===3){

                  echo '<div style="float:left;border-bottom:1px solid #d7d5c4;padding-right:9px; margin-right:5px;padding-bottom:9px; margin-bottom:5px; width:100%;" id="'.$dataform['id'].'">';

                  //echo '<div id="'.$dataform['id'].'">';

                  echo '<div style="float:left;"><label for='.$dataform['id'].' style="width:158px;">'.$dataform['labal_name'].'</label></div>';

                  echo '<div style="float:left;" id="'.$dataform['id'].'_inputs">';


                  $formcount=0;
                  foreach($data5 as $datarecord){ if($datarecord['element_hierarchy']===$dataform['id']){ //select the value for more than one foreach
                  $datarecordvalue=$datarecord['value'];

                  $formmulti=$datarecord['multi'];
                  $formcount+=1;
                  echo'<div id="'.$dataform['id'].'_'.$formmulti.'_field">';

                  if($dataform['vocabulary_id']>0){//select and isset vocabulary

                  echo '<select name="'.$dataform['id'].'_'.$datarecord['multi'].'" style="width:300px;">';

                  echo '<option value="">Select </option>';

                  foreach($datavoc as $datavoc1){
                  if($datavoc1['id']===$dataform['vocabulary_id']){
                  echo '<option value="'.$datavoc1['value'].'" ';
                  if($datarecordvalue===$datavoc1['value']){echo 'selected=selected';}
                  echo '>'.$datavoc1['value'].'</option>';
                  }}
                  echo '</select>';
                  if($dataform['max_occurs']>1){?>
                  <a href="#" onClick="removeFormFieldExisted('<?php echo $dataform['id'].'_'.$formmulti.'_field'; ?>','<?php echo $dataform['id']; ?>','<?php echo $datarecord['language_id']; ?>','<?php echo $datarecord['record_id']; ?>','<?php echo $datarecord['multi']; ?>'); return false;" style="position:relative; left:5px; top:2px;">Remove</a><?php
                  }//maxoccurs>1
                  echo '<br style="clear:both"><br>';


                  } //select and isset vocabulary
                  else{


                  echo '<select name="'.$dataform['id'].'_'.$formcount.'">';
                  foreach($datalan as $datalan1){
                  echo '<option value="'.$datalan1['id'].'" ';
                  if($datarecordvalue===$datalan1['id']){echo 'selected=selected';}
                  echo '>'.$datalan1['locale_name'].'</option>';
                  }
                  echo '</select>';

                  echo '<br style="clear:both"><br>';

                  }//end else select and isset vocabulary
                  echo "</div>";
                  }}//select the value for more than one foreach



                  //an den uparxei eggrafh create one empty
                  if($formcount===0){
                  $formmulti=1;
                  $formcount+=1;
                  if($dataform['vocabulary_id']>0){//select and isset vocabulary

                  echo '<select name="'.$dataform['id'].'_'.$formcount.'" style="width:300px;">';
                  echo '<option value="">Select </option>';
                  foreach($datavoc as $datavoc1){
                  if($datavoc1['id']===$dataform['vocabulary_id']){
                  echo '<option value="'.$datavoc1['value'].'" ';
                  //if($datarecordvalue===$datalan1['id']){echo 'selected=selected';}
                  echo '>'.$datavoc1['value'].'</option>';
                  }}
                  echo '</select>';
                  echo '<br style="clear:both"><br>';


                  } //select and isset vocabulary
                  else{

                  echo '<select name="'.$dataform['id'].'_'.$formcount.'">';
                  foreach($datalan as $datalan1){
                  echo '<option value="'.$datalan1['id'].'" ';
                  //if($datarecordvalue===$datalan1['id']){echo 'selected=selected';}
                  echo '>'.$datalan1['locale_name'].'</option>';
                  }
                  echo '</select>';

                  echo '<br style="clear:both"><br>';

                  }//end else select and isset vocabulary


                  }

                  //end create one empty
                  echo "</div>";


                  if($dataform['max_occurs']>1){?>
                  <input name="hdnLine_<?php echo $dataform['id']; ?>" id="hdnLine_<?php echo $dataform['id']; ?>" type="hidden" value="<?php echo $formmulti; ?>">

                  <div style="position:relative;clear:both;"><a href="#" onClick="addFormFieldSelect('<?php echo $formmulti; ?>','<?php echo $dataform['id']; ?>','hdnLine_<?php echo $dataform['id']; ?>','<?php echo $dataform['vocabulary_id']; ?>'); return false;">Add</a></div>

                  <!--<INPUT style="margin-top:0px; margin-left:10px;" type="button" value="Add" onclick="addmulti('<?php //echo $formcount; ?>','<?php //echo $dataform['id']; ?>','hdnLine_<?php //echo $dataform['id']; ?>','<?php //echo $dataform['vocabulary_id']; ?>'); "/> -->
                  <?php }

                  echo '</div>';
                  echo '<br style="clear:both"><br>';

                  } //end form name = select


                  else{



                  echo '<div style="float:left;border-bottom:1px solid #d7d5c4;padding-right:9px; margin-right:5px;padding-bottom:9px; margin-bottom:5px; width:100%;" id="'.$dataform['id'].'">';

                  //echo '<div id="'.$dataform['id'].'">';

                  echo '<div style="float:left;"><label for='.$dataform['id'].' style="width:158px;">'.$dataform['labal_name'].'</label></div>';

                  $formcount=0;
                  echo '<div style="float:left;" id="'.$dataform['id'].'_inputs">';
                  foreach($data5 as $datarecord){ if($datarecord['element_hierarchy']===$dataform['id']){
                  $datarecordvalue=$datarecord['value']; $datarecordvaluelan=$datarecord['language_id'];//select the value for more than one foreach


                  $formcount+=1;

                  echo'<div id="'.$dataform['id'].'_'.$formcount.'_field">';
                  echo '<textarea rows="4" cols="30" class="textinput" name="'.$dataform['id'].'_'.$formcount.'" id="'.$dataform['id'].'_'.$formcount.'">'.stripslashes($datarecordvalue).'</textarea>&nbsp;&nbsp';

                  //if hierarchy type= langstring
                  if($dataform['datatype_id']===1){
                  echo '<select name="'.$dataform['id'].'_'.$formcount.'_lan" class="combo" style="vertical-align:top;">';
                  foreach($datalan as $datalan1){
                  echo '<option value="'.$datalan1['id'].'" ';
                  if($datarecordvaluelan===$datalan1['id']){echo 'selected=selected';}
                  echo '>'.$datalan1['locale_name'].'</option>';
                  }
                  echo '</select>';

                  }//langstring
                  ?><a href="#" onClick="removeFormFieldExisted('<?php echo $dataform['id'].'_'.$formcount.'_field'; ?>','<?php echo $dataform['id']; ?>','<?php echo $datarecord['language_id']; ?>','<?php echo $datarecord['record_id']; ?>','<?php echo $datarecord['multi']; ?>'); return false;" style="position:relative; left:5px; top:2px;">Remove</a><?php
                  echo '<br>';
                  echo '</div>';

                  }}//select the value for more than one foreach //if $datarecord['element_hierarchy']===$dataform['id']  an uparxei eggrafh


                  //an den uparxei eggrafh create one empty
                  if($formcount===0){

                  $formcount+=1;
                  echo '<textarea rows="4" cols="30" class="textinput" name="'.$dataform['id'].'_'.$formcount.'" id="'.$dataform['id'].'_'.$formcount.'" ></textarea>&nbsp;&nbsp';

                  //if hierarchy type= langstring
                  if($dataform['datatype_id']===1){
                  echo '<select name="'.$dataform['id'].'_'.$formcount.'_lan" class="combo">';
                  foreach($datalan as $datalan1){
                  echo '<option value="'.$datalan1['id'].'" ';
                  echo '>'.$datalan1['locale_name'].'</option>';
                  }
                  echo '</select>';

                  }//langstring

                  echo '<br>';

                  //end create one empty


                  }

                  echo "</div>";

                  ?>


                  <?php
                  //if hierarchy type= langstring
                  if($dataform['datatype_id']===1){ ?>
                  <div style="position:relative;clear:both;"><a href="#" onClick="addFormField('<?php echo $formcount; ?>','<?php echo $dataform['id']; ?>','hdnLine_<?php echo $dataform['id']; ?>'); return false;">Add</a></div>
                  <input name="hdnLine_<?php echo $dataform['id']; ?>" id="hdnLine_<?php echo $dataform['id']; ?>" type="hidden" value="<?php echo $formcount; ?>">
                  <?php } ?>


                  <?php


                  echo '</div>';


                  if($dataform['max_occurs']>1){?>

                  <p><a href="#" onClick="addFormField('<?php echo $formcount; ?>','<?php echo $dataform['id']; ?>','hdnLine_<?php echo $dataform['id']; ?>'); return false;">Add</a></p>
                  <input name="hdnLine_group_<?php echo $dataform['id']; ?>" id="hdnLine_group_<?php echo $dataform['id']; ?>" type="hidden" value="<?php echo $formcount; ?>">
                  <!--<INPUT style="margin-top:0px; margin-left:10px;" type="button" value="Add" onclick="add('<?php //echo $formcount; ?>','<?php //echo $dataform['id']; ?>','hdnLine_<?php //echo $dataform['id']; ?>'); "/> -->
                  <?php }
                  echo '<br style="clear:both"><br>';
                  }


                  }//if $data['element_id']===$dataform['pelement_id']


                  }//if pelement tou hierarchy = element general (dataform)

                  echo '<br><br></div>';  //close div general

                  }//end for every element general  (data)

                  ?>

                  <script type="text/javascript">
                  function addFormField(multi,divid,iddiv) {
                  var id = document.getElementById(''+iddiv+'').value;
                  id = (id - 1) + 2;
                  document.getElementById(''+iddiv+'').value = id;

                  jQuery('#'+divid+'_inputs').append("<div id='row" + id + "'><textarea cols='30' row='5' class='textinput' name='"+divid+"_"+id+"' id='txt" + id + "'></textarea>&nbsp;&nbsp<select style='vertical-align:top;' name='"+divid+"_"+id+"_lan' class='combo'><?php foreach($datalan as $datalan1){?><option value='<?php echo $datalan1['id']; ?>'><?php echo $datalan1['locale_name']; ?></option><?php } ?></select>&nbsp;&nbsp;<a href='#' onClick='removeFormField(\"#row" + id + "\"); return false;'>Remove</a><div>");


                  }

                  function addFormFieldSelect(multi,divid,iddiv,vocabulary_id) {
                  var id = document.getElementById(''+iddiv+'').value;
                  id = (id - 1) + 2;
                  document.getElementById(''+iddiv+'').value = id;
                  var selectoption="<div id='row" + id + "'><select name='"+divid+"_"+id+"' class='combo' style='width:300px;'>";
                  selectoption+="<option value=''>Select</option>";

                  <?php foreach($datavoc as $datavoc1){ ?>
                  var vocabulary=<?php echo $datavoc1['id']; ?>;
                  if(vocabulary_id==vocabulary){
                  selectoption+="<option value='<?php echo $datavoc1['value']; ?>'><?php echo $datavoc1['value']; ?></option>"; }
                  <?php }	?>
                  selectoption+="</select> <a href='#' onClick='removeFormField(\"#row" + id + "\"); return false;'>Remove</a><div><br>";

                  jQuery('#'+divid+'_inputs').append(selectoption);


                  }


                  function removeFormFieldExisted(id,element_hierarchy,language_id,record_id,multi) {

                  var answer = confirm("Are you sure you want to DELETE it?")
                  if (answer){

                  jQuery.post("<?php echo uri('exhibits/deleteelementvalue'); ?>", { element_hierarchy: element_hierarchy, language_id: language_id, record_id: record_id, multi: multi },
                  function(data) {

                  jQuery('#'+id).remove();
                  });

                  }
                  }



                  function removeFormField(id) {
                  jQuery(id).remove();

                  }
                  </script>


                  </div><br style="clear:both;">
                  <?php */ ?>
            <?php } //if isset exhibit view metadata ?>
            <?php //Metadata End 
            ?>

            <br>
            <div style="border-bottom:solid; position:relative;"></div>
            <br style="clear:both;">
            <fieldset>
                    <?php if (isset($exhibit['id'])) { ?> <legend><?php echo return_template_by_id($exhibit['target_group']); ?> <?php echo __('Sections and Pages'); ?></legend>
                    <div id="section-list-container">
                        <?php if (!$exhibit->Sections): ?>
                            <p><?php echo __('There are no sections'); ?>.</p>
                        <?php else: ?>
                            <p id="reorder-instructions"><!--To reorder sections or pages, click and drag the section or page up or down to the preferred location. --></p>
                            <?php endif; ?>
                        <ul class="section-list">
    <?php common('section-list', compact('exhibit'), 'exhibits'); ?>
                        </ul>
                    </div>
                <?php }else { ?> <legend><?php echo __('Select Pathway Template'); ?></legend>
                    <?php
                    echo '<select name="template">';
                    $total_templates = return_template_by_id(0);
                    //print_r($total_templates);
                    foreach ($total_templates as $total_templates) {
                        echo '<option value="' . $total_templates['id'] . '">' . $total_templates['name'] . '</option>';
                    }

                    echo '</select>';
                    ?>
<?php } ?>
                <!--<div id="section-add">
                    <input type="submit" name="add_section" id="add-section" value="Add Section" />
                </div> -->
            </fieldset>



            <div class="field">
                <?php
                $date_modified = date("Y-m-d H:i:s");
                //echo $date_modified; 
                ?>
                <input type="hidden" name="date_modified" id="date_modified" value="<?php echo $date_modified ?>" />
                <input type="hidden" name="exhibit_id" id="exhibit_id" value="<?php echo $exhibit['id']; ?>" />
            </div>


            <fieldset>
                <p id="exhibit-builder-save-changes">
<?php if (isset($exhibit['id'])) { ?>
                        <input type="submit" name="save_meta" id="save_exhibit" value="<?php echo __('Save Changes'); ?>" />
                        <input type="submit" name="save_exhibit" id="save_exhibit" value="<?php echo __('Save and Finish'); ?>" />
                    <?php } else { ?>
                        <input type="submit" name="add_exhibit" id="save_exhibit" value="<?php echo __('Add a Pathway'); ?>" />
<?php } ?>
                    or 
                    <a href="<?php echo html_escape(uri('exhibits')); ?>" class="cancel"><?php echo __('Cancel'); ?></a>
                </p>
            </fieldset>
        </form>     
</div>
<?php foot(); ?>





<?php /* origina; code from omeka
  <script type="text/javascript" charset="utf-8">
  //<![CDATA[
  var listSorter = {};

  function makeSectionListDraggable()
  {
  var sectionList = jQuery('.section-list');
  var sectionListSortableOptions = {axis:'y', forcePlaceholderSize: true};
  var sectionListOrderInputSelector = '.section-info input';

  var sectionListDeleteLinksSelector = '.section-delete a';
  var sectionListDeleteConfirmationText = <?php echo js_escape(__('Are you sure you want to delete this section?')); ?>;
  var sectionListFormSelector = '#exhibit-metadata-form';
  var sectionListCallback = Omeka.ExhibitBuilder.addStyling;
  makeSortable(sectionList,
  sectionListSortableOptions,
  sectionListOrderInputSelector,
  sectionListDeleteLinksSelector,
  sectionListDeleteConfirmationText,
  sectionListFormSelector,
  sectionListCallback);

  var pageListSortableOptions = {axis:'y', connectWith:'.page-list'};
  var pageListOrderInputSelector = '.page-info input';
  var pageListDeleteLinksSelector = '.page-delete a';
  var pageListDeleteConfirmationText = <?php echo js_escape(__('Are you sure you want to delete this page?')); ?>;
  var pageListFormSelector = '#exhibit-metadata-form';
  var pageListCallback = Omeka.ExhibitBuilder.addStyling;

  var pageLists = jQuery('.page-list');
  jQuery.each(pageLists, function(index, pageList) {
  makeSortable(jQuery(pageList),
  pageListSortableOptions,
  pageListOrderInputSelector,
  pageListDeleteLinksSelector,
  pageListDeleteConfirmationText,
  pageListFormSelector,
  pageListCallback);

  // Make sure the order inputs for pages change the names to reflect their new
  // section when moved to another section
  jQuery(pageList).bind('sortreceive', function(event, ui) {
  var pageItem = jQuery(ui.item);
  var orderInput = pageItem.find(pageListOrderInputSelector);
  var pageId = orderInput.attr('name').match(/(\d+)/g)[1];
  var nSectionId = pageItem.closest('li.exhibit-section-item').attr('id').match(/(\d+)/g)[0];
  var nInputName = 'Pages['+ nSectionId + ']['+ pageId  + '][order]';
  orderInput.attr('name', nInputName);
  });
  });
  }

  jQuery(window).load(function() {
  Omeka.ExhibitBuilder.wysiwyg();
  Omeka.ExhibitBuilder.addStyling();

  makeSectionListDraggable();

  // Fixes jQuery UI sortable bug in IE7, where dragging a nested sortable would
  // also drag its container. See http://dev.jqueryui.com/ticket/4333
  jQuery(".page-list li").hover(
  function(){
  jQuery(".section-list").sortable("option", "disabled", true);
  },
  function(){
  jQuery(".section-list").sortable("option", "disabled", false);
  }
  );
  });
  //]]>
  </script>

  <h1><?php echo html_escape($exhibitTitle); ?></h1>

  <div id="primary">
  <div id="exhibits-breadcrumb">
  <a href="<?php echo html_escape(uri('exhibits')); ?>"><?php echo __('Exhibits'); ?></a> &gt;
  <?php echo html_escape($exhibitTitle); ?>
  </div>

  <?php echo flash();?>

  <form id="exhibit-metadata-form" method="post" class="exhibit-builder">

  <fieldset>
  <legend><?php echo __('Exhibit Metadata'); ?></legend>
  <div class="field">
  <?php echo text(array('name'=>'title', 'class'=>'textinput', 'id'=>'title'), $exhibit->title, __('Title')); ?>
  <?php echo form_error('title'); ?>
  </div>
  <div class="field">
  <?php echo text(array('name'=>'slug', 'id'=>'slug', 'class'=>'textinput'), $exhibit->slug, __('Slug')); ?>
  <p class="explanation"><?php echo __('No spaces or special characters allowed.'); ?></p>
  <?php echo form_error('slug'); ?>
  </div>
  <div class="field">
  <?php echo text(array('name'=>'credits', 'id'=>'credits', 'class'=>'textinput'), $exhibit->credits, __('Credits')); ?>
  </div>
  <div class="field">
  <?php echo textarea(array('name'=>'description', 'id'=>'description', 'class'=>'textinput','rows'=>'10','cols'=>'40'), $exhibit->description, __('Description')); ?>
  </div>
  <?php $exhibitTagList = join(', ', pluck('name', $exhibit->Tags)); ?>
  <div class="field">
  <?php echo text(array('name'=>'tags', 'id'=>'tags', 'class'=>'textinput'), $exhibitTagList, __('Tags')); ?>
  </div>
  <div class="field">
  <label for="featured"><?php echo __('Featured'); ?></label>
  <div class="radio"><?php echo checkbox(array('name'=>'featured', 'id'=>'featured'), $exhibit->featured); ?></div>
  </div>
  <div class="field">
  <label for="featured"><?php echo __('Public'); ?></label>
  <div class="radio"><?php echo checkbox(array('name'=>'public', 'id'=>'public'), $exhibit->public); ?></div>
  </div>
  <div class="field">
  <label for="theme"><?php echo __('Theme'); ?></label>
  <?php $values = array('' => __('Current Public Theme')) + exhibit_builder_get_ex_themes(); ?>
  <div class="select"><?php echo __v()->formSelect('theme', $exhibit->theme, array('id'=>'theme'), $values); ?>
  <?php if ($theme && $theme->hasConfig): ?><a href="<?php echo html_escape(uri("exhibits/theme-config/$exhibit->id")); ?>" class="configure-button button"><?php echo __('Configure'); ?></a><?php endif;?>
  </div>
  </div>
  </fieldset>
  <fieldset>
  <legend><?php echo __('Sections and Pages'); ?></legend>
  <div id="section-list-container">
  <?php if (!$exhibit->Sections): ?>
  <p><?php echo __('There are no sections.'); ?></p>
  <?php else: ?>
  <p id="reorder-instructions"><?php echo __('To reorder sections or pages, click and drag the section or page up or down to the preferred location.'); ?></p>
  <?php endif; ?>
  <ul class="section-list">
  <?php common('section-list', compact('exhibit'), 'exhibits'); ?>
  </ul>
  </div>
  <div id="section-add">
  <input type="submit" name="add_section" id="add-section" value="<?php echo __('Add Section'); ?>" />
  </div>
  </fieldset>
  <fieldset>
  <p id="exhibit-builder-save-changes">
  <input type="submit" name="save_exhibit" id="save_exhibit" value="<?php echo __('Save Changes'); ?>" /> <?php echo __('or'); ?>
  <a href="<?php echo html_escape(uri('exhibits')); ?>" class="cancel"><?php echo __('Cancel'); ?></a>
  </p>
  </fieldset>
  </form>
  </div>
  <?php foot(); ?>
 * 
 */ ?>
