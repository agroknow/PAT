<?php head();?>
<div id="page-body" class="two_column">
<?php include ("common/menu.php") ?>

<div class="column" id="column-d">
<h1 class="section_title index">Science Tweets on... natural_europe</h1>

<div class="flash_animation">
		<script type='text/javascript' src='http://education.natural-europe.eu/test2/archive/player/swfobject.js'></script>
		<div id='mediaspace1'>This text will be replaced</div>
		<script type='text/javascript'>
		  var so1 = new SWFObject('http://education.natural-europe.eu/test2/archive/player/player.swf','mpl','424','200','9');
		  so1.addParam('allowfullscreen','true');
		  so1.addParam('allowscriptaccess','always');
		  so1.addParam('wmode','opaque');
		  so1.addParam('allowscriptaccess','always');
		  so1.addVariable('viral.onpause','false');
		  so1.addParam('wmode','transparent');

          so1.addVariable('viral.oncomplete','false');
		  so1.addVariable('icons','false');
		  so1.addVariable('controlbar','none');
		  so1.addVariable('autostart','true');
		  so1.addVariable('start','1');
		  so1.addVariable('repeat','always');
		  so1.addVariable('stretching','fill');
		  so1.addVariable('image','http://www.westsideomaha.org/images/stories/frontpage/snippetimages/1.jpg');
		  so1.addVariable('file','http://education.natural-europe.eu/development/themes/natural/flashanimation/sciencetweets.flv');
		  
		  so1.write('mediaspace1');
		  
		</script>
		
		 </div><!--end flash_animation--->


	<div class="intro-text">
        <p>Welcome to the ScienceTweets on natural_europe platform, 
a collaborative initiative of the <a href="<?php echo uri('project?section=home')?>">e-Knownet project.</a></p>
		<p>This platform was developed by a <a href="<?php echo uri('network?section=home')?>">network of contributors</a> hoping to promote fast and efficient sharing of new scientific knowledge with the rest of society.</p> 
      	</div><!--end intro-text div-->
       	<div class="clear"></div>
       	<dl class="intro-text">
	       <dt>This platform is relevant for you, if you are:</dt>
               <dd class="students">- a <a href="<?php echo uri('index?target=students')?>">Student</a></dd>
               <dd class="lifelong_learners">- a <a href="<?php echo uri('index')?>">Lifelong Learner</a></dd>
               <dd class="science_educators">- a <a href="<?php echo uri('index?target=educators')?>">Science Educator</a>, or anyone involved in science museum education</dd>
               <dd class="researchers">- a <a href="<?php echo uri('index?target=researchers')?>">Researcher</a> in natural_europe</dd>
       	</dl>
        <div class="quick_links index">
        	<p>Here you can:</p>
            <ul>
            	<li class="left">
                    <p><span class="first_word">Explore</span> engaging learning material in the form of digital exhibits and web collections and learn more about natural_europe.</p>
                    <p><span class="first_word">Develop</span> digital resources that tell your own natural_europe 'story', for your own enjoyment, to share with friends and colleagues, or for learning purposes, especially if you work in science education, at school or in a non-formal learning environment (e.g. a science museum).</p>
                    <p><span class="first_word">Discover</span> a wealth of educational and entertaining digital resources, such as information links, images and videos, interactive games, and lots more...</p>
                </li>
                <li class="right">
                	<p><span class="first_word">Share</span> relevant digital material developed by you or resources which you discovered on the web. If you are a natural_europe expert you have the opportunity to share you research findings with non-experts in a creating and entertaining way: you can develop your own exhibit using a simple editorial tool provided by ScienceTweets.</p>
                    <p><span class="first_word">Communicate</span> with people and learning communities that share the same interests with you.</p>
                    <p><span class="first_word">Vote</span> for the most engaging exhibits and other resources, post your comments and suggestions, and help scientists communicate their ideas!</p>
                </li>
            </ul>
        </div><!--end quick_links div-->
</div><!--end columnD div-->


<div class="column" id="column-e">
        <div class="panel sidebar">
        <ul class="videos">
        <li>
        	<h2 class="descriptive_title">Interview with Dr. Dimitra Markovitsi<br>Head of the Francis Perrin Laboratory
<br>President of the European natural_europe Association 2007- 2010</h2>
			<script type='text/javascript' src='http://education.natural-europe.eu/test2/archive/player/swfobject.js'></script>
			<div id='mediaspace'>This text will be replaced</div>
			<script type='text/javascript'>
			  var so = new SWFObject('http://education.natural-europe.eu/test2/archive/player/player.swf','mpl','230','190','9');
			  so.addParam('allowfullscreen','true');
			  so.addParam('allowscriptaccess','always');
			  so.addParam('wmode','opaque');
			  so.addVariable('stretching','fill');
			  so.addVariable('icons','false');
			  so.addVariable('image','http://education.natural-europe.eu/natural_europe/archive/files/Markovitsi_mask.jpg');
			  so.addVariable('file','http://education.natural-europe.eu/natural_europe/archive/files/evlalia_markovitsh_idryma_finalsmall_4ace2cc760.mp4?frame=11');
			  so.write('mediaspace');
			</script>
        </li>
        <li>
        	<h2 class="descriptive_title"><a href="http://education.natural-europe.eu/natural_europe/archive/files/00___cedis_introani_ve_0d344966c4.swf" target="_blank" class="lightview" title=" :: :: width: 720, height: 540">Introduction into
natural_europe</a></h2>
			<a href="http://education.natural-europe.eu/natural_europe/archive/files/00___cedis_introani_ve_0d344966c4.swf" target="_blank" class="lightview" title=" :: :: width: 720, height: 540"><img src="<?php echo uri('themes/natural/images/Intro_video_fub_mask.jpg'); ?>"/></a>
        </li>
        </ul>
         </div><!--end panel sidebar div-->
</div><!--end columnE div-->
<div class="clear"></div><!--clear DIV NEEDS TO BE ADDED TO ALL TEMPLATES-->
</div><!--end page-body div-->
<div class="clear"></div><!--clear DIV NEEDS TO BE ADDED TO ALL TEMPLATES-->
</div><!--end page-container div-->
<?php foot(); ?>