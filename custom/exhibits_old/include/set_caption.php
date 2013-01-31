<?php
	
	require_once("../../include/db_connect.php");

	$path_db="../../../application/config/db.ini";
	db_connect($path_db);

	$item_id=$_POST["item_id"];
	$response="";
	
	$query_caption="select text from omeka_metatext where item_id='$item_id' and metafield_id='49'";
	$result_caption=mysql_query($query_caption);
	if ( $result_caption ){
		$numrows_caption=mysql_numrows($result_caption);
		
		if ( $numrows_caption > 0 ){
			$row_caption=mysql_fetch_array($result_caption);
			$item_caption=htmlspecialchars($row_caption["text"], ENT_QUOTES);
			
			if ( strlen($item_caption) > 0 ){
				$response=$item_caption;
			}
			else{
				$response=2; //no caption found
			}			
		}
		else{
			$response=2; //no caption found
		}
	}
	else{
		$response=1; //unexpected error
	}
	
	echo $response;
?>
