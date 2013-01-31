<?php
	
	require_once("../../include/db_connect.php");

	$path_db="../../../application/config/db.ini";
	db_connect($path_db);

	$item_id=$_POST["item_id"];
	$response="";
	
	$query_video_name="select archive_filename,rights from omeka_files where item_id='$item_id'";
	$result_video_name=mysql_query($query_video_name);
	$row_video_name=mysql_fetch_array($result_video_name);
	$video_name=$row_video_name["archive_filename"];
	$video_name_rights=$row_video_name["rights"];
	
	
	echo $video_name;
?>
