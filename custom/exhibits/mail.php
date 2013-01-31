	<?php
		  //change this to your email.

    $to = 'gkista@yahoo.gr';
$_POST["email"]= 'gkista@agroknow.gr';


    $subject = "Contact us";



	$headers = 'MIME-Version: 1.0' . "\r\n";

    $headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";

	$headers .= 'From: <'.$_POST["email"].'>' . "\r\n";



    //options to send to cc+bcc

    //$headers .= "Cc: [email]maa@p-i-s.cXom[/email]";

    //$headers .= "Bcc: [email]email@maaking.cXom[/email]";

	

$message = "

<html>

<body>

<h2>Contact form.</h2>

<p></p><br>

<table border='0'>

<tr> ";



$message .= "123123";





$message .= "

</tr>

</table>

</body>

</html>

";







    // now lets send the email.

    mail($to, $subject, $message, $headers);    
	?>