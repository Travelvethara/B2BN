@extends('layouts.app')

@section('content')
<?php 
/*echo "<pre>";
print_r($hotel_details);
echo "</pre>";*/

?>



<div class="m-grid__item m-grid__item--fluid m-wrapper">
	<!-- BEGIN: Subheader -->
	
	<!-- END: Subheader -->
	<div class="m-content">
		<!--Begin::Section-->
		<div class="payment-page confirmationpage clear">
         <div class="confirmationsuccssfull text-center">
         	
            <p>Your Reservation was pending</p>
         </div>
         <div class="reservation-details">
         <h5>Reservation Details</h5>
         <div class="reservaton-detail-contents clear">
         		<img src="<?php echo $hotel_details->Images->Image[0]; ?>">
             <div class="confirmation-lotte">
             	<h6>{{$hotel_details->HotelName}}</h6>
                <div class="starratings">
                      	<ul class="clear">
                        @for($s=1;$s<=round($hotel_details->StarRating);$s++)
                            <li><a href="#"></a><i class="fa fa-star" aria-hidden="true"></i></li>
                          
                            @endfor
                        </ul>
                     </div>
                     <i>{{$hotel_details->Address}}</i>
             </div>
             <div class="name-and-confirmation">
             	<p>Name:<b>{{$vouched_booking[0]->firstname }} {{$vouched_booking[0]->lastname}}</b></p>
                <p class="nobotommar">Confirmation No:<b>{{$vouched_booking[0]->id }}</b></p>
             </div>
         </div>
         </div>
         <div class="payment-room-details">
         <h5>Room Details</h5>
         <table class="table">
                     <thead>
                     <tr>	
                    <th>Room</th>
                    <th>Adults</th>
                    <th>Children</th>
                     </tr>
                     </thead>
                     <tbody>
                     <?php 
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
                     <?php }  ?>
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
         	     <h5>
                     Payment
                     </h5>
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
         
       
          <div class="payment-hotel-policy-list">
         	<h6>Late Check In:</h6>
            <p>If a customer is expected to arrive after 21:00 hours, please contact the hotel and inform them of Customer's arrival time. 
Some hotels have limited reception services after 21:00 hours. Failing to inform the hotel of a late arrival can result in the space being released..</p>
         </div>
        </div><!-- end of confirmationpage -->

    </div>
    
    
    
</div>
    
    
 

	
@endsection
