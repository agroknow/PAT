<?php 
    require_once("./custom/include/db_connect.php");  
    
    $path_db="./application/config/db.ini";
	db_connect($path_db);
?>

<div class="search_box">
<script type="text/javascript" language="javascript" src="<?php echo uri('themes/natural/javascripts/jquery.js'); ?>"></script>
<script>
     jQuery.noConflict();
   </script>
<script type="text/javascript" language="javascript" src="<?php echo uri('custom/glossary/pager.js'); ?>"></script>

<!-- the input fields that will hold the variables we will use -->
	<input type='hidden' id='current_page' />
	<input type='hidden' id='show_per_page' />

<form id="login" action="<?php if($_GET["target"]){ echo uri('glossary?target='.$_GET["target"].''); } elseif($_GET["section"]){ echo uri('glossary?section='.$_GET["section"].''); } else {echo uri('glossary');}?>" method="post">
	<input type="text" class="theInput" name="search" />
	<input type="submit" name="Submit" value="Search" class="theSubmit" />
 </form>
 </div><!--search_box-->
</div><!--end toolbar-->
	<div id='content_paging'>
<?php
function giasql($string){
    //This function removes all characters we do not want

    $string = preg_replace("/[^0-9αβγδεζηθικλμνξοπρστυφχψωςόάέίύήϊΑ-Ωa-zA-Z-\/_ ]/", "", $string);
    return $string;
}
if(isset($_GET["letter"])){
  $search=giasql($_GET["letter"]);
  $search = strtoupper($search);
$search = strip_tags($search);
$search = trim ($search);
}
if(isset($_GET["search_word"])){
  $search=giasql($_GET["search_word"]);
  $search = strtoupper($search);
$search = strip_tags($search);
$search = trim ($search);
}

if(isset($_POST["Submit"]) or isset($_POST["search"])) {
  $search_word=giasql($_POST["search"]);
  $search_word = strtoupper($search_word);
$search_word = strip_tags($search_word);
$search_word = trim ($search_word); 
}


$query="SELECT c.text,a.title FROM omeka_metatext c INNER JOIN omeka_types_metafields d ON (d.metafield_id=c.metafield_id) INNER JOIN omeka_metafields e ON (e.id=c.metafield_id)  INNER JOIN omeka_items a ON ( c.item_id = a.id )  ";
$query.=" WHERE d.type_id=18";
if(isset($_GET["letter"])){$query.=" AND UCASE(MID(title,1,1))='".$search."'";}
if(isset($_GET["search_word"])){$query.=" AND a.title like '%".$search."%'"; }
if(isset($_POST["Submit"]) or isset($_POST["search"])) {
echo ($search_word."<br />");
$query.=" AND a.title like '%".$search_word."%'"; }
  
$query.=" ORDER BY a.title ASC";

$query=mysql_query($query) or die(" Error: ".mysql_error());
$num_rows = mysql_num_rows($query);

if($num_rows>0){
while($result = mysql_fetch_assoc($query)){ 


 echo ("<div class='glossary_results'><strong>".$result['title']." : </strong><br />".strip_tags($result['text'],"<b><i><p><a><div><li><ul>")."<hr /></div>"); }
 
 }//if num_rows>0

else{
    if(isset($_POST["Submit"]) or isset($_POST["search"])){
// array of words to check against
$query="SELECT c.text,a.title FROM omeka_metatext c INNER JOIN omeka_types_metafields d ON (d.metafield_id=c.metafield_id) INNER JOIN omeka_metafields e ON (e.id=c.metafield_id)  INNER JOIN omeka_items a ON ( c.item_id = a.id )  ";
$query.=" WHERE d.type_id=18";
$query=mysql_query($query);

while($result = mysql_fetch_assoc($query)){ 
$words[]=$result['title'];
$searcha = Array();
$searcha = explode(" ", $result['title']); 
$pos = strpos($result['title']," ");
if($pos>0) {
foreach ($searcha as $search_word2) { 
$words[]=$search_word2;}}

}


 
// no shortest distance found, yet
$shortest = -1;

// loop through words to find the closest
foreach ($words as $word) {
$word=strtoupper($word);
    // calculate the distance between the input word,
    // and the current word
    $lev = levenshtein($search_word, $word);
	//echo $word."<br />";
    // check for an exact match
    if ($lev == 0) {

        // closest word is this one (exact match)
        $closest = $word;
        $shortest = 0;

        // break out of the loop; we've found an exact match
        break;
    }

    // if this distance is less than the next found shortest
    // distance, OR if a next shortest word has not yet been found
    if ($lev <= $shortest || $shortest < 0) {
        // set the closest match, and shortest distance
        $closest  = $word;
        $shortest = $lev;
    }
}

if ($shortest == 0) {
    echo "<div class='glossary_results'>No result found for ".$search_word." . <br /> Please try again.</div>";
} else {
    echo "<div class='glossary_results'>No result found for ".$search_word."<br />Did you mean: <a href='".uri('glossary?search_word='.$closest.'')."'>".$closest."</a>?\n</div>";
}
   }//if isset search
	}//else num_rows>0
?> 

</div>

	<!-- An empty div which will be populated using jQuery -->

	<div id='page_navigation' class='page_navigation'></div>