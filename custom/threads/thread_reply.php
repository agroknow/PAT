<?php
require_once("../include/conf.php");

require_once("../include/db_connect.php");  
$path_db="../../application/config/db.ini";
db_connect($path_db);

if($_POST["thread_text"]==''){ 

} else{
foreach ($_POST as $var => $value) {
echo "$var = $value<br>";
} 

$sql_values="";
$fields = explode("&",$_POST['data']);
foreach($fields as $field){
	$field_key_value = explode("=",$field);
	$key = urldecode($field_key_value[0]);
	$value = urldecode($field_key_value[1]);
	$sql_values.="'".$value."',";
}


$sql="INSERT INTO omeka_replies (user_id,exhibit_id,thread_id,text,post_date)
VALUES (".$_POST['uid'].",".$_POST['eid'].",".$_POST['thread_id'].",'".$_POST['thread_text']."', NOW())";
//$sql="INSERT INTO omeka_threads ( user_id , exhibit_id, text,post_date)
//VALUES (".$sql_values." NOW())";
//ECHO $sql;
$res=mysql_query($sql);
//if ($res) echo "ok";
//else echo "skata";

}//if is keno
?>