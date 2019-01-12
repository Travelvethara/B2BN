@extends('layouts.app')

@section('content')
<?php 
$route = 'role.roleinsert';
if (isset($rolelist) && !empty($rolelist)){ $route = 'role.roleupdate'; }
?>

<!-- END: Left Aside -->

					<!-- BEGIN: Subheader -->
					
					<!-- END: Subheader -->
					<div class="m-content user-role">
					<form action="{{route($route)}}" method="post" id="roleform">
                    <input type="hidden" name="_token" value="<?php echo @csrf_token(); ?>">
						<div class="m-portlet agency-info-tab">
						<div class="role-name-agency">
							<div class="positionrelative user-role-agen-block m-portlet-padding">
                            	<div class="row">
								<div class="col-md-4">
									<div class="m-form__group">
										<input type="text" class="form-control darkfield m-input m-input--square rolename" placeholder="Role Name" name="role_name" <?php if (isset($rolelist->role_name) && !empty($rolelist->role_name)){?> value="{{ $rolelist->role_name }}" <?php }else{ ?> value="{{old('role_name')}}"<?php } ?>>                                    @if ($errors->has('role_name'))
                                        <span class="error-message dark rolename-error" >   
                                             The field is required.  
                                         </span>
                                         @endif
                                         <span class="error-message dark rolename-error rolename-error1" style="display:none;" >   
                                             The field is required.  
                                         </span>
									</div>
								</div>
								<div class="col-md-6 agentck agentcknew">
									<label class="m-checkbox m-checkbox--solid m-checkbox--brand">
											<input type="checkbox" class="checkvalidatecheckbox" id="agency_create_user" name="agency_create_user" <?php if (isset($rolelist->agency_create_user) && !empty($rolelist->agency_create_user)){?> checked="checked" <?php }else{ ?> {{ old('agency_create_user') ? 'checked' : '' }} <?php } ?>> Agency can create user on this role.
											<span></span>
									</label>
								</div>
                                </div>
							</div>
                            
                            <div class="m-portlet-padding">
							<div class="permissions">
							<i>Permissions</i>
							</div>
							<div class="permission-roles">
								<div class="row">
									<div class="col-md-2">
											<label class="m-checkbox m-checkbox--solid m-checkbox--success">
											<input type="checkbox" name="agency_approve" id="agency_approve" class="checkchagebox checkvalidatecheckbox"  <?php if (isset($rolelist->agency_approve) && !empty($rolelist->agency_approve)){?> checked="checked" <?php }else{ ?> {{ old('agency_approve') ? 'checked' : '' }} <?php } ?>> Can approve agency
											<span></span>
									       </label>
									</div>
									<div class="col-md-2">
											<label class="m-checkbox m-checkbox--solid m-checkbox--success">
											<input type="checkbox" name="agency_open" id="agency_open" class="checkchagebox checkvalidatecheckbox" <?php if (isset($rolelist->agency_open) && !empty($rolelist->agency_open)){?> checked="checked" <?php }else{ ?> {{ old('agency_open') ? 'checked' : '' }} <?php } ?>> Can open agency
											<span></span>
									       </label>
									</div>
									<div class="col-md-2">
											<label class="m-checkbox m-checkbox--solid m-checkbox--success">
											<input type="checkbox" name="agency_remove" id="agency_remove" class="checkchagebox checkvalidatecheckbox" <?php if (isset($rolelist->agency_remove) && !empty($rolelist->agency_remove)){?> checked="checked" <?php }else{ ?> {{ old('agency_remove') ? 'checked' : '' }} <?php } ?>> Can remove agency
											<span></span>
									       </label>
									</div>
									<div class="col-md-2">
											<label class="m-checkbox m-checkbox--solid m-checkbox--success">
											<input type="checkbox" name="agency_edit" id="agency_edit" class="checkchagebox checkvalidatecheckbox" <?php if (isset($rolelist->agency_edit) && !empty($rolelist->agency_edit)){?> checked="checked" <?php }else{ ?> {{ old('agency_edit') ? 'checked' : '' }} <?php } ?>> Can Edit agency
											<span></span>
									       </label>
									</div>
                                    <div class="col-md-2">
											<label class="m-checkbox m-checkbox--solid m-checkbox--success">
											<input type="checkbox" name="agency_list" id="agency_list" class="checkchagebox checkvalidatecheckbox" <?php if (isset($rolelist->agency_list) && !empty($rolelist->agency_list)){?> checked="checked" <?php }else{ ?> {{ old('agency_list') ? 'checked' : '' }} <?php } ?>> Can open list agency
											<span></span>
									       </label>
									</div>
                                    </div>
    
								<div class="row">
									<div class="col-md-2">
											<label class="m-checkbox m-checkbox--solid m-checkbox--success ">
											<input type="checkbox" name="user_create" id="user_create" class="checkchagebox checkvalidatecheckbox" <?php if (isset($rolelist->user_create) && !empty($rolelist->user_create)){?> checked="checked" <?php }else{ ?> {{ old('user_create') ? 'checked' : '' }} <?php } ?>> Can create users
											<span></span>
									       </label>
									</div>
                                    <div class="col-md-2">
											<label class="m-checkbox m-checkbox--solid m-checkbox--success">
											<input type="checkbox" name="user_list" id="user_list" class="checkchagebox checkvalidatecheckbox" <?php if (isset($rolelist->user_list) && !empty($rolelist->user_list)){?> checked="checked" <?php }else{ ?> {{ old('user_list') ? 'checked' : '' }} <?php } ?>> Can users list
											<span></span>
									       </label>
									</div>
									<div class="col-md-2">
											<label class="m-checkbox m-checkbox--solid m-checkbox--success">
											<input type="checkbox" name="user_remove" id="user_remove" class="checkchagebox checkvalidatecheckbox" <?php if (isset($rolelist->user_remove) && !empty($rolelist->user_remove)){?> checked="checked" <?php }else{ ?> {{ old('user_remove') ? 'checked' : '' }} <?php } ?>> Can remove users
											<span></span>
									       </label>
									</div>
									<div class="col-md-2">
											<label class="m-checkbox m-checkbox--solid m-checkbox--success">
											<input type="checkbox" name="user_lock" id="user_lock" class="checkchagebox checkvalidatecheckbox" <?php if (isset($rolelist->user_lock) && !empty($rolelist->user_lock)){?> checked="checked" <?php }else{ ?> {{ old('user_lock') ? 'checked' : '' }} <?php } ?>> Can lock users
											<span></span>
									       </label>
									</div>
                                    
                                    <div class="col-md-2">
											<label class="m-checkbox m-checkbox--solid m-checkbox--success">
											<input type="checkbox" name="user_edit" id="user_edit" class="checkchagebox checkvalidatecheckbox" <?php if (isset($rolelist->user_edit) && !empty($rolelist->user_edit)){?> checked="checked" <?php }else{ ?> {{ old('user_edit') ? 'checked' : '' }} <?php } ?>> Can users edit
											<span></span>
									       </label>
									</div>
									
								</div>
								<div class="row">
									<div class="col-md-2">
											<label class="m-checkbox m-checkbox--solid m-checkbox--success">
											<input type="checkbox" name="approve_credit_limit" class="checkchagebox checkvalidatecheckbox" class="checkchagebox" id="approve_credit_limit" <?php if (isset($rolelist->approve_credit_limit) && !empty($rolelist->approve_credit_limit)){?> checked="checked" <?php }else{ ?> {{ old('approve_credit_limit') ? 'checked' : '' }} <?php } ?>> Can approve credit limits
											<span></span>
									       </label>
									</div>
									<div class="col-md-2">
											<label class="m-checkbox m-checkbox--solid m-checkbox--success">
											<input type="checkbox" name="approve_credit_terms" id="approve_credit_terms" class="checkchagebox checkvalidatecheckbox" <?php if (isset($rolelist->approve_credit_terms) && !empty($rolelist->approve_credit_terms)){?> checked="checked" <?php }else{ ?> {{ old('approve_credit_terms') ? 'checked' : '' }} <?php } ?>> Can approve credit terms
											<span></span>
									       </label>
									</div>
									<div class="col-md-2">
											<label class="m-checkbox m-checkbox--solid m-checkbox--success">
											<input type="checkbox" name="approve_credit_assign" id="approve_credit_assign" class="checkchagebox checkvalidatecheckbox" <?php if (isset($rolelist->approve_credit_assign) && !empty($rolelist->approve_credit_assign)){?> checked="checked" <?php }else{ ?> {{ old('approve_credit_assign') ? 'checked' : '' }} <?php } ?>> Can assign credit limits
											<span></span>
									       </label>
									</div>
									<div class="col-md-2">
											<label class="m-checkbox m-checkbox--solid m-checkbox--success">
											<input type="checkbox" name="approve_credit_assign_terms" class="checkchagebox checkvalidatecheckbox" id="approve_credit_assign_terms" <?php if (isset($rolelist->approve_credit_assign_terms) && !empty($rolelist->approve_credit_assign_terms)){?> checked="checked" <?php }else{ ?> {{ old('approve_credit_assign_terms') ? 'checked' : '' }} <?php } ?>> Can assign credit terms
											<span></span>
									       </label>
									</div>
								</div>
								<div class="row">
									<div class="col-md-2">
											<label class="m-checkbox m-checkbox--solid m-checkbox--success">
											<input type="checkbox" class="checkvalidatecheckbox" name="book" id="book" <?php if (isset($rolelist->book) && !empty($rolelist->book)){?> checked="checked" <?php }else{ ?> {{ old('book') ? 'checked' : '' }} <?php } ?>> Can book
											<span></span>
									       </label>
									</div>
									<div class="col-md-2">
											<label class="m-checkbox m-checkbox--solid m-checkbox--success">
											<input type="checkbox" name="offline_booking" id="offline_booking" class="checkvalidatecheckbox" <?php if (isset($rolelist->offline_booking) && !empty($rolelist->offline_booking)){?> checked="checked" <?php }else{ ?> {{ old('offline_booking') ? 'checked' : '' }} <?php } ?>> Can input offline booking
											<span></span>
									       </label>
									</div>
									<div class="col-md-2">
											<label class="m-checkbox m-checkbox--solid m-checkbox--success">
											<input type="checkbox" name="booking_confirm" id="booking_confirm" class="checkvalidatecheckbox" <?php if (isset($rolelist->booking_confirm) && !empty($rolelist->booking_confirm)){?> checked="checked" <?php }else{ ?> {{ old('booking_confirm') ? 'checked' : '' }} <?php } ?>> Can confirm
											<span></span>
									       </label>
									</div>
									
								</div>
								<div class="row">
									<div class="col-md-2">
											<label class="m-checkbox m-checkbox--solid m-checkbox--success">
											<input type="checkbox" name="create_voucher" id="create_voucher" class="checkvalidatecheckbox" <?php if (isset($rolelist->create_voucher) && !empty($rolelist->create_voucher)){?> checked="checked" <?php }else{ ?> {{ old('create_voucher') ? 'checked' : '' }} <?php } ?>> Can create voucher
											<span></span>
									       </label>
									</div>
									<div class="col-md-2">
											<label class="m-checkbox m-checkbox--solid m-checkbox--success">
											<input type="checkbox" name="issue_receipts" id="issue_receipts" class="checkvalidatecheckbox" <?php if (isset($rolelist->issue_receipts) && !empty($rolelist->issue_receipts)){?> checked="checked" <?php }else{ ?> {{ old('issue_receipts') ? 'checked' : '' }} <?php } ?>> Can issue receipts
											<span></span>
									       </label>
									</div>
									<div class="col-md-2">
											<label class="m-checkbox m-checkbox--solid m-checkbox--success">
											<input type="checkbox" name="knock_off" id="knock_off" class="checkvalidatecheckbox" <?php if (isset($rolelist->knock_off) && !empty($rolelist->knock_off)){?> checked="checked" <?php }else{ ?> {{ old('knock_off') ? 'checked' : '' }} <?php } ?>> Can knock-off
											<span></span>
									       </label>
									</div>
								</div>
								<div class="row">
									<div class="col-md-2">
											<label class="m-checkbox m-checkbox--solid m-checkbox--success">
											<input type="checkbox" name="incentive_slobs" id="incentive_slobs" class="checkvalidatecheckbox" <?php if (isset($rolelist->incentive_slobs) && !empty($rolelist->incentive_slobs)){?> checked="checked" <?php }else{ ?> {{ old('incentive_slobs') ? 'checked' : '' }} <?php } ?>> Incentive slobs / incentive
											<span></span>
									       </label>
									</div>
									
								</div>
								<div class="row">
									<div class="col-md-4">
											<label class="m-checkbox m-checkbox--solid m-checkbox--success">
											<input type="checkbox" name="partial_refund_cancel" class="checkvalidatecheckbox" id="partial_refund_cancel" <?php if (isset($rolelist->partial_refund_cancel) && !empty($rolelist->partial_refund_cancel)){?> checked="checked" <?php }else{ ?> {{ old('partial_refund_cancel') ? 'checked' : '' }} <?php } ?>> Can request refund / partial cancellation /waiver
											<span></span>
									       </label>
									</div>
									<div class="col-md-4">
											<label class="m-checkbox m-checkbox--solid m-checkbox--success">
											<input type="checkbox" name="approve_refund_cancel" class="checkvalidatecheckbox" id="approve_refund_cancel" <?php if (isset($rolelist->approve_refund_cancel) && !empty($rolelist->approve_refund_cancel)){?> checked="checked" <?php }else{ ?> {{ old('approve_refund_cancel') ? 'checked' : '' }} <?php } ?>> Can approve refund / partial cancellation /waiver
											<span></span>
									       </label>
									</div>
								</div>
								
<br />
<br />
										<div class="col-md-6">
                                       
                                        <?php if (isset($_GET['id']) && !empty($_GET['id'])){ ?> 
										
										<input type="hidden" name="roleid" value="{{$rolelist->id}}"/>
                                        <button type="submit" class="btn btn-primary checkrole">Update Role</button>
										<?php }else{?>
										<button type="submit" class="btn btn-primary checkrole">Create Role</button>
                                            <?php } ?>
                                             <span class="error-message atleast" style="display:none">   
                                                 Please select at least one permission 
                                         </span>
										</div>

							</div>
                            
                            
                            </div>
						</div>
                        </div>
						</form>
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


<!-- end:: Footer -->
             <?php if(isset($_GET['id']) && !empty($_GET['id'])){?>           
                                <input type="hidden" id="homeurl" value="<?php echo URL::to("/role?id=".$_GET['id']);?>"/>
                                 <?php }else{ ?>
                                <input type="hidden" id="homeurl" value="<?php echo URL::to("/role");?>"/>
								<?php } ?>
              
@endsection

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script>
$(document).ready(function(e) {
	
$(document).on('click', '.closeurl', function(){

$('.modelshow').hide();

var url = $('#homeurl').val();
window.history.pushState('', '', url);

});
$('.checkrole').click(function(e) {
	 
	 
	 var ck_box = $('.checkvalidatecheckbox:checked').length;
       	
	  if (ck_box == 0){
		  if($('#card_holder_country').val() == ''){
			   $('.atleast').show();
		  }else{
			   $('.atleast').hide();
		  
		  }
        $('.atleast').show();
        return false;
      }else{
		if($('.rolename').val() == ''){
		$('.rolename-error1').show();
		$('.rolename').focus();
		error=1;
	   }else{
		   $('.rolename-error1').hide();
		$('.lastname').hide();
		 $('.atleast').hide();
	  $('#roleform').submit();
	   }
	  }

	
});
	
	$('#agency_create_user').click(function(e) {
		if(this.checked){
		$('#agency_approve').prop('checked', false); // Unchecks it
		$('#agency_open').prop('checked', false); // Unchecks it
		$('#agency_remove').prop('checked', false); // Unchecks it
		$('#agency_lock').prop('checked', false); // Unchecks it
		$('#user_create').prop('checked', false); // Unchecks it
		$('#user_remove').prop('checked', false); // Unchecks it
		$('#user_lock').prop('checked', false); // Unchecks it
		$('#agency_edit').prop('checked', false); // Unchecks it
		$('#approve_credit_limit').prop('checked', false); // Unchecks it
		$('#approve_credit_terms').prop('checked', false); // Unchecks it
		$('#approve_credit_assign').prop('checked', false); // Unchecks it
		$('#approve_credit_assign_terms').prop('checked', false); // Unchecks it
		$('#agency_list').prop('checked', false); // Unchecks it
		$('#user_list').prop('checked', false); // Unchecks it
		$('#user_edit').prop('checked', false); // Unchecks it
		}
	});
	
	$('#agency_list').click(function(e) {
		if(this.checked){
		//$('#agency_create_user').prop('checked', false);
		}else{
		$('#agency_remove').prop('checked', false); // Unchecks it
		$('#agency_edit').prop('checked', false); // Unchecks it
		
		
		}
		
	});
	
	$('.checkchagebox').click(function(e) {
		if(this.checked){
		$('#agency_create_user').prop('checked', false);
		}
		
	});
	
	
	$('#agency_remove').click(function(e) {
		if(this.checked){
		$('#agency_list').prop('checked', true);
		}
		
	});
	$('#agency_edit').click(function(e) {
		if(this.checked){
		$('#agency_list').prop('checked', true);
		}
		
	});
    

	
});
</script>