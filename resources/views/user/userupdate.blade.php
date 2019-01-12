
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
			<form action="{{ route($route) }}" method="post" class="m-form" id="formsubmit">
				
				<input type="hidden" name="_token" value="<?php echo @csrf_token(); ?>">
				<div class="m-portlet m-portlet-padding user-info agency-info-tab">
					<div class="form-group m-form__group row">
						<label class="col-lg-3 col-form-label" >Name<span class="requiredcls" aria-required="true"> * </span></label>
						<div class="col-lg-6">
							<input type="text" class="form-control m-input" id="name" name="name" placeholder="Name"<?php if (isset($user->name) && !empty($user->name)){?>  value = "{{ $user->name }}" <?php }else{ ?>value="{{old('name')}}" <?php } ?> maxlength="30"> 
							<span class="error-message fullname-check" style="display:none">
								The field is required.
							</span>
							@if ($errors->has('name'))
							
							
							<span class="error-message">
								{{ $errors->first('name') }}
							</span>
							@endif 
						</div>
					</div>
					
					<div class="form-group m-form__group row">
						<label class="col-lg-3 col-form-label">Email<span class="requiredcls" aria-required="true"> * </span></label>
						<div class="col-lg-6">
							<input type="email" class="form-control m-input " id="email"  name="email" aria-describedby="emailHelp" placeholder="Email" <?php if (isset($user->email) && !empty($user->email)){?>  value = "{{ $user->email }}" <?php }else{ ?>value="{{old('email')}}"<?php } ?> maxlength="30">  
							<span class="error-message aconfirm-email-check-match" style="display:none">
													Email do not match.
												</span>
                            <span class="error-message email-check" style="display:none">
								The field is required.
							</span>
							<span class="error-message email-involid-check" style="display:none">
								The Email is not vaild.
							</span>
							@if ($errors->has('email'))<span class="error-message">
								{{ $errors->first('email') }}
							</span>
							@endif 
						</div>
					</div>
                    
                    <div class="form-group m-form__group row">
                                             <label class="col-lg-3 col-form-label">Confirm Email<span class="requiredcls" aria-required="true"> * </span></label>
                                              <div class="col-lg-6">
												<input type="text" class="form-control m-input" id="confirmemail" name="confirmemail" aria-describedby="emailHelp" placeholder=""  <?php if (isset($user->email) && !empty($user->email)){?>  value = "{{ $user->email }}" <?php }else{ ?>value="{{old('email')}}"<?php } ?> maxlength="30">  
                                                
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
						<label class="col-lg-3 col-form-label">Phone<span class="requiredcls" aria-required="true"> * </span></label>
						<div class="col-lg-6">
							<input type="text" id="phone" name="phone" class="form-control " i placeholder="Phone" <?php if (isset($user->phone) && !empty($user->phone)){?>  value = "{{ $user->phone }}" <?php }else{ ?>value="{{old('phone')}}"<?php } ?> maxlength="30">
							<span class="error-message phone-check" style="display:none">
								The field is required.
							</span>
							@if ($errors->has('phone'))<span class="error-message">
								{{ $errors->first('phone') }}
							</span>
							@endif 
						</div>
					</div>
					<div class="form-group m-form__group row">
						<label class="col-lg-3 col-form-label" >Mobile<span class="requiredcls" aria-required="true"> * </span></label>
						<div class="col-lg-6">
							<input type="text" id="mobile" name="mobile" class="form-control "  placeholder="Mobile" <?php if (isset($user->mobile) && !empty($user->mobile)){?>  value = "{{ $user->mobile }}" <?php }else{ ?>value="{{old('mobile')}}"<?php } ?> maxlength="30">
							<span class="error-message mobile-check" style="display:none">
								The field is required.
							</span>
							
							@if ($errors->has('mobile'))<span class="error-message"
							{{ $errors->first('mobile') }}
						</span>
						@endif 
					</div>
				</div>
                
               <?php  if(Auth::user()->user_type == 'AgencyManger') { ?> 
			   <div class="form-group m-form__group row">
					<label class="col-lg-3 col-form-label" >User role<span class="requiredcls" aria-required="true"> * </span></label>
					<div class="col-lg-6">
						<select class="form-control" value="id" name="roleid" id="userRole">                                  <option>-Select-</option>
							@foreach ($AgencyMangerrole as $row)
							<option value="<?php echo $row->id; ?>" <?php if($row->id == $user->roleid) { ?> selected="selected" <?php } ?>><?php echo $row->role_name ?></option>
							@endforeach
						</select>               
						<span class="error-message userlevel-check" style="display:none">
							The field is required.
						</span>

					</div>
				</div>
			   
			   <?php }else{?>
				
				<div class="form-group m-form__group row">
					<label class="col-lg-3 col-form-label" >User role<span class="requiredcls" aria-required="true"> * </span></label>
					<div class="col-lg-6">
						<select class="form-control" value="id" name="roleid" id="userRole">                                  <option>-Select-</option>
							@foreach ($role as $row)
							<option value="<?php echo $row->id; ?>" <?php if($row->id == $user->roleid) { ?> selected="selected" <?php } ?>><?php echo $row->role_name ?></option>
							@endforeach
						</select>               
						<span class="error-message userlevel-check" style="display:none">
							The field is required.
						</span>

					</div>
				</div>
                <?php } ?>
				<div class="form-group m-form__group row">
					<label class="col-lg-3 col-form-label" >Userid</label>
					<div class="col-lg-6">
						<input type="text"   <?php if (isset($user->userid) && !empty($user->userid)){?>  value = "{{ $user->userid }}" <?php }else{ ?>value="{{old('userid')}}"<?php } ?>class="form-control " readonly  placeholder="" >
					</div>
				</div>
				
				<div class="form-group m-form__group row">
					<label class="col-lg-3 col-form-label"></label>
					<div class="col-lg-6">
						<span class="m-switch  m-switch--success active pull-left" id="active">
							<label>
								<input type="checkbox" id="active" <?php if($user->activestatus) { ?> checked="checked" <?php } ?> name="activestatus" maxlength="30">
								<span></span>
							</label>
						</span>
						<label class="col-form-label pull-left paddleft">Active</label>
					</div>
				</div>
				<div class="form-group m-form__group row" <?php if(Auth::user()->user_type == 'AgencyManger'){ ?> style="display:none;" <?php }?> >
					<label class="col-lg-3 col-form-label"></label>
					<div class="col-lg-6">
						<label class="m-checkbox m-checkbox--square">
							<input type="checkbox" id="is_agent" class="isagency" name="agent_level" <?php if($user->agent_level) { ?> checked <?php } ?> > Agent level user
							<span></span>
						</label>
					</div>	
				</div>
				
				<div class="form-group m-form__group row">
					<label class="col-lg-3 col-form-label"></label>
					<div class="col-lg-6">
						<label class="m-checkbox m-checkbox--square">
							<input type="checkbox" name= "changepassword" class="changepassword ispassword" {{ old('changepassword') ? 'checked' : '' }}> Do You Change Password<span></span>
						</label>
					</div>	
				</div>
				
				<div  id="passcheck" <?php if(old('changepassword')){?> style="display:black;" <?php }else{  ?> style="display:none;" <?php } ?>>
					<div class="form-group m-form__group row">
						<label class="col-lg-3 col-form-label">Password<span class="requiredcls" aria-required="true"> * </span></label>
						<div class="col-lg-6">
							<input type="password" class="form-control m-input" name="password" placeholder="Password" id="password_is" maxlength="30">																	                                          
							<span class="error-message password-check-is" style="display:none">
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
						<label class="col-lg-3 col-form-label">Confirm Password<span class="requiredcls" aria-required="true"> * </span></label>
						<div class="col-lg-6">
							<input type="password" class="form-control m-input" name="password_confirmation" maxlength="30" placeholder="Confirm Password" id="password_confirmation_is">
							<span class="error-message confirm-password-check_is" style="display:none">
								The field is required.
							</span>
							<span class="error-message confirm-password-check-match" style="display:none">
								Password do not match.
							</span>
							<span class="error-message">  @if ($errors->has('password_confirmation'))
								{{ $errors->first('password_confirmation') }}
							@endif </span>
						</div>
					</div>
				</div>
				
				<div  id="aname" <?php if(Auth::user()->user_type == 'AgencyManger'){ ?> style="display:none;" <?php }?> <?php if($user->agent_level) { ?> style="display:block;" <?php } else { ?> style="display:none;" <?php } ?> >
					<div class="form-group m-form__group row">
						<label class="col-lg-3 col-form-label">Agent name<span class="requiredcls" aria-required="true"> * </span></label>
						<div class="col-lg-6">
							<select class="form-control agencylevel" value="id" name="agentid">
								<option value="0">-Select-</option>
								@foreach($agency as $ag)
								<option value="<?php echo $ag->id; ?>"  <?php if($ag->id == $user->agentid) { ?> selected="selected" <?php } ?>><?php echo $ag->name; ?></option>                                                                    @endforeach
							</select>
							<span class="error-message agencylevel-check" style="display:none">
								The field is required.
							</span>
						</div>	
					</div>	
				</div>
				
				<div class="m-portlet__foot m-portlet__foot--fit">
					<div class="m-form__actions m-form__actions">
						<div class="row">
							<div class="col-lg-3">
							</div>
							<div class="col-lg-6">
								<?php if (!empty($user->loginid)){  ?> 
									<input type="hidden" name="loginid" value="{{Crypt::encrypt(base64_encode($user->loginid))}}"/>
									<input type="hidden" name="userid" value="{{Crypt::encrypt(base64_encode($user->id))}}"/>
									
								<?php }  ?>
								<button type="submit" class="btn btn-primary update_user">Update user</button>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!--End::Section-->
		
		
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
    	The User information has been updated successfully.
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
	<input type="hidden" id="homeurl" value="<?php echo URL::to("/userupdate?id=".$_GET['id']);?>"/>
<?php }else{ ?>
	<input type="hidden" id="homeurl" value="<?php echo URL::to("/userupdate");?>"/>
<?php } ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script>
	$(document).ready(function (){
		
		
		$(document).on('click', '.update_user', function(){
			var error = 0;
			
			
			
			if($('.isagency').prop('checked')==true){
				
				var error = 1;
				if($('.agencylevel').val() == ''){
					
					$('.agencylevel-check').show();
					var error = 1;
					
				}else{
					$('.agencylevel-check').hide();
					
				}	
				
			}else{
				$('.agencylevel-check').hide();
				
			}
			
			
			
			if($('.ispassword').prop('checked')==true){
				
				
				if($('#password_is').val() == ''){
					$('.password-check-is').show();
					var error = 1;
				}else{
					
					$('.password-check-is').hide();
				}
				
				if($('#password_confirmation_is').val() == ''){
					
					$('.confirm-password-check_is').show();
					var error = 1;
					
				}else{
					$('.confirm-password-check_is').hide();
					
				}

				
			}else{
				$('.password-check-is').hide();
				$('.confirm-password-check_is').hide();
			//var error = 0;
		}

		
		if($('.agencylevel').val() == ''){
			
			$('.agencylevel-check').show();
			var error = 1;
			
		}else{
			$('.agencylevel-check').hide();
			
		}	
		
		
		
		if($('.userRole').val() == ''){
			
			$('.userlevel-check').show();
			var error = 1;
			
		}else{
			$('.userlevel-check').hide();
			
		}		
		
		//name validation
		if($('#name').val() == ''){
	//alert(name);
	$('#name').focus();
	$('.fullname-check').show();
	error=1;
}else{
	$('.fullname-check').hide();
}


		//phone number validation
	//start
	if($('#phone').val() == ''){
	//alert(name);
	$('#phone').focus();
	$('.phone-check').show();
	error=1;
}else{
	$('.phone-check').hide();
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

	//email validation
	
	
	
	
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
	
	if(error == 1){
		return false;
	}else{
		//alert('hi');
		$('#formsubmit').submit();
		
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
				$(this).css({"border": "1px solid red"});
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
				$(this).css({"border": "1px solid red"});
				return false;
			}
			else
			{
				$(this).css({"border-color": "#ebedf2","color":"#575962"});
			}
		});	
		
		$("#is_agent").click(function(){
  // action goes here!!
  if($("#is_agent").is(':checked')){
		//agency = 1;
		//alert(agency);
		$("#aname").show();
	} else {
				//agency = 0;
		//alert(agency);
		$("#aname").hide();
	}
});
		
		$(".changepassword").click(function(){
  // action goes here!!
  if($(".changepassword").is(':checked')){
		//agency = 1;
		//alert(agency);
		$("#passcheck").show();
	} else {
				//agency = 0;
		//alert(agency);
		$("#passcheck").hide();
	}
});
	});
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