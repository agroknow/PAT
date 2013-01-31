<?php 
		    require_once("./custom/include/db_connect.php");  
    
    $path_db="./application/config/db.ini";
	db_connect($path_db);
	
		function item_select($type_id,$title)
	{


$query="SELECT title,description FROM  omeka_items  ";
$query.=" WHERE type_id=$type_id AND title='$title' ";

$query=mysql_query($query) or die(" Error: ".mysql_error());

$result = mysql_fetch_assoc($query); 


  $return_result.= "<div id='content_paging'>".$result['description']."</div>" ; 

	 
	return $return_result;
	}  

	
?>