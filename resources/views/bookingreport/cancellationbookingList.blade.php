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
				<table class="m-datatable m-datatable_s_no" id="html_table" width="100%">
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
					@foreach($vouched_booking as $vouched_booking_detail)
                    
                    
                   <?php $guest = unserialize($vouched_booking_detail->guest); ?>
                    
                    
						<tr>
                        <td>{{$sno}}</td>
							<td>{{$guest[0]['firstname'][1]}}{{$guest[0]['lastname'][1]}}</td>
							
							<td>{{$vouched_booking_detail->email}}</td>
						    <td>{{$vouched_booking_detail->user_type}}</td>
                            <td><?php if($vouched_booking_detail->booking_confirm == 2) { ?>  cancel <?php
				   } else { ?>Pending <?php } ?></td>
                            
							
						<td>
 <button class="btn btn-link" data-id="<?php echo $vouched_booking_detail->id; ?>" id="popup">View </button>
 
				</td>
								</tr>  
                                <?php ++$sno;?>  
						@endforeach
                        		
								
							</tbody>
						</table>
						<!--end: Datatable -->
					</div>
				</div>      
				
				
			</div>

			
		</div>
        
        
        
  @foreach($vouched_booking as $vouched_booking_detail)      
<div class="modal modalviewmore fade show modelshow optioniddata<?php echo $vouched_booking_detail->id; ?>" id="m_modal_6 popup" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" style="display: none; padding-right: 17px;">
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
     
		
		<form id="rolelistform" action="{{route('cancellation.BookingCancellation')}}" method="POST" style="display:block;">
			<input type="hidden" name="_token" value="<?php echo @csrf_token(); ?>">
            <input type="hidden" name="CustomerBookId" value="<?php echo $vouched_booking_detail->id; ?>" />
			 <button type="submit" class="btn btn-primary closeurl">Cancelled</button>
		</form>
        
        
         <div class="modal-footer">
        <!--<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>-->
        <button type="button" class="btn btn-primary closeurl">Ok</button>
      </div>
    </div>
  </div>
</div>
		
@endforeach		
		<!-- end:: Body -->
		<!-- begin::Footer -->
		
		
		



@foreach($vouched_booking as $vouched_booking_detail)

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
      <div class="booking-details-email booking-details-email-booking">
   	<div class="row">
    	<div class="col-md-6">
        <b>Email:</b><p> <?php echo  $vouched_booking_detail->email;?></p>
        </div>
        <div class="col-md-6">
           <b>Mobile:</b> <p><?php echo  $vouched_booking_detail->phone;?></p>
        </div>
    </div>
    	<div class="row">
    	<div class="col-md-6">
        <b>Checkin:</b> <p> <?php echo date("d M Y", strtotime($vouched_booking_detail->checkin)) ;?></p>
        </div>
        <div class="col-md-6">
           <b>	Checkout:</b> <p> <?php echo date("d M Y", strtotime ($vouched_booking_detail->checkout)) ;?></p>
        </div>
    </div>
    	<div class="row">
    	<div class="col-md-6">
        <b>Booking Date:</b> <p><?php echo  date("d M Y", strtotime($vouched_booking_detail->Bookdate));?></p>
        </div>
        <div class="col-md-6">
           <b>	Price:</b> <p> $<?php echo  $vouched_booking_detail->totalprice;?></p>
        </div>
    </div>
    	<div class="row">
    	<div class="col-md-6">
        <b>Nights:</b><p><?php echo $daycount;?></p>
        </div>
    </div>
    
     <?php if($Premissions['type'] == 'SuperAdmin') { ?>
    <div class="row">
 
        
        <div class="col-md-6">
           <b>Booking API: </b> <p> <?php echo ucfirst($vouched_booking_detail->supplier); ?></p>
        </div>
        <div class="col-md-6">
           <b>Booking Id: </b> <p> <?php echo $vouched_booking_detail->BookingReference; ?></p>
        </div>
        
        <div class="col-md-6">
           <b>Agency Booking Id: </b> <p> TP<?php echo $vouched_booking_detail->hotelid.$vouched_booking_detail->id; ?></p>
        </div>
        
        
    </div>
    
    <?php } ?>
    
    <?php if($Premissions['type'] == 'AgencyManger') { ?>
    
     <div class="row">

        <div class="col-md-6">
           <b>Booking Id: </b> <p> TP<?php echo $vouched_booking_detail->hotelid.$vouched_booking_detail->id; ?></p>
        </div>
        
        
    </div>
    
    <?php } ?>
    
    
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
	
	   $original_array=unserialize($guest);
	   
	   
	   $room = $vouched_booking_detail->roomdeatils;
	 
	   $roomdetails=unserialize($room);

		 
	    $roomlistarray = array(); 
		 $aultname = '';
		 for($i=0; $i<count($original_array); $i++){
			 
			 $roomlistarray['RoomName'.$i] = $roomdetails[$i]['RoomName'];
			 
			 $adultCount=$original_array[$i]['adult'];
			
			for($a=1; $a<= $adultCount; $a++){
				if($a == 1){
				$roomlistarray['aultname'.$i] = ''.$original_array[$i]['title'][$a].$original_array[$i]['firstname'][$a].$original_array[$i]['lastname'][$a].' ';
				}else{
				
				$roomlistarray['aultname'.$i] .= ', '.$original_array[$i]['title'][$a].$original_array[$i]['firstname'][$a].$original_array[$i]['lastname'][$a].'';
				
				}
			}
			
			$roomlistarray['childname'.$i] = 'No Children';
			if($original_array[$i]['child'] != 0){
			
				
			for($c=1; $c<= $original_array[$i]['child']; $c++){
				if($c == 1){
				$roomlistarray['childname'.$i] = ''.$original_array[$i]['childFirstName'][$c].$original_array[$i]['childLastName'][$c].'('.$original_array[$i]['childage'][$c].') ';
				}else{
				
				$roomlistarray['childname'.$i] .= ', '.$original_array[$i]['childFirstName'][$c].$original_array[$i]['childLastName'][$c].'('.$original_array[$i]['childage'][$c].')';
				
				}
			 }
			
			}
			 
		 }
	
		 
		 
		  for($i=0; $i<count($original_array); $i++){
		 
		 $adultCount=$original_array[$i]['adult'];
		  
		 
		
		 ?>
												                                                                                                                     
                                 

                               <tr>
                               	<td><?php echo $i+1;?></td>
                                <td><?php echo $roomlistarray['aultname'.$i]; ?></td>
                                <td><?php echo $roomlistarray['childname'.$i]; ?> </td>
                                <td><?php echo $roomlistarray['RoomName'.$i]; ?> </td>
                               </tr>
                                   <?php }  ?>
                                 
                                                                  
											</tbody>
										</table>
                 
                 
               
                    
      
                                     
                                         
    </div>
    <div class="modal-footer">
    
     <!--<button type="button" id="exportButton" class="btn btn-lg btn-danger mailsendButton" data-bookingid="<?php echo $vouched_booking_detail->id; ?>" >Send mail</button>
     <button type="button" id="exportButton" class="btn btn-lg btn-primary exportButton" data-bookingid="<?php echo $vouched_booking_detail->id; ?>" > Download Invoice</button>
-->        <!--<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>-->
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

@endsection

<style>
    #exportButton {
        border-radius: 0;
    }
</style>







<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script>


   var paymentinserturl = "{{ URL::to('invoicepayment')}}";

   var Bookmailsenturl = "{{ URL::to('invoicepaymentemail')}}";
   
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
			
			
			
			
			//$(document).on('click', '#popupcancel', function(){
//						if(confirm('Are you sure want to Cancelled Booking?')) {
//							console.log('Delete');
//							
//							
//							} else {
//								return false;
//								}
//						});	

		$(document).on('click', '.DeleteRole', function(){
			
			var id = $(this).data('id');
			
			var r = confirm("Are you sure you want to Delete now?");
       //cancel clicked : stop button default action 
       if (r === false) {
       	return false;
       }
       
       else if(r === true){
       	
       	var storehidden = '<input type="hidden" value="'+id+'" name="id"/>';
       	$('.deleteagency').append(storehidden);
       	
       	$('#rolelistform').submit();
       	
       	
       }
        //action continues, saves in database, no need for more code


    });
		

		
		



		function checkParentCheckboxValue() {
			var parentagency ='';
			
			if($("#parentagency").is(':checked')){
				parentagency = 1;
			} else {
				parentagency = 0;
			}
			return parentagency;	
		}
		
		function checkSubCheckboxValue() {
			var subagency ='';
			if($("#subagency").is(':checked')){
				subagency = 1;
			} else {
				subagency = 0;
			}	
			return subagency;	
		}
		
		function append_data(d) {
			var one = '';
			
			var last_id =	parseInt($("#autoincrementid").val());
			last_id--;	
			var greaterthenzero = '';
			greaterthenzero = 1;
			$.map( d, function( a ) {
				var parent = '';
				var status = '';
				ida = a.parentagencyid;
				if(!ida){
					var namee = 'Parent';
				}
				else{
					var namee = 'Sub';
				}
				
				status =a.activestatus;
				if(status>0){
					var  statu = 'Active';
				}
				else{
					var statu = 'Locked';
					
				}
				last_id++;	
				greaterthenzero++; 
				var usertype = '<?php echo $Premissions['type']; ?>';

				var editicon = '';
				var eyeicon = '';
				var deleteicon = '';
				
				eyeicon =  '<a href="<?php echo route('agency.viewagency') ?>?id='+a.id+'" target="_blank"><i class="fas fa-eye" data-id="1"></i></a>';

				
				if(usertype == 'SuperAdmin') {	
					editicon = '<a href="<?php echo route('agency'); ?>?id='+a.id+'" target="_blank"><i class="fas fa-edit"></i></a>';	
					deleteicon = '<i class="far fa-trash-alt DeleteRole Deleteagency" data-id='+a.id+'></i>';
				}
				if(usertype == 'UserInfo') {	
					var editpermission = '<?php if(isset($Premissions['premission'][0]->agency_edit)) { echo $Premissions['premission'][0]->agency_edit; } ?>'; 
					var deletepermission = '<?php if(isset($Premissions['premission'][0]->agency_remove)) { echo $Premissions['premission'][0]->agency_remove; } ?>';
					if(editpermission == 1) { editicon = '<a href="<?php echo route('agency'); ?>?id='+a.id+'" target="_blank"><i class="fas fa-edit"></i></a>';	}
					if(deletepermission == 1) { deleteicon = '<i class="far fa-trash-alt DeleteRole Deleteagency" data-id='+a.id+'></i>'; }
				}
				
				one += '<tr><td>'+last_id+'</td><td>'+a.name+'</td><td>'+namee+'</td><td>'+a.email+'</td><td>'+a.city+'</td><td>'+a.country+'</td><td>'+statu+'</td><td>'+eyeicon+editicon+deleteicon+'</td></tr>';
			});
			
			if(parseInt(greaterthenzero) < 10) {
				$(".loadmorebutton").hide();
			} else {
				$(".loadmorebutton").show(); 
			}
			$("#autoincrementid").val(last_id);
			return one;
		}
		
		function AjaxCall(offset, parentagency, subagency){

			$.ajax
			({
				type: "GET",
				url: "agencylistLoadMoreAjax",
				data: {'offset': offset, 'parentagency': parentagency, 'subagency':subagency },
				success: function(data)
				{
					data= JSON.parse(data);
					var result = append_data(data);
					$("#moreresults").append(result);
				}
			});
		}
		
		$(document).on('click', '#parentagency', function(){
			$("#autoincrementid").val('1');
			var offset = 0;
			$('#offset').val('10'); 
			parentagency = checkParentCheckboxValue();
			subagency = checkSubCheckboxValue();
			$("#tablebody").html('');
			AjaxCall(offset, parentagency, subagency);
		});


		$(document).on('click', '#subagency', function(){
			$("#autoincrementid").val('1');
			var offset = 0;
			$('#offset').val('10'); 
			parentagency = checkParentCheckboxValue();
			subagency = checkSubCheckboxValue();
			$("#tablebody").html('')
			AjaxCall(offset, parentagency, subagency);
		});


		$(document).on('click', '#loadMore', function(){
			
			var offset = '';
			offset = $("#offset").val();
			
			var newoffset = '';
			newoffset = parseInt(offset) + parseInt(10);

			$('#offset').val(newoffset); 

			var parentagency = subagency = '';

			parentagency = checkParentCheckboxValue();
			subagency = checkSubCheckboxValue();
			AjaxCall(offset, parentagency, subagency);
			
		});
		
	});

$(document).on('click', '.fa-eye', function(){

});
</script>

<script>

			$(function() {
				$("#btnExport").click(function(){
				$(".m-datatable").table2excel({
					exclude: ".noExl",
    				name: "Excel Document Name"
				}); 
				 });
			});
		</script>