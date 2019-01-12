<?php 



$to = 'maniprakashpalani@gmail.com';

$subject = 'Website Change Reqest';

$headers = "From: admin@livebeds.com\r\n";
$headers .= "Reply-To: suresh@travelinsert.com\r\n";
$headers .= "CC: suresu89@gmail.com\r\n";
$headers .= "MIME-Version: 1.0\r\n";
$headers .= "Content-Type: text/html; charset=UTF-8\r\n";

$message = '<p><strong>This is strong text</strong> while this is not.</p>';


$mail_to = mail($to, $subject, $message, $headers);

if($mail_to){
echo 'send';

}else{
	
	echo 'No';
	}



?>