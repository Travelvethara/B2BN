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


$to = 'maniprakashpalani@gmail.com';

//sender
$from = 'sender@example.com';
$fromName = 'CodexWorld';

//email subject
$subject = 'admin'; 

//attachment file path
$file = "http://23.229.195.196/test/public/pdf/pdf_mail_MAMjA=.pdf";

//email body content
$htmlContent = '<h1>PHP Email with Attachment by CodexWorld</h1>
    <p>This email has sent from PHP script with attachment.</p>';

//header for sender info
$headers = "From: $fromName"." <".$from.">";

//boundary 
$semi_rand = md5(time()); 
$mime_boundary = "==Multipart_Boundary_x{$semi_rand}x"; 

//headers for attachment 
$headers .= "\nMIME-Version: 1.0\n" . "Content-Type: multipart/mixed;\n" . " boundary=\"{$mime_boundary}\""; 

//multipart boundary 
$message = "--{$mime_boundary}\n" . "Content-Type: text/html; charset=\"UTF-8\"\n" .
"Content-Transfer-Encoding: 7bit\n\n" . $htmlContent . "\n\n"; 

//preparing attachment
if(!empty($file) > 0){
    if(is_file($file)){
        $message .= "--{$mime_boundary}\n";
        $fp =    @fopen($file,"rb");
        $data =  @fread($fp,filesize($file));

        @fclose($fp);
        $data = chunk_split(base64_encode($data));
        $message .= "Content-Type: application/octet-stream; name=\"".basename($file)."\"\n" . 
        "Content-Description: ".basename($files[$i])."\n" .
        "Content-Disposition: attachment;\n" . " filename=\"".basename($file)."\"; size=".filesize($file).";\n" . 
        "Content-Transfer-Encoding: base64\n\n" . $data . "\n\n";
    }
}
$message .= "--{$mime_boundary}--";
$returnpath = "-f" . $from;

//send email
$mail = @mail($to, $subject, $message, $headers, $returnpath); 

echo $mail;

//email sending status
echo $mail?"<h1>Mail sent.</h1>":"<h1>Mail sending failed.</h1>";










?>