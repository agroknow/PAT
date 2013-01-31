<link rel="stylesheet" type="text/css" href="http://education.natural-europe.eu/test2/themes/natural/css/content.css"/> 

<link rel="stylesheet" type="text/css" href="http://education.natural-europe.eu/test2/themes/natural/css/section.css" />

<div style="width:510px; font-family:Arial, sans-serif;">

<div style="float:left;"><a href="<?php echo uri('home')?>" title="Home"><img border="0" src="<?php echo uri('themes/natural/images/logo.png')?>" alt="Mantis" id="page-logo" /></a></div> 
<div style="float:left; padding-top:60px;left:330px; position:absolute;"><A HREF="javascript:window.print()">Click to Print This Page&nbsp;&nbsp;<img src="<?php echo uri('themes/natural/images/print.gif')?>" border="0"></A></div>
<div style="clear:both;"></div>
<hr style="color:#CCCCCC;">


<h1><?php echo h($exhibit->title); ?></h1>
<div class="column" id="column-d">
	<div id="content-exhibit">
		<?php 
		foreach ($exhibit->Sections as $key => $section) {
		?> 
		<div>
		<?php
		echo "<h2>".($section->title)."</h2><br>";
		exhibit_section_text($exhibit->id,$section->slug); 
		echo  exhibit_picture($exhibit->id,'100','print',$section->slug); ?>
		</div>
		<?php } ?>
	</div>
</div><!-- end div.column #column-b -->

</div> 