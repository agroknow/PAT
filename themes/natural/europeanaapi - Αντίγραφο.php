<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>
<body style=" margin-top: 0px; margin-bottom: 0px; margin-left: 0px; margin-right: 0px;">
<?php
		require_once 'Omeka/Core.php';
$core = new Omeka_Core;

try {
    $db = $core->getDb();
	$db->query("SET NAMES 'utf8'");
   
    //Force the Zend_Db to make the connection and catch connection errors
    try {
        $mysqli = $db->getConnection()->getConnection();
    } catch (Exception $e) {
        throw new Exception("<h1>MySQL connection error: [" . mysqli_connect_errno() . "]</h1>" . "<p>" . $e->getMessage() . '</p>');
    }
} catch (Exception $e) {
	die($e->getMessage() . '<p>Please refer to <a href="http://omeka.org/codex/">Omeka documentation</a> for help.</p>');
}
function onlyNumbers($string){
    //This function removes all characters other than numbers
    $string = preg_replace("/[^0-9]/", "", $string);
    return (int) $string;
} 

    $exhibit_id=onlyNumbers($_GET['ex_id']);
	$sec_id=onlyNumbers($_GET['sec_id']);
	$pg_id=onlyNumbers($_GET['pg_id']);	

if(isset($_POST['insert'])){ //if click add to pathway
echo $_POST['title'];
echo $_POST['uri'];
$_POST['title']=addslashes($_POST['title']);
$sql2="insert into omeka_teasers (sec_id,exhibit_id,pg_id,europeana_title,europeana_uri,type) values (".$_POST['sec_id'].",".$_POST['ex_id'].",".$_POST['pg_id'].",'".$_POST['title']."','".$_POST['uri']."','europeana')";
$exec2=$db->query($sql2); 
$_POST['title']=stripslashes($_POST['title']);

$sql2="SELECT LAST_INSERT_ID() AS LAST_ID FROM omeka_teasers";
$exec3=$db->query($sql2); 
$data3=$exec3->fetch();
?>
<script language=JavaScript>
						  window.close();
					   window.opener.document.getElementById('text_supporting_europeana').innerHTML += "<?php echo "<div style='padding-top:6px;'><a href='javascript:deleteeuropeanaObject(".$data3['LAST_ID'].")' class='delete'><span class='section-delete'>&nbsp;</span></a><a style='padding-left:10px;' target='_new' href='".$_POST['uri']."'>".$_POST['title']."</a></div>"; ?>";
						  </script>
<?php
}else{//if click add to pathway
?>

<div style="text-align:center; width:600px;">
<form action="#" method="post" name="form1">
Search in Europeana:<br/>
<input type="text" name="europeanatext">
<input type="submit" value="search" name="search">

</form>
<style>
a {
color:black;
text-decoration:none;
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
echo 'http://api.europeana.eu/api/opensearch.rss?searchTerms=text:"'.$europeanatext.'"&&startPage='.$startPage.'&wskey=IIRTOOIRNG';
?>
<div>Filter results by type: 
<select name="bytype">
<option value="image">IMAGE</option>
<option value="IMAGE">IMAGE</option>
<option value="TEXT">TEXT</option>
<option value="VIDEO">VIDEO</option>
<option value="SOUND">SOUND</option>
</select>
</div>
<?php 
$xml = simplexml_load_file('http://api.europeana.eu/api/opensearch.rss?searchTerms=text:"'.$europeanatext.'"&&startPage='.$startPage.'&wskey=IIRTOOIRNG');

$xml->getName() . "<br />";
echo "1";
foreach($xml->children() as $child1)
  {
  
  $childgeneral = $child1->children();
  echo "<div style='width:600px; border:1px solid; margin-top:10px;'>";
	 print  "You search: ". $childgeneral->description."<br />";
//Use that namespace
$opensearch = $child1->children('http://a9.com/-/spec/opensearch/1.1/');
  print "Total results : ".$opensearch->totalResults; 
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

  </script>
  <form action="#" method="post" name="form2">
  <input type="hidden" name="europeanatext" value="<?php echo $_POST['europeanatext']; ?>">
  <input type="hidden" name="startPage" value="<?php echo $_GET['startPage']; ?>">

  <?php 
  if($pages<10){
  while($i<$pages){echo "<a href='javascript:GoPage(".$i.")' >".$i."</a> ";  $i+=1;}
  
  } 
  else{
  
   if($startPage<8){ 
   while($i<$pages and $i<11){  echo "<a href='javascript:GoPage(".$i.")' >".$i."</a> ";  $i+=1;}
  echo ("...");
  echo "<a href='javascript:GoPage(".$pages.")' >".$pages."</a> ";
  }
  elseif($startPage<($pages-8)){
  echo "<a href='javascript:GoPage(1)' >1</a> ";
  echo ("...");
  $i=$startPage-5;
  $x=$startPage+5;
  while($i<$x){  echo "<a href='javascript:GoPage(".$i.")' >".$i."</a> ";  $i+=1;}
  echo ("...");
  echo "<a href='javascript:GoPage(".$pages.")' >".$pages."</a> ";
  }//elseif
  
  elseif($startPage>($pages-8)){
  echo "<a href='javascript:GoPage(1)' >1</a> ";
  echo ("...");
  $i=$pages-10;
   while($i<$pages){  echo "<a href='javascript:GoPage(".$i.")' >".$i."</a> ";  $i+=1;}
  }//elseif
  
  
  
  }//else kenriko
  ?>
  </form>
  <?php 
  $cb=0;
 	 foreach($child1->children() as $child2)
 	 {
  $cb+=1;

	
	 
	  		 $child = $child2->children();
		 $name=$child2->getName();
		
		 if($name=='item'){
          echo "<div style='width:500px; border:1px solid; margin-top:10px;'>";
		  
		 $link1= str_replace('srw?wskey=IIRTOOIRNG','html', $child->link);

		 echo '<form action="'.uri('europeanaapi').'" method="post" name="'.$cb.'">';
		
		 print  "<a href='". $link1."' target='_new'>". $child->title."</a><br />";
		 print  "<a href='". $child->enclosure->attributes()."' target='_new'><img src='". $child->enclosure->attributes()." ' width='100' height='100' border='0'></a><br />";
		  //print  "Link :<br />". $child->link."<br /><hr>";
		   print  "". $child->description."<br />";
		   print  "<a href='". $child->link."' target='_new'>View Metadata</a> or <input type='submit' value='Add it to pathway' name='insert'><br /><br />";
		     echo '<input type="hidden" name="ex_id" value="'.$exhibit_id.'">';
			 echo '<input type="hidden" name="sec_id" value="'.$sec_id.'">';
			 echo '<input type="hidden" name="pg_id" value="'.$pg_id.'">';
			 $child->title = preg_replace('/(["\'])/ie', '',  $child->title);
			 echo '<input type="hidden" name="title" value="'.$child->title.'">';
			 echo '<input type="hidden" name="uri" value="'.$link1.'">';
			 echo '</form>';

		 $arr = $child->enclosure->attributes();
		// print ("ID=".$arr['url']);
		// print ("  Company=".$child->title); echo "<br><br>";
 		//echo $child->getName() . ": " . $child . "<br /><br />";
		
		echo "</div>";
			}
 		 
 	 } 
  } 
  
}//is iiset europeana text



}//if click add to pathway

}//if >0 page

?>
</div>
</body>
</html>