<?php
	require_once("../../exhibits/include/getid3/getid3/getid3.php");
	require_once("../../include/db_connect.php");

	$path_db="../../../application/config/db.ini";
	db_connect($path_db);

	$item_id=$_POST["item_id"];
	$response="";
	
	$query_video_name="select width,height from omeka_files where item_id='$item_id'";
	$result_video_name=mysql_query($query_video_name);
	$row_video_name=mysql_fetch_array($result_video_name);
	$video_namex=$row_video_name["width"];
	$video_namey=$row_video_name["height"];
	
	
	echo $video_namex; 
	 
?>