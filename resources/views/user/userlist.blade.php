@extends('layouts.app')

@section('content')
<?php 
$route = 'userinsert';
if (isset($userlist) && !empty($userlist)){ $route = 'userupdate'; }

?>
<!-- END: Left Aside -->

	<!-- BEGIN: Subheader -->
	
	<!-- END: Subheader -->
	<div class="m-content agencies_list">
		
		<div class="m-portlet agency-info-tab">
			
			<div class="m-portlet m-portlet--mobile">
				
				<div class="m-portlet__body">
					<!--begin: Search Form -->
					<div class="m-form m-form--label-align-right">
						<div class="row align-items-center">
							<div class="col-xl-8 order-2 order-xl-1">
								<div class="form-group m-form__group row align-items-center">
									
									
									<div class="col-md-4">
										<div class="m-input-icon m-input-icon--left">
											<input type="text" class="form-control m-input" placeholder="Search..." id="generalSearch">
											<span class="m-input-icon__icon m-input-icon__icon--left">
												<span>
													<i class="la la-search"></i>
												</span>
											</span>
										</div>
									</div>
								</div>
							</div>
							<div class="col-xl-4 order-1 order-xl-2 m--align-right">
								
								<div class="m-separator m-separator--dashed d-xl-none"></div>
							</div>
						</div>
					</div>
					<!--end: Search Form -->
					<!--begin: Datatable -->
					<table class="m-datatable" id="html_table" width="100%">
						<thead>
							
							<tr>
								<th title="Field #1">
									S No
								</th>
								<th title="Field #2">
									User Name 
								</th>
								<th title="Field #3">
									User Role
								</th>
								<th title="Field #4">
									User ID
								</th>
								<th title="Field #9">
									Current Status
								</th>
								
								<th title="Field #6">
									Action
								</th>
								
								
								
								
							</tr>
						</thead>
						<tbody>
							<?php $i =1; ?>
							@foreach ($products as $details)
							<tr>
								<td>{{ $i }}</td>
								<td>{{ $details->name}}</td>
								
								<td>{{ $details->role_name }}</td>
								<td>{{ $details->userid }}</td>
								<td><?php if(isset($details->activestatus) && ($details->activestatus == 1)) { ?><span class="m-badge  m-badge--success m-badge--wide">Active</span>  <?php
							} else { ?>  <span class="m-badge  m-badge--metal m-badge--wide">Locked</span><?php } ?> </td>
							
							<td>
								<?php if($Premissions['type'] == 'SuperAdmin' || $Premissions['type'] == 'AgencyManger') {?>
									<a href="{{route('userupdate')}}?id={{Crypt::encrypt(base64_encode($details->id))}}" class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" ><i class="la la-edit"></i></a>
								<?php } ?>
								
								<?php 
								if($Premissions['type'] == 'UserInfo') {
									if($Premissions['premission'][0]->user_edit == 1){
									        // $encrypted_id = base64_encode($details->id);
										?>
										
										
										<a href="{{route('userupdate')}}?id={{Crypt::encrypt(base64_encode($details->id))}}" class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" ><i class="la la-edit"></i></a>
										
										
										
									<?php } } ?>
									
									<?php if($Premissions['type'] == 'SuperAdmin' || $Premissions['type'] == 'AgencyManger') {?>
										<a href="javascript:void(0)" class="m-portlet__nav-link btn m-btn m-btn--hover-danger m-btn--icon m-btn--icon-only m-btn--pill">
											<i class="far fa-trash-alt DeleteRole" data-id="{{$details->id}}"></i>
										</a>
									<?php } ?>
									
									<?php 
									if($Premissions['type'] == 'UserInfo') {
										if($Premissions['premission'][0]->user_remove == 1){
											
											?>
											
											
											
											<a href="javascript:void(0)" class="m-portlet__nav-link btn m-btn m-btn--hover-danger m-btn--icon m-btn--icon-only m-btn--pill">
												<i class="far fa-trash-alt DeleteRole" data-id="{{$details->id}}"></i>
											</a>
										<?php } } ?>     
										
										
										<form id="userlistform{{$details->id}}" action="{{route('userdelete')}}" method="POST" style="display: none;">                                                                            
											<input type="hidden" name="_token" value="<?php echo @csrf_token(); ?>">
											<input type="hidden" value="{{$details->id}}" name="id"/>
										</form>
									</td>

									
									
									
								</tr>
								<?php $i++; ?>
								@endforeach
							</tbody>
						</table>
						<!--end: Datatable -->
					</div>
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

<?php if(isset($_GET['datas1'])) {?>
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
    	The data was deleted successfully.
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

@endsection

<!-- end:: Footer -->

<?php if(isset($_GET['id']) && !empty($_GET['id'])){?>           
	<input type="hidden" id="homeurl" value="<?php echo URL::to("/userlist?id=".$_GET['id']);?>"/>
<?php }else{ ?>
	<input type="hidden" id="homeurl" value="<?php echo URL::to("/userlist");?>"/>
<?php } ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

<script>




//Detelt details



$(document).ready(function(e) {

	$(document).on('click', '.DeleteRole', function(){
		
		var id = $(this).data('id');
		
		var view = confirm("Are you sure you want to Delete now?");
		
		if (view === false) {
			return false;
		}
		
		else if(view === true){
			
			$('#userlistform'+id).submit();
			
			
		}
		

	});	
	

	$(document).on('click', '.closeurl', function(){

		$('.modelshow').hide();

		var url = $('#homeurl').val();
		window.history.pushState('', '', url);

	});



	

	
});

</script>