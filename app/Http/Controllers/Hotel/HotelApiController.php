<?php
namespace App\Http\Controllers\Hotel;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;
use Crypt;
use Illuminate\Contracts\Encryption\DecryptException;

class HotelApiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function hotel_tbolist_xml(){

     $CheckInDate = date("Y-m-d", strtotime($_GET['checkin']));
	 $CheckOutDate = date("Y-m-d", strtotime($_GET['checkout']));

	 $gettbocity=DB::select("SELECT DISTINCT CityId FROM TBOcities WHERE CityName LIKE '".$_GET['cityname']."%'");

	 	//USING error handle
	$norooms = $_GET['norooms'];
		$NumAdults = '';
		
		$tboloop  = '';
		$aultcount = 0;
		$childcount = 0;
		$childcountloop = '';
		if($norooms){
			for($no=1;$no<=$norooms;$no++){
				if(isset($_GET['adult'.$no])){
					
					$aultcount = $_GET['adult'.$no];
				
				}
				if(!empty($_GET['child'.$no])){
					$childcount = $_GET['child'.$no];
					
					$childcountloop .= '<hot:ChildAge>';
					for($chill=1;$chill<=$_GET['child'.$no];$chill++){
						$childcountloop .= '<hot:int>'.$_GET['childage'.$no.$chill].'</hot:int>';
					}
					$childcountloop .= '</hot:ChildAge>';
					
					}
			$tboloop .= '<hot:RoomGuest AdultCount="'.$aultcount.'" ChildCount="'.$childcount.'">';
			$tboloop .= $childcountloop;
			$tboloop .= '</hot:RoomGuest>';
				
			}
		}
		
		//echo  htmlspecialchars($tboloop);
	
		if($norooms){
			for($no=1;$no<=$norooms;$no++){
				$NumAdults .= '<Room>';
				if(isset($_GET['adult'.$no])){
					
					$NumAdults .= '<NumAdults>'.$_GET['adult'.$no].'</NumAdults>';
				
				}
				
				if(isset($_GET['child'.$no])){
					
					$NumAdults .='<Children>';
					
					for($ch=1;$ch<=$_GET['child'.$no];$ch++){
						
						$NumAdults .= '<ChildAge>'.$_GET['childage'.$no.$ch].'</ChildAge>';
					}
					$NumAdults .= '</Children>';
				
				}
				$NumAdults .= '</Room>';
			
				
			}
		}
		else
		{
		
			
		 return \Response::view('errors.404',array(),404);
		}
			if(isset($gettbocity[0]->CityId)){
			$citytboid=$gettbocity[0]->CityId;
			 $tbourl = "https://api.tbotechnology.in/HotelAPI_V7/HotelService.svc";

    // The value for the SOAPAction: header It will change among methods
    $action = "http://TekTravel/HotelBookingApi/HotelSearch";

    // Get the SOAP data into a string, I am using HEREDOC syntax
    // but how you do this is irrelevant, the point is just get the
    // body of the request into a string
    // You need to take reference of document to use specific request for specific method, here was:Action will change
    $mySOAP = <<<EOD
<?xml version="1.0" encoding="utf-8" ?>
<soap:Envelope xmlns:soap="http://www.w3.org/2003/05/soap-envelope"

xmlns:hot="http://TekTravel/HotelBookingApi">
  <soap:Header xmlns:wsa="http://www.w3.org/2005/08/addressing">
    <hot:Credentials UserName="hldypln" Password="Hol@93669601"> </hot:Credentials>
    <wsa:Action>http://TekTravel/HotelBookingApi/HotelSearch</wsa:Action>
    <wsa:To>https://api.tbotechnology.in/HotelAPI_V7/HotelService.svc</wsa:To>
  </soap:Header>
  <soap:Body>
    <hot:HotelSearchRequest>
      <hot:CheckInDate>$CheckInDate</hot:CheckInDate>
      <hot:CheckOutDate>$CheckOutDate</hot:CheckOutDate>
      <hot:CityId>$citytboid</hot:CityId>
      <hot:IsNearBySearchAllowed>false</hot:IsNearBySearchAllowed>
      <hot:NoOfRooms>$norooms</hot:NoOfRooms>
      <hot:GuestNationality>IN</hot:GuestNationality>
      <hot:RoomGuests>
        $tboloop
      </hot:RoomGuests>
      <hot:ResultCount>0</hot:ResultCount>
      <hot:Filters>
        <hot:StarRating>All</hot:StarRating>
        <hot:OrderBy>PriceAsc</hot:OrderBy>
      </hot:Filters>
    </hot:HotelSearchRequest>
  </soap:Body>
</soap:Envelope>
EOD;

//echo htmlspecialchars($mySOAP);
    // The HTTP headers for the request (based on image above)
    // Content-Type and SOAPAction are important parameter
    $tboheaders = array(
    'Content-Type: application/soap+xml; charset=utf-8',
    'Content-Length: '.strlen($mySOAP),
    'SOAPAction: ' .$action
    );

    // Build the cURL session
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $tbourl);
    curl_setopt($ch, CURLOPT_POST, TRUE);
    // Set required soap header
    curl_setopt($ch, CURLOPT_HTTPHEADER, $tboheaders);
    // Set request xml
    curl_setopt($ch, CURLOPT_POSTFIELDS, $mySOAP);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
 
    // Send the request and check the response
    // below you will be requesting our api using  curl_exec($ch), and $result contains api response
    if (($result = curl_exec($ch)) === FALSE) {
   die('cURL error: '.curl_error($ch)."<br />\n");
    } else {
        $tboresponse = preg_replace("/(<\/?)(\w+):([^>]*>)/", "$1$2$3", $result);
        $tboarray = array();
         if(!empty($tboresponse)){
        $tboxml = new \SimpleXMLElement($tboresponse);
        $tboarray = json_decode(json_encode((array)$tboxml), TRUE);



    if ($tboarray['sBody']['HotelSearchResponse']['Status']['StatusCode']==01) {
  
    
        session_start();
        unset($_SESSION['sessionId']);
        $_SESSION['sessionId'] = $tboarray['sBody']['HotelSearchResponse']['SessionId'];
	    return $tboarray['sBody']['HotelSearchResponse'];
    }

}else{
 session_start();
        unset($_SESSION['sessionId']);
$_SESSION['sessionId'] = 'jhghjghjhg';
return $tboarray;
}
}
curl_close($ch);


		}

    }

    public function hotel_list_xml() //Get list of Hotels from API Expedia API
    {
		
		
		$url = "http://xmldemo.travellanda.com/xmlv1/HotelSearchRequest.xsd";
		
	
		$CheckInDate = date("Y-m-d", strtotime($_GET['checkin']));
		$CheckOutDate = date("Y-m-d", strtotime($_GET['checkout']));
        
        
        $adminportal=DB::select("SELECT * FROM adminportal WHERE id=1");
        
        
        $user = $adminportal[0]->Travelanda_Test_Usename;
		$password = $adminportal[0]->Travelanda_Test_Password;
        
        if($adminportal[0]->Travelanda_Live == '1'){
        
         $user = $adminportal[0]->Travelanda_Test_Usename; //$adminportal[0]->Travelanda_Live_Username;
		 $password = $adminportal[0]->Travelanda_Test_Password; //$adminportal[0]->Travelanda_Live_Password;
        
        
        }
        
        
		//$user = 'a8f59bf51803d0f189b76cbf45ecff2e';
		//$password = 'jRTLGatyuxRx';
		
		
        
        if(isset($_GET['pag']) && !empty($_GET['pag'])) {
             $start = 0;
             $end = $_GET['pag']; 
         }else{ 
             $start = 0;
             $end = 20; 
         }

		
		$gethotels=DB::select("SELECT DISTINCT HotelId FROM gethotels WHERE CityId='".$_GET['cityid']."' LIMIT ".$start.", ".$end."");

		

		
		//loop
		$hotelidc = '';
		foreach($gethotels as $row){
		
		  $hotelidc .= '<HotelId>'.$row->HotelId.'</HotelId>'; 
		
		}
		//echo htmlspecialchars($hotelidc);
		//USING error handle
	$norooms = $_GET['norooms'];
		$NumAdults = '';
		
		if($norooms){
			for($no=1;$no<=$norooms;$no++){
				$NumAdults .= '<Room>';
				if(isset($_GET['adult'.$no])){
					
					$NumAdults .= '<NumAdults>'.$_GET['adult'.$no].'</NumAdults>';
				
				}
				
				if(isset($_GET['child'.$no])){
					
					$NumAdults .='<Children>';
					
					for($ch=1;$ch<=$_GET['child'.$no];$ch++){
						
						$NumAdults .= '<ChildAge>'.$_GET['childage'.$no.$ch].'</ChildAge>';
					}
					$NumAdults .= '</Children>';
				
				}
				$NumAdults .= '</Room>';
				
			}
		}
		else
		{
		
			
		 return \Response::view('errors.404',array(),404);
		}
	
		
		
		

		$post_string = array('xml'=>'<Request><Head><Username>'.$user.'</Username><Password>'.$password.'</Password><RequestType>HotelSearch</RequestType></Head><Body><HotelIds>'.$hotelidc.'</HotelIds><CheckInDate>'.$CheckInDate.'</CheckInDate><CheckOutDate>'.$CheckOutDate.'</CheckOutDate><Rooms>'.$NumAdults.'</Rooms><Nationality>AL</Nationality><Currency>USD</Currency><AvailableOnly>0</AvailableOnly></Body></Request>');
		
		if(isset($_GET['mani'])){
		echo htmlspecialchars('<Request><Head><Username>'.$user.'</Username><Password>'.$password.'</Password><RequestType>HotelSearch</RequestType></Head><Body><HotelIds>'.$hotelidc.'</HotelIds><CheckInDate>'.$CheckInDate.'</CheckInDate><CheckOutDate>'.$CheckOutDate.'</CheckOutDate><Rooms>'.$NumAdults.'</Rooms><Nationality>AL</Nationality><Currency>USD</Currency><AvailableOnly>0</AvailableOnly></Body></Request>');
		exit;
		}
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
    
		return $xmlo;

	}
    
   
	
	
	public function hotel_list_xml_ajax($array) //Get list of Hotels from API Expedia API
    {
		//page lilt
		//from 
		$norooms = $array['norooms'];
		$NumAdults = '';
		
		
		if($norooms){
			
			for($no=1;$no<=$norooms;$no++){
				$NumAdults .= '<Room>';
				if(isset($array['adult'.$no])){
					$NumAdults .= '<NumAdults>'.$array['adult'.$no].'</NumAdults>';
				}
				
				if(isset($array['child'.$no])){
					
					$NumAdults .='<Children>';
					
					for($ch=1;$ch<=$array['child'.$no];$ch++){
						
						$NumAdults .= '<ChildAge>'.$array['childage'.$no.$ch].'</ChildAge>';
					}
					$NumAdults .= '</Children>';
				
				}
				$NumAdults .= '</Room>';
				
			}
		}
		
		
		
		$pageno_form = $array['pageno']- 10;
		$pageno_to = $array['pageno'];
	
		$url = "http://xmldemo.travellanda.com/xmlv1/HotelSearchRequest.xsd";
		
		$CheckInDate = date("Y-m-d", strtotime($array['checkin']));
		$CheckOutDate = date("Y-m-d", strtotime($array['checkout']));
        
        $adminportal=DB::select("SELECT * FROM adminportal WHERE id=1");
        
        
        $user = $adminportal[0]->Travelanda_Test_Usename;
		$password = $adminportal[0]->Travelanda_Test_Password;
        
        if($adminportal[0]->Travelanda_Live == '1'){
        
         $user = $adminportal[0]->Travelanda_Test_Usename; //$adminportal[0]->Travelanda_Live_Username;
		 $password = $adminportal[0]->Travelanda_Test_Password; //$adminportal[0]->Travelanda_Live_Password;
        
        
        }
        
        
		//$user = 'a8f59bf51803d0f189b76cbf45ecff2e';
		//$password = 'jRTLGatyuxRx';
		
		//$gethotels=DB::table('gethotels')->where('CityId','=','255059')->offset(10)->limit(0,10)->get();
		//echo "SELECT * FROM gethotels WHERE CityId='".$array['cityid']."' LIMIT ".$pageno_to.", ".$pageno_form."";
		
		$gethotels=DB::select("SELECT DISTINCT HotelId FROM gethotels WHERE CityId='".$array['cityid']."' LIMIT ".$pageno_to.", ".$pageno_form."");
		//loop
		$hotelidc = '';
		foreach($gethotels as $row){
		
		$hotelidc .= '<HotelId>'.$row->HotelId.'</HotelId>'; 
		
		}
		//echo htmlspecialchars($hotelidc);
		
		$post_string = array('xml'=>'<Request><Head><Username>'.$user.'</Username><Password>'.$password.'</Password><RequestType>HotelSearch</RequestType></Head><Body><HotelIds>'.$hotelidc.'</HotelIds><CheckInDate>'.$CheckInDate.'</CheckInDate><CheckOutDate>'.$CheckOutDate.'</CheckOutDate><Rooms>'.$NumAdults.'</Rooms><Nationality>AL</Nationality><Currency>USD</Currency><AvailableOnly>0</AvailableOnly></Body></Request>');
		
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
		return $xmlo;

	}
    
    
    
    
     
    public function hotelDetailsTBOhotelDetail($array) //Get list of Hotels from API Expedia API
    {
    
		
		
        
        session_start();
     $session = $_SESSION['sessionId'];
     
     
 
     
     unset($_SESSION['HotelId']);
     if(isset($_GET['hotelid1']) && !empty($_GET['hotelid1'])){
		$_SESSION['HotelId'] = $array['hotelid1'];
        $hotelId = $array['hotelid1'];
       $resultindex =  $array['resultindex'];
        
        
	   }
        $city = explode(",",$array['city']);
	/*	
		echo '<pre>';
		print_r($city[0]);
		print_r($array);
		echo '</pre>';
		*/
		
		$cityId=DB::select("SELECT * FROM TBOcities WHERE `CityName` LIKE '".$city[0]."%' LIMIT 0, 1");
		
	/*	echo '<pre>';
		print_r($cityId);
		print_r($array);
		echo '</pre>';*/
		
		
		
    $url = "https://api.tbotechnology.in/HotelAPI_V7/HotelService.svc";
    // The value for the SOAPAction: header It will change among methods
    $action = "http://TekTravel/HotelBookingApi/AvailableHotelRooms";
    // Get the SOAP data into a string, I am using HEREDOC syntax
    // but how you do this is irrelevant, the point is just get the
    // body of the request into a string
// You need to take reference of document to use specific request for specific method, here was:Action will change

 $mySOAP = <<<EOD
<?xml version="1.0" encoding="utf-8" ?>
<soap:Envelope xmlns:soap="http://www.w3.org/2003/05/soap-envelope" xmlns:hot="http://TekTravel/HotelBookingApi">
  <soap:Header xmlns:wsa="http://www.w3.org/2005/08/addressing">
    <hot:Credentials UserName="hldypln" Password="Hol@93669601"> </hot:Credentials>
    <wsa:Action>http://TekTravel/HotelBookingApi/AvailableHotelRooms</wsa:Action>
    <wsa:To>https://api.tbotechnology.in/HotelAPI_V7/HotelService.svc</wsa:To>
  </soap:Header>
  <soap:Body>
  <hot:HotelRoomAvailabilityRequest>
<hot:SessionId>$session</hot:SessionId>
<hot:ResultIndex>$resultindex</hot:ResultIndex>
<hot:HotelCode>$hotelId</hot:HotelCode>
<hot:ResponseTime>0</hot:ResponseTime>
</hot:HotelRoomAvailabilityRequest>
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

$response = preg_replace("/(<\/?)(\w+):([^>]*>)/", "$1$2$3", $result);
$xml = new \SimpleXMLElement($response);


$string = str_replace('@attributes', 'attributes', json_encode($xml));
$array1 = json_decode($string);
$array = json_decode(json_encode((array)$array1), TRUE);


unset($_SESSION['ResultIndex']);
unset($_SESSION['RoomDetails']);
unset($_SESSION['Cancelpolicy']);
unset($_SESSION['RoomDetailscode']);
$_SESSION['ResultIndex'] = $array['sBody']['HotelRoomAvailabilityResponse']['ResultIndex'];

$ResultIndex = $_SESSION['ResultIndex'];


$_SESSION['RoomDetails'] = $array;
$_SESSION['RoomDetailscode'] = $array;

return $array;
}

		
		
		
		
		
	
    
    }
    
    
    
    
    
    
      public function hotelDetailsTBO($array) //Get list of Hotels from API Expedia API
    
       {
		
		
        
        session_start();
     $session = $_SESSION['sessionId'];
     
     
 
     
     unset($_SESSION['HotelId']);
     if(isset($_GET['hotelid1']) && !empty($_GET['hotelid1'])){
		$_SESSION['HotelId'] = $array['hotelid1'];
        $hotelId = $array['hotelid1'];
       $resultindex =  $array['resultindex'];
        
        
	   }
        $city = explode(",",$array['city']);
	/*	
		echo '<pre>';
		print_r($city[0]);
		print_r($array);
		echo '</pre>';
		*/
		
		$cityId=DB::select("SELECT * FROM TBOcities WHERE `CityName` LIKE '".$city[0]."%' LIMIT 0, 1");
		
	/*	echo '<pre>';
		print_r($cityId);
		print_r($array);
		echo '</pre>';*/
		
		
		
    $url = "https://api.tbotechnology.in/HotelAPI_V7/HotelService.svc";
    // The value for the SOAPAction: header It will change among methods
    $action = "http://TekTravel/HotelBookingApi/AvailableHotelRooms";
    // Get the SOAP data into a string, I am using HEREDOC syntax
    // but how you do this is irrelevant, the point is just get the
    // body of the request into a string
// You need to take reference of document to use specific request for specific method, here was:Action will change

 $mySOAP = <<<EOD
<?xml version="1.0" encoding="utf-8" ?>
<soap:Envelope xmlns:soap="http://www.w3.org/2003/05/soap-envelope" xmlns:hot="http://TekTravel/HotelBookingApi">
  <soap:Header xmlns:wsa="http://www.w3.org/2005/08/addressing">
    <hot:Credentials UserName="hldypln" Password="Hol@93669601"> </hot:Credentials>
    <wsa:Action>http://TekTravel/HotelBookingApi/AvailableHotelRooms</wsa:Action>
    <wsa:To>https://api.tbotechnology.in/HotelAPI_V7/HotelService.svc</wsa:To>
  </soap:Header>
  <soap:Body>
  <hot:HotelRoomAvailabilityRequest>
<hot:SessionId>$session</hot:SessionId>
<hot:ResultIndex>$resultindex</hot:ResultIndex>
<hot:HotelCode>$hotelId</hot:HotelCode>
<hot:ResponseTime>0</hot:ResponseTime>
</hot:HotelRoomAvailabilityRequest>
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

$response = preg_replace("/(<\/?)(\w+):([^>]*>)/", "$1$2$3", $result);
$xml = new \SimpleXMLElement($response);


$string = str_replace('@attributes', 'attributes', json_encode($xml));
$array1 = json_decode($string);
$array = json_decode(json_encode((array)$array1), TRUE);


unset($_SESSION['ResultIndex']);
unset($_SESSION['RoomDetails']);
unset($_SESSION['Cancelpolicy']);
unset($_SESSION['RoomDetailscode']);
$_SESSION['ResultIndex'] = $array['sBody']['HotelRoomAvailabilityResponse']['ResultIndex'];

$ResultIndex = $_SESSION['ResultIndex'];


$roomname_with_key = array();



$_SESSION['RoomDetails'] = $array;
$_SESSION['RoomDetailscode'] = $array;
if(isset($array['sBody']['HotelRoomAvailabilityResponse']['HotelRooms']['HotelRoom'][0])){
foreach($array['sBody']['HotelRoomAvailabilityResponse']['HotelRooms']['HotelRoom'] as $roomnames){


$RoomName = str_replace(' ','',$roomnames['RoomTypeName']);
$roomname_with_key[$roomnames['RoomIndex']] = $RoomName;
$_SESSION['RoomDetailscode']['code'.$roomnames['RoomIndex']] = $roomnames;




}



}else{
if($array['sBody']['HotelRoomAvailabilityResponse']['Status']['StatusCode'] == '01'){
$RoomName = str_replace(' ','',$array['sBody']['HotelRoomAvailabilityResponse']['HotelRooms']['HotelRoom']['RoomTypeName']);
$_SESSION['RoomDetailscode']['code'.$array['sBody']['HotelRoomAvailabilityResponse']['HotelRooms']['HotelRoom']['RoomIndex']] = $array['sBody']['HotelRoomAvailabilityResponse']['HotelRooms']['HotelRoom'];
$roomname_with_key[$array['sBody']['HotelRoomAvailabilityResponse']['HotelRooms']['HotelRoom']['RoomIndex']] = $RoomName;
}
}



if(isset($array['sBody']['HotelRoomAvailabilityResponse']['OptionsForBooking']['RoomCombination'][0])){
foreach($array['sBody']['HotelRoomAvailabilityResponse']['OptionsForBooking']['RoomCombination'] as $roomAge){

 
$RoomIndex = $roomAge['RoomIndex'];


$roomAgecount = count($roomAge['RoomIndex']);

if($roomAgecount>=2){

foreach($roomAge['RoomIndex'] as $RoomIndexi){

$RoomIndex1 = $RoomIndexi;

$RoomIndex12 = $this->canacellation_policy($resultindex, $RoomIndex1);

   $_SESSION['Cancelpolicy'][$hotelId]['RoomIndex'.$RoomIndex1] = $RoomIndex12;

}

}else{

  $canacellationPolicy = $this->canacellation_policy($resultindex, $RoomIndex);
  
 
$_SESSION['Cancelpolicy'][$hotelId]['RoomIndex'.$RoomIndex] = $canacellationPolicy;
}

}
}else{
if($array['sBody']['HotelRoomAvailabilityResponse']['Status']['StatusCode'] == '01'){
$RoomIndex = $array['sBody']['HotelRoomAvailabilityResponse']['OptionsForBooking']['RoomCombination']['RoomIndex'];
$RoomIndex12 = $this->canacellation_policy($resultindex, $RoomIndex);
$_SESSION['Cancelpolicy'][$hotelId]['RoomIndex'.$RoomIndex] = $RoomIndex12;
}
}





$RoomIndex_message = '';

$RoomIndex_message_array = array();

if($array['sBody']['HotelRoomAvailabilityResponse']['Status']['StatusCode'] == '01'){
 
 $roomAgecountprice = count($array['sBody']['HotelRoomAvailabilityResponse']['OptionsForBooking']['RoomCombination']);

if(isset($array['sBody']['HotelRoomAvailabilityResponse']['OptionsForBooking']['RoomCombination'][0])){
foreach($array['sBody']['HotelRoomAvailabilityResponse']['OptionsForBooking']['RoomCombination'] as $roomAge){

$roomskeyarray ='';
$roomskeyarray = array();



 $roomAgecountprice = count($roomAge['RoomIndex']);
    if($roomAgecountprice>=2){
   $RoomIndex_message  = '';
    $RoomIndex_message .= '<hot:RoomCombination>';
  foreach($roomAge['RoomIndex'] as $roomAge_v){
   
   $roomskeyarray[$roomAge_v] = $roomAge_v; 
   $RoomIndex_message .= '<hot:RoomIndex>'.$roomAge_v.'</hot:RoomIndex>';
   
   
  }
   $RoomIndex_message .= '</hot:RoomCombination>';
   
   $availabilityAndPricing =  $this->availabilityAndPricing($RoomIndex_message, $session, $hotelId, $ResultIndex);


    foreach($roomskeyarray as $roomskeyarray_value){

   $RoomIndex_message_array[$roomskeyarray_value]['AvailableForBook'] = $availabilityAndPricing['sBody']['AvailabilityAndPricingResponse']['AvailableForBook'];
   $RoomIndex_message_array[$roomskeyarray_value]['AvailableForConfirmBook'] = $availabilityAndPricing['sBody']['AvailabilityAndPricingResponse']['AvailableForConfirmBook'];
   }

   
 

}else{

   $RoomIndex_message = '<hot:RoomCombination>';
   $RoomIndex_message .= '<hot:RoomIndex>'.$roomAge['RoomIndex'].'</hot:RoomIndex>';
   $RoomIndex_message .= '</hot:RoomCombination>';
   
   
     $availabilityAndPricing =  $this->availabilityAndPricing($RoomIndex_message, $session, $hotelId, $ResultIndex);
      $RoomIndex_message_array[$roomAge['RoomIndex']]['AvailableForBook'] = $availabilityAndPricing['sBody']['AvailabilityAndPricingResponse']['AvailableForBook'];
      $RoomIndex_message_array[$roomAge['RoomIndex']]['AvailableForConfirmBook'] = $availabilityAndPricing['sBody']['AvailabilityAndPricingResponse']['AvailableForConfirmBook'];
    
     

}

}
}
}

$array['RoomIndex_message_array'] = $RoomIndex_message_array;







return $array;
}

		
		
		
		
		
	}
    
    public function tboHolidaysHotelDetails_pay($attr ,$session) //Get list of Hotels from API Expedia API
    {

     if(isset($attr['hotelid'])){
		$_SESSION['HotelId'] = $attr['hotelid'];
        $hotelId = $attr['hotelid'];
        $resultindex = $attr['resultindex'];
        
        
	   }


		
    $url = "https://api.tbotechnology.in/HotelAPI_V7/HotelService.svc";
    // The value for the SOAPAction: header It will change among methods
    $action = "http://TekTravel/HotelBookingApi/AvailableHotelRooms";
    // Get the SOAP data into a string, I am using HEREDOC syntax
    // but how you do this is irrelevant, the point is just get the
    // body of the request into a string
// You need to take reference of document to use specific request for specific method, here was:Action will change

 $mySOAP = <<<EOD
<?xml version="1.0" encoding="utf-8" ?>
<soap:Envelope xmlns:soap="http://www.w3.org/2003/05/soap-envelope" xmlns:hot="http://TekTravel/HotelBookingApi">
  <soap:Header xmlns:wsa="http://www.w3.org/2005/08/addressing">
    <hot:Credentials UserName="hldypln" Password="Hol@93669601"> </hot:Credentials>
    <wsa:Action>http://TekTravel/HotelBookingApi/AvailableHotelRooms</wsa:Action>
    <wsa:To>https://api.tbotechnology.in/HotelAPI_V7/HotelService.svc</wsa:To>
  </soap:Header>
  <soap:Body>
  <hot:HotelRoomAvailabilityRequest>
<hot:SessionId>$session</hot:SessionId>
<hot:ResultIndex>$resultindex</hot:ResultIndex>
<hot:HotelCode>$hotelId</hot:HotelCode>
<hot:ResponseTime>0</hot:ResponseTime>
</hot:HotelRoomAvailabilityRequest>
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

$response = preg_replace("/(<\/?)(\w+):([^>]*>)/", "$1$2$3", $result);
$xml = new \SimpleXMLElement($response);


$string = str_replace('@attributes', 'attributes', json_encode($xml));
$array1 = json_decode($string);
$array = json_decode(json_encode((array)$array1), TRUE);


return $array;
}

		
		
		
		
    
    
    
    
    
    
    
    
    }
    
    


public function tboHolidaysHotelDetails($attr) //Get list of Hotels from API Expedia API
    {
    
    
 
  $hotelid1 =   $attr;
    //echo  $_SESSION['SessionId'];
    //$session_id =  $_SESSION['SessionId'];
    //echo $session_id;
    $url = "https://api.tbotechnology.in/HotelAPI_V7/HotelService.svc";
    // The value for the SOAPAction: header It will change among methods
    $action = "http://TekTravel/HotelBookingApi/HotelDetails";
    // Get the SOAP data into a string, I am using HEREDOC syntax
    // but how you do this is irrelevant, the point is just get the
    // body of the request into a string
// You need to take reference of document to use specific request for specific method, here was:Action will change

 $mySOAP = <<<EOD
<?xml version="1.0" encoding="utf-8" ?>
<soap:Envelope xmlns:soap="http://www.w3.org/2003/05/soap-envelope" xmlns:hot="http://TekTravel/HotelBookingApi">
  <soap:Header xmlns:wsa="http://www.w3.org/2005/08/addressing">
    <hot:Credentials UserName="hldypln" Password="Hol@93669601"> </hot:Credentials>
    <wsa:Action>http://TekTravel/HotelBookingApi/HotelDetails</wsa:Action>
    <wsa:To>https://api.tbotechnology.in/HotelAPI_V7/HotelService.svc</wsa:To>
  </soap:Header>
  <soap:Body>
  <hot:HotelDetailsRequest>
<hot:HotelCode>$hotelid1</hot:HotelCode>
</hot:HotelDetailsRequest>
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

$response = preg_replace("/(<\/?)(\w+):([^>]*>)/", "$1$2$3", $result);
$xml = new \SimpleXMLElement($response);
$string = str_replace('@attributes', 'attributes', json_encode($xml));
$array11 = json_decode($string);
$array = json_decode(json_encode((array)$array11), TRUE);
return $array; 
}

curl_close($ch);
    
    
    
    
    }


public function canacellation_policy($resultindex, $attr) //Get list of Hotels from API Expedia API
    {



     $session = $_SESSION['sessionId'];

   $url = "https://api.tbotechnology.in/HotelAPI_V7/HotelService.svc";

  $action = "http://TekTravel/HotelBookingApi/HotelCancellationPolicy";

$mySOAP = <<<EOD
<?xml version="1.0" encoding="utf-8" ?>
<soap:Envelope xmlns:soap="http://www.w3.org/2003/05/soap-envelope" xmlns:hot="http://TekTravel/HotelBookingApi">
<soap:Header xmlns:wsa='http://www.w3.org/2005/08/addressing' >
<hot:Credentials UserName="hldypln" Password="Hol@93669601">
</hot:Credentials>
<wsa:Action>http://TekTravel/HotelBookingApi/HotelCancellationPolicy</wsa:Action> 
<wsa:To>https://api.tbotechnology.in/HotelAPI_V7/HotelService.svc</wsa:To>
</soap:Header>
<soap:Body>
<hot:HotelCancellationPolicyRequest>
<hot:ResultIndex>$resultindex</hot:ResultIndex>
<hot:SessionId>$session</hot:SessionId>
<hot:OptionsForBooking>
<hot:FixedFormat>false</hot:FixedFormat>
<hot:RoomCombination>
<hot:RoomIndex>$attr</hot:RoomIndex>
<!-- <hot:RoomIndex>2</hot:RoomIndex> -->
</hot:RoomCombination>
</hot:OptionsForBooking>
</hot:HotelCancellationPolicyRequest>
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
$response = preg_replace("/(<\/?)(\w+):([^>]*>)/", "$1$2$3", $result);
$xml = new \SimpleXMLElement($response);

$array = json_decode(json_encode((array)$xml), TRUE);
return $array; 
    }

}


public function canacellation_policy_Pay($RoomIndex, $session, $ResultIndex) //Get list of Hotels from API Expedia API
    {



   $url = "https://api.tbotechnology.in/HotelAPI_V7/HotelService.svc";

  $action = "http://TekTravel/HotelBookingApi/HotelCancellationPolicy";

$mySOAP = <<<EOD
<?xml version="1.0" encoding="utf-8" ?>
<soap:Envelope xmlns:soap="http://www.w3.org/2003/05/soap-envelope" xmlns:hot="http://TekTravel/HotelBookingApi">
<soap:Header xmlns:wsa='http://www.w3.org/2005/08/addressing' >
<hot:Credentials UserName="hldypln" Password="Hol@93669601">
</hot:Credentials>
<wsa:Action>http://TekTravel/HotelBookingApi/HotelCancellationPolicy</wsa:Action> 
<wsa:To>https://api.tbotechnology.in/HotelAPI_V7/HotelService.svc</wsa:To>
</soap:Header>
<soap:Body>
<hot:HotelCancellationPolicyRequest>
<hot:ResultIndex>$ResultIndex</hot:ResultIndex>
<hot:SessionId>$session</hot:SessionId>
<hot:OptionsForBooking>
<hot:FixedFormat>false</hot:FixedFormat>
<hot:RoomCombination>
<hot:RoomIndex>$RoomIndex</hot:RoomIndex>
<!-- <hot:RoomIndex>2</hot:RoomIndex> -->
</hot:RoomCombination>
</hot:OptionsForBooking>
</hot:HotelCancellationPolicyRequest>
</soap:Body>
</soap:Envelope>
EOD;
/*
echo htmlspecialchars($mySOAP);*/

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
$response = preg_replace("/(<\/?)(\w+):([^>]*>)/", "$1$2$3", $result);
$xml = new \SimpleXMLElement($response);

$array = json_decode(json_encode((array)$xml), TRUE);
return $array; 
    }

}


public function availabilityAndPricing_pay($attr, $session, $hotelId, $ResultIndex) //Get list of Hotels from API Expedia API
    { 


  
    $url = "https://api.tbotechnology.in/HotelAPI_V7/HotelService.svc";

  // The value for the SOAPAction: header It will change among methods
  $action = "http://TekTravel/HotelBookingApi/AvailabilityAndPricing";

  // Get the SOAP data into a string, I am using HEREDOC syntax
  // but how you do this is irrelevant, the point is just get the
  // body of the request into a string
  // You need to take reference of document to use specific request for specific method, here was:Action will change
$mySOAP = <<<EOD
<?xml version="1.0" encoding="utf-8" ?>
<soap:Envelope xmlns:soap="http://www.w3.org/2003/05/soap-envelope" xmlns:hot="http://TekTravel/HotelBookingApi">
<soap:Header xmlns:wsa='http://www.w3.org/2005/08/addressing' >
<hot:Credentials UserName="hldypln" Password="Hol@93669601">
</hot:Credentials>
<wsa:Action>http://TekTravel/HotelBookingApi/AvailabilityAndPricing</wsa:Action> 
<wsa:To>https://api.tbotechnology.in/HotelAPI_V7/HotelService.svc</wsa:To>
</soap:Header>
<soap:Body>
<hot:AvailabilityAndPricingRequest>
<hot:ResultIndex>$ResultIndex</hot:ResultIndex>
<hot:HotelCode>$hotelId</hot:HotelCode>
<hot:SessionId>$session</hot:SessionId>
<hot:OptionsForBooking>
<hot:FixedFormat>false</hot:FixedFormat>
<hot:RoomCombination>
<hot:RoomIndex>$attr</hot:RoomIndex>
</hot:RoomCombination>
</hot:OptionsForBooking>
</hot:AvailabilityAndPricingRequest>
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
$response = preg_replace("/(<\/?)(\w+):([^>]*>)/", "$1$2$3", $result);
$xml = new \SimpleXMLElement($response);

$array = json_decode(json_encode((array)$xml), TRUE);
return $array;  
}
}




public function availabilityAndPricing($attr, $session, $hotelId, $ResultIndex) //Get list of Hotels from API Expedia API
    { 

    $mySOAP = '';
    $url = "https://api.tbotechnology.in/HotelAPI_V7/HotelService.svc";

  // The value for the SOAPAction: header It will change among methods
  $action = "http://TekTravel/HotelBookingApi/AvailabilityAndPricing";

  // Get the SOAP data into a string, I am using HEREDOC syntax
  // but how you do this is irrelevant, the point is just get the
  // body of the request into a string
  // You need to take reference of document to use specific request for specific method, here was:Action will change
$mySOAP = <<<EOD
<?xml version="1.0" encoding="utf-8" ?>
<soap:Envelope xmlns:soap="http://www.w3.org/2003/05/soap-envelope" xmlns:hot="http://TekTravel/HotelBookingApi">
<soap:Header xmlns:wsa='http://www.w3.org/2005/08/addressing' >
<hot:Credentials UserName="hldypln" Password="Hol@93669601">
</hot:Credentials>
<wsa:Action>http://TekTravel/HotelBookingApi/AvailabilityAndPricing</wsa:Action> 
<wsa:To>https://api.tbotechnology.in/HotelAPI_V7/HotelService.svc</wsa:To>
</soap:Header>
<soap:Body>
<hot:AvailabilityAndPricingRequest>
<hot:ResultIndex>$ResultIndex</hot:ResultIndex>
<hot:HotelCode>$hotelId</hot:HotelCode>
<hot:SessionId>$session</hot:SessionId>
<hot:OptionsForBooking>
<hot:FixedFormat>false</hot:FixedFormat>
$attr
</hot:OptionsForBooking>
</hot:AvailabilityAndPricingRequest>
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
$response = preg_replace("/(<\/?)(\w+):([^>]*>)/", "$1$2$3", $result);
$xml = new \SimpleXMLElement($response);

$array = json_decode(json_encode((array)$xml), TRUE);
return $array; 
}
}
    
	
	
	
	public function Getresponce($url)  //Get API Response from EXPEDIA API

	{

		$cur=curl_init();

		curl_setopt($cur,CURLOPT_URL,$url);

		curl_setopt($cur,CURLOPT_HTTPHEADER,array('Accept:application/xml'));

		curl_setopt($cur, CURLOPT_HTTPHEADER, array('Content-Type: text/xml,charset=UTF-8'));

		curl_setopt($cur, CURLOPT_RETURNTRANSFER,1);

		$retValue = curl_exec($cur);

		if(curl_errno($cur))

			curl_error($cur).'<br />';

		curl_close($cur);

		$result=new \SimpleXMLElement($retValue);


		return $result;

	}



//detail page


public function hoteldetails($id,$checkin,$checkout,$request){
$url = "http://xmldemo.travellanda.com/xmlv1/HotelSearchRequest.xsd";
$CheckInDate = $checkin;
$CheckOutDate = $checkout;
$HotelId = $id;

	$link_adult = '';

	$childcount = '';

	

		for($i = 1; $i<=$_GET['norooms']; $i++){

			//$link_room .= '&noadult'.$i.'='.$_GET['adult'.$i].'&child'.$i.'='.$_GET['child'.$i];

			$link_adult .= '<Room><NumAdults>'.$_GET['adult'.$i].'</NumAdults>';
			//$childcount = $request['child'.$i];

			//$link_adult .= '<numberOfChildren>'.$_GET['child'.$i].'</numberOfChildren>';

		           if(isset($_GET['child'.$i])){
					
					$link_adult .='<Children>';
					
					for($ch=1;$ch<=$_GET['child'.$i];$ch++){
						
						$link_adult .= '<ChildAge>'.$_GET['childage'.$i.$ch].'</ChildAge>';
					}
					$link_adult .= '</Children>';
				
				}

			$link_adult .= '</Room>';

		}

$rooms = '';

         $adminportal=DB::select("SELECT * FROM adminportal WHERE id=1");
        
        
        $user = $adminportal[0]->Travelanda_Test_Usename;
		$password = $adminportal[0]->Travelanda_Test_Password;
        
        if($adminportal[0]->Travelanda_Live == '1'){
        
         $user = $adminportal[0]->Travelanda_Test_Usename; //$adminportal[0]->Travelanda_Live_Username;
		 $password = $adminportal[0]->Travelanda_Test_Password; //$adminportal[0]->Travelanda_Live_Password;
        
        
        }

//$user = 'a8f59bf51803d0f189b76cbf45ecff2e';
//$password = 'jRTLGatyuxRx';

$post_string = array('xml'=>'<Request><Head><Username>'.$user.'</Username><Password>'.$password.'</Password><RequestType>HotelSearch</RequestType></Head><Body><HotelIds><HotelId>'.$HotelId.'</HotelId></HotelIds><CheckInDate>'.$CheckInDate.'</CheckInDate><CheckOutDate>'.$CheckOutDate.'</CheckOutDate><Rooms>'.$link_adult.'</Rooms><Nationality>AL</Nationality><Currency>USD</Currency><AvailableOnly>0</AvailableOnly></Body></Request>');

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
if(isset($_GET['mani'])){
echo "<pre>";
print_r($xmlo);
echo "</pre>";

}
return $xmlo;
	
	}
public function hotelpolicies($optionsID){

$url = "http://xmldemo.travellanda.com/xmlv1/HotelPoliciesRequest.xsd";
///$OptionId = '463149091018';

$adminportal=DB::select("SELECT * FROM adminportal WHERE id=1");
        
        
        $user = $adminportal[0]->Travelanda_Test_Usename;
		$password = $adminportal[0]->Travelanda_Test_Password;
        
        if($adminportal[0]->Travelanda_Live == '1'){
        
         $user = $adminportal[0]->Travelanda_Test_Usename; //$adminportal[0]->Travelanda_Live_Username;
		 $password = $adminportal[0]->Travelanda_Test_Password; //$adminportal[0]->Travelanda_Live_Password;
        
        
        }

//$user = 'a8f59bf51803d0f189b76cbf45ecff2e';
//$password = 'jRTLGatyuxRx';

$post_string = array('xml'=>'<Request><Head><Username>'.$user.'</Username><Password>'.$password.'</Password><RequestType>HotelPolicies</RequestType></Head><Body><OptionId>'.$optionsID.'</OptionId></Body></Request>');

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
	
	return $xmlo;
	
	
}

public function Gethotelresponse($hotelid)  //Get specific Hotel information API Request
{
$url = "http://xmldemo.travellanda.com/xmlv1/GetHotelDetailsRequest.xsd";
         $adminportal=DB::select("SELECT * FROM adminportal WHERE id=1");
        $user = $adminportal[0]->Travelanda_Test_Usename;
		$password = $adminportal[0]->Travelanda_Test_Password;
        
        if($adminportal[0]->Travelanda_Live == '1'){
        
         $user = $adminportal[0]->Travelanda_Test_Usename; //$adminportal[0]->Travelanda_Live_Username;
		 $password = $adminportal[0]->Travelanda_Test_Password; //$adminportal[0]->Travelanda_Live_Password;
        
        
        }
//$user = 'a8f59bf51803d0f189b76cbf45ecff2e';
//$password = 'jRTLGatyuxRx';

$post_string = array('xml'=>'<Request><Head><Username>'.$user.'</Username><Password>'.$password.'</Password><RequestType>GetHotelDetails</RequestType></Head><Body><HotelIds><HotelId>'.$hotelid.'</HotelId></HotelIds></Body></Request>');

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


	
	return $xmlo;
}



public function TboBookingResults($request){





$noroom = $request['noofroom'];
	
	//echo '<pre>';
	//print_r($request->all());
	//echo '</pre>';
    
    
     $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < 4; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
     ;

$clientrefnumber= date("dmyhis")."123#".$randomString;
	
		$NumAdults = '';
        $LeadGuest = 'true';
		
		if($noroom){
        
        $guestdetail = '';
        $guestdetail = '<hot:Guests>';
        
        for($no=1;$no<=$noroom;$no++){
        
        if(isset($request['NumAdults'.$no])){
        
        for($ao=1;$ao<=$request['NumAdults'.$no];$ao++){
        
        $guestdetail .= '<hot:Guest LeadGuest="'.$LeadGuest.'" GuestType="Adult" GuestInRoom="'.$no.'"><hot:Title>'.$request['selectadult'.$no.$ao].'</hot:Title><hot:FirstName>'.$request['inptutroomfirstname'.$no.$ao].'</hot:FirstName>
			<hot:LastName>'.$request['inptutroomlastname'.$no.$ao].'</hot:LastName>
		</hot:Guest>';
        $LeadGuest = 'false';
        }
        if(isset($request['NumChildren'.$no])){
        for($co=1;$co<=$request['NumChildren'.$no];$co++){
        
        $guestdetail .= '<hot:Guest LeadGuest="false" GuestType="Child" GuestInRoom="'.$no.'"><hot:Title>Mr</hot:Title><hot:FirstName>'.$request['childfirstname'.$no.$co].'</hot:FirstName>
			<hot:LastName>'.$request['childlastname'.$no.$co].'</hot:LastName>
			<hot:Age>'.$request['childage'.$no.$co].'</hot:Age>
		</hot:Guest>';
        
        }
        }
       
        }
        $LeadGuest = 'false';
        
           }
        $guestdetail .= '</hot:Guests>';
        
        }
        
        //echo htmlspecialchars($guestdetail);
       /* session_start();
        echo '<pre>';
        print_r($_SESSION);
        echo '</pre>';*/

$hotelromm = '';
for($no=1;$no<=$noroom;$no++){

$hotelromm .='<hot:HotelRoom><hot:RoomIndex>'.$request['RoomIndex'.$no].'</hot:RoomIndex><hot:RoomTypeName>'.$request['RoomName'.$no].'</hot:RoomTypeName>
<hot:RoomTypeCode>'.$request['RoomTypeCode'.$no].'</hot:RoomTypeCode>
<hot:RatePlanCode>'.$request['RatePlanCode'.$no].'</hot:RatePlanCode>
<hot:RoomRate RoomFare="'.$request['RoomFare'.$no].'" Currency="'.$request['Currency'.$no].'" AgentMarkUp="'.$request['AgentMarkUp'.$no].'" RoomTax="'.$request['RoomTax'.$no].'" TotalFare="'.$request['TotalFare'.$no].'"/>
</hot:HotelRoom>';
}

 session_start();
 $session = $_SESSION['sessionId'];
 $ResultIndex = $_SESSION['ResultIndex'];
 
      /*   echo '<pre>';
        print_r($_SESSION);
        echo '</pre>';
        
        exit;*/

$hotelinfo = '<hot:SessionId>'.$session.'</hot:SessionId>
<hot:NoOfRooms>'.$noroom.'</hot:NoOfRooms> 
<hot:ResultIndex>'.$ResultIndex.'</hot:ResultIndex>
<hot:HotelCode>'.$request["hotelid"].'</hot:HotelCode> 
<hot:HotelName>'.$request["Hotelname"].'</hot:HotelName>';






 $url = "https://api.tbotechnology.in/HotelAPI_V7/HotelService.svc";

    // The value for the SOAPAction: header It will change among methods
  	  $action = "http://TekTravel/HotelBookingApi/HotelBook";

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
<wsa:Action>http://TekTravel/HotelBookingApi/HotelBook</wsa:Action> 
<wsa:To>https://api.tbotechnology.in/HotelAPI_V7/HotelService.svc</wsa:To>
</soap:Header>
<soap:Body>
<hot:HotelBookRequest>
<!-- <hot:ClientReferenceNumber>070817125855789#kuld</hot:ClientReferenceNumber> -->
<hot:ClientReferenceNumber>$clientrefnumber</hot:ClientReferenceNumber> 
<hot:GuestNationality>IN</hot:GuestNationality>
	$guestdetail
<hot:PaymentInfo VoucherBooking="true" PaymentModeType="Limit">
</hot:PaymentInfo>
$hotelinfo
<hot:HotelRooms>
$hotelromm
</hot:HotelRooms>
</hot:HotelBookRequest>
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
$xml = new \SimpleXMLElement($response);

$array = json_decode(json_encode((array)$xml), TRUE);
return $array;
}


}



public function BookingResults($request){
	
	
	$noroom = $request['norooms'];
	
	//echo '<pre>';
	//print_r($request->all());
	//echo '</pre>';
	
		$NumAdults = '';
		
		if($noroom){
			$NumAdults .= '<OptionId>'.$request['optionID'].'</OptionId>';
			$NumAdults .= '<YourReference>XMLTEST</YourReference>';
			$NumAdults .= '<Rooms>';
			for($no=0;$no<$noroom;$no++){
				$NumAdults .= '<Room>';
				$NumAdults .= '<RoomId>'.$request['RoomId'.$no].'</RoomId>';
				$NumAdults .='<PaxNames>';
				if(isset($request['NumAdults'.$no])){
					for($a=1;$a<=$request['NumAdults'.$no];$a++){
					$NumAdults .= '<AdultName>';
					$NumAdults .= '<Title>'.$request['selectadult'.$no.$a].'</Title>';
					
					$NumAdults .= '<FirstName>'.$request['inptutroomfirstname'.$no.$a].'</FirstName>';
					$NumAdults .= '<LastName>'.$request['inptutroomlastname'.$no.$a].'</LastName>';
					$NumAdults .= '</AdultName>';
					}
				}
				
				if(!empty($request['NumChildren'.$no])){
					
					
					
					for($ch=1;$ch<=$request['NumChildren'.$no];$ch++){
						$NumAdults .='<ChildName>';
						$NumAdults .= '<FirstName>'.$request['childfirstname'.$no.$ch].'</FirstName>';
						$NumAdults .= '<LastName>'.$request['childlastname'.$no.$ch].'</LastName>';
						$NumAdults .= '</ChildName>';
					}
					
				
				}
				$NumAdults .= '</PaxNames>';
				$NumAdults .= '</Room>';
				
			}
			$NumAdults .= '</Rooms>';
		}
		else
		{
		
			
		 return \Response::view('errors.404',array(),404);
		}
	//echo htmlspecialchars($NumAdults);
	//echo "<pre>";
	//print_r(htmlspecialchars($NumAdults));
	//echo "</pre>";
	
	
	   
$url = "http://xmldemo.travellanda.com/xmlv1/HotelBookingRequest.xsd";

$adminportal=DB::select("SELECT * FROM adminportal WHERE id=1");
        
        
        $user = $adminportal[0]->Travelanda_Test_Usename;
		$password = $adminportal[0]->Travelanda_Test_Password;
        
        if($adminportal[0]->Travelanda_Live == '1'){
        
         $user = $adminportal[0]->Travelanda_Test_Usename; //$adminportal[0]->Travelanda_Live_Username;
		 $password = $adminportal[0]->Travelanda_Test_Password; //$adminportal[0]->Travelanda_Live_Password;
        
        
        }

//$user = 'a8f59bf51803d0f189b76cbf45ecff2e';
//$password = 'jRTLGatyuxRx';

$post_string = array('xml'=>'<Request><Head><Username>'.$user.'</Username><Password>'.$password.'</Password><RequestType>HotelBooking</RequestType></Head><Body>'.$NumAdults.'</Body></Request>');

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
	
	return $xmlo;
	
	
	
	
}



public function getBookingDetails($getDetailsBook){
	


$url = "http://xmldemo.travellanda.com/xmlv1/HotelBookingDetailsRequest.xsd";

$checkIn = $getDetailsBook->checkin;
$checkOut = $getDetailsBook->checkout;
$BookingStart =  date("Y-m-d", strtotime($getDetailsBook->Bookdate));
$BookingEnd = date("Y-m-d", strtotime($getDetailsBook->Bookdate));
$adminportal=DB::select("SELECT * FROM adminportal WHERE id=1");
        
        
        $user = $adminportal[0]->Travelanda_Test_Usename;
		$password = $adminportal[0]->Travelanda_Test_Password;
        
        if($adminportal[0]->Travelanda_Live == '1'){
        
         $user = $adminportal[0]->Travelanda_Test_Usename; //$adminportal[0]->Travelanda_Live_Username;
		 $password = $adminportal[0]->Travelanda_Test_Password; //$adminportal[0]->Travelanda_Live_Password;
        
        
        }

//$user = 'a8f59bf51803d0f189b76cbf45ecff2e';
//$password = 'jRTLGatyuxRx';
//$xml = '<Request><Head><Username>'.$user.'</Username><Password>'.$password.'</Password><RequestType>HotelBookingDetails</RequestType></Head><Body><BookingDates><BookingDateStart>'.$checkIn.'</BookingDateStart><BookingDateEnd>'.$checkOut.'</BookingDateEnd></BookingDates></Body></Request>';
$post_string = array('xml'=>'<Request><Head><Username>'.$user.'</Username><Password>'.$password.'</Password><RequestType>HotelBookingDetails</RequestType></Head><Body><YourReference>XMLTEST</YourReference><BookingDates><BookingDateStart>'.$BookingStart.'</BookingDateStart><BookingDateEnd>'.$BookingEnd.'</BookingDateEnd></BookingDates><CheckInDates><CheckInDateStart>'.$checkIn.'</CheckInDateStart><CheckInDateEnd>'.$checkOut.'</CheckInDateEnd></CheckInDates></Body></Request>');

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
	
	return $xmlo;
	
}






public function BookingCancellationAPI($getDetails){
	


$url = "http://xmldemo.travellanda.com/xmlv1/HotelBookingCancelRequest.xsd";
$BookingReference = $getDetails;
$adminportal=DB::select("SELECT * FROM adminportal WHERE id=1");
        
        
        $user = $adminportal[0]->Travelanda_Test_Usename;
		$password = $adminportal[0]->Travelanda_Test_Password;
        
        if($adminportal[0]->Travelanda_Live == '1'){
        
         $user = $adminportal[0]->Travelanda_Test_Usename; //$adminportal[0]->Travelanda_Live_Username;
		 $password = $adminportal[0]->Travelanda_Test_Password; //$adminportal[0]->Travelanda_Live_Password;
        
        
        }

//$user = 'a8f59bf51803d0f189b76cbf45ecff2e';
//$password = 'jRTLGatyuxRx';

$post_string = array('xml'=>'<Request><Head><Username>'.$user.'</Username><Password>'.$password.'</Password><RequestType>HotelBookingCancel</RequestType></Head><Body><BookingReference>'.$BookingReference.'</BookingReference></Body></Request>');

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
	
	return $xmlo;
	
}


//payment

	public function hotelpayment(){  //Make Booking for Expedia API

	    $hotelid =$_GET['hotelid'];               //$_POST[''];

	    $currencyCode = 'USD'; 

		$locale = 'en_US';  //$_POST[''];

		$checkin = $_GET['checkin'];      //$_POST['maxStarRating'];

		$checkout = $_GET['checkout']; //$_POST['maxStarRating'];

		$rateCode = $_GET['rateCode']; //$_POST['maxStarRating'];

		$roomtype = $_GET['roomtype']; //$_POST['maxStarRating'];

		//$minprice = $_POST['minprice'];

		//$maxprice = $_POST['minStarRating'];

	   // $signature = md5($this->apiKey.$Secret.gmdate('U'));
		
		$signature = md5($this->apiKey.$this->Secret.gmdate('U'));

		$upPrice = 0;

		$upStatus = 0;

		$start = date($checkin);

		$end = date($checkout);

		$start_Date = strtotime($start);

		$end_Date = strtotime($end);

		$currentDate = strtotime(date('m/d/Y'));

		$link_adult = '';

		$link_childage = '';

		$link_room = '';

		$link_room = '&norooms='.$_GET['norooms'];

		for($i = 1; $i<=$_GET['norooms']; $i++){

			$link_room .= '&noadult'.$i.'='.$_GET['adult'.$i].'&child'.$i.'='.$_GET['child'.$i];

			$link_adult .= '<Room><numberOfAdults>'.$_GET['adult'.$i].'</numberOfAdults>';

			$link_adult .= '<numberOfChildren>'.$_GET['child'.$i].'</numberOfChildren>';

			for($chi = 1 ; $chi<=1; $chi++){

		//$link_room .= '&childAge'.$i.$chi.'=2';

		//$link_adult .= '<childAge>2</childAge>';

			}

			$link_adult .= '</Room>';

		}

		$hotelurl = '';

		if($start_Date >= $currentDate){
			
			$url  = $this->PAYUrl.'minorRev=26&sig='.$signature.'&apiKey='.$this->apiKey.'&cid='.$this->Cid.'&locale=en_US&currencyCode=USD&_type=xml&xml=<HotelRoomAvailabilityRequest><hotelId>'.$hotelid.'</hotelId><arrivalDate>'.$start.'</arrivalDate><departureDate>'.$end.'</departureDate><roomTypeCode>'.$roomtype.'</roomTypeCode><rateCode>'.$rateCode.'</rateCode><includeDetails>true</includeDetails><RoomGroup>'.$link_adult.'</RoomGroup></HotelRoomAvailabilityRequest>';	

			$result = $this->Getresponce($url);

		}

		return $result;

	}
	
	
	
	
	public function HotelRoomDetail($array1, $array)
	
	{ 
	
	
	$norooms = $array['norooms'];
		$NumAdults = '';
		
		
		if($norooms){
			
			for($no=1;$no<=$norooms;$no++){
				$NumAdults .= '<Room>';
				if(isset($array['adult'.$no])){
					$NumAdults .= '<NumAdults>'.$array['adult'.$no].'</NumAdults>';
				}
				
				if(isset($array['child'.$no])){
					
					$NumAdults .='<Children>';
					
					for($ch=1;$ch<=$array['child'.$no];$ch++){
						
						$NumAdults .= '<ChildAge>'.$array['childage'.$no.$ch].'</ChildAge>';
					}
					$NumAdults .= '</Children>';
				
				}
				$NumAdults .= '</Room>';
				
			}
		}
		
		

	
		$url = "http://xmldemo.travellanda.com/xmlv1/HotelSearchRequest.xsd";
		
		$CheckInDate = date("Y-m-d", strtotime($array['checkin']));
		$CheckOutDate = date("Y-m-d", strtotime($array['checkout']));
        $adminportal=DB::select("SELECT * FROM adminportal WHERE id=1");
        
        
        $user = $adminportal[0]->Travelanda_Test_Usename;
		$password = $adminportal[0]->Travelanda_Test_Password;
        
        if($adminportal[0]->Travelanda_Live == '1'){
        
         $user = $adminportal[0]->Travelanda_Test_Usename; //$adminportal[0]->Travelanda_Live_Username;
		 $password = $adminportal[0]->Travelanda_Test_Password; //$adminportal[0]->Travelanda_Live_Password;
        
        
        }
		//$user = 'a8f59bf51803d0f189b76cbf45ecff2e';
		//$password = 'jRTLGatyuxRx';
		
		//$gethotels=DB::table('gethotels')->where('CityId','=','255059')->offset(10)->limit(0,10)->get();
		//echo "SELECT * FROM gethotels WHERE CityId='".$array['cityid']."' LIMIT ".$pageno_to.", ".$pageno_form."";
	
		
		$hotelidc = '<HotelId>'.$array['hotelid'].'</HotelId>'; 
		
		
		//echo htmlspecialchars($hotelidc);
		
		$post_string = array('xml'=>'<Request><Head><Username>'.$user.'</Username><Password>'.$password.'</Password><RequestType>HotelSearch</RequestType></Head><Body><HotelIds>'.$hotelidc.'</HotelIds><CheckInDate>'.$CheckInDate.'</CheckInDate><CheckOutDate>'.$CheckOutDate.'</CheckOutDate><Rooms>'.$NumAdults.'</Rooms><Nationality>AL</Nationality><Currency>USD</Currency><AvailableOnly>0</AvailableOnly></Body></Request>');
		
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
		
		//aray 
		
		$rom_detail_arry = array();
		foreach($xmlo->Body->Hotels->Hotel->Options->Option as $Optionvalues){
			echo '<pre>';
		print_r($array['optionID']);
		print_r($Optionvalues);
		echo '</pre>';
			if($array['optionID'] == $Optionvalues->OptionId){
			
			$rom_detail_arry[$Optionvalues->OptionId] = $Optionvalues;
			
			}
		}
		
		echo '<pre>';
		print_r($rom_detail_arry);
		echo '</pre>';
		
	   exit;
	
	}
	
    
    
    public function tbobboking_details($id){
    
    
     $url = "https://api.tbotechnology.in/HotelAPI_V7/HotelService.svc";

  // The value for the SOAPAction: header It will change among methods
  $action = "http://TekTravel/HotelBookingApi/HotelBookingDetail";

  // Get the SOAP data into a string, I am using HEREDOC syntax
  // but how you do this is irrelevant, the point is just get the
  // body of the request into a string
  // You need to take reference of document to use specific request for specific method, here was:Action will change
  $mySOAP = <<<EOD
<?xml version="1.0" encoding="utf-8" ?>
<soap:Envelope xmlns:soap="http://www.w3.org/2003/05/soap-envelope" xmlns:hot="http://TekTravel/HotelBookingApi">
<soap:Header xmlns:wsa='http://www.w3.org/2005/08/addressing' >
<hot:Credentials UserName="hldypln" Password="Hol@93669601"> </hot:Credentials>
<wsa:Action>http://TekTravel/HotelBookingApi/HotelBookingDetail</wsa:Action>
<wsa:To>https://api.tbotechnology.in/HotelAPI_V7/HotelService.svc</wsa:To>
</soap:Header>
<soap:Body>
<hot:HotelBookingDetailRequest>
<hot:BookingId>$id</hot:BookingId>
</hot:HotelBookingDetailRequest>
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


$response = preg_replace("/(<\/?)(\w+):([^>]*>)/", "$1$2$3", $result);
$xml = new \SimpleXMLElement($response);

$array = json_decode(json_encode((array)$xml), TRUE);
return $array;


}
   
   
   
   
   
   
    }
	
	
	
	

}
