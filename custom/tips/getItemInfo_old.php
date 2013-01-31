<?
include('dbConn.php');


/*	DETECT BROWSER FOR  method setAttribute in javascrit for attribute class	*/
$browser = strtolower($_SERVER['HTTP_USER_AGENT']); // what browser they use.

if(ereg("msie", $browser)) {
$class="className";
} else {
$class="class";
}
/************END OF DETECTION******************/


if ($_GET['field'] == 'Image' ){			//for onclick imagesTab 
	itemImages($_GET['item']);
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
   		    	 			 			WHERE a.title='".$_GET['item']."'  AND
										d.type_id=14 ".$additionWhereStatement);	
										 

	while($Fields= mysql_fetch_array($queryReturnItemFields) ){		
	//		REPLACE THE CARRIAGE RETURN CHARACTERS FROM THE TEXT BECAUSE JAVASCRIPT FAILS WITH ERROR 'unterminated string literal' 
		$oldChars=array(chr(13),chr(10));  // \r and \n
		$newChars=array('','');
		$text = str_replace($oldChars,$newChars,$Fields['text']);
	//		protect single quote (') with backslash (\) because javascript returns error
		$text = addslashes($text);
	//	when nothing is returned from DB as Tip for the specified item then return	another field for the specified item e.g. Links , Video , Images  .  the first none empty returned
		if($text == "" && $_GET['field'] == 'Tip'){
			$queryReturnRestFields=mysql_query("SELECT c.text,e.name,e.id
   					 					FROM omeka_metatext c INNER JOIN omeka_types_metafields d ON (d.metafield_id=c.metafield_id)
										INNER JOIN omeka_metafields e ON (e.id=c.metafield_id) 
										INNER JOIN omeka_items a ON ( c.item_id = a.id )
   		    	 			 			WHERE a.title='".$_GET['item']."'  AND
										d.type_id=14 ");
			$resourceFound=false;							
			while($restFields= mysql_fetch_array($queryReturnRestFields)  ){	
				if ($restFields['text'] != ""){
					$text = str_replace($oldChars,$newChars,$restFields['text']);	
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
function itemImages($item){

// Global Variables set after browser detection		
	global $class;		
	global $style;
	
	//  this query fetches images that belong to a specific item
	$queryReturnItemImages=mysql_query("SELECT a.*,b.archive_filename,b.original_filename
  	 				 					FROM omeka_items a LEFT JOIN omeka_files b ON (b.item_id=a.id)
  	 		     			 			WHERE a.title='".$item."' AND a.type_id=14");
	
	
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
		";
		
	if($tabID!=""){   
		//assign the tab with the selected class	
		echo "document.getElementById('".$tabID."').parentNode.setAttribute('".$class."','selected');";
	}	
}					
?>