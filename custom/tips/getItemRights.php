<?php
include('dbConn.php');

$queryReturnRestFields=mysql_query("SELECT rights FROM `omeka_files` 
									WHERE archive_filename='".$_GET["item"]."'");
									
while($restFields= mysql_fetch_array($queryReturnRestFields)  ){	
				if ($restFields['rights'] != ""){
					$text = $restFields['rights'];
				
					$oldChars=array(chr(13),chr(10));  // \r and \n
					$newChars=array('','');
					$text = str_replace($oldChars,$newChars,$text);
					$text = addslashes($text);
					echo "obj.innerHTML += '".$text."';";	
				}//end of if
			}//end of while	

	
?>