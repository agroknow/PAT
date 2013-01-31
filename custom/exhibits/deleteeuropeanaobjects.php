<?php
require_once("../include/conf.php");
require_once("../include/db_connect.php");  
    
    $path_db="../../application/config/db.ini";
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

$sql = "SELECT * FROM omeka_teasers WHERE exhibit_id=".$result_sqlexhibit['exhibit_id']." and pg_id=".$result_sqlexhibit['pg_id']." and type='europeana'";
$res=mysql_query($sql);
$output='';
while ($data2=mysql_fetch_array($res)){
$output.='<div id="pagedelete" style="padding-top:6px;">
		<a href="javascript:deleteeuropeanaObject('.$data2['id'].');"  class="delete" ><span class="section-delete">&nbsp;</span></a>';
$output.="<a style='padding-left:10px;' target='_new' href='".$data2['europeana_uri']."'>".$data2['europeana_title']."</a>";
$output.='</div>';
		}
echo $output;
} else { echo '0'; }
?>