<?php head(array('title'=>'Browse Items','content_class' => 'horizontal-nav', 'bodyclass'=>'items primary browse-items')); ?>
<h1>Art plus:europeana with youtube</h1>
<?php if (has_permission('Items', 'add')): ?>

<?php
	
function onlyNumbers($string){
    //This function removes all characters other than numbers
    $string = preg_replace("/[^0-9]/", "", $string);
    return (int) $string;
} 

if(isset($_POST['insert'])){ //if click add to pathway

}else{//if click add to pathway
?>

<div style="text-align:center; width:800px;">
<form action="#" method="post" style="text-align:center;">

<div style="text-align:center;">
<img src="<?php echo uri('themes/default/items/images/minihacathon.png'); ?>"><br>
Search in Europeana:
</div>
<div style="text-align:center;">
<input type="text" name="europeanatext"> 
<input type="submit" class="button" value="Search" style="float:none;">
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
if(isset($_POST['startPage'])){$startPage= $_POST['startPage'];} else{$startPage=1;}
if(isset($_POST['bytype'])){$europenana_type= "+europeana_type:*".$_POST['bytype']."*";} else{$europenana_type="";}

//print_r($_POST);break;
$europeanatext  = str_replace(" ","+",$europeanatext);
//echo 'http://api.europeana.eu/api/opensearch.rss?searchTerms='.$europeanatext.'+europeana_type:*IMAGE*+creator:*'.$europeanatext.'*&startPage='.$startPage.'&wskey=IIRTOOIRNG';
?>
<div><em><strong>Filter results by type: </strong></em><br> 
  <script>
  function GoType(type){
  document.form4.bytype.value=''+type+'';
  document.form4.submit();}
  </script>
  <form action="#" method="post" name="form4">
  <input type="hidden" name="europeanatext" value="<?php echo $_POST['europeanatext']; ?>">
  <input type="hidden" name="startPage" value="1">
  <?php if(isset($_POST['bytype'])){$bytype=$_POST['bytype'];}else{$bytype='';} ?>
  <input type="hidden" name="bytype" value="<?php echo $bytype; ?>">
  


</div> 

</form>
</div>
<?php 
libxml_use_internal_errors(false);
$xml = simplexml_load_file('http://api.europeana.eu/api/opensearch.rss?searchTerms='.$europeanatext.'+europeana_type:*IMAGE*+creator:*'.$europeanatext.'*&startPage='.$startPage.'&wskey=IIRTOOIRNG', NULL, LIBXML_NOERROR | LIBXML_NOWARNING);
$linkeuropeana='http://api.europeana.eu/api/opensearch.rss?searchTerms='.$europeanatext.'+europeana_type:*IMAGE*+creator:*'.$europeanatext.'*&startPage='.$startPage.'&wskey=IIRTOOIRNG';


///////////////////////youtube////////////
// generate feed URL
     // $feedURL = "http://gdata.youtube.com/feeds/api/videos?vq={$vq}&orderby={$s}&max-results={$i}&start-index={$o}";
      
      $output  = str_replace("+","/",$europeanatext);
     // echo $output.'<br>';
      $youtubetext='art/paintings/'.$output;
     // echo $youtubetext;
     $feedURL = "http://gdata.youtube.com/feeds/api/videos/-/".$youtubetext."?orderby=viewCount&max-results=25";
      // read feed into SimpleXML object
      $sxmlyou = simplexml_load_file($feedURL, NULL, LIBXML_NOERROR | LIBXML_NOWARNING);
      
      // get summary counts from opensearch: namespace
     // print_r($sxmlyou);
      $counts = $sxmlyou->children('http://a9.com/-/spec/opensearchrss/1.0/');
      $total = $counts->totalResults; 
      $startOffset = $counts->startIndex; 
      $endOffset = ($startOffset-1) + $counts->itemsPerPage;

////////////////


if($xml){
$xml->getName() ."<br />";


foreach($xml->children() as $child1)
  {
  
  $childgeneral = $child1->children();
  echo "<div style='width:650px; border-top:1px solid; border-bottom:1px solid; margin-top:10px;'>";
	 print  "You search: ". $childgeneral->description."<br />";
//Use that namespace
$opensearch = $child1->children('http://a9.com/-/spec/opensearch/1.1/');
 // print "Total results : ".$opensearch->totalResults; 
 // print "<br />startIndex : ".$opensearch->startIndex;
  $pages=$opensearch->totalResults/12;
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
  function submitform(formname) {
	  
	
		document.formname.submit();
	}

  </script>

  
  <form action="#" method="post" name="form2" class="pagination" style="float:none; margin-top:10px; width:540px;">
  <input type="hidden" name="europeanatext" value="<?php echo $_POST['europeanatext']; ?>">
  <input type="hidden" name="startPage" value="<?php echo $_GET['startPage']; ?>">
  <?php if(isset($_POST['bytype'])){?> <input type="hidden" name="bytype" value="<?php echo $_POST['bytype']; ?>"> <?php } ?>

  <?php 
  if($pages<10){
  while($i<$pages){
  	
  	echo "<a href='javascript:GoPage(".$i.")' ";
  	if($i==$startPage){echo "id='active'";}
  	echo " >".$i."</a> ";  $i+=1;}
  
  } 
  else{
  
   if($startPage<8){ 
   while($i<$pages and $i<11){  
   	
   echo "<a href='javascript:GoPage(".$i.")' ";
  	if($i==$startPage){echo "id='active'";}
  	echo " >".$i."</a> ";  $i+=1;}
   	
  echo ("...");
  echo "<a href='javascript:GoPage(".$pages.")' ";
  	if($i==$startPage){echo "id='active'";}
  	echo "  >".$pages."</a> ";
  }
  elseif($startPage<($pages-8)){
  echo "<a href='javascript:GoPage(1)'  ";
  	if($i==$startPage){echo "id='active'";}
  	echo " >1</a> ";
  echo ("...");
  $i=$startPage-5;
  $x=$startPage+5;
  while($i<$x){  echo "<a href='javascript:GoPage(".$i.")'  ";
  	if($i==$startPage){echo "id='active'";}
  	echo " >".$i."</a> ";  $i+=1;}
  echo ("...");
  echo "<a href='javascript:GoPage(".$pages.")'  ";
  	if($i==$startPage){echo "id='active'";}
  	echo " >".$pages."</a> ";
  }//elseif
  
  elseif($startPage>($pages-8)){
  echo "<a href='javascript:GoPage(1)'  ";
  	if($i==$startPage){echo "id='active'";}
  	echo " >1</a> ";
  echo ("...");
  $i=$pages-10;
   while($i<$pages+1){  echo "<a href='javascript:GoPage(".$i.")'  ";
  	if($i==$startPage){echo "id='active'";}
  	echo " >".$i."</a> ";  $i+=1;}
  }//elseif
  
  
  
  }//else kenriko
  ?>
  </form>
    <div style="float:left; text-align:center; margin-top:40px;">
  <script>
  function GoPage(iPage) {
  
    document.form2.startPage.value = iPage;
	document.form2.submit();
}
  function submitform(formname) {
	  
		
		document.formeuropeana.submit();
	}
function submitform2(formname) {
	  
		
		document.formyoutube.submit();
	}

  </script>

  <form action="minihacathon" method="post" name="formeuropeana" style=" float:left; margin-top:10px; ">
  <input type="hidden" name="europeanatext" value="<?php echo $_POST['europeanatext']; ?>">
  <input type="hidden" name="startPage" value="1">
<input type="hidden" name="europeanatext" value="<?php echo $_POST['europeanatext']; ?>">
<a href="#" onclick="submitform('IMAGE');"> Europeana (<?php echo $opensearch->totalResults; ?>)</a><br>
</form>
<br>
  <form action="youtube" method="post" name="formyoutube" style=" float:left; margin-top:10px; ">
  <input type="hidden" name="europeanatext" value="<?php echo $_POST['europeanatext']; ?>">
  <input type="hidden" name="startPage" value="1">
<input type="hidden" name="europeanatext" value="<?php echo $_POST['europeanatext']; ?>">
<a href="#" onclick="submitform2('TEXT');">Youtube (<?php echo $total; ?>)  </a>

</form>
</div> 
<div style="float:left; width:670px; margin-left:25px;margin-top:20px;">
  
  <?php 
  
  ///////////////////////////youtube items///////////////////////////////
  foreach ($sxmlyou->entry as $entry) {
        // get nodes in media: namespace for media information
        $media = $entry->children('http://search.yahoo.com/mrss/');
        
        // get video player URL
        $attrs = $media->group->player->attributes();
        $watch = $attrs['url']; 
        
        // get video thumbnail
        $attrs = $media->group->thumbnail[0]->attributes();
        $thumbnail = $attrs['url']; 
        
        // get <yt:duration> node for video length
        $yt = $media->children('http://gdata.youtube.com/schemas/2007');
        $attrs = $yt->duration->attributes();
        $length = $attrs['seconds']; 
        
        // get <gd:rating> node for video ratings
        $gd = $entry->children('http://schemas.google.com/g/2005'); 
        if ($gd->rating) {
          $attrs = $gd->rating->attributes();
          $rating = $attrs['average']; 
        } else {
          $rating = 0; 
        }

        // print record 
        echo "<div><br>";
        echo "<tr><td colspan=\"2\" class=\"line\"></td>
        </tr>\n";
        echo "<tr>\n";
        echo "<td><a href=\"{$watch}\"><img src=\"$thumbnail\" style='width:100px;'/></a></td>\n";
        echo "<td><a href=\"{$watch}\">
        {$media->group->title}</a><br/>\n";
        //echo sprintf("%0.2f", $length/60) . " min. | {$rating} user 
        //rating<br/>\n";
        //echo $media->group->description . "</td>\n";
        echo "</tr>\n";
        echo "</div>";
      }
    
  
  
  
  
  ///////////////////////////////////////////end youtube///////////////

 	 echo "</div>";
  } 
     }//if isset xml
}//is iiset europeana text



}//if click add to pathway

}//if >0 page
?>
</div>
<?php 
endif; //permission to add item
?>
</div>

</div>