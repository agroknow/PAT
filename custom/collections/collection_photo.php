<?php
    require_once("./custom/include/db_connect.php");  
    
    $path_db="./application/config/db.ini";
	db_connect($path_db);

// RETURN THE ITEM-IMAGES THAT BELONG TO COLLECTION
//  this query fetches images that belong to a specific item

	$queryReturnItemImages=mysql_query("SELECT * FROM omeka_items WHERE collection_id='".$id."' and featured='1' AND type_id=19"); 
											
$Images = mysql_fetch_array($queryReturnItemImages);
if($Images['source']){
				
				$uri_part1 = uri('items/browse/', array('collection'=>$collection->id)); $uri_part2 = '&title='.h($collection->name); 
				
			$hmtl_photo = 	'<a   href="'.$uri_part1.$uri_part2.$targetteam.'">	   
							<img src="http://education.natural-europe.eu/natural_europe/custom/phpThumb/phpThumb.php?src='.$Images['source'].'&amp;w=135" border="0"></a>';   
				  				
			$isEmpty = false;		// the query return at least on record
			$count++;
		}
		else
		{
			$hmtl_photo ='';
		}//telos if
				
	
?>