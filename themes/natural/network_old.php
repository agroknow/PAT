<?php head(array('title'=>'About')); ?>
<script type="text/javascript">
	window.onload = function() {
		preloadAll();
		hideAll();
		show('m02');
	}
</script>
		
		<ul id="do">
		<li><a href="#" onmouseover="img('do05', 'do05_on')" onmouseout="img('do05', 'do05_off')"><img src="./themes/natural/images/do_learn_off.png" width="36" height="47" alt="" name="do05"> Learn</a></li>
		<li><a href="#" onmouseover="img('do02', 'do02_on')" onmouseout="img('do02', 'do02_off')"><img src="./themes/natural/images/do_discuss_off.png" width="36" height="47" alt="" name="do02"> Discuss</a></li>
		<li><a href="#" onmouseover="img('do03', 'do03_on')" onclick="showShare('share');return false;" onmouseout="img('do03', 'do03_off')"><img src="./themes/natural/images/do_share_off.png" width="36" height="47" alt="" name="do03"> Share</a></li>
		<li><a href="#" onmouseover="img('do06', 'do06_on')" onmouseout="img('do06', 'do06_off')"><img src="./themes/natural/images/do_experiment_off.png" width="36" height="47" alt="" name="do06"> Experiment</a></li>
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
		
		<div id="h1_wrapper_home0"><h1>The Network</h1></div>
		<div id="h4_wrapper"><h4>&nbsp;</h4></div>
		<div id="homephoto"><img src="./themes/natural/images/Network_Grid.jpg" width="660" height="288" alt=""></div>
		<?php 
			// Call the php file or the function that performs queries to retrieve all the content according to the type
		?>
		<div id="content">
		<div id="partenariat">PARTENARIAT</div>
		<div id="supporters">ACTIVE USERS - SUPPORTERS</div>
		<div id="EF"><a onclick="showShare('EF_info');return false;" href="#">E.F.</a></div>
		<div id="GRNET"><a onclick="showShare('GRNET_info');return false;" href="#">GRNET</a></div>
		<div id="FPL"><a onclick="showShare('FPL_info');return false;" href="#">FPL/CEA-CNRS</a></div>
		<div id="FUB"><a onclick="showShare('FUB_info');return false;" href="#">CeDiS/FUB</a></div>
		<div id="UPF"><a onclick="showShare('UPF_info');return false;" href="#">OCC/UPF</a></div>
		<div id="EPA"><a onclick="showShare('EPA_info');return false;" href="#">EPA</a></div>
		<div id="TPCI"><a onclick="showShare('TPCI_info');return false;" href="#">TPCI</a></div>
		<div id="EEF"><a onclick="showShare('EEF_info');return false;" href="#">EEF</a></div>
		<div id="ETPE"><a onclick="showShare('ETPE_info');return false;" href="#">ETPE</a></div>
		</div>
		<div id="EF_info" style="display: none;">
		<div class="container">
		<a class="title" onclick="hideShare('EF_info');return false;" href="#">Close</a>
		<br/>
		<div id="share-sites">
				<div>
				Eugenides Foundation, Greece <br>(<a href="http://www.eugenfound.edu.gr">http://www.eugenfound.edu.gr</a>)
				</div>
				<div> The Eugenides Foundation ...........................
				</div>
		</div>
		</div>
		</div>
		<div id="GRNET_info" style="display: none;">
		<div class="container">
		<a class="title" onclick="hideShare('GRNET_info');return false;" href="#">Close</a>
		<br/>
		<div id="share-sites">
				<div>
				Greek Research and Technology Network, Greece <br>(<a href="http://www.eugenfound.edu.gr">http://www.eugenfound.edu.gr</a>)
				</div>
				<div> Greek Research and Technology Network ...........................
				</div>
		</div>
		</div>
		</div>
		<div id="FPL_info" style="display: none;">
		<div class="container">
		<a class="title" onclick="hideShare('FPL_info');return false;" href="#">Close</a>
		<br/>
		<div id="share-sites">
				<div>
				The Francis Perrin Laboratory (LFP), Science Content Source, France <br>(<a href="http://www-lfp.cea.fr/?lang=ang" target="_blank">http://www-lfp.cea.fr/?lang=ang</a>)
				</div>
				<div> The Francis Perrin Laboratory (LFP) is a joint research unit (URA 2453) of the Atomic Energy Commissariat (CEA) and the National Center for the Scientific Research (CNRS). It has about thirty permanent research scientists and technicians; some twenty PhD students and post-docs are trained there. 
					The laboratory is part of the Service des Photons, Atomes et Molecules (SPAM) of the Institut of (IRAMIS) and is located in the research center of the CEA Saclay.
				</div>
				<div>Director: <a href="http://iramis.cea.fr/Pisp/18/dimitra.markovitsi.html" target="_blank">Dimitra Markovitsi</div>
		</div>
		</div>
		</div>
		<div id="FUB_info" style="display: none;">
		<div class="container">
		<a class="title" onclick="hideShare('FUB_info');return false;" href="#">Close</a>
		<br/>
		<div id="share-sites">
				<div>
				CeDiS / FUB (DE) (ICT expertise)
				Center for Digital Systems / Freie Universitaet Berlin, Germany
				</div>
				<div> ...........................
				</div>
		</div>
		</div>
		</div>
		<div id="UPF_info" style="display: none;">
		<div class="container">
		<a class="title" onclick="hideShare('UPF_info');return false;" href="#">Close</a>
		<br/>
		<div id="share-sites">
				<div>
				OCC / UPF (ES) (science communication)
				Science Communication Observatory / University Pompeu Fabra, Spain
				</div>
				<div> ...........................
				</div>
		</div>
		</div>
		</div>
		<div id="EPA_info" style="display: none;">
		<div class="container">
		<a class="title" onclick="hideShare('EPA_info');return false;" href="#">Close</a>
		<br/>
		<div id="share-sites">
				<div>
				EPA (science content source)<br>
				European natural_europe Association (<a href="http://www.natural_europe.eu/" target="_blank">http://www.natural_europe.eu/</a>)</div>
				<div> &nbsp;</div>
		</div>
		</div>
		</div>
		<div id="TPCI_info" style="display: none;">
		<div class="container">
		<a class="title" onclick="hideShare('TPCI_info');return false;" href="#">Close</a>
		<br/>
		<div id="share-sites">
				<div>
				Theoretical and Physical Chemistry Institute (<a href="http://www.eie.gr/nhrf/institutes/tpci/index-en.html" target="_blank">http://www.eie.gr/nhrf/institutes/tpci/index-en.html</a>)
				<br><a href="http://www.e-yliko.gr/" target="_blank">http://www.e-yliko.gr/</a> (science dissemination)<br>
				The Hellenic Ministry of Education Official Educational Portal
				</div>
				<div> TPCI contributed in the following exhibits:
				<ul>
					<li><a href="http://education.natural-europe.eu/natural_europe/exhibits/protein-folding/to-begin-with" target="_blank">Protein Folding</a></li>
					<li><a href="http://education.natural-europe.eu/natural_europe/exhibits/protein-folding/to-begin-with" target="_blank">Protein Folding</a></li>
				</ul>
				</div>
		</div>
		</div>
		</div>
		<div id="EEF_info" style="display: none;">
		<div class="container">
		<a class="title" onclick="hideShare('EEF_info');return false;" href="#">Close</a>
		<br/>
		<div id="share-sites">
				<div>
				EEF (science communication)
				<br>Hellenic Physical Society (<a href="http://www.eef.gr/" target="_blank">http://www.eef.gr/</a>)
				</div>
				<div> EEF contributed in the following exhibits:
				<ul>
					<li><a href="http://education.natural-europe.eu/natural_europe/exhibits/protein-folding/to-begin-with" target="_blank">Protein Folding</a></li>
					<li><a href="http://education.natural-europe.eu/natural_europe/exhibits/protein-folding/to-begin-with" target="_blank">Protein Folding</a></li>
				</ul>
				</div>
		</div>
		</div>
		</div>
		<div id="ETPE_info" style="display: none;">
		<div class="container">
		<a class="title" onclick="hideShare('ETPE_info');return false;" href="#">Close</a>
		<br/>
		<div id="share-sites">
				<div>
				ETPE (science education)<br>
				Greek Scientific Association of Information and Communications Technologies in Education (<a href="http://www.etpe.gr/" target="_blank">http://www.etpe.gr/</a>)
				</div>
				<div> ETPE contributed in the following exhibits:
				<ul>
					<li><a href="http://education.natural-europe.eu/natural_europe/exhibits/protein-folding/to-begin-with" target="_blank">Protein Folding</a></li>
					<li><a href="http://education.natural-europe.eu/natural_europe/exhibits/protein-folding/to-begin-with" target="_blank">Protein Folding</a></li>
				</ul>
				</div>
		</div>
		</div>
		</div>

<?php foot(); ?>