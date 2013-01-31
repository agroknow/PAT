<?php head(array('title'=>'About')); ?>
<script type="text/javascript"">
	window.onload = function() {
		preloadAll();
		hideAll();
		show('m07');
	}
</script>
		<ul id="submenu3">
		<?php

			echo('<li class="selected" id="item_01"><a href="'.('http://'.$_SERVER['HTTP_HOST'].'/portal/material/').'">Science education <br> reference material</a></li>
				<li id="item_02"><a href="'.('http://'.$_SERVER['HTTP_HOST'].'/portal/material/').'">Science communication <br> reference material</a></li>
				');
		?>	
			
		</ul>
		
		<ul id="do">
		<li>&nbsp;</li>
		<li><a href="#" onmouseover="img('do03', 'do03_on');showShare('share');return false;" onmouseout="img('do03', 'do03_off')"><img src="./themes/natural/images/do_share_off.png" width="36" height="47" alt="" name="do03"> Share</a></li>
		</ul>
		
		<div id="share" style="display: none;">
		<div class="container">
		<a class="title" onclick="hideShare('share');return false;" href="#">Close</a>
		<br/>
		<div id="share-sites"><div>
				<a onclick="window.location = 'http://www.reddit.com/submit?url=' + encodeURIComponent(window.location); return false" href="http://www.reddit.com/submit">
				<img border="0" width="20" alt="submit to reddit" src="http://education.natural-europe.eu/portal/themes/natural/images/social/tools_reddit.gif"/>
				reddit
				</a>
				</div>
				<div>
				<a onclick="window.location = 'http://slashdot.org/slashdot-it.pl?op=basic&url='+encodeURIComponent(window.location);return false;" href="http://slashdot.org/slashdot-it.pl">
				<img border="0" width="24" alt="Slashdot" src="http://education.natural-europe.eu/portal/themes/natural/images/social/tools_slashdot.gif"/>
				Slashdot
				</a>
				</div>
				<div>
				<a onclick="window.location = 'http://digg.com/submit?url='+encodeURIComponent(location.href); return false;" href="http://digg.com/">
				<img width="24" alt="Digg!" src="http://education.natural-europe.eu/portal/themes/natural/images/social/tools_digg.jpg"/>
				Digg
				</a>
				</div>
				<div>
				<a onclick="window.location = 'http://www.stumbleupon.com/submit?url='+encodeURIComponent(window.location);return false;" href="http://www.stumbleupon.com">
				<img border="0" width="24" alt="StumbleUpon" src="http://education.natural-europe.eu/portal/themes/natural/images/social/tools_stumbleupon.jpg"/>
				StumbleUpon
				</a>
				</div>
				<div>
				<a onclick="window.open('http://delicious.com/save?v=5&noui&jump=close&url='+encodeURIComponent(location.href)+'&title='+encodeURIComponent(document.title), 'delicious','toolbar=no,width=550,height=550'); return false;" href="http://www.delicious.com">
				<img border="0" width="24" alt="delicious" src="http://education.natural-europe.eu/portal/themes/natural/images/social/tools_delicious.gif"/>
				delicious
				</a>
				</div>
				<script>
				function fbs_click() {u=location.href;t=document.title;window.open('http://www.facebook.com/sharer.php?u='+encodeURIComponent(u)+'&t='+encodeURIComponent(t),'sharer','toolbar=0,status=0,width=626,height=436');return false;}
				</script>
				<div>
				<a target="_blank" onclick="return fbs_click()" href="http://www.facebook.com/share.php?u=<url>">
				<img width="24" alt="Facebook" src="http://education.natural-europe.eu/portal/themes/natural/images/social/tools_facebook.gif"/>
				Facebook
				</a>
				</div>
				</div>
				</div>
		</div>
		
		<div id="patch_top"></div>
		<div id="patch_bottom"></div>
		<div id="patch_resources"></div>
		
		<div id="h1_wrapper_home0"><h1>{Material}</h1></div>
		
		<div id="h4_wrapper"><h4>
		
		<?php
	//show letters
	$lettersarray= range ( 'A' , 'Z' );
           foreach($lettersarray as $letter) {                     

                echo ("<a href=http://education.natural-europe.eu/natural_europe/glossary?letter=$letter> $letter </a>");    

}
echo "<a href=http://education.natural-europe.eu/natural_europe/glossary> / All</a>";
//end show letters

?>	

</h4></div>
		<div id="content" style="overflow:auto; width:570px; height:310px; text-align:center;">
		
		</div>
		<ul id="videolinks">
		<li><div class="dialog">
		 <div class="content">
		  <div class="t"></div>
			<a href="#"><img src="./themes/natural/images/videolink_01.jpg" width="48" height="48" alt="" class="corner iradius4"></a>
		 </div>
		 <div class="b"><div></div></div>
		</div></li>
		<li><div class="dialog">
		 <div class="content">
		  <div class="t"></div>
			<a href="#"><img src="./themes/natural/images/videolink_02.jpg" width="48" height="48" alt="" class="corner iradius4"></a>
		 </div>
		 <div class="b"><div></div></div>
		</div></li>
		<li><div class="dialog">
		 <div class="content">
		  <div class="t"></div>
			<a href="#"><img src="./themes/natural/images/videolink_03.jpg" width="48" height="48" alt="" class="corner iradius4"></a>
		 </div>
		 <div class="b"><div></div></div>
		</div></li>
		<li><div class="dialog">
		 <div class="content">
		  <div class="t"></div>
			<a href="#"><img src="./themes/natural/images/videolink_04.jpg" width="48" height="48" alt="" class="corner iradius4"></a>
		 </div>
		 <div class="b"><div></div></div>
		</div></li>
		</ul>
		
		<ul id="resources_home">
		<li><a onclick="getItemLinks(this)" id="tabLinks" name="Protein/p53/Other methods/p. protein representations/p. enzyme Adenylate Kinase"  href="javascript:void(0);">Links</a></li>
		<li><a onclick="getItemImages(this)" id="tabImages" name="Protein/p53/Other methods/p. protein representations/p. enzyme Adenylate Kinase" href="javascript:void(0);">Images</a></li>
		<li><a onclick="getItemVideo(this)" id="tabVideo" name="Protein/p53/Other methods/p. protein representations/p. enzyme Adenylate Kinases" href="javascript:void(0);">Video</a></li>
		<li><a onclick="getItemGames(this)" id="tabGames/Activities" name="Protein/p53/Other methods/p. protein representations/p. enzyme Adenylate Kinase" href="javascript:void(0);">Games/Activities</a></li>
		</ul>
		
		<div id="info_full">
		<p>"Voyage to the heart of a cell"<br />
		Structure / Shapes / Role<br />
		<a href="#">Proteins, the chemistry of life</a></p>
		</div>
<?php foot(); ?>