<?php 
    require_once("./custom/include/db_connect.php");  
    
    $path_db="./application/config/db.ini";
	db_connect($path_db);
?>

<script type="text/javascript" language="javascript" src="<?php echo uri('themes/natural/javascripts/jquery.js'); ?>"></script>
<script>
     jQuery.noConflict();
   </script>
<script type="text/javascript" language="javascript" src="<?php echo uri('custom/registration/pager.js'); ?>"></script>
<!-- the input fields that will hold the variables we will use -->
	<input type='hidden' id='current_page' />
	<input type='hidden' id='show_per_page' />


	<div id='content_paging'>
<?php
 $targetteam="";
if(isset($_GET["target"])){$targetteam="&target=".$_GET["target"]."";}
if(isset($_GET["section"])){$targetteam="&section=".$_GET["section"]."";}

$query="SELECT c.id,c.last_name,c.middle_name,c.first_name,c.institution,d.role FROM omeka_entities c INNER JOIN omeka_users d ON (d.entity_id =c.id) ";
$query.=" WHERE d.active =1";
if(isset($_GET['researcher'])){ $query.=" AND d.role='Researcher'"; }
$query.=" ORDER BY c.last_name ASC";

$query=mysql_query($query) or die(" Error: ".mysql_error());
$reg_count=0;
while($result = mysql_fetch_assoc($query)){ 

if(isset($_GET['researcher_exhibit'])){ 
 $query2="SELECT DISTINCT  * FROM omeka_exhibits c INNER JOIN omeka_entities_relations d ON (d.relation_id=c.id AND d.type='Exhibit') INNER JOIN omeka_entity_relationships e ON (d.relationship_id=e.id) INNER JOIN omeka_entities f ON (d.entity_id=f.id)";
$query2.=" WHERE f.id ='".$result['id']."' AND (e.name='added' OR e.name='modified') AND c.public=1";

$query3="SELECT DISTINCT c.name,c.id FROM omeka_collections c INNER JOIN omeka_entities_relations d ON (d.relation_id=c.id AND d.type='Collection') INNER JOIN omeka_entity_relationships e ON (d.relationship_id=e.id) INNER JOIN omeka_entities f ON (d.entity_id=f.id)";
$query3.=" WHERE f.id ='".$result['id']."' AND (e.name='added' OR e.name='modified') AND c.public=1";

$queryexh=mysql_query($query2);
$querycol=mysql_query($query3);
$num_rowsexh = mysql_num_rows($queryexh);
$num_rowscol = mysql_num_rows($querycol);
if($num_rowsexh>0 or $num_rowscol>0) {

$reg_count+=1;
if($result['role']=='admin' or $result['role']=='super'){$role="Content generator";}else{$role=$result['role'];}
 echo ("<div class='registration_results'>"); 

?>
 <a href=" <?php echo uri(''); ?>profile?entity= <?php echo $result['id'].$targetteam; ?>">
 <?php
 echo(ucfirst($result['last_name'])." ".$result['middle_name']." ".$result['first_name']."</a></strong><br /><strong>Institution : </strong>".ucfirst($result['institution'])."<br /><strong>I am : </strong>".ucfirst($role)."</div>");
if($reg_count%2===0){echo("<div style='clear: both'></div>");}

    }//if num_rows
       }//if exist researcher_exhibit
	   else{
	   $reg_count+=1;
if($result['role']=='admin' or $result['role']=='super'){$role="Content generator";}else{$role=$result['role'];}
 echo ("<div class='registration_results'>"); ?>
 
  <a href=" <?php echo uri(''); ?>profile?entity= <?php echo $result['id'].$targetteam; ?>">
 <?php
 echo(ucfirst($result['last_name'])." ".$result['middle_name']." ".$result['first_name']."</a></strong><br /><strong>Institution : </strong>".ucfirst($result['institution'])."<br /><strong>I am : </strong>".ucfirst($role)."</div>");
if($reg_count%2===0){echo("<div style='clear: both'></div>");}
	        
	   
	   }//else researcher_exhibit
  }//while
?> 
</div>

	<!-- An empty div which will be populated using jQuery -->
	<div style="clear: both"></div>
	<div id='page_navigation' class="page_navigation"></div>
