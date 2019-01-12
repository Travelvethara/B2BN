@extends('layouts.app')

@section('content')
<!--<pre>{{print_r($Premissionsview)}}</pre>-->
<?php ?>

<!-- END: Left Aside -->

	<!-- BEGIN: Subheader -->
	
	<!-- END: Subheader -->
	<div class="m-content agencies_list">
		<div class="m-portlet m-portlet-padding agency-info-tab">
			
			<div class="view-ageny-page">
				<div class="row">
					<div class="col-md-6 agencyname">
						Agency Name {{$agency->aname}}
					</div>
					<div class="col-md-6 text-right">
						<b>Agency ID:</b>{{$agency->userid}}
					</div>
				</div>
				<div class="row">
					<div class="col-md-6">
						<b>Agency Level:</b> 
						@if($agency->parentagencyid == 0) 
						<?php echo "Parant Agency"; ?>
						@else
						<?php echo "Sub Agency"; ?>
						@endif  
					</div>
					<div class="col-md-6 text-right">
						<b>Manager:</b>  {{$agency->name}}
					</div>
				</div>
				<div class="row">
					<div class="col-md-12">
						<b>Street Address:</b>{{$agency->address1}}, {{$agency->address2}}, {{$agency->city}}, {{$agency->country}}
					</div>
				</div>	
			</div>
			<div class="row booking-refunf-agen">
				<div class="col-md-12">
					<div class="booking-refunf-agen-display">
						<a href="{{route('agentbooking')}}?id=<?php echo base64_encode($agency->id);?>">Bookings</a>
					</div>
					<div class="booking-refunf-agen-display">
						<a href="{{route('userlist')}}?id={{Crypt::encrypt(base64_encode($agency->id))}}">Users</a>
					</div>
					@if($agency->parentagencyid == 0)
					<div class="booking-refunf-agen-display">
						<a href="{{route('subagencylist')}}?id={{Crypt::encrypt(base64_encode($agency->id))}}">Sub Agency</a>
					</div>
					@endif 
				</div>
			</div>
			<form method="POST" action="{{ route('agency.updateagency') }}" id="viewagencyp" />
			<input type="hidden" name="_token" value="<?php echo @csrf_token(); ?>">
			<input type="hidden" name="id" value="<?php if(isset($_GET['id']) && !empty($_GET['id'])) { echo $_GET['id']; } ?>"/>
			<div class="credit-accept-decline">
				<div class="row">
					<div class="col-md-6 col-sm-12">
						
						@if($agency->parentagencyid == 0) 
						Current limit:<span>$ {{$agency->current_credit_limit}}</span> 
						@else
						Parent Current limit:<span>$ {{$agency_parent_details->current_credit_limit}}</span> 
						@endif  
						
						<?php if($role_type == 'SuperAdmin' && $agency->requested_amount > 0) { ?>
							@if($agency->parentagencyid == 0)
							<div class="class-cCredit-accept-decline">
								<div class="inline-class-cCredit-accept-decline">Manager Requested <span>$ </span><span id="amount"><?php echo $agency->requested_amount; ?></span> Credit limit </div>
								<div class="cCredit-accept-decline">
									<div class="credit-accept">
										<button type="button" class="btn btn-success" id="acceptbutton"> Accept</button>
									</div>
									<div class="credit-decline">
										<button type="button" class="btn btn-danger" id="declinebutton"> Decline</button>
									</div>
								</div>	
							</div>
							@endif;
						<?php } ?>
						
						<?php  if($role_type == 'UserInfo') { if($Premissionsview->approve_credit_limit == 1) {if($role_type == 'UserInfo' && $agency->requested_amount > 0) { ?>
							<div class="class-cCredit-accept-decline">
								<div class="inline-class-cCredit-accept-decline">Manager Requested <span>$ </span><span id="amount"><?php echo $agency->requested_amount; ?></span> Credit limit </div>
								<div class="cCredit-accept-decline">
									<div class="credit-accept">
										<button type="button" class="btn btn-success" id="acceptbutton"> Accept</button>
									</div>
									<div class="credit-decline">
										<button type="button" class="btn btn-danger" id="declinebutton"> Decline</button>
									</div>
								</div>	
							</div>
						<?php } } } ?>
						
						<?php if($role_type == 'AgencyManger' && $agency->requested_amount > 0) { ?>
							<div class="class-cCredit-accept-decline">
								@if($agency->parentagencyid == 0) 
								<div class="inline-class-cCredit-accept-decline"> You have requested <span>$ <?php echo $agency->requested_amount; ?></span> Credit limit. Waiting for Approval </div>
								@endif
							</div>
							
						<?php } ?>	
						<?php if($role_type == 'UserInfo') { if($Premissionsview->approve_credit_limit == 0) {if($role_type == 'UserInfo' && $agency->requested_amount > 0) { ?>
							<div class="class-cCredit-accept-decline">
								<div class="inline-class-cCredit-accept-decline"> You have requested <span>$ <?php echo $agency->requested_amount; ?></span> Credit limit. Waiting for Approval </div>
							</div>
						<?php } } } ?>
						
						<?php if($role_type == 'SuperAdmin' || $role_type == 'UserInfo' || $role_type == 'AgencyManger') {  ?>
							<div class="New-Credit-Limit" <?php if($role_type == 'UserInfo') { if ($Premissionsview->approve_credit_limit == '1' && $Premissionsview->approve_credit_assign == '1') { ?>  <?php }else if($Premissionsview->approve_credit_limit == '1') { ?> style="display:none;" <?php }else if($Premissionsview->approve_credit_assign == 0){ ?> style="display:none;" <?php }}  ?>>
								@if($agency->parentagencyid == 0)
								<div class="form-group m-form__group">
									<label for="exampleInputEmail1">New Credit Limit</label>
									<input type="text" class="form-control m-input" name="newcreditlimit" id="newcreditlimit" value=""  placeholder="Enter New Credit Limit">
									<span class="error-message">   @if ($errors->has('newcreditlimit'))
										{{ $errors->first('newcreditlimit') }}
									@endif    </span>
								</div>
								@endif
							</div>
							
						<?php }  ?>
						
						
					</div>
					<?php if($role_type == 'SuperAdmin') { ?>
						@if($agency->parentagencyid == 0) 
						<div class="col-md-6 col-sm-12 positionrelative">
							<div class="topcurreny">
								Current Mark Up:<span>{{$agency->current_markup}} %</span>
								
							</div>
							<div class="new-markup">
								<div class="form-group m-form__group">
									<label for="exampleInputEmail1">New Markup %</label>
									<input type="text" class="form-control m-input" name="newmarkup" value="" placeholder="Enter New Markup %">
									<span class="error-message">     </span>
								</div>
							</div>
						</div>
						@endif
					<?php } ?>
					
					
					<?php if(!empty($agency_parent_details)){?>
						<input type="hidden" name="agencyparentid" id="agencyparentid" value="{{Crypt::encrypt(base64_encode($agency_parent_details->id))}}"/>
					<?php }else{ ?>
						<input type="hidden" name="parentagecncy" id="parentagecncy" value="1"/>
					<?php } ?>  
					
					
					<input type="hidden" name="requestedstatus" id="requestedstatus" value=""/>
					<input type="hidden" name="requestedid" id="requestedid" value="{{Crypt::encrypt(base64_encode($agency->requestid))}}"/>
					
					<?php if($role_type == 'UserInfo') { if ($Premissionsview->approve_credit_limit == '1' && $Premissionsview->approve_credit_assign == '1') {  ?>
						<input type="hidden" name="credit_type" id="" value="3"/> 
					<?php }else if($Premissionsview->approve_credit_limit == '1'){ ?>
						<input type="hidden" name="credit_type" id="" value="2"/> 
					<?php   }else if($Premissionsview->approve_credit_assign == '1'){?>
						<input type="hidden" name="credit_type" id="" value="1"/>
						
					<?php } } ?>
					
					
					
					
					
				</div>	
				<?php if($role_type == 'SuperAdmin' || $role_type == 'UserInfo') { if($role_type == 'SuperAdmin' || $Premissionsview->agency_approve == '1'){ ?>
					<div class="main-displayblockk">
						
						<label class="displayblockk">Approve</label>
						<span class="m-switch">
							<label>
								<input type="checkbox" <?php if($agency->activestatus == 1) { ?>checked="checked" <?php } ?> name="activestatus">
								<span></span>
							</label>
						</span>
						
						
					</div>
				<?php } } ?>
				
				
			</div>
			<div class="row marginbottom">
				
			</div>	
			<div class="update-edit-btn">
				<div class="update-btn">
					<button type="submit" <?php if($role_type == 'SuperAdmin') { ?> Update <?php } else { ?> Request Credit Limit <?php } ?> class="btn btn-primary " <?php if($role_type == 'UserInfo') { if ($Premissionsview->approve_credit_limit == '1' && $Premissionsview->approve_credit_assign == '1') { ?>  <?php }else if($Premissionsview->approve_credit_limit == 0 && $Premissionsview->approve_credit_assign == 0){ ?> style="display:none;" <?php }else if($Premissionsview->approve_credit_assign == '1') { ?>  style="display:block;"<?php } else if($Premissionsview->approve_credit_limit == '1')    { ?> style="display:block;" <?php }}  ?>> Update </button >
				</div>
				<div class="update-btn update-edit">
					<a href="{{route('agency')}}?id={{Crypt::encrypt(base64_encode($agency->id))}}"><button type="button" class="btn btn-metal"> Edit </button></a>
				</div>							   
			</div>
		</form>
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
    	The {{$agency->aname}} @if($agency->parentagencyid == 0) 
						<?php echo "Parant Agency"; ?>
						@else
						<?php echo "Sub Agency"; ?>
						@endif details has been updated  successfully.
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
	<?php $tab = ''; if(isset($_GET['tab']) && !empty($_GET['tab'])){ $tab = $_GET['tab']; }?>    
	<input type="hidden" id="homeurl" value="<?php echo URL::to("/viewagency?id=".$_GET['id']);?>"/>
<?php }else{ ?>
	<input type="hidden" id="homeurl" value="<?php echo URL::to("/viewagency");?>"/>
<?php } ?>

<?php if(isset($_GET['id']) && !empty($_GET['id'])){?>
	<script>
		$(document).ready(function (){

			$(document).on('click', '.closeurl', function(){

			$('.modelshow').hide();

			var url = $('#homeurl').val();
			window.history.pushState('', '', url);

		   });
			
			
		});
		


	</script>
<?php } ?>




@endsection
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script>

	$(document).ready(function () {
		$(document).on('click', '.check-parent-limit', function(){
			
			var parentamount = <?php if(!empty($agency_parent_details)){ echo $agency_parent_details->current_credit_limit; }else{ echo 0; } ?>;
			var currentamount = $('#newcreditlimit').val();
			if(parentamount >=currentamount){
				$('#viewagencyp').submit();
			}else{
				
				$('.error-message').html('You can only set '+parentamount+' credit limit only');
				return false;
			}
			
			
			
		});
		
		$("#newcreditlimit").keypress(function (e) {
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
		
		
		$(function() {
			$('.priceparent').on('keydown', '.price', function(e){-1!==$.inArray(e.keyCode,[46,8,9,27,13,110,190])||(/65|67|86|88/.test(e.keyCode)&&(e.ctrlKey===true||e.metaKey===true))&&(!0===e.ctrlKey||!0===e.metaKey)||35<=e.keyCode&&40>=e.keyCode||(e.shiftKey||48>e.keyCode||57<e.keyCode)&&(96>e.keyCode||105<e.keyCode)&&e.preventDefault()});
		})
		
		$(document).on('change', '.price', function(){
			var numb = $(this).val();
			var zzz = (parseFloat(numb) || 0).toFixed(2);
			$(this).val(zzz);
		});
		
		$(document).on('click', '#acceptbutton', function(){
			var assignedamount =$("#amount").html();
			$("#newcreditlimit").val(assignedamount);
			$("#requestedstatus").val('approved');
		});
		
		
		$(document).on('click', '#declinebutton', function(){
			$("#newcreditlimit").val('');
			$("#requestedstatus").val('declined');
		});
		
		
		
		
		
		
		
		
		
		
	});

</script>

