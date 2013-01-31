<?php 
    require_once("./custom/include/db_connect.php");  
    
    $path_db="./application/config/db.ini";
	db_connect($path_db);
?>
<style type="text/css">
a { text-decoration:none }

.glossary_results{

text-align:left;
	margin-bottom:1px;
	font-size:9pt;
}

#page_navigation {
position:absolute;
left:0;
bottom:2px;
 text-align:center;
}


</style>
<script type="text/javascript" language="javascript" src="http://education.natural-europe.eu/natural_europe/themes/eknownetv3/jcarousel/lib/jquery-1.2.3.pack.js"></script>
<script type="text/javascript" language="javascript" src="http://education.natural-europe.eu/natural_europe/custom/glossary/pager.js"></script>

<!-- the input fields that will hold the variables we will use -->
	<input type='hidden' id='current_page' />
	<input type='hidden' id='show_per_page' />


	
<?php
function giasql($string){
    //This function removes all characters we do not want

    $string = preg_replace("/[^0-9αβγδεζηθικλμνξοπρστυφχψωςόάέίύήϊΑ-Ωa-zA-Z-\/_ ]/", "", $string);
    return $string;
}


//$query="SELECT a.title, a.description FROM omeka_items a  ";

$query = 	"SELECT a.*,b.archive_filename,b.original_filename
			FROM omeka_items a LEFT JOIN omeka_files b ON (b.item_id=a.id)";
$query.=" WHERE a.type_id=22";
  
$query.=" ORDER BY a.title ASC";

$query=mysql_query($query) or die(" Error: ".mysql_error());
?>
<div id='content_paging'>
<?php
while($result = mysql_fetch_assoc($query)){ 


 echo ("<div class='glossary_results' style='margin-bottom: 30px;'><strong>".$result['title']." : </strong>".$result['description']."<a href='http://education.natural-europe.eu/natural_europe/archive/files/".$result['archive_filename']."' target='_blank'>Read more...</a><hr></div>"); }
?> 

</div>

	<!-- An empty div which will be populated using jQuery -->
	<br>
	<div id='page_navigation' class="page_navigation" align="center"></div>