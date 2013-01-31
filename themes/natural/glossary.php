<?php head(array('title'=>'Glossary')); ?>
<div id="page-body" class="one_column">
<?php include ("common/menu.php") ?>


<div class="column" id="column-c">
<h1 class="section_title">Glossary</h1>

<div class="toolbar glossary">
<div class="alphabet">
<?php
	//show letters
	$lettersarray= range ( 'A' , 'Z' );
           foreach($lettersarray as $letter) {  
		   
		   
	if($_GET["target"]){ $tagretcmd="target=".$_GET["target"]; }	 
	if($_GET["section"]){ $sectioncmd="&section=".$_GET["section"]; }  else{$sectioncmd="";}
		                      
 if($_GET["target"]){ 
                echo ("<a href=".uri('')."glossary?target=".$_GET["target"]."".$sectioncmd."&letter=$letter> $letter </a>");  
				} else{
				echo ("<a href=".uri('')."glossary?letter=$letter".$sectioncmd."> $letter </a>");
				}  

}
 if($_GET["target"]){
echo "<a href=".uri('')."glossary?target=".$_GET["target"]."".$sectioncmd."> / All</a>";
} else{
echo "<a href=".uri('')."glossary".$sectioncmd."> / All</a>";
}
//end show letters
?>
</div>


<?php include('./custom/glossary/glossary_custom.php'); ?>

		
</div><!-- end div.content-->	

<div class="clear"></div><!--clear DIV NEEDS TO BE ADDED TO ALL TEMPLATES-->
</div><!--end page-body div-->
<div class="clear"></div><!--clear DIV NEEDS TO BE ADDED TO ALL TEMPLATES-->
</div><!--end page-container div-->
<?php foot(); ?>