<?php
session_start();

require_once("../../include/conf.php");
require_once("../Classes/phpmailer/mailer_conf.php");
require_once("../Classes/class.html2text.php");

$reply_to=$_GET["from_email"];
$subject=$_GET["subject"];
$message=$_GET["message"];
$from_id=$_GET["from_id"];

$svar=$_GET["from_id"];
 $strc='@';
$str=strpos($svar,$strc);

if ($str!=true)   {$from_id='stoitsis@gmail.com,public@lists.e-knownet.eu';} 
			  
				  

create_phpmailer();
//$flag_send = send_email($reply_to, $EMAIL_TO, $EMAIL_NAME_TO, $subject, $message, $EMAIL_FORMAT);
// This is how omeka sends an email using Zend framework

$from = ''.$reply_to;
		$body =$message;
		$title =$subject;
		$header = 'From: '.$from. "\n" . 'X-Mailer: PHP/' . phpversion();
		$flag=mail($from_id, $title, $body, $header);
        echo $flag;

$flag_send=true;

//echo $flag_send;
?>