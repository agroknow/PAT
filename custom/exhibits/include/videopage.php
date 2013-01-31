<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title></title>

<!-- Meta -->
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />


<!-- Stylesheets -->
<script src="http://education.natural-europe.eu/natural_europe/themes/eknownetv3/scripts/ajax/ajax2.js" type="text/javascript">
</script>
<script src="http://education.natural-europe.eu/natural_europe/themes/eknownetv3/scripts/ajax/ajax_chained2.js" type="text/javascript">
</script>

<body>
<div id="wrap">
<div id="content" style="text-align:center;">

<?php
	
	require_once("../../include/db_connect.php");

	$path_db="../../../application/config/db.ini";
	db_connect($path_db);

	$item_id=$_GET["video_name"];
	function giasql($string){
    //This function removes all characters we do not want

    $string = preg_replace("/[^0-9αβγδεζηθικλμνξοπρστυφχψωςόάέίύήϊΑ-Ωa-zA-Z-\/_ ]/", "", $string);
    return $string;
	}
	$item_id=giasql($item_id);
	$response="";
	$video_namex=0;
	$video_namey=0;
	$query_video_name="select * from omeka_files where item_id='$item_id'";
	$result_video_name=mysql_query($query_video_name);
	$row_video_name=mysql_fetch_array($result_video_name);
	$video_name=$row_video_name["archive_filename"];
	$video_namex=$row_video_name["width"];
	$video_namey=$row_video_name["height"];
	$video_namex=giasql($video_namex);
	$video_namey=giasql($video_namey);
	if($video_namey>0){$video_namey=$video_namey;}else{$video_namey=440;}
	if($video_namex>0){$video_namex=$video_namex;}else{$video_namex=550;}
	
	
	//echo $query_video_name; 
	 
?>

<?php if(stripos($video_name,'.swf')){ ?>

<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=8,0,0,0" width="<?php echo $video_namex;  ?>" height="<?php echo $video_namey;  ?>">
<param name="movie" value="../../../archive/files/<?php echo $video_name;  ?>" />
<param name="quality" value="high" />
<PARAM NAME="SCALE" VALUE="default">
<embed src="../../../archive/files/<?php echo $video_name;  ?>" quality="high" type="application/x-shockwave-flash" width="<?php echo $video_namex;  ?>" height="<?php echo $video_namey;  ?>" SCALE="default" pluginspage="http://www.macromedia.com/go/getflashplayer" />
</object>


<?php } else{ ?>
				
				<OBJECT CLASSID="clsid:02BF25D5-8C17-4B23-BC80-D3488ABDDC6B"
CODEBASE="http://www.apple.com/qtactivex/qtplugin.cab" WIDTH="<?php echo $video_namex;  ?>" HEIGHT="<?php echo $video_namey;  ?>" >
<PARAM NAME="src" VALUE="../../../archive/files/<?php echo $video_name;  ?>" >
<PARAM NAME="autoplay" VALUE="true" >
<param name="controller" value="true" />
<param name="loop" value="false" />
<EMBED SRC="../../../archive/files/<?php echo $video_name;  ?>" TYPE="image/x-macpaint"
PLUGINSPAGE="http://www.apple.com/quicktime/download" controller="true" WIDTH="<?php echo $video_namex;  ?>" HEIGHT="<?php echo $video_namey;  ?>" AUTOPLAY="true"></EMBED>
</OBJECT>
				
	<?php } ?> 
	
	
	                       
</div><!-- end content -->
</div><!--end wrap-->
<a onclick="showRightsid(this)" name="<?php echo $row_video_name["id"];  ?>" id="rights" href="javascript:void(0);">Licence</a>
<div id="info_full">
&nbsp;
</div>
</body>
</html>