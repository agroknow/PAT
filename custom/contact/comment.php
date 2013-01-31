<?php
session_start();
require_once("../include/conf.php");
require_once("Classes/phpmailer/mailer_conf.php");

?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Omeka Admin: e-KNOWNET portal | Exhibit Page</title>

<!-- Meta -->
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<!-- Stylesheets -->
<link rel="stylesheet" media="screen" href="http://education.natural-europe.eu/natural_europe/admin/themes/default/css/screen3.css" />
<link rel="stylesheet" media="print" href="http://education.natural-europe.eu/natural_europe/admin/themes/default/css/print.css" />
<link rel="stylesheet" media="screen" href="http://education.natural-europe.eu/natural_europe/admin/themes/default/css/niftyCorners.css" />
<link rel="stylesheet" media="screen" href="http://education.natural-europe.eu/natural_europe/shared/exhibit_layouts/text-image-right/layout.css" />

<?php
		

		$jvalidate_script="<script type='text/javascript' src='".$JVAL_PATH."jquery.validate.js'></script> ".
				"<script type='text/javascript' src='".$JVAL_PATH."send_message.js'></script> ".				
				"<link rel='stylesheet' type='text/css' href='".$JVAL_PATH."jquery.validate.css'> ";
                                        
                $jquery_script="<script type='text/javascript' src='".$JQUERY_BASE."jquery-1.3.2.js'></script> ";
                
                $custom_scripts="<script type='text/javascript' src='".$CUSTOM_SCRIPTS_BASE."scripts.js'></script> ";
                
                
                $scripts="";
                $scripts.=$jquery_script.$jvalidate_script.$custom_scripts;
                
                echo $scripts;

?>
</head>
<body style="width:400px;">

<form name="send-message-form" id="send-message-form" method="post">


<div id="content">
<div style="width:400px; padding-left: 10px;"><p>
Please send us your comments on any aspect of this article or topic you think can be improved. The editorial team of ScienceTweets will review your comment and consider the changes you have suggested. Please be as specific as possible when referring to any errors or discrepancies. (And if you really liked the article, you can let us know that too!)
</p></div>
<div id="primary">



<?php
session_start();

// Write a function that will: 
// 1. check if user is logged in

//return_user();

// 2. check the user indentity
//  Use the USerController of OMEKA and Zend


    require_once("../include/db_connect.php");  
    
    $path_db="../../application/config/db.ini";
    db_connect($path_db);
    
    echo '<div id="result_send" style="display: none;">';
    echo '</div>';
    
    echo "From (Email): ";
    echo "<br>";
    echo '<input type="text" id="email" name="email" class="textinput" cols="50">';
    echo "<br>";
    echo "Subject: ";
    echo "<br>";
    echo '<input type="text" id="subject" name="subject" class="textinput" cols="50">';
    echo "<br>";
    echo "Comment: ";
    echo "<br>";
    echo '<textarea id="message" name="message" rows="15" class="textinput" cols="55">';
    
    
    echo '</textarea>';

    
    echo '<br><br>';
    
    echo '<p id="page-submits">';

    echo '<input type="button" onClick="return sendEmail();" name="send" id="send" value="Send" style="margin-right: 10px;">';
    echo '<input type="button" onClick="return Close();" name="cancel" id="cancel" value="Cancel">';
    
    echo "</p>";
    
    echo '<input type="hidden" name="item_title_hid" id="item_title_hid" >';



?>
</div>
</div>
</form>
</body>
</html>