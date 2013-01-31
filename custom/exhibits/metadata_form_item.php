<?php
require_once("../include/conf.php");
//contact with database
    require_once("../include/db_connect.php");  
    
    $path_db="../../application/config/db.ini";
    db_connect($path_db);
	

foreach($_POST as $var => $value)
{

$result_teaser=mysql_query("select * from metadata_record where object_id=".$_POST['it_id']." and object_type='item'");
$result_sqlexhibit=mysql_fetch_array($result_teaser);
$record_id=$result_sqlexhibit['id'];

if($var!='it_id' and $var!='title' and $var!='hdnLine' and $var!='slug' and $var!='public' and $var!='save_matadata' and $var!='date_modified' and $var!='save_exhibit_new'){
$var1=explode("_",$var); //split form name at _
$var=$var1[0]; 
$varlan=$var1[2]; 



if($var1[2]!='lan' and $var!='hdnLine'){ //not get in if is language name at form or name is hdnline



if(isset($_POST[$var.'_'.$var1[1].'_lan'])){$language=$_POST[$var.'_'.$var1[1].'_lan'];} else{$language='none';}//langueage for this form name


//if($var==6 and $language=='en'){$exhibit_title_from_metadata=$value;}//title gia pathway

$res_multi=mysql_query("select * from metadata_element_hierarchy where id=".$var.""); 
$result_multi=mysql_fetch_array($res_multi);
if($result_multi['max_occurs']>0){ $multi=$var1[1]; } else{$multi=1;}

if(strlen($value)>1){
$sql="insert into metadata_element_value SET element_hierarchy=".$var.",value='".$value."',language_id='".$language."',record_id=".$record_id.",multi=".$multi." ON DUPLICATE KEY UPDATE value='".$value."'";
$result_teaser=mysql_query($sql) or die(mysql_error());

}//if strlen >1 if exist value
}//end not get in if is language name at form 
}
}

if(isset($_POST['save_matadata'])){ ?>
<script language=JavaScript>
						  window.close();
						  </script>
						  <?php
}
?>