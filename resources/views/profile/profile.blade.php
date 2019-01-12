@extends('layouts.app')
@section('content')
<?php 

?>

	
	<!-- BEGIN: Subheader -->
	
	<div class="">
		<!-- END: Subheader -->
		<div class="m-content">
			<!--Begin::Section-->
			
			<div class="edit-profile-content">
				<form action="{{ route('profile.profileupdate') }}" class="m-form" method="post">
					<input type="hidden" name="_token" value="<?php echo @csrf_token(); ?>">
					<div class="m-portlet m-portlet-padding edit-info-tab">
						
						<div class="form-group m-form__group row">
							<label class="col-lg-2 col-form-label" >User ID</label>
							<div class="col-lg-5">
								<input type="text" class="form-control m-input" readonly placeholder="User ID" value="{{$userid}}">
							</div>
						</div>
						
						<div class="form-group m-form__group row">
							<label class="col-lg-2 col-form-label" >Name<span class="requiredcls" aria-required="true"> * </span></label>
							<div class="col-lg-5">
								<input type="text" class="form-control m-input" i placeholder="Name" value="{{$name}}" name="name" maxlength="30">
								@if ($errors->has('name'))
								<span class="error-message"> 
									{{ $errors->first('name') }}
								</span>
								@endif 
							</div>
						</div>
						
						<div class="form-group m-form__group row">
							<label class="col-lg-2 col-form-label">Phone<span class="requiredcls" aria-required="true"> * </span></label>
							<div class="col-lg-5">
								<input type="text" class="form-control m-inpu"  placeholder="Phone" value="{{$phone}}" name="phone" maxlength="20">
								@if ($errors->has('phone'))
								<span class="error-message">
									{{ $errors->first('phone') }}
								</span>
								@endif 
							</div>
						</div>
						
						
						<div class="form-group m-form__group row">
							<label class="col-lg-2 col-form-label">Email<span class="requiredcls" aria-required="true"> * </span></label>
							<div class="col-lg-5">
								<input type="text" class="form-control m-input"  placeholder="Email" value="{{$email}}" name="email" maxlength="40">
								@if ($errors->has('email'))
								<span class="error-message">
									{{ $errors->first('email') }}
								</span>
								@endif 
							</div>
						</div>
						
						<div class="form-group m-form__group row">
							<label class="col-lg-2 col-form-label"></label>
							<div class="col-lg-5">
								<label class="m-checkbox m-checkbox--square">
									<input type="checkbox" name="changepassword" class="changepassword" {{ old('changepassword') ? 'checked' : '' }}> Do you Change password
									<span></span>
								</label>
							</div>	
						</div>
						
						
						<div class="checkpassword" <?php if(old('changepassword')){?> style="display:black;" <?php }else{  ?> style="display:none;" <?php } ?> >
							<div class="form-group m-form__group row">
								<label class="col-lg-2 col-form-label">Password<span class="requiredcls" aria-required="true"> * </span></label>
								<div class="col-lg-5">
									<input type="password" class="form-control m-input"  placeholder="Password" name="password" maxlength="40">
									@if ($errors->has('password'))
									<span class="error-message">
										{{ $errors->first('password') }}
									</span>
									@endif
								</div>
							</div>
							
							<div class="checkpassword" <?php if(old('changepassword')){?> style="display:black;" <?php }else{  ?> style="display:none;" <?php } ?>>
								<div class="form-group m-form__group row">
									<label class="col-lg-2 col-form-label">Confirm Password<span class="requiredcls" aria-required="true"> * </span></label>
									<div class="col-lg-5">
										<input type="password" class="form-control m-input"  placeholder="Confirm Password" name="password_confirmation" maxlength="40">
										@if ($errors->has('password_confirmation'))
										<span class="error-message">
											{{ $errors->first('password_confirmation') }}
										</span>
										@endif 
									</div>
								</div>
							</div>
						</div>
						
						
						<div class="m-form__actions m-form__actions">
							<div class="row">
								<div class="col-lg-2">
								</div>
								<div class="col-lg-5">
									<input type="hidden" name="id" value="{{$id}}"/>
									<input type="hidden" name="type" value="{{$type}}"/>
									<input type="hidden" name="loginid" value="{{$loginid}}"/>
									<button type="submit" class="btn btn-primary">Update</button>
								</div>
							</div>
						</div>
						
					</form>
					
					
				</div>
				<!--End::Section-->

				
				<!--End::Section-->
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
	<input type="hidden" id="homeurl" value="<?php echo URL::to("/profile?id=".$_GET['id']);?>"/>
<?php }else{ ?>
	<input type="hidden" id="homeurl" value="<?php echo URL::to("/profile");?>"/>
<?php } ?>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script>
	$(document).ready(function(e) {
		
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
</script>	




@endsection
