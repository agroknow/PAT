<?php

require_once('./custom/include/conf.php');


require_once("./custom/include/db_connect.php");  
$path_db="./application/config/db.ini";
db_connect($path_db);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title></title>
<?php $jquery_script="<script type='text/javascript' src='./custom/js/jquery-1.3.2.js'></script> ";
echo $jquery_script;
?>
<link rel="stylesheet" type="text/css" href="./custom/threads/css/threadscss.css" />


  <script type="text/javascript" src="http://dev.jquery.com/view/trunk/plugins/validate/jquery.validate.js"></script>

<script src="./custom/threads/js/jquery.counter.js" type="text/javascript"></script>
    <script type="text/javascript">
        $(function() {

            $("#default_usage").counter();
            $("#thread_text").counter({
                count: 'up',
                goal: 500
            });
		$(".button").click(function() { 

		    // validate and process form here
			var dataString = document.getElementById('thread_text'); 
			
          if(dataString.value==''){ alert("Please enter a text.."); } 
		  
		   else{ 

				$.ajax({  
    			type: "POST",  
    			url: "./custom/threads/thread_reply.php",  
    			//data: dataString,  
			   	data: $("#thread").serialize(),
				success: function() {  
      				$('#thread_form').html("<div id='message'></div>");  
      				$('#message').html("<h2>Contact Form Submitted!</h2>")  
      				.append("<p>We will be in touch soon.</p>") 
      				//.hide()
    			}  			
  			}); 
			} //else if it is keno
			return false;  
			});
    
        });
    </script>

</head>
<body>
<?php

$uid=$user;
$sql="SELECT a.text, unix_timestamp(a.post_date) AS post_date_tmp, b.username FROM omeka_threads a 
	  INNER JOIN omeka_users b ON a.user_id=b.id
	  WHERE a.exhibit_id=".$_GET['eid']." AND is_active='1' ORDER BY post_date desc";
$res=mysql_query($sql);

$content='<table border="0" width="100%">';


		$content_form ='<tr><td colspan="2"><strong>Discuss this exhibit</strong></td></tr>';
		$content_form.='<tr><td colspan="2">
									<div id="thread_form">
									<form id="thread" method="POST">
									<input type="hidden" name="uid" id="uid" value="'.$uid.'"/>
									<br/>
									<input type="hidden" name="thread_id" id="thread_id" value="'.$_GET['thread_id'].'"/>
									<input type="hidden" name="eid" id="eid" value="'.$_GET['eid'].'"/>
									<br/>
									<textarea rows="5" cols="80" id="thread_text" name="thread_text"></textarea>
									<br/>
									<input type="submit" name="submit" class="button" id="submit_btn" value="Send" />
									</form>
									</div>
		
		</td></tr>
		<tr><td colspan="2">&nbsp;</td></tr>
		<tr><td colspan="2">&nbsp;</td></tr>
		<tr><td colspan="2">&nbsp;</td></tr>';
		
		echo $content_form;

$content.='</table>';
echo $content;

// To retrieve the logged user you can use the following
//echo current_user()->first_name;
?>
</body>