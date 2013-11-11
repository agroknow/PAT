<?php 
$exhibit_id = preg_replace("/[^0-9]/", "", $_POST['ex_id']);
$sec_id = preg_replace("/[^0-9]/", "", $_POST['sec_id']);
$pg_id = preg_replace("/[^0-9]/", "", $_POST['pg_id']);
$item_id = preg_replace("/[^0-9]/", "", $_POST['item_id']);
$lastinsertid=array();
$lastinsertid=addteasers_to_pathway_page($exhibit_id,$sec_id,$pg_id,$item_id); 
if($lastinsertid['id']>0){
echo "<div style='padding-top:6px;'><a href='javascript:deleteObject(" . $lastinsertid['id'] . ")' class='delete'><span class='section-delete'>&nbsp;</span></a><a style='padding-left:10px;' target='_new' href='" . uri('items/edit/') . "" . $item_id . "'>" . $lastinsertid['text'] . "</a></div>";    
}
?>