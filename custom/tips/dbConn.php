<?php

 $con=mysql_connect("localhost","root","r00t!") or die('Not connected : ' . mysql_error());
 mysql_select_db("natural_europe") or die ('Cannot select Database: ' . mysql_error());	

  mysql_query("SET NAMES 'utf8'");	



?> 