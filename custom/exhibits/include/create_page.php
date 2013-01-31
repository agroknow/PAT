<?php
	
	require_once("../../include/db_connect.php");

	$path_db="../../../application/config/db.ini";
	db_connect($path_db);

	$item_name=$_POST["title"];
	$item_id=$_POST["item_id"];
	$response="";
		
	include("../Classes/class.FastTemplate.php3");
	
	$tpl=new FastTemplate("../templates");
	$tpl->define(array( "MAIN_PAGE" => "create_page_master.tpl"));
	
	$query_video_name="select archive_filename from omeka_files where item_id='$item_id'";
	$result_video_name=mysql_query($query_video_name);
	$numrows_video_name=mysql_numrows($result_video_name);
	
	if ( $numrows_video_name < 1 ){
		$response=1; //no video found for this item		
	}
	else{
		if ( $result_video_name ){
			$row_video_name=mysql_fetch_array($result_video_name);
			$video_name=$row_video_name["archive_filename"];
			
			
			$movie_path="../../../archive/files/".$video_name;
			$tpl->assign("{MOVIE_PATH}",$movie_path);
			$tpl->assign("{MOVIE_NAME}",$video_name);			
			
			
			$tpl->parse(MAIN, "MAIN_PAGE");
			$html_file = $tpl->FastPrint();			
			
			
			$file_path="../../../themes/eknownetv3/movies/video_".$item_id.".html";
			//$file_path="video_".$item_id.".html";
			$handle = fopen($file_path,"w");
			if(fwrite($handle, $html_file)){
				$response=4; //success
			}else{
				$response=3; //error
			}
			fclose($handle);			
		}
		else{
			$response=2; //an unexpected error occured
		}
	}	
	
	echo $response;
?>
