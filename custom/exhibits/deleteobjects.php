<?php
require_once("../include/conf.php");
require_once("../include/db_connect.php");  
    
    $path_db="../../db.ini";
    db_connect($path_db);
	
function onlyNumbers($string){
    //This function removes all characters other than numbers
    $string = preg_replace("/[^0-9]/", "", $string);
    return (int) $string;
} 
if(isset($_GET['ts_id'])){
	$_GET['ts_id']=onlyNumbers($_GET['ts_id']);

$sql = 'SELECT * FROM omeka_teasers where id ="'.$_GET['ts_id'].'"';
$res=mysql_query($sql);
$result_sqlexhibit=mysql_fetch_array($res);	

$sql = 'DELETE FROM omeka_teasers where id ="'.$_GET['ts_id'].'"';
mysql_query($sql);

//$sql = 'SELECT a.*,b.title FROM omeka_teasers a JOIN omeka_items b ON a.item_id=b.id WHERE a.exhibit_id="'.$result_sqlexhibit['exhibit_id'].'" and a.pg_id="'.$result_sqlexhibit['pg_id'].'" and a.type!="europeana"';

$sql="SELECT a.*,c.text FROM omeka_teasers a JOIN omeka_items b ON a.item_id=b.id JOIN omeka_element_texts c ON a.item_id=c.record_id WHERE a.exhibit_id=".$result_sqlexhibit['exhibit_id']." and a.pg_id=".$result_sqlexhibit['pg_id']." and a.type!='europeana' and c.element_id=68";

$res=mysql_query($sql);
$output='';
while ($data2=mysql_fetch_array($res)){
$output.='<div id="pagedelete" style="padding-top:6px;">
		<a href="javascript:deleteObject('.$data2['id'].');"  class="delete" ><span class="section-delete">&nbsp;</span></a>';
$output.="<a style='padding-left:10px;' target='_new' href='".$urllinkbase."admin/items/edit/".$data2['item_id']."'>".$data2['text']."</a>";
$output.='</div>';
		}
echo $output;
} else { echo '0'; }
?>