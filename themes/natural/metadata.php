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

$CONTENT_TYPE = 'Content-type: text/xml';
$xmlheader = '<?xml version="1.0" encoding="UTF-8"?>';
$output.='';
if(isset($_GET['path_id'])){$_GET['path_id']=$_GET['path_id'];}else{$_GET['path_id']=1;}
$pathway=$_GET['path_id'];
//query for all values

$sql="SELECT * FROM omeka_exhibits where id=".$pathway." and public=1";
$execrecord=$db->query($sql);
$datarecord=$execrecord->fetchAll();
$count= count($datarecord);
if($count>0){//an uparxei

foreach($datarecord as $datarecord){


$output.="\n"."<pathway>";
$output.="<title>".$datarecord['title']."</title>";
$output.="<creator>".return_user_of_exhibit2($pathway)."</creator>";
$output.="<link>http://education.natural-europe.eu/natural_europe/exhibits/".$datarecord['slug']."/to-begin-with</link>";
$output.="<id>".$datarecord['id']."</id>";
$output.="<date_modified>".$datarecord['date_modified']."</date_modified>";

$output.="<metadata>";

		//query for creating general elements pelement=0		 
$sql2="SELECT a.*,c.*,b.* FROM metadata_element_label a LEFT JOIN metadata_element b ON a.element_id = b.id LEFT JOIN metadata_element_hierarchy c ON c.element_id = b.id WHERE c.pelement_id=0 and c.is_visible=1 ORDER BY (case WHEN c.sequence IS NULL THEN '9999' ELSE c.sequence END) ASC;";
$exec2=$db->query($sql2); 
$data2=$exec2->fetchAll();
		//end


$sql="SELECT * FROM metadata_record WHERE object_id=".$pathway." and object_type='exhibit'";
$execrecord2=$db->query($sql);
$datarecord2=$execrecord2->fetchAll();
foreach($datarecord2 as $datarecord2){$datarecord2['id']=$datarecord2['id'];}		
//query for all elements without asking pelement
$sql="SELECT a.*,c.labal_name,b.* FROM metadata_element_value a join metadata_element_hierarchy b ON b.id=a.element_hierarchy join metadata_element_label c ON b.element_id=c.element_id WHERE a.record_id=".$datarecord2['id']." ORDER BY b.pelement_id ASC, b.sequence ASC";
$exec5=$db->query($sql);
$data51=$exec5->fetchAll();
//end		


foreach($data2 as $data){  //for every element general
$output.="<".$data['labal_name'].">";
foreach($data51 as $data5){
if($data['element_id']===$data5['pelement_id']){ //if pelement tou hierarchy = element general

$search  = array(' ','?','(',')');
$replace = array('_','','','');
$data5['labal_name']=str_replace($search, $replace, $data5['labal_name']);

$output.="<".$data5['labal_name'].">";
$output.=$data5['value'];	
$output.="</".$data5['labal_name'].">";	
}
}
$output.="</".$data['labal_name'].">";	
		}


$output.="</metadata>";
$output.="</pathway>";
}//while exhibit
}//an uparxei 
else{
$output.="<error>";
$output.="No pathway with this id";	
$output.="</error>";	
}






header($CONTENT_TYPE);
echo $xmlheader;
echo $output;



?>