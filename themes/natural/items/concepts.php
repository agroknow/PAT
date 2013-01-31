<?php
		$con=mysql_connect("localhost","projects","thrillos25");
		//if ($con) echo "1";
		$db_selected = mysql_select_db("projects_omeka");
		$sql = "SELECT a.*,b.archive_filename FROM omeka_items a
				LEFT JOIN omeka_files b ON (b.item_id=a.id)";
		$sql.= " WHERE a.title='".$_GET["title"]."' AND a.type_id=14";
		//echo $sql;
		$rel=mysql_query($sql);
		$result=mysql_fetch_array($rel);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title></title>

<!-- Meta -->
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />


<!-- Stylesheets -->
<link rel="stylesheet" media="screen" href="<?php echo css('screen'); ?>" />
<link rel="stylesheet" media="print" href="<?php echo css('print'); ?>" />
<!-- Plugin Stuff -->
<?php echo plugin_header(); ?>

</head>
<body>
	<div id="wrap">

<div id="primary" class="show">

	<h1 class="item-title"><?php if($result["title"]) echo h($result["title"]); else echo 'Untitled'; ?></h1>
<!--  The following is extended metadata that is assigned based on the Type that is assigned to an item -->
	
	<div id="extended-metadata">
            <!-- This loop outputs all of the extended metadata -->
            <?php 
				$sql = "SELECT c.text,e.name,e.id FROM omeka_metatext c,omeka_types_metafields d, omeka_metafields e";
				$sql.= " WHERE c.item_id='".$result["id"]."' AND d.type_id=".$result["type_id"]." AND d.metafield_id=c.metafield_id AND e.id=c.metafield_id";
				$rel_=mysql_query($sql);
				$counter=1;
				while ($result_=mysql_fetch_array($rel_)){
			?>
                <div id="<?php echo $result_["id"]; ?>" class="field">
                    <?php if ($counter==1 && $result["archive_filename"]){?>
					 <img src="<?php 
						$path_parts=pathinfo("../../archive/thumbnails/".$result["archive_filename"]);
						echo $path_parts['dirname']."/".$path_parts["filename"].".jpg";?>" style="float:left"/>
					<?php }?>
					<h2><?php echo $result_["name"]; ?></h2>
                    <div class="field-value"><?php echo nls2p($result_["text"]); ?></div>
                </div>
            <?php $counter++;}?>

	</div>
</div>
</div><!-- end content -->
</div><!--end wrap-->
</body>
</html>