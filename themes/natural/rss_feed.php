<?php head(array('title'=>'RSS feed')); ?>
<div id="page-body" class="one_column">
<?php include ("common/menu.php") ?>
<div class="column" id="column-c">	
<h1 class="section_title">ScienceTweets RSS Feeds</h1>
<div class="rss_links">
	<a href="<?php echo uri('rss?rss=exhibits'); ?>">Exhibits <img src="./themes/natural/images/xml.jpg" /></a>
</div>
<div class="rss_links">
	<a href="<?php echo uri('rss?rss=collections'); ?>">Collections <img src="./themes/natural/images/xml.jpg" /></a>
</div>
<p class="bold">What is RSS?</p>
<p>RSS (Really Simple Syndication) is an easy way to keep up with favorite ScienceTweets information. An RSS feed contains headlines, summaries and links to full content. RSS is written in the Internet coding language known as XML (eXtensible Markup Language).</p>
</div>

<div class="clear"></div><!--clear DIV NEEDS TO BE ADDED TO ALL TEMPLATES-->
</div><!--end page-body div-->
<div class="clear"></div><!--clear DIV NEEDS TO BE ADDED TO ALL TEMPLATES-->
</div><!--end page-container div-->
<?php foot(); ?>