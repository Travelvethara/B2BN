<?php

namespace App\Http\Controllers\Hotel;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Hotel\HotelApiController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;
use app;

use Crypt;
use Illuminate\Contracts\Encryption\DecryptException;
//use \PDF;

class HotelController extends HotelApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    
    public function __construct()
    {
    	$this->middleware('auth');
    } 
 
	
	
	/**
     * Home search.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
	
    public function homesearch()  //Hotel Search Page 
    {
        header('Access-Control-Allow-Origin: *'); 
    	$query=$_GET['search'];
		$products=DB::table('cities')->where('CityName','LIKE','%'.$query.'%')->get();
		$TBOcities=DB::table('TBOcities')->where('CityName','LIKE',''.$query.'%')->get();
		/*echo '<pre>';
		print_r($TBOcities[0]->CityId);
		echo '</pre>';*/
		
    	$data=array();
    	foreach ($products as $product) {
	       $getcountries=DB::table('getcountries')->where('CountryCode','=',''.$product->CountryCode.'')->get();
	       $data[]=array('value'=>$product->CityName.','.$getcountries[0]->CountryCode.','.$getcountries[0]->CountryName,'cityid' => $product->CityId,'cityname'=>$product->CityName, 'tbocities'=> $TBOcities[0]->CityId);
		}
		if(count($data)){
			return $data;
		}else{
			return ['value'=>'No Result Found','id'=>''];
			
		}
	}
	
	/**
     * Hotelname search.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
	
	
	public function hotelsearchn()  //Hotel Search Page 
    {
 
		header('Access-Control-Allow-Origin: *'); 
    	
    	$query=$_GET['search'];
		
    	$products=DB::table('gethotels')->where('HotelName','LIKE','%'.$query.'%')->get();
		
    	$data=array();
		
    	foreach ($products as $product) {
	   		   
	       $data[]=array('value'=>$product->HotelName);
		}
		if(count($data)){
			return $data;
		}else{
			return ['value'=>'No Result Found','id'=>''];
			
		}
	}
	
	
	/**
     * Hotelname List page. It is get hotels from TBO and travelanda  
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
	

    public function hotellist() //Get datas from Hotel list API Controller
    {
   
		$data['pagename'] = 'hotellist';
         
    	$hotel_list_xml = HotelApiController::hotel_list_xml();
    	$hotel_tbolist_xml = HotelApiController::hotel_tbolist_xml();
	
		$error_array = array();
		
		if(isset($hotel_list_xml->Body->Error)){
			$error_array['error'] = $hotel_list_xml->Body->Error->ErrorText; 
		//return \Response::view('errors.404',array(),404);
		}
		//array
		$hotel_list_Options_array = array();
		$tt=1;
		$i = 1;
		$norooms = $_GET['norooms'];
		$CheckInDate = date("Y-m-d", strtotime($_GET['checkin']));
		$CheckOutDate = date("Y-m-d", strtotime($_GET['checkout']));
		$city = $_GET['city'];
		$NumAdults = '?checkin='.$CheckInDate.'&checkout='.$CheckOutDate.'&city='.$city.'&norooms='.$norooms;
		if($norooms){
			for($no=1;$no<=$norooms;$no++){
				if(isset($_GET['adult'.$no])){
					$NumAdults .= '&adult'.$no.'='.$_GET['adult'.$no];
					$NumAdults .= '&child'.$no.'='.$_GET['child'.$no];
				}
				if(isset($_GET['child'.$no])){
					for($ch=1;$ch<=$_GET['child'.$no];$ch++){
						$NumAdults .= '&childage'.$no.$ch.'='.$_GET['childage'.$no.$ch];
					}
				}
			}
		}
		$hotelDetailArray = array();
		$rrt=1;
		$hotel_list_Options_array_new = array();
		$data['hotelDetailArray'] = $hotel_list_xml->Body->Hotels->Hotel;
        $data['hotel_list_xml'] = $hotel_list_xml;
		if(isset($_GET['hotelname']) && !empty($_GET['hotelname'])){
	        $products = DB::table('gethotels')->where('HotelName','LIKE','%'.$_GET['hotelname'].'%')->get();
			$HotelId = '1234';
			$CheckIn = date("Y-m-d", strtotime($_GET['checkin']));
		    $CheckOut = date("Y-m-d", strtotime($_GET['checkout']));
		    $cityid = $_GET['cityid'];
		    $request = $_GET;
			if(!empty($products[0]->HotelId)){
			    if($products[0]->CityId == $cityid){
						 $HotelId = $products[0]->HotelId;
			    }
			}
			$hoteldetails = HotelApiController::hoteldetails($HotelId, $CheckIn, $CheckOut, $request);
		    $data['hotelDetailArray'] = $hoteldetails->Body->Hotels->Hotel;
		}
		
		if(Auth::user()->user_type == 'SuperAdmin'){
		    $markup =0;
		
		}else{
			if(Auth::user()->user_type == 'AgencyManger'){
				$checkcreditlimit =DB::table('agency')->where('loginid','=',Auth::user()->id)->get();
				if(isset($checkcreditlimit[0]->current_markup)){
					$markup = $checkcreditlimit[0]->current_markup;
				}
			}else if(Auth::user()->user_type == 'SubAgencyManger'){
				$checkcreditlimit_parent =DB::table('agency')->where('loginid','=',Auth::user()->id)->get();
				$checkcreditlimit =DB::table('agency')->where('id','=',$checkcreditlimit_parent[0]->parentagencyid)->get();
				if(isset($checkcreditlimit[0]->current_markup)){
				    $markup = $checkcreditlimit[0]->current_markup;
				}
			 }else if(Auth::user()->user_type == 'UserInfo'){
				$userinformation =DB::table('userinformation')->where('loginid','=',Auth::user()->id)->get();
				if($userinformation[0]->agentid != 0){
						 //agency user
					$checkcreditlimit =DB::table('agency')->where('id','=',$userinformation[0]->agentid)->get();
					if(isset($checkcreditlimit[0]->current_markup)){
						$markup = $checkcreditlimit[0]->current_markup;
					 }
				  }
			  }
			
		}
    	$data['hotel_tbolist_xml'] = $hotel_tbolist_xml;
		$data['hotel_tbolist_xmls'] = $hotel_tbolist_xml;
		$data['hotel_detail_url'] = $NumAdults;
		$data['errorarray'] = $error_array;
		$data['hotel_detail_mark_up'] = $markup;
		//$data['hotel_detail_xml'] = $hotel_list_Options_array;
		$data['hotel_list_Options_array_new'] = $hotel_list_xml->Body->Hotels->Hotel;
    	$RoleId = Auth::user()->RoleID;
    	$RoleIdPremissions = controller::Role_Permissions();
	    //print_r($RoleIdPremissions);
    	$data['Premissions'] = $RoleIdPremissions;
    	return view('hotel.hotellist',$data);
    	
    }
    /**
     * Tbo Hotelprice avaiblity check using ajax call
	 *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */	
	
	public function updateDetailajax(Request $request) // Get Hotel detail api response from Hotel API Controller
    {
		
		session_start();
		
		$array = json_decode(base64_decode($_GET['romm']));
		$rommindexs =  (array) $array;
		
		$rommindexsarray =array();
		$i =1;
		foreach($rommindexs as $rommindexs1){
			$rommindexsarray[$i] = $rommindexs1;
			++$i;
		}
		//Detail
		$session = $_SESSION['sessionId'];
		$hotelId = $_GET['hotelid1'];
		$ResultIndex = $_GET['resultindex'];
		$RoomIndex_message = '<hot:RoomCombination>';
		if(!empty($rommindexsarray[1])){
			foreach($rommindexsarray as $roomCom){
				$RoomIndex_message .= '<hot:RoomIndex>'.$roomCom.'</hot:RoomIndex>';
			}
		}else{
			$RoomIndex_message .= '<hot:RoomIndex>'.$rommindexsarray[1].'</hot:RoomIndex>';
		}
		
		$RoomIndex_message .= '</hot:RoomCombination>';
		$avaiable = 'false';
		$availabilityAndPricing =  HotelApiController::availabilityAndPricing($RoomIndex_message, $session, $hotelId, $ResultIndex);
		if(!empty($rommindexsarray[1])){
			foreach($rommindexsarray as $roomCom){
				$_SESSION['Cancelpolicy'][$_GET['hotelid1']]['RoomIndex'.$roomCom] = $availabilityAndPricing['sBody']['AvailabilityAndPricingResponse']['HotelCancellationPolicies']['CancelPolicies'];
			}
			
		}else{
	
			$_SESSION['Cancelpolicy'][$_GET['hotelid1']]['RoomIndex'.$rommindexsarray[1]] = $availabilityAndPricing['sBody']['AvailabilityAndPricingResponse']['HotelCancellationPolicies']['CancelPolicies'];
		}
		if($availabilityAndPricing['sBody']['AvailabilityAndPricingResponse']['AvailableForBook'] == 'true' && $availabilityAndPricing['sBody']['AvailabilityAndPricingResponse']['AvailableForConfirmBook'] == 'true'){
		
			$avaiable = 'true';
		}
		$resultdata = array('value'=>$avaiable);
		echo json_encode($resultdata);
		exit;
    }
	
	
	/**
     * Tbo HotelDatail function. Its will show tbo and travelanada room list.
	 *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */	
    
    public function hoteldetail(Request $request) // Get Hotel detail api response from Hotel API Controller
    {	
        $data['pagename'] = 'hotellist';
        $id = $request->input('hotelid');
		$checkin = $request->input('checkin');
		$checkout = $request->input('checkout');
		$tboroomcount = array();
		$data['RoomCombinationArray'] =  '';
		if(isset($_GET['hotelid1']) && !empty($_GET['hotelid1'])){
			$tboroomcount = array();
			$RoomCombinationarray_Combination = array();
			$hotelDetailsTBO = HotelApiController::hotelDetailsTBOhotelDetail($_GET);
			$RoomCombinationarray_Combination = array();
			if($hotelDetailsTBO['sBody']['HotelRoomAvailabilityResponse']['Status']['StatusCode'] == '01'){
	            if(empty($hotelDetailsTBO['sBody']['HotelRoomAvailabilityResponse']['HotelRooms']['HotelRoom'][0])){
					//roomindex
					$RoomIndex = $hotelDetailsTBO['sBody']['HotelRoomAvailabilityResponse']['HotelRooms']['HotelRoom']['RoomIndex'];
					$RoomCombinationarray_Combination[0]['RoomIndex'.$RoomIndex] = $RoomIndex;
					$RoomCombinationarray_Combination[0]['RoomTypeName'.$RoomIndex] = $hotelDetailsTBO['sBody']['HotelRoomAvailabilityResponse']['HotelRooms']['HotelRoom']['RoomTypeName'];
					$RoomCombinationarray_Combination[0]['RoomTypeCode'.$RoomIndex] = $hotelDetailsTBO['sBody']['HotelRoomAvailabilityResponse']['HotelRooms']['HotelRoom']['RoomTypeCode'];
					$RoomCombinationarray_Combination[0]['RatePlanCode'.$RoomIndex] = $hotelDetailsTBO['sBody']['HotelRoomAvailabilityResponse']['HotelRooms']['HotelRoom']['RatePlanCode'];
					$RoomCombinationarray_Combination[0]['TotalFare'.$RoomIndex] = $hotelDetailsTBO['sBody']['HotelRoomAvailabilityResponse']['HotelRooms']['HotelRoom']['RoomRate']['attributes']['TotalFare'];
				}
				//foreach
				if(!empty($hotelDetailsTBO['sBody']['HotelRoomAvailabilityResponse']['HotelRooms']['HotelRoom'][0])){
					foreach($hotelDetailsTBO['sBody']['HotelRoomAvailabilityResponse']['HotelRooms']['HotelRoom'] as $HotelRoom){
						$RoomIndex = $HotelRoom['RoomIndex'];
						$RoomCombinationarray_Combination[0]['RoomIndex'.$RoomIndex] = $RoomIndex;
						$RoomCombinationarray_Combination[0]['RoomTypeName'.$RoomIndex] = $HotelRoom['RoomTypeName'];
						$RoomCombinationarray_Combination[0]['RoomTypeCode'.$RoomIndex] = $HotelRoom['RoomTypeCode'];
						$RoomCombinationarray_Combination[0]['RatePlanCode'.$RoomIndex] = $HotelRoom['RatePlanCode'];
						$RoomCombinationarray_Combination[0]['TotalFare'.$RoomIndex] = $HotelRoom['RoomRate']['attributes']['TotalFare'];
					}
				}
				
              $data['RoomCombinationarray_Combination'] =  $RoomCombinationarray_Combination;

		   }
				// 1room room combination
		   $RoomCombinationArray = array();
	
		   if($hotelDetailsTBO['sBody']['HotelRoomAvailabilityResponse']['Status']['StatusCode'] == '01'){
				
		       if(empty($hotelDetailsTBO['sBody']['HotelRoomAvailabilityResponse']['OptionsForBooking']['RoomCombination'][0])){
		            $RoomTypeCode = '';
					$rc =1;
		            $RoomCombinationArray[1]['RoomCombination']['index'][1] = $hotelDetailsTBO['sBody']['HotelRoomAvailabilityResponse']['OptionsForBooking']['RoomCombination']['RoomIndex'];
				    $roomindex = $hotelDetailsTBO['sBody']['HotelRoomAvailabilityResponse']['OptionsForBooking']['RoomCombination']['RoomIndex'];
					$RoomTypeCode .= '&RoomTypeCode'.$rc.'='.$RoomCombinationarray_Combination[0]['RoomTypeCode'.$roomindex];
					$RoomTypeCode .= '&RatePlanCodes'.$rc.'='.$RoomCombinationarray_Combination[0]['RatePlanCode'.$roomindex];
					$RoomTypeCode .= '&RoomIndexs'.$rc.'='.$RoomCombinationarray_Combination[0]['RoomIndex'.$roomindex];
					$RoomCombinationArray[1]['RoomCombination']['rooomcodes'] = $RoomTypeCode;
				}
				if(!empty($hotelDetailsTBO['sBody']['HotelRoomAvailabilityResponse']['OptionsForBooking']['RoomCombination'][0])){
		              $tc = 1;
					  foreach($hotelDetailsTBO['sBody']['HotelRoomAvailabilityResponse']['OptionsForBooking']['RoomCombination'] as $RoomCombination){
				
						$RoomIndexCount = count($RoomCombination['RoomIndex']);  
						$RoomTypeCode ='';
						if($RoomIndexCount>=2){
							 $rc = 1;
							 foreach($RoomCombination['RoomIndex'] as $RoomCombinationRoomIndex){
							    $RoomCombinationArray[$tc]['RoomCombination']['index'][$rc] = $RoomCombinationRoomIndex;
							    $RoomTypeCode .= '&RoomTypeCode'.$rc.'='.$RoomCombinationarray_Combination[0]['RoomTypeCode'.$RoomCombinationRoomIndex];
								$RoomTypeCode .= '&RatePlanCodes'.$rc.'='.$RoomCombinationarray_Combination[0]['RatePlanCode'.$RoomCombinationRoomIndex];
								$RoomTypeCode .= '&RoomIndexs'.$rc.'='.$RoomCombinationarray_Combination[0]['RoomIndex'.$RoomCombinationRoomIndex];
							    ++$rc;
							 }
							 $RoomCombinationArray[$tc]['RoomCombination']['rooomcodes'] = $RoomTypeCode;
						 }else{
							 $rc = 1;
							 $RoomCombinationArray[$tc]['RoomCombination']['index'][$rc] = $RoomCombination['RoomIndex'][0];
							 $RoomTypeCode .= '&RoomTypeCode'.$rc.'='.$RoomCombinationarray_Combination[0]['RoomTypeCode'.$RoomCombination['RoomIndex'][0]];
							 $RoomTypeCode .= '&RatePlanCodes'.$rc.'='.$RoomCombinationarray_Combination[0]['RatePlanCode'.$RoomCombination['RoomIndex'][0]];
							 $RoomTypeCode .= '&RoomIndexs'.$rc.'='.$RoomCombinationarray_Combination[0]['RoomIndex'.$RoomCombination['RoomIndex'][0]];
							 $RoomCombinationArray[$tc]['RoomCombination']['rooomcodes'] = $RoomTypeCode;
							 
						 }
					   ++$tc;
					  }
				}
				$data['RoomCombinationArray'] =  $RoomCombinationArray;
				//romdetail get
			 
		     }

		}
		$data['tboroomcount'] = $tboroomcount;
    	$hoteldetail = HotelApiController::hoteldetails($id,$checkin,$checkout,$request);
		$optionsID = '';
		$policiesdetails_dead_array = array();
    	$hotel_Info = HotelApiController::Gethotelresponse($id);
		if(Auth::user()->user_type == 'SuperAdmin'){
			
		    $markup =0;
		
		}
		
		else{
		    if(Auth::user()->user_type == 'AgencyManger'){
			
		        $checkcreditlimit =DB::table('agency')->where('loginid','=',Auth::user()->id)->get();
			
			    if(isset($checkcreditlimit[0]->current_markup)){
			
		            $markup = $checkcreditlimit[0]->current_markup;
			    }
		    }else if(Auth::user()->user_type == 'SubAgencyManger'){
			
		        $checkcreditlimit_parent =DB::table('agency')->where('loginid','=',Auth::user()->id)->get();
			
			    $checkcreditlimit =DB::table('agency')->where('id','=',$checkcreditlimit_parent[0]->parentagencyid)->get();
			
			    if(isset($checkcreditlimit[0]->current_markup)){
			
		            $markup = $checkcreditlimit[0]->current_markup;
			
			     }
		    }else if(Auth::user()->user_type == 'UserInfo'){
                $userinformation =DB::table('userinformation')->where('loginid','=',Auth::user()->id)->get();
                if($userinformation[0]->agentid != 0){
				 //agency user
			        $checkcreditlimit =DB::table('agency')->where('id','=',$userinformation[0]->agentid)->get();
			        if(isset($checkcreditlimit[0]->current_markup)){
		                $markup = $checkcreditlimit[0]->current_markup;
			        }
		        }
		    }
		
	   }
       $data['hotel_details'] = '';
	   $data['hotel_Info'] = '';
	   $data['policiesdetails_dead_array'] = '';
	   if(isset($_GET['hotelid1']) && empty($_GET['hotelid'])){
	       $tboHolidaysHotelDetails = HotelApiController::tboHolidaysHotelDetails($_GET['hotelid1']);
		   $data['hotel_Info_tbo'] =	$tboHolidaysHotelDetails['sBody']['HotelDetailsResponse']['HotelDetails'];	
	   }
       if(isset($_GET['hotelid']) && !empty($_GET['hotelid'])){
           $data['hotel_details'] = $hoteldetail->Body->Hotels->Hotel->Options;
    	   $data['hotel_Info'] = $hotel_Info->Body->Hotels->Hotel;
		   $data['policiesdetails_dead_array'] = $policiesdetails_dead_array;
	   }
       $RoleId = Auth::user()->RoleID;
       $RoleIdPremissions = controller::Role_Permissions();
	   //print_r($RoleIdPremissions);
       $data['Premissions'] = $RoleIdPremissions;
	   $data['hotel_detail_mark_up'] = $markup;
       return view('hotel.hoteldetail',$data);
    }
    
	
	
	/**
     * Tbo Hotellist function. Its will get from hotel image using API.
	 *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */	
    
    public function ajaxhotellist()  // Load more hotel lists function Ajax. Get resposne from HotelApiController
    {
		
    	$hotel_list_xml = HotelApiController::hotel_list_xml();
    	$hotel_tbolist_xml = '';//HotelApiController::hotel_tbolist_xml();
		$error_array = array();
		
		if(isset($hotel_list_xml->Body->Error)){
			$error_array['error'] = $hotel_list_xml->Body->Error->ErrorText; 
		}
		//array
		$hotel_list_Options_array = array();
		$tt=1;
		$i = 1;		
		$hotelDetailArray = array();
		$rrt=1;
		$ss = 1;
		$imagess = '';
		//$divcount = $_GET['divcount']*15;
		 $hotel_list_Options_array_new = array();
		foreach($hotel_list_xml->Body->Hotels->Hotel as $Hotel_v){
			 if($_GET['hotelids'] == $Hotel_v->HotelId){ //if($rrt > $divcount){
				$hotelDetailArray[$rrt] = $Hotel_v;
				$Gethotelresponse = $this->Gethotelresponse($Hotel_v->HotelId);
				$hotelid = $Gethotelresponse->Body->Hotels->Hotel->HotelId;
				$imagess = $Gethotelresponse->Body->Hotels->Hotel->Images->Image[0];
				$imagesss = $Gethotelresponse->Body->Hotels->Hotel->Images->Image;
			 }
		}
		
		if(isset($imagess)){
		    echo $imagess;
		}else{
		    echo asset('img/noimage.png');	
		}
//echo json_encode($hotel_list_Options_array_new);

     }
    
    
	/**
     * Travelanda Hotelpayment function. Its will get from user detail.
	 *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */	
	
    
    public function payment(Request $request)  //Send booking request to API from Hotel API Controller
    {
		
		$data['pagename'] = 'hotellist';

        $id = $request->input('hotelid');
		  
		$checkin = $request->input('checkin');
		  
		$checkout = $request->input('checkout');
		  
		$optionID = $_GET['optionID'];
		if(!empty($_GET['bookingid'])){ 
		    $bookId = $_GET['bookingid'];
		    $Book_details = DB::table('payment')->where('id','=',$bookId)->get();
		}

    	
		 $hotel_Info = HotelApiController::Gethotelresponse($id);
		 $policiesdetails = HotelApiController::hotelpolicies($optionID);
		 
		 
		 if(Auth::user()->user_type == 'SuperAdmin'){
			
		     $markup =0;
		
		 }else{
		     if(Auth::user()->user_type == 'AgencyManger'){
			
		         $checkcreditlimit =DB::table('agency')->where('loginid','=',Auth::user()->id)->get();
			
			     if(isset($checkcreditlimit[0]->current_markup)){
			
		             $markup = $checkcreditlimit[0]->current_markup;
			      }
		    }else if(Auth::user()->user_type == 'SubAgencyManger'){
			
		        $checkcreditlimit_parent =DB::table('agency')->where('loginid','=',Auth::user()->id)->get();
			
			    $checkcreditlimit =DB::table('agency')->where('id','=',$checkcreditlimit_parent[0]->parentagencyid)->get();
			
			    if(isset($checkcreditlimit[0]->current_markup)){
			
		            $markup = $checkcreditlimit[0]->current_markup;
			
			    }
		    }else if(Auth::user()->user_type == 'UserInfo'){
			

                $userinformation =DB::table('userinformation')->where('loginid','=',Auth::user()->id)->get();
			 
                if($userinformation[0]->agentid != 0){
				 //agency user
			        $checkcreditlimit =DB::table('agency')->where('id','=',$userinformation[0]->agentid)->get();
			        if(isset($checkcreditlimit[0]->current_markup)){
		                $markup = $checkcreditlimit[0]->current_markup;
			
			        }
		        }
		   }
		}


	    
		$hoteldetail = HotelApiController::hoteldetails($id,$checkin,$checkout,$request);
	   
	    $getDatesFromRange =  $this->getDatesFromRange($_GET['checkin'],$_GET['checkout']);

        array_pop($getDatesFromRange);

        $data['getDatesFromRange'] = $getDatesFromRange;

		if(!empty($_GET['bookingid'])){
			   
		    $data['Book_details'] = $Book_details;
		  
		 }
		$data['hotel_detail_mark_up'] = $markup;
    	$data['hotel_Info'] = $hotel_Info;
		$data['hotel_details'] = $hoteldetail;
		$data['policiesdetails'] = $policiesdetails->Body;
    	$RoleId = Auth::user()->RoleID;
    	$RoleIdPremissions = controller::Role_Permissions();
	   //print_r($RoleIdPremissions);
    	$data['Premissions'] = $RoleIdPremissions;
    	
    	return view('hotel.payment',$data);
    	
    }
	
	/**
     * TBO Hotelpayment function. Its will get from user detail.
	 *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */	
	
	
	
	
	public function tboPayment(Request $request)  //Send booking request to API from Hotel API Controller
    {
		
		
		$data['pagename'] = 'hotellist';
		$id = $request->input('hotelid');
		$checkin = $request->input('checkin');
		$checkout = $request->input('checkout');
		if(!empty($_GET['bookingid'])){ 
		    $bookId = $_GET['bookingid'];
		    $Book_details = DB::table('payment')->where('id','=',$bookId)->get();
		}
		session_start();
		$session = $_SESSION['sessionId'];
		$ResultIndex = $_GET['resultindex'];
		$session = $_SESSION['sessionId'];
		$canacellation_policy_array = array();
		$RoomIndex_message = '<hot:RoomCombination>';
		for($roo=1;$roo<=$_GET['norooms'];$roo++){
		    $RoomIndex_message .= '<hot:RoomIndex>'.$_GET['RoomIndexs'.$roo].'</hot:RoomIndex>';
		    $canacellation_policy_array[$_GET['RoomIndexs1']] = $this->canacellation_policy_Pay($_GET['RoomIndexs'.$roo], $session, $ResultIndex);
		}
		$RoomIndex_message .= '</hot:RoomCombination>';
	
		$hotel_Info = HotelApiController::tboHolidaysHotelDetails($id);
		
		$hotelId = $_GET['hotelid'];
		
		$availabilityAndPricing =  HotelApiController::availabilityAndPricing($RoomIndex_message, $session, $hotelId, $ResultIndex);
		
		$tboHolidaysHotelDetails_pay = $_SESSION['RoomDetails'];
		
		
		$priceinroom = array();
		$priceinroomdetailget = array();
		
		if(isset($tboHolidaysHotelDetails_pay['sBody']['HotelRoomAvailabilityResponse']['HotelRooms']['HotelRoom'])){
		    foreach($tboHolidaysHotelDetails_pay['sBody']['HotelRoomAvailabilityResponse']['HotelRooms']['HotelRoom'] as $roomdeatil){
		        for($r=1;$r<=$_GET['norooms'];$r++){
		            if($_GET['RoomTypeCode'.$r] == $roomdeatil['RoomTypeCode']){
		                $RoomIndex = $roomdeatil['RoomIndex'];
		                $priceinroom = $roomdeatil;
		                $priceinroomdetailget['RoomIndex'][$RoomIndex] = $roomdeatil;
		             }
		         }
		
		    }
		}
		$ResultIndex = $_GET['resultindex'];
		for($t=1;$t<=$_GET['norooms'];$t++){
		    $policiesdetails = $_SESSION['Cancelpolicy'][$_GET['hotelid']]['RoomIndex'.$_GET['RoomIndexs'.$t]];
		}
		
		$data['priceinroom'] = $priceinroom;
		
		$data['priceinroomdetailget'] = $priceinroomdetailget;
		
		if(Auth::user()->user_type == 'SuperAdmin'){
		
		    $markup =0;
		
		}
		
		else{
		
		    if(Auth::user()->user_type == 'AgencyManger'){
		        $checkcreditlimit =DB::table('agency')->where('loginid','=',Auth::user()->id)->get();
		            if(isset($checkcreditlimit[0]->current_markup)){
		                $markup = $checkcreditlimit[0]->current_markup;
		            }
		    }else if(Auth::user()->user_type == 'SubAgencyManger'){
		
		        $checkcreditlimit_parent =DB::table('agency')->where('loginid','=',Auth::user()->id)->get();
		
		        $checkcreditlimit =DB::table('agency')->where('id','=',$checkcreditlimit_parent[0]->parentagencyid)->get();
		
		        if(isset($checkcreditlimit[0]->current_markup)){
		
		            $markup = $checkcreditlimit[0]->current_markup;
		
		        }
		    }else if(Auth::user()->user_type == 'UserInfo'){
		        $userinformation =DB::table('userinformation')->where('loginid','=',Auth::user()->id)->get();
		        if($userinformation[0]->agentid != 0){
		//agency user
		            $checkcreditlimit =DB::table('agency')->where('id','=',$userinformation[0]->agentid)->get();
		            if(isset($checkcreditlimit[0]->current_markup)){
		                $markup = $checkcreditlimit[0]->current_markup;
		            }
		        }
		    }
		
		}
		
		
		
		$hoteldetail = HotelApiController::hoteldetails($id,$checkin,$checkout,$request);
		
		$getDatesFromRange =  $this->getDatesFromRange($_GET['checkin'],$_GET['checkout']);
		
		array_pop($getDatesFromRange);
		
		$data['getDatesFromRange'] = $getDatesFromRange;

		if(!empty($_GET['bookingid'])){
		
		    $data['Book_details'] = $Book_details;
		
		}
		$data['hotel_detail_mark_up'] = $markup;
		
		$data['hotel_Info'] = $hotel_Info;
		$data['policiesdetails'] = $canacellation_policy_array[$_GET['RoomIndexs1']];
		$RoleId = Auth::user()->RoleID;
		$RoleIdPremissions = controller::Role_Permissions();
		//print_r($RoleIdPremissions);
		$data['Premissions'] = $RoleIdPremissions;
		return view('hotel.tbopayment',$data);
    }
	
	
	/**
     * TBO Hotel Booking function. Its will get from user detail.
	 *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */	
	
	
	
	 public function ajaxhotelpaymenttbo(Request $request) //Send booking request to API from Hotel API Controller
     {

		require_once('tcpdf/pdfblock/tcpdf_include.php');
	    require_once('tcpdf/tcpdf.php');  
		$data = $request->all();
		$home_url = URL::to("/");
		$norooms = $request['noofroom'];
	    $postarray = array();
		try {
	            $canceldeadline_confirm_d = Crypt::decrypt($request->input('canceldeadline_confirm'));
		        $canceldeadline_confirm = base64_decode($canceldeadline_confirm_d);
				 //echo $canceldeadline;
	        } catch (DecryptException $e) {
		        return \Response::view('errors.404',array(),404);
		    }

	    try {
		    $canceldeadline_id = Crypt::decrypt($request->input('canceldeadline'));
		    $canceldeadline = base64_decode($canceldeadline_id);
				 //echo $canceldeadline;
		    } catch (DecryptException $e) {
				
		        return \Response::view('errors.404',array(),404);
		    }

		try {
			   $totalp_id = Crypt::decrypt($request->input('totalprice'));
			   $totalprice = base64_decode($totalp_id);
			} catch (DecryptException $e) {
				   return \Response::view('errors.404',array(),404);
			}
				
			if($request->input('DiscountApplied') != 0){
	            try {
				        $DiscountApplied_id = Crypt::decrypt($request->input('DiscountApplied'));
				        $DiscountApplied = base64_decode($DiscountApplied_id);
				    } catch (DecryptException $e) {
				
				        return \Response::view('errors.404',array(),404);
				    }
			 }else{
			        $DiscountApplied = 0;
			 }
			  
			  if($request->input('markupprice') != 0){
	              try {
				          $markupprice_id = Crypt::decrypt($request->input('markupprice'));
		                  $markupprice = base64_decode($markupprice_id);
				      } catch (DecryptException $e) {
				
				          return \Response::view('errors.404',array(),404);
				      }
			  }else{
			     $markupprice = 0;
			  }
    $room_daily_price_array = array();
	
	$t= 1;
	
	foreach($request->input('roomdailycontnt') as $roomdailycontnt){
	    $room_daily_price_array[$t] = base64_decode(Crypt::decrypt($roomdailycontnt));
	    ++$t;
	}
	    for($ro=0;$ro<$norooms;$ro++){
		    $resf = $ro+1;
		
		    $postarray[$ro]['RoomId']= $_POST['RoomId'.$resf];
		
		    $postarray[$ro]['adult']= $_POST['NumAdults'.$resf];
		//$postarray[$ro]['adultName']=$_GET['adultname'.$ro];
		     $nosdult = $_POST['NumAdults'.$resf];
		     for($ad=1;$ad<=$nosdult; $ad++){
			     $postarray[$ro]['title'][$ad]=$_POST['selectadult'.$resf.$ad];
			     $postarray[$ro]['firstname'][$ad]=$_POST['inptutroomfirstname'.$resf.$ad];
			     $postarray[$ro]['lastname'][$ad]=$_POST['inptutroomlastname'.$resf.$ad];
			     $postarray[$ro]['child']=$_POST['NumChildren'.$resf];
				
				 $nochild = $_POST['NumChildren'.$resf];
				 for($co=1;$co<=$nochild;$co++){
					$postarray[$ro]['childFirstName'][$co]=$_POST['childfirstname'.$resf.$co];
					$postarray[$ro]['childLastName'][$co]=$_POST['childlastname'.$resf.$co];	
					$postarray[$ro]['childage'][$co]=$_POST['childage'.$resf.$co];
				}
			
			 }
	   
	   
	     } 
		 
		 
		/* echo '<pre>';
		 print_r($postarray);
		 echo '</pre>';
		exit;*/
		$post = array();
		for($ro=0;$ro<$norooms;$ro++){
			$resf = $ro+1;
		    $post['RoomId']=$_POST['RoomId'.$resf];
		 }
	    $inputfirstname = '';
		$inputlastname= '';
		$inputemail = '';
		$inputphone = '';
		if($request->input('inputemail')){
		    $inputemail = $request->input('inputemail');
		}
		if($request->input('inputphone')){
			$inputphone = $request->input('inputphone');
		}
		if($request->input('inputfirstname')){
			$inputfirstname = $request->input('inputfirstname');
		}
		if($request->input('inputlastname')){
			$inputlastname = $request->input('inputlastname');
		}
		
		$datainsert['firstname'] = $inputfirstname;
		$datainsert['lastname'] = $inputlastname;
		$datainsert['CancellationDeadline'] = $canceldeadline;
		$datainsert['guest'] =serialize($postarray);
		//$datainsert['firstname'] = $request->input('inputfirstname');
		//$datainsert['lastname'] = $request->input('inputlastname');
		$datainsert['email'] = $inputemail;
		$datainsert['phone'] = $inputphone;
		$datainsert['no_of_room'] = $request->input('noofroom');
		$datainsert['markupprice'] = $markupprice;
		$datainsert['hotelid'] = $request->input('hotelid');
		$datainsert['checkin'] = $request->input('checkin');
		$datainsert['checkout'] = $request->input('checkout');
		$datainsert['totalprice'] = $totalprice;
		$datainsert['RoomTypeCode'] = 'ghgh';
		$datainsert['RatePlanCode'] = 'ghg';
		$datainsert['RoomIndex'] = '65';
		$datainsert['supplier'] = 'tbo';
		$datainsert['RoomId'] = serialize($post);
		$datainsert['Bookdate'] = date('Y-m-d');
		$serializeValue = serialize($postarray);
		$datainsert['roomdailycontnt'] = serialize($room_daily_price_array);
		$datainsert['booking_confirm'] = 0;
		if(Auth::user()->user_type == 'SuperAdmin'){
			
		        // $datainsert['booking_confirm'] = 1;
		}
		
		else{
		//agency manager
			if(Auth::user()->user_type == 'AgencyManger'){
			
			    $checkcreditlimit =DB::table('agency')->where('loginid','=',Auth::user()->id)->get();
			
			    if($datainsert['totalprice']<=$checkcreditlimit[0]->current_credit_limit){
			        $bal_limit = $checkcreditlimit[0]->current_credit_limit - $datainsert['totalprice'];
				}
			} 
			
			else if(Auth::user()->user_type == 'SubAgencyManger'){
			
			
			    $checkcreditlimit_parent =DB::table('agency')->where('loginid','=',Auth::user()->id)->get();
			
			    $checkcreditlimit =DB::table('agency')->where('id','=',$checkcreditlimit_parent[0]->parentagencyid)->get();

			        if($datainsert['totalprice']<=$checkcreditlimit[0]->current_credit_limit){
			            $bal_limit = $checkcreditlimit[0]->current_credit_limit - $datainsert['totalprice'];
	                }
			
			}else if(Auth::user()->user_type == 'UserInfo'){
                 $userinformation =DB::table('userinformation')->where('loginid','=',Auth::user()->id)->get();
                 if($userinformation[0]->agentid != 0){
				 //agency user
			         $checkcreditlimit =DB::table('agency')->where('id','=',$userinformation[0]->agentid)->get();
			         if($datainsert['totalprice']<=$checkcreditlimit[0]->current_credit_limit){
			             $bal_limit = $checkcreditlimit[0]->current_credit_limit - $datainsert['totalprice'];
			         }
			      }
			
			}

		
		
		}
		//CHECK ADMIN
		
		if(Auth::user()->user_type == 'SuperAdmin'){
			
			$datainsert['login_id'] = 0;
			$datainsert['user_type'] = 'SuperAdmin';
		}else{
		    $datainsert['login_id'] = Auth::user()->id;
		    $datainsert['user_type'] = Auth::user()->user_type;
		}
		
		if($datainsert['booking_confirm'] == 0){

		    $hotel_booking = HotelApiController::TboBookingResults($request);
		    $BookingId =$hotel_booking['sBody']['HotelBookResponse']['BookingId'];
		    $BookingStatus = $hotel_booking['sBody']['HotelBookResponse']['BookingStatus'];
		    $datainsert['BookingReference'] = $BookingId ;
		    $datainsert['BookingStatus'] = $BookingStatus;
		    $data['BookingId'] = $BookingId;

		  if($hotel_booking['sBody']['HotelBookResponse']['Status']['StatusCode'] == '03'){
				$ErrorText = $hotel_booking['sBody']['HotelBookResponse']['Status']['Description'];
				$datainsert['ErrorText'] = $hotel_booking['sBody']['HotelBookResponse']['Status']['Description'];
				$datainsert['BookingStatus'] = 'Failed';
				DB::table('payment')->insertGetId( $datainsert );
				return redirect('/errorbooking'); 
			    exit;	
				
			}
			
			
			if($hotel_booking['sBody']['HotelBookResponse']['Status']['StatusCode'] == '04-33'){
				$ErrorText = $hotel_booking['sBody']['HotelBookResponse']['Status']['Description'];
				$datainsert['ErrorText'] = $hotel_booking['sBody']['HotelBookResponse']['Status']['Description'];
				$datainsert['BookingStatus'] = 'Failed';
				DB::table('payment')->insertGetId( $datainsert );
				return redirect('/errorbooking');  
			    exit;	
				
			}
	
			if($BookingStatus == 'Failed'){
				$ErrorText = $hotel_booking['sBody']['HotelBookResponse']['Status']['Description'];
				$datainsert['ErrorText'] = $hotel_booking['sBody']['HotelBookResponse']['Status']['Description'];
				$datainsert['BookingStatus'] = 'Failed';
				DB::table('payment')->insertGetId( $datainsert );
				return redirect('/errorbooking'); 
			    exit;	
			}
			
			
		    if(!isset($BookingId)){
			    return redirect('/errorbooking'); 
			    exit;
		    }
		
			
			


		    $booking_staus = '<span style="color:green">Complete</sapn>';
		    $booking_id  = $BookingId;
		}else{
		    $booking_staus = '<span style="color:red">Pending</span>';
		    $booking_id  = '-';
		}
		
		//mail
		$roomdeatai_arry = array();
				$roomtype = '';
		$html_room_pdf = '';
		for($ro=1;$ro<=$request->input('noofroom');$ro++){
			$roomdeatai_arry[$ro]['RoomName'] = $request->input('RoomName'.$ro);
			$roomdeatai_arry[$ro]['NumAdults'] = $request->input('NumAdults'.$ro);
			$roomdeatai_arry[$ro]['NumChildren'] = $request->input('NumChildren'.$ro);
			$roomdeatai_arry[$ro]['RoomPrice'] = $request->input('RoomPrice'.$ro);
			$roomdeatai_arry[$ro]['RoomId'] = $request->input('RoomId'.$ro);
			$roomtype .= '<tr>
					<td style="padding:10px 0px 10px 10px;border: 1px solid #e3e3e3;">'.$request->input('RoomName'.$ro).'</td>
					<td style="padding:10px 0px 10px 10px;border: 1px solid #e3e3e3;">'.$request->input('NumAdults'.$ro).'</td>
					 <td style="padding:10px 0px 10px 10px;border: 1px solid #e3e3e3;">'.$request->input('NumChildren'.$ro).'</td>
					<td style="padding:10px 0px 10px 10px;border: 1px solid #e3e3e3;">$ '.$request->input('RoomFare'.$ro).'</td>
				  </tr>';
				  $noro = $ro +1;
			$html_room_pdf .= '<tr style="line-height: 30px;">
					<td style="border-bottom: 1px solid #b0b0b0;border-right: 1px solid #b0b0b0;border-left: 1px solid #b0b0b0">'.$noro.'</td>
					<td style="border-bottom: 1px solid #b0b0b0;font-size: 10px;border-right: 1px solid #b0b0b0">'.$request->input('RoomName'.$ro).'</td>
					<td style="border-bottom: 1px solid #b0b0b0;border-right: 1px solid #b0b0b0">'.$request->input('NumAdults'.$ro).'</td>
					<td style="border-bottom: 1px solid #b0b0b0;border-right: 1px solid #b0b0b0">'.$request->input('NumChildren'.$ro).'</td>
					<td style="border-bottom: 1px solid #b0b0b0;border-right: 1px solid #b0b0b0">$ '.$request->input('RoomFare'.$ro).'</td>
				  </tr>';	  
		}

		$star = '';
		for($so=0;$so<$request->input('Hotelstar');$so++){
		    $star .= '<img style="width:16px" src="'.$home_url.'/img/star.png" />';
		}
		
		$mail_template = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
		<html xmlns="http://www.w3.org/1999/xhtml">
		<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>Untitled Document</title>
		</head>
		<link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" rel="stylesheet">
		
		<body class="margin:0">
		  <div class="voucher-backgrouund" style="font-family: "Poppins", sans-serif;background: #f2f3f8; font-size:14px;">
			<div class="voucher-contents" style="max-width:900px;margin: auto;color: #575962;-webkit-box-shadow: 0 1px 15px 1px rgba(69,65,78,.08);-moz-box-shadow: 0 1px 15px 1px rgba(69,65,78,.08);box-shadow: 0 1px 15px 1px rgba(69,65,78,.08);background-color: #fff;">
				<div class="voucher-header" style="background:url('.$home_url.'/img/voucherbackground.jpg)">
				  <div class="voucher-haeader-background" style="padding: 75px">
					<div class="invoice-headingh-logo" style="position:relative;">
						<div class="invoicheading" style="display:inline-block; font-size: 37px;text-transform: uppercase;font-weight: 600;color: #ffffff;">
							Booking 
						</div>
						<div class="companylogo" style="    position: absolute;right: 0;top: 50%;margin-top: -14px;">
							<img src="'.$home_url.'/img/white_logo_default_dark.png" />
						</div>
						<div class="clear" style="display:table;clear:both;">
						</div>
					</div
					><div class="hoteladdress" style="padding-bottom: 30px;margin-bottom: 30px; border-bottom: 1px solid #837dd1">
					<address style="text-align: right;font-weight: 100;font-size: 14px; color: #cecdcd;">
						Cecilia Chapman, 711-2880 Nulla St, Mankato
						<p style="margin:0">Mississippi 96522</p>
					</address>
					</div>
				</div>
				</div>
				<div class="voucher-body" style="padding:75px;position:relative;">
				
				
				<div class="voucher-right" style="margin-bottom:40px">
					  
						<div class="voucher-right-hotel" style="font-size: 18px;color: #fe21be;font-weight: 500;margin-bottom: 10px;">
							'.$request->input('Hotelname').'
						</div>
						<div class="voucher-right-ratings" style="margin-bottom:5px">
							'.$star.'
						</div>
						 <div class="voucher-right-address">
							'.$request->input('Hoteladdress').'
						</div>
					</div>
					
					
					<div class="voucher-left" style="margin-bottom:30px">
					
					
					<div class="voucher-left-main">
					 <div class="voucher-left-parent" style="margin-bottom:14px;width:50%;float:left;">
					 <div class="voucher-l-left" style="font-weight: 600;width: 120px;float:left;">
						First Name:
						</div>
					 <div class="voucher-r-right" style="margin-right:123px;color: #9699a2;font-size: 13px;">
						 '.$request->input('inputfirstname').'
						</div>
						<div class="clear" style="display:table;clear:both;">
					 </div>
					 </div>   
					 <div class="voucher-left-parent" style="margin-bottom:14px;width:50%;float:left;">
					 <div class="voucher-l-left" style="font-weight: 600;width: 120px;float:left;">
						 Last Name:
						</div>
					 <div class="voucher-r-right" style="margin-right:123px;color: #9699a2;font-size: 13px;">
						 '.$request->input('inputlastname').'
						</div>
						<div class="clear" style="display:table;clear:both;">
					 </div>
					 </div>
					  <div class="clear" style="display:table;clear:both;">
					 </div>
					 </div>
					 
					 
					 
					 <div class="voucher-left-main">
					 <div class="voucher-left-parent" style="margin-bottom:14px;width:50%;float:left;">
					 <div class="voucher-l-left" style="font-weight: 600;width: 120px;float:left;">
					   Email:
						</div>
					 <div class="voucher-r-right" style="margin-right:123px;color: #9699a2;font-size: 13px;">
						'.$inputemail.'
						</div>
						<div class="clear" style="display:table;clear:both;">
					 </div>
					 </div>   
					 <div class="voucher-left-parent" style="margin-bottom:14px;width:50%;float:left;">
					 <div class="voucher-l-left" style="font-weight: 600;width: 120px;float:left;">
						 Phone:
						</div>
					 <div class="voucher-r-right" style="margin-right:123px;color: #9699a2;font-size: 13px;">
						 '.$inputphone.'
						</div>
						<div class="clear" style="display:table;clear:both;">
					 </div>
					 </div>
					  <div class="clear" style="display:table;clear:both;">
					 </div>
					 </div>
					
					
					
					<div class="voucher-left-main">
					 <div class="voucher-left-parent" style="margin-bottom:14px;width:50%;float:left;">
					 <div class="voucher-l-left" style="font-weight: 600;width: 120px;float:left;">
					Check In:
						</div>
					 <div class="voucher-r-right" style="margin-right:123px;color: #9699a2;font-size: 13px;">
						'.$datainsert['checkin'].'
						</div>
						<div class="clear" style="display:table;clear:both;">
					 </div>
					 </div>   
					 <div class="voucher-left-parent" style="margin-bottom:14px;width:50%;float:left;">
					 <div class="voucher-l-left" style="font-weight: 600;width: 120px;float:left;">
					   Check Out:
						</div>
					 <div class="voucher-r-right" style="margin-right:123px;color: #9699a2;font-size: 13px;">
						'.$datainsert['checkout'].'
						</div>
						<div class="clear" style="display:table;clear:both;">
					 </div>
					 </div>
					  <div class="clear" style="display:table;clear:both;">
					 </div>
					 </div>
					
					 <div class="voucher-left-main">
					 <div class="voucher-left-parent" style="margin-bottom:14px;width:50%;float:left;">
					 <div class="voucher-l-left" style="font-weight: 600;width: 120px;float:left;">
				   Booking Date:
						</div>
					 <div class="voucher-r-right" style="margin-right:123px;color: #9699a2;font-size: 13px;">
					   '.date("Y-m-d").'
						</div>
						<div class="clear" style="display:table;clear:both;">
					 </div>
					 </div>   
					 <div class="voucher-left-parent" style="margin-bottom:14px;width:50%;float:left;">
					 <div class="voucher-l-left" style="font-weight: 600;width: 120px;float:left;">
					 Booking Status:
						</div>
					 <div class="voucher-r-right" style="margin-right:123px;color: #9699a2;font-size: 13px;">
					   Unpaid
						</div>
						<div class="clear" style="display:table;clear:both;">
					 </div>
					 </div>
					  <div class="clear" style="display:table;clear:both;">
					 </div>
					 </div>
					 
					
					 
					  <div class="voucher-left-main">
					 <div class="voucher-left-parent" style="margin-bottom:14px;width:50%;float:left;">
					 <div class="voucher-l-left" style="font-weight: 600;width: 120px;float:left;">
				  Booking Id:
						</div>
					 <div class="voucher-r-right" style="margin-right:123px;color: #9699a2;font-size: 13px;">
					   '.$booking_id.'
						</div>
						<div class="clear" style="display:table;clear:both;">
					 </div>
					 </div>   
					 <div class="voucher-left-parent" style="margin-bottom:14px;width:50%;float:left;">
					 <div class="voucher-l-left" style="font-weight: 600;width: 120px;float:left;">
					 Total Price:
						</div>
					 <div class="voucher-r-right" style="margin-right:123px;color: #9699a2;font-size: 13px;">
					   $ '.$datainsert['totalprice'].'
						</div>
						<div class="clear" style="display:table;clear:both;">
					 </div>
					 </div>
					  <div class="clear" style="display:table;clear:both;">
					 </div>
					 </div>
					 
					 
					</div>
					
					 <div class="clear" style="display:table;clear:both;">
					 </div>
					  <table style="width: 100%;text-align: left; border: 1px solid #c9c9ca;border-collapse: collapse;">
					  <tr>
						<th style="padding:10px 0px 10px 10px;border: 1px solid #e3e3e3;">Room type</th>
						
						 <th style="padding:10px 0px 10px 10px;500;border: 1px solid #e3e3e3;">Adults</th>
						<th style="padding:10px 0px 10px 10px;border: 1px solid #e3e3e3;">Children</th>
						<th style="padding:10px 0px 10px 10px;border: 1px solid #e3e3e3;">Price</th>
					  </tr>
					  '.$roomtype.'
					 
					</table>
				</div>
				
				<div class="voucher-footer" style="padding: 75px;background-color: #f7f8fa;">
				  
					<div class="blowtable">
						<div class="below_table_header" style="font-weight:600;margin-bottom:10px;">
							Rate comments:
						</div>
						<div class="below_table_content" style="font-size:12px;">
							<p>1x DOUBLE Estimated total amount of taxes & fees for this booking: 26,88 US Dollar payable on arrival</p>
							<p> Check-in hour 00:00 – 08:59. . -Must be 21 years of age to check in</p>
							<p>Guest will be asked for incidentals deposit at check-in to be reimbursed at the end of stay. Cash is not accepted</p>
						</div>
					</div>
				</div>
			</div>
			</div>
		</body>
		</html>';
     //invoice
		$my_html_PDF = '<table width="700">
		  <h3 style="text-align: center">BOOKING VOUCHER</h3>
		  <h4 style="text-align: center">New B2B</h4>
		  <tr style="line-height: 30px">
			<td >VOUCHER ID : '.$booking_id.'</td>
			<td>DATE :  '.date("Y-m-d").'</td>
		  </tr>
		  <tr style="line-height: 30px">
			<td>Name : '.$request->input('inputfirstname').''.$request->input('inputlastname').'</td>
			<td>E-mail : '.$inputemail.'</td>
		  </tr>
		   <tr style="line-height: 30px">
			<td>Hotel Name : '.$request->input('Hotelname').'</td>
			<td>Hote Address : '.$request->input('Hoteladdress').'</td>
		  </tr>
		  
		  
		</table>
		<table style="text-align: center">
		  <tr style="background-color: #666666;color: #fff;line-height: 30px;">
			<th style="border-bottom: 1px solid #b0b0b0;border-left: 1px solid #b0b0b0">S.No</th>
			<th style="border-bottom: 1px solid #b0b0b0;border-right: 1px solid #b0b0b0">ROOM DETAIL</th>
			<th style="border-bottom: 1px solid #b0b0b0;border-right: 1px solid #b0b0b0">ADULT</th>
			<th style="border-bottom: 1px solid #b0b0b0;border-right: 1px solid #b0b0b0">CHILDREN</th>
			<th style="border-bottom: 1px solid #b0b0b0;border-right: 1px solid #b0b0b0">PRICE</th>
		  </tr>
		'.$html_room_pdf.'
	
		  <tr style="line-height: 30px;">
			<td ></td>
			<td ></td>
			<td style="border-right: 1px solid #b0b0b0;">Discount Applied</td>
			<td style="border-bottom: 1px solid #b0b0b0;"></td>
			<td style="border-bottom: 1px solid #b0b0b0;border-right: 1px solid #b0b0b0">$ '.$DiscountApplied.'</td>
		  </tr>
		  <tr style="line-height: 30px;">
			<td ></td>
			<td ></td>
			<td style="border-right: 1px solid #b0b0b0"> GRAND TOTAL</td>
			<td style="border-bottom: 1px solid #b0b0b0;"></td>
			<td style="border-bottom: 1px solid #b0b0b0;border-right: 1px solid #b0b0b0">$ '.$datainsert['totalprice'].'</td>
		  </tr>
		  <h2 style="font-size: 12px;line-height: 50px"> THANKYOU FOR BOOKING WITH NEW B2B</h2>
		</table>';
		


		
		//echo $mail_template;
		$datainsert['Mailtemplate'] = $mail_template ;
		$datainsert['Vouchertemplate'] = $my_html_PDF;
		$datainsert['roomdeatils'] = serialize($roomdeatai_arry);
		$datainsert['canceldetails'] = 'null';
		$datainsert['canceldeadline_confirm'] = $canceldeadline;
		$lastInsertedID = DB::table('payment')->insertGetId( $datainsert );	

		if($datainsert['booking_confirm'] == 0){
		
		    $getBookingdetails=DB::table('payment')->where('BookingReference','=',''.$BookingId.'')->get();
			$cancelationDeadline1 = $canceldeadline_confirm;	
		    $adminemailid = '';
		    $adminemail = DB::select('select * from adminemail where id=1');
				 if(isset($adminemail[0]->EmailName) && !empty($adminemail[0]->EmailName)){
		             $adminemailid = $adminemail[0]->EmailName;
		         }else{
		             $adminemailid = 'vasistcompany@gmail.com';
		        }
    	//$to = 'vasistcompany@gmail.com';
			$to = $adminemailid;
			$subject = "New B2B Booking Confirmation" ;
			$message = $mail_template;
			$headers = "From: B2B project<admin@livebeds.com>\r\n";
			$headers .= "MIME-Version: 1.0\r\n";
			$headers .= "Content-Type: text/html; charset=UTF-8\r\n";
			mail($to,$subject,$message,$headers);

		    $agencyemailids = $adminemailid;
		    if(Auth::user()->user_type == 'AgencyManger'){
	
		        $mailEmail  = DB::table('agency')->where('loginid','=',Auth::user()->id)->get(); 
	            $agencyemailids = $mailEmail[0]->email;
		    } 
			
		    if(Auth::user()->user_type == 'SubAgencyManger'){
			    $checkcreditlimit_parent =DB::table('agency')->where('loginid','=',Auth::user()->id)->get();
			    $mailEmail =DB::table('agency')->where('id','=',$checkcreditlimit_parent[0]->parentagencyid)->get();
			    $agencyemailids = $mailEmail[0]->email;
			}
			
			
		   if(Auth::user()->user_type == 'UserInfo'){
		       $userinformation =DB::table('userinformation')->where('loginid','=',Auth::user()->id)->get();
			   if($userinformation[0]->agentid != 0){
					$mailEmail =DB::table('agency')->where('id','=',$userinformation[0]->agentid)->get();
				    $agencyemailids = $mailEmail[0]->email;
				}
			}
		
		
			$to = $agencyemailids;
			$subject = "New B2B Booking Confirmation" ;
			$message = $mail_template;
			$headers = "From: B2B project<admin@livebeds.com>\r\n";
			$headers .= "MIME-Version: 1.0\r\n";
			$headers .= "Content-Type: text/html; charset=UTF-8\r\n";
			mail($to,$subject,$message,$headers);
	        return redirect('confirmationpage?id='.Crypt::encrypt(base64_encode($lastInsertedID)).'');
		}
		else{
			//go
			$to = 'maniprakashpalani@gmail.com';
			$subject = "New B2B Booking Pending" ;
			$message = $mail_template;
			$headers = "From: B2B project<admin@livebeds.com>\r\n";
			$headers .= "MIME-Version: 1.0\r\n";
			$headers .= "Content-Type: text/html; charset=UTF-8\r\n";
			mail($to,$subject,$message,$headers);
		    return redirect('confirmation-pending?id='.Crypt::encrypt(base64_encode($lastInsertedID)).'');
		}
		
		//detail send 
		$data['confirm'] = $datainsert['booking_confirm'];
		$data['bookingid'] = $lastInsertedID; 
		
		if($lastInsertedID){
			//echo $datainsert['booking_confirm'];
			return $data;
		}
	
    	
  exit;
    	

		   
		   
	   }
	
    
	
	
	  public function ajaxhotelpayment(Request $request) //Send booking request to API from Hotel API Controller
       {
		   
		    require_once('tcpdf/pdfblock/tcpdf_include.php');
	
	    require_once('tcpdf/tcpdf.php');  
		   
		$data = $request->all();
		
		
		
		$home_url = URL::to("/");
        
		$norooms = $request['noofroom'];
	  
	    $postarray = array();
		
		
		try 
				{
				  $canceldeadline_confirm_d = Crypt::decrypt($request->input('canceldeadline_confirm'));
				  $canceldeadline_confirm = base64_decode($canceldeadline_confirm_d);
				 //echo $canceldeadline;
				} catch (DecryptException $e) {
				
				   return \Response::view('errors.404',array(),404);
				}
				
				
				
				
		//dead line
		
		
		try 
				{
				  $canceldeadline_id = Crypt::decrypt($request->input('canceldeadline'));
				  $canceldeadline = base64_decode($canceldeadline_id);
				 //echo $canceldeadline;
				} catch (DecryptException $e) {
				
				   return \Response::view('errors.404',array(),404);
				}
						
				
			
				
		
		try 
				{
				  $totalp_id = Crypt::decrypt($request->input('totalprice'));
				  $totalprice = base64_decode($totalp_id);
				} catch (DecryptException $e) {
				
				   return \Response::view('errors.404',array(),404);
				}
				
			if($request->input('DiscountApplied') != 0)
		      {
	try 
				{
				  $DiscountApplied_id = Crypt::decrypt($request->input('DiscountApplied'));
				  $DiscountApplied = base64_decode($DiscountApplied_id);
				} catch (DecryptException $e) {
				
				   return \Response::view('errors.404',array(),404);
				}
			  }else{
			  
			     $DiscountApplied = 0;
			  }
			  
			  
			  
			  if($request->input('markupprice') != 0)
		      {
	try 
				{
				    $markupprice_id = Crypt::decrypt($request->input('markupprice'));
		            $markupprice = base64_decode($markupprice_id);
				} catch (DecryptException $e) {
				
				   return \Response::view('errors.404',array(),404);
				}
			  }else{
			  
			     $markupprice = 0;
			  }
			  $room_daily_price_array = array();
	
	$t= 1;
	
	
	foreach($request->input('roomdailycontnt') as $roomdailycontnt){
	$room_daily_price_array[$t] = base64_decode(Crypt::decrypt($roomdailycontnt));
	++$t;
	}
	    for($ro=0;$ro<$norooms;$ro++){
		
		$postarray[$ro]['RoomId']=$request['RoomId'.$ro];
		
		$postarray[$ro]['adult']=$request['NumAdults'.$ro];
		//$postarray[$ro]['adultName']=$_GET['adultname'.$ro];
		          $nosdult = $request['NumAdults'.$ro];
		           for($ad=1;$ad<=$nosdult; $ad++){
					 $postarray[$ro]['title'][$ad]=$request['selectadult'.$ro.$ad];
		             $postarray[$ro]['firstname'][$ad]=$request['inptutroomfirstname'.$ro.$ad];
					 $postarray[$ro]['lastname'][$ad]=$request['inptutroomlastname'.$ro.$ad];
		        	 $postarray[$ro]['child']=$request['NumChildren'.$ro];
		        	    
						$nochild = $request['NumChildren'.$ro];
	                    for($co=1;$co<=$nochild;$co++){
	                    	$postarray[$ro]['childFirstName'][$co]=$request['childfirstname'.$ro.$co];
							$postarray[$ro]['childLastName'][$co]=$request['childlastname'.$ro.$co];	
		                    $postarray[$ro]['childage'][$co]=$request['childage'.$ro.$co];
                             }
					
					 }
	   
	   
	     } 
		
		$post = array();
		for($ro=1;$ro<=$norooms;$ro++){
		$post['RoomId']=$request['roomid'.$ro];
		 }
	
		
		
		$datainsert['CancellationDeadline'] = $canceldeadline;
		
		$datainsert['guest'] =serialize($postarray);
		
		$inputfirstname = '';
		$inputlastname= '';
		
				 
				 
		$inputemail = '';
		$inputphone = '';
		if($request->input('inputemail')){
			$inputemail = $request->input('inputemail');
		}
		if($request->input('inputphone')){
			$inputphone = $request->input('inputphone');
		}

		
		if($request->input('inputfirstname')){
			$inputfirstname = $request->input('inputfirstname');
		}
		
		
		if($request->input('inputlastname')){
			$inputlastname = $request->input('inputlastname');
		}
		
		$datainsert['firstname'] = $inputfirstname;
		$datainsert['lastname'] = $inputlastname;
		$datainsert['email'] = $inputemail;
		$datainsert['phone'] = $inputphone;
		$datainsert['no_of_room'] = $request->input('noofroom');
		$datainsert['markupprice'] = $markupprice;
		$datainsert['totalprice'] = $totalprice;
		$datainsert['hotelid'] = $request->input('hotelid');
		$datainsert['checkin'] = $request->input('checkin');
		$datainsert['checkout'] = $request->input('checkout');
		$datainsert['optionID'] = $request->input('optionID');
		$datainsert['supplier'] = 'travelanda';
		$datainsert['RoomId'] = serialize($post);
		$datainsert['Bookdate'] = date('Y-m-d');
		$serializeValue = serialize($postarray);
		$datainsert['roomdailycontnt'] = serialize($room_daily_price_array);
		
		
		$datainsert['booking_confirm'] = 0;
		
		
		if(Auth::user()->user_type == 'SuperAdmin'){
			
		         //$datainsert['booking_confirm'] = 1;
		
		}
		
		else{
		//agency manager
			if(Auth::user()->user_type == 'AgencyManger'){
			
			    $checkcreditlimit =DB::table('agency')->where('loginid','=',Auth::user()->id)->get();
			
			    if($datainsert['totalprice']<=$checkcreditlimit[0]->current_credit_limit){
		
			        $bal_limit = $checkcreditlimit[0]->current_credit_limit - $datainsert['totalprice'];
			
			    }
		    } 
			
			else if(Auth::user()->user_type == 'SubAgencyManger'){
				
				$checkcreditlimit_parent =DB::table('agency')->where('loginid','=',Auth::user()->id)->get();
				$checkcreditlimit =DB::table('agency')->where('id','=',$checkcreditlimit_parent[0]->parentagencyid)->get();
				if($datainsert['totalprice']<=$checkcreditlimit[0]->current_credit_limit){
				//$datainsert['booking_confirm'] = 1;
				//minmize condttions
				    $bal_limit = $checkcreditlimit[0]->current_credit_limit - $datainsert['totalprice'];
				//update
				//$lastInsertedID = DB::table('agency')->where('id', $checkcreditlimit[0]->id)->update(['current_credit_limit' => $bal_limit]);
				}
			}else if(Auth::user()->user_type == 'UserInfo'){
                $userinformation =DB::table('userinformation')->where('loginid','=',Auth::user()->id)->get();
                if($userinformation[0]->agentid != 0){
				 //agency user
			        $checkcreditlimit =DB::table('agency')->where('id','=',$userinformation[0]->agentid)->get();
			        if($datainsert['totalprice']<=$checkcreditlimit[0]->current_credit_limit){
			            $bal_limit = $checkcreditlimit[0]->current_credit_limit - $datainsert['totalprice'];
			        }
		        }
			
			}

		}
		//CHECK ADMIN
		
		if(Auth::user()->user_type == 'SuperAdmin'){
			$datainsert['login_id'] = 0;
			$datainsert['user_type'] = 'SuperAdmin';
			
		}else{
		    $datainsert['login_id'] = Auth::user()->id;
		    $datainsert['user_type'] = Auth::user()->user_type;
		}
		
		if($datainsert['booking_confirm'] == 0){
		
		//check credit limit
	        $hotel_booking = HotelApiController::BookingResults($request);
	        $BookingId = $hotel_booking->Body->HotelBooking->BookingReference;
	        $BookingStatus =  $hotel_booking->Body->HotelBooking->BookingStatus;
			if(!empty($hotel_booking->Body->Error)){
				$ErrorText = $hotel_booking->Body->Error->ErrorText;
				$datainsert['ErrorText'] = $hotel_booking->Body->Error->ErrorText;
				$datainsert['BookingStatus'] = 'Failed';
				DB::table('payment')->insertGetId( $datainsert );
				return redirect('/errorbooking'); 
			    exit;	
				
			}
	        if($BookingStatus == 'Failed'){
	            return redirect('/errorbooking'); 
			    exit;
	        }
		    $datainsert['BookingReference'] = $BookingId ;
		    $datainsert['BookingStatus'] = $BookingStatus;
		    $data['BookingId'] = $BookingId;
		    if(!isset($BookingId)){
			    return redirect('/errorbooking'); 
			    exit;
		    }
		
		    $booking_staus = '<span style="color:green">Complete</sapn>';
		    $booking_id  = $BookingId;
		}else{
		    $booking_staus = '<span style="color:red">Pending</span>';
		    $booking_id  = '-';
		}
		//mail
		$roomdeatai_arry = array();
		$roomtype = '';
		$html_room_pdf = '';
		for($ro=0;$ro<$request->input('noofroom');$ro++){
		
			$roomdeatai_arry[$ro]['RoomName'] = $request->input('RoomName'.$ro);
			$roomdeatai_arry[$ro]['NumAdults'] = $request->input('NumAdults'.$ro);
			$roomdeatai_arry[$ro]['NumChildren'] = $request->input('NumChildren'.$ro);
			$roomdeatai_arry[$ro]['RoomPrice'] = $request->input('RoomPrice'.$ro);
			$roomdeatai_arry[$ro]['RoomId'] = $request->input('RoomId'.$ro);
			$roomtype .= '<tr>
					<td style="padding:10px 0px 10px 10px;border: 1px solid #e3e3e3;">'.$request->input('RoomName'.$ro).'</td>
					<td style="padding:10px 0px 10px 10px;border: 1px solid #e3e3e3;">'.$request->input('NumAdults'.$ro).'</td>
					 <td style="padding:10px 0px 10px 10px;border: 1px solid #e3e3e3;">'.$request->input('NumChildren'.$ro).'</td>
					<td style="padding:10px 0px 10px 10px;border: 1px solid #e3e3e3;">$ '.base64_decode(Crypt::decrypt($request->input('RoomPrice'.$ro))).'</td>
				  </tr>';
				  $noro = $ro +1;
			$html_room_pdf .= '<tr style="line-height: 30px;">
					<td style="border-bottom: 1px solid #b0b0b0;border-right: 1px solid #b0b0b0;border-left: 1px solid #b0b0b0">'.$noro.'</td>
					<td style="border-bottom: 1px solid #b0b0b0;font-size: 10px;border-right: 1px solid #b0b0b0">'.$request->input('RoomName'.$ro).'</td>
					<td style="border-bottom: 1px solid #b0b0b0;border-right: 1px solid #b0b0b0">'.$request->input('NumAdults'.$ro).'</td>
					<td style="border-bottom: 1px solid #b0b0b0;border-right: 1px solid #b0b0b0">'.$request->input('NumChildren'.$ro).'</td>
					<td style="border-bottom: 1px solid #b0b0b0;border-right: 1px solid #b0b0b0">$ '.base64_decode(Crypt::decrypt($request->input('RoomPrice'.$ro))).'</td>
				  </tr>';	  
		}
		$star = '';
		for($so=0;$so<$request->input('Hotelstar');$so++){
		    $star .= '<img style="width:16px" src="'.$home_url.'/img/star.png" />';
		}
		$mail_template = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
		<html xmlns="http://www.w3.org/1999/xhtml">
		<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>Untitled Document</title>
		</head>
		<link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" rel="stylesheet">
		
		<body class="margin:0">
		<div class="voucher-backgrouund" style="font-family: "Poppins", sans-serif;background: #f2f3f8; font-size:14px;">
		<div class="voucher-contents" style="max-width:900px;margin: auto;color: #575962;-webkit-box-shadow: 0 1px 15px 1px rgba(69,65,78,.08);-moz-box-shadow: 0 1px 15px 1px rgba(69,65,78,.08);box-shadow: 0 1px 15px 1px rgba(69,65,78,.08);background-color: #fff;">
			<div class="voucher-header" style="background:url('.$home_url.'/img/voucherbackground.jpg)">
			  <div class="voucher-haeader-background" style="padding: 75px">
				<div class="invoice-headingh-logo" style="position:relative;">
					<div class="invoicheading" style="display:inline-block; font-size: 37px;text-transform: uppercase;font-weight: 600;color: #ffffff;">
						Booking 
					</div>
					<div class="companylogo" style="    position: absolute;right: 0;top: 50%;margin-top: -14px;">
						<img src="'.$home_url.'/img/white_logo_default_dark.png" />
					</div>
					<div class="clear" style="display:table;clear:both;">
					</div>
				</div
				><div class="hoteladdress" style="padding-bottom: 30px;margin-bottom: 30px; border-bottom: 1px solid #837dd1">
				<address style="text-align: right;font-weight: 100;font-size: 14px; color: #cecdcd;">
					Cecilia Chapman, 711-2880 Nulla St, Mankato
					<p style="margin:0">Mississippi 96522</p>
				</address>
				</div>
			</div>
			</div>
			<div class="voucher-body" style="padding:75px;position:relative;">
			
			
			<div class="voucher-right" style="margin-bottom:40px">
				  
					<div class="voucher-right-hotel" style="font-size: 18px;color: #fe21be;font-weight: 500;margin-bottom: 10px;">
						'.$request->input('Hotelname').'
					</div>
					<div class="voucher-right-ratings" style="margin-bottom:5px">
						'.$star.'
					</div>
					 <div class="voucher-right-address">
						'.$request->input('Hoteladdress').'
					</div>
				</div>
				
				
				<div class="voucher-left" style="margin-bottom:30px">
				
				
				<div class="voucher-left-main">
				 <div class="voucher-left-parent" style="margin-bottom:14px;width:50%;float:left;">
				 <div class="voucher-l-left" style="font-weight: 600;width: 120px;float:left;">
					First Name:
					</div>
				 <div class="voucher-r-right" style="margin-right:123px;color: #9699a2;font-size: 13px;">
					 '.$request->input('inputfirstname').'
					</div>
					<div class="clear" style="display:table;clear:both;">
				 </div>
				 </div>   
				 <div class="voucher-left-parent" style="margin-bottom:14px;width:50%;float:left;">
				 <div class="voucher-l-left" style="font-weight: 600;width: 120px;float:left;">
					 Last Name:
					</div>
				 <div class="voucher-r-right" style="margin-right:123px;color: #9699a2;font-size: 13px;">
					 '.$request->input('inputlastname').'
					</div>
					<div class="clear" style="display:table;clear:both;">
				 </div>
				 </div>
				  <div class="clear" style="display:table;clear:both;">
				 </div>
				 </div>
				 
				 
				 
				 <div class="voucher-left-main">
				 <div class="voucher-left-parent" style="margin-bottom:14px;width:50%;float:left;">
				 <div class="voucher-l-left" style="font-weight: 600;width: 120px;float:left;">
				   Email:
					</div>
				 <div class="voucher-r-right" style="margin-right:123px;color: #9699a2;font-size: 13px;">
					'.$inputemail.'
					</div>
					<div class="clear" style="display:table;clear:both;">
				 </div>
				 </div>   
				 <div class="voucher-left-parent" style="margin-bottom:14px;width:50%;float:left;">
				 <div class="voucher-l-left" style="font-weight: 600;width: 120px;float:left;">
					 Phone:
					</div>
				 <div class="voucher-r-right" style="margin-right:123px;color: #9699a2;font-size: 13px;">
					 '.$inputphone.'
					</div>
					<div class="clear" style="display:table;clear:both;">
				 </div>
				 </div>
				  <div class="clear" style="display:table;clear:both;">
				 </div>
				 </div>
				
				
				
				<div class="voucher-left-main">
				 <div class="voucher-left-parent" style="margin-bottom:14px;width:50%;float:left;">
				 <div class="voucher-l-left" style="font-weight: 600;width: 120px;float:left;">
				Check In:
					</div>
				 <div class="voucher-r-right" style="margin-right:123px;color: #9699a2;font-size: 13px;">
					'.$datainsert['checkin'].'
					</div>
					<div class="clear" style="display:table;clear:both;">
				 </div>
				 </div>   
				 <div class="voucher-left-parent" style="margin-bottom:14px;width:50%;float:left;">
				 <div class="voucher-l-left" style="font-weight: 600;width: 120px;float:left;">
				   Check Out:
					</div>
				 <div class="voucher-r-right" style="margin-right:123px;color: #9699a2;font-size: 13px;">
					'.$datainsert['checkout'].'
					</div>
					<div class="clear" style="display:table;clear:both;">
				 </div>
				 </div>
				  <div class="clear" style="display:table;clear:both;">
				 </div>
				 </div>
				
				 <div class="voucher-left-main">
				 <div class="voucher-left-parent" style="margin-bottom:14px;width:50%;float:left;">
				 <div class="voucher-l-left" style="font-weight: 600;width: 120px;float:left;">
			   Booking Date:
					</div>
				 <div class="voucher-r-right" style="margin-right:123px;color: #9699a2;font-size: 13px;">
				   '.date("Y-m-d").'
					</div>
					<div class="clear" style="display:table;clear:both;">
				 </div>
				 </div>   
				 <div class="voucher-left-parent" style="margin-bottom:14px;width:50%;float:left;">
				 <div class="voucher-l-left" style="font-weight: 600;width: 120px;float:left;">
				 Booking Status:
					</div>
				 <div class="voucher-r-right" style="margin-right:123px;color: #9699a2;font-size: 13px;">
					Unpaid
					</div>
					<div class="clear" style="display:table;clear:both;">
				 </div>
				 </div>
				  <div class="clear" style="display:table;clear:both;">
				 </div>
				 </div>
				 
				
				 
				  <div class="voucher-left-main">
				 <div class="voucher-left-parent" style="margin-bottom:14px;width:50%;float:left;">
				 <div class="voucher-l-left" style="font-weight: 600;width: 120px;float:left;">
			  Booking Id:
					</div>
				 <div class="voucher-r-right" style="margin-right:123px;color: #9699a2;font-size: 13px;">
				   '.$booking_id.'
					</div>
					<div class="clear" style="display:table;clear:both;">
				 </div>
				 </div>   
				 <div class="voucher-left-parent" style="margin-bottom:14px;width:50%;float:left;">
				 <div class="voucher-l-left" style="font-weight: 600;width: 120px;float:left;">
				 Total Price:
					</div>
				 <div class="voucher-r-right" style="margin-right:123px;color: #9699a2;font-size: 13px;">
				   $ '.$datainsert['totalprice'].'
					</div>
					<div class="clear" style="display:table;clear:both;">
				 </div>
				 </div>
				  <div class="clear" style="display:table;clear:both;">
				 </div>
				 </div>
				 
				 
				</div>
				
				 <div class="clear" style="display:table;clear:both;">
				 </div>
				  <table style="width: 100%;text-align: left; border: 1px solid #c9c9ca;border-collapse: collapse;">
				  <tr>
					<th style="padding:10px 0px 10px 10px;border: 1px solid #e3e3e3;">Room type</th>
					
					 <th style="padding:10px 0px 10px 10px;500;border: 1px solid #e3e3e3;">Adults</th>
					<th style="padding:10px 0px 10px 10px;border: 1px solid #e3e3e3;">Children</th>
					<th style="padding:10px 0px 10px 10px;border: 1px solid #e3e3e3;">Price</th>
				  </tr>
				  '.$roomtype.'
				 
				</table>
			</div>
			
			<div class="voucher-footer" style="padding: 75px;background-color: #f7f8fa;">
			  
				<div class="blowtable">
					<div class="below_table_header" style="font-weight:600;margin-bottom:10px;">
						Rate comments:
					</div>
					<div class="below_table_content" style="font-size:12px;">
						<p>1x DOUBLE Estimated total amount of taxes & fees for this booking: 26,88 US Dollar payable on arrival</p>
						<p> Check-in hour 00:00 – 08:59. . -Must be 21 years of age to check in</p>
						<p>Guest will be asked for incidentals deposit at check-in to be reimbursed at the end of stay. Cash is not accepted</p>
					</div>
				</div>
			</div>
		</div>
		</div>
		</body>
		</html>';








//pdf
		$my_html_PDF = '<table width="700">
		  <h3 style="text-align: center">BOOKING VOUCHER</h3>
		  <h4 style="text-align: center">New B2B</h4>
		  <tr style="line-height: 30px">
			<td >VOUCHER ID : '.$booking_id.'</td>
			<td>DATE :  '.date("Y-m-d").'</td>
		  </tr>
		  <tr style="line-height: 30px">
			<td>Name : '.$request->input('inputfirstname').''.$request->input('inputlastname').'</td>
			<td>E-mail : '.$inputemail.'</td>
		  </tr>
		   <tr style="line-height: 30px">
			<td>Hotel Name : '.$request->input('Hotelname').'</td>
			<td>Hote Address : '.$request->input('Hoteladdress').'</td>
		  </tr>
		  
		  
		</table>
		<table style="text-align: center">
		  <tr style="background-color: #666666;color: #fff;line-height: 30px;">
			<th style="border-bottom: 1px solid #b0b0b0;border-left: 1px solid #b0b0b0">S.No</th>
			<th style="border-bottom: 1px solid #b0b0b0;border-right: 1px solid #b0b0b0">ROOM DETAIL</th>
			<th style="border-bottom: 1px solid #b0b0b0;border-right: 1px solid #b0b0b0">ADULT</th>
			<th style="border-bottom: 1px solid #b0b0b0;border-right: 1px solid #b0b0b0">CHILDREN</th>
			<th style="border-bottom: 1px solid #b0b0b0;border-right: 1px solid #b0b0b0">PRICE</th>
		  </tr>
		'.$html_room_pdf.'
	
		  <tr style="line-height: 30px;">
			<td ></td>
			<td ></td>
			<td style="border-right: 1px solid #b0b0b0;">Discount Applied</td>
			<td style="border-bottom: 1px solid #b0b0b0;"></td>
			<td style="border-bottom: 1px solid #b0b0b0;border-right: 1px solid #b0b0b0">$ '.$DiscountApplied.'</td>
		  </tr>
		  <tr style="line-height: 30px;">
			<td ></td>
			<td ></td>
			<td style="border-right: 1px solid #b0b0b0"> GRAND TOTAL</td>
			<td style="border-bottom: 1px solid #b0b0b0;"></td>
			<td style="border-bottom: 1px solid #b0b0b0;border-right: 1px solid #b0b0b0">$ '.$datainsert['totalprice'].'</td>
		  </tr>
		  <h2 style="font-size: 12px;line-height: 50px"> THANKYOU FOR BOOKING WITH NEW B2B</h2>
		</table>';
		



//echo $mail_template;
		$datainsert['Mailtemplate'] = $mail_template ;
		$datainsert['Vouchertemplate'] = $my_html_PDF;
		$datainsert['roomdeatils'] = serialize($roomdeatai_arry);
		$datainsert['canceldetails'] = 'null';
		$datainsert['canceldeadline_confirm'] = $canceldeadline;
		$datainsert['booking_confirm'] = 0;
		$lastInsertedID = DB::table('payment')->insertGetId( $datainsert );	
//Old Booking Details deleted

/*if (isset($request->input('BookingdeleteId')) && !empty($request->input('BookingdeleteId'))){
	
$delete_Id =  $request->input('BookingdeleteId');

$booking_deleted = DB::table('payment')->where('id', $delete_Id)->delete();
}*/
		
		if($datainsert['booking_confirm'] == 0){
		    $getBookingdetails=DB::table('payment')->where('BookingReference','=',''.$BookingId.'')->get();
			$cancelationDeadline1 = $canceldeadline_confirm;	
			$users = DB::table('payment')->where('BookingReference', $BookingId)->update(['canceldeadline_confirm' => $cancelationDeadline1]);
		    $adminemailid = '';
		    $adminemail = DB::select('select * from adminemail where id=1');
		    if(isset($adminemail[0]->EmailName) && !empty($adminemail[0]->EmailName)){
		         $adminemailid = $adminemail[0]->EmailName;
		    }else{
		         $adminemailid = 'vasistcompany@gmail.com';
		    }
			
        //mail
    	//$to = 'vasistcompany@gmail.com';
			$to = $adminemailid;
			$subject = "New B2B Booking Confirmation" ;
			$message = $mail_template;
			$headers = "From: B2B project<admin@livebeds.com>\r\n";
			$headers .= "MIME-Version: 1.0\r\n";
			$headers .= "Content-Type: text/html; charset=UTF-8\r\n";
			mail($to,$subject,$message,$headers);
			
			//admin
			$agencyemailids = $adminemailid;
			if(Auth::user()->user_type == 'AgencyManger'){
				//update
			   $mailEmail  = DB::table('agency')->where('loginid','=',Auth::user()->id)->get(); 
			   $agencyemailids = $mailEmail[0]->email;
			} 
				
			if(Auth::user()->user_type == 'SubAgencyManger'){
				$checkcreditlimit_parent =DB::table('agency')->where('loginid','=',Auth::user()->id)->get();
				$mailEmail =DB::table('agency')->where('id','=',$checkcreditlimit_parent[0]->parentagencyid)->get();
				$agencyemailids = $mailEmail[0]->email;
			}
				
			if(Auth::user()->user_type == 'UserInfo'){
			   $userinformation =DB::table('userinformation')->where('loginid','=',Auth::user()->id)->get();
					if($userinformation[0]->agentid != 0){
							 //agency user
						$mailEmail =DB::table('agency')->where('id','=',$userinformation[0]->agentid)->get();
						$agencyemailids = $mailEmail[0]->email;
					}
					
			}
			
			
			$to = $agencyemailids;
			$subject = "New B2B Booking Confirmation" ;
			$message = $mail_template;
			$headers = "From: B2B project<admin@livebeds.com>\r\n";
			$headers .= "MIME-Version: 1.0\r\n";
			$headers .= "Content-Type: text/html; charset=UTF-8\r\n";
			mail($to,$subject,$message,$headers);

	        return redirect('confirmationpage?id='.Crypt::encrypt(base64_encode($lastInsertedID)).'');
	    }else{
			//go
			$to = 'maniprakashpalani@gmail.com';
			$subject = "New B2B Booking Pending" ;
			$message = $mail_template;
			$headers = "From: B2B project<admin@livebeds.com>\r\n";
			$headers .= "MIME-Version: 1.0\r\n";
			$headers .= "Content-Type: text/html; charset=UTF-8\r\n";
			mail($to,$subject,$message,$headers);
			return redirect('confirmation-pending?id='.Crypt::encrypt(base64_encode($lastInsertedID)).'');
		}
		//detail send 
		$data['confirm'] = $datainsert['booking_confirm'];
		$data['bookingid'] = $lastInsertedID; 
		
		if($lastInsertedID){
			return $data;
			
		}
    	
        exit;
    	
    	
    	
    }
	
	
	
	
	public function confirmationpage() 
	
	{


		$data['pagename'] = 'hotellist';
		$RoleIdPremissions = controller::Role_Permissions();
			   //print_r($RoleIdPremissions);
		$data['Premissions'] = $RoleIdPremissions;
		/*for($rr=25;$rr<=28;$rr++){
		
				echo '<a href="http://23.229.195.196/test/public/confirmationpage?id='.Crypt::encrypt(base64_encode($rr)).'">'.$rr.'</a>';
				
				echo '<br>';
		}*/
		try {
			    $totalp_id = Crypt::decrypt($_GET['id']);
				$paymentid = base64_decode($totalp_id);
			} catch (DecryptException $e) {
						
			     return \Response::view('errors.404',array(),404);
			}
			
				
		$vouched_booking =DB::table('payment')->where('id','=',$paymentid)->get();
		
				
		if($vouched_booking[0]->confirmGet == 1) { 
				
		    $agencyemailids  = 'admin@livebeds.com';
				
		    if(Auth::user()->user_type == 'AgencyManger'){
					//update
				   $mailEmail  = DB::table('agency')->where('loginid','=',Auth::user()->id)->get(); 
				   $agencyemailids = $mailEmail[0]->email;
			} 
					
			if(Auth::user()->user_type == 'SubAgencyManger'){
		
			    $checkcreditlimit_parent =DB::table('agency')->where('loginid','=',Auth::user()->id)->get();
			    $mailEmail =DB::table('agency')->where('id','=',$checkcreditlimit_parent[0]->parentagencyid)->get();
				$agencyemailids = $mailEmail[0]->email;
			}
			if(Auth::user()->user_type == 'UserInfo'){
				
		        $userinformation =DB::table('userinformation')->where('loginid','=',Auth::user()->id)->get();
				if($userinformation[0]->agentid != 0){
								 //agency user
				    $mailEmail =DB::table('agency')->where('id','=',$userinformation[0]->agentid)->get();
					$agencyemailids = $mailEmail[0]->email;
				}
						
			}
				
			$to = $agencyemailids;
			$subject = "New B2B Booking Confirmation" ;
			$message = $vouched_booking[0]->Mailtemplate;
			$headers = "From: B2B project<admin@livebeds.com>\r\n";
			$headers .= "MIME-Version: 1.0\r\n";
			$headers .= "Content-Type: text/html; charset=UTF-8\r\n";
			mail($to,$subject,$message,$headers);
			$adminemail = DB::select('select * from adminemail where id=1');
			if(isset($adminemail[0]->EmailName) && !empty($adminemail[0]->EmailName)){
			    $adminemailid = $adminemail[0]->EmailName;
			}else{
			    $adminemailid = 'vasistcompany@gmail.com';
			}
					
			//mail
			//$to = 'vasistcompany@gmail.com';
			$to = $adminemailid;
			$subject = "New B2B Booking Confirmation" ;
			$message = $vouched_booking[0]->Mailtemplate;
			$headers = "From: B2B project<admin@livebeds.com>\r\n";
			$headers .= "MIME-Version: 1.0\r\n";
			$headers .= "Content-Type: text/html; charset=UTF-8\r\n";
			mail($to,$subject,$message,$headers);
		
		}
				
		if($vouched_booking[0]->supplier == 'tbo'){
			$tboHolidaysHotelDetails = HotelApiController::tboHolidaysHotelDetails($vouched_booking[0]->hotelid);
			$tbobboking_details = HotelApiController::tbobboking_details($vouched_booking[0]->BookingReference);
			$data['tboHolidaysHotelDetails'] = $tboHolidaysHotelDetails;
			
			$data['tbobboking_details'] = $tbobboking_details;
			$data['vouched_booking'] = $vouched_booking;
					
					
		}else{
			$hotel_Id = $vouched_booking[0]->hotelid;
			$hotelDetails = HotelApiController::Gethotelresponse($hotel_Id);
			$hotel_details = $hotelDetails->Body->Hotels->Hotel;
			$policiesdetails = controller::hotelpoliciesnew($vouched_booking[0]);
			$booked_array  =array();
			foreach ($policiesdetails->Body->Bookings->HotelBooking as $booking_values){
			    if($booking_values->BookingReference == $vouched_booking[0]->BookingReference){
			        $ro =1;
			        foreach ($booking_values->Policies->Policy as $booking_values_deatils){
						$From  = $booking_values_deatils->From;
						$xml2array = $this->xml2array($booking_values_deatils->From);
						$Type = $this->xml2array($booking_values_deatils->Type);
						$Value = $this->xml2array($booking_values_deatils->Value);
						
						$booked_array['Policy'][$ro]['From'] = $xml2array[0];
						$booked_array['Policy'][$ro]['Type'] = $Type[0];
						$booked_array['Policy'][$ro]['Value'] = $Value[0];
						++$ro;
			         }
			         $booked_array_v = serialize($booked_array);
			         $users = DB::table('payment')->where('id', $paymentid)->update(['canceldetails' => $booked_array_v, 'canceldeadline_confirm' => $booking_values->CancellationDeadline]);
			
			     }
			}
			$booking =DB::table('payment')->where('id','=',$paymentid)->get();		
			$data['vouched_booking'] = $booking;
			$data['hotel_details'] = $hotel_details;
		}
		return view('hotel.confirmation', $data);	
	
	}
	
	public function xml2array ( $xmlObject, $out = array () )
    {
        foreach ( (array) $xmlObject as $index => $node )
            $out[$index] = ( is_object ( $node ) ) ? xml2array ( $node ) : $node;
            return $out;
    }
	
	
	public function errorbooking() 
	{
        $data['pagename'] = 'hotellist';
        return view('hotel.errorbooking', $data);	
	}
	
	
	
	public function BookingCancellation(Request $request)
	{
	
	
		$getBookingdetails = DB::table('payment')->where('id', '=', ''.$request->input('CustomerBookId'))->get();
		//agecy manager
		if (isset($getBookingdetails[0]->user_type)) {
			if ($getBookingdetails[0]->user_type == 'AgencyManger') {
				$agency_credit_limit_check = DB::table('agency')->where('loginid', '=', ''.$getBookingdetails[0]->login_id.'')->get();
				$bal_limit = $agency_credit_limit_check[0]->current_credit_limit + $request['Totalprice'];
				$lastInsertedID = DB::table('agency')->where('id', $agency_credit_limit_check[0]->id)->update(['current_credit_limit' => $bal_limit]);
			}
		
			if ($getBookingdetails[0]->user_type == 'SubAgencyManger') {
		
				//login check
				$agency_credit_parent = DB::table('agency')->where('loginid', '=', ''.$getBookingdetails[0]->login_id.'')->get();
		
				$agency_credit_limit_check = DB::table('agency')->where('id', '=', $agency_credit_parent[0]->parentagencyid)->get();
		
				$bal_limit = $agency_credit_limit_check[0]->current_credit_limit + $request['Totalprice'];
				//refund
				//update
				$lastInsertedID = DB::table('agency')->where('id', $agency_credit_limit_check[0]->id)->update(['current_credit_limit' => $bal_limit]);
			}
		
			if ($getBookingdetails[0]->user_type == 'UserInfo') {
				//login check
				$userinformation = DB::table('userinformation')->where('loginid', '=', $getBookingdetails[0]->login_id)->get();
		
				$agency_credit_limit_check = DB::table('agency')->where('id', '=', $userinformation[0]->agentid)->get();
		
				if (isset($agency_credit_limit_check[0]->current_credit_limit)) {
					$bal_limit = $agency_credit_limit_check[0]->current_credit_limit + $request['Totalprice'];
					//refund
					//update
					$lastInsertedID = DB::table('agency')->where('id', $agency_credit_limit_check[0]->id)->update(['current_credit_limit' => $bal_limit]);
				}
			}
		}
		
		if ($request->input('Customersupplier') == 'tbo') {
			$Cancellation = $this->tbobboking_canceldetails($getBookingdetails[0]->BookingReference);
		
			$Book = $Cancellation['sBody']['HotelCancelResponse']['RequestStatus'];
		
			$policiesdetails = controller::hotelpoliciesnew($getBookingdetails[0]);
		
			$Cancellation = HotelApiController::BookingCancellationAPI($getBookingdetails[0]->BookingReference);
		
			//$Book =0;
			$Book = $Cancellation->Body->HotelBooking->BookingStatus;
			$CancellationStatus = DB::table('payment')->where('BookingReference', $getBookingdetails[0]->BookingReference)->update(['BookingStatus' => $Book, 'booking_confirm' => 2]);
		} else {
			$policiesdetails = controller::hotelpoliciesnew($getBookingdetails[0]);
		
			$Cancellation = HotelApiController::BookingCancellationAPI($getBookingdetails[0]->BookingReference);
		
			//$Book =0;
			$Book = $Cancellation->Body->HotelBooking->BookingStatus;
			$CancellationStatus = DB::table('payment')->where('BookingReference', $getBookingdetails[0]->BookingReference)->update(['BookingStatus' => $Book, 'booking_confirm' => 2]);
		}
		
		if ($request->input('Customerrole') == 'AgencyManger') {
			return redirect()->route('agencyUnBookingdetails', ['tab' => '2', 'datas1' => 'insert']);
		} else {
			return redirect()->route('unvouchecdbooking', ['tab' => '2', 'datas1' => 'insert']);
		}

	}
	
	
	
	
	public  function Cancellationpoilcyajax() 
	{
	
		$optionID = $_GET['optionId'];
		if ($_GET['sub'] == 'Travelanda') {
			$policiesdetails1 = HotelApiController::hotelpolicies($optionID);
			$policiesdetails = $policiesdetails1->Body;
			$policylead = '<div><h5 class="cancellationheading">Cancellation Deadline:'.$policiesdetails->CancellationDeadline.'</h5>';
			$policylead .= '<div class="alert-message_alter"><h5>Chargable cancellation Date</h5>';
			$policylead .= '<div class=""><span> </span> You may cancel your reservation for no charge before this deadline. 
				 Please note that we will assess full payment of reservation if you must cancel after this deadline.</div>';
		
			$bo = 1;
			if (isset($policiesdetails->Policies->Policy)) {
				foreach ($policiesdetails->Policies->Policy as $Policy) {
					if ($Policy->Type == 'Percentage') {
						$policylead .= '<div class=""><span></span> If you will cancel the booking after  <b>'.$Policy->From.'</b> then you should  pay  <b<'.$Policy->Value.'% </b> penalty for this booking.</div>';
					}
		
					if ($Policy->Type == 'Amount') {
						$policylead .= '<div class=""><span> </span> If you will cancel the booking after  <b>'.$Policy->From.'</b> then you should  pay $ <b>'.$Policy->Value.'</b> penalty for this booking.</div>';
					}
		
					if ($Policy->Type == 'Nights') {
						$policylead .= '<div class=""><span></span> If you will cancel the booking after  <b>'.$Policy->From.'</b> then you should  pay <b>'.$Policy->Value.'</b> night price penalty for this booking.</div>';
					}
		
					++$bo;
				}
			}
		
			$policylead .= '</div>';
			if (!empty($policiesdetails->Alerts->Alert)) {
				$policylead .= '<div class="alert-message alert-message_alter">';
				$policylead .= '<h5>Cancel Message</h5>';
		
				$go = 1;
				foreach ($policiesdetails->Alerts->Alert as $Alerts) {
					$policylead .= '<p><span></span> '.$Alerts.'</p>';
		
					++$go;
				}
		
				$policylead .= '</div>';
			}
		
			$policylead .= '</div>';
			echo $policylead;
		}
		
		if ($_GET['sub'] == 'TboHolidays') {
			session_start();
			/*echo '<pre>';
					print_r($_SESSION['Cancelpolicy'][$_GET['hotelid']]['RoomIndex'.$_GET['optionId']]);
					print_r($_GET);
					echo '</pre>';*/
		
			$policylead = '<div><h5 class="cancellationheading">Cancellation Deadline:'.date('Y-m-d', strtotime($_SESSION['Cancelpolicy'][$_GET['hotelid']]['RoomIndex'.$_GET['optionId']]['sBody']['HotelCancellationPolicyResponse']['CancelPolicies']['LastCancellationDeadline'])).'</h5>';
		
			$policylead .= '<div class="alert-message_alter"><h5>Chargable cancellation Date</h5>';
		
			$policylead .= '<div class=""><span> </span> You may cancel your reservation for no charge before this deadline. 
				 Please note that we will assess full payment of reservation if you must cancel after this deadline.</div>';
		
			$policiesdetails = $_SESSION['Cancelpolicy'][$_GET['hotelid']]['RoomIndex'.$_GET['optionId']];
		
			$attr = '@attributes';
			$bo = 1;
			if (isset($policiesdetails['sBody']['HotelCancellationPolicyResponse']['CancelPolicies']['CancelPolicy'][0])) {
				foreach ($policiesdetails['sBody']['HotelCancellationPolicyResponse']['CancelPolicies']['CancelPolicy'] as $Policy) {
					if ($Policy[$attr]['ChargeType'] == 'Fixed') {
						$policylead .= '<div class=""><span> </span>  If you will cancel the booking  <b>'.$Policy[$attr]['FromDate'].'</b> to  <b>'.$Policy[$attr]['ToDate'].'</b> then you should pay '.$Policy[$attr]['Currency'].' '.$Policy[$attr]['CancellationCharge'].'penalty for this booking</div>';
					}
		
					if ($Policy[$attr]['ChargeType'] == 'Percentage') {
						$policylead .= '<div class=""><span> </span>  If you will cancel the booking  <b>'.$Policy[$attr]['FromDate'].' </b> to  <b>'.$Policy[$attr]['ToDate'].'</b> then you should pay '.$Policy[$attr]['CancellationCharge'].'% penalty for this booking</div>';
					}
					if ($Policy[$attr]['ChargeType'] == 'Night') {
						$policylead .= '<div class=""><span> </span>  If you will cancel the booking  <b>'.$Policy[$attr]['FromDate'].' </b> to  <b>'.$Policy[$attr]['ToDate'].'</b> then you should pay '.$Policy[$attr]['CancellationCharge'].'% penalty for this booking</div>';
					}
					++$bo;
				}
			}
			$policylead .= '</div>';
			$policylead .= '</div>';
		
			echo $policylead;
		}
		
	}
	
	public  function getDatesFromRange($strDateFrom,$strDateTo) {

		$aryRange = array();
		$iDateFrom = mktime(1, 0, 0, substr($strDateFrom, 5, 2),     substr($strDateFrom, 8, 2), substr($strDateFrom, 0, 4));
		$iDateTo = mktime(1, 0, 0, substr($strDateTo, 5, 2),     substr($strDateTo, 8, 2), substr($strDateTo, 0, 4));
		if ($iDateTo >= $iDateFrom) {
			array_push($aryRange, date('Y-m-d', $iDateFrom)); // first entry
			while ($iDateFrom < $iDateTo) {
				$iDateFrom += 86400; // add 24 hours
				array_push($aryRange, date('Y-m-d', $iDateFrom));
			}
		}
		return $aryRange;
   }



	public function tbobboking_canceldetails($id)
	{
		
        $url = "http://api.tbotechnology.in/HotelAPI_V7/HotelService.svc";

		// The value for the SOAPAction: header It will change among methods
		$action = "http://TekTravel/HotelBookingApi/HotelCancel";
		
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
        <wsa:Action>http://TekTravel/HotelBookingApi/HotelCancel</wsa:Action>
        <wsa:To>http://api.tbotechnology.in/hotelapi_v7/hotelservice.svc</wsa:To>
        </soap:Header>
        <soap:Body>
        <hot:HotelCancelRequest>
        <hot:BookingId>$id</hot:BookingId>
        <hot:RequestType>HotelCancel</hot:RequestType>
        <hot:Remarks>test cancel</hot:Remarks>
        </hot:HotelCancelRequest>
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
        curl_close($ch);
        
        
        }

    
    
}
