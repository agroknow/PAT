<?php
	
	require_once("../../include/db_connect.php");

	$path_db="../../../db.ini";
	db_connect($path_db);

	$keyword = $_GET["q"];

	if ( !$keyword ) return;
    
	$patterns = array('/\s+/', '/"+/', '/%+/'); 
	$replace = array(''); 
	$keyword = preg_replace($patterns, $replace, $keyword); 



	if($keyword != '') {
	$query=" select a.id, f.text from omeka_items a JOIN omeka_entities_relations b ON a.id=b.relation_id JOIN omeka_entities c ON c.id=b.entity_id 
		JOIN omeka_users d ON c.id=d.entity_id JOIN omeka_element_texts f ON a.id=f.record_id  where f.text like '%".$keyword."%'"."
		  and b.relationship_id=1 and a.public=1 and b.entity_id=".$_GET['user_id']."  and f.element_id=68";
		
}
	else {
	    $query = " select a.id, f.text from omeka_items a JOIN omeka_entities_relations b ON a.id=b.relation_id JOIN omeka_entities c ON c.id=b.entity_id 
		JOIN omeka_users d ON c.id=d.entity_id JOIN omeka_element_texts f ON a.id=f.record_id  where b.relationship_id=1 and a.public=1 and b.entity_id=".$_GET['user_id']."  and f.element_id=68";	
}
	$result = mysql_query($query);
	
	while ($row=mysql_fetch_array($result)){        
		$find_title=$row["text"];
		$find_id=$row["id"];

		//$find_name.="#m6s#".$find_tag;
		
		echo "$find_title|$find_id\n";
	}  	
?>
