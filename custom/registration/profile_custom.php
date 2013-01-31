<?php 
    require_once("./custom/include/db_connect.php");  
    
    $path_db="./application/config/db.ini";
	db_connect($path_db);
?>


<?php
function giasql($string){
    //This function removes all characters we do not want

    $string = preg_replace("/[^0-9αβγδεζηθικλμνξοπρστυφχψωςόάέίύήϊΑ-Ωa-zA-Z-\/_ ]/", "", $string);
    return $string;
}
if(isset($_GET["entity"])){
  $search=giasql($_GET["entity"]);
  $search = strtoupper($search);
$search = strip_tags($search);
$search = trim ($search);
}


$query="SELECT c.id,c.last_name,c.middle_name,c.first_name,c.institution,d.role,c.email,d.my_science_field_of_interest,d.my_science_field_of_interest2,d.my_expertise,d.my_expertise2 FROM omeka_entities c INNER JOIN omeka_users d ON (d.entity_id =c.id) ";
$query.=" WHERE c.id ='".$search."'";


$query=mysql_query($query) or die(" Error: ".mysql_error());
$result = mysql_fetch_assoc($query);
if($result['role']=='admin' or $result['role']=='super'){$role="Content generator";}else{$role=$result['role'];}

 echo ("<div class='profile_results'><h2 class='member_name'>".ucfirst($result['last_name'])." ".$result['middle_name']." ".$result['first_name']."<br /><strong>Institution : </strong>".ucfirst($result['institution'])."<br /><strong>I am : </strong>".ucfirst($role)."<br /></div>");
 
 echo "<br /><div class='profile_interests_expertise'>";
if((isset($result['my_science_field_of_interest2']) and $result['my_science_field_of_interest2']!=NULL) or (isset($result['my_science_field_of_interest'])and $result['my_science_field_of_interest']!=NULL)){
echo ("<strong>My science field of interest : </strong>".$result['my_science_field_of_interest']." ");
 if((isset($result['my_science_field_of_interest2']) and $result['my_science_field_of_interest2']!=NULL) and (isset($result['my_science_field_of_interest'])and $result['my_science_field_of_interest']!=NULL)){ echo (", "); }
echo ("".$result['my_science_field_of_interest2']."");
}

if((isset($result['my_expertise']) and $result['my_expertise']!=NULL) or (isset($result['my_expertise2'])and $result['my_expertise2']!=NULL)){
echo ("<br /><strong>My expertise : </strong>".$result['my_expertise']." ");
 if((isset($result['my_expertise']) and $result['my_expertise']!=NULL) and (isset($result['my_expertise2'])and $result['my_expertise2']!=NULL)){ echo (", "); }
echo ("".$result['my_expertise2']."");
}

 
 $query2="SELECT DISTINCT  c.title,c.slug FROM omeka_exhibits c INNER JOIN omeka_entities_relations d ON (d.relation_id=c.id AND d.type='Exhibit') INNER JOIN omeka_entity_relationships e ON (d.relationship_id=e.id) INNER JOIN omeka_entities f ON (d.entity_id=f.id)";
$query2.=" WHERE f.id ='".$search."' AND (e.name='added' OR e.name='modified') AND c.public=1";

$query3=mysql_query($query2) or die(" Error: ".mysql_error());
$result2 = mysql_fetch_assoc($query3);
if(isset($result2['title'])){
echo("<br />");
echo("<strong>Exhibits : </strong><br />");
$query2=mysql_query($query2) or die(" Error: ".mysql_error());
while($result2 = mysql_fetch_assoc($query2)){
echo ("<a href='".uri('')."exhibits/".$result2['slug']."/to-begin-with'>".$result2['title']."</a><br />");
}
}//if isset exhibits


$query2="SELECT DISTINCT c.name,c.id FROM omeka_collections c INNER JOIN omeka_entities_relations d ON (d.relation_id=c.id AND d.type='Collection') INNER JOIN omeka_entity_relationships e ON (d.relationship_id=e.id) INNER JOIN omeka_entities f ON (d.entity_id=f.id)";
$query2.=" WHERE f.id ='".$search."' AND (e.name='added' OR e.name='modified') AND c.public=1";
$query3=mysql_query($query2) or die(" Error: ".mysql_error());
$result2 = mysql_fetch_assoc($query3);
if(isset($result2['name'])){
echo("<br />");
echo("<strong>Collections : </strong><br />");
$query2=mysql_query($query2) or die(" Error: ".mysql_error());
while($result2 = mysql_fetch_assoc($query2)){
echo ("<a href='".uri('')."items/browse/?collection=".$result2['id']."&title=".$result2['name']."'>".$result2['name']."</a><br />");
}

}//if isset collection

echo "</div>";

?>
<div class="profile_communicate">
<?php echo "<a class='lightview' rel='iframe' title=' ::  :: width: 600, height: 550' class='lightview' href='".uri('custom/contact')."/contact.php?id=".$result['id']."'>Communicate with ".ucfirst($result['last_name'])." ".$result['middle_name']." ".$result['first_name']."</a>"; ?>
</div><!--end profile_icommunicate-->
