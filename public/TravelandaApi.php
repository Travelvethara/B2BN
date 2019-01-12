<?php 



$DB_NAME = 'choizmfm_b2b';
$DB_HOST = 'localhost';
$DB_USER = 'choizmfm_b2buser';
$DB_PASSWORD = '@cH!xE8uvFyT';

$mysqli = new mysqli($DB_HOST, $DB_USER, $DB_PASSWORD, $DB_NAME);

/* check connection */
if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}

$query = 'TRUNCATE TABLE gethotels';
$resultrrt = $mysqli->query($query);

$query = 'SELECT * FROM getcountries';
$result1 = $mysqli->query($query);

while ($result = mysqli_fetch_array($result1, MYSQLI_ASSOC)) {
    $url = 'http://xmldemo.travellanda.com/xmlv1/GetHotelsRequest.xsd';
    $user = 'a8f59bf51803d0f189b76cbf45ecff2e';
    $password = 'jRTLGatyuxRx';
    $post_string = array('xml' => '<Request><Head><Username>'.$user.'</Username><Password>'.$password.'</Password><RequestType>GetHotels</RequestType></Head><Body><CountryCode>'.$result['CountryCode'].'</CountryCode></Body></Request>');
    $soap_do = curl_init();
    curl_setopt($soap_do, CURLOPT_URL,            $url);
    curl_setopt($soap_do, CURLOPT_CONNECTTIMEOUT, 30);
    curl_setopt($soap_do, CURLOPT_TIMEOUT,        30);
    curl_setopt($soap_do, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($soap_do, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($soap_do, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($soap_do, CURLOPT_POST,           true);
    curl_setopt($soap_do, CURLOPT_POSTFIELDS,     http_build_query($post_string));
    curl_setopt($soap_do, CURLOPT_HTTPHEADER,     array('Content-Type: application/x-www-form-urlencoded'));
    //curl_setopt($soap_do, CURLOPT_USERPWD, $user . ":" . $password);
    $result = curl_exec($soap_do);

    $response = preg_replace("/(<\/?)(\w+):([^>]*>)/", '$1$2$3', $result);
    $request = json_decode($response);

    $xmlo = new SimpleXMLElement($response);
    if ($xmlo->Body->HotelsReturned != 0) {
        foreach ($xmlo->Body->Hotels->Hotel as $datails) {

            $query = 'INSERT INTO gethotels (HotelId,CityId,HotelName) VALUES ("'.$datails->HotelId.'","'.$datails->CityId.'","'.$datails->HotelName.'")';
            //echo '<br>';
            //print_r($datails);
            //echo '<br>';
            $mysqli->query($query);
        }
        //$mysqli->query($query);
    }
}



?>
