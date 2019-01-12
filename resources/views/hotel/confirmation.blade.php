@extends('layouts.app')

@section('content')
<?php 

$guest = $vouched_booking[0]->guest;
$guest_un = unserialize($vouched_booking[0]->guest);
/*	echo '<pre>';
//print_r($tbobboking_details);
print_r($guest_un[1]['firstname'][1]);
print_r($vouched_booking[0]);
echo "</pre>";
exit;*/
?>



<div class="m-grid__item m-grid__item--fluid m-wrapper">
	<!-- BEGIN: Subheader -->
	
	<!-- END: Subheader -->
	<div class="m-content">
		<!--Begin::Section-->
		<div class="payment-page confirmationpage clear roboto">
         <div class="confirmationsuccssfull text-center">
         	<i class="fa fa-check-circle" aria-hidden="true"></i>
            <p>Your Reservation was successfull</p>
         </div>
         <div class="reservation-details">
         <h2>Reservation Details</h2>
         <div class="reservaton-detail-contents clear">
         		<img src="<?php if($vouched_booking[0]->supplier == 'tbo') { echo $tboHolidaysHotelDetails['sBody']['HotelDetailsResponse']['HotelDetails']['ImageUrls']['ImageUrl'][0]; }else{ echo $hotel_details->Images->Image[0]; } ?>">
             <div class="confirmation-lotte">
             	<div class="ho-name"> <?php if($vouched_booking[0]->supplier == 'tbo') { echo $tboHolidaysHotelDetails['sBody']['HotelDetailsResponse']['HotelDetails']['attributes']['HotelName']; } else{ echo $hotel_details->HotelName; } ?></div>
                <?php if($vouched_booking[0]->supplier == 'tbo') {  
					                if($tboHolidaysHotelDetails['sBody']['HotelDetailsResponse']['HotelDetails']['attributes']['HotelRating'] == 'FourStar'){  $starrating = 4;  }
									if($tboHolidaysHotelDetails['sBody']['HotelDetailsResponse']['HotelDetails']['attributes']['HotelRating'] == 'FiveStar'){  $starrating = 5;  }
									if($tboHolidaysHotelDetails['sBody']['HotelDetailsResponse']['HotelDetails']['attributes']['HotelRating'] == 'ThreeStar'){  $starrating = 3;  }
									if($tboHolidaysHotelDetails['sBody']['HotelDetailsResponse']['HotelDetails']['attributes']['HotelRating'] == 'TwoStar'){  $starrating = 2;  } 
									if($tboHolidaysHotelDetails['sBody']['HotelDetailsResponse']['HotelDetails']['attributes']['HotelRating'] == 'OneStar'){  $starrating = 1;  } 
				
				
				} else{ $starrating = $hotel_details->StarRating; } ?>
                <div class="hotel-list-star hotel-details-u hotel-details-u-confirmation">
                      	<ul class="clear">
                        @for($s=1;$s<=round($starrating);$s++)
                            <li><img src="{{asset('img/star.png')}}" /></li>
                            @endfor
                        </ul>
                     </div>
                     <div class="hotel-o-address"> <?php if($vouched_booking[0]->supplier == 'tbo') { echo $tboHolidaysHotelDetails['sBody']['HotelDetailsResponse']['HotelDetails']['Address']; }else{ echo $hotel_details->Address; } ?></div>
             </div>
             <div class="name-and-confirmation">
             <?php if($vouched_booking[0]->supplier == 'tbo') {  ?>
			 
			 <p>Name:<b>{{$guest_un[0]['firstname'][1] }} {{$guest_un[0]['lastname'][1]}}</b></p>
             
			 <?php }else{ ?>
                <p>Name:<b>{{$guest_un[0]['firstname'][1] }} {{$guest_un[0]['lastname'][1]}}</b></p>
               <?php } ?> 
				<?php if($vouched_booking[0]->user_type == 'SuperAdmin') {?>
                <p class="nobotommar">Confirmation No:<b>{{$vouched_booking[0]->BookingReference }}</b></p>
                <p class="nobotommar">Agent Confirmation No:<b>TP{{$vouched_booking[0]->hotelid}}{{$vouched_booking[0]->id}}</b></p>
                <?php }else{  ?>
                <p class="nobotommar">Confirmation No:<b>TP{{$vouched_booking[0]->hotelid}}{{$vouched_booking[0]->id}}</b></p>
                
                <?php } ?>
             </div>
         </div>
         </div>
         <div class="payment-room-details">
         <h2>Room Details</h2>
         <table class="table table-striped">
                     <thead>
                     <tr>	
                    <th>Room No</th>
                  
                   
                    <?php if($vouched_booking[0]->supplier == 'tbo') {?>
                     <th>Room Name</th>
                     <?php } ?>
                    <th>Adults</th>
                    <th>Children</th>
                     </tr>
                     </thead>
                     <tbody>
                     <?php 
					 
					 if($vouched_booking[0]->supplier == 'tbo') { 
					 $i=1;
					 if(isset($tbobboking_details['sBody']['HotelBookingDetailResponse']['BookingDetail']['Roomtype']['RoomDetails'][0])){
						 foreach($tbobboking_details['sBody']['HotelBookingDetailResponse']['BookingDetail']['Roomtype']['RoomDetails'] as $roomvalues){
							 
						?>
                        <tr>
                     <td><?php echo $i;?></td>
                     <td><?php echo $roomvalues['RoomName'];?></td>
                     <td><?php echo $roomvalues['AdultCount']; ?></td>
                     <td><?php echo $roomvalues['ChildCount']; ?></td>
                     </tr>
                        
						 
						 <?php 
						 ++$i;}
					 }else{ ?>
						 
					  <td><?php echo $i;?></td>
                      <td><?php echo $tbobboking_details['sBody']['HotelBookingDetailResponse']['BookingDetail']['Roomtype']['RoomDetails']['RoomName']; ?></td>
                     <td><?php echo $tbobboking_details['sBody']['HotelBookingDetailResponse']['BookingDetail']['Roomtype']['RoomDetails']['AdultCount']; ?></td>
                     <td><?php echo $tbobboking_details['sBody']['HotelBookingDetailResponse']['BookingDetail']['Roomtype']['RoomDetails']['ChildCount']; ?></td>
						 
						 <?php 
					 }
					 
					 
					 
					 }else{
						 
					 
					 $guest = $vouched_booking[0]->guest;
	
	                 $original_array=unserialize($guest);
					 
					 
					 
	                   
					 for($i=0; $i<count($original_array); $i++){
		 
		             $adultCount=$original_array[$i]['adult'];
		            
					 $aultname = '';
		            
					 ?>
                     <tr>
                     <td><?php echo $i+1;?></td>
                     <td><?php echo $original_array[$i]['adult']; ?></td>
                     <td><?php echo $original_array[$i]['child']; ?></td>
                     </tr>
                     <?php } } ?>
                     </tbody>
                     </table>
                     <div class="confirmation-checkin-checkout">
                     	<div class="confirmation-checkin">
                        	<h6>Check In</h6>
                            <p>{{date("d M Y", strtotime($vouched_booking[0]->checkin))}}</p>
                        </div>
                        <div class="confirmation-checkout">
                        	<h6>Check Out</h6>
                            <p>{{date("d M Y", strtotime($vouched_booking[0]->checkout))}}</p>
                        </div>
                       <div class="clear">
                       </div>
                        <!--<div class="confirmation-nightyrates">
                         <h6>Nighty Rates</h6>
                        	<table class="table">
                            <tbody>
                            	<tr>
                                	<td>wed, 19, Dec</td>
                                    <td>$83.15</td>
                                </tr>
                            </tbody>
                            </table>
                        </div>-->
                     </div>
         </div><!-- end-of room-details-->
         <div class="confirmation-payment-details">
         	    
                     <div class="payment-blocks clear">
                     	<div class="payment-blocks-left">
                        	Total Price
                        </div>
                        <?php 
						      if(isset($vouched_booking[0]->markupprice)){
						      $new_width = ($vouched_booking[0]->markupprice / 100) * $vouched_booking[0]->totalprice;
							  $Total_price = $vouched_booking[0]->totalprice + $new_width;
							  }else{
							  $Total_price = $vouched_booking[0]->totalprice;  
							  } ?>
                         	<div class="payment-blocks-right">
                            $<?php echo $Total_price; ?>
                        </div>
                     </div>
         </div>
         <div class="payment-hotel-policy">
         	<h2>Hotel policy</h2>
         </div>
         		 
         <div class="payment-hotel-policy-list">
         	<h6>Cancellation Policy:</h6>
            <div class=""><span> </span> You may cancel your reservation for no charge before this deadline. 
		 Please note that we will assess full payment of reservation if you must cancel after this deadline.</div>
         
         
             <?php 
			 

           

            if($vouched_booking[0]->supplier == 'tbo') {
				$bo =1;
		            $attr = '@attributes';

                      foreach($tbobboking_details['sBody']['HotelBookingDetailResponse']['BookingDetail']['HotelCancelPolicies']['CancelPolicy'] as $Policy){

                  	   if($Policy[$attr]['ChargeType'] == 'Fixed'){
				   
				   ?>
                   <div class=""><span> </span>  If you will cancel the booking  <b>{{$Policy[$attr]['FromDate']}} </b> to  <b>{{$Policy[$attr]['ToDate']}}</b> then you should pay {{$Policy[$attr]['Currency']}} {{$Policy[$attr]['CancellationCharge']}} penalty for this booking</div>
                   
				   <?php 
			   }
			   
			   if($Policy[$attr]['ChargeType'] == 'Percentage'){
				   
				   ?>
                   <div class=""><span></span>  If you will cancel the booking  <b>{{$Policy[$attr]['FromDate']}} </b> to  <b>{{$Policy[$attr]['ToDate']}}</b> then you should pay {{$Policy[$attr]['CancellationCharge']}} % penalty for this booking</div>
                   
				   <?php 
			   }
			    if($Policy[$attr]['ChargeType'] == 'Night'){
				   
				   ?>
                   <div class=""><span> </span>  If you will cancel the booking  <b>{{$Policy[$attr]['FromDate']}} </b> to  <b>{{$Policy[$attr]['ToDate']}}</b> then you should pay {{$Policy[$attr]['CancellationCharge']}} % penalty for this booking</div>
                   
				   <?php 
			   }				
				
					  ++$bo;}
				
			}else{


					 $policedetails = $vouched_booking[0]->canceldetails;
	                 
					 $police_array= unserialize($policedetails);
					 
					  
					
					 $bo = 1;
		foreach($police_array['Policy'] as $Policy){
			
			
			if($Policy['Type'] == 'Percentage'){
				
				
				?>
                 <p><span> </span> If you will cancel the booking after  <b><?php echo $Policy['From'];  ?></b> then you should  pay  <b<<?php echo $Policy['Value'];  ?>% </b> penalty for this booking.</p>
                
                <?php 
				
				
			}
			
			if($Policy['Type'] == 'Amount'){
				
				?>
                <p><span> </span> If you will cancel the booking after  <b><?php echo $Policy['From'];  ?></b> then you should  pay $ <b><?php echo $Policy['Value'];  ?></b> penalty for this booking.</p>
                
                <?php 
				
			}
			if($Policy['Type'] == 'Nights'){
				
				
				?>
                <p><span> </span> If you will cancel the booking after  <b><?php echo $Policy['From'];  ?></b> then you should  pay <b><?php echo $Policy['Value'];  ?></b> night price penalty for this booking.</p>
                
                <?php 
				
				
			}
			
			
	
			++$bo;
			
		}
			}
		
	                
		   ?>	
           
         </div>
          <div class="payment-hotel-policy-list">
         	<h6>Late Check In:</h6>
            <p>If a customer is expected to arrive after 21:00 hours, please contact the hotel and inform them of Customer's arrival time. 
Some hotels have limited reception services after 21:00 hours. Failing to inform the hotel of a late arrival can result in the space being released..</p>
         </div>
        </div><!-- end of confirmationpage -->

    </div>
    
    
    
</div>
    
    
 

	
@endsection
