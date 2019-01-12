@extends('layouts.app')
@section('content')
<?php 


?>

	
	<!-- BEGIN: Subheader -->
	
	<div class="">
		<!-- END: Subheader -->
		<div class="m-content">
						<!--Begin::Section-->
<!--<div class="row">
				<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
					<div class="dashboard-stat2 ">
						<div class="display clearfix">
								<div class="number">
									<h3 class="font-green-sharp">
										<span class="counterup travelandabookings" data-counter="counterup" data-value="8384">0</span>
										<small class="font-green-sharp font-green-shalt travelandabookingstext">Bookings</small>
									</h3>
									<small>Travellanda</small>
								</div>
								<div class="icon das-month-select">
								<select class="form-control bookingstaustravelanad">
														  <option value="30">-Month-</option> 
															<option value="7">Week</option>
															<option value="1">Day</option>
									</select>
								</div>
						</div>
					</div>
				</div>
				<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
					<div class="dashboard-stat2 ">
						<div class="display clearfix">
								<div class="number">
									<h3 class="font-green-sharp">
										<span class="counterup tbobookings" data-counter="counterup" data-value="">0</span>
										<small class="font-green-sharp font-green-shalt tbobookingstext">Bookings</small>
									</h3>
									<small>TBO Holidays</small>
								</div>
								<div class="icon das-month-select">
								<select class="form-control bookingstaustbo">
														   <option value="30">-Month-</option> 
															<option value="7">Week</option>
															<option value="1">Day</option>
															</select>
								</div>
								</div>
						</div>
					</div>
		        </div>-->



                                                <div class="tabfn m-portlet m-portlet-padding">
						<div class="row">
							<ul class="nav nav-tabs  m-tabs-line m-tabs-line--primary somehti" role="tablist">
											<li class="nav-item m-tabs__item">
												<a class="nav-link m-tabs__link managerdetails active show" data-url="http://dev.livebeds.com/agency&amp;tab=1" data-toggle="tab" href="#m_tabs_6_1" role="tab" aria-selected="true">
                                                    Travelanda
												</a>
											</li>
									
											<li class="nav-item m-tabs__item">
												<a class="nav-link m-tabs__link agencyinfo" data-url="http://dev.livebeds.com/agency&amp;tab=2" data-toggle="tab" href="#m_tabs_6_3" role="tab" aria-selected="false">
													TBO Holidays
												</a>
											</li>
                                            
										</ul>
						</div>
                        <div class="tab-content">
										<div class="tab-pane managerdetailstab active show" id="m_tabs_6_1" role="tabpanel">
								<!--<form action="{{ route('apiprofiledataupdate') }}" class="m-form infoagen" method="post" id="signformsubmit" style="">
                                    
                                  <input type="hidden" name="_token" value="<?php echo @csrf_token(); ?>">
                                  
							<div class=" agency-info-tab active">
                            
                            
                             <div class="form-group m-form__group row">
						                      <label class="col-lg-2 col-form-label">Credit Limit<span class="requiredcls" aria-required="true"> </span></label>
						                      <div class="col-lg-5">
							                  <input type="text" name="creditlimit" class="form-control m-input verfycontent" placeholder="" value="<?php if(isset($adminportal->creditLimit) && !empty($adminportal->creditLimit)) { echo $adminportal->creditLimit; } ?>" id="name" >
                                              
                                              <span class="error-message fullname-check" style="display:none">
													The field is required.
												 </span>
                                      
						                        </div>
					           </div>
                               
                               
                               
                               <div class="form-group m-form__group row">
						                      <label class="col-lg-2 col-form-label">Bought API Person Name<span class="requiredcls" aria-required="true"></span></label>
						                      <div class="col-lg-5">
							                  <input type="text" name="Testpassword" class="form-control m-input verfycontent" placeholder="" value="<?php if(isset($adminportal->name) && !empty($adminportal->name)) { echo $adminportal->name; } ?>" id="name" >
                                              
                                              <span class="error-message fullname-check" style="display:none">
													The field is required.
												 </span>
              
						                        </div>
					           </div>
                              
                               
                               
                             <div class="form-group m-form__group row">
						                      <label class="col-lg-2 col-form-label">Bought API Person Email<span class="requiredcls" aria-required="true">  </span></label>
						                      <div class="col-lg-5">
							                  <input type="text" name="email" class="form-control m-input verfycontent" placeholder="" value="<?php if(isset($adminportal->email) && !empty($adminportal->email)) { echo $adminportal->email; } ?>" id="name" >
                                              
                                              <span class="error-message fullname-check" style="display:none">
													The field is required.
												 </span>
                                     
						                        </div>
					           </div>
                               
                               
                                                                                                                                              
												   <div class="m-portlet__foot m-portlet__foot--fit">
												 <div class="m-form__actions m-form__actions">
												    <div class="row">
													    <div class="col-lg-2">
														</div>
														<div class="col-lg-5">
                                                <input type="hidden" name="supplier" value="travellanda">
                                                        
                                                  <button type="submit" name="create_sublier" class="btn btn-primary create-agency">Submit</button>
                                                                                                                        
														</div>
													</div>
													</div>
												
											</div>
											</div>
                                            </form>-->
                                            
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
												<option value="BOOK1">
													Day
												</option>
												<option value="BOOK7">
													Week
												</option>
                                                
                                                <option value="BOOK30">
													Month
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
				<table class="m-datatable snoagentbooking" id="html_table" width="100%">
					<thead>
						<tr>
							<th title="S no" class="">
								S No
							</th>
                            <th title="Booking Ref #">
								Time Date
							</th>
                            
							<th title="Booking Id">
							 Booking Id
							</th>
							
							<th title="Email">
								Hotel Name 
							</th>
							
                            <th title="Check In">
                                Check In
								
							</th>
                            <th title="Check Out">
                                Check Out
								
							</th>
                             <th title="Agency Name">
								Nights
							</th>
                            
                            <th title="Booking Log">
								Booking Log
							</th>
                            <th title="Price">
								Price
							</th>
                        
						</tr>
					</thead>
					<tbody>
                     <?php $sno = 1;?>
					@foreach($travelanda as $vouched_booking_detail)
                    
                    <?php 
					//day count get
					
					$date1=date_create($vouched_booking_detail->checkin);
                    $date2=date_create($vouched_booking_detail->checkout);
                    $diff=date_diff($date1,$date2);
                    $daycount = $diff->days;
					
					//day count from date to current date
					
					$Today = date('Y-m-d');
					$Fromday = date('Y-m-d', strtotime($vouched_booking_detail->Bookdate));
					$date_Fromday=date_create($Fromday);
                    $date_Today=date_create($Today);
                    $diff1=date_diff($date_Fromday,$date_Today);
                    $daycount1 = $diff1->days;
					//days
					$booklog = '';
					if($daycount1<=1){
						
						$booklog = 1;
						
					}else if($daycount1<=7){
						
						$booklog = 7;
						
					}else{
					    $booklog = 30;
					}
					
					
					
					
					 ?>
                      <tr>
                            <td>{{$sno}}</td>
                            <td><?php echo  date("d M Y", strtotime($vouched_booking_detail->Bookdate));?> <?php echo date("h:sa", strtotime($vouched_booking_detail->bookingdate));?></td>
							<td>{{$vouched_booking_detail->BookingReference}}</td>
							
							<td>{{$TravelladaArray[$vouched_booking_detail->hotelid]}}</td>
							
                            <td>{{$vouched_booking_detail->checkin}}</td>
                            
                            <td>{{$vouched_booking_detail->checkout}}</td>
                            <td>{{$daycount}}</td>
                            <td>BOOK{{$booklog}}</td>
                            
                            <td>${{$vouched_booking_detail->totalprice}}</td>

						 </tr>  
                   
                        	 <?php ++$sno;?>  
						@endforeach	
								
							</tbody>
						</table>
						<!--end: Datatable -->
					</div>
				</div>      
				
				
			</div>

                                            
                                            <input type="hidden" id="verfytext" value="">
                                            </div>
                                            
                                            <!------- create agency---------->
								<div class="tab-pane agencyinformation" id="m_tabs_6_3" role="tabpanel" style="display: none;">
												<div class="">
                                 		<!--<form action="{{ route('apiprofiledataupdate') }}" class="m-form" method="POST" id="agency_info">
                                      <input type="hidden" name="_token" value="<?php echo @csrf_token(); ?>">
										                                              
                                       
                             <div class="form-group m-form__group row">
						                      <label class="col-lg-2 col-form-label">Credit Limit<span class="requiredcls" aria-required="true"> </span></label>
						                      <div class="col-lg-5">
							                  <input type="text" name="creditlimit" class="form-control m-input verfycontent" placeholder="" value="<?php if(isset($adminportal1->creditLimit) && !empty($adminportal1->creditLimit)) { echo $adminportal1->creditLimit; } ?>" id="name" >
                                              
                                              <span class="error-message fullname-check" style="display:none">
													The field is required.
												 </span>
                                       
						                        </div>
					           </div>
                               
                               
                               
                               <div class="form-group m-form__group row">
						                      <label class="col-lg-2 col-form-label">Bought API Person Name<span class="requiredcls" aria-required="true"></span></label>
						                      <div class="col-lg-5">
							                  <input type="text" name="Testpassword" class="form-control m-input verfycontent" placeholder="" value="<?php if(isset($adminportal1->name) && !empty($adminportal1->name)) { echo $adminportal1->name; } ?>" id="name" >
                                              
                                              <span class="error-message fullname-check" style="display:none">
													The field is required.
												 </span>
                                       
						                        </div>
					           </div>
                              
                               
                               
                             <div class="form-group m-form__group row">
						                      <label class="col-lg-2 col-form-label">Bought API Person Email<span class="requiredcls" aria-required="true">  </span></label>
						                      <div class="col-lg-5">
							                  <input type="text" name="email" class="form-control m-input verfycontent" placeholder="" value="<?php if(isset($adminportal1->email) && !empty($adminportal1->email)) { echo $adminportal1->email; } ?>" id="name" >
                                              
                                              <span class="error-message fullname-check" style="display:none">
													The field is required.
												 </span>
                                 
						                        </div>
					           </div>
												  
												 
												<div class="m-portlet__foot m-portlet__foot--fit">
												 <div class="m-form__actions m-form__actions">
												    <div class="row">
													   <div class="col-lg-2">
													   </div>
														<div class="col-lg-5">
                                                       
                                           <input type="hidden" name="supplier" value="tbo">
                                                        
                                                  <button type="submit" name="create_sublier" class="btn btn-primary create-agency">Submit</button>
									
														</div>
													</div>
													</div>
											</div>
                                            </form>-->
											</div>
							</div>
						<!--End::Section-->

						
						<!--End::Section-->
					</div>
                    </div>
				</div>
		</div>	
	</div>
	
	
	
	<?php if(isset($_GET['datas'])) {?>
		<div class="modal fade show modelshow" id="m_modal_6" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" style="display: block; padding-right: 17px;">
			<div class="modal-dialog modal-dialog-centered" role="document">
				<div class="modal-content">
    <!--  <div class="modal-header">
     <h5 class="modal-title" id="exampleModalLongTitle">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
    </div>-->
    <div class="modal-body">
    	The data was added successfully.
    </div>
    <div class="modal-close-btn">
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
<?php } ?>  



<?php if(isset($_GET['id']) && !empty($_GET['id'])){?>           
	<input type="hidden" id="homeurl" value="<?php echo URL::to("/apiprofiledata?id=".$_GET['id']);?>"/>
<?php }else{ ?>
	<input type="hidden" id="homeurl" value="<?php echo URL::to("/apiprofiledata");?>"/>
<?php } ?>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script>

var apiprofiledataajax = "{{ URL::to('apiprofiledataajax')}}";
	$(document).ready(function(e) {
		
		apiprofiledataajax_Travelanada(30);
		apiprofiledataajax_tbo(30);
		
		$('.managerdetails').click(function (){
	$(".managerdetailstab").show();
		$(".agencyinformation").removeClass("active");
		
		$(".agencyinformation").removeClass("show");
		$(".agencyinformation").hide();

		$(".infoagen").show();

});



	$('.agencyinfo').click(function()
	{
		$(".agencyinformation").addClass("active");
		
		
		$(".agencyinformation").addClass("show");
		$(".agencyinformation").show();
		
		
		$(".infoagen").hide();

		
	});
		
		
		
		$(document).on('change', '.bookingstaustravelanad', function(){
			
			var days = $(this).val();
			
			apiprofiledataajax_Travelanada(days);
			
			
		});
		
		
		$(document).on('change', '.bookingstaustbo', function(){
			
			var days = $(this).val();
			
			apiprofiledataajax_tbo(days);
			
			
		});
		
		
		
		
		
		
		$(document).on('click', '.closeurl', function(){

			$('.modelshow').hide();

			var url = $('#homeurl').val();
			window.history.pushState('', '', url);

		});

		$('.changepassword').click(function(e) {
			if(this.checked){
				
				$('.checkpassword').show();

			}else{
				
				$('.checkpassword').hide();
			}
		});
	});
function apiprofiledataajax_tbo(attr){

var thehref = 'days='+attr+'&supplier=tbo';
 $.ajax({
         type:"GET",
         url:apiprofiledataajax,
         data:thehref,
         success: function(data){
			 
			 console.log(data);
			 
			 $('.tbobookings').text(data);
			 if(data == '0'){
	$('.tbobookingstext').text('BOOKING');
	
	}else{
	$('.tbobookingstext').text('BOOKINGS');
	}
	
			 },
         error: function(data){

                               }
                  });


}


function apiprofiledataajax_Travelanada(attr){




var thehref = 'days='+attr+'&supplier=travelanada';
 $.ajax({
         type:"GET",
         url:apiprofiledataajax,
         data:thehref,
         success: function(data){
	console.log(data);
	
	$('.travelandabookings').text(data);
	
	if(data == '0'){
	$('.travelandabookingstext').text('BOOKING');
	
	}else{
	$('.travelandabookingstext').text('BOOKINGS');
	}
	
			 },
         error: function(data){

                               }
                  });


}




	
	
</script>	




@endsection
