<?php
include('dbConn.php');


/*	DETECT BROWSER FOR  method setAttribute in javascrit for attribute class	*/
$browser = strtolower($_SERVER['HTTP_USER_AGENT']); // what browser they use.

if(ereg("msie", $browser)) {
$class="className";
} else {
$class="class";
}

/************END OF DETECTION******************/


/***********Check multiple resources****************/
//$_GET['item']="protein&Atom";
$findme = '/';
$pos = stripos($_GET['item'],$findme);
if($pos==true) 
{
	$items = explode($findme,$_GET['item']);
	$sql_items = "WHERE (a.title='".$items[0]."'";
	$sizeof_arr = sizeof($items);
	for ($i=1; $i<$sizeof_arr; $i++) 
	{
		$sql_items .= "OR a.title='".$items[$i]."'";
	}
	$sql_items .=")";
}
else
{
	$sql_items = "WHERE a.title='".$_GET['item']."'";
}
 

if ($_GET['field'] == 'Image' ){			//for onclick imagesTab 
	itemImages($sql_items);
	makeTabSelected('tabImages');
}//end of if ($_GET['field'] == 'Image' ){
else{		//	$_GET['field'] = Links or Video or Tip
	
	$tabID="";   //the tab link id 
	if( $_GET['field'] != "Tip" )		//for tip field no tab is selected
		$tabID="tab".$_GET['field'];
	
	if($_GET['field'] == 'Links'){
		$additionWhereStatement=" AND ( name='Links' OR name='Interactives' )";
	}
	else	
		$additionWhereStatement=" AND  name='".$_GET['field']."' ";
		
	//  this query fetches specific item's fields
	/*
	$queryReturnItemImages=mysql_query("SELECT c.text,e.name,e.id
   					 					FROM omeka_metatext c,omeka_types_metafields d, omeka_metafields e
   			     			 			WHERE c.item_id='".$result["id"]."' AND 
										d.type_id=".$result["type_id"]." AND 
										d.metafield_id=c.metafield_id AND 
										e.id=c.metafield_id");						  
									  
	*/
	//join with table omeka_items in order to use the title of the item in the where statement not the item_id
	$queryReturnItemFields=mysql_query("SELECT c.text,e.name,e.id
   					 					FROM omeka_metatext c INNER JOIN omeka_types_metafields d ON (d.metafield_id=c.metafield_id)
										INNER JOIN omeka_metafields e ON (e.id=c.metafield_id) 
										INNER JOIN omeka_items a ON ( c.item_id = a.id )
   		    	 			 			".$sql_items."  AND
										d.type_id=14 ".$additionWhereStatement);	
										 

	// Create the variables for the grade icons
	$iconM = '<img alt="" title="Medium" src="http://education.natural-europe.eu/natural_europe/themes/eknownetv3/images/bullet_medium.gif"/>';
	$iconE = '<img  alt="" title="Easy" src="http://education.natural-europe.eu/natural_europe/themes/eknownetv3/images/bullet_easy.gif"/>';
	$iconA = '<img alt="" title="Advanced"  src="http://education.natural-europe.eu/natural_europe/themes/eknownetv3/images/bullet_advanced.gif"/>';
	
	
	while($Fields= mysql_fetch_array($queryReturnItemFields) ){		
	//		REPLACE THE CARRIAGE RETURN CHARACTERS FROM THE TEXT BECAUSE JAVASCRIPT FAILS WITH ERROR 'unterminated string literal' 
		$oldChars=array(chr(13),chr(10));  // \r and \n
		$newChars=array('','');
		$text_temp = $Fields['text'];
		$item = str_replace("[M]", $iconM, $text_temp);
		$item = str_replace("[E]", $iconE, $item);
		$item = str_replace("[A]", $iconA, $item);
		
		// Add the external link icon
		$item = addExternalIcon($item);
		//$item = removeBlankPar($item);
		
		$text = str_replace($oldChars,$newChars,$item);
		//protect single quote (') with backslash (\) because javascript returns error
		$text = addslashes($text);
		//when nothing is returned from DB as Tip for the specified item then return	another field for the specified item e.g. Links , Video , Images  .  the first none empty returned
		if($text == "" && $_GET['field'] == 'Tip'){
			$queryReturnRestFields=mysql_query("SELECT c.text,e.name,e.id
   					 					FROM omeka_metatext c INNER JOIN omeka_types_metafields d ON (d.metafield_id=c.metafield_id)
										INNER JOIN omeka_metafields e ON (e.id=c.metafield_id) 
										INNER JOIN omeka_items a ON ( c.item_id = a.id )
   		    	 			 			".$sql_items."  AND
										d.type_id=14 ");
			$resourceFound=false;							
			while($restFields= mysql_fetch_array($queryReturnRestFields)  ){	
				if ($restFields['text'] != ""){
					$text_temp = $restFields['text'];
					$item_rest = str_replace("[M]", $iconM, $text_temp);
					$item_rest = str_replace("[E]", $iconE, $item_rest);
					$item_rest = str_replace("[A]", $iconA, $item_rest);
					
					
					// Add the external link icon
					$item_rest = addExternalIcon($item_rest);
					//$item_rest = removeBlankPar($item_rest);
					
					$text = str_replace($oldChars,$newChars,$item_rest);	
					$text = addslashes($text);
					
					$resourceFound=true;
					echo "obj.innerHTML += '".$text."';";
					$text="";
					if ( $restFields['name'] != "Interactives" )		//tab Interactives does not exist
						$tabID="tab".$restFields['name'];
					if ( $restFields['name'] != "Interactives" &&  $restFields['name'] != "Links")	//Links and Interactives field names always display together
						break;
				}//end of if
			}//end of while	
			if(!$resourceFound){   //if no resource is found then retrieve the item's images
				itemImages($_GET['item']);	
				$tabID="tabImages";				
			}
		}//end of 		if $text == "" && $_GET....
		elseif ($text == "" &&  $_GET['field'] != 'Tip')   		// echo a nothing found message
			$text="";		
		echo "obj.innerHTML += '".$text."';";
		$text="";
		//obj = document.getElementById('info_full')   						
	}//telos while	
	
	makeTabSelected($tabID);  //assign the selected class to the selected Tab						
}//end of else		

/*
info :	function that retrieves the images that belong to a specific item
arguements : the name of the item 
returns		: nth is returned , it produces javascript code which is executed after ajax call is completed
*/
function itemImages($sql_items){

// Global Variables set after browser detection		
	global $class;		
	global $style;
	
	$additionWhereStatement=" AND  name='Photo links'";
	

	$queryReturnRestFields=mysql_query("SELECT c.text,e.name,e.id
   					 					FROM omeka_metatext c INNER JOIN omeka_types_metafields d ON (d.metafield_id=c.metafield_id)
										INNER JOIN omeka_metafields e ON (e.id=c.metafield_id) 
										INNER JOIN omeka_items a ON ( c.item_id = a.id )
   		    	 			 			".$sql_items."  AND
										d.type_id=14 ".$additionWhereStatement);
	$resourceFound=false;							
	while($restFields= mysql_fetch_array($queryReturnRestFields)  ){	
		if ($restFields['text'] != ""){
			
			//$text = str_replace($oldChars,$newChars,$restFields['text']);
			
			$text_array = explode("src=",$restFields['text']);
			
			$count = count($text_array);
			
			for($i=1; $i<$count; $i++)
			{
				$text = $text_array[$i];
				$text = explode('"',$text);
				$url_text = $text[1];
				$text = $url_text;
				
				//foreach 
				
				$text = addslashes($text);
				
				$oldChars=array(chr(13),chr(10));  // \r and \n
				$newChars=array('','');
				
				$text = str_replace($oldChars,$newChars,$text);
				
				$resourceFound=true;
				
	
				//echo "obj.innerHTML += '<li><div class=\"dialog\"><div class=\"content\"><div class=\"t\"/>".$text."</div></div></div></li>';";
				//echo "obj.innerHTML += '".$text."';";
				//createthumb('http://www.eccentrix.com/members/chempics/Slike/Generalchemistry/2Water_structure.jpg','../thumbs/2Water_structure.jpg',48,48);
				//echo "obj.innerHTML += '<li><div class=\"dialog\"><div class=\"content\"><div class=\"t\"/><a><img class=\"corner iradius4\" src=\"http://education.natural-europe.eu/natural_europe/custom/phpThumb/phpThumb.php?src=http://www.eccentrix.com/members/chempics/Slike/Generalchemistry/2Water_structure.jpg&h=50\"></a></div></div></div></li>';";
				
				echo "liObj=document.createElement('li');
					  divObj1=document.createElement('div');
					  divObj2=document.createElement('div');
					  divObj3=document.createElement('div');
					  aObj=document.createElement('a');
					  imgObj=document.createElement('img');
					  divObj4=document.createElement('div');
					  divObj5=document.createElement('div');		  		  
					  divObj1.setAttribute('".$class."','dialog');		  
					  divObj2.setAttribute('".$class."','content');
					  divObj3.setAttribute('".$class."','t');
					  divObj4.setAttribute('".$class."','b');			  	  
					  divObj2.appendChild(divObj3); 
					  divObj4.appendChild(divObj5); 
					  aObj.setAttribute('href','".$text."');	   
					  aObj.setAttribute('".$class."','lightview');
					  aObj.setAttribute('title','From ".$text."');
					  imgObj.setAttribute('src','http://education.natural-europe.eu/natural_europe/custom/phpThumb/phpThumb.php?src=".$text ."&h=50');   
					  imgObj.setAttribute('width','48');
					  imgObj.setAttribute('height','48');
					  imgObj.setAttribute('title','From ".$text."');
					  imgObj.setAttribute('alt','');
					  imgObj.setAttribute('".$class."','corner iradius4');
					  aObj.appendChild(imgObj);
					  divObj2.appendChild(aObj);
					  divObj1.appendChild(divObj2);
					  divObj1.appendChild(divObj4);
					  liObj.appendChild(divObj1);		  
					  obj.appendChild(liObj);					
					 ";					//// obj = document.getElementById('videolinks')
			$text="";
			}
			
		}//end of if
	}//end of while	

	
	
	//  this query fetches images that belong to a specific item
	$queryReturnItemImages=mysql_query("SELECT a.*,b.archive_filename,b.original_filename, b.description, b.rights
  	 				 					FROM omeka_items a LEFT JOIN omeka_files b ON (b.item_id=a.id)
  	 		     			 			".$sql_items." AND a.type_id=14");
	
	/*  javascript with DOM method 'innerHTML'
	while($Images= mysql_fetch_array($queryReturnItemImages) ){
		 echo "obj.innerHTML += '<li><div class=\"dialog\"><div class=\"content\"><div class=\"t\"></div><a href=\"#\"><img 				src=\"images/".$Images['original_filename']."\" width=\"48\" height=\"48\" alt=\"\" class=\"corner iradius4\"></a></div><div class=\"b\">		<div></div></div></div></li>';";   //write javscript code to be executed in ajax execution mode
	}//telos while	
	*/
	/* javascript with DOM functions createElement() , setAttribute() , appendChild() */

	$isEmpty = true;		//if the query returns NO images

	while($Images = mysql_fetch_array($queryReturnItemImages)  ){		
		if(  !is_null($Images['archive_filename'])  )	{			//for records that are returned with   original_filename = NULL
			
			/* use the jpg version of images */
			$Images_jpg = explode('.',$Images['archive_filename'],2);
			
			if ($Images_jpg[1]=='gif') {
				$Images_jpg = $Images_jpg[0].".gif";
			}
			else
			{
				$Images_jpg = $Images_jpg[0].".jpg";
			}
			
			$oldChars=array(chr(13),chr(10));  // \r and \n
			$newChars=array('','');
			$rights = str_replace($oldChars,$newChars,$Images['rights']);	
			$rights = addslashes($rights);
			
			echo "liObj=document.createElement('li');
				  divObj1=document.createElement('div');
				  divObj2=document.createElement('div');
				  divObj3=document.createElement('div');
				  aObj=document.createElement('a');
				  imgObj=document.createElement('img');
				  divObj4=document.createElement('div');
				  divObj5=document.createElement('div');		  		  
				  divObj1.setAttribute('".$class."','dialog');		  
				  divObj2.setAttribute('".$class."','content');
				  divObj3.setAttribute('".$class."','t');
				  divObj4.setAttribute('".$class."','b');			  	  
		    	  divObj2.appendChild(divObj3); 
				  divObj4.appendChild(divObj5); 
				  aObj.setAttribute('href','http://education.natural-europe.eu/natural_europe/archive/fullsize/".$Images_jpg."');	   
				  aObj.setAttribute('".$class."','lightview');
				  aObj.setAttribute('title','".$Images['description']." :: ".$rights."');
				  imgObj.setAttribute('src','http://education.natural-europe.eu/natural_europe/archive/files/".$Images['archive_filename']."');
				  imgObj.setAttribute('width','48');
				  imgObj.setAttribute('height','48');
				  imgObj.setAttribute('alt','');
				  imgObj.setAttribute('".$class."','corner iradius4');
				  aObj.appendChild(imgObj);
				  divObj2.appendChild(aObj);
				  divObj1.appendChild(divObj2);
				  divObj1.appendChild(divObj4);
				  liObj.appendChild(divObj1);		  
				  obj.appendChild(liObj);					
				 ";					//// obj = document.getElementById('videolinks')
				  
				 $isEmpty = false;		// the query return at least on record
		}//telos if
	}//telos while
	
	
	
	if ($isEmpty)
		echo "obj.innerHTML += '';";	
	 

	/******************************************	
	the HTML code that we want to produce

	<li><div class="dialog">

 	<div class="content">

  	<div class="t"></div>

	<a href="#"><img src="images/videolink_01.jpg" width="48" height="48" alt="" class="corner iradius4"></a>

 	</div>

 	<div class="b"><div></div></div>

	</div></li>
	********************************************/	
}

/*
info : assignes the li of the tab link with the class selected after it has initialized all the tabs with no class
arguements : the id of the tab link that the selected class wiil be assigned to
returns		: nth is returned , it produces javascript code which is executed after ajax call is completed
*/	
function makeTabSelected($tabID){
	global $class;		// variable set after browser detection
	//	parentNode for the li tag which contains the a tag
	//initialize the tab classes
	echo "
		document.getElementById('tabImages').parentNode.setAttribute('".$class."','');		
		document.getElementById('tabVideo').parentNode.setAttribute('".$class."','');
		document.getElementById('tabLinks').parentNode.setAttribute('".$class."','');
		document.getElementById('tabGames/Activities').parentNode.setAttribute('".$class."','');
		";
		
	if($tabID!=""){   
		//assign the tab with the selected class	
		echo "document.getElementById('".$tabID."').parentNode.setAttribute('".$class."','selected');";
	}	
}

function addExternalIcon($text){
	//Check if the resource is external link
	$external_link = ' style="background:transparent url(http://education.natural-europe.eu/natural_europe/themes/eknownetv3/images/external.png) no-repeat scroll right center; padding:0 13px;"';
	
	// Check if the text include the server name
	$findme_eknow='eknownetv3/movies/'; 
	
	
	// split the text object to paragraphs
	$new_text = explode("</p>",$text);
	
	foreach ($new_text as $value)
	{
		$pos_eknow = stripos($value,$findme_eknow);
		if (!$pos_eknow)
		{
			$value = str_replace("<a", "<a ".$external_link, $value);
			//$newtext = explode("href=",$item_rest);
			//$newtext[0] = $newtext[0]."href=".$external_link;
			//$item_rest = $newtext[1];
		}
		$textaAdd .= $value;
	} 
	$text = $textaAdd;
	return $text;
}

function removeBlankPar($text)
{
	$findme = 'href';
	// split the text object to paragraphs
	$new_text = explode("</p>",$text);
	
	foreach ($new_text as $value)
	{
		$pos_eknow = stripos($value,$findme);
		if (!$pos_eknow)
		{
			$value = str_replace("<p", "<b", $value);
			$value = str_replace("</p", "</b", $value);
		}
		$textaAdd .= $value;
	} 
	$text = $textaAdd;
	return $text;
}				
?>