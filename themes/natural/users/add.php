<?php head();?>
<?php //common('users-nav'); ?>
<div id="page-body">
<div id="nav-breadcrumbs"> You are here:
      <ul id="nav-breadcrumbs-menu">

			<li><a href="/index.html">Home</a></li>
			<li> &gt; </li>            		
        </ul>	
	</div>


<div class="column" id="column-c">
 <h1 class="section_title">Natural Europe Registration Form</h1>
 <h2 class="section_sub_title">Enter your information below</h2>	
			<div id="form_container">
<form method="post" id="new-user-form" accept-charset="utf-8">
<?php include('form.php'); ?>
<input class="submit" type="submit" name="submit" value="Add this User"/>
</form>
</div>
</div>
</div><!-- end div.content-->	
</div> <!-- end div #page-body -->
<?php foot();?>