<?php
 
    require_once("./custom/include/db_connect.php");  
    
    $path_db="./db.ini";
	db_connect($path_db);


/*++++++++++++++++++++
$ul_id='crumbs';
$bc=explode("/",$_SERVER["REQUEST_URI"]);
while(list($key,$val)=each($bc)){
 $dir='';
 if($key > 1){
  $n=1;
  while($n < $key){
   $dir.='/'.$bc[$n];
   $val=$bc[$n];
   $n++;
  }
  if($key < count($bc)-1) echo '<a href="'.$dir.'">'.$val.'</a>&gt; ';
 }
}
-----------------------*/


$req_url = $_SERVER['REQUEST_URI'];  //whatever is after sciencetweets.eu
$url_part = explode('/',$req_url); //seperate at /
// foreach ()
/*foreach ($url_part as $value)
{


}*/

$part1 = ucfirst($url_part[1]); //test2 or natural_europe kefalaio to prwto
$_url_part1 = $_SERVER['HTTP_HOST']; // www.sciencetweets.eu

 if (stripos($_SERVER['REQUEST_URI'],"collection") || stripos($_SERVER['REQUEST_URI'],"items/show"))
{


	
	if ($_GET["eidteaser"]){

$eidteaser = preg_replace("/[^0-9]/", "", $_GET['eidteaser']);
$query="SELECT * FROM omeka_exhibits WHERE id='".$eidteaser."'"; 
  
$query=mysql_query($query) or die(" Error: ".mysql_error());
$num_rows = mysql_num_rows($query);

if($num_rows>0){
$result2 = mysql_fetch_assoc($query); } else{$result2['title']="Error";}

}
	if ($url_part[2]){ 
	
	if ($_GET["eidteaser"]){
	$_output .= '<a href="http://'.$_url_part1.'/'.$url_part[1].'/index'.target().'">'.ucfirst(__('Pathways')).' ></a>'.$title;}
	
	 }
	 
	if ($_GET["eidteaser"]){
	$_output .= '<a href="http://'.$_url_part1.'/'.$url_part[1].'/exhibits/show/'.$result2['slug'].'/to-begin-with'.target().'" >'.ucfirst($result2['title']).'</a>';}
	
	
}

else if ($url_part[2]=="exhibits")
{

if ($url_part[3]){
$query="SELECT title,date_modified FROM omeka_exhibits WHERE slug='".$url_part[4]."'"; 
  
$query=mysql_query($query) or die(" Error: ".mysql_error());
$num_rows = mysql_num_rows($query);

if($num_rows>0){
$result = mysql_fetch_assoc($query); } else{$result['title']="Error";}

}

	if (!$url_part[3]){ $_output = ''.__('Pathways').'';}
	else { $_output = '';
	if ($url_part[2]) $_output .= '<a href="http://'.$_url_part1.'/'.$url_part[1].'/index'.target().'">'.__('Pathways').' ></a>';
	if ($url_part[4]) $_output .= '<a href="http://'.$_url_part1.'/'.$url_part[1].'/'.$url_part[2].'/'.$url_part[3].'/'.$url_part[4].'/to-begin-with'.target().'">'.ucfirst($result['title']).'</a>';
	}
	
}

echo $_output;

?>