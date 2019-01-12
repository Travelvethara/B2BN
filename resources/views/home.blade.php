@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css">
<script src="//code.jquery.com/jquery-1.10.2.js"></script> 
<script src="//code.jquery.com/ui/1.11.2/jquery-ui.js"></script> 

<!-- BEGIN: Subheader --> 

<!-- END: Subheader -->
<div class="m-content m-content-formcontrolalter"> 
  <!--Begin::Section-->
  
  <div class="user-content user-content-search">
    <form action="{{ route('hotellist') }}" method="get" id="hotelserch"/>
    
    <div class="m-portlet m-portlet-padding user-info">
      <div class="row">
        <div class="col-md-6">
          <div class="form-group m-form__group">
            <label>Destination</label>
            <input type="text" class="form-control m-input Destination required" id="showresule" name="city" placeholder="Enter a location">
            <input type="hidden" name="cityid" id="cityid" value=""/>
            <input type="hidden" name="cityname" id="cityname" value=""/>
            <input type="hidden" name="tbocities" id="tbocities" value=""/>
          </div>
        </div>
        <div class="col-md-3 selectdatealter">
          <div class="form-group m-form__group positionrelative claendericon ">
            <div class='input-group' id='m_daterangepicker_1_validate'> 
              
            <!-- <input type='text' class="form-control m-input required" readonly  placeholder="Select date range"/>-->
              <label>Checkin Date</label>
              <input type="text" class="form-control required" id="m_datepicker_1" readonly placeholder="Select date" name="checkin"/>
            </div>
            <span><i class="far fa-calendar-alt"></i></span> </div>
        </div>
        <div class="col-md-3 selectdatealter">
          <div class="form-group m-form__group positionrelative claendericon ">
            <div class='input-group' id='m_daterangepicker_1_validate'> 
              
           <!-- <input type='text' class="form-control m-input required" readonly  placeholder="Select date range"/> -->
              <label>CheckOut Date</label>
              <input type="text" class="form-control required" id="m_datepicker_2" readonly placeholder="Select date" name="checkout"/>
            </div>
            <span><i class="far fa-calendar-alt"></i></span> </div>
        </div>
   <!-- <div class="col-md-2 ">
															<div class="form-group m-form__group positionrelative claendericon">
																<input type="text" class="form-control m-input checkoutorlando" id="checkoutorlando"  placeholder="Chack Out" name="checkout">
																<span><i class="far fa-calendar-alt"></i></span>
															</div>
														</div>
       <div class="col-md-2 ">
															<div class="form-group m-form__group no-days-block">
															<lable> <b>2</b> days </lable>
															</div>
														</div> -->
      </div>
      <div class="row">
        <div class="col-md-6">
          <div class="form-group m-form__group">
            <label>Hotel Name</label>
            <input type="text" class="form-control PropertyName"   placeholder="Enter any Hotel Name" name="hotelname"/>
          </div>
        </div>
        <div class="col-md-2">
          <div class="form-group m-form__group">
            <label>Nationality</label>
            <select class="form-control m-input " name="nationaltly" >
              <?php if(isset($getcountries)) {
																         foreach($getcountries as $getcountries_value){	
																 ?>
              <option value="{{$getcountries_value->CountryCode}}">{{$getcountries_value->CountryName}}</option>
              <?php }} ?>
            </select>
          </div>
        </div>
        <div class="col-md-2">
          <div class="form-group m-form__group">
            <label>Star Rating</label>
            <select class="form-control m-input starrating" name="star" >
              <option value="">--Select--</option>
              <option value="5">5</option>
              <option value="4">4</option>
              <option value="3">3</option>
              <option value="2">2</option>
              <option value="1">1</option>
            </select>
          </div>
          <input type="hidden" name="minstar" id="minstar" value=""/>
          <input type="hidden" name="maxstar" id="maxstar" value=""/>
        </div>
        <div class="col-md-2">
          <div class="form-group m-form__group">
            <label>Currency</label>
            <select class="form-control m-input " name="currency" >
              <option value="USD">USD</option>
              <option value="GBP">GBP</option>
              <option value="PKR">PKR</option>
              <option value="EUR">EUR</option>
              <option value="HKD">HKD</option>
            </select>
          </div>
        </div>
      </div>
      <input type="hidden" name="norooms" id="norooms" value="1"/>
      @for($i=1;$i<=5;$i++)
      <div class="row searchroomlist{{$i}}" <?php if($i>1) {?> style="display:none"; <?php } ?>>
        <div class="col-md-3" >
          <div class="form-group m-form__group">
            <label>Adults</label>
            <select class="form-control m-input noadultclass{{$i}}" name="adult{{$i}}" id="noadult{{$i}}">
              <option value="1">1 Adults</option>
              <option value="2" selected="selected">2 Adults</option>
              <option value="3">3 Adults</option>
              <option value="4">4 Adults</option>
              <option value="5">5 Adults</option>
            </select>
          </div>
        </div>
        <div class="col-md-3">
          <div class="form-group m-form__group">
            <label>Children</label>
            <select class="form-control m-input nochildclass{{$i}} nochild" name="child{{$i}}" id="nochild{{$i}}" data-room="{{$i}}">
              <option value="0">0</option>
              <option value="1">1 </option>
              <option value="2">2 </option>
              <option value="3">3 </option>
            </select>
          </div>
        </div>
        @for($c=1;$c<=3;$c++)
        <div class="col-md-2 nochildageclass{{$i}}{{$c}} childageperroom{{$i}} " style="display:none";>
          <div class="form-group m-form__group" >
            <label>Child Age </label>
            <select class="form-control m-input nochildageclassva{{$i}}{{$c}}" name="childage{{$i}}{{$c}}" id="nochildage{{$i}}{{$c}}">
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
        @endfor </div>
      @endfor
      <div class="row">
        <div class="col-md-3 Addrooms">
          <input type="hidden" id="addmaxroom" value="2"/>
          <i class="fas fa-plus-square"></i> <b>Add rooms</b> </div>
        <div class="col-md-3 delaterooms">
          <input type="hidden" id="removeminroom" value="2"/>
          <i class="fas fa-minus-square"></i> <b>Remove rooms</b> </div>
       
        
      </div>
      <div class="row">
      	  <div class="col-md-3">
          <div class="form-group m-form__group">
            <label>Mark Up</label>
             <input type="text" class="form-control m-input" onkeyup="numonly(this);" id="markup" placeholder="Enter a markup" name="markup">
          </div>
        </div>
         <div class="col-md-3 nightsshowa">
          <div class="form-group m-form__group">
            <label>Nights</label>
            <select class="form-control m-input nights" name="nights" >
            @for($i=1;$i<=30;$i++)
              <option value="{{$i}}">{{$i}}</option>
            
              @endfor
            </select>
          </div>
        </div>
      </div>
    <!-- <div class="row marginten">
													  <div class="col-md-12">
														<h5>Star Rating</h5>
													  </div>	
													</div>-->
  <!--<div class=" star-rating-blocks clear">
												    <div class="rating-block-one">
														<label class="m-checkbox m-checkbox--square">
															<input type="checkbox"> 1
													        <span></span>
											             </label>
													</div>
													 <div class="rating-block-one">
														<label class="m-checkbox m-checkbox--square">
															<input type="checkbox"> 2
													        <span></span>
											             </label>
													</div>
													 <div class="rating-block-one">
														<label class="m-checkbox m-checkbox--square">
															<input type="checkbox"> 3
													        <span></span>
											             </label>
													</div>
													 <div class="rating-block-one">
														<label class="m-checkbox m-checkbox--square">
															<input type="checkbox"> 4
													        <span></span>
											             </label>
													</div>
													 <div class="rating-block-one">
														<label class="m-checkbox m-checkbox--square">
															<input type="checkbox"> 5
													        <span></span>
											             </label>
													</div>
												</div> -->
      
      <div class="row nomargin">
        <div class="col-md-6">
          <button type="button" class="btn btn-primary" id="home_btnsubmit">Search Hotels</button>
        </div>
      </div>
    </div>
    
    <!-- after changer -->
    

    <?php /*?><div class="m-portlet m-portlet-padding user-info">
      <div class="row">
        <div class="col-md-6">
          <div class="form-group m-form__group">
            <label>Destination</label>
            <input type="text" class="form-control m-input Destination required" id="showresule" name="city" placeholder="Enter a location">
            <input type="hidden" name="cityid" id="cityid" value=""/>
            <input type="hidden" name="cityname" id="cityname" value=""/>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-3 selectdatealter">
          <div class="form-group m-form__group positionrelative claendericon ">
            <div class='input-group' id='m_daterangepicker_1_validate'> 
              
              <!--<input type='text' class="form-control m-input required" readonly  placeholder="Select date range"/>-->
              <label>Checkin Date</label>
              <input type="text" class="form-control required" id="m_datepicker_1" readonly placeholder="Select date" name="checkin"/>
            </div>
            <span><i class="far fa-calendar-alt"></i></span> </div>
        </div>
        <div class="col-md-3 selectdatealter">
          <div class="form-group m-form__group positionrelative claendericon ">
            <div class='input-group' id='m_daterangepicker_1_validate'> 
              
              <!--<input type='text' class="form-control m-input required" readonly  placeholder="Select date range"/>-->
              <label>CheckOut Date</label><span id="above_one_month"></span>
              <input type="text" class="form-control required" id="m_datepicker_2" readonly placeholder="Select date" name="checkout"/>
               <input type="hidden"  id="date_count"  />
            </div>
            <span><i class="far fa-calendar-alt"></i></span> </div>
        </div>
        <div class="col-md-3 nightsshowa" style="display:none;">
          <div class="form-group m-form__group">
            <label>Nights</label>
            <select class="form-control m-input nights" name="nights" >
            @for($i=1;$i<=30;$i++)
              <option value="{{$i}}">{{$i}}</option>
            
              @endfor
            </select>
          </div>
        </div>
        </div>
        <div class="row">
        <div class="col-md-3">
          <div class="form-group m-form__group">
            <label>Rooms</label>
            <select class="form-control m-input Addrooms" name="norooms" >
              <option value="1">1</option>
              <option value="2">2</option>
              <option value="3">3</option>
              <option value="4">4</option>
            </select>
          </div>
        </div>
        @for($i=1;$i<=5;$i++)
        <?php
        if($i > 1){
        ?>
         <div class="row">
        <div class="offset-md-3 col-md-3 searchroomlist{{$i}}" <?php if($i>1) {?> style="display:none"; <?php } ?>>
        <?php
         }else{
        ?>
        <div class="col-md-3 searchroomlist{{$i}}" <?php if($i>1) {?> style="display:none"; <?php } ?>>
        <?php
        }
        ?>
          <div class="form-group m-form__group roomcountlabel">
            <label>Room {{$i}}</label>
          
          </div>
        </div>
        
        <div class="col-md-3 searchroomlist{{$i}}" <?php if($i>1) {?> style="display:none"; <?php } ?>>
          <div class="form-group m-form__group">
            <label>Adults</label>
           <select class="form-control m-input noadultclass{{$i}}" name="adult{{$i}}" id="noadult{{$i}}">
																	<option value="1">1 Adults</option>
																	<option value="2" selected="selected">2 Adults</option>
																	<option value="3">3 Adults</option>
																	<option value="4">4 Adults</option>
																	<option value="5">5 Adults</option>
																</select>
          </div>
        </div>
        <div class="col-md-3 searchroomlist{{$i}}" <?php if($i>1) {?> style="display:none"; <?php } ?>>
          <div class="form-group m-form__group">
            <label>children</label>
            <select class="form-control m-input nochildclass{{$i}} nochild" name="child{{$i}}" id="nochild{{$i}}" data-room="{{$i}}">
																	<option value="0">0</option>
																	<option value="1">1 </option>
																	<option value="2">2 </option>
																	<option value="3">3 </option>
																</select>
          </div>
        </div>
         <?php
        if($i > 1){
        ?>
        </div>
        <?php
         }
        ?>
         <?php
        if($i <=1){
        ?>
         </div>
        <?php
        }
        ?>
     
        <div class="row childagedicv childagedivshow{{$i}}">
        @for($c=1;$c<=3;$c++)
        <?php
        if($c <=1){
        ?>
        <div class="offset-md-6 col-md-2 nochildageclass{{$i}}{{$c}} childageperroom{{$i}}" style="display:none";>
        <?php
        }else{
        ?>
        <div class="col-md-2 nochildageclass{{$i}}{{$c}} childageperroom{{$i}}" style="display:none";>
        <?php
        }
        ?>
          <div class="form-group m-form__group">
              <label>Age </label>
            <select class="form-control m-input nochildageclassva{{$i}}{{$c}}" name="childage{{$i}}{{$c}}" id="nochildage{{$i}}{{$c}}">
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
         @endfor
           </div>
        @endfor
    
      
      <div class="row" >
        <div class="col-md-3" >
          <div class="form-group m-form__group">
            <label>Currency</label>
																<select class="form-control m-input " name="currency" >
																	<option value="USD">USD</option>
                                                                    <option value="GBP">GBP</option>
                                                                    <option value="EUR">EUR</option>
                                                                    <option value="HKD">HKD</option>
                                                                    <option value="INR">INR</option>
																</select>
          </div>
        </div>
        <div class="col-md-3">
          <div class="form-group m-form__group">
             <label>Nationality</label>
																<select class="form-control m-input " name="nationaltly" >
                                                                <?php if(isset($getcountries)) {
																         foreach($getcountries as $getcountries_value){	
																 ?>
																	<option value="{{$getcountries_value->CountryCode}}">{{$getcountries_value->CountryName}}</option>
																<?php }} ?>
                                                                
                                                                </select>
          </div>
        </div>
         <div class="col-md-6">
          <div class="form-group m-form__group">
            <label>Star Rating</label>
           <div class="star-checkbox star-rating-checkbok">
                        					<div class="star-one">
                        						<label class="m-checkbox m-checkbox--solid m-checkbox--success">
                        							<input type="checkbox" name="star[]" value="1"  class="star" id="1star"> 
                        							<div class="star-star">
                        							1
                        							</div>
                        							<span></span>
                        						</label>
                        					</div>
                        					<div class="star-one">
                        						<label class="m-checkbox m-checkbox--solid m-checkbox--success">
                        							<input type="checkbox" name="" value="2" class="star" id="2star"> 
                        							<div class="star-star">
                        								2
                        							</div>
                        							<span></span>
                        						</label>
                        					</div>
                        					<div class="star-one">
                        						<label class="m-checkbox m-checkbox--solid m-checkbox--success">
                        							<input type="checkbox" name="" value="3" class="star" id="3star"> 
                        							<div class="star-star">
                        								3
                        							</div>
                        							<span></span>
                        						</label>
                        					</div>
                        					<div class="star-one">
                        						<label class="m-checkbox m-checkbox--solid m-checkbox--success">
                        							<input type="checkbox" name="" value="4" class="star" id="4star"> 
                        							<div class="star-star">
                        								4
                        							</div>
                        							<span></span>
                        						</label>
                        					</div>
                        					<div class="star-one">
                        						<label class="m-checkbox m-checkbox--solid m-checkbox--success">
                        							<input type="checkbox" name="" value="5" class="star" id="5star"> 
                        							<div class="star-star">
                        								5
                        							</div>
                        							<span></span>
                        						</label>
                        					</div>
                                            <div class="star-one">
                        						<label class="m-checkbox m-checkbox--solid m-checkbox--success">
                        							<input type="checkbox" name="" value="all" class="star allcheckstar" id="allcheckstar"> 
                        							<div class="star-star">
                        								All
                        							</div>
                        							<span></span>
                        						</label>
                        					</div>
                                            <input type="hidden" id="minstar" value="" name="minstar"/>
		                             <input type="hidden" id="maxstar" value="" name="maxstar"/>
                        				</div>
          </div>
        </div>
 </div>
     
     <!-- <div class="row">
        <div class="col-md-3 Addrooms">
          <input type="hidden" id="addmaxroom" value="2"/>
          <i class="fas fa-plus-square"></i> <b>Add rooms</b> </div>
        <div class="col-md-3 delaterooms">
          <input type="hidden" id="removeminroom" value="2"/>
          <i class="fas fa-minus-square"></i> <b>Remove rooms</b> </div>
      </div>
      <!--<div class="row marginten">
													  <div class="col-md-12">
														<h5>Star Rating</h5>
													  </div>	
													</div>--> 
      <!--<div class=" star-rating-blocks clear">
												    <div class="rating-block-one">
														<label class="m-checkbox m-checkbox--square">
															<input type="checkbox"> 1
													        <span></span>
											             </label>
													</div>
													 <div class="rating-block-one">
														<label class="m-checkbox m-checkbox--square">
															<input type="checkbox"> 2
													        <span></span>
											             </label>
													</div>
													 <div class="rating-block-one">
														<label class="m-checkbox m-checkbox--square">
															<input type="checkbox"> 3
													        <span></span>
											             </label>
													</div>
													 <div class="rating-block-one">
														<label class="m-checkbox m-checkbox--square">
															<input type="checkbox"> 4
													        <span></span>
											             </label>
													</div>
													 <div class="rating-block-one">
														<label class="m-checkbox m-checkbox--square">
															<input type="checkbox"> 5
													        <span></span>
											             </label>
													</div>
												</div>-->
                                                
      <div class="row">
        <div class="col-md-6">
          <div class="form-group m-form__group">
            <label>Hotel Name</label>
             <input type="text" class="form-control m-input Destination " id="showresule" name="hotelname" placeholder="Enter a Hotel Name">
          </div>
        </div>
        <div class="col-md-3">
          <div class="form-group m-form__group">
            <label>Mark Up</label>
             <input type="text" class="form-control m-input" onkeyup="numonly(this);" id="markup" placeholder="Enter a markup" name="markup" />
          </div>
        </div>
        
        
      </div>                                          
      
      <div class="row nomargin">
        <div class="offset-md-6 col-md-6">
          <button type="button" class="btn btn-primary" id="home_btnsubmit">Search Hotels</button>
        </div>
      </div>
    </div>
    
   <!-- end of after changer--> 
    </form>
  </div>
  <!--End::Section--> 
  <!--End::Section--> 
</div><?php */?>
<!-- after- change-end -->

</div>

<script>
								var homesearchurl = "{{ URL::to('/homesearch')}}";
								var homesearchurlnew = "{{ URL::to('/hotelsearchn')}}";

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
		    $('#cityname').val(ui.item.cityname); // save selected id to input
			$('#tbocities').val(ui.item.tbocities); // save selected id to input
		   return false;
		}
	});
	
	
	$(".PropertyName" ).autocomplete({
	minLength: 3,
	source: function( request, response ) {
		$.ajax({
			url: homesearchurlnew,
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
	  
	  $('.PropertyName').val(ui.item.value);;
	 // display the selected text
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
	
	
	
	$(document).on('click', '.starrating', function(){
		
		var starratingValue = $(this).val();
		
		if(starratingValue){
		$('#minstar').val(starratingValue);
		$('#maxstar').val(starratingValue);
			
		}else{
		
		$('#minstar').val('');
		$('#maxstar').val('');
		
		}
		
		
		
		
	});
	$('.Destination').val('');
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

$(document).on('click', '.delaterooms', function(){
		//Add Rooms
		
		var room =$('#removeminroom').val();
		
		/*$('.searchroomlist2').hide();
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
			
			
		}*/
		
		
	});
	
	
	
	$(document).on('change', '.star', function() {
				
				var maxrating = '';
				for(i=0;i<=5;i++){
					if($('#' + i + 'star').is(':checked')){
						maxrating = i;
						
					}
				}
				$('#maxstar').val(maxrating);
				var minrating = '';
				for(i=5;i>=0;i--){
					if($('#' + i + 'star').is(':checked')){
						minrating = i;
						
					}
				}
				
				$('#minstar').val(minrating);
            //$TIPlugin('#Mod_maxstar').val(maxrating);
            $('#maxstar').val(maxrating);
            $('#minstar').val(minrating);
            //$('.loder-edit').show();
            //ajaxjsonhotel();
			for(i=minrating;i<=maxrating;i++){
				
				$('#'+i+'star').prop('checked', true);
			}
  
			//hotelajax();
		});	
			

	
	
	
	$(document).on('click', '.checkinorlando', function(){
		
		
		$('.dropdown-menu').hide();
		
	});
	
	$(document).on('change', '.nights', function(){
		
		var date = $('#m_datepicker_1').datepicker('getDate');
		var count_input = $(this).val();
		var count_num = parseInt(count_input);
		var time_count = parseInt(1000*60*60*24*count_num);
		if(date.getTime()){
		}else{
		date = new Date(); 
		}
		date.setTime(date.getTime() + (time_count))
		$('#m_datepicker_2').datepicker("setDate", date);
		$('#date_count').val(count_num);
		
	});
	
	
	$(document).on('change', '#m_datepicker_2', function(){
		$(".nightsshowa").show();
			var From_date = new Date($("#m_datepicker_1").val());
			var To_date = new Date($("#m_datepicker_2").val());
			var diff_date =  To_date - From_date;

			var years = Math.floor(diff_date/31536000000);
			var months = Math.floor((diff_date % 31536000000)/2628000000);
			var days = Math.floor(((diff_date % 31536000000) % 2628000000)/86400000);
			$("#date_count").html(years+" year(s) "+months+" month(s) "+days+" and day(s)");
			$("#date_count").val(days);
			$('#above_one_month').html('');
			$('.nights').val(days).attr("selected", "selected");
			if(months>=1){
				$("#m_datepicker_2").focus();
				$('#above_one_month').html('select below 30 days');
				$("#m_datepicker_2").val('');
			}
	
		
		
	});
	
	
	$(document).on('click', '.checkoutorlando', function(){
		
		
		$('.dropdown-menu').hide();
		
	});
	$(document).on('change', '.Addrooms', function(){
		//Add Rooms
		
		var room =$(this).val();
		//alert(room);
		for(i=1;i<=room;i++){
			
			$('.searchroomlist'+i).show();
			
		}
		for(i=4;i>room;i--){
			
			$('.searchroomlist'+i).hide();
			$().val('');
			$('.noadult'+i).val('0').attr("selected", "selected");
			$('.nochild'+i).val('0').attr("selected", "selected");
			var nochild = $('.nochild'+i).val();
			for(c=3;c>nochild;c--){
			  $('.nochildage'+i+c).val('');
			
			}
			
			
		}
		
		
/*		$('#norooms').val(room);
		//alert(room);
		$('.searchroomlist'+room).show();
		var addroom = parseInt(room) + parseInt(1);
		$('#addmaxroom').val(addroom);
		$('#removeminroom').val(room);
		$('.delaterooms').show();
		
		if(room == 5){
			$('.Addrooms').hide();
		}*/
		
		
	});
	$(document).on('click', '.nochild', function(){
		var addchild = $(this).val(); 
		var Proom = $(this).data('room');
		
		for(p=1;p<=addchild;p++){
		$('.searchroomlist'+Proom).show();
    $('.childagedivshow'+Proom).css('display', 'flex');
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
//Star check

$(document).on('click', '.star', function(e){
  	var values = $(this).val();
  	if(values == 'all'){
	    if($(this).prop('checked')){
			  $('.star').prop('checked', true);
	    }else{
	         $('.star').prop('checked', false);
	    }
	}else{
		$('.allcheckstar').prop('checked', false);
	}
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
  		$('.loader-fixed').show();
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
  
  function numonly(root){
    var reet = root.value;    
    var arr1=reet.length;      
    var ruut = reet.charAt(arr1-1);   
        if (reet.length > 0){   
        var regex = /[0-9]|\./;   
            if (!ruut.match(regex)){   
            var reet = reet.slice(0, -1);   
            $(root).val(reet);   
            }   
        }  
      	if(parseInt(reet)>parseInt(99)){
      		$('#markup').val(99);
        }
 }
</script> 
@endsection 