<?php

 $url = "http://api.tbotechnology.in/HotelAPI_V7/HotelService.svc";

  // The value for the SOAPAction: header It will change among methods
  $action = "http://TekTravel/HotelBookingApi/HotelSearchWithRooms";

  // Get the SOAP data into a string, I am using HEREDOC syntax
  // but how you do this is irrelevant, the point is just get the
  // body of the request into a string
  // You need to take reference of document to use specific request for specific method, here was:Action will change
$mySOAP = <<<EOD
<?xml version="1.0" encoding="utf-8"?>
<soap:Envelope xmlns:soap="http://www.w3.org/2003/05/soap-envelope" xmlns:hot="http://TekTravel/HotelBookingApi">
<soap:Header xmlns:wsa='http://www.w3.org/2005/08/addressing' >
<hot:Credentials UserName="hldypln" Password="Hol@93669601">
</hot:Credentials>
<wsa:Action>http://TekTravel/HotelBookingApi/HotelSearchWithRooms</wsa:Action> 
<wsa:To>http://api.tbotechnology.in/hotelapi_v7/hotelservice.svc</wsa:To>
</soap:Header>
<soap:Body>
<hot:HotelSearchWithRoomsRequest>
<hot:CheckInDate>2019-05-25</hot:CheckInDate>
<hot:CheckOutDate>2019-05-26</hot:CheckOutDate>
<hot:CountryName>United Arab Emirates</hot:CountryName>
<hot:CityName>Dubai</hot:CityName>
<hot:CityId>115936</hot:CityId>
<hot:IsNearBySearchAllowed>false</hot:IsNearBySearchAllowed>
<hot:NoOfRooms>1</hot:NoOfRooms>
<hot:GuestNationality>IN</hot:GuestNationality>
<hot:RoomGuests>
<hot:RoomGuest AdultCount="1" ChildCount="0">
</hot:RoomGuest>
</hot:RoomGuests>
<hot:ResultCount>0</hot:ResultCount>
<hot:Filters>
<hot:HotelCodeList>1133169</hot:HotelCodeList>
<hot:StarRating>All</hot:StarRating>
<hot:OrderBy>PriceAsc</hot:OrderBy>
</hot:Filters>
<hot:IsCancellationPolicyRequired>false</hot:IsCancellationPolicyRequired>
</hot:HotelSearchWithRoomsRequest>
</soap:Body>
</soap:Envelope>
EOD;

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

// Send the request and check the response
// below you will be requesting our api using  curl_exec($ch), and $result contains api response
if (($result = curl_exec($ch)) === FALSE) {
die('cURL error: '.curl_error($ch)."<br />\n");
} else {
echo "Success!<br />\n";

$response = preg_replace("/(<\/?)(\w+):([^>]*>)/", "$1$2$3", $result);
$xml = new SimpleXMLElement($response);

$array = json_decode(json_encode((array)$xml), TRUE);
//echo '<pre>'; 
//print_r($array);
echo "<pre>";
print_r($xml->sBody);
echo "</pre>";
}
curl_close($ch);


?>

