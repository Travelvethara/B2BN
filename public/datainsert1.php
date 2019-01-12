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


$query = 'TRUNCATE TABLE TBOcities';
$resultrrt = $mysqli->query($query);

$query = 'SELECT * FROM getcountries';
$result1 = $mysqli->query($query);
$CountryCode ='';
while ($result = mysqli_fetch_array($result1, MYSQLI_ASSOC)) {


$CountryCode = $result['CountryCode'];
	
	$action = "http://TekTravel/HotelBookingApi/DestinationCityList";
	  $mySOAP = '<soap:Envelope xmlns:soap="http://www.w3.org/2003/05/soap-envelope" xmlns:hot="http://TekTravel/HotelBookingApi">
				<soap:Header xmlns:wsa="http://www.w3.org/2005/08/addressing" >
				<hot:Credentials UserName="nozhattest" Password="Noz@17272502">
				</hot:Credentials>
				<wsa:Action>http://TekTravel/HotelBookingApi/DestinationCityList</wsa:Action>
				<wsa:To>https://api.tbotechnology.in/hotelapi_v7/hotelservice.svc</wsa:To>
				</soap:Header>
				<soap:Body>
				<hot:DestinationCityListRequest>
				<hot:CountryCode>'.$result['CountryCode'].'</hot:CountryCode>
				<hot:ReturnNewCityCodes>true</hot:ReturnNewCityCodes>
				</hot:DestinationCityListRequest>
				</soap:Body>
				</soap:Envelope>';
		  
	  $url = "https://api.tbotechnology.in/hotelapi_v7/hotelservice.svc";
		// The HTTP headers for the request (based on image above)
		// Content-Type and SOAPAction are important parameter
		$headers = array(
						'Content-Type: application/soap+xml; charset=utf-8',
						'Content-Length: '.strlen($mySOAP),
						'SOAPAction: ' .$action
					);
		// Build the cURL session
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_POST, TRUE);
		// Set required soap header
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		// Set request xml
		curl_setopt($ch, CURLOPT_POSTFIELDS, $mySOAP);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_ENCODING, 'gzip');		
		// Send the request and check the response
		// below you will be requesting our api using  curl_exec($ch), and $result contains api response
		if (($result = curl_exec($ch)) === FALSE)
		{
			die('cURL error: '.curl_error($ch)."<br />\n");
		} 
		else 
		{
			$response = preg_replace("/(<\/?)(\w+):([^>]*>)/", "$1$2$3", $result);
			$xml = new SimpleXMLElement($response);
			$json = str_replace('@attributes', 'attributes', json_encode($xml));
			$xml = json_decode($json);		
			//return $xml;
		}
		curl_close($ch);
		 
		  
		  if($xml->sBody->DestinationCityListResponse->Status->StatusCode == '01') {
              echo $CountryCode;
		
			   foreach($xml->sBody->DestinationCityListResponse->CityList->City as $CityList){
		           
				   echo '</br>';
	               $insertSql = 'INSERT INTO TBOcities(CountryCode, CityId, CityName) VALUES ("'.$CountryCode.'", "'.$CityList->attributes->CityCode.'", "'.$CityList->attributes->CityName.'");';	  
	                echo  $insertSql;
				  // echo '<br>';
				   $mysqli->query($insertSql);
			   }
		  }
	
	}



?>
