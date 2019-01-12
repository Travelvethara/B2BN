@extends('./layouts.app')

@section('content')

<?php

$route = 'agencylist.agencydetails';

$data ='';

?>

<!-- END: Left Aside -->

	<!-- BEGIN: Subheader -->
	
	<!-- END: Subheader -->
	<div class="m-content agencies_list">
		
		<div class="m-portlet m-portlet--mobile">
			
			<div class="m-portlet__body">
				<!--begin: Search Form -->
				<div class="m-form m-form--label-align-right">
					<div class="row align-items-center">
						<div class="col-xl-8 order-2 order-xl-1">
							<div class="form-group m-form__group row align-items-center">
								<!--<div class="col-md-4">
									<div class="m-form__group m-form__group--inline">
										<div class="m-form__label">
											<label>
												Type:
											</label>
										</div>
										<div class="m-form__control">
											<select class="form-control m-bootstrap-select" id="m_form_agency_level">
												<option value="">
													All
												</option>
												<option value="1">
													Parent
												</option>
												<option value="2">
													Sub
												</option>

											</select>
										</div>
									</div>
									<div class="d-md-none m--margin-bottom-10"></div>
								</div>-->
								
								<div class="col-md-4">
									<div class="m-input-icon m-input-icon--left">
										<input type="text" class="form-control m-input" placeholder="Search..." id="generalSearch" value="">
										<span class="m-input-icon__icon m-input-icon__icon--left">
											<span>
												<i class="la la-search"></i>
											</span>
										</span>
									</div>
								</div>
                                <div class="col-md-4">
									<div class="m-input-icon m-input-icon--left">
										<!--<input type="text" class="form-control m-input" placeholder="Search..." id="generalSearch" value="">-->
                                        
                                        <button class="btn btn-success form-control m-input" id="btnExport">Export</button>
										<!--<span class="m-input-icon__icon m-input-icon__icon--left">
											<span>
												<i class="la la-search"></i>
											</span>
										</span>-->
									</div>
								</div>
							</div>
						</div>
						
					</div>
				</div>
				<!--end: Search Form -->
				<!--begin: Datatable -->
				<table class="m-datatable" id="html_table" width="100%">
					<thead>
						<tr>
							<th title="S no">
								S No
							</th>
							<th title="Name">
							    Name
							</th>
							
							<th title="Email">
								Email 
							</th>
							  <th title="Role">
								Role
							</th>
							
                            <th title="CancellationDeadline">
								CancellationDeadline
							</th>
                          
                            
							<th title="Current Status">
								Current Status
							</th>
                          
							<th title="Action">
								Action
							</th>
							
							
						</tr>
					</thead>
					<tbody>
                    <?php $sno = 1;?>
                    @if(!empty($agency_booking))
					@foreach($agency_booking as $agency_booking_detail)
						<tr>
                        <td>{{$sno}}</td>
							<td>{{$agency_booking_detail->firstname}}  {{$agency_booking_detail->lastname}}</td>
							
							<td>{{$agency_booking_detail->email}}</td>
							<td>{{$agency_booking_detail->user_type}}</td>
                             <?php 
					$dateMy = date('Y-m-d');
					if($agency_booking_detail->CancellationDeadline >= $dateMy) { ?> <td><span class="m-badge  m-badge--success m-badge--wide"> {{date("d M Y", strtotime ($agency_booking_detail->CancellationDeadline))}}</span></td> <?php
						} else { ?> <td><span class="m-badge  m-badge--metal m-badge--wide" style="background-color: #f4516c;"> {{date("d M Y", strtotime ($agency_booking_detail->CancellationDeadline))}}</span> </td><?php } ?>
							
                            <td><?php if($agency_booking_detail->booking_confirm == 1) { ?> Confirmed<?php
				   } else { ?>Pending <?php } ?></td>
							
						
                        
                        <td>

 <button class="btn btn-link" data-id="<?php echo $agency_booking_detail->id; ?>" id="popup">View </button>
 
 @if(Auth::user()->user_type != 'SubAgencyManger' && Auth::user()->user_type != 'UserInfo')
<?php 
$dateMy = date('Y-m-d');

if($agency_booking_detail->CancellationDeadline >= $dateMy ){ ?>	
 <button class="btn btn-link" data-id="<?php echo $agency_booking_detail->id; ?>" id="popupcancel">Cancellation</button>
 <?php } ?>	
 
 @endif				</td>
								</tr>  
                                <?php ++$sno;?>  
                                
						@endforeach
                        		@endif
								
							</tbody>
						</table>
						<!--end: Datatable -->
					</div>
				</div>      
				
				
			</div>

			
		</div>
        
        
        @if(!empty($agency_booking))
  @foreach($agency_booking as $agency_booking_detail)      
<div class="modal modalviewmore fade show modelshow optioniddata<?php echo $agency_booking_detail->id; ?>" id="" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" style="display: none; padding-right: 17px;">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
    <!--  <div class="modal-header">
     <h5 class="modal-title" id="exampleModalLongTitle">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>-->
         <div class="modal-body">
    	 Booking Details Cancelled.
  
  
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true" class="closeurl">×</span>
        </button>
    </div>
     
		<?php $agency_booking_details  =''; if(!empty($agency_booking_detail->canceldetails) && $agency_booking_detail->canceldetails != 'null') { $agency_booking_details = unserialize($agency_booking_detail->canceldetails); 
		 /*echo '<pre>';
		 print_r($agency_booking_details); 
		 echo '</pre>'; */
		 }?>
        <div><h5 class="cancellationheading">Free Cancellation Deadline:{{$agency_booking_detail->canceldeadline_confirm}}</h5>
        <?php 
		
		$date = date('Y-m-d');
		$totalprice = '';
		//echo $date;
		if($date <= '2018-07-23' ){
		
		$totalprice = $agency_booking_detail->totalprice;
		 
		} else if(!empty($agency_booking_details)) {
			
			foreach($agency_booking_details['Policy'] as $Policy){
				
				if($Policy['Type'] == 'Amount'){
					
					if($date <= $Policy['From'] ){
		
		              $totalprice = $agency_booking_detail->totalprice - $Policy['Value'];
		
		                 break;
		 
		              }
					
				}
				
				if($Policy['Type'] == 'Percentage'){
					
					if($date <= $Policy['From'] ){
		              
					   $Percentage_price = ($Policy['Value'] / 100) * $agency_booking_detail->totalprice;
					  
		               $totalprice = $agency_booking_detail->totalprice - $Percentage_price;
		
		                 break;
		 
		              }
					
				}
				
			}
			
		}
		
		echo $totalprice;
			
		
		if(!empty($agency_booking_details)) {
			$bo = 1;
		foreach($agency_booking_details['Policy'] as $Policy) {
			if($Policy['Type'] == 'Percentage'){
				
				
				?>
                <div class=""><span><?php echo $bo;?>. </span> If you will cancel the booking before <?php echo $Policy['From'];  ?> then you should  pay <?php echo $Policy['Value'];  ?>% penalty for this booking.</div>
                
                <?php 
				
				
			}
			
			if($Policy['Type'] == 'Amount'){
				
				?>
                <div class=""><span><?php echo $bo;?>. </span> If you will cancel the booking before <?php echo $Policy['From'];  ?> then you should  pay $ <?php echo $Policy['Value'];  ?> penalty for this booking.</div>
                
                <?php 
				
			}
			
			
			if($Policy['Type'] == 'Nights'){
				
				
				?>
                <div class=""><span><?php echo $bo;?>. </span> If you will cancel the booking before <?php echo $Policy['From'];  ?> then you should  pay <?php echo $Policy['Value'];  ?> night price penalty for this booking.</div>
                
                <?php 
				
				
			}
	
			++$bo;
			
		}
		++$bo;
		 } ?>
     </div>
                
        
     
		<form id="rolelistform" action="{{route('cancellation.BookingCancellation')}}" method="POST" style="display:block;">
			<input type="hidden" name="_token" value="<?php echo @csrf_token(); ?>">
            <input type="hidden" name="CustomerBookId" value="<?php echo $agency_booking_detail->id; ?>" />
			 <button type="submit" class="btn btn-primary closeurl">Cancelled</button>
		</form>
        
        
         <div class="modal-footer">
        <!--<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>-->
        <button type="button" class="btn btn-primary closeurl">Ok</button>
      </div>
    </div>
  </div>
</div>
 </div>
		
@endforeach	
@endif	
		<!-- end:: Body -->
		<!-- begin::Footer -->
		
		
		
@if(!empty($agency_booking))

@foreach($agency_booking as $vouched_booking_detail)

<?php 

     $date1=date_create($vouched_booking_detail->checkin);
     $date2=date_create($vouched_booking_detail->checkout);
     $diff=date_diff($date1,$date2);
    $daycount = $diff->days; ?>
<div class="modal modalviewmore fade show modelshow optionid<?php echo $vouched_booking_detail->id; ?>" id="m_modal_6 popup" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" style="display: none; padding-right: 17px;">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
    <!--  <div class="modal-header">
     <h5 class="modal-title" id="exampleModalLongTitle">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>-->
      <?php 
	/* if(!empty($vouched_booking_detail->Vouchertemplate)){
     echo '<pre>';
     print_r($vouched_booking_detail->Vouchertemplate);
     echo '</pre>';
       }*/
     ?>
    <form class="form" style="max-width: none; width: 1005px;">   
      
       <div class="modal-body">
       <h5> Booking Details </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true" class="closeurl">×</span>
        </button>
      </div>
      
      <div class="modalviewmorebody">  
      <div class="booking-details-email">
   	<div class="row">
    	<div class="col-md-6">
        <b>Email</b><p> <?php echo  $vouched_booking_detail->email;?></p>
        </div>
        <div class="col-md-6">
           <b>	mobile</b> <p><?php echo  $vouched_booking_detail->phone;?></p>
        </div>
    </div>
    	<div class="row">
    	<div class="col-md-6">
        <b>Checkin</b> <p> <?php echo date("d M Y", strtotime($vouched_booking_detail->checkin)) ;?></p>
        </div>
        <div class="col-md-6">
           <b>	Checkout</b> <p> <?php echo date("d M Y", strtotime ($vouched_booking_detail->checkout)) ;?></p>
        </div>
    </div>
    	<div class="row">
    	<div class="col-md-6">
        <b>Date</b> <p><?php echo  date("d M Y", strtotime($vouched_booking_detail->Bookdate));?></p>
        </div>
         <?php
					$Total_price = '';
							
			        if($vouched_booking_detail->markupprice){
					
					$markup_price = $vouched_booking_detail->totalprice % 100;
					$new_width = ($vouched_booking_detail->markupprice / 100) * $vouched_booking_detail->totalprice;
					$Total_price = $vouched_booking_detail->totalprice + $new_width;
					}else{
					$Total_price = $vouched_booking_detail->totalprice;
					}
								
								 ?>
        <div class="col-md-6">
           <b>	Price</b> <p> $<?php echo  $Total_price;?></p>
        </div>
    </div>
    	<div class="row">
    	<div class="col-md-6">
        <b>Nights</b><p><?php echo $daycount;?></p>
        </div>
    </div>
   </div>
   
   
	<?php /*?><table class="table m-table" id="exportTable">
											<thead>
												<tr>
								<th title="S no">
									CheckIn
								</th>
								<th title="Agency Name">
									CheckOut
								</th>
								
								<th title="Login Email ID ">
									Booking
								</th>
                                <th>
                                  Price
                                </th>
                                <th>
                               Nights</th>
                                </tr>
											</thead>
											<tbody>
												
								  
								 
                                 

                                <tr>
                                  <td><?php echo date("d M Y", strtotime($vouched_booking_detail->checkin)) ;?></td>
                                <td> <?php echo date("d M Y", strtotime ($vouched_booking_detail->checkout)) ;?></td>
                                <td> <?php echo  date("d M Y", strtotime($vouched_booking_detail->Bookdate));?></td>
                                <td> $<?php echo  $vouched_booking_detail->totalprice;?></td>
                                <td><?php echo $daycount;?></td>
                                </tr>
                               
                                 
											</tbody>
										</table><?php */?>
       <?php /*?>                                 
        <div class="below-payment-image-details-cont clear">
         <div class="below-payment-image-left">
							<b>Email </b>
						</div>
						<div class="below-payment-image-right">
							 <?php echo  $vouched_booking_detail->email;?>
						</div><br />
                         <div class="below-payment-image-left">
							<b>Mobile </b>
						</div>
						<div class="below-payment-image-right">
							<?php echo  $vouched_booking_detail->phone;?>
						</div>
        
        </div> 
        <?php */?>
        
        
         
         
       <table class="table m-table table-bordered tabletitwidth m-table--border-brand m-table--head-bg-success">
											<thead>
												<tr>
								<th title="">
									Room
								</th>
								
                                <th title="">
									Title
								</th>
                                <th title="">
									Adult Name
								</th>
                                <th title="">
									Child Name
								</th>
                                <th title="">
									Room Name
								</th>
											</thead>
											<tbody>
                                            
                                             <?php 
		 
	   $guest = $vouched_booking_detail->guest;
	// $original_array = unserialize($guest);
	   $original_array=unserialize($guest);
	   
	   
	   $room = $vouched_booking_detail->roomdeatils;
	 
	   $roomdetails=unserialize($room);
	/*echo "<pre>";
	 print_r($roomdetails);
	echo "</pre>";
	*/
	   $count = count($roomdetails);
		 
		 
		  for($i=0; $i<count($original_array); $i++){
		 
		 $adultCount=$original_array[$i]['adult'];
		   $aultname = '';
		 for($a=1; $a<= $adultCount; $a++){ $aultname .= '<p>'.$original_array[$i]['firstname'][$a].$original_array[$i]['lastname'][$a].'</p>';  
		 
		 $aultname;
		 ?>
												                                                                                                                     
                                 

                               <tr>
                               	<td><?php echo $i+1;?></td>
                                <td><?php echo $original_array[$i]['title'][$a]; ?></td>
                                <td><?php echo $original_array[$i]['firstname'][$a]; ?> <?php echo $original_array[$i]['lastname'][$a]; ?></td>
                                
                                
                                <?php if($original_array[$i]['child']){ ?>
                                <?php for($c=1; $c<=$original_array[$i]['child']; $c++){ ?>
                                <td><?php echo $original_array[$i]['childFirstName'][$c]; ?> <?php echo $original_array[$i]['childLastName'][$c]; ?></td>   <?php } ?>  <?php }else{ ?> <td>  No Children </td> <?php } ?>
                                
                              
                                 <td><?php echo $roomdetails[$i]['RoomName']; ?></td>
                               </tr>
                                   <?php }}  ?>
                                 
                                                                  
											</tbody>
										</table>
                 
                 
               
                    
      
                                     
                                         
    </div>
    <div class="modal-footer">
    
     <button type="button" id="exportButton" class="btn btn-lg btn-danger mailsendButton" data-bookingid="<?php echo $vouched_booking_detail->id; ?>" >Send mail</button>
     <button type="button" id="exportButton" class="btn btn-lg btn-primary exportButton" data-bookingid="<?php echo $vouched_booking_detail->id; ?>" > Download Invoice</button>
        <!--<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>-->
        <!--<button type="button" class="btn btn-primary closeurl">Ok</button>-->
      </div>
       </form> 
       
       
        <form action="" method="post" id="paymentsummit<?php echo $vouched_booking_detail->id; ?>">
            <input type="hidden" name="_token" value="<?php echo @csrf_token(); ?>">
            <input type="hidden" name="bookingid" value="<?php echo $vouched_booking_detail->id; ?>">
  </form> 
       
    </div>
  </div>
</div>

@endforeach


@endif


<div class="modal modalviewmore fade show modelshow mailmsgpopup" id="m_modal_6 popup" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" style="display: none; padding-right: 17px;">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
    <!--  <div class="modal-header">
     <h5 class="modal-title" id="exampleModalLongTitle">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>-->
         <div class="modal-body">
    	 Booking Details has been sented in your mail.
  
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true" class="closeurl">×</span>
        </button>
    </div>
     
		
	
        
        
         <div class="modal-footer">
        <!--<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>-->
        <button type="button" class="btn btn-primary closeurl">Ok</button>
      </div>
    </div>
  </div>
</div>
<?php if(isset($_GET['id']) && !empty($_GET['id'])){?>           
	<input type="hidden" id="homeurl" value="<?php echo URL::to("/agencyList?id=".$_GET['id']);?>"/>
<?php }else{ ?>
	<input type="hidden" id="homeurl" value="<?php echo URL::to("/agencyList");?>"/>
<?php } ?>


@endsection


<style>
    #exportButton {
        border-radius: 0;
    }
</style>







<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script>
var paymentinserturl = "{{ URL::to('invoicepayment')}}";

var Bookmailsenturl = "{{ URL::to('mailsentpayment')}}";

	$(document).ready(function () {
		
		
		
		$(document).on('click', '.exportButton', function(){
			
		var bookingid = $(this).data('bookingid');
        $.ajax({
        type:"POST",
        url:paymentinserturl,
        data:$('#paymentsummit'+bookingid).serialize(),
        success: function(data){
	
        var link = document.createElement('a');
        link.href = data.value;
        link.download=data.name+".pdf";
        link.click();
  },
        error: function(data){

        }
    });
		
		
		});
		
		
		
			$(document).on('click', '.mailsendButton', function(){
			
		var bookingid = $(this).data('bookingid');
        $.ajax({
        type:"POST",
        url:Bookmailsenturl,
        data:$('#paymentsummit'+bookingid).serialize(),
      success: function(data){
		   $('.mailmsgpopup').show();
      
  },
        error: function(data){

        }
       
    });
		
		
		});
		
		
		    $(document).on('click', '.closeurl', function(){

            $('.modelshow').hide();

           // var url = $('#homeurl').val();
           // window.history.pushState('', '', url);
           });
		   
           $(document).on('click', '#popup', function(){

           var id = $(this).data('id');
           $('.optionid'+id).show();
            });
			
			
		 $(document).on('click', '#popupcancel', function(){

           var id = $(this).data('id');
           $('.optioniddata'+id).show();
            });
		

		
	});

</script>



 <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
    <script src="table2excel.js" type="text/javascript"></script>
    <script type="text/javascript">
        $(function () {
            $("#btnExport").click(function () {
                $("#html_table").table2excel({
                    filename: "Table.xls"
                });
            });
        });
    </script>