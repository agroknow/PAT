<?php
	
	require_once("../../include/db_connect.php");

	$path_db="../../../application/config/db.ini";
	db_connect($path_db);

	$keyword = $_GET["q"];

	if ( !$keyword ) return;
    
	$patterns = array('/\s+/', '/"+/', '/%+/'); 
	$replace = array(''); 
	$keyword = preg_replace($patterns, $replace, $keyword); 



	if($keyword != '') 
	    $query = 'select id, title, slug, target_group from omeka_exhibits '.
		   'where (title like "%'.$keyword.'%"'.'
		   and public=1 ) order by title';
	else 
	    $query = 'select id, title, slug, target_group from omeka_exhibits '.
		   'where (title="" '.
		   ' and public=1 ) order by title';	

	$result = mysql_query($query);
	
	while ($row=mysql_fetch_array($result)){        
		$find_title=$row["title"];
		$find_id=$row["id"];
		$find_slug=$row["slug"];
        $find_group=$row["target_group"];

		//$find_name.="#m6s#".$find_tag;
		
		echo "$find_title|$find_id;$find_slug;$find_group\n";
	}  	
?>
