<?php
    require_once("./custom/include/db_connect.php");  
    
    $path_db="./application/config/db.ini";
	db_connect($path_db);

// RETURN THE ITEM-IMAGES THAT BELONG TO COLLECTION
//  this query fetches images that belong to a specific item
	$queryReturnItemImages=mysql_query("SELECT a.*,b.archive_filename,b.original_filename, b.description
  	 				 					FROM omeka_items a LEFT JOIN omeka_files b ON (b.item_id=a.id)
  	 		     			 			WHERE a.id='".$id."'");
	

	$isEmpty = true;		//if the query returns NO images
	$count = 1;
	$hmtl_photo='';
	
	
	while(($Images = mysql_fetch_array($queryReturnItemImages)) && $count==1){
		if(  !is_null($Images['archive_filename'])  )	{			//for records that are returned with   original_filename = NULL
			
			/* use the jpg version of images */
			$Images_jpg = explode('.',$Images['archive_filename'],2);
			
			if ($Images_jpg[1]=='gif') {
				$Images_jpg = $Images_jpg[0].".gif";
			}
			else if ($Images_jpg[1]=='png') {
				$count=0;
			}
			else
			{
				$Images_jpg = $Images_jpg[0].".jpg";
			}
			
			
			//echo '<img src="http://education.natural-europe.eu/natural_europe/custom/phpThumb/phpThumb.php" alt="">';
			//echo '<img src="./custom/phpThumb/phpThumb.php?src=http://education.natural-europe.eu/natural_europe/archive/files/'.$Images['archive_filename'].'&w=100">';
			
			// For collection browse check of the Get[collection] variable is assigned
			if ($_GET['collection'])
			{
				$hmtl_photo = 	'<div ><a name="leaf" href="'.uri('items/show/'.$id.'').'">	   
								<img src="http://education.natural-europe.eu/natural_europe/archive/files/'.$Images['archive_filename'].'" height="90px"></a></div>';
	
				if ($Images['description']) $hmtl_photo .= 	'<div style="margin-left: 75px;"><b>Caption</b>: <br>'.substr($Images['description'], 0, 228).'&nbsp;&nbsp;<a href="'.uri('items/show/'.$id.'').'">...More</a></div>';
				$count++;
			}
			// for the show item page
			else 
			{
				$hmtl_photo .= 	'<div ><a name="leaf" class="lightview" title="'.$Images['description'].' :: '.$Images['rights'].'" href="http://education.natural-europe.eu/natural_europe/archive/files/'.$Images['archive_filename'].'">	   
								<img src="http://education.natural-europe.eu/natural_europe/archive/files/'.$Images['archive_filename'].'" height="120px"></a></div>';
	
				if ($Images['description']) $hmtl_photo .= 	'<div style="margin-left: 5px;"><b>Caption</b>: <br>'.$Images['description'].'</div>';
			}
			$isEmpty = false;		// the query return at least on record
			
		}
		else
		{
			$hmtl_photo ='';
		}//telos if
	}//telos while					
	
?>