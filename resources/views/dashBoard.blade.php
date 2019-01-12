@extends('layouts.app')

@section('content')

<?php 

/* echo '<pre>';
	 print_r($agency);
	 echo '</pre>';*/


?>


<link rel="stylesheet" href="//code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css">
<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="//code.jquery.com/ui/1.11.2/jquery-ui.js"></script>




                                
                                <div class="m-content">
                                	<div class="row">

                        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">

                            <div class="dashboard-stat2 ">

                                <div class="display clearfix">

                                    <div class="number">

                                        <h3 class="font-green-sharp">

                                            <span class="counterup" data-counter="counterup" data-value="8384">0</span>

                                            <small class="font-green-sharp">$</small>

                                        </h3>

                                        <small>TOTAL PROFIT</small>

                                    </div>

                                    <div class="icon">

                                        <i class="la la-money"></i>

                                    </div>

                                </div>

                               

                            </div>

                        </div>
                       <?php if(Auth::user()->user_type == 'AgencyManger' || Auth::user()->user_type == 'SuperAdmin' ) { ?>
                        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">

                            <div class="dashboard-stat2 ">

                                <div class="display clearfix">

                                    <div class="number">

                                        <h3 class="font-red-haze">

                                            <span class="totalagent" data-counter="counterup" data-value="20">0</span>

                                        </h3>

                                        <small>TOTAL AGENTS</small>

                                    </div>

                                    <div class="icon">

                                        <i class="la la-thumbs-o-up"></i>

                                    </div>

                                </div>

                                

                            </div>

                        </div>
                        
            

                        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">

                            <div class="dashboard-stat2 ">

                                <div class="display clearfix">

                                    <div class="number">

                                        <h3 class="font-blue-sharp">

                                            <span class="totalbooking" data-counter="counterup" data-value="13">0</span>

                                        </h3>

                                        <small>TOTAL BOOKINGS</small>

                                    </div>

                                    <div class="icon">

                                        <i class="la la-shopping-cart"></i>

                                    </div>

                                </div>

                                

                            </div>

                        </div>

                        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">

                            <div class="dashboard-stat2 ">

                                <div class="display clearfix">

                                    <div class="number">

                                        <h3 class="font-purple-soft">

                                            <span class="totaluser" data-counter="counterup" data-value="29">0</span>

                                        </h3>

                                        <small>TOTAL USERS</small>

                                    </div>

                                    <div class="icon">

                                        <i class="la la-user"></i>

                                    </div>

                                </div>


                            </div>

                        </div>
                        <?php } ?>

                    </div>
                    <?php if(Auth::user()->user_type == 'AgencyManger') { ?>
                    <div class="row">

                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">

                            <div class="dashboard-stat2 ">

                                <div class="display clearfix">

                                    <div class="number">

                                        <h3 class="font-green-sharp">

                                            <span class="agencycounterup" data-counter="counterup" data-value="8384">0</span>

                                            <small class="font-green-sharp">$</small>

                                        </h3>

                                        <small>AVAIABLE CREDIT LIMIT</small>

                                    </div>

                                    <div class="icon">

                                        <i class="la la-money"></i>

                                    </div>

                                </div>

                               

                            </div>

                        </div>
                        
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">

                            <div class="dashboard-stat2 ">

                                <div class="display clearfix">

                                    <div class="number">

                                        <h3 class="font-green-sharp">

                                            <span class="" data-counter="counterup" data-value="8384">0</span>

                                            <small class="font-green-sharp"></small>

                                        </h3>

                                        <small>Active Login</small>

                                    </div>

                                    <div class="icon">

                                        <i class="la fa-sign-in"></i>

                                    </div>

                                </div>

                               

                            </div>

                        </div>

                    </div>
                    
                    
                    
                    <?php } ?>
                    <div class="row">

                        <div class="col-lg-6 col-xs-12 col-sm-12">
                        <div class="m-portlet m-portlet--bordered-semi  ">
                        <div class="m-portlet__head">
										<div class="m-portlet__head-caption">
											<div class="m-portlet__head-title">
												<h3 class="m-portlet__head-text">
													BOOKINGS
												</h3>
											</div>
										</div>
										
										
										
									</div>

                             <div class="portlet light ">

                                <div class="m-portlet__body">
										<!--begin::Widget5-->
										<div class="m-widget4">
											<div class="m-widget4__chart m-portlet-fit--sides m--margin-top-10 m--margin-top-20" style="height:260px;">
												<canvas id="m_chart_trends_stats"></canvas>
											</div>
										</div>
										<!--end::Widget 5-->
									</div>

                                

                            </div>

                        </div>
                        </div>
                    <?php if(Auth::user()->user_type == 'AgencyManger' || Auth::user()->user_type == 'SuperAdmin' ) { ?>
                        <div class="col-lg-6 col-xs-12 col-sm-12">
                        <div class="m-portlet m-portlet--bordered-semi  ">
                                <div class="m-portlet__head">
										<div class="m-portlet__head-caption">
											<div class="m-portlet__head-title">
												<h3 class="m-portlet__head-text">
													 RECENTLY ADDED USER AND   
                                                     <?php if (Auth::user()->user_type == 'AgencyManger') {?>
                                                     SUB-AGENT
                                                     <?php } ?>
                                                     
                                                     
                                                      <?php if (Auth::user()->user_type == 'SuperAdmin') {?>
                                                         AGENCY
                                                     
                                                     <?php } ?>
												</h3>
											</div>
										</div>
										
										
										
									</div>

                            <div class="portlet light nopadtop">
                                <div class="m-content agencies_list nopaddingbox">
		
		<div class="m-portlet m-portlet--mobile nopaddingbox">
			
			<div class="m-portlet__body nopaddingbox">
				<!--begin: Search Form -->
				
				<!--end: Search Form -->
				<!--begin: Datatable -->
				<table class="m-datatable" id="html_table" width="100%">
					<thead>
						<tr>
							<th title="Field #1">
								Name
							</th>
                            
                            <th title="Field #1">
								Role
							</th>
                            
							<th title="Field #2">
								Action
							</th>
							
							
						</tr>
					</thead>
					<tbody>
						
                        <?php if(isset($agency)) {
							
							foreach($agency as $agency_v){
							?>
                        
								<tr>
									<td>{{$agency_v->name}}</td>
                                    <?php if($agency_v->parentagencyid == 0) {?>
									<td>Agency Manger</td>
                                    <?php }else{ ?>
                                    <td>Sub-Agent</td>
                                    <?php } ?>
                                    
									<td><a href="{{route('agency')}}?id={{Crypt::encrypt(base64_encode($agency_v->id))}}" class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill"><i class="la la-edit"></i></a></td>
								</tr>
						  <?php }} ?>
                          
                          
                          <?php if(isset($userinformation)) {
							
							foreach($userinformation as $agency_v){
							?>
                        
								<tr>
									<td>{{$agency_v->name}}</td>
                                    <td>User</td>
                                    
									<td><a href="{{route('userupdate')}}?id={{Crypt::encrypt(base64_encode($agency_v->id))}}" class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill"><i class="la la-edit"></i></a></td>
								</tr>
						  <?php }} ?>		
						
							
							
						</tbody>
					</table>
					<!--end: Datatable -->
				</div>
			</div>
			
		</div>
                            </div>

                        </div>

                    </div>
                    <?php } ?>
                                </div>
                                
                                
                                
                                
							</div>
                            
                            <input type="hidden" id="Ids" value="{{Auth::user()->id}}"/>
                            <input type="hidden" id="role" value="{{Auth::user()->user_type}}"/>
                            
							<script>
								var homesearchurl = "{{ URL::to('/homesearch')}}";
								var dashboardcharturl = "{{ URL::to('/dashboardcharturl')}}";

//homwsearch autocomplete
$(".Destination" ).autocomplete({
	minLength: 3,
	source: function( request, response ) {
		$.ajax({
			url: homesearchurl,
			type: 'GET',
			dataType: "json",
			data: {search: request.term},
			success: function( data ) {
				response(data);
				
			}
		});
	},
	select: function (event, ui) 
	{
		
	  //document.getElementById('#Destinationclass').value = ui.item.Destination;
	  
	  $('#showresule').val(ui.item.value);;
	 // display the selected text
		   $('#cityid').val(ui.item.cityid); // save selected id to input
		   return false;
		}
	});





//Autocomplete Detapicker Start
$( ".checkinorlando" ).datepicker({
	defaultDate: +1,        
	dateFormat: 'YY-mm-dd',
	minDate: new Date() ,     
	onSelect: function(dateText, inst) {
		if($('.checkoutorlando').val() == '') {
			var current_date = $.datepicker.parseDate('YY-mm-dd', dateText);
			current_date.setDate(current_date.getDate()+1);
			$('.checkoutorlando').datepicker('setDate', current_date);
		}
	},
	onClose: function(selectedDate, test) {
		if(selectedDate != ""){
			var $date = new Date($( ".checkinorlando" ).datepicker( "getDate" ));
			$date.setDate($date.getDate()+1);

			$( ".checkoutorlando" ).datepicker( "option", "minDate", $date );
			$( ".checkoutorlando" ).datepicker('setDate', $date);

			var $minusDate = new Date($( ".checkinorlando" ).datepicker( "getDate" ));
			$minusDate.setDate($minusDate.getDate()-1);
			var maxDate = new Date($minusDate);
			maxDate.setMonth(maxDate.getMonth()+ 2);
			$( ".checkoutorlando" ).focus();
		}            
	}

});
$( ".checkoutorlando" ).datepicker({
	dateFormat: 'YY-mm-dd',
	beforeShow: function(input, inst) {
	},
	minDate: new Date(),
	onClose: function( selectedDate ) {
		if(selectedDate != ""){
		}
	}
});


//Autocomplete Detapicker End

$(document).ready(function(e) {
	$(document).on('click', '.checkinorlando', function(){
		
		
		$('.dropdown-menu').hide();
		
	});
	
	$(document).on('click', '.checkoutorlando', function(){
		
		
		$('.dropdown-menu').hide();
		
	});
	$(document).on('click', '.Addrooms', function(){
		//Add Rooms
		
		var room =$('#addmaxroom').val();
		$('#norooms').val(room);
		//alert(room);
		$('.searchroomlist'+room).show();
		var addroom = parseInt(room) + parseInt(1);
		$('#addmaxroom').val(addroom);
		$('#removeminroom').val(room);
		$('.delaterooms').show();
		
		if(room == 5){
			$('.Addrooms').hide();
		}
		
		
	});
	$(document).on('click', '.nochild', function(){
		var addchild = $(this).val(); 
		var Proom = $(this).data('room');
		
		for(p=1;p<=addchild;p++){
		///$('.searchroomlist'+Proom).show();
		$('.nochildageclass'+Proom+p).show();
	}
	
	for (n=3; n>addchild; n--) {
		$('.nochildageclass'+Proom+n).hide();
	}
	
	
	
});
	
	
	$(document).on('click', '.delaterooms', function(){
		//Add Rooms
		
		var room =$('#removeminroom').val();
		//alert(room);
		$('.searchroomlist'+room).hide();
		var removeroom = parseInt(room) - parseInt(1);
		$('#addmaxroom').val(room);
		$('#removeminroom').val(removeroom);
		var totalrooms = parseInt(removeroom) - parseInt(1);
		$('#norooms').val(removeroom);
		//$('.delaterooms').show();
		$('.Addrooms').show();
		//min if room check
		
		if(room == 2){
			$('.delaterooms').hide();
		}else{
			$('.delaterooms').show();
			
			
		}
		
		
	});
	
	
	
	
	
});

  // Destination and checkin,checkout validation
  $(document).on('click', '#home_btnsubmit', function(e){
  	var counter = 0;
  	$(".required").each(function() {
  		if ($(this).val() === "") {
			e.preventDefault(); // stops the default action of an element
			//console.log(e.preventDefault());
			$(this).css('border','1px solid #ff1400');
			counter++;
		}else { $(this).css('border','2px solid #dadde2'); }
	});
	
	
	var norooms = $('#norooms').val();
	//alert(norooms);
	  for(nr=1;nr<=norooms;nr++)
	  {
		var nochild = $('#nochild'+nr).val();
		
		if(nochild){
			for(cr=1;cr<=nochild;cr++){
			var value = $('.nochildageclassva11').val();
				// alert(value);
				 if($('.nochildageclassva'+nr+cr).val() == 0){
				 $('.nochildageclassva'+nr+cr).css('border','1px solid #ff1400');
				 var counter = 1;
				 }else{
				 $('.nochildageclassva'+nr+cr).css('border','2px solid #dadde2');
				 }
				
			}
		}
		  
	  }
	
	
	
  	if(counter == 0){
  		
  		$('#hotelserch').submit(); 
		 //alert('form is submitrd');//that is form id "#formid"
		} else {
			$('.required').each(function(){
				if($(this).val() == ''){
					this.focus();
					return false;
				}
			});
		}
	});
  
  
</script>
@endsection
