<?php 

/*$user = 'a8f59bf51803d0f189b76cbf45ecff2e';
$password = 'jRTLGatyuxRx';

$post_string = array('xml'=>'<Request>
<Head>
<Username>'.$user.'</Username>
<Password>'.$password.'</Password>
<RequestType>GetHotels</RequestType>
</Head>
<Body>
<CountryCode>GB</CountryCode>
</Body>
</Request>');

$soap_do = curl_init(); 
curl_setopt($soap_do, CURLOPT_URL,            $url );
curl_setopt($soap_do, CURLOPT_CONNECTTIMEOUT, 30); 
curl_setopt($soap_do, CURLOPT_TIMEOUT,        30); 
curl_setopt($soap_do, CURLOPT_RETURNTRANSFER, true );
curl_setopt($soap_do, CURLOPT_SSL_VERIFYPEER, false);  
curl_setopt($soap_do, CURLOPT_SSL_VERIFYHOST, false); 
curl_setopt($soap_do, CURLOPT_POST,           true ); 
curl_setopt($soap_do, CURLOPT_POSTFIELDS,     http_build_query($post_string));
curl_setopt($soap_do, CURLOPT_HTTPHEADER,     array('Content-Type: application/x-www-form-urlencoded'));
//curl_setopt($soap_do, CURLOPT_USERPWD, $user . ":" . $password);
$result = curl_exec($soap_do);



$response = preg_replace("/(<\/?)(\w+):([^>]*>)/", "$1$2$3", $result);
$request =  json_decode($response);

$xmlo = new \SimpleXMLElement($response);
echo '<pre>';
print_r($xmlo);
echo '</pre>';*/


//$to = 'maniprakash@travelinsert.com';
$to = 'maniprakashphp@gmail.com';

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