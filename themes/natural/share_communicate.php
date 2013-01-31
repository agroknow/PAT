<?php head(array('title'=>'Connect With ScienceTweets on Social Networking Sites')); ?>
<div id="page-body" class="one_column">
<?php include ("common/menu.php") ?>


<div class="column" id="column-c">
<h1 class="section_title">Connect With ScienceTweets on Social Networking Sites</h1>
<script language="javascript"> 
function twitter() {
	var ele = document.getElementById("twitter");
	if(ele.style.display == "block") {
    		ele.style.display = "none";
	
  	}
	else {
		ele.style.display = "block";
	
	}
} 

function facebook() {
	var ele = document.getElementById("facebook");
	if(ele.style.display == "block") {
    		ele.style.display = "none";
	
  	}
	else {
		ele.style.display = "block";
	
	}
} 

function youtube() {
	var ele = document.getElementById("youtube");
	if(ele.style.display == "block") {
    		ele.style.display = "none";
	
  	}
	else {
		ele.style.display = "block";
	
	}
} 
</script>


<ul>
<li><a href="javascript:twitter();"><img src="<?php echo uri('themes/natural/images/twitter.jpg')?>" alt=""></a>
<ul><li id="twitter" style="display: none;"><a href="http://twitter.com/sciencetweets" target="_blank">http://twitter.com/sciencetweets</a></li></ul>


</li>
<br />

		
<li><a href="javascript:facebook();" ><img src="<?php echo uri('themes/natural/images/facebook.jpg')?>" alt=""></a></li>
<ul><li id="facebook" style="display: none;"><a href="http://www.facebook.com/pages/ScienceTweets/130443697017413?v=wall" target="_blank">http://www.facebook.com/pages/ScienceTweets/130443697017413?v=wall</a></li></ul>
<br />
<li><a href="javascript:youtube();" ><img src="<?php echo uri('themes/natural/images/youtube.jpg')?>" alt=""></a></li>
<ul><li id="youtube" style="display: none;"><a href="http://www.youtube.com/ScienceTweets" target="_blank">http://www.youtube.com/ScienceTweets</a></li></ul>
</ul>

		
</div><!-- end div.content-->	

<div class="clear"></div><!--clear DIV NEEDS TO BE ADDED TO ALL TEMPLATES-->
</div><!--end page-body div-->
<div class="clear"></div><!--clear DIV NEEDS TO BE ADDED TO ALL TEMPLATES-->
</div><!--end page-container div-->
<?php foot(); ?>