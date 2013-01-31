<?php head(array('title'=>'natural_europe')); ?>
<div id="page-body" class="two_column">
<?php include ("common/menu.php") ?>

<div class="column" id="column-d">
<h1 class="section_title">Chemical <a id="Chemical bond (glossary)" class="undrline" onclick="getItemDef(this)" href="javascript:void(0);"><u>bonds</u></a> and chemical <a id="molecular structure (glossary)" class="undrline" onclick="getItemDef(this)" href="javascript:void(0);"><u>structure</u></a> of the molecule</h1>
 

<p>
Atoms can be bonded together forming molecules, as letters can form words. We can think of molecules as a collection of nuclei sharing their electrons, giving rise to chemical bonds. The electrons act as ‘glue’ sticking the atoms together.
Usually, in scientific representations of molecules, nuclei are represented by small balls, often of different color depending on the atom they represent (carbon, hydrogen, oxygen etc), whereas bonds by sticks. 
In the box below you can see the example of thymine, one of the four DNA bases. 
</p>

<h2>The Thymine molecule – two different representations</h2>

<div style="float:left; text-align:center;"> <h4>Thymidine Monophosphate</h4><br> <img height="180" width="180"  src="<?php echo uri('themes/natural/images/intropages/t.gif');  ?>" alt="" /></div>
<div style="float:left; text-align:center;"> <h4>Chemical representation of thymine</h4><br> <img height="180" width="180"  src="<?php echo uri('themes/natural/images/intropages/chemical thymine.jpg');  ?>" alt="" /></div>
<div style="clear:both;"></div>


</div><!-- end div.column #column-b -->
<div class="column" id="column-e">

	<div class="panel-exhibit">
	<a id="panel-exhibitlink" onclick='clearItemInfo();' href="javascript:void(0);"></a>
	<div class="scroll-pane"><!--ADD SCROLL PANE DIV WITH JAVASCRIPT WHEN MENU SCROLLS WITH THE PAGE TO REPLACE DEFAULT SCROLLBAR?-->
	<div class="panel sidebar resources">
	<h2 class="title_sel" id="title">Explore further</h2>	
		<div class="panel-intro" id="item-tip">
			Click on a term of the exhibit and learn more by exploring:
		</div><!-- end div.panel-intro -->	
		<div id="panel-exhibit_gialink"><h4 class="panel-exhibit_gialink">Images</h4>	</div>
		<div class="panel-intro" id="image-resources">
		</div><!-- end div.panel-intro -->	
		<div id="panel-exhibit_gialink"><h4 class="panel-exhibit_gialink">Videos</h4>	</div>
		<div class="panel-intro" id="video-resources">	
		</div><!-- end div.panel-intro -->	
		<div id="panel-exhibit_gialink"><h4 class="panel-exhibit_gialink">Links</h4>	</div>
		<div class="panel-intro" id="links-resources">
			
		</div><!-- end div.panel-intro -->
		<div id="panel-exhibit_gialink"><h4 class="panel-exhibit_gialink">Games</h4>	</div>
		<div class="panel-intro" id="links-games">
			
		</div><!-- end div.panel-intro -->	
		<div class="panel-footer">
		&nbsp;
		</div><!-- end div.panel-footer -->
	</div><!-- end div.panel -->
	</div>
	</div>
<div class="clear"></div><!--clear DIV NEEDS TO BE ADDED TO ALL TEMPLATES-->
</div><!--end page-body div-->
<div class="clear"></div><!--clear DIV NEEDS TO BE ADDED TO ALL TEMPLATES-->
</div><!--end page-container div-->
<?php foot(); ?>