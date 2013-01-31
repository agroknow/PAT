<?php head(array('title'=>'Browse Items','content_class' => 'horizontal-nav', 'bodyclass'=>'items primary browse-items')); ?>
<h1><?php echo __('Ingest a Resource from Ariadne federation'); ?></h1>
<?php if (has_permission('Items', 'add')): ?>

<?php
	
function onlyNumbers($string){
    //This function removes all characters other than numbers
    $string = preg_replace("/[^0-9]/", "", $string);
    return (int) $string;
} 

    $exhibit_id=onlyNumbers($_GET['ex_id']);
	$sec_id=onlyNumbers($_GET['sec_id']);
	$pg_id=onlyNumbers($_GET['pg_id']);	

?>
<div style="text-align:center; width:850px;">
<form action="#" method="post" style="text-align:center;">
<div style="text-align:center;">
<img src="<?php echo uri('themes/default/items/images/ariadne_logo.png'); ?>"><br>
<?php echo __('Search in Ariadne'); ?>:
</div>
<div style="text-align:center;">
<input type="text" name="europeanatext"> 
<input type="submit" class="button" value="<?php echo __('Search'); ?>" style="float:none;">
</div>
</form>

<style>
a {
color:black;
text-decoration:none;
}
#active{
background-color:#cc6600;
color:#ffffff;
}
</style>

<?php


// Get SimpleXMLElement object from an XML document
//$xml = simplexml_load_file("http://api.europeana.eu/api/opensearch.rss?searchTerms=bible&startPage=1&wskey=IIRTOOIRNG");
 
// Get XML string from a SimpleXML element
// When you select "View source" in the browser window, you will see the objects and elements
//echo $xml->asXML();
if(isset($_POST['europeanatext'])){$europeanatext= $_POST['europeanatext'];
$_POST['europeanatext']=str_replace(' ','+', $_POST['europeanatext']);
if(isset($_POST['startPage'])){$startPage= $_POST['startPage']; $startPageurl= $_POST['startPage']*12-11;} else{$startPageurl=1; $startPage=1;}
//if(isset($_POST['bytype'])){$europenana_type= "+europeana_type:*".$_POST['bytype']."*";} else{$europenana_type="";}
//echo 'http://ariadne.cs.kuleuven.be/ariadne-partners/api/sqitarget?query='.$europeanatext.'&start='.$startPageurl.'&size=12&lang=plql1&format=lom';
?>

<?php 
libxml_use_internal_errors(false);
$xml = @simplexml_load_file('http://ariadne.cs.kuleuven.be/ariadne-partners/api/sqitarget?query="'.$europeanatext.'"&start='.$startPageurl.'&size=12&lang=plql1&format=lom', NULL, LIBXML_NOERROR | LIBXML_NOWARNING);
if($xml === false){ echo "An Error occured. Please try again later. Thank you!";}
//$xml = simplexml_load_file('http://ariadne.cs.kuleuven.be/ariadne-partners/api/sqitarget?query=learning&start='.$startPage.'&size=12&lang=plql1&format=lom', NULL, LIBXML_NOERROR | LIBXML_NOWARNING);
if($xml){
$xml->getName() . "<br />";

//print_r($xml);

//echo $xml->getName();
//echo $xml['cardinality']."123123";

  echo "<div style='width:850px; border-top:1px solid; border-bottom:1px solid; margin-top:10px;'>";
	 print  "".__('You search').": ". $_POST['europeanatext']."<br />";
	//  print  "Page you are: ". $startPage."<br />";
  print "".__('Total results')." : ".$xml['cardinality']; 
 // print "<br />startIndex : ".$opensearch->startIndex;
  $pages=$xml['cardinality']/12;
  $pages2=round($pages); 
  if($pages2>$pages){$pages=$pages2;}else{$pages=$pages2+1;}
  if($pages>0){ 

  //print $opensearch->itemsPerPage;

	 //print  "Total results: ". $childgeneral->opensearch->totalResults."<br />";
	 echo "</div>";
	 
	     $i=1; ?>
  <script>
  function GoPage(iPage) {
  
    document.form2.startPage.value = iPage;
	document.form2.submit();
}

  </script>
  <form action="#" method="post" name="form2"  class="pagination" style="float:none; margin-top:10px; width:540px;">
  <input type="hidden" name="europeanatext" value="<?php echo $_POST['europeanatext']; ?>">
  <input type="hidden" name="startPage" value="<?php echo $_GET['start']; ?>">
  
   <?php 
  if($pages<10){
  while($i<$pages){echo "<a href='javascript:GoPage(".$i.")'   ";
  	if($i==$startPage){echo "id='active'";}
  	echo " >".$i."</a> ";  $i+=1;}
  
  } 
  else{
  
   if($startPage<8){ 
   while($i<$pages and $i<11){  echo "<a href='javascript:GoPage(".$i.")'   ";
  	if($i==$startPage){echo "id='active'";}
  	echo " >".$i."</a> ";  $i+=1;}
  echo ("...");
  echo "<a href='javascript:GoPage(".$pages.")'   ";
  	if($i==$startPage){echo "id='active'";}
  	echo " >".$pages."</a> ";
  }
  elseif($startPage<($pages-8)){
  echo "<a href='javascript:GoPage(1)'   ";
  	if($i==$startPage){echo "id='active'";}
  	echo " >1</a> ";
  echo ("...");
  $i=$startPage-5;
  $x=$startPage+5;
  while($i<$x){  echo "<a href='javascript:GoPage(".$i.")'   ";
  	if($i==$startPage){echo "id='active'";}
  	echo " >".$i."</a> ";  $i+=1;}
  echo ("...");
  echo "<a href='javascript:GoPage(".$pages.")'   ";
  	if($i==$startPage){echo "id='active'";}
  	echo " >".$pages."</a> ";
  }//elseif
  
  elseif($startPage>($pages-8)){
  echo "<a href='javascript:GoPage(1)'   ";
  	if($i==$startPage){echo "id='active'";}
  	echo " >1</a> ";
  echo ("...");
  $i=$pages-10;
   while($i<$pages+1){  echo "<a href='javascript:GoPage(".$i.")'   ";
  	if($i==$startPage){echo "id='active'";}
  	echo " >".$i."</a> ";  $i+=1;}
  }//elseif
  
  
  
  }//else kenriko
?>
  </form>
     <div style="float:left; text-align:center; margin-top:20px;">
<?php echo ingest_search_total_block(''.$europeanatext.'',3); ?>
</div> 
<div style="float:left; width:670px; margin-left:25px;margin-top:20px;">
  
<?php
		
	foreach($xml->children() as $child1){
  
//  echo $child1->getName() . ": " . $child1 . "<br />";
  
 		  $childgeneral = $child1->children();
 
		  $cb=0;

 				 foreach($child1->children() as $child2){
 				 	
 				 	$cb+=1;
 					 $child3=$child2->children();
					 
					 //print_r($child1);

					 $child = $child3->children();
					 $name=$child2->getName();
					 $name2=$child3->getName();
					 		
							 
							 
						
								if($name=='technical'){
								///echo $child2->format."123";
								
										$format=$child2->format;
										
										if($child2->format=='text/html'){
										$preview='<img src="http://open.thumbshots.org/image.aspx?url='.$child2->location.'"/>';
										$identifier=$child2->location;
										}
										elseif($child2->format=='application/pdf'){
										$uri=WEB_ROOT;
										$preview='<img src="'.$uri.'/application/views/scripts/images/files-icons/pdf.png"/>';
										$identifier=$child2->location;
										}
										elseif(stripos($child2->location,".pdf")>0){
										$uri=WEB_ROOT;
										$preview='<img src="'.$uri.'/application/views/scripts/images/files-icons/pdf.png"/>';
										$identifier=$child2->location;
										}
										elseif($child2->format=='application/msword'){
										$uri=WEB_ROOT;
										$preview='<img src="'.$uri.'/application/views/scripts/images/files-icons/word.png"/>';
										$identifier=$child2->location;
										}
										elseif($child2->format=='video/x-ms-wmv'){
										$uri=WEB_ROOT;
										$preview='<img src="'.$uri.'/application/views/scripts/images/files-icons/video.png"/>';
										$identifier=$child2->location;
										}
										elseif($child2->format=='application/vnd.ms-powerpoint'){
										$uri=WEB_ROOT;
										$preview='<img src="'.$uri.'/application/views/scripts/images/files-icons/powerpoint.png"/>';
										$identifier=$child2->location;
										}
										else{
										$preview='<img src="http://open.thumbshots.org/image.aspx?url='.$child2->location.'"/>';
										$identifier=$child2->location;
										}
			
								}						
						
						
						
						
						
								 if($name=='general'){
									 
											 foreach($child2->children() as $getgeneral){
													 //print_r($getgeneral);
													 $getgeneralname=$getgeneral->getName();
								
													if($getgeneralname=='title'){ 
														foreach($getgeneral as $string){ 
									 						 if($string['language']=='en'){
																	$title= $string;
																  }else{$title2= $string;}
														 }
														 if(strlen($title)>2){$title=$title;}else{$title=$title2;}
													} //if($getgeneralname=='title'){ 
													
													if($getgeneralname=='description'){ 
														foreach($getgeneral as $string){ 
									 						 if($string['language']=='en'){
																	$description= $string;
																  }
														 }
													} //if($getgeneralname=='title'){ 
									 
									 			} // foreach($child2->children() as $getgeneral){
								}//if name-general
								
							
								
							  
 		 		  		
 				 } //foreach ($child1->children() as $child2)
	
	
	$user = current_user();
	$title = preg_replace('/(["\'])/ie', '',  $title);
	$description = preg_replace('/(["\'])/ie', '',  $description);
	$format = preg_replace('/(["\'])/ie', '',  $format);
	$identifier = preg_replace('/(["\'])/ie', '',  $identifier);
	
	$params=array('title'=>$title,
			  'description'=>$description,
			  'source'=>'Ariadne',
			  'format'=>$format,
			  'identifier'=>$identifier,
			  'user'=>$user['entity_id']);

	
	echo "<div style='width:805px; margin-top:10px;clear:both;'>";			 
	echo '<div style="float:left; width:130px;">'; 
	echo $preview;
	echo '</div>';	
	echo '<div style="float:left;width:605px;">'; 
	echo "<strong>".$title."</strong><br>";
	echo $description."<br>";
	if($identifier){ echo '<br><a href="'.$identifier.'" target="_blank">'.__('Access to the resource').'</a>'; }

	//echo '<br><div style='position:relative; top:2px;height:40px;"><a style="position:relative; top:10px;background-color: #F4F3EB;
    //color: #CC5500;
    //padding-bottom: 10px;
    //padding-right: 10px;
	//padding-left: 10px;
    //padding-top: 10px;" href="'.uri("items/addinjestitem",$params).'">Add it to my Repository</a>';
	//echo '</div>';

		
	echo '<form method="post" name="'.$cb.'" action="'.uri("items/addinjestitem").'">';

echo '<input type="hidden" name="title" value="'.$title.'">';
echo '<input type="hidden" name="description" value="'.$description.'">';
echo '<input type="hidden" name="source" value="Ariadne">';
echo '<input type="hidden" name="format" value="'.$format.'">';
echo '<input type="hidden" name="identifier" value="'.$identifier.'">';
echo '<input type="hidden" name="user" value="'.$user['entity_id'].'">';
	
	
	echo "<br><div style='position:relative; top:2px;height:40px;'>
<input id='newsubmit' type='submit' value='".__('Add it to my Repository')."' name='insert' 
style='background-color:#F4F3EB;color: #CC5500; background-image:none; border:none; float:left; font-weight:normal;text-shadow:none;'>";
echo '</div>';
echo '</form>';
	
	echo '</div>';			 
	echo "</div>";
	echo '<br style="clear:both;">';
	
	} //foreach($xml->children() as $child1){

 ?>
    <script>
                    function GoPage2(iPage) {
                                                                  
                        document.form3.startPage.value = iPage;
                        document.form3.submit();
                    }

                </script>
    <form action="#" method="post" name="form3"  class="pagination" style="float:none; margin-top:10px; width:540px;">
  <input type="hidden" name="europeanatext" value="<?php echo $_POST['europeanatext']; ?>">
  <input type="hidden" name="startPage" value="<?php echo $_GET['start']; ?>">
  
   <?php 
   $i=1;
  if($pages<10){
  while($i<$pages){echo "<a href='javascript:GoPage2(".$i.")'   ";
  	if($i==$startPage){echo "id='active'";}
  	echo " >".$i."</a> ";  $i+=1;}
  
  } 
  else{
  
   if($startPage<8){ 
   while($i<$pages and $i<11){  echo "<a href='javascript:GoPage2(".$i.")'   ";
  	if($i==$startPage){echo "id='active'";}
  	echo " >".$i."</a> ";  $i+=1;}
  echo ("...");
  echo "<a href='javascript:GoPage2(".$pages.")'   ";
  	if($i==$startPage){echo "id='active'";}
  	echo " >".$pages."</a> ";
  }
  elseif($startPage<($pages-8)){
  echo "<a href='javascript:GoPage2(1)'   ";
  	if($i==$startPage){echo "id='active'";}
  	echo " >1</a> ";
  echo ("...");
  $i=$startPage-5;
  $x=$startPage+5;
  while($i<$x){  echo "<a href='javascript:GoPage2(".$i.")'   ";
  	if($i==$startPage){echo "id='active'";}
  	echo " >".$i."</a> ";  $i+=1;}
  echo ("...");
  echo "<a href='javascript:GoPage2(".$pages.")'   ";
  	if($i==$startPage){echo "id='active'";}
  	echo " >".$pages."</a> ";
  }//elseif
  
  elseif($startPage>($pages-8)){
  echo "<a href='javascript:GoPage2(1)'   ";
  	if($i==$startPage){echo "id='active'";}
  	echo " >1</a> ";
  echo ("...");
  $i=$pages-10;
   while($i<$pages+1){  echo "<a href='javascript:GoPage2(".$i.")'   ";
  	if($i==$startPage){echo "id='active'";}
  	echo " >".$i."</a> ";  $i+=1;}
  }//elseif
  
  
  
  }//else kenriko
?>
  </form>
    <?php
        
}//if isset xml
}//is iiset europeana text


}//if >0 page
?>
</div>
<?php 
endif; //permission to add item
?>
</div>

</div>