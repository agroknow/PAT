<?php
session_start();

require_once("../../include/conf.php");
require_once("../Classes/phpmailer/mailer_conf.php");
require_once("../Classes/class.html2text.php");

$reply_to=$_GET["from_email"];
$subject=$_GET["subject"];
$message=$_GET["message"];

$requested_path=$_SESSION["contact_for"];
$message.="<br><br><small><b><u>For the Exhibit:</u></b></small><br>".
	    "<small>".$requested_path."</small>";

create_phpmailer();
$flag_send = send_email($reply_to, $EMAIL_TO, $EMAIL_NAME_TO, $subject, $message, $EMAIL_FORMAT);

$flag_send=true;

echo $flag_send;
?>