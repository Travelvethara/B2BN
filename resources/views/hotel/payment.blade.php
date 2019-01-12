@extends('layouts.app')

@section('content')
<?php 



$date1=date_create($hotel_details->Body->CheckInDate);
$date2=date_create($hotel_details->Body->CheckOutDate);
$diff=date_diff($date1,$date2);
$daycount = $diff->days;

$date_from = $_GET['checkin'];   
$date_from = strtotime($date_from); // Convert date to a UNIX timestamp  
$date_to = $_GET['checkout'];  
$date_to = strtotime($date_to); // Convert date to a UNIX timestamp  
  
$dataFrom = $hotel_details->Body->CheckInDate;
$dateTo = $hotel_details->Body->CheckOutDate; 
$finalday = $daycount-1;



foreach($hotel_details->Body->Hotels->Hotel->Options->Option as $Option){

						
if($_GET['optionID'] == $Option->OptionId){
for($r=0;$r<=$_GET['norooms']-1;$r++){
	
	
 $numadult = $Option->Rooms->Room[$r]->NumAdults;
 $Option->Rooms->Room[$r]->NumChildren;

// echo $Option->Rooms->Room[$r]->NumChildren;
	
	
}
}
}
if (isset($_GET['bookingid']) && !empty($_GET['bookingid'])){
	
$booking_guest = unserialize($Book_details[0]->guest);	
/*echo '<pre>';
print_r($booking_guest);

echo '</pre>';
exit;*/
}


$currenytype = 'USD_'.$_GET['currency'];

$url = "https://free.currencyconverterapi.com/api/v5/convert?q=".$currenytype."&compact=ultra"; 
$cur=curl_init();
curl_setopt($cur,CURLOPT_URL,$url);
curl_setopt($cur, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
curl_setopt($cur,CURLOPT_HTTPHEADER,array('Accept:application/xml'));
curl_setopt($cur, CURLOPT_HTTPHEADER, array('Content-Type: text/xml,charset=UTF-8'));
curl_setopt($cur, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($cur, CURLOPT_RETURNTRANSFER,1);
$currency_curl_value = curl_exec($cur);
$cureency_result = json_decode($currency_curl_value, true);

$currecny_price = $cureency_result[$currenytype];


if(isset($_GET['tha'])){

echo '<pre>';
print_r($currecny_price);
echo '</pre>';
exit;
}

?>



<div class="m-grid__item m-grid__item--fluid m-wrapper">
	<!-- BEGIN: Subheader -->
	
	<!-- END: Subheader -->
	<div class="m-content">
		<!--Begin::Section-->
		<div class="payment-page roboto clear">
        <input type="hidden" id="getOptionID" value="<?php echo $_GET['optionID']; ?>" readonly="readonly" />
			<div class="payment-page-left">
				<h2>Review Booking Details</h2>
				<div class="payment-htel-details clear">
					<div class="payment-hotel-image">
						<img src="{{$hotel_Info->Body->Hotels->Hotel->Images->Image[0]}}" alt="htel-images">
					</div>
					<div class="payment-hotel-info">
					<div class="list-wrap-two">
						<div class="ho-name"> {{$hotel_Info->Body->Hotels->Hotel->HotelName}}</div>
                        <div class="hotel-list-star hotel-details-u hotel-details-u-confirmation">
                            	<ul>
								@for($s=1;$s<=round($hotel_Info->Body->Hotels->Hotel->StarRating);$s++)
								 <li><img src="{{asset('img/star.png')}}" /></li>
								 @endfor
                                 </ul>
							</div>
							<div class="hotel-o-address">
								{{$hotel_Info->Body->Hotels->Hotel->Address}}
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
					<div class="below-payment-image-details-cont clear">
						<div class="below-payment-image-left">
							<b>Rooms</b>
						</div>
						<div class="below-payment-image-right">
							{{$_GET['norooms']}}
						</div>
					</div>
                    <div class="below-payment-image-details-cont clear">
						<div class="below-payment-image-left">
							<b>Room Name</b>
						</div>
						<div class="below-payment-image-right">
							  {{$Option->Rooms->Room[0]->RoomName}}
						</div>
					</div>
                  
                    
                    <table class="table table-striped">
                    
                    <th>Adult</th>
                    <th>Children</th>
                    </tr>
                     <?php 
					
					foreach($hotel_details->Body->Hotels->Hotel->Options->Option as $Option){
						
						if($_GET['optionID'] == $Option->OptionId){
							
							 for($r=0;$r<$_GET['norooms'];$r++) {  
							  
							 
					         ?> 
                             
                             
                             
                             
                    <tr>
                   
                    <td>{{$Option->Rooms->Room[$r]->NumAdults}}</td>
                    <td> {{$Option->Rooms->Room[$r]->NumChildren}}</td>
                    </tr>
                    <?php  } } } ?>
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
					
					
					/*echo '<pre>';
							 print_r($hotel_details);
							 echo '</pre>';*/
					
					
					
					foreach($hotel_details->Body->Hotels->Hotel->Options->Option as $Option){
						
						
						if($_GET['optionID'] == $Option->OptionId){
							 /*
							     echo '<pre>';
								 print_r($Option);
								 echo '</pre>';*/
							 
							 
							 
					         ?> 
                            
					<!--<div class="nighty-rates-block">
						<b>Nighty Rates </b>
					</div>-->
                    <table class="table table-striped">
                  
                             @for($i=0;$i<=$daycount-1; $i++)<!--<tr>
                                            
								<th> {{date("d M Y", strtotime($getDatesFromRange[$i]))}}:<?php $i; ?></th>
                                 <?php 
								 
								 
							   
								 
								 
								 if($Option->Rooms->Room[0]->DailyPrices) {
									 $Total_price_room = '';
									if(isset($hotel_detail_mark_up)){
								$markup_price = $Option->Rooms->Room[0]->DailyPrices->DailyPrice[$i] % 100;
									$new_width = ($hotel_detail_mark_up / 100) * $Option->Rooms->Room[0]->DailyPrices->DailyPrice[$i];
								   $Total_price_room = $Option->Rooms->Room[0]->DailyPrices->DailyPrice[$i] + $new_width;
								}else{
								    $Total_price_room = $Option->Rooms->Room[0]->DailyPrices->DailyPrice[$i];
								} 
									
									if(isset($_GET['markup']) && !empty($_GET['markup'])){
                                    	$Total_price_room =  number_format(((($_GET['markup'] / 100) * $Total_price_room)+$Total_price_room),2);
                                    }
									
									$Total_price_room  = $currecny_price * $Total_price_room;
									 
									  ?>
					                  <td>{{$_GET['currency']}} {{number_format($Total_price_room, 2)}}</td>
                                 <?php }elseif($Option->Rooms->Room->RoomPrice){
									 
									  $Total_price_room = '';
									if(isset($hotel_detail_mark_up)){
								$markup_price = $Option->Rooms->Room->RoomPrice % 100;
									$new_width = ($hotel_detail_mark_up / 100) * $Option->Rooms->Room->RoomPrice;
								   $Total_price_room = $Option->Rooms->Room->RoomPrice + $new_width;
								}else{
								    $Total_price_room = $Option->Rooms->Room->RoomPrice;
								} 
									
									if(isset($_GET['markup']) && !empty($_GET['markup'])){
                                    	$addMarkupPrice = (($_GET['markup'] / 100) * $Total_price_room);
									
									    $Total_price_room = $Total_price_room +  $addMarkupPrice;
                                    }
									
									$Total_price_room  = $currecny_price * $Total_price_room;
									 
									 
									 
									  ?>
                                      <td>{{$_GET['currency']}} {{number_format($Total_price_room, 2)}}</td>
                                  <?php } ?>
									   </tr>--> @endfor
											  
							                <!-- <tr>
												<th>Tax:</th>
												<td>$0</td>
											  </tr>-->
                                              <?php 
											    if(isset($_GET['norooms'])){
													
													$RoomPrice = '';
													
													for($rom=0;$rom<$_GET['norooms'];$rom++){
														$RoomPrice += (float)($Option->Rooms->Room[$rom]->RoomPrice);
														
													}
												}
												
												
											   if(isset($hotel_detail_mark_up)){
								                $new_width = ($hotel_detail_mark_up / 100) * $RoomPrice;
								               
											    $RoomPrice = $RoomPrice + $new_width;
												
													if(isset($Option->DiscountApplied)) {
												 $new_width_tax = ($hotel_detail_mark_up / 100) * $Option->DiscountApplied;
								               
											    $RoomPrice_tax = $Option->DiscountApplied + $new_width_tax;
												     }
								
												//Discount account price
								                 
												 }else{
								                 
												 $RoomPrice = $RoomPrice;
												 if(isset($Option->DiscountApplied)) {
												 $RoomPrice_tax = $Option->DiscountApplied;
												 }
												 }
								
								
								
								//echo $RoomPrice;
								//echo '<br>';
								//echo $RoomPrice_tax;
								
							
								
								
							  if(isset($_GET['markup']) && !empty($_GET['markup'])){
							    
								      $addMarkupPrice = (($_GET['markup'] / 100) * $RoomPrice);
										$RoomPrice = $RoomPrice +  $addMarkupPrice;
										
										if(isset($Option->DiscountApplied)) {
										$addMarkupPrice_tax = (($_GET['markup'] / 100) * $RoomPrice_tax);
										$RoomPrice_tax = $RoomPrice_tax +  $addMarkupPrice_tax;
										}
										
										//Discount account price
										
										
                              }	
												
											  
											  ?>
                                              
                                              
											   <tr>
												<th>Orginal Price</th>
                                                <td>{{$_GET['currency']}} {{$RoomPrice}}</td>
                                                </tr>
                                                <?php if(isset($Option->DiscountApplied)) { ?>
                                                <tr>
                                                <th>Tax:</th>
                                                 <td>{{$_GET['currency']}} {{$RoomPrice_tax}}</td>
                                                </tr>
                                                <?php } ?>
                                                
                                                <tr>
                                                <th>Grand Total:</th>
                                                <?php
												$Total_price = '';
								//echo $hotel_detail_mark_up;
								//echo $hotel_list->Options->Option->TotalPrice;
								if(isset($hotel_detail_mark_up)){
								$markup_price = $Option->TotalPrice % 100;
									$new_width = ($hotel_detail_mark_up / 100) * $Option->TotalPrice;
								   $Total_price = $Option->TotalPrice + $new_width;
								}else{
								   $Total_price = $Option->TotalPrice;
								}
								
								echo $Total_price;
								if(isset($_GET['markup']) && !empty($_GET['markup'])){
                                    	$addMarkupPrice = (($_GET['markup'] / 100) * $Total_price);
									
									    $Total_price = $Total_price +  $addMarkupPrice;
                                    }
									
									$Total_price_grand  = $currecny_price * $Total_price; 
								   //echo $hotel_list->Options->Option->TotalPrice;
								 ?>
												<td>{{$_GET['currency']}} {{number_format($Total_price_grand, 2)}}</td>
                                              
											  </tr>
										</table>
                                          <?php  
						                  }
					           }
					?>
       
                    
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
			<form action="" method="post" id="paymentsummit">
            <input type="hidden" name="_token" value="<?php echo @csrf_token(); ?>">
            <input type="hidden" name="canceldeadline_confirm" value="<?php echo Crypt::encrypt(base64_encode($policiesdetails->CancellationDeadline)); ?>">
            <?php if (isset($_GET['bookingid']) && !empty($_GET['bookingid'])){ ?>
            <input type="hidden" name="BookingdeleteId" value="<?php echo $_GET['bookingid']; ?>" />
            <?php } $t = 1; $room_daily_price_array = array();
			
			if($_GET['norooms'] == 1){ ?>
            
            <?php 
	   
			if(isset($Option->Rooms->Room->RoomPrice)){
				$room_daily_price = $Option->Rooms->Room->RoomPrice;
			//$room_daily_price_array[ = $room_daily_price;   
	           ?>
			<input type="hidden" name="roomdailycontnt[]" value="<?php echo Crypt::encrypt(base64_encode($room_daily_price)); ?>">
			 
			<?php 
			}
			?>
				
			<?php }else{ 
			?>
            @for($i=0;$i<=$daycount-1; $i++)
            
            
            <?php 
	         
			 
			
			if(isset($Option->Rooms->Room[0]->RoomPrice)){
				$room_daily_price = $Option->Rooms->Room[0]->RoomPrice;
			    $room_daily_price_array[$t] = $room_daily_price;
				
				if(isset($hotel_detail_mark_up)){
								$markup_price = $room_daily_price % 100;
									$new_width = ($hotel_detail_mark_up / 100) * $room_daily_price;
								   $room_daily_price = $room_daily_price+ $new_width;
								}else{
						$room_daily_price = $room_daily_price;
								}
				
				
				
				   
	           ?>
			<input type="hidden" name="roomdailycontnt[]" value="<?php echo Crypt::encrypt(base64_encode($room_daily_price)); ?>">
			 
			<?php 
			++$t;
			}
			
			
			?>
            
            <?php 
	         
			 
			
			if(isset($Option->Rooms->Room[0]->DailyPrices)){
				$room_daily_price = $Option->Rooms->Room[0]->DailyPrices->DailyPrice[$i];
			$room_daily_price_array[$t] = $room_daily_price;
			
			
			if(isset($hotel_detail_mark_up)){
								$markup_price = $room_daily_price % 100;
									$new_width = ($hotel_detail_mark_up / 100) * $room_daily_price;
								   $room_daily_price = $room_daily_price+ $new_width;
								}else{
						$room_daily_price = $room_daily_price;
								}
			   
	           ?>
			<input type="hidden" name="roomdailycontnt[]" value="<?php echo Crypt::encrypt(base64_encode($room_daily_price)); ?>">
			 
			<?php 
			++$t;
			}
			
			
			?>
            @endfor
            <?php } ?>
				<div class="contact-details-block-wrap">	
					
					<div class="contact-details-block">
                    <input type="hidden" class=""  name="noofroom" value="<?php echo $_GET['norooms']; ?>">
                     <?php foreach($hotel_details->Body->Hotels->Hotel->Options->Option as $Option){
						
					 if($_GET['optionID'] == $Option->OptionId){
						 
						 $TotalPrice_total = '';
						if(isset($hotel_detail_mark_up)){
								$markup_price = $Option->TotalPrice % 100;
									$new_width = ($hotel_detail_mark_up / 100) * $Option->TotalPrice;
								   $TotalPrice_total = $Option->TotalPrice+ $new_width;
								}else{
						      $TotalPrice_total = $Option->TotalPrice;
								
								} 
						 
						 
						 if(isset($_GET['markup']) && !empty($_GET['markup'])){
                                    	$addMarkupPrice = (($_GET['markup'] / 100) * $TotalPrice_total);
									
									    $TotalPrice_total = $TotalPrice_total +  $addMarkupPrice;
                                    }
						 
						 
						 
						  ?>
					
                      <input type="hidden" class=""  name="totalprice" value="<?php echo Crypt::encrypt(base64_encode($TotalPrice_total)); ?>" >
                      
                       <input type="hidden" class=""  name="encrypt" value="<?php echo Crypt::encrypt(base64_encode(11)); ?>" >
                       
                      <input type="hidden" class=""  name="markupprice" value="<?php if(isset($hotel_detail_mark_up)) { echo Crypt::encrypt(base64_encode($hotel_detail_mark_up)); }else{ echo '0';} ?>" >
                      
                      <input type="hidden" class=""  name="DiscountApplied" value="<?php if(isset($Option->DiscountApplied)) { echo Crypt::encrypt(base64_encode($Option->DiscountApplied)); }else{ echo '0';} ?>" >
                     <?php } } ?>
                     <input type="hidden" class=""  name="optionID" value="<?php echo $_GET['optionID']; ?>" >
						<h6 class="roomcount" data-room="3">Guest Details</h6>
                        
                                               
<?php foreach($hotel_details->Body->Hotels->Hotel->Options->Option as $Option){

						$roomid = 1;
if($_GET['optionID'] == $Option->OptionId){
for($r=0;$r<$_GET['norooms'];$r++){ ?>
						
                        <p>Room {{$r+1}}</p>
                        @for($a=1;$a<=$Option->Rooms->Room[$r]->NumAdults;$a++)
                         <input type="hidden" class="adultgetCount{{$r}}" value="<?php echo $Option->Rooms->Room[$r]->NumAdults; ?>" />
                      
						
						<div class="row">
                           <?php ?>
                        <div class="col-md-2">
								<div class="form-group m-form__group">
									<span class="error-message selectAdderror{{$r}}{{$a}}" style="display:none">
										The field is required.
									</span>
								<select class="form-control m-input m-input--square selectAdd{{$r}}{{$a}}" name="selectadult{{$r}}{{$a}}" <?php if($r==0 && $a==1){?>   id="selectadult1" <?php }?> >
                                <option value="Mr." <?php if (isset($_GET['bookingid']) && !empty($_GET['bookingid'])){ if($booking_guest[$r]['title'][$a] == 'Mr.') { ?> selected="selected" <?php }} ?>>Mr.</option>
                                <option value="Mrs." <?php if (isset($_GET['bookingid']) && !empty($_GET['bookingid'])){ if($booking_guest[$r]['title'][$a] == 'Mrs.') { ?> selected="selected" <?php }} ?>>Mrs</option>
                                <option value="Miss" <?php if (isset($_GET['bookingid']) && !empty($_GET['bookingid'])){ if($booking_guest[$r]['title'][$a] == 'Miss') { ?> selected="selected" <?php }} ?>>Miss</option>
  
                                </select>
								</div>
                             </div>
                       <?php ?>
							<div class="col-md-4 nopadright">
								<span class="error-message vali-room-firstname{{$r}}{{$a}}" style="display:none">
									The field is required.
								</span>
								<div class="form-group m-form__group">
                               
									<input type="text" class="form-control m-input m-input--square inptut-room-firstname{{$r}}{{$a}}"  maxlength="35" placeholder="First Name"  <?php if($r==0 && $a==1){?>  id="inptutroomfirstname1" <?php }?> name="inptutroomfirstname{{$r}}{{$a}}" <?php if (isset($_GET['bookingid']) && !empty($_GET['bookingid'])){ if (!empty($booking_guest[$r]['firstname'][$a]) && isset($booking_guest[$r]['firstname'][$a])) { ?> value="{{ $booking_guest[$r]['firstname'][$a] }}" <?php } }else{ ?> value = "" <?php } ?>>
								</div>
							</div>
							<div class="col-md-6 ">
								<span class="error-message vali-room-lastname{{$r}}{{$a}}" style="display:none">
									The field is required.
								</span>
								<div class="form-group m-form__group">
									<input type="text" class="form-control m-input m-input--square inptut-room-lastname{{$r}}{{$a}}" maxlength="35" placeholder="Last Name" <?php if($r==0 && $a==1){?> id="inptutroomlastname1" <?php }?> name="inptutroomlastname{{$r}}{{$a}}" <?php if (isset($_GET['bookingid']) && !empty($_GET['bookingid'])){ if (!empty($booking_guest[$r]['lastname'][$a]) && isset($booking_guest[$r]['lastname'][$a])) { ?> value="{{ $booking_guest[$r]['lastname'][$a] }}" <?php } }else{ ?> value = "" <?php } ?>>
								</div>
							</div>
						</div>
                        @endfor
                         @for($ch=1;$ch<=$Option->Rooms->Room[$r]->NumChildren;$ch++)
                          <input type="hidden" class="childgetCount{{$r}}" value="<?php echo $Option->Rooms->Room[$r]->NumChildren; ?>" />
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
								<div class="form-group m-form__group">
									<select class="form-control m-input nochildageclassva{{$r}}{{$ch}}" name="childage{{$r}}{{$ch}}" id="nochildage{{$r}}{{$ch}}">
																	<option value="0">Age</option>
																	<option value="1">1</option>
																	<option value="2">2</option>
																	<option value="3">3</option>
																	<option value="4">4</option>
																	<option value="5">5</option>
																	<option value="6">6</option>
																	<option value="7">7</option>
																	<option value="8">8</option>
																	<option value="9">9</option>
																	<option value="10">10</option>
																	<option value="11">11</option>
																	<option value="12">12</option>
																</select>
								</div>
							</div>
                            
                            
						</div>
                        @endfor
						
                          <?php } } } ?>
					</div>
                    
                    <div class="contact-details-block">
						<h6>Contact Details</h6>
                        <?php /*?><div class="row">
                        <div class="col-md-3">
								<div class="form-group m-form__group">
									<span class="error-message selectAdderror" style="display:none">
										The field is required.
									</span>
								<select class="form-control m-input m-input--square selectAdd" id="selectadult" onchange="selectfunction();">
                                <option value="" selected>---Select--</option>
                                <option value="Mr." <?php if (isset($_GET['bookingid']) && !empty($_GET['bookingid'])){ if($booking_guest[0]['title'][1] == 'Mr.') { ?> selected="selected" <?php }} ?>>Mr.</option>
                                <option value="Mrs." <?php if (isset($_GET['bookingid']) && !empty($_GET['bookingid'])){ if($booking_guest[0]['title'][1] == 'Mrs.') { ?> selected="selected" <?php }} ?>>Mrs</option>
                                <option value="Miss" <?php if (isset($_GET['bookingid']) && !empty($_GET['bookingid'])){ if($booking_guest[0]['title'][1] == 'Miss') { ?> selected="selected" <?php }} ?>>Miss</option>
  
                                </select>
								</div>
                             </div>
                        </div><?php */?>
						<div class="row">
							<div class="col-md-6">
								<div class="form-group m-form__group">
									<span class="error-message firstname" style="display:none">
										The field is required.
									</span>
									<input type="text" class="form-control m-input m-input--square input-firstname" placeholder="First Name" maxlength="30" onkeyup="firstfunction();" id="inputfirstname" name="inputfirstname" <?php if (isset($_GET['bookingid']) && !empty($_GET['bookingid'])){?> value="{{ $Book_details[0]->firstname }}" <?php }else{ ?> value = "" <?php } ?>>
								</div>
							</div>
							<div class="col-md-6 ">
								<div class="form-group m-form__group">
									<span class="error-message lastname" style="display:none">
										The field is required.
									</span>
									<input type="text" class="form-control m-input m-input--square  input-lastname"  placeholder="Last Name" maxlength="30" onkeyup="lastfunction();" id="inputlastname" name="inputlastname" <?php if (isset($_GET['bookingid']) && !empty($_GET['bookingid'])){?> value="{{ $Book_details[0]->lastname }}" <?php }else{ ?> value = "" <?php } ?>>
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
                    <?php foreach($hotel_details->Body->Hotels->Hotel->Options->Option as $Option){
						
						if($_GET['optionID'] == $Option->OptionId){ ?>
                         <?php
							    $Total_price = '';
								
								if(isset($hotel_detail_mark_up)){
								$markup_price = $Option->TotalPrice % 100;
									$new_width = ($hotel_detail_mark_up / 100) * $Option->TotalPrice;
								   $Total_price = $Option->TotalPrice + $new_width;
								}else{
								$Total_price = $Option->TotalPrice;
								}
								
								
						
								if(isset($_GET['markup']) && !empty($_GET['markup'])){
                                    	$Total_price =  number_format(((($_GET['markup'] / 100) * $Total_price)+$Total_price),2);
                                 }
									
									$Total_price_grand  = $currecny_price * $Total_price;
								
								  
								 ?>
					<div class="amount-payable">
						<span>	Amount Payable </span>{{$_GET['currency']}} {{number_format($Total_price_grand, 2)}}
					</div>
                    <?php } } ?>
                    
                    <div class="u-cancellation-policy-message">
                        <h4 class="cancellationheadingcls"> Cancellation Policy </h4>
                    	<div><h6 class="cancellationheading">Cancellation Deadline:  <?php echo $policiesdetails->CancellationDeadline; ?></h6>
       
       
        
        <div class="alert-message_alter"><h6>Chargable cancellation Date</h6>
        
        <div class=""><span> </span> You may cancel your reservation for no charge before this deadline. 
		 Please note that we will assess full payment of reservation if you must cancel after this deadline.</div>
                         <?php 
		
		//Percentage

		$bo = 1;
		if(isset($policiesdetails->Policies->Policy)){
		foreach($policiesdetails->Policies->Policy as $Policy){
			
			if($Policy->Type == 'Percentage'){
				
				
				?>
                <div class=""><span></span> If you will cancel the booking after  <b><?php echo $Policy->From;  ?></b> then you should  pay  <b<<?php echo $Policy->Value;  ?>% </b> penalty for this booking.</div>
                
                <?php 
				
				
			}
			
			if($Policy->Type == 'Amount'){
				
				?>
                <div class=""><span> </span> If you will cancel the booking after  <b><?php echo $Policy->From;  ?></b> then you should  pay $ <b><?php echo $Policy->Value;  ?></b> penalty for this booking.</div>
                
                <?php 
				
			}
			
			
			if($Policy->Type == 'Nights'){
				
				
				?>
                <div class=""><span></span> If you will cancel the booking after  <b><?php echo $Policy->From;  ?></b> then you should  pay <b><?php echo $Policy->Value;  ?></b> night price penalty for this booking.</div>
                
                <?php 
				
				
			}
	
			++$bo;
			
		} }
		
		?>
                
                        </div>
                        
                         <?php if(!empty($policiesdetails->Alerts->Alert)){?>
        <div class="alert-message alert-message_alter cancellblock">
        <h5>Cancel Message</h5>
        
        <?php 
		$go = 1;
		foreach($policiesdetails->Alerts->Alert as $Alerts){
			?>
			
            <p><span></span>  <?php echo $Alerts;  ?></p>
            
		<?	
		++$go;
        }
		
		
		?>
        
        
        
        </div>
<?php } ?>
                        

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
					foreach($hotel_details->Body->Hotels->Hotel->Options->Option as $Option){
						
						if($_GET['optionID'] == $Option->OptionId){
					         //$hotel_room_value[$Option->OptionId] = $Option;
							     for($r=0;$r<$_GET['norooms'];$r++) {  ?>
					               
                                   <input type="hidden" value="<?php echo $Option->Rooms->Room[$r]->RoomId;?>" name="RoomId{{$r}}"/>
                                   <input type="hidden" value="<?php echo $Option->Rooms->Room[$r]->RoomName;?>" name="RoomName{{$r}}"/>
                                   <input type="hidden" value="<?php echo $Option->Rooms->Room[$r]->NumAdults;?>" name="NumAdults{{$r}}"/>
                                   <input type="hidden" value="<?php echo $Option->Rooms->Room[$r]->NumChildren;?>" name="NumChildren{{$r}}"/>
                                   <input type="hidden" value="<?php echo Crypt::encrypt(base64_encode($Option->Rooms->Room[$r]->RoomPrice));?>" name="RoomPrice{{$r}}"/>
                                   
                                   
                    
                    <?php 
						                 }
						?>
						
						<?php }
					
					}
					$deadlinedate_array = '';
					
					$canceldeail_array = array(); 
					$deadline = 1;
					
					/*echo '<pre>';
					print_r($policiesdetails);
					echo '</pre>';*/
					if(isset($policiesdetails->Policies->Policy)){
						foreach($policiesdetails->Policies->Policy as $Policy){
							
							$deadlinedate_array = $Policy->From;
						}
					}
					
					
					?>
                    <input type="hidden" value="<?php echo Crypt::encrypt(base64_encode($deadlinedate_array)); ?>" name="canceldeadline"/>
                   
                    
                    <input type="hidden" value="<?php echo $hotel_Info->Body->Hotels->Hotel->HotelName; ?>" name="Hotelname"/>
                    
                    <input type="hidden" value="<?php echo $hotel_Info->Body->Hotels->Hotel->Address; ?>" name="Hoteladdress"/>
                    
                    <input type="hidden" value="<?php echo $hotel_Info->Body->Hotels->Hotel->StarRating; ?>" name="Hotelstar"/>
                    
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
	
    
    
 <?php 
 
 $check_arry = array();
 $i=1;
 foreach($hotel_details->Body->Hotels->Hotel->Options->Option as $Option){
						
						if($_GET['optionID'] == $Option->OptionId ){ $check_arry[$i] = 0; }else{
						$check_arry[$i] = 1;;
						}
						++$i;
						} 
						if(min($check_arry) != 0){ ?>
							
<div class="modal modalviewmore fade show modelshow" id="m_modal_6 popup" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" style="display:block; padding-right: 17px;">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
    <!--  <div class="modal-header">
     <h5 class="modal-title" id="exampleModalLongTitle">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>-->
       <div class="modal-body">
       <h5> Details </h5>
       <p>Your details has been expired</p>
  
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true" class="closeurl">×</span>
        </button>
  
      </div>
      
 

 

                                
      
    
     <div class="modal-footer">
        <!--<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>-->
        <a href="home"><button type="button" class="btn btn-primary closeurl">Ok</button></a>
      </div>
    </div>
  </div>
</div>
               
							
							<?php }
						
						?>
    
    
    
    <!-- Button trigger modal -->

<!-- Modal -->
<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h2 class="modal-title" id="exampleModalLongTitle">Cancellation Policies</h2>
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
       
        
        
        
        <div><h5 class="cancellationheading">Cancellation Deadline:<?php echo $policiesdetails->CancellationDeadline; ?></h5>
       
       
        
        <div class="alert-message_alter"><h5>Chargable cancellation Date</h5>
        <?php 
		
		//Percentage

		$bo = 1;
		if(isset($policiesdetails->Policies->Policy)){
		foreach($policiesdetails->Policies->Policy as $Policy){
			
			if($Policy->Type == 'Percentage'){
				
				
				?>
                <div class=""><span></span> If you will cancel the booking before  <b><?php echo $Policy->From;  ?></b> then you should  pay  <b<<?php echo $Policy->Value;  ?>% </b> penalty for this booking.</div>
                
                <?php 
				
				
			}
			
			if($Policy->Type == 'Amount'){
				
				?>
                <div class=""><span></span> If you will cancel the booking before  <b><?php echo $Policy->From;  ?></b> then you should  pay $ <b><?php echo $Policy->Value;  ?></b> penalty for this booking.</div>
                
                <?php 
				
			}
			
			
			if($Policy->Type == 'Nights'){
				
				
				?>
                <div class=""><span></span> If you will cancel the booking before  <b><?php echo $Policy->From;  ?></b> then you should  pay <b><?php echo $Policy->Value;  ?></b> night price penalty for this booking.</div>
                
                <?php 
				
				
			}
	
			++$bo;
			
		} }
		
		?>
        </div>
        <?php if(!empty($policiesdetails->Alerts->Alert)){?>
        <div class="alert-message alert-message_alter cancellblock">
        <h5>Cancel Message</h5>
        
        <?php 
		$go = 1;
		foreach($policiesdetails->Alerts->Alert as $Alerts){
			?>
			
            <p><?php echo $Alerts;  ?></p>
            
		<?	
		++$go;
        }
		
		
		?>
        
        
        
        </div>
<?php } ?>
        
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
var paymentinserturl = "{{ URL::to('ajaxhotelpayment')}}";
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
	
	
	
	


/*if($('.input-phone').val() == ''){
	$('.phone_vali').show();
	$('.input-phone').focus();
	error=1;
}else{
	$('.phone_vali').hide();
}*/
	//email
/*	var sEmail = $('.input-email').val();
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

	/*if($('.input-lastname').val() == ''){
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
	}*/
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


  

	/*function firstfunction() {
		document.getElementById('inptutroomfirstname1').value = document.getElementById('inputfirstname').value;
	}




	function lastfunction() {
		document.getElementById('inptutroomlastname1').value = document.getElementById('inputlastname').value;
	}*/

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


<?php /*?><script language="javascript">
document.onmousedown=disableclick;
status="Right Click Disabled";
function disableclick(event)
{
  if(event.button==2)
   {
     alert(status);
     return false;    
   }
}
document.onkeydown = function(e) {
  if(event.keyCode == 123) {
     return false;
  }
  if(e.ctrlKey && e.shiftKey && e.keyCode == 'I'.charCodeAt(0)) {
     return false;
  }
  if(e.ctrlKey && e.shiftKey && e.keyCode == 'C'.charCodeAt(0)) {
     return false;
  }
  if(e.ctrlKey && e.shiftKey && e.keyCode == 'J'.charCodeAt(0)) {
     return false;
  }
  if(e.ctrlKey && e.keyCode == 'U'.charCodeAt(0)) {
     return false;
  }
}


</script><?php */?>


	
@endsection
