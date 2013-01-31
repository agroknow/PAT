<?php
require_once("../include/conf.php");
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Natural Europe - Add Supporting Materials</title>

<!-- Meta -->
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<!-- Stylesheets -->
<link rel="stylesheet" media="screen" href="<?php echo $urllinkbase; ?>admin/themes/default/css/screen.css" />
<link rel="stylesheet" media="print" href="<?php echo $urllinkbase; ?>admin/themes/default/css/print.css" />
<link rel="stylesheet" media="screen" href="<?php echo $urllinkbase; ?>admin/themes/default/css/niftyCorners.css" />

<link rel="stylesheet" media="screen" href="<?php echo $urllinkbase; ?>shared/exhibit_layouts/text-image-right/layout.css" />

<?php 	  
		$autocomplete_scripts="<script type='text/javascript' src='".$AUTO_BASE."lib/jquery.bgiframe.min.js'></script> ".
					"<script type='text/javascript' src='".$AUTO_BASE."lib/jquery.ajaxQueue.js'></script> ".
					"<script type='text/javascript' src='".$AUTO_BASE."lib/thickbox-compressed.js'></script> ".
					"<script type='text/javascript' src='".$AUTO_BASE."jquery.autocomplete.js'></script> ".					
					"<link rel='stylesheet' type='text/css' href='".$AUTO_BASE."jquery.autocomplete.css'> ".
					"<link rel='stylesheet' type='text/css' href='".$AUTO_BASE."lib/thickbox.css'> ";
					$autocomplete_scripts.="<script type='text/javascript' src='".$AUTO_BASE."search_teaser.js'></script> ";
					if(isset($_GET['testtime'])){$autocomplete_scripts.="<script type='text/javascript' src='".$AUTO_BASE."search_testtime.js'></script> ";}
					if(isset($_GET['students_reality'])){$autocomplete_scripts.="<script type='text/javascript' src='".$AUTO_BASE."search_students_reality.js'></script> ";}
					if(isset($_GET['evaluation_activities'])){$autocomplete_scripts.="<script type='text/javascript' src='".$AUTO_BASE."search_evaluation_activities.js'></script> ";}
                                        
                $jquery_script="<script type='text/javascript' src='".$JQUERY_BASE."jquery-1.3.2.js'></script> ";
                
                $select_box_script="<script type='text/javascript' src='".$SELECT_BOXES_BASE."jquery.selectboxes.pack.js'></script> ";
                
                $custom_scripts="<script type='text/javascript' src='".$CUSTOM_SCRIPTS_BASE."scripts.js'></script> ";
                
                
                $scripts="";
                $scripts.=$jquery_script.$autocomplete_scripts.$select_box_script.$custom_scripts;
                
                echo $scripts;

?>
</head>
<body class="exhibits">
<?php $pageURL= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];?>
<form name="item-exhibit" id="page-form" method="post" action="http://<?php echo $pageURL; ?>">


<div id="content">

<div id="primary">



<?php
//contact with database
    require_once("../include/db_connect.php");  
    
    $path_db="../../db.ini";
	db_connect($path_db);
	
function onlyNumbers($string){
    //This function removes all characters other than numbers
    $string = preg_replace("/[^0-9]/", "", $string);
    return (int) $string;
} 

    $exhibit_id=onlyNumbers($_GET['ex_id']);
	$sec_id=onlyNumbers($_GET['sec_id']);
	$pg_id=onlyNumbers($_GET['pg_id']);	
	$user_id=onlyNumbers($_GET['entityid']);	
	
	
//if isset the exhibit	
	$sqlexhibit="select id from omeka_exhibits where id=".$exhibit_id."";
$res_sqlexhibit=mysql_query($sqlexhibit);
$result_sqlexhibit=mysql_fetch_array($res_sqlexhibit);
if(isset($result_sqlexhibit['id'])){ 


     if(isset($_POST['insert']) and $_POST['insert']=='Insert'){
	 
	  
$query_item_js="select text from omeka_element_texts  where record_id=".$_POST['select_item']." and element_id=68";
//echo $query_item_js; break;
$res_item_js=mysql_query($query_item_js);
$result_item_js=mysql_fetch_array($res_item_js);
	 
                   if($_POST['select_item']>0){
				   $query_teaser="insert into omeka_teasers (sec_id,exhibit_id,pg_id,item_id,type) values (".$sec_id.",".$exhibit_id.",".$pg_id.",".$_POST['select_item'].",'null')";
				    $result_teaser=mysql_query($query_teaser);
					
					$query_teaser="SELECT LAST_INSERT_ID() AS LAST_ID FROM omeka_teasers";
				    $result_teaser=mysql_query($query_teaser);
					$result_teaser_id=mysql_fetch_array($result_teaser);
				        ?>
                          <script language=JavaScript>
						  window.close();
						  window.opener.document.getElementById('text_supporting').innerHTML += "<?php echo "<div style='padding-top:6px;'><a href='javascript:deleteObject(".$result_teaser_id['LAST_ID'].")' class='delete'><span class='section-delete'>&nbsp;</span></a><a style='padding-left:10px;' target='_new' href='".$urllinkbase."admin/items/edit/".$_POST['select_item']."'>".$result_item_js['text']."</a></div>"; ?>";
						  </script>
						  <?php }//if $_POST['select_item']>0 
						  else{?>
						  <script language=JavaScript>
						  window.close();
						  </script>
						  <?php }//else $_POST['select_item']>0 ?>
<?php }

//end contact with database

echo "<div>Select an object to add</div>"; 
    
    echo '<div><input type="text" id="search_item" name="search_item" rows="30" cols="50" class="textinput"></div>';
    echo "<br style='clear:both;'><div>All Items: </div>";
    echo '<select name="select_item" id="select_item" style="width:336px;">';
                
        echo $query_item="select a.id, f.text from omeka_items a JOIN omeka_entities_relations b ON a.id=b.relation_id JOIN omeka_entities c ON c.id=b.entity_id 
		JOIN omeka_users d ON c.id=d.entity_id JOIN omeka_element_texts f ON a.id=f.record_id  where 
		b.relationship_id=1 and b.entity_id=".$user_id." and a.public=1  and f.element_id=68 order by a.added desc";
      /// echo $query_item; break;
		$result_item=mysql_query($query_item);
        $numrows_item=mysql_numrows($result_item);
		
				

        if ( $numrows_item <1 ){
            echo '<option>No items</option>';
        }
        else{
		        echo '<option value="0" >Choose an Item or (Nothing)</option>';    
        }
        
        for ($i=0;$i<$numrows_item;$i++){
            $row_item=mysql_fetch_array($result_item);
            
            $item_id=$row_item["id"];
            $item_title=$row_item["text"];
            if($item_id==$row_teaser_item['id']){
            echo '<option value="'.$item_id.'" selected="selected">'.$item_title.'</option>'; 
			}
			else{
			echo '<option value="'.$item_id.'">'.$item_title.'</option>';
			}          
        }
        

    echo '</select>';
    
    echo '<br><br>';
    
    echo '<p id="page-submits">';

    echo '<input type="submit" name="insert" value="Insert" style="margin-right: 10px;float:left;">';
    echo '<input type="button" onClick="return Close();" name="cancel" value="Cancel"  style="float:left;">';
    
    echo "</p>";
	  echo '<input type="hidden" name="item_title_hid" id="item_title_hid" >';

	
	}//if isset the exhibit
?>
</div>

</div>
</form>

</body>
</html>