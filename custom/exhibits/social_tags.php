<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Pathway Authoring Tool Admin</title>

<!-- Meta -->
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<!-- Stylesheets -->
<link rel="stylesheet" media="screen" href="<?php echo $uri; ?>admin/themes/default/css/screen3.css" />
<link rel="stylesheet" media="print" href="<?php echo $uri; ?>admin/themes/default/css/print.css" />
<link rel="stylesheet" media="screen" href="<?php echo $uri; ?>admin/themes/default/css/niftyCorners.css" />
<link rel="stylesheet" media="screen" href="<?php echo $uri; ?>shared/exhibit_layouts/text-image-right/layout.css" />


</head>
<body style="width:400px;">


<?php 

    require_once('./custom/include/conf.php');


require_once("./custom/include/db_connect.php");  
$path_db="./db.ini";
db_connect($path_db);

$uid=$user; //to id tou user
//echo $uri;


//insert data
if(isset($_POST['tagging']) and $_POST['tagging']=='Tag this pathway'){

$query_teaser="insert into metadata_social_tags (user_id,exhibit_id,cd,cdk,ad,pd,description,cd_description,cdk_description,ad_description,pd_description) 
values (".$_POST['user_id'].",".$_POST['exhibit_id'].",'".$_POST['cd']."','".$_POST['cdk']."','".$_POST['ad']."','".$_POST['pd']."','".$_POST['description']."','".$_POST['cd_description']."','".$_POST['cdk_description']."','".$_POST['ad_description']."','".$_POST['pd_description']."') 
ON DUPLICATE KEY UPDATE cd='".$_POST['cd']."',cdk='".$_POST['cdk']."',ad='".$_POST['ad']."',pd='".$_POST['pd']."',description='".$_POST['description']."',cd_description='".$_POST['cd_description']."',cdk_description='".$_POST['cdk_description']."',ad_description='".$_POST['ad_description']."',pd_description='".$_POST['pd_description']."'";
$result_teaser=mysql_query($query_teaser);

echo "<h2 style='color:#003385;'>Tagging Form Submitted!</h2> ";
echo "<p style='color:#003385;'>Thank you for tagging this pathway!</p> ";

}
//end insert data

else{

 $pageURL= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];?>
<form name="item-exhibit" id="page-form" method="post" action="http://<?php echo $pageURL; ?>">



<div id="primary">



<?php
session_start();

// Write a function that will: 
// 1. check if user is logged in

//return_user();

// 2. check the user indentity
//  Use the USerController of OMEKA and Zend



 
	//query for selecting vocabulary
$query_item_js="SELECT f.value,d.id,d.source_name FROM metadata_vocabulary d RIGHT JOIN metadata_vocabulary_record e ON d.id = e.vocabulary_id RIGHT JOIN metadata_vocabulary_value f ON f.vocabulary_rid = e.id WHERE d.id=4 or d.id=5 or d.id=6 or d.id=7";
$res_item_js=mysql_query($query_item_js);

//end

	//query for selecting if user already put socal tags
$query="SELECT * FROM metadata_social_tags  WHERE user_id=".$uid." and exhibit_id=".$_GET['eid']."";
$res=mysql_query($query);
$result_user=mysql_fetch_array($res);
//end 
?>  

<label>Cognitive Domain</label>
<select name="cd" style="width:300px;">
<option value="">Select a tag</option>
<?php 
while($result_item_js=mysql_fetch_array($res_item_js)){
if($result_item_js['id']==4){
echo '<option value="'.$result_item_js['value'].'" ';
if($result_item_js['value']===$result_user['cd']){echo 'selected=selected';}
echo '>'.$result_item_js['value'].'</option>';
}
}
?>
</select>  
<br><br>
<input type="text" name="cd_description" style="width:300px;" value="<?php echo $result_user['cd_description'] ?>">
<br><br><br>
<label>Cognitive Domain (Knowledge)</label>
<select name="cdk" style="width:300px;">
<option value="">Select a tag</option>
<?php 
$res_item_js=mysql_query($query_item_js);
while($result_item_js=mysql_fetch_array($res_item_js)){
if($result_item_js['id']==5){
echo '<option value="'.$result_item_js['value'].'" ';
if($result_item_js['value']===$result_user['cdk']){echo 'selected=selected';}
echo '>'.$result_item_js['value'].'</option>';
}
}
?>
</select>  
<br><br>
<input type="text" name="cdk_description" style="width:300px;" value="<?php echo $result_user['cdk_description'] ?>">

<br><br><br>
<label>Affective Domain</label>
<select name="ad" style="width:300px;">
<option value="">Select a tag</option>
<?php 
$res_item_js=mysql_query($query_item_js);
while($result_item_js=mysql_fetch_array($res_item_js)){
if($result_item_js['id']==6){
echo '<option value="'.$result_item_js['value'].'" ';
if($result_item_js['value']===$result_user['ad']){echo 'selected=selected';}
echo '>'.$result_item_js['value'].'</option>';
}
}
?>
</select>  
<br><br>
<input type="text" name="ad_description" style="width:300px;" value="<?php echo $result_user['ad_description'] ?>">

<br><br><br>
<label>Psychomotor Domain</label>
<select name="pd" style="width:300px;">
<option value="">Select a tag</option>
<?php 
$res_item_js=mysql_query($query_item_js);
while($result_item_js=mysql_fetch_array($res_item_js)){
if($result_item_js['id']==7){
echo '<option value="'.$result_item_js['value'].'" ';
if($result_item_js['value']===$result_user['pd']){echo 'selected=selected';}
echo '>'.$result_item_js['value'].'</option>';
}
}
?>
</select> 
<br><br>
<input type="text" name="pd_description" style="width:300px;" value="<?php echo $result_user['pd_description'] ?>">
 
<br><br><br>
<label>Description</label>
<input type="text" name="description" value="<?php echo $result_user['description']; ?>" style="width:300px;" >
<br><br>

<input type="hidden" name="user_id" value="<?php echo $uid; ?>" >
<input type="hidden" name="exhibit_id" value="<?php echo $_GET['eid']; ?>" >
<input type="submit" value="Tag this pathway" name="tagging">
</div>
</div>
</form>
<?php } ?>
</body>
</html>