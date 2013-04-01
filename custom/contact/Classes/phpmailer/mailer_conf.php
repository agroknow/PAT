<?php
function create_phpmailer(){
        require_once('class.phpmailer.php');
	require_once("class.smtp.php");
		
	class m6sMailer extends PHPMailer {  
		 // Set default variables for all new objects  
		 var $From     = "dim_mexis@yahoo.gr";
		 var $FromName = "Dimitris Mexis";  
		 var $Host     = "smtp.mail.yahoo.gr";
		 var $Mailer   = "smtp"; // Alternative to IsSMTP() 
		 var $SMTPAuth = true;
		 var $Username = "dim_mexis";
		 var $Password = "9429573";
	}
	return true;
}

function send_email($reply_to, $to, $nameto, $subject, $message, $format){	   
	$mail = new m6sMailer();
	if ( $format == "1" ){
	 	$mail->IsHTML(true); //sending in html format
		$mail->MsgHTML($message);
	}
	else{
		$h2t =& new html2text($message);
		$message = $h2t->get_text(); 
	}
	if ( strlen($from)>3 ){
		$mail->From = $from;
	}
	
	$mail->AddReplyTo($reply_to);
	
	for ( $i=0;$i<count($to);$i++ ){
		$mail->AddAddress($to[$i],$nameto[$i]);
	}
	
	//$mail->AddAddress('dim_mexis@yahoo.gr','Mexis');
	  
	$mail->Subject  = $subject;  
	$mail->Body     = $message;
	   
	if ( !$mail->Send() ) {  
	  	//echo 'Message was not sent.';  
	 	//echo 'Mailer error: ' . $mail->ErrorInfo; 
		return false; 
	} 
	else {  
	   //echo 'Message has been sent.'; 
	   return true;
	}
}
?>