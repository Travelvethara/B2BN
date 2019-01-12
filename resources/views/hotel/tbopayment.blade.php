@extends('layouts.app')

@section('content')
<?php 



/*
echo '<pre>';
print_r($_GET);
print_r($priceinroom);
echo '</pre>';

echo 'sessionid='.$session = $_SESSION['sessionId'];
exit;*/





$date1=date_create($_GET['checkin']);
$date2=date_create($_GET['checkout']);
$diff=date_diff($date1,$date2);
$daycount = $diff->days;

$date_from = $_GET['checkin'];   
$date_from = strtotime($date_from); // Convert date to a UNIX timestamp  
$date_to = $_GET['checkout'];  
$date_to = strtotime($date_to); // Convert date to a UNIX timestamp  

$finalday = $daycount-1;

if (isset($_GET['bookingid']) && !empty($_GET['bookingid'])){
	
$booking_guest = unserialize($Book_details[0]->guest);	
echo '<pre>';
print_r($booking_guest);

echo '</pre>';

}

/*
echo '<pre>';
print_r($priceinroomdetailget);

echo '</pre>';
*/
?>



<div class="m-grid__item m-grid__item--fluid m-wrapper">
	<!-- BEGIN: Subheader -->
	
	<!-- END: Subheader -->
	<div class="m-content">
		<!--Begin::Section-->
		<div class="payment-page clear">
        <input type="hidden" id="getOptionID" value="" readonly="readonly" />
			<div class="payment-page-left">
				<h2>Review Booking Details</h2>
				<div class="payment-htel-details clear">
					<div class="payment-hotel-image">
						<img src="{{$hotel_Info['sBody']['HotelDetailsResponse']['HotelDetails']['ImageUrls']['ImageUrl'][0]}}" alt="htel-images">
					</div>
					<div class="payment-hotel-info">
					<div class="list-wrap-two">
                    <div class="ho-name"> {{$hotel_Info['sBody']['HotelDetailsResponse']['HotelDetails']['attributes']['HotelName']}}</div>
						
							
                             <div class="hotel-list-star hotel-details-u hotel-details-u-confirmation">
                            	<ul>
								@for($s=1;$s<=4;$s++)
								 <li><img src="{{asset('img/star.png')}}" /></li>
								 @endfor
                                 </ul>
							</div>
							<div class="hotel-o-address">
								{{$hotel_Info['sBody']['HotelDetailsResponse']['HotelDetails']['Address']}}
							</div>
						</div>
					</div>
				</div>
				<div class="below-payment-image-details">
					<div class="below-payment-image-details-cont clear">
						<div class="below-payment-image-left">
							<b>Check In</b>
						</div>
						<div class="below-payment-image-right">
							{{date("d M Y", strtotime($_GET['checkin']))}}
						</div>
					</div>
					<div class="below-payment-image-details-cont clear">
						<div class="below-payment-image-left">
							<b>Check Out</b>
						</div>
						<div class="below-payment-image-right">
								{{date("d M Y", strtotime($_GET['checkout']))}}
						</div>
					</div>
					<div class="below-payment-image-details-cont clear">
						<div class="below-payment-image-left">
							<b>Nights</b>
						</div>
						<div class="below-payment-image-right">
							{{$daycount}}
						</div>
					</div>
					<div class="below-payment-image-details-cont clear">
						<div class="below-payment-image-left">
							<b>Check In</b>
						</div>
						<div class="below-payment-image-right">
							Check Out
						</div>
					</div>
					
                    <?php for($rm=1;$rm<=$_GET['norooms'];$rm++) { ?>
                    <div class="below-payment-image-details-cont clear">
						<div class="below-payment-image-left">
							<b>Room Name</b>
						</div>
						<div class="below-payment-image-right">
							  {{$priceinroomdetailget['RoomIndex'][$_GET['RoomIndexs'.$rm]]['RoomTypeName']}}
						</div>
					</div>
                    <?php } ?>
                    
                    
                    
                    <table class="table table-striped">
                    <th>Adult</th>
                    <th>Children</th>
                    </tr>
                     <?php 
				
							
							 for($r=1;$r<=$_GET['norooms'];$r++) {  
							  
							 
					         ?> 
               
                    <tr>
                  
                    
                    <?php $roomCpount = 0; if(isset($_GET['adult'.$r])) { $roomCpount += $_GET['adult'.$r];  }?>
                    <td>{{$roomCpount}}</td>
                    <?php $child = 0; if(isset($_GET['child'.$r])) { $child += $_GET['child'.$r];  }?>
                    
                    <td> {{$child}}</td>
                    </tr>
                    <?php  }  ?>
                    </table>
                  
					<!--<div class="below-payment-image-details-cont clear">
						<div class="below-payment-image-left">
							<b>Children</b>
						</div>
						<div class="below-payment-image-right">
							2
						</div>
					</div>-->
				</div>	
		
				<div class="nighty-rates optionid">
                
                                    <?php 
				
							 
					         ?> 
                            
					<div class="nighty-rates-block">
						<b>Nighty Rates </b>
					</div>
                    
                    
                    <?php 
					
					
					
					
					?>
                    <table class="table table-striped">
                  
											   <tr>
												<th>Grand Total:</th>
                                                <?php
												$Total_price = '';
												
								//TotalFare
								
								$TotalFare = '';
								
								for($rm=1;$rm<=$_GET['norooms'];$rm++) {
									
								$TotalFare += $priceinroomdetailget['RoomIndex'][$_GET['RoomIndexs'.$rm]]['RoomRate']['attributes']['TotalFare'];
									
								}
												
												
								//echo $hotel_detail_mark_up;
								//echo $hotel_list->Options->Option->TotalPrice;
								if(isset($hotel_detail_mark_up)){
								$markup_price = $TotalFare % 100;
									$new_width = ($hotel_detail_mark_up / 100) * $TotalFare;
								   $Total_price = $TotalFare + $new_width;
								}else{
								$Total_price = $TotalFare;
								}
								   //echo $hotel_list->Options->Option->TotalPrice;
								 ?>
												<td>${{$Total_price}}</td>
                                              
											  </tr>
                                              
                                               
                           
										</table>
                 
                    <div class="cancellation-plicy"> <a href="javascript:void(0);" class="" data-toggle="modal" data-target="#exampleModalCenter">
  Cancellation Policies
</a>
</div>
					
			</div>
       
			
		</div>
		<div class="payment-page-right">
			<h2>Payment Information</h2>
            
            
            <?php 
		
			?>
			<form action="{{route('ajaxhotelpaymenttbo')}}" method="post" id="paymentsummit">
            <input type="hidden" name="_token" value="<?php echo @csrf_token(); ?>">
            <input type="hidden" name="canceldeadline_confirm" value="<?php echo Crypt::encrypt(base64_encode(date('Y-m-d', strtotime($policiesdetails['sBody']['HotelCancellationPolicyResponse']['CancelPolicies']['LastCancellationDeadline'])))); ?>">
            <?php if (isset($_GET['bookingid']) && !empty($_GET['bookingid'])){ ?>
            <input type="hidden" name="BookingdeleteId" value="<?php echo $_GET['bookingid']; ?>" />
            <?php } $t = 0; $room_daily_price_array = array();
		
		
		for($rm=1;$rm<=$_GET['norooms'];$rm++) {
	
			?>
            @for($i=0;$i<=$daycount; $i++)

            
            <?php 
	   
			
			if(isset($priceinroomdetailget['RoomIndex'][$_GET['RoomIndexs'.$rm]]['RoomRate']['DayRates']['DayRate'][$i]['attributes']['BaseFare'])){
				$room_daily_price = $priceinroomdetailget['RoomIndex'][$_GET['RoomIndexs'.$rm]]['RoomRate']['DayRates']['DayRate'][$i]['attributes']['BaseFare']; 
	           ?>
			<input type="hidden" name="roomdailycontnt[]" value="<?php echo Crypt::encrypt(base64_encode($room_daily_price)); ?>">
			 
			<?php 
			
			}
			
			
			?>
            @endfor
            
            <?PHP } ?>
           
				<div class="contact-details-block-wrap">	
					
					<div class="contact-details-block">
                    <input type="hidden" class=""  name="noofroom" value="<?php echo $_GET['norooms']; ?>">
                    
					
                      <input type="hidden" class=""  name="totalprice" value="<?php echo Crypt::encrypt(base64_encode($Total_price)); ?>" >
                      
                       <input type="hidden" class=""  name="encrypt" value="<?php echo Crypt::encrypt(base64_encode(11)); ?>" >
                       
                      <input type="hidden" class=""  name="markupprice" value="<?php if(isset($hotel_detail_mark_up)) { echo Crypt::encrypt(base64_encode($hotel_detail_mark_up)); }else{ echo '0';} ?>" >
                      
                      <input type="hidden" class=""  name="DiscountApplied" value="<?php if(isset($priceinroom['RoomRate']['attributes']['RoomTax'])) { echo Crypt::encrypt(base64_encode($priceinroom['RoomRate']['attributes']['RoomTax'])); }else{ echo '0';} ?>" >
                    
                      <input type="hidden" class=""  name="checkin" value="<?php if(isset($_GET['checkin'])) {echo $_GET['checkin']; } ?>" >
                      <input type="hidden" class=""  name="checkout" value="<?php if(isset($_GET['checkout'])) {echo $_GET['checkout']; } ?>" >
                      <input type="hidden" class=""  name="hotelid" value="<?php if(isset($_GET['hotelid'])) {echo $_GET['hotelid']; } ?>" >
                      

                    <?php if(isset($_GET['norooms'])){
						
				
						
						for($tt=1;$tt<=$_GET['norooms'];$tt++){
						 ?>
                      <input type="hidden" class=""  name="Currency{{$tt}}" value="<?php if(isset($priceinroomdetailget['RoomIndex'][$_GET['RoomIndexs'.$tt]]['RoomRate']['attributes']['Currency'])) {echo $priceinroomdetailget['RoomIndex'][$_GET['RoomIndexs'.$tt]]['RoomRate']['attributes']['Currency']; } ?>" >
                      <input type="hidden" class=""  name="AgentMarkUp{{$tt}}" value="<?php if(isset($priceinroomdetailget['RoomIndex'][$_GET['RoomIndexs'.$tt]]['RoomRate']['attributes']['AgentMarkUp'])) {echo $priceinroomdetailget['RoomIndex'][$_GET['RoomIndexs'.$tt]]['RoomRate']['attributes']['AgentMarkUp']; } ?>" >
                       <input type="hidden" class=""  name="RoomFare{{$tt}}" value="<?php if(isset($priceinroomdetailget['RoomIndex'][$_GET['RoomIndexs'.$tt]]['RoomRate']['attributes']['RoomFare'])) {echo $priceinroomdetailget['RoomIndex'][$_GET['RoomIndexs'.$tt]]['RoomRate']['attributes']['RoomFare']; } ?>" >
                       <input type="hidden" class=""  name="RoomTax{{$tt}}" value="<?php if(isset($priceinroomdetailget['RoomIndex'][$_GET['RoomIndexs'.$tt]]['RoomRate']['attributes']['RoomTax'])) {echo $priceinroomdetailget['RoomIndex'][$_GET['RoomIndexs'.$tt]]['RoomRate']['attributes']['RoomTax']; } ?>" >
                       <input type="hidden" class=""  name="TotalFare{{$tt}}" value="<?php if(isset($priceinroomdetailget['RoomIndex'][$_GET['RoomIndexs'.$tt]]['RoomRate']['attributes']['TotalFare'])) {echo $priceinroomdetailget['RoomIndex'][$_GET['RoomIndexs'.$tt]]['RoomRate']['attributes']['TotalFare']; } ?>" >   
                     <input type="hidden" class=""  name="RoomTypeCode{{$tt}}" value="<?php if(isset($_GET['RoomTypeCode'.$tt])){ echo $_GET['RoomTypeCode'.$tt];  }  ?>" >
                     <input type="hidden" class=""  name="RatePlanCode{{$tt}}" value="<?php if(isset($_GET['RatePlanCodes'.$tt])){ echo $_GET['RatePlanCodes'.$tt];  }  ?> " >
                     <input type="hidden" class=""  name="RoomIndex{{$tt}}" value="<?php if(isset($_GET['RoomIndexs'.$tt])){ echo $_GET['RoomIndexs'.$tt];  }  ?>" >
						<?php }}  ?>
                        
                        
                        <h6 class="roomcount" data-room="3">Guest Details</h6>
                        
                        
                                               

<?php 
						$roomid = 1;

for($r=1;$r<=$_GET['norooms'];$r++){ ?>
						
                        <p>Room {{$r}}</p>
         <?php $roomCpount = 0; if(isset($_GET['adult'.$r])) { $roomCpount += $_GET['adult'.$r];  }?>
                        @for($a=1;$a<=$_GET['adult'.$r];$a++)
                         <input type="hidden" class="adultgetCount{{$r}}" value="<?php echo $roomCpount; ?>" />
                         <div class="row">
                        <div class="col-md-2">
								<div class="form-group m-form__group">
									<span class="error-message selectAdderror{{$r}}{{$a}}" style="display:none">
										The field is required.
									</span>
								<select class="form-control m-input m-input--square selectAdd{{$r}}{{$a}}" name="selectadult{{$r}}{{$a}}" <?php if($r==1 && $a==1){?>   id="selectadult1" <?php }?> >
                                <option value="Mr." <?php if (isset($_GET['bookingid']) && !empty($_GET['bookingid'])){ if($booking_guest[$r]['title'][$a] == 'Mr.') { ?> selected="selected" <?php }} ?>>Mr.</option>
                                <option value="Mrs." <?php if (isset($_GET['bookingid']) && !empty($_GET['bookingid'])){ if($booking_guest[$r]['title'][$a] == 'Mrs.') { ?> selected="selected" <?php }} ?>>Mrs</option>
                                <option value="Miss" <?php if (isset($_GET['bookingid']) && !empty($_GET['bookingid'])){ if($booking_guest[$r]['title'][$a] == 'Miss') { ?> selected="selected" <?php }} ?>>Miss</option>
  
                                </select>
								</div>
                             </div>
							<div class="col-md-4 nopadright">
								<span class="error-message vali-room-firstname{{$r}}{{$a}}" style="display:none">
									The field is required.
								</span>
								<div class="form-group m-form__group">
                               
									<input type="text" class="form-control m-input m-input--square inptut-room-firstname{{$r}}{{$a}}"  maxlength="35" placeholder="First Name"  <?php if($r==0 && $a==1){?> readonly="" id="inptutroomfirstname1" <?php }?> name="inptutroomfirstname{{$r}}{{$a}}" <?php if (isset($_GET['bookingid']) && !empty($_GET['bookingid'])){ if (!empty($booking_guest[$r]['firstname'][$a]) && isset($booking_guest[$r]['firstname'][$a])) { ?> value="{{ $booking_guest[$r]['firstname'][$a] }}" <?php } }else{ ?> value = "" <?php } ?>>
								</div>
							</div>
							<div class="col-md-6 ">
								<span class="error-message vali-room-lastname{{$r}}{{$a}}" style="display:none">
									The field is required.
								</span>
								<div class="form-group m-form__group">
									<input type="text" class="form-control m-input m-input--square inptut-room-lastname{{$r}}{{$a}}" maxlength="35" placeholder="Last Name" <?php if($r==0 && $a==1){?> readonly=""  id="inptutroomlastname1" <?php }?> name="inptutroomlastname{{$r}}{{$a}}" <?php if (isset($_GET['bookingid']) && !empty($_GET['bookingid'])){ if (!empty($booking_guest[$r]['lastname'][$a]) && isset($booking_guest[$r]['lastname'][$a])) { ?> value="{{ $booking_guest[$r]['lastname'][$a] }}" <?php } }else{ ?> value = "" <?php } ?>>
								</div>
							</div>
						</div>
                        @endfor
                        <?php $child = 0; if(isset($_GET['child'.$r])) { $child += $_GET['child'.$r];  }?>
                         @for($ch=1;$ch<=$_GET['child'.$r];$ch++)
                          <input type="hidden" class="childgetCount{{$r}}" value="<?php echo $child; ?>" />
                            <div class="row">
							<div class="col-md-6">
								<span class="error-message vali-room-childfirstname{{$r}}{{$ch}}" style="display:none">
									The field is required.
								</span>
								<div class="form-group m-form__group">
									<input type="text" class="form-control m-input m-input--square inptut-room-childfirstname{{$r}}{{$ch}}" placeholder="Child First Name"  <?php if($r==0 && $ch==1){?> maxlength="35" id="inptutroomchildfirstname1" <?php }?> name="childfirstname{{$r.$ch}}" <?php if (isset($_GET['bookingid']) && !empty($_GET['bookingid'])){ if (!empty($booking_guest[$r]['childFirstName'][$ch]) && isset($booking_guest[$r]['childFirstName'][$ch])) { ?> value="{{ $booking_guest[$r]['childFirstName'][$ch] }}" <?php } }else{ ?> value = "" <?php } ?> >
								</div>
							</div>
                            <div class="col-md-6 ">
								<span class="error-message vali-room-childlastname{{$r}}{{$ch}}" style="display:none">
									The field is required.
								</span>
								<div class="form-group m-form__group">
									<input type="text" class="form-control m-input m-input--square inptut-room-childlastname{{$r}}{{$ch}}"  placeholder="Child Last Name" <?php if($r==0 && $ch==1){?>  maxlength="35" id="inptutroomchildlastname1" <?php }?> name="childlastname{{$r.$ch}}" <?php if (isset($_GET['bookingid']) && !empty($_GET['bookingid'])){ if (!empty($booking_guest[$r]['childLastName'][$ch]) && isset($booking_guest[$r]['childLastName'][$ch])) { ?> value="{{ $booking_guest[$r]['childLastName'][$ch] }}" <?php } }else{ ?> value = "" <?php } ?>>
								</div>
							</div>
                            
                            <div class="col-md-6 ">
								<!--<span class="error-message vali-room-childlastname{{$r}}{{$ch}}" style="display:none">
									The field is required.
								</span>-->
                                <?php if(isset($_GET['childage'.$r.$ch])) {?>
                                <input type="hidden" value="<?php  echo $_GET['childage'.$r.$ch]; ?>" name="childage{{$r}}{{$ch}}" />
                                  <?php } ?>
								
							</div>
                            
                            
						</div>
                        @endfor
                        <?php }?>
						
                          
					</div>
                    <div class="contact-details-block">
						<h6>Contact Details</h6>
						<div class="row">
							<div class="col-md-6">
								<div class="form-group m-form__group">
									<span class="error-message firstname" style="display:none">
										The field is required.
									</span>
									<input type="text" class="form-control m-input m-input--square" placeholder="First Name" maxlength="30"  <?php if (isset($_GET['bookingid']) && !empty($_GET['bookingid'])){?> value="{{ $Book_details[0]->firstname }}" <?php }else{ ?> value = "" <?php } ?>>
								</div>
							</div>
							<div class="col-md-6 ">
								<div class="form-group m-form__group">
									<span class="error-message lastname" style="display:none">
										The field is required.
									</span>
									<input type="text" class="form-control m-input m-input--square"  placeholder="Last Name" maxlength="30"  name="inputlastname" <?php if (isset($_GET['bookingid']) && !empty($_GET['bookingid'])){?> value="{{ $Book_details[0]->lastname }}" <?php }else{ ?> value = "" <?php } ?>>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6 ">
								<div class="form-group m-form__group">
									<span class="error-message email_vali" style="display:none">
										The field is required.
									</span>
									<span class="error-message email_vali1" style="display:none">
										Please enter valid email address.
									</span>
									<input type="email" class="form-control m-input m-input--square input-email" aria-describedby="emailHelp" placeholder="Email" maxlength="35" name="inputemail" <?php if (isset($_GET['bookingid']) && !empty($_GET['bookingid'])){?> value="{{ $Book_details[0]->email }}" <?php }else{ ?> value = "" <?php } ?> >
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group m-form__group">
									<span class="error-message phone_vali" style="display:none">
										The field is required.
									</span>
									<input type="text" class="form-control m-input m-input--square input-phone" placeholder="Phone Number" name="inputphone" maxlength="10" <?php if (isset($_GET['bookingid']) && !empty($_GET['bookingid'])){?> value="{{ $Book_details[0]->phone }}" <?php }else{ ?> value = "" <?php } ?>>
								</div>
							</div>
						</div>
					</div>
					<!--<div class="contact-details-block">
						<h6>Payment details</h6>
						<div class="row">
							
							<div class="col-md-6 ">
								<span class="error-message card-number-vali" style="display:none">
									The field is required.
								</span>
								<div class="form-group m-form__group">
									<input type="text" class="form-control m-input m-input--square input-card-number"  placeholder="Card Number" name="cmber">
								</div>
							</div>
							<div class="col-md-6 ">
								<span class="error-message card-name-vali" style="display:none">
									The field is required.
								</span>
								<div class="form-group m-form__group">
									<input type="text" class="form-control m-input m-input--square input-card" placeholder="Name On Card">
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-3 ">
								<span class="error-message month_vali" style="display:none">
									The field is required.
								</span>
								<div class="form-group m-form__group">
									<select class="form-control m-input m-input--square input-month" name="card_month">
										<option value="0">Exp Month</option>
										<option value="2">2</option>
										<option value="3">3</option>
										<option value="4">4</option>
										<option value="5">5</option>
									</select>
								</div>
							</div>
							
							<div class="col-md-3">
								<span class="error-message year_vali" style="display:none">
									The field is required.
								</span>
								<div class="form-group m-form__group">
									<select class="form-control m-input m-input--square input-year" name="card_year">
										<option value="0">Exp Year</option>
										<option value="2">2</option>
										<option value="3">3</option>
										<option value="4">4</option>
										<option value="5">5</option>
									</select>
								</div>
							</div>
							<div class="col-md-3">
								<span class="error-message cvv_vali" style="display:none">
									The field is required.
								</span>
								<div class="form-group m-form__group">
									<input type="text" class="form-control m-input m-input--square input-cvv" placeholder="CVV Code" name="card_cvv">
								</div>
							</div>
						</div>
					</div>-->
                    <?php 	//TotalFare
								
								$TotalFare = '';
								
								for($rm=1;$rm<=$_GET['norooms'];$rm++) {
									
								$TotalFare += $priceinroomdetailget['RoomIndex'][$_GET['RoomIndexs'.$rm]]['RoomRate']['attributes']['TotalFare'];
									
								}
												
												
								//echo $hotel_detail_mark_up;
								//echo $hotel_list->Options->Option->TotalPrice;
								if(isset($hotel_detail_mark_up)){
								$markup_price = $TotalFare % 100;
									$new_width = ($hotel_detail_mark_up / 100) * $TotalFare;
								   $Total_price = $TotalFare + $new_width;
								}else{
								$Total_price = $TotalFare;
								}
								  
								 ?>
					<div class="amount-payable">
						<span>	Amount Payable </span>${{$Total_price}}
					</div>
                    
                    
                    <div class="u-cancellation-policy-message">
                        <h4 class="cancellationheadingcls"> Cancellation Policy </h4>
                    	<div><h6 class="cancellationheading">Cancellation Deadline:  <?php echo date('Y-m-d', strtotime($policiesdetails['sBody']['HotelCancellationPolicyResponse']['CancelPolicies']['LastCancellationDeadline'])); ?></h6>
       
       
        
        <div class="alert-message_alter"><h6>Chargable cancellation Date</h6>
        
        <div class=""><span> </span> You may cancel your reservation for no charge before this deadline. 
		 Please note that we will assess full payment of reservation if you must cancel after this deadline.</div>
 <?php 
		$attr = '@attributes';
		$bo = 1;
        if(isset($policiesdetails['sBody']['HotelCancellationPolicyResponse']['CancelPolicies']['CancelPolicy'][0])){
		   foreach($policiesdetails['sBody']['HotelCancellationPolicyResponse']['CancelPolicies']['CancelPolicy'] as $Policy){
			   
			   if($Policy[$attr]['ChargeType'] == 'Fixed'){
				   
				   ?>
                   <div class=""><span><?php echo $bo;?>. </span>  If you will cancel the booking  <b>{{$Policy[$attr]['FromDate']}} </b> to  <b>{{$Policy[$attr]['ToDate']}}</b> then you should pay {{$Policy[$attr]['Currency']}} {{$Policy[$attr]['CancellationCharge']}} penalty for this booking</div>
                   
				   <?php 
			   }
			   
			   if($Policy[$attr]['ChargeType'] == 'Percentage'){
				   
				   ?>
                   <div class=""><span><?php echo $bo;?>. </span>  If you will cancel the booking  <b>{{$Policy[$attr]['FromDate']}} </b> to  <b>{{$Policy[$attr]['ToDate']}}</b> then you should pay {{$Policy[$attr]['CancellationCharge']}} % penalty for this booking</div>
                   
				   <?php 
			   }
			    if($Policy[$attr]['ChargeType'] == 'Night'){
				   
				   ?>
                   <div class=""><span><?php echo $bo;?>. </span>  If you will cancel the booking  <b>{{$Policy[$attr]['FromDate']}} </b> to  <b>{{$Policy[$attr]['ToDate']}}</b> then you should pay {{$Policy[$attr]['CancellationCharge']}} % penalty for this booking</div>
                   
				   <?php 
			   }
      ++$bo;
		   }
		}
	     ?>
        
                
                        </div>

                        

      </div>
                    </div>
                    
                    
                    
                    
                    
                    
                    
                   
					<div class="i-agree-checkbox">
						<span class="error-message term_vali" style="display:none">
							The field is required.
						</span>
						<label class="m-checkbox">
							<input type="checkbox" class="input-term"> I agree the terms and conditions and understand the cancellation policy.
							<span></span>
						</label>
					</div>
                    <?php 
					
					
					
					
					//array()
					$hotel_room_value = array();
			
					         //$hotel_room_value[$Option->OptionId] = $Option;
							 
							 
					
							     for($r=1;$r<=$_GET['norooms'];$r++) {  ?>
					               
                                   <input type="hidden" value="<?php echo $priceinroomdetailget['RoomIndex'][$_GET['RoomIndexs'.$r]]['RoomIndex'];?>" name="RoomId{{$r}}"/>
                                   <input type="hidden" value="<?php echo $priceinroomdetailget['RoomIndex'][$_GET['RoomIndexs'.$r]]['RoomTypeName'];?>" name="RoomName{{$r}}"/>
                                   <?php $roomCpount = 0; if(isset($_GET['adult'.$r])) { $roomCpount += $_GET['adult'.$r];  }?>
                                   <input type="hidden" value="<?php echo $roomCpount;?>" name="NumAdults{{$r}}"/>
                                   <?php $child = 0; if(isset($_GET['child'.$r])) { $child += $_GET['child'.$r];  }?>
                                   <input type="hidden" value="<?php echo $child;?>" name="NumChildren{{$r}}"/>
                                   <input type="hidden" value="<?php //echo Crypt::encrypt(base64_encode($priceinroomdetailget['RoomIndex'][$_GET['RoomIndexs'.$r]]['RoomRate']['DayRates']['DayRate'][$r]['attributes']['BaseFare']));?>" name="RoomPrice{{$r}}"/>
                                   
                                   
                    
                    <?php 
				
					
					}
					$deadlinedate_array = '';
					
					$canceldeail_array = array(); 
					$deadline = 1;
					
					
					if(isset($policiesdetails['sBody']['HotelCancellationPolicyResponse']['CancelPolicies']['LastCancellationDeadline'])){
							
							$deadlinedate_array = $policiesdetails['sBody']['HotelCancellationPolicyResponse']['CancelPolicies']['LastCancellationDeadline'];
					}
					
					
					?>
                    <input type="hidden" value="<?php echo Crypt::encrypt(base64_encode($deadlinedate_array)); ?>" name="canceldeadline"/>
                   
                    
                    <input type="hidden" value="<?php echo $hotel_Info['sBody']['HotelDetailsResponse']['HotelDetails']['attributes']['HotelName']; ?>" name="Hotelname"/>
                    
                    <input type="hidden" value="<?php echo $hotel_Info['sBody']['HotelDetailsResponse']['HotelDetails']['Address']; ?>" name="Hoteladdress"/>
                    
                    <input type="hidden" value="4" name="Hotelstar"/>
                    
					<div class="complete-reservation">
						<button type="submit" class="btn btn-primary com_reser_book" id="book-result" > Complete Reservation</button>
					</div>
				</div>	
				<form>
				</div>
			</div>
			
			<!--End::Section-->

			
			<!--End::Section-->
		</div>
	
    
    <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Cancellation Policies</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <?php 
		/*echo '<pre>';
		print_r($policiesdetails);
		echo '</pre>';
		*/
		
		
		?>
       
        
        
        
        <div><h5 class="cancellationheading">Cancellation Deadline: <?php echo date('Y-m-d', strtotime($policiesdetails['sBody']['HotelCancellationPolicyResponse']['CancelPolicies']['LastCancellationDeadline'])); ?></h5>
       
        <div class="alert-message_alter"><h5>Chargable cancellation Date</h5>
        
        <?php 
		$attr = '@attributes';
		$bo = 1;
        if(isset($policiesdetails['sBody']['HotelCancellationPolicyResponse']['CancelPolicies']['CancelPolicy'][0])){
		   foreach($policiesdetails['sBody']['HotelCancellationPolicyResponse']['CancelPolicies']['CancelPolicy'] as $Policy){
			   
			   if($Policy[$attr]['ChargeType'] == 'Fixed'){
				   
				   ?>
                   <div class=""><span><?php echo $bo;?>. </span>  If you will cancel the booking  <b>{{$Policy[$attr]['FromDate']}} </b> to  <b>{{$Policy[$attr]['ToDate']}}</b> then you should pay {{$Policy[$attr]['Currency']}} {{$Policy[$attr]['CancellationCharge']}} penalty for this booking</div>
                   
				   <?php 
			   }
			   
			   if($Policy[$attr]['ChargeType'] == 'Percentage'){
				   
				   ?>
                   <div class=""><span><?php echo $bo;?>. </span>  If you will cancel the booking  <b>{{$Policy[$attr]['FromDate']}} </b> to  <b>{{$Policy[$attr]['ToDate']}}</b> then you should pay {{$Policy[$attr]['CancellationCharge']}} % penalty for this booking</div>
                   
				   <?php 
			   }
			    if($Policy[$attr]['ChargeType'] == 'Night'){
				   
				   ?>
                   <div class=""><span><?php echo $bo;?>. </span>  If you will cancel the booking  <b>{{$Policy[$attr]['FromDate']}} </b> to  <b>{{$Policy[$attr]['ToDate']}}</b> then you should pay {{$Policy[$attr]['CancellationCharge']}} % penalty for this booking</div>
                   
				   <?php 
			   }
      ++$bo;
		   }
		}
	     ?>
        
        
        
        </div>

        
      </div>
      </div>
      <div class="modal-footer modal-footer-withpadding">
        <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

    
    
    
    
    
    </div>
    
    
    
	<?php 
	
	
	//date range 
	function getDatesFromRange($strDateFrom,$strDateTo) {



		$aryRange=array();



		$iDateFrom=mktime(1,0,0,substr($strDateFrom,5,2),     substr($strDateFrom,8,2),substr($strDateFrom,0,4));

		$iDateTo=mktime(1,0,0,substr($strDateTo,5,2),     substr($strDateTo,8,2),substr($strDateTo,0,4));



		if ($iDateTo>=$iDateFrom)

		{

        array_push($aryRange,date('Y-m-d',$iDateFrom)); // first entry

        while ($iDateFrom<$iDateTo)

        {

            $iDateFrom+=86400; // add 24 hours

            array_push($aryRange,date('Y-m-d',$iDateFrom));

        }

    }

    return $aryRange;

}


?>            

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script>
var paymentinserturl = "{{ URL::to('ajaxhotelpaymenttbo')}}";
	$(document).ready(function (){
		
		
		
$(document).on('click', '.closeurl', function(){

$('.modelshow').hide();

var url = $('#homeurl').val();
window.history.pushState('', '', url);




});

		var id = $('#getOptionID').val();
		$('.optionid'+id).show(); 
		
//console.log(optionvalues);

		$(document).on('click', '.com_reser_book', function(){
			var error = 0;
			var Addselect = $('.selectAdd').val();
//var adultCount = $('.adultgetCount').val();
       //console.log(adultCount);
 
	//term condition
	//payment_ajax();
	if($('.input-term').prop("checked") == false){
		$('.term_vali').show();
		$('.input-term').focus();
		error=1;
	}else{
		$('.term_vali').hide();
		
	}
	//credit card validation
	if($('.input-cvv').val() == ''){
		$('.cvv_vali').show();
		$('.input-cvv').focus();
		error=1;
	}else{
		$('.cvv_vali').hide();
		
	}
	
	if($('.input-year').val() == ''){
		$('.year_vali').show();
		$('.input-year').focus();
		error=1;
	}else{
		$('.year_vali').hide();
		
	}
	if($('.input-month').val() == ''){
		$('.month_vali').show();
		$('.input-month').focus();
		error=1;
	}else{
		$('.month_vali').hide();
	}
	
	if($('.input-card').val() == ''){
		$('.card-name-vali').show();
		$('.input-card').focus();
		error=1;
	}else{
		$('.card-name-vali').hide();
		
	}
	if($('.input-card-number').val() == ''){
		$('.card-number-vali').show();
		$('.input-card-number').focus();
		error=1;
	}else{
		$('.card-number-vali').hide();
		
	}
	
	
	
	var roomcount = $('.roomcount').data('room');

	for(r=0;r<roomcount;r++){
			
		//condition
		var adultCount = $('.adultgetCount'+r).val();
	
       //console.log(adultCount+r);
	  // console.log('test');
	  for(a=1;a<=adultCount+r;a++){
		  
       if($('.selectAdd'+r+a).val() == ''){
			$('.selectAdderror'+r+a).show();
			$('.selectAdd'+r+a).focus();
			error=1;
		}else{
			$('.selectAdderror'+r+a).hide();
			
		}
		if($('.inptut-room-firstname'+r+a).val() == ''){
			$('.vali-room-firstname'+r+a).show();
			$('.inptut-room-firstname'+r+a).focus();
			error=1;
		}else{
			$('.vali-room-firstname'+r+a).hide();
			
		}
		
		
		if($('.inptut-room-lastname'+r+a).val() == ''){
			$('.vali-room-lastname'+r+a).show();
			$('.inptut-room-lastname'+r+a).focus();
			error=1;
		}else{
			$('.vali-room-lastname'+r+a).hide();
			
		}
		}
		
		//Child Validation
		var childCount = $('.childgetCount'+r).val();
		 for(c=1;c<=childCount+r;c++){
		  
		  
	  
		if($('.inptut-room-childfirstname'+r+c).val() == ''){
			$('.vali-room-childfirstname'+r+c).show();
			$('.inptut-room-childfirstname'+r+c).focus();
			error=1;
		}else{
			$('.vali-room-childfirstname'+r+c).hide();
			
		}
		
		
		if($('.inptut-room-childlastname'+r+c).val() == ''){
			$('.vali-room-childlastname'+r+c).show();
			$('.inptut-room-childlastname'+r+c).focus();
			error=1;
		}else{
			$('.vali-room-childlastname'+r+c).hide();
			
		}
		}
		
		
		

	
	
	
}




/*if($('.input-phone').val() == ''){
	$('.phone_vali').show();
	$('.input-phone').focus();
	error=1;
}else{
	$('.phone_vali').hide();
}
	//email
	var sEmail = $('.input-email').val();
	if($.trim(sEmail).length == 0){
		$('.email_vali').show();
		$('.input-email').focus();
		$('.email_vali1').hide();
		error=1;
	}
	if($('.input-email').val() != ''){
		if(validateEmail(sEmail)){
			$('.email_vali').hide();
			$('.email_vali1').hide();
			
		}else{
			$('.email_vali1').show();
			$('.email_vali').hide();
			error=1;
		}
	}*/

	if($('.input-lastname').val() == ''){
		$('.lastname').show();
		$('.input-lastname').focus();
		error=1;
	}else{
		$('.lastname').hide();
	}
	//first name
	if($('.input-firstname').val() == ''){
		$('.firstname').show();
		$('.input-firstname').focus();
		error=1;
	}else{
		$('.firstname').hide();
	}
	//Get Adult Mr details
	if($('.selectAdd').val() == ''){
		$('.selectAdderror').show();
		//$('.input-firstname').focus();
		error=1;
	}else{
		$('.selectAdderror').hide();
	}
	
	
	$(".input-firstname").keypress(function(){
		var rsult = $(".input-firstname").val();
});
	
	
	//alert();
	if(error == 1){
		return false;
	}else{
		('#paymentsummit').submit();
		payment_ajax();
		return false;
	}
	
});
//phone
$(".input-phone").keypress(function (e) {

	if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) 
	{
		$("#errmsg").html("Digits Only").show().fadeOut(5000);
		$(this).css({"border": "1px solid red"});
		return false;
	}
	else
	{
		$(this).css({"border-color": "#ebedf2","color":"#575962"});
	}
});
//card number 

$(".input-card-number").keypress(function (e) {

	if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) 
	{
		$("#errmsg").html("Digits Only").show().fadeOut(5000);
		$(this).css({"border": "1px solid red"});
		return false;
	}
	else
	{
		$(this).css({"border-color": "#ebedf2","color":"#575962"});
	}
});	 






});

	function validateEmail(sEmail) {
		var filter = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;
		if (filter.test(sEmail)) {
			return true;
		}
		else {
			
			return false;
		}
	}



     $(".selectAdd").change(function () {
        var val = $(this).val();
        if (val == "Mr.") {
            $("#selectadult1").html("<option value='Mr.'>Mr</option>");
        } else if (val == "Mrs.") {
            $("#selectadult1").html("<option value='Mrs.'>Mrs</option>");
        } else if (val == "Miss") {
            $("#selectadult1").html("<option value='Miss'>Miss</option>");
        }
    });
	  
	  $("#selectadult1").change(function () {
        var val = $(this).val();
        if (val == "Mr.") {
            $(".selectAdd").html("<option value='Mr.'>Mr</option>");
        } else if (val == "Mrs.") {
            $(".selectAdd").html("<option value='Mrs.'>Mrs</option>");
        } else if (val == "Miss") {
            $(".selectAdd").html("<option value='Miss'>Miss</option>");
        }
    });


  

	function firstfunction() {
		document.getElementById('inptutroomfirstname1').value = document.getElementById('inputfirstname').value;
	}




	function lastfunction() {
		document.getElementById('inptutroomlastname1').value = document.getElementById('inputlastname').value;
	}

	function payment_ajaxddd() {
		
	//alert('hi');
	
	
	var thehref = '';
	var firstname = $('.input-firstname').val();
	var lastname = $('.input-lastname').val();
	var email = $('.input-email').val();
	var phone = $('.input-phone').val();
	var roomcount = $('.roomcount').data('room');

	var cardnumber = $('.input-card-number').val();
	var roomname = '';
	for(r=1;r<=roomcount;r++){
		roomname += 'firstname'+r+'='+$('.inptut-room-firstname'+r).val()+'&lastname'+r+'='+$('.inptut-room-lastname'+r).val(); 
	}
	
}



function payment_ajax(){
	//$('.loder-edit').show();


        $.ajax({
        type:"POST",
        url:paymentinserturl,
        data:$('#paymentsummit').serialize(),
        success: function(data){

            //window.location.href = data;
			
			if(data.confirm == 1){
			alert('your booking is confirm');
			}else{
			alert('your booking is pending');	
			}
        },
        error: function(data){

        }
    })
	
	
}











</script>


<script language="javascript">


</script>


	
@endsection
