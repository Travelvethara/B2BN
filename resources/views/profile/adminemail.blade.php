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
				<form action="{{ route('emailupdate') }}" class="m-form" method="post" id="agency_info">
					<input type="hidden" name="_token" value="<?php echo @csrf_token(); ?>">
					<div class="m-portlet m-portlet-padding edit-info-tab">
						
						<div class="form-group m-form__group row">
							<label class="col-lg-2 col-form-label">Email<span class="requiredcls" aria-required="true"> * </span></label>
							<div class="col-lg-5">
								<input type="text" class="form-control m-input" id="email"  placeholder="Email" value="{{$adminemail[0]->EmailName}}" name="email" maxlength="40">
                                
                                <span class="error-message conformemail1-check" style="display:none">
												The field is required.
											</span>
											<span class="error-message conformemail1-involid-check" style="display:none">
												The Email is a not vaild.
											</span>
								@if ($errors->has('email'))
								<span class="error-message">
									{{ $errors->first('email') }}
								</span>
								@endif 
							</div>
						</div>
	
						<div class="m-form__actions m-form__actions">
							<div class="row">
								<div class="col-lg-2">
								</div>
								<div class="col-lg-5">
									
									<button type="button" class="btn btn-primary adminemailupdate">Update</button>
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
	
	<input type="hidden" id="homeurl" value="<?php echo URL::to("/adminemail");?>"/>
	
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
    	The data was updated successfully.
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



<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

<script type="text/javascript">

$(document).ready(function (){
	
	$(document).on('click', '.adminemailupdate', function(){
	
	var error = 0;
	
	//email validation
	//start
	var sEmail = $('#email').val();
		console.log('gkhklfgjhkjdfgkhjkfdg');
	if($.trim(sEmail).length == 0){
		$('.email-check').show();
		$('.conformemail1-check').show();
		$('#email').focus();
	
		error=1;
	}
	if($('#email').val() != ''){
	if(validateEmail(sEmail)){
	
	$('.email-check').hide();
	$('.email-involid-check').hide();
	 $('.confirm-email-check-match').hide();
	emailinvoild= 1;
	//return false;
	}else{
		$('.email-check').hide();
		$('.conformemail1-involid-check').show();
		$('.conformemail1-check').hide();
		$('#email').focus();
		error=1;
		//return false;
	}
	}
	console.log(error);
	if(error == 1){
		return false;
	}else{
		
		$('#agency_info').submit();
	
	}
	
	
	});
	
	$(document).on('click', '.closeurl', function(){

$('.modelshow').hide();

var url = $('#homeurl').val();
//window.history.pushState('', '', url+'&tab=1');
window.history.pushState('', '', url);

});
	
});

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





@endsection
