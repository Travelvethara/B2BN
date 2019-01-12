
@extends('layouts.app')

@section('content')
<?php 
$route = 'userinsert';
if (isset($user) && !empty($user)){
$route = 'userupdate';
}

?>
				<!-- END: Left Aside -->
			
					<!-- BEGIN: Subheader -->
					
					<!-- END: Subheader -->
					<div class="m-content">
						<!--Begin::Section-->
						   
                        <div class="user-content">
							<form action="{{ route($route) }}" class="m-form" method="post" id="signformsubmit">
                                  <input type="hidden" name="_token" value="<?php echo @csrf_token(); ?>">
									<div class="m-portlet m-portlet-padding user-info agency-info-tab">
									   <div class="form-group m-form__group row">
						                      <label class="col-lg-2 col-form-label">Full Name<span class="requiredcls" aria-required="true"> * </span></label>
						                          <div class="col-lg-5">
							                      <input type="text" name="name" id="name" class="form-control m-input"  <?php if (isset($agency->name) && !empty($agency->name)){?> value="{{ $agency->name }}" <?php }else{ ?>value="{{old('name')}}"<?php } ?>>
												   <span class="error-message fullname-check" style="display:none">
													The field is required.
												 </span>
                                                    @if ($errors->has('name'))
                                                    <span class="error-message"> 
												   {{ $errors->first('name') }}
                                                    </span>
											    	@endif   
							                                  <!--<span class="m-form__help">Please enter your full name</span>-->
						                            </div>
					                    		</div>
										<div class="form-group m-form__group row">
                                             <label class="col-lg-2 col-form-label">Email<span class="requiredcls" aria-required="true"> * </span></label>
                                              <div class="col-lg-5">
												<input type="text" class="form-control m-input" id="email" name="email" aria-describedby="emailHelp" placeholder="" <?php if (isset($user->email) && !empty($user->email)){?>  value = "{{ $user->email }}" <?php }else{ ?>value="{{old('email')}}"<?php } ?>>  
                                                <span class="error-message aconfirm-email-check-match" style="display:none">
													Email do not match.
												</span>
                                                <span class="error-message email-check" style="display:none">
												 The field is required.
												 </span>
                                                <span class="error-message email-involid-check" style="display:none">
														The Email is not vaild.
													</span>
                                                @if ($errors->has('email'))
                                                  
                                                  
                                                <span class="error-message">
                       						  {{ $errors->first('email') }}
                                               </span>
                       							 @endif
                                               </div>
								     	</div>
                                        
                                        
                                        <div class="form-group m-form__group row">
                                             <label class="col-lg-2 col-form-label">Confirm Email<span class="requiredcls" aria-required="true"> * </span></label>
                                              <div class="col-lg-5">
												<input type="text" class="form-control m-input" id="confirmemail" name="confirmemail" aria-describedby="emailHelp" placeholder="" <?php if (isset($user->email) && !empty($user->email)){?>  value = "{{ $user->email }}" <?php }else{ ?>value="{{old('email')}}"<?php } ?>>  
                                                
                                                <span class="error-message confirmemail-check" style="display:none">
												 The field is required.
												 </span>
                                                <span class="error-message confirmemail-involid-check" style="display:none">
														The Email is not vaild.
													</span>
                                                @if ($errors->has('confirmemail'))
                                                  
                                                  
                                                <span class="error-message">
                       						  {{ $errors->first('confirmemail') }}
                                               </span>
                       							 @endif
                                               </div>
								     	</div>
														
                                                      
                                                    
										<div class="form-group m-form__group row">
                                                <label class="col-lg-2 col-form-label">Password<span class="requiredcls" aria-required="true"> * </span></label>
                                                  <div class="col-lg-5">
								                  <input type="password" class="form-control m-input" name="password" id="password" placeholder="" <?php if (isset($user->password) && !empty($user->password)){?>  value = "{{ $user->password }}" <?php }else{ ?>value="{{old('password')}}"<?php } ?>>  
                                                  
                                                  <span class="error-message password-check" style="display:none">
																			  The field is required.
																			    </span>
                                                  @if ($errors->has('password'))
                                                  
                                                  <span class="error-message">
                       						      {{ $errors->first('password') }}
                                                  </span>
                       							   @endif 
                                                  </div>
									   	</div>
														
														
										<div class="form-group m-form__group row">
                                                   <label class="col-lg-2 col-form-label">Confirm Password<span class="requiredcls" aria-required="true"> * </span></label>
                                                    <div class="col-lg-5">
													<input type="password" class="form-control m-input" name="password_confirmation" placeholder="" id="password_confirmation">
                                                    
                                                       <span class="error-message confirm-password-check" style="display:none">
																			  The field is required.
																			    </span>
                                                                                <span class="error-message confirm-password-check-match" style="display:none">
																			  Password do not match.
																			    </span>
                                                      @if ($errors->has('password_confirmation'))
                                                      <span class="error-message">
                       						      {{ $errors->first('password_confirmation') }}
                                                  </span>
                       							   @endif 
													</div>
                                         </div>
														
                                                   
                                         <div class="form-group m-form__group row">
                                                     <label class="col-lg-2 col-form-label">Phone<span class="requiredcls" aria-required="true"> * </span></label>
                                                     <div class="col-lg-5">
													<input type="text" name="phone" id="phone" class="form-control m-input" placeholder="" <?php if (isset($user->phone) && !empty($user->phone)){?>  value = "{{ $user->phone }}" <?php }else{ ?>value="{{old('phone')}}"<?php } ?>>
                                                    <span class="error-message phone-check" style="display:none">
													The field is required.
                                                    </span>    @if ($errors->has('phone'))
                                                     
                                                    <span class="error-message"> 
                       						         {{ $errors->first('phone') }}
                                                     </span>
                       							     @endif 
                                                      </div>
									      </div>
                                                            
                                                            
                                         <div class="form-group m-form__group row">
                                                      <label class="col-lg-2 col-form-label">Mobile<span class="requiredcls" aria-required="true"> * </span></label>
                                                       <div class="col-lg-5">
													  <input type="text" id="mobile" name="mobile" class="form-control m-input "  placeholder="" <?php if (isset($user->mobile) && !empty($user->mobile)){?>  value = "{{ $user->mobile }}" <?php }else{ ?>value="{{old('mobile')}}"<?php } ?>> 
                                                       <span class="error-message mobile-check" style="display:none">
																			  The field is required.
																			    </span>
                                                      
                                                      @if ($errors->has('mobile'))
                                                     
                                                      <span class="error-message"> 
                       						         {{ $errors->first('mobile') }}
                                                     </span>
                       							      @endif 
                                                       </div>
										  </div>   
												   
													
														
                                           <div class="form-group m-form__group row">
                                                         <label class="col-lg-2 col-form-label">User role<span class="requiredcls" aria-required="true"> * </span></label>
                                                          <div class="col-lg-5">
														   <select class="form-control " value="id" id="selectId" name="roleid" >
                                                           <option value="" >-Select-</option>             
                                                            @foreach ($role as $row)
                                                           <option value="<?php echo $row->id; ?>"><?php echo $row->role_name ?></option>;                                                            @endforeach
												          </select>
                                                          <span class="error-message selectId-check" style="display:none">
																			  The field is required.
																			    </span>
                                                            @if ($errors->has('roleid'))
                                                            <span class="error-message">
                       						         {{ $errors->first('roleid') }}
                                                     </span>
                       							      @endif 
                                                          
                                                          
                                                           </div>
											</div>  
                                                            
                                                            
                                                             
										    
												   
												   
                                                  
                                                   
                                                  
												  <div class="form-group m-form__group row">
														<label class="col-lg-2 col-form-label"></label>
						                       <div class="col-lg-5">
																	<span class="m-switch  m-switch--success active pull-left" id="active">
																		<label>
													<input type="checkbox" checked="checked" id="active" name="activestatus">
																		<span></span>
																		</label>
																	</span>
																	<label class="col-form-label pull-left paddleft">Active</label>
																</div>
																
																
									                         </div>
													
                                                   
												   <?php if($Premissions['type'] != 'AgencyManger') { ?>
												   <div class="form-group m-form__group row">
													  <label class="col-lg-2 col-form-label"></label>
													     <div class="col-lg-5">
														<label class="m-checkbox m-checkbox--square">
															<input type="checkbox" class="agent_level" id="agent" name="agent_level"> Agent level user
															<span></span>
														</label>
													   </div>	
												
													</div>
                                                    
                                                    <div class="form-group m-form__group row" id="aname" style="display:none;">
                                                         <label class="col-lg-2 col-form-label">Agency Name<span class="requiredcls" aria-required="true"> * </span></label>
                                                          <div class="col-lg-5">
														   <select class="form-control m-input agenctyname" value="id" name="agentid" >
                                                                     <option selected="selected" value="">-Select-</option>
																	@foreach($agency as $ag)
                                                       <option value="<?php echo $ag->id; ?>"><?php echo $ag->name; ?></option>
                                                                    @endforeach
															</select>
                                                            <span class="error-message agenctyname-check" style="display:none">
																			  The field is required.
																			    </span>
                                                           </div>
										        	</div>
                                                    
												
                                                    <?php } ?>
                                                    <div class="m-portlet__foot m-portlet__foot--fit">
													<div class="m-form__actions m-form__actions">
												    <div class="row">
													<div class="col-lg-2">
													</div>
													
														<div class="col-lg-5">
                                                         <?php if (!empty($user->loginid)){  ?> 
															 <input type="hidden" name="loginid" value="{{$user->loginid}}"/>
                                                             <input type="hidden" name="userid" value="{{$user->id}}"/>
															 
															 <?php }  ?>
															<button type="submit" class="btn btn-primary create_user">Create user</button>
															<!--<button type="reset" class="btn btn-secondary">Cancel</button>-->
														</div>
													</div>
													</div>
													</div>
											</div>
							</div>
						<!--End::Section-->
               
						
						<!--End::Section-->
					</div>
				</div> </form>
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
        The User has been added successfully.
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
             
			
			<!-- end:: Body -->
            <!-- begin::Footer -->
			@endsection
			<!-- end:: Footer -->
             <?php if(isset($_GET['id']) && !empty($_GET['id'])){?>           
                                <input type="hidden" id="homeurl" value="<?php echo URL::to("/user?id=".$_GET['id']);?>"/>
                                <?php }else{ ?>
                                <input type="hidden" id="homeurl" value="<?php echo URL::to("/user");?>"/>
                                <?php } ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script>
$(document).ready(function (){
	
	var con =  $("#password_confirmation").keyup(validate);	
	
	$(document).on('click', '.create_user', function(){
		var error = 0;
		
		
		
	if($('.agent_level').prop('checked')==true){
	
		if($('.agenctyname').val() == ''){
			
			$('.agenctyname-check').show();
			var error = 1;
		
		}else{
		$('.agenctyname-check').hide();
		
		}	
	
	}else{
		    $('.agenctyname-check').hide();
		
	}	
	
	
	
	//alert(error);
	
			//start
	if($('#selectId').val() == ''){
	//alert('name');
	  $('#selectId').focus();
	  $('.selectId-check').show();
	  error=1;
	}else{
	  $('.selectId-check').hide();
	}
	//end
		
			//start
	if($('#mobile').val() == ''){
	//alert('name');
	  $('#mobile').focus();
	  $('.mobile-check').show();
	  error=1;
	}else{
	  $('.mobile-check').hide();
	}
	//end
		
			//password number validation
	//start
	if($('#password_confirmation').val() == ''){
		//alert(name);
		  $('#password_confirmation').focus();
		  $('.confirm-password-check').show();
		  error=1;
		  
	}else{
		
	     $('.confirm-password-check').hide();
		 
	}
	//end
	//password number validation
	//start
	if($('#password').val() == ''){
		
		//alert(name);
		  $('#password').focus();
		  $('.password-check').show();
		  error=1;
		  
	}else{
		
	  $('.password-check').hide();
	  
	}
	//end
		
			//phone number validation
	//start
	if($('#phone').val() == ''){
	//alert('name');
	  $('#phone').focus();
	  $('.phone-check').show();
	  error=1;
	}else{
	  $('.phone-check').hide();
	}
	//end
		
		
	var emailinvoild =0;
	   var conformemailinvoild =0;
	
	//email validation
	//start
	var sEmail = $('#confirmemail').val();
	if($.trim(sEmail).length == 0){
		$('.confirmemail-check').show();
		$('.confirmemail-involid-check').hide();
		$('#confirmemail').focus();
		error=1;
	}
	if($('#confirmemail').val() != ''){
		if(validateEmail(sEmail)){
			
			$('.confirmemail-check').hide();
			$('.confirmemail-involid-check').hide();
			$('.confirmemail-email-check-match').hide();
			conformemailinvoild =1;
		}else{
			$('.confirmemail-check').hide();
			$('.confirmemail-involid-check').show();
			$('.confirmemail-email-check-match').hide();
			
			$('#conformemail1').focus();
			error=1;
		}
	}	
		
		
	//email validation
	//start
	var sEmail = $('#email').val();
	if($.trim(sEmail).length == 0){
		$('.email-check').show();
		$('.email-involid-check').hide();
		$('#email').focus();
		error=1;
	}
	if($('#email').val() != ''){
	if(validateEmail(sEmail)){
	
	$('.email-check').hide();
	$('.email-involid-check').hide();
	emailinvoild =1;
	$('.confirmemail-email-check-match').hide();
	//return false;
	}else{
		$('.email-check').hide();
		$('.email-involid-check').show();
		$('.confirmemail-email-check-match').hide();
		$('#email').focus();
		error=1;
		//return false;
	}
	}
	
	
	
	if(emailinvoild && conformemailinvoild){ 
	
	
	//alert('hi');
	var sEmail = $('#email').val();
	var conformemail = $('#confirmemail').val();
	
	  if (sEmail != conformemail)
           {
           //alert('hi');
		   $('#email').focus();
		   $('.aconfirm-email-check-match').show();
		   error=1;
           }else{
		    $('.aconfirm-email-check-match').hide();
		   
		   }
	
	
	}
	
	//end
		
	
	
		
		
	//name validation
	if($('#name').val() == ''){
	//alert(name);
	  $('#name').focus();
	  $('.fullname-check').show();
	  error=1;
	}else{
	  $('.fullname-check').hide();
	}
	
	
	 var password = $("#password").val();
            var confirmPassword = $("#password_confirmation").val();
            if (password != confirmPassword) {
                $('.confirm-password-check-match').show();
				$('.password-check').hide();
				$('.confirm-password-check').hide();
                return false;
            }
	 
	 
	 
	 
	if(error == 1){
		return false;
	}else{
		//alert('hi');
		$('#signformsubmit').submit();
	
	}
	

});


	
	
$(document).on('click', '.closeurl', function(){

$('.modelshow').hide();

var url = $('#homeurl').val();
window.history.pushState('', '', url);

});
	
$("#phone").keypress(function (e) {

  if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) 
       {
          $("#errmsg").html("Digits Only").show().fadeOut(5000);
         
                 return false;
       }
	   else
	   {
		 $(this).css({"border-color": "#ebedf2","color":"#575962"});
	   }
     });	
$("#mobile").keypress(function (e) {

  if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) 
       {
          $("#errmsg").html("Digits Only").show().fadeOut(5000);
         
                 return false;
       }
	   else
	   {
		 $(this).css({"border-color": "#ebedf2","color":"#575962"});
	   }
     });	
	
	$("#agent").click(function(){
  // action goes here!!
      if($("#agent").is(':checked')){
			$.ajax
			({
			  type: "GET",
			  url: "getuserRoleforAgency",
			  data: {'type': 'agencyuserrolesoly'},
			  success: function(data)
			  {
				 data= JSON.parse(data);
				 var $el = $("#selectId");
				 $el.empty();
				 $el.append($("<option></option>")
							 .attr("value", "").text("-- Select --"));
				 $.each(data, function(key,value) {
					  $el.append($("<option></option>")
					 .attr("value", value.id).text(value.role_name));
					 });
			  		}
				});
			  $("#selectId").css('border','1px solid #ff1400');
			  setTimeout(function(){ $("#selectId").css('border','1px solid #c4c6cd'); },2000)		
			  $("#aname").show();
			  
			} else {
					$.ajax
					({
					  type: "GET",
					  url: "getuserRoleforAgency",
					  data: {'type': 'allroles'},
					  success: function(data)
					  {
						 data= JSON.parse(data);
						 var $el = $("#selectId");
						 $el.empty();
						 $el.append($("<option></option>")
							 .attr("value", "").text("-- Select --"));
						 $.each(data, function(key,value) {
							  $el.append($("<option></option>")
							 .attr("value", value.id).text(value.role_name));
							 });
					  }
					});
					$("#selectId").css('border','1px solid #ff1400');
			        setTimeout(function(){ $("#selectId").css('border','1px solid #c4c6cd'); },2000)	
				 $("#aname").hide();
		}
		});
		
		
});



function validate() {
  var password1 = $("#password").val();
  var password1_length = $("#password").val().length;
  var password2 = $("#password_confirmation").val();
  var password2_length = $("#password_confirmation").val().length;
  
  $('.password-check').hide();
  $('.confirm-password-check').hide();

    if(password1 == password2) {
       $(".confirm-password-check-match").hide();
      
    }
    else {
		if(password2_length>=password1_length){
			
        $(".confirm-password-check-match").show();
		}else{
			
		$(".confirm-password-check-match").hide();
		}
     
    }
    
    
}

function validateEmail(sEmail) {
    var filter = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;
    if (filter.test(sEmail)) {
        return true;
    }
    else {
		
        return false;
    }
}
</script>
<style>
#errmsg
{
 color:red;
}

.error-message {
    color: #ff3c41;
    padding: 5px 10px;
    margin-left: 0;
    width: 100%;
}
</style>